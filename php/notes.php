<?php include_once("cn.php"); 
require_once('../vendor/autoload.php');
$client = new \GuzzleHttp\Client();
define("ID_SESSION",$_SESSION[KSJZXID]);define('PAGE_SIZE',10);define("URL",'../img/notes/');
if(chekAjax()){
	$EXTRA=["web_buttons"=>[["id" => "like-button",
        "text" => "Lire Notification",
        "icon" => "https://www.kompassit.com/apps/maroc_competence/email.png",
        "url" => "https://www.kompassit.com/apps/maroc_competence/#/home"]]];
	function loads(){
		$js = json_decode(file_get_contents("php://input"),true);
		$page=isset($js['pg'])?$js['pg']:$_REQUEST['p'];
		if($page){
		$total= SQL_GET_TABLE_SIZE(NOTES);
		$newdata=array();
		$start=getPage($page,PAGE_SIZE,$total);
		
		$res=SQL_QUERY("SELECT n.*,c.name FROM `".NOTES."` n LEFT JOIN ".COMPTE." c ON c.id=n.writer ORDER BY date_ DESC  LIMIT  $start,".PAGE_SIZE);
		if($res['test']==false){
			echoJson(array("test"=>false,'errors'=>$res['errors']));exit;
		}else{
			foreach($res['data'] as $f){$f=demake($f);
			$f['tt']=link_it($f['text']);
			$newdata[]=$f;}
			return array("d"=>$newdata,"count"=>(int)$total);
		}
		}else{echoJson(array("test"=>false,"errors"=>"No params"));exit;}
	}
	 if($_REQUEST['action']=="loadNotes"){echoJson(array("test"=>true,"data"=>loads()));
	}else if($_REQUEST['action']=="save_edit_Note"){
		 $js = json_decode($_REQUEST['info'],true);unset($js['name'],$js['tt']);
		 
			 if(isset($_FILES['img']) and $_FILES['img']['error']==0){$f=$_FILES['img'];
		$f['name']=file_exists(URL.$f['name'])?time().$f['name']:$f['name'];
		if(!move_uploaded_file($f['tmp_name'],URL.$f['name']) OR $f['error']>0){echoJson(array("test"=>false,"errors"=>"Error uploading image"));exit;}else{
		if(isset($js['id'])){if(file_exists(URL.$js['img']) and is_file(URL.$js['img'])){unlink(URL.$js['img']);}}
		$js['img']=$f['name'];
		}
		}
			 if(isset($js['id'])){
				 $res=SQL_UPDATE(NOTES,$js,"id",$js['id']);
			 }else{
				 $js['writer']=ID_SESSION;
				 $res=SQL_ADD(NOTES,$js);
	
   
	
	if(isDateInFuture($data['date_'])){	 
		$notif=["heading"=>$js['text'], "message"=>"Maroc Compétence(".$_SESSION['data']['name'].")"];
		$EXTRA['included_segments']=array('Subscribed Users');
			SendNotification($notif,$EXTRA);}
    
			 }
		if($res['test']==true){
			echoJson(array("test"=>true,"data"=>loads()));
		}else{
			echoJson(array("test"=>false,"errors"=>$res['errors']));
		}
		
	}else  if($_REQUEST['action']=="deleteNote"){
		$js = json_decode(file_get_contents("php://input"),true);
		
		 if(file_exists(URL.$js['img']) and is_file(URL.$js['img'])){unlink(URL.$js['img']);}
		if($js){$res=SQL_DELETE(NOTES,"id",$js['idx']);
		if($res){
			echoJson(array("test"=>true));
		}else{
			echoJson(array("test"=>false,'errors'=>$res['errors']));
		}
		}
	}
}else{echoJson(array("test"=>false,"errors"=>"server not authorized"));exit;}