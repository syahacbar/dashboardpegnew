<?php
helper(['html','format']); 
?>
<div class="card">
  <div class="card-header">
    <div class="row">
      <div class="col-md-10">
        <h5 class="card-title"><?=$current_module['judul_module']?></h5>
      </div>
      <div class="col-md-2 float-right" id="toolbar-export">
      </div>
    </div>
</div>

  <div class="card-body">
    <div class="row">
      <div class="col-sm-3">
        <label for="dd_satuankerja">Satuan Kerja</label>
          <select id="dd_satuankerja" name="dd_satuankerja" class="form-select">
            <option value="">-- SEMUA --</option>
            <?php foreach($satuan_kerja AS $sk) : ?>
              <option value="<?php echo $sk->instansi;?>"><?php echo $sk->instansi;?></option>
            <?php endforeach; ?>
          </select>
      </div>
      <div class="col-sm-3">
        <label for="dd_jenisjabatan">Jenis Jabatan</label>
          <select id="dd_jenisjabatan" name="dd_jenisjabatan" class="form-select">
            <option value="">-- SEMUA --</option>
            <?php foreach($jenis_jabatan AS $jj) : ?>
              <option value="<?php echo $jj->jenis_jabatan;?>"><?php echo $jj->jenis_jabatan;?></option>
            <?php endforeach; ?>
          </select>
      </div>
      <div class="col-sm-3">
        <label for="dd_jenisusulanpensiun">Jenis Usulan Pensiun</label>
          <select id="dd_jenisusulanpensiun" name="dd_jenisusulanpensiun" class="form-select">
            <option value="">-- SEMUA --</option>
            <?php foreach($jenis_usulan_pensiun AS $ju) : ?>
              <option value="<?php echo $ju->jenis_usulan_pensiun;?>"><?php echo $ju->jenis_usulan_pensiun;?></option>
            <?php endforeach; ?>
          </select>
      </div>
      <div class="col-sm-3">
        <label for="dd_statususulan">Status Usulan</label>
          <select id="dd_statususulan" name="dd_statususulan" class="form-select">
            <option value="">-- SEMUA --</option>
            <?php foreach($status_usulan AS $su) : ?>
              <option value="<?php echo $su->status_usulan;?>"><?php echo $su->status_usulan;?></option>
            <?php endforeach; ?>
          </select>
      </div>
      
    </div>
    
    <hr>
    <div class="row">
        <?php
        if (!empty($msg)) {
          show_alert($msg);
        }

        $column = [
          'ignore_search_urut' => 'NO',
          'nama' => 'NAMA',
          'nip' => 'NIP',
          'instansi' => 'SATUAN KERJA',
          'jabatan' => 'JABATAN',
          'jenis_jabatan' => 'JENIS JABATAN',
          'jenis_usulan_pensiun' => 'JENIS USULAN PENSIUN',
          'tmt_pensiun' => 'TMT PENSIUN',
          'tgl_terima_usulan' => 'TGL. TERIMA USULAN',
          'tgl_penetapan' => 'TGL. PENETAPAN',
          'status_usulan' => 'STATUS USULAN',
          'keterangan' => 'KETERANGAN'
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

        <table id="tbl-pensiun" class="table display table-striped table-bordered table-hover tbl-pensiun" style="width:100%">
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
  </div>
</div>
