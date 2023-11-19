<?php include_once("cn.php"); 
define("ID_SESSION",$_SESSION[KSJZXID]);
if(chekAjax()){
	if($_REQUEST['action']=="saveAuto"){
		$js = json_decode(file_get_contents("php://input"));
		if($js){
			$_SESSION[CONFIG]=$js->data;
		$res=SQL_UPDATE(COMPTE,array("config"=>json_encode($_SESSION[CONFIG])),"id",$_SESSION[KSJZXID]);
		if($res['test']==true){
			echoJson(array("test"=>true));
		}else{
			echoJson(array("test"=>false,"errors"=>$res['errors']));
		}}
	}else if($_REQUEST['action']=="saveAccount"){
		$js = json_decode(file_get_contents("php://input")); 
		if($js){
			if(isset($js->data->id)){$data=arrayCastRecursive($js->data);
				if(isset($js->data->pass) && $js->data->pass!=""){$data['pass']=setPasword($js->data->pass);}
				$data['active']=@$data['active']==true?1:0;$data['admin']=@$data['admin']==true?1:0;
				
				$idx=$data['id'];unset($data['iddd'],$data['id'],$data['createime']);$data['menus']=json_encode($data['menus'],JSON_UNESCAPED_UNICODE );
				$res=SQL_UPDATE(COMPTE,$data,"id",$idx);
			}else{
				$data=array("name"=>$js->data->name."","email"=>$js->data->email."","pass"=>setPasword($js->data->pass),"active"=>true,"menus"=>json_encode($js->data->menus,JSON_UNESCAPED_UNICODE ),"config"=>'{"AutoD":{"active":false,"time":"3"},"header":"1","theme":{"bgcolor":"#00897b","primarycolor":"#ffffff","fontsize":16,"fontfamily":"Roboto"}}');
				$data['src']=GetRandomImage();
				$res=SQL_ADD(COMPTE,$data);
			}
			if($res['test']==true){
			$res=SQL_QUERY("SELECT id,email,name,active,menus,createime FROM `".COMPTE."` WHERE id<>0 AND  id<>".$_SESSION[KSJZXID]);
			$newdata=array();foreach($res['data'] as $d){$d=demake($d);$d['active'];$d['active']=(BOOLEAN)$d['active'];$d['menus']=json_decode($d['menus']);$newdata[]=$d;}
			echoJson(array("test"=>true,"data"=>$newdata));
		}else{
			echoJson(array("test"=>false,"errors"=>$res['errors']));
		}
		}
	}if($_REQUEST['action']=="loadAccountx"){
		$res=SQL_QUERY("SELECT id,email,name,active,menus,createime,admin,src FROM `".COMPTE."` WHERE id<>0  AND id<>".$_SESSION[KSJZXID]);
		$newdata=array();
		foreach($res['data'] as $d){$d=demake($d);$d['active']=(BOOLEAN)$d['active'];$d['admin']=(BOOLEAN)$d['admin'];$d['menus']=json_decode($d['menus']);$newdata[]=$d;}
		if($res['test']==true){$menu=file_get_contents("json/menu.json");$menu=$menu?json_decode($menu):array();
		
			echoJson(array("test"=>true,"data"=>$newdata,"menu"=>$menu));
		}else{echoJson(array("test"=>false,"errors"=>$res['errors']));}
	}else if($_REQUEST['action']=="photo"){
		$f=$_FILES['files'];define("URL","../downloads/");
		$f['name']=file_exists(URL.$f['name'])?time().$f['name']:$f['name'];
		if(move_uploaded_file($f['tmp_name'],URL.$f['name'])){
			$f=fopen("json/biblio.json","w+");
		if(fputs($f,($_REQUEST['files']))){fclose($f);}
			echoJson(array("test"=>true,"data"=>($_REQUEST['files'])));	
		}
	}else if($_REQUEST['action']=="setActive"){
		$js = json_decode(file_get_contents("php://input"));
		if($js){
			$res=SQL_UPDATE(COMPTE,array("active"=>(DOUBLE)$js->active),"id",$js->id);
			if($res['test']==true){
				echoJson(array("test"=>true));
			}else{
				echoJson(array("test"=>false,"errors"=>$res['errors']));
			}
		}
	}else if($_REQUEST['action']=="setAdmin"){
		$js = json_decode(file_get_contents("php://input"));
		if($js){
			$res=SQL_UPDATE(COMPTE,array("admin"=>(DOUBLE)$js->admin),"id",$js->id);
			if($res['test']==true){
				echoJson(array("test"=>true));
			}else{
				echoJson(array("test"=>false,"errors"=>$res['errors']));
			}
		}
	}else if($_REQUEST['action']=="deleteAccount"){
		$js = json_decode(file_get_contents("php://input"));
		if($js){
			$res=SQL_DELETE(COMPTE,"id",$js->id);
			if($res['test']==true){
				echoJson(array("test"=>true));
			}else{
				echoJson(array("test"=>false,"errors"=>$res['errors']));
			}
		}
	}
}else{echoJson(array("test"=>false,"errors"=>"server not authorized"));exit;}