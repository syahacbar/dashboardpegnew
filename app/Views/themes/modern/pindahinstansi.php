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
        <label for="dd_instansiasal">Instansi Asal</label>
          <select id="dd_instansiasal" name="dd_instansiasal" class="form-select">
            <option value="">-- SEMUA --</option>
            <?php foreach($instansiasal AS $a) : ?>
              <option value="<?php echo $a->instansi_asal;?>"><?php echo $a->instansi_asal;?></option>
            <?php endforeach; ?>
          </select>
      </div>
      <div class="col-sm-3">
        <label for="dd_instansipenerima">Instansi Penerima</label>
          <select id="dd_instansipenerima" name="dd_instansipenerima" class="form-select">
            <option value="">-- SEMUA --</option>
            <?php foreach($instansipenerima AS $p) : ?>
              <option value="<?php echo $p->instansi_penerima;?>"><?php echo $p->instansi_penerima;?></option>
            <?php endforeach; ?>
          </select>
      </div>
      <div class="col-sm-3">
        <label for="dd_status">Status</label>
          <select id="dd_status" name="dd_status" class="form-select">
            <option value="">-- SEMUA --</option>
            <?php foreach($status AS $s) : ?>
              <option value="<?php echo $s->status;?>"><?php echo $s->status;?></option>
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
          'nomor_surat' => 'NO. SURAT',
          'tgl_surat' => 'TGL SURAT',
          'nama' => 'NAMA',
          'nip' => 'NIP',
          'instansi_asal' => 'INSTANSI ASAL',
          'instansi_penerima' => 'INSTANSI PENERIMA',
          'status' => 'STATUS',
          'tgl_sk_pertek' => 'TGL SK/PERTEK',
          'no_sk_pertek' => 'NO. SK/PERTEK',
          'ket_masalah' => 'KET. MASALAH'
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

        <table id="tbl-pindahinstansi" class="table display table-striped table-bordered table-hover tbl-pindahinstansi" style="width:100%">
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
