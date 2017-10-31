<?php
Header("Cache-control: private, no-cache");
Header("Expires: Mon, 26 Jun 1997 05:00:00 GMT");

session_start();
$backwardseperator = "../";

$scNo 		= $_POST["cboScNo"];
$styleId 	= $_POST["cboStyle"];
$companyID = $_SESSION["FactoryID"];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Left Over :: Bin To Bin Transfer</title>

<link href="../css/erpstyle.css" rel="stylesheet" type="text/css" />
<link href="../css/erpstyle.css" rel="stylesheet" type="text/css" />
<script src="../javascript/script.js" type="text/javascript"></script>
<script src="bin2bin.js" type="text/javascript"></script>
</head>

<body>
<?php

	include "../Connector.php";	
?>
<form name="bintobin" id="bintobin" action="binToBinTransfer.php" method="post">
<tr>
    <td><?php include '../Header.php'; ?></td>
</tr>
<table width="950" border="0" align="center" bgcolor="#FFFFFF" class="bcgl1">

  <tr>
  	<td height="6" colspan="8" bgcolor="#498CC2" class="TitleN2white">Left Over Bin To Bin Transfer</td>
  </tr>
  <tr>
    <td colspan="7"><table width="100%" border="0">
      <tr>
	    <tr>
   <td height="6" colspan="8" class="normalfnt2bld"><table width="100%">
       <tr>
         <td width="26%">Source Bin</td>
         <td width="13%"><span class="normalfnt">Sc No </span></td>
         <td width="14%"><select name="cboScNo" class="txtbox" id="cboScNo" style="width:120px" onchange="GetStyleName(this);">
           <?PHP					
					$SQL="SELECT distinct  S.intSRNO,S.intStyleId FROM specification S INNER JOIN orders O on O.intStyleId=S.intStyleId where O.intStatus=13 ORDER BY  intSRNO desc";
					$result =$db->RunQuery($SQL);
					echo "<option value =\"".""."\">"."Select One"."</option>";
					while ($row=mysql_fetch_array($result))
					{	
						if($scNo==$row["intStyleId"])
							echo "<option selected = \"selected\" value=\"".$row["intStyleId"]."\">".$row["intSRNO"]."</option>";
						else
							echo "<option value=\"".$row["intStyleId"]."\">".$row["intSRNO"]."</option>";
					}
				
				?>
         </select></td>
         <td width="9%" class="normalfnt">Order No </td>
         <td width="14%">
           <select name="cboStyle" class="txtbox" id="cboStyle" style="width:120px" onchange="GetScNo(this);" >
             <?PHP			
					
					$SQL="SELECT distinct  O.intStyleId,O.strOrderNo FROM specification S INNER JOIN orders O on O.intStyleId=S.intStyleId where O.intStatus=13 ORDER BY  strOrderNo ASC";
					$result =$db->RunQuery($SQL);
					echo "<option value =\"".""."\">"."Select One"."</option>";
					while ($row=mysql_fetch_array($result))
					{	
						if($styleId==$row["intStyleId"])
							echo "<option selected = \"selected\" value=\"".$row["intStyleId"]."\">".$row["strOrderNo"]."</option>";
						else
							echo "<option value=\"".$row["intStyleId"]."\">".$row["strOrderNo"]."</option>";
					}
				
			?>
           </select>        </td>
         <td width="9%" class="normalfnt"> BuyerPo No </td>
         <td width="15%"><select name="cboBuyerPoNo" class="txtbox" id="cboBuyerPoNo" style="width:120px" >        
         </select></td>
       </tr>
     </table></td>
  </tr>
        <td width="100%"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="bcgl1">
		
          <tr>
            <td width="8%" height="25" class="normalfnt">Main Stores </td>
            <td class="normalfnt"><select name="cboMainStores" class="txtbox" id="cboMainStores" style="width:220px">
				<?PHP		
				
					$mainId= $_POST["cboMainStores"];
					$SQL="SELECT mainstores.strMainID, mainstores.strName FROM `mainstores` where intCommonBin=1 and intCompanyId ='$companyID' ORDER BY mainstores.strMainID ASC";
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
            <td width="13%" class="normalfnt">&nbsp;</td>
            <td width="6%" class="normalfnt">&nbsp;</td>
            <td width="15%" class="normalfnt">&nbsp;</td>
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
        <tr height="25" bgcolor="#498CC2">
          <td class="normaltxtmidb2">ScNo</td>
          <td class="normaltxtmidb2">Style No</td>
          <td class="normaltxtmidb2">Item Description</td>
          <td class="normaltxtmidb2">Color</td>
          <td class="normaltxtmidb2">Size</td>
          <td class="normaltxtmidb2">Bin Qty </td>
          <td class="normaltxtmidb2">Trans Qty </td>
          <td class="normaltxtmidb2"> Transfer</td>
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
    <td width="14%" class="normalfnt"><select name="cboDesMainStores" class="txtbox" id="cboDesMainStores" style="width:120px" onchange="loadSubStores('des');" >
      <?PHP		
				
					$desMainId= $_POST["cboDesMainStores"];
					$SQL="SELECT mainstores.strMainID, mainstores.strName FROM `mainstores` where intCommonBin =0 and intStatus=1 ORDER BY mainstores.strMainID ASC";
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
    <td width="13%" class="normalfnt"><select name="cboDesSubStores" class="txtbox" id="cboDesSubStores" style="width:120px" onchange="loadLocation('des');" >
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
    <td width="13%" class="normalfnt"><select name="cboDesLocation" class="txtbox" id="cboDesLocation" style="width:120px" onchange="loadBIN('des');;" >
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
    <td width="15%" class="normalfnt"><select name="cboDesBin" class="txtbox" id="cboDesBin" style="width:120px"  >
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
        <tr height="25" bgcolor="#498CC2">
		<td width="6%" class="normaltxtmidb2">Del</td>
          <td width="7%" class="normaltxtmidb2">ScNo</td>
          <td width="18%" class="normaltxtmidb2">Style No</td>
          <td width="32%" class="normaltxtmidb2">Item Description</td>
          <td width="11%" class="normaltxtmidb2">Color</td>
          <td width="11%" class="normaltxtmidb2">Size</td>
          <td width="15%" class="normaltxtmidb2">Trans Qty </td>
          </tr>
      </table>
    </div></td>
  </tr>
	    
	    <tr>
    <td height="15" colspan="7"  class="normalfnt" ><table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#D6E7F5">
      <tr>
        <td width="34%">&nbsp;</td>
        <td width="16%" class="normalfntMid"><img src="../images/save.png" id="butSave" alt="save" width="84" height="24" class="mouseover" onclick="GetNo();" /></td>
        <td width="16%" class="normalfntMid"><a href="../main.php"><img src="../images/close.png" alt="closed" width="97" height="24" border="0" class="mouseover" /></a></td>
        <td width="34%">&nbsp;</td>
      </tr>
    </table></td>
    </tr>
</table>
</form>
</body>
</html>
