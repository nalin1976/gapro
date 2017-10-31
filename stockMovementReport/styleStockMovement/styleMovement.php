<?php 
	session_start();
 $backwardseperator = "../../"; 
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Stock Movement</title>
<script src="../../javascript/script.js" type="text/javascript"></script>
<script src="styleMovement.js" type="text/javascript"></script>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />

</head>
<?php 
include "../../Connector.php";
?>
<body>
<form id="frmStockMvItem" name="frmStockMvItem" >
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><?php include '../../Header.php'; ?></td>
  </tr>
  <tr>
    <td><table cellpadding="0" cellspacing="0" align="center">
    	<tr><td height="10"></td></tr>
        <tr><td>
    	<table cellpadding="2" cellspacing="0" align="center" class="bcgl1"><tr><td>
    <table width="500" border="0" cellspacing="0" cellpadding="0" align="center">
      <tr>
        <td class="mainHeading"> Stock Movement</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>
        <table width="500" border="0" cellspacing="0" cellpadding="2" class="normalfnt">
        <tr>
            <td>Style No</td>
            <td><select name="cboStyle" id="cboStyle" style="width:180px;" onChange="loadStylewiseOrderList();">
            <?php 
			$SQL_style = "SELECT distinct orders.strStyle FROM orders
					Inner Join specification ON orders.intStyleId = specification.intStyleId
					 ORDER BY orders.strStyle ASC ";
	
	
			$result_style = $db->RunQuery($SQL_style);
			echo "<option value=\"". "" ."\">" . "" ."</option>" ;
			while($row = mysql_fetch_array($result_style))
			{
				if ($_POST["cboStyle"] ==  $row["strStyle"])
					echo "<option selected=\"selected\" value=\"". $row["strStyle"] ."\">" . $row["strStyle"] ."</option>" ;
				else
					echo "<option value=\"". $row["strStyle"] ."\">" . $row["strStyle"] ."</option>" ;
			}
			?>
            </select>
            </td>
          </tr>
        <tr>
            <td class="normalfnt">Order No </td>
                      <td><select name="cboOrder" class="txtbox" id="cboOrder" style="width:180px" onChange="GetScNo(this)" >
                        <?php
						$strStyleId = $_POST["cboOrder"];
							
						$SQL = 	"select O.intStyleId,O.strOrderNo from orders O
inner join specification S on O.intStyleId=S.intStyleId Order By strOrderNo";

						$result = $db->RunQuery($SQL);
						echo "<option value=\"". "" ."\">" . "" ."</option>" ;
						while($row = mysql_fetch_array($result))
						{
						if($strStyleId==$row["intStyleId"])
							echo "<option selected=\"selected\" value=\"". $row["intStyleId"] ."\">" . trim($row["strOrderNo"]) ."</option>" ;								
						else
							echo "<option value=\"". $row["intStyleId"] ."\">" . trim($row["strOrderNo"]) ."</option>" ;
						}
							
						?>
                      </select>
                        <select name="cboSc" class="txtbox" id="cboSc" style="width:100px" onChange="GetStyleId(this)" >
                          <?php
						$ScNo = $_POST["cboSc"];
							
						$SQL = 	"select O.intStyleId,intSRNO from orders O
inner join specification S on O.intStyleId=S.intStyleId Order By intSRNO DESC";
						$result = $db->RunQuery($SQL);
						echo "<option value=\"". "" ."\">" . "" ."</option>" ;
						while($row = mysql_fetch_array($result))
						{
						if($ScNo==$row["intStyleId"])
							echo "<option selected=\"selected\" value=\"". $row["intStyleId"] ."\">" . trim($row["intSRNO"]) ."</option>" ;								
						else
							echo "<option value=\"". $row["intStyleId"] ."\">" . trim($row["intSRNO"]) ."</option>" ;
						}
							
						?>
                        </select>          </tr>
          <tr>
            <td width="150">Main Category</td>
            <td width="350"><select name="cboMainCat" id="cboMainCat" style="width:285px;" onChange="getSubcategory();">
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
            </select>            </td>
          </tr>
          
          <tr>
            <td>Sub Category</td>
            <td><select name="cboSubcat" id="cboSubcat" style="width:285px;" onChange="LoadItemDetails();">
             <?php
						$intSubCatNo = $_POST["cboSubcat"];
							
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
            <td>Material Like</td>
            <td><input type="text" name="txtmaterial" id="txtmaterial" style="width:284px;" onKeyPress="EnterSubmitLoadItem(event);"></td>
          </tr>
          <tr>
            <td>Material</td>
            <td><select name="cboMaterial" id="cboMaterial" style="width:285px;">
            <?php
					$intMatItem = $_POST["cboMaterial"];
						
					$SQL = 	"SELECT MIL.intItemSerial, MIL.strItemDescription 
							FROM matitemlist MIL  ";		
					
					$SQL .= " Order By strItemDescription";
					$result = $db->RunQuery($SQL);
					echo "<option value=\"". "" ."\">" . "" ."</option>" ;
					/*while($row = mysql_fetch_array($result))
					{
					if($intMatItem==$row["intItemSerial"])
						echo "<option selected=\"selected\" value=\"". $row["intItemSerial"] ."\">" . trim($row["strItemDescription"]) ."</option>" ;								
					else
						echo "<option value=\"". $row["intItemSerial"] ."\">" . trim($row["strItemDescription"]) ."</option>" ;
					}*/
						
					?>
            </select>            </td>
          </tr>
          
          <tr>
            <td>Color</td>
            <td><select name="cboColor" class="txtbox" id="cboColor" style="width:285px" >
                    <?php
					$strColor = $_POST["cboColor"];
						
					$SQL = 	"SELECT strColor FROM colors";
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
            <td>Size</td>
            <td><select name="cboSize" class="txtbox" id="cboSize" style="width:285px" >
						<?php
						$strSize = $_POST["cboSize"];
							
						$SQL = 	"SELECT strSize FROM sizes";
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
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      
      <tr>
        <td>&nbsp;</td>
      </tr>
     
      <tr>
        <td ><table width="100%" border="0" cellspacing="0" cellpadding="2" bgcolor="#FFE1E1" class="bcgl1">
          <tr>
            <td align="center" >
			<img src="../../images/new.png" width="96" height="24" onClick="clearPage();"><img src="../../images/report.png" width="108" height="24" onClick="viewStockReport();">
           <a href="../../main.php"><img src="../../images/close.png" width="97" height="24" border="0"></a>		   </td>
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
