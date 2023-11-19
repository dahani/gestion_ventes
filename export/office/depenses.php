<?php
 include("../../php/cn.php");
 require_once '../../vendor/autoload.php';
 use \PhpOffice\PhpWord\PhpWord;
 use \PhpOffice\PhpWord\TemplateProcessor;
 
$date="";$_REQUEST['id']=!isset($_REQUEST['id'])?date("Y"):$_REQUEST['id'];
if(isset($_REQUEST['m'])){if($_REQUEST['m']!="-1"){$date.=" AND MONTH(d.`date_`)='{$_REQUEST['m']}'";}}
if(isset($_REQUEST['t'])){if($_REQUEST['t']!="-1" and $_REQUEST['t']!=""){$date.=" AND nature=".$_REQUEST['t'];}}
$data=SQL_QUERY("SELECT d.*,c.name as cr FROM `".DEPENSES."` d LEFT JOIN ".COMPTE." c ON c.id=d.id_creator WHERE YEAR(d.date_)=:Y  $date",array(":Y"=>$_REQUEST['id']));

	if($data['test']==false){
	die("Error...!");
}

$phpWord = new PhpWord();
$doc = new TemplateProcessor("depenses.docx");
$doc->setValue('dtx',date('d/m/Y H:i:s'));$doc->setValue('cr',$_SESSION['data']['name']);
$values=array();$types=getStConfig(TYPE_DEP);
foreach($data['data'] as $f){
$f=demake($f); $f['nrt']=isset($types[$f['nature']])?$types[$f['nature']]:'----';
$f['date_']=SQL2FR($f['date_']);
$f['mtn']=num_form($f['mtn']);
$values[]=$f;
}

$doc->cloneRowAndSetValues('date_',$values);
ob_end_clean();
header("Content-Description: File Transfer");
header('Content-Disposition: attachment; filename="Dépenses('.count($data['data']).').docx"');
header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
header('Content-Transfer-Encoding: binary');
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
header('Expires: 0');
$doc->saveAs('php://output');