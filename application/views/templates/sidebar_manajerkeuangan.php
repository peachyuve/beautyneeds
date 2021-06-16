<div class="wrapper">
	<nav class="navbar fixed-top navbar-expand-lg navbar-dark" style="background: #B47169;">

		<a class="navbar-brand" href="#"><i ></i><?= $appname; ?></a>
		<button type="button" id="sidebarCollapse" class="btn text-white">
			<i class="fas fa-bars fa-lg"></i>
		</button>

		<div class="collapse navbar-collapse">
			<ul class="navbar-nav ml-auto mt-2 mt-lg-0">
				<li class="nav-item dropdown active">
					<a class="nav-link dropdown-toggle" href="" id="" role="button" data-toggle="dropdown"
						style="background: #FFE5DE;">
						<!--<?= $nama['nama']; ?></span>-->

					</a>
					<div class="dropdown-menu dropdown-menu-right" aria-labelledby="">
						<div class="dropdown-divider"></div>
						<a href="<?= base_url('karyawan/logout'); ?>"class="dropdown-item" >Logout</a>
					</div>
				</li>
			</ul>
		</div>

	</nav>
	<!-- Sidebar  -->
	<nav id="sidebar" style="background-color: #B47169;">
		<!-- <div class="sidebar-header">
                <h3>Bootstrap Sidebar</h3>
            </div> -->

		<ul class="list-unstyled components mt-5">
			<div class="mt-4 my-3 ml-3">
				<h6>Manajer Keuangan</h6>
			</div>

			<?php if ($title == 'Dashboard') :?>
			<li class="active">
				<?php else : ?>
			<li>
				<?php endif; ?>
				<a class="nav-link" href="<?= base_url('manajerkeuangan'); ?>">
					<i ></i>Dashboard</a>
			</li>

			<?php if ($title == 'Laba') :?>
			<li class="active">
				<?php else : ?>
			<li>
				<?php endif; ?>
				<a class="nav-link" href="<?= base_url('manajerkeuangan/laba'); ?>">
					<i></i>Laba</a>
			</li>
			<?php if ($title == 'Pendapatan Sales') :?>
			<li class="active">
				<?php else : ?>
			<li>
				<?php endif; ?>
				<a class="nav-link" href="<?= base_url('manajerkeuangan/pendapatansales'); ?>">
					<i></i>Pendapatan Sales</a>
			</li>
		</ul>
	</nav>

	<!-- Page Content  -->
	<div id="content">
