<?php
	 session_start();
	 include "Connector.php";
         
         $styleID = $_GET["styleid"];
         
         $printStatus   = 0;
         $embStatus     = 0;
         $HSStatus      = 0;
         $HWStatus      = 0;
         $otherStatus   = 0;
         $strOtherType  = '';
         $NAStatus      = 0;
         
         #=====================================
         # Adding - New Embelishment Types
         # Add On - 04/28/2017
         # Add By - Nalin Jayakody
         #=====================================
         $CPLStatus     = 0;
         $PreSewStatus  = 0;
         $pressingState = 0;
         $BNPStatus     = 0;
         $HTPStatus     = 0;
         $SAStatus      = 0;
         $DAStatus      = 0;
         $SmokingState  = 0;
         $PleatingState = 0;
         $WashStatus    = 0;
         #=====================================
         
	 
         $sql = " SELECT intPrint, intEMB, intHeatSeal, intHW, intOther, strOther, intNA, intCPL, intPreSew, intPressing, intBNP, intHTP, intSA, intDA, intSmoking, intPleating, intWash FROM orders WHERE intStyleId = '$styleID' ";
         $res = $db->RunQuery($sql);
         //echo $sql;
         while(list($print, $emb, $hs, $hw, $other, $strOth, $na, $cpl, $presew, $pressing, $bnp, $htp, $SeqAttach, $diamondattach, $smoking, $pleating, $wash) = mysql_fetch_array($res)){
            $printStatus =  $print;
            $embStatus = $emb;
            $HSStatus = $hs;
            $HWStatus = $hw;
            $otherStatus =  $other;
            $strOtherType = $strOth;
            $NAStatus = $na;
            
            $CPLStatus = $cpl;
            $PreSewStatus = $presew;
            $pressingState = $pressing;
            $BNPStatus = $bnp;
            $HTPStatus = $htp;
            $SAStatus = $SeqAttach;
            $DAStatus = $diamondattach;
            $SmokingState = $smoking;
            $PleatingState = $pleating;
            $WashStatus = $wash;
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
            <table width="100%" id="tbEmbType" name="tbEmbType" border="0">
                <tr><td class="normalfnt" width="20%">Print</td>
                    <td width="10%"><input type="checkbox" id="chkPrint" name="chkPrint" <?php if($printStatus == 1){echo "checked='checked'";} ?>></input></td>
                    <td width="14%">&nbsp;</td>
                    <td class="normalfnt" width="28%">Back neck Print</td>
                    <td width="10%"><input type="checkbox" id="chkBNP" name="chkBNP" <?php if($BNPStatus == 1){echo "checked='checked'";} ?>></input></td>
                    <td width="18%">&nbsp;</td>
                </tr>
                <tr><td class="normalfnt">Embroidery</td><td><input type="checkbox" id="chkEmb" name="chkEmb" <?php if($embStatus == 1){echo "checked='checked'";} ?>></input></td>
                    <td width="14%">&nbsp;</td>
                    <td class="normalfnt" width="28%">Heat Transfer Printing</td>
                    <td width="10%"><input type="checkbox" id="chkHTP" name="chkHTP" <?php if($HTPStatus == 1){echo "checked='checked'";} ?>></input></td>
                    <td width="18%">&nbsp;</td>
                </tr>
                <tr><td class="normalfnt">Heat Seal</td><td><input type="checkbox" id="chkHeatSeal" name="chkHeatSeal" <?php if($HSStatus == 1){echo "checked='checked'";} ?>></input></td>
                    <td width="14%">&nbsp;</td>
                    <td class="normalfnt" width="28%">Sequins Attach</td>
                    <td width="10%"><input type="checkbox" id="chkSEQ" name="chkSEQ" <?php if($SAStatus == 1){echo "checked='checked'";} ?>></input></td>
                    <td width="18%">&nbsp;</td>
                </tr>
                <tr><td class="normalfnt">Handwork</td><td><input type="checkbox" id="chkHW" name="chkHW" <?php if($HWStatus == 1){echo "checked='checked'";} ?>></input></td>
                    <td width="14%">&nbsp;</td>
                    <td class="normalfnt" width="28%">Diamonds Attach</td>
                    <td width="10%"><input type="checkbox" id="chkDA" name="chkDA" <?php if($DAStatus == 1){echo "checked='checked'";} ?>></input></td>
                    <td width="18%">&nbsp;</td>
                </tr>
                <tr><td class="normalfnt">CPL</td><td><input type="checkbox" id="chkCPL" name="chkCPL" <?php if($CPLStatus == 1){echo "checked='checked'";} ?>></input></td>
                    <td width="14%">&nbsp;</td>
                    <td class="normalfnt" width="28%">Smoking</td>
                    <td width="10%"><input type="checkbox" id="chkSmoking" name="chkSmoking" <?php if($SmokingState == 1){echo "checked='checked'";} ?>></input></td>
                    <td width="18%">&nbsp;</td>
                </tr>
                <tr><td class="normalfnt">Pre Sew</td><td><input type="checkbox" id="chkPreSew" name="chkPreSew" <?php if($PreSewStatus == 1){echo "checked='checked'";} ?>></input></td>
                    <td width="14%">&nbsp;</td>
                    <td class="normalfnt" width="28%">Pleating</td>
                    <td width="10%"><input type="checkbox" id="chkPleating" name="chkPleating" <?php if($PleatingState == 1){echo "checked='checked'";} ?>></input></td>
                    <td width="18%">&nbsp;</td>
                </tr>
                <tr><td class="normalfnt">Other</td><td><input type="checkbox" id="chkOther" name="chkOther" onclick="setEmbOther();" <?php if($otherStatus == 1){echo "checked='checked'";} ?>></input></td>
                    <td align="left" colspan="4"><input type="text" id="txtOther" name="txtOther" style="<?php if($otherStatus == 1){echo "visibility:visible";}else{echo "visibility:hidden";} ?>" value="<?php echo $strOtherType; ?>"></input></td>
                </tr>
                
                <tr><td class="normalfnt">N/A</td><td><input type="checkbox" id="chkNA" name="chkNA" <?php if($NAStatus == 1){echo "checked='checked'";} ?>></input></td>
                    <td width="14%">&nbsp;</td>
                    <td class="normalfnt" width="28%">Wash</td>
                    <td width="10%"><input type="checkbox" id="chkWash" name="chkWash" <?php if($WashStatus == 1){echo "checked='checked'";} ?>></input></td>
                    <td width="18%">&nbsp;</td>
                </tr>
                <tr><td class="normalfnt">Pressing</td><td><input type="checkbox" id="chkPressing" name="chkPressing" <?php if($pressingState == 1){echo "checked='checked'";} ?>></input></td>
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