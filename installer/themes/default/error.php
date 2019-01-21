<?php
	require ('./themes/' . _THEME_ . '/locales/' . locales() . '.lang.php');
	$licence = file_get_contents('./licences/' . locales() . '.txt');
	$title = $error['title'] ; 
	ob_start(); 
?>
	


	<!-- Begin page content -->
	<div class="container">

		<div class="page-header">
			<div class="text-center">
				<img style="width: 120px;" src="<?= _BASE_DIR_ . _APPLOGO_ ?>" >
			</div>
			<h1 class="text-center"><?= strtoupper($title) ?></h1>
		</div>

		<p class="lead">

		</p>

		<div class="container text-justify">
			<br>
			<p>
				<?= $step_two['explanation'] ?>
			</p>
			<br><br>
		</div>


		<div class="panel panel-default">

			<div class="panel-heading">
				<h3 class="panel-title text-center">DATABASE SETTINGS</h3>
			</div>

			<div class="panel-body">

				<form method="post">

					<div class="form-group">
						<label for="host"><?= $step_two['host'] ?> <span class="text-danger">( <?= $step_two['required'] ?> )</span></label>
						<input type="text" id="host" name="host" required class="form-control">
					</div>

					<div class="form-group">
						<label for="user"><?= $step_two['user'] ?> <span class="text-danger">( <?= $step_two['required'] ?> )</span></label>
						<input type="text" id="user" name="user" required class="form-control">
					</div>

					<div class="form-group">
						<label for="password"><?= $step_two['password'] ?></label>
						<input type="text" id="password" name="password" class="form-control">
					</div>

					<div class="form-group">
						<label for="name"><?= $step_two['name'] ?> <span class="text-danger">( <?= $step_two['required'] ?> )</span></label>
						<input type="text" id="name" name="name" required class="form-control">
					</div>

					<div class="form-group text-center">
						<button type="submit" class="btn btn-primary" name="submit"><?= $step_two['submit'] ?></button>
					</div>			

				</form>

			</div>

		</div>




    </div>



<?php $content = ob_get_clean(); ?>
<?php require ('templates/default.tmpl.php'); ?>