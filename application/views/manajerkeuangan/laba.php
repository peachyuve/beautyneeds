<div class="col pt-3 mb-4">
	<div class="container mt-5">
		<h2>Laba</h2>
		<!-- MULAI KONTEN DISINI -->

		<?= $this->session->flashdata('message'); ?>

		<div class="mt-4 row">
            <div class="col justify-content-start">
                <a href="<?= base_url(); ?>manajerkeuangan/rekaplaba">
                    <button class="btn btn-success">
                        <i class="fas fa-fw fa-plus mr-2"></i>Rekap Laba
                    </button>
                </a>
                <a href="<?= base_url(); ?>manajerkeuangan/tambahlaba">
                    <button class="btn btn-success">
                        <i class="fas fa-fw fa-plus mr-2"></i>Tambah Laba
                    </button>
                </a>
            </div>
            <form action="<?= base_url('manajerkeuangan/laba'); ?>" method="post" class="col-4 justify-content-end">
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
						<th scope="col">Nama Sales</th>
						<th scope="col">Jumlah Laba</th>
						<th scope="col" colspan="3">Action</th>
					</tr>
				</thead>
				<tbody>
                    <?php if ( empty($labapagination) ) :?>
                        <tr>
                            <td colspan="6">
                                <div class="alert alert-danger" role="alert">
                                    Data tidak ditemukan.
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
					<?php foreach ($labapagination as $u ) :?>
					<tr>
						<form action="">
							<td><?= ++$start ?></td>
							<td><?= $u['nama'] ?></td>
							<td><?= $u['nama_user']?></td>
							<td><?= $u['jumlahLaba']?></td>


                            <td width="1">
                                <span data-toggle="tooltip" data-placement="left" title="Hapus">
                                    <a href="<?= base_url(); ?>manajerkeuangan/hapuslaba/<?= $u['idLaba']?>">
                                    <button type="button" class="btn btn-danger ml-1">
                                        <i class="fas fa-fw fa-times"></i>
                                    </button>
                                </span>
                            </td>
						</form>
					</tr>
					<?php endforeach; ?>
				</tbody>
			</table>

			<?= $this->pagination->create_links(); ?>

		</div>

	</div>

</div>

<!-- MODAL FORM DETAIL laba -->
<div class="modal fade" id="daterekaplaba" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4>Tanggal</h4>
            </div>
            <div class="modal-body my-auto">
                <div class="input-group">
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary">
                            <i class="fas fa-calendar-alt"></i>
                        </button>
                    </div>
                    <input type="text" method="post" name="datefilter" autocomplete="off" autofocus
                    value="<?= set_value('date'); ?>">
                </div>
            </div>
            <div class="modal-footer">
                <a href="<?= base_url(); ?>manajerkeuangan/rekaplaba">
                    <button class="btn btn-success">Search</button>
                </a>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>

    </div>
</div>


<script>
$(function() {
  $('input[name="datefilter"]').daterangepicker({
      autoUpdateInput: false,
      locale: {
          cancelLabel: 'Clear'
      }
  });
  $('input[name="datefilter"]').on('apply.daterangepicker', function(ev, picker) {
      $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
  });

  $('input[name="datefilter"]').on('cancel.daterangepicker', function(ev, picker) {
      $(this).val('');
  });
});
</script>