<?php
//Header("Cache-control: private, no-cache");
//Header("Expires: Mon, 26 Jun 1997 05:00:00 GMT");

session_start();
$backwardseperator = "../";

$styleId = $_POST["cboStyleId"];
$companyID = $_SESSION["FactoryID"];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Bin To Bin Transfer</title>

<!--<link href="../css/erpstyle.css" rel="stylesheet" type="text/css" />
<style type="text/css">



</style>-->
<link href="../css/erpstyle.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="../javascript/calendar/theme.css" />
<script src="../javascript/calendar/calendar.js" type="text/javascript"></script>
<script src="../javascript/calendar/calendar-en.js" type="text/javascript"></script>
<script src="../javascript/script.js" type="text/javascript"></script>
<script src="bin2bin.js" type="text/javascript"></script>
<!--<script src="transfer-java.js" type="text/javascript"></script>-->
<script type="text/javascript">
function changeSc()
{
	var scNo = document.getElementById("cboStyleNo").options[document.getElementById("cboStyleNo").selectedIndex].text;
	document.getElementById("cboScNo").value = scNo;
	RemoveAllRows('tblSource');
	RemoveAllRows('tblDestination');
}
function changeStyle()
{
	var styleNo = document.getElementById("cboScNo").options[document.getElementById("cboScNo").selectedIndex].text;
	document.getElementById("cboStyleNo").value=styleNo;
	RemoveAllRows('tblSource');
	RemoveAllRows('tblDestination');
}
</script>

<style type="text/css">
<!--
.style1 {font-size: 9px}
.style3 {font-family: Verdana}
/*body {
	background-color: #CCCCCC;
}*/
-->
</style>
</head>

<body>
<?php

	include "../Connector.php";	
	$arrStatus  = explode(',',$headerPub_AllowOrderStatus);
?>
<form name="frmBinToBin" id="frmBinToBin" action="binToBinTransfer.php" method="post">
<table width="100%" border="0" align="center">
	<tr><td><?php include '../Header.php'; ?>
     </td>
    </tr>
    <tr><td>
<table width="950" border="0" align="center" bgcolor="#FFFFFF" class="bcgl1">

  <tr>
  	<td height="25" colspan="8"  class="mainHeading">BIN to BIN transfer</td>
  </tr>
  <tr>
    <td colspan="7"><table width="100%" border="0">
      <tr>
	    <tr>
   <td height="6" colspan="8" class="normalfnt2bld"><table width="100%">
       <tr>
         <td width="26%">Source Bin</td>
         <td width="13%"><span class="normalfnt">SC No </span></td>
         <td width="14%"><select name="cboStyleNo" class="txtbox" id="cboStyleNo" style="width:120px" onchange="changeStyleid(this);">
           <?PHP		
					$styleId = $_POST["cboStyleNo"];
					
					//$SQL="SELECT distinct  intSRNO,intStyleId FROM specification  ORDER BY  intSRNO ASC";
					$SQL = "SELECT distinct  S.intSRNO,S.intStyleId
							FROM specification S INNER JOIN orders O ON S.intStyleId = O.intStyleId
							INNER JOIN stocktransactions ST ON ST.intStyleId = O.intStyleId
							WHERE (O.intStatus = $arrStatus[0] or O.intStatus = $arrStatus[1] or O.intStatus = $arrStatus[2])
							GROUP BY S.intSRNO,S.intStyleId
							HAVING SUM(ST.dblQty)>0
							ORDER BY  intSRNO desc";
							
					$result =$db->RunQuery($SQL);
					echo "<option value =\"".""."\">"."Select One"."</option>";
					while ($row=mysql_fetch_array($result))
					{	
						if($styleId==$row["intStyleId"])
							echo "<option selected = \"selected\" value=\"".$row["intStyleId"]."\">".$row["intSRNO"]."</option>";
						else
							echo "<option value=\"".$row["intStyleId"]."\">".$row["intSRNO"]."</option>";
					}
				
				?>
         </select></td>
         <td width="9%" class="normalfnt">Order No </td>
         <td width="14%">
           <select name="cboScNo" class="txtbox" id="cboScNo" style="width:120px" onchange="changeSC(this);" >
             <?PHP		
				
					$scNo = $_POST["cboScNo"];
					//$SQL="SELECT distinct  intSRNO,intStyleId FROM specification ORDER BY  intStyleId ASC ";
					$SQL = "SELECT distinct  O.intStyleId,O.strOrderNo
							FROM  orders O INNER JOIN  stocktransactions S ON O.intStyleId = S.intStyleId
							where (O.intStatus = $arrStatus[0] or O.intStatus = $arrStatus[1] or O.intStatus = $arrStatus[2])
							GROUP BY O.intStyleId,O.strStyle 
							HAVING SUM(S.dblQty)>0
							order by O.strOrderNo";
							
					$result =$db->RunQuery($SQL);
					echo "<option value =\"".""."\">"."Select One"."</option>";
					while ($row=mysql_fetch_array($result))
					{	
						if($scNo==$row["intStyleId"])
							echo "<option selected = \"selected\" value=\"".$row["intStyleId"]."\">".$row["strOrderNo"]."</option>";
						else
							echo "<option value=\"".$row["intStyleId"]."\">".$row["strOrderNo"]."</option>";
					}
				
			?>
           </select>        </td>
         <td width="9%" class="normalfnt"> BuyerPO No </td>
         <td width="15%"><select name="cboBuyerPoNo" class="txtbox" id="cboBuyerPoNo" style="width:120px" >        
         </select></td>
       </tr>
     </table></td>
  </tr>
        <td width="100%"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="bcgl1">
		
          <tr>
            <td width="8%" height="25" class="normalfnt">Main Stores </td>
            <td width="14%" class="normalfnt"><select name="cboMainStores" class="txtbox" id="cboMainStores" style="width:120px" onchange="loadSubStores('sor');" >
				<?PHP		
				
					$mainId= $_POST["cboMainStores"];
					$SQL="SELECT mainstores.strMainID, mainstores.strName FROM `mainstores`
					where intStatus=1 and intCompanyId ='$companyID'  ORDER BY mainstores.strMainID ASC";
					$result =$db->RunQuery($SQL);
					echo "<option value =\"".""."\">"."Select One"."</option>";
					while ($row=mysql_fetch_array($result))
					{	
						if($mainId==$row["strMainID"])
							echo "<option selected = \"selected\" value=\"".$row["strMainID"]."\">".$row["strName"]."</option>";
						else
							echo "<option value=\"".$row["strMainID"]."\">".$row["strName"]."</option>";
					}
				
				?>
                </select></td>
            <td width="8%" class="normalfnt">Sub Stores</td>
            <td width="13%" class="normalfnt"><select name="cboSubStores" class="txtbox" id="cboSubStores" style="width:120px" onchange="loadLocation('sor');" >
              <?PHP		
				$subId = $_POST["cboSubStores"];
				
					$SQL="SELECT  substores.strSubID, substores.strSubStoresName  FROM `substores` WHERE substores.strMainID =  '$mainId'";
					$result =$db->RunQuery($SQL);
					echo "<option value =\"".""."\">"."Select One"."</option>";
					while ($row=mysql_fetch_array($result))
					{	
						if($subId==$row["strSubID"])
							echo "<option selected = \"selected\" value=\"".$row["strSubID"]."\">".$row["strSubStoresName"]."</option>";
						else
							echo "<option value=\"".$row["strSubID"]."\">".$row["strSubStoresName"]."</option>";
					}
				
				?>
                        </select></td>
          <td width="9%" class="normalfnt">Location </td>
          <td width="13%" class="normalfnt"><select name="cboLocation" class="txtbox" id="cboLocation" style="width:120px" onchange="loadBIN('sor');" >
              <?PHP		
				$location = $_POST["cboLocation"];
				
					$SQL="SELECT storeslocations.strLocID, storeslocations.strLocName FROM `storeslocations` 
					WHERE storeslocations.strMainID =  '$mainId' AND storeslocations.strSubID =  '$subId' AND storeslocations.intStatus =  '1'";
					$result =$db->RunQuery($SQL);
					echo "<option value =\"".""."\">"."Select One"."</option>";
					while ($row=mysql_fetch_array($result))
					{	
						if($location==$row["strLocID"])
							echo "<option selected = \"selected\" value=\"".$row["strLocID"]."\">".$row["strLocName"]."</option>";
						else
							echo "<option value=\"".$row["strLocID"]."\">".$row["strLocName"]."</option>";
					}
				
				?>
                        </select></td>
            <td width="6%" class="normalfnt">Bin</td>
            <td width="15%" class="normalfnt"><select name="cboBin" class="txtbox" id="cboBin" style="width:120px"  >
				
				<?PHP		
				$binId = $_POST["cboBin"];
				
					$SQL="SELECT storesbins.strBinID, storesbins.strBinName FROM `storesbins` 
					WHERE storesbins.strMainID =  '$mainId' AND storesbins.strSubID =  '$subId' 
					AND storesbins.strLocID =  '$location' and intStatus='1' ";
					
					$result =$db->RunQuery($SQL);
					echo "<option value =\"".""."\">"."Select One"."</option>";
					while ($row=mysql_fetch_array($result))
					{	
						if($binId==$row["strBinID"])
							echo "<option selected = \"selected\" value=\"".$row["strBinID"]."\">".$row["strBinName"]."</option>";
						else
							echo "<option value=\"".$row["strBinID"]."\">".$row["strBinName"]."</option>";
					}
				
				?>
                    </select></td>
            <td width="5%" class="normalfnt">&nbsp;</td>
            <td width="9%" class="normalfnt"><img src="../images/search.png" alt="search" class="mouseover" onclick="LoadSourceBinDetails();" /></td>
          </tr>
        </table></td>
        </tr>

    </table></td>
  </tr>
  
   <tr>
    <td height="15" colspan="7"  class="normalfnt" ><div id="divcons" style="overflow:scroll; height:200px; width:950px;">
      <table id="tblSource" width="100%" border="0" cellspacing="1" cellpadding="0" bgcolor="#CCCCFF">
        <tr  class="mainHeading4">
          <td width="5%" height="25">SCNo</td>
          <td width="10%" >Order No</td>
          <td width="23%" >Item Description</td>
          <td width="10%" >Color</td>
          <td width="7%" >Size</td>
          <td width="8%" >Bin Qty </td>
          <td width="11%">Trans Qty </td>
          <td width="6%" > Transfer</td>
           <td width="7%" > GRN No</td>
            <td width="6%" > GRN Year</td>
            <td width="7%" >GRN Type </td>
        </tr>
      </table>
    </div></td>
  </tr>
  <tr><td><table width="100%">
  <tr>
    <td width="136" class="normalfnt2bld">Destination Bin </td>
    <td width="9" class="normalfnt2BI">&nbsp;</td>
    <td width="52" class="normalfnt2BI">&nbsp;</td>
    <td width="90" class="normalfnt2BI">&nbsp;</td>
    <td width="163" class="normalfnt2BI">&nbsp;</td>
    <td width="93" class="normalfnt2BI"><span id="spanOrderTransferCount"></span></td>
    <td width="117" align="right" class="normalfnt2BI"></td>
    <td width="254" class="normalfnt2BI">&nbsp;</td>
  </tr>
  </table>
  </td>
  </tr>
<td width="100%"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="bcgl1">
  <tr>
    <td width="8%" height="25" class="normalfnt">Main Stores </td>
    <td width="14%" class="normalfnt"><select name="cboDesMainStores" class="txtbox" id="cboDesMainStores" style="width:120px" onchange="RemoveAllRows('tblDestination');loadSubStores('des');getCommonBinDet();" >
      <?PHP		
				
					$desMainId= $_POST["cboDesMainStores"];
					$SQL="SELECT mainstores.strMainID, mainstores.strName FROM `mainstores` 
					where intStatus=1 and intCompanyId ='$companyID'
					ORDER BY mainstores.strMainID ASC";
					$result =$db->RunQuery($SQL);
					echo "<option value =\"".""."\">"."Select One"."</option>";
					while ($row=mysql_fetch_array($result))
					{	
						if($desMainId==$row["strMainID"])
							echo "<option selected = \"selected\" value=\"".$row["strMainID"]."\">".$row["strName"]."</option>";
						else
							echo "<option value=\"".$row["strMainID"]."\">".$row["strName"]."</option>";
					}
				
				?>
    </select></td>
    <td width="8%" class="normalfnt">Sub Stores</td>
    <td width="13%" class="normalfnt"><select name="cboDesSubStores" class="txtbox" id="cboDesSubStores" style="width:120px" onchange="RemoveAllRows('tblDestination');loadLocation('des');" >
      <?PHP		
				$desSubId = $_POST["cboDesSubStores"];
				
					$SQL="SELECT  substores.strSubID, substores.strSubStoresName  FROM `substores` WHERE substores.strMainID =  '$desMainId'";
					$result =$db->RunQuery($SQL);
					echo "<option value =\"".""."\">"."Select One"."</option>";
					while ($row=mysql_fetch_array($result))
					{	
						if($desSubId==$row["strSubID"])
							echo "<option selected = \"selected\" value=\"".$row["strSubID"]."\">".$row["strSubStoresName"]."</option>";
						else
							echo "<option value=\"".$row["strSubID"]."\">".$row["strSubStoresName"]."</option>";
					}
				
				?>
    </select></td>
    <td width="9%" class="normalfnt">Location </td>
    <td width="13%" class="normalfnt"><select name="cboDesLocation" class="txtbox" id="cboDesLocation" style="width:120px" onchange="RemoveAllRows('tblDestination');loadBIN('des');;" >
      <?PHP		
				$desLocation = $_POST["cboDesLocation"];
				
					$SQL="SELECT storeslocations.strLocID, storeslocations.strLocName FROM `storeslocations` 
					WHERE storeslocations.strMainID =  '$desMainId' AND storeslocations.strSubID =  '$desSubId' AND storeslocations.intStatus =  '1'";
					$result =$db->RunQuery($SQL);
					echo "<option value =\"".""."\">"."Select One"."</option>";
					while ($row=mysql_fetch_array($result))
					{	
						if($desLocation==$row["strLocID"])
							echo "<option selected = \"selected\" value=\"".$row["strLocID"]."\">".$row["strLocName"]."</option>";
						else
							echo "<option value=\"".$row["strLocID"]."\">".$row["strLocName"]."</option>";
					}
				
				?>
    </select></td>
    <td width="6%" class="normalfnt">Bin</td>
    <td width="15%" class="normalfnt"><select name="cboDesBin" class="txtbox" id="cboDesBin" style="width:120px"  onchange="RemoveAllRows('tblDestination');">
      <?PHP		
				$desBinId = $_POST["cboDesBin"];
				
					$SQL="SELECT storesbins.strBinID, storesbins.strBinName FROM `storesbins` 
					WHERE storesbins.strMainID =  '$desMainId' AND storesbins.strSubID =  '$desSubId' 
					AND storesbins.strLocID =  '$desLocation' and intStatus='1' ";
					
					$result =$db->RunQuery($SQL);
					echo "<option value =\"".""."\">"."Select One"."</option>";
					while ($row=mysql_fetch_array($result))
					{	
						if($desBinId==$row["strBinID"])
							echo "<option selected = \"selected\" value=\"".$row["strBinID"]."\">".$row["strBinName"]."</option>";
						else
							echo "<option value=\"".$row["strBinID"]."\">".$row["strBinName"]."</option>";
					}
				
				?>
    </select></td>
    <td width="5%" class="normalfnt">&nbsp;</td>
    <td width="9%" class="normalfnt">&nbsp;</td>
  </tr>
</table></td>
 
   <tr>
    <td height="15" colspan="7"  class="normalfnt" ><div id="divcons" style="overflow:scroll; height:200px; width:950px;">
	<table id="tblDestination" width="100%" border="0" cellspacing="1" cellpadding="0" bgcolor="#CCCCFF">
        <tr class="mainHeading4">
		<td height="25" width="4%" >Del</td>
          <td width="4%" >SCNo</td>
          <td width="14%">Order  No</td>
          <td width="30%" >Item Description</td>
          <td width="10%" >Color</td>
          <td width="10%" >Size</td>
          <td width="9%">Trans Qty </td>
           <td width="6%" >GRN No </td>
            <td width="6%" >GRN Year</td>
            <td width="7%" >GRN Type </td>
        </tr>
      </table>
    </div></td>
  </tr>
	    
	    <tr>
    <td height="15" colspan="7"  class="normalfnt" ><table width="100%" border="0" cellspacing="0" cellpadding="0" class="bcgl1">
      <tr>
        <td width="40%" class="normalfntMid">
		<img src="../images/new.png" alt="new" onclick="ClearForm();" />
        <img src="../images/save.png" id="butSave" alt="save" width="84" height="24" class="mouseover" onclick="GetNo();" />
        <a href="../main.php"><img src="../images/close.png" alt="closed" width="97" height="24" border="0" class="mouseover" /></a>
        </td>
      </tr>
    </table></td>
    </tr>
</table>
</td></tr></table>
</form>
</body>
</html>
