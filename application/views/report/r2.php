<?=cahya_getview("report/start");?>

<p><i>Laporan dengan rentang waktu mulai dari <?=$xstart;?> sampai <?=$xend;?>.</i></p>
<p>Berikut adalah laporan "<?=$report_name;?>":</p>

<?php foreach ($absen as $k => $v) { ?>
	<?php if(count($v['dp']) != 0) {?>
		<h3>MATAKULIAH : <?=$v['mk_name'];?></h3>
		<table width="100%" class="table">
			<tr class="thead">
				<td class="th">#NO</td>
				<td class="th" width="30%">NAMA LENGKAP</td>
				<td class="th">KETERANGAN</td>
			</tr>
			<?php $no=1; foreach ($v['dp'] as $k2 => $v2) { ?>
				<?php if($v['dp'][$k2]['alpha']  >= 2) {?>
					<tr class="tbody">
						<td class="td"><?=$no;?></td>
						<td class="td"><?=$v2['fullname'];?></td>
						<?php if($v['dp'][$k2]['alpha']  == 2) {?>
							<td class="td">Sudah mendekati batas maksimal alpha. Kehadiran kurang bagus, alpha <?=$v2['alpha'];?> dari <?=$v2['hadir']+$v2['alpha'];?> pertemuan.</td>
						<?php } elseif($v['dp'][$k2]['alpha']  == 3) {?>
							<td class="td">Sudah memenuhi batas maksimal alpha, ini tidak bagus, alpha <?=$v2['alpha'];?> dari <?=$v2['hadir']+$v2['alpha'];?> pertemuan.</td>
						<?php } elseif($v['dp'][$k2]['alpha']  > 3) {?>
							<td class="td">Ini sangat tidak bagus, sudah melebihi batas maksimal alpha, alpha <?=$v2['alpha'];?> dari <?=$v2['hadir']+$v2['alpha'];?> pertemuan.</td>
						<?php } ?>
					</tr>
				<?php $no++; } ?>
			<?php } ?>
		</table>
	<?php } ?>
<?php } ?>

<?=cahya_getview("report/end");?>