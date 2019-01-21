<?php

	session_start();

	require ('config.php');
	require ('controller.php');


	try {

		$setup = new installer ; # 3 step , 0 to 2

		if ( isset($_SESSION['step']) ) {

			switch ( $_SESSION['step'] ) {
				case 'init':
					$setup->_init(); # general info
					break;

				case 'setup':
					$setup->_setup(); # get config and test them. if test ok, go next : else : error message
					break;

				case 'endl':
					$setup->_endl(); # all config ok text show
					break;

				case 'over':
					$setup->_endl(); # just show last page
					break;
			}

		} else {

			$_SESSION['step'] = 'init';
			header('Location: index.php');

		}

		if ( isset($_GET['destroy']) ) {

			session_destroy();
			$_SESSION = [];
			//header('Refresh: /');
			
		}

	} catch (Exception $e) {

		/*
			echo "<pre>";
			print_r($_SESSION);
			echo "</pre>";
		 */

		echo "<div style='text-align : center ;' >" ;
		echo $e->getMessage() . "</br>" ;
		echo "</div>";

		
		
	}