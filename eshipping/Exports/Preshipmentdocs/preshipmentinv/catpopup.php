<?php
$backwardseperator = "../../../";
session_start();
//include("../../Connector.php");
//$backwardseperator = "../../";
include "$backwardseperator".''."Connector.php";


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script type="text/javascript" src="../../../js/jquery-1.3.2.min.js"></script>
<script type="text/javascript" src="../../../js/jquery-1.4.4.min.js"></script>
<script type="text/javascript" src="../../../js/jquery-ui-1.7.2.custom.min.js"></script>
<script type="text/javascript" src="../../../js/jquery-ui-1.8.9.custom.min.js"></script>
<script type="text/javascript" src="../../../javascript/script.js"></script>
<link type="text/css" href="../../../css/ui-lightness/jquery-ui-1.7.2.custom.css" rel="stylesheet" />
<script type="text/javascript" src="Commercialinvoice.js"></script>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Cat No</title>
<link href="../../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="../../../javascript/calendar/theme.css" />
</head>

<body>
<table width="870"  border="0" align="center" bgcolor="#FFFFFF">
<tr>
<tr> 
    	<td colspan="3" bgcolor="#316895" class="TitleN2white" style="text-align:right"><span class="normalfnt" style="text-align:right"><span class="TitleN2white" style="text-align:right"><span class="normalfnt" style="text-align:right"><img src="../../../images/cross.png" width="31" height="25" id="Close" onclick="closeWindow();" class="mouseover" /></span></span></span></td>
        
  </tr>
  <tr> 
    	<td colspan="3" bgcolor="#316895" class="TitleN2white" style="text-align:center">Shipment forecast</td>
        
  </tr>
   
    <tr>
    <td  class="normalfnt" width="100" style="text-align:center"> Select Buyer</td>
    						<td style="text-align:left"><select name="cboBuyer" style="width:200px"  id="cboBuyer" class="txtbox" onchange="loadGrid();">
					  <option value="0"></option>
                     <?php
							echo $sql="SELECT
							shipmentforecast_detail.strBuyer
							FROM
							shipmentforecast_detail
							GROUP BY
							shipmentforecast_detail.strBuyer;";
							$result=$db->RunQuery($sql);
							while($row=mysql_fetch_array($result))
							{
							?>
					  <option value="<?php echo $row['strBuyer']; ?>"> <?php echo $row['strBuyer']; ?></option>
					  <?php
							}
							?>
					 
				    </select>
				    </td>
                    <td><img src="../../../images/add_alone.png" width="78" height="20" onclick="loadPre();" /></td>
    </tr>
    <tr>
     <td colspan="3">
	  <div align="center" style="width:850px; height:200px; overflow: scroll; height: 250px; width: 900px; margin-top:5px;">
				  <table align="center" width="900px" bgcolor="#CCCCFF" id="tblForcast" cellpadding="0" cellspacing="1" border="0">
						<thead>
							<tr  bgcolor="#498CC2" class="normaltxtmidb2">
                                <td width="42">Select</td>
                                <td width="35">SC No</td>
                                <td width="37">Style No</td>
                                <td width="42">Buyer PO No</td>
                                <td width="74">Description</td>
                                <td width="84">Fabric Composition </td>
                                <td width="58">Country </td>
                                <td width="59">Season</td>
                                <td width="42">Price</td>
                                <td width="60">Del Date</td>
                                <td width="62">Factory</td>
                                <td width="88">NOF CTN </td>
                                <td width="39">QTY</td>
                                <td width="55">Net WT</td>
                                <td width="50">GRS WT</td>
							</tr>
						</thead>
						<tbody>
						</tbody>
				  </table>
				  
    </div>
</td>
        
      </tr>
    </table></td>
  </tr>
  </table>
</body>
</html>
