<?php  include_once("cn.php"); 
define("TABLE","session");define("ID_SESSION",$_SESSION[KSJZXID]);define("URL","../produits/coop_profile/");define('PAGE_SIZE',10);
if(chekAjax()){
	function loads(){
		$js = json_decode(file_get_contents("php://input"));
		if($js){$date=substr($js->date,0,10);
			$SQL="SELECT id_compte,SEC_TO_TIME(SUM(TIME_TO_SEC(TIMEDIFF(`end_date`,`start_date`))))as dif,c.name,src,email FROM `".SESSIONS."` ss JOIN ".COMPTE." c ON ss.id_compte=c.id WHERE  DATE(`start_date`)='".$date."' GROUP by id_compte "."";
		$t=SQL_QUERY($SQL);$total= count($t['data']);
		$newdata=array();$nbPages = ceil($total/PAGE_SIZE);$current = 1;
		if (isset($js->pg) && is_numeric($js->pg)) {$page = intval($js->pg);if ($page >= 1 && $page <= $nbPages) {$current=$page;} else if ($page < 1) {$current=1;} else {$current = $nbPages;}}
		$start = ($current *PAGE_SIZE - PAGE_SIZE);$start =$start <0?0:$start ;
		$SQLL="SELECT id_compte,SEC_TO_TIME(SUM(TIME_TO_SEC(TIMEDIFF(`end_date`,`start_date`))))as dif,c.name,src,email FROM `".SESSIONS."` ss JOIN ".COMPTE." c ON ss.id_compte=c.id WHERE  DATE(`start_date`)='".$date."' GROUP by id_compte "." LIMIT  $start,".PAGE_SIZE;
		$res=SQL_QUERY($SQLL);
		if(isset($res['test']) and $res['test']==false){
			echo echoJson(array("test"=>false,'errors'=>$res['errors']));exit;
		}else{
			foreach($res['data'] as $f){
			$f=demake($f);
			$lines=SQL_SELECT(SESSIONS,"  DATE(`start_date`)='".($date)."' AND  id_compte",$f['id_compte'],"","TIME(CONVERT_TZ(end_date,'+00:00','".TIME_ZONE."'))as end,TIME(CONVERT_TZ(start_date,'+00:00','".TIME_ZONE."')) as start,TIMEDIFF(`end_date`,`start_date`)as dif,type,ip");
			$f['lns']=$lines['test']==true?$lines['data']:array();
			$newdata[]=$f;}
			return array("d"=>$newdata,"count"=>(int)$total);
		}
		}else{
			echo echoJson(array("test"=>false,"errors"=>"No params"));exit;
		}
	}
	 if($_REQUEST['action']=="load"){
		 echo echoJson(array("test"=>true,"data"=>loads()));
	}else if($_REQUEST['action']=="loadgraph"){
		$js = json_decode(file_get_contents("php://input"));
		if($js){
			$res=SQL_QUERY("SELECT DAY(start_date)as mois,SUM(TIME_TO_SEC(TIMEDIFF(`end_date`,`start_date`)))as tt  FROM `".SESSIONS."` WHERE id_compte=".$js->id." AND YEAR(start_date)=:Y AND MONTH(start_date)=:M GROUP BY DAY(start_date)",array(":M"=>$js->m,":Y"=>$js->y));
		if($res['test']==true){
			$DAYS=array();$number = cal_days_in_month(CAL_GREGORIAN,$js->m,$js->y);
			foreach($res['data'] as $r){$DAYS[$r['mois']]=(DOUBLE)$r['tt']*1000;};
			echo echoJson(array("test"=>true,"data"=>mergeDays($DAYS,$number),"name"=>$MONTHS[$js->m]));
		}else{
			echo echoJson(array("test"=>false,"errors"=>$res['errors']));
		}
		}else{
			echo echoJson(array("test"=>false,"errors"=>"No params"));exit;
		}
	}
}else{echo json_encode(array("test"=>false,"errors"=>"server not authorized"));exit;}