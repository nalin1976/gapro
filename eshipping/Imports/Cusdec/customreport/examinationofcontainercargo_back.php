<?php
	session_start();
	include("../../../Connector.php");
	$deliveryNo	= $_GET["deliveryNo"];
	$companyID	= $_SESSION["FactoryID"];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>eShipping Web - Examination Of Container Cargo_Back :: Report</title>
<link href="../../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.reporttitle {
	font-family: Times New Roman;
	font-size: 25pt;
	font-weight: bold;
	color: #000000;
	margin: 0px;
	text-align: center;
	letter-spacing:normal;
	word-spacing:normal;
}
.reportsubtitle {
	font-family: Times New Roman;
	font-size: 22pt;
	font-weight: bold;
	color: #000000;
	margin: 0px;
	text-align: center;
	word-spacing:10px;
}
.font-Size12_family-times{	
			font-family:Times New Roman;
			font-size:20px;
			color:#000000;
			margin:0px;
			font-weight: normal;
			text-align:justify;
			letter-spacing:normal;
			word-spacing:6px;		
}

-->
</style>
</head>

<body style="margin-top:80px">

<table  width="979"  align="center">

  <tr>
    <td width="42" rowspan="3">&nbsp;</td>
    <td width="891"><table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td colspan="5"><table width="100%" height="245" border="0" cellpadding="0" cellspacing="0" class="outline">
		  <tr height="10">
            <td width="2%"  >&nbsp;</td>
            <td colspan="3"  >&nbsp;</td>
            <td width="16%"  >&nbsp;</td>
            <td width="6%"  >&nbsp;</td>
            <td width="24%" >&nbsp;</td>
            <td width="3%" >&nbsp;</td>
          </tr>
          <tr height="10">
            <td width="2%"  >&nbsp;</td>
            <td colspan="3" class="font-Size12_family-times" >ENDOSEMENT OF THE A.S.C. (L/W) </td>
            <td width="16%"  >&nbsp;</td>
            <td width="6%" class="font-Size12_family-times" >W/H</td>
            <td width="24%" class="normalfntTAB2" >&nbsp;</td>
            <td width="3%" >&nbsp;</td>
          </tr>
          <tr>
            <td >&nbsp;</td>
            <td width="21%" >&nbsp;</td>
            <td width="17%" >&nbsp;</td>
            <td width="11%" >&nbsp;</td>
            <td >&nbsp;</td>
            <td >&nbsp;</td>
            <td >&nbsp;</td>
            <td >&nbsp;</td>
          </tr>
          <tr>
            <td >&nbsp;</td>
            <td class="font-Size12_family-times">Custom's Pass No : </td>
            <td >&nbsp;</td>
            <td >&nbsp;</td>
            <td >&nbsp;</td>
            <td >&nbsp;</td>
            <td >&nbsp;</td>
            <td >&nbsp;</td>
          </tr>
		  <tr height="5">
            <td >&nbsp;</td>
            <td>&nbsp;</td>
            <td >&nbsp;</td>
            <td >&nbsp;</td>
            <td >&nbsp;</td>
            <td >&nbsp;</td>
            <td >&nbsp;</td>
            <td >&nbsp;</td>
          </tr>
          <tr>
            <td height="33" >&nbsp;</td>
            <td class="font-Size12_family-times">SLPA Pass No : </td>
            <td >&nbsp;</td>
            <td >&nbsp;</td>
            <td >&nbsp;</td>
            <td >&nbsp;</td>
            <td >&nbsp;</td>
            <td >&nbsp;</td>
          </tr>
          <tr>
            <td >&nbsp;</td>
            <td >&nbsp;</td>
            <td >&nbsp;</td>
            <td >&nbsp;</td>
            <td >&nbsp;</td>
            <td >&nbsp;</td>
            <td >&nbsp;</td>
            <td >&nbsp;</td>
          </tr>
          <tr>
            <td >&nbsp;</td>
            <td >&nbsp;</td>
            <td class="normalfntTAB2">&nbsp;</td>
            <td >&nbsp;</td>
            <td class="normalfntTAB2">&nbsp;</td>
            <td >&nbsp;</td>
            <td class="normalfntTAB2">&nbsp;</td>
            <td >&nbsp;</td>
          </tr>
          <tr>
            <td >&nbsp;</td>
            <td >&nbsp;</td>
            <td class="font-Size12_family-times" style="text-align:center">Date</td>
            <td >&nbsp;</td>
            <td class="font-Size12_family-times" style="text-align:center">Time</td>
            <td >&nbsp;</td>
            <td class="font-Size12_family-times" style="text-align:center">LW's Signature </td>
            <td >&nbsp;</td>
          </tr>
          <tr>
            <td >&nbsp;</td>
            <td >&nbsp;</td>
            <td class="font-Size12_family-times" style="text-align:center">&nbsp;</td>
            <td >&nbsp;</td>
            <td class="font-Size12_family-times" style="text-align:center">&nbsp;</td>
            <td >&nbsp;</td>
            <td class="font-Size12_family-times" style="text-align:center">&nbsp;</td>
            <td >&nbsp;</td>
          </tr>
        </table></td>        
      </tr>
	  	<tr> 
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td> 
		</tr>
		<tr> 
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td> 
		</tr>
      <tr>
        <td colspan="5"><table width="100%" height="215" border="0" cellpadding="0" cellspacing="0" class="outline">
		<tr>
            <td width="2%" >&nbsp;</td>
            <td colspan="4"  >&nbsp;</td>
            <td width="5%" >&nbsp;</td>
            <td width="25%" >&nbsp;</td>
            <td width="3%" >&nbsp;</td>
          </tr>
		  
          <tr>
            <td width="2%" >&nbsp;</td>
            <td colspan="4" class="font-Size12_family-times" >ENDOSEMENT OF THE APO AT THE EXIT GATE</td>
            <td width="5%" >&nbsp;</td>
            <td width="25%" >&nbsp;</td>
            <td width="3%" >&nbsp;</td>
          </tr>
          <tr>
            <td >&nbsp;</td>
            <td width="20%" >&nbsp;</td>
            <td width="19%" >&nbsp;</td>
            <td width="9%">&nbsp;</td>
            <td width="17%">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td class="font-Size12_family-times">Custom's Seal No </td>
            <td class="normalfntTAB2">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td >&nbsp;</td>
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
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td >&nbsp;</td>
            <td class="normalfntTAB2">&nbsp;</td>
            <td >&nbsp;</td>
            <td class="normalfntTAB2">&nbsp;</td>
            <td >&nbsp;</td>
            <td class="normalfntTAB2">&nbsp;</td>
            <td >&nbsp;</td>
          </tr>
          <tr>
            <td >&nbsp;</td>
            <td >&nbsp;</td>
            <td class="font-Size12_family-times" style="text-align:center">Date</td>
            <td >&nbsp;</td>
            <td class="font-Size12_family-times" style="text-align:center">Time</td>
            <td >&nbsp;</td>
            <td class="font-Size12_family-times" style="text-align:center">APO's Signature </td>
            <td >&nbsp;</td>
          </tr>
          <tr>
            <td >&nbsp;</td>
            <td >&nbsp;</td>
            <td class="font-Size12_family-times" style="text-align:center">&nbsp;</td>
            <td >&nbsp;</td>
            <td class="font-Size12_family-times" style="text-align:center">&nbsp;</td>
            <td >&nbsp;</td>
            <td class="font-Size12_family-times" style="text-align:center">&nbsp;</td>
            <td >&nbsp;</td>
          </tr>
        </table></td>
      </tr>
	  

      <tr>
        <td width="22%" height="8">&nbsp;</td>
        <td class="normalfnt_size10">&nbsp;</td>
        <td class="normalfnt_size10">&nbsp;</td>
        <td class="normalfnt_size10">&nbsp;</td>
        <td class="normalfnt_size10">&nbsp;</td>
      </tr>
      <tr>
        <td height="16" colspan="5" class="font-Size12_family-times"><table width="100%" height="286" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td width="27%" class="reportsubtitle" style="text-align:center">REPORT OF THE EXAMINATION PANAL </td>
            </tr>
			<tr>
            <td width="27%">&nbsp;</td>
            </tr>
          <tr>
            <td>In order,goods released </td>
            </tr>
			  <tr>
            <td>&nbsp;</td>
            </tr>
          <tr>
            <td height="31">Not in order,following discrepancies were noted and the importer was instructed to hold the </td>
            </tr>
          <tr>
            <td>goods , if not in order , please submit the report to DC. (CCED) / DDC (PEU) immediatly. </td>
            </tr>
          <tr>
            <td>&nbsp;</td>
            </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="3%">&nbsp;</td>
                <td width="37%" class="normalfntTAB2" style="text-align:center">&nbsp;</td>
                <td width="18%">&nbsp;</td>
                <td width="37%" class="normalfntTAB2" style="text-align:center">&nbsp;</td>
                <td width="5%">&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td style="text-align:center">Supervising Officer </td>
                <td>&nbsp;</td>
                <td style="text-align:center">Appraiser</td>
                <td>&nbsp;</td>
              </tr>
            </table></td>
          </tr>
        </table></td>
        </tr>
      <tr>
        <td >&nbsp;</td>
        <td colspan="4" >&nbsp;</td>
      </tr>
	   <tr>
        <td >&nbsp;</td>
        <td colspan="4" >&nbsp;</td>
      </tr>
	   <tr>
	     <td >&nbsp;</td>
	     <td colspan="4" >&nbsp;</td>
        </tr>
	   <tr>
	     <td >&nbsp;</td>
	     <td colspan="4" >&nbsp;</td>
        </tr>
	   <tr>
	     <td colspan="5" class="font-Size12_family-times" ><table width="100%" height="147" border="0" cellpadding="0" cellspacing="0">
           <tr>
             <td height="36">Please return the Examination Report together with connected documents on the following day </td>
           </tr>
           <tr>
             <td>to D.D.C.(PEU) </td>
           </tr>
		    <tr>
             <td>&nbsp;</td>
           </tr>
           <tr>
             <td>Kindly make note to inform DDC (PEU) / SC (PEU) change of duty place giving telephone </td>
           </tr>
           <tr>
             <td>number etc. </td>
           </tr>
         </table></td>
        </tr>
    </table>    </td>
    <td rowspan="3" width="42">&nbsp;</td>
  </tr>

 
</table>

</body>
</html>

</table>

</body>
</html>
