<?php


	function deleteDir($dirPath) {
	    if (! is_dir($dirPath)) {
	        throw new InvalidArgumentException("$dirPath must be a directory");
	    }
	    if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
	        $dirPath .= '/';
	    }
	    $files = glob($dirPath . '*', GLOB_MARK);
	    foreach ($files as $file) {
	        if (is_dir($file)) {
	            self::deleteDir($file);
	        } else {
	            unlink($file);
	        }
	    }
	    rmdir($dirPath);
	}



	if ( is_dir('installer') ) {

		deleteDir('installer');

		if ( file_exists($installed) ) {
			
			header('Location: index.html');

		} else {

			header('Location: installer/index.php');

		}

	} else {

		header('Location: index.html');

	}


