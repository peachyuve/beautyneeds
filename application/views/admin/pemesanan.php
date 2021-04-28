<div class="col pt-3 mb-4">
    <div class="container mt-5">
        <h2>Pemesanan</h2>
        <!-- MULAI KONTEN DISINI -->

        <?= $this->session->flashdata('message'); ?>

        <div class="mt-4 row">
            <div class="col justify-content-start">
                <a href="<?= base_url(); ?>admin/tambahpesanan">
                    <button class="btn btn-success">
                        <i class="fas fa-fw fa-plus mr-2"></i>Tambah Pemesanan
                    </button>
                </a>
            </div>
            <form action="<?= base_url('admin/pemesanan'); ?>" method="post" class="col-4 justify-content-end">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Cari.." name="keyword" autocomplete="off" autofocus
                    value="<?= set_value('keyword'); ?>">
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary" type="submit" name="submit">
                            <i class="fas fa-fw fa-search"></i></button>
                    </div>
                </div>
            </form>
        </div>

        <div class="mt-4 table-responsive-lg">

            <table id="datatables" class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Tanggal Pemesanan</th>
                        <th scope="col">Customer</th>
                        <th scope="col">Total</th>
                        <th scope="col">Status</th>
                        <th scope="col" colspan="2">Action</th>

                    </tr>
                </thead>
                <tbody>
                    <?php if ( empty($pemesananpagination) ) :?>
                        <tr>
                            <td colspan="6">
                                <div class="alert alert-danger" role="alert">
                                    Data tidak ditemukan.
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
                    <?php $no=1; foreach ($pemesananpagination as $p ) :?>
                    <tr>
                        <form action="">
                            <td><?= $no++; ?></td>
                            <td><?= $p['tgl_pemesanan']?></td>
                            <td><?= $p['nama'] ?></td>
                            <td>Rp<?= number_format($p['total'], 0,',','.'); ?>,-</td>
                          
                            <td>
                                <?php if ($p['statuspm'] == 1) {
                                    echo '<h5><span class="badge text-white" style="background: #00b894;">Selesai</span></h5>';
                                }else if ($p['statuspm'] == 2){
                                    echo '<h5><span class="badge badge-warning">Sudah Dibayar</span></h5>';
                                }else{
                                    echo '<h5><span class="badge badge-danger">Belum Selesai</span></h5>';
                                }
                                ?>
                            </td>


                            <td width="1">
                                    <span data-toggle="tooltip" data-placement="left" title="Detail">
                                        <button type="button" class="btn btn-primary" data-toggle="modal"
                                                data-target="#detail<?= $p['idPemesanan']?>">
                                            <i class="fas fa-fw fa-info"></i>
                                        </button>
                                    </span>
                                    <span data-toggle="tooltip" data-placement="left" title="Hapus">
                                        <a href="<?= base_url(); ?>admin/hapusPemesanan/<?= $p['idPemesanan']?>"
                                                onClick="return confirm('Apakah Anda yakin ingin menghapus Pemesanan ini?')">
                                        <button type="button" class="btn btn-danger ml-1">
                                                <i class="fas fa-fw fa-times"></i>
                                        </<button>
                                    </span>
                                    <?php if ($p['statuspm'] != 1) : ?>
                                    <span data-toggle="tooltip" data-placement="left" title="Selesai">
                                       <a href="<?= base_url(); ?>admin/pemesananselesai/<?= $p['idPemesanan']?>"
                                                onClick="return confirm('Apakah Anda yakin ingin menyelesaikan pemesanan ini?')">
                                        <button type="button" class="btn btn-success ml-1">
                                                <i class="fas fa-fw fa-check"></i>
                                        </<button>
                                    </span>
                                    <?php endif; ?>
                            </td>

                        </form>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

        </div>

    </div>

</div>


<!-- MODAL FORM DETAIL PEMESANAN -->
<?php $no=1; foreach ($allPemesanan as $p ) :?>
<div class="modal fade" id="detail<?= $p['idPemesanan']; ?>" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <!-- <div class="modal-header">
                <h4>Detail User</h4>
            </div> -->
            <div class="modal-body mt-3">
                <div class="row mx-auto my-2">
                    <div class="col">
                        <h6>Tanggal Pemesanan</h6>
                    </div>
                    <div class="col-7">
                        <?= date("D, d F Y", strtotime($p['tgl_pemesanan']));?>
                    </div>
                </div>
                <div class="row mx-auto my-2">
                    <div class="col">
                        <h6>Tanggal Pembayaran</h6>
                    </div>
                    <div class="col-7">
                        <?= date("D, d F Y", strtotime($p['tanggalBayar']));?>
                    </div>
                </div>
                <div class="row mx-auto my-2">
                    <div class="col">
                        <h6>Tanggal Tenggat</h6>
                    </div>
                    <div class="col-7">
                        <?= date("D, d F Y", strtotime($p['tanggalTenggat']));?>
                    </div>
                </div>
                <div class="row mx-auto my-2">
                    <div class="col">
                        <h6>Customer</h6>
                    </div>
                    <div class="col-7">
                        <?= $p['nama'];?>
                    </div>
                </div>
                <div class="row mx-auto my-2">
                    <div class="col">
                        <h6>Alamat Pengiriman</h6>
                    </div>
                    <div class="col-7">
                        <?= $p['alamat'];?>
                    </div>
                </div>
                <div class="row mx-auto my-2">
                    <div class="col">
                        <h6>Metode Pembayaran</h6>
                    </div>
                    <div class="col-7">
                        <?= $p['namajenisb'];?>
                    </div>
                </div>
                <div class="row mx-auto my-2">
                    <div class="col">
                        <h6>Bukti</h6>
                    </div>
                    <div class="col-7">
                        <?php if (!$p['bukti']){
                            echo "Tidak Tersedia";
                        }else{
                            echo $p['bukti'];
                        } ?>
                    </div>
                </div>
                <div class="row mx-auto my-2">
                    <div class="col">
                        <h6>Status</h6>
                    </div>
                    <div class="col-7">
                        <?php if (!$p['bukti']){
                            echo "Belum Lunas";
                        }else{
                            echo "Lunas";
                        } ?>
                    </div>
                </div>
                
                <div class="table-responsive">
                    <table class="table table col mx-auto mt-4">
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
                            <?php if (empty($p['itemPemesanan']) ): ?>
                                <tr><td colspan="5">
                                <div class="alert alert-danger text-center" role="alert">
                                    Item Kosong.
                                </div></td></tr>
                            <?php else: ?>
                                <?php $no=1; foreach ($p['itemPemesanan'] as $items) : ?>
                                <tr>
                                    <th scope="row"><?= $no++; ?></th>
                                    <td><?= $items['nama']; ?></td>
                                    <td><?= $items['jumlah']; ?></td>
                                    <td>Rp<?= number_format(($items['subtotal']/$items['jumlah']), 0,',','.'); ?>,-</td>
                                    <td align="right">Rp<?= number_format($items['subtotal'], 0,',','.'); ?>,-</td>
                                </tr>
                                <?php endforeach; ?>
                                <tr>
                                    <td align="right" colspan="4"><b>Total</b></td>
                                    <td align="right"><b>Rp<?= number_format($p['total'], 0,',','.'); ?>,-</b></td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>

        </div>
    </div>
</div>
<?php endforeach; ?>
