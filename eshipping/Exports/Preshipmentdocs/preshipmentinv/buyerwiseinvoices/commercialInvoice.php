<?php 
session_start();
include "../../../../Connector.php";
$xmldoc=simplexml_load_file('../../../../config.xml');
include "common_report.php";
$Company=$xmldoc->companySettings->Declarant;
$Address=$xmldoc->companySettings->Address;
$City=$xmldoc->companySettings->City;
$phone=$xmldoc->companySettings->phone;
$Fax=$xmldoc->companySettings->Fax;
$email=$xmldoc->companySettings->Email;
$Website=$xmldoc->companySettings->Website;
$Country=$xmldoc->companySettings->Country;

$invoiceNo=$_GET['InvoiceNo'];
include "invoice_queries.php";
$type=($_GET['type']==""? "FOB":$_GET['type']);
	 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<link href="../../../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>PRE-INVOICE</title>
</head>

<body>
<table width="900" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td class="normalfnt_size20" style="text-align:center" bgcolor="" height="10"></td>
  </tr>
  <tr>
    <td class="normalfnt2bldBLACKmid"><table width="100" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="20%">&nbsp;</td>
        <td width="60%" style="text-align:center"></td>
        <td width="20%"></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td ><table width="900%" border="0" cellspacing="0" cellpadding="0" class="normalfnt">
      <tr>
        <td colspan="3" rowspan="6" class="">
        <table width="420">
        	<tr>
            	<td width="107" rowspan="2"> <img src="../../../../images/callogo.jpg" /></td>
            	<td width="301" height="30"><label class="normalfnth2B"><?php echo $Company;?></label><br /><br /><u>Manufacturers and Exporters of Quality Garments</u></td>
                
            </tr>
            <tr>
            	<td class="normalfntMid" height="20" style="text-align:left"><?php echo $Address." ".$City?><br /><?php echo "Tel ".$phone." Fax ".$Fax;?><br /><?php echo "E-mail: general@maliban.com";?></td>
            </tr>
        </table>
        </td>
        <td class="normalfnth2B border-top-left-fntsize12">Invoice No. and Date</td>
        <td colspan="2" class="normalfnth2B border-top-right">&nbsp;</td>
      </tr>
      <tr>
        <td class="border-left"><?PHP echo $invoiceNo; ?></td>
        <td colspan="2" class="border-right"><span style="text-align:center">
          <?PHP  echo $dateVariable; ?>
        </span></td>
        </tr>
      <tr>
        <td class="normalfnth2B border-Left-Top-right">Seller's/Shipper's Ref.</td>
        <td colspan="2" class="normalfnth2B border-top-right">Buyer's Ref.</td>
        </tr>
      <tr>
        <td class="border-left border-right"><?php echo $customerLocationCode; ?></td>
        <td colspan="2" class="normalfnth2B  border-right">&nbsp;</td>
        </tr>
      <tr>
        <td width="27%" class="normalfnth2B border-top-left-fntsize12">FCR/BL/Awb No. and Date</td>
        <td colspan="2" class="normalfnth2B border-top-right">&nbsp;</td>
        </tr>
      <tr>
        <td class=" border-left">&nbsp;
        <?php 
		
			if($BL!="")
			{
				echo $BL."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$dateVariable;
			}
			else if($HAWB)
			{
				echo $HAWB."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$dateVariable;
			}
			else if($FCR)
			{
				echo $FCR."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$dateVariable;
			}
		
		?>
        
        </td>
        <td colspan="2" class="border-right">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="3" class="normalfnth2B border-top-left">Consignee</td>
        <td colspan="3" class="normalfnth2B border-Left-Top-right">Buyer (If not Consignee)</td>
      </tr>
      <tr>
        <td colspan="3" class="border-top-left">
        <br />
        &nbsp;<?php echo $BuyerName; ?><br />
        &nbsp;<?php echo $BuyerAddress1; ?><br />
        &nbsp;<?php echo $BuyerAddress2; ?><br />
        &nbsp;<?php echo $BuyerCountry; ?><br /><br />
        </td>
        <td colspan="3" class="border-Left-Top-right">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="3" class="border-top-left"><span class="normalfnth2B">Notify</span></td>
        <td colspan="3" class="normalfnth2B border-Left-Top-right">Terms of Delivery and Payment</td>
      </tr>
      <tr>
        <td colspan="3" class="border-top-left">
        <br />
        &nbsp;<?php echo $BrokerName; ?><br />
        &nbsp;<?php echo $BrokerAddress1; ?><br />
        &nbsp;<?php echo $BrokerAddress2; ?><br />
        &nbsp;<?php echo $BrokerCountry; ?><br /><br />
       
          </td>
        <td colspan="3" class="border-Left-Top-right" style="text-align:center"><?php echo $Incoterms; ?></td>
        </tr>
      <tr>
        <td width="30%" class="border-top-left"><span class="normalfnth2B ">Mode</span></td>
        <td colspan="2" class="border-top-left"><span class="normalfnth2B">Port of Loading</span></td>
        <td class="border-top-left">&nbsp;</td>
        <td colspan="2" class="border-top-right">&nbsp;</td>
        </tr>
      <tr>
        <td class="border-top-left"><?php echo $TransportMode; ?></td>
        <td colspan="2" class="border-top-left"><?php echo $PortOfLoading; ?></td>
        <td class="border-left">&nbsp;</td>
        <td colspan="2" class="border-right">&nbsp;</td>
      </tr>
      <tr>
        <td class="normalfnth2B border-top-left">Port of Discharge</td>
        <td colspan="2" class="normalfnth2B border-top-left">Final Destination</td>
        <td class="border-left">&nbsp;</td>
        <td colspan="2" class="border-right">&nbsp;</td>
      </tr>
      <tr>
        <td class="border-bottom-left border-top"><?php echo $Destinationcity; ?></td>
        <td colspan="2" class="border-top-left border-bottom"><?php echo $Destinationport; ?></td>
        <td class="border-left border-bottom">&nbsp;</td>
        <td colspan="2" class="border-bottom border-right" >&nbsp;</td>
        </tr>
      
      <tr>
        <td colspan="6" class="border-left">
         <table width="100%" border="0" cellspacing="0" cellpadding="0" class="normalfnt">
         	<tr>
            	<td class="normalfnth2B border-bottom-right" style="text-align:center">Container/Seal Nos : Shipping Marks</td>
                <td class="normalfnth2B border-bottom-right" style="text-align:center">No. and Kind of Packages; Description of Goods</td>
                <td class="normalfnth2B border-bottom-right" style="text-align:center">Category</td>
                <td class="normalfnth2B border-bottom-right" style="text-align:center">Quantity (Units)</td>
                <td class="normalfnth2B border-bottom-right" style="text-align:center">Unit Price (USD)</td>
                <td class="normalfnth2B border-bottom-right" style="text-align:center">Amount (USD)</td>
            </tr>
            <tr>
            	<td class="" style="text-align:left">
                <br />
                &nbsp;<?php echo $mainmark1; ?><br />
				&nbsp;<?php echo $mainmark2; ?><br />
                &nbsp;<?php echo $mainmark3; ?><br />
                &nbsp;<?php echo $mainmark4; ?><br />
                &nbsp;<?php echo $mainmark5; ?><br />
                &nbsp;<?php echo $mainmark6; ?><br />
                &nbsp;<?php echo $mainmark7; ?><br />
                &nbsp;<?php echo $sidemark1; ?><br />
                &nbsp;<?php echo $sidemark2; ?><br />
                &nbsp;<?php echo $sidemark3; ?><br />
                &nbsp;<?php echo $sidemark4; ?><br />
                &nbsp;<?php echo $sidemark5; ?><br />
                &nbsp;<?php echo $sidemark6; ?><br />
                &nbsp;<?php echo $sidemark7; ?><br />
                </td>
                <td class="" style="text-align:left; vertical-align:text-top">
                &nbsp;<u>WEARING APPARELS</u>
                <br /><br />
                &nbsp;<?php  echo $r_summary->summary_sum($invoiceNo,'intNoOfCTns');?>&nbsp;&nbsp;Cartons Containing
                <br /><br />
                 &nbsp;<?php echo $r_summary->summary_sum($invoiceNo,'dblQuantity'); ?>&nbsp;<?php echo $r_summary->summary_string($invoiceNo,'strUnitID'); ?>&nbsp;of&nbsp;<?php echo $r_summary->summary_string($invoiceNo,'strDescOfGoods'); ?>
                 <br /><br />
                 &nbsp;Style No : <?php echo $r_summary->summary_string($invoiceNo,'strStyleID'); ?>
        		 <br /><br />
        		 &nbsp;Order No : <?php echo $r_summary->summary_string($invoiceNo,'strBuyerPONo'); ?>
                </td>
                <td class="" style="text-align:center"></td>
                <td class="" style="text-align:center; vertical-align:text-top;">
                <table width="100%" border="0" cellspacing="0" cellpadding="0" class="normalfnt">
                <tr>
                <td style="border-bottom-style:double; text-align:center">
                <br />
                <?php
					$sumQty = 0;
					while($row = mysql_fetch_assoc($result_Detail_Sum))
					{
						
						echo $row["dblQuantity"]." ".$row["strUnitID"]."<br />";
						$sumQty+=$row["dblQuantity"];
					}
				?>
                ______________<br />
                <br />
                <?php echo $sumQty; ?>
                <br />
                <br />
                </td>
                </tr>
                <tr>
                <td style="text-align:center">
                <br />
                	<?php
							
					echo $r_summary->roundup($sumQty,12);		
					
					
					?>
                </td>
                </tr> 
                </table>               
                </td>
                <td class="" style="text-align:center; vertical-align:text-top">
                <table width="100%" border="0" cellspacing="0" cellpadding="0" class="normalfnt">
                <tr>
                <td style="text-align:center">
               <br />
                <?php
					$sumUP = 0;
					$result_Detail_Sum = $db->RunQuery($str_Detail_Sum);
					while($row = mysql_fetch_assoc($result_Detail_Sum))
					{
						
						echo $row["dblUnitPrice"]."<br />";
						$sumUP+=$row["dblUnitPrice"];
					}
				?>
               
                <br />
                
                <br />
                <br />
                </td></tr></table>
                </td>
                <td class="border-right" style="text-align:center; vertical-align:text-top">
                <table width="100%" border="0" cellspacing="0" cellpadding="0" class="normalfnt">
                <tr>
                <td style="border-bottom-style:double; text-align:center">
                <br />
                <?php
					$sumAMT = 0;
					$result_Detail_Sum = $db->RunQuery($str_Detail_Sum);
					while($row = mysql_fetch_assoc($result_Detail_Sum))
					{
						
						echo $row["dblAmount"]."<br />";
						$sumAMT+=$row["dblAmount"];
					}
				?>
                ______________<br />
                <br />
                <?php echo $sumAMT; ?>
                <br />
                <br />
                </td></tr></table>
                </td>
            </tr>
         
         </table>
        </td>
        </tr>
      
    </table></td>
  </tr>
  <tr>
    <td class="border-top">&nbsp;</td>
  </tr>
 </table>
</body>
</html>
