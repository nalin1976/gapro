<?php
session_start();
$backwardseperator = "../../";
include "../../Connector.php";

			$styleno=$_POST["cbostyleno"];
			$company=$_POST["cbocompany"];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Check Status</title>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
body {
	background-color: #CCCCCC;
}
-->
</style>
<script type="text/javascript" src="checkstatusjs.js"></script>
</head>

<body>
<form name="frmcheckstatus" id="frmcheckstatus" method="post" action="checkstatus.php">
<table width="950" border="0" align="center" bgcolor="#FFFFFF">
  <tr>
    <td><?php include '../../Header.php'; ?></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" class="bcgl1" bgcolor="#DDEEEE">
      <tr>
        <td width="8%" class="normalfnt">Material</td>
		<td width="56%"><select name="cbostyleno" class="txtbox" id="cbostyleno" style="width:160px">
     <?php
	 					
	$SQL_style = "select intID,strDescription from genmatmaincategory";
	$result_style = $db->RunQuery($SQL_style);
	echo "<option value=\"". "" ."\">" . "" ."</option>" ;
	while($row = mysql_fetch_array($result_style))
	{
		if ($_POST["cbostyleno"] ==  $row["intID"])
			echo "<option selected=\"selected\" value=\"". $row["intID"] ."\">" . $row["strDescription"] ."</option>" ;
		else
			echo "<option value=\"". $row["intID"] ."\">" . $row["strDescription"] ."</option>" ;
	}
	
	?>
        
        </select></td>
        
        
        
        <td width="36%" rowspan="2" valign="bottom"><img src="../../images/search.png" alt="search" width="80" height="24" onclick="SubmitForm();"/></td>
      </tr>
      <tr>
        <td class="normalfnt">Stores</td>
        <td colspan="5"><select name="cbocompany" class="txtbox" id="cbocompany" style="width:408px">
        <?php
			/*** @@@ 'Companies' Table changed to 'Main Stores' Table @@@***/
			//$SQL_style = "SELECT strComCode,strName FROM companies WHERE intStatus = '1';";
			$SQL_style = "SELECT strMainID As strComCode,strName FROM mainstores WHERE intStatus = '1';";
			
			$result_style = $db->RunQuery($SQL_style);
			echo "<option value=\"". "" ."\">" . "" ."</option>" ;
			while($row = mysql_fetch_array($result_style))
			{
					if ($_POST["cbocompany"] ==  $row["strComCode"])
					echo "<option selected=\"selected\" value=\"". $row["strComCode"] ."\">" . $row["strName"] ."</option>" ;
					else	
					echo "<option value=\"". $row["strComCode"] ."\">" . $row["strName"] ."</option>" ;
			}
		?>
        </select></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td height="17" bgcolor="#9BBFDD" class="normalfnth2"><div align="center">Check Status</div></td>
        </tr>
      <tr>
        <td><div id="divcons2" style="overflow:scroll; height:400px; width:950px;">
          <table border="0" cellpadding="0" cellspacing="0" width="1200">
            <tbody>
              <tr>
                <td width="2%" bgcolor="#498CC2" class="normaltxtmidb2">Category</td>
                <td width="25%" bgcolor="#498CC2" class="normaltxtmidb2">Detail</td>
                <td width="7%" bgcolor="#498CC2" class="normaltxtmidb2">Item Code</td>
                <td width="2%" bgcolor="#498CC2" class="normaltxtmidb2">Unit</td>
                <td width="7%" bgcolor="#498CC2" class="normaltxtmidb2">Balance</td>
                <td width="7%" align="right" bgcolor="#498CC2" class="normaltxtmidb2">Ordered Qty</td>
                <td width="7%" bgcolor="#498CC2" class="normaltxtmidb2">Rec. Qty</td>
                <td width="7%" bgcolor="#498CC2" class="normaltxtmidb2">GP Trans Qty</td>
                <td width="7%" bgcolor="#498CC2" class="normaltxtmidb2">Ret To Stores</td>
                <td width="7%" bgcolor="#498CC2" class="normaltxtmidb2">Issue Qty</td>
                <td width="7%" bgcolor="#498CC2" class="normaltxtmidb2">GatePass Qty</td>
                <td width="7%" bgcolor="#498CC2" class="normaltxtmidb2">Return To Supp</td>
                <td width="4%" bgcolor="#498CC2" class="normaltxtmidb2">Extra</td>
                <td width="5%" bgcolor="#498CC2" class="normaltxtmidb2">MatDet</td>
              </tr>
             <?php		
						$result_search = "";
						$SQL_details = "SELECT
										genmatsubcategory.StrCatName As strDescription,
										genmatitemlist.intItemSerial As intMatDetailId,
										genmatitemlist.strItemDescription As strItemDescription,
										genmatitemlist.strUnit
										FROM
										genmatmaincategory
										Inner Join genmatsubcategory ON genmatmaincategory.intID = genmatsubcategory.intCatNo
										Inner Join genmatitemlist ON genmatsubcategory.intCatNo = genmatitemlist.intMainCatID 
										AND genmatsubcategory.intSubCatNo = genmatitemlist.intSubCatID
										WHERE
										genmatmaincategory.strID = '".$styleno."' AND
										genmatitemlist.intStatus = '1'
										GROUP BY
										genmatsubcategory.StrCatName,
										genmatitemlist.strItemDescription";				
						$result_search = $db->RunQuery($SQL_details);
				
				while($row_search=mysql_fetch_array($result_search))
				{$reqqty = $row_search["Qty"];
				 
			  ?>
              <tr bgcolor="#ffffff" onmouseover="this.style.background ='#D6E7F5';" onmouseout="this.style.background='';">
                <td  class="normalfntTAB"><?php echo substr($row_search["strDescription"],0,3);?></td><!--strDescription-->
                <td class="normalfntTAB"><?php echo $row_search["strItemDescription"];?></td><!--strItemDescription-->
                <td class="normalfntTAB"><?php echo $row_search["intMatDetailId"];?></td>
                <td class="normalfntTAB"><?php echo $row_search["strUnit"];?></td><!--strUnit-->
				
                <td align="right"  class="normalfntTAB"><?php $SQL_bal="SELECT A.balance AS StockBal 
						FROM(SELECT	 genstocktransactions.strUnit,
						genmatmaincategory.strDescription,genmatitemlist.strItemDescription, 
						genstocktransactions.strMainStoresID,genstocktransactions.intMatDetailId,SUM(genstocktransactions.dblQty) AS balance 				FROM  genstocktransactions
						INNER JOIN genmatitemlist ON genstocktransactions.intMatDetailId = genmatitemlist.intItemSerial 
						INNER JOIN genmatmaincategory ON genmatitemlist.intMainCatID = genmatmaincategory.intID 
						INNER JOIN mainstores ON mainstores.strMainID = genstocktransactions.strMainStoresID 
						WHERE genstocktransactions.intMatDetailId = '".$row_search["intMatDetailId"]."' 
						GROUP BY
						genstocktransactions.intMatDetailId,
						genmatmaincategory.strDescription,
						genmatitemlist.strItemDescription,
						genstocktransactions.strUnit,genstocktransactions.strMainStoresID)AS A 
						WHERE A.intMatDetailId = ".$row_search["intMatDetailId"]." 
						and A.strMainStoresID = '".$company."' ;";
				
			  			$result_bal = $db->RunQuery($SQL_bal);
						while($row_bal=mysql_fetch_array($result_bal))
						{
							echo number_format($row_bal["StockBal"],2,".",",");
                        }
?> </td>
                <td align="right"  class="normalfntTAB"><?php 
						$SQL_orderqty="	SELECT sum(generalpurchaseorderdetails.dblQty)as qty, 
										generalpurchaseorderdetails.intMatDetailID
								 		FROM generalpurchaseorderdetails 
								 		Inner Join generalpurchaseorderheader 
										ON generalpurchaseorderheader.intGenPONo = generalpurchaseorderdetails.intGenPONo
								 		WHERE  generalpurchaseorderdetails.intMatDetailID =  '".$row_search["intMatDetailId"]."'
								 		AND generalpurchaseorderheader.intDeliverTo = '".$company."'
								 		AND generalpurchaseorderheader.intStatus =  '1'
								 		GROUP BY
								 		generalpurchaseorderdetails.intMatDetailID ";						 
						 //echo $SQL_orderqty;
						$result_orderqty = $db->RunQuery($SQL_orderqty);
						while($row_orderqty=mysql_fetch_array($result_orderqty))
						{
							echo number_format($row_orderqty["qty"],2,".",",");
							
							$orderqty = $row_orderqty["qty"];
                        }

?></td><!--dblQty-->
                <td  align="right" class="normalfntTAB"><div align="left"><img src="../../images/add.png" width="16" height="16" onclick="ShowinterjobWindow()"><?php 
				/*** @@@ Changes made to query: 'Companies' Table Replaced With 'Mainstores' Table @@@ ***/
					$SQL_grn="SELECT A.balance AS grnqty 
						FROM(SELECT	 genstocktransactions.strUnit,
						genmatmaincategory.strDescription,genmatitemlist.strItemDescription, genstocktransactions.strType,
						genstocktransactions.strMainStoresID,genstocktransactions.intMatDetailId,
						SUM(genstocktransactions.dblQty) AS balance 						
						FROM genstocktransactions
						INNER JOIN genmatitemlist ON genstocktransactions.intMatDetailId = genmatitemlist.intItemSerial 
						INNER JOIN genmatmaincategory ON genmatitemlist.intMainCatID = genmatmaincategory.intID 
						INNER JOIN mainstores ON mainstores.strMainID = genstocktransactions.strMainStoresID 
						WHERE genstocktransactions.intMatDetailId = '".$row_search["intMatDetailId"]."' 
						GROUP BY
						genstocktransactions.intMatDetailId,
						genstocktransactions.strType,genmatmaincategory.strDescription,
						genmatitemlist.strItemDescription,
						genstocktransactions.strUnit,genstocktransactions.strMainStoresID)AS A 
						WHERE A.intMatDetailId = '".$row_search["intMatDetailId"]."' 
						and A.strType = 'GRN' 
						and A.strMainStoresID = '".$company."' ;";
						//echo $SQL_grn;
			  			$result_grn = $db->RunQuery($SQL_grn);
						while($row_grn=mysql_fetch_array($result_grn))
						{
							echo number_format($row_grn["grnqty"],2,".",",");
                        }
?></div>
</td>
                <td align="right"  class="normalfntTAB"><?php 
					$SQL_gpin="SELECT A.balance AS gpinqty 
							FROM(SELECT	 genstocktransactions.strUnit,
							genmatmaincategory.strDescription,genmatitemlist.strItemDescription, genstocktransactions.strType,
							genstocktransactions.strMainStoresID,genstocktransactions.intMatDetailId,
							SUM(genstocktransactions.dblQty) AS balance 						
							FROM genstocktransactions
							INNER JOIN genmatitemlist ON genstocktransactions.intMatDetailId = genmatitemlist.intItemSerial 
							INNER JOIN genmatmaincategory ON genmatitemlist.intMainCatID = genmatmaincategory.intID 
							INNER JOIN mainstores ON mainstores.strMainID = genstocktransactions.strMainStoresID 
							WHERE genstocktransactions.intMatDetailId = '".$row_search["intMatDetailId"]."' 
							GROUP BY
							genstocktransactions.intMatDetailId,
							genstocktransactions.strType,genmatmaincategory.strDescription,
							genmatitemlist.strItemDescription,
							genstocktransactions.strUnit,genstocktransactions.strMainStoresID)AS A 
							WHERE A.intMatDetailId = '".$row_search["intMatDetailId"]."' 
							and A.strType = 'GPT' 
							and A.strMainStoresID = '".$company."' ;";
			  			$result_gpin = $db->RunQuery($SQL_gpin);
						while($row_gpin=mysql_fetch_array($result_gpin))
						{
							echo number_format($row_gpin["gpinqty"],2,".",",");
                        }
?></td>

                <td align="right" class="normalfntTAB"><?php 
							$SQL_rts="SELECT A.balance AS rtsqty 
								FROM(SELECT	 genstocktransactions.strUnit,
								genmatmaincategory.strDescription,genmatitemlist.strItemDescription, genstocktransactions.strType,
								genstocktransactions.strMainStoresID,genstocktransactions.intMatDetailId,
								SUM(genstocktransactions.dblQty) AS balance 						
								FROM genstocktransactions
								INNER JOIN genmatitemlist ON genstocktransactions.intMatDetailId = genmatitemlist.intItemSerial 
								INNER JOIN genmatmaincategory ON genmatitemlist.intMainCatID = genmatmaincategory.intID 
								INNER JOIN mainstores ON mainstores.strMainID = genstocktransactions.strMainStoresID 
								WHERE genstocktransactions.intMatDetailId = '".$row_search["intMatDetailId"]."' 
								GROUP BY
								genstocktransactions.intMatDetailId,
								genstocktransactions.strType,genmatmaincategory.strDescription,
								genmatitemlist.strItemDescription,
								genstocktransactions.strUnit,genstocktransactions.strMainStoresID)AS A 
								WHERE A.intMatDetailId = '".$row_search["intMatDetailId"]."' 
								and A.strType = 'RSTO' 
								and A.strMainStoresID = '".$company."' ;";
			  			$result_rts = $db->RunQuery($SQL_rts);
						while($row_rts=mysql_fetch_array($result_rts))
						{
							echo number_format($row_rts["rtsqty"],2,".",",");
                        }
?></td>
                <!--<td bgcolor="#ffffff" class="normalfntTAB">0</td>-->
                <td align="right" class="normalfntTAB"><?php 
							$SQL_issue="SELECT A.balance AS issueqty 
								FROM(SELECT	 genstocktransactions.strUnit,
								genmatmaincategory.strDescription,genmatitemlist.strItemDescription, genstocktransactions.strType,
								genstocktransactions.strMainStoresID,genstocktransactions.intMatDetailId,
								SUM(genstocktransactions.dblQty) AS balance 						
								FROM genstocktransactions
								INNER JOIN genmatitemlist ON genstocktransactions.intMatDetailId = genmatitemlist.intItemSerial 
								INNER JOIN genmatmaincategory ON genmatitemlist.intMainCatID = genmatmaincategory.intID 
								INNER JOIN mainstores ON mainstores.strMainID = genstocktransactions.strMainStoresID 
								WHERE genstocktransactions.intMatDetailId = '".$row_search["intMatDetailId"]."' 
								GROUP BY
								genstocktransactions.intMatDetailId,
								genstocktransactions.strType,genmatmaincategory.strDescription,
								genmatitemlist.strItemDescription,
								genstocktransactions.strUnit,genstocktransactions.strMainStoresID)AS A 
								WHERE A.intMatDetailId = '".$row_search["intMatDetailId"]."' 
								and A.strType = 'ISSUE' 
								and A.strMainStoresID = '".$company."' ;";
								//echo $SQL_issue;
			  			$result_issue = $db->RunQuery($SQL_issue);
						while($row_issue=mysql_fetch_array($result_issue))
						{
							echo number_format(($row_issue["issueqty"] * -1),2,".",",");
                        }
?></td>
                <td align="right" class="normalfntTAB"><?php 
				$SQL_gpout="SELECT A.balance AS gpoutqty 
								FROM(SELECT	 genstocktransactions.strUnit,
								genmatmaincategory.strDescription,genmatitemlist.strItemDescription, genstocktransactions.strType,
								genstocktransactions.strMainStoresID,genstocktransactions.intMatDetailId,
								SUM(genstocktransactions.dblQty) AS balance 						
								FROM genstocktransactions
								INNER JOIN genmatitemlist ON genstocktransactions.intMatDetailId = genmatitemlist.intItemSerial 
								INNER JOIN genmatmaincategory ON genmatitemlist.intMainCatID = genmatmaincategory.intID 
								INNER JOIN mainstores ON mainstores.strMainID = genstocktransactions.strMainStoresID 
								WHERE genstocktransactions.intMatDetailId = '".$row_search["intMatDetailId"]."' 
								GROUP BY
								genstocktransactions.intMatDetailId,
								genstocktransactions.strType,genmatmaincategory.strDescription,
								genmatitemlist.strItemDescription,
								genstocktransactions.strUnit,genstocktransactions.strMainStoresID)AS A 
								WHERE A.intMatDetailId = '".$row_search["intMatDetailId"]."' 
								and A.strType = 'GPF' 
								and A.strMainStoresID = '".$company."' ;";
						$result_gpout = $db->RunQuery($SQL_gpout);
						while($row_gpout=mysql_fetch_array($result_gpout))
						{
							echo number_format(($row_gpout["gpoutqty"] * -1),2,".",",");
                        }
?></td>
                <td align="right" class="normalfntTAB"><?php 
					$SQL_rtsup="SELECT A.balance AS rtsupqty 
						FROM(SELECT	 genstocktransactions.strUnit,
						genmatmaincategory.strDescription,genmatitemlist.strItemDescription, genstocktransactions.strType,
						genstocktransactions.strMainStoresID,genstocktransactions.intMatDetailId,
						SUM(genstocktransactions.dblQty) AS balance 						
						FROM genstocktransactions
						INNER JOIN genmatitemlist ON genstocktransactions.intMatDetailId = genmatitemlist.intItemSerial 
						INNER JOIN genmatmaincategory ON genmatitemlist.intMainCatID = genmatmaincategory.intID 
						INNER JOIN mainstores ON mainstores.strMainID = genstocktransactions.strMainStoresID 
						WHERE genstocktransactions.intMatDetailId = '".$row_search["intMatDetailId"]."' 
						GROUP BY
						genstocktransactions.intMatDetailId,
						genstocktransactions.strType,genmatmaincategory.strDescription,
						genmatitemlist.strItemDescription,
						genstocktransactions.strUnit,genstocktransactions.strMainStoresID)AS A 
						WHERE A.intMatDetailId = '".$row_search["intMatDetailId"]."' 
						and A.strType = 'RSUP' 
						and A.strMainStoresID = '".$company."' ;";
			  			$result_rtsup = $db->RunQuery($SQL_rtsup);
						while($row_rtsup=mysql_fetch_array($result_rtsup))
						{
							echo number_format(($row_rtsup["rtsupqty"] * -1),2,".",",");
                        }
?></td>
                <!--<td bgcolor="#ffffff" class="normalfntTAB"><?php echo $row_search["strBuyerPONo"] ?></td>-->
                <td class="normalfntTAB"><img src="../../images/add.png" width="16" height="16" onclick="getgrn(this)"></td>
                <td class="normalfntTAB"><?php echo $row_search["intMatDetailId"];?></td>
              </tr>
              <?php
			  		
				}
			  ?>
            </tbody>
          </table>
        </div></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td bgcolor="#D6E7F5"><table width="100%" border="0">
      <tr>
        <td>&nbsp;</td>
        <td width="28%">&nbsp;</td>
        <td width="11%">&nbsp;</td>
        <td width="11%"><a href="../main.php"><img src="../../images/close.png" alt="close" width="97" height="24" border="0"/></a></td>
      </tr>
    </table></td>
  </tr>
</table>
</form>
</body>
</html>
