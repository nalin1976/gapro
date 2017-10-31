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
<script src="../../javascript/jquery.js"></script>
<script src="../../javascript/jquery-ui.js"></script>

</head>

<body>
<form id="frmcomplete" name="frmcomplete" method="post" action="itemdeletionandsearch.php">
    <tr >
      <td><?php include '../../../Header.php'; ?></td>
    </tr>
  <table width="950" border="0" align="center" bgcolor="#FFFFFF">

    <tr>
      <td><table width="100%" border="0" class="tableBorder1">        
        <tr>
			<td width="486"  align="center" height="24" bgcolor="" class="TitleN2white"><table width="100%" border="0">
          <tr>
            <td width="94%" align="center" class="mainHeading"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="13%" valign="middle" class="normaltxtmidb2">&nbsp;</td>
                  <td width="72%" class="mainHeading">Item Search, Edit &amp; Delete </td>
                  <td width="15%" class="seversion"> (Ver 0.3) </td>
                </tr>
              </table></td>            
          </tr>
      </table></td>
          </tr>
        <tr>
          <td><table width="100%" border="0">
            <!--DWLayoutTable-->
            <tr>
              <td width="50%" height="21"><table width="931" border="0">
                <tr>
                  <td width="11" valign="middle" class="normalfntMid">&nbsp;</td>
                  <td width="126" valign="middle" class="normalfnt">Main Category</td>
                  <td colspan="2" class="txtbox"><select name="cboMainCategory" class="txtbox" id="cboMainCategory" style="width:250px" onchange="LoadSubCategory(this.value);">
                    <option value="" selected="selected">Select One</option>
                    <?php 
	$SQL = "SELECT intID,strDescription FROM matmaincategory order by intID;";	
	$result = $db->RunQuery($SQL);		
	while($row = mysql_fetch_array($result))
	{
		if ($mainCatgory == $row["intID"])
		{
			echo "<option selected=\"selected\" value=\"". $row["intID"] ."\">" . $row["strDescription"] ."</option>" ;
		}
		else
		{
			echo "<option value=\"". $row["intID"] ."\">" . $row["strDescription"] ."</option>" ;
		}
	}
	
	?>
                  </select> </td>
                  
						<td width="183" colspan="4" rowspan="3" align="center" valign="middle" class="txtbox"><div align="center"><img id="butSearch" src="../../../images/search.png" alt="Search" width="80" height="24" class="mouseover" onclick="submitForm();" /></div></td>
                  </tr>
                <tr>
                  <td valign="middle" class="normalfntMid">&nbsp;</td>
                  <td valign="middle" class="normalfnt">Sub Category</td>
                  <td colspan="2" class="txtbox"><select name="cboSubCategory" class="txtbox" id="cboSubCategory" style="width:250px" >
                    <option value="" selected="selected">Select One</option>
                    <?php
	$sql="select intSubCatNo,StrCatName from matsubcategory where intCatNo=$mainCatgory order by StrCatName";	
	$result = $db->RunQuery($sql);		
	while($row = mysql_fetch_array($result))
	{
		if ($subCategory  == $row["intSubCatNo"])
		{
			echo "<option selected=\"selected\" value=\"". $row["intSubCatNo"] ."\">" . $row["StrCatName"] ."</option>" ;
		}
		else
		{
			echo "<option value=\"". $row["intSubCatNo"] ."\">" . $row["StrCatName"] ."</option>" ;
		}
	}
	
	?>
                  </select></td>
                  </tr>
                <tr>
                  <td class="normalfntMid">&nbsp;</td>
                  <td class="normalfnt">Description Like</td>
                  <td colspan="2" class="txtbox"><input type="text" id="txtDescription" name="txtDescription"class="txtbox" style="width:250px;" value="<?php echo ($description=="" ? "":$description) ?>" /></td>
                  </tr>

              </table></td>
              </tr>
          </table></td>
          </tr>
        <tr>
          <td>
          <div id="divData" style="width:930px; height:400px; overflow: scroll; ">
            <table width="910" bgcolor="#804000" border="0" cellpadding="0" cellspacing="1" class="tableBorder" id="tblPreOders" >
              <tr>
                <td width="9%" class="mainHeading2">Item Code </td>
                <td width="63%" height="19" class="mainHeading2">Item Description</td>
				<td width="5%" height="19" class="mainHeading2">UOM</td>
				<td width="5%" height="19" class="mainHeading2">Price</td>
				<td width="4%" height="19" class="mainHeading2">Edit</td>
                <td width="6%" class="mainHeading2">Delete</td>
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
	
	
	$sql="select intItemSerial,strItemDescription,intStatus,strUnit,intSubCatID,dblLastPrice from matitemlist  ".
		"where intMainCatID <>0";
		
	if($mainCatgory !=""){
		$sql .= " and intMainCatID='$mainCatgory'";
		}
			
	if($subCategory !=""){
		$sql .= " and intSubCatID='$subCategory'";
		}
	
	if($description !=""){
		$sql .= " and strItemDescription like'%$description%'";
		
		$sql .= " Order By strItemDescription";
		}

	$result = $db->RunQuery($sql);
	//echo $sql;
	$rowCount	= mysql_num_rows($result);
	$pos = 0;
	while($row = mysql_fetch_array($result))
	{
		$status		= $row["intStatus"];
		$itemSerial	= $row["intItemSerial"];
		
		//for checking in order details table.
		$sql2 = "SELECT intMatDetailID FROM orderdetails where intMatDetailID='$itemSerial'";
		$orderCount = $db->QueryCount($sql2);
		
			
		
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
				
		<?php 
		if($orderCount>0)
		{
		?>
			<td class="normalfntMid">&nbsp;</td>
			<!--for delete button-->
			<?php if($status!=1){?>
                <td class="normalfntMid"><img src="../../../images/accept.png"  class="mouseover" onclick="ValidateActive(this);"/></td>
				<?php }
				else{
			?>
				 <td width="2%" class="normalfntMid"><img src="../../../images/deletered.png"  class="mouseover" onclick="ValidateDelete(this);"/></td>			
			<?php }?>
			<!--end of delete criteria-->
		<?php 
		}
		else
		{
		?>
			<td width="2%" class="normalfntMid"><img src="../../../images/edit.png"  class="mouseover" onclick="ShowNameCreationWindow(<?php echo $row["intItemSerial"]?>);"/></td>
			<!--for delete button-->
			<?php if($status==1){?>
                <td width="2%" class="normalfntMid"><img src="../../../images/deletered.png"  class="mouseover" onclick="ValidateDelete(this);"/></td>
				<?php }
				else{
				?>
				<td width="2%" class="normalfntMid"><img src="../../../images/accept.png"  class="mouseover" onclick="ValidateActive(this);"/></td>
				<?php }?>
			<!--end of delete criteria-->
		<?php
		}
		?>
			
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
