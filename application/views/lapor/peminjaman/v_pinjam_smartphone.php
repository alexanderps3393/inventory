<div class="form-group">
	<label for="barang" class="col-sm-2 control-label">S/N Smartphone-<?php echo $i;?></label>
	<div class="col-sm-4">
		<input type="hidden" name="jenis_barang[]" value="<?php echo $jenis_barang[$key];?>">
		<select class="select2" name="barang[]" id="barang" style="width:300px" required>
			<option value="">Pilih</option>
			<?php
				foreach ($listSmartphone->result() as $row) {
					echo "<option value='$row->smartphone_id'>".$row->smartphone_sn."</option>";
				}
			?>
		</select>
	</div>
</div>