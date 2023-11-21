<?php include_once("cn.php");
$js = json_decode(file_get_contents("php://input"));
  if($_REQUEST['action']=="per"){
	$DATAX=array(); $txt=trim($_REQUEST['c']);$txt=strip_tags($txt);
	$SQL="SELECT id,nom as name FROM ".COOP." WHERE  ( `nom`  LIKE :Q OR `cin`  LIKE :Q)  ORDER BY nom DESC";
	$data=SQL_QUERY($SQL." LIMIT 0,10",array(":Q"=>'%'.$txt.'%'));
	if($data['test']==true){foreach($data['data'] as $d){$d=demake($d);$d['name']=strtoupper($d['name']);$DATAX[]=$d;}}
	echoJson($DATAX);
}else if($_REQUEST['action']=="perso"){
	$DATAX=array(); $txt=trim($_REQUEST['c']);$txt=strip_tags($txt);
	$SQL="SELECT id,name,src as img FROM ".COMPTE." WHERE id<>0 AND id <>".$_SESSION[KSJZXID]." AND   ( `name`  LIKE :Q  )  ORDER BY name DESC";
	$data=SQL_QUERY($SQL." LIMIT 0,10",array(":Q"=>'%'.$txt.'%'));
	if($data['test']==true){foreach($data['data'] as $d){$d=demake($d);$d['name']=strtoupper($d['name']);$DATAX[]=$d;}}
	echo json_encode($DATAX);
}else if($_REQUEST['action']=="four"){
	$DATAX=array(); $txt=trim($_REQUEST['c']);$txt=strip_tags($txt);
	$SQL="SELECT id,nom as name FROM ".FOURNISSEURS." WHERE  ( `nom`  LIKE :Q  OR  `ice`  LIKE :Q OR `tel`  LIKE :Q OR `addr` LIKE :Q OR `iff`  LIKE :Q OR `email`  LIKE :Q )  ORDER BY id DESC";
	$data=SQL_QUERY($SQL." LIMIT 0,10",array(":Q"=>'%'.$txt.'%'));
	if($data['test']==true){foreach($data['data'] as $d){$d=demake($d);$d['name']=strtoupper($d['name']);$DATAX[]=$d;}}
	 echoJson($DATAX);
}else if($_REQUEST['action']=="pr_stock"){
	$DATAX=array(); $txt=trim($_REQUEST['c']);$txt=strip_tags($txt);
	$SQL="SELECT id,name,prix  FROM  ".PRODUCTS."  WHERE ( `name`  LIKE :Q  OR  `code`  LIKE :Q)   ORDER BY name ASC";
	$data=SQL_QUERY($SQL." LIMIT 0,10",array(":Q"=>'%'.$txt.'%'));
	if($data['test']==true){foreach($data['data'] as $d){$d=demake($d);$d['prix']=(DOUBLE)$d['prix'];$d['name']=strtoupper($d['name']).' <i style="color:red">'.num_form($d['prix']).' dhs</i> ';$DATAX[]=$d;}}
	if(count($DATAX)==0){
		$DATAX[]=["name"=>'<i style="color:red">Ajouter Produit</i>',"txt"=>$txt,'id'=>"add"];
	}
	 echoJson($DATAX);
}else  if($_REQUEST['action']=="ventes"){
	$DATAX=array(); $txt=trim($_REQUEST['c']);$txt=strip_tags($txt);
	$SQL="SELECT p.id,SUM(q) as qt,p.name,p.qn_min,s.prix_vente as prix FROM `".STOCK."` s LEFT JOIN ".PRODUCTS." p ON p.id=s.id_pr WHERE (`name`  LIKE :Q  OR `code`  LIKE :Q)  GROUP BY p.id   ORDER BY name ASC";
	$data=SQL_QUERY($SQL." LIMIT 0,10",array(":Q"=>'%'.$txt.'%'));
	
	if($data['test']==true){foreach($data['data'] as $d){$d=demake($d);$d['prix']=(DOUBLE)$d['prix'];
	$d['qt']=(INT)$d['qt'];
	$d['namex']=strip_tags($d['name']);
	$d['name']=strtoupper($d['name']).' <i style="color:red">'.num_form($d['prix']).' dhs</i> ';$DATAX[]=$d;}}

	 echoJson($DATAX);
}else  if($_REQUEST['action']=="code"){
	$DATAX=array(); $code=trim($_REQUEST['code']);$code=strip_tags($code);
	$SQL="SELECT p.id,SUM(q) as qt,p.name,p.qn_min,s.prix_vente as prix FROM `".STOCK."` s LEFT JOIN ".PRODUCTS." p ON p.id=s.id_pr WHERE p.code=:Q  GROUP BY p.id ";
	$data=SQL_QUERY($SQL." LIMIT 0,1",array("Q"=>(int)$code));
	
	if($data['test']==true){foreach($data['data'] as $d){$d=demake($d);$d['prix']=(DOUBLE)$d['prix'];
	$d['qt']=(INT)$d['qt'];$d['q']=1;
	$DATAX[]=$d;}}

	 echoJson($DATAX);
}



 ?>