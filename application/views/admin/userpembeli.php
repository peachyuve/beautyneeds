<div class="col pt-3 mb-4">
	<div class="container mt-5">
		<h2>User Pembeli</h2>
		<!-- MULAI KONTEN DISINI -->

		<?= $this->session->flashdata('message'); ?>

		<div class="mt-4 row">
            <div class="col justify-content-start">
                <a href="<?= base_url(); ?>karyawan/tambahuserpembeli">
                    <button class="btn btn-success">
                        <i class="fas fa-fw fa-user-plus mr-2"></i>Tambah User
                    </button>
                </a>
            </div>
            <form action="<?= base_url('karyawan/userpembeli'); ?>" method="post" class="col-4 justify-content-end">
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
						<th scope="col">Username</th>
						<th scope="col">Email</th>
						<th scope="col">Nama</th>
						<th scope="col" colspan="3">Action</th>
					</tr>
				</thead>
				<tbody>
                    <?php if ( empty($userpagination) ) :?>
                        <tr>
                            <td colspan="6">
                                <div class="alert alert-danger" role="alert">
                                    Data tidak ditemukan.
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
					<?php foreach ($userpagination as $u ) :?>
					<tr>
						<form action="">
							<td><?= ++$start ?></td>
							<td><?= $u['username'] ?></td>
							<td><?= $u['email']?></td>
							<td><?= $u['nama']?></td>

							<td width="1">
                                <span data-toggle="tooltip" data-placement="left" title="Detail">
                                    <button type="button" class="btn btn-primary" data-toggle="modal"
                                        data-target="#detail<?= $u['idUser']?>">
                                        <i class="fas fa-fw fa-info"></i>
                                    </button>
                                </span>
                            </td>
                            <td width="1">
                                <span data-toggle="tooltip" data-placement="left" title="Edit">
                                    <a href="<?= base_url(); ?>karyawan/edituserpembeli/<?= $u['idUser']?>">
                                    <button type="button" class="btn btn-warning ml-1">
                                        <i class="fas fa-fw fa-user-edit"></i>
                                    </button>
                                </span>
                            </td>
                            <?php if ($u['status'] == 1) : ?>
                                <td width="1">
                                    <span data-toggle="tooltip" data-placement="left" title="Hapus">
                                        <a href="<?= base_url(); ?>karyawan/hapususerpembeli/<?= $u['idUser']?>"
                                            onClick="return confirm('Apakah Anda yakin ingin menghapus user ini?')">
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

<!-- MODAL FORM DETAIL USER -->
<?php $no=1; foreach ($getuser as $u ) :?>
<div class="modal fade" id="detail<?= $u['idUser']; ?>" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<!-- <div class="modal-header">
				<h4>Detail User</h4>
			</div> -->
			<div class="modal-body my-auto">
                <center>
                <img class="rounded-circle mx-2 mb-3 mt-2 bg-light" height="100px" width="100px"
                    src="<?= base_url('assets/img/profile/') . $u['foto']; ?>">
				<h5><?= $u['nama'];?></h5>
                </center>
                <hr>
                <div class="row mx-auto">
                    <div class="col-4">
                        <h6>Email</h6>
                    </div>
                    <div class="col-8">
                        <p><?= $u['email'];?></p>
                    </div>
                </div>
                <div class="row mx-auto">
                    <div class="col-4">
                        <h6>Username</h6>
                    </div>
                    <div class="col-8">
                        <p><?= $u['username'];?></p>
                    </div>
                </div>
                <div class="row mx-auto">
                    <div class="col-4">
                        <h6>Jenis Kelamin</h6>
                    </div>
                    <div class="col-8">
                        <p><?= $u['jenisKelamin'];?></p>
                    </div>
                </div>
                <div class="row mx-auto">
                    <div class="col-4">
                        <h6>Tanggal Lahir</h6>
                    </div>
                    <div class="col-8">
                        <p><?= date("d F Y", strtotime($u['tgl_lahir']));?></p>
                    </div>
                </div>
                <div class="row mx-auto">
                    <div class="col-4">
                        <h6>Alamat</h6>
                    </div>
                    <div class="col-8">
                        <p><?= $u['alamat'];?></p>
                    </div>
                </div>
                <div class="row mx-auto">
                    <div class="col-4">
                        <h6>Telepon</h6>
                    </div>
                    <div class="col-8">
                        <p><?= $u['noHp'];?></p>
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
