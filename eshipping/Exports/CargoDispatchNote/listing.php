<?php
$backwardseperator = "../../";
session_start();
/*$str="select 
	ih.strBuyerID as consigneeid, 
	ih.strCompanyID as exporterid, 
	ih.strNotifyID1 as NotifyID, 
	cdn.strCDNNo, 
	cdn.strInvoiceNo, 
	cdn.strCarrier,
	ih.strGenDesc, 
	ih.strVoyegeNo, 
	cdn.dtmSailingDate, 
	cdn.strPortOfDischarge, 
	cdn.strExVesel, 
	cdn.strPlaceOfDelivery, 
	cdn.strAuthorisedS, 
	cdn.strDescriptionOfGoods as cdndesc, 
	cdn.dblGrossWt, 
	cdn.dblNetWt, 
	cdn.dblCBM, 
	cdn.strLorryNo, 
	cdn.strBLNo, 
	cdn.dblTareWt, 
	cdn.strSealNo, 
	cdn.strDriverName, 
	cdn.strCleanerName, 
	cdn.strOthres, 
	cdn.strDeclarentName, 
	cdn.strCustomerEntry, 
	cdn.strMarks, 
	cdn.dblHieght, 
	cdn.dblLength, 
	cdn.strType, 
	cdn.dblTemperature, 
	cdn.strDelivery, 
	cdn.strReciept, 
	cdn.strRemarks, 
	cdn.strUserId, 
	cdn.dtmCreateDate, 
	cdn.strVSLOPRCode, 
	cdn.strCNTOPRCode
	from 
	cdn cdn
	inner join invoiceheader ih on ih.strInvoiceNo=cdn.strInvoiceNo
	where cdn.strInvoiceNo='001'";
$result=$db->RunQuery($str);
$row=mysql_fetch_array($result);*/
											$consigneeid=$row["consigneeid"];
											$exporterid=$row["exporterid"];
											$NotifyID=$row["NotifyID"];
											$CustomEntryNo=$row["strCustomEntryNo"];
											$BLNo=$row["strBLNo"];
											$ShippingLineName=$row["strShippingLineName"];
											$PlcOfAcceptence=$row["strPlcOfAcceptence"];
											$PlaceOfDelivery=$row["strPlaceOfDelivery"];
											$SLPANo=$row["strSLPANo"];
											$VoyageNo=$row["strVoyageNo"];
											$WarehouseNo=$row["strWarehouseNo"];
											$Carrier=$row["strCarrier"];
											$PortOfDischarge=$row["strPortOfDischarge"];
											$VslOprCode=$row["strVslOprCode"];
											$CtnOprCode=$row["strCtnOprCode"];
											$MarksNo=$row["strMarksNo"];
											$DescriptionOfGoods=$row["strDescriptionOfGoods"];
											$GrossWt=$row["dblGrossWt"];
											$NetWt=$row["dblNetWt"];
											$CBM=$row["dblCBM"];
											$consigneeid=$row["consigneeid"];
											
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Banks</title>
<style type="text/css">
<!--
body {
	background-color: #CCCCCC;
}
-->
</style>

<script src="button.js"></script>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />

</head>

<body>


<form id="frmBanks" name="form1" method="POST" action="">
<table width="950" border="0" align="center" bgcolor="#FFFFFF">
  <tr>
    <td><?php include '../../Header.php'; ?></td>
  </tr>
  <tr>
    <td><table width="100%" border="0">
      <tr>
        <td width="19%">&nbsp;</td>
        <td width="62%"><table width="100%" border="0">
          <tr>
            <td height="30" bgcolor="#588DE7" class="TitleN2white">Cargo Dispatch Note </td>
          </tr>
          <tr>
            <td height="96">
              <table width="100%" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="100%" class="normalfnt"><table width="100%" border="0" class="bcgl1">
                    <tr>
                      <td class="normalfnt"><table width="100%" border="0" cellpadding="1" cellspacing="1" class="bcgl1">
                        <tr>
                          <td width="1%">&nbsp;</td>
                          <td colspan="2">Marks No Of Packages </td>
                          <td width="7%">&nbsp;</td>
                          <td colspan="2">Item Description </td>
                          </tr>
                        <tr>
                          <td>&nbsp;</td>
                          <td colspan="2" rowspan="12"><label for="textarea"></label>
                            <textarea name="textarea" cols="30" rows="20" id="textarea"></textarea></td>
                          <td>&nbsp;</td>
                          <td colspan="2" rowspan="12"><textarea name="textarea2" cols="30" rows="20" id="textarea2"></textarea></td>
                          </tr>
                        <tr>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          </tr>
                        <tr>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          </tr>
                        <tr>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          </tr>
                        <tr>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          </tr>
                        <tr>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          </tr>
                        <tr>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          </tr>
                        <tr>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          </tr>
                        <tr>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          </tr>
                        <tr>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          </tr>
                        <tr>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          </tr>
                        <tr>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          </tr>
                        <tr>
                          <td>&nbsp;</td>
                          <td width="10%">&nbsp;</td>
                          <td width="31%">&nbsp;</td>
                          <td>&nbsp;</td>
                          <td width="21%">&nbsp;</td>
                          <td width="30%">&nbsp;</td>
                        </tr>
                      </table></td>
                      </tr>
                    <tr class="bcgl1">
                      <td class="normalfnt">&nbsp;</td>
                      </tr>
                  </table></td>
                  </tr>
              </table>
            </td>
          </tr>
          <tr>
            <td height="34"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="bcgl1">
              <tr bgcolor="#d6e7f5">
                <td width="100%"><table width="100%" border="0" cellspacing="0">
                    <tr bgcolor="#d6e7f5">
                      <td width="21%">&nbsp;</td>
                      <td width="19"><img src="../../images/new.png" alt="New" width="100" height="24" name="New"onclick="ClearForm();"/></td>
                      <td width="21"><img src="../../images/save.png" alt="Save" width="84" height="24" name="Save" onclick="butCommand(this.name)"/></td>
                      <td width="21"><img src="../../images/delete.png" alt="Delete" width="100" height="24" name="Delete"onclick="ConfirmDelete(this.name);"/></td>
                      <td width="18%"><a href="../../main.php"><img src="../../images/close.png" alt="Close" name="Close" width="97" height="24" border="0"/></a></td>
                      <td width="21%">&nbsp;</td>
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
