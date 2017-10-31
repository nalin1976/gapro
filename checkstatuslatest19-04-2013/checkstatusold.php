<?php
session_start();
$backwardseperator = "../";
include "../Connector.php";

			$styleno			= $_POST["cboOrderNo"];
			$company			= $_POST["cbocompany"];
			$scno				= $_POST["cboscno"];
			$buyerpono			= $_POST["cbobuyerpo"];
			$matMainCategory	= $_POST["cboMainMatCategory"];	
			$styleName          = $_POST["cbostyleno"];	
			$description        = $_POST["cboDescription"];	


$sql = "SELECT intCompanyId FROM mainstores WHERE strMainID = '$company'";
$result = $db->RunQuery($sql);
while($row = mysql_fetch_array($result))
{
	$pocompany = $row["intCompanyId"];
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GaPro | Check Status</title>
<link href="../css/erpstyle.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
/*body {
	background-color: #CCCCCC;
}*/
-->
</style>
<script type="text/javascript" src="checkstatusjs.js"></script>
<script type="text/javascript" src="../javascript/script.js"></script>
<script type="text/javascript"  language="javascript">
function SubmitCheckForm()
{
	document.checkstatus.submit();
	
}

</script>
</head>
 
<body>
<form name="checkstatus" id="checkstatus" method="post" action="checkstatus.php">
<table width="100%" border="0" align="center">
<tr><td><?php include '../Header.php'; ?>
	</td></tr>
<tr>
<td>
<table width="950" border="0" align="center" bgcolor="#FFFFFF" class="tableBorder">
  <tr>
    <td height="25" bgcolor="#498CC2" class="mainHeading">Check Status</td>
  </tr>
  <tr>
    <td><table width="950" border="0" align="center" class="tableBorder">
      <tr>
        <td width="4%" class="normalfnt">Style</td>
<td width="17%"><select name="cbostyleno" class="txtbox" id="cbostyleno" style="width:160px" onchange="loadOrderNo();" >
                              <?php
	
	$SQL_style = "SELECT distinct orders.strStyle FROM orders
					Inner Join specification ON orders.intStyleId = specification.intStyleId
					WHERE orders.intStatus not in (2,12,13) ORDER BY orders.strStyle ASC ";
	
	
	$result_style = $db->RunQuery($SQL_style);
	echo "<option value=\"". "" ."\">" . "" ."</option>" ;
	while($row = mysql_fetch_array($result_style))
	{
		if ($_POST["cbostyleno"] ==  $row["strStyle"])
			echo "<option selected=\"selected\" value=\"". $row["strStyle"] ."\">" . $row["strStyle"] ."</option>" ;
		else
			echo "<option value=\"". $row["strStyle"] ."\">" . $row["strStyle"] ."</option>" ;
	}
	
	?>
        
        </select></td>
        <td width="11%" class="normalfnt">Order No</td>
        <td width="17%"><select name="cboOrderNo" id="cboOrderNo" style="width:160px;" onchange="LoadSCNo(this);">
        
        <?php 
			$SQL_Order = "SELECT orders.strOrderNo, orders.intStyleId FROM orders
					Inner Join specification ON orders.intStyleId = specification.intStyleId
					WHERE orders.intStatus not in (2,12,13) ";
	
	/*if($styleName != '')
				$SQL_Order .= " and orders.strStyle = '$styleName'";
				
			$SQL_Order .= " ORDER BY orders.strOrderNo ASC ";	
			*/
	$result_order = $db->RunQuery($SQL_Order);
	echo "<option value=\"". "" ."\">" . "" ."</option>" ;
	while($rowO = mysql_fetch_array($result_order))
	{
		if ($_POST["cboOrderNo"] ==  $rowO["intStyleId"])
		
			echo "<option selected=\"selected\" value=\"". $rowO["intStyleId"] ."\">" . $rowO["strOrderNo"] ."</option>" ;
		else
			echo "<option value=\"". $rowO["intStyleId"] ."\">" . $rowO["strOrderNo"] ."</option>" ;
	}
		?>
        </select>
        </td>
        <td width="8%" class="normalfnt">SC</td>
        <td width="18%"><select name="cboscno" class="txtbox" id="cboscno" style="width:160px" onchange="LoadStyleNo(this); ">
          <?php
	
	$SQL_style = "SELECT specification.intSRNO, specification.intStyleId FROM orders
					Inner Join specification ON orders.intStyleId = specification.intStyleId
					WHERE orders.intStatus  not in (2,12,13) ORDER BY specification.intSRNO DESC  ";
	
	/*if($styleName != '')
				$SQL_style .= " and orders.strStyle = '$styleName'";
				
		$SQL_style .= " ORDER BY specification.intSRNO DESC ";	*/
		
	$result_style = $db->RunQuery($SQL_style);
	echo "<option value=\"". "" ."\">" . "" ."</option>" ;
	while($row = mysql_fetch_array($result_style))
	{
            if ($_POST["cboscno"] ==  $row["intStyleId"])
			echo "<option selected=\"selected\" value=\"". $row["intStyleId"] ."\">" . $row["intSRNO"] ."</option>" ;
		    else		
			echo "<option value=\"". $row["intStyleId"] ."\">" . $row["intSRNO"] ."</option>" ;
	}
	
	?>
        </select></td>
         <td width="8%"><span class="normalfnt">Buyer PO </span></td>
        <td><select name="cbobuyerpo" class="txtbox" id="cbobuyerpo" style="width:160px">
          <?php

$SQL_style="select distinct strBuyerPONO from materialratio where intStyleId='". $styleno ."' ".
			"ORDER BY strBuyerPONO";

$result_style = $db->RunQuery($SQL_style);

		while($row = mysql_fetch_array($result_style))
		{
			if($row["strBuyerPONO"]=="#Main Ratio#")
				$buyersPoName	= "#Main Ratio#";
			else
				$buyersPoName = GetBuyerPoName($row["strBuyerPONO"]);
				
			if ($_POST["cbobuyerpo"] ==  $row["strBuyerPONO"])
				echo "<option selected=\"selected\" value=\"". $row["strBuyerPONO"] ."\">" . $buyersPoName ."</option>" ;
			else		
				echo "<option value=\"". $row["strBuyerPONO"] ."\">" . $buyersPoName ."</option>" ;
		}
	
?></select></td>
      </tr>
      <tr>
        <td class="normalfnt">Stores</td>
        <td><select name="cbocompany" class="txtbox" id="cbocompany" style="width:160px">
<?php		
$SQL_style = "SELECT strMainID As strComCode,strName FROM mainstores WHERE intStatus = '1';";
			
$result_style = $db->RunQuery($SQL_style);
			
		while($row = mysql_fetch_array($result_style))
		{
			if ($_POST["cbocompany"] ==  $row["strComCode"])
				echo "<option selected=\"selected\" value=\"". $row["strComCode"] ."\">" . $row["strName"] ."</option>" ;
			else	
				echo "<option value=\"". $row["strComCode"] ."\">" . $row["strName"] ."</option>" ;
		}
?>
        </select></td>
        <td class="normalfnt">Main Category </td>
        <td><select name="cboMainMatCategory" class="txtbox" id="cboMainMatCategory" style="width:160px" onchange="loadDescription();">
          <?php
	
	$sql= "select intID,strDescription from matmaincategory Order By intID";
	
	$result = $db->RunQuery($sql);
	echo "<option value=\"". "" ."\">" . "" ."</option>" ;
	while($row = mysql_fetch_array($result))
	{
            if ($_POST["cboMainMatCategory"] ==  $row["intID"])
			echo "<option selected=\"selected\" value=\"". $row["intID"] ."\">" . $row["strDescription"] ."</option>" ;
		    else		
			echo "<option value=\"". $row["intID"] ."\">" . $row["strDescription"] ."</option>" ;
	}
	
	?>
        </select></td>
 
       <td width="8%" class="normalfnt">Description</td>
        <td width="18%"><select name="cboDescription" class="txtbox" id="cboDescription" style="width:160px">
          <?php
	
	$SQL = "SELECT
orderdetails.intStyleId,
orderdetails.intMatDetailID,
matitemlist.intItemSerial,
matitemlist.strItemDescription,
matitemlist.intMainCatID,
orders.strStyle
FROM
orders
Inner Join orderdetails ON orders.intStyleId = orderdetails.intStyleId
Inner Join matitemlist ON orderdetails.intMatDetailID = matitemlist.intItemSerial ";
		
		if($matMainCategory != '')
				$SQL .= " and matitemlist.intMainCatID = '$matMainCategory'";
		if($styleName != '')
				$SQL .= " and orders.strStyle = '$styleName'";
				
		$SQL .= " ORDER BY matitemlist.strItemDescription ASC ";		
	$result = $db->RunQuery($SQL);
	echo "<option value=\"". "" ."\">" . "" ."</option>" ;
	while($row = mysql_fetch_array($result))
	{
		 if ($_POST["cboDescription"] ==  $row["intItemSerial"])
			echo "<option  selected=\"selected\" value=\"". $row["intItemSerial"] ."\">" . $row["strItemDescription"] ."</option>" ;
			  else		
			echo "<option value=\"". $row["intItemSerial"] ."\">" . $row["strItemDescription"] ."</option>" ;
		  
	}
	?>
        </select></td>
        <td>&nbsp;</td>
        
        <td width="17%" rowspan="2" valign="bottom"><div align="right"><img src="../images/search.png" alt="search" width="80" height="24" onclick="SubmitCheckForm();"/></div></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="950" border="0" cellpadding="0" cellspacing="0" align="center">
      
      <tr>
        <td><div id="divcons2" style="overflow: -moz-scrollbars-horizontal; height:450px; width:930px;">
          <table width="100%" id="tblMain" cellpadding="0" cellspacing="1" bgcolor="#CCCCFF" >
            <!--<tbody>-->
              <tr nowrap="nowrap" class="mainHeading4">            
				<td nowrap="nowrap" >&nbsp;Buyer PONo&nbsp;</td>
                <td nowrap="nowrap" >&nbsp;Cat.&nbsp;</td>
                <td >Detail</td>
                <td >ItemCode</td>
                <td >&nbsp;&nbsp;Color&nbsp;&nbsp;</td>
                <td >&nbsp;&nbsp;Size&nbsp;&nbsp;</td>
                <td >&nbsp;Unit&nbsp;</td>
                <td nowrap="nowrap"align="right" >&nbsp;&nbsp;&nbsp;&nbsp;Reqd Qty&nbsp;&nbsp;</td>
                <td nowrap="nowrap" align="right" >Bal To Order</td>
                <td nowrap="nowrap" align="right" >Ordered Qty</td>
                <td >Stock Balance</td>
				<td >&nbsp;</td>
                <td nowrap="nowrap" >GRN Qty</td>
				<td >&nbsp;</td>
                <td nowrap="nowrap" >Issue Qty</td>
                <td width="4%" >GatePass Qty</td>
                <td width="4%" >GP Trans Qty</td>
                <td  width="4%" >InterJob Trans In Qty</td>
                <td width="4%" >InterJob Trans Out Qty</td>
                <td width="4%" >Ret To Stores</td>
                <td width="4%" >Return To Supp</td>
                <td width="4%" >Bin Allo Out</td>
                <td width="4%" >Bin Allo In</td>   
                <td width="4%" >Bulk Allo In</td>   
                <td width="4%" >Leftover Allo In</td>     
                <td width="4%" >Leftover Out</td>           
                <td width="2%" >Extra</td>
                <td width="1%" >MatDet</td>				
              </tr>
<?php			
$result_search = "";
	$SQL_details = "SELECT s.intStyleId AS intStyleId, s.intSRNO,mc.strDescription, mil.strItemDescription,mil.intItemSerial AS intMatDetailId,mr.materialRatioID,
mr.strColor, mr.strSize,mr.strBuyerPONo,spd.strUnit,mr.dblQty AS Qty , mr.dblBalQty AS BalQty,mr.dblRecutQty,
(select sum(pd.dblQty) as purchQty from purchaseorderdetails pd inner join purchaseorderheader ph on ph.intPONo = pd.intPONo and 
ph.intYear = pd.intYear where pd.intStyleId = s.intStyleId and pd.intMatDetailID = mr.strMatDetailID and pd.strColor = mr.strColor and pd.strSize= mr.strSize and pd.strBuyerPONO = mr.strBuyerPONo and ph.intStatus=10 
and ph.intDelToCompID='$pocompany') as purchQty,
(select sum(st.dblQty) as stockQty from stocktransactions st where st.intStyleId = s.intStyleId and st.strBuyerPoNo = mr.strBuyerPoNo and st.intMatDetailId = spd.strMatDetailID and st.strColor = mr.strColor and st.strSize = mr.strSize and st.strMainStoresID='$company' ) as stockQty,
(select sum(st.dblQty) as grnQty from stocktransactions st where st.intStyleId = s.intStyleId and st.strBuyerPoNo = mr.strBuyerPoNo and st.intMatDetailId = spd.strMatDetailID and st.strColor = mr.strColor and st.strSize = mr.strSize and st.strMainStoresID='$company' and st.strType='GRN') as grnQty,
(select abs(sum(st.dblQty)) as binAlloout from stocktransactions st where st.intStyleId = s.intStyleId and st.strBuyerPoNo = mr.strBuyerPoNo and st.intMatDetailId = spd.strMatDetailID and st.strColor = mr.strColor and st.strSize = mr.strSize and st.strMainStoresID='$company' and st.strType='BINTROUT') as binAlloout,
(select abs(sum(st.dblQty)) as binAllIn from stocktransactions st where st.intStyleId = s.intStyleId and st.strBuyerPoNo = mr.strBuyerPoNo and st.intMatDetailId = spd.strMatDetailID and st.strColor = mr.strColor and st.strSize = mr.strSize and st.strMainStoresID='$company' and st.strType='BINTRIN') as binAllIn
FROM specification s inner join specificationdetails spd on spd.intStyleId = s.intStyleId
INNER JOIN matitemlist mil on mil.intItemSerial = spd.strMatDetailID
INNER JOIN  materialratio mr on mr.intStyleId = s.intStyleId and mr.strMatDetailID=spd.strMatDetailID
INNER JOIN matmaincategory mc on mc.intID = mil.intMainCatID
WHERE s.intStyleId ='$styleno'  ";
					if($buyerpono != ""){
						$SQL_details .= " AND mr.strBuyerPONo = '". $buyerpono ."' ";
					}
					if($matMainCategory!=""){
						$SQL_details .= " AND mc.intID = '". $matMainCategory ."' ";
					}
					if($description!=""){
						$SQL_details .= " AND mil.intItemSerial = '". $description ."' ";
					}
	$SQL_details .= "ORDER BY mc.intID ASC, mr.strMatDetailID ASC ";
//echo $SQL_details; 
$result_search = $db->RunQuery($SQL_details);			
	$i=0;
	while($row_search=mysql_fetch_array($result_search))
	{
			$i++;
			$reqqty	 	= $row_search["Qty"];
	 	if ($i % 2 == 0)
			$classtext 	= "bcgcolor-tblrowWhite";
		else
			$classtext 	= "bcgcolor-tblrowLiteBlue";
			
			if($row_search["strBuyerPONo"]=="#Main Ratio#")
				$buyersPoName	= "#Main Ratio#";
			else
				$buyersPoName = GetBuyerPoName($row_search["strBuyerPONo"]);
		
		$color = $row_search["strColor"];
		$size = $row_search["strSize"];	
		$matDetailId = $row_search["intMatDetailId"];
		$grnQty = $row_search["grnQty"];
		
		//start 2011-09-19 Bulk Allocation Qty
		$bulkAlloQty = getBulkAlloQty($styleno,$buyerpono,$company,$matDetailId,$color,$size,1);
		$cancelBAlloQty =getBulkAlloQty($styleno,$buyerpono,$company,$matDetailId,$color,$size,10); 
		$BAlloQty = $bulkAlloQty-$cancelBAlloQty;
		//end 2011-09-19 Bulk Allocation Qty
		
		//start 2011-09-20 Leftover Allocation In Qty
		$leftAlloInQty = getLeftoverAllocationQty($styleno,$buyerpono,$company,$matDetailId,$color,$size,1);
		$cancelLAlloQty = getLeftoverAllocationQty($styleno,$buyerpono,$company,$matDetailId,$color,$size,10); 
		$lAlloQty = $leftAlloInQty-$cancelLAlloQty;
		//end 2011-09-20 Leftover Allocation In Qty
		
		$leftoverStockQty = getLeftoverStockQty($styleno,$buyerpono,$company,$matDetailId,$color,$size);
		
?>
              <tr onclick="rowclickColorChange(this);" class="<?php echo $classtext;?>" onmouseover="this.style.background ='#D6E7F5';" onmouseout="this.style.background='';" >    
				<td onclick="GetCellIndex(this);" nowrap="nowrap" class="normalfntMid" id="<?php echo $row_search["strBuyerPONo"];?>"><?php echo $buyersPoName;?></td>
                <td  onclick="GetCellIndex(this);"  nowrap="nowrap" class="normalfnt"><?php echo substr($row_search["strDescription"],0,3);?></td>
                <td nowrap="nowrap" class="normalfnt"><?php echo $row_search["strItemDescription"];?></td>
                <td class="normalfnt"><?php echo $row_search["materialRatioID"];?></td>
                <td class="normalfnt"><?php echo $row_search["strColor"];?></td>
                <td  class="normalfnt"><?php echo $row_search["strSize"];?></td>
                <td  class="normalfntMid"><?php echo $row_search["strUnit"];?></td>
				
                <td nowrap="nowrap" align="right"  class="normalfntRite"><?php 
				$totQty = $row_search["Qty"]+$row_search["dblRecutQty"];
				echo number_format($totQty,2,".",",");?></td>
                
                <td nowrap="nowrap" align="right"  class="normalfntRite">
<?php 	
		$balqty =  $row_search["BalQty"];
		echo number_format($balqty,2,".",",");
 ?>				 </td>
                <td nowrap="nowrap" align="right" class="normalfntRite">
<?php 
				echo round($row_search["purchQty"],2);
?></td>
<td nowrap="nowrap" align="right" class="normalfntRite">
<?php 		

	echo round($row_search["stockQty"],2);
?> </td>
<td nowrap="nowrap" align="right" class="normalfntRite"><div align="center"><img src="../images/add.png" width="16" height="16" onclick="ShowDailyStockMovement(this);" /></div></td>
<td nowrap="nowrap" align="right" class="normalfntRite">
<?php 
echo ($grnQty==0?'':round($grnQty,2));
?></td>
<td nowrap="nowrap" align="right" class="normalfntRite"><div align="center"><img src="../images/add.png" width="16" height="16" onclick="ShowinterjobWindow(this);"></div></td>
<td nowrap="nowrap"  align="right" class="normalfntRite">
<?php
$issueQty='';
	if($grnQty>0 || $BAlloQty>0)
	{
$sql_i = "select sum(id.dblQty) as issueQty from issuesdetails id inner join issues i on
i.intIssueNo = id.intIssueNo and i.intIssueYear = id.intIssueYear where intStyleId='$styleno' and id.strColor ='$color'  
and id.strSize='$size' and i.intCompanyID = '$pocompany' and id.strBuyerPONO ='$buyerpono' and id.intMatDetailID='$matDetailId' ";

		$result_i = $db->RunQuery($sql_i);
		$rowI = mysql_fetch_array($result_i);
		$issueQty = $rowI["issueQty"];
	}
	echo $issueQty;
?></td>
<td nowrap="nowrap"  align="right" class="normalfntRite">
<?php 
	$sql_gp = "select sum(gpd.dblQty) as gpQty from gatepass gp inner join gatepassdetails gpd on 
gp.intGatePassNo = gpd.intGatePassNo and gp.intGPYear = gpd.intGPYear 
where gpd.intStyleId ='$styleno' and gpd.strBuyerPONO='$buyerpono' and gpd.strColor='$color' and gpd.intMatDetailId='$matDetailId'  and gpd.strSize='$size' and gp.intCompany='$pocompany' ";
	$result_gp = $db->RunQuery($sql_gp);
	$rowGp = mysql_fetch_array($result_gp);
	
	echo $rowGp["gpQty"];
?></td>
                <td nowrap="nowrap"  align="right" class="normalfntRite"><?php 
	$sql_gpT = "select sum(TD.dblQty) AS gpTransInQty from gategasstransferinheader TH 
	INNER JOIN gategasstransferindetails TD ON
	TH.intTransferInNo = TD.intTransferInNo AND TH.intTINYear = TD.intTINYear
	WHERE TH.intCompanyId='$pocompany' AND TD.intStyleId='$styleno' AND TD.strBuyerPONO='$buyerpono' AND TD.intMatDetailId='$matDetailId' AND TD.strColor ='$color' 	AND TD.strSize='$size'";
	
	$result_gpT = $db->RunQuery($sql_gpT);
	$rowGpT = mysql_fetch_array($result_gpT);
	echo $rowGpT["gpTransInQty"];
?></td>
                <td nowrap="nowrap" align="right" class="normalfntRite"><?php
	$intjobInQty = getIntejobAlloInQty($styleno,$buyerpono,$company,$matDetailId,$color,$size,3);	
	$cancelIjobQty = getIntejobAlloInQty($styleno,$buyerpono,$company,$matDetailId,$color,$size,10);
	if($intjobInQty>0)
		echo ($intjobInQty-$cancelIjobQty);			
//$interjobInQty = $row_search["interjobInQty"]-$row_search["cancelInterjobIn"];
//echo round($interjobInQty,2);
?></td>
                <td nowrap="nowrap" align="right" class="normalfntRite"><?php 
	$intjobOutQty = getIntejobAlloOutQty($styleno,$buyerpono,$company,$matDetailId,$color,$size,3);
	$cancelIjobOutQty = getIntejobAlloOutQty($styleno,$buyerpono,$company,$matDetailId,$color,$size,10);
	if($intjobOutQty>0)
		echo ($intjobOutQty - $cancelIjobOutQty);
?></td>
                <td nowrap="nowrap" align="right" class="normalfntRite"><?php
	$retStoreQty = getReturnToStoreQty($styleno,$buyerpono,$pocompany,$matDetailId,$color,$size,1);
	$cncelRetStoreQty = getReturnToStoreQty($styleno,$buyerpono,$pocompany,$matDetailId,$color,$size,10);
	if($retStoreQty>0)
		echo ($retStoreQty - $cncelRetStoreQty);
?></td>
                <td nowrap="nowrap" align="right" class="normalfntRite"><?php
	$retSupQty = getRetSupQty($styleno,$buyerpono,$pocompany,$matDetailId,$color,$size,1);
	$cancelRetSupQty = getRetSupQty($styleno,$buyerpono,$pocompany,$matDetailId,$color,$size,10);
	if($retSupQty>0)
		echo ($retSupQty - $cancelRetSupQty);
?></td>
                <td nowrap="nowrap" align="right" class="normalfntMid"><?php
echo $row_search["binAlloout"];
?></td>
                <td nowrap="nowrap" align="right" class="normalfntMid"><?php
echo $row_search["binAllIn"];
?></td>
	  <td nowrap="nowrap" class="normalfntRite" ><?php echo ($BAlloQty==0?'':$BAlloQty); ?></td>   
                <td nowrap="nowrap" class="normalfntRite" ><?php echo ($lAlloQty==0?'':$lAlloQty); ?></td>     
                <td nowrap="nowrap" class="normalfntRite"><?php echo ($leftoverStockQty==0?'':$leftoverStockQty); ?></td> 
                <td nowrap="nowrap" class="normalfntMid"><div align="center"><img src="../images/add.png" width="16" height="16" onclick="ShowExtra(this)"></div></td>
                <td nowrap="nowrap"  class="normalfntRite"><?php echo $row_search["intMatDetailId"];?></td>
              </tr>
              <?php
			  		
				}
			  ?>          
          </table>
        </div></td>
			      <td>
	 <div style="cursor: pointer;" class="div_verticalscroll" onmouseover="this.style.cursor='pointer'">
	<div style="height: 50%;" onmousedown="upp();" onmouseup="upp(1);"><img class="buttonUp" src="../images/uF035.png"></div>
	<div style="height: 50%;" onmousedown="down();" onmouseup="down(1);"><img class="buttonDn" src="../images/uF036.png"></div>
</div>      
      </td>
	  
      </tr>
    </table></td>
  </tr>
  <tr>
	  			      <td >
                      <table align="center" width="950px;"><tr><td>
<div class="div_horizontalscroll" onmouseover="this.style.cursor='pointer'" >
	<div style="float:left;width:50%;height:100%;" onmousedown="right();" onmouseup="right(1);" ><img class="buttonRight" src="../images/uF033.png"  ></div>

	<div style="float:right;width:50%;height:100%;" onmousedown="left();" onmouseup="left(1);" ><img class="buttonLeft" src="../images/uF034.png"></div>
</div> 
</td></tr></table>   
      </td>
	  </tr>
  <tr>
    <td ><table width="950" border="0" align="center" class="tableBorder">
      <tr>
        <td width="11%"><div align="center"><img src="../images/report.png" width="108" height="24" onclick="Report();" />
        <a href="../main.php"><img src="../images/close.png" alt="close" width="97" height="24" border="0"/></a></div></td>
      </tr>
    </table></td>
  </tr>
</table>
</td></tr></table>
</form>
<?php
	function GetBuyerPoName($buyerPoId)
	{
		global $db;
		$sql="select strBuyerPoName from style_buyerponos where strBuyerPONO='$buyerPoId'";
		$result=$db->RunQuery($sql);
		$row = mysql_fetch_array($result);
		return $row["strBuyerPoName"];
	}
?>
 <script type="text/javascript">
 var freezeRow=1; //change to row to freeze at
  var freezeCol=6; //change to column to freeze at
  var myRow=freezeRow;
  var myCol=freezeCol;
  var speed=100; //timeout speed

  var myTable;
  var noRows;
  var myCells,ID;
  

  
function setUp(){
	if(!myTable){myTable=document.getElementById("tblMain");}
 	myCells = myTable.rows[0].cells.length;
	noRows=myTable.rows.length;

	for( var x = 0; x < myTable.rows[0].cells.length; x++ ) {
		colWdth=myTable.rows[0].cells[x].offsetWidth;
		myTable.rows[0].cells[x].setAttribute("width",colWdth-4);

	}
}


function right(up){
	if(up){window.clearTimeout(ID);return;}
	if(!myTable){setUp();}

	if(myCol<(myCells)){
		for( var x = 0; x < noRows; x++ ) {
			myTable.rows[x].cells[myCol].style.display="";
		}
		if(myCol >freezeCol){myCol--;}
		ID = window.setTimeout('right()',speed);
	}
}

function left(up){
	if(up){window.clearTimeout(ID);return;}
	if(!myTable){setUp();}

	if(myCol<(myCells-1)){
		for( var x = 0; x < noRows; x++ ) {
			myTable.rows[x].cells[myCol].style.display="none";
		}
		myCol++
		ID = window.setTimeout('left()',speed);

	}
}

function down(up){
	if(up){window.clearTimeout(ID);return;}
	if(!myTable){setUp();}

	if(myRow<(noRows-1)){
			myTable.rows[myRow].style.display="none";
			myRow++	;

			ID = window.setTimeout('down()',speed);
	}
}

function upp(up){
	if(up){window.clearTimeout(ID);return;}
	if(!myTable){setUp();}
	if(myRow<=noRows){
		myTable.rows[myRow].style.display="";
		if(myRow >freezeRow){myRow--;}
		ID = window.setTimeout('upp()',speed);
	}
}
function GetCellIndex(obj){
	freezeCol=parseInt(obj.cellIndex);

}

</script>
<style type="text/css" media="all">
.td1 {background:#EEEEEE;color:#000;border:1px solid #000;}
.th{background:blue;color:white;border:1px solid #000;}
A:link {COLOR: #0000EE;}
A:hover {COLOR: #0000EE;}
A:visited {COLOR: #0000EE;}
A:hover {COLOR: #0000EE;}

.div_freezepanes_wrapper{
position:relative;width:90%;height:400px;
overflow:hidden;background:#fff;border-style: ridge;
}

.div_verticalscroll{
position: relative;
#left:900px;
#top:-220px;
right:0px;
width:18px;
height:450px;
background:#EAEAEA;
border:1px solid #C0C0C0;
}

.buttonUp{
width:20px;position: absolute;top:2px;
}

.buttonDn{
width:20px;position: absolute;bottom:22px;
}

.div_horizontalscroll{
#position: absolute;
#bottom:100px;
width:950px;
height:18px;
background:#EAEAEA;
border:1px solid #C0C0C0;
}

.buttonRight{
width:20px;position: relative;left:0px;padding-top:2px;
}

.buttonLeft{
width:20px;position: relative;left:450px;padding-top:2px;
}
</style>
<?php 
function getBulkAlloQty($styleno,$buyerpono,$company,$matDetailId,$color,$size,$status)
{
	global $db;
	$sql = " select sum(cbd.dblQty) as bulkAlloQty from commonstock_bulkdetails cbd inner join commonstock_bulkheader cbh on cbh.intTransferNo = cbd.intTransferNo and cbh.intTransferYear = cbd.intTransferYear
where cbh.intToStyleId='$styleno' and cbh.intMainStoresID='$company' and cbd.intMatDetailId='$matDetailId' and cbd.strColor='$color' and cbd.strSize = '$size' and cbh.intStatus='$status' and strToBuyerPoNo ='$buyerpono'";
	
	$result =  $db->RunQuery($sql);	
	$row = mysql_fetch_array($result);
	return $row["bulkAlloQty"];
}

function getIntejobAlloInQty($styleno,$buyerpono,$company,$matDetailId,$color,$size,$status)
{
	global $db;
	$sql = "select sum(id.dblQty) as ijobQty from itemtransfer i inner join itemtransferdetails id on
i.intTransferId = id.intTransferId and i.intTransferYear = id.intTransferYear
where i.intStyleIdTo='$styleno' and i.strToBuyerPoNo='$buyerpono'  and i.intMainStoreID ='$company'
and id.intMatDetailId='$matDetailId' and id.strColor='$color' and id.strSize='$size' and i.intStatus ='$status' ";
	
	$result =  $db->RunQuery($sql);	
	$row = mysql_fetch_array($result);
	return $row["ijobQty"];
}

function getIntejobAlloOutQty($styleno,$buyerpono,$company,$matDetailId,$color,$size,$status)
{
	global $db;
	$sql = "select sum(id.dblQty) as ijobQty from itemtransfer i inner join itemtransferdetails id on
i.intTransferId = id.intTransferId and i.intTransferYear = id.intTransferYear
where i.intStyleIdFrom='$styleno' and id.strBuyerPoNo='$buyerpono'  and i.intMainStoreID ='$company'
and id.intMatDetailId='$matDetailId' and id.strColor='$color' and id.strSize='$size' and i.intStatus ='$status' ";
	
	$result =  $db->RunQuery($sql);	
	$row = mysql_fetch_array($result);
	return $row["ijobQty"];
}

function getReturnToStoreQty($styleno,$buyerpono,$pocompany,$matDetailId,$color,$size,$status)
{
	global $db;
	$sql = "select sum(rsd.dblReturnQty) as returnQty from returntostoresdetails rsd inner join returntostoresheader rsh on
rsh.intReturnNo = rsd.intReturnNo and rsh.intReturnYear = rsd.intReturnYear
where rsh.intStatus='$status' and rsh.intCompanyID='$pocompany' and rsd.intStyleId='$styleno' and rsd.strBuyerPoNo='$buyerpono' and rsd.intMatdetailID='$matDetailId' and rsd.strColor='$color' and rsd.strSize='$size' ";
	
	$result =  $db->RunQuery($sql);	
	$row = mysql_fetch_array($result);
	return $row["returnQty"];
}
function getRetSupQty($styleno,$buyerpono,$pocompany,$matDetailId,$color,$size,$status)
{
	global $db;
	$sql = "select sum(rsd.dblQty) as retSupQty from returntosupplierdetails rsd inner join returntosupplierheader rs on
rs.intReturnToSupNo = rsd.intReturnToSupNo and rs.intReturnToSupYear= rsd.intReturnToSupYear
where rs.intStatus='$status' and rs.intCompanyID='$pocompany' and rsd.intStyleId='$styleno' and rsd.strBuyerPoNo='$buyerpono' and rsd.intMatdetailID ='$matDetailId' and rsd.strColor='$color' and rsd.strSize='$size' ";
	
	$result =  $db->RunQuery($sql);	
	$row = mysql_fetch_array($result);
	return $row["retSupQty"];
}
function getLeftoverAllocationQty($styleno,$buyerpono,$company,$matDetailId,$color,$size,$status)
{
	global $db;
	$sql = "select sum(lcd.dblQty) as leftQty from commonstock_leftoverdetails lcd inner join 
	commonstock_leftoverheader lch on
lch.intTransferNo = lcd.intTransferNo and lch.intTransferYear= lcd.intTransferYear
where lch.intStatus='$status' and lch.intMainStoresId='$company' and lch.intToStyleId='$styleno' and lch.strToBuyerPoNo='$buyerpono' and lcd.intMatDetailId='$matDetailId' and lcd.strColor='$color' and lcd.strSize='$size' ";
	
	$result =  $db->RunQuery($sql);	
	$row = mysql_fetch_array($result);
	return $row["leftQty"];
}
function getLeftoverStockQty($styleno,$buyerpono,$company,$matDetailId,$color,$size)
{
	global $db;
	echo $sql = " select sum(dblQty) as leftStock from stocktransactions_leftover where strMainStoresID='$company'
and intStyleId='$styleno' and strBuyerPoNo='$buyerpono' and intMatDetailId='$matDetailId' and strColor='$color' and strSize='$size' ";

	$result =  $db->RunQuery($sql);	
	$row = mysql_fetch_array($result);
	return $row["leftStock"];
}
?>
</body>
</html>
