<?php  include_once("cn.php"); 
define("ID_SESSION",$_SESSION[KSJZXID]);define("URL","../img/profiles/");
if(chekAjax()){
	 if($_REQUEST['action']=="save"){
		$js = json_decode(file_get_contents("php://input"));
		if($js){$data=arrayCastRecursive($js->d);unset($data['last'],$data['idx'],$data['event']);
		$res=SQL_UPDATE(COMPTE,$data,'id',ID_SESSION);
		if($res['test']){$_SESSION["data"]['name']=$data['name'];
		/*$_SESSION["data"]['email']=$data['email'];$_SESSION["data"]['service']=$data['service'];$_SESSION["data"]['tel']=$data['tel'];*/
			echoJson(array("test"=>true));
		}else{echoJson(array("test"=>false,"errors"=>$res['errors']));}
		}else{echoJson(array("test"=>false,"errors"=>"No params"));exit;}
	}else if($_REQUEST['action']=="photo"){
		$f=$_FILES['files'];
		$f['name']=file_exists(URL.$f['name'])?time().$f['name']:$f['name'];
		if(move_uploaded_file($f['tmp_name'],URL.$f['name'])){
			$res=SQL_UPDATE(COMPTE,array("src"=>$f['name']),'id',ID_SESSION);
			if($res['test']){if(file_exists(URL.$_REQUEST['src'])){unlink(URL.$_REQUEST['src']);}
			$_SESSION['data']['src']=$f['name'];
				echoJson(array("test"=>true,"src"=>$f['name']));
			}else{
				echoJson(array("test"=>false));
			}
		}
	}else if($_REQUEST['action']=="updatepass"){
		$js = json_decode(file_get_contents("php://input"));
		if($js){$pass=setPasword($js->d->pass);$npass=setPasword($js->d->npass);$email=makesafestr($js->d->email);
			$res=SQL_SELECT(COMPTE,"id",ID_SESSION);
			if($res['test']==true){$res=$res['data'][0];
			 if($res['pass']===$pass){
				$res=SQL_UPDATE(COMPTE,array("pass"=>$npass,"email"=>$email),'id',ID_SESSION);
				if($res['test']){
					echoJson(array("test"=>true));
				}else{
					echoJson(array("test"=>false));
				}
			}else{
				echoJson(array("test"=>false,"errors"=>"L'ancien mot de passe incorrect"));
			}
			}
		}else{
			echoJson(array("test"=>false,"errors"=>"No params"));exit;
		}
	}
}else{echoJson(array("test"=>false,"errors"=>"server not authorized"));exit;}