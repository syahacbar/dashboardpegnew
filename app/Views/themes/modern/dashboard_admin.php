<?php helper(['html','format']) ?>
<div class="card-body dashboard">
	<div class="row h-100">
		<div class="col-lg-2 col-sm-6 ">
			<div class="card text-bg-primary shadow h-100">
				<div class="card-body card-stats">
					<div class="description">
						<h5 class="card-title h4"><?php echo format_ribuan($count_pegawai_all->totalpegawai);?></h5>
						<p class="card-text">Pegawai</p>

					</div>
					<div class="icon bg-warning-light">
						<i class="material-icons">group</i>
					</div>
				</div>
				<div class="card-footer">
					<div class="card-footer-left">
						<div class="icon me-2">
						</div>
					</div>
					<div class="card-footer-right">
					</div>
				</div>
			</div>
		</div>
		<div class="col-lg-2 col-sm-6">
			<div class="card text-bg-success shadow h-100">
				<div class="card-body card-stats">
					<div class="description">
						<h5 class="card-title h4"><?php echo format_ribuan($count_total_usulan_kp->total_usulan_kp);?></h5>
						<p class="card-text">Usulan Kenaikan Pangkat</p>

					</div>
					<div class="icon bg-warning-light">
						<i class="material-icons">group</i>
					</div>
				</div>
				<div class="card-footer">
					<div class="card-footer-left">
						<div class="icon me-2">
						</div>
					</div>
					<div class="card-footer-right">
					</div>
				</div>
			</div>
		</div>
		<div class="col-lg-2 col-sm-6">
			<div class="card text-bg-info shadow h-100">
				<div class="card-body card-stats">
					<div class="description">
						<h5 class="card-title h4"><?php echo format_ribuan($count_total_usulan_pindahinstansi->total_usulan_pindahinstansi);?></h5>
						<p class="card-text">Usulan Pindah Instansi</p>

					</div>
					<div class="icon bg-warning-light">
						<i class="material-icons">group</i>
					</div>
				</div>
				<div class="card-footer">
					<div class="card-footer-left">
						<div class="icon me-2">
						</div>
					</div>
					<div class="card-footer-right">
					</div>
				</div>
			</div>
		</div>
		<div class="col-lg-2 col-sm-6">
			<div class="card text-bg-warning shadow h-100">
				<div class="card-body card-stats">
					<div class="description">
						<h5 class="card-title h4">0</h5>
						<p class="card-text">Usulan Pencantuman Gelar</p>

					</div>
					<div class="icon bg-warning-light">
						<i class="material-icons">group</i>
					</div>
				</div>
				<div class="card-footer">
					<div class="card-footer-left">
						<div class="icon me-2">
						</div>
					</div>
					<div class="card-footer-right">
					</div>
				</div>
			</div>
		</div>
		<div class="col-lg-2 col-sm-6">
			<div class="card text-bg-danger shadow h-100">
				<div class="card-body card-stats">
					<div class="description">
						<h5 class="card-title h4"><?php echo format_ribuan($count_pensiun_all->totalpensiun);?></h5>
						<p class="card-text">Usulan Pensiun</p>

					</div>
					<div class="icon bg-warning-light">
						<i class="material-icons">group</i>
					</div>
				</div>
				<div class="card-footer">
					<div class="card-footer-left">
						<div class="icon me-2">
						</div>
					</div>
					<div class="card-footer-right">
					</div>
				</div>
			</div>
		</div>
		<div class="col-lg-2 col-sm-6">
			<div class="card text-bg-secondary shadow h-100">
				<div class="card-body card-stats">
					<div class="description">
						<h5 class="card-title h4">0</h5>
						<p class="card-text">Usulan Pengadaan</p>

					</div>
					<div class="icon bg-warning-light">
						<i class="material-icons">group</i>
					</div>
				</div>
				<div class="card-footer">
					<div class="card-footer-left">
						<div class="icon me-2">
						</div>
					</div>
					<div class="card-footer-right">
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-12 col-md-12 col-lg-12 col-xl-6 mb-4">
			<div class="card">
				<div class="card-body">
					<figure class="highcharts-figure">
						<div id="pegawai_instansi"></div>
					</figure>

				</div>
			</div>
		</div>
		<div class="col-12 col-md-12 col-lg-12 col-xl-6 mb-4">
			<div class="card">
				<div class="card-body">
					<figure class="highcharts-figure">
						<div id="kp_by_instansi"></div>
					</figure>
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-12 col-md-12 col-lg-12 col-xl-6 mb-4">
			<div class="card">
				<div class="card-body">
					<figure class="highcharts-figure">
						<div id="pindahinstansi_by_instansi"></div>
					</figure>
				</div>
			</div>
		</div>
		<div class="col-12 col-md-12 col-lg-12 col-xl-6 mb-4">
			<div class="card">
				<div class="card-body">
					<figure class="highcharts-figure">
						<div id="pensiun_by_instansi"></div>
					</figure>
				</div>
			</div>
		</div>
	</div>

</div>

<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/highcharts-3d.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>


<script>
	
	Highcharts.chart('pegawai_instansi', {
	    chart: {
	        type: 'bar'
	    },
	    title: {
	        text: 'Jumlah Pegawai Berdasarkan Instansi',
	        align: 'left'
	    },
	    xAxis: {
	        categories: [<?php foreach($count_pegawai_by_instansi AS $pi) { echo "'".$pi->nama_instansi."',"; } ?>],
	        title: {
	            text: null
	        }
	    },
	    yAxis: {
	        min: 0,
	        labels: {
	            overflow: 'justify'
	        }
	    },
	    tooltip: {
	        valueSuffix: ' pegawai'
	    },
	    plotOptions: {
	        bar: {
	            dataLabels: {
	                enabled: true
	            }
	        }
	    },
	    credits: {
	        enabled: false
	    },
	    series: [{
	        name: 'Jumlah Pegawai',
	        data: [<?php foreach($count_pegawai_by_instansi AS $pi) { echo $pi->jumlah_pegawai.","; } ?>]
	    }]
	});

	Highcharts.chart('kp_by_instansi', {
	    chart: {
	        type: 'bar'
	    },
	    title: {
	        text: 'Jumlah Usulan Kenaikan Pangkat Berdasarkan Instansi',
	        align: 'left'
	    },
	    xAxis: {
	        categories: [<?php foreach($count_usulan_kp AS $kp) { echo "'".$kp->nama_instansi."',"; } ?>],
	        title: {
	            text: null
	        }
	    },
	    yAxis: {
	        min: 0,
	        labels: {
	            overflow: 'justify'
	        }
	    },
	    tooltip: {
	        valueSuffix: ' pegawai'
	    },
	    plotOptions: {
	        bar: {
	            dataLabels: {
	                enabled: true
	            }
	        }
	    },
	    credits: {
	        enabled: false
	    },
	    series: [{
	        name: 'Jumlah Pegawai',
	        data: [<?php foreach($count_usulan_kp AS $kp) { echo $kp->jumlah_usulan_kp.","; } ?>]
	    }]
	});

	Highcharts.chart('pindahinstansi_by_instansi', {
	    chart: {
	        type: 'bar'
	    },
	    title: {
	        text: 'Jumlah Usulan Pindah Instansi Berdasarkan Instansi',
	        align: 'left'
	    },
	    xAxis: {
	        categories: [<?php foreach($count_usulan_pindahinstansi AS $pi) { echo "'".$pi->nama_instansi."',"; } ?>],
	        title: {
	            text: null
	        }
	    },
	    yAxis: {
	        min: 0,
	        labels: {
	            overflow: 'justify'
	        }
	    },
	    tooltip: {
	        valueSuffix: ' pegawai'
	    },
	    plotOptions: {
	        bar: {
	            dataLabels: {
	                enabled: true
	            }
	        }
	    },
	    credits: {
	        enabled: false
	    },
	    series: [{
	        name: 'Jumlah Pegawai',
	        data: [<?php foreach($count_usulan_pindahinstansi AS $pi) { echo $pi->jumlah_usulan_pindahinstansi.","; } ?>]
	    }]
	});
	Highcharts.chart('pensiun_by_instansi', {
	    chart: {
	        type: 'bar'
	    },
	    title: {
	        text: 'Jumlah Usulan Pensiun Berdasarkan Instansi',
	        align: 'left'
	    },
	    xAxis: {
	        categories: [<?php foreach($count_usulan_pensiun_by_instansi AS $pen) { echo "'".$pen->nama_instansi."',"; } ?>],
	        title: {
	            text: null
	        }
	    },
	    yAxis: {
	        min: 0,
	        labels: {
	            overflow: 'justify'
	        }
	    },
	    tooltip: {
	        valueSuffix: ' pegawai'
	    },
	    plotOptions: {
	        bar: {
	            dataLabels: {
	                enabled: true
	            }
	        }
	    },
	    credits: {
	        enabled: false
	    },
	    series: [{
	        name: 'Jumlah Pegawai',
	        data: [<?php foreach($count_usulan_pensiun_by_instansi AS $pen) { echo $pen->jumlah_usulan_pensiun.","; } ?>]
	    }]
	});	
	

</script>