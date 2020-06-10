<?php
$cv = $_GET['nombre'];

$content = file_get_contents($cv);
header('Content-Type: application/pdf');
header('Content-Length: '.strlen( $content ));
header('Content-disposition: inline; filename="' . $cv . '"');
header('Cache-Control: public, must-revalidate, max-age=0');
header('Pragma: public');
header('Expires: Sat, 26 Jul 1997 05:00:00 GMT');
header('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT');
echo $content;
?>