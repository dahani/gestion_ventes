<?php 
include_once("php/cn.php");$err="";
$cssfiles=array("css/icomoon/style.css","css/app.min.1.css","css/app.min.2.css");$IMG="img/rbm.png";
if(isSet($_POST['login'])){
	$pass=setPasword($_POST['pass']);$email=strip_tags($_POST['email']);$email=htmlentities($email);$token = md5(rand(1000,9999));
	
		$re=SQL_QUERY("SELECT * FROM `".COMPTE."` WHERE `email`=:email AND  `pass`=:pass",array(":email"=>$email,":pass"=>$pass));
		if($re['test']){
		if(count($re['data'])>0){$line=$re['data'][0];
				if($line['active']==0){
				echo "<html><body style='background-color: #0d14f2;color: white;font-size: 2em;font-weight: bold;'><p style='text-align: center;'>Votre compte est temporairement désactivé.<br> Contactez l'administrateur </p></body></html>";session_destroy();exit;
				}
		$_SESSION[TOKEN] = $token;$_SESSION['type']="admin";
		$_SESSION[KSJZXID]=$line['id'];unset($line['pass']);$_SESSION[OZCUSERCUZSZ]=$line['email'];$_SESSION["data"]=$line;
		$_SESSION[CONFIG]=json_decode($line['config']);$_SESSION[ACCESS]=json_decode($line['menus']);if(isset($_POST['stay'])){setcookie("user",$token,time()+20*24*3600);}else{setcookie("user","",time()-3600);}SQL_UPDATE(COMPTE,array("session_id"=>$token),"id",$line['id']);
		@header("location:./");
		}else{$err= 'Mot de pass incorrect';}
		}else{$err=$re['errors'];}	
	
}else{
	if(isset($_COOKIE['user'])){$token = md5(rand(1000,9999));
		
		$re=SQL_QUERY("SELECT * FROM `".COMPTE."` WHERE `session_id`=:email ",array(":email"=>$_COOKIE['user']));
		if($re['test']){
		if(count($re['data'])>0){$line=$re['data'][0];
				if($line['active']==0){
				echo "<html><body style='background-color: #0d14f2;color: white;font-size: 2em;font-weight: bold;'><p style='text-align: center;'>Votre compte est temporairement désactivé.<br> Contactez l'administrateur </p></body></html>";session_destroy();exit;
				}
		$_SESSION[TOKEN] = $token;$_SESSION['type']="admin";
		$_SESSION[KSJZXID]=$line['id'];unset($line['pass']);$_SESSION[OZCUSERCUZSZ]=$line['email'];$_SESSION["data"]=$line;
		$_SESSION[CONFIG]=json_decode($line['config']);$_SESSION[ACCESS]=json_decode($line['menus']);if(isset($_POST['stay'])){setcookie("user",$token,time()+20*24*3600);}else{setcookie("user","",time()-3600);}SQL_UPDATE(COMPTE,array("session_id"=>$token),"id",$line['id']);
		@header("location:./");
		}else{$err= 'Mot de pass incorrect';}
		}else{$err=$re['errors'];}	
	
	}
}
?>
<!DOCTYPE html><html  lang="fr">
<head>
<html class="login-content" >
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?=GLOBALNAME ?> (AUTHENTIFICATION)</title>
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
<link rel="icon" href="favicon.ico" type="image/x-icon">
<meta name="theme-color" content="#459adb">
<?php foreach($cssfiles as $f){ echo '<link href="'.$f."?v=".VERSION.'" rel="stylesheet">';} ?>
<style>
body.login-content:before{display:none}.login-bottom ul li span{background:url(img/social.png) no-repeat;width:34px;height:34px;display:block}.login-bottom ul li{list-style:none;display:inline-block;vertical-align:middle;margin:3px}.login-bottom ul li span.fb{background-position:0 0}.login-bottom ul li span.twit{background-position:-34px 0}.login-bottom ul li span.google{background-position:-68px 0}
  .lc-block {width: 60%;}.borderx{    border-right: 2px solid #afafaf;}
@media (max-width: 768px){img {width: 250px;}.borderx{border-right:none!important}
.lc-block {width: 95%;}
.zsdz	{    padding-left: 15px!important;padding-right: 15px!important}
.btn-float{bottom: 4px;left: 46.3%;}
}
.box {
    padding: 20px;
    background: #fff;
    margin: 20px auto 60px;
    border-radius: 2px;
}
.css3-shadow, .css3-gradient1, .css3-gradient2 {
    position: relative;
    -webkit-box-shadow: 0 1px 4px rgba(0, 0, 0, 0.3);
    box-shadow: 0 1px 4px rgba(0, 0, 0, 0.3);
}
.css3-shadow:after {
    content: "";
    position: absolute;
    z-index: -2;
    -webkit-box-shadow: 0 0 40px rgba(0,0,0,0.8);
    box-shadow: 0 0 40px rgba(0,0,0,0.8);
    bottom: 0px;
    width: 80%;
    height: 50%;
    -moz-border-radius: 100%;
    border-radius: 28%;
    left: 10%;
    right: 10%;
}
</style>
</head>
<body class="login-content " style="background-color: #dcdcdc;" >
<!-- Login -->
<div class="lc-block toggled p-0 box css3-shadow" id="l-login">
<div class="row"><form action="" method="post">
<div class="col-sm-6 borderx" ><img  src="img/logo.webp"/></div>
<div class="col-sm-6  p-l-0 zsdz" > <input type="hidden" name="type" ng-value="PAGE" />
<div class="card" style="box-shadow: none;margin-bottom: 50px;">
<div class="card-header bgm-cyan text-left">
<h2>AUTHENTIFICATION <small>ESPACE DES ADMINISTRATEUR</small></h2>
</div>
<div class="card-body"><br>
<span class="c-red"><i><?php echo $err;?></i></span>			
<div class="input-group m-b-20" style="margin-top: 30px;">
<span class="input-group-addon"><i class="zmdi zmdi-account"></i></span>
<div class="fg-line">
<input type="email" class="form-control" ng-if="PAGE==0" autocomplete="username" ng-model="email" required name="email" placeholder="Code">
</div>
</div>
<div class="input-group m-b-20">
<span class="input-group-addon"><i class="zmdi zmdi-lock"></i></span>
<div class="fg-line">
<input type="password" name="pass" required autocomplete="current-password" ng-if="PAGE==0" ng-model="pass"  class="form-control" placeholder="MOT DE PASS">
</div>
</div>
<div class="clearfix"></div>
</div>
</div></div>
</div><button type="submit" name="login" class="btn btn-login btn-danger btn-float"><i class="zmdi zmdi-long-arrow-right"></i></button>
</form></div>
</div>
</body>
</html>