<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Gate Pass</title>
<link href="css/erpstyle.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.style1 {color: #666666}
-->
</style>
</head>

<body>
<?php
include "Connector.php";

  //$GatepassNo = "195";
  //$Year = "2009";
  
  $GatepassNo = $_GET[""];
  $Year = $_GET[""];
  
  $SQL_header = "SELECT gatepass.intGatePassNo,gatepass.intGPYear,gatepass.dtmDate,mainstores.strName,companies.strName FROM gatepass INNER JOIN mainstores ON gatepass.strTo = mainstores.strMainID INNER JOIN companies ON gatepass.intCompany = companies.intCompanyID WHERE intGatePassNo = ".$GatepassNo." AND intGPYear = ".$Year.";";
  
            $result_header = $db->RunQuery($SQL_header);
			while($row_header = mysql_fetch_array($result_header))
			{
			  $PassNo = $row_header["intGatePassNo"];
			  $PassYear = $row_header["intGPYear"];
			  $MainStoName = $row_header["strName"];
			  $CompanyName = $row_header["strName"];
			  $DateTime = $row_header["dtmDate"];
			  $Date = substr($DateTime,-19,10);
			  $Time = substr($DateTime,-8);
			  $NewDate = explode("-",$Date);
			
			}
?>
<table width="800" border="0" align="center">
  <tr>
    <td><table width="100%" cellpadding="0" cellspacing="0">
      <tr>
        <td width="20%"><img src="images/GaPro_logo.png" alt="" width="191" height="47" class="normalfnt" /></td>
        <td width="6%" class="normalfnt">&nbsp;</td>
        <td width="74%" class="tophead"><p class="topheadBLACK"><?php echo $CompanyName; ?></p></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" class="head2BLCK">
      <tr>
        <td width="78%" height="38" class="head2BLCK">GATE PASS</td>
        <td width="22%" class="head2BLCK">QAP-43-J7</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0">
      <tr>
        <td width="22%" class="normalfnt2bldBLACK">SERIAL NO</td>
        <td width="28%" class="normalfnt"><?php echo $PassYear."/".$PassNo; ?></td>
        <td width="19%" class="normalfnt2bldBLACK">TIME</td>
        <td width="31%" class="normalfnt"><?php echo $NewDate[2]."/".$NewDate[1]."/".$NewDate[0];?></td>
      </tr>
      <tr>
        <td class="normalfnt2bldBLACK">TO</td>
        <td rowspan="3" valign="top" class="normalfntSM"><p class="normalfnt"><?php echo $MainStoName;?></p>
<!--          <p class="normalfnt">45,</p>
          <p class="normalfnt">FERNEOOD </p>
          <p class="normalfnt">AVENUE EDISON NJ USA</p></td>-->
        <td class="normalfnt2bldBLACK">DATE</td>
        <td class="normalfnt"><?php echo $Time;?></td>
      </tr>
      <tr>
        <td class="normalfnt2bldBLACK">&nbsp;</td>
        <td class="normalfnt2bldBLACK">&nbsp;</td>
        <td class="normalfnt">&nbsp;</td>
      </tr>
      <tr>
        <td class="normalfnt2bldBLACK">&nbsp;</td>
        <td class="normalfnt2bldBLACK">&nbsp;</td>
        <td class="normalfnt">&nbsp;</td>
      </tr>
      <tr>
        <td class="normalfnt2bldBLACK">&nbsp;</td>
        <td class="normalfnt">&nbsp;</td>
        <td class="normalfnt2bldBLACK">&nbsp;</td>
        <td class="normalfnt">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td height="69"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="tablez">
      <tr>
        <td width="28%" height="35" class="normalfntBtab">STYLE</td>
        <td width="35%" class="normalfntBtab">DESCRIPTION</td>
        <td width="13%" class="normalfntBtab">UNIT</td>
        <td width="15%" class="normalfntBtab">QTY</td>
        </tr>
        <?php
        $SQL_details = "SELECT gatepassdetails.intStyleId,gatepassdetails.dblQty,matitemlist.strItemDescription,matitemlist.strUnit FROM gatepassdetails INNER JOIN gatepass ON gatepass.intGatePassNo = gatepassdetails.intGatePassNo AND gatepass.intGPYear = gatepassdetails.intGPYear INNER JOIN matitemlist ON gatepassdetails.intMatDetailId = matitemlist.intItemSerial WHERE gatepass.intGatePassNo =  ".$GatepassNo." AND gatepass.intGPYear =  ".$Year.";";
		   $result_details = $db->RunQuery($SQL_details);
		   while($row_details = mysql_fetch_array($result_details))  
		   {
		
		?>
      <tr>
        <td class="normalfntTAB"><?php echo $row_details["intStyleId"];?></td>
        <td class="normalfntTAB"><?php echo $row_details["strItemDescription"];?></td>
        <td class="normalfntMidTAB"><?php echo $row_details["strUnit"];?></td>
        <td class="normalfntRiteTAB"><?php echo $row_details["dblQty"];?></td>
        </tr>
        <?php
		   }
		?>
      <tr>
        <td colspan="4" class="tablezREDMid">&nbsp;</td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td height="73"><table width="100%" border="0">
      <tr>
        <td width="25%" class="bcgl1txt1">&nbsp;</td>
        <td width="25%" class="bcgl1txt1">&nbsp;</td>
        <td width="25%" class="bcgl1txt1">&nbsp;</td>
        <td width="25%" class="bcgl1txt1">&nbsp;</td>
      </tr>
      <tr>
        <td class="normalfntMid">Prepared by</td>
        <td class="normalfntMid">Authorized By</td>
        <td class="normalfntMid">Delivered By</td>
        <td class="normalfntMid">Signature</td>
      </tr>
      <tr>
        <td class="bcgl1txt1">&nbsp;</td>
        <td class="bcgl1txt1">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td class="normalfntMid">Vehicle No</td>
        <td class="normalfntMid">Time In</td>
        <td class="normalfntMid">&nbsp;</td>
        <td class="normalfntMid">&nbsp;</td>
      </tr>
      <tr>
        <td class="bcgl1txt1">&nbsp;</td>
        <td class="bcgl1txt1">&nbsp;</td>
        <td class="bcgl1txt1">&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td class="normalfntMid">Date</td>
        <td class="normalfntMid">Time Out</td>
        <td class="normalfntMid">Signature Security</td>
        <td class="normalfntMid">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
</table>
</body>
</html>
