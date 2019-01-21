<?php
	require ('./themes/' . _THEME_ . '/locales/' . locales() . '.lang.php');
	$licence = file_get_contents('./licences/' . locales() . '.txt');
	$title = $init['title'] ; 
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

		<p>
			<?= $init['text'] ?>
			<br>
		</p>

		<div class="row">
			<div class="col-md-12">

				<form method="post">

					<textarea class="form-control lic"><?= $licence ?></textarea>

					<div class="checkbox text-left">
				      <label>
				        <input type="checkbox" name="accept" class="myCheckbox"> <?= $init['accept'] ?>
				      </label>
				    </div>

					<div class="form-group text-center">
						<button type="submit" class="btn btn-primary" name="submit" value="init"><?= $init['submit'] ?></button>
					</div>

				</form>

			</div>
		</div>

    </div>



<?php $content = ob_get_clean(); ?>
<?php require ('templates/default.tmpl.php'); ?>