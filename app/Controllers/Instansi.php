<?php
namespace App\Controllers; 
use App\Models\InstansiModel;

class Instansi extends BaseController
{

	public function __construct() { 
		
		parent::__construct(); 
		
		$this->model = new InstansiModel;	
		$this->data['site_title'] = 'Image Upload';

		$this->addJs ( $this->config->baseURL . 'public/vendors/jquery.select2/js/select2.full.min.js' );
		$this->addStyle ( $this->config->baseURL . 'public/vendors/jquery.select2/css/select2.min.css' );
		$this->addStyle ( $this->config->baseURL . 'public/vendors/jquery.select2/bootstrap-5-theme/select2-bootstrap-5-theme.min.css' );
		
		$this->addJs ( $this->config->baseURL . 'public/themes/modern/js/options-dinamis.js' );
		$this->addJs ( $this->config->baseURL . 'public/vendors/bootstrap-datepicker/js/bootstrap-datepicker.js' );
		
		$this->addJs ( $this->config->baseURL . 'public/themes/modern/js/date-picker.js');
		$this->addJs ( $this->config->baseURL . 'public/themes/modern/js/image-upload.js');
		$this->addJs ( $this->config->baseURL . 'public/themes/modern/js/data-tables-ajax.js');
		$this->addJs ( $this->config->baseURL . 'public/vendors/datatables/extensions/Buttons/js/dataTables.buttons.min.js');
		$this->addJs ( $this->config->baseURL . 'public/vendors/datatables/extensions/Buttons/js/buttons.bootstrap5.min.js');
		$this->addJs ( $this->config->baseURL . 'public/vendors/datatables/extensions/JSZip/jszip.min.js');
		$this->addJs ( $this->config->baseURL . 'public/vendors/datatables/extensions/pdfmake/pdfmake.min.js');
		$this->addJs ( $this->config->baseURL . 'public/vendors/datatables/extensions/pdfmake/vfs_fonts.js');
		$this->addJs ( $this->config->baseURL . 'public/vendors/datatables/extensions/Buttons/js/buttons.html5.min.js');
		$this->addJs ( $this->config->baseURL . 'public/vendors/datatables/extensions/Buttons/js/buttons.print.min.js');
		$this->addStyle ( $this->config->baseURL . 'public/vendors/datatables/extensions/Buttons/css/buttons.bootstrap5.min.css');
		$this->addStyle ( $this->config->baseURL . 'public/vendors/bootstrap-datepicker/css/bootstrap-datepicker3.css');
	}
	

	public function index()
	{
		$this->cekHakAkses('read_data');
		if ($this->request->getPost('delete')) 
		{
			// $this->cekHakAkses('delete_data', 'user', 'id_user');
			
			$result = $this->model->deleteInstansi();
			if ($result) {
				$data['message'] = ['status' => 'ok', 'message' => 'Data Instansi berhasil dihapus'];
			} else {
				$data['message'] = ['status' => 'warning', 'message' => 'Tidak ada data yang dihapus'];
			}
		}

		$data = $this->data;

		$this->view('instansi.php', $data);
	}

	public function getDataDT() {
		
		$this->cekHakAkses('read_data');
		
		$num_data = $this->model->countAllData($this->whereOwn());
		$result['draw'] = $start = $this->request->getPost('draw') ?: 1;
		$result['recordsTotal'] = $num_data;
		
		$query = $this->model->getListData($this->whereOwn());
		$result['recordsFiltered'] = $query['total_filtered'];
				
		helper(['html','format']);
		
		$no = $this->request->getPost('start') + 1 ?: 1;
		foreach ($query['data'] as $key => &$val) 
		{			
			$val['ignore_search_urut'] = $no;
			$val['gambar_instansi'] = '<img align="center" src="'.$this->config->baseURL.'public/images/logoinstansi/'.$val['gambar'].'">';
			$no++;
			$val['ignore_search_action'] = btn_action([
				'edit' => ['url' => $this->config->baseURL . $this->currentModule['nama_module'] . '/edit?id='. SHA1($val['id_instansi'])],
				'delete' => ['url' => '', 
							 'id' =>  $val['id_instansi'],
							 'delete-title' => 'Hapus data Instansi: <strong>'.$val['nama_instansi'].'</strong> ?']
			]);
		}
					
		$result['data'] = $query['data'];
		echo json_encode($result); exit();
	}

	public function add() 
	{
		$this->cekHakAkses('create_data');
		
		$data = $this->data;
		$data['title'] = 'Tambah Data Instansi';
		$data['breadcrumb']['Add'] = '';
		
		// Submit
		$data['msg'] = [];
		$id_instansi = false;
		if (isset($_POST['submit'])) 
		{
			// $form_errors = validate_form();
			$form_errors = false;
							
			if ($form_errors) {
				$data['msg']['status'] = 'error';
				$data['msg']['content'] = $form_errors;
			} else {
				
				// $query = false;
				$id_instansi = $this->model->saveData();
			
				if ($id_instansi) {
					$data['msg']['status'] = 'ok';
					$data['msg']['content'] = 'Data berhasil disimpan';
				} else {
					$data['msg']['status'] = 'error';
					$data['msg']['content'] = 'Data gagal disimpan';
				}
				
				$data['title'] = 'Edit Data Instansi';
			}
		}
		
		if ($id_instansi) 
		{
			$data['breadcrumb']['Edit'] = '';
			
			$data['title'] = 'Edit Data Instansi';
			$data['id_instansi'] = $id_instansi;
			
			$data_instansi = $this->setData($id_instansi);
			if (empty($data_instansi['nama_instansi'])) {
				$this->errorDataNotFound();
				return;
			}
			$data = array_merge ($data, $data_instansi);
			
		}
		
		$data_options = $this->setDataOptions();
		$data = array_merge ($data, $data_options);
	
		$this->view('instansi-form.php', $data);
	}

	public function edit()
	{
		$this->data['title'] = 'Edit Data';
		$data = $this->data;
		
		if (empty($_GET['id'])) {
			$this->errorDataNotFound();
			return;
		}
		
		$this->cekHakAkses('create_data');
		
		// Submit
		$data['msg'] = [];
		if (isset($_POST['submit'])) 
		{
			// $form_errors = validate_form();
			$form_errors = false;
							
			if ($form_errors) {
				$data['msg']['status'] = 'error';
				$data['msg']['content'] = $form_errors;
			} else {
				
				// $query = false;
				$query = $this->model->saveData();
				
				if ($query) {
					$data['msg']['status'] = 'ok';
					$data['msg']['content'] = 'Data berhasil disimpan';
				} else {
					$data['msg']['status'] = 'error';
					$data['msg']['content'] = 'Data gagal disimpan';
				}
				
				$data['title'] = 'Edit Data Instansi';
			}
		}
		
		if (!empty($_GET['id'])) 
		{
			$breadcrumb['Edit'] = '';
			
			$data['title'] = 'Edit Data Instansi';
			
			$data_instansi = $this->setData($_GET['id']);
			if (empty($data_instansi['nama_instansi'])) {
				$this->errorDataNotFound();
				return;
			}
			
			$data = array_merge ($data, $data_instansi);
			// $data['id_instansi'] = $_GET['id'];
		}
		
		$data_options = $this->setDataOptions();
		$data = array_merge ($data, $data_options);
		
		
		$data['breadcrumb']['Edit'] = '';
		$this->view('instansi-form.php', $data);
	}

	private function setDataOptions() 
	{
		$result = $this->model->getUserforInstansi();
		$userx = [];
		foreach($result as $val) {
			$userx[$val['id_user']] = $val['username'];
		}
			
		$data['userx'] = $userx;
		
		return $data;
	}
	
	private function setData($id) {
		
		$data = [];
		$result = $this->model->getInstansi($id);
		foreach ($result as $arr) {
			foreach ($arr as $key => $val) {
				$data[$key]	= $val;
			}
		}
		
		$result = $this->model->getUserInstansi($id);
		foreach ($result as $arr) {
			foreach ($arr as $key => $val) {
				$data['id_user'][]	= $val;
			}
		}
		
	
		
		return $data;
	}

	private function validateForm() {

		$validation =  \Config\Services::validation();
		$validation->setRule('id_user[]', 'Nama User', 'trim|required');
		$validation->withRequest($this->request)->run();
		$form_errors = $validation->getErrors();
		
		return $form_errors;
	}
	
}