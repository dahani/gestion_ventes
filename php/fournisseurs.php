<?php  include_once("cn.php");
define("ID_SESSION",$_SESSION[KSJZXID]);define("URL","../img/four/");
			$newdata[]=$d;
		if(isset($data['id'])){$idx=$data['id'];unset($data['id']);$data['id_updator']=ID_SESSION;$data['dt_update']=date("Y-m-d H:i:s");$res=SQL_UPDATE(FOURNISSEURS,$data,"id",$idx);