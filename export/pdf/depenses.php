<?php  include("../../php/cn.php");
   require_once '../../vendor/autoload.php';
   use Spipu\Html2Pdf\Html2Pdf;
use Spipu\Html2Pdf\Exception\Html2PdfException;
use Spipu\Html2Pdf\Exception\ExceptionFormatter;
$date="";

$_REQUEST['id']=!isset($_REQUEST['id'])?date("Y"):$_REQUEST['id'];
if(isset($_REQUEST['m'])){if($_REQUEST['m']!="-1"){$date.=" AND MONTH(d.`date_`)='{$_REQUEST['m']}'";}}
if(isset($_REQUEST['t'])){if($_REQUEST['t']!="-1" and $_REQUEST['t']!=""){$date.=" AND nature=".$_REQUEST['t'];}}
$data=SQL_QUERY("SELECT d.*,c.name as cr FROM `".DEPENSES."` d LEFT JOIN ".COMPTE." c ON c.id=d.id_creator WHERE YEAR(d.date_)=:Y  $date",array(":Y"=>$_REQUEST['id']));
if($data['test']==false){
	die("Error...!");
}
$data=$data['data'];
$info=json_decode(file_get_contents("../../php/json/infos.json"));ob_end_clean();ob_start();
?>
<style>
.page_header{padding:1px 15px;width: 100%;border-bottom:1px solid #989898}
table.page_footer {width: 100%; border: none;padding:5px; border-top: solid 1px #000;}
.table {color:#000;width:100%;font-size:15px;;-moz-border-radius:3px;-webkit-border-radius:3px;border-radius:3px;-moz-box-shadow: 0 1px 2px #d1d1d1;-webkit-box-shadow: 0 1px 2px #d1d1d1;box-shadow: 0 1px 2px #d1d1d1;}
.table th {}
.table td{vertical-align: middle;background: #fafafa;;background: -webkit-gradient(linear, left top, left bottom, from(#fbfbfb), to(#fafafa));background: -moz-linear-gradient(top,  #fbfbfb,  #fafafa);word-wrap: break-word;white-space: normal;padding:5px 5px;}
.table th{padding:5px 5px;background:#bbb2b2}
	</style>
<page backtop="35mm" backbottom="10mm" backleft="2mm" backright="2mm" style="font-size: 12pt" >
<page_header>
  <table class="page_header" style="width: 100%; " >
		 <tr >
			<td style="text-align: left;    width: 30%" ><img style="width:100px" src="../../img/logo.webp" /></td>
			<td style="text-align: center;    width: 60%"><h2>Liste des Dépenses (<?php echo count($data);?>) [<?php echo (@$_REQUEST['m']!="-1"?@$_REQUEST['m']."/":'').$_REQUEST['id']; ?>]</h2></td>
			<td style="width: 10%;text-align:right"><h2></h2></td>	
		</tr>
	</table>
</page_header>
<page_footer>
        <table class="page_footer">
            <tr>
				<td style="width: 33.33%; text-align: left">Générer par <?=$_SESSION['data']['name']."(".$info->name.")"  ?></td>     
				<td style="width: 33.33%; text-align: center"><?=date('d/m/Y H:i:s')?></td>  				
			   <td style="width: 33.33%; text-align: right">[[page_cu]]/[[page_nb]]</td>
            </tr>
        </table>
    </page_footer>
   <div style="padding:2px">
		<table border="0.2" cellspacing="0" align="center"  cellpadding="0"    class="table" style="margin-left:1px!important" >
					<thead>
					<tr>				
						<th style="width:22px">N°</th><th >Date</th>
						<th>Montant</th>
						<th >Nature</th>
						<th >Motif</th>
					</tr>
				</thead>
				<tbody>
						<?php $i=1; $types=getStConfig(TYPE_DEP);$tt=0;
						foreach($data as $r){$r=demake($r);$r['nrt']=isset($types[$r['nature']])?$types[$r['nature']]:'----';
							echo "<tr><td>$i</td><td style='width:12%'>".SQL2FR($r['date_'])."</td>
							
							<td  style='width:10%'>".num_form($r['mtn'])."</td>
							<td style='width:22%'>".($r['nrt'])."</td>
							<td style='width:50%'>".$r['motif']."</td>
							</tr>";
							$i++;$tt+=$r['mtn'];
						}
							echo "<tr><td colspan='4'><b>Total</b></td>
							<td>".num_form($tt)."</td>
							</tr>";
						?>
				</tbody>
					</table>
					</div>
</page>
<?php 
    $content = ob_get_clean();

    try
    {
        $html2pdf = new Html2Pdf('P', 'A4', 'fr', true, 'UTF-8', 0);$html2pdf->writeHTML($content,false);
		$html2pdf->pdf->SetTitle("Dépenses (". count($data).")");
		$nofichier="Dépenses(". count($data).").pdf";$html2pdf->Output($nofichier,'I');
    }
    catch(HTML2PDF_exception $e){echo $e;exit;}