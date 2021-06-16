<div class="container-fluid pt-5 mt-5">
	<!-- MULAI KONTEN DISINI -->

    <?= $this->session->flashdata('message'); ?>
    
    <div class="row col-11 mb-4 mx-auto justify-content-start">
        <div class="col-8">
            <h3>Riwayat Pemesanan</h3>
        </div>
        <div class="col justify-content-end">
            <form action="<?= base_url('pembeli/riwayatPemesanan'); ?>" method="post" class="mr-3">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Cari Pemesanan.." name="keyword" autocomplete="off" autofocus
                    value="<?= set_value('keyword'); ?>">
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary" style="background-color: #FFE5DE" type="submit" name="submit">
                            <i class="fas fa-fw fa-search"></i></button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <?php foreach ($pemesananPagination as $p) : ?>
        <div class="row justify-content-start col-11 mx-auto">
            <div class="card ml-3 mb-4 shadow-sm" style="width: 50rem; border: none;">
                <h6 class="card-header"><?= date("D, d F Y", strtotime($p['tgl_pemesanan'])); ?></h6>
                <div class="card-body">
                    <!-- <div class="container"> -->
                        <div class="row justify-content-between">
                            <div class="col-2">
                                <small>Status</small>
                                <?php if ($p['statuspm'] == 1) {
                                    echo '<h5><span class="badge text-white" style="background: #00b894;">Selesai</span></h5>';
                                }else if ($p['statuspm'] == 2){
                                    echo '<h5><span class="badge badge-warning">Sudah Bayar</span></h5>';
                                }else{
                                    echo '<h5><span class="badge badge-danger">Belum Selesai</span></h5>';
                                }
                                ?>
                            </div>
                            <div class="col-4">
                                <small>Metode Pembayaran</small>
                                <p> <?= $p['namajenisb'];?> </p>
                            </div>
                            <div class="col-3">
                                <small>Total</small>
                                <p>Rp<?= number_format($p['total'], 0,',','.'); ?>,-</p>
                            </div>
                            <div class="col">
                                <a href="#" class="btn btn-info mt-2" id="toggle<?= $p['idPemesanan']; ?>">Lihat Detail</a>
                            </div>
                            <?php  if ($p['statuspm'] == 0) :?>
                                <div class="col">
                                    <a href="<?= base_url(); ?>pembeli/uploadbukti/<?= $p['idPembayaran']?>/<?= $p['idPemesanan']?>">
                                        <button class="btn btn-success">
                                            <i class="fas fa-fw fa-plus mr-2"></i>Upload Bukti
                                        </button>
                                    </a>
                                </div>
                            <?php else : ?>
                                <div class="col">
                                    <button type="button" class="btn btn-primary" data-toggle="modal"
                                        data-target="#bukti<?= $p['idPembayaran']?>">Bukti Pembayaran
                                    </button>
                                </div>
                            <?php endif; ?>
                            
                            
                        </div>
                        <div clas="row">
                            <table class="table table mt-2 mx-auto" id="table<?= $p['idPemesanan']; ?>" >
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
                            <?php $no=1; foreach ($p['itemPemesanan'] as $items) : ?>
                                <tr>
                                    <th scope="row"><?= $no++; ?></th>
                                    <td><?= $items['nama']; ?></td>
                                    <td><?= $items['jumlah']; ?></td>
                                    <td align="right">Rp<?= number_format($items['subtotal']/$items['jumlah'], 0,',','.'); ?>,-</td>
                                    <td align="right">Rp<?= number_format($items['subtotal'], 0,',','.'); ?>,-</td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                            </table>
                        </div>
                    <!-- </div> -->
                </div>
            </div>
           
        </div>
        
        <script>
            $(document).ready(function () 
            {
                $("#table<?= $p['idPemesanan']; ?>").hide();
                $("#toggle<?= $p['idPemesanan']; ?>").click(function(){
                    $("#table<?= $p['idPemesanan']; ?>").fadeToggle("slow");
                    $(this).text($(this).text() == 'Lihat Detail' ? 'Sembunyikan' : 'Lihat Detail'); 
                });
            });
        </script>

    <?php endforeach; ?>

    <?= $this->pagination->create_links(); ?>

    <!-- AKHIR KONTEN -->
</div>
<?php $no=1; foreach ($pemesananPagination as $o ) :?>
    <div class="modal fade" id="bukti<?= $p['idPembayaran']; ?>" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body my-auto">
                    <center>
                    <img class="mx-2 mb-3 mt-2 bg-white" height="150px"
                        src="<?= base_url('assets/img/produk/') . $o['bukti']; ?>">
                    </center>
                </div>
            </div>
            <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
<?php endforeach; ?>

