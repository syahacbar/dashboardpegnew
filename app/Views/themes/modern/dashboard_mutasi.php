<?php helper(['html','format']) ?>
<div class="card-body dashboard">
	<div class="row">
		<div class="col-lg-4 col-sm-6 col-xs-12 mb-4">
			<div class="card text-bg-primary shadow">
				<div class="card-body card-stats">
					<div class="description">
						<h5 class="card-title h4"><?php echo $count_total_usulan_kp->total_usulan_kp;?></h5>
						<p class="card-text">Jumlah Usulan Kenaikan Pangkat</p>

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
		<div class="col-lg-4 col-sm-6 col-xs-12 mb-4">
			<div class="card text-white bg-success shadow">
				<div class="card-body card-stats">
					<div class="description">
						<h5 class="card-title h4"><?php echo $count_total_usulan_pindahinstansi->total_usulan_pindahinstansi;?></h5>
						<p class="card-text">Jumlah Usulan Pindah Instansi</p>
					</div>
					<div class="icon">
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
		<div class="col-lg-4 col-sm-6 col-xs-12 mb-4">
			<div class="card text-white bg-warning shadow">
				<div class="card-body card-stats">
					<div class="description">
						<h5 class="card-title h4">0</h5>
						<p class="card-text">Jumlah Usulan Pencantuman Gelar</p>
					</div>
					<div class="icon">
						<!-- <i class="fas fa-money-bill-wave"></i> -->
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
						<div id="kp_by_instansi"></div>
					</figure>

				</div>
			</div>
		</div>
		<div class="col-12 col-md-12 col-lg-12 col-xl-6 mb-4">
			<div class="card">
				<div class="card-body">
					<figure class="highcharts-figure">
						<div id="kp_by_status"></div>
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
						<div id="pindahinstansi_by_status"></div>
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

	Highcharts.chart('kp_by_status', {
		chart: {
			type: 'pie',
			options3d: {
				enabled: true,
				alpha: 45,
				beta: 0
			}
		},
		title: {
			text: 'Jumlah Usulan KP Berdasarkan Status',
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
				<?php foreach($count_usulan_kp_by_status AS $kps) : ?>
					['<?php echo $kps->status;?>',<?php echo $kps->jumlah_status; ?>],
				<?php endforeach;?>

			
			]
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

	Highcharts.chart('pindahinstansi_by_status', {
		chart: {
			type: 'pie',
			options3d: {
				enabled: true,
				alpha: 45,
				beta: 0
			}
		},
		title: {
			text: 'Jumlah Usulan Pindah Instansi Berdasarkan Status',
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
				<?php foreach($count_usulan_pindahinstansi_by_status AS $pis) : ?>
					['<?php echo $pis->status;?>',<?php echo $pis->jumlah_status; ?>],
				<?php endforeach;?>

			
			]
		}]
	});

</script>