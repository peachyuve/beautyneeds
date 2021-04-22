<nav class="navbar fixed-top navbar-expand-lg navbar-light bg-light shadow-sm">

	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target=".collapse">
		<span class="navbar-toggler-icon"></span>
	</button>
	<a class="navbar-brand" href="<?= base_url(''); ?>"><i class="fas fa-fas fa-store mr-3"></i><?= $appname; ?></a>

	<div class="collapse navbar-collapse">
		<ul class="navbar-nav mr-auto">
			
			<?php if ($title == 'Home') :?>
				<li class="nav-item active">
			<?php else : ?>
				<li class="nav-item">
			<?php endif; ?>
				<a class="nav-link" href="<?= base_url(''); ?>">Home <span class="sr-only">(current)</span></a>
			</li>

			<?php if ($title == 'Daftar Produk') :?>
				<li class="nav-item active">
			<?php else : ?>
				<li class="nav-item">
			<?php endif; ?>
				<a class="nav-link" href="<?= base_url('pembeli/produk'); ?>">Produk</a>
			</li>

			<?php if ($title == 'Kontak Kami') :?>
				<li class="nav-item active">
			<?php else : ?>
				<li class="nav-item">
			<?php endif; ?>
				<a class="nav-link" href="<?= base_url('pembeli/kontak'); ?>">Kontak</a>
			</li>
			
			<?php if ($this->session->has_userdata('username')) : ?>
				<?php if ($title == 'Riwayat Pemesanan') :?>
					<li class="nav-item active">
				<?php else : ?>
					<li class="nav-item">
				<?php endif; ?>
					<a class="nav-link" href="<?= base_url('pembeli/riwayatPemesanan'); ?>">Riwayat Pemesanan</a>
				</li>
			<?php endif; ?>

		</ul>
		<ul class="navbar-nav navbar-right mt-2 mt-lg-0">
			<li class="nav-item active mr-4">
				<a class="nav-link align-self-center" href="<?= base_url('pemesanan/keranjang'); ?>">
					<button type="button" class="btn btn-outline-dark">
						<i class="fas fa-shopping-cart fa-lg mr-2"></i>
						<span class="badge badge-danger"><?= $this->cart->total_items();?></span>
					</button>
				</a>
			</li>

			<?php if ( $this->session->userdata('username') ) : ?>
				<li class="nav-item dropdown active">
					<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown">
						<?= $user['nama']; ?></span>
						<img class="rounded-circle mx-2 bg-light" height="35px" width="35px"
							src="<?= base_url('assets/img/profile/') . $user['foto']; ?>">
					</a>
					<div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
						<a class="dropdown-item" href="<?= base_url('customer/profile'); ?>">Profil Saya</a>
						<div class="dropdown-divider"></div>
						<a class="dropdown-item" href="<?= base_url('auth/logout'); ?>">Logout</a>
					</div>
				</li>
			<?php else : ?>
				<a href="<?= base_url('user'); ?>"><button class="btn btn-outline-dark my-2 mr-2">Login</button></a>
				<a href="<?= base_url('user/register'); ?>"><button class="btn btn-outline-dark my-2">Daftar</button></a>
			<?php endif; ?>
		</ul>
	</div>

</nav>

<!-- <div class="container-fluid px-0 pt-0 h-100"> -->
	<!-- <div class="row min-vh-100 collapse show no-gutters d-flex h-100 position-relative"> -->
		
