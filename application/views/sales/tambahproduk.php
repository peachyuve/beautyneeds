<div class="col pt-3 mb-4">
	<div class="container mt-5">
		<h2>Tambah</h2>
		<!-- MULAI KONTEN DISINI -->

		<?= form_open_multipart('sales/tambahproduk');?>
		
        <div class="col-md-7 mt-3">

			<div class="form-group row">
				<label for="nama" class="col-sm-3 col-form-label">Nama</label>
				<div class="col-sm-9">
					<input type="text" class="form-control" id="nama" name="nama" placeholder="Nama"
                    value="<?= set_value('nama'); ?>">
					<?= form_error('nama', '<small class="form-text text-danger">', '</small>'); ?>
				</div>
			</div>

			<div class="form-group row">
				<label for="idJenisProduk" class="col-sm-3 col-form-label">Jenis Produk</label>
				<div class="col-sm-9">
					<select class="custom-select" name="idJenisProduk">
						<?php foreach ($getjenis as $r ) :?>
                            <?php if( set_value('namaJenis') == $r['idJenisProduk'] ) : ?>
                                <option value="<?= $r['idJenisProduk']; ?>" selected><?= $r['namaJenis']; ?></option>
                            <?php else : ?>
                                <option value="<?= $r['idJenisProduk']; ?>"><?= $r['namaJenis']; ?></option>
                            <?php endif; ?>
						<?php endforeach; ?>
					</select>
				</div>
			</div>

			<div class="form-group row">
				<label for="warna" class="col-sm-3 col-form-label">Warna</label>
				<div class="col-sm-9">
					<input type="text" class="form-control" id="warna" name="warna" placeholder="Warna"
                    value="<?= set_value('warna'); ?>">
					<?= form_error('warna', '<small class="form-text text-danger">', '</small>'); ?>
				</div>
			</div>

			<div class="form-group row">
				<label for="harga" class="col-sm-3 col-form-label">Harga</label>
				<div class="col-sm-9">
					<input type="text" class="form-control" id="harga" name="harga" placeholder="Harga" value="<?= set_value('harga'); ?>">
					<?= form_error('harga', '<small class="form-text text-danger">', '</small>'); ?>
				</div>
			</div>

			<div class="form-group row">
				<label for="gambar" class="col-sm-3 col-form-label">Gambar</label>
				<div class="col-sm-7">
					<div class="custom-file">
						<input type="file" class="custom-file-input" id="gambar" name="gambar">
						<label class="custom-file-label" for="foto">Pilih Gambar</label>
						<?= $this->session->flashdata('message'); //pesan error khusus upload ?>
					</div>
				</div>
			</div>

			<div class="form-group row">
				<label for="deskripsi" class="col-sm-3 col-form-label">Deskripsi</label>
				<div class="col-sm-9">
					<input type="text" class="form-control" id="deskripsi" name="deskripsi" placeholder="Deskripsi"
                    value="<?= set_value('deskripsi'); ?>">
					<?= form_error('deskripsi', '<small class="form-text text-danger">', '</small>'); ?>
				</div>
			</div>

			<div class="form-group row">
				<label for="stok" class="col-sm-3 col-form-label">Stok</label>
				<div class="col-sm-9">
					<input type="text" class="form-control" id="stok" name="stok" placeholder="Stok"
                    value="<?= set_value('stok'); ?>">
					<?= form_error('stok', '<small class="form-text text-danger">', '</small>'); ?>
				</div>
			</div>

			<div class="form-group row">
				<label for="status" class="col-sm-3 col-form-label">Status</label>
				<div class="col-sm-9">
					<select class="custom-select" name="status">
						<?php if( set_value('status') == 1 ) : ?>
							<option value="1" selected>Tersedia</option>
						<?php else : ?>
							<option value="1">Tersedia</option>
						<?php endif; ?>
						<?php if( set_value('status') == 0 ) : ?>
							<option value="0" selected>Tidak Tersedia</option>
						<?php else : ?>
							<option value="0">Tidak Tersedia</option>
						<?php endif; ?>
					</select>
				</div>
			</div>
            <hr>
			<div class="form-group row justify-content-end">
				<a type="button" href="<?= base_url('sales/produk'); ?>" class="btn btn-secondary form-control mt-2 col-sm-2 mx-1">Batal</a>
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