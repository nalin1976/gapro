<?php
	session_start();
	
	include "../Connector.php";
	$chequeRefNo=$_GET["chequeRefNo"];
	$amtInWords=$_GET["amtInWords"];
	if(strlen($amtInWords)<41)
	{
		$amtInWords1=$amtInWords;
		
	}
	else
	{
		$amtInWordsA=substr($amtInWords,0,40);
		$tempAmtInWords=substr($amtInWords,41);
		
		if(strlen($tempAmtInWords)<41)
		{
		$amtInWordsB=$tempAmtInWords;

		}
		else
		{
		$amtInWordsB=substr($tempAmtInWords,41,40);
		$amtInWordsC=substr($tempAmtInWords,41);

		}
		
	}
?>

<head runat="server">
<meta content="text/VBScript" http-equiv="content-script-type" />
<title>Cheque Priveiw</title>
<link href="../css/erpstyle.css" rel="stylesheet" type="text/css" />
<link href="calendar.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="../javascript/calendar/theme.css" />

<script type="text/javascript" language="JavaScript">

function CallPrint(strid)
{
	var prtContent = document.getElementById(strid);
	var WinPrint =window.open('','','left=0,top=0,width=1,height=1,t oolbar=0,scrollbars=0,status=0');
	WinPrint.document.write(prtContent.innerHTML);
	WinPrint.document.close();
	WinPrint.focus();
	WinPrint.print();
	WinPrint.close();
	//prtContent.innerHTML=strOldOne;
}

</script>

<style type="text/css">
<!--
#Layer2 {
	position:absolute;
	left:380px;
	top:66px;
	width:140px;
	height:25px;
	z-index:1;
}
#Layer3 {
	position:absolute;
	left:-5px;
	top:-4px;
	width:1249px;
	height:312px;
	z-index:1;
	overflow: visible;
	background-color: #FFFFFF;
}
-->

</style>

<style type="text/css">
<!--
body {
	background-color: #CCCCCC;
	
}
-->
</style>

<style type="text/css">
<!--
#tblSample td, th { padding: 0.5em; }
.classy0 { background-color: #234567; color: #89abcd; }
.classy1 { background-color: #89abcd; color: #234567; }
#Layer1 {
	position:absolute;
	left:842px;
	top:173px;
	width:204px;
	height:41px;
	z-index:1;
}
#Layer4 {
	position:absolute;
	left:1392px;
	top:183px;
	width:116px;
	height:36px;
	z-index:2;
	background-color: #FFFF00;
}
-->
</style>
</head>
<body>
<?php
$strSQL= "SELECT chequeRefNo,chDate,payee,chequeType,totalAmount FROM chequeprinterhead WHERE chequeRefNo='$chequeRefNo'";
$result=$db->RunQuery($strSQL);
while($row = mysql_fetch_array($result))
{ 
	
	$payee= strtoupper($row["payee"]);
	$date= $row["chDate"];
	$totalAmount=$row["totalAmount"];
}

$strSQL= "update chequeprinterhead set isChequePrinted=1 WHERE chequeRefNo='$chequeRefNo'";
$db->RunQuery($strSQL);


?>

<div id="Layer3" style="width:1721px">
  <table width="1720" height="367" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td width="5">&nbsp;</td>
      <td width="5">&nbsp;</td>
      <td width="12">&nbsp;</td>
      <td width="5">&nbsp;</td>
      <td width="5">&nbsp;</td>
      <td width="5">&nbsp;</td>
      <td width="5">&nbsp;</td>
      <td width="9">&nbsp;</td>
      <td width="17">&nbsp;</td>
      <td colspan="3" class="normalfnt_size20"><?php echo(date("d/m/Y")); ?></td>
      <td width="186" class="normalfnt_size20">&nbsp;</td>
      <td class="normalfnt_size20">&nbsp;</td>
      <td colspan="3" class="normalfnt_size20"><?php //echo($chequeRefNo); ?></td>
      <td colspan="2" class="normalfnt_size20">&nbsp;</td>
      <td width="159" class="normalfnt_size20">&nbsp;</td>
      <td width="8" class="normalfnt_size20">&nbsp;</td>
      <td width="62" class="normalfnt_size20">&nbsp;</td>
      <td width="21" class="normalfnt_size20">&nbsp;</td>
      <td width="128">&nbsp;</td>
      <td width="12">&nbsp;</td>
      <td width="45">&nbsp;</td>
      <td width="73">&nbsp;</td>
      <td width="73" class="normalfnt_size20"><?php 
		$sday=date("d");
		$sday1=substr($sday,0,1);
		$sday2=substr($sday,1,1);
		
		$smonth=date("m");
		$smonth1=substr($smonth,0,1);
		$smonth2=substr($smonth,1,1);
		
		$syear=date("Y");
		$syear1=substr($syear,0,1);
		$syear2=substr($syear,1,1);
		$syear3=substr($syear,2,1);
		$syear4=substr($syear,3,1);

	?></td>
      <td width="53" class="normalfnt_size20">&nbsp;</td>
      <td colspan="2" class="normalfnt_size20">&nbsp;</td>
      <td colspan="2" class="normalfnt_size20">&nbsp;</td>
      <td width="37" class="normalfnt_size20">&nbsp;</td>
      <td width="37" class="normalfnt_size20">&nbsp;</td>
      <td width="31" class="normalfnt_size20">&nbsp;</td>
      <td width="31" class="normalfnt_size20">&nbsp;</td>
      <td width="4" class="normalfnt_size20">&nbsp;</td>
      <td width="161" class="normalfnt_size20">&nbsp;</td>
    </tr>
    <tr>
      <td height="27" rowspan="2">&nbsp;</td>
      <td rowspan="2">&nbsp;</td>
      <td rowspan="2">&nbsp;</td>
      <td rowspan="2">&nbsp;</td>
      <td rowspan="2">&nbsp;</td>
      <td rowspan="2">&nbsp;</td>
      <td rowspan="2">&nbsp;</td>
      <td rowspan="2">&nbsp;</td>
      <td rowspan="2">&nbsp;</td>
      <td width="55" rowspan="2">&nbsp;</td>
      <td width="55" rowspan="2">&nbsp;</td>
      <td width="34" rowspan="2">&nbsp;</td>
      <td rowspan="2">&nbsp;</td>
      <td width="52" rowspan="2">&nbsp;</td>
      <td colspan="3" rowspan="2">&nbsp;</td>
      <td width="33" rowspan="2">&nbsp;</td>
      <td width="53" rowspan="2">&nbsp;</td>
      <td rowspan="2">&nbsp;</td>
      <td rowspan="2">&nbsp;</td>
      <td rowspan="2">&nbsp;</td>
      <td rowspan="2">&nbsp;</td>
      <td rowspan="2" class="normalfnt_size20">&nbsp;</td>
      <td colspan="3" rowspan="2" class="normalfnt_size20">&nbsp;</td>
      <td rowspan="2">&nbsp;</td>
      <td rowspan="2">&nbsp;</td>
      <td width="44" rowspan="2">&nbsp;</td>
      <td width="4" height="2">&nbsp;</td>
      <td width="28">&nbsp;</td>
      <td width="43">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td colspan="2">&nbsp;</td>
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td height="20" colspan="9"><table width="286" height="25" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="25">&nbsp;</td>
          <td  class="normalfnt_size20"><span ><?php echo($sday1); ?></span></td>
          <td  class="normalfnt_size20"><span ><?php echo($sday2); ?></span></td>
          <td  class="normalfnt_size20"><span ><?php echo($smonth1); ?></span></td>
          <td  class="normalfnt_size20"><span ><?php echo($smonth2); ?></span></td>
          <td width="27"  class="normalfnt_size20"><span ><?php echo '  '; //echo($syear1); ?></span></td>
          <td width="27" class="normalfnt_size20"><span ><?php echo '  '; //echo($syear2); ?></span></td>
          <td  class="normalfnt_size20"><span ><?php echo($syear3); ?></span></td>
          <td  class="normalfnt_size20"><span ><?php echo($syear4); ?></span></td>
        </tr>
      </table></td>
    </tr>
    <tr>
      <td height="27">&nbsp;</td>
      <td>&nbsp;</td>
      <td class="normalfnt_size20">&nbsp;</td>
      <td class="normalfnt_size20">&nbsp;</td>
      <td class="normalfnt_size20">&nbsp;</td>
      <td>&nbsp;</td>
      <td colspan="7">&nbsp;</td>
      <td colspan="3" class="normalfnt_size20">&nbsp;</td>
      <td width="6">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td colspan="2">&nbsp;</td>
      <td colspan="2">&nbsp;</td>
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td height="56">&nbsp;</td>
      <td height="56">&nbsp;</td>
      <td height="56">&nbsp;</td>
      <td height="56">&nbsp;</td>
      <td height="56">&nbsp;</td>
      <td height="56">&nbsp;</td>
      <td height="56">&nbsp;</td>
      <td height="56">&nbsp;</td>
      <td height="56">&nbsp;</td>
      <td height="56" colspan="6"><span class="normalfnt_size20"><span ><?php echo($payee); ?></span></span></td>
      <td width="24" height="56">&nbsp;</td>
      <td height="56">&nbsp;</td>
      <td height="56">&nbsp;</td>
      <td height="56">&nbsp;</td>
      <td height="56">&nbsp;</td>
      <td height="56" colspan="9"><span class="normalfnt_size20"><?php echo($payee); ?></span></td>
      <td height="56">&nbsp;</td>
      <td height="56">&nbsp;</td>
      <td height="56">&nbsp;</td>
      <td height="56">&nbsp;</td>
      <td height="56">&nbsp;</td>
      <td height="56">&nbsp;</td>
      <td height="56">&nbsp;</td>
      <td height="56">&nbsp;</td>
      <td height="56">&nbsp;</td>
      <td height="56">&nbsp;</td>
    </tr>
    
    <tr>
      <td height="40">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td colspan="7">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td colspan="7"><span class="normalfnt_size20"><?php echo($amtInWords); ?></span></td>
      <td>&nbsp;</td>
      <td colspan="2">&nbsp;</td>
      <td colspan="3">&nbsp;</td>
      <td colspan="2">&nbsp;</td>
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td height="19">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td colspan="7"><span class="normalfnt_size20"><?php echo($amtInWords); ?></span></td>
      <td>&nbsp;</td>
      <td colspan="2">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td colspan="7">&nbsp;</td>
      <td>&nbsp;</td>
      <td colspan="2">&nbsp;</td>
      <td>&nbsp;</td>
      <td colspan="3"><span class="normalfnt_size20"><?php echo(number_format($totalAmount,2)); ?></span></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td height="23">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td colspan="7"></td>
      <td></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td >&nbsp;</td>
      <td colspan="7" >&nbsp;</td>
      <td class="normalfnt_size20">&nbsp;</td>
      <td colspan="2">&nbsp;</td>
      <td>&nbsp;</td>
      <td colspan="3">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td height="19">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td width="100">&nbsp;</td>
      <td colspan="2">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td colspan="8">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td colspan="4">&nbsp;</td>
      <td colspan="2">&nbsp;</td>
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td colspan="2" class="normalfnt_size20"><span ><?php echo(number_format($totalAmount,2)); ?></span></td>
      <td>&nbsp;</td>
      <td colspan="5"><table width="362" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="41">&nbsp;</td>
          <td width="22">&nbsp;</td>
          <td width="79"><span class="normalfnt_size20"><?php echo(number_format($totalAmount,2)); ?></span></td>
          <td width="76">&nbsp;</td>
          <td width="101"><span class="normalfnt_size20"><?php echo '0.00'; ?></span></td>
          <td width="43"><span class="normalfnt_size20"><?php echo(number_format($totalAmount,2)); ?></span></td>
        </tr>
      </table></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td class="normalfnt_size20">&nbsp;</td>
      <td colspan="3" class="normalfnt_size20">&nbsp;</td>
      <td>&nbsp;</td>
      <td colspan="3">&nbsp;</td>
      <td colspan="2">&nbsp;</td>
      <td colspan="2">&nbsp;</td>
      <td colspan="2">&nbsp;</td>
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td colspan="2">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td class="normalfnt_size20">&nbsp;</td>
      <td colspan="3" class="normalfnt_size20">&nbsp;</td>
      <td>&nbsp;</td>
      <td colspan="3">&nbsp;</td>
      <td colspan="2">&nbsp;</td>
      <td colspan="2">&nbsp;</td>
      <td colspan="2">&nbsp;</td>
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td colspan="2">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td class="normalfnt_size20">&nbsp;</td>
      <td colspan="3" class="normalfnt_size20">&nbsp;</td>
      <td>&nbsp;</td>
      <td colspan="3">&nbsp;</td>
      <td colspan="2">&nbsp;</td>
      <td colspan="2">&nbsp;</td>
      <td colspan="2">&nbsp;</td>
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td colspan="2">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td colspan="3">&nbsp;</td>
      <td>&nbsp;</td>
      <td colspan="3">&nbsp;</td>
      <td colspan="2">&nbsp;</td>
      <td colspan="2">&nbsp;</td>
      <td colspan="2">&nbsp;</td>
      <td colspan="2">&nbsp;</td>
    </tr>
  </table>
</div>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>
  <input type="button" value="Print" onClick="CallPrint('Layer3');" style="width: 110px" id="Button1" />
  
</p>
</body>
</html>
