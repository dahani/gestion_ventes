<?php   include_once("cn.php");
if(chekAjax()){
	function loads(){$tt=0;$infos=file_get_contents("json/infos.json");$infos=json_decode($infos);
		$notification=array();$where="";
	$DL=$infos->config->t_expire;
	$chks=SQL_QUERY("SELECT s.date_pre,f.nom as frn,p.name as pr FROM `".STOCK."` s LEFT JOIN ".FOURNISSEURS." f ON f.id=s.id_four  LEFT JOIN ".PRODUCTS." p ON p.id=s.id_pr WHERE  DATEDIFF(`date_pre`,NOW()) BETWEEN 0 AND :CC   ",['CC'=>$DL]);
	if($chks['test']==true){$tt+=count($chks['data']);foreach($chks['data'] as $n){$n=demake($n);
	$notification['exp'][]=$n;}
	}
	return $notification;
	}
	 if($_REQUEST['action']=="load"){
		  echoJson(array("test"=>true,"data"=>loads()));
	}
}else{echo  echoJson(array("test"=>false,"errors"=>"server not authorized"));exit;}