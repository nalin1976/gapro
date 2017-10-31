<?php 
session_start();
include "../../../Connector.php";
$xmldoc=simplexml_load_file('../../../config.xml');
$Company=$xmldoc->companySettings->Declarant;
$Address=$xmldoc->companySettings->Address;
$City=$xmldoc->companySettings->City;
$phone=$xmldoc->companySettings->phone;
$Fax=$xmldoc->companySettings->Fax;
$email=$xmldoc->companySettings->Email;
$Website=$xmldoc->companySettings->Website;
$Country=$xmldoc->companySettings->Country;

$dispatchNo=$_GET['dispatchNo'];

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<link href="../../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Dispatch Note Report</title>
</head>

<body>
<table width="100" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td class="normalfnt_size20" style="text-align:center" bgcolor="" height="10"></td>
  </tr>
  <tr>
    <td class="normalfntMid" height="18"></td>
  </tr>
  <tr>
    <td class="normalfntMid">&nbsp;</td>
  </tr>
  <tr>
    <td class="normalfnt2bldBLACKmid"><table width="100" border="0" cellspacing="0" cellpadding="0">
      <tr>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td ><table width="200%" border="0" cellspacing="0" cellpadding="3" class="normalfnt">
      <tr>
        <td width="93%" class="">
        <table width="808">
        	<tr>
            	<td width="293" rowspan="2"> <img align="right" src="../../../images/callogo.jpg" /></td>
            	<td width="503" height="30"><label class="normalfnth2B"><?php echo $Company;?></label><br /><br /><u>Manufacturers and Exporters of Quality Garments</u></td>
                
            </tr>
            <tr>
            	<td class="normalfntMid" height="20" style="text-align:left"><?php echo $Address." ".$City?><br /><?php echo "Tel ".$phone." Fax ".$Fax;?><br /><?php echo "E-mail: general@maliban.com";?></td>
            </tr>
        </table>
        </td>
      </tr>
	  
	  <tr>
        <td width="93%" class="">
        <table width="804">
		<tr>
			<td width="9">&nbsp;</td>
			<td width="775">&nbsp;</td>
			<td width="10">&nbsp;</td>
		</tr>
		<tr>
			<td width="9">&nbsp;</td>
			<td width="775">&nbsp;</td>
			<td width="10">&nbsp;</td>
		</tr>
		<tr>
			<td width="9">&nbsp;</td>
			<td width="775" align="center" class="normalfnt-center_size12"><b>&nbsp;Dispatch Note Report</b></td>
			<td width="10">&nbsp;</td>
		</tr>
		</table>
		</td>
	</tr>
	
	 
	  <tr>
        <td width="93%" class="">
        <table width="804" cols="4" class="tablez">
		<tr>
			<td width="168">&nbsp;</td>
			<td width="309" class="normalfnBLD1" height="25">&nbsp;Gate Pass No:&nbsp;<span class="normalfnt"><?php echo $dispatchNo; ?></span></td>
			<?php
				$sql="SELECT
						exportdispatchheader.dtmDate,
						forwaders.strName
						FROM
						exportdispatchheader
						INNER JOIN forwaders ON exportdispatchheader.intForwaderId = forwaders.intForwaderID
						WHERE intDispatchNo=$dispatchNo";
				$result=$db->RunQuery($sql);
				$row=mysql_fetch_array($result);
			 ?>
			<td width="287" class="normalfnBLD1">Forwader:&nbsp;<span class="normalfnt"><?php echo $row['strName']; ?></span></td>
			<td width="20">&nbsp;</td>
		</tr>
		<tr>
			<td width="168">&nbsp;</td>
			<td width="309" class="normalfnBLD1" height="25">&nbsp;Date:&nbsp;<span class="normalfnt"><?php echo $row['dtmDate']; ?></span></td>
			<td width="287">&nbsp;</td>
			<td width="20">&nbsp;</td>
		</tr>
		</table>
		
		</td>
	</tr>
	
	
	 <tr>
        <td width="93%">
        <table width="804" cols="5" class="tablez">
		<tr>
		<thead>
			<td width="127" class="normalfnBLD1" height="25" align="center">&nbsp;PL NO&nbsp;</td>
			<td width="143" class="normalfnBLD1" align="center">&nbsp;Style</td>
			<td width="149" class="normalfnBLD1" align="center">&nbsp;PO No</td>
			<td width="136" class="normalfnBLD1" align="center">&nbsp;Unit</td>
			<td width="156" class="normalfnBLD1" height="25" align="center">&nbsp;Gate Pass Qty</td>
		</thead>	
		</tr>
		<?php
			$sql="SELECT
exportdispatchdetail.strPLNo,
exportdispatchdetail.strStyleNo,
exportdispatchdetail.strOrderNo,
exportdispatchdetail.dblDispatchQty,
orderspec.dblUnit_Price,
orderspec.dblOrderQty
FROM
exportdispatchdetail
INNER JOIN orderspec ON orderspec.strOrder_No = exportdispatchdetail.strOrderNo
WHERE intDispatchNo=$dispatchNo
";
			$result=$db->RunQuery($sql);
			while($row=mysql_fetch_array($result))
			{	 
		?>
		<tr>
			<td width="127" class="normalfnBLD1" height="25" align="center">&nbsp;<?php echo $row['strPLNo']; ?>&nbsp;</td>
			<td width="143" class="normalfnBLD1" align="center">&nbsp;<?php echo $row['strStyleNo']; ?></td>
			<td width="149" class="normalfnBLD1" align="center">&nbsp;<?php echo $row['strOrderNo']; ?></td>
			<td width="136" class="normalfnBLD1" align="center">&nbsp;<?php echo $row['dblUnit_Price']; ?></td>
			<td width="156" class="normalfnBLD1" height="25" align="center">&nbsp;<?php echo $row['dblDispatchQty']; ?></td>
		</tr>
		<?php } ?>
		</table>
		
		</td>
	</tr>
	
	
	
	  
    </table></td>
  </tr>
      
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
 </table>
</body>
</html>
