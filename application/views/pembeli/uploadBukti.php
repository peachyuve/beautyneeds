<div class="col pt-3 mb-4">
	<div class="container mt-5">
		<br/>
		<h2>Upload Bukti</h2>
		<!-- MULAI KONTEN DISINI -->

		<?= form_open_multipart('pembeli/uploadbukti/'.$idPembayaran.'/'.$idPemesanan);?>
		
        <div class="col-md-7 mt-3">


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


            <hr>
			<div class="form-group row justify-content-end">
				<a type="button" href="<?= base_url('karyawan/produk'); ?>" class="btn btn-secondary form-control mt-2 col-sm-2 mx-1">Batal</a>
				<button type="submit" class="btn btn-success form-control mt-2 col-sm-2 mx-1">Submit</button>
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