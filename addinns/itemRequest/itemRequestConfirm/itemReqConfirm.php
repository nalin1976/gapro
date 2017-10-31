<?php
 session_start();
$backwardseperator = "../../../";
include "${backwardseperator}authentication.inc";
$mainCatgory = $_POST["cboMainCat"];
$subCategory = $_POST["cboSubCat"];
$description	= $_POST["txtMatItem"];
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Item Request Confirm</title>
<link href="../../../css/erpstyle.css" rel="stylesheet" type="text/css"/>
<script src="itemConfirm.js" type="text/javascript" language="javascript"></script>
<script src="../../../javascript/script.js" type="text/javascript" language="javascript"></script>
</head>
<?php
	include "../../../Connector.php";

?>
<body>
<form name="frmItemconfirm" method="post" action="" id="frmItemconfirm">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td><?php include $backwardseperator.'Header.php'; ?></td>
    </tr>
    <tr>
      <td><table width="850" border="0" cellspacing="0" cellpadding="2" align="center" class="tableBorder1">
        <tr>
          <td><table width="850" border="0" cellspacing="0" cellpadding="0" align="center">
            <tr>
              <td height="5"></td>
              <td></td>
              <td></td>
            </tr>
            <tr>
              <td colspan="3" height="26" class="mainHeading">Item Request Confirm</td>
              </tr>
            <tr>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td colspan="3"><table width="700" border="0" cellspacing="0" cellpadding="0"  align="center">
                <tr class="normalfnt">
                  <td width="141" height="20">Main Category</td>
                  <td width="213"><select name="cboMainCat" id="cboMainCat" style="width:200px;" onChange="getSubCat();">
                   <?php 
			 
			  $SQL = 	"SELECT matmaincategory.intID, matmaincategory.strDescription FROM matmaincategory
			            order by matmaincategory.intID ";
						$result = $db->RunQuery($SQL);
						echo "<option value=\"". "" ."\">" . "" ."</option>" ;
						while($row = mysql_fetch_array($result))
						{
							if($mainCatgory==$row["intID"])
								echo "<option selected=\"selected\" value=\"". $row["intID"] ."\">" . trim($row["strDescription"]) ."</option>" ;								
							else
								echo "<option value=\"". $row["intID"] ."\">" . trim($row["strDescription"]) ."</option>" ;
						}
			  ?>
                  </select>                  </td>
                  <td width="124">Sub Category</td>
                  <td width="322"><select name="cboSubCat" id="cboSubCat" style="width:200px;">\
                  <?php 
				  $sql="SELECT MSC.intSubCatNo, MSC.StrCatName FROM matsubcategory MSC WHERE MSC.intCatNo<>''";
	
					if($mainCatgory!="")
						$sql .=" AND MSC.intCatNo = '$mainCatgory'";
						
					$sql .=" order by MSC.StrCatName";
					$result=$db->RunQuery($sql);
					echo "<option value=\"". "" ."\">".""."</option>\n";
					
					while($row=mysql_fetch_array($result))
					{
						if($subCategory == $row["intSubCatNo"])
							echo "<option selected=\"selected\" value=\"". $row["intSubCatNo"] ."\">" . trim($row["StrCatName"]) ."</option>" ;	
						else
								echo "<option value=\"". $row["intSubCatNo"] ."\">".$row["StrCatName"]."</option>\n";	
					}
				  ?>
                  </select>                  </td>
                </tr>
                <tr class="normalfnt">
                  <td height="20">Description Like</td>
                  <td><input type="text" name="txtMatItem" id="txtMatItem" style="width:200px;"></td>
                  <td>&nbsp;</td>
                  <td><img src="../../../images/search.png" width="80" height="24" onClick="submitPage();"></td>
                </tr>
              </table></td>
              </tr>
            <tr>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td colspan="3" align="center"><table cellpadding="1" cellspacing="0" class="bcgl1" width="830px"><tr><td>
              <div id="divItemDet" style="overflow:scroll; width:830px; height:350px;" align="center">
                <table width="820" border="0" cellspacing="1" cellpadding="0" bgcolor="#CCCCFF" id="tblValues">
                  <tr class="mainHeading4">
                    <td width="64" height="25"><input type="checkbox" name="chlAll" id="chlAll" onClick="checkAll();"></td>
                    <td width="535">Item Description</td>
                    <td width="134">UOM</td>
                    <td width="167">Price</td>
                  </tr>
                  <?php 
				  if(isset($_POST["cboCompany"]))
	{
				  	$sql = " SELECT intItemSerial,strItemDescription,strUnit,dblLastPrice
							from matitemlist_temp 
							where intMainCatID<>0 ";
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
	$i=1;
	while($row = mysql_fetch_array($result))
	{
		
		$itemSerial	= $row["intItemSerial"];
			
						
				  ?>
                  <tr bgcolor="#FFFFFF" class="normalfnt">
                    <td align="center" height="20" id="<?php echo $i; ?>"><input type="checkbox" name="chkitem" id="chkitem"></td>
                    <td id="<?php echo $itemSerial; ?>"><?php echo $row["strItemDescription"]; ?></td>
                    <td><?php echo $row["strUnit"]; ?></td>
                    <td><?php echo $row["dblLastPrice"]; ?></td>
                  </tr>
                  <?php 
				  $i++;
				  }
				  }
				  ?>
                </table>
              </div></td></tr></table></td>
              </tr>
            <tr>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td colspan="3" align="center"><table width="900" border="0" cellspacing="0" cellpadding="0" class="bcgl1">
                <tr>
                  <td align="center"><img src="../../../images/conform.png" width="115" height="24" onClick="confirmItem();"></td>
                </tr>
              </table></td>
              </tr>
           
          </table></td>
        </tr>
      </table></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
    </tr>
  </table>
</form>
</body>
</html>
