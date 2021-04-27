<div class="container-fluid pt-5 mt-5">
	<!-- MULAI KONTEN DISINI -->
  
	<div class="col-7 mx-auto">
		<div class="row mb-4">
			<div class="col">
				<h2>Pembayaran</h2>
			</div>
		</div>
    
		<div class="row mb-3">
			<div class="col">
				<h5>Data Pengiriman</h5>
			</div>
		</div>
    
    <?= $this->session->flashdata('message'); ?>
    
		<div class="row mb-2">
			<div class="col-2">
				<h6>Nama</h6>
			</div>
			<div class="col">
				<?= $user['nama'] ?>
			</div>
		</div>
		<div class="row mb-2">
			<div class="col-2">
				<h6>Telepon</h6>
			</div>
			<div class="col">
				<?= $user['noHp'] ?>
			</div>
		</div>
		<div class="row mb-2">
			<div class="col-2">
				<h6>Alamat</h6>
			</div>
			<div class="col">
				<?= $user['alamat'] ?>
			</div>
		</div>
	</div>

	<div class="table-responsive">
		<table class="table table col-7 mx-auto mt-3">
			<thead>
				<tr>
					<th scope="col"></th>
					<th scope="col">Nama produk</th>
					<th scope="col">Jumlah</th>
					<th scope="col">Harga</th>
					<th scope="col">Subtotal</th>
				</tr>
			</thead>
			<tbody>
				<?php if (!$this->cart->contents()):?>
				<tr>
					<td colspan="5">
						<div class="alert alert-danger text-center" role="alert">
							Keranjang belum terisi.
						</div>
					</td>
				</tr>
				<?php else: ?>
				<?php $no=1; foreach ($this->cart->contents() as $items) : ?>
				<tr>
					<th scope="row"><?= $no++; ?></th>
					<td><?= $items['name']; ?></td>
					<td><?= $items['qty']; ?></td>
					<td align="right">Rp<?= number_format($items['price'], 0,',','.'); ?>,-</td>
					<td align="right">Rp<?= number_format($items['subtotal'], 0,',','.'); ?>,-</td>
				</tr>
				<?php endforeach; ?>
				<tr>
					<td align="right" colspan="4"><b>Total</b></td>
					<td align="right"><b>Rp<?= number_format($this->cart->total(), 0,',','.'); ?>,-</b></td>
				</tr>
				<?php endif; ?>
			</tbody>
		</table>
	</div>

	<div class="col-7 mx-auto">

        <?= form_open_multipart('pemesanan/pembayaran');?>
            <div class="row justify-content-end">
                <div class="form-group row">
                    <label class="col-sm col-form-label">Metode Pembayaran</label>
                    <div class="col-sm">
                        <select class="custom-select" name="idJenisBayar">
							<?php foreach ($getjenis as $r ) :?>
		                        <?php if( set_value('namajenisb') == $r['idJenisBayar'] ) : ?>
		                            <option value="<?= $r['idJenisBayar']; ?>" selected><?= $r['namajenisb']; ?></option>
		                        <?php else : ?>
		                            <option value="<?= $r['idJenisBayar']; ?>"><?= $r['namajenisb']; ?></option>
		                        <?php endif; ?>
							<?php endforeach; ?>
						</select>
                    </div>
                </div>
            </div>
            <hr>
            <div class="row justify-content-end">
                <a type="button" href="<?= base_url('keranjang'); ?>" class="btn btn-secondary form-control col-2 ">Batal</a>
                <button type="submit" class="btn btn-success form-control col-2">Selesaikan</button>
            </div>
        </form>
	<!-- AKHIR KONTEN -->
</div>
