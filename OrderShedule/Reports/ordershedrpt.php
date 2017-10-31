<?php
 session_start();
include "../../Connector.php";

$AppDateFrom		= $_GET["AppDateFromGET"];
 $AppDateFromArray		= explode('/',$AppDateFrom);
  $formatedAppDateFrom = $AppDateFromArray[2]."-".$AppDateFromArray[1]."-".$AppDateFromArray[0];
    //echo "APP From $AppDateFrom<br>";
$AppDateTo   		= $_GET["AppDateToGET"];
 $AppDateToArray		= explode('/',$AppDateTo);
  $formatedAppDateTo = $AppDateToArray[2]."-".$AppDateToArray[1]."-".$AppDateToArray[0];
  //echo "App To $AppDateTo<br>";

$ShipDateFrom		    = $_GET["ShipDateFromGET"];
 $ShipDateFromArray		= explode('/',$ShipDateFrom);
  $formatedShipDateFrom = $ShipDateFromArray[2]."-".$ShipDateFromArray[1]."-".$ShipDateFromArray[0];
      //echo "Ship From $ShipDateFrom<br>";
$ShipDateTo		        = $_GET["ShipDateToGET"];
 $ShipDateToArray		= explode('/',$ShipDateTo);
  $formatedShipDateTo   = $ShipDateToArray[2]."-".$ShipDateToArray[1]."-".$ShipDateToArray[0];
  //echo "Ship To $ShipDateTo<br>";
$cbointSRNOFrom	    = $_GET["cbointSRNOFromGET"];
 //echo "Sr From $cbointSRNOFrom<br>";
$cbointSRNOTo 	    = $_GET["cbointSRNOToGET"];
//echo "Sr To $cbointSRNOTo<br>";

$CutDateFrom	    = $_GET["CutDateFromGET"];
 $CutDateFromArray		= explode('/',$CutDateFrom);
  $formatedCutDateFrom = $CutDateFromArray[2]."-".$CutDateFromArray[1]."-".$CutDateFromArray[0];
  //echo "Cut Date $CutDateFrom<br>";
  
$CutDateTo   	    = $_GET["CutDateToGET"];
 $CutDateToArray		= explode('/',$CutDateTo);
  $formatedCutDateTo = $CutDateToArray[2]."-".$CutDateToArray[1]."-".$CutDateToArray[0];
  //echo "Cut Date $CutDateTo<br>";

$cboItem   	    = $_GET["cboItem"];
//echo "Item $cboItem<br>";
$cboCompany     = $_GET["cboCompany1"];
//echo "Com  $cboCompany<br>";
$cboBuyer       = $_GET["cboBuyer"];
//echo "Buyer $cboBuyer<br>";


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Order Schedule Report</title>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.style4 {
	font-size: xx-large;
	color: #FF0000;
}
.style3 {
	font-size: xx-large;
	color: #FF0000;
}
-->

</style>

</head>

<body>
<table align="center" width="100%" border="0">
<tr>
<?php
		
					$SQL_address="SELECT * FROM 
						companies
						Inner Join useraccounts ON companies.intCompanyID = useraccounts.intCompanyID
						WHERE
						useraccounts.intUserID =  '".$_SESSION["UserID"]."'";
							
						$result_address = $db->RunQuery($SQL_address);
					
					
		while($rows = mysql_fetch_array($result_address))
		{	
		$strName=$rows["strName"];
		$comAddress1=$rows["strAddress1"];
		$comAddress2=$rows["strAddress2"];
		$comStreet=$rows["strStreet"];
		$comCity=$rows["strCity"];
		$comCountry=$rows["strCountry"];
		$comZipCode=$rows["strZipCode"];
		$strPhone=$rows["strPhone"];
		$comEMail=$rows["strEMail"];
		$comFax=$rows["strFax"];
		$comWeb=$rows["strWeb"];
		}			
				?>
<td align="center" style="font-family: Arial;	font-size: 16pt;color: #000000;font-weight: bold;"><?php echo $strName; ?></td>				
</tr>

<tr>
 <td align="center" style="font-family: Arial;	font-size: 10pt;color: #000000;font-weight: bold;">
<p >
		  <?php echo $comAddress1." ".$comAddress2." ".$comStreet."<br>".$comCity." ".$comCountry.".<br>"."Tel:".$comPhone." ".$comZipCode." Fax: ".$comFax."<br> E-Mail: ".$comEMail." Web: ".$comWeb;?></p></td>
</tr>
<tr>
 <td align="center" style="font-family: Arial;	font-size: 12pt;color: #000000;font-weight: bold;">
 ORDERS IN HAND
 </td>
</table>

<table width="1200" border='0' align='center'>
      <tr>
      <td width="72"  align="left"><font  style='font-size: 9px;' ><b>Approved Date</font></td>
	  <?php
	  if($AppDateFrom != ""){
	  ?>
	  <td width="172"  align="left"><font  style='font-size: 9px;' ><b>From <?php echo $AppDateFrom;?> To <?php echo $AppDateTo;?></font></td>
	  <?php
	  }else{
	  ?>
	  <td width="52"  align="left"><font  style='font-size: 9px;' ><b>All</font></td>
	  <?php
	  }
	  ?>
	  </tr>
	  
	  <tr>
	  <td  align="left"><font  style='font-size: 9px;' ><b>Shipment Date</font></td>
	  <?php
	  if($ShipDateFrom != ""){
	  ?>
	  <td  align="left"><font  style='font-size: 9px;' ><b>From <?php echo $ShipDateFrom;?> To <?php echo $ShipDateTo;?></font></td>
	  <?php
	  }else{
	  ?>
	  <td  align="left"><font  style='font-size: 9px;' ><b>All</font></td>
	  <?php
	  }
	  ?>
	  <td width="53"  align="left"><font  style='font-size: 9px;' ><b>Item</font></td>
	  <?php
	  if($cboItem != ""){
	  ?>
	  <td width="225"  align="left"><font  style='font-size: 9px;' ><b><?php echo $cboItem;?> </font></td>
	  <?php
	  }else{
	  ?>
	  <td width="586"  align="left"><font  style='font-size: 9px;' ><b>All</font></td>
	  <?php
	  }
	  ?>
	  </tr>
	  
	  <tr>
	  <td  align="left"><font  style='font-size: 9px;' ><b>SRNO</font></td>
	  <?php
	  if($cbointSRNOFrom != ""){
	  ?>
	  <td  align="left"><font  style='font-size: 9px;' ><b>From <?php echo $cbointSRNOFrom;?> To <?php echo $cbointSRNOTo;?></font></td>
	  <?php
	  }else{
	  ?>
	  <td  align="left"><font  style='font-size: 9px;' ><b>All</font></td>
	  <?php
	  }
	  ?>
	  <td  align="left"><font  style='font-size: 9px;' ><b>Company</font></td>
	  <?php
	  if($cboCompany != ""){
	  ?>
	  <td  align="left"><font  style='font-size: 9px;' ><b><?php echo $cboCompany;?> </font></td>
	  <?php
	  }else{
	  ?>
	  <td  align="left"><font  style='font-size: 9px;' ><b>All</font></td>
	  <?php
	  }
	  ?>
      </tr>
	  
	  <tr>
	  <td  align="left"><font  style='font-size: 9px;' ><b>Cut Date</font></td>
	  <?php
	  if($cbointCutFrom != ""){
	  ?>
	  <td  align="left"><font  style='font-size: 9px;' ><b>From <?php echo $cbointCutFrom;?> To <?php echo $cbointCutTo;?></font></td>
	  <?php
	  }else{
	  ?>
	  <td  align="left"><font  style='font-size: 9px;' ><b>All</font></td>
	  <?php
	  }
	  ?>
	  <td  align="left"><font  style='font-size: 9px;' ><b>Buyer</font></td>
	  <?php
	  if($cboBuyer != ""){
	  ?>
	  <td  align="left"><font  style='font-size: 9px;' ><b><?php echo $cboBuyer;?> </font></td>
	  <?php
	  }else{
	  ?>
	  <td  align="left"><font  style='font-size: 9px;' ><b>All</font></td>
	  <?php
	  }
	  ?>
      </tr>
</table>		
	  
<table width="1200" border='1' align='center' CELLPADDING=3 CELLSPACING=1  RULES=COLS,ROWS FRAME=BOX >
      <tr>
	  <td class='normalfntBtab' align="center"><font  style='font-size: 9px;' ><b>Style No</font></td>
	  <td class='normalfntBtab' align="center"><font  style='font-size: 9px;' ><b>Export PO No</font></td>
	  <td class='normalfntBtab' align="center"><font  style='font-size: 9px;' ><b>Description</font></td>
	  <td class='normalfntBtab' align="center"><font  style='font-size: 9px;' ><b>Approved Date</font></td>
	  <td class='normalfntBtab' align="center"><font  style='font-size: 9px;' ><b>Order Qty</font></td>
	  <td class='normalfntBtab' align="center"><font  style='font-size: 9px;' ><b>FOB</font></td>
	  <td class='normalfntBtab' align="center"><font  style='font-size: 9px;' ><b>C & M</font></td>
	  </tr></b>
	  
      <?php

		$SQL_style="SELECT orders.strStyle,
		                   specification.intSRNO,
					       orders.strDescription,
						   buyers.strName,
						   orders.dtmAppDate,
						   orders.intQty,
						   orders.reaFOB,
						   orders.reaSMV,
						   orders.reaSMVRate
					       FROM 
						   orders INNER JOIN specification on orders.intStyleId = specification.intStyleId								       
							      INNER JOIN buyers on orders.intBuyerID = buyers.intBuyerID 
								  INNER JOIN companies on orders.intCompanyID = companies.intCompanyID
								  WHERE orders.intStatus !='1000'"; 
						   
						   
		  if($AppDateFrom != "" AND $AppDateTo != "" ){
		  $SQL_style .= " AND orders.dtmAppDate>='$formatedAppDateFrom' AND orders.dtmAppDate<='$formatedAppDateTo'";
		  }	
		  
		  if($cbointSRNOFrom != "" AND $cbointSRNOTo != "" ){
		  $SQL_style .= " AND specification.intSRNO>='$cbointSRNOFrom' AND specification.intSRNO<='$cbointSRNOTo'";
		  }	
		  
		  if($cboItem != "" ){
		  $SQL_style .= " AND orders.strDescription ='$cboItem'";
		  }	
		  
		  if($cboCompany != "" ){
		  $SQL_style .= " AND orders.intCompanyID ='$cboCompany'";
		  }
		  
		  if($cboBuyer != "" ){
		  $SQL_style .= " AND orders.intBuyerID ='$cboBuyer'";
		  }

		   			    
          $result_alldetails = $db->RunQuery($SQL_style);

		
		while($row = mysql_fetch_array($result_alldetails))
		{		
		$strStyle       = $row["strStyle"];
		$intSRNO        = $row["intSRNO"];
		$strDescription = $row["strDescription"];
		$strName        = $row["strName"];
		$dtmAdviceDate  = $row["dtmAdviceDate"];
		$dtmAppDate     = $row["dtmAppDate"];
		$intQty         = $row["intQty"];
		$reaFOB         = $row["reaFOB"];
		$reaSMV         = $row["reaSMV"];
		$reaSMVRate     = $row["reaSMVRate"];
		$CM             = $reaSMV*$reaSMVRate; 
								
						
    echo "<tr>";
	  echo"<td><font  style='font-size: 9px;'>SC NO : $intSRNO </font></td>";
	  echo"<td><font  style='font-size: 9px;'>Buyer : $strName </font></td>";
	  echo"<td></td>";
	  echo"<td></td>";
	  echo"<td></td>";
	  echo"<td></td>";
   echo"</tr>";	
   echo "<tr>";
   echo"<td><font  style='font-size: 9px;'> $strStyle </font></td>";							
   
   	    $SQL_style_buyerponos = "SELECT orders.strStyle,
		                        style_buyerponos.strBuyerPONO
								FROM 
								orders INNER JOIN style_buyerponos on orders.intStyleId = style_buyerponos.intStyleId
								WHERE orders.strStyle = '$strStyle'";
        $resultstyle_buyerponos = $db->RunQuery($SQL_style_buyerponos);
		$i=0;
		while($row1 = mysql_fetch_array($resultstyle_buyerponos))
		{	
		$strBuyerPONO=$row1["strBuyerPONO"];
		if($i == 0){
		echo"<td><font  style='font-size: 9px;'>$strBuyerPONO </font></td>";
		
		}else{
		echo"<td></td><td><font  style='font-size: 9px;'>$strBuyerPONO </font></td><td></td><td></td><td></td><td></td>";

		}
		if($i == 0){
		echo"<td><font  style='font-size: 9px;'>$strDescription </font></td>";
		echo"<td align='center'><font  style='font-size: 9px;'>$dtmAppDate </font></td>";
		echo"<td align='center'><font  style='font-size: 9px;'>$intQty </font></td>";
		echo"<td align='center'><font  style='font-size: 9px;'>$reaFOB </font></td>";
		echo"<td align='center'><font  style='font-size: 9px;'>$CM </font></td>";
		}
        echo "</tr>";
		$i++;
		}
		
		$SQL_deliveryschedule = "SELECT orders.strStyle,
		                         deliveryschedule.dblQty,
								 deliveryschedule.dbExQty,
								 deliveryschedule.dtDateofDelivery
								 FROM 						
								 orders INNER JOIN deliveryschedule on orders.intStyleId = deliveryschedule.intStyleId
								 WHERE orders.strStyle = '$strStyle'";	
								 
	    if($ShipDateFrom != "" AND $ShipDateTo != "" ){
			$SQL_deliveryschedule .= " AND deliveryschedule.dtDateofDelivery>='$formatedShipDateFrom' AND                   							                                       deliveryschedule.dtDateofDelivery<='$formatedShipDateTo'";
		  }
		  //echo $SQL_deliveryschedule;
		  /*
		 if($CutDateFrom != "" AND $CutDateTo != "" ){
			$SQL_deliveryschedule .= " AND deliveryschedule.dtDateofDelivery>='$formatedShipDateFrom' AND                   							                                       deliveryschedule.dtDateofDelivery<='$formatedShipDateTo'";
		  }*/

       $resultdeliveryschedule = $db->RunQuery($SQL_deliveryschedule);								 
	   if(mysql_num_rows($resultdeliveryschedule)){
	   echo "<tr>";	
	    echo"<td></td>";
	    echo"<td></td>";
	    echo"<td class='normalfntBtab' align='center'><font  style='font-size: 9px;'><b>DELIVERY DATE </font></td>";
		echo"<td class='normalfntBtab' align='center'><font  style='font-size: 9px;'><b>QTY </font></td>";
		echo"<td class='normalfntBtab' align='center'><font  style='font-size: 9px;'><b>WITH EX QTY </font></td>";
		echo"<td class='normalfntBtab' align='center'><font  style='font-size: 9px;'><b>SHIPPED QTY </font></td>";
		echo"<td class='normalfntBtab' align='center'><font  style='font-size: 9px;'><b>BALANCE QTY </font></td>";
	   echo "</tr>";
		}

	   $totBalQty = 0;			 
	    while($row2 = mysql_fetch_array($resultdeliveryschedule))
		{
	    $dtDateofDelivery = $row2["dtDateofDelivery"];
		$dblQty           = $row2["dblQty"];
		$dbExQty          = $row2["dbExQty"];
		$withExQty        = $dblQty  * $dbExQty;
		
		$totBalQty += $withExQty;
				
	   echo "<tr>";	
	    echo"<td></td>";
	    echo"<td></td>";
	    echo"<td align='center'><font  style='font-size: 9px;'>$dtDateofDelivery </font></td>";
		echo"<td align='center'><font  style='font-size: 9px;'>$dblQty </font></td>";
		echo"<td align='center'><font  style='font-size: 9px;'>$withExQty </font></td>";
		echo"<td align='center'><font  style='font-size: 9px;'>0.00 </font></td>";
		echo"<td align='center'><font  style='font-size: 9px;'>$withExQty </font></td>";
	   echo "</tr>";	
		}
	 if(mysql_num_rows($resultdeliveryschedule)){
	   echo "<tr>";	
	    echo"<td></td>";
	    echo"<td></td>";
	    echo"<td></td>";
	    echo"<td></td>";
	    echo"<td></td>";
	    echo"<td></td>";
	    echo"<td align='center'><font  style='font-size: 9px;'>$totBalQty </font></td>";
	   echo "<tr>";	
	 }
	   echo "<tr>";	
		echo"<td class='normalfntBtab'></td>";
		echo"<td class='normalfntBtab'></td>";
		echo"<td class='normalfntBtab'></td>";
		echo"<td class='normalfntBtab'></td>";
		echo"<td class='normalfntBtab'></td>";
		echo"<td class='normalfntBtab'></td>";
		echo"<td class='normalfntBtab'></td>";
	   echo "</tr>";
	?>


	
	<?php	
		}
	?>
		
</table>

</body>
</html>
