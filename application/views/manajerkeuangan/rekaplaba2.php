<div class="col pt-3 mb-4">
  <div class="container mt-5">
    <h2>Rekap Laba</h2>
    <!-- MULAI KONTEN DISINI -->
    <body>


          <?php if ( empty($labapagination) == FALSE ) :?>
            <div class="mt-4 table-responsive-lg">
              <a> Tanggal Awal : <?= $tgl_awal ?></a>
              <br/>
              <a> Tanggal Akhir : <?= $tgl_akhir ?></a>
              <table class="table table-hover">
                <thead>
                  <tr>
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
          <?php
                $filename = "Data Laba " . $tgl_awal . $tgl_akhir . ".xls";
                header("Content-Disposition: attachment; filename=\"$filename\"");
                header("Content-Type: application/vnd.ms-excel");
          ?>
        <?php endif; ?>


      </div>
    </body>
  </div>
</div>






