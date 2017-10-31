<?php
$backwardseperator = "../";
session_start();
include('../Connector.php');
$styleId	= $_GET["StyleId"];
$mainStore	= $_GET["MainStore"];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>

<link href="../css/erpstyle.css" rel="stylesheet" type="text/css" />
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
                                <td width="6%" height="25" ><img src="../images/cross.png" onclick="CloseIWLOItem('popupLayer1');" /></td>
                        	</tr>
                           <tr>
                            	<td colspan="2" class="normalfnt"><table width="100%" border="0" cellspacing="0" cellpadding="1">
                                  <tr>
                                    <td width="22%">Main Category </td>
                                    <td width="78%"><select id="cboPopMainCat" style="width:250px" onchange="LoadSubCat(<?php echo $styleId ?>);">
<?PHP		
$sql="select distinct MC.intID,MC.strDescription 
from matmaincategory MC 
inner join matitemlist MIL on  MIL.intMainCatID=MC.intID
inner join orderdetails OD on OD.intMatDetailID=MIL.intItemSerial
where OD.intStyleId=$styleId order by MC.intID";	 
$result =$db->RunQuery($sql);
	echo "<option value =\"".""."\">"."Select One"."</option>";
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
$sql="select distinct MSC.intSubCatNo,MSC.StrCatName from matsubcategory MSC 
inner join matitemlist MIL on  MIL.intSubCatID=MSC.intSubCatNo
inner join orderdetails OD on OD.intMatDetailID=MIL.intItemSerial
where OD.intStyleId=$styleId order by MSC.StrCatName";	 
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
                                    <img src="../images/search.png" alt="search" align="absmiddle" onclick="LoadPopItems();" /></td>
                                  </tr>
                                </table></td>
                       	  </tr>
                            <tr>
                            	<td colspan="2"><table style="width:850px" border="0" cellpadding="0" cellspacing="1" bgcolor="#F3E8FF" id="tblPopItem">
                                  <thead>
                                    <tr class="mainHeading4">
                                      <th width="20" height="25" ><input name="checkbox" type="checkbox" onclick="CheckAll(this,'tblPopItem');"/></th>
                                      <th width="99" >Main Category </th>
                                      <th width="97" >Sub Category </th>
                                      <th width="325" >Item Description</th>
                                      <th width="80" >Buyer PO No </th>
                                      <th width="71" >Color</th>
                                      <th width="44" >Size</th>
                                      <th width="43" >Unit</th>
                                      <th width="61" >Stock Balance </th>
                                      <th width="61" >GRN No </th>
                                      <th width="61" >GRN Type </th>
                                    </tr>
                                  </thead>
                                  <tbody >
                                    <?php 
$sql="select MMC.strDescription,MIL.intSubCatID,MSC.StrCatName,ST.intMatDetailId,MIL.strItemDescription,ST.strBuyerPoNo,
ST.strColor,ST.strSize,ST.strUnit,
round(sum(dblQty),2)- coalesce((select round(sum(dblBalQty),2)as balQty 
from matrequisitiondetails MRD INNER JOIN matrequisition MRH ON MRH.intMatRequisitionNo=MRD.intMatRequisitionNo AND MRH.intMRNYear=MRD.intYear
 where MRD.intStyleId=ST.intStyleId and MRD.strBuyerPONO=ST.strBuyerPoNo and MRD.strMatDetailID=ST.intMatDetailId and MRD.strColor=ST.strColor 
and MRD.strSize=ST.strSize and MRD.intGrnNo=ST.intGrnNo  and MRD.intGrnYear=ST.intGrnYear and MRD.strGRNType=ST.strGRNType 
AND ST.strMainStoresID = MRH.strMainStoresID),0) -
coalesce((SELECT ABS(SUM(STT.dblQty)) AS GPqty FROM stocktransactions_temp STT 
WHERE STT.strMainStoresID=ST.strMainStoresID AND STT.intStyleId=ST.intStyleId AND STT.strBuyerPoNo=ST.strBuyerPoNo
AND STT.intMatDetailId = ST.intMatDetailId AND STT.strColor = ST.strColor AND STT.strSize = ST.strSize AND 
STT.intGrnNo = ST.intGrnNo AND STT.intGrnYear = ST.intGrnYear AND STT.strGRNType = ST.strGRNType AND STT.strType='SGatePass'),0) -
coalesce((SELECT SUM(ITD.dblQty) AS InterjobQty 
FROM itemtransferdetails ITD 
INNER JOIN itemtransfer IT ON IT.intTransferId = ITD.intTransferId AND IT.intTransferYear = ITD.intTransferYear
WHERE IT.intStyleIdFrom=ST.intStyleId AND ITD.strBuyerPoNo =ST.strBuyerPoNo AND ITD.intMatDetailId =ST.intMatDetailId
 AND ITD.strColor=ST.strColor AND ITD.strSize=ST.strSize AND ITD.intGrnNo= ST.intGrnNo AND ITD.intGrnYear=ST.intGrnYear
 AND ITD.strGRNType=ST.strGRNType AND IT.intMainStoreID = ST.strMainStoresID AND IT.intStatus IN (0,1,2)),0) 
 as stockBal,
ST.intGrnNo,ST.intGrnYear,ST.strGRNType
from stocktransactions ST inner join matitemlist MIL on MIL.intItemSerial=ST.intMatDetailId
inner join matmaincategory MMC on MMC.intID=MIL.intMainCatID
inner join matsubcategory MSC on MSC.intSubCatNo=MIL.intSubCatID
where ST.intStyleId='$styleId' and ST.strMainStoresID='$mainStore'
group by strMainStoresID,intStyleId,intMatDetailId,strColor,strSize,ST.intGrnNo,ST.intGrnYear,ST.strGRNType
having stockBal>0
order by MIL.intMainCatID,MSC.StrCatName,MIL.strItemDescription ";
//echo $sql;
$result=$db->RunQuery($sql);
$rowCount = mysql_num_rows($result);
while($row=mysql_fetch_array($result))
{
	if($row["strGRNType"]=='B')
		$grnType = 'Bulk';
	elseif($row["strGRNType"]=='S')
		$grnType = 'Style';
	
	$stockBal	= $row['stockBal'];
	
?>
<tr class="bcgcolor-tblrowWhite">
	<td height="20" class="normalfntMid" id="<?php echo $row['intMainCatID'];?>"><input name="checkbox" type="checkbox" /></td>
	<td class="normalfnt" ><?php echo $row['strDescription'];?></td>
	<td class="normalfnt" id="<?php echo $row['intSubCatID'];?>"><?php echo $row['StrCatName'];?></td>
	<td class="normalfnt" id="<?php echo $row['intMatDetailId'];?>"><?php echo $row['strItemDescription'];?></td>
	<td class="normalfnt" ><?php echo $row['strBuyerPoNo'];?></td>
	<td class="normalfnt"><?php echo $row['strColor'];?></td>
	<td class="normalfnt"><?php echo $row['strSize'];?></td>
	<td class="normalfnt"><?php echo $row['strUnit'];?></td>
	<td class="normalfntRite"><?php echo round($stockBal,2);?></td>
    <td class="normalfnt"><?php echo $row['intGrnYear'].'/'.$row['intGrnNo'];?></td>
    <td class="normalfnt" id="<?php echo $row["strGRNType"];?>"><?php echo $grnType;?></td>
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
				<img src="../images/addsmall.png" alt="add" onclick="AddToMainPage();" />
				<img src="../images/close.png" alt="close" onclick="CloseIWLOItem('popupLayer1');"  /></td>
				</tr>
            </table></td>
     </tr>
</table>
</body>
</html>
