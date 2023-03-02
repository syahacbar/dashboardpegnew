<?php
namespace App\Controllers; 
use App\Models\PindahInstansiModel;

class Pindahinstansi extends BaseController
{

	public function __construct() {
		
		parent::__construct(); 
		
		$this->model = new PindahInstansiModel;	
		$this->data['site_title'] = 'Image Upload';
		
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
		
		$id_instansi = SHA1($this->session->get('user')['id_instansi']);

		$data = $this->data;

		$data['instansiasal'] = $this->model->get_instansi_asal($id_instansi);
		$data['instansipenerima'] = $this->model->get_instansi_penerima($id_instansi);
		$data['status'] = $this->model->get_status($id_instansi);
		$this->view('pindahinstansi.php', $data);
	}

	public function getDataDT() {
		
		$this->cekHakAkses('read_data');

		$id_instansi = $this->session->get('user')['id_instansi'];
		
		$num_data = $this->model->countAllData($this->whereOwn(),SHA1($id_instansi));
		$result['draw'] = $start = $this->request->getPost('draw') ?: 1;
		$result['recordsTotal'] = $num_data;
		
		$query = $this->model->getListData($this->whereOwn(),SHA1($id_instansi));
		$result['recordsFiltered'] = $query['total_filtered'];
				
		helper(['html','format']);
		
		$no = $this->request->getPost('start') + 1 ?: 1;
		foreach ($query['data'] as $key => &$val) 
		{
			
			$val['ignore_search_urut'] = $no;
			$no++;
		}
					
		$result['data'] = $query['data'];
		echo json_encode($result); exit();
	}
}