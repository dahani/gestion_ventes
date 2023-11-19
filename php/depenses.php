<?php  include_once("cn.php");
require_once '../vendor/autoload.php';
use Spatie\Image\Image;
define("ID_SESSION",$_SESSION[KSJZXID]);define("URL","../img/ps/");
if(chekAjax()){
	function loaddx(){ 
		$total=0;$js = json_decode(file_get_contents("php://input"));if(!isset($js)){$js=json_decode('{"pg":1,"psiz":10}');}
		 if(!isset($js->q)){$js->q="";}$q=strip_tags($js->q);$q=trim($q);
		 $year=isset($js->year)?$js->year:date('Y');$mois=isset($js->mois)?$js->mois:date('m'); $date=" WHERE  YEAR(d.`date_`)='$year'";
		 $ORDERBY=" ORDER BY id DESC";
		if(isset($js->sort->ord)){$ORDERBY=" ORDER BY {$js->sort->k} ".($js->sort->ord?" DESC":" ASC ");}
		
		if(isset($js->mois)){if($js->mois!="-1"){$date.=" AND MONTH(d.`date_`)='$mois'";}}
		if(isset($js->extra->type)){if($js->extra->type!="-1"){$date.=" AND nature=".$js->extra->type;}}
		if(strlen($q)>0){
			 $SQL="SELECT d.*,c.name as cr FROM `".DEPENSES."` d  LEFT JOIN ".COMPTE." c ON c.id=d.id_creator WHERE  ( `mtn`  LIKE :Q OR d.`motif`  LIKE :Q )  $ORDERBY";
			$count="SELECT count(*)as cnt  FROM  `".DEPENSES."` d LEFT JOIN ".COMPTE." c ON c.id=d.id_creator WHERE  ( s.`nom`  LIKE :Q  OR `mtn`  LIKE :Q OR d.`motif`  LIKE :Q )   ";
			$total= SQL_GET_TABLE_SIZE($count,2,array(":Q"=>'%'.$q.'%'));
		}else{$total= SQL_GET_TABLE_SIZE("SELECT count(*)as cnt  FROM `".DEPENSES."` d    $date",2);}
		$newdata=array();$start = getPage($js->pg,$js->psiz,$total);
		if(strlen($q)>0){
			$data=SQL_QUERY($SQL." LIMIT $start,".$js->psiz,array(":Q"=>'%'.$q.'%'));
		}else if(isset($_REQUEST['id'])){$id=trim($_REQUEST['id']);$id=(INT)$id;
		$data=SQL_QUERY("SELECT d.*,c.name as cr FROM `".DEPENSES."` d LEFT JOIN ".COMPTE." c ON c.id=d.id_creator  WHERE d.id=:ID",array(':ID'=>$id));
		}else{
			$data=SQL_QUERY("SELECT d.*,c.name as cr FROM `".DEPENSES."` d  LEFT JOIN ".COMPTE." c ON c.id=d.id_creator  $date  $ORDERBY LIMIT $start,".$js->psiz);
		}
		if($data['test']==true){$types=getStConfig(TYPE_DEP);
			foreach($data['data'] as $d){$d=demake($d);$d['mtn']=(DOUBLE)$d['mtn'];
			$d['nrt']=isset($types[$d['nature']])?$types[$d['nature']]:'----';
			$d['dt_crt']=strtotime($d['dt_crt'])*1000;$d['dt_update']=strtotime($d['dt_update'])*1000;
			$d['up']=$d['id_creator']==$d['id_updator']?$d['cr']:getcreator($d['id_updator']);
			$d['image']=$d['img']!=""?'<a href="img/ps/'.$d['img'].'"   class="without-caption image-link"><img style="width:55px" src="img/ps/'.$d['img'].'" />  </a>':"<span  class='c-blue f-17 show text-center '>----</span>";
			$newdata[]=$d;
			}return array("d"=>$newdata,"count"=>(int)$total,"test"=>true);
		}else{
			return array("d"=>[],"count"=>0,"test"=>false,"errors"=>$data['errors']);
		}
	}
	if($_REQUEST['action']=="save_edit"){
		 $js = json_decode($_REQUEST['info']);$data=arrayCastRecursive($js); $tmpsrc=isset($data['img'])?$data['img']:"";unset($data['cr'],$data['dt_crt'],$data['dt_update'],$data['up'],$data['nrt'],$data['benif'],$data['image'],$data['frm']);
		if(isset($_FILES['file'])){ $f=$_FILES['file'];$name=pathinfo($f['name'], PATHINFO_FILENAME).".webp";$name=file_exists(URL.$name)?time().$name:$name;
		if(file_exists($f['tmp_name'])){
			$op1=Image::load($f['tmp_name'])->quality(60)->optimize()->save(URL.$name);
			$data['img']=$name;
		}
		}
		if($tmpsrc!=@$data['img']){if(file_exists(URL.$tmpsrc) and is_file(URL.$tmpsrc)){unlink(URL.$tmpsrc);}}
		if(isset($data['id'])){$idx=$data['id'];unset($data['id']);$data['id_updator']=ID_SESSION;$data['dt_update']=date("Y-m-d H:i:s");
		$res=SQL_UPDATE(DEPENSES,$data,"id",$idx);
		}else{$data['id_creator']=ID_SESSION;$data['dt_crt']=date("Y-m-d H:i:s");$res=SQL_ADD(DEPENSES,$data);}
		if($res['test']==true){
			echo echoJson(array("test"=>true,"data"=>loaddx()));
		}else{
			echo echoJson(array("test"=>false,"errors"=>$res['errors']));
		}		
	}else if($_REQUEST['action']=="load"){
		echo echoJson(loaddx());
	}else if($_REQUEST['action']=="delete"){$data = json_decode(file_get_contents("php://input"),true);
		$sq=SQL_QUERY("SELECT img FROM `".DEPENSES."` WHERE `id` IN(".implode(",",$data['dl']).")");
	if($sq['test']==true){
		foreach($sq['data'] as $f){if(file_exists(URL.$f['img']) and is_file(URL.$f['img'])){unlink(URL.$f['img']);}}
	}
		$r=SQL_QUERY("DELETE FROM `".DEPENSES."` WHERE `id` IN(".implode(",",$data['dl']).")");
		echo echoJson(array("data"=>loaddx(),"test"=>true));
	}
}else{echo  echoJson(array("test"=>false,"errors"=>"server not authorized"));exit;}