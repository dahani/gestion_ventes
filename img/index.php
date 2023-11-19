<?php

error_reporting(0);
require_once '../vendor/autoload.php';
use Spatie\Image\Image;

$default=isset($_GET['df'])?$_GET['df']:'default.png';$url=strip_tags($_GET['url']);
header('Content-type: image/webp');
//header("Cache-Control: max-age=2592000");
//header("Last-Modified: " . gmdate("D, d M Y H:i:s",time()-2592000) . " GMT");
$tmp="tmp.webp";
if(isset($_GET['w'],$_GET['h'],$_GET['url'])){
	$w=(int)$_GET['w'];$h=(int)$_GET['h'];
	try {
		
		$op1=Image::load($url)->fit("stretch",$w,$h)->quality(60)->optimize()->save($tmp);
		readfile($tmp);
		unlink($tmp);
} catch(Exception $err) {
  $op1=Image::load($default)->fit("stretch",$w,$h)->quality(60)->optimize()->save($tmp);
		readfile($tmp);
		unlink($tmp);
}
}else{
	try {
 $op1=Image::load($default)->quality(60)->optimize()->save($tmp);
readfile($tmp);
unlink($tmp);
} catch(Exception $err){}
}





