<?php
// Set the content-type
header('Content-type: image/png');

// Create the image
//$im = imagecreatetruecolor(360, 100);
$im = imagecreatetruecolor(300, 100);

// Create some colors
//$white = imagecolorallocate($im, 255, 255, 255);
$white = imagecolorallocate($im, 255, 255, 255);
//$grey = imagecolorallocate($im, 128, 128, 128);
$black = imagecolorallocate($im, 0, 0, 0);
//imagefilledrectangle($im, 0, 0, 360, 100, $white);
imagefilledrectangle($im, 3, 0, 300, 100, $white);
// The text to draw

$text = $_GET["id"];
//$text = "*3P00020*";

// Replace path by your own font path
$font = 'font/bar.ttf';

// Add some shadow to the text
///imagettftext($im, 20, 0, 0, 60, $grey, $font, $text);

// Add the text

//imagettftext($im, 25, 0, 0, 70, $black, $font, $text);
imagettftext($im, 20, 0, 0, 80, $black, $font, $text);
// Using imagepng() results in clearer text compared with imagejpeg()
imagepng($im);
imagedestroy($im);
?>

