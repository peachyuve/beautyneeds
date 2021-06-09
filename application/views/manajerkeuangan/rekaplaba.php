<div class="col pt-3 mb-4">
  <div class="container mt-5">
    <h2>Download Data</h2>
    <!-- MULAI KONTEN DISINI -->
    <body>
    <?= form_open_multipart('manajerkeuangan/rekaplaba');?>
    
        <div class="col-md-7 mt-3">

          <div class="form-group row">
            <label for="tgl_awal" class="col-sm-3 col-form-label">Tanggal Awal</label>
            <div class="col-sm-9">
              <input type="date" class="form-control" id="tgl_lahir" name="tgl_awal"
                        value="<?= set_value('tgl_awal'); ?>">
              <?= form_error('tgl_awal', '<small class="form-text text-danger">', '</small>'); ?>
            </div>
          </div>

          <div class="form-group row">
            <label for="tgl_akhir" class="col-sm-3 col-form-label">Tanggal Akhir</label>
            <div class="col-sm-9">
              <input type="date" class="form-control" id="tgl_akhir" name="tgl_akhir"
                        value="<?= set_value('tgl_akhir'); ?>">
              <?= form_error('tgl_akhir', '<small class="form-text text-danger">', '</small>'); ?>
            </div>
          </div>

          <div class="form-group row justify-content-end">
            <a type="button" href="<?= base_url('manajerkeuangan/laba'); ?>" class="btn btn-secondary form-control mt-2 col-sm-2 mx-1">Batal</a>
            <button  type="submit" class="btn btn-success form-control mt-2 col-sm-2 mx-1" >Cari</button>
          </div>

          <?php if ( empty($labapagination) == FALSE ) :?>
            <div class="mt-4 table-responsive-lg">
                          
              <center>
               <input type="hidden" id="export2" name="custId" value="3487">
                <a  href="<?= base_url(); ?>manajerkeuangan/rekaplaba2/<?= $tgl_awal?>/<?= $tgl_akhir?>">EXPORT KE EXCEL</a>
              </center>
              <a> Tanggal Awal : <?= $tgl_awal ?></a>
              <br/>
              <a> Tanggal Akhir : <?= $tgl_akhir ?></a>
              <table class="table table-hover">
                <thead>
                  <tr>
                    <th scope="col"></th>
                    <th scope="col">Nama Produk</th>
                    <th scope="col">Nama Sales</th>
                    <th scope="col">Tanggal Laba</th>
                    <th scope="col">Jumlah Laba</th>
                  </tr>
                </thead>
                <tbody>
                    <?php foreach ($labapagination as $u ) :?>
                        <tr>
                          <form action="">
                            <td><?= ++$start ?></td>
                            <td><?= $u['nama'] ?></td>
                            <td><?= $u['nama_user']?></td>
                            <td><?= $u['tgl_laba']?></td>
                            <td><?= $u['jumlahLaba']?></td>
                          </form>
                      </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <?= $this->pagination->create_links(); ?>
          </div>
        <?php else : ?>
          <tr>
            <td colspan="6">
                <div class="alert alert-danger" role="alert">
                    Data tidak ditemukan.
                </div>
            </td>
        </tr>
        <?php endif; ?>

      </div>
    </body>
  </div>
</div>








