<?php
 session_start();
 include "authentication.inc";
 

$styleID = $_POST["cboStyles"];
$srNo = $_POST["cboSR"];
include "Connector.php"; 
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GaPro - Sub Contract Reports</title>
<link href="css/erpstyle.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
body {
	background-color: #CCCCCC;
}

-->
</style>



<script type="text/javascript" src="javascript/aprovedPreoder.js"></script>
<script type="text/javascript" src="javascript/script.js"></script>
<script type="text/javascript" src="javascript/bom.js"></script>
<script type="text/javascript">

function submitForm()
{
	document.frmcomplete.submit();
}



</script>
</head>

<body>
<form id="frmcomplete" name="frmcomplete" method="post" action="subcontractlist.php">
  <table width="950" border="0" align="center" bgcolor="#FFFFFF">
    <tr>
      <td><?php include 'Header.php'; ?></td>
    </tr>
    <tr>
      <td><table width="100%" border="0">
        <tr>
          <td colspan="2">&nbsp;</td>
        </tr>
        <tr>
          <td width="4%"><div align="center"><img src="images/butt_1.png" width="15" height="15" /></div></td>
          <td width="96%" class="head1">Sub Contract Reports </td>
        </tr>
        <tr>
          <td colspan="2"><table width="100%" border="0">
            <!--DWLayoutTable-->
            <tr>
              <td width="50%" height="21"><table width="931" border="0">
                <tr>
                  
                  <td width="72"  bgcolor="#99CCFF" class="txtbox">Style No </td>
                  <td width="155" class="txtbox"><select name="cboStyles" class="txtbox" style="width:150px" id="cboStyles" onchange="getScNo();resetCompanyBuyer();">
                    <option value="Select One" selected="selected">Select One</option>
                    <?php
	
	$SQL = "SELECT DISTINCT subcontractororders.intStyleId FROM subcontractororders INNER JOIN orders ON subcontractororders.intStyleId = orders.intStyleId AND orders.intStatus = 11 ;";
	
	$result = $db->RunQuery($SQL);
	
	
	while($row = mysql_fetch_array($result))
	{
		if ($styleID==  $row["intStyleId"])
		{
			echo "<option selected=\"selected\" value=\"". $row["intStyleId"] ."\">" . $row["intStyleId"] ."</option>" ;
		}
		else
			echo "<option value=\"". $row["intStyleId"] ."\">" . $row["intStyleId"] ."</option>" ;
	}
	
	?>
                  </select></td>
                  <td width="70"  bgcolor="#99CCFF" class="txtbox">SC No</td>
                  <td width="150" class="txtbox"><select name="cboSR" class="txtbox" style="width:150px" id="cboSR" onchange="getStyleNo();resetCompanyBuyer();">
                    <option value="Select One" selected="selected">Select One</option>
                    <?php
	
	$SQL = "SELECT DISTINCT intSRNO FROM specification INNER JOIN subcontractororders
 ON subcontractororders.intStyleId = specification.intStyleId INNER JOIN orders 
 ON specification.intStyleId = orders.intStyleId AND orders.intStatus = 11 order by intSRNO desc;";
	
	$result = $db->RunQuery($SQL);
	
	
	while($row = mysql_fetch_array($result))
	{
		if ($srNo==  $row["intSRNO"])
		{
			echo "<option selected=\"selected\" value=\"". $row["intSRNO"] ."\">" . $row["intSRNO"] ."</option>" ;
		}
		else
			echo "<option value=\"". $row["intSRNO"] ."\">" . $row["intSRNO"] ."</option>" ;
	}
	
	?>
                  </select></td>
                  <td width="72" ><div align="right"><img src="images/search.png" alt="Search" width="80" height="24" class="mouseover" onclick="submitForm();" /></div></td>
                  <td width="72" ></td>
                  <td width="72"  ></td>
                  <td width="72" ></td>
                  </tr>
                
              </table></td>
              </tr>
          </table></td>
          </tr>
        <tr>
          <td colspan="2"><div id="divData" style="width:930px; height:400px; overflow: scroll; border-width:3px; border-style:solid;border-color:#99CCFF;">
            <table width="910" bgcolor="#CCCCFF" border="0" cellpadding="0" cellspacing="1" class="bcgl1" id="tblPreOders" >
              <tr>

                <td width="33%" bgcolor="#498CC2" class="normaltxtmidb2">Sub Contractor</td>
                <td width="11%" bgcolor="#498CC2" class="normaltxtmidb2">Quantity</td>
                <td width="11%" bgcolor="#498CC2" class="normaltxtmidb2">FOB</td>
                <td width="11%" bgcolor="#498CC2" class="normaltxtmidb2">CM</td>
                <td width="14%" bgcolor="#498CC2" class="normaltxtmidb2">Delivery Date</td>
                <td width="10%" bgcolor="#498CC2" class="normaltxtmidb2">Sub Bom</td>
					<td width="10%" bgcolor="#498CC2" class="normaltxtmidb2">Agreement</td>
              </tr>
              <?php
			
			
		
			
			$sql = "SELECT subcontractors.strSubContractorID,subcontractors.strName,  strBuyerPONO,intQty,fob,cm,  DATE_FORMAT(deliveryDate, '%Y %b %d')  AS deliveryDate  FROM subcontractororders INNER JOIN subcontractors 
 ON  subcontractororders.intSubContractorID = subcontractors.intSubContractorID 
 WHERE intStyleId = '$styleID' group by strName";
			
			
			
			$result = $db->RunQuery($sql);	
			$pos = 0;
			while($row = mysql_fetch_array($result))
			{
			?>
              <tr class="<?php 
			  if ($pos % 2 == 0)
					echo "bcgcolor-tblrow";
				else
					echo "bcgcolor-tblrowWhite";
			   ?>">
                <td class="normalfnt"><?php echo  $row["strName"]; ?></td>
                <td class="normalfntRite"><?php echo  $row["intQty"]; ?></td>
                <td class="normalfntRite"><?php echo  $row["fob"]; ?></td>
                <td class="normalfntRite"><?php echo  $row["cm"]; ?>&nbsp;</td>
                <td class="normalfntMid"><?php echo  $row["deliveryDate"]; ?></td>
                <td class="normalfnt"><a href="subbomreport.php?styleID=<?php echo  $styleID; ?>&subcon=<?php echo $row["strSubContractorID"]; ?>" target="_blank"><img src="images/view2.png" border="0" class="noborderforlink" /></a></td>
                <td class="normalfnt"><!-- <a href="buyerPO.php?styleID=<?php echo  $row["intStyleId"]; ?>" target="_blank"><img src="images/view2.png" border="0" class="noborderforlink" /></a> --></td>
              </tr>
              <?php
			  $pos ++;
			}
			?>
            </table>
          </div></td>
        </tr>
      </table></td>
    </tr>
    <tr>
      <td><div align="right"></div></td>
    </tr>
  </table>
</form>
</body>
</html>
