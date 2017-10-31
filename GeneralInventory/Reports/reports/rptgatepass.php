<?php
	session_start();
	include "../../../Connector.php" ;
	$backwardseperator 	= "../../../";	
	$intMeterial 		= $_GET["intMeterial"];
	$intCategory 		= $_GET["intCategory"];
	$intDescription 	= $_GET["intDescription"];
	$intSupplier 		= $_GET["intSupplier"];
	$intBuyer 	  		= $_GET["intBuyer"];
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
<title>ePlan Web - Style Reports :: Gate Pass Details</title>
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
    <td colspan="5"><table width="100%" cellpadding="0" cellspacing="0">
      <tr>
        <td class="tophead"><table width="100%" cellpadding="0" cellspacing="0">
              <tr>
                <td width="19%"><img src="../../../images/eplan_logo.png" alt="" width="191" height="47" class="normalfnt" /></td>
              <td width="1%" class="normalfnt">&nbsp;</td>
				 <td align="center" valign="top" width="62%" class="topheadBLACK">
<?php
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
                 <td width="18%" class="tophead">&nbsp;</td>
              </tr>
          </table></td>
      </tr>
    </table></td>
  </tr>
    </table></td>
  </tr>
  
  
<tr>
     <td colspan="5" class="normalfnt2bldBLACKmid"><?php echo ("GATE PASS DETAILS.")?></td>
  </tr>
  <tr>
    <td colspan="5" class="normalfnth2" style="text-align:center">
	<?php 		
		if ($intStatus==1) $listType="(CONFIRMED LIST)"; 
		elseif ($intStatus==10) $listType="(PENDING LIST)";					 
		else $listType="(CANCELED LIST)"; 		
		echo $listType;
	?></td>
  </tr>  
  
  	<?php 		
$sql = "SELECT distinct GH.strGatepassID as intGatePassNo,
GH.intYear as intGPYear,
GH.dtmDate,
GH.strAttention,
(select  strName from companies MS where MS.intCompanyID=GH.intToStores)AS destination, 
(select  strName from companies MS where MS.intCompanyID=GH.intCompanyId)AS Dispatched
from gengatepassheader GH
inner join gengatepassdetail GD on GH.strGatepassID=GD.strGatepassID and GH.intYear=GD.intYear 
inner join genmatitemlist MIL on GD.intMatDetailID=MIL.intItemSerial
where GH.intStatus=$intStatus";			

			if($noFrom!=""){
				$sql .= " and GH.strGatepassID >= '$noFrom'";
			}
			if($noTo!=""){
				$sql .= " and GH.strGatepassID <= '$noTo'";
			}			
			if ($intCompany!="")
			{
				$sql = $sql." and GH.intCompanyId=$intCompany ";
			}
						
			if ($intMeterial!= "")
			{					
				$sql = $sql." and MIL.intMainCatID=$intMeterial ";	
			}

			if ($intCategory!= "")
			{
				$sql = $sql." and MIL.intSubCatID=$intCategory " ;
			}
			
			if ($intDescription!= "")
			{
				$sql = $sql." and MIL.intItemSerial=$intDescription " ;
			}

			if($dtmDateFrom!="")
			{					
				$sql = $sql." and DATE_FORMAT(GH.dtmDate ,'%Y/%m/%d') >= DATE_FORMAT('$dtmDateFrom','%Y/%m/%d')"; 
			}
			
			if($dtmDateTo!="")
			{					
			$sql = $sql." and DATE_FORMAT(GH.dtmDate ,'%Y/%m/%d') <= DATE_FORMAT('$dtmDateTo','%Y/%m/%d')"; 
			}
			
			$sql = $sql. " order by GH.strGatepassID";			
			
			//echo $sql;
			
			$result = $db->RunQuery($sql);
			$rowCount	= mysql_num_rows($result);
			while ($rowdata=mysql_fetch_array($result))
			{								
	?>
	<tr>
    	<td width="134" bgcolor="#C4DBFD" class="normalfnth2B" >Gate Pass Number : </td>
  	    <td width="67" bgcolor="#C4DBFD" class="normalfnth2B" ><?php echo $rowdata["intGPYear"].'/'.$rowdata["intGatePassNo"];  ?></td>
  	    <td width="800" >&nbsp;</td>
  	</tr> 
    <tr>	
    	<td colspan="3">
		<table width="965" border="0" cellpadding="0" cellspacing="0" class="bcgl1"><tr><td>
		
		<table width="100%" border="0" cellpadding="0" cellspacing="0" class="bcgl1">
          <tr height="25">
            <td  width="121" height="18" class="normalfnth2B">Destination</td>
			<td width="10" class="normalfnt">:</td>
			<td width="334" class="normalfnt">
            <?php
echo $rowdata["destination"];
?></td>
			<td colspan="2" class="normalfnt">&nbsp;</td>
			<td width="106" class="normalfnth2B">ATTENTION BY</td>
			<td width="11" class="normalfnth2B">:</td>
			<td width="241" class="normalfnt"><?php echo $rowdata["strAttention"]; ?></td>
          </tr>
          <tr height="25">
            <td height="18" class="normalfnth2B">Dispatched</td>
            <td class="normalfnt">:</td>
            <td class="normalfnth2B"><span class="normalfnt">		<?PHP
	echo $rowdata["Dispatched"];
		?></span></td>
            <td colspan="2" class="normalfnt">&nbsp;</td>
            <td class="normalfnth2B">Date &amp; Time </td>
            <td class="normalfnth2B">:</td>
            <td class="normalfnt"><?php  echo $rowdata["dtmDate"];?></td>
          </tr>          
        </table>
		<p class="head2BLCK"></p></td>
  	</tr>	
	<tr>
    	<td colspan="3"><table width="1003" border="0" cellpadding="0" cellspacing="0" class="tablez">
          <tr >
             <td width="20" bgcolor="#CCCCCC" class="normalfntBtab"  >Category</td>
	        <td width="277" bgcolor="#CCCCCC" class="normalfntBtab" >Item Code</td>
	        <td width="277" bgcolor="#CCCCCC" class="normalfntBtab" >Description</td>
            <td width="50" bgcolor="#CCCCCC" class="normalfntBtab">Unit</td>			
			<td width="73" bgcolor="#CCCCCC" class="normalfntBtab">Qty</td>
			<td width="70" bgcolor="#CCCCCC" class="normalfntBtab">GP Trans Qty</td>															
          </tr>
<?php 
$detailSql="SELECT distinct GH.strGatepassID as intGatePassNo,
GH.intYear AS intGPYear,  
GD.intMatDetailID,
MIL.strItemCode,
MIL.strItemDescription,
MIL.strUnit,
GD.dblQty,
(GD.dblQty-GD.dblBalQty)AS transInQty
FROM gengatepassheader GH
INNER JOIN gengatepassdetail GD ON GH.strGatepassID=GD.strGatepassID AND GH.intYear=GD.intYear
INNER JOIN genmatitemlist MIL ON GD.intMatDetailID=MIL.intItemSerial 
AND GH.strGatepassID =".$rowdata["intGatePassNo"]." AND GH.intYear =".$rowdata["intGPYear"]."";

			
			
			if ($intMeterial!= "")
			{					
				$detailSql .= " AND MIL.intMainCatID=$intMeterial ";
			}

			if ($intCategory!= "")
			{
				$detailSql .= " AND MIL.intSubCatID=$intCategory " ;
			}

			if ($intDescription!= "")
			{
				$detailSql .= " AND MIL.intItemSerial=$intDescription ";						
			}
				
					
			$detailResult = $db->RunQuery($detailSql);
		
			while ($details=mysql_fetch_array($detailResult))
			{
				
		  	?>
          <tr>
	        <td class="normalfntTAB"><?php echo $details["strDescription"]; ?></td>
	        <td class="normalfntTAB"><?php echo $details["strItemCode"]; ?></td>
            <td class="normalfntTAB"><?php echo $details["strItemDescription"]; ?></td>
            <td class="normalfntMidTAB"><?php
			/*$sqlstock="select strUnit from stocktransactions 
			where intDocumentNo='".$rowdata["intGatePassNo"]."'
			and intDocumentYear='".$rowdata["intGPYear"]."'
			and strStyleNo='".$details["strstyleid"]."'
			and strBuyerPoNo ='".$details["strBuyerPONO"]."'
			and intMatDetailId ='".$details["intMatDetailID"]."'
			and strColor ='".$details["strColor"]."'
			and strSize ='".$details["strSize"]."'";*/
			
			$sqlstock = "SELECT
						specificationdetails.strUnit
						FROM
						specificationdetails
						Inner Join specification ON specification.strStyleID = specificationdetails.strStyleID
						WHERE
						specification.intSRNO =  '". $details["intSRNO"]."' AND
						specificationdetails.strMatDetailID =  '". $details["intMatDetailID"]."'
						";
			$result_stock = $db->RunQuery($sqlstock);
			$row_sqlstock = mysql_fetch_array($result_stock);
			 echo $details["strUnit"]; ?></td>
            <td class="normalfntRiteTAB"><?php echo round($details["dblQty"],2); ?></td>
            <td class="normalfntRiteTAB"><?php echo round($details["transInQty"],2); ?></td>          
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
