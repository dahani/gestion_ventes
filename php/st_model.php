<?php  include_once("cn.php");
header("Access-Control-Allow-Origin:".AllowOriginAccess);
header("Content-Type: text/plain; charset=UTF-8");
define("ID_SESSION",$_SESSION[KSJZXID]);
if(chekAjax()){
	 $js = json_decode(file_get_contents("php://input"));
	 if(isset($js->mois)){
		 if($js->mois=="type_depenses"){
			 define("TABLE",TYPE_DEP);
		 }else if($js->mois=="cert"){
			 define("TABLE",CERTIFICAT);
		 }else if($js->mois=="ask"){
			 define("TABLE",ASK);
		 }
		 
	 }else{exit("notable");}
	function loaddx(){ 
	$total=0;$js = json_decode(file_get_contents("php://input"));
		 if(!isset($js->q)){$js->q="";}$q=strip_tags($js->q);$q=trim($q);
		if(strlen($q)>0){
			 $SQL="SELECT * FROM ".TABLE." WHERE  ( `name`  LIKE :Q   )  ORDER BY name ";
			$count="SELECT count(*)as cnt  FROM `".TABLE."`  WHERE ( `name`  LIKE :Q   )   ";
			$total= SQL_GET_TABLE_SIZE($count,2,array(":Q"=>'%'.$q.'%'));
		}else{$total= SQL_GET_TABLE_SIZE("SELECT count(*)as cnt  FROM `".TABLE."`  WHERE  1",2);}
		
		$newdata=array();$start = getPage($js->pg,$js->psiz,$total);
		if(strlen($q)>0){
			$data=SQL_QUERY($SQL." LIMIT $start,".$js->psiz,array(":Q"=>'%'.$q.'%'));
		}else{
			$data=SQL_SELECT(TABLE,"1",1,"  ORDER BY name LIMIT $start,".$js->psiz);
		}
	
		
		if($data['test']==true){
			foreach($data['data'] as $d){$d=demake($d);
			if(isset($d['price'])){$d['price']=(DOUBLE)$d['price'];}
			$newdata[]=$d;}
			return array("d"=>$newdata,"count"=>(int)$total,"test"=>true);
		}else{
			return array("d"=>[],"count"=>0,"test"=>false,"errors"=>$data['errors']);
		}
	}
	if($_REQUEST['action']=="save_edit"){
		 $js = json_decode(file_get_contents("php://input"));
		$data=arrayCastRecursive($js->data);
		if(isset($data['id'])){$data['id_creator']=$data['id_creator']==""?ID_SESSION:$data['id_creator'];$idx=$data['id'];unset($data['id']);$res=SQL_UPDATE(TABLE,$data,"id",$idx);
		}else{$data['id_creator']=ID_SESSION;$res=SQL_ADD(TABLE,$data);}
		if($res['test']==true){
			echoJson(array("test"=>true,"data"=>loaddx()));
		}else{
			echoJson(array("test"=>false,"errors"=>$res['errors']));
		}		
	}else if($_REQUEST['action']=="load"){
		echoJson(loaddx());
	}else if($_REQUEST['action']=="delete"){$js = json_decode(file_get_contents("php://input"));
		$data=arrayCastRecursive($js);
		$r=SQL_QUERY("DELETE FROM `".TABLE."` WHERE `id` IN(".implode(",",$data['dl']).")");
		echoJson(array("data"=>loaddx(),"test"=>true));
	}
}else{echoJson(array("test"=>false,"errors"=>"server not authorized"));exit;}
