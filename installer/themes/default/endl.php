<?php
	$page = _REDIRECT_;
	$sec = "10";
	header("Refresh: $sec; url=$page");
	
	require ('./themes/' . _THEME_ . '/locales/' . locales() . '.lang.php');
	$licence = file_get_contents('./licences/' . locales() . '.txt');
	$title = $endl['title'] ; 
	ob_start(); 
?>
	


	<!-- Begin page content -->
	<div class="container">

		<div class="page-header">
			<div class="text-center">
				<img style="width: 120px;" src="<?= './themes/' . _THEME_ . _APPLOGO_ ?>" >
			</div>
			<h1 class="text-center"><?= $title ?></h1>
		</div>

		<p class="lead">
			<?= $endl['text'] ?>
		</p>

		<div class="panel panel-default">

			<div class="panel-body">

				<a href="<?= _REDIRECT_ ?>" class="text-center"><?= $endl['redirect'] ?></a>

			</div>

		</div>




    </div>



<?php $content = ob_get_clean(); ?>
<?php require ('templates/default.tmpl.php'); ?>