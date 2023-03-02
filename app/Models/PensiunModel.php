<?php

namespace App\Models;

class PensiunModel extends \App\Models\BaseModel
{
	private $fotoPath;
	
	public function __construct() {
		parent::__construct();
	}

	public function get_satuankerja($id_instansi) {
		$sql = 'SELECT DISTINCT instansi FROM tbl_pensiun WHERE instansi<>"" AND SHA1(id_instansi) = "'.$id_instansi.'"';
		$result = $this->db->query($sql)->getResult();
		return $result;
	}

	public function get_jenis_jabatan($id_instansi) {
		$sql = 'SELECT DISTINCT jenis_jabatan FROM tbl_pensiun WHERE jenis_jabatan<>"" AND SHA1(id_instansi) = "'.$id_instansi.'"';
		$result = $this->db->query($sql)->getResult();
		return $result;
	}

	public function get_jenis_usulan_pensiun($id_instansi) {
		$sql = 'SELECT DISTINCT jenis_usulan_pensiun FROM tbl_pensiun WHERE jenis_usulan_pensiun<>"" AND SHA1(id_instansi) = "'.$id_instansi.'"';
		$result = $this->db->query($sql)->getResult();
		return $result;
	}

	public function get_status_usulan($id_instansi) {
		$sql = 'SELECT DISTINCT status_usulan FROM tbl_pensiun WHERE status_usulan<>"" AND SHA1(id_instansi) = "'.$id_instansi.'"';
		$result = $this->db->query($sql)->getResult();
		return $result;
	}
	
	public function countAllData($where,$id_instansi) {
		$sql = 'SELECT COUNT(*) AS jml FROM tbl_pensiun '. $where . ' AND SHA1(id_instansi) = "'.$id_instansi.'"';
		$result = $this->db->query($sql)->getRow();
		return $result->jml;
	}

	public function get_active_data($id_instansi)
	{
		$sql = 'SELECT * FROM tbl_history_import WHERE aktif="1" AND tabel="tbl_pensiun" AND SHA1(id_instansi) = "'.$id_instansi.'"';
		$result = $this->db->query($sql)->getResult();
		return $result;
	}
	
	public function getListData($where,$id_instansi) {

		$columns = $this->request->getPost('columns');
	    $searchName = @$this->request->getPost('search')['value'];
		$searchSatuanKerja = $_POST['searchSatuanKerja'];
		$searchJenisJabatan = $_POST['searchJenisJabatan'];
		$searchJenisUsulanPensiun = $_POST['searchJenisUsulanPensiun'];
	    $searchStatusUsulan = $_POST['searchStatusUsulan'];
	    

	    $search_arr = array();
	    // $searchQuery = "";

	    //search
	    if($searchName != ''){
        $where .= ' AND (nip LIKE "%'.$searchName.'%" OR 
         nama LIKE "%'.$searchName.'%") ';
		}

		if($searchSatuanKerja != ''){
		$where .= ' AND instansi="'.$searchSatuanKerja.'" ';
		}

		if($searchJenisJabatan != ''){
		$where .= ' AND jenis_jabatan="'.$searchJenisJabatan.'" ';
		}

		if($searchJenisUsulanPensiun != ''){
		$where .= ' AND jenis_usulan_pensiun="'.$searchJenisUsulanPensiun.'" ';
		}

		if($searchStatusUsulan != ''){
		$where .= ' AND status_usulan="'.$searchStatusUsulan.'" ';
		}


		$waktu_update = $this->get_active_data($id_instansi);
		if($waktu_update != NULL)
		{
			$where .= ' AND ';
			$wu_arr = array();
			$urut = 1;
			foreach($waktu_update AS $wu)
			{
				$wu_arr[$urut] = 'waktu_update="'.$wu->waktu_upload.'"';
				$urut++;
			}
			$where .= implode(" OR ",$wu_arr);
		}	
		
		// Order		
		$order_data = $this->request->getPost('order');
		$order = '';
		if (strpos($_POST['columns'][$order_data[0]['column']]['data'], 'ignore_search') === false) {
			$order_by = $columns[$order_data[0]['column']]['data'] . ' ' . strtoupper($order_data[0]['dir']);
			$order = ' ORDER BY ' . $order_by;
		}
		$waktu_update = $this->get_active_data($id_instansi);
		// Query Total Filtered
		$sql = 'SELECT COUNT(*) AS jml_data FROM tbl_pensiun ' . $where. ' AND SHA1(id_instansi) = "'.$id_instansi.'"';
		$total_filtered = $this->db->query($sql)->getRowArray()['jml_data'];
		
		// Query Data
		$start = $this->request->getPost('start') ?: 0;
		$length = $this->request->getPost('length') ?: 10;
		if($length=="-1")
		{
			$sql = 'SELECT * FROM tbl_pensiun ' . $where . ' AND SHA1(id_instansi) = "' . $id_instansi . '" ' . $order;
		}
		else
		{
			$sql = 'SELECT * FROM tbl_pensiun ' . $where . ' AND SHA1(id_instansi) = "' . $id_instansi . '" ' . $order . ' LIMIT ' . $start . ', ' . $length;
		}
		$data = $this->db->query($sql)->getResultArray();
				
		return ['data' => $data, 'total_filtered' => $total_filtered];
	}
}
?>