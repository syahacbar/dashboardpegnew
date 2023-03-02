<!DOCTYPE HTML>
<html lang="en">
<title>Home | Dashboard Kepegawaian</title> 
<meta name="descrition" content="Home - Dashboard Kepegawaian"/>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>

<link rel="shortcut icon" href="<?=$config->baseURL?>public/images/favicon.png" />
<link rel="stylesheet" type="text/css" href="<?=$config->baseURL?>public/vendors/font-awesome/css/all.css?r=<?=time()?>"/>
<link rel="stylesheet" type="text/css" href="<?=$config->baseURL?>public/vendors/bootstrap/css/bootstrap.min.css?r=<?=time()?>"/>
<link rel="stylesheet" type="text/css" href="<?=$config->baseURL?>public/themes/modern/builtin/css/bootstrap-custom.css?r=<?=time()?>"/>
<link rel="stylesheet" type="text/css" href="<?=$config->baseURL?>public/themes/modern/css/tanpalogin.css?r=<?=time()?>"/>
<link rel="stylesheet" type="text/css" href="<?=$config->baseURL?>public/vendors/overlayscrollbars/OverlayScrollbars.min.css?r=<?=time()?>"/>
<link rel="stylesheet" id="font-switch" type="text/css" href="<?=$config->baseURL . 'public/themes/modern/builtin/css/fonts/'.$app_layout['font_family'].'.css?r='.time()?>"/>
<link rel="stylesheet" id="font-size-switch" type="text/css" href="<?=$config->baseURL . 'public/themes/modern/builtin/css/fonts/font-size-'.$app_layout['font_size'].'.css?r='.time()?>"/>

<script type="text/javascript" src="<?=$config->baseURL?>public/vendors/jquery/jquery.min.js"></script>
<script type="text/javascript" src="<?=$config->baseURL?>public/themes/modern/js/site.js?r=<?=time()?>"></script>
<script type="text/javascript" src="<?=$config->baseURL?>public/vendors/bootstrap/js/bootstrap.min.js?r=<?=time()?>"></script>
<script type="text/javascript" src="<?=$config->baseURL?>public/vendors/overlayscrollbars/jquery.overlayScrollbars.min.js?r=<?=time()?>"></script>
<script type="text/javascript">
	var base_url = "<?=$config->baseURL?>";
</script>

<!-- Leaflet-->
	<link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css" />
	<script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js"></script>

	<link rel="stylesheet" href="<?=$config->baseURL?>public/vendors/leaflet-locatecontrol/dist/L.Control.Locate.min.css" />
	<script src="<?=$config->baseURL?>public/vendors/leaflet-locatecontrol/src/L.Control.Locate.js"></script>

<style type="text/css">
	header, footer {
		background: #5a43a0;
	}

	footer *,header * {
		color: #fff;
	}

	footer li a, header li a {
		color: #fff !important;
	}

	footer li a:hover, header li a:hover {
		color: orange !important;
	}
</style>
</head>
<body>
	<?php helper(['format']); ?>
	<div class="site-container">
	<header class="shadow-sm">
		<div class="menu-wrapper wrapper clearfix">
			<a href="#" id="mobile-menu-btn" class="show-mobile">
				<i class="fa fa-bars"></i>
			</a>
			<div class="nav-left">
				<a href="" class="logo-header" title="Jagowebdev">
					<img src="<?=$config->baseURL?>public/images/logohome.png" alt="Dashboard Kepegawaian"/>
				</a>
			</div>
			<nav class="nav-right nav-header">
				<ul class="main-menu">
					<li class="menu">
						<a class="depth-0" href="<?=$config->baseURL?>">
							<i class="menu-icon fas fa-home"></i>Home </a>
					</li>
					<li class="menu">
						<a class="depth-0" href="<?=$config->baseURL?>login"><i class="menu-icon fas fa-sign-in-alt"></i>Login</a>
					</li>
				</ul>
			</nav>
			<div class="clearfix"></div>
		</div>
	</header>
	<div class="page-container">
		
		<div id="map" style="width: 100%; height: 850px;"></div>

	</div>
	<footer>
		<div class="footer-menu-container">
			<div class="wrapper clearfix">
				<div class="nav-left">Copyright &copy; 2023 
				</div>
				<nav class="nav-right nav-footer">
					<ul class=footer-menu>
						<li class="menu">
							<a class="depth-0" href="<?=$config->baseURL?>">Home</a>
						</li>
						<li class="menu">
							<a class="depth-0" href="tremofuser">Term of Use</a>
						</li>
					</ul>
				</nav>
			</div>
		</div>
	</footer>
	</div><!-- site-container -->
</body>
</html>

<script>
	navigator.geolocation.getCurrentPosition(function(location) {
		var latlng = new L.LatLng(location.coords.latitude, location.coords.longitude);
		var grupinstansi = L.layerGroup();
		var peta1 = L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
			attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, ' +
				'<a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
				'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
			id: 'mapbox/streets-v11'
		});

		var peta2 = L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
			attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, ' +
				'<a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
				'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
			id: 'mapbox/satellite-v9'
		});

		var peta3 = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
			attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
		});

		var map = L.map('map', {
			center: [-1.725, 132.891],
			zoom: 8,
			layers: [peta2, grupinstansi]
		});

		var baseLayers = {
			"Grayscale": peta1,
			"Satelite": peta2,
			"Streets": peta3
		};

		var overlays = {
			"instansi": grupinstansi,
		};

		L.control.layers(baseLayers, overlays).addTo(map);

		// Coba 
		<?php foreach ($instansi as $key => $value) { ?>

			L.marker([<?= $value->latitude ?>, <?= $value->longitude ?>], {
				icon: L.icon({
					iconUrl: base_url+'public/images/logoinstansi/<?=$value->gambar?>',
					// iconUrl: '<?= base_url('gambar/' . $value->gambar)  ?>',
					iconSize: [50, 50], // size of the icon
				})
			}).addTo(grupinstansi).bindPopup("<center><img align='center' src='<?= base_url('public/images/logoinstansi/' . $value->gambar) ?>' width='80px'></center><br>" + "<div><h4> <?= $value->nama_instansi; ?></h4><p>Total Pegawai: <strong><?=format_ribuan($value->TotPegawai)?></strong></p>" +
			"<?php if($value->TotPegawai != 0) {?><p><a href='<?= base_url('home/detail/' . SHA1($value->id_instansi)) ?>' class='btn btn-sm btn-outline-primary'>Detail</a></p><?php } ?>");
		<?php } ?>
	});
</script>
