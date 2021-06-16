<!-- KONTEN -->
	<div class="container h-100">
		<div class="row h-100 justify-content-center align-items-center">
			<div class="col-10 col-md-8 col-lg-5">
				<div class="card o-hidden border-0 shadow-lg" >
					<div class="card-body">
						<div class="text-center">
							<h1 class="h4 text-gray-900 mb-4">Unique Code</h1>
						</div>
						
						<?= $this->session->flashdata('message'); ?>

						<form action="login" method="post">
							<div class="form-group">
								<label for="uniqueCode">Unique Code</label>
								<input type="text" class="form-control" id="uniqueCode" name="uniqueCode" value="<?= set_value('uniqueCode'); ?>">
								<?= form_error('uniqueCode', '<small class="form-text text-danger">', '</small>'); ?>
							</div>
							<div class="form-group">
								<button type="submit" class="btn form-control mt-2" style="background-color: #B47169;">Login</button>
							</div>
							<hr>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>

<!-- AKHIR KONTEN -->

</html>
