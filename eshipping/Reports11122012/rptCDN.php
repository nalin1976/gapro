<?php
	session_start();
	include("../../../Connector.php");
	/*$invoiceNo	= $_GET["invoiceNo"];
	$cusdectype=$_GET["cusdectype"];
	$companyID	= $_SESSION["FactoryID"];
	$pub_EicAmount	= 0;*/
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>eShipping Web - Export CDN :: Report</title>
<link href="../css/erpstyle.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="613" height="40" border="0" cellpadding="0" cellspacing="0" align="center">
  <tr>
    <td class="cusdec-normalfnt2bldBLACK"align="center">CARGO DISPATCH NOTE / FCL CONTAINER LOAD PLAN</td>
  </tr>
</table>
<table width="900" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td height="100"colspan="4" rowspan="4" class="border-top-left-fntsize12" style="vertical-align:top" ><table width="447" height="100" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="450" height="5">&nbsp;&nbsp;1. a Shipper(Name and Address) </td>
        </tr>
      <tr>
        <td height="15">&nbsp;</td>
        </tr>
      <tr>
        <td height="15">&nbsp;</td>
      </tr>
      <tr>
        <td height="15">&nbsp;</td>
      </tr>
      <tr>
        <td height="15">&nbsp;</td>
      </tr>
    </table></td>
    <td height="24" colspan="2" class="border-top-left-fntsize12">&nbsp;&nbsp;7. Lorry Trailer No </td>
    <td colspan="2" class="border-Left-Top-right-fntsize12">&nbsp;&nbsp;8. SN / (B/L) No. </td>
  </tr>
  <tr>
    <td height="25" colspan="2" class="border-left-fntsize12">&nbsp;</td>
    <td colspan="2"  class="border-left-right-fntsize12">&nbsp;</td>
  </tr>
  <tr>
    <td height="25" colspan="2" class="border-top-left-fntsize12">&nbsp;&nbsp;9. Tare Wt.(Kg) </td>
    <td colspan="2" class="border-Left-Top-right-fntsize12">&nbsp;&nbsp;10. SLPA No </td>
  </tr>
  <tr>
    <td height="25" colspan="2" class="border-left-fntsize12">&nbsp;</td>
    <td colspan="2" class="border-left-right-fntsize12">&nbsp;</td>
  </tr>
  <tr>
    <td height="100" colspan="4" rowspan="8" style="vertical-align:top" class="border-top-left-fntsize12"><table width="447" height="100" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="447" height="5">&nbsp;&nbsp;1. b Consignee(Name and Address) </td>
        </tr>
      <tr>
        <td height="15">&nbsp;</td>
        </tr>
      <tr>
        <td height="15">&nbsp;</td>
      </tr>
      <tr>
        <td height="15">&nbsp;</td>
      </tr>
      <tr>
        <td height="15">&nbsp;</td>
      </tr>
    </table></td>
    <td height="21"colspan="2" class="border-top-left-fntsize12">&nbsp;&nbsp;11. Seal No. 9308 </td>
    <td height="21"colspan="2" class="border-Left-Top-right-fntsize12">&nbsp;&nbsp;11 B Customer Entry </td>
  </tr>
  <tr>
    <td height="13"colspan="2" class="border-left-fntsize12">&nbsp;</td>
    <td height="13"colspan="2" class="border-left-right-fntsize12">&nbsp;</td>
  </tr>
  <tr>
    <td height="12" colspan="4" class="border-Left-Top-right-fntsize12">&nbsp;&nbsp;12. Name of Driver </td>
  </tr>
  <tr>
    <td height="13" colspan="4" class="border-left-right-fntsize12">&nbsp;</td>
  </tr>
  <tr>
    <td height="12" colspan="4" class="border-Left-Top-right-fntsize12">&nbsp;&nbsp;13. Name of Cleaner </td>
  </tr>
  <tr>
    <td height="13" colspan="4" class="border-left-right-fntsize12">&nbsp;&nbsp;</td>
  </tr>
  <tr>
    <td height="12" colspan="4" class="border-Left-Top-right-fntsize12">&nbsp;&nbsp;14. Any Others Accompanying </td>
  </tr>
  <tr>
    <td height="13" colspan="4" class="border-left-right-fntsize12">&nbsp;</td>
  </tr>
  <tr>
    <td width="112" height="50" rowspan="6" class="border-top-left-fntsize12">&nbsp;</td>
    <td width="112" rowspan="6" class="border-top-left-fntsize12">&nbsp;</td>
    <td width="112" rowspan="6" class="border-top-left-fntsize12">&nbsp;</td>
    <td width="112" rowspan="6" class="border-top-left-fntsize12">&nbsp;</td>
    <td colspan="4" class="border-Left-Top-right-fntsize12">&nbsp;&nbsp;15. Time of Departure from Stores/CFS . </td>
  </tr>
  <tr>
    <td colspan="4" class="border-left-right-fntsize12"   >&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4" class="border-left-right-fntsize12"   >&nbsp;&nbsp; The container/lorry was stuffed/loaded under strict strict security</td>
  </tr>
  <tr>
    <td colspan="4" class="border-left-right-fntsize12"   >&nbsp;condition & I certify that this container/lorry is safe to behandled in</td>
  </tr>
  <tr>
    <td colspan="4" class="border-left-right-fntsize12"   >&nbsp;the port. </td>
  </tr>
  <tr>
    <td colspan="4" class="border-left-right-fntsize12"   >&nbsp;</td>
  </tr>
  <tr>
    <td height="15" colspan="2" class="border-top-left-fntsize12">&nbsp;&nbsp;3.a Voyge No./Date 8228</td>
    <td colspan="2" class="border-top-left-fntsize12">&nbsp;&nbsp;3. b Ex-Vessel </td>
    <td colspan="4" class="border-left-right-fntsize12" >&nbsp;&nbsp;16. Name of Certifying security officer/authorized signatory.</td>
  </tr>
  <tr>
    <td height="15" colspan="2"  class="border-left-fntsize12">&nbsp;</td>
    <td colspan="2" class="border-left-fntsize12">&nbsp;</td>
    <td colspan="4" class="border-left-right-fntsize12" >&nbsp; </td>
  </tr>
  <tr>
    <td height="15" colspan="2" class="border-top-left-fntsize12">&nbsp;&nbsp;4. Veessel 8122/3</td>
    <td colspan="2" class="border-top-left-fntsize12">&nbsp;&nbsp;6. Port of loading</td>
    <td colspan="4" class="border-left-right-fntsize12"  >&nbsp;</td>
  </tr>
  <tr>
    <td height="15" colspan="2" class="border-left-fntsize12" >&nbsp;</td>
    <td colspan="2" class="border-left-fntsize12">&nbsp;</td>
    <td colspan="4" class="border-left-right-fntsize12"  >&nbsp;&nbsp;17. Signature, Designation and Date</td>
  </tr>
  <tr>
    <td height="15" colspan="2" class="border-top-left-fntsize12">&nbsp;&nbsp;5. Port of Discharge 3424/5 </td>
    <td class="border-top-left-fntsize12">&nbsp;&nbsp;VSL.OPR.CODE</td>
    <td class="border-top-left-fntsize12">&nbsp;&nbsp;CTN.OPR.CODE</td>
    <td colspan="4" class="border-left-right-fntsize12" >&nbsp; </td>
  </tr>
  <tr>
    <td height="15" colspan="2" class="border-left-fntsize12" >&nbsp;</td>
    <td class="border-left-fntsize12">&nbsp;</td>
    <td class="border-left-fntsize12">&nbsp;</td>
    <td   class="border-left-fntsize12">&nbsp;</td>
    <td   >&nbsp;</td>
    <td   >12/12/2009</td>
    <td   class="border-right-fntsize12">11:24 PMs </td>
  </tr>
  <tr>
    <td colspan="2" class="border-top-left-fntsize12">18. Marks &amp; Numbers/Container </td>
    <td colspan="2" class="border-top-fntsize12">&nbsp;&nbsp;
    19. Number & Kind of packages </td>
    <td colspan="2" class="border-top-fntsize12">&nbsp;&nbsp;
    20. Description of Codes*</td>
    <td width="112" height="21" class="border-top-left-fntsize12">&nbsp;21.(a)Gross Wt.</td>
    <td width="112" class="border-Left-Top-right-fntsize12">&nbsp;22. Cube CBM </td>
  </tr>
  <tr>
    <td height="10" colspan="2" class="border-left-fntsize12">&nbsp;No.</td>
    <td >&nbsp; &nbsp; 224  </td>
    <td ><div align="right">7064/5 &nbsp; &nbsp; </div></td>
    <td colspan="2" >&nbsp;&nbsp;&nbsp;&nbsp;7002</td>
    <td height="10" class="border-left-fntsize12"><div align="center">(Kg.)6292</div></td>
    <td width="112"  class="border-left-right-fntsize12"><div align="center">6324</div></td>
  </tr>
  <tr>
    <td colspan="2" class="border-left-fntsize12">&nbsp;&nbsp;7102</td>
    <td colspan="2" align="center" ><table width="67" height="15" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="67" class="border-All-fntsize12"><div align="center" >NOSE</div></td>
      </tr>
    </table></td>
    <td colspan="2" >&nbsp;</td>
    <td height="10" class="border-left-fntsize12">&nbsp;</td>
    <td width="112"  class="border-left-right-fntsize12">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" class="border-left-fntsize12">&nbsp;</td>
    <td colspan="2" >&nbsp;</td>
    <td colspan="2" >&nbsp;</td>
    <td height="10" class="border-top-left-fntsize12">&nbsp;21.(b)Net Wt.</td>
    <td width="112"  class="border-left-right-fntsize12">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" class="border-left-fntsize12">&nbsp;</td>
    <td colspan="2" >&nbsp;</td>
    <td colspan="2" >&nbsp;</td>
    <td height="10" class="border-left-fntsize12"><div align="center">(Kg.)6160</div></td>
    <td width="112"  class="border-left-right-fntsize12">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" class="border-left-fntsize12">&nbsp;</td>
    <td colspan="2" >&nbsp;</td>
    <td colspan="2" >&nbsp;</td>
    <td height="10" class="border-left-fntsize12">&nbsp;</td>
    <td width="112"  class="border-left-right-fntsize12">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" class="border-left-fntsize12">&nbsp;</td>
    <td colspan="2" >&nbsp;</td>
    <td colspan="2" >&nbsp;</td>
    <td height="10" class="border-top-left-fntsize12">&nbsp;21.(c) 6294</td>
    <td width="112"  class="border-left-right-fntsize12">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" class="border-left-fntsize12">&nbsp;</td>
    <td colspan="2" >&nbsp;</td>
    <td colspan="2" >&nbsp;</td>
    <td height="10" class="border-left-fntsize12">&nbsp;</td>
    <td width="112"  class="border-left-right-fntsize12">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" class="border-left-fntsize12">&nbsp;</td>
    <td colspan="2" >&nbsp;</td>
    <td colspan="2" >&nbsp;</td>
    <td height="10" class="border-left-fntsize12">&nbsp;</td>
    <td width="112"  class="border-left-right-fntsize12">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" class="border-left-fntsize12">&nbsp;</td>
    <td colspan="2" >&nbsp;</td>
    <td colspan="2" >&nbsp;</td>
    <td height="10" class="border-top-left-fntsize12">&nbsp;</td>
    <td width="112"  class="border-left-right-fntsize12">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" class="border-left-fntsize12">&nbsp;</td>
    <td colspan="2" >&nbsp;</td>
    <td colspan="2" >&nbsp;</td>
    <td height="10" class="border-left-fntsize12">&nbsp;</td>
    <td width="112"  class="border-left-right-fntsize12">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" class="border-left-fntsize12">&nbsp;</td>
    <td colspan="2" >&nbsp;</td>
    <td colspan="2" >&nbsp;</td>
    <td height="5" class="border-left-fntsize12">&nbsp;</td>
    <td width="112"  class="border-left-right-fntsize12">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" class="border-left-fntsize12">&nbsp;</td>
    <td colspan="2" >&nbsp;</td>
    <td colspan="2" >&nbsp;</td>
    <td height="5" class="border-left-fntsize12">&nbsp;</td>
    <td width="112"  class="border-left-right-fntsize12">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" class="border-left-fntsize12">&nbsp;</td>
    <td colspan="2" >&nbsp;</td>
    <td colspan="2" >&nbsp;</td>
    <td height="10" class="border-left-fntsize12">&nbsp;</td>
    <td width="112"  class="border-left-right-fntsize12">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" class="border-left-fntsize12">&nbsp;</td>
    <td colspan="2" >&nbsp;</td>
    <td colspan="2" >&nbsp;</td>
    <td height="5" class="border-left-fntsize12">&nbsp;</td>
    <td width="112"  class="border-left-right-fntsize12">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" class="border-left-fntsize12">&nbsp;</td>
    <td colspan="2" >&nbsp;</td>
    <td colspan="2" >&nbsp;</td>
    <td height="5" class="border-left-fntsize12">&nbsp;</td>
    <td width="112"  class="border-left-right-fntsize12">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" class="border-left-fntsize12">&nbsp;</td>
    <td colspan="2" >&nbsp;</td>
    <td colspan="2" >&nbsp;</td>
    <td height="5" class="border-left-fntsize12">&nbsp;</td>
    <td width="112"  class="border-left-right-fntsize12">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" class="border-left-fntsize12">&nbsp;</td>
    <td colspan="2" align="center" ><table width="67" height="15" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="67" class="border-All-fntsize12"><div align="center" >DOOR</div></td>
      </tr>
    </table></td>
    <td colspan="2" >&nbsp;</td>
    <td height="5" class="border-left-fntsize12">&nbsp;</td>
    <td width="112"  class="border-left-right-fntsize12">&nbsp;</td>
  </tr>
  <tr>
    <td height="10" colspan="3" class="border-top-left-fntsize12">&nbsp;&nbsp;21. Type of container </td>
    <td colspan="2" class="border-top-left-fntsize12" >&nbsp;</td>
    <td colspan="3" class="border-Left-Top-right-fntsize12">&nbsp; </td>
  </tr>
  <tr>
    <td height="20" colspan="3" class="border-left-fntsize12">&nbsp;&nbsp;&nbsp;Height ............. Length ............ Type .............</td>
    <td colspan="2" class="border-left-fntsize12" >&nbsp;</td>
    <td colspan="3" class="border-left-right-fntsize12" >&nbsp;</td>
  </tr>
  <tr>
    <td height="10" colspan="3" class="border-left-fntsize12">&nbsp;</td>
    <td colspan="2" class="border-left-fntsize12" >&nbsp;</td>
    <td colspan="3" class="border-left-right-fntsize12" >&nbsp;</td>
  </tr>
  <tr>
    <td height="10" colspan="3" class="border-left-fntsize12">&nbsp;&nbsp;24. Reefer Temperature Required </td>
    <td colspan="2" class="border-left-fntsize12" >&nbsp;</td>
    <td colspan="3" class="border-left-right-fntsize12" >&nbsp;</td>
  </tr>
  <tr>
    <td height="10" class="border-left-fntsize12">&nbsp;</td>
    <td height="10" ><sup>o</sup>F</td>
    <td height="10" ><sup>o</sup>C</td>
    <td colspan="2"  class="border-left-fntsize12">&nbsp;</td>
    <td colspan="3" class="border-left-right-fntsize12" >&nbsp;</td>
  </tr>
  <tr>
    <td height="10" colspan="3" class="border-left-fntsize12">&nbsp;&nbsp;</td>
    <td colspan="2"  class="border-left-fntsize12">&nbsp;</td>
    <td colspan="3" class="border-left-right-fntsize12">&nbsp;</td>
  </tr>
  <tr>
    <td height="10" colspan="3" class="border-left-fntsize12">&nbsp;&nbsp;25. Place of Delivery </td>
    <td colspan="2"  class="border-left-fntsize12" >&nbsp;</td>
    <td colspan="3"  class="border-Left-Top-right-fntsize12">&nbsp;</td>
  </tr>
  <tr>
    <td height="15" colspan="3" class="border-left-fntsize12">&nbsp;
      <table width="340" height="18" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="30" height="18"><div align="right"><table width="20" height="15" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="10" class="border-All-fntsize12"><div align="center" >&nbsp;</div></td>
      </tr>
    </table></div></td>
          <td width="50"><div align="center">CY</div></td>
          <td width="50"><div align="right"><table width="20" height="15" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="10" class="border-All-fntsize12"><div align="center" >&nbsp;</div></td>
      </tr>
    </table></div></td>
          <td width="50"><div align="center">CYS</div></td>
          <td width="50"><div align="right"><table width="20" height="15" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="10" class="border-All-fntsize12"><div align="center" >&nbsp;</div></td>
      </tr>
    </table></div></td>
          <td width="50"><div align="center">DOOR</div></td>
        </tr>
      </table></td>
    <td colspan="2"  class="border-left-fntsize12">&nbsp;</td>
    <td colspan="3" class="border-left-right-fntsize12" >&nbsp;</td>
  </tr>
  <tr>
    <td height="10" colspan="3" class="border-left-fntsize12">&nbsp;&nbsp;</td>
    <td colspan="2" class="border-top-left-fntsize12" >&nbsp;</td>
    <td colspan="3" class="border-left-right-fntsize12" >&nbsp;</td>
  </tr>
  <tr>
    <td height="5" colspan="3" class="border-left-fntsize12">&nbsp;&nbsp;26. Place of Receipt </td>
    <td colspan="2" class="border-left-fntsize12" >&nbsp;</td>
    <td colspan="3" class="border-left-right-fntsize12" >&nbsp;</td>
  </tr>
  <tr>
    <td height="2" colspan="3" class="border-left-fntsize12">&nbsp;<table width="340" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><div align="right"><table width="20" height="15" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="10" class="border-All-fntsize12"><div align="center" >&nbsp;</div></td>
      </tr>
    </table></div></td>
        <td width="40"><div align="center">CY</div></td>
        <td width="43"><div align="right"><table width="20" height="15" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="10" class="border-All-fntsize12"><div align="center" >&nbsp;</div></td>
      </tr>
    </table></div></td>
        <td width="43"><div align="center">PORT</div></td>
        <td width="40"><div align="right"><table width="20" height="15" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="10" class="border-All-fntsize12"><div align="center" >&nbsp;</div></td>
      </tr>
    </table></div></td>
        <td width="43"><div align="center">CFS</div></td>
        <td><div align="right"><table width="20" height="15" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="10" class="border-All-fntsize12"><div align="center" >&nbsp;</div></td>
      </tr>
    </table></div></td>
        <td><div align="center">DOOR</div></td>
      </tr>
    </table></td>
    <td colspan="2" class="border-left-fntsize12" >&nbsp;</td>
    <td colspan="3" class="border-left-right-fntsize12" >&nbsp;</td>
  </tr>
  <tr>
    <td height="3" colspan="3" class="border-left-fntsize12">&nbsp;</td>
    <td colspan="2" class="border-left-fntsize12" >&nbsp;</td>
    <td colspan="3" class="border-left-right-fntsize12" >&nbsp;</td>
  </tr>
  <tr>
    <td height="2" colspan="3" class="border-left-fntsize12">&nbsp;&nbsp;27. Remarks </td>
    <td colspan="2" class="border-left-fntsize12" >&nbsp;</td>
    <td colspan="3" class="border-left-right-fntsize12" >&nbsp;</td>
  </tr>
  <tr>
    <td height="3" colspan="3" class="border-left-fntsize12">&nbsp;</td>
    <td colspan="2" class="border-left-fntsize12" >&nbsp;</td>
    <td colspan="3" class="border-left-right-fntsize12" >&nbsp;</td>
  </tr>
  <tr>
    <td height="5" colspan="3" class="border-left-fntsize12">&nbsp;</td>
    <td colspan="2" class="border-left-fntsize12" >&nbsp;</td>
    <td colspan="3" class="border-left-right-fntsize12" >&nbsp;</td>
  </tr>
  <tr>
    <td height="5" colspan="3" class="border-left-fntsize12">&nbsp;</td>
    <td colspan="2" class="border-left-fntsize12" >&nbsp;</td>
    <td colspan="3" class="border-left-right-fntsize12" >&nbsp;</td>
  </tr>
  <tr>
    <td height="10" colspan="3" class="border-top-left-fntsize12">&nbsp;</td>
    <td colspan="2" class="border-top-left-fntsize12">&nbsp;</td>
    <td colspan="3" class="border-left-right-fntsize12" >&nbsp;</td>
  </tr>
  <tr>
    <td height="10" colspan="3" class="border-left-fntsize12">&nbsp;</td>
    <td colspan="2" class="border-left-fntsize12">&nbsp;</td>
    <td colspan="3" class="border-left-right-fntsize12" >&nbsp;</td>
  </tr>
  <tr>
    <td height="10" colspan="3" class="border-top-left-fntsize12">&nbsp;</td>
    <td colspan="2" class="border-top-left-fntsize12">&nbsp;</td>
    <td colspan="3" class="border-left-right-fntsize12" >&nbsp;</td>
  </tr>
  <tr>
    <td height="10" colspan="3" class="border-left-fntsize12">&nbsp;</td>
    <td colspan="2" class="border-left-fntsize12">&nbsp;</td>
    <td colspan="3"class="border-left-right-fntsize12" >&nbsp;</td>
  </tr>
  <tr>
    <td height="10" colspan="3" class="border-top-left-fntsize12">&nbsp;</td>
    <td colspan="2" class="border-top-left-fntsize12">&nbsp;</td>
    <td colspan="3" class="border-left-right-fntsize12" >&nbsp;</td>
  </tr>
  <tr>
    <td height="10" colspan="3" class="border-bottom-left-fntsize12">&nbsp;</td>
    <td colspan="2" class="border-bottom-left-fntsize12">&nbsp;</td>
    <td colspan="3" class="border-Left-bottom-right-fntsize12">&nbsp;</td>
  </tr>
  <tr>
    <td height="10" >&nbsp;</td>
    <td height="10" >&nbsp;</td>
    <td height="10" >&nbsp;</td>
    <td height="10" >&nbsp;</td>
    <td width="112" height="10" >&nbsp;</td>
    <td width="112" height="10" >&nbsp;</td>
    <td height="10" >&nbsp;</td>
    <td height="10" >&nbsp;</td>
  </tr>
</table>
<p>&nbsp;</p>
</body>
</html>
