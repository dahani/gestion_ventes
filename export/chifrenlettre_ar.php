<?php 
 
//echo chiffre_en_arabe(2400.34); 
function chiffre_en_arabe($d){
 $Unite ;$dizaine ;$decimales ;$CasPart ;$lettres ;$Numlettre ;$Cent_Pluriel ;$Vingt_Pluriel ;$Nombre=$d;
 $devise=" &#x62F;&#x631;&#x647;&#x645; ";

    If ($Nombre >= 1000000000000 ){
		exit("Ce nombre est trop grand !");
    }
 
 
    $Unite = Array(""," &#1608;&#1575;&#1581;&#1583;", "&#1575;&#1579;&#1606;&#1610;&#1606;", "&#1579;&#1604;&#1575;&#1579;&#1577;", "&#1575;&#1585;&#1576;&#1593;&#1577;", "&#1582;&#1605;&#1587;&#1577;", "&#1587;&#1578;&#1577;", "&#1587;&#1576;&#1593;&#1577;", "&#1579;&#1605;&#1575;&#1606;&#1610;&#1577;", "&#1578;&#1587;&#1593;&#1577;");
 
    $dizaine = Array("","&#1593;&#1588;&#1585;&#1577;", "&#1593;&#1588;&#1585;&#1608;&#1606;", "&#1579;&#1604;&#1575;&#1579;&#1608;&#1606;", "&#1575;&#1585;&#1576;&#1593;&#1608;&#1606;", "&#1582;&#1605;&#1587;&#1608;&#1606;", "&#1587;&#1578;&#1608;&#1606;", "&#1587;&#1576;&#1593;&#1608;&#1606;", "&#1579;&#1605;&#1575;&#1606;&#1608;&#1606;", "&#1578;&#1587;&#1593;&#1608;&#1606;");
 
    $CasPart = Array("","&#1593;&#1588;&#1585;&#1577;", "&#1575;&#1581;&#1583; &#1593;&#1588;&#1585;&#1577;", "&#x627;&#x62B;&#x646;&#x627; &#x639;&#x634;&#x631;&#x629;", "&#1579;&#1604;&#1575;&#1579;&#1577; &#1593;&#1588;&#1585;&#1577;", "&#1575;&#1585;&#1576;&#1593;&#1577; &#1593;&#1588;&#1585;&#1577;", "&#1582;&#1605;&#1587;&#1577; &#1593;&#1588;&#1585;&#1577;", "&#1587;&#1578;&#1577; &#1593;&#1588;&#1585;&#1577;", "&#1587;&#1576;&#1593;&#1577; &#1593;&#1588;&#1585;&#1577;", "&#1579;&#1605;&#1575;&#1606;&#1610;&#1577; &#1593;&#1588;&#1585;&#1577;", "&#1578;&#1587;&#1593;&#1577; &#1593;&#1588;&#1585;&#1577;");
 
 
 
// Mise à vide de la chaîne de réception de la traduction du nombre
 
    $lettres = "";
 
 
 
// Initialisation des indicateurs de pluriel des nombres cent et vingt
 
    $Cent_Pluriel = True;
 
    $Vingt_Pluriel = True;
 
 
 
// Conversion de la partie décimale en un nombre de 0 à 99
 
// arrondi à l//$Unite la plus proche
$b=explode(".",$Nombre."");

      $decimales = ((int)isset($b[1])?$b[1]:0);
 

 
// Conservation de la partie entière du nombre
 
     $Nombre = (int)($Nombre);

 
 
// Orientation du traitement suivant valeur de la partie entière
 
   if($Nombre==0){
	   $lettres = "&#1589;&#1601;&#1585;";
   }else if($Nombre>=1 && $Nombre<=9){
	   $lettres = $Unite[(int)($Nombre)];
   }else if($Nombre>=10 && $Nombre<=99){
	   $lettres= Trt_dizaines($Nombre,$CasPart,$dizaine,$Unite);
   }else if($Nombre>=100 && $Nombre<=999){
	    $lettres=  Trt_Centaines($Nombre,$CasPart,$dizaine,$Unite,$Cent_Pluriel);
   }else if($Nombre>=1000 && $Nombre<= 999999999999){
	     $lettres= Trt_Multiples_de_Mille ($Nombre,$Cent_Pluriel,$CasPart,$dizaine,$Unite);
   }
 
/*
    If ($Nombre > 1 )
        $lettres = $lettres ." &#1605;&#1604;&#1610;&#1605;";
    Else
        $lettres = $lettres ." &#1605;&#1604;&#1610;&#1605;";
 */
// Orientation du traitement suivant valeur de la partie décimale
	$lettres .=$devise;
   if( $decimales>=1 &&  $decimales<=9){
	   $lettres = $lettres ." &#x648; ". $Unite[(int)($decimales)];
   }else if( $decimales>=10 &&  $decimales<=99){
	    $lettres .=" &#x648; ".Trt_dizaines($decimales,$CasPart,$dizaine,$Unite);
   }
  

// Indication des centimes
 if($decimales>0){
	 if($decimales<=10){
		 $lettres .=" &#x633;&#x646;&#x62A;&#x64A;&#x645;&#x627;&#x62A;";
    }else{
		 $lettres .=" &#x633;&#x646;&#x62A;&#x64A;&#x645;";
    }
 }
     
 return  $lettres;
 }


function  Trt_Multiples_de_Mille($Nombre,$Cent_Pluriel,$CasPart,$dizaine,$Unite){
 $Rank ; $Nom_Rang="" ; $Reste ;$lettres="";

    $Cent_Pluriel = False;
 
    $Vingt_Pluriel = False;
// Initialisation suivant taille du nombre : milliers, millions ou milliards
	if($Nombre<=1000){
		$Rank = (int)($Nombre / 1000);
            $Reste = $Nombre % 1000;
			$Nom_Rang = "&#1575;&#1604;&#1601;";
			
	}else if($Nombre>1000 && $Nombre<=999999){
		 $Rank = (int)($Nombre / 1000);
         $Reste = $Nombre % 1000;
		 if($Rank==1){
			 	$Nom_Rang = "&#1575;&#1604;&#1601;";
		 }else if($Rank==2){
			 	$Nom_Rang = "&#x623;&#x644;&#x641;&#x64A;&#x646;";
		 }else{
			 	$Nom_Rang = "&#1570;&#1604;&#1575;&#1601;";
		 }
	   
    }else if($Nombre>1000000 && $Nombre<=999999999){
		 $Rank = (int)($Nombre / 1000000);
 
            $Reste = $Nombre % 1000000;
 
            If ($Rank > 1 )
                $Nom_Rang = "&#1605;&#1604;&#1575;&#1610;&#1610;&#1606;";
            Else
                $Nom_Rang = "&#1605;&#1604;&#1610;&#1608;&#1606;";

    }else if($Nombre>999999999){
		$Rank = (int)($Nombre / 1000000000);
            $Reste = $Nombre - $Rank * 1000000000;
            If ($Rank > 1 )
                $Nom_Rang = "&#1575;&#1604;&#1601; &#1605;&#1604;&#1610;&#1608;&#1606;";
            Else
                $Nom_Rang = "&#1570;&#1604;&#1575;&#1601; &#1575;&#1604;&#1605;&#1604;&#1610;&#1608;&#1606;";  
    }
 
 
// Traitement du rang des milliers, millions ou milliards
 
  if($Rank==1){
	    If ($Nom_Rang == "&#1575;&#1604;&#1601;" )
                $lettres = $lettres . "&#1575;&#1604;&#1601;";
            Else
                $lettres = $lettres .$Unite[(int)($Rank)]. " " .$Nom_Rang; //& " &#1608;"
 
  }else if($Rank>=2 && $Rank<=9){
	  if($Nom_Rang == "&#x623;&#x644;&#x641;&#x64A;&#x646;" ){
			$lettres = $lettres . "&#x623;&#x644;&#x641;&#x64A;&#x646;";
	  }else{
		  $lettres = $lettres .$Unite[(int)($Rank)] ." " .$Nom_Rang; //& " &#1608;"
	  }
	 
  }else if($Rank>=10 && $Rank<=99){
	   $lettres .=Trt_dizaines ($Rank,$CasPart,$dizaine,$Unite);
            $lettres = $lettres ." " . $Nom_Rang ;//& " &#1608;"
  }else if($Rank>=100 && $Rank<=999){
	  $lettres .=  Trt_Centaines($Rank,$CasPart,$dizaine,$Unite,$Cent_Pluriel);
	$lettres = $lettres ." " . $Nom_Rang; //& " &#1608;"
 
  }
 
 
    $Cent_Pluriel = True;
 
    $Vingt_Pluriel = True;
 
 
 
// Orientation du traitement du reste si > 0
 
   if($Reste>=1 && $Reste<=9){
	   $lettres = $lettres ." &#1608;" . " " .$Unite[(int)($Reste)];
   }else if($Reste>=10 && $Reste<=99){
	   $lettres = $lettres ." &#1608;" ." ";

		$lettres .=Trt_dizaines($Reste,$CasPart,$dizaine,$Unite);
   }else if($Reste>=100 && $Reste<=999){
	   $lettres = $lettres . " &#1608;" . " ";
	 $lettres .= Trt_Centaines($Reste,$CasPart,$dizaine,$Unite,$Cent_Pluriel);
   }else if($Reste>999){
	   $lettres = $lettres . " &#1608;". " ";
	$lettres .=Trt_Multiples_de_Mille($Reste,$Cent_Pluriel,$CasPart,$dizaine,$Unite); 
   }else {$lettres = $lettres . " ";
   }
 
   return $lettres;
}
 
 
//
 
// -----------------------------------
 
// TRAITEMENT DES NOMBRES DE 100 0 999
 
// -----------------------------------
 
//
 
function  Trt_Centaines($Nombre,$CasPart,$dizaine,$Unite,$Cent_Pluriel){
 $Rank ;$Reste ; $lettres="";$Rank = (int)($Nombre / 100);$Reste = $Nombre % 100;
// Traitement du rang des centaines
 
    If ($Rank == 1 ){
		  If ($Reste == 0 )
            $lettres = $lettres. "&#1605;&#1575;&#1574;&#1577;";
        Else
            $lettres = $lettres ."&#1605;&#1575;&#1574;&#1577;" . " &#1608;";
    }else{
		  If ($Reste == 0 And $Cent_Pluriel ){
			  if($Rank==2){
				  $lettres = $lettres .  "&#x645;&#x627;&#x626;&#x62A;&#x627;&#x646;";
			  }else{
				  $lettres = $lettres . $Unite[(int)($Rank)]." " . "&#1605;&#1575;&#1574;&#1577;";
			  }
			   
		  } Else{
			  if($Rank==2){
				  $lettres = $lettres  ."&#x645;&#x627;&#x626;&#x62A;&#x627;&#x646;" ." &#1608;";
			  }else{
				   $lettres = $lettres . $Unite[(int)($Rank)] ." " . "&#1605;&#1575;&#1574;&#1577;" ." &#1608;";
			  }
			 
		  }
            
 
    }
 
 
 
// Traitement du reste < 100
 
    if($Reste>=1 && $Reste<=9){
		$lettres = $lettres . " " . $Unite[(int)($Reste)];
    }else if($Reste>9){
		 $lettres = $lettres ." ";
            $Vingt_Pluriel = True;
          $lettres .=  Trt_dizaines ($Reste,$CasPart,$dizaine,$Unite);
    }
 
 return  $lettres;
}
 
 
 
//
 
// ---------------------------------
 
// TRAITEMENT DES NOMBRES DE 10 0 99
 
// ---------------------------------
 
//
 
function  Trt_dizaines($Nombre,$CasPart,$dizaine,$Unite){
$Reste ;$Rank ;$lettres ="";
    $Rank = (int)($Nombre / 10);
    $Reste = $Nombre % 10;
 if($Rank==1){
	  $lettres = $lettres . $CasPart[$Reste + 1];
 }else if($Rank==7){
	  if( $Reste==0){
		   $lettres = $lettres . $dizaine[$Rank];
	  }else{
		  $lettres = $lettres .$Unite[(int)($Reste)] . " &#1608; " . $dizaine[$Rank];
	  }
 }else if($Rank==8){
	  If ($Reste == 0 )
                $lettres = $lettres . $dizaine[$Rank];
            Else
                $lettres = $lettres . $Unite[(int)($Reste)] . " &#1608; " . $dizaine[$Rank];

 }else if($Rank==9){
	  If ($Reste == 0 )
             $lettres = $lettres . $dizaine[$Rank];
 
            Else
                $lettres = $lettres . $Unite[(int)($Reste)] . " &#1608; " . $dizaine[$Rank];
 
 }else{
	   if($Reste==0){
		    $lettres = $lettres .$dizaine[$Rank];
	   }else{
		   $lettres = $lettres . $Unite[(int)($Reste)] . " &#1608; " .$dizaine[$Rank];
	   }
 
 }
 return $lettres;
}