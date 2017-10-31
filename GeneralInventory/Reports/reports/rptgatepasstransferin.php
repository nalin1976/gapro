<?php
	session_start();
	include "../../../Connector.php" ;
	$backwardseperator 	= "../../../";	
	$strStyleNo			= $_GET["strStyleNo"];
	$strBPo				= $_GET["strBPo"];
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
<title>ePlan Web - Reports ::General-Gate Pass TransferIn Details </title>
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
  
<tr>
     <td colspan="5" class="normalfnt2bldBLACKmid"><?php echo ("GATE PASS TRANSFER IN DETAILS.")?></td>
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
$sql = "SELECT distinct 
GH.intTransferInNo as intTransferInNo,
GH.intTransferInYear as intTINYear,
GH.intGatePassNo as intGatePassNo,
GH.intGPYear as intGPYear,
GH.dtmDate
from gengatepasstransferinheader GH
inner join gengatepasstransferindetails GD on GH.intTransferInNo=GD.intTransferInNo and GH.intTransferInYear=GD.intTransferInYear 
inner join genmatitemlist MIL on GD.intMatDetailId=MIL.intItemSerial
where GH.intStatus=$intStatus";			


			if($intCompany!=""){
				$sql .= " and GH.intCompanyId= '$intCompany'";
			}
			if($noFrom!=""){
				$sql .= " and GH.intTransferInNo >= '$noFrom'";
			}
			if($noTo!=""){
				$sql .= " and GH.intTransferInNo <= '$noTo'";
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
			
			$sql = $sql. " order by GH.intTransferInNo";			
			//echo $sql;
			$result = $db->RunQuery($sql);
			$rowCount	= mysql_num_rows($result);
			while ($rowdata=mysql_fetch_array($result))
			{								
	?>
	<tr>
    	<td width="142" bgcolor="#C4DBFD" class="normalfnth2B" >GP Trans In Number : </td>
  	    <td width="99" bgcolor="#C4DBFD" class="normalfnth2B" ><?php echo $rowdata["intTINYear"].'/'.$rowdata["intTransferInNo"];  ?></td>
  	    <td width="760" >&nbsp;</td>
  	</tr> 
    <tr>	
    	<td colspan="3">
		<table width="965" border="0" cellpadding="0" cellspacing="0" class="bcgl1"><tr><td>
		
		<table width="100%" border="0" cellpadding="0" cellspacing="0" class="bcgl1">
          <tr height="25">
            <td  width="134" height="18" class="normalfnth2B">Gate Pass No </td>
			<td width="10" class="normalfnt">:</td>
			<td width="322" class="normalfnt"><?php echo $rowdata["intGPYear"].'/'.$rowdata["intGatePassNo"];  ?></td>
			<td colspan="2" class="normalfnt">&nbsp;</td>
			<td width="163" class="normalfnth2B">&nbsp;</td>
			<td width="65" class="normalfnth2B">Date : </td>
			<td width="241" class="normalfnt"><?php echo $rowdata["dtmDate"]; ?></td>
          </tr>          
        </table>
		</td>
  	</tr>	
	<tr>
    	<td colspan="3"><table width="1003" border="0" cellpadding="0" cellspacing="0" class="tablez">
          <tr >
             <td width="20" bgcolor="#CCCCCC" class="normalfntBtab"  >Ctegory</td>
             <td width="20" bgcolor="#CCCCCC" class="normalfntBtab"  >Item Code</td>
	        <td width="277" bgcolor="#CCCCCC" class="normalfntBtab" >Description</td>
            <td width="50" bgcolor="#CCCCCC" class="normalfntBtab">Unit</td>			
			<td width="73" bgcolor="#CCCCCC" class="normalfntBtab">Qty</td>															
          </tr>
<?php 
$detailSql="SELECT distinct   
GD.intMatDetailId,
MIL.strItemCode,
MIL.strItemDescription,
MIL.strUnit,
GD.dblQty,
MMC.strID
FROM gengatepasstransferinheader GH
INNER JOIN gengatepasstransferindetails GD ON GH.intTransferInNo=GD.intTransferInNo AND GH.intTransferInYear=GD.intTransferInYear
INNER JOIN genmatitemlist MIL ON GD.intMatDetailId=MIL.intItemSerial 
INNER JOIN genmatmaincategory MMC ON MMC.intID=MIL.intMainCatID 
AND GH.intTransferInNo =".$rowdata["intTransferInNo"]." AND GH.intTransferInYear =".$rowdata["intTINYear"]."";

			
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
	        <td class="normalfntMidTAB"><?php echo $details["strID"]; ?></td>
	        <td class="normalfntTAB"><?php echo $details["strItemCode"]; ?></td>
            <td class="normalfntTAB"><?php echo $details["strItemDescription"]; ?></td>
            <td class="normalfntMidTAB"><?php
			$sqlstock="select strUnit from genstocktransactions 
			where intDocumentNo='".$rowdata["intTransferInNo"]."'
			and intDocumentYear='".$rowdata["intTINYear"]."'
			and intMatDetailId ='".$details["intMatDetailId"]."'";
			$result_stock = $db->RunQuery($sqlstock);
			$row_sqlstock = mysql_fetch_array($result_stock);
			 echo $row_sqlstock["strUnit"]; ?></td>
            <td class="normalfntRiteTAB"><?php echo round($details["dblQty"],2); ?></td>                
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
