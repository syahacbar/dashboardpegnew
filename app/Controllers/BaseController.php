<?php 
/**
*	App Name	: Admin Template Dashboard Codeigniter 4	
*	Developed by: Agus Prawoto Hadi
*	Website		: https://jagowebdev.com
*	Year		: 2020-2022
*/

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Libraries\Auth;
use Config\App;
use App\Models\BaseModel;

class BaseController extends Controller
{
	protected $data;
	protected $config;
	protected $session;
	protected $router;
	protected $request;
	protected $isLoggedIn;
	protected $auth;
	protected $user;
	protected $model;
	
	public $currentModule;
	private $controllerName;
	private $methodName;
	protected $actionUser;
	protected $moduleURL;
	protected $moduleRole;
	
	public function __construct() 
	{
		date_default_timezone_set('Asia/Jayapura');
		$this->session = \Config\Services::session();
		$this->request = \Config\Services::request();
		$this->config = new App;
		$this->auth = new Auth;
		$this->model = new BaseModel;
		helper('util');
		$web = $this->session->get('web');

		$nama_module = $web['nama_module'];
		$module = $this->model->getModule($nama_module);
		
		if (!$module) {
			$this->data['status'] = 'error';
			$this->data['title'] = 'ERROR';
			$this->data['content'] = 'Module ' . $nama_module . ' tidak ditemukan di database';
			$this->viewError($this->data);
			exit();
		}
		
		$this->currentModule = $module;
		$this->moduleURL = $web['module_url'];
		
		$this->model->checkRememberme();
		$this->isLoggedIn = $this->session->get('logged_in');
		$this->data['current_module'] = $this->currentModule;
		$this->data['scripts'] = array($this->config->baseURL . '/public/assets/vendors/jquery/jquery.min.js'
										, $this->config->baseURL . '/public/assets/vendors/flatpickr/flatpickr.js'
										, $this->config->baseURL . '/public/themes/modern/assets/js/site.js?r='.time()
										, $this->config->baseURL . '/public/assets/vendors/bootstrap/js/bootstrap.js'
										, 'https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js'
									);
		$this->data['styles'] = array(
									$this->config->baseURL . '/public/assets/vendors/bootstrap/css/bootstrap.css'
									, $this->config->baseURL . '/public/themes/modern/assets/css/site.css?r='.time()
								);
		$this->data['config'] = $this->config;
		$this->data['request'] = $this->request;
		$this->data['isloggedin'] = $this->isLoggedIn;
		$this->data['session'] = $this->session;
		$this->data['site_title'] = 'Dashboard Kepegawaian';
		$this->data['site_desc'] = 'Dashboard Kepegawaian';
		$this->data['settingAplikasi'] = $this->model->getSettingAplikasi();
		$this->data['user'] = [];
		$this->data['auth'] = $this->auth;
		$this->data['scripts'] = [];
		$this->data['styles'] = [];
		$this->data['module_url'] = $this->moduleURL;
		
		if ($this->isLoggedIn) {
			$user_setting = $this->model->getUserSetting();
			
			if ($user_setting) {
				$this->data['app_layout'] = json_decode($user_setting->param, true);
			}
		} else {
			$query = $this->model->getAppLayoutSetting();
			foreach ($query as $val) {
				$app_layout[$val['param']] = $val['value'];
			}
			$this->data['app_layout'] = $app_layout;
		}
		
		// Login? Yes, No, Restrict
		/* echo '<pre>';
		print_r($this->currentModule);
		die; */
		if ($this->currentModule['login'] == 'Y' && $nama_module != 'login') {
			$this->loginRequired();
		} else if ($this->currentModule['login'] == 'R') {
			$this->loginRestricted();
		}
				
		if ($this->isLoggedIn) 
		{
			$this->user = $this->session->get('user');
			$this->data['user'] = $this->user;
			
			// List action assigned to role
			$this->data['action_user'] = $this->actionUser;
			$this->data['menu'] = $this->model->getMenu($this->currentModule['nama_module']);
			
			$this->data['breadcrumb'] = ['Home' => $this->config->baseURL, $this->currentModule['judul_module'] => $this->moduleURL];
			$this->data['module_role'] = $this->model->getDefaultUserModule();
						
			$this->getModuleRole();
			$this->getListAction();
			
			// Check Global Role Action
			$this->checkRoleAction();
			
			if ($nama_module == 'login') {
				$this->redirectOnLoggedIn();
			}
		}
		
		if ($module['id_module_status'] != 1) {
			$message = 'Module ' . $module['judul_module'] . ' sedang ' . strtolower($module['nama_status']);
			$this->data['status'] = 'error';
			$this->data['title'] = 'ERROR';
			$this->data['content'] = $message;
			// $this->viewError($this->data);
			$this->printError(['message' => $message, 'status' => 'error']);
			exit();
		}
	}
	
	private function getModuleRole()
	{
		$query = $this->model->getModuleRole($this->currentModule['id_module']);
		$this->moduleRole = [];
		foreach ($query as $val) {
			$this->moduleRole[$val['id_role']] = $val;
		}
	}
	
	private function getListAction() 
	{
		$roles = $this->session->get('user')['role'];
		
		if ($this->isLoggedIn && $this->currentModule['nama_module'] != 'login') {
			
			if ($this->moduleRole) {
				
				if ($roles) {
					$list = ['read_data' => '', 'create_data' => '', 'update_data' => '', 'delete_data' => ''];
					foreach ($roles as $id_role => $val) 
					{
						if (key_exists($id_role, $this->moduleRole)) 
						{
							foreach ($list as $action_name => $action_val) {
								$akses = $action_name == 'create_data' ? 'yes' : 'all';
								
								if ($action_val != $akses ) {
									$list[$action_name] = $this->moduleRole[$id_role][$action_name];
								}
							}
						}
						
					}
					$this->actionUser = $list;
				}
				
				if ($this->currentModule['nama_module'] != 'login' ) {
					
					$exists = false;
					foreach ($roles as $id_role => $val) 
					{
						if (key_exists($id_role, $this->moduleRole)) {
							$exists = true;
						}
					}
					
					if (!$exists) {
						$this->setCurrentModule('error');
						$this->data['msg']['status'] = 'error';
						$this->data['msg']['message'] = 'Anda tidak berhak mengakses halaman ini';
						$this->view('error.php', $this->data);
						
						exit();
					}
				}
			} else {
				if ($this->currentModule['login'] == 'Y') {
					$this->setCurrentModule('error');
					$this->data['msg']['status'] = 'error';
					$this->data['msg']['message'] = 'Role untuk module ini belum diatur'; 
					$this->view('error.php',$this->data);
					exit();
				}
			}
		}
	}
	
	private function setCurrentModule($module) {
		$this->currentModule['nama_module'] = $module;
	}
	
	protected function getControllerName() {
		return $this->controllerName;
	}
	
	protected function getMethodName() {
		return $this->methodName;
	}
	
	protected function addStyle($file) {
		$this->data['styles'][] = $file;
	}
	
	protected function addJs($file, $print = false) {
		if ($print) {
			$this->data['scripts'][] = ['print' => true, 'script' => $file];
		} else {
			$this->data['scripts'][] = $file;
		}
	}
	
	protected function viewError($data) {
	
		echo view('app_error.php', $data);
	}
	
	protected function view($file, $data = false, $file_only = false) 
	{
		if (is_array($file)) {
			foreach ($file as $file_item) {
				echo view($file_item, $data);
			}
		} else {
			echo view('themes/modern/header.php', $data);
			echo view('themes/modern/' . $file, $data);
			echo view('themes/modern/footer.php');
		}
	}
	
	protected function loginRequired() 
	{
		if (!$this->isLoggedIn) {
			header('Location: ' . $this->config->baseURL . 'login');
			// redirect()->to($this->config->baseURL . 'login');
			exit();
		}
	}
	
	protected function loginRestricted() {
		if ($this->isLoggedIn) {
			if ($this->methodName !== 'logout') {
				header('Location: ' . $this->config->baseURL);
			}
		}
	}
	
	protected function redirectOnLoggedIn() {

		if ($this->isLoggedIn) {
			header('Location: ' . $this->config->baseURL . $this->data['module_role']->nama_module);
			// redirect($this->router->default_controller);
		}
	}
	
	protected function mustNotLoggedIn() {
		if ($this->isLoggedIn) {	
			if ($this->currentModule['nama_module'] == 'login') {
				header('Location: ' . $this->config->baseURL . $this->data['module_role']->nama_module);
				exit();
			}
		}
	}
	
	protected function mustLoggedIn() {
		if (!$this->isLoggedIn) {
			header('Location: ' . $this->config->baseURL . 'login');
			exit();
		}
	}
	
	private function checkRoleAction() 
	{
		if ($this->config->checkRoleAction['enable_global']) 
		{
			$method = $this->session->get('web')['method_name'];
			$error = false;
			if ($method == 'add') {
				if ($this->actionUser['create_data'] == 'no') {
					$error = 'Role Anda tidak diperkenankan untuk menambah data';
				}
			} else if ($method == 'edit') {
				if ($this->actionUser['update_data'] == 'no') {
					$error = 'Role Anda tidak diperkenankan untuk mengubah data';
				}
			} else {
				if (!empty($_POST['delete'])) {
					if ($this->actionUser['delete_data'] == 'no') {
						$error = 'Role Anda tidak diperkenankan untuk menghapus data';
					}
				}
			}
			
			if ($error) {
				$this->data['msg'] = ['status' => 'error', 'message' => $error];
				$this->view('error.php', $this->data);
				exit;
			}
		}
		
	}
	
	protected function cekHakAkses($action, $table_column = null, $column_check = null) {

		$action_title = ['read_data' => 'membuka data', 'create_data' => 'menambah data', 'update_data' => 'mengubah data', 'delete_data' => 'menghapus data'];
		$allowed = $this->actionUser[$action];
				
		if ($allowed == 'no') {
			$this->currentModule['nama_module'] = 'error';
			$this->data['msg'] = ['status' => 'error', 'message' => 'Role Anda tidak diperkenankan untuk ' . $action_title[$action]];
			$this->view('error.php', $this->data);
		} 
		else if ($allowed == 'own') 
		{
			// Read -> go to where_own()
			if ($action == 'read_data') 
				return true;
			
			// Update and delete
			$column = '';
			if ($table_column) {
				$exp = explode('|', $table_column);
				$table = $exp[0];
				$column = @$exp[1];
			} else {
				$table = $this->currentModule['nama_module'];
			}
			
			if (!$column) {
				$column = 'id_' . $table;
			}
			
			if (!$column_check) {
				$column_check = $this->config->checkRoleAction['field'];
			}
			
			$result = $this->model->getDataById($table, $column, trim($_REQUEST['id']));
					
			if ($result) {
				$data = $result[0];
				
				if ($data[$column_check] != $_SESSION['user']['id_user']) {
					$this->data['msg'] = ['status' => 'error', 'message' => 'Role Anda tidak diperkenankan untuk ' . $action_title[$action] . ' ini'];
					$this->view('/error.php', $this->data);
				}
			}
		}
	}
	
	public function whereOwn($column = null) 
	{	
		if (!$column)
			$column = $this->config->checkRoleAction['field'];
			
		if ($this->actionUser['read_data'] == 'own') {
			return ' WHERE ' . $column . ' = ' . $_SESSION['user']['id_user'];
		}
		
		return ' WHERE 1 = 1 ';
	}
	
	protected function printError($message) {
		$this->data['title'] = 'Error...';
		$this->data['msg'] = $message;
		$this->view('error.php', $this->data);
	}
	
	/* Used for modules when edited data not found */
	protected function errorDataNotFound($addData = null) {
		$data = $this->data;
		$data['title'] = 'Error';
		$data['msg']['status'] = 'error';
		$data['msg']['content'] = 'Data tidak ditemukan';
		
		if ($addData) {
			$data = array_merge($data, $addData);
		}
		$this->view('error-data-notfound.php', $data);
	}
}