<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<script src="java.js" type="text/javascript"></script>
<style type="text/css">
<!--
body {
	background-color: #CCCCCC;
}
-->
</style>
<link href="erpstyle.css"  rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.style1 {
	color: #FFFFFF;
	font-weight: bold;
	font-size: 14px;
	font-family: Tahoma;
	}
</style>

<!--<script src="button.js"></script>
<script src="Search.js"></script>-->

</head>


<body onload="getData();">

<form id="frmBuyers" name="frmBuyers" method="post" action="messageQ.php">
<table width="950" border="0" align="center" bgcolor="#FFFFFF">
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><table width="100%" border="0">
      <tr>
        <td width="19%">&nbsp;</td>
        <td width="62%"><table width="100%" border="0">
          <tr>
            <td height="35" bgcolor="#498cc2" class="TitleN2white"><div align="center" class="style1">Message Q </div></td>
          </tr>
          <tr>
            <td height="96">
              <table width="100%" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td colspan="2" class="normalfnt">&nbsp;</td>
                  <td width="63%">&nbsp;</td>
                </tr>
                <tr>
                  <td width="5%" class="normalfnt">&nbsp;</td>
                  <td width="32%" class="normalfnt">&nbsp;</td>
                  <td class="normalfnt2bld"><span id="search">Searching...</span></td>
                </tr>
                <tr>
                  <td colspan="3" class="normalfnt">&nbsp;</td>
                  </tr>
                <tr>
                  <td colspan="3" class="normalfnt"><table width="100%" border="0" class="bcgl1">
                    <tr>
                      <td width="32%" class="normalfnt">&nbsp;</td>
                      <td width="21%" class="normalfnt">&nbsp;</td>
                      <td colspan="2" class="normalfnt2bld"></td>
                    </tr>
                    <tr>
                      <td class="normalfnt">&nbsp;</td>
                      <td class="normalfnt">Record Count </td>
                      <td colspan="2"><span class="normalfnt2bld"  id="all">0</span></td>
                    </tr>
                    <tr>
                      <td class="normalfnt">&nbsp;</td>
                      <td class="normalfnt">&nbsp;</td>
                      <td class="headRed"></td>
                      <td width="22%" rowspan="5" class="headRed"><img src="images/loading_6.gif" alt="CLOSE" name="butLoading"  id="butLoading" /></td>
                    </tr>
                    <tr>
                      <td class="normalfnt">&nbsp;</td>
                      <td class="normalfnt">Completed</td>
                      <td width="25%"><span class="normalfnt2bld" id="completed">0</span></td>
                      </tr>
                    <tr>
                      <td class="normalfnt">&nbsp;</td>
                      <td class="normalfnt">&nbsp;</td>
                      <td>&nbsp;</td>
                      </tr>
                    <tr>
                      <td class="normalfnt">&nbsp;</td>
                      <td class="normalfnt">Not Completed </td>
                      <td class="headRed"><span id="notcompleted">0</span></td>
                      </tr>
                    <tr>
                      <td class="normalfnt"><span class="error1" id="errMessage"></span></td>
                      <td class="normalfnt"><img onclick="passError(this.index);" src="images/continue.png" alt="CLOSE" name="imgContinue" class="mouseover" id="imgContinue" style="visibility:hidden" /></td>
                      <td class="normalfnt">&nbsp;</td>
                      </tr>
                    
                    <tr>
                      <td class="normalfnt">&nbsp;</td>
                      <td class="normalfnt">&nbsp;</td>
                      <td colspan="2">&nbsp;</td>
                    </tr>
                    <tr>
                      <td height="29" colspan="4" class="normalfnt"><div id="cccc" style="width:600px">
                        <table width="598" height="23">
                          <tr><td width="414" align="center"><span id="txtHint" style="color:#FF0000" ></span></td>
                          </tr></table></div></td>
                      </tr>
                  </table></td>
                  </tr>
              </table>
              </td>
          </tr>
          <tr>
            <td height="34"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="bcgl1">
              <tr>
                <td width="100%" bgcolor="#d6e7f5"><table width="100%" border="0">
                    <tr>
                      <td>&nbsp;</td>
                      <td width="26%"><img src="../images/close.png" alt="CLOSE" width="97" height="24" name="close" /></td>
                    </tr>
                </table></td>
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
</form>
</body>
</html>
