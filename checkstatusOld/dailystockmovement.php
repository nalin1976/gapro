<?php
session_start();
$backwardseperator = "../";
include "../Connector.php";

			$styleID		= $_GET["styleID"];		
			$buyerPoNo		= $_GET["buyerPoNo"];				
			$matDetailID	= $_GET["matItemList"];
			$color			= $_GET["color"];
			$size			= $_GET["size"];
			$mainStores		= $_GET["mainStoreID"];

?>
<?php
$sqldesc="select strItemDescription from matitemlist where intItemSerial= $matDetailID";
$result_desc=$db->RunQuery($sqldesc);
while($row_desc=mysql_fetch_array($result_desc))
{
	$itemDescription 	= $row_desc["strItemDescription"];
}
?>
<link href="../css/erpstyle.css" rel="stylesheet" type="text/css" />
<table width="90%" border="0" bgcolor="#FFFFFF">
            <tr>
            <td width="100%" height="16"  >
			<table width="100%"border="0" cellpadding="0" cellspacing="0">
                <tr class="mainHeading">
                  <td width="96%" height="25">Daily Stock Movement</td>
                  <td width="4%"  class="mouseover">
		         <img src="../images/cross.png" alt="close" width="17" height="17"
				 onClick="CloseOSPopUp('popupLayer1');" />				  </td>
              </tr>
              </table></td>
            </tr>
			<tr>
				<td class="normalfnth2"><?php echo $styleID .' :: '. $buyerPoNo .' :: '. $itemDescription .' :: '. $color .' :: '. $size;?></td>
			</tr>
            <tr>
          <td height="0" class="normalfnt"><table width="100%" border="0" class="bcgl1">
                <tr>
                  <td width="100%"><div align="center">
                    <div id="divcons" style="overflow:scroll; height:275px; width:780px;">
                      <table id="mytable" width="760" cellpadding="0" cellspacing="1" bgcolor="#CCCCFF">
                        <tr class="mainHeading4">
						<th width="20" height="20" >&nbsp;</th>
                          <th width="200" >Type</th>
            <th width="140"  height="15" >Date</th>
                         <th width="100" >Ref No</th>
						 <th width="100" >IN</th>
						 <th width="100" >OUT</th>
						 <th width="100" >Balance</th>
                        </tr>
<?php
$date="";
 $loop=0;
 $totalQty=0;
$sql="SELECT strTypeName,dtmDate AS dtmDate,sum(dblQty)AS Qty,Concat(intDocumentYear,'/',intDocumentNo)AS refNo FROM stocktransactions S 
	left Join stocktype ST ON S.strType = ST.strType 
	WHERE intStyleId='$styleID' AND 
	strBuyerPoNo='$buyerPoNo' AND 
	intMatDetailId='$matDetailID' AND 
	strColor='$color' AND 
	strSize='$size' AND 
	strMainStoresID='$mainStores'
group by strTypeName,dtmDate,intDocumentNo,intDocumentYear
Order By dtmDate,intType;";
$result=$db->RunQuery($sql);
$previousDate = "";
$balance = 0;
$firstRow = true;
$pos = 0;
$rowCount = mysql_num_rows($result);
while($row=mysql_fetch_array($result))
{
$pos ++;
$qty	= $row["Qty"];
$inQty	= 0;
$outQty	= 0;
$outQtyArray[1]	= 0;
	
	if(trim(substr($qty,0,1))=="-")
		$outQtyArray	= explode('-',$qty);
	else
		$inQty			= $qty;
		


//if ($previousDate!=$row["dtmDate"] && !$firstRow )
//{
?>
<!--<tr class="bcgcolor-tblrow">
	<td colspan="6" class="normalfntLeftBlue">Balance as at : <?php echo $previousDate ; ?></td>
	<td class="normalfntRiteBlue"><?php echo $balance;?></td>
</tr>-->
<?php
//}	
?>
<tr class="bcgcolor-tblrowWhite">
	<td class="normalfntMid"><?php echo ++$loop;?></td>
	<td class="normalfnt"><?php echo $row["strTypeName"];?></td>
	<td class="normalfntMid"><?php echo $row["dtmDate"];?></td>
	<td class="normalfntMid"><?php echo $row["refNo"];?></td>
	<td class="normalfntRite"><?php echo round($inQty,2);?></td>
	<td class="normalfntRite"><?php echo round($outQtyArray[1],2)?></td>
	<td class="normalfntRite"><?php echo $A1 = $A1+$qty;?></td>
</tr>
<?PHP
	
$balance += $qty;
//$previousDate=$row["dtmDate"];
//$firstRow = false;
//
//if ($rowCount == $pos)
//{
?>
<!--<tr class="bcgcolor-tblrow">
	<td colspan="6" class="normalfntLeftBlue">Balance as at : <?php echo $previousDate ; ?></td>
	<td class="normalfntRiteBlue"><?php echo $balance;?></td>
</tr>-->
<?php
//}
}
?>
                      </table>
                    </div>
                  </div></td>
            </tr>
              </table></td>
  </tr>
            <tr>
              <td height="21" ><table width="100%" border="0">
                <tr>
                  <td width="31%" class="normalfnBLD1">Total Stock</td>
            <td width="23%" class="txtboxgray"><label id="txtStock">
            <div align="center"><?php echo round($balance,2);?></div>
            </label></td>
     <td width="46%" class="mouseover" ><div align="right"><img src="../images/close.png" alt="close"
	 onClick="CloseOSPopUp('popupLayer1');" width="97" height="24"/></div>	 </td>
                </tr>
              </table></td>
            </tr>
          </table>
