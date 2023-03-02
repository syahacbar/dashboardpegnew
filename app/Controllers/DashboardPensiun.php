<?php

namespace App\Controllers;

use App\Models\DashboardModel;

class DashboardPensiun extends BaseController
{
	public function __construct()
	{
		parent::__construct();
		$this->model = new DashboardModel;
		$this->addJs($this->config->baseURL . 'public/vendors/chartjs/chart.js');
		$this->addStyle($this->config->baseURL . 'public/vendors/material-icons/css.css');

		$this->addJs($this->config->baseURL . 'public/vendors/datatables/extensions/Buttons/js/dataTables.buttons.min.js');
		$this->addJs($this->config->baseURL . 'public/vendors/datatables/extensions/Buttons/js/buttons.bootstrap5.min.js');
		$this->addJs($this->config->baseURL . 'public/vendors/datatables/extensions/JSZip/jszip.min.js');
		$this->addJs($this->config->baseURL . 'public/vendors/datatables/extensions/pdfmake/pdfmake.min.js');
		$this->addJs($this->config->baseURL . 'public/vendors/datatables/extensions/pdfmake/vfs_fonts.js');
		$this->addJs($this->config->baseURL . 'public/vendors/datatables/extensions/Buttons/js/buttons.html5.min.js');
		$this->addJs($this->config->baseURL . 'public/vendors/datatables/extensions/Buttons/js/buttons.print.min.js');
		$this->addStyle($this->config->baseURL . 'public/vendors/datatables/extensions/Buttons/css/buttons.bootstrap5.min.css');

		$this->addStyle($this->config->baseURL . 'public/themes/modern/css/dashboard.css');
		$this->addJs($this->config->baseURL . 'public/themes/modern/js/dashboard.js');
	}

	public function index()
	{
		$this->data['count_usulan_pensiun_by_status'] = $this->model->count_usulan_pensiun_by_status();
		$this->data['count_usulan_pensiun_by_instansi'] = $this->model->count_usulan_pensiun_by_instansi();
		$this->data['count_usulan_pensiun_by_jabatan'] = $this->model->count_usulan_pensiun_by_jabatan();
		$this->data['count_usulan_pensiun_by_jenisjabatan'] = $this->model->count_usulan_pensiun_by_jenisjabatan();
		$this->data['count_usulan_pensiun_by_jenisusulan'] = $this->model->count_usulan_pensiun_by_jenisusulan();
		
		$this->view('dashboard_pensiun.php', $this->data);
	}

	
}
