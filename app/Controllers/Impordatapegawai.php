<?php

namespace App\Controllers;

use App\Models\ImpordataModel;
use Box\Spout\Reader\Common\Creator\ReaderEntityFactory;

class Impordatapegawai extends BaseController
{
    protected $model;

    public function __construct()
    {
        parent::__construct();
        $this->model = new ImpordataModel;
        $this->data['title'] = 'Upload Excel';
        // $this->addJs($this->config->baseURL . 'public/themes/modern/js/uploadexcel.js');
    }

    public function index()
    {
        if (isset($_POST['submit'])) {
            $form_errors = $this->validateForm();
            if ($form_errors) {
                $data['msg']['status'] = 'error';
                $data['msg']['content'] = $form_errors;
            } else {
                $this->data['message'] = $this->model->impordatapegawai();
               
            } 
        }

        $this->data['dropdowninstansi'] = $this->model->get_all_instansi();
        $this->data['get_history_import'] = $this->model->get_history_import('tbl_pegawai');

        $this->view('impordatapegawai.php', $this->data);
    }



    function validateForm()
    {

        $form_errors = [];

        if ($_FILES['file_excel']['name']) {
            $file_type = $_FILES['file_excel']['type'];
            $allowed = ['application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'];

            if (!in_array($file_type, $allowed)) {
                $form_errors['file_excel'] = 'Tipe file harus ' . join(', ', $allowed);
            }
        } else {
            $form_errors['file_excel'] = 'File excel belum dipilih';
        }

        return $form_errors;
    }
}
