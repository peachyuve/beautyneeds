

<div class="container-fluid pt-3 mt-4 mb-5">
    <!-- MULAI KONTEN DISINI -->

    <div class="row col-11 mb-4 mx-auto justify-content-start">
        <?= $this->session->flashdata('message'); ?>
        <div class="col-8">
            <h3>Daftar Produk</h3>
        </div>
        <div class="col justify-content-end">
            <form action="<?= base_url('pembeli/produk'); ?>" method="post" class="mr-3">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Cari Produk.." name="keyword" autocomplete="off" autofocus
                    value="<?= set_value('keyword'); ?>">
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary" type="submit" name="submit">
                            <i class="fas fa-fw fa-search"></i></button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="row justify-content-center mx-auto">
        <?php foreach ($obatpagination as $obat) : ?>
        <div class="card mx-3 mb-4 shadow-sm" style="width: 18rem; border: none;">
            <a href="" data-toggle="modal" data-target="#detail<?= $obat['idProduk']?>"><img src="<?= base_url('assets/img/produk/') . $obat['gambar']; ?>" style="padding:30px; object-fit: cover; height: 258px;" class="card-img-top"></a>
            <small class="text-center text-muted">Klik gambar untuk detail produk.</small>
            <div class="card-body text-center text-capitalize">
                <h5 class="card-title"><b><?= $obat['nama']; ?></b></h5>
                <h6 class="mt-n2 mb-3"><small class="text-secondary"><?= $obat['namaJenis']; ?></small></h6>
                <h5><span class="text-info">Rp<?= number_format($obat['harga'], 0,',','.'); ?>,-</span></h5>
            </div>
            <div class="card-footer bg-white">
                <?php if ($obat['stok'] > 0) :?>
                    <a href="<?= base_url('customer/addtocart/').$obat['idProduk']; ?>" class="btn btn-info mr-1 w-100"><i class="fas fa-lg fa-cart-plus ml-n1 mr-1"></i> Tambah ke Keranjang</a>
                <?php else : ?>
                    <a href="" class="btn btn-danger mr-1 w-100 disabled">Stok Habis</a>
                <?php endif; ?>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <?= $this->pagination->create_links(); ?>

    <!-- AKHIR KONTEN -->
</div>

<!-- MODAL FORM DETAIL OBAT -->
<?php $no=1; foreach ($allobat as $o ) :?>
<div class="modal fade" id="detail<?= $o['idProduk']; ?>" tabindex="-1" role="dialog">
 <div class="modal-dialog" role="document">
  <div class="modal-content">
   <div class="modal-header">
    <!-- <h4>Detail User</h4> -->
                <img class="mx-auto mb-3 mt-2 bg-white" style="object-fit: cover; max-height: 200px;"
                    src="<?= base_url('assets/img/produk/') . $o['gambar']; ?>">
    <h5><?//= $o['nama'];?></h5>
    <p><?//= $o['jenis_obat'];?></p>
   </div>
   <div class="modal-body my-auto">
                <div class="row mx-auto">
                    <div class="col-4">
                        <h6>Nama Obat</h6>
                    </div>
                    <div class="col-8">
                        <p><?= $o['nama'];?></p>
                    </div>
                </div>
                <div class="row mx-auto">
                    <div class="col-4">
                        <h6>Jenis Produk</h6>
                    </div>
                    <div class="col-8">
                        <p><?= $o['namaJenis'];?></p>
                    </div>
                </div>
                <div class="row mx-auto">
                    <div class="col-4">
                        <h6>Harga</h6>
                    </div>
                    <div class="col-8">
                        <p>Rp<?= $o['harga'];?>,-</p>
                    </div>
                </div>
   </div>
   <div class="modal-footer">
                <a href="<?= base_url('customer/addtocart/').$obat['idProduk']; ?>" class="btn btn-outline-info mr-1"><i class="fas fa-lg fa-cart-plus ml-n1 mr-1"></i> Tambah ke Keranjang</a>
    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Tutup</button>
   </div>
  </div>
 </div>
</div>
<?php endforeach; ?>