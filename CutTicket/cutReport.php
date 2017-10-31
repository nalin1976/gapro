<?php
include "../Connector.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>CONSUMPTION REPORT</title>
<link href="../css/erpstyle.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="1100" border="0" align="center">
  <tr>
    <td><table width="100%" cellpadding="0" cellspacing="0">
      <tr>
        <td width="20%"><img src="../images/GaPro_logo.png" alt="" width="191" height="47" class="normalfnt" /></td>
        <td width="6%" class="normalfnt">&nbsp;</td>
        <td width="74%" class="tophead"><p class="topheadBLACK"><?php
	
		/////////////////////////////////// FOR GET FACTORY DETAILS /////////////////////////////////////////////
		
//			$strStyleId='019-475-0-99';
//			$matDetailId='6';
//			$strBuyerPoNo = '#Main Ratio#';
//			$strColor='FUEGO RED';
//			$strMarker = 'M1';
//			$intCutNo	='1';
			$strStyleId		=$_GET["strStyleId"];
			$matDetailId	=$_GET["matDetailId"];
			$strBuyerPoNo 	=$_GET["strBuyerPoNo"];
			$strColor		=$_GET["strColor"];
			$strMarker 		=$_GET["strMarker"];
			$intCutNo		=$_GET["intCutNo"];

		
		$strSQL="SELECT
						companies.strName AS strName,
						companies.strAddress1 AS strAddress1,
						companies.strAddress2 AS strAddress2,
						companies.strStreet AS strStreet,
						companies.strCity AS strCity,
						companies.strCountry AS strCountry,
						companies.strPhone AS strPhone,
						companies.strEMail AS strEmail,
						companies.strFax AS strFax,
						companies.strWeb AS strWeb
						FROM
						cadconsumptionheader
						Inner Join useraccounts ON useraccounts.intUserID = cadconsumptionheader.strUserId ,
						companies
						WHERE
						cadconsumptionheader.intStyleId =  '$strStyleId' AND
						cadconsumptionheader.strColor =  '$strColor' AND
						cadconsumptionheader.intMatdetailId =  '$matDetailId'";



					$result = $db->RunQuery($strSQL);

		
		while($row = mysql_fetch_array($result))
		{		
						$strName			=$row["strName"];
						$strAddress1		=$row["strAddress1"];
						$strAddress2		=$row["strAddress2"];
						$strStreet			=$row["strStreet"];
						$strCity			=$row["strCity"];
						$strCountry			=$row["strCountry"];
						$strPhone			=$row["strPhone"];
						$strEmail			=$row["strEmail"];
						$strFax				=$row["strFax"];
						$strWeb				=$row["strWeb"];
						$dtDate				=$row["dtDate"];
						break;
		}
		
			echo $strName ?></p>
          <p class="normalfnt"><?PHP echo "$strAddress1 $strAddress2  $strStreet $strCity $strCountry . Tel: $strPhone  Fax: $strFax" ?> </p>
          <p class="normalfnt"><?php echo "E-Mail: $strEmail Web: $strWeb" ?></p></td>
      </tr>
    </table></td>
  </tr>
  <?php
  /////////////////////////////////// FOR GET HEADER DETAILS /////////////////////////////////////////////
				  $SQL1 = "SELECT *
					FROM
					cutticketsheader
					Inner Join matitemlist ON matitemlist.intItemSerial = cutticketsheader.intMatDetailId
					Inner Join useraccounts ON useraccounts.intUserID = cutticketsheader.intUserId
					WHERE
					cutticketsheader.intStyleId =  '$strStyleId' AND
					cutticketsheader.intMatDetailId =  '$matDetailId' AND
					cutticketsheader.strBuyerPoNo =  '$strBuyerPoNo' AND
					cutticketsheader.strColor =  '$strColor' AND
					cutticketsheader.strMarker =  '$strMarker' AND
					cutticketsheader.dblCutNo =  '$intCutNo'
				";
  					$result1 = $db->RunQuery($SQL1);

		
		while($row = mysql_fetch_array($result1))
		{		
					$dblWidth			= $row["dblWidth"];
					$strItemDescription	= $row["strItemDescription"];
					$dtDate				= $row["dtDate"];
					$dblOrderQty		= $row["dblOrderQty"];
					$strFactRefNo		= $row["strFactRefNo"];
					$dblPercentage		= $row["dblPercentage"];
					$intUserId			= $row["intUserId"];
					$dblMarkerLengthYrd	= $row["dblMarkerLengthYrd"];
					$dblMarkerLengthInch= $row["dblMarkerLengthInch"];
					$Eff				= $row["Eff"];
					$dblTotalYrd		= $row["dblTotalYrd"];
					$dblLayerNo 		= $row["dblLayerNo"];
					$dbladitictLayer	= $row["dbladitictLayer"];
					$intStatus			= $row["intStatus"];
					$strUserName		= $row["Name"];
		}
  
  ?>
  <tr>
    <td><table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td height="36" colspan="6" class="head2">DAILY CUT  REPORT </td>
      </tr>
      <tr>
        <td class="normalfnth2B">&nbsp;</td>
        <td class="normalfnt"><span class="normalfnth2B">STYLE NO </span></td>
        <td class="normalfnt">: <?php echo $strStyleId ?></td>
        <td width="9%">&nbsp;</td>
        <td width="16%" class="normalfnth2B">FACTORY REF NO </td>
        <td width="27%" valign="top" class="normalfnt">: <?php echo '' ?></td>
      </tr>
      <tr>
        <td width="9%" class="normalfnth2B">&nbsp;</td>
        <td width="12%" class="normalfnt"><span class="normalfnth2B">JPO NO </span></td>
        <td width="27%" class="normalfnt">: <?php echo '' ?></td>
        <td>&nbsp;</td>
        <td class="normalfnth2B">ORDER QTY </td>
        <td width="27%" valign="top" class="normalfnt">: <?php echo $dblTotalYrd ?></td>
      </tr>
      <tr>
        <td height="13" class="normalfnth2B">&nbsp;</td>
        <td class="normalfnt"><span class="normalfnth2B">FABRIC</span></td>
        <td class="normalfnt">: <?php echo $strItemDescription ?></td>
        <td>&nbsp;</td>
        <td class="normalfnth2B">PERCENTAGE</td>
        <td width="27%" valign="top" class="normalfnt">: <?php echo $dblPercentage ?></td>
      </tr>
      <tr>
        <td height="13" class="normalfnth2B">&nbsp;</td>
        <td class="normalfnt"><span class="normalfnth2B">BUYER</span></td>
        <td class="normalfnt">: <?php echo '' ?></td>
        <td>&nbsp;</td>
        <td class="normalfnth2B">BUYER PO NO </td>
        <td width="27%" valign="top" class="normalfnt">: <?php echo $strBuyerPoNo ?></td>
      </tr>

    </table></td>
  </tr>
  <tr>
    <td class="normalfnth2B">&nbsp;</td>
  </tr>
 
  <tr>
    <td><table width="100%" border="0" cellpadding="0" cellspacing="0" class="tablez">
      <tr>
        <td width="99" height="25" class="normalfntBtab">FAB COLOR  </td>
        <td width="68" class="normalfntBtab">DATE</td>
        <td width="68" class="normalfntBtab">CUT NO </td>
        <td width="57" class="normalfntBtab">&nbsp;</td>
		
		
		
             			   <?php
  /////////////////////////////////// FOR GET SIZE HEADER DETAILS /////////////////////////////////////////////
					
					$SQL3="
					
						SELECT strSize, dblCutQty FROM cutticketsdetails
						WHERE
						intStyleId =  '$strStyleId' AND
						intMatDetailId =  '$matDetailId' AND
						strBuyerPoNo =  '$strBuyerPoNo' AND
						strColor =  '$strColor' AND
						strMarker =  '$strMarker' AND
						dblCutNo =  '$intCutNo'
						
						";
					
    				$result3 = $db->RunQuery($SQL3);
					$count = mysql_num_rows($result3);
					$x = 50/(int)$count;
				$y=0;
		while($row2 = mysql_fetch_array($result3))
		{		
			$strSize				= $row2["strSize"];
			$dblQty					= $row2["dblCutQty"];
			$Tsize[++$y]=$dblQty;
  		 ?>
        <td width="<?php $x?>%" class="normalfntBtab"><?PHP echo "$strSize"  ?></td>
		<?PHP 
		}
		?>
		
		
		
		<td width="88" class="normalfntBtab">TOTAL</td>
		<td width="88" class="normalfntBtab">CUM QTY</td>
        <td width="88" class="normalfntBtab">MARKER LENGTH YRD </td>
        <td width="91" class="normalfntBtab">MARKER LENGTH INCH </td>
        <td width="51" class="normalfntBtab">EFF</td>
        <td width="95" class="normalfntBtab">TOTAL YRD </td>
      </tr>
      <tr>
        <td class="normalfntTAB"><?php echo $strColor; ?></td>
        <td class="normalfntTAB"><?php echo $dtDate; ?></td>
        <td class="normalfntMidTAB"><?php echo $intCutNo; ?></td>
        <td class="normalfntMidTAB">Cuttable</td>
		
		
		
       			<?php
  			/////////////////////////////////// FOR GET SIZE DETAILS /////////////////////////////////////////////
				$SQL4 = "SELECT strSize, dblCuttableQty FROM cutticketsdetails
						WHERE
						intStyleId =  '$strStyleId' AND
						intMatDetailId =  '$matDetailId' AND
						strBuyerPoNo =  '$strBuyerPoNo' AND
						strColor =  '$strColor' AND
						strMarker =  '$strMarker' AND
						dblCutNo =  '$intCutNo'";
						
  					$result4 = $db->RunQuery($SQL4);
					$sizeCount = mysql_num_rows($result4);
					//$x = 50/(int)$count;
				$A_dblQty=0;
				$x=0;
				while($row4 = mysql_fetch_array($result4))
				{		
					$dblQty					= $row4["dblCuttableQty"];
  					//$Size[++$x] += $dblQty*$dblLayers;
 			 ?>
			 
        <td class="normalfntMidTAB"><?PHP echo $dblQty; ?></td>
		
		
					<?PHP 
					
					}
					
					?>
		
		
        <td class="normalfntMidTAB">&nbsp;</td>
        <td class="normalfntMidTAB">&nbsp;</td>
        <td class="normalfntMidTAB"><?php echo $dblMarkerLengthYrd; ?></td>
        <td class="normalfntRiteTAB"><?php echo $dblMarkerLengthInch; ?></td>
		<td class="normalfntRiteTAB"><?php echo $Eff; ?></td>
		<td class="normalfntRiteTAB"><?php echo $dblTotalYrd; ?></td>
      </tr>
	        <tr>
        <td class="normalfntTAB">&nbsp;</td>
        <td class="normalfntTAB">&nbsp;</td>
        <td class="normalfntMidTAB">&nbsp;</td>
        <td class="normalfntMidTAB">With%</td>
		
		
        			<?php
  			/////////////////////////////////// FOR GET SIZE DETAILS /////////////////////////////////////////////
				$SQL4 = "SELECT strSize, dblCutQty FROM cutticketsdetails
						WHERE
						intStyleId =  '$strStyleId' AND
						intMatDetailId =  '$matDetailId' AND
						strBuyerPoNo =  '$strBuyerPoNo' AND
						strColor =  '$strColor' AND
						strMarker =  '$strMarker' AND
						dblCutNo =  '$intCutNo'";
						
  					$result4 = $db->RunQuery($SQL4);
					$sizeCount = mysql_num_rows($result4);
					//$x = 50/(int)$count;
				$A_dblQty=0;
				$x=0;
				while($row4 = mysql_fetch_array($result4))
				{		
					$dblQty					= $row4["dblCutQty"];
  					//$Size[++$x] += $dblQty*$dblLayers;
 			 ?>
			 
        <td class="normalfntMidTAB"><?PHP echo 0; ?></td>
		
		
					<?PHP 
					
					}
					
					?>
		
		
        <td class="normalfntMidTAB">&nbsp;</td>
        <td class="normalfntMidTAB">&nbsp;</td>
        <td class="normalfntMidTAB">&nbsp;</td>
        <td class="normalfntRiteTAB">&nbsp;</td>
		<td class="normalfntRiteTAB">&nbsp;</td>
		<td class="normalfntRiteTAB">&nbsp;</td>
      </tr>
	        <tr>
        <td class="normalfntTAB">&nbsp;</td>
        <td class="normalfntTAB">&nbsp;</td>
        <td class="normalfntMidTAB">&nbsp;</td>
        <td class="normalfntMidTAB">Cut Qty </td>
        			<?php
  			/////////////////////////////////// FOR GET SIZE DETAILS /////////////////////////////////////////////
				$SQL4 = "SELECT strSize, dblCutQty FROM cutticketsdetails
						WHERE
						intStyleId =  '$strStyleId' AND
						intMatDetailId =  '$matDetailId' AND
						strBuyerPoNo =  '$strBuyerPoNo' AND
						strColor =  '$strColor' AND
						strMarker =  '$strMarker' AND
						dblCutNo =  '$intCutNo'";
						
  					$result4 = $db->RunQuery($SQL4);
					$sizeCount = mysql_num_rows($result4);
					//$x = 50/(int)$count;
				$A_dblQty=0;
				$x=0;
				while($row4 = mysql_fetch_array($result4))
				{		
					$dblQty					= $row4["dblCutQty"];
					$total +=$dblQty;
  					//$Size[++$x] += $dblQty*$dblLayers;
 			 ?>
			 
        <td class="normalfntMidTAB"><?PHP echo $dblQty; ?></td>
		
		
					<?PHP 
					
					}
					
					?>
        <td class="normalfntMidTAB"><?php echo $total; ?></td>
        <td class="normalfntMidTAB"><?php echo $total; ?></td>
        <td class="normalfntMidTAB">&nbsp;</td>
        <td class="normalfntRiteTAB">&nbsp;</td>
		<td class="normalfntRiteTAB">&nbsp;</td>
		<td class="normalfntRiteTAB">&nbsp;</td>
      </tr>
	        <tr>
        <td class="normalfntTAB">&nbsp;</td>
        <td class="normalfntTAB">&nbsp;</td>
        <td class="normalfntMidTAB">&nbsp;</td>
        <td class="normalfntMidTAB">Bal Qty </td>
        			<?php
  			/////////////////////////////////// FOR GET SIZE DETAILS /////////////////////////////////////////////
				$SQL4 = "SELECT (dblCuttableQty-dblCutQty) as dblBalance FROM cutticketsdetails
						WHERE
						intStyleId =  '$strStyleId' AND
						intMatDetailId =  '$matDetailId' AND
						strBuyerPoNo =  '$strBuyerPoNo' AND
						strColor =  '$strColor' AND
						strMarker =  '$strMarker' AND
						dblCutNo =  '$intCutNo'";
						
  					$result4 = $db->RunQuery($SQL4);
					$sizeCount = mysql_num_rows($result4);
					//$x = 50/(int)$count;
				$A_dblQty=0;
				$x=0;
				while($row4 = mysql_fetch_array($result4))
				{		
					$dblQty					= $row4["dblBalance"];
  					//$Size[++$x] += $dblQty*$dblLayers;
 			 ?>
			 
        <td class="normalfntMidTAB"><?PHP echo $dblQty; ?></td>
		
		
					<?PHP 
					
					}
					
					?>
        <td class="normalfntMidTAB">&nbsp;</td>
        <td class="normalfntMidTAB">&nbsp;</td>
        <td class="normalfntMidTAB">&nbsp;</td>
        <td class="normalfntRiteTAB">&nbsp;</td>
		<td class="normalfntRiteTAB">&nbsp;</td>
		<td class="normalfntRiteTAB">&nbsp;</td>
      </tr>

      <tr>
        <td class="normalfntBtab" >&nbsp;</td>
        <td class="normalfntBtab" height="25">&nbsp;</td>
        <td class="normalfntBtab">&nbsp;</td>

        <td class="normalfntBtab">&nbsp;</td>
        			<?php
  			/////////////////////////////////// FOR GET SIZE DETAILS /////////////////////////////////////////////
				$SQL4 = "SELECT (dblCuttableQty-dblCutQty) as dblBalance FROM cutticketsdetails
						WHERE
						intStyleId =  '$strStyleId' AND
						intMatDetailId =  '$matDetailId' AND
						strBuyerPoNo =  '$strBuyerPoNo' AND
						strColor =  '$strColor' AND
						strMarker =  '$strMarker' AND
						dblCutNo =  '$intCutNo'";
						
  					$result4 = $db->RunQuery($SQL4);
					$sizeCount = mysql_num_rows($result4);
					//$x = 50/(int)$count;
				$A_dblQty=0;
				$x=0;
				while($row4 = mysql_fetch_array($result4))
				{		
					$dblQty					= $row4["dblBalance"];
  					//$Size[++$x] += $dblQty*$dblLayers;
 			 ?>
			 
        <td class="normalfntBtab">&nbsp;</td>
		
		
					<?PHP 
					
					}
					
					?>

        <td class="normalfntBtab">&nbsp;</td>
        <td class="normalfntBtab">&nbsp;</td>
        <td class="normalfntBtab">&nbsp;</td>
		<td class="normalfntBtab">&nbsp;</td>
		<td class="normalfntBtab">&nbsp;</td>
        <td class="normalfntBtab" style="text-align:right">&nbsp;</td>
      </tr>
    </table></td>
  </tr>

  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td class="normalfnBLD1">&nbsp;</td>
  </tr>
  <tr>
    <td><table width="100%" border="0">
      <tr>
        <td width="8%" class="normalfnt">&nbsp;</td>
        <td width="19%" class="bcgl1txt1">&nbsp;</td>
        <td width="5%">&nbsp;</td>
        <td width="39%" class="bcgl1txt1">&nbsp;</td>
        <td width="4%">&nbsp;</td>
        <td width="16%" class="bcgl1txt1">&nbsp;</td>
        <td width="9%">&nbsp;</td>
      </tr>
      <tr>
        <td class="normalfnt">&nbsp;</td>
        <td class="normalfnth2Bm" >PREPARED BY</td>
        <td>&nbsp;</td>
        <td class="normalfnth2Bm">CHECKED BY</td>
        <td>&nbsp;</td>
        <td class="normalfnth2Bm" >APPROVED BY </td>
        <td>&nbsp;</td>
      </tr>

    </table></td>
  </tr>
</table>
</body>
</html>
