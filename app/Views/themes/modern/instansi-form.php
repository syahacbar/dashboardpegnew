<!-- Leaflet-->
	<link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css" />
	<script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js"></script>

	<link rel="stylesheet" href="<?=$config->baseURL?>public/vendors/leaflet-locatecontrol/dist/L.Control.Locate.min.css" />
	<script src="<?=$config->baseURL?>public/vendors/leaflet-locatecontrol/src/L.Control.Locate.js"></script>

<div class="card">
	<div class="card-header">
		<h5 class="card-title"><?=$title?></h5>
	</div>
	
	<div class="card-body">
		<?php 
		helper ('html');
		if (!empty($msg)) {
			show_message($msg['content'], $msg['status']);
		}
		
		echo btn_label(['attr' => ['class' => 'btn btn-success btn-xs'],
			'url' => $config->baseURL . $current_module['nama_module'] . '/add',
			'icon' => 'fa fa-plus',
			'label' => 'Tambah Data'
		]);
		
		echo btn_label(['attr' => ['class' => 'btn btn-light btn-xs'],
			'url' => $config->baseURL . $current_module['nama_module'],
			'icon' => 'fa fa-arrow-circle-left',
			'label' => $current_module['judul_module']
		]); 
		?>
		<hr/>
		<div class="row">
			<div class="col-6">
				<form method="post" action="" id="form-container" enctype="multipart/form-data">
					<div class="tab-content" id="form-container">
						<div class="row mb-3">
							<label class="col-sm-3 col-form-label">Nama Instansi</label>
							<div class="col-sm-6">
								<input class="form-control" type="text" name="nama_instansi" value="<?=set_value('nama_instansi', @$nama_instansi)?>" placeholder="Nama Instansi" required="required"/>
							</div>
						</div>
						<div class="row mb-3">
							<label class="col-sm-3 col-form-label">Latitude</label>
							<div class="col-sm-6">
								<input class="form-control" type="text" id="latitude" name="latitude" value="<?=set_value('latitude', @$latitude)?>" placeholder="Latitude" required="required" readonly/>
							</div>
						</div>
						<div class="row mb-3">
							<label class="col-sm-3 col-form-label">Longitude</label>
							<div class="col-sm-6">
								<input class="form-control" type="text" id="longitude" name="longitude" value="<?=set_value('longitude', @$longitude)?>" placeholder="Longitude" required="required" readonly/>
							</div>
						</div>
						<div class="row mb-3">
							<label class="col-sm-3 col-form-label">Gambar</label>
							<div class="col-sm-6">
								<?php 
								$gambar = @$_FILES['file']['name'] ?: @$gambar;
								if (!empty($gambar) ) {
									echo '<div class="img-choose" style="margin:inherit;margin-bottom:10px">
											<div class="img-choose-container">
												<img src="'.$config->baseURL. 'public/images/logoinstansi/' . $gambar . '?r=' . time() . '"/>
												<a href="javascript:void(0)" class="remove-img"><i class="fas fa-times"></i></a>
											</div>
										</div>
										';
								}
								?>
								<input type="hidden" class="gambar-delete-img" name="gambar_delete_img" value="0">
								<input type="file" class="file form-control" name="gambar">
									<?php if (!empty($form_errors['gambar'])) echo '<small style="display:block" class="alert alert-danger mb-0">' . $form_errors['gambar'] . '</small>'?>
								<small class="small" style="display:block">Tipe file: .JPG, .JPEG, .PNG</small>
								<div class="upload-img-thumb mb-2"><span class="img-prop"></span></div>
							</div>
						</div>
						<div class="row mb-3">
							<label class="col-sm-3 col-form-label">User ID</label>
							<div class="col-sm-6">
								<?php
					
								if (!$userx) {
									echo '<div class="alert alert-danger">Data User ID masih kosong atau telah digunakan Instansi Lainnya, silakan Buat User Operator Instansi terlebih dahulu</div>';
								} else {
									echo options(['class' => 'form-control id_user select2'
													, 'name' => 'id_user[]'
													, 'multiple' => 'multiple'
													, 'required' => 'required'
													]
												, $userx
												, set_value('id_user', @$id_user)
											);
								} ?>
							</div>
						</div>
						<div class="row mb-3">
							<div class="col-sm-5">
								<button type="submit" name="submit" id="btn-submit" value="submit" class="btn btn-primary">Submit</button>
								<input type="hidden" name="id_instansi" value="<?=set_value('id_instansi', @$id_instansi)?>"/>
							</div>
						</div>
					</div>
				</form>
			</div>
			<div class="col-6">
				<div id="mapid" style="height: 700px;"></div>
			</div>
		</div>
	</div>
</div>

<script>
	var curLocation = [0, 0];
	if (curLocation[0] == 0 && curLocation[1] == 0) {
		curLocation = [-1.725, 132.891];
	}

	var mymap = L.map('mapid').setView([-1.725, 132.891], 8);
	L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
		attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, ' +
			'<a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
			'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
		id: 'mapbox/streets-v11'
	}).addTo(mymap);

	mymap.attributionControl.setPrefix(false);
	var marker = new L.marker(curLocation, {
		draggable: 'true'
	});

	marker.on('dragend', function(event) {
		var position = marker.getLatLng();
		marker.setLatLng(position, {
			draggable: 'true'
		}).bindPopup(position).update();
		$("#latitude").val(position.lat);
		$("#longitude").val(position.lng).keyup();
	});

	$("#latitude, #longitude").change(function() {
		var position = [parseInt($("#latitude").val()), parseInt($("#longitude").val())];
		marker.setLatLng(position, {
			draggable: 'true'
		}).bindPopup(position).update();
		mymap.panTo(position);
	});
	mymap.addLayer(marker);
</script>