<div class="container-fluid pt-5 mt-5">
    <!-- MULAI KONTEN DISINI -->
    
    <div class="container-fluid w-100 col-7 mb-4">
        <h3>Keranjang</h3>
        <?= $this->session->flashdata('message'); ?>
    </div>
    <div class="table-responsive">
        <table class="table table-hover col-7 mx-auto">
            <thead>
                <tr>
                    <th scope="col"></th>
                    <th scope="col">Nama Obat</th>
                    <th scope="col">Jumlah</th>
                    <th scope="col">Harga</th>
                    <th scope="col">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!$this->cart->contents()):?>
                    <tr><td colspan="5">
                    <div class="alert alert-danger text-center" role="alert">
                        Keranjang belum terisi.
                    </div></td></tr>
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

    <div class="container-fluid col-7">
        <div class="row justify-content-between">
            <?php if($this->cart->contents()) : ?>
            <div class=""><a href="<?= base_url('keranjang/hapus'); ?>">
                <button type="button" class="btn btn-danger"
                    onclick="return confirm('Apakah Anda yakin ingin menghapus keranjang ini?')">
                    <i class="fas fa-trash-alt mr-2"></i>Hapus Keranjang
                </button></a>
            </div>
            <?php endif; ?>
            <div class=""><a href="<?= base_url('pembeli/produk'); ?>">
                <button type="button" class="btn btn-info">
                    <i class="fas fa-shopping-cart mr-2"></i>Lanjutkan Belanja
                </button></a>
            </div>
            <?php if($this->cart->contents()) : ?>
            <div class=""><a href="<?= base_url('pemesanan/pembayaran'); ?>">
                <button type="button" class="btn btn-success">
                <i class="fas fa-arrow-circle-right mr-2"></i>Lanjut ke Pembayaran
                </button></a>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- AKHIR KONTEN -->
</div>
