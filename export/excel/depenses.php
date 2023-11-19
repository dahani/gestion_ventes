<?php

require '../../vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use \PhpOffice\PhpSpreadsheet\Cell\DataType;
use \PhpOffice\PhpSpreadsheet\IOFactory;
$spreadsheet = IOFactory::load("tmp.xls");
$objPHPExcel = $spreadsheet->getActiveSheet();
$info=json_decode(file_get_contents("../../php/json/infos.json"));
$spreadsheet->getProperties()->setCreator("KOMPASSIT SARL")
 ->setLastModifiedBy("KOMPASSIT")
 ->setTitle("Liste des Dépenses")
 ->setSubject("Liste des Dépenses")
 ->setDescription("Dépenses document for Office 2007 XLSX, generated using PHP classes.")
 ->setKeywords("office 2007 openxml php")
 ->setCategory("kompassit SARL");
  require('../../php/cn.php');
  $date="";
$_REQUEST['id']=!isset($_REQUEST['id'])?date("Y"):$_REQUEST['id'];
if(isset($_REQUEST['m'])){if($_REQUEST['m']!="-1"){$date.=" AND MONTH(d.`date_`)='{$_REQUEST['m']}'";}}
if(isset($_REQUEST['t'])){if($_REQUEST['t']!="-1" and $_REQUEST['t']!=""){$date.=" AND nature=".$_REQUEST['t'];}}
$data=SQL_QUERY("SELECT d.*,c.name as cr FROM `".DEPENSES."` d  LEFT JOIN ".COMPTE." c ON c.id=d.id_creator WHERE YEAR(d.date_)=:Y  $date",array(":Y"=>$_REQUEST['id']));
if($data['test']==false){
	die("Error...!");
}
	$spreadsheet->setActiveSheetIndex(0)->setCellValue('A1',"Date")->setCellValue('B1',"Montant ")
	->setCellValue('C1',"Nature")->setCellValue('D1',"Motif")->setCellValue('E1',"Crée Par");
$i=2;$types=getStConfig(TYPE_DEP);
foreach($data['data'] as $f){
$f=demake($f); $f['nrt']=isset($types[$f['nature']])?$types[$f['nature']]:'----';
$spreadsheet->getActiveSheet()
->setCellValueExplicit('A'.$i,SQL2FR($f['date_']),DataType::TYPE_STRING)
->setCellValueExplicit('B'.$i,($f['mtn']),DataType::TYPE_NUMERIC)
->setCellValueExplicit('C'.$i,($f['nrt']),DataType::TYPE_STRING)
->setCellValueExplicit('D'.$i,$f['motif'],DataType::TYPE_STRING)
->setCellValueExplicit('E'.$i,$f['cr'],DataType::TYPE_STRING);
$i++;
}
$spreadsheet->getActiveSheet()->setTitle("Dépenses");
ob_end_clean();
header("Content-Disposition: attachment;filename=Dépenses.xls");
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Cache-Control: max-age=0');
header('Cache-Control: max-age=1');
header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT');
header ('Cache-Control: cache, must-revalidate');
header ('Pragma: public');
//$writer = IOFactory::createWriter($spreadsheet, 'Xls');
$objWriter = new Xls($spreadsheet);
$objWriter->save('php://output');
exit;