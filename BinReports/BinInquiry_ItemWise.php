<?php
 session_start();
 $backwardseperator = "../";
 $style		= $_POST["cboStyle"];
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GaPro | Bin Inquiry - Item Wise</title>
<style type="text/css">
<!--
body {
	background-color: #FFFFFF;
}
-->
</style>
<link href="../css/erpstyle.css" rel="stylesheet" type="text/css" />
<script src="BinInquiry.js" type="text/javascript"></script>
<script src="../javascript/script.js" type="text/javascript"></script>
</head>

<body>

<?php

include "../Connector.php";

?>

<form id="frmBalance" name="frmBalance" method="POST" action="stockBalance.php">
  <tr>
    <td><?php include '../Header.php'; ?></td>
  </tr>
<table width="950" border="0" align="center" bgcolor="#FFFFFF">
  <tr>
    <td><table width="100%" border="0">
      <tr>
        <td width="19%">&nbsp;</td>
        <td width="62%"><table width="100%" border="0" class="tableBorder">
          <tr>
            <td height="35" class="mainHeading">Bin Inquiry-Item Wise</td>
          </tr>
          <tr>
            <td height="96">
              <table width="100%" border="0" cellpadding="0" cellspacing="0">
                
                
                <tr>
                  <td width="40" colspan="2" class="normalfnt">&nbsp;</td>
                  <td width="72%">&nbsp;</td>
                </tr>
                <tr>
                  <td colspan="3" class="normalfnt"><table width="100%" border="0" >
                    <tr>
                      <td width="5%" class="normalfnt">&nbsp;</td>
                      <td width="23%" class="normalfnt">Order No </td>
                      <td><select name="cboStyle" id="cboStyle" class="txtbox" style="width:285px;" onChange="LoadSC(this);">	
						<?php 
						
						$sql = "SELECT distinct O.intStyleId,O.strOrderNo  FROM orders O order by O.strOrderNo ASC ";	
						$result =$db->RunQuery($sql);		
								echo "<option value =\"".""."\">Select One</option>";
							while ($row=mysql_fetch_array($result))
							{
								if($style==$row["intStyleId"])
									echo "<option selected=\"selected\"value=\"". $row["intStyleId"] ."\">" . $row["strOrderNo"] ."</option>" ;
								else
									echo "<option value=\"".$row["intStyleId"]."\">".$row["strOrderNo"]."</option>";
							}
				
						?>   
				  </select></td>
                    </tr>
                    <tr>
                      <td class="normalfnt">&nbsp;</td>
                      <td class="normalfnt">SC No</td>
                      <td><select name="cboSC" id="cboSC" style="width:285px" class="txtbox" onChange="LoadStyle(this);">
              <?php 
			$SQL = "SELECT distinct S.intStyleId,S.intSRNO FROM specification S order by S.intSRNO DESC";	
			$result =$db->RunQuery($SQL);
		
			echo "<option value =\"".""."\"></option>";
		while ($row=mysql_fetch_array($result))
		{
			if($_POST["cboSC"]==$row["intStyleId"])
				echo "<option selected=\"selected\"value=\"".$row["intStyleId"]."\">".$row["intSRNO"]."</option>";
			else
				echo "<option value=\"".$row["intStyleId"]."\">".$row["intSRNO"]."</option>";
		}
				
	  ?>
					 
            </select></td>
                    </tr>
                    <tr>
                      <td class="normalfnt">&nbsp;</td>
                      <td class="normalfnt">Main Cat</td>
                      <td><select name="cboMainCat" id="cboMainCat" class="txtbox" style="width:285px;" onchange="LoadSubCategory(this);">
                    <?php 
						$maincatid		= $_POST["cboMainCat"];
						$SQL = "SELECT  intID,strDescription FROM matmaincategory order by intID ASC ";	
						$result =$db->RunQuery($SQL);
						
							echo "<option value =\"".""."\"></option>";
							while ($row=mysql_fetch_array($result))
							{
								if($maincatid==$row["intID"])
									echo "<option selected=\"selected\"value=\"". $row["intID"] ."\">" . $row["strDescription"] ."</option>" ;
								else
									echo "<option value=\"".$row["intID"]."\">".$row["strDescription"]."</option>";
								}
						?>
                  </select></td>
                    </tr>
                    <tr>
                      <td class="normalfnt">&nbsp;</td>
                      <td class="normalfnt">Sub Cat</td>
                      <td><select name="cboSubCat" id="cboSubCat" class="txtbox" style="width:285px;" onchange="LoadMaterials(this);">
                      <?php 
						$subcatid			= $_POST["cboSubCat"];	
						
						if($subcatid!=''){
						
							$SQL = "SELECT  intSubCatNo,StrCatName  FROM matsubcategory where matsubcategory.intCatNo ='$maincatid' order by StrCatName ASC ";	
							$result =$db->RunQuery($SQL);
						
							echo "<option value =\"".""."\"></option>";
							while ($row=mysql_fetch_array($result))
							{
								if($subcatid==$row["intSubCatNo"])
									echo "<option selected=\"selected\"value=\"". $row["intSubCatNo"] ."\">" . $row["StrCatName"] ."</option>" ;
								else
									echo "<option value=\"".$row["intSubCatNo"]."\">".$row["StrCatName"]."</option>";
								} 
							}
						?>
                    </select></td>
                    </tr>
<tr>
                      <td class="normalfnt">&nbsp;</td>
                      <td class="normalfnt">Mat Desc</td>
                      <td><select name="cboMatDesc" id="cboMatDesc" class="txtbox" style="width:285px;" onChange="LoadColorSizeGrnPo(this);">
						<?php 
						$material		= $_POST["cboMatDesc"];
						
						if($subcatid!=''){
						
						$SQL = "select matitemlist.intItemSerial, matitemlist.strItemDescription  from stocktransactions join matitemlist on stocktransactions.intMatDetailId=matitemlist.intItemSerial where matitemlist.intMainCatID =  '$maincatid' and matitemlist.intSubCatID =  '$subcatid' and stocktransactions.strStyleNo =  '$style' group by matitemlist.intItemSerial   order by strItemDescription ASC ";	
						$result =$db->RunQuery($SQL);
						
						echo "<option value =\"".""."\"></option>";
						while ($row=mysql_fetch_array($result))
						{
							if($material==$row["intItemSerial"])
								echo "<option selected=\"selected\"value=\"". $row["intItemSerial"] ."\">" . $row["strItemDescription"] ."</option>" ;
							else
								echo "<option value=\"".$row["intItemSerial"]."\">".$row["strItemDescription"]."</option>";
							} 
						}
						
						?>  
						</select></td>
                    </tr>					
<tr>
                      <td class="normalfnt">&nbsp;</td>
                      <td class="normalfnt">Color</td>
                      <td><select name="cboColor" id="cboColor" style="width:285px" class="txtbox" onChange="loadGRNPO(this);">
							<?php					
							$color		= $_POST["cboColor"];
			  
							if($material!=''){
			  
							$SQL = "select stocktransactions.strColor, stocktransactions.strColor  from stocktransactions join matitemlist on stocktransactions.intMatDetailId=matitemlist.intItemSerial where matitemlist.intMainCatID =  '$maincatid' and matitemlist.intSubCatID =  '$subcatid' and stocktransactions.strStyleNo =  '$style' and stocktransactions.intMatDetailId =  '$material' group by stocktransactions.strColor ";	
							$result =$db->RunQuery($SQL);
		
							echo "<option value =\"".""."\"></option>";
							while ($row=mysql_fetch_array($result))
							{
								if($color==$row["strColor"])
									echo "<option selected=\"selected\"value=\"". $row["strColor"] ."\">" . $row["strColor"] ."</option>" ;
								else
									echo "<option value=\"".$row["strColor"]."\">".$row["strColor"]."</option>";
								} 
							}
							?> 
						</select></td>
                    </tr>					
<tr>
                      <td class="normalfnt">&nbsp;</td>
                      <td class="normalfnt">Size</td>
                      <td><select name="cboSize" id="cboSize" style="width:285px" class="txtbox" onChange="loadGRNPO(this);">
							<?php					
							$size		= $_POST["cboSize"];
									  
							if($material!=''){
									  
									$SQL = "select stocktransactions.strSize, stocktransactions.strSize  from stocktransactions join matitemlist on stocktransactions.intMatDetailId=matitemlist.intItemSerial where matitemlist.intMainCatID =  '$maincatid' and matitemlist.intSubCatID =  '$subcatid' and stocktransactions.strStyleNo =  '$style' and stocktransactions.intMatDetailId =  '$material' group by stocktransactions.strSize ";	
									$result =$db->RunQuery($SQL);
								
							echo "<option value =\"".""."\"></option>";
							while ($row=mysql_fetch_array($result))
							{
								if($size==$row["strSize"])
									echo "<option selected=\"selected\"value=\"". $row["strSize"] ."\">" . $row["strSize"] ."</option>" ;
								else
									echo "<option value=\"".$row["strSize"]."\">".$row["strSize"]."</option>";
								} 
							}
							?> 
						</select></td>
                    </tr>                    <tr>
                      <td colspan="2" class="normalfnt">&nbsp;</td>
                      <td>&nbsp;<span id="txtHint" style="color:#FF0000"></span></td>
                    </tr>
                    
                  </table></td>
                  </tr>
              </table>
            </td>
          </tr>
          <tr>
            <td height="34"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="tableBorder">
              <tr>
                <td width="100%" ><table align="center">
				<tr>
					<td>&nbsp;</td>
					<td><img src="../images/new.png" alt="new" onclick="clearFormItem();" /></td>
					<td><img src="../images/report.png" alt="new"  onclick="loadReport();" /></td>
					<td><a href="../main.php"><img src="../images/close.png"  border="0" class="mouseover" /></a></td>
				</tr>
			</table>

</td>
              </tr>
            </table></td>
          </tr>
        </table></td>
        <td width="19%">&nbsp;</td>
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
</form>
</body>
</html>
