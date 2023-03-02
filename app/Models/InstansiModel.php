<?php
namespace App\Models;

class InstansiModel extends \App\Models\BaseModel
{
	public function __construct() {
		parent::__construct();
	}
	
	public function countAllData($where) {
		$sql = 'SELECT COUNT(*) AS jml FROM tbl_instansi ti LEFT JOIN tbl_instansi_user tiu USING(id_instansi) LEFT JOIN user u USING(id_user) '. $where;
		$result = $this->db->query($sql)->getRow();
		return $result->jml;
	}
	 
	public function getListData($where) {

		$columns = $this->request->getPost('columns');
	    $searchName = @$this->request->getPost('search')['value'];

	    $search_arr = array();
	    $searchQuery = "";

	    //search
	    if($searchName != ''){
        $where .= ' AND (nip LIKE "%'.$searchName.'%" OR 
         nama LIKE "%'.$searchName.'%" OR 
         jabatan LIKE "%'.$searchName.'%" ) ';
		}

		
		if(count($search_arr) > 0){
		$where .= implode(" AND ",$search_arr);
		}

		
		
		// Order		
		$order_data = $this->request->getPost('order');
		$order = '';
		if (strpos($_POST['columns'][$order_data[0]['column']]['data'], 'ignore_search') === false) {
			$order_by = $columns[$order_data[0]['column']]['data'] . ' ' . strtoupper($order_data[0]['dir']);
			$order = ' ORDER BY ' . $order_by;
		}

		// Query Total Filtered
		$sql = 'SELECT COUNT(*) AS jml_data FROM tbl_instansi ti LEFT JOIN tbl_instansi_user tiu USING(id_instansi) LEFT JOIN user u USING(id_user) ' . $where;
		$total_filtered = $this->db->query($sql)->getRowArray()['jml_data'];
		
		// Query Data
		$start = $this->request->getPost('start') ?: 0;
		$length = $this->request->getPost('length') ?: 10;
		if($length=="-1")
		{
			$sql = 'SELECT * FROM tbl_instansi ti LEFT JOIN tbl_instansi_user tiu USING(id_instansi) LEFT JOIN user u USING(id_user) ' . $where . ' ' . $order;
		}
		else
		{
			$sql = 'SELECT * FROM tbl_instansi ti LEFT JOIN tbl_instansi_user tiu USING(id_instansi) LEFT JOIN user u USING(id_user) ' . $where . ' ' . $order . ' LIMIT ' . $start . ', ' . $length;
		}
		$data = $this->db->query($sql)->getResultArray();
				
		return ['data' => $data, 'total_filtered' => $total_filtered];
	}

	public function getInstansi($id) {
		$sql = 'SELECT * FROM tbl_instansi WHERE SHA1(id_instansi) = ?';
		$result = $this->db->query($sql, trim($id))->getResultArray();
		return $result;
	}

	public function getUserforInstansi() {
		$sql = 'SELECT * FROM user u LEFT JOIN user_role ur USING (id_user) LEFT JOIN role r USING (id_role) WHERE r.nama_role="Operator Instansi" AND id_user NOT IN (SELECT id_user FROM tbl_instansi_user)';
		$result = $this->db->query($sql)->getResultArray();
		return $result;
	}

	public function getUserInstansi($id) {
		$sql = 'SELECT id_user FROM tbl_instansi_user WHERE SHA1(id_instansi) = ?';
		$result = $this->db->query($sql, trim($id))->getResultArray();
		return $result;
	}

	public function deleteInstansi() 
	{
		$id_instansi = $this->request->getPost('id');
		$sql = 'SELECT * FROM tbl_instansi WHERE id_instansi = ?';
		$instansi = $this->db->query($sql, $id_instansi)->getRowArray();
		if (!$instansi) {
			return false;
		}
			
		$this->db->transStart();
		$this->db->table('tbl_instansi')->delete(['id_instansi' => $id_instansi]);
		$this->db->table('tbl_instansi_user')->delete(['id_instansi' => $id_instansi]);
		$delete = $this->db->affectedRows();
		$this->db->transComplete();
		$trans = $this->db->transStatus();
		
		if ($trans) {
			if (!empty($instansi['gambar'])) {
				delete_file(ROOTPATH . 'public/images/logoinstansi/' . $instansi['gambar']);
			}
		}
		
		return true;
	}

	public function saveData() 
	{
		$this->db->transStart();
		$data_db['nama_instansi'] = $_POST['nama_instansi'];
		$data_db['latitude'] = $_POST['latitude'];
		$data_db['longitude'] = $_POST['longitude'];

		
		
		// EDIT
		if (!empty($_POST['id_instansi'])) 
		{		
			$query  = $this->db->table('tbl_instansi')->update($data_db, 'SHA1(id_instansi) = "' . $_POST['id_instansi'].'"');
			
			$id_instansi = $_POST['id_instansi'];

		} else {
			$query = $this->db->table('tbl_instansi')->insert($data_db);
			$id_instansi = $newid = $this->db->insertID();
		}

		//gambar
		
		$file = $this->request->getFile('gambar');
		$path = ROOTPATH . 'public/images/logoinstansi/';
		
		$sql = 'SELECT gambar FROM tbl_instansi WHERE SHA1(id_instansi) = ?';
		$img_db = $this->db->query($sql, 'c1dfd96eea8cc2b62785275bca38ac261256e278')->getRowArray();
		$new_name = $img_db['gambar'];
		
		if (!empty($_POST['gambar_delete_img'])) 
		{
			$del = delete_file($path . $img_db['gambar']);
			$new_name = '';
			if (!$del) {
				$result['message'] = 'Gagal menghapus gambar lama';
				$error = true;
			}
		}
				
		if ($file && $file->getName()) 
		{
			//old file
			if ($img_db['gambar']) {
				if (file_exists($path . $img_db['gambar'])) {
					$unlink = delete_file($path . $img_db['gambar']);
					if (!$unlink) {
						$result['msg']['status'] = 'error';
						$result['msg']['content'] = 'Gagal menghapus gambar lama';
					}
				}
			}
						
			helper('upload_file');
			$new_name =  get_filename($file->getName(), $path);
			$file->move($path, $new_name);
				
			if (!$file->hasMoved()) {
				$result['message'] = 'Error saat memperoses gambar';
				return $result;
			}
		}
		
		// Update gambar
		$data_db = [];
		$data_db['gambar'] = $new_name;
		$save = $this->db->table('tbl_instansi')->update($data_db, 'SHA1(id_instansi) = "'.$id_instansi.'"');

		foreach ($_POST['id_user'] as $val) {
			$data_db_instansi_user[] = ['id_instansi' => $id_instansi, 'id_user' => $val];
		}
		
		$query = $this->db->table('tbl_instansi_user')->insertBatch($data_db_instansi_user);
		

		
		$query = $this->db->transComplete();
		$result = $this->db->transStatus();
		
		if ($result)
			return $id_instansi;
		
		return false;
	}
}