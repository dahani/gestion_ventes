<?php
require '../vendor/autoload.php';
 $code=  generateEAN();

// This will output the barcode as HTML output to display in the browser
$generator = new Picqer\Barcode\BarcodeGeneratorHTML();
$tmp= $generator->getBarcode($code, $generator::TYPE_CODE_128);


?>
<table border="1">
   <?php for($j=0;$j<=20;$j++){
        echo "<tr>";
       for($i=0;$i<=4;$i++){ echo "<td>$tmp</td>";}
   echo "</tr>";
    }
    ?>
</table>
