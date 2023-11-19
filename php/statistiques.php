<?php
  include_once("cn.php");
define("ID_SESSION",$_SESSION[KSJZXID]);$infos=file_get_contents("json/infos.json");$infos=json_decode($infos);
if(chekAjax()){
function money_annee(){$DATAD=array();$js = json_decode(file_get_contents("php://input"));$year=isset($js->year)?$js->year:date("Y");
	$res=SQL_QUERY("SELECT MONTH(`date_`)as mois ,SUM(mtn)as tt FROM ".PAY." WHERE YEAR(date_)='$year' GROUP BY mois");
	$MONTS=array();
	if($res['test']==true){
		foreach($res['data'] as $r){$MONTS[$r['mois']]=(DOUBLE)$r['tt'];};$DATAD=mergeDays($MONTS,12);
	}else{return array("test"=>false,"errors"=>$res['errors']);}
	return array("test"=>true,"data"=>$DATAD);
}
function clients_annee(){$DATAD=array();$js = json_decode(file_get_contents("php://input"));$year=isset($js->year)?$js->year:date("Y");
	$res=SQL_QUERY("SELECT MONTH(`date_visite`)as mois,COUNT(*)as tt FROM ".CLIENTS." WHERE YEAR(date_visite)='$year' GROUP BY mois");
	$MONTS=array();
	if($res['test']==true){
		foreach($res['data'] as $r){$MONTS[$r['mois']]=(DOUBLE)$r['tt'];};$DATAD[]=array("name"=>"Date Visite","data"=>mergeDays($MONTS,12));
	}else{return array("test"=>false,"errors"=>$res['errors']);}
	$res=SQL_QUERY("SELECT MONTH(`date_inscrit`)as mois,COUNT(*)as tt FROM ".CLIENTS." WHERE YEAR(date_inscrit)='$year' GROUP BY mois");
	$MONTS=array();
	if($res['test']==true){
		foreach($res['data'] as $r){$MONTS[$r['mois']]=(DOUBLE)$r['tt'];};$DATAD[]=array("name"=>"Date Inscrit.","data"=>mergeDays($MONTS,12));
	}else{return array("test"=>false,"errors"=>$res['errors']);}
	return array("test"=>true,"data"=>$DATAD);
}
function dep_annee(){$DATAD=array();$js = json_decode(file_get_contents("php://input"));$year=isset($js->year)?$js->year:date("Y");
	$cmt=SQL_SELECT(COMPTE,"id",0,"","id,name",'<>');
	if($cmt['test']){
		foreach($cmt['data'] as $d){
			$res=SQL_QUERY("SELECT MONTH(`date_visite`)as mois,COUNT(*)as tt FROM ".CLIENTS." WHERE YEAR(date_visite)='$year' AND id_creator=".$d['id']." GROUP BY mois");$MONTS=array();
		if($res['test']==true){
			foreach($res['data'] as $r){$MONTS[$r['mois']]=(DOUBLE)$r['tt'];};$DATAD[]=array("name"=>$d['name'],"data"=>mergeDays($MONTS,12));
		}
		}
		}
	return array("test"=>true,"data"=>$DATAD);
}
function pub(){
		$js = json_decode(file_get_contents("php://input"));$year=isset($js->year)?$js->year:date("Y");
		$res=SQL_QUERY("SELECT findus as mois,COUNT(*)as nbr FROM `".CLIENTS."` WHERE  1 GROUP by mois");$data=array();
		
		if($res['test']==true){$types=getPubType();
			$i=true;foreach($res['data'] as $r){
			$data[]=array("name"=>isset($types[$r['mois']])?html_entity_decode($types[$r['mois']]):'----',"y"=>(int)$r['nbr'],"sliced"=>false,"selected"=>false);$i=false;
			}
			return array("test"=>true,"data"=>$data);
		}else{return array("test"=>false,"errors"=>$res['errors']);}
}
function Tel(){
		$js = json_decode(file_get_contents("php://input"));$year=isset($js->year)?$js->year:date("Y");
		$res=SQL_QUERY("SELECT id_for as mois,COUNT(*)as nbr FROM `".TELS."` WHERE  1 GROUP by mois");$data=array();
		
		if($res['test']==true){$frm=getStConfig(FORMATIONS);
			$i=true;foreach($res['data'] as $r){
			$data[]=array("name"=>isset($frm[$r['mois']])?html_entity_decode($frm[$r['mois']]):'----',"y"=>(int)$r['nbr'],"sliced"=>false,"selected"=>false);$i=false;
			}
			return array("test"=>true,"data"=>$data);
		}else{return array("test"=>false,"errors"=>$res['errors']);}
}
function from(){
		$js = json_decode(file_get_contents("php://input"));$year=isset($js->year)?$js->year:date("Y");
		$res=SQL_QUERY("SELECT _from as mois,COUNT(*)as nbr FROM `".TELS."` WHERE  1 GROUP by mois");$data=array();
		
		if($res['test']==true){
			$i=true;foreach($res['data'] as $r){
			$data[]=array("name"=>$r['mois'],"y"=>(int)$r['nbr'],"sliced"=>false,"selected"=>false);$i=false;
			}
			return array("test"=>true,"data"=>$data);
		}else{return array("test"=>false,"errors"=>$res['errors']);}
}
function drill1(){
		$js = json_decode(file_get_contents("php://input"));
		$res=SQL_QUERY("SELECT id_form ,SUM(mtn)as tt FROM ".DEPENSES."  GROUP BY id_form");
		$data=array();
		if($res['test']==true){$frm=getStConfig(FORMATIONS);
			foreach($res['data'] as $r){
				$r['frm']=isset($frm[$r['id_form']])?$frm[$r['id_form']]:'----';
				$data['chart'][]=["name"=>$r['frm'],"y"=>(DOUBLE)$r['tt'],"drilldown"=>$r['id_form']];
					$nature=SQL_QUERY("SELECT t.name,SUM(mtn)as tt FROM `".DEPENSES."` d LEFT JOIN ".TYPE_DEP." t ON t.id=d.nature WHERE id_form=:ID GROUP BY nature",['ID'=>$r['id_form']]);
					if($nature['test']==true){
						$tmp=[];
						foreach($nature['data'] as $x){$tmp[]=[$x['name'],(DOUBLE)$x['tt']];};
						$data['drill'][]=["name"=>$x['name'],"id"=>$r['id_form'],"data"=>$tmp];
					}
			}//end foeach
			return array("test"=>true,"data"=>$data);
		}else{return array("test"=>false,"errors"=>$res['errors']);}
}
function drill(){
		$js = json_decode(file_get_contents("php://input"));$type=isset($js->type)?$js->type:"month";global $MONTHS;
		$res=SQL_QUERY("SELECT YEAR(`date_`)as year ,SUM(mtn)as tt FROM ".PAY." WHERE date_ IS NOT NULL GROUP BY year");
		$data=array();
		if($res['test']==true){
			foreach($res['data'] as $r){
				$data['chart'][]=["name"=>$r['year'],"y"=>(DOUBLE)$r['tt'],"drilldown"=>$r['year']];
				if($type=="month"){
					$mois=SQL_QUERY("SELECT DATE_FORMAT(`date_`,'%m')as mois,SUM(mtn)as tt FROM ".PAY." WHERE YEAR(date_)=:M GROUP BY mois ORDER BY mois ",[":M"=>$r['year']]);
					if($mois['test']==true){
						$tmp=[];
						foreach($mois['data'] as $x){$tmp[]=[$MONTHS[$x['mois']],(DOUBLE)$x['tt']];};
						$data['drill'][]=["name"=>$r['year'],"id"=>$r['year'],"data"=>$tmp];
					}
				}else if($type=="staff"){
					$staff=SQL_QUERY("SELECT p.id_creator,SUM(mtn)as tt,c.name as nom FROM ".PAY." p LEFT JOIN ".COMPTE." c ON c.id=p.id_creator WHERE YEAR(date_)=:Y GROUP BY p.id_creator ORDER BY tt",array(":Y"=>$r['year']));
					if($staff['test']==true){
						$tmp=[];
						foreach($staff['data'] as $x){$x['nom']=$x['nom']==null?'Non défini':$x['nom'];$tmp[]=[$x['nom'],(DOUBLE)$x['tt']];};
						$data['drill'][]=["name"=>$r['year'],"id"=>$r['year'],"data"=>$tmp];
					}
				}else if($type=="type"){
					$typex=SQL_QUERY("SELECT f.name,SUM(p.mtn)as tt FROM  ".FORMATIONS." f LEFT JOIN ".CLIENTS." cl  ON cl.id_for=f.id LEFT JOIN ".PAY." p ON p.id_cl=cl.id WHERE YEAR(p.date_)=:M GROUP BY cl.id_for ORDER BY tt ",[":M"=>$r['year']]);
					if($typex['test']==true){
						$tmp=[];
						foreach($typex['data'] as $x){$tmp[]=[html_entity_decode($x['name']),(DOUBLE)$x['tt']];};
						$data['drill'][]=["name"=>$r['year'],"id"=>$r['year'],"data"=>$tmp];
					}
				}
			}//end foeach
			return array("test"=>true,"data"=>$data);
		}else{return array("test"=>false,"errors"=>$res['errors']);}
}
function globall(){$dt=array();global $infos;
	//
	$js = json_decode(file_get_contents("php://input"));$shere="";
	$bg=["deeppurple","red","red","pink","purple","indigo","blue","lightblue","cyan","teal","green","lime","yellow","amber","orange","deeporange","brown","gray"];
		$gl=SQL_QUERY("SELECT COUNT(i.id) cnt,c.name FROM   ".FORMATIONS." c LEFT JOIN `".CLIENTS."` i ON c.id=i.id_for GROUP BY i.id_for");
		if($gl['test']==true){
			$dts=[];
			foreach($gl['data'] as $d){
			$dts[]=['title'=>strtoupper($d['name']),'cnt'=>$d['cnt'],'icon'=>"diploma",'bg'=>$bg[rand(0,count($bg)-1)]];
			}	
			$dt['totals']=$dts;
		}
		if(isset($js->id) and $js->id!="" and $js->id>=0){
			$gl=SQL_QUERY("SELECT COUNT(i.id) cnt,c.name FROM   ".FORMATIONS." c LEFT JOIN `".CLIENTS."` i ON c.id=i.id_for WHERE i.id_creator=".$js->id." GROUP BY i.id_for");
		if($gl['test']==true){
			$dts=[];
			foreach($gl['data'] as $d){
			$dts[]=['title'=>strtoupper($d['name']),'cnt'=>$d['cnt'],'icon'=>"diploma",'bg'=>$bg[rand(0,count($bg)-1)]];
			}	
			$dt['creator']=$dts;
		}
		}
		$br=SQL_QUERY("SELECT COUNT(*)as cnt,findus FROM `".CLIENTS."` GROUP BY findus ORDER BY findus DESC");
		if($br['test']==true){
			$total = 0;foreach ($br['data'] as $k){$total += $k['cnt'];}
			foreach ($br['data'] as $f){
				$dt['percent'][]=array("v"=>num_form($f['cnt']*100/$total,1,','),"color"=>$bg[rand(0,count($bg)-1)],"name"=>"(".$f['cnt'].") ".getPubType($f['findus']),'bg'=>"#FFF");
			}
		}
		$br=SQL_QUERY("SELECT COUNT(*)as cnt, COUNT(if(`inscrit`=1,inscrit,null)) inscri FROM ".CLIENTS);
		if($br['test']==true and isset($br['data'][0])){$dx=$br['data'][0];
			$dt['percent'][]=array("v"=>num_form($dx['inscri']*100/$dx['cnt'],1,','),"color"=>$bg[rand(0,count($bg)-1)],"name"=>"({$dx['inscri']}) Non Inscrit",'bg'=>"#FFF");
		}
		/*
		//sparkline STOCK
		$res=SQL_QUERY("SELECT MONTH(`date_en`)as mois,COUNT(*)as tt FROM ".STOCK." WHERE YEAR(date_en)=:Y GROUP BY mois",array(":Y"=>date("Y")));
		if($res['test']==true){$mnt=array();
			foreach($res['data'] as $r){$mnt[$r['mois']]=(DOUBLE)$r['tt'];};
			$dt['spark'][]=array("title"=>"Lot par mois","data"=>mergeDaysSingle($mnt,12),"color"=>"bgm-blue","type"=>"line");
		}
		//sparkline ACHAT
		$res=SQL_QUERY("SELECT MONTH(`date_en`)as mois,SUM(qn*plot)as tt FROM ".STOCK." WHERE YEAR(date_en)=:Y GROUP BY mois",array(":Y"=>date("Y")));
		if($res['test']==true){$mnt=array();
			foreach($res['data'] as $r){$mnt[$r['mois']]=(DOUBLE)$r['tt'];};
			$dt['spark'][]=array("title"=>"Achats par mois","data"=>mergeDaysSingle($mnt,12),"color"=>"bgm-orange","type"=>"line");
		}
		//sparkline VENTEs
		$res=SQL_QUERY("SELECT MONTH(`date_vente`)as mois,SUM(total)as tt FROM ".COMMANDES." WHERE YEAR(date_vente)=:Y GROUP BY mois",array(":Y"=>date("Y")));
		if($res['test']==true){$mnt=array();
			foreach($res['data'] as $r){$mnt[$r['mois']]=(DOUBLE)$r['tt'];};
			$dt['spark'][]=array("title"=>"Ventes par mois","data"=>mergeDaysSingle($mnt,12),"color"=>"bgm-teal","type"=>"line");
		}
		//sparkline depenses
		$res=SQL_QUERY("SELECT MONTH(`date_`)as mois,SUM(mtn)as tt FROM ".DEPENSES." WHERE YEAR(date_)=:Y GROUP BY mois",array(":Y"=>date("Y")));
		if($res['test']==true){$mnt=array();
			foreach($res['data'] as $r){$mnt[$r['mois']]=(DOUBLE)$r['tt'];};
			$dt['spark'][]=array("title"=>"Dépenses par mois","data"=>mergeDaysSingle($mnt,12),"color"=>"bgm-lightgreen","type"=>"line");
		}*/
		return $dt;
}
		if($_REQUEST['action']=="load"){$DATAS=array();
		$DATAS['globall']=globall();
		$DATAS['clients_annee']=clients_annee();
		$DATAS['money_annee']=money_annee();
		$DATAS['pub']=pub();
		$DATAS['Tel']=Tel();
		$DATAS['from']=from();
		$DATAS['drill']=drill();
		$DATAS['drill1']=drill1();
		$DATAS['dep_annee']=dep_annee();
		echoJson($DATAS);
	}
	else if($_REQUEST['action']=="globall"){echoJson(globall());}
	else if($_REQUEST['action']=="drill"){echoJson(drill());}
	else if($_REQUEST['action']=="drill1"){echoJson(drill1());}
	else if($_REQUEST['action']=="pub"){echoJson(pub());}
	else if($_REQUEST['action']=="Tel"){echoJson(Tel());}
	else if($_REQUEST['action']=="from"){echoJson(from());}
	else if($_REQUEST['action']=="dep_annee"){echoJson(dep_annee());}
	else if($_REQUEST['action']=="money_annee"){echoJson(money_annee());}
	else if($_REQUEST['action']=="clients_annee"){echoJson(clients_annee());}
}else{echoJson(array("test"=>false,"errors"=>"server not authorized"));exit;}