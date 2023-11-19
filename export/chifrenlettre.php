<?php 
function chifre_en_lettre($montant, $devise1='', $devise2='')
{
	if(empty($devise1)) $dev1='DIRHAMS';
	else $dev1=$devise1;
	if(empty($devise2)) $dev2='CENTIMES';
	else $dev2=$devise2;
	$valeur_entiere=intval($montant);
	$valeur_decimal=intval(round($montant-intval($montant), 2)*100);
	$dix_c=intval($valeur_decimal%100/10);
	$unite_c= intval($valeur_decimal%10/1);
	$cent_c=0;//intval($valeur_decimal%100/10);
	$unite[1]=$valeur_entiere%10;
	$dix[1]=intval($valeur_entiere%100/10);
	$cent[1]=intval($valeur_entiere%1000/100);
	$unite[2]=intval($valeur_entiere%10000/1000);
	$dix[2]=intval($valeur_entiere%100000/10000);
	$cent[2]=intval($valeur_entiere%1000000/100000);
	$unite[3]=intval($valeur_entiere%10000000/1000000);
	$dix[3]=intval($valeur_entiere%100000000/10000000);
	$cent[3]=intval($valeur_entiere%1000000000/100000000);
	$chif=array('', 'UN', 'DEUX', 'TROIS', 'QUATRE', 'CINQ', 'SIX', 'SEPT', 'HUIT', 'NEUF', 'DIX', 'ONZE', 'DOUZE', 'TREIZE', 'QUATORZE', 'QUINZE', 'SEIZE', 'DIX SEPT', 'DIX HUIT', 'DIX NEUF');
		$secon_c='';
		$trio_c='';
	for($i=1; $i<=3; $i++){
		$prim[$i]='';
		$secon[$i]='';
		$trio[$i]='';
		if($dix[$i]==0){
			$secon[$i]='';
			$prim[$i]=$chif[$unite[$i]];
		}
		else if($dix[$i]==1){
			$secon[$i]='';
			$prim[$i]=$chif[($unite[$i]+10)];
		}
		else if($dix[$i]==2){
			if($unite[$i]==1){
			$secon[$i]='VINGT ET';
			$prim[$i]=$chif[$unite[$i]];
			}
			else {
			$secon[$i]='VINGT';
			$prim[$i]=$chif[$unite[$i]];
			}
		}
		else if($dix[$i]==3){
			if($unite[$i]==1){
			$secon[$i]='TRENTE ET';
			$prim[$i]=$chif[$unite[$i]];
			}
			else {
			$secon[$i]='TRENTE';
			$prim[$i]=$chif[$unite[$i]];
			}
		}
		else if($dix[$i]==4){
			if($unite[$i]==1){
			$secon[$i]='QUARANTE ET';
			$prim[$i]=$chif[$unite[$i]];
			}
			else {
			$secon[$i]='QUARANTE';
			$prim[$i]=$chif[$unite[$i]];
			}
		}
		else if($dix[$i]==5){
			if($unite[$i]==1){
			$secon[$i]='CINQUANTE ET';
			$prim[$i]=$chif[$unite[$i]];
			}
			else {
			$secon[$i]='CINQUANTE';
			$prim[$i]=$chif[$unite[$i]];
			}
		}
		else if($dix[$i]==6){
			if($unite[$i]==1){
			$secon[$i]='SOIXANTE ET';
			$prim[$i]=$chif[$unite[$i]];
			}
			else {
			$secon[$i]='SOIXANTE';
			$prim[$i]=$chif[$unite[$i]];
			}
		}
		else if($dix[$i]==7){
			if($unite[$i]==1){
			$secon[$i]='SOIXANTE ET';
			$prim[$i]=$chif[$unite[$i]+10];
			}
			else {
			$secon[$i]='SOIXANTE';
			$prim[$i]=$chif[$unite[$i]+10];
			}
		}
		else if($dix[$i]==8){
			if($unite[$i]==1){
			$secon[$i]='QUATRE-VINGTS ET';
			$prim[$i]=$chif[$unite[$i]];
			}
			else {
			$secon[$i]='QUATRE-VINGT';
			$prim[$i]=$chif[$unite[$i]];
			}
		}
		else if($dix[$i]==9){
			if($unite[$i]==1){
			$secon[$i]='QUATRE-VINGTS ET';
			$prim[$i]=$chif[$unite[$i]+10];
			}
			else {
			$secon[$i]='QUATRE-VINGTS';
			$prim[$i]=$chif[$unite[$i]+10];
			}
		}
		if($cent[$i]==1) $trio[$i]='CENT';
		else if($cent[$i]!=0 || $cent[$i]!='') $trio[$i]=$chif[$cent[$i]] .' CENTS';
	}
	
	
$chif2=array('', 'DIX', 'VINGT', 'TRENTE', 'QUARANTE', 'CINQUANTE', 'SOIXANTE', 'SOIXANTE-DIX', 'QUATRE-VINGTS', 'QUATRE-VINGTS DIX');

	if($valeur_decimal>10 && $valeur_decimal<20) 
	{
		$secon_c = $chif[$valeur_decimal];
	}
	else 	
	{
		if($valeur_decimal>70 and $valeur_decimal<80)
		{
			//5555555
			$secon_c=$chif2[$dix_c-1].' '.$chif[$unite_c+10];
		}
		else
		{
			if($valeur_decimal>90 and $valeur_decimal<100)
		{
			//5555555
			$secon_c=$chif2[$dix_c-1].' '.$chif[$unite_c+10];
		}
		else
		{
		$secon_c=$chif2[$dix_c].' '.$chif[$unite_c];
		}
		}
		}
	if($cent_c==1) $trio_c='CENT';
	else if($cent_c!=0 || $cent_c!='') $trio_c=$chif[$cent_c] .' CENTS';
	
	if(($cent[3]==0 || $cent[3]=='') && ($dix[3]==0 || $dix[3]=='') && ($unite[3]==1)) 
		$e1 =  $trio[3]. '  ' .$secon[3]. ' ' . $prim[3]. ' MILLION ';
	else if(($cent[3]!=0 && $cent[3]!='') || ($dix[3]!=0 && $dix[3]!='') || ($unite[3]!=0 && $unite[3]!=''))
		$e1 = $trio[3]. ' ' .$secon[3]. ' ' . $prim[3]. ' MILLIONS ';
	else
		$e1= $trio[3]. ' ' .$secon[3]. ' ' . $prim[3];
	
	if(($cent[2]==0 || $cent[2]=='') && ($dix[2]==0 || $dix[2]=='') && ($unite[2]==1)) 
		$e2 = ' MILLE ';
	else if(($cent[2]!=0 && $cent[2]!='') || ($dix[2]!=0 && $dix[2]!='') || ($unite[2]!=0 && $unite[2]!=''))
		$e2 = $trio[2]. ' ' .$secon[2]. ' ' . $prim[2]. ' MILLES ';
	else
		$e2 = $trio[2]. ' ' .$secon[2]. ' ' . $prim[2];
	
	$e3 =  $trio[1]. ' ' .$secon[1]. ' ' . $prim[1];
	
	$e4 =  ' '. $dev1 .' ' ;
	

	if(($cent_c=='0' || $cent_c=='') && ($dix_c=='0' || $dix_c=='') && ($unite_c=='0' || $unite_c==''))
		$e5 =""; //' ET ZERO '. $dev2;
	else 
		$e5 = $trio_c. ' ' .$secon_c. ' ' . $dev2;
		
		$e = $e1 . $e2 . $e3 . $e4 . $e5 ;
		return $e;
}
?>