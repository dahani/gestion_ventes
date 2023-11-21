<?php  include("../../php/cn.php");
  require_once '../../vendor/autoload.php';
   use Spipu\Html2Pdf\Html2Pdf;
   use Spipu\Html2Pdf\Exception\Html2PdfException;
   $code=  generateEAN();
   $generator = new Picqer\Barcode\BarcodeGeneratorHTML();
$tmp= $generator->getBarcode($code, $generator::TYPE_CODE_128);
ob_start();
?>
<style>
.table {color:#000;width:100%;font-size:15px;;-moz-border-radius:3px;-webkit-border-radius:3px;border-radius:3px;-moz-box-shadow: 0 1px 2px #d1d1d1;-webkit-box-shadow: 0 1px 2px #d1d1d1;box-shadow: 0 1px 2px #d1d1d1;}
.table td{vertical-align: middle;background: #fafafa;;background: -webkit-gradient(linear, left top, left bottom, from(#fbfbfb), to(#fafafa));background: -moz-linear-gradient(top,  #fbfbfb,  #fafafa);word-wrap: break-word;white-space: normal;padding:10px 8px;}

	</style>
<page backtop="0mm" backbottom="0mm" backleft="0mm" backright="0mm" style="font-size: 12pt" >

   <div style="padding:2px">
		<table  border="0" cellspacing="0" align="center"  cellpadding="0"  class="table" style="margin-left:1px!important" >
						
				<tbody>
						<?php $i=1; 
						for($i=0;$i<=41;$i++){$w=33.3;
						echo "<tr>
							<td  style='width:$w%'>".($tmp)."</td>
							<td  style='width:$w%;border-left:0.2px solid '>".($tmp)."</td>
							<td style='width:$w%;border-left:0.2px solid '>".($tmp)."</td>
							</tr>";
							$i++;
						}
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
		$html2pdf->pdf->SetTitle($code);
		$nofichier=$code.".pdf";$html2pdf->Output($nofichier,'I');
    }
    catch(Html2PdfException $e){echo $e;exit;}