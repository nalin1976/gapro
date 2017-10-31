<?php
session_start();
$backwardseperator = "../";
include "../authentication.inc";
include "../Connector.php";

$report_companyId  	= $_SESSION["FactoryID"];	
$xml 				= simplexml_load_file('config.xml');
$ReportISORequired 	= $xml->companySettings->ReportISORequired;
$style				= $_GET["style"];
$orderNo			= GetOrderNo($style);
$maincatid			= $_GET["maincatid"];
$subcatid			= $_GET["subcatid"];	
$material			= $_GET["material"];
$color				= $_GET["color"];
$size				= $_GET["size"];
$grnNo				= $_GET["grnNo"];	
$poNo				= $_GET["poNo"];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GaPro | Item Wise Bin Report</title>
<link href="../css/erpstyle.css" rel="stylesheet" type="text/css" />
</head>
<body>
<table width="800" border="0" align="center">
  <tr>
    <td><table width="100%" cellpadding="0" cellspacing="0">
      
      <tr>
        <td><?php	
$SQL = "select
matitemlist.strItemDescription
from matitemlist
where matitemlist.intItemSerial =  '$material'";	
$result_matre = $db->RunQuery($SQL);
$row = mysql_fetch_array($result_matre);
$materialDesc=$row["strItemDescription"];
	
$SQL = "select
matmaincategory.strDescription
from matmaincategory
where matmaincategory.intID =  '$maincatid'";	
$result_matre = $db->RunQuery($SQL);
$row = mysql_fetch_array($result_matre);
$mainCatDesc=$row["strDescription"];
	
$SQL = "select
matsubcategory.StrCatName
from matsubcategory
where matsubcategory.intSubCatNo =  '$subcatid'";	
$result_matre = $db->RunQuery($SQL);
$row = mysql_fetch_array($result_matre);
$subCatDesc=$row["StrCatName"];
		

		
		 ?>           
            </p>
             <?php include "../reportHeader.php";?></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" class="head2BLCK">
      <tr>
      	<td width="16%"></td>
        <td width="67%" class="head2BLCK">BIN INQUIRY REPORT-ITEM WISE</td>
        <td width="17%"><?php			
   					if($ReportISORequired == "true")
   					{
   						$xmlISO = simplexml_load_file('iso.xml');
   						echo  $xmlISO->ISOCodes->StyleMRNReport;
					}          
         ?></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0">
      <tr>
        <td width="50%" ><table width="100%" border="0">
              <tr> 
                <td width="41%" class="normalfnt2bldBLACK">Order No </td>
                <td width="59%" class="normalfnt">: <?php echo $orderNo;?></td>
              </tr>
            </table></td>
        <td width="50%" ><table width="100%" border="0">
              <tr> 
                <td width="34%" class="normalfnt2bldBLACK"><?php echo $mainCatDesc=='' ? '&nbsp;':"Main Catogory" ?> </td>
                <td width="66%" class="normalfnt"><?php echo $mainCatDesc=='' ? '&nbsp;':":&nbsp;$mainCatDesc" ?></td>
              </tr>
            </table></td>
      </tr>
      <tr>
        <td width="50%" ><table width="100%" border="0">
              <tr> 
                <td width="41%" class="normalfnt2bldBLACK"><?php echo $subCatDesc=='' ? '&nbsp;':"Sub Category" ?> </td>
                <td width="59%" class="normalfnt"><?php echo $subCatDesc=='' ? '&nbsp;':":&nbsp;$subCatDesc" ?></td>
              </tr>
            </table></td>
        <td width="50%" ><?php if($materialDesc!=""){ ?><table width="100%" border="0">
              <tr> 
                <td width="34%" class="normalfnt2bldBLACK">Material</td>
                <td width="66%" class="normalfnt">: <?php echo $materialDesc;?></td>
              </tr>
            </table> <?php } ?></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellpadding="0" cellspacing="0" class="tablez">		
<?php
$SQL = "select * from(SELECT
round(Sum(ST.dblQty),2) AS Qty,
O.strOrderNo,
ST.intMatDetailId,
ST.strColor,
ST.strSize,
MS.strName,
SS.strSubStoresName,
SL.strLocName,
SB.strBinName,
S.intSRNO, 
ST.strUnit, 
MIL.strItemDescription
FROM stocktransactions ST
inner join orders O on O.intStyleId=ST.intStyleId
Inner join matitemlist MIL on ST.intMatDetailId = MIL.intItemSerial
Inner Join substores SS ON SS.strSubID = ST.strSubStores
Inner Join mainstores MS ON MS.strMainID = ST.strMainStoresID
Inner Join storeslocations SL ON SL.strLocID = ST.strLocation
Inner Join storesbins SB ON SB.strBinID = ST.strBin 
Inner Join specification S ON ST.intStyleId = S.intStyleId  
where ST.intStyleId =  '$style'";
	
if($maincatid!="")
	 $SQL.=" and MIL.intMainCatID =  '$maincatid'";
	
if($subcatid!="")
	 $SQL.=" and MIL.intSubCatID =  '$subcatid'";
	
if($material!="")
	 $SQL.=" and ST.intMatDetailId =  '$material'";
	
if($color!="")
	 $SQL.=" and ST.strColor = '$color'";

if($size!="")
	 $SQL.=" and ST.strSize = '$size'";	 
	
$SQL.=" GROUP BY
ST.intStyleId,
ST.strMainStoresID , 
ST.strSubStores , 
ST.strLocation , 
ST.strBin , 
ST.intMatDetailId,
ST.strColor,
ST.strSize 
ORDER BY 
ST.intStyleId,  
ST.strMainStoresID , 
ST.strSubStores , 
ST.strLocation , 
ST.strBin, 
ST.intMatDetailId,
ST.strColor,
ST.strSize   ) as main where Qty>0";
$subresult = $db->RunQuery($SQL);

	$itemTmp="";
	$MainTmp="";
	$SubTmp="";
	$LocationTmp="";
	$BinTmp="";
$rowCount	= mysql_num_rows($subresult);		
while($row = mysql_fetch_array($subresult))
{
			$qty= $row["Qty"]; 
			
			if(($MainTmp!=$row["strName"]) or ($SubTmp!=$row["strSubStoresName"]) or ($LocationTmp!=$row["strLocName"]) or ($BinTmp!=$row["strBinName"])){
		?>
        <tr > 
						<td height="25" class="normalfntBtab">Main Stores</td>
						<td class="normalfntBtab">Sub Stores</td>
						<td class="normalfntBtab">Location</td>
						<td class="normalfntBtab">Bin</td>
						<td class="normalfntBtab">Order No</td>
						<td class="normalfntBtab">SC No</td>
						<td class="normalfntBtab">UOM</td>
						<td class="normalfntBtab">Item Description</td>
						<td class="normalfntBtab">Color</td>
						<td class="normalfntBtab">Size</td>
						<td class="normalfntBtab">Qty</td>
        </tr>
		<?php
		$MainTmp=$row["strName"];
		$SubTmp=$row["strSubStoresName"];
		$LocationTmp=$row["strLocName"];
		$BinTmp=$row["strBinName"];
		}
		?>
		
        <tr> 
          <td class="normalfntTAB"><?php echo  $row["strName"]; ?></td>
          <td class="normalfntTAB"><?php echo  $row["strSubStoresName"]; ?></td>
          <td class="normalfntTAB"><?php echo  $row["strLocName"]; ?></td>
          <td class="normalfntTAB"><?php echo  $row["strBinName"]; ?></td>
          <td class="normalfntTAB"><?php echo  $row["strOrderNo"]; ?></td>
          <td class="normalfntRiteTAB"><?php echo  $row["intSRNO"]; ?></td>
          <td class="normalfntTAB"><?php echo  $row["strUnit"]; ?></td>
          <td class="normalfntTAB"><?php echo  $row["strItemDescription"]; ?></td>
          <td class="normalfntTAB"><?php echo  $row["strColor"]; ?></td>
          <td class="normalfntTAB"><?php echo  $row["strSize"]; ?></td>
          <td class="normalfntRiteTAB"><?php echo  number_format($row["Qty"],2); ?></td>
		  
        </tr>
		<?php
			}
		
		?>
		
		
      </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
<div style="left:314px; top:156px; z-index:30; position:absolute; width: 229px; visibility:hidden; height: 54px; background-color: #FFFF00; layer-background-color: #FFFF00; border: 1px none #000000;" id="progress">
  <table width="213" height="55" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td><input type="image" name="imageField" src="images/loading.gif" /></td>
          </tr>
  </table>
		
</div>
</body>
</html>
<script type="text/javascript">

var rowCount =<?php echo $rowCount?>;
if(rowCount<=0){
	alert("Sorry!\nNo Records found in selected options.")
	window.close();
}
</script>
<?php
function  GetOrderNo($styleId)
{
global $db;
	$sql="select strOrderNo from orders where intStyleId=$styleId";
	$result=$db->RunQuery($sql);
	$row=mysql_fetch_array($result);
	return $row["strOrderNo"];

}
?>
