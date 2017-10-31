<?php
	session_start();
	include "../../../Connector.php" ;
	$backwardseperator 	= "../../../";	
	$intMeterial 		= $_GET["intMeterial"];
	$intCategory 		= $_GET["intCategory"];
	$intDescription 	= $_GET["intDescription"];
	$intSupplier 		= $_GET["intSupplier"];
	$dtmDateFrom		= $_GET["dtmDateFrom"];
	$dtmDateTo 	  		= $_GET["dtmDateTo"];
	$noTo 	  			= $_GET["noTo"];
	$noFrom 	  		= $_GET["noFrom"];	
	$intCompany     	= $_GET["intCompany"];
	$intStatus 			= $_GET["status"];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GAPRO - General Inventory Reports :: Grn Details</title>
<link href="../../../css/erpstyle.css" rel="stylesheet" type="text/css" />

<style type="text/css">
<!--
.style1 {font-size: 12pt}
.style2 {font-size: 14pt}
-->
</style>
</head>


<body>
<table width="1000" border="0" align="center" cellpadding="0">
  <tr>
    <td colspan="3"><table width="100%" cellpadding="0" cellspacing="0">
      <tr>
        <td class="tophead"><table width="100%" cellpadding="0" cellspacing="0">
              <tr>
                <td width="19%"><img src="../../../images/eplan_logo.png" alt="" width="191" height="47" class="normalfnt" /></td>
              <td width="1%" class="normalfnt">&nbsp;</td>
				 <td align="center" valign="top" width="60%" class="topheadBLACK"><?php
if($intCompany!=0){		
		$SQL = "SELECT strname, CONCAT(straddress1,'.',strAddress2) AS address,
		strStreet,strCity,strCountry
		FROM companies WHERE intCompanyid=$intCompany;";
		$result = $db->RunQuery($SQL);
		$row = mysql_fetch_array($result);	
		echo ($row["strname"]);
		?><br />
		<span class="bigfntnm1mid"><?php echo ($row["address"]);?><br /><?php echo ($row["strStreet"]."&nbsp;".$row["strCity"]."&nbsp;".$row["strCountry"]);
		}?></span></td>
                 <td width="20%" class="tophead">&nbsp;</td>
              </tr>
          </table></td>
      </tr>
    </table></td>
  </tr>
  <tr>
     <td colspan="5" class="normalfnt2bldBLACKmid"><?php echo ("GRN REGISTER.")?></td>
  </tr>
  <tr>
   <td colspan="5" class="normalfnth2" style="text-align:center">
	<?php 		
		if ($intStatus==1) echo "(CONFIRMED LIST)"; 
		elseif ($intStatus==0) echo "(PENDING LIST)";					 
		elseif ($intStatus==10) echo "(CANCELED LIST)"; 				
	?>
	</td>
  </tr> 
  	<?php 		
$sql = "SELECT distinct GH.strGenGrnNo,
GH.intYear,
GH.intGenPONo,
GH.intGenPOYear,
suppliers.strTitle, 
POH.strPINO, 
GH.dtRecdDate,
GH.intStatus 
from gengrnheader GH
inner join gengrndetails on GH.strGenGrnNo=gengrndetails.strGenGrnNo and GH.intYear=gengrndetails.intYear 
inner join generalpurchaseorderheader POH on GH.intGenPONo =POH.intGenPONo AND GH.intGenPOYear=POH.intYear
inner join suppliers on POH.intSupplierID=suppliers.strSupplierID 
inner join genmatitemlist on gengrndetails.intMatDetailID=genmatitemlist.intItemSerial 
where GH.intStatus=$intStatus";			

			if($noFrom!=""){
				$sql .= " and GH.strGenGrnNo >= '$noFrom'";
			}
			if($noTo!=""){
				$sql .= " and GH.strGenGrnNo <= '$noTo'";
			}			
			/*if ($intCompany!="")
			{
				$sql = $sql." and GH.intCompId=$intCompany ";
			}*/
			if ($intMeterial!= "")
			{					
				$sql = $sql." and genmatitemlist.intMainCatID=$intMeterial ";	
			}

			if ($intCategory!= "")
			{
				$sql = $sql." and genmatitemlist.intSubCatID=$intCategory " ;
			}
			
			if ($intDescription!= "")
			{
				$sql = $sql." and genmatitemlist.intItemSerial=$intDescription " ;
			}
	
			if ($intSupplier!="")
			{			
				$sql = $sql." and POH.intSupplierID=$intSupplier ";
			}

			if($dtmDateFrom!="")
			{					
				$sql = $sql." and DATE_FORMAT(GH.dtRecdDate,'%Y/%m/%d') >= DATE_FORMAT('$dtmDateFrom','%Y/%m/%d')"; 
			}
			
			if($dtmDateTo!="")
			{					
			$sql = $sql." and DATE_FORMAT(GH.dtRecdDate,'%Y/%m/%d') <= DATE_FORMAT('$dtmDateTo','%Y/%m/%d')"; 
			}
			
			$sql = $sql. " order by GH.strGenGrnNo";			
			//echo $sql;
			$result = $db->RunQuery($sql);
			$rowCount	= mysql_num_rows($result);
			while ($rowdata=mysql_fetch_array($result))
			{								
	?>
	<tr>
    	<td width="87" bgcolor="#C4DBFD" class="normalfnth2B" >GRN  Number</td>
  	    <td width="114" bgcolor="#C4DBFD" class="normalfnth2B" ><?php echo $rowdata["intYear"].'/'.$rowdata["strGenGrnNo"];  ?></td>
  	    <td width="800" >&nbsp;</td>
  	</tr> 
    <tr>	
    	<td colspan="3">
		<table width="965" border="0" cellpadding="0" cellspacing="0" class="bcgl1"><tr><td>
		
		<table width="100%" border="0" cellpadding="0" cellspacing="0" class="bcgl1">
          <tr height="25">
            <td  width="53" height="18" class="normalfnth2B">Po No : </td>
			<td width="98" class="normalfnt"><?php echo $rowdata["intGenPOYear"],'/',$rowdata["intGenPONo"]; ?></td>
			<td width="94" class="normalfnth2B">Supplier : </td>
			<td colspan="2" class="normalfnt"><?php echo $rowdata["strTitle"]; ?></td>
			<td width="122" class="normalfnt">PI NO : <?php echo $rowdata["strPINO"]; ?></td>
			<td width="46" class="normalfnth2B"> Date : </td>
			<td width="126" class="normalfnt"><?php  echo $rowdata["dtRecdDate"];?></td>
          </tr>          
        </table>
		<p class="head2BLCK"></p></td>
  	</tr>
	
	<tr>
    	<td height="25" colspan="3" class="normalfnth2B">Item Details</td>
  	</tr>
	<tr>
    	<td colspan="3"><table width="1003" border="0" cellpadding="0" cellspacing="0" class="tablez">
          <tr >
             <td width="48" bgcolor="#CCCCCC" class="normalfntBtab"  >Mat</td>
              <td width="81" bgcolor="#CCCCCC" class="normalfntBtab"  >Item Code</td>
	        <td width="368" bgcolor="#CCCCCC" class="normalfntBtab" >Description</td>
            <td width="76" bgcolor="#CCCCCC" class="normalfntBtab">Unit</td>			
			<td width="111" bgcolor="#CCCCCC" class="normalfntBtab">Qty</td>
			<td width="103" bgcolor="#CCCCCC" class="normalfntBtab">Rate</td>
			<td width="106"  bgcolor="#CCCCCC" class="normalfntBtab">Amount</td>
			<td width="108" bgcolor="#CCCCCC" class="normalfntBtab">Ret To Supp.</td>															
          </tr>
<?php 
$detailSql="SELECT distinct GH.strGenGrnNo,
 GH.intYear,
gengrndetails.intMatDetailID,
 GH.dtRecdDate,
genmatitemlist.intMainCatID,
genmatitemlist.intSubCatID,
 GH.intStatus,
genmatmaincategory.strDescription,
genmatitemlist.strItemDescription, 
genmatitemlist.strItemCode,
gengrndetails.dblQty AS dblQty,
 ((gengrndetails.dblQty) - gengrndetails.dblBalance) AS retToSup, 
POD.dblUnitPrice,
 POD.strUnit
FROM gengrnheader GH 
INNER JOIN gengrndetails ON GH.strGenGrnNo=gengrndetails.strGenGrnNo AND GH.intYear=gengrndetails.intYear 
INNER JOIN generalpurchaseorderheader POH ON GH.intGenPONo=POH.intGenPONo AND GH.intGenPOYear=POH.intYear 
INNER JOIN genmatitemlist ON gengrndetails.intMatDetailID=genmatitemlist.intItemSerial 
INNER JOIN genmatmaincategory ON genmatitemlist.intMainCatID=genmatmaincategory.intID
 inner join generalpurchaseorderdetails POD on POH.intGenPoNo= POD.intGenPoNo and POH.intYear= POD.intYear and POD.intMatDetailID=gengrndetails.intMatDetailID  
WHERE GH.intStatus=$intStatus 
AND GH.strGenGrnNo =".$rowdata["strGenGrnNo"]." AND GH.intYear =".$rowdata["intYear"]."";

			
			/*if ($intCompany!="")
			{
				$detailSql .= " AND GH.intCompId=$intCompany  ";
			}*/
			
			if ($intMeterial!= "")
			{					
				$detailSql .= " AND genmatitemlist.intMainCatID=$intMeterial ";
			}

			if ($intCategory!= "")
			{
				$detailSql .= " AND genmatitemlist.intSubCatID=$intCategory " ;
			}

			if ($intDescription!= "")
			{
				$detailSql .= " AND POD.intMatDetailID=$intDescription ";						
			}
					
			$detailResult = $db->RunQuery($detailSql);
			
		//	echo $detailSql;
			while ($details=mysql_fetch_array($detailResult))
			{
				
		  	?>
          <tr>
	        <td class="normalfntTAB"><?php echo(($details["strDescription"])); ?></td>
            <td class="normalfntTAB">&nbsp<?php echo(($details["strItemCode"])); ?></td>
            <td class="normalfntTAB"><?php echo($details["strItemDescription"]); ?></td>
            <td class="normalfntMidTAB"><?php echo($details["strUnit"]); ?></td>
            <td class="normalfntRiteTAB"><?php echo($details["dblQty"]); ?></td>
            <td class="normalfntRiteTAB"><?php echo(number_format($details["dblUnitPrice"],4)); ?></td>
            <td class="normalfntRiteTAB"><?php echo(number_format($details["dblQty"]*$details["dblUnitPrice"],2)); ?></td>
            <td class="normalfntRiteTAB"><?php echo round($details["retToSup"],2); ?></td>          
          </tr>
		  
		  <?php 		  
		  	}
		  ?>		  
        </table></td>
  	</tr>
	</table>
	<tr><td>&nbsp;</td></tr>
<?php
	}
?>

</td></tr></table>
<script type="text/javascript">

var rowCount =<?php echo $rowCount?>;
if(rowCount<=0){
	alert("Sorry!\nNo Records found in selected options.")
	window.close();
}
</script>
</body>
</html>
