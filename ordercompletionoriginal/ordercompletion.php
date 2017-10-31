<?php
 session_start();
 include "../authentication.inc";
 include "../Connector.php"; 
$backwardseperator	= "../";
$factory 			= $_POST["cboFactory"];
$buyer 				= $_POST["cboCustomer"];
$styleID 			= $_POST["cboOrderNo"];
$srNo 				= $_POST["cboSR"];
$status	 			= $_POST["cboStatus"];
$styleName          = $_POST["cboStyles"];

if ($factory != "Select One")
{
	//$styleID = "Select One";
	$srNo = "Select One";
}
$userQuery = "";
$xml = simplexml_load_file('../config.xml');

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GaPro - Order Completion</title>
<link href="../css/erpstyle.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="ordercompletion.js"></script>
<script type="text/javascript" src="../javascript/script.js"></script>
<script type="text/javascript" src="../javascript/jquery.js"></script>
</head>

<body>
<form id="frmcomplete" name="frmcomplete" method="post" action="ordercompletion.php">
    <tr>
      <td><?php include '../Header.php'; ?></td>
    </tr>
  <table width="950" border="0" align="center" class="bcgl1">
    <tr>
      <td><table width="100%" border="0">
        <tr>
          <td colspan="2" bgcolor="#316895"><div align="center" class="mainHeading">Order Completion</div></td>
        </tr>
        <tr>
          <td colspan="2"><table width="100%" border="0">
            <tr>
              <td width="50%" height="21"><table width="931" border="0" class="normalfnt">
                <tr>
                  <td width="72" >Buyer</td>
                  <td width="72" ><select name="cboCustomer" class="txtbox" style="width:180px" id="cboCustomer"  onchange="selectStyles(this);">
                    <option value="Select One" selected="selected">Select One</option>
                    <?php
	
	$SQL = "SELECT intBuyerID, strName FROM buyers order by strName;";
	
	$result = $db->RunQuery($SQL);
	
	while($row = mysql_fetch_array($result))
	{
		if ($buyer == $row["intBuyerID"])
		{
			echo "<option selected=\"selected\" value=\"". $row["intBuyerID"] ."\">" . $row["strName"] ."</option>" ;
		}
		else
		{
			echo "<option value=\"". $row["intBuyerID"] ."\">" . $row["strName"] ."</option>" ;
		}
	}
	
	?>
                  </select></td>
                  <td width="72" >Style No </td> <!--resetCompanyBuyer();-->
                  <td width="72" ><select name="cboStyles" class="txtbox" style="width:150px" id="cboStyles" onchange="getStylewiseOrderNo();getStylewiseSCNo();">
                    <option value="Select One" selected="selected">Select One</option>
                    <?php
	
	$SQL = "select distinct orders.strStyle from specification inner join orders on specification.intStyleId = orders.intStyleId AND orders.intStatus <>13 " . $userQuery." order by orders.strStyle";
	

	$result = $db->RunQuery($SQL);
	
	
	while($row = mysql_fetch_array($result))
	{
		if ($styleName==  $row["strStyle"])
		{
			echo "<option selected=\"selected\" value=\"". $row["strStyle"] ."\">" . $row["strStyle"] ."</option>" ;
		}
		else
			echo "<option value=\"". $row["strStyle"] ."\">" . $row["strStyle"] ."</option>" ;
	}
	
	?>
                  </select></td>
                  <td width="72" >Order No</td>
                  <td width="155" ><select name="cboOrderNo" id="cboOrderNo" style="width:150px;" onchange="GetScNo(this);">
                    <option value="Select One" <!--selected="selected"-->Select One</option>
                    <?php
	
	$SQL = "select orders.strOrderNo,specification.intStyleId from specification inner join orders on specification.intStyleId = orders.intStyleId AND orders.intStatus <>13 " . $userQuery." ";
	
	if($styleName != 'Select One' && $styleName != '')
		$SQL .= " and orders.strStyle='$styleName' ";
		
		$SQL .= " order by strOrderNo ";	
	$result = $db->RunQuery($SQL);
	
	
	while($row = mysql_fetch_array($result))
	{
		if ($styleID==  $row["intStyleId"])
		{
			echo "<option selected=\"selected\" value=\"". $row["intStyleId"] ."\">" . $row["strOrderNo"] ."</option>" ;
		}
		else
			echo "<option value=\"". $row["intStyleId"] ."\">" . $row["strOrderNo"] ."</option>" ;
	}
	
	?>
                  </select></td>
                  <td width="70" >SC No</td> <!--resetCompanyBuyer();-->
                  <td width="150" ><select name="cboSR" class="txtbox" style="width:150px" id="cboSR" onchange="GetStyleNo(this);">
                    <option value="Select One" selected="selected">Select One</option>
                    <?php
	
	$SQL = "select specification.intSRNO,specification.intStyleId from specification inner join orders on specification.intStyleId = orders.intStyleId AND orders.intStatus <>13 " . $userQuery ;
	
	if($styleName != 'Select One' && $styleName != '')
		$SQL .= " and orders.strStyle='$styleName' ";
		
		$SQL .= " order by specification.intSRNO desc ";	
	
	$result = $db->RunQuery($SQL);
	
	
	while($row = mysql_fetch_array($result))
	{
		if ($styleID==  $row["intStyleId"])
		{
			echo "<option selected=\"selected\" value=\"". $row["intStyleId"] ."\">" . $row["intSRNO"] ."</option>" ;
		}
		else
			echo "<option value=\"". $row["intStyleId"] ."\">" . $row["intSRNO"] ."</option>" ;
	}
	
	?>
                  </select></td>
                  </tr>
                <tr>
                  <td >Category</td>
                  <td><select name="cboStatus" class="txtbox" id="cboStatus" style="width:170px">
                    <option <?php if ($status =="") {  ?> selected="selected" <?php } ?> value="">All</option>
                    <option  <?php if ($status =="0") {  ?> selected="selected" <?php } ?>  value="0">Pending PreOrder</option>
                    <option  <?php if ($status =="1") {  ?> selected="selected" <?php } ?>  value="1">Send to approval</option>
                    <option  <?php if ($status =="11") {  ?> selected="selected" <?php } ?>  value="11">Confirmed</option>
                  </select></td>
                  <td><!--Factory--> &nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td><div align="right"><img src="../images/search.png" alt="Search" width="80" height="24" class="mouseover" onclick="submitForm();" /></div></td>
                  </tr>
              </table></td>
              </tr>
          </table></td>
          </tr>
        <tr>
          <td colspan="2"><div id="divData" style="width:950px; height:450px; overflow: scroll; border-width:3px; border-style:solid;border-color:#FAD163;">
            <table width="937" border="0" cellpadding="0" cellspacing="1"  id="tblCompleteOrders" bgcolor="#ccccff">
              <tr class="mainHeading4">
                <td width="2%" height="22" style="display:none" >
                  <input name="chkSelectAll" id="chkSelectAll" type="checkbox" value="checkbox" onchange="SelectAll(this)"/>
                </td>
                <td width="16%" height="22" >Main Category </td>
                <td width="16%" >Sub Category</td>
                <td width="22%" >Description</td>
                <td width="20%" >Color</td>
				<td width="7%" >Size </td>
                <td width="7%" >Unit </td>
                <td width="7%" >Qty</td>
              </tr>
              <?php
			
			
		
			
			/*$sql = "SELECT strStyle,orders.intStyleId,strDescription, companies.strComCode, buyers.strName,intQty,strOrderNo  FROM orders INNER JOIN companies ON orders.intCompanyID = companies.intCompanyID INNER JOIN buyers ON orders.intBuyerID = buyers.intBuyerID inner join specification on specification.intStyleId=orders.intStyleId WHERE orders.intStatus <>13 " . $userQuery ;*/
			
			$sql="SELECT
					Sum(stocktransactions.dblQty) AS QTY,
					matsubcategory.StrCatName,
					matmaincategory.strDescription,
					stocktransactions.strUnit,
					stocktransactions.strSize,
					stocktransactions.strColor,
					matitemlist.strItemDescription
					FROM
					stocktransactions
					Inner Join matitemlist ON matitemlist.intItemSerial = stocktransactions.intMatDetailId
					Inner Join orders ON orders.intStyleId = stocktransactions.intStyleId
					Inner Join matmaincategory ON matitemlist.intMainCatID = matmaincategory.intID
					Inner Join matsubcategory ON matsubcategory.intSubCatNo = matitemlist.intSubCatID
					WHERE orders.intStatus <>13   " . $userQuery."";

			/*if ($factory != "Select One")
			{
				$sql.= " and orders.intCompanyID = $factory";
			}
			if ($buyer != "Select One" )
			{
				$sql.= " and orders.intBuyerID = $buyer";
			}
			if ($styleID != "Select One" )
			{
				$sql.= " and orders.intStyleId = '$styleID'";
			}
			if ($status != "" )
			{
				$sql.= " and orders.intStatus = '$status'";
			
			if($styleID != "Select One")
			{*/
				$sql.= " and orders.intStyleId = '$styleID'";
			//}		
			 $sql.=" GROUP BY
					stocktransactions.strColor,
					stocktransactions.strSize,
					stocktransactions.intMatDetailId,
					stocktransactions.intStyleId
					order by matitemlist.intMainCatID,matitemlist.strItemDescription";
						//echo $sql;
			$result = $db->RunQuery($sql);	
			$pos = 0;
			while($row = mysql_fetch_array($result))
			{
			?>
              <tr class="<?php 
			  if ($pos % 2 == 0)
					echo "bcgcolor-tblrowWhite";//echo "bcgcolor-tblrow";
				else
					echo "bcgcolor-tblrowWhite";
			   ?>">
                <td height="18" class="normalfnt" style="display:none"><input name="checkbox" id="<?php echo  $row["intStyleId"]; ?>" type="checkbox" value="checkbox" /></td>
                <td class="normalfnt" height="18"><?php echo  $row["strDescription"]; ?></td>
                <td class="normalfnt"><?php echo  $row["StrCatName"]; ?></td>
                <td class="normalfnt"><?php echo  $row["strItemDescription"]; ?></td>
                <td class="normalfnt"><?php echo  $row["strColor"]; ?></td>
				<td class="normalfnt"><?php echo  $row["strSize"]; ?></td>
                <td class="normalfntMid"><?php echo  $row["strUnit"]; ?></td>
                <td class="normalfntRite"><?php echo  round($row["QTY"],2); ?></td>
              </tr>
              <?php
			  $pos ++;
			}
			?>
            </table>
          </div></td>
        </tr>
      </table></td>
    </tr>
    <tr>
      <td><?php echo $userQuery;?></td>
    </tr>
    <tr>
      <td class="normalfntMid" ><table width="100%" border="0" align="center" class="tableFooter">
        <tr>
          <td align="center"><img src="../images/conform.png" onclick="startCompletionProcess();" alt="Confirm" width="115" height="24" class="mouseover" id="butConfirm" /><a href="../main.php"><img src="../images/close.png" width="97" height="24" border="0" /></a></td>
        </tr>
      </table></td>
    </tr>
  </table>
</form>
</body>
</html>
