<?php
 session_start();
 $backwardseperator = "../../";
include "../../Connector.php";
$report_companyId = $_SESSION["FactoryID"];

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>BL Instructions</title>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
</head>
<body>
<table width="900" border="0" align="center" cellpadding="0">
  <tr>
    <td width="100%" colspan="3"><table width="100%" cellpadding="0" cellspacing="0">
      <tr>
        <td class="tophead"><table width="100%" cellpadding="0" cellspacing="0">
              <tr>
                <td width="100%"><?php include "../../reportHeader.php";?></td>

              </tr>
          </table></td>
      </tr>
    </table></td>
  </tr>
  
  <tr>
    <td colspan="5" class="normalfnt2bldBLACKmid"></td>
  </tr>
  


  <tr>
    <td colspan="5" style="text-align:center">


<table width="100%" border='1' cellpadding="3" cellspacing="0" rules="all">

<?php
 $intScheduleNo = $_GET['intScheduleNo']; 
					
  $sql = "SELECT
			weeklyshipmentschedule.dblShipNowQuantitySea,
			weeklyshipmentschedule.etdDate,
			weeklyshipmentschedule.intStyleId,
			weeklyshipmentschedule.intDestID,
			weeklyshipmentschedule.dblDeliveryQty,
			weeklyshipmentschedule.dblOrderQty,
			weeklyshipmentschedule.dblLength,
			weeklyshipmentschedule.dblWidth,
			weeklyshipmentschedule.dblHeight,
			weeklyshipmentschedule.etdDate,
			weeklyshipmentschedule.dblLength,
			weeklyshipmentschedule.dblWidth,
			weeklyshipmentschedule.dblHeight,
			weeklyshipmentschedule.strRemarks,
			weeklyshipmentschedule.dblQtyCtn,
			orders.strOrderNo,
			orders.strDescription,
			orders.strStyle,
			orders.strOrderNo,
			orders.intQty,
			orders.strStyle,
			destination.intDestCode,
			orderdata.strDescription as fabric,
			destination.strDestName
			FROM
			weeklyshipmentschedule
			Inner Join orders ON orders.intStyleId = weeklyshipmentschedule.intStyleId
			Inner Join destination ON weeklyshipmentschedule.intDestID = destination.intDestID 
			Inner Join orderdata ON orders.intStyleId = orderdata.intStyleID
			WHERE intScheduleNo='$intScheduleNo' AND  weeklyshipmentschedule.dblShipNowQuantitySea<>0
			ORDER BY destination.strDestName,orders.intStyleId ";					
  	     
  //echo"$sql<br>"; 
  $result = $db->RunQuery($sql);
  
  if(mysql_num_rows($result))
  {
   $flg_newpgyn  = ""; 
   $flg_firstyn  = "";
   $flg_newdocyn = "";
   $te_docmain   = ""; 

   
   $flg_newpgyn2  = ""; 
   $flg_firstyn2  = "";
   $flg_newconyn2 = "";

   $j = 0;
   $te_totsubQtySEA = 0;
   $te_totsubQtyCtnSEA = 0;
   while($fields = mysql_fetch_array($result, MYSQL_BOTH)) 
   { 
    $te_intDestID      = $fields['intDestID'];
	$te_strDestName    = $fields['strDestName'];	
    $dblShipNowQuantitySea = $fields['dblShipNowQuantitySea'];
	$etdDate           = $fields['etdDate'];  
    $dblDeliveryQty    = $fields['dblDeliveryQty'];
    $dblOrderQty       = $fields['dblOrderQty']; 
    $strDescription    = $fields['strDescription'];
	$strOrderNo        = $fields['strOrderNo']; 
	$intStyleId        = $fields['intStyleId']; 
	$strStyle          = $fields['strStyle']; 
	$strOrderNo        = $fields['strOrderNo']; 
	$intQty            = $fields['intQty'];
	$etdDate           = $fields['etdDate']; 
	$dblLength         = $fields['dblLength']; 
	$dblWidth          = $fields['dblWidth']; 
	$dblHeight         = $fields['dblHeight']; 
	$strRemarks        = $fields['strRemarks']; 
	$dblQtyCtnSEA      = $fields['dblQtyCtn']; 
	$strStyle          = $fields['strStyle']; 
	$intDestCode       = $fields['intDestCode']; 
	$fabric            = $fields['fabric']; 

    
   if($j == 0 )
   {	    
    echo "<br><table width='1000' border='0' align='center'>";
    echo "<tr align='center'>";
    echo "<td class='normalfnt2bldBLACKmid'>BL Instructions</td>";
    echo "</tr>";
    echo "</table>";

    echo "<table width='100%' border='1' align='center' CELLPADDING=3 CELLSPACING=1  RULES=COLS,ROWS FRAME=BOX >";
	
    echo "<tr align='center'>";
	echo "<td class='normalfnt2bldBLACKmid'>FTY</td>";
    echo "<td class='normalfnt2bldBLACKmid'>PO</td>";
	echo "<td class='normalfnt2bldBLACKmid'>Description</td>";
    echo "<td class='normalfnt2bldBLACKmid'>Lot #</td>";
    echo "<td class='normalfnt2bldBLACKmid'>DO #</td>";
    echo "<td class='normalfnt2bldBLACKmid'>DC #</td>";
    echo "<td class='normalfnt2bldBLACKmid'>Col</td>";
	echo "<td class='normalfnt2bldBLACKmid'>PO QTY(PCS)</td>";
    echo "<td class='normalfnt2bldBLACKmid'>QTY Ctn</td>";
	echo "<td class='normalfnt2bldBLACKmid'>QTY Pcs</td>";
	echo "<td class='normalfnt2bldBLACKmid'>PO ETD</td>";
    echo "<td class='normalfnt2bldBLACKmid'>FABRIC</td>";
    echo "<td class='normalfnt2bldBLACKmid'>L</td>";
    echo "<td class='normalfnt2bldBLACKmid'>W</td>";
    echo "<td class='normalfnt2bldBLACKmid'>H</td>";
	echo "<td class='normalfnt2bldBLACKmid'>CBM</td>";
    echo "<td class='normalfnt2bldBLACKmid'>PP Pcs</td>";
    echo "<td class='normalfnt2bldBLACKmid'>Remarks</td>";
    echo "</tr>";

   }
       
   #---------------------------
    if($te_docmain != $te_intDestID."".$intStyleId)
    {
     $flg_newdocyn = "y";
    }
    else
    {
     $flg_newdocyn = "n";  
    }	
    $te_docmain = $te_intDestID."".$intStyleId; 
  
    #---------------------------[ subtotal ]------------------------------
    if($flg_newdocyn== "y")
    {
 	 if($flg_firstyn  == "n")
	 {	 

      echo "<tr>";
	  echo "<td align='right' colspan=8></td>";   
	  echo "<td  class='normalfntRite'>".number_format($te_totsubQtyCtnSEA,2)."</td>";    
	  echo "<td class='normalfntRite'>".number_format($te_totsubQtySEA,2)."</td>"; 
	  echo "<td align='right'width='' colspan=16></td>"; 
      echo "</tr>";
      $te_totsubQtySEA = 0;
	  $te_totsubQtyCtnSEA = 0;
     }	    
    }    
	
	  $te_totsubQtySEA+= $dblShipNowQuantitySea;
	  $te_totsubQtyCtnSEA+= $dblQtyCtnSEA;
	//echo $flg_newdocyn;

    if($flg_newdocyn== "y" || $flg_newdocyn == "y" )
    {
	?>
     <tr>
     <td colspan='20'  align='left'><b><font  style='font-size: 13px;'><?php echo $strStyle." ".$te_strDestName." "."VSL" ?></font></b></td>      

     </tr> 
	<?php
    } 

     echo "<tr>";
	 echo "<td align='right' width=''></td>";  
     echo "<td class='normalfnt'>$strOrderNo</td>";
     echo "<td   class='normalfnt'>$strDescription</td>";
     echo "<td class='normalfnt'>$strStyle</td>";
     echo "<td class='normalfntRite'></td>"; 
	 echo "<td class='normalfnt'>$intDestCode</td>"; 
	 echo "<td class='normalfntRite'></td>"; 
	 echo "<td class='normalfntRite'>".number_format($intQty,2,".","")."</td>"; 
	 echo "<td class='normalfntRite'>$dblQtyCtnSEA </td>"; 
	  echo "<td class='normalfntRite'>$dblShipNowQuantitySea</td>"; 
	 echo "<td class='normalfntMid'>$etdDate</td>"; 
	 echo "<td class='normalfnt'>$fabric</td>"; 
	 echo "<td class='normalfnt'>$dblLength</td>"; 
	 echo "<td class='normalfnt'>$dblWidth</td>"; 
	 echo "<td class='normalfnt'>$dblHeight</td>"; 
	 echo "<td class='normalfntRite'></td>"; 
	 echo "<td class='normalfntRite'></td>"; 
	 echo "<td class='normalfnt'>$strRemarks</td>"; 
     echo "</tr>";  

     $flg_firstyn  = "n";
     $flg_firstyn2 = "n";          
     $j++;    
   }//end while 
       
      echo "<tr>";
	  echo "<td align='right' colspan=8></td>";   
	  echo "<td class='normalfntRite'>".number_format($te_totsubQtyCtnSEA,2)."</td>";    
	  echo "<td class='normalfntRite'>".number_format($te_totsubQtySEA,2)."</td>"; 
	  echo "<td align='right'width='' colspan=16></td>"; 
      echo "</tr>";
  
//---------------------------------------------------------------------------------------------------------------------------
  }
  $sql = "SELECT
			weeklyshipmentschedule.dblShipNowQuantityAir,
			weeklyshipmentschedule.etdDate,
			weeklyshipmentschedule.intStyleId,
			weeklyshipmentschedule.intDestID,
			weeklyshipmentschedule.dblDeliveryQty,
			weeklyshipmentschedule.dblOrderQty,
			weeklyshipmentschedule.dblLength,
			weeklyshipmentschedule.dblWidth,
			weeklyshipmentschedule.dblHeight,
			weeklyshipmentschedule.etdDate,
			weeklyshipmentschedule.dblLength,
			weeklyshipmentschedule.dblWidth,
			weeklyshipmentschedule.dblHeight,
			weeklyshipmentschedule.strRemarks,
			weeklyshipmentschedule.dblQtyCtn,
			orders.strOrderNo,
			orders.strDescription,
			orders.strStyle,
			orders.strOrderNo,
			orders.intQty,
			destination.strDestName,
			orders.strStyle,
			destination.intDestCode,
			orderdata.strDescription as fabric
			FROM
			weeklyshipmentschedule
			Inner Join orders ON orders.intStyleId = weeklyshipmentschedule.intStyleId
			Inner Join destination ON weeklyshipmentschedule.intDestID = destination.intDestID 
			Inner Join orderdata ON orders.intStyleId = orderdata.intStyleID
			WHERE intScheduleNo='$intScheduleNo' AND  weeklyshipmentschedule.dblShipNowQuantityAir<>0
			ORDER BY destination.strDestName,orders.intStyleId ";					
  	     
  //echo"$sql<br>"; 
  $result = $db->RunQuery($sql);
  
  if(mysql_num_rows($result))
  {
   $flg_newpgyn  = ""; 
   $flg_firstyn  = "";
   $flg_newdocyn = "";
   $te_docmain   = ""; 

   
   $flg_newpgyn2  = ""; 
   $flg_firstyn2  = "";
   $flg_newconyn2 = "";
  	
   $te_totsubsmv = 0;
   $te_totsubsmvHelp = 0;
   $j = 0;
   
   $te_totsubQtyAIR = 0;
   $te_totsubQtyCtnAIR = 0;

   while($fields2 = mysql_fetch_array($result, MYSQL_BOTH)) 
   { 
    $te_intDestID      = $fields2['intDestID'];
	$te_strDestName    = $fields2['strDestName'];	
	$dblShipNowQuantityAir = $fields2['dblShipNowQuantityAir'];
	$etdDate           = $fields2['etdDate'];  
    $dblDeliveryQty    = $fields2['dblDeliveryQty'];
    $dblOrderQty       = $fields2['dblOrderQty']; 
    $strDescription    = $fields2['strDescription'];
	$strOrderNo        = $fields2['strOrderNo']; 
	$intStyleId        = $fields2['intStyleId']; 
	$strStyle          = $fields2['strStyle']; 
	$strOrderNo        = $fields2['strOrderNo']; 
	$intQty            = $fields2['intQty'];
	$etdDate           = $fields2['etdDate']; 
	$dblLength         = $fields2['dblLength']; 
	$dblWidth          = $fields2['dblWidth']; 
	$dblHeight         = $fields2['dblHeight']; 
	$strRemarks        = $fields2['strRemarks']; 
	$dblQtyCtnAIR      = $fields2['dblQtyCtn']; 
	$strStyle          = $fields2['strStyle']; 
	$intDestCode       = $fields2['intDestCode']; 
	$fabric            = $fields2['fabric']; 

    
       
   #---------------------------
    if($te_docmain != $te_intDestID."".$intStyleId)
    {
     $flg_newdocyn = "y";
    }
    else
    {
     $flg_newdocyn = "n";  
    }	
    $te_docmain = $te_intDestID."".$intStyleId; 
  
    #---------------------------[ subtotal ]------------------------------
    if($flg_newdocyn== "y")
    {
 	 if($flg_firstyn  == "n")
	 {	  
	  
      echo "<tr>";
	  echo "<td align='right' colspan=8></td>";  
	  echo "<td class='normalfntRite'>".number_format($te_totsubQtyCtnAIR,2)."</td>";  
	  echo "<td class='normalfntRite'>".number_format($te_totsubQtyAIR,2)."</td>";    
	  echo "<td align='right'width='' colspan=16></td>"; 
      echo "</tr>";
     $te_totsubQtyAIR = 0;
     $te_totsubQtyCtnAIR = 0;
     }	    
    } 
	  $te_totsubQtyAIR+= $dblShipNowQuantityAir;
	  $te_totsubQtyCtnAIR+= $dblQtyCtnAIR;   

	//echo $flg_newdocyn;

    if($flg_newdocyn== "y" || $flg_newdocyn == "y" )
    {
	?>
     <tr>
     <td colspan='20'  align='left'><b><font  style='font-size: 13px;'><?php echo $strStyle." ".$te_strDestName." "."AIR" ?></font></b></td> 
	      

     </tr> 
	<?php
    } 

     echo "<tr>";
	 echo "<td align='right' width=''></td>";  
     echo "<td class='normalfnt'>$strOrderNo</td>";
     echo "<td   class='normalfnt'>$strDescription</td>";
     echo "<td class='normalfnt'>$strStyle</td>";
     echo "<td class='normalfntRite'></td>"; 
	 echo "<td class='normalfnt'>$intDestCode</td>"; 
	 echo "<td class='normalfntRite'></td>"; 
	 echo "<td class='normalfntRite'>".number_format($intQty,2,".","")."</td>"; 
	 echo "<td class='normalfntRite'>$dblQtyCtnAIR </td>"; 
	  echo "<td class='normalfntRite'>$dblShipNowQuantityAir</td>"; 
	 echo "<td class='normalfntMid'>$etdDate</td>"; 
	 echo "<td class='normalfnt'>$fabric</td>"; 
	 echo "<td class='normalfnt'>$dblLength</td>"; 
	 echo "<td class='normalfnt'>$dblWidth</td>"; 
	 echo "<td class='normalfnt'>$dblHeight</td>"; 
	 echo "<td class='normalfntRite'></td>"; 
	 echo "<td class='normalfntRite'></td>"; 
	 echo "<td class='normalfnt'>$strRemarks</td>"; 
     echo "</tr>";   

     $flg_firstyn  = "n";
     $flg_firstyn2 = "n";          
     $j++;    
   }//end while 
      echo "<tr>";
	  echo "<td align='right' colspan=8></td>";   
	  echo "<td class='normalfntRite'>".number_format($te_totsubQtyCtnAIR,2)."</td>"; 
	  echo "<td class='normalfntRite'>".number_format($te_totsubQtyAIR,2)."</td>";    
	  echo "<td align='right'width='' colspan=16></td>"; 
      echo "</tr>";
   }

?>
					
    </table></td>
  </tr>
  </table>
</body>
</html>
