<div class="col pt-3 mb-4">
	<div class="container mt-5">
		<h2>Dashboard</h2>
		<!-- MULAI KONTEN DISINI -->
		<div class="row mt-2 ml-1 justify-content-between">
            <div class="card text-white mb-3" style="background: #00b894;width: 15rem; border: none;" >
				<div class="card-header h5">Jumlah Produk</div>
				<div class="card-body row">
					<div class="col">
						<h1 class="card-title"><?= $jml_produk; ?></h1>
					</div>
					<div class="col">
						<!--<i class="fas fa-fw fa-pills fa-4x"></i>-->
					</div>
				</div>
			</div>
			<div class="card text-white mb-3" style="background: #0abde3;width: 15rem; border: none;" >
				<div class="card-header h5">Jumlah Pemesanan</div>
				<div class="card-body row">
					<div class="col">
						<h1 class="card-title"><?= $jml_pemesanan; ?></h1>
					</div>
					<div class="col">
						<!--<i class="fas fa-fw fa-pills fa-4x"></i>-->
					</div>
				</div>
			</div>
			<div class="card text-white mb-3" style="background: #2e86de;width: 15rem; border: none;" >
				<div class="card-header h5">Jumlah Sales</div>
				<div class="card-body row">
					<div class="col">
						<h1 class="card-title"><?= $jml_userSales; ?></h1>
					</div>
					<div class="col">
						<!--<i class="fas fa-fw fa-pills fa-4x"></i>-->
					</div>
				</div>
			</div>
			<div class="card text-white mb-3" style="background: #ff9f43;width: 15rem; border: none;" >
				<div class="card-header h5">Jumlah Pembeli</div>
				<div class="card-body row">
					<div class="col">
						<h1 class="card-title"><?= $jml_userPembeli; ?></h1>
					</div>
					<div class="col">
						<!--<i class="fas fa-fw fa-pills fa-4x"></i>-->
					</div>
				</div>
			</div>
		</div>
	</div>

</div>