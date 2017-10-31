<?php
session_start();
$backwardseperator 	= "../";
include('../Connector.php');
$report_companyId=$_SESSION['FactoryID'];
$docNo = $_GET['req'];
$documentNo=$_GET['no'];
$year=$_GET['year'];

//$status=$_GET['status'];
$values	=	$_POST['txtValues'];
$val=explode(',',$values);
$status=$val[0];
$user=$val[1];
$date=$val[2];
$sql="SELECT * from stocktransactions where intDocumentNo=$documentNo and intYear=$year and strType =  'StyleDispose' ";

$res=$db->RunQuery($sql);
(mysql_num_rows($res) >0 )?$status=2:$status=1;


$tbl="";
	($status==1)?$tbl="stocktransactions_temp":$tbl="stocktransactions";
	$sqlS="SELECT
		date($tbl.dtmDate) as dtm,
		useraccounts.Name ,
		useraccounts.intUserID
		FROM
		$tbl
		Inner Join useraccounts ON useraccounts.intUserID = $tbl.intUser
		WHERE
		$tbl.intDocumentNo =  '$documentNo' AND
		$tbl.intDocumentYear =  '$year';";

		$resG=$db->RunQuery($sqlS);
		$rowG=mysql_fetch_array($resG);

if($status == 1)
{?>

<div style="position:absolute;top:100px;left:300px;">
<img src="../images/pending.png">
</div>
<?php
} ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Item Disposal Report</title>
<link href="../css/erpstyle.css" rel="stylesheet" type="text/css" />
<script src="../javascript/script.js" type="text/javascript"></script>
<script src="pending-java.js" type="text/javascript"></script>
<script src="itemDispos.js" type="text/javascript"></script>
<script src="../javascript/jquery.js"></script>
<script src="../javascript/jquery-ui.js"></script>
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
table
{
	border-spacing:0px;

	
}
</style>
</head>
<body>
<form name="frmDispose" id="frmDispose">
<table width="800" border="0" align="center" >
  <tr>
    <td>
	<table border="0" width="100%">
		<tr>
			<td align="center">  <?php include('../reportHeader.php'); ?> </td>
		</tr>
	</table>

<table width="100%" border="0" class="head2BLCK">
      <tr>
        <td width="100%" height="38" class="head2BLCK" >Item Disposal Report</td>
        <!--<td width="18%" class="head2BLCK">&nbsp;</td>-->
      </tr>
    </table>
<br />

<?php 

$sqlE="
SELECT 
mainstores.intCommonBin FROM $tbl inner join mainstores on mainstores.strMainID=$tbl.strMainStoresID
 where $tbl.intDocumentNo='$documentNo' AND  $tbl.intYear='$year'";
$resE=$db->RunQuery($sqlE);
$rowE=mysql_fetch_array($resE);
$store=$rowE['intCommonBin'];


$sql_dets="
SELECT 
$tbl.intStyleId,
$tbl.strBuyerPoNo,
matitemlist.strItemDescription,
$tbl.dblQty,
$tbl.strColor,
$tbl.strSize,
$tbl.dtmDate,
mainstores.strName,
$tbl.intGrnNo,
$tbl.intGrnYear,$tbl.strGRNType,
orders.strOrderNo";

//if($store!=1){
$sql_dets .=",substores.strSubStoresName,
storeslocations.strLocName,
storesbins.strBinName";
//}

$sql_dets .=" FROM $tbl
 left join mainstores on mainstores.strMainID=$tbl.strMainStoresID
 left join matitemlist on matitemlist.intItemSerial=$tbl.intMatDetailId
 Inner Join orders ON orders.intStyleId = $tbl.intStyleId";
 
//if($store!=1){
$sql_dets .=" left join substores on substores.strSubID=$tbl.strSubStores
 left join storeslocations on storeslocations.strLocID=$tbl.strLocation
  left join storesbins on storesbins.strBinID=$tbl.strBin";
//}

$sql_dets .=" where $tbl.intDocumentNo='$documentNo' AND  $tbl.intYear='$year' 
AND
$tbl.strType =  'StyleDispose' 
order by $tbl.intStyleId,
$tbl.strBuyerPoNo,
matitemlist.strItemDescription ASC";

$resD=$db->RunQuery($sql_dets);
$resS=$db->RunQuery($sql_dets);
//echo $sql_dets;
$rowO=mysql_fetch_array($resS);
$available = false;
?>
<table width="1000" border="1" align='center' CELLPADDING=1 CELLSPACING=1 rules="rows" >
    <tr>
	  <td class='bcgl1txt1NB' align="left" width="76">Dispose No. :</td>
	  <td class='bcgl1txt1NB' align="left" width="86"><?php echo $year.'/'.$documentNo;?></td>
      <td class='bcgl1txt1NB' align="left" width="205"></td>
      <td class='bcgl1txt1NB' align="left" width="79"></td>
      <td class='bcgl1txt1NB' align="left" width="101">User :</td>
      <td class='bcgl1txt1NB' align="left" width="98"><?php echo $rowG['Name']; ?></td>
      <td class='bcgl1txt1NB' align="left" width="92"></td>
      <td class='bcgl1txt1NB' align="left" width="70"></td>
      <td class='bcgl1txt1NB' align="left" width="45"></td>
      <td class='bcgl1txt1NB' align="left" width="45">Date. :</td>
      <td class='bcgl1txt1NB' align="left" width="45"><?php echo $rowG['dtm'];?></td>
	</tr>
</table>
<table width="1000" border="1" align='center' CELLPADDING=1 CELLSPACING=1 rules="rows" >
      <tr>
	  <td class='bcgl1txt1NB' align="left" width="76">Order No</td>
	  <td class='bcgl1txt1NB' align="left" width="76">GRN No</td>
	  <td class='bcgl1txt1NB' align="left" width="86">Buyer PO</td>
      <td class='bcgl1txt1NB' align="left" width="205">Material Description</td>
      <td class='bcgl1txt1NB' align="left" width="98">Color</td>
      <td class='bcgl1txt1NB' align="left" width="45">Size</td>
      <td class='bcgl1txt1NB' align="left" width="100">Main Stores</td>
      <td class='bcgl1txt1NB' align="left" width="90">Sub Stores</td>
      <td class='bcgl1txt1NB' align="left" width="92">Location</td>
      <td class='bcgl1txt1NB' align="left" width="40">Bin</td>        
	  <td class='bcgl1txt1NB' align="left" width="65">Dispose Qty</td>
      <td class='bcgl1txt1NB' align="left" width="40">GRN Type</td>  
	  </tr>
      
      <?php while($rowD=mysql_fetch_array($resD))
	  {
	  	($status==2)?$available =false:	$available = true;
		
		$grnType = $rowD["strGRNType"];
		switch($grnType)
		{
			case 'S':
			{
				$strGRNType = 'Style';
				break;
			}
			case 'B':
			{
				$strGRNType = 'Bulk';
				break;
			}
		}
	  ?>
      <tr>
	  <td class='normalfnt' align="left" width="76"><?php echo $rowD['strOrderNo'];?></td>
	  <td class='normalfnt' align="left" width="76"><?php echo $rowD['intGrnYear']."/".$rowD['intGrnNo'];?></td>
	  <td class='normalfnt' align="left" width="86"><?php echo $rowD['strBuyerPoNo'];?></td>
      <td class='normalfnt' align="left" width="205"><?php echo $rowD['strItemDescription'];?></td>
	  <td class='normalfnt' align="left" width="98"><?php echo $rowD['strColor'];?></td>
      <td class='normalfnt' align="left" width="45"><?php echo $rowD['strSize'];?></td>
      <td class='normalfnt' align="left" width="100"><?php echo $rowD['strName'];?></td>
      <td class='normalfnt' align="left" width="90"><?php echo $rowD['strSubStoresName'];?></td>
      <td class='normalfnt' align="left" width="92"><?php echo $rowD['strLocName'];?></td>
      <td class='normalfnt' align="left" width="40"><?php echo $rowD['strBinName'];?></td>    
	  <td class='normalfntRite' align="left" width="65"><?php echo ($rowD['dblQty']*(-1));?>&nbsp;</td>
      <td class='normalfnt' align="left" width="40"><?php echo $strGRNType; ?></td>
	  </tr>
      <?php }?>
	  
	  <?php
	  	if($available){
	  		$status = 1;}
		else{
			$status = 0;
		}
		
		$u="";
		$dt="";
		if($status==1){
			///$u= $_SESSION["UserID"] ;
			$dt=date('Y-m-d');
		}
		else{
			$sqlUId="select intConfirmedBy,dtmCDate from itemdispose where intDocumentNo='$documentNo' and intYear='$year';";
			
			$resU=$db->RunQuery($sqlUId);
			while($r=mysql_fetch_array($resU)){
				$u=$r['intConfirmedBy'];
				$dt=$r['dtmCDate'];
			}
		}
		$SQLU = "select Name from useraccounts where intUserID  =" .$u  ;
		
		?>
</table><table width="1000" border="0"  align="center">
	<tr>
		<td colspan="5">&nbsp; </td>
	</tr>
	<tr>
	<td>&nbsp;</td>
	<td class="normalfnth2Bm" width="100"> Prepared By </td> 
	<td>&nbsp;</td>
	<td class="normalfnth2Bm" width="100">Checked By</td>
	<td>&nbsp;</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td class="normalfntTAB2">
			<?php echo $rowG['Name'];?>		</td>
		<td>&nbsp;</td>
		<td  class="normalfntTAB2">
		<?php 
		$resultU = $db->RunQuery($SQLU);
		while($rowU = mysql_fetch_array($resultU)){
			echo $rowU["Name"];
		}
			?>		
		</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>&nbsp;		</td>
		<td class="normalfnth2Bm">&nbsp;</td>
		<td>&nbsp;</td>
		<td><span class="normalfnth2Bm">Authorized By.</span></td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td class="normalfntMidSML">
		<?php $s="select dtmPDate from itemdispose where intDocumentNo='$documentNo' and intYear='$year';";	
		$r=$db->RunQuery($s);
		
		if(mysql_num_rows($r)>0){
		
		$rw=mysql_fetch_array($r);
		echo substr($rw['dtmPDate'],0,10);
		}
		else {echo $rowG['dtm'];}?>		</td>
		<td>&nbsp;</td>
		<td class="normalfntMidSML">
			<?php echo substr($dt,0,10);?>		</td>
		<td>&nbsp;</td>
	</tr>
	<?php if($status==1){?>

</table>
<table width="1000" border="0" align="center" class="">&nbsp;	
	<tr>
	  <td colspan="10" align="center" id="confrimDiv">
	  
	  
	  <img src="../images/conform.png" onClick="confirmItemDispose('<?php  echo $year; ?>','<?php echo $documentNo;?>');" />
	 
	  
	  </td>
	  </tr>	
</table> <?php }?>
</td>
</tr>
</table>
</form>
</body>
</html>
