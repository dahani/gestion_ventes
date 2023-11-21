<?php include_once("cn.php");
$js = json_decode(file_get_contents("php://input"));
if(isset($_REQUEST['c'])){
	
	$DATAX=array(); $txt=trim($_REQUEST['c']);$txt=strip_tags($txt);

	
/*FOURNISSEURS*/

	$SQL="SELECT id, nom as name FROM ".FOURNISSEURS." WHERE  ( `nom`  LIKE :Q  OR `cin`  LIKE :Q OR `addr`  LIKE :Q OR `tel`  LIKE :Q  OR `ville`  LIKE :Q OR `addr` LIKE :Q OR `iff`  LIKE :Q OR `email`  LIKE :Q )   ORDER BY id DESC";

	$data=SQL_QUERY($SQL." LIMIT 0,3",array(":Q"=>'%'.$txt.'%'));

	if($data['test']==true){foreach($data['data'] as $d){$d=demake($d);$d['name']=strtoupper($d['name'])." (Fournisseur)";$d['type']="app.settings.fournisseurs";$DATAX[]=$d;}}
	
/*depenses*/
	$SQL="SELECT id,motif as name,mtn FROM `".DEPENSES."` d   WHERE  ( d.`motif`  LIKE :Q )  ORDER BY id DESC";
	$data=SQL_QUERY($SQL." LIMIT 0,3",array(":Q"=>'%'.$txt.'%'));
	if($data['test']==true){foreach($data['data'] as $d){$d=demake($d);$d['extra']=$d['name'];$d['name']=strtoupper($d['name'])." (Dépenses- ".$d['mtn']." )";$d['type']="app.depenses";$DATAX[]=$d;}}
	
	
	/*Produits*/
	$SQL="SELECT id, name FROM ".PRODUCTS." WHERE  (`name`  LIKE :Q  OR  `code`  LIKE :Q )   ORDER BY id DESC";
	$data=SQL_QUERY($SQL." LIMIT 0,3",array(":Q"=>'%'.$txt.'%'));
	if($data['test']==true){foreach($data['data'] as $d){$d=demake($d);$d['name']=strtoupper($d['name'])." (Produits)";$d['type']="app.produits";$DATAX[]=$d;}}
	
	echo json_encode($DATAX);
}
 ?>