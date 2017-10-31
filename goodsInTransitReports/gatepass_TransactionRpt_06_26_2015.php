<?php
session_start();
include "../Connector.php";
$backwardseperator = "../";
include "${backwardseperator}authentication.inc";

 $factoryID =  $_SESSION["CompanyID"]; 

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GAPRO - Gate Pass Transaction</title>
<link href="../css/erpstyle.css" rel="stylesheet" type="text/css" />
<script src="../javascript/script.js" type="text/javascript"></script>
<style type="text/css">
<!--
body {
	background-color: #CCCCCC;
}
-->
</style>
<script type="text/javascript" >
//var pub_urlBank = "/hela/goodsInTransitReports/";
var UserID = <?php
 echo $_SESSION["UserID"]; 
 ?>;



function loadSubStore(){
var mainStore       = document.getElementById("GP_trans_cboMainStore").value;
 loadCombo("SELECT DISTINCT intDocumentNo,CONCAT(intDocumentYear,'/',intDocumentNo)  FROM stocktransactions WHERE strMainStoresID="+mainStore+"  ORDER BY intDocumentNo ASC ",'GP_trans_GatePassNo');	
}

function report(){
var mainStore       = document.getElementById("GP_trans_cboMainStore").options[document.getElementById("GP_trans_cboMainStore").selectedIndex].text;
var GatePassNo      = document.getElementById("GP_trans_GatePassNo").options[document.getElementById("GP_trans_GatePassNo").selectedIndex].text;

var mainStoreID     = document.getElementById("GP_trans_cboMainStore").value;
var GatePassNoID    = document.getElementById("GP_trans_GatePassNo").value;

if(document.getElementById("chkBox").checked ==true){
chkBox='1';
}else{
chkBox='0';
}

var path = document.location.protocol+'//'+document.location.hostname+'/'+document.location.pathname.split("/")[1]+'/'+document.location.pathname.split("/")[2];

 window.open(path+"/gatepass_TransactionRpt2.php?mainStore=" + mainStore+"  &&GatePassNo="+GatePassNo+"&&mainStoreID="+mainStoreID+"&&GatePassNoID="+GatePassNoID+" &&chkBox="+chkBox  ,'GP_trans'); 
}

function setStyle(){
	
	var styleCode = document.getElementById('cmbSCNo').value;	
	loadCombo("SELECT orders.intStyleId, orders.strStyle FROM orders WHERE orders.intStyleId = "+styleCode,'cmbStyleID');
}

</script>
<script src="../javascript/script.js" type="text/javascript"></script>
<script type="text/javascript" src="../javascript/preorder.js"></script>

</head>

<body>
<form id="GP_trans" name="GP_trans" method="post" action="">
  <table width="950" border="0" align="center" bgcolor="#FFFFFF">
    <tr>
      <td><?php include '../Header.php'; ?></td>
    </tr>
    <tr>
      <td><table width="100%" border="0">
        <tr>
          <td width="100%">&nbsp;</td>
        </tr>
        <tr>
          <td><table width="100%" border="0">
            <tr>
              <td width="19%">&nbsp;</td>
              <td width="62%"><table width="100%" border="0">
                  <tr>
                    <td height="35" bgcolor="#498CC2" class="TitleN2white">Gate Pass Transaction</td>
                  </tr>
                  <tr>
                    <td height="61"><table width="100%" border="0" cellpadding="1" cellspacing="1">
                        <tr>
                          <td colspan="2" class="normalfnt">&nbsp;</td>
                          <td colspan="3">&nbsp;</td>
                        </tr>
                        <!--<tr>
							<td class="normalfnt">SC No</td>
                            <td><select class="txtbox" id="cmbSCNo" style="width:130px;" onchange="setStyle()">
 								<?php
								
									$strSql = " SELECT orders.intStyleId, specification.intSRNO FROM specification ".
                                              "        Inner Join orders ON specification.intStyleId = orders.intStyleId ".
                                              " WHERE  orders.intStatus =  '11'";
											  
									$result =$db->RunQuery($strSql);	
									
									echo "<option value=\"".""."\">" .""."</option>";
									
									while ($row=mysql_fetch_array($result))
									{
										echo "<option value=\"".$row["intStyleId"]."\">".$row["intSRNO"]."</option>";
									}  
														
								?>                           
                            </select></td>
                            <td class="normalfnt">Style ID</td>
                            <td><select id="cmbStyleID" class="txtbox" style="width:130px;">
                            
                            	<?php
								
									$strSql = " SELECT orders.intStyleId, orders.strStyle FROM orders ".
                                              " WHERE  orders.intStatus =  '11'";
											  
									$result =$db->RunQuery($strSql);	
									
									echo "<option value=\"".""."\">" .""."</option>";
									
									while ($row=mysql_fetch_array($result))
									{
										echo "<option value=\"".$row["intStyleId"]."\">".$row["strStyle"]."</option>";
									}  
														
								?>   
                            
                            </select></td>
                        </tr>-->
						<tr>
                          <td width="18%" class="normalfnt">Main Store</td>
                          <td width="36%"><select name="GP_trans_cboMainStore"  id="GP_trans_cboMainStore" class="txtbox" id="GPNOFrom" style="width:130px" onchange="loadSubStore(this.value);">
	 <?php
 
		$SQL ="SELECT strMainID,strName FROM mainstores WHERE intCommonBin='0'";
		//echo $SQL;
			$result =$db->RunQuery($SQL);
		
		echo "<option value=\"".""."\">" .""."</option>";
		
			while ($row=mysql_fetch_array($result))
			{
				echo "<option value=\"".$row["strMainID"]."\">".$row["strName"]."</option>";
			}
	
 	?>         
        </select></td>
                          <td width="18%" class="normalfnt">Gate Pass No</td>
                          <td width="36%"><select name="GP_trans_GatePassNo" class="txtbox" id="GP_trans_GatePassNo" style="width:130px">
	 <?php
 		
		$SQL ="SELECT DISTINCT intGatePassNo FROM gatepassdetails";
		//echo $SQL;
			$result =$db->RunQuery($SQL);
		
		echo "<option value=\"".""."\">" .""."</option>";
		
			while ($row=mysql_fetch_array($result))
			{
				echo "<option value=\"".$row["intGatePassNo"]."\">".$row["intGatePassNo"]."</option>";
			}

 	?>         
        </select></td>
                        </tr>
						

                        <tr>
                          <td width="25%" class="normalfnt">&nbsp;</td>
                          
                          <td width="23%" class="normalfnt"><!--DWLayoutEmptyCell-->&nbsp;</td>
                          <td width="13%"><!--DWLayoutEmptyCell-->&nbsp;</td>
                        </tr>
				   <tr>
                          <td width="25%" class="normalfnt">Not Transfered</td>
                          <td width="18%" class="normalfnt"><input type="checkbox" id="chkBox"/></td>
                          <td width="36%">&nbsp;</td>
                          <td width="23%" class="normalfnt"><!--DWLayoutEmptyCell-->&nbsp;</td>
                          <td width="13%"><!--DWLayoutEmptyCell-->&nbsp;</td>
                        </tr>
                    </table></td>
                  </tr>
				  
				  
                  <tr>
                    <td height="34"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="bcgl1">
                        <tr>
                          <td width="100%" bgcolor="#d6e7f5"><table width="100%" border="0">
                              <tr>
                                <td width="21%">&nbsp;</td>
                                <td width="21%">&nbsp;</td>
                                <td width="19%"><img src="../images/report.png" alt="OK" width="86" height="24" onclick="report();" /></td>
                                <td width="18%">&nbsp;</td>
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
      </table></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
    </tr>
  </table>
</form>
</body>
</html>
