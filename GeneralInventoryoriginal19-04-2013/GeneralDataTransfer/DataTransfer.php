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
<title>Data Transfer</title>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
body {
	background-color: #CCCCCC;
}
-->
</style>
<!--<script type="text/javascript" src="checkstatusjs.js"></script>-->
<script type="text/javascript">
	function SubmitForm()
	{
		document.frmdatatransfer.submit();
	}
</script>
</head>

<body>
<form name="frmdatatransfer" id="frmdatatransfer" method="post" action="DataTransfer.php">
<table width="950" border="0" align="center" bgcolor="#FFFFFF">
  <tr>
    <td><?php include '../../Header.php'; ?></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" class="tablezRED">
      <tr>
        <td width="8%" class="normalfnt">Transaction</td>
		<td width="56%"><select name="cbostyleno" class="txtbox" id="cbostyleno" style="width:160px">
     <?php
	 					
	/*$SQL_style = "select intID,strDescription from genmatmaincategory";
	$result_style = $db->RunQuery($SQL_style);
	echo "<option value=\"". "" ."\">" . "" ."</option>" ;
	while($row = mysql_fetch_array($result_style))
	{
		if ($_POST["cbostyleno"] ==  $row["intID"])
			echo "<option selected=\"selected\" value=\"". $row["intID"] ."\">" . $row["strDescription"] ."</option>" ;
		else
			echo "<option value=\"". $row["intID"] ."\">" . $row["strDescription"] ."</option>" ;
	}*/	
	
	//if ($_POST["cbostyleno"] == $tranType)
	//{
		//echo "<option selected=\"selected\" value=\"". $tranType ."\">" . $tranType ."</option>" ;
	//}
	//else
	//{
		echo "<option value=\"". "" ."\">" . "" ."</option>" ;
		echo "<option value=\"GRN\">GRN</option>";
		echo "<option value=\"ISSUE\">ISSUE</option>";
		echo "<option value=\"STORES RETURN\">STORES RETURN</option>";
		echo "<option value=\"SUPPLIER RETURN\">SUPPLIER RETURN</option>";
		echo "<option value=\"GPF\">GPF</option>";
	//}
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
			
			$SQL_style = "SELECT strMainID As strComCode,strName FROM mainstores WHERE intStatus = '1' ORDER BY strName;";
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
        <td height="17" bgcolor="#9BBFDD" class="normalfnth2"><div align="center">Stock Transaction</div></td>
        </tr>
      <tr>
        <td><div id="divcons2" style="overflow:scroll; height:400px; width:950px;">
          <table border="0" cellpadding="0" cellspacing="0" width="1000">
            <tbody>
              <tr>
                <td width="2%" bgcolor="#498CC2" class="normaltxtmidb2">*</td>
                <td width="4%" bgcolor="#498CC2" class="normaltxtmidb2">Year</td>
                <td width="7%" bgcolor="#498CC2" class="normaltxtmidb2">Main Stores</td>
				<td width="7%" bgcolor="#498CC2" class="normaltxtmidb2">Sub Stores</td>
				<td width="7%" bgcolor="#498CC2" class="normaltxtmidb2">Location</td>
				<td width="4%" bgcolor="#498CC2" class="normaltxtmidb2">Bin</td>
                <td width="2%" bgcolor="#498CC2" class="normaltxtmidb2">Document No</td>
                <td width="7%" bgcolor="#498CC2" class="normaltxtmidb2">Document Year</td>
				<td width="7%" bgcolor="#498CC2" class="normaltxtmidb2">MatDetail ID</td>
				<td width="5%" bgcolor="#498CC2" class="normaltxtmidb2">Type</td>
                <td width="7%" bgcolor="#498CC2" class="normaltxtmidb2">Unit</td>
                <td width="7%" bgcolor="#498CC2" class="normaltxtmidb2">Qty</td>
                <td width="7%" bgcolor="#498CC2" class="normaltxtmidb2">Date</td>
                <td width="7%" bgcolor="#498CC2" class="normaltxtmidb2">User ID</td>
              </tr>
             <?php
			 	//if ($_POST["cbostyleno"] == "GRN")/* GRN Query - START*/
				/*{
					$tranType = "GRN";
					$result_search = "";
					$SQL_details = "SELECT
									genaralgrn.strGRNfacUser AS intYear,
									genaralgrn.strLocation AS strLocation,
									genaralgrn.strGenGrnNo AS intDocumentNo,
									genaralgrn.strGRNfacUser AS intDocumentYear,
									generalgrndetail.strcode AS intMatDetailId,
									generalgrndetail.strUnit AS strUnit,
									Sum(generalgrndetail.dblQty) AS dblQty,
									genaralgrn.dtRecdDate AS dtmDate,
									genaralgrn.strUserId
									FROM
									genaralgrn
									Inner Join generalgrndetail ON genaralgrn.strGenGrnNo = generalgrndetail.strGenGrnNo 
									AND genaralgrn.strGRNfacUser = generalgrndetail.strGRNfacUser
									WHERE
									genaralgrn.intStatus =  '1'"
									;				
					
					if ($_POST["cbocompany"] != "")
					{
						$sql_company = "SELECT strremarks AS strMainId FROM
										mainstores WHERE strMainId = '" . $_POST["cbocompany"] . "' ";
						$rst_company = $db->RunQuery($sql_company);
						while($row_company=mysql_fetch_array($rst_company))
						{
							if($row_company["strMainId"] == "")
							{
								$location = " AND genaralgrn.strLocation IS NULL ";
								$SQL_details = $SQL_details . " AND genaralgrn.strLocation IS NULL ";
							}
							else
							{
								//$location = " AND genaralgrn.strLocation = '". $row_company["strMainId"]  ."' ";
								//$SQL_details = $SQL_details . " AND genaralgrn.strLocation = '". $row_company["strMainId"]  ."' ";
								$location = " AND genaralgrn.strCompanyId = '". $row_company["strMainId"]  ."' ";
								$SQL_details = $SQL_details . " AND genaralgrn.strCompanyId = '". $row_company["strMainId"]  ."' ";
							}
						}
					}					 
					$SQL_details = $SQL_details . "GROUP BY
					genaralgrn.strGRNfacUser,
					genaralgrn.strLocation,
					genaralgrn.strGenGrnNo,
					generalgrndetail.strcode,
					generalgrndetail.strUnit,
					genaralgrn.dtRecdDate,
					genaralgrn.strUserId
					ORDER BY genaralgrn.strGRNfacUser,genaralgrn.strGenGrnNo";
				}*//* GRN Query - END*/
				
				if ($_POST["cbostyleno"] == "ISSUE")/* ISSUE Query - START*/
				{
					$tranType = "ISSUE";
					$result_search = "";
					$SQL_details = "SELECT
									genaralissue.strIsFacUser AS intYear,
									genaralissue.strCompID AS strLocation,
									genaralissue.strGenIssueNo AS intDocumentNo,
									genaralissue.strIsFacUser AS intDocumentYear,
									genaralissuedetail.strCode AS intMatDetailId,
									genmatitemlist.strUnit AS strUnit,
									Sum(genaralissuedetail.dblQty) AS dblQty,
									genaralissue.dtIssuedDate AS dtmDate,
									genaralissue.strUserId
									FROM
									genaralissue
									Inner Join genaralissuedetail ON genaralissue.strGenIssueNo = genaralissuedetail.strGenIssueNo 
									AND genaralissue.strIsFacUser = genaralissuedetail.strIsFacUser
									Inner Join genmatitemlist ON genaralissuedetail.strCode = genmatitemlist.intItemSerial
									WHERE
									genaralissue.intStatus = '0'
									
									";
					if ($_POST["cbocompany"] != "")
					{
						$sql_company = "SELECT strremarks AS strMainId FROM
										mainstores WHERE strMainId = '" . $_POST["cbocompany"] . "' ";
						$rst_company = $db->RunQuery($sql_company);
						while($row_company=mysql_fetch_array($rst_company))
						{
							if($row_company["strMainId"] == "")
							{
								$location = " AND genaralissue.strCompID IS NULL ";
								$SQL_details = $SQL_details . " AND genaralissue.strCompID IS NULL ";
							}
							else
							{
								//$location = " AND genaralissue.strCompID = '". $row_company["strMainId"]  ."' ";
								//$SQL_details = $SQL_details . " AND genaralissue.strCompID = '". $row_company["strMainId"]  ."' ";
								$location = " AND genaralissue.strCompID = '". $row_company["strMainId"]  ."' ";
								$SQL_details = $SQL_details . " AND genaralissue.strCompID = '". $row_company["strMainId"]  ."' ";
							}
						}
					}					 
					$SQL_details = $SQL_details . "GROUP BY
													genaralissue.strIsFacUser,
													genaralissue.strCompID,
													genaralissue.strGenIssueNo,
													genaralissuedetail.strCode,
													genmatitemlist.strUnit,
													genaralissue.dtIssuedDate,
													genaralissue.strUserId";				
				}/* ISSUE Query - END*/
				
				//if ($_POST["cbostyleno"] == "GPF")/* GatepassOut Query - START*/
				/*{
					$tranType = "GPF";
					$result_search = "";
					$SQL_details = "SELECT
									normalgatepassout.strGPFacUser AS intYear,
									normalgatepassout.strCompanyId AS strLocation,
									normalgatepassout.strGatePassNo AS intDocumentNo,
									normalgatepassout.strGPFacUser AS intDocumentYear,
									genmatitemlist.intItemSerial AS intMatDetailId,
									normalgatepassoutdetail.strUnit AS strUnit,
									Sum(normalgatepassoutdetail.dblQty) AS dblQty,
									normalgatepassout.dtDate AS dtmDate,
									normalgatepassout.strPrepairedBy AS strUserId
									FROM
									normalgatepassout
									Inner Join normalgatepassoutdetail 
									ON normalgatepassout.strGatePassNo = normalgatepassoutdetail.strGatePassNo 
									AND normalgatepassout.strGPFacUser = normalgatepassoutdetail.strGPFacUser
									Inner Join genmatitemlist 
									ON normalgatepassoutdetail.strDescription = genmatitemlist.strItemDescription
									";
					if ($_POST["cbocompany"] != "")
					{
						$sql_company = "SELECT strremarks AS strMainId FROM
										mainstores WHERE strMainId = '" . $_POST["cbocompany"] . "' ";
						$rst_company = $db->RunQuery($sql_company);
						while($row_company=mysql_fetch_array($rst_company))
						{
							if($row_company["strMainId"] == "")
							{
								$location = " AND normalgatepassout.strCompanyId IS NULL ";
								$SQL_details = $SQL_details . " AND normalgatepassout.strCompanyId IS NULL ";
							}
							else
							{
								$location = " AND normalgatepassout.strCompanyId = '". $row_company["strMainId"]  ."' ";
								$SQL_details = $SQL_details . " AND normalgatepassout.strCompanyId = '". $row_company["strMainId"]  ."' ";
							}
						}
					}					 
					$SQL_details = $SQL_details . "GROUP BY
												normalgatepassout.strGPFacUser,
												normalgatepassout.strCompanyId,
												normalgatepassout.strGatePassNo,
												genmatitemlist.intItemSerial,
												normalgatepassoutdetail.strUnit";				
				}*//* GatepassOut Query - END*/
				
				$result_search = $db->RunQuery($SQL_details);
				$count = mysql_num_rows($result_search);
				echo $_POST["cbostyleno"] . " Record Count :" . $count;
				$incr = 1;
				$errTrack = 0;
				//$arrCnt = "";
				$arrCnt = 0;
				$arrCnt =  round($count /1000) ;
				echo "Array Count :" . $arrCnt;
				if ($arrCnt == 0){$actArrCnt = $arrCnt; $arrCnt = 1;}else{$actArrCnt = $arrCnt; $arrCnt = $arrCnt;}
				for($i=1;$i <= $arrCnt;$i++)
				{	$sql_embedd = "";
					if ($i == 1)
					{
						$x = 1;
						$y = 1;
					}
					else
					{
						$y = $y + 1000;
						//$x = ($i * 1000) + 1;
						$x = $x + 1000;
					}
					if ($actArrCnt == 0)
					{
						$sql_embedd = $SQL_details ;
					}
					else
					{
						$sql_embedd = $SQL_details . " Limit " . $y . "," .($x + 1000);
					}
					////echo $sql_embedd;
					////echo " Limit " . $y . "," . ($x + 1000);
					////echo "---";
					////$sql_embedd = $SQL_details . " Limit 3149,4925";
					$result_search = $db->RunQuery($sql_embedd);
					
				///}
					///$result_search = "";
					
					while($row_search=mysql_fetch_array($result_search))
					{
						$sql_user = "SELECT Max(intUserId) AS intUserId FROM
									 useraccounts WHERE oldName = '" . $row_search["strUserId"] . "' ";
						$rst_user = $db->RunQuery($sql_user);
						while($row_user=mysql_fetch_array($rst_user))
						{
							$userid = $row_user["intUserId"];
							if ($userid == "")
							{	
								$userid = $row_search["strUserId"];
								if ($userid  == "Nuwan")
								{$userid = "997";}
								elseif($userid  == "weeramuni")
								{$userid = "998";}
								elseif($userid  == "pradeep")
								{$userid = "999";}
								else
								{$userid = "";}
							}
						}
						
						$sql_mainstore = "SELECT Max(strMainId) AS strMainId FROM
									mainstores WHERE strremarks = '" . $row_search["strLocation"] . "' ";
						$rst_mainstore = $db->RunQuery($sql_mainstore);
						while($row_mainstore=mysql_fetch_array($rst_mainstore))
						{
							$mainstore = $row_mainstore["strMainId"];
							if ($mainstore == "")
							{	
								$mainstore = $row_search["strLocation"];
								if ($mainstore  == "JB")
								{$mainstore = "96";$loc = "JB";}
								if ($mainstore  == "TCW")
								{$mainstore = "97";$loc = "TCW";}
								elseif($mainstore  == "JF_MAW")
								{$mainstore = "98";$loc = "JF_MAW";}
								elseif($mainstore  == "")
								{$mainstore = "99";$loc = "99";}
								else
								{$mainstore="";}
							}
						}
				  ?>
				  <tr bgcolor="#ffffff">
					<td bgcolor="#ffffff" class="normalfntTAB"><?php echo $incr;?></td>
					<td bgcolor="#ffffff" class="normalfntTAB"><?php echo $row_search["intYear"];?></td>
					<td bgcolor="#ffffff" class="normalfntTAB"><?php echo $mainstore; ?></td>
					<td bgcolor="#ffffff" class="normalfntTAB"><?php echo "99";?></td>
					<td bgcolor="#ffffff" class="normalfntTAB"><?php echo $row_search["strLocation"]; if($loc == ""){$loc = $row_search["strLocation"];}$loc ="JV";?></td>
					<td bgcolor="#ffffff" class="normalfntTAB"><?php echo "99";?></td>
					<td bgcolor="#ffffff" class="normalfntTAB"><?php echo $row_search["intDocumentNo"];?></td>
					<td bgcolor="#ffffff" class="normalfntTAB"><?php echo $row_search["intDocumentYear"];?></td>
					<td align="right" bgcolor="#ffffff" class="normalfntTAB"><?php echo $row_search["intMatDetailId"];
					?> </td>
					<td bgcolor="#ffffff" class="normalfntTAB"><?php echo $tranType;?></td>
	
					<td bgcolor="#ffffff" align="right" class="normalfntTAB"><?php echo $row_search["strUnit"];
					?>
					</td>
					<td align="right" bgcolor="#ffffff" class="normalfntTAB"><?php echo number_format($row_search["dblQty"],2,".",",");
					?></td>
					<td align="right" bgcolor="#ffffff" class="normalfntTAB"><?php echo substr($row_search["dtmDate"],0,10);?></td>
					<td align="right" bgcolor="#ffffff" class="normalfntTAB"><?php echo $userid;?></td>
				  </tr>
				  <?php  
						/*$sql_insert = "insert into eplan.genstocktransactions 
											(intYear, 
											strMainStoresID, 
											strSubStores, 
											strLocation, 
											strBin, 
											intDocumentNo, 
											intDocumentYear, 
											intMatDetailId, 
											strType, 
											strUnit, 
											dblQty, 
											dtmDate, 
											intUser
											)
											values
											('". $row_search["intYear"] ."', 
											'". $mainstore ."', 
											'99', 
											'". $row_search["strLocation"] ."', 
											'99', 
											'". $row_search["intDocumentNo"] ."', 
											'".  $row_search["intDocumentYear"] ."', 
											'". $row_search["intMatDetailId"] ."', 
											'GRN', 
											'". $row_search["strUnit"] ."', 
											'". $row_search["dblQty"] ."', 
											'". substr($row_search["dtmDate"],0,10) ."', 
											'". $userid ."'
											);";*/
											//echo $sql_insert;
						//$result = $db->RunQuery($sql_insert);
						//if ($result == 0){$errTrack++;}
						
						if ($_POST["cbostyleno"] == "ISSUE" || $_POST["cbostyleno"] == "RSUP" )
						{
							$stockQty = ($row_search["dblQty"] * -1);
						}
						else
						{
							$stockQty = $row_search["dblQty"];
						}
							
						
$sql_file = " '". "20" . $row_search["intYear"] ."','". 6 ."','99','". $row_search["strLocation"] ."','99','". $row_search["intDocumentNo"] ."','".  "20" . $row_search["intDocumentYear"] ."','". $row_search["intMatDetailId"] ."','". $tranType ."','". $row_search["strUnit"] ."','". $stockQty ."','". substr($row_search["dtmDate"],0,10) ."','". $userid ."' \n";
						
						$Data = $Data . $sql_file;
						
						$incr++;
					}
					 /* Field Delimeter = Comma(,)
					 	Record Seperator = LF
						Text Qualifier = '
						Date Order = YMD
						Date Delimeter = -
						lngTransactionNo = PrimaryKey
					  */
					 
					$File = "C:\stock_inserts". "_" . $tranType . "_" . $loc . ".txt";
					$Handle = fopen($File, 'w');
					//$Data = $sql_insert;
					fwrite($Handle, $Data); 
					fclose($Handle);
				}
			  ?>
            </tbody>
          </table>
        </div></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td height="51" bgcolor="#D6E7F5"><div id="divcons33" style="height:50px; width:950px;"><table width="100%" border="0">
      <tr>
        <td height="45"><?php echo "Error Count : " . $errTrack; ?></td>
        <td width="28%">&nbsp;</td>
        <td width="11%">&nbsp;</td>
        <td width="11%"><a href="../main.php"><img src="../../images/close.png" alt="close" width="97" height="24" border="0"/></a>			</td>
      </tr>
    </table></div></td>
  </tr>
</table>
</form>
</body>
</html>
