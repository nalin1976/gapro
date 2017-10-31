<?php
session_start();
$backwardseperator = "../";
include "../Connector.php";
$companyId	= $_SESSION["FactoryID"];
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Bin Inquiry - Bin Wise</title>
<style type="text/css">
<!--
body {
	background-color: #FFFFFF;
}
-->
</style>

<script src="untitled/button.js"></script>
<link href="../css/erpstyle.css" rel="stylesheet" type="text/css" />
<script src="BinInquiry.js" type="text/javascript"></script>
<script src="../javascript/script.js" type="text/javascript"></script>
<script type="text/javascript">	
function viewReport()
{
	if(document.getElementById("cboMainStores").value=='')
	{
		alert('Pls select the stores.');
		return;
	}
	
	var url = 	'';//document.getElementById("tagA").name;
	if(document.getElementById('rdoStyleWise').checked)
		url = 'stylewisereport.php';
	else
		url = 'report.php';
	
	if(document.getElementById("cboMainStores").value!='')
		url	+=	'?mainStores='+document.getElementById("cboMainStores").value;
		
	if(document.getElementById("cboMainCat").value!='')
		url	+=	'&mainId='+document.getElementById("cboMainCat").value;
	
	if(document.getElementById("cboSubCat").value!='')
		url	+=	'&subId='+document.getElementById("cboSubCat").value;
	
	if(document.getElementById("cboMatItem").value!='')
		url	+=	'&maiItem='+document.getElementById("cboMatItem").value;
	
	if(document.getElementById("cboColor").value!='')
		url	+=	'&color='+document.getElementById("cboColor").value;
	
	if(document.getElementById("cboSize").value!='')
		url	+=	'&size='+document.getElementById("cboSize").value;
		
	if(document.getElementById("cboStyle").value!='')
		url	+=	'&style='+document.getElementById("cboStyle").value;
		
	url	+=	'&with0='+document.getElementById("rdoWith").checked;
	
	var x = '';
	if(document.getElementById("rdoAll").checked)
		x = 'all';
	else if(document.getElementById("rdoRunning").checked)
		x = 'running';
	else
		x = 'leftOvers';
		
	url	+=	'&x='+x;	
	
	
	window.open( url,'Stock Report');
	//alert(document.getElementById("tagA").href);
}
function GetStyleId(obj)
{
	document.getElementById('cboStyle').value = obj.value;
}
function GetScNo(obj)
{
	document.getElementById('cboSc').value = obj.value;
}
	</script>
</head>

<body>
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
            <td height="35" class="mainHeading">Bin Inquiry-Bin Wise</td>
          </tr>
          <tr>
            <td height="96">
              <table width="100%" border="0" cellpadding="0" cellspacing="0">
                
                <tr>
                  <td width="20" colspan="2" class="normalfnt">&nbsp;</td>
                  <td width="72%">&nbsp;</td>
                </tr>
                <tr>
                  <td colspan="3" class="normalfnt"><table width="100%" border="0" >
                    <tr>
                      <td width="5%" class="normalfnt">&nbsp;</td>
                      <td width="23%" class="normalfnt">Main Stores</td>
                      <td><select name="cboMainStore" id="cboMainStore" style="width:285px" class="txtbox" onChange="loadSubStores();">
						<?php 
						$mainStore		= $_POST["cboMainStore"];
						
						$SQL = "SELECT  strMainID,strName  FROM mainstores where intStatus=1 and intCompanyId=$companyId order by strName ASC ";	
						$result =$db->RunQuery($SQL);
						
						echo "<option value =\"".""."\"></option>";
						while ($row=mysql_fetch_array($result))
						{
							if($mainStore==$row["strMainID"])
								echo "<option selected=\"selected\"value=\"". $row["strMainID"] ."\">" . $row["strName"] ."</option>" ;
							else
								echo "<option value=\"".$row["strMainID"]."\">".$row["strName"]."</option>";
						}
						
						?>
            			</select></td>
                    </tr>
                    <tr>
                      <td class="normalfnt">&nbsp;</td>
                      <td class="normalfnt">Sub Stores</td>
                      <td><select name="cboSubStore" id="cboSubStore" style="width:285px" class="txtbox" onChange="loadLocations();">
							<?php 
							$subStore		= $_POST["cboSubStore"];
							
							$SQL = "SELECT  strSubID,strSubStoresName  FROM substores where strMainID='$mainStore' order by strSubStoresName ASC ";	
							$result =$db->RunQuery($SQL);
							
							echo "<option value =\"".""."\"></option>";
							while ($row=mysql_fetch_array($result))
							{
								if($subStore==$row["strSubID"])
									echo "<option selected=\"selected\"value=\"". $row["strSubID"] ."\">" . $row["strSubStoresName"] ."</option>" ;
								else
									echo "<option value=\"".$row["strSubID"]."\">".$row["strSubStoresName"]."</option>";
							}
							
							?>
						</select></td>
                    </tr>
                    <tr>
                      <td class="normalfnt">&nbsp;</td>
                      <td class="normalfnt">Location</td>
                      <td><select name="cboLocation" id="cboLocation" style="width:285px" class="txtbox" onChange="loadBins();">
							<?php 
							$location = $_POST["cboLocation"];	
							
							$SQL = "SELECT  strLocID,strLocName  FROM storeslocations where strMainID='$mainStore' and strSubID='$subStore' order by strLocName ASC ";	
							$result =$db->RunQuery($SQL);
							
							echo "<option value =\"".""."\"></option>";
							while ($row=mysql_fetch_array($result))
							{
								if($location==$row["strLocID"])
									echo "<option selected=\"selected\"value=\"". $row["strLocID"] ."\">" . $row["strLocName"] ."</option>" ;
								else
									echo "<option value=\"".$row["strLocID"]."\">".$row["strLocName"]."</option>";
							}
							?>
						</select></td>
                    </tr>
                    <tr>
                      <td class="normalfnt">&nbsp;</td>
                      <td class="normalfnt">Bin</td>
                      <td><select name="cboBin" id="cboBin" style="width:285px" class="txtbox" >
							<?php 
							$bin = $_POST["cboBin"];
							
							$SQL = "SELECT  strBinID,strBinName  FROM storesbins where strMainID='$mainStore' and strSubID='$subStore' and strLocID='$location'  order by strBinName ASC ";	
							$result =$db->RunQuery($SQL);
							
							echo "<option value =\"".""."\"></option>";
							while ($row=mysql_fetch_array($result))
							{
								if($bin==$row["strBinID"])
									echo "<option selected=\"selected\"value=\"". $row["strBinID"] ."\">" . $row["strBinName"] ."</option>" ;
								else
									echo "<option value=\"".$row["strBinID"]."\">".$row["strBinName"]."</option>";
							}
							?>
						</select></td>
                    </tr>
                    <tr>
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
                <td width="100%"  >			<table align="center">
				<tr>
					<td>&nbsp;</td>
					<td><img src="../images/new.png" alt="new"  onclick="clearFormBin();"/></td>
					<td><img src="../images/report.png" alt="new"  onclick="loadReportBinWise();" /></td>
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
