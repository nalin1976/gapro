<?php
session_start();
$backwardseperator = "../../../";
include_once("${backwardseperator}authentication.inc");
include_once("${backwardseperator}Connector.php");
include_once("../class/class.washing_qc.php");
$wqcObj=new classWashingQC();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script src="../../../javascript/script.js" type="text/javascript"></script>
</head>
<body>
<table width="100%">
<tr>
	<td><?php include("${backwardseperator}Header.php");?></td>
</tr>
</table>
<form name="frmWetQc" id="frmWetQc" method="post" action="">
<table width="95%" align="center" class="main_border_line" border="0">
	<tr>
    	<td class="mainHeading" colspan="8">Hourly Inspection Entry</td>
    </tr>
    <tr>
    	<td class="normalfnt">Order No</td><td>
       	 <select>
         	<option value="">Select One</option>
            <?php 
				$res=$wqcObj->getPoNo(1);
				while($row=mysql_fetch_assoc($res)){
				echo "<option value=".$row['intStyleId'].">".$row['strOrderNo']."</option>";
				
			}?>
            
         </select>
        </td>
        <td class="normalfnt">Color</td><td><select></select></td>
        <td class="normalfnt">Sewing Factory</td><td colspan="3"><input type="text" /></td>
    </tr>
    <tr>
    	<td class="normalfnt">Eployee Name</td><td><select></select></td>
        <td class="normalfnt">EPF No</td><td><select></select></td>
        <td class="normalfnt">Shift</td><td><select></select></td>
        <td class="normalfnt">Date</td><td><input type="text" /></td>
    </tr>
    <tr>
    	<td class="normalfnt" width="100%" colspan="8">
        	<table width="100%">
            	<tr>
                	<td class="normalfnt" width="16%">Time</td>
                    <td rowspan="2" width="7%"><div>7-8</div></td>
                    <td rowspan="2" width="7%"><div>8-9</div></td>
                    <td rowspan="2" width="7%"><div>9-10</div></td>
                    <td rowspan="2" width="7%"><div>10-11</div></td>
                    <td rowspan="2" width="7%"><div>11-12</div></td>
                    <td rowspan="2" width="7%"><div>12-13</div></td>
                    <td rowspan="2" width="7%"><div>13-14</div></td>
                    <td rowspan="2" width="7%"><div>14-15</div></td>
                    <td rowspan="2" width="7%"><div>15-16</div></td>
                    <td rowspan="2" width="7%"><div>16-17</div></td>
                    <td rowspan="2" width="7%"><div>17-18</div></td>
                    <td rowspan="2" width="7%"><div>18-19</div></td>
                </tr>
                <tr>
                	<td class="normalfnt">Damages</td>
                </tr>
                <tr>
                	<td width="16%" class="normalfnt">&nbsp;</td>
                    <td width="7%"><input type="text" style="width:70px" onkeypress="return isValidZipCode(this.value,event);  "/></td>
                    <td width="7%"><input type="text" style="width:70px" onkeypress="return isValidZipCode(this.value,event);  "/></td>
                    <td width="7%"><input type="text" style="width:70px" onkeypress="return isValidZipCode(this.value,event);  "/></td>
                    <td width="7%"><input type="text" style="width:70px" onkeypress="return isValidZipCode(this.value,event);  "/></td>
                    <td width="7%"><input type="text" style="width:70px" onkeypress="return isValidZipCode(this.value,event);  "/></td>
                    <td width="7%"><input type="text" style="width:70px" onkeypress="return isValidZipCode(this.value,event);  "/></td>
                    <td width="7%"><input type="text" style="width:70px" onkeypress="return isValidZipCode(this.value,event);  "/></td>
                    <td width="7%"><input type="text" style="width:70px" onkeypress="return isValidZipCode(this.value,event);  "/></td>
                    <td width="7%"><input type="text" style="width:70px" onkeypress="return isValidZipCode(this.value,event);  "/></td>
                    <td width="7%"><input type="text" style="width:70px" onkeypress="return isValidZipCode(this.value,event);  "/></td>
                    <td width="7%"><input type="text" style="width:70px" onkeypress="return isValidZipCode(this.value,event);  "/></td>
                    <td width="7%"><input type="text" style="width:70px" onkeypress="return isValidZipCode(this.value,event);  "/></td>
                </tr>
                <tr>
                	<td>&nbsp;</td>
                	<td colspan="2">&nbsp;</td>
                    <td>&nbsp;</td>
                    <td colspan="2">&nbsp;</td>
                    <td></td>
                    <td colspan="2"></td>
                    <td></td>
                    <td colspan="2"></td>
                    <td></td>
                </tr>
                <tr>
                	<td>&nbsp;</td>
                	<td colspan="2" class="normalfnt">Inspected By</td>
                    <td>&nbsp;</td>
                    <td colspan="2" class="normalfnt">QA-Charge</td>
                    <td></td>
                    <td colspan="2" class="normalfnt">Prod/Shif Manager</td>
                    <td></td>
                    <td colspan="2" class="normalfnt">AQAM/QAM</td>
                    <td></td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</form>
</body>
</html>