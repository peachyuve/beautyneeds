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
						<!--<?= $nama['nama']; ?></span>-->

					</a>
					<div class="dropdown-menu dropdown-menu-right" aria-labelledby="">
						<div class="dropdown-divider"></div>
						<a href="<?= base_url('user/logout'); ?>"class="dropdown-item" >Logout</a>
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
				<h6>Sales</h6>
			</div>

			<?php if ($title == 'Dashboard') :?>
			<li class="active">
				<?php else : ?>
			<li>
				<?php endif; ?>
				<a class="nav-link" href="<?= base_url('sales'); ?>">
					<i ></i>Dashboard</a>
			</li>

			<?php if ($title == 'Produk') :?>
			<li class="active">
				<?php else : ?>
			<li>
				<?php endif; ?>
				<a class="nav-link" href="<?= base_url('sales/produk'); ?>">
					<i></i>Produk</a>
			</li>
			<?php if ($title == 'Pendapatan') :?>
			<li class="active">
				<?php else : ?>
			<li>
				<?php endif; ?>
				<a class="nav-link" href="<?= base_url('sales/pendapatan'); ?>">
					<i></i>Pendapatan</a>
			</li>
		</ul>
	</nav>

	<!-- Page Content  -->
	<div id="content">
