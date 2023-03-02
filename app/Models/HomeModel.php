<?php
namespace App\Models;

class HomeModel extends \App\Models\BaseModel
{
	public function __construct() {
		parent::__construct();
	}
	
	public function get_all_data_by_instansi() {
		$sql = 'SELECT ti.*, (SELECT COUNT(tp.id_pegawai) AS totpegawai FROM tbl_pegawai tp WHERE tp.id_instansi=ti.id_instansi) AS TotPegawai FROM tbl_instansi ti';
		$result = $this->db->query($sql)->getResult();
		return $result;
	}

	public function get_data_by_instansi($id_instansi) {
		$sql = 'SELECT * FROM tbl_instansi ti WHERE SHA1(ti.id_instansi)="'.$id_instansi.'"';
		$result = $this->db->query($sql)->getRow();
		return $result;
	}

	public function get_all_pegawai_by_instansi($id_instansi) {
		$sql = 'SELECT COUNT(tp.id_pegawai) AS totalpegawaiinstansi FROM tbl_pegawai tp WHERE SHA1(tp.id_instansi)="'.$id_instansi.'"';
		$result = $this->db->query($sql)->getRow();
		return $result;
	}

	public function get_all_golru_by_instansi($id_instansi)
	{
		$sql = 'SELECT gol_akhir,COUNT(gol_akhir) AS jum_golru FROM tbl_pegawai WHERE SHA1(id_instansi)="'.$id_instansi.'" GROUP BY gol_akhir';
		$result = $this->db->query($sql)->getResult();
		return $result;
	}

	public function get_jenkel_by_instansi($id_instansi)
	{
		$sql = 'SELECT IF (tp.jk ="L","Laki-Laki","Perempuan") AS gender, COUNT(tp.jk) AS jum_gender FROM tbl_pegawai tp WHERE SHA1(tp.id_instansi)="'.$id_instansi.'" GROUP BY tp.jk DESC';
		$result = $this->db->query($sql)->getResult();
		return $result;
	}

	public function count_pegawai_by_instansi($id_instansi)
	{
		$sql = 'SELECT COUNT(id_pegawai) AS totalpegawai FROM tbl_pegawai WHERE SHA(id_instansi)="'.$id_instansi.'"';
		$result = $this->db->query($sql)->getRow();
		return $result;
	}


	public function get_jenjab_by_instansi($id_instansi)
	{
		$sql = 'SELECT tp.jenis_jabatan AS jj, COUNT(tp.jenis_jabatan) AS jum_jj FROM tbl_pegawai tp WHERE SHA1(tp.id_instansi)="'.$id_instansi.'" GROUP BY tp.jenis_jabatan';
		$result = $this->db->query($sql)->getResult();
		return $result;
	}

	public function count_jenis_jabatan($id_instansi,$jj)
	{
		if($jj == 'STR')
		{
			$sql = 'SELECT COUNT(tp.str_namajabatan) AS jumlah FROM tbl_pegawai tp WHERE SHA1(tp.id_instansi)="'.$id_instansi.'" and tp.str_namajabatan <>""';
		}
		elseif ($jj == 'FU')
		{
			$sql = 'SELECT COUNT(tp.fung_namajabatan_fu) AS jumlah FROM tbl_pegawai tp WHERE SHA1(tp.id_instansi)="'.$id_instansi.'" and tp.fung_namajabatan_fu <>""';
		} 
		elseif ($jj == 'FT')
		{
			$sql = 'SELECT COUNT(tp.fung_namajabatan_ft) AS jumlah FROM tbl_pegawai tp WHERE SHA1(tp.id_instansi)="'.$id_instansi.'" and tp.fung_namajabatan_ft <>""';
		}
		 
		$result = $this->db->query($sql)->getRow();
		return $result;
	}

	public function get_usulankp_by_instansi($id_instansi)
	{
		$waktu_update = $this->get_active_data($id_instansi);
		if($waktu_update != NULL)
		{
			$wu_arr = array();
			$urut = 1;
			foreach($waktu_update AS $wu)
			{
				$wu_arr[$urut] = $wu->waktu_upload;
				$urut++;
			}
			$wherewaktuupload = implode(",",$wu_arr);
			$sql = 'SELECT tkp.status, COUNT(tkp.status) AS jum_ukp FROM tbl_kenaikanpangkat tkp WHERE SHA1(tkp.id_instansi)="'.$id_instansi.'" AND waktu_update IN ("'.$wherewaktuupload.'") GROUP BY tkp.status';
		} else {
			$sql = 'SELECT tkp.status, COUNT(tkp.status) AS jum_ukp FROM tbl_kenaikanpangkat tkp WHERE SHA1(tkp.id_instansi)="'.$id_instansi.'" GROUP BY tkp.status';
		}
		$result = $this->db->query($sql)->getResult();
		return $result;
	}

	public function count_all_usulankp_by_instansi($id_instansi)
	{
		$waktu_update = $this->get_active_data($id_instansi);
		if($waktu_update != NULL)
		{
			$wu_arr = array();
			$urut = 1;
			foreach($waktu_update AS $wu)
			{
				$wu_arr[$urut] = $wu->waktu_upload;
				$urut++;
			}
			$wherewaktuupload = implode(",",$wu_arr);
			$sql = 'SELECT COUNT(tkp.status) AS jum_ukp FROM tbl_kenaikanpangkat tkp WHERE SHA1(tkp.id_instansi)="'.$id_instansi.'" AND waktu_update IN ("'.$wherewaktuupload.'")';
		}
		else
		{
			$sql = 'SELECT COUNT(tkp.status) AS jum_ukp FROM tbl_kenaikanpangkat tkp WHERE SHA1(tkp.id_instansi)="'.$id_instansi.'"';
		}

		
		$result = $this->db->query($sql)->getRow();
		return $result;
	}

	public function count_usulankp_by_instansi($id_instansi,$status)
	{
		$waktu_update = $this->get_active_data($id_instansi);
		if($waktu_update != NULL)
		{
			$wu_arr = array();
			$urut = 1;
			foreach($waktu_update AS $wu)
			{
				$wu_arr[$urut] = $wu->waktu_upload;
				$urut++;
			}
			$wherewaktuupload = implode(",",$wu_arr);
			$sql = 'SELECT COUNT(tkp.status) AS countstatus FROM tbl_kenaikanpangkat tkp WHERE SHA1(tkp.id_instansi)="'.$id_instansi.'" AND tkp.status="'.$status.'" AND waktu_update IN ("'.$wherewaktuupload.'")';
		}
		else
		{
			$sql = 'SELECT COUNT(tkp.status) AS countstatus FROM tbl_kenaikanpangkat tkp WHERE SHA1(tkp.id_instansi)="'.$id_instansi.'" AND tkp.status="'.$status.'"';
		}

		
		$result = $this->db->query($sql)->getRow();
		return $result;

	}

	// public function count_usulan_kp_by_status($status)
	// {
	// 	$waktu_update = $this->get_active_data($id_instansi);
	// 	if($waktu_update != NULL)
	// 	{
	// 		$wu_arr = array();
	// 		$urut = 1;
	// 		foreach($waktu_update AS $wu)
	// 		{
	// 			$wu_arr[$urut] = 'waktu_update="'.$wu->waktu_upload.'"';
	// 			$urut++;
	// 		}
	// 		$wherewaktuupload = implode(" OR ",$wu_arr);
	// 	}
	// 	$sql = 'SELECT COUNT(tk.status) AS jumlah_status FROM tbl_kenaikanpangkat tk WHERE tk.status="'.$status.'" AND '.$wherewaktuupload;
	// 	$result = $this->db->query($sql)->getRow();
	// 	return $result;
	// }

	public function get_active_data($id_instansi)
	{
		$sql = 'SELECT * FROM tbl_history_import WHERE aktif="0" AND SHA1(id_instansi) = "'.$id_instansi.'"';
		$result = $this->db->query($sql)->getResult();
		return $result;
	}
	
}