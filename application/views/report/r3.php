<?=cahya_getview("report/start");?>

	<p><i>Laporan dengan rentang waktu mulai dari <?=$xstart;?> sampai <?=$xend;?>.</i></p>
	<p>Berikut adalah laporan "<?=$report_name;?>":</p>
	
	<table width="100%" class="table">
		<tr class="thead">
			<td class="th">#NO</td>
			<td class="th" width="30%">BULAN</td>
			<td class="th">PERSENTASE KEHADIRAN (%)</td>
			<td class="th">KETERANGAN</td>
		</tr>
		<?php 
			$hadir = $absen['hadir'];
			$alpha = $absen['alpha'];
			for ($i=0; $i < count($hadir); $i++) { ?>
			<tr class="tbody">
				<td class="td"><?=($i+1);?></td>
				<td class="td"><?=getMonthName($hadir[$i]['presensi_date']);?> <?=rfdate($hadir[$i]['presensi_date'], "Y");?></td>
				<td class="td"><?=round(($hadir[$i]['ttl_presensi']/($hadir[$i]['ttl_presensi']+$alpha[$i]['ttl_presensi']))*100);?> %</td>
				<td class="td"><?=$hadir[$i]['ttl_presensi'];?> dari <?=($hadir[$i]['ttl_presensi']+$alpha[$i]['ttl_presensi']);?> pertemuan</td>
			</tr>
		<?php } ?>
	</table>

<?=cahya_getview("report/end");?>