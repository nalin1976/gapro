<?php
 session_start();
 include "../../Connector.php";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Calender</title>


<link href="../css/planning.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="../../javascript/calendar/theme.css" />
<script src="../../javascript/calendar/calendar.js" type="text/javascript"></script>
<script src="../../javascript/calendar/calendar-en.js" type="text/javascript"></script>
<script src="../../javascript/script.js" type="text/javascript"></script>
<script src="../calender/calender-js.js" type="text/javascript"></script>

</head>

<body  >
<?php 
	//$intYear  	= $_POST["cboYear"];
	$intYear	= 2011;
	$intMonth	= $_POST["cboMonth"];
?>
<table width="320" height="260" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
    <tr class="cursercross" onmousedown="grab(document.getElementById('frmCalender'),event);">
    <td width="296" height="25" bgcolor="#498CC2" class="TitleN2white">Calender</td>
    <td width="24" bgcolor="#498CC2" class="mouseover"><img onclick="closeWindow();" id="butClose" src="../../images/cross.png"/></td>
  </tr>
  <tr>
    <td colspan="2"><table width="75%" border="0">
      <tr>
        <td width="90%"><form id="frmCalender" method="post" action="calender.php">
          <table width="84%" height="216" border="0">

            <tr>
              <td height="17"><table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#D6E7F5">
                <tr>
                  <td width="29%" height="23" bgcolor="#CCCCCC"class="tablezRED"  style="text-align:center"><select name="cboMonth" class="txtbox" id="cboMonth" style="width:80px" onchange="loadCalenderData();">
				  <?php 
				  //$text=[];
				  $text[$intMonth] = "selected=\"selected\"";
				  echo $text[$intMonth];
				  ?>
                    <option <?php echo $text[1]; ?> value="1">January</option>
                    <option <?php echo $text[2]; ?> value="2">Febuary</option>
                    <option <?php echo $text[3]; ?> value="3">March</option>
                    <option <?php echo $text[4]; ?> value="4">April</option>
                    <option <?php echo $text[5]; ?> value="5">May</option>
                    <option <?php echo $text[6]; ?> value="6">June</option>
                    <option <?php echo $text[7]; ?> value="7">July</option>
                    <option <?php echo $text[8]; ?> value="8">August</option>
                    <option <?php echo $text[9]; ?> value="9">September</option>
                    <option <?php echo $text[10]; ?> value="10">Octomber</option>
                    <option <?php echo $text[11]; ?> value="11">November</option>
                    <option <?php echo $text[12]; ?> value="12">December</option>
					
                  </select></td>
                  <td width="29%" bgcolor="#CCCCCC"class="tablezRED"  style="text-align:center"><span class="tablezRED" style="text-align:center">
                    <select  onchange="loadCalenderData();" name="cboYear" class="txtbox" id="cboYear" style="width:80px">
					<?php
						for($i=2010;$i<=2020;$i++)
						{
							if($intYear==$i)
								echo "<option selected=\"selected\">$i</option>";
							else
								echo "<option>$i</option>";
						}
					?>
                    </select>
                  </span></td>
                  <td width="42%" bgcolor="#CCCCCC"class="tablezRED"  style="text-align:center"><span id="caption">August 2010 </span></td>
                </tr>
              </table></td>
            </tr>
            <tr>
              <td height="165"><table width="100%" height="180" border="0" cellpadding="0" cellspacing="0">
                <tr class="bcgl1">
                  <td width="100%"><table width="68%" height="188" border="0" bgcolor="#FFFFFF" class="bcgl1">
                    <tr>
                      <td height="182" colspan="3"><div id="myDiv" style="overflow:auto; height:210px; width:300px;">
                        <div align="center">
                          <table  border="1" bordercolor="#CCCCCC" cellpadding="1" cellspacing="1" height="167"  class="normalfnt" id="tblGLs"> 
                            <tr height="20">
                              <td width="40" class="bcgcolor-highlighted">Sun</td>
                              <td width="40" class="bcgcolor-highlighted">Mon</td>
                              <td width="40" class="bcgcolor-highlighted">Tue</td>  
                              <td width="40" class="bcgcolor-highlighted">Wed</td>
                              <td width="40" class="bcgcolor-highlighted">Thur</td>
                              <td width="40" class="bcgcolor-highlighted">Fri</td>
                              <td width="40" class="bcgcolor-highlighted">Sat</td>
                            </tr>
                            <tr>
                  <td height="30" class="mouseover" id="sun" onclick="showPop(this);"><div   id="box1" style="height:20px" align="center" ></div></td>
                  <td class="mouseover" onclick="showPop(this);"><div id="box2" style="height:20px" align="center" ></div></td>
                  <td class="mouseover" onclick="showPop(this);"><div id="box3" style="height:20px" align="center" ></div></td>
                  <td class="mouseover" onclick="showPop(this);"><div id="box4" style="height:20px" align="center" ></div></td>
                  <td class="mouseover" onclick="showPop(this);"><div id="box5" style="height:20px" align="center" ></div></td>
                  <td class="mouseover" onclick="showPop(this);"><div id="box6" style="height:20px" align="center" ></div></td>
                  <td class="mouseover" id="sat" onclick="showPop(this);" id="sat"><div id="box7" style="height:20px" align="center" ></div></td>
                  </tr>
                  <tr>
                  <td height="30" class="mouseover" id="sun" onclick="showPop(this);"><div id="box8" style="height:20px" align="center" ></div></td>
                  <td class="mouseover" onclick="showPop(this);"><div id="box9" style="height:20px" align="center" ></div></td>
                  <td class="mouseover" onclick="showPop(this);"><div id="box10" style="height:20px" align="center" ></div></td>
                  <td class="mouseover" onclick="showPop(this);"><div id="box11" style="height:20px" align="center" ></div></td>
                  <td class="mouseover" onclick="showPop(this);"><div id="box12" style="height:20px" align="center" ></div></td>
                  <td class="mouseover" onclick="showPop(this);"><div id="box13" style="height:20px" align="center" ></div></td>
                  <td class="mouseover" id="sat" onclick="showPop(this);" id="sat"><div id="box14" style="height:20px" align="center" ></div></td>
                  </tr> 
                  <tr>
                  <td height="30" class="mouseover" id="sun" onclick="showPop(this);"><div id="box15" style="height:20px" align="center" ></div></td>
                  <td class="mouseover"  onclick="showPop(this);"><div id="box16" style="height:20px" align="center" ></div></td>
                  <td class="mouseover" onclick="showPop(this);"><div id="box17" style="height:20px" align="center" ></div></td>
                  <td class="mouseover" onclick="showPop(this);"><div id="box18" style="height:20px" align="center" ></div></td>
                  <td class="mouseover" onclick="showPop(this);"><div id="box19" style="height:20px" align="center" ></div></td>
                  <td class="mouseover" onclick="showPop(this);"><div id="box20" style="height:20px" align="center" ></div></td>
                  <td class="mouseover" id="sat" onclick="showPop(this);" id="sat"><div id="box21" style="height:20px" align="center" ></div></td>
                  </tr>
                  <tr>
                  <td height="30" class="mouseover" id="sun" onclick="showPop(this);"><div id="box22" style="height:20px" align="center" ></div></td>
                  <td class="mouseover" onclick="showPop(this);"><div id="box23" style="height:20px" align="center" ></div></td>
                  <td class="mouseover"  onclick="showPop(this);"><div id="box24" style="height:20px" align="center" ></div></td>
                  <td class="mouseover"  onclick="showPop(this);"><div id="box25" style="height:20px" align="center" ></div></td>
                  <td class="mouseover"  onclick="showPop(this);"><div id="box26" style="height:20px" align="center" ></div></td>
                  <td class="mouseover"  onclick="showPop(this);"><div id="box27" style="height:20px" align="center" ></div></td>
                  <td class="mouseover" id="sat" onclick="showPop(this);" id="sat"><div id="box28" style="height:20px" align="center" ></div></td>
                  </tr>
                  <tr>
                  <td height="30" class="mouseover" id="sun" onclick="showPop(this);"><div id="box29" style="height:20px" align="center" ></div></td>
                  <td class="mouseover" onclick="showPop(this);"><div id="box30" style="height:20px" align="center" ></div></td>
                  <td class="mouseover"  onclick="showPop(this);"><div id="box31" style="height:20px" align="center" ></div></td>
                  <td class="mouseover"  onclick="showPop(this);"><div id="box32" style="height:20px" align="center" ></div></td>
                  <td class="mouseover"  onclick="showPop(this);"><div id="box33" style="height:20px" align="center" ></div></td>
                  <td class="mouseover"  onclick="showPop(this);"><div id="box34" style="height:20px" align="center" ></div></td>
                  <td class="mouseover" id="sat" onclick="showPop(this);" id="sat"><div id="box35" style="height:20px" align="center" ></div></td>
                  </tr>
			      <tr>
                  <td height="30" class="mouseover" id="sun" onclick="showPop(this);"><div id="box36" style="height:20px" align="center" ></div></td>
                  <td class="mouseover"  onclick="showPop(this);"><div id="box37" style="height:20px" align="center" ></div></td>
                  <td class="mouseover" onclick="showPop(this);"><div id="box38" style="height:20px" align="center" ></div></td>
                  <td class="mouseover"  onclick="showPop(this);"><div id="box39" style="height:20px" align="center" ></div></td>
                  <td class="mouseover" onclick="showPop(this);"><div id="box40" style="height:20px" align="center" ></div></td>
                  <td class="mouseover"  onclick="showPop(this);"><div id="box41" style="height:20px" align="center" ></div></td>
                  <td class="mouseover" id="sat" onclick="showPop(this);" id="sat"><div id="box42" style="height:20px" align="center" ></div></td>
                  </tr>
                  </table>
                  </div>
                  </div></td>
                  </tr>
                  </table></td>
                </tr>
                <tr class="bcgl1">
                  <td height="15" bgcolor="#D6E7F5"><table width="100%" border="0">
                    <tr>
                      <td width="8%" class="normalfntp2">&nbsp;</td>
                      <td width="61%" class="normalfntp2"></td>
                      <td width="29%" class="mouseover"><img id="butSave" src="../../images/save.png" alt="report" width="84" height="24" onclick="checkIfAssigened();" /><a href="../../main.php"></a></td>
                      <td width="2%">&nbsp;</td>
                    </tr>
                  </table></td>
                </tr>
              </table></td>
            </tr>
          </table>
        </form></td>
      </tr>
    </table>
  </tr>
  <tr>  </tr>
</table>

</body>
</html>
