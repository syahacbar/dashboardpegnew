<?php helper(['html','format']) ?>
<div class="card-body dashboard">
	<div class="row">
		<?php 
		$warnakotak = array('primary','success','info','warning');
		$no=0;	
		foreach($count_usulan_pensiun_by_status AS $up) : ?>
		<div class="col-lg-3 col-sm-6 col-xs-12 mb-3">
			<div class="card text-bg-<?php echo $warnakotak[$no++];?> shadow">
				<div class="card-body card-stats">
					<div class="description">
						<h5 class="card-title h4"><?php echo $up->total_usulan_pensiun;?></h5>
						<p class="card-text"><strong><?php echo $up->status_usulan;?></strong></p>

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
		<?php endforeach; ?>	
	</div>

	<div class="row">
		<div class="col-12 col-md-12 col-lg-12 col-xl-6 mb-4">
			<div class="card">
				<div class="card-body">
					<figure class="highcharts-figure">
						<div id="pensiun_by_instansi"></div>
					</figure>

				</div>
			</div>
		</div>
		<div class="col-12 col-md-12 col-lg-12 col-xl-6 mb-4">
			<div class="card">
				<div class="card-body">
					<figure class="highcharts-figure">
						<div id="pensiun_by_jabatan"></div>
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
						<div id="pensiun_by_jenisjabatan"></div>
					</figure>
				</div>
			</div>
		</div>
		<div class="col-12 col-md-12 col-lg-12 col-xl-6 mb-4">
			<div class="card">
				<div class="card-body">
					<figure class="highcharts-figure">
						<div id="pensiun_by_jenisusulanpensiun"></div>
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

	Highcharts.chart('pensiun_by_jabatan', {
		chart: {
			type: 'pie',
			options3d: {
				enabled: true,
				alpha: 45,
				beta: 0
			}
		},
		title: {
			text: 'Jumlah Usulan Pensiun Berdasarkan Jabatan',
		},
		accessibility: {
			point: {
				valueSuffix: '%'
			}
		},
		tooltip: {
			pointFormat: '{series.name}: <b>{point.y} pegawai</b>'
		},
		plotOptions: {
			pie: {
				allowPointSelect: true,
				cursor: 'pointer',
				depth: 35,
				dataLabels: {
	                enabled: true,
	                format: '{point.name}<br>{point.percentage:.1f} %'
	            }
			}
		},
		series: [{
			type: 'pie',
			name: 'Jumlah Usulan',
			data: [
				<?php foreach($count_usulan_pensiun_by_jabatan AS $pj) : ?>
					['<?php echo $pj->jabatan;?>',<?php echo $pj->jumlah_usulan_pensiun; ?>],
				<?php endforeach;?>

			
			]
		}]
	});

	Highcharts.chart('pensiun_by_jenisjabatan', {
		chart: {
			type: 'pie',
			options3d: {
				enabled: true,
				alpha: 45,
				beta: 0
			}
		},
		title: {
			text: 'Jumlah Usulan Pensiun Berdasarkan Jenis Jabatan',
		},
		accessibility: {
			point: {
				valueSuffix: '%'
			}
		},
		tooltip: {
			pointFormat: '{series.name}: <b>{point.y} pegawai</b>'
		},
		plotOptions: {
			pie: {
				allowPointSelect: true,
				cursor: 'pointer',
				depth: 35,
				dataLabels: {
	                enabled: true,
	                format: '{point.name}<br>{point.percentage:.1f} %'
	            }
			}
		},
		series: [{
			type: 'pie',
			name: 'Jumlah Usulan',
			data: [
				<?php foreach($count_usulan_pensiun_by_jenisjabatan AS $pjj) : ?>
					['<?php echo $pjj->jenis_jabatan;?>',<?php echo $pjj->jumlah_usulan_pensiun; ?>],
				<?php endforeach;?>

			
			]
		}]
	});

	Highcharts.chart('pensiun_by_jenisusulanpensiun', {
		chart: {
			type: 'pie',
			options3d: {
				enabled: true,
				alpha: 45,
				beta: 0
			}
		},
		title: {
			text: 'Jumlah Usulan Pensiun Berdasarkan Jenis Jabatan',
		},
		accessibility: {
			point: {
				valueSuffix: '%'
			}
		},
		tooltip: {
			pointFormat: '{series.name}: <b>{point.y} pegawai</b>'
		},
		plotOptions: {
			pie: {
				allowPointSelect: true,
				cursor: 'pointer',
				depth: 35,
				dataLabels: {
	                enabled: true,
	                format: '{point.name}<br>{point.percentage:.1f} %'
	            }
			}
		},
		series: [{
			type: 'pie',
			name: 'Jumlah Usulan',
			data: [
				<?php foreach($count_usulan_pensiun_by_jenisusulan AS $pju) : ?>
					['<?php echo $pju->jenis_usulan_pensiun;?>',<?php echo $pju->jumlah_usulan_pensiun; ?>],
				<?php endforeach;?>

			
			]
		}]
	});

</script>