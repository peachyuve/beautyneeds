<div class="col pt-3 mb-4">
	<div class="container mt-5">
		<h2>Tambah</h2>
		<!-- MULAI KONTEN DISINI -->

		<?= form_open_multipart('manajerkeuangan/tambahlaba');?>
		
        <div class="col-md-7 mt-3">


			<div class="form-group row">
				<label for="idProduk" class="col-sm-3 col-form-label">Produk</label>
				<div class="col-sm-9">
					<select class="custom-select" name="idProduk">
						<?php foreach ($allProduk as $r ) :?>
                            <?php if( set_value('nama') == $r['idProduk'] ) : ?>
                                <option value="<?= $r['idProduk']; ?>" selected><?= $r['nama']; ?></option>
                            <?php else : ?>
                                <option value="<?= $r['idProduk']; ?>"><?= $r['nama']; ?></option>
                            <?php endif; ?>
						<?php endforeach; ?>
					</select>
				</div>
			</div>

			<div class="form-group row">
				<label for="idUser" class="col-sm-3 col-form-label">Sales</label>
				<div class="col-sm-9">
					<select class="custom-select" name="idUser">
						<?php foreach ($allSales as $r ) :?>
                            <?php if( set_value('nama_user') == $r['idUser'] ) : ?>
                                <option value="<?= $r['idUser']; ?>" selected><?= $r['nama_user']; ?></option>
                            <?php else : ?>
                                <option value="<?= $r['idUser']; ?>"><?= $r['nama_user']; ?></option>
                            <?php endif; ?>
						<?php endforeach; ?>
					</select>
				</div>
			</div>
			<div class="form-group row">
				<label for="jumlahLaba" class="col-sm-3 col-form-label">Jumlah Laba</label>
				<div class="col-sm-9">
					<input type="text" class="form-control" id="jumlahLaba" name="jumlahLaba" placeholder="jumlahLaba">
					<?= form_error('nama', '<small class="form-text text-danger">', '</small>'); ?>
				</div>
			</div>

			
            <hr>
			<div class="form-group row justify-content-end">
				<a type="button" href="<?= base_url('manajerkeuangan/laba'); ?>" class="btn btn-secondary form-control mt-2 col-sm-2 mx-1">Batal</a>
				<button type="submit" class="btn btn-success form-control mt-2 col-sm-2 mx-1">Tambah</button>
			</div>
		</div>

		</form>
	</div>
</div>
<script>
    $('.custom-file-input').on('change', function() { 
        let fileName = $(this).val().split('\\').pop(); 
        $(this).next('.custom-file-label').addClass("selected").html(fileName); 
    });
</script>