<?php
	 session_start();
	 include "Connector.php";
         
         $styleID = $_GET["styleid"];
         
         $printStatus = 0;
         $embStatus = 0;
         $HSStatus = 0;
         $HWStatus = 0;
         $otherStatus = 0;
         $strOtherType = '';
         $NAStatus = 0;
	 
         $sql = " SELECT intPrint, intEMB, intHeatSeal, intHW, intOther, strOther, intNA FROM orders WHERE intStyleId = '$styleID' ";
         $res = $db->RunQuery($sql);
         //echo $sql;
         while(list($print, $emb, $hs, $hw, $other, $strOth, $na) = mysql_fetch_array($res)){
            $printStatus =  $print;
            $embStatus = $emb;
            $HSStatus = $hs;
            $HWStatus = $hw;
            $otherStatus =  $other;
            $strOtherType = $strOth;
            $NAStatus = $na;
         }
         
         
         
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Material Ratio</title>
<style type="text/css">
<!--
body {
	background-color: #CCCCCC;
}
-->
</style>
<link href="css/erpstyle.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="380" border="0" align="center">    
    <tr><td colspan="4" class="normalfntMid">&nbsp;</td></tr>
    <tr><td>&nbsp;</td></tr>
    <tr>
        <td colspan="4">
            <fieldset style="border:1px solid orange;">
                <legend class="normalfnt"><strong>Embellishment Type</strong></legend>
            <table width="100%" id="tbEmbType" name="tbEmbType">
                <tr><td class="normalfnt" width="20%">Print</td>
                    <td width="10%"><input type="checkbox" id="chkPrint" name="chkPrint" <?php if($printStatus == 1){echo "checked='checked'";} ?>></input></td>
                    <td width="70%">&nbsp;</td>
                </tr>
                <tr><td class="normalfnt">Embroidery</td><td><input type="checkbox" id="chkEmb" name="chkEmb" <?php if($embStatus == 1){echo "checked='checked'";} ?>></input></td></tr>
                <tr><td class="normalfnt">Heat Seal</td><td><input type="checkbox" id="chkHeatSeal" name="chkHeatSeal" <?php if($HSStatus == 1){echo "checked='checked'";} ?>></input></td></tr>
                <tr><td class="normalfnt">Handwork</td><td><input type="checkbox" id="chkHW" name="chkHW" <?php if($HWStatus == 1){echo "checked='checked'";} ?>></input></td></tr>
                <tr><td class="normalfnt">Other</td><td><input type="checkbox" id="chkOther" name="chkOther" onclick="setEmbOther();" <?php if($otherStatus == 1){echo "checked='checked'";} ?>></input></td>
                    <td align="left"><input type="text" id="txtOther" name="txtOther" style="<?php if($otherStatus == 1){echo "visibility:visible";}else{echo "visibility:hidden";} ?>" value="<?php echo $strOtherType; ?>"></input></td>
                </tr>
                <tr><td class="normalfnt">N/A</td><td><input type="checkbox" id="chkNA" name="chkNA" <?php if($NAStatus == 1){echo "checked='checked'";} ?>></input></td></tr>
            </table>
            </fieldset>
        </td>
    </tr>
    <tr>
        <td>&nbsp;</td>
    </tr>
    <tr bgcolor="#D6E7F5">
        <td width="30%">&nbsp;</td>
        <td width="23%"><img src="images/ok.png" alt="ok" width="86" height="24" onclick="SaveEmb();" /></td>

        <td width="26%"><img src="images/close.png" width="97" height="24" onclick="closeWindow();" /></td>
        <td width="21%">&nbsp;</td>
    </tr>
</table>
</body>
</html>