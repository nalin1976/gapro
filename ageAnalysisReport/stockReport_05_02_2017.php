<?php 
	session_start();
 $backwardseperator = "../";
 include "{$backwardseperator}authentication.inc";
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Stock Report</title>
<script src="../javascript/script.js" type="text/javascript"></script>
<script src="stockBalReport.js" type="text/javascript"></script>
<script src="../js/jquery-1.10.2.js" type="text/javascript"></script>
<script src="../js/jquery-ui-1.10.4.custom.js" type="text/javascript"></script>
<link href="../css/erpstyle.css" rel="stylesheet" type="text/css" />
</head>
<?php 
include "../Connector.php";
?>
<body>
<form id="frmStockRpt" name="frmStockRpt" action="javascript:void(0)" >
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><?php include '../Header.php'; ?></td>
  </tr>
  <tr>
    <td><table cellpadding="0" cellspacing="0" align="center">
    	<tr><td height="10"></td></tr>
        <tr><td>
    	<table cellpadding="0" cellspacing="0" align="center" class="bcgl1"><tr><td>
    <table width="500" border="0" cellspacing="0" cellpadding="0" align="center">
      <tr>
        <td class="mainHeading">Age Analysis Report - Style</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>
        <table width="500" border="0" cellspacing="0" cellpadding="2" class="normalfnt">
          <tr>
            <td width="150" style="padding-left:20px">Main Category</td>
            <td width="350"><select name="cboMainCat" id="cboMainCat" style="width:320px;" onChange="loadSubCatDetails();">
            <?php
						$intMainCat = $_POST["cboMainCat"];
							
						$SQL = 	"SELECT matmaincategory.intID, matmaincategory.strDescription FROM matmaincategory";
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
            </select>            </td>
          </tr>
          <tr>
            <td style="padding-left:20px">Sub Category</td>
            <td><select name="cboSubCat" id="cboSubCat" style="width:320px;">
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
            </select>            </td>
          </tr>
          <tr>
            <td style="padding-left:20px">Material Like</td>
            <td><input type="text" name="txtMatItem" id="txtMatItem" style="width:319px;" onKeyPress="enterLoadItem(event);"></td>
          </tr>
          <tr>
            <td style="padding-left:20px">Material</td>
            <td><select name="cboMaterial" id="cboMaterial" style="width:320px;">
            <?php
					$intMatItem = $_POST["cboMaterial"];
						
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
            </select>            </td>
          </tr>
          <tr>
            <td style="padding-left:20px">Color</td>
            <td><select name="cboColor" id="cboColor" style="width:320px;">
            <?php 
				$strColor = $_POST["cboColor"];
						
					$SQL = 	"SELECT strColor FROM colors order by strColor";
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
            </select>            </td>
          </tr>
          <tr>
            <td style="padding-left:20px">Size</td>
            <td><select name="cboSize" id="cboSize" style="width:320px;">
            <?php
						$strSize = $_POST["cboSize"];
							
						$SQL = 	"SELECT strSize FROM sizes order by strSize";
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
            </select>            </td>
          </tr>
          <tr>
              <td style="padding-left:20px">Customer</td>
              <td>
                  <select name="cboCustomer" id="cboCustomer" style="width:320px;">
                      <?php
                        
                        $strCustomerId = $_POST["cboCustomer"];
                        
                        $SQL = " SELECT buyers.intBuyerID,buyers.strName,buyers.intStatus
                                 FROM buyers WHERE buyers.intStatus = 1 ";
                        
                        $result = $db->RunQuery($SQL);
                        echo "<option value=\"". "" ."\">" . "" ."</option>" ;
                        while($row = mysql_fetch_array($result))
                        {
                        if($strSize==$row["intBuyerID"])
                                echo "<option selected=\"selected\" value=\"". $row["intBuyerID"] ."\">" . trim($row["strName"]) ."</option>" ;								
                        else
                                echo "<option value=\"". $row["intBuyerID"] ."\">" . trim($row["strName"]) ."</option>" ;
                        }
                        
                      ?>
                  </select>
              </td>
          </tr>
          <tr>
            <td style="padding-left:20px">Store</td>
            <td><select name="cboStore" id="cboStore" style="width:320px;" onchange="loadSubStores()">
            <?php
						$intMainStores = $_POST["cboStore"];
							
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
            </select>            </td>
          </tr>
          <tr>
            <td style="padding-left:20px">Sub Store</td>
            <td><select name="cboSubStore" id="cboSubStore" style="width:320px;">
                </select>
            </td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td align="center"><table width="495" border="0" cellspacing="0" cellpadding="0" bgcolor="#FFE1E1" align="center" class="bcgl1">
          <tr>
            <td width="387" align="right" height="26"><img src="../images/report.png" width="108" height="24" onClick="viewAgeAnalysisRpt('N');"></td>
            <td><img class="mouseover" border="0" value ="E" onClick="viewAgeAnalysisRpt('E');" name="Delete" alt="Report" src="../images/download.png"></td>
            <td width="113"><a href="../main.php"><img src="../images/close.png" width="97" height="24" border="0"></a></td>
          </tr>
        </table></td>
      </tr>
      <tr>
      	<td height="5"></td>
      </tr>
    </table></td></tr></table>
    </td></tr></table>
    </td>
  </tr>
</table>
</form>
</body>
</html>
