<?php
 session_start();
 $backwardseperator = "../../";
include "../../Connector.php";
$report_companyId = $_SESSION["FactoryID"];
$cboMainCat   = $_GET['cboMainCat']; 
 $cboSubCat   = $_GET['cboSubCat']; 
 $cboMatItem  = $_GET['cboMatItem']; 
 $cboCompanyId  = $_GET['cboCompany'];
 $bal         = $_GET['bal']; 
 $txtmaterial = $_GET["txtmaterial"];
 $costCenter  = $_GET["CostCenter"];
 $GLCode	  = $_GET["GLCode"];	
 
 $cboCompany = GetMainStoresID($cboCompanyId);

?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>General Stock Balance-Summery Report</title>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="900" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td><?php include "../../reportHeader.php";?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td class="head2BLCK">General Stock Balance - Summery Report</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><table width="900" border="0" cellspacing="1" cellpadding="2" bgcolor="#000000">
      <tr class="normalfntMid" bgcolor="#CCCCCC">
        <th width="150">Main Category</th>
        <th width="167">Sub Category</th>
        <th width="167">Item Code</th>
        <th width="344">Item Description</th>
        <th width="103">Stock Balance</th>
        <th width="110">Stock Balance Value</th>   
      </tr>
      <?php 
	  if($costCenter!="")
	  {
	  $sql_stock = "select sum(gst.dblQty) as stockQty,gmil.strItemDescription, gmc.strDescription as mainCategory,gmsub.StrCatName as subCategory,gst.intMatDetailId, gmil.strItemCode
from genstocktransactions gst inner join genmatitemlist gmil on 
gmil.intItemSerial= gst.intMatDetailId
inner join genmatmaincategory gmc on gmc.intID = gmil.intMainCatID
inner join genmatsubcategory gmsub on gmsub.intSubCatNo = gmil.intSubCatID
where gst.strMainStoresID>0 ";

	if($cboMainCat != '')
		$sql_stock .= " and gmil.intMainCatID = '$cboMainCat' ";
	 if($cboSubCat != '')
		$sql_stock .= " and gmil.intSubCatID = '$cboSubCat' ";
	 if($cboMatItem != '')
		$sql_stock .= " and gst.intMatDetailId = '$cboMatItem' ";
	 if($txtmaterial != '')			
		$sql_stock .= " and gmil.strItemDescription like '%$txtmaterial%' ";
	 if($cboCompany != '')
		$sql_stock .= " and gst.strMainStoresID = '$cboCompany' ";	
	if($costCenter!="")
		$sql_stock .= " and gst.intCostCenterId = '$costCenter' ";	
	if($GLCode!="")
		$sql_stock .= " and gst.intGLAllowId = '$GLCode' ";	
		
	$sql_stock .= " group by mainCategory,subCategory,gmil.strItemDescription,gst.intCostCenterId,gst.intGLAllowId ";
	
	if($bal==0)
		$sql_stock .= " having stockQty>=0 ";
	else
		$sql_stock .= " having stockQty>0 ";
	  }
	  else
	  {
		   $sql_stock = "select sum(gst.dblQty) as stockQty,gmil.strItemDescription, gmc.strDescription as mainCategory,gmsub.StrCatName as subCategory,gst.intMatDetailId, gmil.strItemCode
from genstocktransactions gst inner join genmatitemlist gmil on 
gmil.intItemSerial= gst.intMatDetailId
inner join genmatmaincategory gmc on gmc.intID = gmil.intMainCatID
inner join genmatsubcategory gmsub on gmsub.intSubCatNo = gmil.intSubCatID
left join glallowcation GLA on GLA.GLAccAllowNo=gst.intGLAllowId
where gst.strMainStoresID>0 ";

	if($cboMainCat != '')
		$sql_stock .= " and gmil.intMainCatID = '$cboMainCat' ";
	 if($cboSubCat != '')
		$sql_stock .= " and gmil.intSubCatID = '$cboSubCat' ";
	 if($cboMatItem != '')
		$sql_stock .= " and gst.intMatDetailId = '$cboMatItem' ";
	 if($txtmaterial != '')			
		$sql_stock .= " and gmil.strItemDescription like '%$txtmaterial%' ";
	 if($cboCompany != '')
		$sql_stock .= " and gst.strMainStoresID = '$cboCompany' ";	
	if($costCenter!="")
		$sql_stock .= " and gst.intCostCenterId = '$costCenter' ";	
	if($GLCode!="")
		$sql_stock .= " and GLA.GLAccNo = '$GLCode' ";	
		
	//$sql_stock .= " group by mainCategory,subCategory,gmil.strItemDescription,gst.intGLAllowId,gst.intCostCenterId ";
	$sql_stock .= " group by mainCategory,subCategory,gmil.strItemDescription ";	
	if($bal==0)
		$sql_stock .= " having stockQty>=0 ";
	else
		$sql_stock .= " having stockQty>0 ";
	  }
	//echo $sql_stock;
	$result_stock = $db->RunQuery($sql_stock);
	$totQty =0;
	$totValue=0;
	while($rowS = mysql_fetch_array($result_stock))
	{
		$value = getStockValue($rowS["intMatDetailId"],$cboCompany,$bal);
		$totQty += $rowS["stockQty"];
		$totValue += $value;
	  ?>
      <tr bgcolor="#FFFFFF">
        <td class="normalfnt" height="20"><?php echo $rowS["mainCategory"]; ?></td>
        <td class="normalfnt"><?php echo $rowS["subCategory"]; ?></td>
        <td class="normalfnt"><?php echo $rowS["strItemCode"]; ?></td>
        <td class="normalfnt"><?php echo $rowS["strItemDescription"]; ?></td>
        <td class="normalfntRite"><?php echo round($rowS["stockQty"],4); ?></td>
        <td class="normalfntRite"><?php echo number_format($value,4); ?></td>  
      </tr>
      <?php 
	  }
	  ?>
      <tr bgcolor="#EBEBEB">
      <td class="normalfnt" colspan="4"><b>Grand Total</b></td>
      <td class="normalfntRite"><?php echo round($totQty,4); ?></td>
      <td class="normalfntRite"><?php echo round($totValue,4); ?></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
<?php 
function getStockValue($matDetailId,$cboCompany,$bal)
{
	global $db;
	$sql = " select sum(gst.dblQty) as Qty,intGRNNo,intGRNYear
from genstocktransactions gst 
where intMatDetailId='$matDetailId' ";

	if($cboCompany != '')
		$sql .= " and gst.strMainStoresID = '$cboCompany' ";
	$sql .= " group by  intGRNNo,intGRNYear ";	
	
	if($bal='0')
		$sql .= " having Qty>=0 ";
	else
		$sql .= " having Qty>0 ";
		
	$result = $db->RunQuery($sql);
	$value=0;
	//echo $sql;
	while($row = mysql_fetch_array($result))
	{
		$Qty = $row["Qty"];
		$intGRNNo = $row["intGRNNo"];
		$intGRNYear = $row["intGRNYear"];
		
		$sql_val = "select gd.dblRate,gh.dblExRate 
from gengrnheader gh inner join gengrndetails gd on
gh.strGenGrnNo = gd.strGenGrnNo and gh.intYear= gd.intYear
where gh.strGenGrnNo='$intGRNNo' and gh.intYear='$intGRNYear' and gd.intMatDetailID='$matDetailId' ";
		$result_val = $db->RunQuery($sql_val);
		$rowR = mysql_fetch_array($result_val);
		
		$value += $Qty*$rowR["dblRate"]/$rowR["dblExRate"];
		
	}
	return round($value,4);	
}

function GetMainStoresID($prmCompanyId){
	
	global $db;
	
	$sql = " SELECT * FROM mainstores WHERE intCompanyId = ".$prmCompanyId;
	
	$result = $db->RunQuery($sql);
	
	while($row=mysql_fetch_array($result)){		
		return $row['strMainID'];		
	}
}

?>
</body>
</html>
