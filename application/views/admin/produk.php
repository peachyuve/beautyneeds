<div class="col pt-3 mb-4">
	<div class="container mt-5">
		<h2>Produk</h2>
		<!-- aMULAI KONTEN DISINI -->

		<?= $this->session->flashdata('message'); ?>

		<div class="mt-4 row">
            <div class="col justify-content-start">
                <a href="<?= base_url(); ?>karyawan/tambahproduk">
                    <button class="btn btn-success">
                        <i class="fas fa-fw fa-plus mr-2"></i>Tambah Produk
                    </button>
                </a>
            </div>
            <form action="<?= base_url('karyawan/produk'); ?>" method="post" class="col-4 justify-content-end">
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

			<table class="table table-hover">
				<thead>
					<tr>
						<th scope="col"></th>
						<th scope="col">Id Produk</th>
						<th scope="col">Nama </th>
						<th scope="col">Jenis</th>
						<th scope="col">Warna</th>
                        <th scope="col">Harga</th>
                        <th scope="col">Gambar</th>
                        <th scope="col">Deskripsi</th>
                        <th scope="col">Stok</th>
						<th scope="col">Status</th>
						<th scope="col" colspan="2">Action</th>
					</tr>
				</thead>
				<tbody>
                    <?php if ( empty($produkpagination) ) :?>
                        <tr>
                            <td colspan="6">
                                <div class="alert alert-danger" role="alert">
                                    Data tidak ditemukan.
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
					<?php foreach ($produkpagination as $o ) :?>
					<tr>
						<form action="">
							<td><?= ++$start ?></td>
							<td><?= $o['idProduk'] ?></td>
							<td><?= $o['nama']?></td>
							<td><?= $o['namaJenis']?></td>
                            <td><?= $o['warna']?></td>
                            <td>Rp<?= $o['harga']?>,-</td>
                            <td><?= $o['gambar']?></td>
                            <td><?= $o['deskripsi']?></td>
                            <td><?= $o['stok']?></td>
							<td>
                                <?php if ($o['status'] == 1) : ?>
                                    Tersedia
                                <?php else : ?>
                                    Tidak Tersedia
                                <?php endif; ?>
                            </td>

							<td width="1">
                                <span data-toggle="tooltip" data-placement="left" title="Detail">
                                    <button type="button" class="btn btn-primary" data-toggle="modal"
                                        data-target="#detail<?= $o['idProduk']?>">
                                        <i class="fas fa-fw fa-info"></i>
                                    </button>
                                </span>
                            </td>
                            <td width="1">
                                <span data-toggle="tooltip" data-placement="left" title="Edit">
                                    <a href="<?= base_url(); ?>karyawan/editproduk/<?= $o['idProduk']?>">
                                    <button type="button" class="btn btn-warning ml-1">    
                                        <i class="fas fa-fw fa-edit"></i>
                                    </button>
                                </span>
                            </td>
                            <?php if ($o['status'] == 1) : ?>
                                <td width="1">
                                    <span data-toggle="tooltip" data-placement="left" title="Hapus">
                                        <a href="<?= base_url(); ?>karyawan/hapusProduk/<?= $o['idProduk']?>"
                                            onClick="return confirm('Apakah Anda yakin ingin menghapus obat ini?')">
                                        <button type="button" class="btn btn-danger ml-1">
                                            <i class="fas fa-fw fa-trash-alt"></i>
                                        </<button>
                                    </span>
                                </td>
                            <?php endif; ?>
						</form>
					</tr>
					<?php endforeach; ?>
				</tbody>
			</table>

			<?= $this->pagination->create_links(); ?>

		</div>

	</div>

</div>
<!-- MODAL FORM DETAIL OBAT -->
<?php $no=1; foreach ($allproduk as $o ) :?>
<div class="modal fade" id="detail<?= $o['idProduk']; ?>" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <!-- <div class="modal-header">
                <h4>Detail User</h4>
            </div> -->
            <div class="modal-body my-auto">
                <center>
                <img class="mx-2 mb-3 mt-2 bg-white" height="150px"
                    src="<?= base_url('assets/img/obat/') . $o['gambar']; ?>">
                <h5><?//= $o['nama_obat'];?></h5>
                <p><?//= $o['jenis_obat'];?></p>
                </center>
                <div class="row mx-auto">
                    <div class="col-4">
                        <h6>Kode Produk</h6>
                    </div>
                    <div class="col-8">
                        <p><?= $o['idProduk'];?></p>
                    </div>
                </div>
                <div class="row mx-auto">
                    <div class="col-4">
                        <h6>Nama Produk</h6>
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
                        <h6>Warna</h6>
                    </div>
                    <div class="col-8">
                        <p><?= $o['warna'];?></p>
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
                <div class="row mx-auto">
                    <div class="col-4">
                        <h6>gambar</h6>
                    </div>
                    <div class="col-8">
                        <p><?= $o['gambar'];?></p>
                    </div>
                </div>
                <div class="row mx-auto">
                    <div class="col-4">
                        <h6>deskripsi</h6>
                    </div>
                    <div class="col-8">
                        <p><?= $o['deskripsi'];?></p>
                    </div>
                </div>
                <div class="row mx-auto">
                    <div class="col-4">
                        <h6>Status</h6>
                    </div>
                    <div class="col-8">
                        <?php if ($o['status'] == 1) :?>
                            <p>Tersedia</p>
                        <?php else : ?>
                            <p>Tidak Tersedia</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
<?php endforeach; ?>


