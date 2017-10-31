<?php
 session_start();
$backwardseperator = "../../../";
include "${backwardseperator}authentication.inc";
$mainCatgory = $_POST["cboMainCategory"];
$subCategory = $_POST["cboSubCategory"];
$description	= $_POST["txtDescription"];
	include "../../../Connector.php";
$xml = simplexml_load_file('../../../config.xml');
$reportname = $xml->PreOrder->ReportName;

//echo print_r($_POST);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Item Search, Edit &amp; Delete</title>
<link href="../../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<script src="itemdeletionandsearch.js" type="text/javascript"></script>
<script src="../../../javascript/autofill.js" type="text/javascript"></script>
<script src="../../../javascript/script.js" type="text/javascript"></script>

</head>

<body>
<form id="frmcomplete" name="frmcomplete" method="post" action="itemdeletionandsearch.php">
    <tr>
      <td><?php include '../../../Header.php'; ?></td>
    </tr>
  <table width="950" border="0" align="center" class="tableBorder" cellpadding="1" cellspacing="0" >

    <tr>
      <td><table width="100%" border="0" cellpadding="0" cellspacing="0">        
        <tr>
			<td height="25" class="mainHeading">Item Search, Edit &amp; Delete</td>
          </tr>
        <tr>
          <td><table width="100%" border="0" cellpadding="2" cellspacing="0">
            <tr>
              <td width="3%" class="normalfnt">&nbsp;</td>
              <td width="15%" class="normalfnt">Main Category</td>
              <td width="73%" class="normalfnt"><select name="cboMainCategory" class="txtbox" id="cboMainCategory" style="width:250px" onchange="LoadSubCategory(this.value);">
                <option value="" selected="selected">Select One</option>
                <?php

	$SQL = "select intID,strDescription from genmatmaincategory where status=1 order by strDescription";
	$result = $db->RunQuery($SQL);
	while($row = mysql_fetch_array($result))
	{
	//	if(isset($_POST["cboMainCategory"]))
	//	{
			if ($_POST["cboMainCategory"] == $row["intID"] )
				echo "<option selected=\"selected\" value=\"". $row["intID"] ."\">" . $row["strDescription"] ."</option>" ;
			else
				echo "<option value=\"". $row["intID"] ."\">" . $row["strDescription"] ."</option>" ;
		//}
	//	else
	//	{
		//	echo "<option value=\"". $row["intID"] ."\">" . $row["strDescription"] ."</option>" ;
	//	}
	}
	
	?>
              </select></td>
              <td width="9%" colspan="4" rowspan="3" align="center" valign="middle" class="normalfnt"><div align="center"><img id="butSearch" src="../../../images/search.png" alt="Search" width="80" height="24" class="mouseover" onclick="submitForm();" /></div></td>
            </tr>
            <tr>
              <td class="normalfnt">&nbsp;</td>
              <td class="normalfnt">Sub Category </td>
              <td class="normalfnt"><select name="cboSubCategory" class="txtbox" id="cboSubCategory" style="width:250px" >
                <option value="" selected="selected">Select One</option>
                <?php
	
	$intCatNo=$_GET["intCatNo"];
	//$intCatNo=1;
	
	$SQL = "SELECT intSubCatNo,StrCatName FROM genmatsubcategory WHERE intStatus = 1 AND intCatNo= ".$_POST["cboMainCategory"]." ORDER BY StrCatName;";
	
	$_SESSION["CatID"]=$_GET["intCatNo"];
	
	$result = $db->RunQuery($SQL);
//	echo "<option value=\"". "" ."\">" . "" ."</option>" ;
	while($row = mysql_fetch_array($result))
	{
		//echo "<option value=\"". "" ."\">" . "" ."Pass</option>" ;
		//if(isset($_SESSION["intCatNo"]))
		//{
			if ($_POST["cboSubCategory"] == $row["intSubCatNo"] )
				echo "<option selected=\"selected\" value=\"". $row["intSubCatNo"] ."\">" . $row["StrCatName"] ."</option>" ;
			else
				echo "<option value=\"". $row["intSubCatNo"] ."\">" . $row["StrCatName"] ."</option>" ;
		//}
	//	else
	//	{
	//		echo "<option value=\"". $row["intSubCatNo"] ."\">" . $row["StrCatName"] ."</option>" ;
	//	}
	}
	
	?>
              </select></td>
              </tr>
            <tr>
              <td class="normalfnt">&nbsp;</td>
              <td class="normalfnt">Description Like</td>
              <td class="normalfnt"><input type="text" id="txtDescription" name="txtDescription"class="txtbox" style="width:400px;" value="<?php echo ($description=="" ? "":$description) ?>" /></td>
              </tr>
          </table></td>
          </tr>
        <tr>
          <td>
          <div id="divData" style="width:950px; height:450px; overflow: scroll; ">
            <table width="100%" bgcolor="#CCCCFF" border="0" cellpadding="2" cellspacing="1" id="tblPreOders" >
              <tr class="mainHeading4">
                <th width="8%" height="25">Item Code </th>
                <th width="70%" >Item Description</th>
				<th width="6%" >UOM</th>
				<th width="5%" >Price<br/>(USD)</th>
				<th width="4%" >Edit</th>
                <th width="5%" >Delete</th>
              </tr>
<?php
	/*$sql = "select intItemSerial,strItemDescription from matitemlist 
	where intItemSerial not in (select intMatDetailID from orderdetails) 
	and intItemSerial not in (select strMatDetailID from specificationdetails)
	and intMainCatID='$mainCatgory'";
if	($subCategory !="")
	$sql .= " and intSubCatID='$subCategory'";
	
	$sql .= " and intStatus=1 Order By strItemDescription";	*/
	if(isset($_POST["cboCompany"]))
	{
	
	
	$sql="select intItemSerial,strItemDescription,intStatus,strUnit,dblLastPrice,intSubCatID from genmatitemlist  ".
		"where intMainCatID <>0";
		
	if($mainCatgory !="")
		$sql .= " and intMainCatID='$mainCatgory'";
			
	if($subCategory !="")
		$sql .= " and intSubCatID='$subCategory'";
	
	if($description !="")
		$sql .= " and strItemDescription like'%$description%'";
		
		$sql .= " Order By strItemDescription";
		//echo $sql;
				
	$result = $db->RunQuery($sql);
	$rowCount	= mysql_num_rows($result);
	$pos = 0;
	while($row = mysql_fetch_array($result))
	{
	$status	= $row["intStatus"];

	if($status==1)
		$name	= "deletered.png";
	elseif($status==0)
		$name	= "accept.png";
?>
              <tr class="<?php 
			  if ($pos % 2 == 0)
					echo "bcgcolor-tblrowWhite";
				else
					echo "bcgcolor-tblrowWhite";
			   ?>">
                <td class="normalfnt" id="<?php echo $row["intItemSerial"]?>"><?php echo $row["intItemSerial"]?></td>
                <td height="21" class="normalfnt" id="<?php echo $row["intItemSerial"]?>"><?php echo  $row["strItemDescription"]; ?></td>
				<td class="normalfnt"><?php echo  $row["strUnit"]; ?></td>
				<td class="normalfnt" style="text-align:right;"><?php echo  $row["dblLastPrice"]; ?></td>
				<td class="normalfntMid"><img src="../../../images/edit.png"  class="mouseover" onclick="ShowNameCreationWindow(<?php echo $row["intItemSerial"]?>,this);"/></td>
				<?php if($status==1){?>
                <td class="normalfntMid"><img src="../../../images/deletered.png"  class="mouseover" onclick="ValidateDelete(this);"/></td>
				<?php }
				else{
				?>
				<td width="2%" class="normalfntMid"><img src="../../../images/accept.png"  class="mouseover" onclick="ValidateActive(this);"/></td>
				<?php }?>
				</tr>
<?php
	$pos ++;
	
	}
	}
?>
            </table>
          </div></td>
        </tr>
      </table></td>
    </tr>

  </table>
</form>
<script type="text/javascript">
var rowCount = <?php echo $rowCount?>;
if (rowCount <= 0)
	alert("Sorry!\nNo records found in selected options.");
</script>
</body>
</html>
