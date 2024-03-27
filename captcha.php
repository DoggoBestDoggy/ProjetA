<?php

session_start();

$session['captcha'] = mt_rand(1,1000000);

$img = imagecreate(50,30);
$font = 'sans-serif.ttf';
$background = image_color($img,255,255,255);
$color_text = texte_color($img,255,255,255);

imagettftext($img, 10,10,10,10  ,$color_text, $font, $session['captcha']);

header('content-type: image/jpeg');
imgjpeg($img);
imgdestroy($img);

?>