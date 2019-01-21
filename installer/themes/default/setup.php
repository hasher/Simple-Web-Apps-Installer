<?php
	require ('./themes/' . _THEME_ . '/locales/' . locales() . '.lang.php');
	$licence = file_get_contents('./licences/' . locales() . '.txt');
	$title = $setup['title'] ; 
	ob_start(); 
?>
	
	<!-- Begin page content -->
	<div class="container">

			<div class="page-header">
				<div class="text-center">
					<img style="width: 120px;" src="<?= './themes/' . _THEME_ . _APPLOGO_ ?>" >
				</div>
				<h1 class="text-center"><?= strtoupper($title) ?></h1>
			</div>

			<p class="lead">

			</p>

			<div class="container text-justify">
				<br>
				<p>
					<?= $setup['explanation'] ?>
				</p>
				<br><br>
			</div>


			<div class="panel panel-default">

				<div class="panel-heading">
					<h3 class="panel-title text-center"><?= strtoupper($setup['panel-title']) ?></h3>
				</div>

				<div class="panel-body">

					<form method="post">

						<div class="form-group">
							<label for="host"><?= $setup['host'] ?> <span class="text-danger">( <?= $setup['required'] ?> )</span></label>
							<input type="text" id="host" name="host" required class="form-control">
						</div>

						<div class="form-group">
							<label for="user"><?= $setup['user'] ?> <span class="text-danger">( <?= $setup['required'] ?> )</span></label>
							<input type="text" id="user" name="user" required class="form-control">
						</div>

						<div class="form-group">
							<label for="password"><?= $setup['password'] ?></label>
							<input type="text" id="password" name="password" class="form-control">
						</div>

						<div class="form-group">
							<label for="name"><?= $setup['name'] ?> <span class="text-danger">( <?= $setup['required'] ?> )</span></label>
							<input type="text" id="name" name="name" required class="form-control">
						</div>

						<div class="form-group text-center">
							<button type="submit" class="btn btn-primary" name="submit"><?= $setup['submit'] ?></button>
						</div>			

					</form>

				</div>

			</div>


    </div>

<?php $content = ob_get_clean(); ?>
<?php require ('templates/default.tmpl.php'); ?>