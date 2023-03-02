<?php
helper(['html','format']); 
?>
<div class="card">`
<div class="card-body">
  <div class="table-responsive">
    <a href="<?php echo current_url()?>/add" class="btn btn-success btn-xs"><i class="fa fa-plus pe-1"></i> Tambah Data</a>
    <hr/>
<?php
        if (!empty($msg)) {
          show_alert($msg);
        }

        $column = [
          'ignore_search_urut' => 'NO',
          'nama_instansi' => 'NAMA INSTANSI',
          'latitude' => 'LATITUDE',
          'longitude' => 'LONGITUDE',
          'gambar_instansi' => 'GAMBAR', 
          'username' => 'USER ID',
          'ignore_search_action' => 'Action'
        ];

        $settings['order'] = [2, 'asc'];
        $index = 0;
        $th = '';
        foreach ($column as $key => $val) {
          $th .= '<th>' . $val . '</th>';
          if (strpos($key, 'ignore_search') !== false) {
            $settings['columnDefs'][] = ["targets" => $index, "orderable" => false];
          }
          $index++;
        }

        ?>
    <table id="table-result" class="table display nowrap table-striped table-bordered" style="width:100%">
          <thead>
            <tr>
              <?=$th?>
            </tr>
          </thead>
          <tfoot>
            <tr>
              <?=$th?>
            </tr>
          </tfoot>
        </table>
        <?php
          foreach ($column as $key => $val) {
            $column_dt[] = ['data' => $key];
          }
        ?>
        <span id="dataTables-column" style="display:none"><?=json_encode($column_dt)?></span>
        <span id="dataTables-setting" style="display:none"><?=json_encode($settings)?></span>
        <span id="dataTables-url" style="display:none"><?=current_url() . '/getDataDT'?></span>
</div>
  </div>
