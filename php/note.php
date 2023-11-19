<?php  include_once("cn.php");
require_once('../vendor/autoload.php');
$client = new \GuzzleHttp\Client();
header("Access-Control-Allow-Origin:".AllowOriginAccess);
header("Content-Type: text/plain; charset=UTF-8");
define("ID_SESSION",$_SESSION[KSJZXID]);
if(chekAjax()){
	$EXTRA=["web_buttons"=>[["id" => "like-button",
        "text" => "Lire Notification",
        "icon" => "https://www.kompassit.com/apps/maroc_competence/email.png",
        "url" => "https://www.kompassit.com/apps/maroc_competence/#/home"]]];
	function loaddx(){ 
		$total=0;$js = json_decode(file_get_contents("php://input"));$where="";
		 if(!isset($js->q)){$js->q="";}$q=strip_tags($js->q);$q=trim($q);
		 $where.=" WHERE ";
		if(strlen($q)>0){
			 $SQL="SELECT * FROM ".TASKS." t  WHERE   ( text  LIKE :Q  ) ";
			
			$count="SELECT count(*)as cnt  FROM ".TASKS." t   WHERE  (text  LIKE :Q ) ";
			$total= SQL_GET_TABLE_SIZE($count,2,array(":Q"=>'%'.$q.'%'));
		}else{$total= SQL_GET_TABLE_SIZE("SELECT count(*)as cnt  FROM `".TASKS."`  ",2);}
		
		$newdata=array();$start = @getPage($js->pg,@$js->psiz,$total);
		if(strlen($q)>0){
			$data=SQL_QUERY($SQL." LIMIT $start,".$js->psiz,array(":Q"=>'%'.$q.'%'));
		}else if(@$js->get){$id=trim($js->get);$id=(INT)$id;
			$data=SQL_QUERY("SELECT * FROM ".TASKS." t  WHERE t.id=:ID",array(":ID"=>$id));
		}else{
			$data=SQL_QUERY("SELECT * FROM  ".TASKS." t    ORDER BY t.date_ DESC LIMIT $start,".$js->psiz);
			
		}
		if($data['test']==true){
			foreach($data['data'] as $d){$d=demake($d);
			$d['dt']=strtotime($d['date_'])*1000;
			$newdata[]=$d;
			}return array("d"=>$newdata,"count"=>(int)$total,"test"=>true);
		}else{
			return array("d"=>[],"count"=>0,"test"=>false,"errors"=>$data['errors']);
		}
	}
	if($_REQUEST['action']=="save_edit"){
		$js = json_decode(file_get_contents("php://input"),true);$data=$js['data'];$data['date_']=$data['date_']." ".$data['time'];
		unset($data['time'],$data['dt']);
		if(isset($data['id'])){$idx=$data['id'];unset($data['id']);
			deleteNotification($data['onesignal_id']);
			if(isDateInFuture($data['date_'])){	 
			$EXTRA['include_external_user_ids']=[$_SESSION['data']['id']];
		$notif=["date"=>$data['date_'],"heading"=>$data['date_'], "message"=>$data['text'] ,"last"=>$idx];
			SendNotification($notif,$EXTRA);}
		$res=SQL_UPDATE(TASKS,$data,"id",$idx);
		}else{$data['id_creator']=ID_SESSION;$res=SQL_ADD(TASKS,$data);
		if(isDateInFuture($data['date_'])){	 
		$notif=["date"=>$data['date_'],"heading"=>$data['date_'], "message"=>$data['text'] ,"last"=>$res['last']];
		$EXTRA['include_external_user_ids']=[$_SESSION['data']['id']];
			SendNotification($notif,$EXTRA);}
		
		}
		if($res['test']==true){
			echo echoJson(array("test"=>true,"data"=>loaddx()));
		}else{
			echo echoJson(array("test"=>false,"errors"=>$res['errors']));
		}		
	}else if($_REQUEST['action']=="load"){
		echo echoJson(loaddx());
	}else if($_REQUEST['action']=="delete"){$data = json_decode(file_get_contents("php://input"),true);
		$r=SQL_QUERY("DELETE FROM `".TASKS."` WHERE `id` IN(".implode(",",$data['dl']).")");
		echo echoJson(array("data"=>loaddx(),"test"=>true));
	}
}else{echo  echoJson(array("test"=>false,"errors"=>"server not authorized"));exit;}
