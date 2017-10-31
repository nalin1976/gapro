<?php
 session_start();
include "../../Connector.php";
$backwardseperator = "../../";
$userID        = $_SESSION["UserID"];
$companyID     = $_SESSION["CompanyID"];


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>In House Wash Price - Po Available</title>
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
<table align="center" width="1000" border="0">
<tr>
<?php
		
			$SQL_address="SELECT was_washpriceheader.intUserCompanyId FROM was_washpriceheader;";
					
			$result_address = $db->RunQuery($SQL_address);
			$rows = mysql_fetch_array($result_address);
			$report_companyId =$rows["intUserCompanyId"];
					
				?>
<td align="center" style="font-family: Arial;	font-size: 16pt;color: #000000;font-weight: bold;"><?php include $backwardseperator.'reportHeader.php'; ?><?php //echo $strName; ?></td>				
</tr>

<tr>
 <td align="center" style="font-family: Arial;	font-size: 10pt;color: #000000;font-weight: bold;">
<p >
		  <?php //echo $comAddress1." ".$comAddress2." ".$comStreet."<br>".$comCity." ".$comCountry.".<br>"."Tel:".$comPhone." ".$comZipCode." Fax: ".$comFax."<br> E-Mail: ".$comEMail." Web: ".$comWeb;?></p></td>
</tr>
<tr>
 <td align="center" style="font-family: Arial;	font-size: 12pt;color: #000000;font-weight: bold;">
 In House Wash Price   -   PO Available
 </td>
</table>


<!--<table width="800" border='1' align='center' CELLPADDING=3 CELLSPACING=1  RULES=COLS,ROWS FRAME=BOX >-->
      <table width="90%" align='center' border="1" rules="all">
      <tr>
	  <td width="7%" align="center" class='normalfntBtab'>PO No</td>
	  <td width="13%" align="center" class='normalfntBtab'>Style Name</td>
	  <td width="10%" align="center" class='normalfntBtab'>Color</td>
	  <td width="9%" align="center" class='normalfntBtab'>Wash Price</td>
	  <td width="12%" align="center" class='normalfntBtab'>Wash Type</td>
	  <td width="10%" align="center" class='normalfntBtab'>Garment</td>
	  <td width="16%" align="center" class='normalfntBtab'>Fabric Name</td>
  	  <td width="15%" align="center" class='normalfntBtab'>Dry Process</td>
   	  <td width="8%" align="center" class='normalfntBtab'>Dry Price</td>
	  </tr>
	  
    <?php
	$sql_WashPrice_Header = "SELECT orders.strStyle,orders.strOrderNo,orders.strDescription,orders.intStyleId, 
				was_washpriceheader.dblIncome,
				was_washpriceheader.intGarmentId, 
				was_washpriceheader.dblCost,
				productcategory.strCatName,
				was_washtype.strWasType, 
				was_washpriceheader.strColor,
				was_washpriceheader.intWasTypeId,
				was_washpriceheader.strFabDes,
				companies.strName,
				was_washpriceheader.intCompanyId,
				productcategory.strCatName
				FROM orders INNER JOIN was_washpriceheader ON was_washpriceheader.intStyleId = orders.intStyleId 
				INNER JOIN productcategory ON productcategory.intCatId = was_washpriceheader.intGarmentId 
				INNER JOIN was_washtype ON was_washtype.intWasID = was_washpriceheader.intWasTypeId 
				INNER JOIN companies ON was_washpriceheader.intCompanyId = companies.intCompanyID 
				ORDER BY orders.strOrderNo";
		//echo $sqlHeader;
		$result1 = $db->RunQuery($sql_WashPrice_Header);
		while($row = mysql_fetch_array($result1)){		 
			 $poNo               = $row["strOrderNo"];
			 $styleName          = $row["strDescription"];
			 $strColor           = $row["strColor"];
			 $dblIncome          = $row["dblIncome"];
			 $strWasType         = $row["strWasType"];
			 $strGarmentName     = $row["strCatName"];
			 $strFabDes          = $row["strFabDes"];
			 $intStyleId         = $row["intStyleId"];
			 $poN='';
	
		
	
	$sql_WashPrice_Details = 
	"SELECT  was_washpricedetails.dblWashPrice,was_dryprocess.strDescription AS DryDescription
	FROM was_washpricedetails INNER JOIN was_dryprocess ON was_washpricedetails.intDryProssId = was_dryprocess.intSerialNo 
	WHERE was_washpricedetails.intStyleId ='$intStyleId' ORDER BY    was_dryprocess.strDescription";
	//echo $sql_WashPrice_Details;
	$result2 = $db->RunQuery($sql_WashPrice_Details);
			while($row2= mysql_fetch_array($result2)){
			 $strDescription        = $row2["DryDescription"];
			 $dblWashPrice          = $row2["dblWashPrice"]; ?>
<tr <?php if($poNo=="" || $poNo !=$poN ){ echo "style=\"border-bottom:solid #333 1px;border-left:solid #000 1px;border-right:solid #333 1px;\" "; }else { ?> style="border-bottom:solid #FFF 1px;border-left:solid #333 1px;border-right:solid #000 1px;"<?php } ?> >
  <td align="center" class='normalfnt'  ><font  style='font-size: 9px;'><?php if($poNo=="" || $poNo !=$poN ){ echo $poNo;}?></font> </td>
  <td align="center" class='normalfnt'><font  style='font-size: 9px;'><?php if($poNo=="" || $poNo !=$poN ){ echo $styleName;} ?></font> </td>
  <td align="center" class='normalfnt'><font  style='font-size: 9px;'><?php if($poNo=="" || $poNo !=$poN ){ echo $strColor;} ?></font> </td>
  <td align="center" class='normalfntRite'><font  style='font-size: 9px;'><?php if($poNo=="" || $poNo !=$poN ){  echo number_format($dblIncome,2);} ?>&nbsp;</font> </td>
  <td align="center" class='normalfnt'><font  style='font-size: 9px;'><?php if($poNo=="" || $poNo !=$poN ){ echo $strWasType;} ?></font> </td>
  <td align="center" class='normalfnt'><font  style='font-size: 9px;'><?php if($poNo=="" || $poNo !=$poN ){ echo $strGarmentName;} ?></font> </td>
  <td align="center" class='normalfnt'><font  style='font-size: 9px;'><?php if($poNo=="" || $poNo !=$poN ){ echo $strFabDes;} ?></font> </td>
  <td align="center" class='normalfnt'><font  style='font-size: 9px;'>&nbsp;<font  style="font-size: 9px;"><?php echo $strDescription;?></font></td>
  <td align="center" class='normalfntRite'><font  style="font-size: 9px;"><?php echo number_format($dblWashPrice,2) ; $poN=$poNo;?></font>&nbsp;</td>
  
</tr>

     <?php	}
		}
	  ?>

      

		
</table>

</body>
</html>
