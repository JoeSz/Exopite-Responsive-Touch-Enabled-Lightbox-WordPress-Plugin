<?php

if ( ! isset( $_GET['image'] ) && empty( $_GET['image'] ) ) {
  die('Invalid image url');
}

// get server
function curPageURL() {
  $pageURL = 'http';
  if (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on") {
    $pageURL .= "s";
  }
  $pageURL .= "://";
  if ($_SERVER["SERVER_PORT"] != "80") {
    $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"];
  } else {
    $pageURL .= $_SERVER["SERVER_NAME"];
  }
  return $pageURL;
}

// get file path from url
$file = $_SERVER['DOCUMENT_ROOT'] . str_replace( curPageURL(), '', htmlspecialchars( $_GET['image'] ) );

function download_file( $fullPath ){

  // Must be fresh start
  if( headers_sent() )
    die('Headers already sent.');

  // Required for some browsers
  if( ini_get( 'zlib.output_compression' ) )
    ini_set('zlib.output_compression', 'Off');

  // File Exists?
  if( file_exists($fullPath) ){

    // Parse Info / Get Extension
    $fsize = filesize( $fullPath );
    $path_parts = pathinfo( $fullPath );
    $ext = strtolower( $path_parts["extension"] );

    // Determine Content Type
    switch ($ext) {
      case "gif":
        $ctype="image/gif"; break;
      case "png":
        $ctype="image/png"; break;
      case "jpeg":
        //no break
      case "jpg":
        $ctype="image/jpg"; break;
      default:
        die("Invalid image format.");
    }

    header("Pragma: public"); // required
    header("Expires: 0");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    header("Cache-Control: private",false); // required for certain browsers
    header("Content-Type: $ctype");
    header("Content-Disposition: attachment; filename=\"".basename($fullPath)."\";" );
    header("Content-Transfer-Encoding: binary");
    header("Content-Length: ".$fsize);
    ob_clean();
    flush();
    readfile( $fullPath );

  } else {
    die('Image not found.');
  }
}

if( file_exists($file) ) {
  download_file($file);
} else {
  if (strpos($file, '/') !== FALSE) {
    $file = str_replace( '/', '\\', $file);
    download_file( $file );
  } else {
    die('Image not found.');
  }
}

?>

