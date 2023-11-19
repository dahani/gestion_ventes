<?php

require '../../vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use \PhpOffice\PhpSpreadsheet\Cell\DataType;
//use \PhpOffice\PhpSpreadsheet\IOFactory;
$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load("tmp.xls");
$objPHPExcel = $spreadsheet->getActiveSheet();
$info=json_decode(file_get_contents("../../php/json/infos.json"));
$spreadsheet->getProperties()->setCreator("KOMPASSIT SARL")
 ->setLastModifiedBy("KOMPASSIT")
 ->setTitle("Liste des fournisseurs")
 ->setSubject("Liste des fournisseurs")
 ->setDescription("fournisseurs document for Office 2007 XLSX, generated using PHP classes.")
 ->setKeywords("office 2007 openxml php")
 ->setCategory("kompassit SARL");
  require('../../php/cn.php');
  $date="";
 $data=SQL_SELECT(FOURNISSEURS,"1",1,"  ORDER BY nom ASC");
 if($data['test']==false || count($data['data'])==0){die('<i>Erreure 305 liste vide</i>');}
	$spreadsheet->setActiveSheetIndex(0)->setCellValue('A1',"Nom")->setCellValue('B1',"I.F")->setCellValue('C1',"Tel ")
	->setCellValue('D1',"CIN")->setCellValue('E1',"Email")->setCellValue('F1',"Ville");
$i=2;
foreach($data['data'] as $f){
$f=demake($f); 
$spreadsheet->setActiveSheetIndex(0)
->setCellValueExplicit('A'.$i,strtoupper($f['nom']),DataType::TYPE_STRING)
->setCellValueExplicit('B'.$i,($f['iff']),DataType::TYPE_STRING)
->setCellValueExplicit('C'.$i,Phone($f['tel']),DataType::TYPE_STRING)
->setCellValueExplicit('D'.$i,($f['cin']),DataType::TYPE_STRING)
->setCellValueExplicit('E'.$i,$f['email'],DataType::TYPE_STRING)
->setCellValueExplicit('F'.$i,$f['ville'],DataType::TYPE_STRING);
$i++;
}

$spreadsheet->getActiveSheet()->setTitle("fournisseurs");
ob_end_clean();
header("Content-Disposition: attachment;filename=fournisseurs.xls");
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