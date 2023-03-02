<?php helper(['html','format']); ?>

<div class="card-body dashboard">
	<?php
	// if ($message['status'] == 'error') {
	// 	show_message($message);
	// }
	?>
	<div class="row">
		<div class="col-lg-3 col-sm-6 col-xs-12 mb-4">
			<div class="card text-bg-primary shadow">
				<div class="card-body card-stats">
					<div class="description">
						<h5 class="card-title h4"><?php echo $totalukpMS->countstatus; ?></h5>
						<p class="card-text">Usulan KP MS</p>

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
		<div class="col-lg-3 col-sm-6 col-xs-12 mb-4">
			<div class="card text-white bg-success shadow">
				<div class="card-body card-stats">
					<div class="description">
						<h5 class="card-title h4"><?php echo $totalukpBTS->countstatus;?></h5>
						<p class="card-text">Usulan KP BTS</p>
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
		<div class="col-lg-3 col-sm-6 col-xs-12 mb-4">
			<div class="card text-white bg-warning shadow">
				<div class="card-body card-stats">
					<div class="description">
						<h5 class="card-title h4"><?php echo $totalukpDalamProses->countstatus;?></h5>
						<p class="card-text">Usulan KP Dalam Proses Validasi</p>
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
		<div class="col-lg-3 col-sm-6 col-xs-12 mb-4">
			<div class="card text-white bg-danger shadow">
				<div class="card-body card-stats">
					<div class="description">
						<h5 class="card-title h4"><?php echo $totalukpTMS->countstatus;?></h5>
						<p class="card-text">Usulan KP TMS</p>
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
	</div>
	<div class="row">
		<div class="col-12 col-md-12 col-lg-12 col-xl-4 mb-4">
			<div class="card">
				<div class="card-header">
					<div class="card-header-start">
						<h6 class="card-title">Jumlah Pegawai Berdasarkan Golongan/Ruang</h6>
					</div>
				</div>
				<div class="card-body">
					<div style="overflow: auto">
						<table class="table table-striped table-bordered table-hover mytables">
							<thead>
								<tr>
									<th style="text-align: center;" width="20px">NO.</th>
									<th style="text-align: center;">GOLONGAN/RUANG</th>
									<th style="text-align: center;">JUMLAH</th>
								</tr>
								</thead>
							<tbody>
								<?php 	
									$no = 1;
									foreach ($golru AS $gr): 
								?>
									<tr>
										<td style="text-align: center;"><?php echo $no++; ?></td>
										<td style="text-align: center;"><?php echo format_golru($gr->gol_akhir); ?></td>
										<td style="text-align: center;"><?php echo $gr->jum_golru; ?></td>
									</tr>
								<?php endforeach ?>
							</tbody>
								<tfoot>
									<th style="text-align: center;" colspan="2">Total</th>
									<th style="text-align: center;"><?php echo format_ribuan($totalpegawai->totalpegawai); ?></th>
								</tfoot>
						</table>
					</div>
				</div>
			</div>
		</div>
		<div class="col-12 col-md-12 col-lg-12 col-xl-8 mb-4">
			<div class="card" style="height:100%">
				<div class="card-body" style="display:flex">
					<figure class="highcharts-figure" style="min-width:500px;margin:top;width:100%;">
					    <div id="graph-golru"></div>
					</figure>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-12 col-md-12 col-lg-12 col-xl-4 mb-4">
			<div class="card">
				<div class="card-header">
					<div class="card-header-start">
						<h6 class="card-title">Jumlah Pegawai Berdasarkan Jenis Kelamin</h6>
					</div>
				</div>
				<div class="card-body">
					<div style="overflow: auto">
						<table class="table table-striped table-bordered table-hover mytables">
							<thead>
								<tr>
									<th style="text-align: center;">NO.</th>
									<th style="text-align: center;">JENIS KELAMIN</th>
									<th style="text-align: center;">JUMLAH</th>
								</tr>
							</thead>
							<tbody>
								<?php 	
										$no = 1;
										foreach ($gender AS $jk): 
									?>
										<tr>
											<td style="text-align: center;"><?php echo $no++; ?></td>
											<td><?php echo $jk->gender; ?></td>
											<td style="text-align: center;"><?php echo $jk->jum_gender; ?></td>
										</tr>
									<?php endforeach ?>
							</tbody>
								<tfoot>
									<th style="text-align: center;" colspan="2">Total</th>
									<th style="text-align: center;"><?php echo format_ribuan($totalpegawai->totalpegawai); ?></th>
								</tfoot>
						</table>
					</div>
				</div>
			</div>
		</div>
		<div class="col-12 col-md-12 col-lg-12 col-xl-8 mb-4">
			<div class="card" style="height:100%">
				<div class="card-body" style="display:flex">
					<figure class="highcharts-figure" style="min-width:500px;margin:top;width:100%;">
					    <div id="graph-gender"></div>
					</figure>
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-12 col-md-12 col-lg-12 col-xl-4 mb-4">
			<div class="card">
				<div class="card-header">
					<div class="card-header-start">
						<h6 class="card-title">Jumlah Pegawai Berdasarkan Jenis Jabatan</h6>
					</div>
				</div>
				<div class="card-body">
					<div style="overflow: auto">
						<table class="table table-striped table-bordered table-hover mytables">
							<thead>
								<tr>
									<th style="text-align: center;">NO.</th>
									<th style="text-align: center;">JENIS JABATAN</th>
									<th style="text-align: center;">JUMLAH</th>
								</tr>
								</thead>
							<tbody>		
								<tr>
									<td style="text-align: center;">1</td>									
									<td>Struktural</td>									
									<td style="text-align: center;"><?php echo format_ribuan($jenjab1->jumlah); ?></td>	
								</tr>		
								<tr>
									<td style="text-align: center;">2</td>									
									<td>Fungsional</td>									
									<td style="text-align: center;"><?php echo format_ribuan($jenjab2->jumlah); ?></td>	
								</tr>		
								<tr>
									<td style="text-align: center;">3</td>									
									<td>Fungsional Umum</td>									
									<td style="text-align: center;"><?php echo format_ribuan($jenjab3->jumlah); ?></td>	
								</tr>								
								</tbody>
								<tfoot>
									<th style="text-align: center;" colspan="2">Total</th>
									<th style="text-align: center;"><?php echo format_ribuan($totalpegawai->totalpegawai); ?></th>
								</tfoot>
						</table>
					</div>
				</div>
			</div>
		</div>
		<div class="col-12 col-md-12 col-lg-12 col-xl-8 mb-4">
			<div class="card" style="height:100%">
				<div class="card-body" style="display:flex">
					<figure class="highcharts-figure" style="min-width:500px;margin:top;width:100%;">
					    <div id="graph-jenjab"></div>
					</figure>
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-12 col-md-12 col-lg-12 col-xl-4 mb-4">
			<div class="card">
				<div class="card-header">
					<div class="card-header-start">
						<h6 class="card-title">Status Pengusulan Kenaikan Pangkat</h6>
					</div>
				</div>
				<div class="card-body">
					<div style="overflow: auto">
						<table class="table table-striped table-bordered table-hover mytables">
							<thead>
							<tr>
								<th style="text-align: center;" width="20px">NO.</th>
								<th style="text-align: center;">STATUS</th>
								<th style="text-align: center;">JUMLAH</th>
							</tr>
							</thead>
							<tbody>
							<tr>
								<td colspan="2">Sudah Proses Validasi</td>
								<?php $totalukpSudahProses = $totalukpTMS->countstatus + $totalukpBTS->countstatus + $totalukpMS->countstatus; ?>
								<td style="text-align: center;"><?php echo $totalukpSudahProses; ?></td>
							</tr>
							<tr>
								<td>-</td>
								<td>TMS</td>
								<td style="text-align: center;"><?php echo $totalukpTMS->countstatus; ?></td>
							</tr>
							<tr>
								<td>-</td>
								<td>BTS</td>
								<td style="text-align: center;"><?php echo $totalukpBTS->countstatus; ?></td>
							</tr>
							<tr>
								<td>-</td>
								<td>MS</td>
								<td style="text-align: center;"><?php echo $totalukpMS->countstatus; ?></td>
							</tr>
							<tr>
								<td colspan="2">Dalam Proses Validasi</td>
								<td style="text-align: center;"><?php echo $totalukpDalamProses->countstatus; ?></td>
							</tr>

							</tbody>
								<tfoot>
									<th style="text-align: center;" colspan="2">Total</th>
									<th style="text-align: center;"><?php echo format_ribuan($totalukp->jum_ukp); ?></th>
								</tfoot>
						</table>
					</div>
				</div>
			</div>
		</div>
		<div class="col-12 col-md-12 col-lg-12 col-xl-8 mb-4">
			<div class="card" style="height:100%">
				<div class="card-body" style="display:flex">
					<figure class="highcharts-figure" style="min-width:500px;margin:top;width:100%;">
					    <div id="graph-usulankp"></div>
					</figure>
				</div>
			</div>
		</div>
	</div>
</div>

	<script>
		$(document).ready( function () {
		    $('.mytables').DataTable({
		    	"lengthChange": false,
		    	"searching": false
		    });

		} );
	</script>

<script>

	var chart1;
	var chart2;
	var chart3;
	var chart4;
	var total = <?=$pegawai->totalpegawaiinstansi;?>;
	
		// chart golru
		chart1 = new Highcharts.Chart({
		    chart: {
		        renderTo: 'graph-golru',
		        type: 'column',
		        height: (9 / 16 * 100) + '%',
		        
		    },
		    xAxis: {
		        categories: [<?php foreach ($golru AS $gr){ echo "'".format_golru($gr->gol_akhir)."',"; }?>]
		    },
		    yAxis: {
		        title: {
		            enabled: false
		        }
		    },
		    tooltip: {
		        headerFormat: '<b>Gol/Ruang : {point.key}</b><br>',
		        pointFormat: 'Jumlah: {point.y}'
		    },
		    title: {
		        text: 'Jumlah Pegawai berdasarkan Golongan/Ruang',
		        align: 'left'
		    },
		    legend: {
		        enabled: false
		    },
		    plotOptions: {
		        column: {
		            depth: 25
		        }
		    },
		    series: [{
		        data: [<?php foreach ($golru AS $gr){ echo $gr->jum_golru.","; }?>],
		        dataLabels: {  
		        	formatter: function () {
		                return Math.round(100 * this.y / total) + '%';
		            },
		        	enabled: true, 
		        },
		        colorByPoint: true
		    }]
		});

		//graph gender
	
		chart2 = new Highcharts.Chart({
		    chart: {
		    	renderTo: 'graph-gender',
		        type: 'pie',
		        options3d: {
		            enabled: true,
		            alpha: 45,
		            beta: 0
		        }
		    },


		    title: {
		        text: 'Jumlah Pegawai berdasarkan Jenis Kelamin',
		        align: 'left'
		    },
		    accessibility: {
		        point: {
		            valueSuffix: '%'
		        }
		    },
		    tooltip: {
		        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
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
		        name: 'Jumlah',
		        data: [<?php foreach($gender AS $jk){ echo "['".$jk->gender."',".$jk->jum_gender."],"; }?>
		        ]
		    }]
		});


		//graph jenis jabatan
	
		chart3 = new Highcharts.Chart({
		    chart: {
		    	renderTo: 'graph-jenjab',
		        type: 'pie',
		        options3d: {
		            enabled: true,
		            alpha: 45,
		            beta: 0
		        }
		    },


		    title: {
		        text: 'Jumlah Pegawai berdasarkan Jenis Jabatan',
		        align: 'left'
		    },
		    accessibility: {
		        point: {
		            valueSuffix: '%'
		        }
		    },
		    tooltip: {
		        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
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
		        name: 'Jumlah',
		        data: [
		        	['Struktural',<?php echo $jenjab1->jumlah?>],
		        	['Fungsional Umum',<?php echo $jenjab2->jumlah?>],
		        	['Fungsional',<?php echo $jenjab3->jumlah?>],
		        ]
		    }]
		});

		//graph status usulan KP
	
		chart4 = new Highcharts.Chart({
		    chart: {
		    	renderTo: 'graph-usulankp',
		        type: 'pie',
		        options3d: {
		            enabled: true,
		            alpha: 45,
		            beta: 0
		        }
		    },


		    title: {
		        text: 'Status Usulan Kenaikan Pangkat',
		        align: 'left'
		    },
		    accessibility: {
		        point: {
		            valueSuffix: '%'
		        }
		    },
		    tooltip: {
		        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
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
		        name: 'Jumlah',
		        data: [<?php foreach($usulankp AS $ukp){ echo "['".$ukp->status."',".$ukp->jum_ukp."],"; }?>
		        ]
		    }]
		});

		function showValues() {
		    document.getElementById('alpha-value').innerHTML = chart.options.chart.options3d.alpha;
		    document.getElementById('beta-value').innerHTML = chart.options.chart.options3d.beta;
		    document.getElementById('depth-value').innerHTML = chart.options.chart.options3d.depth;
		}

		// Activate the sliders
		document.querySelectorAll('#sliders input').forEach(input => input.addEventListener('input', e => {
		    chart.options.chart.options3d[e.target.id] = parseFloat(e.target.value);
		    showValues();
		    chart.redraw(false);
		}));

		showValues();	   
</script>