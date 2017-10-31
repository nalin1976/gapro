<?php
 session_start();
include "../../Connector.php";
	$backwardseperator 	= "../../";
	//include "{$backwardseperator}Connector.php" ;	
	include "{$backwardseperator}authentication.inc";
	
	$userId	= $_GET["UserId"];
	$report_companyId  = $_SESSION["FactoryID"];
	$branchID = $_GET["branchID"];

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Branch Details Report</title>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.style4 {
	font-size: xx-large;
	color: #FF0000;
}
.style3 {
	font-size: xx-large;
	color: #FF0000;
}
-->

</style>
</head>
<body>
<table width="950" border="0" align="center" cellpadding="0">
  <tr>
    <td width="100%" colspan="3"><table width="100%" cellpadding="0" cellspacing="0">
      <tr>
        <td class="tophead"><table width="100%" cellpadding="0" cellspacing="0">
              <tr>
                <td width="100%"><?php include "../../reportHeader.php";?></td>

              </tr>
          </table></td>
      </tr>
    </table></td>
  </tr>
  
  <tr>
    <td colspan="5" class="normalfnt2bldBLACKmid">&nbsp;</td>
  </tr>
  
  <tr>
    <td colspan="5" style="text-align:center">

<?php

		$SQL="SELECT 
		branch.strBranchCode, 
		branch.strName, 
		branch.strAddress1, 
		country.strCountry, 
		bank.strBankCode, 
		branch.strPhone, 
		branch.strFax, 
		branch.strEMail, 
		branch.strContactPerson, 
		branch.strRemarks, 
		branch.strRefNo, 
		branch.strAccountNo, 
		branch.intStatus  
		FROM 
		branch 
		JOIN country
		ON branch.strCountry=country.intConID 
		JOIN bank 
		ON branch.intBankId=bank.intBankId 
		where branch.intBranchId='$branchID' AND branch.intStatus !='10'"; 
						 		   			    
        $result = $db->RunQuery($SQL);

		while($row = mysql_fetch_array($result))
		{	
		$strBranchCode    = cdata($row["strBranchCode"]);
		$strName          = cdata($row["strName"]);
		$strAddress1      = cdata($row["strAddress1"]);
		$strCountry       = cdata($row["strCountry"]);
		$strBank       	  = cdata($row["strBankCode"]);
		$strPhone         = cdata($row["strPhone"]);
		$strFax           = cdata($row["strFax"]);
		$strEMail         = cdata($row["strEMail"]);
		$strContactPerson = cdata($row["strContactPerson"]);
		$strRemarks       = cdata($row["strRemarks"]);
		$strRefNo         = cdata($row["strRefNo"]);
		$strAccountNo     = cdata($row["strAccountNo"]);
		$intStatus        = cdata($row["intStatus"]);
		if($intStatus == 1){
		$intStatus='Yes';
		}else{
		$intStatus='No';
		}
		}
		?>
<table width="100%" border='0' cellpadding="3" cellspacing="0" rules="all">
  
  <tr>
     <td colspan="2" class='border-Left-Top-right-fntsize12'><div class="normalfnt2bldBLACKmid">Branch Detail Report</div></td>
  </tr>
      <tr>
	  <td align="center" class='border-top-left-fntsize12' width="20%"><span class="normalfnt"><strong> Branch Code</strong></span></td>
	  <td class='border-Left-Top-right-fntsize12' width="80%"><span class="normalfnt"><?php echo $strBranchCode ?></span></td>
	  </tr>
	  
	  <tr>
	  <td align="center" class='border-top-left-fntsize12' ><span class="normalfnt"><strong> Branch Name</strong></span></td>
	  <td class='border-Left-Top-right-fntsize12' width="80%"><span class="normalfnt"><?php echo $strName?></span></td>
	  </tr>
	  
	  <tr>
	  <td align="center" class='border-top-left-fntsize12' ><span class="normalfnt"><strong> Address</strong></span></td>
	  <td class='border-Left-Top-right-fntsize12' width="80%"><span class="normalfnt"><?php echo $strAddress1?></span></td>
	  </tr>
	  
	  <tr>
	  <td align="center" class='border-top-left-fntsize12' ><span class="normalfnt"><strong> Bank Code</strong></span>  </td>
	  <td class='border-Left-Top-right-fntsize12' width="80%"><span class="normalfnt"><?php echo $strBank ?> </span></td>
	  </tr>
	  
	  <tr>
	  <td align="center" class='border-top-left-fntsize12' ><span class="normalfnt"><strong> Country</strong></span></td>
	  <td class='border-Left-Top-right-fntsize12' width="80%"><span class="normalfnt"><?php echo $strCountry ?> </span></td>
	  </tr>
	  
	  <tr>
	  <td align="center" class='border-top-left-fntsize12' ><span class="normalfnt"><strong> Phone</strong></span></td>
	  <td class='border-Left-Top-right-fntsize12' width="80%"><span class="normalfnt"> <?php echo $strPhone ?> </span></td>
	  </tr>
	  
	  <tr>
	  <td align="center" class='border-top-left-fntsize12' ><span class="normalfnt"><strong> Fax</strong></span></td>
      <td class='border-Left-Top-right-fntsize12' width="80%"><span class="normalfnt"><?php echo $strFax ?>  </span></td>
	  </tr>
	  
	  <tr>
	  <td align="center" class='border-top-left-fntsize12' ><span class="normalfnt"><strong> Email</strong></span></td>
	  <td class='border-Left-Top-right-fntsize12' width="80%"><span class="normalfnt"><?php echo $strEMail ?>  </span></td>
	  </tr>
	  
	  <tr>
	  <td align="center" class='border-top-left-fntsize12' ><span class="normalfnt"><strong> Contact Person</strong></span></td>
	  <td class='border-Left-Top-right-fntsize12' width="80%"><span class="normalfnt"> <?php echo $strContactPerson ?> </span></td>
	  </tr>
	  
	  <tr>
	  <td align="center" class='border-top-left-fntsize12' ><span class="normalfnt"><strong> Remarks</strong></span></td>
	  <td class='border-Left-Top-right-fntsize12' width="80%"><span class="normalfnt"><?php echo $strRemarks?>  </span></td>
	  </tr>
	  
	  <tr>
	  <td align="center" class='border-top-left-fntsize12' ><span class="normalfnt"><strong> Ref No</strong></span></td>
	  <td class='border-Left-Top-right-fntsize12' width="80%"><span class="normalfnt"><?php echo $strRefNo ?>  </span></td>
	  </tr>
	  <tr>
	    <td align="center" class='border-top-left-fntsize12' ><strong>Account No / Currency</strong> </td>
	    <td class='border-Left-Top-right-fntsize12'><table width="278" border="0" cellpadding="0" cellspacing="0">
<?php
$sql_branch="select BA.strAccountNo,CT.strCurrency from branch_accounts BA inner join currencytypes CT on CT.intCurID=BA.intCurrencyId where BA.intBranchId='$branchID'";
$result=$db->RunQuery($sql_branch);
while($row=mysql_fetch_array($result))
{
?>
          <tr height="15">
            <td width="146" class="normalfnt"><?php echo $row["strAccountNo"];?></td>
            <td width="77" class="normalfnt"><?php echo $row["strCurrency"];?></td>
          </tr>
<?php 
}
?>
        </table></td>
	    </tr>
	  
	  <tr>
	  <td align="center" class='border-top-left-fntsize12' ><span class="normalfnt"><strong> Active</strong></span></td>
	  <td class='border-Left-Top-right-fntsize12' width="80%"><span class="normalfnt"><?php echo $intStatus ?> </span></td>
	  </tr>
	  <tfoot>
   <tr>
     <td   colspan="2" class="border-top-fntsize12">&nbsp;</td>
   </tr></tfoot>
</table>
</td>
  </tr>
  </table>

  


</body>
</html>
