<?php

namespace App\Models;
// use App\Spout;
use Box\Spout\Reader\Common\Creator\ReaderEntityFactory;
 

class ImpordataModel extends \App\Models\BaseModel
{
    public function __construct()
    {
        parent::__construct();
        helper(['upload_file', 'format']);
    }
 
    public function impordatapegawai()
    {
        $path = ROOTPATH . 'public/files/uploads/impordata/';
        
        $this->db->transStart();
        $file = $this->request->getFile('file_excel');


        if (! $file->isValid())
        {
            throw new RuntimeException($file->getErrorString().'('.$file->getError().')');
        }
                
        require_once 'app/ThirdParty/Spout/src/Spout/Autoloader/autoload.php';
        
        $filename = upload_file($path, $_FILES['file_excel']);
        $reader = ReaderEntityFactory::createReaderFromFile($path . $filename);
        $reader->open($path . $filename);

        $builder = $this->db->table('tbl_pegawai');
        $waktu_update = date("Y-m-d H:i:s");
        $total_row = 0;

        foreach ($reader->getSheetIterator() as $sheet) 
        {
            foreach ($sheet->getRowIterator() as $num_row => $row) 
            {
                $cells = $row->getCells();        
                if ($num_row > 7) {
                      $data_db['nip'] = $cells[1]->getValue();
                      $data_db['nip_lama'] = $cells[2]->getValue();
                      $data_db['nama'] = strtoupper($cells[3]->getValue());
                      $data_db['gelar_depan'] = strtoupper($cells[4]->getValue());
                      $data_db['gelar_belakang'] = strtoupper($cells[5]->getValue());
                      // $data_db['jabatan'] = strtoupper($cells[]->getValue());
                      // $data_db['jenis_jabatan'] = strtoupper($cells[]->getValue());
                      $data_db['tempat_lahir'] = strtoupper($cells[6]->getValue());
                      $data_db['tgl_lahir'] = strtoupper($cells[7]->getValue());
                      $data_db['gol_awal'] = strtoupper($cells[8]->getValue());
                      $data_db['tmt_cpns'] = strtoupper($cells[9]->getValue());
                      $data_db['tmt_pns'] = strtoupper($cells[10]->getValue());
                      $data_db['jk'] = strtoupper($cells[11]->getValue());
                      $data_db['gol_akhir'] = strtoupper($cells[12]->getValue());
                      $data_db['tmt_gol_akhir'] = strtoupper($cells[13]->getValue());
                      $data_db['masakerja_tahun'] = strtoupper($cells[14]->getValue());
                      $data_db['masakerja_bulan'] = strtoupper($cells[15]->getValue());
                      $data_db['str_eselon'] = strtoupper($cells[16]->getValue());
                      $data_db['str_tmt'] = strtoupper($cells[17]->getValue());
                      $data_db['str_namajabatan'] = strtoupper($cells[18]->getValue());
                      $data_db['fung_tmt'] = strtoupper($cells[19]->getValue());
                      $data_db['fung_namajabatan_ft'] = strtoupper($cells[20]->getValue());
                      $data_db['fung_namajabatan_fu'] = strtoupper($cells[21]->getValue());
                      $data_db['unit_kerja'] = strtoupper($cells[22]->getValue());
                      $data_db['unit_kerja_induk'] = strtoupper($cells[23]->getValue());
                      $data_db['nama_pendidikan_terakhir'] = strtoupper($cells[24]->getValue());
                      $data_db['tahunlulus_pendidikan_terakhir'] = strtoupper($cells[25]->getValue());
                      $data_db['kedudukan_hukum'] = strtoupper($cells[26]->getValue());
                      $data_db['jenis_pegawai'] = strtoupper($cells[27]->getValue());
                      $data_db['instansi_induk'] = strtoupper($cells[28]->getValue());
                      $data_db['instansi_kerja'] = strtoupper($cells[29]->getValue());
                      $data_db['id_pns'] = $cells[30]->getValue();

                    $data_db['id_instansi'] = $_POST['dropdowninstansi'];
                    $data_db['waktu_update'] = $waktu_update;
                    $builder->insert($data_db);
                    $id_pegawai = $this->db->insertID();
                    $total_row ++;
                }
                
            }
        }
        $reader->close();
        // unlink ($path . $filename);


        $userdata = $_SESSION['user'];
        $user_id = $userdata['id_user'];

        $data_history_import['nama_file'] = $filename;
        $data_history_import['id_instansi'] = $_POST['dropdowninstansi'];
        $data_history_import['waktu_upload'] = $waktu_update;
        $data_history_import['user_id'] = $user_id;
        $data_history_import['tabel'] = 'tbl_pegawai';
        $data_history_import['aktif'] = '0';

        $this->db->table('tbl_history_import')->insert($data_history_import);
        $id_history_import = $this->db->insertID();

        $this->db->transComplete();

        $result = ['status' => '', 'content'];
        if ($id_pegawai) {
            $result['status'] = 'ok';
            $result['content'] = 'Data berhasil di masukkan ke dalam tabel <strong> Data Pegawai </strong> sebanyak ' . format_ribuan($total_row) . ' baris';
        }
        
        return $result;

    }

    public function imporkenaikanpangkat()
    {
        $path = ROOTPATH . 'public/files/uploads/impordata/';
        
        
        $file = $this->request->getFile('file_excel');


        if (! $file->isValid())
        {
            throw new RuntimeException($file->getErrorString().'('.$file->getError().')');
        }

        
                
        require_once 'app/ThirdParty/Spout/src/Spout/Autoloader/autoload.php';
        
        $filename = upload_file($path, $_FILES['file_excel']);
        $reader = ReaderEntityFactory::createReaderFromFile($path . $filename);
        $reader->open($path . $filename);

        $builder = $this->db->table('tbl_kenaikanpangkat');
        $waktu_update = date("Y-m-d H:i:s");
        $total_row = 0;

        foreach ($reader->getSheetIterator() as $sheet) 
        {
            foreach ($sheet->getRowIterator() as $num_row => $row) 
            {
                $cells = $row->getCells();        
                if ($num_row > 1) {
                    $data_db['nip'] = $cells[1]->getValue();
                    $data_db['nama'] = strtoupper($cells[2]->getValue());
                    $data_db['pangkat'] = strtoupper($cells[3]->getValue());
                    $data_db['satuan_kerja'] = strtoupper($cells[4]->getValue());
                    $data_db['jabatan'] = strtoupper($cells[5]->getValue());
                    $data_db['jenis_jabatan'] = strtoupper($cells[6]->getValue());
                    $data_db['prosedur'] = strtoupper($cells[7]->getValue());
                    $data_db['status'] = strtoupper($cells[8]->getValue());
                    $data_db['alasan'] = strtoupper($cells[9]->getValue());
                    $data_db['waktu_update'] = $waktu_update;
                    $data_db['id_instansi'] = $_POST['dropdowninstansi'];
                    $builder->insert($data_db);
                    $id_pegawai = $this->db->insertID();   
                    $total_row ++;
                }                
            }
        }

        $reader->close();
        // unlink ($path . $filename);

        //insert ke history
        $userdata = $_SESSION['user'];
        $user_id = $userdata['id_user'];

        $data_history_import['nama_file'] = $filename;
        $data_history_import['id_instansi'] = $_POST['dropdowninstansi'];
        $data_history_import['waktu_upload'] = $waktu_update;
        $data_history_import['user_id'] = $user_id;
        $data_history_import['tabel'] = 'tbl_kenaikanpangkat';
        $data_history_import['aktif'] = '0';

        $this->db->table('tbl_history_import')->insert($data_history_import);
        $id_history_import = $this->db->insertID();

        $result = ['status' => '', 'content'];
        if ($id_pegawai) {
            $result['status'] = 'ok';
            $result['content'] = 'Data berhasil di masukkan ke dalam tabel <strong> Kenaikan Pangkat </strong> sebanyak ' . format_ribuan($total_row-1) . ' baris';
        }
        
        return $result;

    }

    public function get_all_instansi() {
        $sql = 'SELECT * FROM tbl_instansi ti';
        $result = $this->db->query($sql)->getResult();
        return $result;
    }
    
    public function get_history_import($tabel) {
        $sql = 'SELECT * FROM tbl_history_import hi JOIN user u ON u.id_user=hi.user_id LEFT JOIN tbl_instansi USING(id_instansi) WHERE hi.tabel="'.$tabel.'" ORDER BY waktu_upload DESC';
        $result = $this->db->query($sql)->getResult();
        return $result;
    }

    public function update_status_histoty()
    {
        $id_history_import = $_POST['id']; 
        $data_update['aktif'] = $_POST['mode'];

        $builder = $this->db->table('tbl_history_import');
       
        $builder->update($data_update, ['id' => $id_history_import]);
        
        return TRUE;
    }

    public function imporpindahinstansi()
    {
        $path = ROOTPATH . 'public/files/uploads/impordata/';
        
        
        $file = $this->request->getFile('file_excel');


        if (! $file->isValid())
        {
            throw new RuntimeException($file->getErrorString().'('.$file->getError().')');
        }
   
        require_once 'app/ThirdParty/Spout/src/Spout/Autoloader/autoload.php';
        
        $filename = upload_file($path, $_FILES['file_excel']);
        $reader = ReaderEntityFactory::createReaderFromFile($path . $filename);
        $reader->open($path . $filename);


        $builder = $this->db->table('tbl_pindah_instansi');
        $waktu_update = date("Y-m-d H:i:s");
        $total_row = 0;

        foreach ($reader->getSheetIterator() as $sheet) 
        {
            foreach ($sheet->getRowIterator() as $num_row => $row) 
            {
                $cells = $row->getCells();        
                if ($num_row > 1) {
                    $data_db['nomor_surat'] = $cells[1]->getValue();
                    $data_db['tgl_surat'] = date_format($cells[2]->getValue(),'Y-m-d');
                    $data_db['nama'] = strtoupper($cells[3]->getValue());
                    $data_db['nip'] = $cells[4]->getValue();
                    $data_db['instansi_asal'] = strtoupper($cells[5]->getValue());
                    $data_db['instansi_penerima'] = strtoupper($cells[6]->getValue());
                    $data_db['status'] = strtoupper($cells[7]->getValue());
                    $data_db['no_sk_pertek'] = $cells[8]->getValue();
                    $data_db['tgl_sk_pertek'] = date_format($cells[9]->getValue(),'Y-m-d');
                    $data_db['ket_masalah'] = strtoupper($cells[10]->getValue());
                    $data_db['waktu_update'] = $waktu_update;
                    $data_db['id_instansi'] = $_POST['dropdowninstansi'];
                    $builder->insert($data_db);
                    $id_pegawai = $this->db->insertID();   
                    $total_row ++;
                }                
            }
        }

        $reader->close();
        // unlink ($path . $filename);

        //insert ke history
        $userdata = $_SESSION['user'];
        $user_id = $userdata['id_user'];

        $data_history_import['nama_file'] = $filename;
        $data_history_import['id_instansi'] = $_POST['dropdowninstansi'];
        $data_history_import['waktu_upload'] = $waktu_update;
        $data_history_import['user_id'] = $user_id;
        $data_history_import['tabel'] = 'tbl_pindah_instansi';
        $data_history_import['aktif'] = '0';

        $this->db->table('tbl_history_import')->insert($data_history_import);
        $id_history_import = $this->db->insertID();

        $result = ['status' => '', 'content'];
        if ($id_pegawai) {
            $result['status'] = 'ok';
            $result['content'] = 'Data berhasil di masukkan ke dalam tabel <strong> Pindah Instansi </strong> sebanyak ' . format_ribuan($total_row-1) . ' baris';
        }
        
        return $result;

    }

     public function imporpensiun()
    {
        $path = ROOTPATH . 'public/files/uploads/impordata/';
        
        
        $file = $this->request->getFile('file_excel');


        if (! $file->isValid())
        {
            throw new RuntimeException($file->getErrorString().'('.$file->getError().')');
        }

        
                
        require_once 'app/ThirdParty/Spout/src/Spout/Autoloader/autoload.php';
        
        $filename = upload_file($path, $_FILES['file_excel']);
        $reader = ReaderEntityFactory::createReaderFromFile($path . $filename);
        $reader->open($path . $filename);

        $builder = $this->db->table('tbl_pensiun');
        $waktu_update = date("Y-m-d H:i:s");
        $total_row = 0;

        foreach ($reader->getSheetIterator() as $sheet) 
        {
            foreach ($sheet->getRowIterator() as $num_row => $row) 
            {
                $cells = $row->getCells();        
                if ($num_row > 1) {
                    $data_db['nama'] = strtoupper($cells[1]->getValue());
                    $data_db['nip'] = $cells[2]->getValue();
                    $data_db['instansi'] = strtoupper($cells[3]->getValue());
                    $data_db['jabatan'] = strtoupper($cells[4]->getValue());
                    $data_db['jenis_jabatan'] = strtoupper($cells[5]->getValue());
                    $data_db['jenis_usulan_pensiun'] = strtoupper($cells[6]->getValue());
                    $data_db['tmt_pensiun'] = $cells[7]->getValue();
                    $data_db['tgl_terima_usulan'] = $cells[8]->getValue();
                    $data_db['tgl_penetapan'] = $cells[9]->getValue();
                    $data_db['status_usulan'] = $cells[10]->getValue();
                    $data_db['keterangan'] = strtoupper($cells[11]->getValue());
                    $data_db['waktu_update'] = $waktu_update;
                    $data_db['id_instansi'] = $_POST['dropdowninstansi'];
                    $builder->insert($data_db);
                    $id_pegawai = $this->db->insertID();   
                    $total_row ++;
                }                
            }
        }

        $reader->close();
        // unlink ($path . $filename);

        //insert ke history
        $userdata = $_SESSION['user'];
        $user_id = $userdata['id_user'];

        $data_history_import['nama_file'] = $filename;
        $data_history_import['id_instansi'] = $_POST['dropdowninstansi'];
        $data_history_import['waktu_upload'] = $waktu_update;
        $data_history_import['user_id'] = $user_id;
        $data_history_import['tabel'] = 'tbl_pensiun';
        $data_history_import['aktif'] = '0';

        $this->db->table('tbl_history_import')->insert($data_history_import);
        $id_history_import = $this->db->insertID();

        $result = ['status' => '', 'content'];
        if ($id_pegawai) {
            $result['status'] = 'ok';
            $result['content'] = 'Data berhasil di masukkan ke dalam tabel <strong> Pensiun </strong> sebanyak ' . format_ribuan($total_row-1) . ' baris';
        }
        
        return $result;

    }


}
