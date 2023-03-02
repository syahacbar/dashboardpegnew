<?php

namespace App\Controllers;

use App\Models\HomeModel;

class Home extends BaseController
{
	public function __construct()
	{
		parent::__construct();
		$this->model = new HomeModel;
	}

	public function index()
	{
		$instansi = $this->model->get_all_data_by_instansi();
		$this->data['instansi'] = $instansi;
		return view('themes/modern/home.php', $this->data);
	}

	public function newhome()
	{
		$instansi = $this->model->get_all_data_by_instansi();
		$this->data['instansi'] = $instansi;
		return view('themes/modern/home1.php', $this->data);
	}

	public function detail($id_instansi)
	{
		$this->data['instansi'] = $this->model->get_data_by_instansi($id_instansi);
		$this->data['golru'] = $this->model->get_all_golru_by_instansi($id_instansi);
		$this->data['gender'] = $this->model->get_jenkel_by_instansi($id_instansi);
		$this->data['jenjab1'] = $this->model->count_jenis_jabatan($id_instansi, 'STR');
		$this->data['jenjab2'] = $this->model->count_jenis_jabatan($id_instansi, 'FU');
		$this->data['jenjab3'] = $this->model->count_jenis_jabatan($id_instansi, 'FT');
		$this->data['pegawai'] = $this->model->get_all_pegawai_by_instansi($id_instansi);
		$this->data['totalpegawai'] = $this->model->count_pegawai_by_instansi($id_instansi);

		return view('themes/modern/detail_instansi.php', $this->data);
	}
}
