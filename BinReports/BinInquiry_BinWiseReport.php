<?php
session_start();
$backwardseperator = "../";
include "../authentication.inc";
include "../Connector.php";

$report_companyId  	= $_SESSION["FactoryID"];	
$xml 				= simplexml_load_file('config.xml');
$ReportISORequired 	= $xml->companySettings->ReportISORequired;
$report_companyId	= $_SESSION['UserID'];
$mainStore			= $_GET["mainStore"];
$subStore			= $_GET["subStore"];
$location			= $_GET["location"];	
$bin				= $_GET["bin"];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Bin Wise Bin Report</title>
<link href="../css/erpstyle.css" rel="stylesheet" type="text/css" />
</head>
<body>
<table width="800" border="0" align="center">
  <tr>
    <td><table width="100%" cellpadding="0" cellspacing="0">
      
      <tr>
        <td><?php include "../reportHeader.php";?></td>
      </tr>
      <tr>
        <td><?php 

		
 $SQL = "select
	mainstores.strName
	 from mainstores
	 where mainstores.strMainID =  '$mainStore'";	
	$result_matre = $db->RunQuery($SQL);
	$row = mysql_fetch_array($result_matre);
	$MainStoreDesc=$row["strName"];
	
$SQL = "select
	substores.strSubStoresName
	 from substores
	 where substores.strSubID =  '$subStore'";	
	$result_matre = $db->RunQuery($SQL);
	$row = mysql_fetch_array($result_matre);
	$SubStoreDesc=$row["strSubStoresName"];
	
$SQL = "select
	storeslocations.strLocName
	 from storeslocations
	 where storeslocations.strLocID =  '$location'";	
	$result_matre = $db->RunQuery($SQL);
	$row = mysql_fetch_array($result_matre);
	$LocationDesc=$row["strLocName"];
		
?>
            
        </td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" class="head2BLCK">
      <tr>
      	<td width="16%"></td>
        <td width="67%" class="head2BLCK">BIN INQUIRY REPORT-BIN WISE</td>
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
                <td width="41%" class="normalfnt2bldBLACK">Main Store </td>
                <td width="59%" class="normalfnt">: <?php echo $MainStoreDesc;?></td>
              </tr>
            </table></td>
        <td width="50%" ><table width="100%" border="0">
              <tr> 
                <td width="34%" class="normalfnt2bldBLACK">Sub Store </td>
                <td width="66%" class="normalfnt">: <?php echo $SubStoreDesc;?></td>
              </tr>
            </table></td>
      </tr>
      <tr>
        <td width="50%" ><table width="100%" border="0">
              <tr> 
                <td width="41%" class="normalfnt2bldBLACK">Location</td>
                <td width="59%" class="normalfnt">: <?php echo $LocationDesc;?></td>
              </tr>
            </table></td>
        <td width="50%" ><table width="100%" border="0">
              <tr> 
                <td width="34%" class="normalfnt2bldBLACK">&nbsp;</td>
                <td width="66%" class="normalfnt">&nbsp;</td>
              </tr>
            </table></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellpadding="0" cellspacing="0" class="tablez">
		
		<?php
		$sum = 0;
		?>
		

<?php
$SQL = "select * from(SELECT round(Sum(ST.dblQty),2) AS Qty, ST.intStyleId,O.strOrderNo, ST.intMatDetailId, ST.strColor, ST.strSize, MS.strName, SS.strSubStoresName, SL.strLocName, SB.strBinName, ST.strUnit, S.intSRNO, MIL.strItemDescription 
	FROM stocktransactions ST
	inner join orders O on O.intStyleId=ST.intStyleId 
	Inner join matitemlist MIL on MIL.intItemSerial = ST.intMatDetailId	
	Inner Join substores SS ON SS.strSubID = ST.strSubStores 
	Inner Join mainstores MS ON MS.strMainID = ST.strMainStoresID 
	Inner Join storeslocations SL ON SL.strLocID = ST.strLocation 
	Inner Join storesbins SB ON SB.strBinID = ST.strBin 
	Inner Join specification S ON ST.intStyleId = S.intStyleId    
	where ST.strMainStoresID =  '$mainStore' 
	and ST.strSubStores = '$subStore' 
	and ST.strLocation = '$location' ";

if($bin!="")
	 $SQL.=" and ST.strBin = '$bin'";
	 
$SQL.=" GROUP BY
	ST.strMainStoresID , 
	ST.strSubStores , 
	ST.strLocation , 
	ST.strBin, 
	ST.intStyleId,
	ST.intMatDetailId,
	ST.strColor,
	ST.strSize"; 

$SQL.=" ORDER BY  
	ST.strMainStoresID , 
	ST.strSubStores , 
	ST.strLocation , 
	ST.strBin, 
	ST.intStyleId,
	ST.intMatDetailId,
	ST.strColor,
	ST.strSize   ) as main where Qty>0";
	//echo $SQL;
$subresult = $db->RunQuery($SQL);
		
$itemTmp		= "";
$MainTmp		= "";
$SubTmp			= "";
$LocationTmp	= "";
$BinTmp			= "";
$rowCount	= mysql_num_rows($subresult);		
	while($row = mysql_fetch_array($subresult))
	{
		$qty	= $row["Qty"]; 
		$sum += $qty;
		
		if(($MainTmp!=$row["strName"]) or ($SubTmp!=$row["strSubStoresName"]) or ($LocationTmp!=$row["strLocName"]) or ($BinTmp!=$row["strBinName"]))
		{
?>
		<tr > 
			<td height="25" class="normalfntBtab">Bin</td>
			<td class="normalfntBtab">Order No</td>
			<td nowrap="nowrap" class="normalfntBtab">SC No</td>
			<td class="normalfntBtab">Item Description</td>
			<td class="normalfntBtab">Color</td>
			<td class="normalfntBtab">Size</td>
			<td class="normalfntBtab">UOM</td>
			<td class="normalfntBtab">Qty</td>
		</tr>
<?php
			$MainTmp		= $row["strName"];
			$SubTmp			= $row["strSubStoresName"];
			$LocationTmp	= $row["strLocName"];
			$BinTmp			= $row["strBinName"];
		}
?>		
		<tr> 
		  <td height="20" class="normalfntTAB">&nbsp;<?php echo  $row["strBinName"]; ?>&nbsp;</td>
		  <td class="normalfntTAB">&nbsp;<?php echo  $row["strOrderNo"]; ?>&nbsp;</td>
		  <td class="normalfntRiteTAB">&nbsp;<?php echo  $row["intSRNO"]; ?>&nbsp;</td>
		  <td class="normalfntTAB">&nbsp;<?php echo  $row["strItemDescription"]; ?>&nbsp;</td>
		  <td class="normalfntTAB">&nbsp;<?php echo  $row["strColor"]; ?>&nbsp;</td>
		  <td class="normalfntTAB">&nbsp;<?php echo  $row["strSize"]; ?>&nbsp;</td>
		  <td class="normalfntTAB">&nbsp;<?php echo  $row["strUnit"]; ?>&nbsp;</td>
		  <td class="normalfntRiteTAB">&nbsp;<?php echo  number_format($row["Qty"],2); ?>&nbsp;</td>
		</tr>
<?php
	}		
?>

<tr> 
		  <td height="20" colspan="7" class="normalfntTAB"> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Total</td>
		  <td class="normalfntRiteTAB"><?php echo number_format($sum,2);?></td>
		</tr>
      </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
<div style="left:314px; top:156px; z-index:30; position:absolute; width: 229px; visibility:hidden; height: 54px; background-color: #FFFF00; layer-background-color: #FFFF00; border: 1px none #000000;" id="progress">
  <table width="213" height="55" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td><input type="image" name="imageField" src="../images/loading.gif" /></td>
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