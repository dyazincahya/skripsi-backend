<?=cahya_getview("report/start");?>

	<p><i>Laporan dengan rentang waktu mulai dari <?=$xstart;?> sampai <?=$xend;?>.</i></p>
	<p>Berikut adalah laporan "<?=$report_name;?>":</p>

	<?php foreach ($absen as $k => $v) { ?>
		<?php if(count($v['dp']) != 0) {?>
			<h3>MATAKULIAH : <?=$v['mk_name'];?></h3>
			<table width="100%" class="table">
				<tr class="thead">
					<td class="th">#NO</td>
					<td class="th" width="65%">NAMA LENGKAP</td>
					<td class="th">HADIR</td>
					<td class="th">TIDAK HADIR</td>
					<td class="th">TOTAL</td>
				</tr>
				<?php foreach ($v['dp'] as $k2 => $v2) { ?>
					<tr class="tbody">
						<td class="td"><?=($k2+1);?></td>
						<td class="td"><?=$v2['fullname'];?></td>
						<td class="td"><?=$v2['hadir'];?></td>
						<td class="td"><?=$v2['alpha'];?></td>
						<td class="td"><?=$v2['hadir']+$v2['alpha'];?></td>
					</tr>
				<?php } ?>
			</table>
		<?php } ?>
	<?php } ?>

<?=cahya_getview("report/end");?>