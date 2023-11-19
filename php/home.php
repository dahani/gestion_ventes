<?php include_once("cn.php"); 
if(chekAjax()){
	 if($_REQUEST['action']=="ventes"){$DATAX=[];$DATE=date("Y-m-d");
		 
		$res=SQL_QUERY("SELECT c.name,SUM(ifnull(total,0))  cnt,'' as icon FROM  ".COMPTE." c LEFT JOIN ".COMMANDES." cmd ON cmd.id_creator=c.id WHERE c.id<>0  AND date_vente=:DATE GROUP BY 1 ",array(":DATE"=>$DATE));
		if($res['test']){$DATAX['totals']=$res['data'];}
		
		$res=SQL_QUERY("SELECT mode_p as mois,SUM(total)as cnt FROM `".COMMANDES."` c  WHERE  date_vente=:DATE GROUP by mois",array(":DATE"=>$DATE));
		if($res['test']==true){$types=getStConfig(MODE_P);$total=0;
			foreach($res['data'] as $r){
				$total+=$r['cnt'];
				$DATAX['dp'][]=["icon"=>"coins","name"=>isset($types[$r['mois']])?html_entity_decode($types[$r['mois']]):'----',"cnt"=>(DOUBLE)$r['cnt']];
			}
			$DATAX['dp'][]=["icon"=>"coins","name"=>"Total recette","cnt"=>(DOUBLE)$total];
		}
		
		
		$res=SQL_QUERY("SELECT  count(*)as cnt FROM  `".COMMANDES."`  WHERE date_vente=:DATE  ",array(":DATE"=>$DATE));
		if($res['test']==true){
			if(isset($res['data'][0])){$DATAX['dp'][]=["icon"=>"beauty","name"=>"Clients servis","cnt"=>$res['data'][0]['cnt']];}
		}
		/*detail recette*/
		$tt=SQL_QUERY("SELECT p.name,SUM(total) tt FROM `".COMMANDES."` c LEFT JOIN ".MODE_P." p on p.id=c.mode_p WHERE  date_vente=:DATE GROUP BY mode_p",array(":DATE"=>$DATE));
		if($tt['test']==true){$DATAX['dt']=$tt['data'];}
		
		/*crédit encaisser*/
		$cr=SQL_QUERY("SELECT m.name,SUM(mtn)tt FROM `".PAY."` c LEFT JOIN ".MODE_P." m ON m.id=c.mode WHERE date_=:DATE AND id_cmd IN(SELECT id from ".COMMANDES." WHERE mode_p=3) GROUP BY mode ",array(":DATE"=>$DATE));
		if($cr['test']==true){$DATAX['cr']=$cr['data'];}
		
		/*detail depense*/
		$tt=SQL_QUERY("SELECT p.name,SUM(mtn) tt FROM `".DEPENSES."` c LEFT JOIN ".TYPE_DEP." p on p.id=c.nature WHERE  date_=:DATE GROUP BY nature",array(":DATE"=>$DATE));
		if($tt['test']==true){$DATAX['dep']=$tt['data'];}
		
		/*caisee espèce*/
		$tt=SQL_QUERY("SELECT SUM(total) mt FROM `".COMMANDES."` WHERE mode_p=1 AND  date_vente=:DATE UNION
		SELECT SUM(mtn)mt FROM `".PAY."` c  WHERE mode=1 AND date_=:DATE AND id_cmd IN(SELECT id from ".COMMANDES." WHERE mode_p=3) GROUP BY mode UNION
		SELECT SUM(mtn) mt FROM `".DEPENSES."` WHERE date_=:DATE 
		",array(":DATE"=>$DATE));
		if($tt['test']==true){
			$DATAX['cais']=['esp'=>@(DOUBLE)$tt['data'][0]['mt'],'cr'=>@(DOUBLE)$tt['data'][1]['mt'],'dep'=>@(DOUBLE)$tt['data'][2]['mt']];
			}
		
		$res=SQL_QUERY("SELECT c.name,count(id_pr)cnt FROM `".VENTES."` a LEFT JOIN ".CATS." c ON c.id=a.id_pr GROUP BY a.id_pr ORDER by cnt DESC LIMIT 0,5");
		if($res['test']==true){$DATAX['top']=$res['data'];}
		
		
		echoJson(array("test"=>true,"data"=>$DATAX));

	}
}else{echoJson(array("test"=>false,"errors"=>"server not authorized"));exit;}
