<?php
 session_start();
$backwardseperator = "../../";
include "${backwardseperator}authentication.inc";
$catgory = $_POST["cboCategory"];


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GaPro - Manage Style Item Categories</title>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />

<script src="category.js" type="text/javascript"></script>



</head>

<body>
<form id="frmcomplete" name="frmcomplete" method="post" action="manageCategories.php">
<table width="100%" border="0" align="center" bgcolor="#FFFFFF">
  <tr>
    <td><?php include "../../Header.php";?></td>
  </tr>
  <tr>
    <td>
  <table width="950" border="0" align="center" bgcolor="#FFFFFF">
    <tr>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td><table width="100%" border="0" class="tableBorder1">
        <tr>
          <td colspan="2" class="mainHeading"><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="13%" valign="middle" class="normaltxtmidb2">&nbsp;</td>
              <td width="72%" class="mainHeading">Manage Style Item Categories</td>
              <td width="15%" class="seversion"> (Ver 0.3) </td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td width="4%"></td>
          <td width="96%" class="head1">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="2"><table width="100%" border="0">
            <!--DWLayoutTable-->
            <tr>
              <td width="50%" height="21"><table width="931" border="0">
                <tr>
                  <td width="72"  colspan="2" bgcolor="#99CCFF" class="mainHeading4">Main Category</td>
                  <td width="72" colspan="2" class="txtbox"><select name="cboCategory" class="txtbox" id="cboCategory" style="width:250px">
                    <option value="Select One" selected="selected">Select One</option>
                    <?php
					
$xml = simplexml_load_file('config.xml');
$reportname = $xml->PreOrder->ReportName;

	include "../../Connector.php"; 
	$SQL = "SELECT intID,strDescription FROM matmaincategory;";	
	$result = $db->RunQuery($SQL);		
	while($row = mysql_fetch_array($result))
	{
		if ($catgory == $row["intID"])
		{
			echo "<option selected=\"selected\" value=\"". $row["intID"] ."\">" . $row["strDescription"] ."</option>" ;
		}
		else
		{
			echo "<option value=\"". $row["intID"] ."\">" . $row["strDescription"] ."</option>" ;
		}
	}
	
	?>
                  </select> </td>
                  
						<td class="txtbox" colspan="4">&nbsp;<img src="../../images/search.png" alt="Search" width="80" height="24" class="mouseover" onclick="submitForm();" />                  
                  </td>
                  </tr>

              </table></td>
              </tr>
          </table></td>
          </tr>
        <tr>
          <td colspan="2">
          <div class="tableBorder2" id="divData" style="width:930px; height:400px; overflow: scroll;">
            <table width="910" bgcolor="#CCCCFF" border="0" cellpadding="0" cellspacing="1"  id="tblPreOders" >
              <tr>
                <td width="40%" height="19" bgcolor="#498CC2" class="mainHeading2">Category Name </td>
                <td width="20%" bgcolor="#498CC2" class="mainHeading2">Inspection Required</td>
                <td width="20%" bgcolor="#498CC2" class="mainHeading2">Additional Allowed</td>
                <td bgcolor="#498CC2" class="mainHeading2"></td>
              </tr>
              <?php
			
			
		
			
			$sql = "SELECT intSubCatNo,intCatNo,StrCatName,intDisplay,intInspection,intAdditionalAllowed FROM matsubcategory WHERE intCatNo = $catgory order by StrCatName;" ;
			
			
			
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
                <td height="21" class="normalfnt"><?php echo  $row["StrCatName"]; ?></td>
                <td class="normalfntMid">              
                <?php if ($row["intInspection"]==1){ ?>
                	<input id="<?php echo  $row["intSubCatNo"]; ?>" checked="checked" onChange="changeInspection(this);" type="checkbox" />
                <?php } else { ?>
                <input  id="<?php echo  $row["intSubCatNo"]; ?>"onChange="changeInspection(this);"  type="checkbox" />
                <?php } ?>
                </td>
                <td class="normalfntMid">              
                <?php if ($row["intAdditionalAllowed"]==1){ ?>
                	<input  id="<?php echo  $row["intSubCatNo"]; ?>" onChange="changeAdditionalAllowed(this);" checked="checked" type="checkbox" />
                <?php } else { ?>
                <input  id="<?php echo  $row["intSubCatNo"]; ?>" onChange="changeAdditionalAllowed(this);" type="checkbox" />
                <?php } ?>
                </td>
               
                 <td></td>
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
  </td>
  </tr>
  </table>
</form>
</body>
</html>
