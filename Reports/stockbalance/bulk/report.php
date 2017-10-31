<?php
 session_start();
include "../../../Connector.php";
$backwardseperator ="../../../";

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GaPro :: Bulk Stock Balance Report</title>
<link href="../../../css/erpstyle.css" rel="stylesheet" type="text/css" />
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
<?PHP
			$mainId		= $_GET["mainId"];
			$subId		= $_GET["subId"];
			$matItem	= $_GET["maiItem"];
			$color		= $_GET["color"];
			$size		= $_GET["size"];
			$mainStores	= $_GET["mainStores"];
			$with0		= $_GET["with0"];
			
			$SQL = 	"SELECT  mainstores.strName, mainstores.intCompanyId FROM mainstores where strMainID=$mainStores";
			$result = $db->RunQuery($SQL);
			while($row = mysql_fetch_array($result))
			{
				$sStores =  $row["strName"];
				$report_companyId = $row["intCompanyId"];
			}
				
			?>
<table width="800" border="0" align="center" >
  <tr>
    <td><table width="100%" cellpadding="0" cellspacing="0">
      <tr>
        <td width="100%"  ><?php include $backwardseperator.'reportHeader.php'; ?></td>
  
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" class="head2BLCK">
      <tr>
	  <?PHP
			
		?>
        <td width="91%" height="38" class="head1">STOCK BALANCE REPORT ( <span><?php echo $sStores; ?></span> ) </td>
        </tr>
    </table></td>
  </tr>
 
  <tr>
    <td><table width="100%" border="0" cellpadding="0" cellspacing="0" class="tablez">
        <tr> 
          <td width="47%" height="21" class="normalfntBtab">Material</td>
          <td width="18%" class="normalfntBtab">Color</td>
          <td width="16%" class="normalfntBtab">Size</td>
          <td width="19%" class="normalfntBtab">Stock Balance </td>
        </tr>
		<?php
			$SQL = 	"SELECT
					MIL.strItemDescription,
					ST.strColor,
					ST.strSize,
					sum(ST.dblQty) as balanceQty
					FROM
					stocktransactions_bulk ST
					Inner Join matitemlist MIL ON MIL.intItemSerial = ST.intMatDetailId
					where strMainStoresID =$mainStores ";
					
			if($mainId!='')
				$SQL1 .=" and intMainCatID =$mainId ";	
			if($subId!='')
				$SQL1 .=" and intSubCatID =$subId ";
			if($matItem!='')
				$SQL1 .=" and ST.intMatDetailId =$matItem ";	
			if($color!='')
				$SQL1 .=" and strColor ='$color' ";
			if($size!='')
				$SQL1 .=" and strSize ='$size' ";	
							
			$SQL2 = " GROUP BY ST.intMatDetailId,strColor,strSize ORDER BY MIL.strItemDescription,strColor,strSize ASC";
			$SQL = $SQL.$SQL1.$SQL2;

			$result = $db->RunQuery($SQL);
			while($row = mysql_fetch_array($result))
			{
				if($with0=="false")
				{
					if($row["balanceQty"] > 0){
		?>
        <tr> 
          <td height="20" class="normalfntTAB"><?php echo $row["strItemDescription"]; ?></td>
          <td class="normalfntTAB"><?php echo $row["strColor"]; ?></td>
          <td class="normalfntTAB"><?php echo $row["strSize"]; ?></td>
          <td class="normalfntRiteTAB"><?php echo round($row["balanceQty"],4); ?></td>
        </tr>
		<?php		}
				}elseif($with0=="true")
				{
		?>
		<tr> 
          <td height="20" class="normalfntTAB"><?php echo $row["strItemDescription"]; ?></td>
          <td class="normalfntTAB"><?php echo $row["strColor"]; ?></td>
          <td class="normalfntTAB"><?php echo $row["strSize"]; ?></td>
          <td class="normalfntRiteTAB"><?php echo round($row["balanceQty"],4); ?></td>
        </tr>
		<?php
				}
			}
		?>
      </table></td>
  </tr>
  <tr>
    <td class="normalfnt">&nbsp;</td>
  </tr>
</table>

</body>
</html>
