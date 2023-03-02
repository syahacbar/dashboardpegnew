<?php

namespace App\Models;

class PindahInstansiModel extends \App\Models\BaseModel
{
	private $fotoPath;
	
	public function __construct() {
		parent::__construct();
	}

	public function get_instansi_asal($id_instansi) {
		$sql = 'SELECT DISTINCT instansi_asal FROM tbl_pindah_instansi WHERE SHA1(id_instansi) = "'.$id_instansi.'"';
		$result = $this->db->query($sql)->getResult();
		return $result;
	}

	public function get_instansi_penerima($id_instansi) {
		$sql = 'SELECT DISTINCT instansi_penerima FROM tbl_pindah_instansi WHERE SHA1(id_instansi) = "'.$id_instansi.'"';
		$result = $this->db->query($sql)->getResult();
		return $result;
	}

	public function get_status($id_instansi) {
		$sql = 'SELECT DISTINCT status FROM tbl_pindah_instansi WHERE SHA1(id_instansi) = "'.$id_instansi.'"';
		$result = $this->db->query($sql)->getResult();
		return $result;
	}
	
	public function countAllData($where,$id_instansi) {
		$sql = 'SELECT COUNT(*) AS jml FROM tbl_pindah_instansi '. $where . ' AND SHA1(id_instansi) = "'.$id_instansi.'"';
		$result = $this->db->query($sql)->getRow();
		return $result->jml;
	}

	public function get_active_data($id_instansi)
	{
		$sql = 'SELECT * FROM tbl_history_import WHERE aktif="1" AND tabel="tbl_pindah_instansi" AND SHA1(id_instansi) = "'.$id_instansi.'"';
		$result = $this->db->query($sql)->getResult();
		return $result;
	}
	
	public function getListData($where,$id_instansi) {

		$columns = $this->request->getPost('columns');
	    $searchName = @$this->request->getPost('search')['value'];
		$searchInstansiAsal = $_POST['searchInstansiAsal'];
	    $searchInstansiPenerima = $_POST['searchInstansiPenerima'];
	    $searchStatus = $_POST['searchStatus'];
	    

	    $search_arr = array();
	    // $searchQuery = "";

	    //search
	    if($searchName != ''){
        $where .= ' AND (nip LIKE "%'.$searchName.'%" OR 
         nama LIKE "%'.$searchName.'%") ';
		}

		if($searchInstansiAsal != ''){
		$where .= ' AND instansi_asal="'.$searchInstansiAsal.'" ';
		}

		if($searchInstansiPenerima != ''){
		$where .= ' AND instansi_penerima="'.$searchInstansiPenerima.'" ';
		}

		if($searchStatus != ''){
		$where .= ' AND status="'.$searchStatus.'" ';
		}

		$waktu_update = $this->get_active_data($id_instansi);
		// if($waktu_update != NULL)
		// {
		// 	$where .= ' AND ';
		// 	$wu_arr = array();
		// 	$urut = 1;
		// 	foreach($waktu_update AS $wu)
		// 	{
		// 		$wu_arr[$urut] = 'waktu_update="'.$wu->waktu_upload.'"';
		// 		$urut++;
		// 	}
		// 	$where .= implode(" OR ",$wu_arr);
		// }

		if($waktu_update != NULL)
		{
			$where .= ' AND waktu_update IN("';
			$wu_arr = array();
			$urut = 1;
			foreach($waktu_update AS $wu)
			{
				$wu_arr[$urut] = $wu->waktu_upload;
				$urut++;
			}
			$where .= implode('","',$wu_arr);
			$where .= '")';
		}


		// if(count($search_arr) > 0){
		// $where .= implode(" AND ",$search_arr);
		// }

		// print_r($where);

		
		
		// Order		
		$order_data = $this->request->getPost('order');
		$order = '';
		if (strpos($_POST['columns'][$order_data[0]['column']]['data'], 'ignore_search') === false) {
			$order_by = $columns[$order_data[0]['column']]['data'] . ' ' . strtoupper($order_data[0]['dir']);
			$order = ' ORDER BY ' . $order_by;
		}
		$waktu_update = $this->get_active_data($id_instansi);
		// Query Total Filtered
		$sql = 'SELECT COUNT(*) AS jml_data FROM tbl_pindah_instansi ' . $where. ' AND SHA1(id_instansi) = "'.$id_instansi.'"';
		$total_filtered = $this->db->query($sql)->getRowArray()['jml_data'];
		
		// Query Data
		$start = $this->request->getPost('start') ?: 0;
		$length = $this->request->getPost('length') ?: 10;
		if($length=="-1")
		{
			$sql = 'SELECT * FROM tbl_pindah_instansi ' . $where . ' AND SHA1(id_instansi) = "' . $id_instansi . '" ' . $order;
		}
		else
		{
			$sql = 'SELECT * FROM tbl_pindah_instansi ' . $where . ' AND SHA1(id_instansi) = "' . $id_instansi . '" ' . $order . ' LIMIT ' . $start . ', ' . $length;
		}
		$data = $this->db->query($sql)->getResultArray();
				
		return ['data' => $data, 'total_filtered' => $total_filtered];
	}
}
?>