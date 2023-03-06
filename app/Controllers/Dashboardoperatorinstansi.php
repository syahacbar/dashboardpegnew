<?php
namespace App\Controllers;
use App\Models\HomeModel;

class Dashboardoperatorinstansi extends BaseController
{
	public function __construct() {
		parent::__construct();
		$this->model = new HomeModel;
		$this->addJs($this->config->baseURL . 'public/vendors/chartjs/chart.js');
		$this->addStyle($this->config->baseURL . 'public/vendors/material-icons/css.css');
		
		$this->addJs ( $this->config->baseURL . 'public/vendors/datatables/extensions/Buttons/js/dataTables.buttons.min.js');
		$this->addJs ( $this->config->baseURL . 'public/vendors/datatables/extensions/Buttons/js/buttons.bootstrap5.min.js');
		$this->addJs ( $this->config->baseURL . 'public/vendors/datatables/extensions/JSZip/jszip.min.js');
		$this->addJs ( $this->config->baseURL . 'public/vendors/datatables/extensions/pdfmake/pdfmake.min.js');
		$this->addJs ( $this->config->baseURL . 'public/vendors/datatables/extensions/pdfmake/vfs_fonts.js');
		$this->addJs ( $this->config->baseURL . 'public/vendors/datatables/extensions/Buttons/js/buttons.html5.min.js');
		$this->addJs ( $this->config->baseURL . 'public/vendors/datatables/extensions/Buttons/js/buttons.print.min.js');
		$this->addStyle ( $this->config->baseURL . 'public/vendors/datatables/extensions/Buttons/css/buttons.bootstrap5.min.css');
		
		$this->addStyle($this->config->baseURL . 'public/themes/modern/css/dashboard.css');
		$this->addJs($this->config->baseURL . 'public/themes/modern/js/dashboard.js');

		//untuk highchart
		$this->addStyle('https://code.highcharts.com/css/highcharts.css');
		$this->addJs('https://code.highcharts.com/highcharts.js');
		$this->addJs('https://code.highcharts.com/highcharts-3d.js');
		$this->addJs('https://code.highcharts.com/modules/exporting.js');
		$this->addJs('https://code.highcharts.com/modules/export-data.js');
		$this->addJs('https://code.highcharts.com/modules/accessibility.js');
		$this->addJs('https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.1.4/Chart.bundle.min.js');
	}
 
	public function index() 
	{		 
		$userdata = $_SESSION['user'];
		$id_instansi = SHA1($userdata['id_instansi']);
		$this->data['instansi'] = $this->model->get_data_by_instansi($id_instansi);
		$this->data['pegawai'] = $this->model->get_all_pegawai_by_instansi($id_instansi);
		$this->data['golru'] = $this->model->get_all_golru_by_instansi($id_instansi);
		$this->data['gender'] = $this->model->get_jenkel_by_instansi($id_instansi);
		$this->data['jenjab1'] = $this->model->count_jenis_jabatan($id_instansi,'STR');
		$this->data['jenjab2'] = $this->model->count_jenis_jabatan($id_instansi,'FU');
		$this->data['jenjab3'] = $this->model->count_jenis_jabatan($id_instansi,'FT');
		$this->data['usulankp'] = $this->model->get_usulankp_by_instansi($id_instansi);
		$this->data['usulanpi'] = $this->model->get_usulanpi_by_instansi($id_instansi);
		$this->data['usulanpensiun'] = $this->model->get_usulanpensiun_by_instansi($id_instansi);
		$this->data['totalpegawai'] = $this->model->count_pegawai_by_instansi($id_instansi);
		//untuk kenaikan pangkat
		$this->data['totalukp'] = $this->model->count_all_usulankp_by_instansi($id_instansi);
		$this->data['totalukpTMS'] = $this->model->count_usulankp_by_instansi($id_instansi,'TMS');
		$this->data['totalukpBMS'] = $this->model->count_usulankp_by_instansi($id_instansi,'BMS');
		$this->data['totalukpMS'] = $this->model->count_usulankp_by_instansi($id_instansi,'MS');
		$this->data['totalukpDalamProses'] = $this->model->count_usulankp_by_instansi($id_instansi,'DALAM PROSES VALIDASI');
		//untuk pindah instansi
		$this->data['totalpi'] = $this->model->count_all_usulanpi_by_instansi($id_instansi);
		$this->data['totalpiTMS'] = $this->model->count_usulanpi_by_instansi($id_instansi,'TMS');
		$this->data['totalpiBMS'] = $this->model->count_usulanpi_by_instansi($id_instansi,'BMS');
		$this->data['totalpiMS'] = $this->model->count_usulanpi_by_instansi($id_instansi,'MS');
		$this->data['totalpiDalamProses'] = $this->model->count_usulanpi_by_instansi($id_instansi,'DALAM PROSES VALIDASI');
		//untuk pensiun
		$this->data['totalpensiun'] = $this->model->count_all_usulanpensiun_by_instansi($id_instansi);
		$this->data['totalpensiunTMS'] = $this->model->count_usulanpensiun_by_instansi($id_instansi,'TMS');
		$this->data['totalpensiunBMS'] = $this->model->count_usulanpensiun_by_instansi($id_instansi,'BMS');
		$this->data['totalpensiunMS'] = $this->model->count_usulanpensiun_by_instansi($id_instansi,'MS');
		$this->data['totalpensiunDalamProses'] = $this->model->count_usulanpensiun_by_instansi($id_instansi,'DALAM PROSES VALIDASI');
		$this->view('dashboardoperatorinstansi.php', $this->data);
	}
}