<?php 
//include __DIR__.'/../vendor/autoload.php';
/*UTC 00:00 # Europe/Berlin +01:00*/
error_reporting(E_ALL ^ E_DEPRECATED);
@session_start();
define('TIME_ZONE', isset($_SERVER['HTTP_ZONE'])?$_SERVER['HTTP_ZONE']:"+0:00");
$offset=explode(':',TIME_ZONE);
$offset=(int)$offset[0];

$timezone_name = timezone_name_from_abbr('', $offset * 3600, true); // e.g. 

date_default_timezone_set($timezone_name);
if(strpos($_SERVER['SCRIPT_FILENAME'],"install.php")<=0){
	if(file_exists(__DIR__."/config.php") ){include_once(__DIR__."/config.php");}else{echo die("NO CONFIG FILE...");}
}
function isLocalhost($whitelist = ['127.0.0.1', '::1']) {return in_array($_SERVER['REMOTE_ADDR'], $whitelist);}
ob_start();define("DEBUG",isLocalhost());define("VERSION","0.1.20");
define("EMAIL","contact@app1.com");
define("AllowOriginAccess",((@$_SERVER['HTTPS']?"https://":"http://").$_SERVER['HTTP_HOST']));
define("YEAR_START",2021);define("TABLE_PREFIX","gv_");
define("LAST_UPDATE","time_up");
define("OZCUSERCUZSZ","email");define("ACCESS","access"); define("SESSION_IDX","session_id");
define("CONFIG","CONFIG");define("KSJZXID","lknlk2d3msz23ss3sa");define("BASE64PREFIX","1AWdSCDR5");define("TOKEN","QSDQSA12#231223.33");
define("SECRET_KEY","Zqkd45qs32343434sd");
/*tables*/
define("COMPTE",TABLE_PREFIX."compte");
define("NOTES",TABLE_PREFIX."notes");
define("SESSIONS",TABLE_PREFIX."sessions");
define("FOURNISSEURS",TABLE_PREFIX."fournisseurs");
define("NOTIFICATIONS",TABLE_PREFIX."notifications");
define("TYPE_DEP",TABLE_PREFIX."config_type_depenses");
define("VENTES",TABLE_PREFIX."commande_article");
define("COMMANDES",TABLE_PREFIX."commandes");
define("DEPENSES",TABLE_PREFIX."depenses");
define("STOCK",TABLE_PREFIX."stock");
define("PRODUCTS",TABLE_PREFIX."products");

define("ONE_SIGNEL_AUTH","Zjc0OTdlNjEtMTQ0OC00ZDcxLTk3OTQtOWMwOTNkNGEyMjM2");
define("ONE_SIGNEL_AP_ID","05e10fef-e24b-4945-8e21-4de6768b6e17");
/*config*/
$INFOS_CONFIG=file_get_contents((__DIR__)."/json/infos.json");$INFOS_CONFIG=json_decode($INFOS_CONFIG);
define("GLOBALNAME","".@$INFOS_CONFIG->name);
$MESSAGES=array(
"cl_update"=>"Le Client [[#cl]] a été modifier | par ",
"newAccount"=>"Nouveau compte créer Nom: [#name] , Email: [#mail] | par");
$MONTHS=array('01' =>"JANVIER",'02'=>"FEVRIER",'03'=>"MARS",'04'=>"AVRIL",'05'=>"MAI",'06'=>"JUIN",'07'=>"JUILLET",'08'=>"AOÛT",'09'=>"SEPTEMBRE", '10'=>"OCTOBRE",'11'=>"NOVEMBRE",'12'=>"DÉCEMBRE");

function deleteNotification($id){
$client = new \GuzzleHttp\Client(['http_errors' => false]);
	try{ 
$response = $client->request('DELETE', "https://onesignal.com/api/v1/notifications/$id?app_id=".ONE_SIGNEL_AP_ID, [
  'headers' => [
   'Authorization' => "Basic ".ONE_SIGNEL_AUTH,
    'accept' => 'application/json',
    'content-type' => 'application/json',
  ],
]);
$r=json_decode($response->getBody(),true);
	if(isset($r['errors'])){
		//echoJson(array("test"=>false,"errors"=>$r['errors']));
	}
	}catch(Exception $e){
		//echoJson(array("test"=>false,"errors"=>$e->getMessage()));exit;
	}
}
function isDateInFuture($date):bool{
    $now=new DateTime();$dtx=new DateTime($date);
	return $dtx>$now;
}
function SendNotification($inf,$extra){
	$client = new \GuzzleHttp\Client(['http_errors' => false]);
	  
$con=["app_id"=>ONE_SIGNEL_AP_ID,'contents'=>['en'=>$inf['message']],'headings'=>['en'=>$inf['heading']]];
if(isset($inf['date'])){$datetime= strtotime("{$inf['date']} - 10 minute");
		 $datetime=date('Y-m-d H:i:s \G\M\TO', $datetime);
		 $con['send_after']=$datetime;
		
	}
$cnf=array_merge($con,$extra);
$cnf=(object)$cnf;
		try{
		$response = $client->request('POST', 'https://onesignal.com/api/v1/notifications', [
	  'body' =>json_encode($cnf),
	  'headers' => [
		'Authorization' => "Basic ".ONE_SIGNEL_AUTH,
		'accept' => 'application/json',
		'content-type' => 'application/json',
	  ],
	]);
	$r=json_decode($response->getBody(),true);
	if(isset($r['errors'])){
			echoJson(array("test"=>false,"errors"=>$r['errors']));exit;
		}else{
			if(isset($inf['last'])){
			$dd=SQL_UPDATE(TASKS,['onesignal_id'=>$r['id']],'id',$inf['last']);
			if($dd['test']==false){
				echoJson(array("test"=>$dd['test'],"errors"=>$dd['errors']));exit;
			}
			}
		}
		}catch(Exception $e){
			//echoJson(array("test"=>false,"errors"=>$e->getMessage()));exit;
		}
}


function getModePay($d="xx"){if($d==null){return '';};$e=array("1"=>"Esp","2"=>"Che","3"=>"mode3","0"=>"Autre");return isset($e[$d])?$e[$d]:$e;}
if(!isset($_SESSION[KSJZXID]) and isset($_REQUEST['action'],$_SERVER['HTTP_X_REQUESTED_WITH'])){echoJson(array("test"=>false,"code"=>"406","errors"=>"You are not connected"));exit;}
function chekAjax(){if(isset($_REQUEST['action'],$_SERVER['HTTP_X_REQUESTED_WITH'])){if($_SESSION[TOKEN]==$_SERVER['HTTP_X_CSRF_TOKEN']){return true;}}else{return false;}}
function check(){if(!isset($_SESSION[KSJZXID])){header("location:logout.php?id=12");exit;}}
function generateToken($UiD){
 	$payload = array('iss' => AllowOriginAccess,'exp' => time()+60000, 'uId' => $UiD);
	try{
		$jwt = JWT::encode($payload,SECRET_KEY,'HS256'); $res=array("test"=>true,"token"=>$jwt);
	}catch (UnexpectedValueException $e) {
		$res=array("test"=>false,"Error"=>$e->getMessage());
	}
 	return $res;
 }
function getErr($code){$SQL_ERROR_MESSAGES=array('1062'=>"déjà existe");
if(isset($SQL_ERROR_MESSAGES[$code[1]])){return $SQL_ERROR_MESSAGES[$code[1]];}else{return isset($code[2])?$code[2]:"";}
}
if(!DEBUG){error_reporting(E_ERROR | E_PARSE);error_reporting(E_ALL);ini_set('display_errors', false);ini_set('display_startup_errors', false);}
/*function getEtat($d="@@"){$e=array("1"=>"Nouveau","2"=>"Bon état","3"=>"À rénover");return (isset($e[$d] )&& $d!="@@")?$e[$d]:$e;}*/
function getGenreClient($d="xx"){if($d==null){return '';};$e=array("1"=>"Femme","2"=>"Homme","3"=>"Enfant");return isset($e[$d])?$e[$d]:$e;} 
function FormatString($html, $args) {foreach($args as $key => $val) $html = str_replace("[#$key]", $val, $html); return $html;}
 function buildTree(array $elements, $parentId = null) {$branch = array();
    foreach ($elements as $element) {
        if ($element['parent'] == $parentId) {
            $children = buildTree($elements, $element['id']);
            if ($children) {
                $element['children'] = $children;
            }
            $branch[] = $element;
        }
    }
    return $branch;
}
function groupBy($arr, $criteria): array{
    return array_reduce($arr, function($accumulator, $item) use ($criteria) {
        $key = (is_callable($criteria)) ? $criteria($item) : $item[$criteria];
        if (!array_key_exists($key, $accumulator)) {
            $accumulator[$key] = [];
        }
        array_push($accumulator[$key], $item);
        return $accumulator;
    }, []);
}
function getLastDeviNum($t,$ff="num"){
	$r=SQL_QUERY("SELECT $ff FROM `".$t."` WHERE $ff like '%/".date("y")."' ORDER by id desc LIMIT 0,1");
	if($r['test']==true){$number=isset($r['data'][0])?$r['data'][0][$ff]:"0/";$num=explode("/",$number);$num[0]++;
		return str_repeat("0",3-@strlen((int)$num[0])).($num[0]).'/'.date("y");
	}else{
		return "001/".date("y");
	}
}
function getStatutPay($payed,$total,$ch=false){if($ch){return'<span class="p-l-25 ventesdt" > <i class="zmdi zmdi-error_outline c-orange  text-center "></i>En cours ENC.</span>';}if($payed==$total){return'<span class="p-l-25 ventesdt" > <i class="zmdi zmdi-check-all c-blue  text-center "></i> PAYEE</span>';}else if($payed>0){return '<span class="p-l-25 ventesdt" > <i class="zmdi zmdi-remove c-orange  text-center "></i> PARTIELLEMENT PAYÉ</span>';}else{return'<span class="p-l-25 ventesdt" > <i class="zmdi zmdi-close c-red  text-center "></i> NON PAYEE</span>';}}
function ExistOrNull($d){return (!isset($d) or $d=="")?null:$d;}
function echoJson($array=null){
	if(DEBUG){
		 $array=")]}',\n".json_encode($array,JSON_UNESCAPED_UNICODE);
	}else{
		$array=")]}',\n".json_encode($array,JSON_UNESCAPED_UNICODE);$array=preg_replace('/{/',"♫",$array);$array=preg_replace('/}/',"♪",$array);
	$array=preg_replace('/:/',"☼",$array);$array=preg_replace('/;/',"♣",$array);
	 $array=base64_encode(BASE64PREFIX.$array);}	
ob_start(); echo $array;$size=ob_get_length();
header("Access-Control-Allow-Origin:".AllowOriginAccess);
header("Content-Type: text/plain; charset=UTF-8");
header("Content-Length: $size"); ob_end_flush(); exit;
}
function getStConfig($table,$t="*",$k="1",$v="1",$ord="",$op="="){$qurtier=SQL_SELECT($table,$k,$v,$ord,$t,$op);if($qurtier['test']==true){$r=array();foreach($qurtier['data'] as $f){$r[$f['id']]=htmlentities($f['name']);}return $r;}else{return array();}
}
function mergeDays($a,$number){$arudata=array();for($i=1;$i<=$number;$i++){if(!isset($a[$i])){$arudata[]=array($i,0);}else{$arudata[]=array($i,(DOUBLE)$a[$i]);}}return $arudata;}
function mergeDaysSingle($a,$number){$arudata=array();for($i=1;$i<=$number;$i++){if(!isset($a[$i])){$arudata[]=0;}else{$arudata[]=(DOUBLE)$a[$i];}}return $arudata;}
 function connect(){$con=null;try {return new PDO('mysql:host='.decryptIt(LSDJSHOSTLSDJ).';dbname='.decryptIt(MLSLDBLKQS),decryptIt(DLZEDUSERJQSDJZ),decryptIt(MSKASJJAPASSDSDJ),array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8,time_zone = "'.TIME_ZONE.'";',PDO::ATTR_EMULATE_PREPARES=>false,PDO::MYSQL_ATTR_DIRECT_QUERY=>true,PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));}catch (PDOException $e) {echoJson(array("errors"=>'Connexion Acces: ' . $e->getMessage(),"test"=>false));exit;}	return $con;
}
function SQL_GET_TABLE_SIZE($table,$t=0,$ex=array()){ 
	$con=connect();$sql="SELECT COUNT(*)as cnt FROM `".$table."` WHERE  1";
	try {
		$res=$con->prepare($t==0?$sql:$table);
		$res->execute($ex);
		return ($res->rowCount()>=1)?$res->fetch(PDO::FETCH_ASSOC)['cnt']:0;
	}
	catch(PDOException $e) {
		$er="SQL_GET_TABLE_SIZE:".utf8_encode($e->errorInfo[2])."<br>".$table;
		echoJson(array("errors"=>$er,"test"=>false));exit;
	}
}
function SQL_DELETE($table,$id,$val){$con=connect();$sql="DELETE FROM `{$table}` WHERE   {$id}='{$val}'";
$res=$con->query($sql);
if($res){return array("test"=>true);}else{return array("test"=>false,"errors"=>$con->errorInfo()[2]);}
}
function SQL_ADD($table,$fild,$ignore=false){global $INFOS_CONFIG;$con=connect();global $MESSAGES;
$sql="INSERT ".($ignore?" IGNORE ":"")." INTO ".$table.' (';
	$i=0;$nefileds=array();
	foreach($fild as $key=>$val){$sql.=($i==count($fild)-1)?$key:$key.' ,';$i++;}
	$sql.=" ) VALUES ( ";$i=0;
	foreach($fild as $key=>$val){
	   if(preg_match('/^date_/i', $key)){ if(!preg_match('/(\d{4})-(\d{2})-(\d{2}) (\d{2}):(\d{2}):(\d{2})/',$fild[$key])){$fild[$key]=substr($val,0,10);if($fild[$key]==""){$fild[$key]=null;}}}
	   $fild[$key]=@strlen($fild[$key])==0?null:$fild[$key];
		$nefileds[$key]=$fild[$key];
	    $sql.=($i==count($fild)-1)?":".$key:":".$key.' ,';$i++;}$sql.=" )  ";
	//echo $sql;
	try {
		$res=$con->prepare($sql);$res=$result=$res->execute($nefileds);
		/*if($table==COMMANDES and @$INFOS_CONFIG->nf->SellBfore && $result &&  dateDif($fild['date_vente'])>0){
			SQL_ADD(NOTIFICATIONS,array("date_"=>date("Y-m-d H:i:s"),"text"=>FormatString($MESSAGES['SellBfore'],array("date"=>$fild['date_vente'],"total"=>$fild['total'],"bl"=>$fild['n_facture'])),"id_creator"=>$_SESSION[KSJZXID]));
		}*/
		if($table==COMPTE and @$INFOS_CONFIG->nf->newAccount && $result ){
			SQL_ADD(NOTIFICATIONS,array("date_"=>date("Y-m-d H:i:s"),"text"=>FormatString($MESSAGES['newAccount'],array("name"=>$fild['name'],"mail"=>$fild['email'])),"id_creator"=>$_SESSION[KSJZXID]));
		}
		return array("test"=>true,"last"=>$con->lastinsertId());
	}
	catch(PDOException $e) {
		return array("test"=>false,"errors"=>getErr($e->errorInfo),'errorText'=>(DEBUG?("SQL_ADD:".$e->errorInfo[2]."<br>".$sql):''));
	}
}
/*
@param String $table
@param sder $id
*/
function SQL_UPDATE($table,$fild,$id,$idval){global $INFOS_CONFIG;$con=connect();global $MESSAGES;
	$sql="UPDATE `{$table}` SET  ";$i=0;$nefileds=array();
	foreach($fild as $key=>$val){
		if(preg_match('/^date_/i', $key)){if(!preg_match('/(\d{4})-(\d{2})-(\d{2}) (\d{2}):(\d{2}):(\d{2})/',$fild[$key])){$fild[$key]=substr($val,0,10);}}
		$fild[$key]=@strlen($fild[$key])==0?null:$fild[$key];
		$nefileds[$key]=$fild[$key];
		$sql.=($i==count($fild)-1)?$key."=:".$key:$key."=:".$key." ,";$i++;}
	$sql.=" WHERE {$id}='{$idval}'";
	try {
		$res=$con->prepare($sql);$result=$res->execute($nefileds);
		/*if($table==CLIENTS and @$INFOS_CONFIG->nf->clientUpdate && $result){
			SQL_ADD(NOTIFICATIONS,array("date_"=>date("Y-m-d H:i:s"),"text"=>FormatString($MESSAGES['cl_update'],array("cl"=>$fild['name'])),"id_creator"=>$_SESSION[KSJZXID]));
		}*/
		return array("test"=>$result?true:false);
	}
	catch(PDOException $e) {
		return array("test"=>false,"errors"=>getErr($e->errorInfo),'errorText'=>(DEBUG?("SQL_UPDATE:".$e->errorInfo[2]."<br>".$sql):''));}	
}
function SQL_SELECT($table,$key,$val,$limit="",$filed="*",$op="="){ $con=connect();$sql="SELECT {$filed} FROM `{$table}` WHERE  {$key}{$op}:val ".$limit;
try { 
		$res=$con->prepare($sql);
		$re=$res->execute(array(":val"=>$val));$data= $res->fetchAll(PDO::FETCH_ASSOC);
		return array("test"=>true,"data"=>$data);
	}
	catch(PDOException $e) {
		return array("test"=>false,"errors"=>getErr($e->errorInfo),'errorText'=>(DEBUG?("SQL_SELECT:".$e->errorInfo[2]."<br>".$sql):''));
	}
}
function SQL_QUERY($q,$ex=array()){$con=connect();
	try {
		$res=$con->prepare($q);$res->execute($ex);
		if (preg_match("/select|show/i", $q)) {$data= $res->fetchAll(PDO::FETCH_ASSOC);return array("test"=>true,"data"=>$data);
		}else{return array("test"=>true);}
	}
	catch(PDOException $e) {
		return array("test"=>false,"errors"=>getErr($e->errorInfo),'errorText'=>(DEBUG?("SQL_QUERY:".$e->errorInfo[2]."<br>".$q):''));}
}
function getcreator($id,$tbl=COMPTE){if($id!=null){$con=connect();$sql="SELECT name FROM `".$tbl."` WHERE id=".$id;$res=$con->query($sql);if($res){return strtoupper(@$res->fetch(PDO::FETCH_ASSOC)['name']);}}}
function getDateString($d){if($d==date("Y-m-d")){return "Aujourd'hui";}else if(dateDif($d)=="1"){return "Hier";}else{return $d;}}
function GetRandomImage(){ $random = substr(md5(mt_rand()), 0, 10);
$size = 512;$image=imagecreatetruecolor($size, $size);
$back = imagecolorallocate($image, 255, 255, 255);
$border = imagecolorallocate($image, 0, 0, 0);
imagefilledrectangle($image, 0, 0, $size - 1, $size - 1, $back);
for($i=1;$i<=57;$i++){ $radius   =rand(0,150);imagefilledellipse($image,rand(0,600),rand(0,600), $radius, $radius, imagecolorallocatealpha($image,rand(0,255), rand(0,255),rand(0,255),rand(0,90)));}
imagepng($image, "../img/profiles/".$random.".png");
imagedestroy($image); return $random.".png";}
function getPage($pj,$psize,$total,$e="xx"){ $psize=$psize>250?250:$psize;
	 $nbPages = ceil($total/$psize);$current = 1;
		if (isset($pj) && is_numeric($pj)) {$page = intval($pj);if ($page >= 1 && $page <= $nbPages) {$current=$page;} else if ($page < 1) {$current=1;} else {$current = $nbPages;}}$start = ($current *$psize - $psize);$start =$start <0?0:$start ;return $e=="xx"?$start:$nbPages;
}
function diffDays($d,$d2="xx"){if($d2=="xx"){$d2=date("Y-m-d");}$dStart = new DateTime($d2);$dEnd  = new DateTime($d);$dDiff = $dEnd->diff($dStart);if($dDiff->format('%R')=="+"){
	return  "----";
}return $dDiff->days;}
function dateDif($d){$d2=date("Y-m-d");$dStart = new DateTime($d2);$dEnd  = new DateTime($d);$dDiff = $dEnd->diff($dStart);return $dDiff->format('%r%a');}
function getAge($d){$dStart = new DateTime(date("Y-m-d"));$dEnd  = new DateTime($d);$dDiff = $dEnd->diff($dStart);
if($dDiff->format('%R')=="+"){$dd="";
	if($dDiff->y>0){$dd.=($dDiff->y==1)?$dDiff->y." An ":$dDiff->y." Ans ";}
	if($dDiff->m>0){$dd.=$dDiff->m." Mois ";}
	return $dd;
}else{return "---";}
}
function link_it($text){  $text= preg_replace("/(^|[\n ])([\w]*?)([\w]*?:\/\/[\w]+[^ \,\"\n\r\t<]*)/is", "$1$2<a target=\"_blank\" href=\"$3\" >$3</a>", $text);$text= preg_replace("/(^|[\n ])([\w]*?)((www)\.[^ \,\"\t\n\r<]*)/is", "$1$2<a target=\"_blank\" href=\"http://$3\" >$3</a>", $text);$text= preg_replace("/(^|[\n ])([\w]*?)((ftp)\.[^ \,\"\t\n\r<]*)/is", "$1$2<a target=\"_blank\" href=\"ftp://$3\" >$3</a>", $text);$text= preg_replace("/(^|[\n ])([a-z0-9&\-_\.]+?)@([\w\-]+\.([\w\-\.]+)+)/i", "$1<a target=\"_blank\" href=\"mailto:$2@$3\">$2@$3</a>", $text); return($text);}
function bytesToSize($bytes) {$sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];if ($bytes == 0) return 'n/a';$i = intval(floor(log($bytes) / log(1024)));if ($i == 0) return $bytes . ' ' . $sizes[$i]; return round(($bytes / pow(1024, $i)),1,PHP_ROUND_HALF_UP). ' ' . $sizes[$i];}
function Phone($f){$f=str_replace(" ",'',$f);$f=str_replace(".",'',$f);$f=str_replace("-",'',$f);return preg_replace("/([0-9]{2})([0-9]{2})([0-9]{3})([0-9]{3})/", "$1 $2-$3-$4", $f);}
function setPasword($f,$dec=0){return $dec==0?encryptIt($f):decryptIt($f);}
function encrypt_decrypt($action, $string) {$output = "";$encrypt_method = "AES-256-CBC";$secret_key = '0ZMALZSAO324';$secret_iv = '02AZAZPO3234332AZA';$key = hash('sha256', $secret_key);$iv = substr(hash('sha256', $secret_iv), 0, 16);if ( $action == 'encrypt' ) {$output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);$output = base64_encode($output);} else if( $action == 'decrypt' ) {$output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);}return $output;
}
function decryptIt( $q ) {if($q==null){return "";}
	if (extension_loaded('openssl')) {return encrypt_decrypt('decrypt', $q);
		}else{$cryptKey  = 'qJB0rGtIn5UB1xG03efyCp';$qDecoded= rtrim( mcrypt_decrypt( MCRYPT_RIJNDAEL_256, md5( $cryptKey ), base64_decode( $q ), MCRYPT_MODE_CBC, md5( md5( $cryptKey ) ) ), "\0");return( $qDecoded );}
	}
function encryptIt( $q ) {if($q==null){return "";}
	if (extension_loaded('openssl')) {return encrypt_decrypt('encrypt', $q);
		}else{$cryptKey  = 'qJB0rGtIn5UB1xG03efyCp';$qEncoded= base64_encode( mcrypt_encrypt( MCRYPT_RIJNDAEL_256, md5( $cryptKey ), $q, MCRYPT_MODE_CBC, md5( md5( $cryptKey ) ) ) );return( $qEncoded );}
	}
function arrayCastRecursive($array){if (is_array($array)) {foreach ($array as $key => $value) {if (is_array($value)) {$array[$key] = arrayCastRecursive($value);}if ($value instanceof stdClass) {$array[$key] = arrayCastRecursive((array)$value);}}}if ($array instanceof stdClass) {
return arrayCastRecursive((array)$array);}return $array;}		
function num_form($bnr,$ze=2,$del=','){$bnr=(DOUBLE)$bnr;return number_format( $bnr, $ze,$del, ' ');}
function makesafe($arr){$xx=array();foreach($arr as $key=>$val){$val=@trim($val);$val=strip_tags($val);$val=addslashes($val);$val=htmlentities($val);$xx[$key]=$val;}return $xx;}
function demake($arr){$xx=array();foreach($arr as $key=>$val){$val=($val);$val=($val);$val=($val);$val=@trim($val);$val=str_replace("’","'",$val);$xx[$key]=$val;}return $xx;}
function makesafestr($val){$val=addslashes($val);$val=@trim($val);$val=strip_tags($val);$val=htmlspecialchars_decode($val);$val=html_entity_decode($val);return $val;}
function FR2SQL ($date){if($date!=""){$datee = explode('/',$date);$date = $datee[2].'-'.$datee[1].'-'.$datee[0]; return $date;}}
function SQL2FR ($date){if($date!=""){$datee = explode('-',$date);$date = $datee[2].'/'.$datee[1].'/'.$datee[0];return $date;}}
function reArrayFiles($file_post) {$file_ary = array();$file_count = count($file_post['name']);$file_keys = array_keys($file_post);for ($i=0; $i<$file_count; $i++) {foreach ($file_keys as $key) {$file_ary[$i][$key] = $file_post[$key][$i];}}return $file_ary;}
ob_get_contents();
?>