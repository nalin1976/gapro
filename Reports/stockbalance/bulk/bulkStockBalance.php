<?php
 session_start();
 $backwardseperator = "../../../";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Bulk Stock Balance</title>

<script src="../../../javascript/script.js" type="text/javascript" ></script>
<script src="bulkStock.js" type="text/javascript"></script>
<link href="../../../css/erpstyle.css" rel="stylesheet" type="text/css" />

<script type="text/javascript">
		function viewReport()
		{
			if(document.getElementById("cboMainStores").value=='')
			{
				alert("Please select the 'Stores'.");
				$('#cboMainStores').focus();
				return;
			}
			
			var url = 'report.php';
						
			if(document.getElementById("cboMainStores").value!='')
				url	+=	'?mainStores='+$('#cboMainStores').val();
				
			if(document.getElementById("cboMainCat").value!='')
				url	+=	'&mainId='+$('#cboMainCat').val();
			
			if(document.getElementById("cboSubCat").value!='')
				url	+=	'&subId='+$('#cboSubCat').val();
			
			if(document.getElementById("cboMatItem").value!='')
				url	+=	'&maiItem='+$('#cboMatItem').val();
			
			if(document.getElementById("cboColor").value!='')
				url	+=	'&color='+URLEncode($('#cboColor').val());
			
			if(document.getElementById("cboSize").value!='')
				url	+=	'&size='+URLEncode($('#cboSize').val());
				
						
			url	+=	'&with0='+document.getElementById("rdoWith").checked;
			
			window.open(url,'frmBalance'); 	
			
			
			//document.getElementById("tagA").href = url;
			//alert(document.getElementById("tagA").href);
		}
		
	</script>
</head>

<body>

<?php

include "../../../Connector.php";

?>

<!--<form id="frmBalance" name="frmBalance" >-->
  <tr>
    <td><?php include '../../../Header.php'; ?></td>
  </tr>
<table width="950" border="0" align="center" bgcolor="#FFFFFF">
  <tr>
    <td><table width="100%" border="0">
      <tr>
        <td width="19%">&nbsp;</td>
        <td width="62%"><table width="100%" border="0" class="bcgl1">
          <tr>
            <td height="35" class="mainHeading">Bulk Stock Balance </td>
          </tr>
          <tr>
            <td height="96">
              <table width="100%" border="0" cellpadding="0" cellspacing="0">
                
                <tr>
                  <td width="92%" colspan="2" class="normalfnt"><table width="100%" border="0" class="bcgl1">
                    <tr>
                      <td width="5%" class="normalfnt">&nbsp;</td>
                      <td width="23%" class="normalfnt">Main Category </td>
                      <td><select name="cboMainCat" class="txtbox" id="cboMainCat" style="width:285px" onchange="getSubCategory();">
                        <?php
						$intMainCat = $_POST["cboMainCat"];
							
						$SQL = 	"SELECT matmaincategory.intID, matmaincategory.strDescription FROM matmaincategory ";
						$result = $db->RunQuery($SQL);
						echo "<option value=\"". "" ."\">" . "" ."</option>" ;
						while($row = mysql_fetch_array($result))
						{
							if($intMainCat==$row["intID"])
								echo "<option selected=\"selected\" value=\"". $row["intID"] ."\">" . trim($row["strDescription"]) ."</option>" ;								
							else
								echo "<option value=\"". $row["intID"] ."\">" . trim($row["strDescription"]) ."</option>" ;
						}
						
						?>
                      </select></td>
                    </tr>
                    <tr>
                      <td class="normalfnt">&nbsp;</td>
                      <td class="normalfnt">Sub Category </td>
                      <td><select name="cboSubCat" class="txtbox" id="cboSubCat" style="width:285px" onchange="getMatIemList();">
                        <?php
						$intSubCatNo = $_POST["cboSubCat"];
							
						$SQL = 	"SELECT MSC.intSubCatNo, MSC.StrCatName FROM matsubcategory  MSC
								WHERE MSC.intCatNo <>'' ";
								
						if($intMainCat!='')
							$SQL .= " AND MSC.intCatNo =  '$intMainCat'";
							
						$SQL .= " order by MSC.StrCatName ";
						
						$result = $db->RunQuery($SQL);
						echo "<option value=\"". "" ."\">" . "" ."</option>" ;
						while($row = mysql_fetch_array($result))
						{
						if($intSubCatNo==$row["intSubCatNo"])
							echo "<option selected=\"selected\" value=\"". $row["intSubCatNo"] ."\">" . trim($row["StrCatName"]) ."</option>" ;								
						else
							echo "<option value=\"". $row["intSubCatNo"] ."\">" . trim($row["StrCatName"]) ."</option>" ;
						}
						
						?>
                      </select></td>
                    </tr>
                    <tr>
                      <td class="normalfnt">&nbsp;</td>
                      <td class="normalfnt">Material Like</td>
                      <td><input type="text" name="txtMatItem" id="txtMatItem" style="width:284px;" onkeyup="EnterSubmitLoadItem(event);" /></td>
                    </tr>
                    <tr>
                      <td class="normalfnt">&nbsp;</td>
                      <td class="normalfnt">Material</td>
                      <td><select name="cboMatItem" class="txtbox" id="cboMatItem" style="width:285px">
                    <?php
					$intMatItem = $_POST["cboMatItem"];
						
					$SQL = 	"SELECT MIL.intItemSerial, MIL.strItemDescription 
							FROM matitemlist MIL WHERE MIL.intMainCatID =  '$intMainCat' AND MIL.intSubCatID =  '$intSubCatNo ";		
					
					$SQL .= " Order By strItemDescription";
					$result = $db->RunQuery($SQL);
					echo "<option value=\"". "" ."\">" . "" ."</option>" ;
					while($row = mysql_fetch_array($result))
					{
					if($intMatItem==$row["intItemSerial"])
						echo "<option selected=\"selected\" value=\"". $row["intItemSerial"] ."\">" . trim($row["strItemDescription"]) ."</option>" ;								
					else
						echo "<option value=\"". $row["intItemSerial"] ."\">" . trim($row["strItemDescription"]) ."</option>" ;
					}
						
					?>
                      </select></td>
                    </tr>
                    <tr>
                      <td class="normalfnt">&nbsp;</td>
                      <td class="normalfnt">Color</td>
                      <td><select name="cboColor" class="txtbox" id="cboColor" style="width:285px" >
                    <?php
					$strColor = $_POST["cboColor"];
						
					//$SQL = 	"SELECT strColor FROM colors";
					$SQL = "select distinct strColor from stocktransactions_bulk ";
					$result = $db->RunQuery($SQL);
					echo "<option value=\"". "" ."\">" . "" ."</option>" ;
					while($row = mysql_fetch_array($result))
					{
					if($strColor==$row["strColor"])
						echo "<option selected=\"selected\" value=\"". $row["strColor"] ."\">" . trim($row["strColor"]) ."</option>" ;								
					else
						echo "<option value=\"". $row["strColor"] ."\">" . trim($row["strColor"]) ."</option>" ;
					}
						
					?>
                      </select></td>
                    </tr>
                    <tr>
                      <td class="normalfnt">&nbsp;</td>
                      <td class="normalfnt">Size</td>
                      <td><select name="cboSize" class="txtbox" id="cboSize" style="width:285px" >
						<?php
						$strSize = $_POST["cboSize"];
							
						//$SQL = 	"SELECT strSize FROM sizes";
						$SQL = "select distinct strSize from stocktransactions_bulk ";
						$result = $db->RunQuery($SQL);
						echo "<option value=\"". "" ."\">" . "" ."</option>" ;
						while($row = mysql_fetch_array($result))
						{
						if($strSize==$row["strSize"])
							echo "<option selected=\"selected\" value=\"". $row["strSize"] ."\">" . trim($row["strSize"]) ."</option>" ;								
						else
							echo "<option value=\"". $row["strSize"] ."\">" . trim($row["strSize"]) ."</option>" ;
						}
							
						?>
						  </select></td>
                      </tr>
                    <tr>
                      <td class="normalfnt">&nbsp;</td>
                      <td class="normalfnt">Stores</td>
                      <td><select name="cboMainStores" class="txtbox" id="cboMainStores" style="width:285px">
						<?php
						$intMainStores = $_POST["cboMainStores"];
							
						$SQL = 	"SELECT mainstores.strMainID, mainstores.strName FROM mainstores";
						$result = $db->RunQuery($SQL);
						echo "<option value=\"". "" ."\">" . "" ."</option>" ;
						while($row = mysql_fetch_array($result))
						{
						if($intMainStores==$row["strMainID"])
							echo "<option selected=\"selected\" value=\"". $row["strMainID"] ."\">" . trim($row["strName"]) ."</option>" ;								
						else
							echo "<option value=\"". $row["strMainID"] ."\">" . trim($row["strName"]) ."</option>" ;
						}
							
						?>
						  </select></td>
                    </tr>
                    <tr>
                      <td colspan="2" class="normalfnt">&nbsp;</td>
                      <td>&nbsp;<span id="txtHint" style="color:#FF0000"></span></td>
                    </tr>
                    <tr>
                      <td colspan="3" class="normalfnt"><table width="100%" border="0" cellspacing="1" cellpadding="0">
                        <tr>
                          <td width="21%">&nbsp;</td>
						 
                          <td width="5%"><input name="rdoB" type="radio" id="rdoWith" value="with" <?php 
						  	if($x=='with')
								echo 'checked="checked"';
						   ?> /></td>
                          <td width="20%">With <strong>0</strong> Balance </td>
                          <td width="6%"><input <?php 
						  	if($x!='with')
								echo 'checked="checked"';
						   ?> name="rdoB" type="radio" value="without" id="rdoWithout" /></td>
                          <td width="34%">Without <strong>0</strong> Balance </td>
                          <td width="14%">&nbsp;</td>
                        </tr>
                      </table></td>
                      </tr>
                    <tr>
                      <td colspan="2" class="normalfnt">&nbsp;</td>
                      <td>&nbsp;</td>
                    </tr>
                  </table></td>
                  </tr>
              </table>
            </td>
          </tr>
          <tr>
            <td height="34"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="bcgl1">
              <tr>
                <td width="100%" bgcolor="#FFE1E1"><table width="100%" border="0">
                    <tr>
                      <td width="25%">&nbsp;</td>                     
                      <td width="25%" ><img src="../../../images/new.png" alt="new" onclick="ClearForm();"/></td>
                      <td width="25%"><img src="../../../images/report.png" alt="Report" name="Delete"  border="0" class="mouseover" onclick="viewReport();" /></td>
                      <td width="25%"><a href="../../../main.php"><img src="../../../images/close.png" alt="Close" name="Close" width="97" height="24" border="0"/></a></td>
                      <td width="25%">&nbsp;</td>
                    </tr>
                </table></td>
              </tr>
            </table></td>
          </tr>
        </table></td>
        <td width="19%"></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>

  
  
  
  
</table>
<script type="text/javascript">
function ClearForm(){	
	//setTimeout("location.reload(true);",0);
	document.frmBalance.reset();
}
</script>
<!--</form>-->
</body>
</html>
