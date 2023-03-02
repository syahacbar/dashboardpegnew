<?php
namespace App\Models;

class DashboardModel extends \App\Models\BaseModel
{
	public function __construct() {
		parent::__construct();
	}

	

	public function count_jenis_jabatan($jj)
	{
		if($jj == 'STR')
		{
			$sql = 'SELECT COUNT(tp.str_namajabatan) AS jumlah FROM tbl_pegawai tp WHERE tp.str_namajabatan <>""';
		}
		elseif ($jj == 'FU')
		{
			$sql = 'SELECT COUNT(tp.fung_namajabatan_fu) AS jumlah FROM tbl_pegawai tp WHERE tp.fung_namajabatan_fu <>""';
		} 
		elseif ($jj == 'FT')
		{
			$sql = 'SELECT COUNT(tp.fung_namajabatan_ft) AS jumlah FROM tbl_pegawai tp WHERE tp.fung_namajabatan_ft <>""';
		}
		
		$result = $this->db->query($sql)->getRow();
		return $result;
	}

	public function count_kedudukan_hukum()
	{
		$sql = 'SELECT tp.kedudukan_hukum, COUNT(tp.kedudukan_hukum) AS jumlah_pegawai FROM tbl_pegawai tp GROUP BY tp.kedudukan_hukum';
		$result = $this->db->query($sql)->getResult();
		return $result;
	}

	

	

	

	




	//untuk dashboard counter mutasi
	public function count_total_usulan_kp()
	{
		$sql = 'SELECT COUNT(tk.id_instansi) AS total_usulan_kp FROM tbl_kenaikanpangkat tk RIGHT JOIN tbl_instansi ti ON ti.id_instansi=tk.id_instansi';
		$result = $this->db->query($sql)->getRow();
		return $result;
	}

	public function count_total_usulan_pindahinstansi()
	{
		$sql = 'SELECT COUNT(tpi.id_instansi) AS total_usulan_pindahinstansi FROM tbl_pindah_instansi tpi RIGHT JOIN tbl_instansi ti ON ti.id_instansi=tpi.id_instansi';
		$result = $this->db->query($sql)->getRow();
		return $result;
	}

	//untuk dashboard counter pensiun
	public function count_usulan_pensiun_by_status()
	{
		$sql = 'SELECT tp.status_usulan, COUNT(tp.status_usulan) AS total_usulan_pensiun FROM tbl_pensiun tp GROUP BY tp.status_usulan';
		$result = $this->db->query($sql)->getResult();
		return $result;
	}

	//untuk graph usulan kp berdasarkan instansi
	public function count_usulan_kp()
	{
		$sql = 'SELECT ti.nama_instansi, COUNT(tk.id_instansi) AS jumlah_usulan_kp FROM tbl_kenaikanpangkat tk RIGHT JOIN tbl_instansi ti ON ti.id_instansi=tk.id_instansi GROUP BY ti.id_instansi';
		$result = $this->db->query($sql)->getResult();
		return $result;
	}
	public function count_usulan_kp_by_status()
	{
		$sql = 'SELECT tk.status, COUNT(tk.status) AS jumlah_status FROM tbl_kenaikanpangkat tk GROUP BY tk.status';
		$result = $this->db->query($sql)->getResult();
		return $result;
	}

	//untuk graph usulan pindah instansi
	public function count_usulan_pindahinstansi()
	{
		$sql = 'SELECT ti.nama_instansi, COUNT(tpi.id_instansi) AS jumlah_usulan_pindahinstansi FROM tbl_pindah_instansi tpi RIGHT JOIN tbl_instansi ti ON ti.id_instansi=tpi.id_instansi GROUP BY ti.id_instansi';
		$result = $this->db->query($sql)->getResult();
		return $result;
	}
	public function count_usulan_pindahinstansi_by_status()
	{
		$sql = 'SELECT tpi.status, COUNT(tpi.status) AS jumlah_status FROM tbl_pindah_instansi tpi GROUP BY tpi.status';
		$result = $this->db->query($sql)->getResult();
		return $result;
	}

	//untuk graph usulan pensiun instansi
	public function count_usulan_pensiun_by_instansi()
	{
		$sql = 'SELECT ti.nama_instansi, COUNT(tp.id_instansi) AS jumlah_usulan_pensiun FROM tbl_pensiun tp RIGHT JOIN tbl_instansi ti ON ti.id_instansi=tp.id_instansi GROUP BY ti.id_instansi';
		$result = $this->db->query($sql)->getResult();
		return $result;
	}

	public function count_usulan_pensiun_by_jabatan()
	{
		$sql = 'SELECT tp.jabatan, COUNT(tp.jabatan) AS jumlah_usulan_pensiun FROM tbl_pensiun tp GROUP BY tp.jabatan';
		$result = $this->db->query($sql)->getResult();
		return $result;
	}

	public function count_usulan_pensiun_by_jenisjabatan()
	{
		$sql = 'SELECT tp.jenis_jabatan, COUNT(tp.jenis_jabatan) AS jumlah_usulan_pensiun FROM tbl_pensiun tp GROUP BY tp.jenis_jabatan';
		$result = $this->db->query($sql)->getResult();
		return $result;
	}

	public function count_usulan_pensiun_by_jenisusulan()
	{
		$sql = 'SELECT tp.jenis_usulan_pensiun, COUNT(tp.jenis_usulan_pensiun) AS jumlah_usulan_pensiun FROM tbl_pensiun tp GROUP BY tp.jenis_usulan_pensiun';
		$result = $this->db->query($sql)->getResult();
		return $result;
	}

	//dashboard admin
	public function count_pegawai_all()
	{
		$sql = 'SELECT COUNT(id_pegawai) AS totalpegawai FROM tbl_pegawai';
		$result = $this->db->query($sql)->getRow();
		return $result;
	}

	public function count_pensiun_all()
	{
		$sql = 'SELECT COUNT(id_pensiun) AS totalpensiun FROM tbl_pensiun';
		$result = $this->db->query($sql)->getRow();
		return $result;
	}

	public function count_pegawai_by_instansi()
	{
		$sql = 'SELECT ti.nama_instansi, COUNT(tp.id_instansi) AS jumlah_pegawai FROM tbl_pegawai tp RIGHT JOIN tbl_instansi ti ON ti.id_instansi=tp.id_instansi GROUP BY ti.id_instansi';
				
		$result = $this->db->query($sql)->getResult();
		return $result;
	}


}