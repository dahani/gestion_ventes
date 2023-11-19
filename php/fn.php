<?php   include_once("cn.php");
header("Access-Control-Allow-Origin:".AllowOriginAccess);header("Content-Type: text/plain; charset=UTF-8");
define("ID_SESSION",$_SESSION[KSJZXID]);define("URL","../img/");
use Spatie\Image\Image;
if(chekAjax()){
	function getNotif(){$notification=array();$infos=file_get_contents("json/infos.json");$infos=json_decode($infos);$PRFINI=0;
	/*$DL=$infos->config->t_pay;
	$notif=SQL_QUERY("SELECT count(*) cnt FROM (SELECT  cl.name,f.price total,SUM(p.mtn) payed FROM `".CLIENTS."` cl LEFT JOIN ".FORMATIONS." f ON cl.id_for=f.id LEFT JOIN ".PAY." p ON p.id_cl=cl.id WHERE cl.inscrit=1 AND f.id IN(SELECT id FROM `".FORMATIONS."` WHERE DATEDIFF(`date_f`,NOW()) BETWEEN 0 AND :CC)   GROUP BY cl.id   HAVING payed<total )c ",['CC'=>$DL]);
	if($notif['data']){$notif=$notif['data'][0]['cnt'];}else{$notif=0;};if($notif>0){$notification[]=array("href"=>"#/notifications","name"=>'('.$notif .") Credits Clients","text"=>"Clients ont des crédits impayés");}
	
	$res=SQL_QUERY("SELECT mm.*,c.name,c.src as img FROM (SELECT m.*,(CASE
    WHEN sendBy=:ID THEN sendTo
    WHEN sendTo = :ID THEN sendBy END )user  FROM ".MESSAGES." m,
	(SELECT MAX(id) as lastid FROM ".MESSAGES." WHERE (sendTo = :ID OR sendBy = :ID )GROUP BY
	CONCAT(LEAST(sendTo, sendBy),'.',GREATEST(sendTo, sendBy))) as conversations
	WHERE id = conversations.lastid ORDER BY date_ DESC) mm LEFT JOIN maroc_compte c ON mm.user=c.id",['ID'=>ID_SESSION]);
	$counter=0;$msg=[];
	if($res['test']==false){echoJson (array("test"=>false,"errors"=>$res['errors']));exit;}
	foreach($res['data'] as $f){$f=demake($f);$f['text']=substr($f['text'],0,25);
	;$f['date_']=SQL2FR(substr($f['date_'],0,10));
	if($f['sendTo']==ID_SESSION and $f['vue']==0){$counter++;}
	$msg[]=$f;}
	
	$sql=SQL_QUERY("SELECT i.name,date_n,TIMESTAMPDIFF(year,date_n, now()) as age,f.name frm FROM `".CLIENTS."` i LEFT JOIN ".FORMATIONS." f ON f.id=i.id_for WHERE inscrit=1 AND MONTH(date_n)=MONTH(now()) AND DAY(date_n)-DAY(NOW()) BETWEEN 0 AND 5");
	foreach($sql['data'] as $f){$f=demake($f);
	;$f['date_n']=SQL2FR(substr($f['date_n'],0,10));
	$notification[]=array("href"=>"#/notifications","name"=>'BIRTHDAY '.strtoupper($f['name']),"text"=>$f['frm']." (".$f['date_n'].")");}
	
	
	*/
	/*produits peremé*/
	$DL=$infos->config->t_expire;
	$notif=SQL_QUERY("SELECT COUNT(*) cnt FROM  ".STOCK." WHERE DATEDIFF(`date_pre`,NOW()) BETWEEN 0 AND ".($DL*30)." ");if($notif['test'] && $notif['data']){$notif=$notif['data'][0]['cnt'];}else{$notif=0;};if($notif>0){$notification[]=array("href"=>"#/notifications","name"=>" Expiration des produits","text"=>"({$notif}) Produits expire dans moins de (<".$DL." Mois)");}
		
		
$stq=json_decode('[]',true);
	return array("notif"=>$notification,"stq"=>$stq,"msg"=>array("count"=>1,"data"=>[]));
	}
		if($_REQUEST['action']=="load"){$infos=file_get_contents("json/infos.json");$infos=$infos?json_decode($infos):array();
	$session=array("email"=>$_SESSION["data"]['email'],"name"=>$_SESSION["data"]['name'],"src"=>$_SESSION["data"]['src'],"idx"=>$_SESSION[KSJZXID],"admin"=>(BOOLEAN)$_SESSION["data"]['admin'],"createime"=>substr($_SESSION["data"]['createime'],0,10));
	echo json_encode(array("infos"=>$infos,"config"=>$_SESSION[CONFIG],"permissions"=>$_SESSION[ACCESS],"session"=>$session,"notifs"=>getNotif()));
	}if($_REQUEST['action']=="refreshNotif"){
		// /*update session time*/
		if(time()-$_SESSION[LAST_UPDATE]<100){SQL_UPDATE(SESSIONS,array("end_date"=>date("Y-m-d H:i:s")),"id",$_SESSION[SESSION_IDX]);$_SESSION[LAST_UPDATE]=time();
		}else{require_once 'mobile.php';
			$detect = new Mobile_Detect;$deviceType = ($detect->isMobile() ? ($detect->isTablet() ? 'tablet' : 'Mobile') : 'Ordinateur');
			$ip = @$_SERVER['HTTP_CLIENT_IP'] ? @$_SERVER['HTTP_CLIENT_IP'] : (@$_SERVER['HTTP_X_FORWARDED_FOR'] ? @$_SERVER['HTTP_X_FORWARDED_FOR'] : @$_SERVER['REMOTE_ADDR']);
			$add=SQL_ADD(SESSIONS,array("ip"=>@$ip,"type"=>$deviceType,"id_compte"=>$_SESSION[KSJZXID],"start_date"=>date("Y-m-d H:i:s"),"end_date"=>date("Y-m-d H:i:s")));$_SESSION[LAST_UPDATE]=time();if($add['test']){$_SESSION[SESSION_IDX]=$add['last'];}}
		echoJson(array("test"=>true,"d1"=>getNotif()));
	}else if($_REQUEST['action']=="login"){$js = json_decode(file_get_contents("php://input"));$pass=setPasword($js->pass);
			$re=SQL_QUERY("SELECT * FROM `".COMPTE."` WHERE `email`=:email AND  `pass`=:pass",array(":email"=>$_SESSION[OZCUSERCUZSZ],":pass"=>$pass));
			if($re['test']){if(count($re['data'])>0){echoJson(array("test"=>true));}else{echoJson(array("test"=>false));}}else{echoJson(array("test"=>false));}
	}else  if($_REQUEST['action']=="saveInfos"){
		require_once '../vendor/autoload.php';
		$js = json_decode($_REQUEST['info']);$data=arrayCastRecursive($js);$tmpsrc=isset($js->logo)?$js->logo:"";
		if(isset($_FILES['files'])){ $f=$_FILES['files'];
		
			if(file_exists($f['tmp_name'])){
				$op1=Image::load($f['tmp_name'])
				->fit("stretch",512,512)->quality(60)->optimize()->save(URL."logo.webp");
				$js->logo="logo.webp";
			}

		}
		$f=fopen("json/infos.json","w+");
		if(fputs($f,json_encode($js,JSON_UNESCAPED_UNICODE))){
			fclose($f); echoJson(array("test"=>true));
		}else{
			 echoJson(array("test"=>false));
		}
	}else  if($_REQUEST['action']=="saveInfos1"){$js = json_decode(file_get_contents("php://input"));
		$f=fopen("json/infos.json","w+");
		if(fputs($f,json_encode($js->data,JSON_UNESCAPED_UNICODE))){
			 echoJson(array("test"=>fclose($f)));
		}else{
			 echoJson(array("test"=>false));
		}
	}if($_REQUEST['action']=="loadtmpl"){$infos=file_get_contents("json/tmpl.json");$infos=$infos?json_decode($infos):array();echoJson($infos);
	}else  if($_REQUEST['action']=="saveTmpl"){$js = json_decode(file_get_contents("php://input"));
		$f=fopen("json/tmpl.json","w+");
		if(fputs($f,json_encode($js->data,JSON_UNESCAPED_UNICODE))){
			 echoJson(array("test"=>fclose($f)));
		}else{
			 echoJson(array("test"=>false));
		}
	}
}else{echoJson(array("test"=>false,"errors"=>"server not authorized"));exit;}