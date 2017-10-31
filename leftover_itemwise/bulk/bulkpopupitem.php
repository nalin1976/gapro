<?php
$backwardseperator = "../../";
session_start();
include('../../Connector.php');
$styleId	= $_GET["StyleId"];
$mainStore	= $_GET["MainStore"];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>

<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<style type="text/css">
    #tblPrcBody { height:270px;overflow:scroll;}
</style>
</head>
<body>
<table width="850"  border="0" align="center" bgcolor="#FFFFFF" cellpadding="0" cellspacing="0">
    <tr>
    	<td>
        	<table  width="100%" border="0">
            	<tr>
                	<td>
                    	<table width="100%" border="0" class="tableBorder">
                        	
                        	<tr class="cursercross mainHeading" >
                            	<td width="94%" height="25">Item Details </td>
                                <td width="6%" height="25" ><img src="../../images/cross.png" onclick="CloseIWLOItem('popupLayer1');" /></td>
                        	</tr>
                           <tr>
                            	<td colspan="2" class="normalfnt"><table width="100%" border="0" cellspacing="0" cellpadding="1">
                                  <tr>
                                    <td width="22%">Main Category </td>
                                    <td width="78%"><select id="cboPopMainCat" style="width:250px" onchange="LoadSubCat(<?php echo $styleId ?>);">
<?PHP		
$sql="select distinct MC.intID,MC.strDescription 
from matmaincategory MC 
order by MC.intID";	 
$result =$db->RunQuery($sql);
	//echo "<option value =\"".""."\">"."Select One"."</option>";
while ($row=mysql_fetch_array($result))
{		
	echo "<option value=\"".$row["intID"]."\">".$row["strDescription"]."</option>";
}
?>
</select></td>
                                  </tr>
                                  <tr>
                                    <td class="normalfnt">Sub Category </td>
                                    <td><select id="cboPopSubCat" style="width:250px">
<?PHP		
$sql="select distinct MSC.intSubCatNo,MSC.StrCatName 
from matsubcategory MSC 
where MSC.intCatNo=1 and MSC.intStatus=1
order by MSC.StrCatName";	 
$result =$db->RunQuery($sql);
	echo "<option value =\"".""."\">"."Select One"."</option>";
while ($row=mysql_fetch_array($result))
{		
	echo "<option value=\"".$row["intSubCatNo"]."\">".$row["StrCatName"]."</option>";
}
?>
</select></td>
                                  </tr>
                                  <tr>
                                    <td class="normalfnt">Item Description </td>
                                    <td><input name="txtDesc" type="text" id="txtDesc" style="width:250px" onkeypress="EnterLoadPopItems(event);"/>
                                    <img src="../../images/search.png" alt="search" align="absmiddle" onclick="LoadPopItems();" /></td>
                                  </tr>
                                </table></td>
                       	  </tr>
                            <tr>
                            	<td colspan="2"><table style="width:850px" border="0" cellpadding="2" cellspacing="1" bgcolor="#CCCCFF" id="tblPopItem">
                                  <thead>
                                    <tr class="mainHeading4">
                                      <th width="20" height="25" ><input name="checkbox" type="checkbox" onclick="CheckAll(this,'tblPopItem');"/></th>
                                      <th width="99" >Main Category </th>
                                      <th width="97" >Sub Category </th>
                                      <th width="325" >Item Description</th>
                                      <th width="71" >Color</th>
                                      <th width="44" >Size</th>
                                      <th width="43" >Unit</th>
                                      <th width="61" >Stock Balance </th>
                                      <th width="61" >GRN No </th>
                                    </tr>
                                  </thead>
                                  <tbody >
                                    <?php 
$sql="select MMC.strDescription,MSC.StrCatName,STB.intMatDetailId,MIL.strItemDescription,STB.strColor,STB.strSize,STB.strUnit,concat(STB.intBulkGrnYear,'/',STB.intBulkGrnNo)as grnNo,
round(sum(STB.dblQty),2) - coalesce((select round(sum(CBD.dblQty),2) from commonstock_bulkheader CBH 
inner join commonstock_bulkdetails CBD on CBD.intTransferNo=CBH.intTransferNo and CBD.intTransferYear=CBH.intTransferYear
where CBD.intMatDetailId=STB.intMatDetailId and CBD.strColor=STB.strColor and CBD.strSize=STB.strSize and CBD.intBulkGRNYear=STB.intBulkGrnYear and CBD.intBulkGrnNo=STB.intBulkGrnNo and CBD.strUnit=STB.strUnit and CBH.intStatus=0 and CBH.intMainStoresID='1'),0) - 
coalesce((select sum(abs(dblQty)) from stocktransactions_bulk_temp STBT 
where STBT.intMatDetailId=STB.intMatDetailId and STBT.strColor=STB.strColor and STBT.strSize=STB.strSize and STBT.strSize=STB.strSize and STBT.strUnit=STB.strUnit and STBT.intBulkGrnNo=STB.intBulkGrnNo and STBT.intBulkGrnYear=STB.intBulkGrnYear and STBT.strType='GATEPASS'),0) as stockBal
from stocktransactions_bulk STB
inner join matitemlist MIL on MIL.intItemSerial=STB.intMatDetailId
inner join matmaincategory MMC on MMC.intID=MIL.intMainCatID
inner join matsubcategory MSC on MSC.intSubCatNo=MIL.intSubCatID
where MMC.intID=1
and STB.strMainStoresID='$mainStore'
group by STB.intMatDetailId,STB.strColor,STB.strSize,STB.strUnit
having stockBal>0
order by MMC.intID,MSC.StrCatName,MIL.strItemDescription,STB.strColor,STB.strSize,STB.strUnit,STB.intBulkGrnYear,STB.intBulkGrnNo;";
//echo $sql;
$result=$db->RunQuery($sql);
$rowCount = mysql_num_rows($result);
while($row=mysql_fetch_array($result))
{
	$stockBal	= $row['stockBal'];
?>
<tr class="bcgcolor-tblrowWhite">
	<td height="20" class="normalfntMid" id="<?php echo $row['intMainCatID'];?>"><input name="checkbox" type="checkbox" /></td>
	<td class="normalfnt" ><?php echo $row['strDescription'];?></td>
	<td class="normalfnt" id="<?php echo $row['intSubCatID'];?>"><?php echo $row['StrCatName'];?></td>
	<td class="normalfnt" id="<?php echo $row['intMatDetailId'];?>"><?php echo $row['strItemDescription'];?></td>
	<td class="normalfnt"><?php echo $row['strColor'];?></td>
	<td class="normalfnt"><?php echo $row['strSize'];?></td>
	<td class="normalfnt"><?php echo $row['strUnit'];?></td>
	<td class="normalfntRite"><?php echo round($stockBal,2);?></td>
    <td class="normalfnt"><?php echo $row['grnNo'];?></td>
    </tr>
<?php
}
?>
                                  </tbody>
                                </table></td>
                            </tr>
                         </table></td>
                </tr>
				<tr>
				<td align="center">
				<img src="../../images/addsmall.png" alt="add" onclick="AddToMainPage();" />
				<img src="../../images/close.png" alt="close" onclick="CloseIWLOItem('popupLayer1');"  /></td>
				</tr>
            </table></td>
     </tr>
</table>
</body>
</html>