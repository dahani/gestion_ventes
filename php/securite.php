<?php  include_once("cn.php"); 
define("TABLE","session");define("ID_SESSION",$_SESSION[KSJZXID]);define("URL","../produits/coop_profile/");define('PAGE_SIZE',10);
if(chekAjax()){
	function loaddx(){ 
		$total=0;$js = json_decode(file_get_contents("php://input"));if(getType($js)=="NULL"){$js = json_decode('{"psiz":"10","pg":"1"}');}
		$total= SQL_GET_TABLE_SIZE("SELECT count(*)as cnt  FROM `".NOTIFICATIONS."`  WHERE  1",2);
		$newdata=array();$start = getPage($js->pg,$js->psiz,$total);
		$data=SQL_QUERY("SELECT CONCAT(f.text,' ',c.name)text,f.date_,f.sent,f.id FROM ".NOTIFICATIONS." f LEFT JOIN ".COMPTE." c ON c.id=f.id_creator   ORDER BY id DESC LIMIT $start,".$js->psiz);
		if($data['test']==true){
			foreach($data['data'] as $d){$d=demake($d);$d['mail']=$d['sent']==0?"NON":"OUI";$d['date_']=strtotime($d['date_'])*1000;
			$newdata[]=$d;
			}return array("d"=>$newdata,"count"=>(int)$total,"test"=>true);
		}else{
			return array("d"=>[],"count"=>0,"test"=>false,"errors"=>$data['errors']);
		}
	}
	 if($_REQUEST['action']=="load"){
		 echo echoJson(loaddx());
	}else if($_REQUEST['action']=="delete"){$js = json_decode(file_get_contents("php://input"));$data=arrayCastRecursive($js);
		$r=SQL_QUERY("DELETE FROM `".NOTIFICATIONS."` WHERE `id` IN(".implode(",",$data['dl']).")");
		 echoJson(array("data"=>loaddx(),"test"=>true));
	}
}else{echo json_encode(array("test"=>false,"errors"=>"server not authorized"));exit;}