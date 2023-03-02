<?php

namespace App\Controllers;

use App\Models\DashboardModel;

class DashboardMutasi extends BaseController
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
		$this->data['count_usulan_kp'] = $this->model->count_usulan_kp();
		$this->data['count_total_usulan_kp'] = $this->model->count_total_usulan_kp();
		$this->data['count_total_usulan_pindahinstansi'] = $this->model->count_total_usulan_pindahinstansi();

		$this->data['count_usulan_kp_by_status'] = $this->model->count_usulan_kp_by_status();

		$this->data['count_usulan_pindahinstansi'] = $this->model->count_usulan_pindahinstansi();
		$this->data['count_usulan_pindahinstansi_by_status'] = $this->model->count_usulan_pindahinstansi_by_status();

		$this->view('dashboard_mutasi.php', $this->data);
	}

	
}
