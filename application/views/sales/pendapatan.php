<div class="col pt-3 mb-4">
	<div class="container mt-5">
		<h2>Pendapatan Sales</h2>
		<!-- MULAI KONTEN DISINI -->

		<?= $this->session->flashdata('message'); ?>

		<div class="mt-4 row">
            <form action="<?= base_url('sales/pendapatansales'); ?>" method="post" class="col-4 justify-content-end">
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
						<th scope="col">Nama Produk</th>
						<th scope="col">Jumlah pendapatan sales</th>
                        <th scope="col">Status</th>
						<th scope="col" colspan="3">Action</th>
					</tr>
				</thead>
				<tbody>
                    <?php if ( empty($pendapatanpagination) ) :?>
                        <tr>
                            <td colspan="6">
                                <div class="alert alert-danger" role="alert">
                                    Data tidak ditemukan.
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
					<?php foreach ($pendapatanpagination as $u ) :?>
					<tr>
						<form action="">
							<td><?= ++$start ?></td>
							<td><?= $u['nama'] ?></td>
							<td><?= $u['jumlahPendapatan']?></td>
                            <td>
                                <?php if ($u['statuspes'] == 1) {
                                    echo '<h5><span class="badge text-white" style="background: #00b894;">Permohonan diproses</span></h5>';
                                }else{
                                    echo '<h5><span class="badge badge-danger">Belum ada permohonan</span></h5>';
                                }
                                ?>
                            </td>

                            <?php if ($u['statuspes'] == 0) : ?>
                                <?php if ($u['jumlahPendapatan'] != 0) : ?>
                                    <td>
                                        <span data-toggle="tooltip" data-placement="left" title="meminta">
                                            <a href="<?= base_url(); ?>sales/memintapermohonan/<?= $u['idPendapatanS']?>">
                                            <button type="button" class="btn btn-success ml-1">
                                                <i class="fas fa-fw fa-check"></i>
                                            </button>
                                        </span>
                                    </td>
                                <?php endif ;?>
                            <?php endif ;?>
						</form>
					</tr>
					<?php endforeach; ?>
				</tbody>
			</table>

			<?= $this->pagination->create_links(); ?>

		</div>

	</div>

</div>

<!-- MODAL FORM DETAIL pendapatansales -->
