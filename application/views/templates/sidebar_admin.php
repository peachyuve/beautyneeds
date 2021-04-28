<div class="wrapper">
	<nav class="navbar fixed-top navbar-expand-lg navbar-dark" style="background: #2f3542;">

		<a class="navbar-brand" href="#"><i ></i><?= $appname; ?></a>
		<button type="button" id="sidebarCollapse" class="btn text-white">
			<i class="fas fa-bars fa-lg"></i>
		</button>
		<div class="collapse navbar-collapse">
			<ul class="navbar-nav ml-auto mt-2 mt-lg-0">
				<li class="nav-item dropdown active">
					<a class="nav-link dropdown-toggle" href="" id="" role="button" data-toggle="dropdown"
						style="background: #2f3542;">
						<?= $user['nama']; ?></span>
						<img class="rounded-circle mx-2 bg-light" style="object-fit: cover;" height="35px" width="35px"
							src="<?= base_url('assets/img/profile/') . $user['foto']; ?>">
					</a>
					<div class="dropdown-menu dropdown-menu-right" aria-labelledby="">
						<div class="dropdown-divider"></div>
						<a class="dropdown-item" href="<?= base_url('karyawan/logout'); ?>">Logout</a>
					</div>
				</li>
			</ul>
		</div>

		<div class="collapse navbar-collapse">
			<ul class="navbar-nav ml-auto mt-2 mt-lg-0">
				<li class="nav-item dropdown active">
					<a class="nav-link dropdown-toggle" href="" id="" role="button" data-toggle="dropdown"
						style="background: #2f3542;">
						<!--<?= $nama['nama']; ?></span>-->

					</a>
					<div class="dropdown-menu dropdown-menu-right" aria-labelledby="">
						<a class="dropdown-item" >Profil Saya</a>
						<div class="dropdown-divider"></div>
						<a href="<?= base_url('karyawan/logout'); ?>"class="dropdown-item" >Logout</a>
					</div>
				</li>
			</ul>
		</div>

	</nav>
	<!-- Sidebar  -->
	<nav id="sidebar">
		<!-- <div class="sidebar-header">
                <h3>Bootstrap Sidebar</h3>
            </div> -->

		<ul class="list-unstyled components mt-5">
			<div class="mt-4 my-3 ml-3">
				<h6>Admin</h6>
			</div>

			<?php if ($title == 'Dashboard') :?>
			<li class="active">
				<?php else : ?>
			<li>
				<?php endif; ?>
				<a class="nav-link" href="<?= base_url('admin'); ?>">
					<i ></i>Dashboard</a>
			</li>

			<?php if ($title == 'User') :?>
			<li class="active">
				<?php else : ?>
			<li class="nav-item dropdown">
				<?php endif; ?>
				<li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        User
                    </a>
                    <div class="dropdown-menu dashboard-dropdown" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="<?= base_url('admin/userpembeli'); ?>">Pembeli</a>
                        <a class="dropdown-item" href="<?= base_url('admin/usersales') ?>">Sales</a>
                    </div>
                </li>
			</li>


			<?php if ($title == 'Kelola Produk') :?>
			<li class="active">
				<?php else : ?>
			<li>
				<?php endif; ?>
				<a class="nav-link" href="<?= base_url('admin/produk'); ?>">
					<i></i>Produk</a>
			</li>
			<?php if ($title == 'Pemesanan Produk') :?>
			<li class="active">
				<?php else : ?>
			<li>
				<?php endif; ?>
				<a class="nav-link" href="<?= base_url('admin/pemesanan'); ?>">
					<i></i>Pemesanan</a>
			</li>
		</ul>
	</nav>

	<!-- Page Content  -->
	<div id="content">
