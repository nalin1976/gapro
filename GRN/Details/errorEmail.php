<?php 

session_start();

	$system		="GRN";
	$userid		=$_SESSION["UserID"];
	$factoryid	=$_SESSION["FactoryID"];
	$ipaddress	=GetHostByName($A);//getRealIpAddr();
	$query		=$_GET["body"];
	$today		= date("Y-m-d");
	
$xHtml = "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">
<html xmlns=\"http://www.w3.org/1999/xhtml\">
<head>
<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />
<title>Untitled Document</title>
<script src=\"../java.js\" type=\"text/javascript\"></script>
<style type=\"text/css\">
<!--
body {
	background-color: #CCCCCC;
}
-->
</style>
<link href=\"../css/erpstyle.css\"  rel=\"stylesheet\" type=\"text/css\" />
<style type=\"text/css\">
.normalfnt {
	font-family: Verdana;
	font-size: 11px;
	color: #000000;
	margin: 0px;
	font-weight: normal;
	text-align:left;
}
.txtbox {
	font-family: Verdana;
	font-size: 11px;
	color: #20407B;
	border: 1px solid #abceea;
	text-align:left;
}
.normalfnth2 {
	font-family: Verdana;
	font-size: 11px;
	color: #1164A8;
	font-weight: bold;
}
.normaltxtmidb2 {
	font-family: Verdana;
	font-size: 11px;
	color: #FFFFFF;
	margin: 0px;
	font-weight: bold;
	text-align: center;
}
.bcgl1 {
	border: 1px solid #C9DFF1;
}

.head1 {
	font-family: Geneva, Arial, Helvetica, sans-serif;
	font-size: 14px;
	font-weight: bold;
	color: #0E4874;
	margin: 0px;
}
.tophead {
	font-family: \"Century Gothic\";
	font-size: 24px;
	font-weight: normal;
	color: #244893;
	margin: 0px;
}
.normalfntRite {
	font-family: Verdana;
	font-size: 11px;
	color: #000000;
	margin: 0px;
	text-align: right;
}
.normalfntMid {
	font-family: Verdana;
	font-size: 11px;
	color: #000000;
	margin: 0px;
	text-align: center;
}
.bodertopb {
	border-top-width: 1pt;
	border-right-width: 1pt;
	border-bottom-width: 1pt;
	border-left-width: 1pt;
	border-top-style: solid;
	border-right-style: solid;
	border-bottom-style: solid;
	border-left-style: solid;
	border-top-color: #9BBFDD;
	border-right-color: #FFFFFF;
	border-bottom-color: #FFFFFF;
	border-left-color: #FFFFFF;
}
.bcgl1Txt {
	border: 1px solid #C9DFF1;
	font-family: Verdana;
	font-size: 11px;
	font-weight: bold;
	color: #FFFFFF;
	text-align: center;
}
.bcgl1Txt2 {
	border: 1px solid #C9DFF1;
	font-family: Verdana;
	font-size: 11px;
	font-weight: normal;
	color: #D6E7F5;
	text-align: center;
}
.bcgl1wf {
	border: 1px solid #C9DFF1;
	font-family: Verdana;
	font-size: 11px;
	font-weight: bold;
	color: #FFFFFF;
	text-align: center;
}
.normalfnt2 {
	font-family: Arial;
	font-size: 10pt;
	color: #1E5E9D;
	margin: 0px;
}
.normalfnt2bld {
	font-family: Arial;
	font-size: 10pt;
	color: #164574;
	margin: 0px;
	font-weight: bold;
}
.error1 {
	font-family: Verdana;
	font-size: 10px;
	font-weight: bold;
	color: #FF0000;
}

.bcgl1txt1 {
	border: 1px solid #666666;
	font-family: Verdana;
	font-size: 10px;
	font-weight: normal;
	color: #000000;
	text-align: center;
}
.bcgl1txt1B {
	border: 1px solid #666666;
	font-family: Verdana;
	font-size: 10px;
	font-weight: bold;
	color: #000000;
	text-align: center;
}
.head2 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 16pt;
	font-weight: bold;
	color: #052B45;
	margin: 0px;
	text-align: center;
}
.normalfnt2BI {
	font-family: Tahoma;
	font-size: 10px;
	color: #164574;
	margin: 0px;
	font-weight: bold;
	font-style: normal;
}
.specialFnt1 {
	font-family: Verdana;
	font-size: 10px;
	color: #999999;
	margin: 0px;
	text-align: right;
}
.nfhighlite1 {
	font-family: Verdana;
	font-size: 11px;
	color: #000000;
	margin: 0px;
	font-weight: normal;
	border-top-width: 2px;
	border-right-width: 1px;
	border-bottom-width: 2px;
	border-left-width: 1px;
	border-top-style: solid;
	border-right-style: solid;
	border-bottom-style: double;
	border-left-style: solid;
	border-top-color: #000000;
	border-right-color: #666666;
	border-bottom-color: #000000;
	border-left-color: #666666;
	text-align: right;
}
.nfhighlite2 {
	font-family: Verdana;
	font-size: 11px;
	color: #000000;
	margin: 0px;
	font-weight: bold;
	border-top-width: 2px;
	border-right-width: 1px;
	border-bottom-width: 2px;
	border-left-width: 1px;
	border-top-style: solid;
	border-right-style: solid;
	border-bottom-style: double;
	border-left-style: solid;
	border-top-color: #000000;
	border-right-color: #999999;
	border-bottom-color: #000000;
	border-left-color: #999999;
	text-align: center;
}
.normalfnBLD1 {
	font-family: Verdana;
	font-size: 11px;
	color: #000000;
	font-weight: bold;
}
.tablez {
	border: 1px solid #666666;
}
.normalfntTAB {
	font-family: Verdana;
	font-size: 11px;
	color: #000000;
	margin: 0px;
	border: 1px solid #999999;
	vertical-align: top;
}
.normalfntMidTAB {
	font-family: Verdana;
	font-size: 11px;
	color: #000000;
	margin: 0px;
	text-align: center;
	border: 1px solid #999999;
	vertical-align: top;
}
.normalfntRiteTAB {
	font-family: Verdana;
	font-size: 11px;
	color: #000000;
	margin: 0px;
	text-align: right;
	border: 1px solid #999999;
	vertical-align: top;
}
.normalfnt2BITAB {
	font-family: Tahoma;
	font-size: 10px;
	color: #000000;
	font-weight: bold;
	font-style: normal;
	border: 1px solid #999999;
	background-color: #BED6E9;
}
.normalfnBLD1TAB {
	font-family: Verdana;
	font-size: 11px;
	color: #000000;
	font-weight: bold;
	border: 1px solid #999999;
}
.normalfntBtab {
	font-family: Verdana;
	font-size: 11px;
	color: #000000;
	font-weight: bold;
	background-color: #CCCCCC;
	border: 1px solid #666666;
	text-align: center;
}
.bigfntnm1 {
	font-family: Arial;
	font-size: 14px;
	color: #000000;
	margin: 0px;
	font-weight: normal;
}
.bigfntnm1mid {
	font-family: Arial;
	font-size: 14px;
	color: #000000;
	margin: 0px;
	font-weight: normal;
	text-align: center;
}
.bigfntnm1rite {
	font-family: Arial;
	font-size: 14px;
	color: #000000;
	margin: 0px;
	font-weight: normal;
	text-align: right;
}
.normalfnt2bldBLACK {
	font-family: Arial;
	font-size: 10pt;
	color: #000000;
	margin: 0px;
	font-weight: bold;
}
.normalfnt2Black {
	font-family: Arial;
	font-size: 10pt;
	color: #000000;
	margin: 0px;
}
.topheadBLACK {
	font-family: \"Century Gothic\";
	font-size: 24px;
	font-weight: normal;
	color: #000000;
	margin: 0px;
}
.head2BLCK {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 16pt;
	font-weight: bold;
	color: #000000;
	margin: 0px;
	text-align: center;
}
.normalfnth2B {
	font-family: Verdana;
	font-size: 11px;
	color: #000000;
	font-weight: bold;
}
.normalfntTAB2 {
	font-family: Verdana;
	font-size: 11px;
	color: #000000;
	margin: 0px;
	border-top-width: 0px;
	border-right-width: 0px;
	border-bottom-width: 1px;
	border-left-width: 0px;
	border-top-style: none;
	border-right-style: none;
	border-bottom-style: dotted;
	border-left-style: none;
	border-bottom-color: #333333;
	text-align: center;
}
.normalfnt2bldBLACKmid {
	font-family: Arial;
	font-size: 10pt;
	color: #000000;
	margin: 0px;
	font-weight: bold;
	text-align: center;
}
.normalfnth2Bm {
	font-family: Verdana;
	font-size: 11px;
	color: #000000;
	font-weight: bold;
	text-align: center;
}
.tablezRED {
	border: 1px solid #DC8714;
	background-color: #F8DDB6;
	font-family: Verdana;
	font-size: 11px;
	color: #000000;
}
.fntwithWite {
	font-family: Verdana;
	font-size: 11px;
	color: #000000;
	border-top-width: 0px;
	border-right-width: 0px;
	border-bottom-width: 0px;
	border-left-width: 0px;
	border-top-style: none;
	border-right-style: none;
	border-bottom-style: none;
	border-left-style: none;
	text-align:left;
}

.PopoupTitleclass {
	font-family: Arial;
	font-size: 14pt;
	font-weight: normal;
	color: #ffffff;
	margin: 0px;
	text-align: left;
}.TitleN2white {
	font-family: Tahoma;
	font-size: 14px;
	font-weight: bold;
	color: #ffffff;
	margin: 0px;
	text-align:center;
}
.bcgl2Lbl {
	border: 1px solid #3E81B7;
}
.bcgl2Lblclear {
	border: 1px solid #FFFFFF;
}
.normalfntp2 {
	font-family: Verdana;
	font-size: 10px;
	color: #666666;
	margin: 0px;
	font-weight: normal;
	text-align:left;
}
.headRed {
	font-family: Geneva, Arial, Helvetica, sans-serif;
	font-size: 14px;
	font-weight: bold;
	color: #FF0000;
	margin: 0px;
}
.normalfntp2TAB {
	font-family: Verdana;
	font-size: 10px;
	color: #666666;
	margin: 0px;
	font-weight: normal;
	text-align:left;
	border: 1px solid #CCCCCC;
}
.tablezREDMid {
	border: 1px solid #666666;
	background-color: #CCCCCC;
	font-family: Verdana;
	font-size: 10px;
	color: #000000;
	text-align: center;
	font-weight: bold;
}

.backgroundSelecterStyle{
   -moz-opacity: 0.5;
   background-color: #000000;
   color: #0066ff;
   filter: progid:DXImageTransform.Microsoft.Alpha(opacity=5);
   font-family: Verdana;
   font-size: 8pt
}
.noborderforlink {
	border-top-width: 0px;
	border-right-width: 0px;
	border-bottom-width: 0px;
	border-left-width: 0px;
	border-top-style: none;
	border-right-style: none;
	border-bottom-style: none;
	border-left-style: none;
}

.normaltxtmidb2L {
	font-family: Verdana;
	font-size: 11px;
	color: #FFFFFF;
	margin: 0px;
	font-weight: bold;
	text-align: left;
}
.normaltxtmidb2R {
	font-family: Verdana;
	font-size: 11px;
	color: #FFFFFF;
	margin: 0px;
	font-weight: bold;
	text-align: right;
}

.mouseover {
	cursor: pointer;
}

.mousewait{
	cursor:wait;
}
.backgroundcancel{
	background-image:url(../images/cancel.jpg)
}
.backcolorYellow {
    background-color: #FDEAA8;
}

.backcolorGreen {
    background-color: #DDF3DA;
}

.backcolorWhite {
    background-color: #FFFFFF;
}
.normalfntSM {

	font-family: Verdana;
	font-size: 10px;
	color: #000000;
	margin: 0px;
	font-weight: normal;
	text-align:left;
}
.normalfntMidSML {

	font-family: Verdana;
	font-size: 10px;
	color: #000000;
	margin: 0px;
	text-align: center;
}
.normalfntRiteSML {

	font-family: Verdana;
	font-size: 10px;
	color: #000000;
	margin: 0px;
	text-align: right;
}
.normalfntSMB {
	font-family: Verdana;
	font-size: 10px;
	color: #000000;
	margin: 0px;
	font-weight: bold;
	text-align:left;
}
.normalfntRiteTABb-ANS {
	font-family: Verdana;
	font-size: 11px;
	color: #000000;
	margin: 0px;
	text-align: right;
	vertical-align: top;
	border-top-width: 1px;
	border-right-width: 1px;
	border-bottom-width: 1px;
	border-left-width: 1px;
	border-top-style: solid;
	border-right-style: solid;
	border-bottom-style: double;
	border-left-style: solid;
	border-top-color: #000000;
	border-right-color: #666666;
	border-bottom-color: #000000;
	border-left-color: #666666;
	font-weight: bold;
}
.color1 {
	background-color: #FFFF00;
	border: 1px solid #333333;
}
.color2 {
	background-color: #999999;
	border: 1px solid #333333;
}
.color3 {
	background-color: #FFCC00;
	border: 1px solid #333333;
}
.color4 {
	background-color: #00CC00;
	border: 1px solid #333333;
}
.color5 {
	background-color: #00CCFF;
	border: 1px solid #333333;
}
.color6 {
	background-color: #FF99FF;
	border: 1px solid #333333;
}
.color7 {
	background-color: #FF0000;
	border: 1px solid #333333;
}
.osc1 {
	background-color: #CCCCCC;
	border: 1px solid #333333;
}
.osc2 {
	background-color: #99FF99;
	border: 1px solid #333333;
}
.osc3 {
	background-color: #FFFF99;
	border: 1px solid #333333;
}
.osc4 {
	background-color: #FF99FF;
	border: 1px solid #333333;
}
.bcgcolor {
	background-color: #D8E4F3;
}
.bcgcolor-row {
	background-color: #265275;
}
.cursercross{
cursor:move;
}

</style>


</head>

<body>

<form id=\"frmBuyers\" name=\"frmBuyers\" method=\"post\" action=\"\">
<table width=\"950\" border=\"0\" align=\"center\" bgcolor=\"#FFFFFF\" class=\"osc1\">
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><table width=\"100%\" border=\"0\">
      <tr>
        <td width=\"19%\">&nbsp;</td>
        <td width=\"62%\"><table width=\"100%\" border=\"0\">
          <tr>
            <td height=\"35\" bgcolor=\"#498cc2\" class=\"TitleN2white\"><div align=\"center\" class=\"style1\">Error Mail System </div></td>
          </tr>
          <tr>
            <td height=\"96\">
              <table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">
                <tr>
                  <td colspan=\"3\" class=\"normalfnt\">&nbsp;</td>
                  </tr>
                <tr>
                  <td width=\"26%\" class=\"normalfnt\">&nbsp;</td>
                  <td width=\"14%\" class=\"normalfnt\">Date</td>
                  <td width=\"60%\" class=\"normalfnt2bld\"><span class=\"normalfnt2bld\">$today</span></td>
                </tr>
                <tr>
                  <td colspan=\"3\" class=\"normalfnt\">&nbsp;</td>
                  </tr>
                <tr>
                  <td colspan=\"3\" class=\"normalfnt\"><table width=\"100%\" border=\"0\" class=\"bcgl1\">
                    <tr>
                      <td width=\"26%\" class=\"normalfnt\">&nbsp;</td>
                      <td width=\"29%\" class=\"normalfnt\">&nbsp;</td>
                      <td width=\"45%\" class=\"normalfnt2bld\"></td>
                    </tr>
                    <tr>
                      <td class=\"normalfnt\">&nbsp;</td>
                      <td class=\"normalfnt\">System</td>
                      <td class=\"normalfnt2bld\">$system</td>
                    </tr>
                    <tr>
                      <td class=\"normalfnt\">&nbsp;</td>
                      <td class=\"normalfnt\">User Id </td>
                      <td class=\"normalfnt2bld\">$userid</td>
                    </tr>
                    <tr>
                      <td class=\"normalfnt\">&nbsp;</td>
                      <td class=\"normalfnt\">Factory Id </td>
                      <td class=\"normalfnt2bld\">$factoryid</td>
                      </tr>
                    <tr>
                      <td class=\"normalfnt\">&nbsp;</td>
                      <td class=\"normalfnt\">Ip Address </td>
                      <td class=\"normalfnt2bld\">$ipaddress</td>
                      </tr>
                    <tr>
                      <td class=\"normalfnt\">&nbsp;</td>
                      <td class=\"normalfnt\">&nbsp;</td>
                      <td class=\"headRed\">&nbsp;</td>
                      </tr>
                    <tr>
                      <td class=\"normalfnt\">&nbsp;</td>
                      <td colspan=\"2\" class=\"normalfnt\">Query</td>
                      </tr>
                    <tr>
                      <td height=\"71\" colspan=\"3\" class=\"normalfnt\"><span class=\"error1\" id=\"errMessage\">$query</span></td>
                      </tr>
                    
                    <tr>
                      <td colspan=\"2\" class=\"normalfnt\">&nbsp;</td>
                      <td><span id=\"txtHint\" style=\"color:#FF0000\"></span></td>
                    </tr>
                  </table></td>
                  </tr>
              </table>
              </td>
          </tr>
          <tr>
            <td height=\"34\"><table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" class=\"bcgl1\">
              <tr>
                <td width=\"100%\" bgcolor=\"#d6e7f5\"><table width=\"100%\" border=\"0\">
                    <tr>
                      <td>&nbsp;</td>
                      </tr>
                </table></td>
              </tr>
            </table></td>
          </tr>
        </table></td>
        <td width=\"19%\">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
</form>
</body>
</html>";
	
	$senderEmail = 'GRN@jinadasa.com';
	$senderName  = 'GRN_Errors';
	$reciever    = 'roshanocs@gmail.com';
	$subject	 = 'GRN-error';
	
	$body = $xHtml;
	include "../../EmailSender.php";
	$eml =  new EmailSender();
	$eml->SendMessage($senderEmail,$senderName,$reciever,$subject,$body);
	//echo "done";
function getRealIpAddr()
{
    if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
    {
      $ip=$_SERVER['HTTP_CLIENT_IP'];
    }
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
    {
      $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    else
    {
      $ip=$_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}

?>