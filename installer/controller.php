<?php



	function allAvailableLang () {

		$allAvailableLang = [];

		$directory = 'themes/' . _THEME_ . '/locales/' ;

		$scanned_directory = array_diff(scandir($directory), array('..', '.'));

		foreach ($scanned_directory as $value) {

			$part = explode('.', $value);

			array_push($allAvailableLang, $part[0]);

		}

		return $allAvailableLang ;

	}


	function locales () {

		if ( isset($_GET['lang']) && !empty($_GET['lang']) ) {

			if ( in_array(cleaner($_GET['lang']) , allAvailableLang()) ) {

				$lang = cleaner($_GET['lang']) ;
				$_SESSION['lang'] = $lang ;

			} else {

				if ( isset($_SESSION['lang']) && !empty($_SESSION['lang']) ) {

					$lang = $_SESSION['lang'] ;

				} else {

					$lang = _LANG_DEFAULT_ ;

				}

			}	

		} else {

			if ( isset($_SESSION['lang']) && !empty($_SESSION['lang']) ) {

				$lang = $_SESSION['lang'] ;

			} else {

				$lang = _LANG_DEFAULT_ ;

			}	

		}

		return $lang;
		
	}


	function cleaner ($string) {	

		$string = trim($string); 		
		$string = stripslashes($string);
		$string = strip_tags($string); 
		$string = htmlspecialchars($string);
		return $string;

	}





	class installer {

		public function _init () {

			$_SESSION['step'] = 'init' ;

			if ( isset($_POST['submit']) ) {

				if ( !empty($_POST['accept']) && $_POST['accept'] == 'on' ) {

					$_SESSION['step'] = 'setup' ;
					
					header('Location: index.php');

				} else {

					$_SESSION['step'] = 'init' ;
					throw new Exception("Error : Accept first the licence condition");

				}

			}

			require ( './themes/' . _THEME_ . '/init.php');
			
		}

		public function _setup () {
			
			if ( $_SESSION['step'] = 'setup' ) {

				if ( isset($_POST['submit']) ) {

					if ( !empty($_POST['host']) && !empty($_POST['user']) && !empty($_POST['name']) ) {

						extract($_POST);
						
						$db = new PDO( 'mysql:host=' . cleaner($host), cleaner($user), cleaner($password) );
						$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

						$name = cleaner($name);
						$q = $db->prepare("CREATE DATABASE `$name`;");
						$q->execute();
						$count = $q->rowCount();
						$q->closeCursor();

						if ( !$count ) {

							$_SESSION['setup'] = false ;
							throw new Exception("Error : Unable to create the database.");

						}

						$_SESSION['step'] = 'endl' ;
						$_SESSION['setup'] = true ;
						
						$_SESSION['host'] = cleaner($host);
						$_SESSION['user'] = cleaner($user);
						$_SESSION['password'] = cleaner($password);
						$_SESSION['name'] = cleaner($name);

						header('Location: index.php');

					} else {

						throw new Exception("Error : Some field is empty.");

					}
					
				}

				require ( './themes/' . _THEME_ . '/setup.php');

			}

		}

		public function _endl () {

			if ( $_SESSION['step'] = 'endl' && $_SESSION['setup'] ) {

				$query = file_get_contents('query.sql');

				$db = new PDO( 'mysql:host=' . $_SESSION['host'] .'; dbname='. $_SESSION['name'], $_SESSION['user'], $_SESSION['password'] );
				$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

				$q = $db->prepare($query);
				$q->execute();
				$q->closeCursor();

				$unzipper = new Unzipper;

				$unzipper->localdir = './../' ;
				$archive = 'script.zip';
				$destination = '.';
				$unzipper->prepareExtraction($archive, $destination);

				$file = fopen("installed.inc", "w");

				$_SESSION['step'] = 'over' ;

				// delete the install file

			} else {

				header('Location: index.php');

			}

			require ( './themes/' . _THEME_ . '/endl.php');

		}

	}





	/**
	 * The Unzipper extracts .zip or .rar archives and .gz files on webservers.
	 *
	 * @author  Andreas Tasch, at[tec], attec.at
	 * @license GNU GPL v3
	 * @package attec.toolbox
	 * @version 0.1.1
	 */

	class Unzipper {
	  public $localdir = '.';
	  public $zipfiles = array();

	  public function __construct() {
	    // Read directory and pick .zip, .rar and .gz files.
	    if ($dh = opendir($this->localdir)) {
	      while (($file = readdir($dh)) !== FALSE) {
	        if (pathinfo($file, PATHINFO_EXTENSION) === 'zip'
	          || pathinfo($file, PATHINFO_EXTENSION) === 'gz'
	          || pathinfo($file, PATHINFO_EXTENSION) === 'rar'
	        ) {
	          $this->zipfiles[] = $file;
	        }
	      }
	      closedir($dh);

	      if (!empty($this->zipfiles)) {
	        $GLOBALS['status'] = array('info' => '.zip or .gz or .rar files found, ready for extraction');
	      }
	      else {
	        $GLOBALS['status'] = array('info' => 'No .zip or .gz or rar files found. So only zipping functionality available.');
	      }
	    }
	  }

	  /**
	   * Prepare and check zipfile for extraction.
	   *
	   * @param string $archive
	   *   The archive name including file extension. E.g. my_archive.zip.
	   * @param string $destination
	   *   The relative destination path where to extract files.
	   */
	  public function prepareExtraction($archive, $destination = '') {
	    // Determine paths.
	    if (empty($destination)) {
	      $extpath = $this->localdir;
	    }
	    else {
	      $extpath = $this->localdir . '/' . $destination;
	      // Todo: move this to extraction function.
	      if (!is_dir($extpath)) {
	        mkdir($extpath);
	      }
	    }
	    // Only local existing archives are allowed to be extracted.
	    if (in_array($archive, $this->zipfiles)) {
	      self::extract($archive, $extpath);
	    }
	  }

	  /**
	   * Checks file extension and calls suitable extractor functions.
	   *
	   * @param string $archive
	   *   The archive name including file extension. E.g. my_archive.zip.
	   * @param string $destination
	   *   The relative destination path where to extract files.
	   */
	  public static function extract($archive, $destination) {
	    $ext = pathinfo($archive, PATHINFO_EXTENSION);
	    switch ($ext) {
	      case 'zip':
	        self::extractZipArchive($archive, $destination);
	        break;
	      case 'gz':
	        self::extractGzipFile($archive, $destination);
	        break;
	      case 'rar':
	        self::extractRarArchive($archive, $destination);
	        break;
	    }

	  }

	  /**
	   * Decompress/extract a zip archive using ZipArchive.
	   *
	   * @param $archive
	   * @param $destination
	   */
	  public static function extractZipArchive($archive, $destination) {
	    // Check if webserver supports unzipping.
	    if (!class_exists('ZipArchive')) {
	      $GLOBALS['status'] = array('error' => 'Error: Your PHP version does not support unzip functionality.');
	      return;
	    }

	    $zip = new ZipArchive;

	    // Check if archive is readable.
	    if ($zip->open($archive) === TRUE) {
	      // Check if destination is writable
	      if (is_writeable($destination . '/')) {
	        $zip->extractTo($destination);
	        $zip->close();
	        $GLOBALS['status'] = array('success' => 'Files unzipped successfully');
	      }
	      else {
	        $GLOBALS['status'] = array('error' => 'Error: Directory not writeable by webserver.');
	      }
	    }
	    else {
	      $GLOBALS['status'] = array('error' => 'Error: Cannot read .zip archive.');
	    }
	  }

	  /**
	   * Decompress a .gz File.
	   *
	   * @param string $archive
	   *   The archive name including file extension. E.g. my_archive.zip.
	   * @param string $destination
	   *   The relative destination path where to extract files.
	   */
	  public static function extractGzipFile($archive, $destination) {
	    // Check if zlib is enabled
	    if (!function_exists('gzopen')) {
	      $GLOBALS['status'] = array('error' => 'Error: Your PHP has no zlib support enabled.');
	      return;
	    }

	    $filename = pathinfo($archive, PATHINFO_FILENAME);
	    $gzipped = gzopen($archive, "rb");
	    $file = fopen($destination . '/' . $filename, "w");

	    while ($string = gzread($gzipped, 4096)) {
	      fwrite($file, $string, strlen($string));
	    }
	    gzclose($gzipped);
	    fclose($file);

	    // Check if file was extracted.
	    if (file_exists($destination . '/' . $filename)) {
	      $GLOBALS['status'] = array('success' => 'File unzipped successfully.');

	      // If we had a tar.gz file, let's extract that tar file.
	      if (pathinfo($destination . '/' . $filename, PATHINFO_EXTENSION) == 'tar') {
	        $phar = new PharData($destination . '/' . $filename);
	        if ($phar->extractTo($destination)) {
	          $GLOBALS['status'] = array('success' => 'Extracted tar.gz archive successfully.');
	          // Delete .tar.
	          unlink($destination . '/' . $filename);
	        }
	      }
	    }
	    else {
	      $GLOBALS['status'] = array('error' => 'Error unzipping file.');
	    }

	  }

	  /**
	   * Decompress/extract a Rar archive using RarArchive.
	   *
	   * @param string $archive
	   *   The archive name including file extension. E.g. my_archive.zip.
	   * @param string $destination
	   *   The relative destination path where to extract files.
	   */
	  public static function extractRarArchive($archive, $destination) {
	    // Check if webserver supports unzipping.
	    if (!class_exists('RarArchive')) {
	      $GLOBALS['status'] = array('error' => 'Error: Your PHP version does not support .rar archive functionality. <a class="info" href="http://php.net/manual/en/rar.installation.php" target="_blank">How to install RarArchive</a>');
	      return;
	    }
	    // Check if archive is readable.
	    if ($rar = RarArchive::open($archive)) {
	      // Check if destination is writable
	      if (is_writeable($destination . '/')) {
	        $entries = $rar->getEntries();
	        foreach ($entries as $entry) {
	          $entry->extract($destination);
	        }
	        $rar->close();
	        $GLOBALS['status'] = array('success' => 'Files extracted successfully.');
	      }
	      else {
	        $GLOBALS['status'] = array('error' => 'Error: Directory not writeable by webserver.');
	      }
	    }
	    else {
	      $GLOBALS['status'] = array('error' => 'Error: Cannot read .rar archive.');
	    }
	  }

	}
