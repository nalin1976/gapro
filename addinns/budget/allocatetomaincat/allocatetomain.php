<?php
	include('../../../Connector.php');	
	$backwardseperator = "../../../";
	include "../../../authentication.inc";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GaPro | Allocate GL to main category</title>
<link href="../../../css/erpstyle.css" rel="stylesheet" type="text/css" />

<!--<link href="../../js/jquery-ui-1.8.9.custom.css" rel="stylesheet" type="text/css" />-->
<!--<link href="../../css/tableGrib.css" rel="stylesheet" type="text/css" />-->

<!--<script src="../../js/jquery-1.4.2.min.js" type="text/javascript"></script>-->
<script src="../../../javascript/jquery.js"></script>
<script src="../../../javascript/script.js" type="text/javascript"></script>
<script src="allocatemain.js" type="text/javascript"></script>

</head>

<body>
<!--<form id="frmAllocateMain" name="frmAllocateMain">-->
<table width="100%" border="0" align="center" bgcolor="#FFFFFF">
	<tr>
		<td height="6" colspan="2"><?php include($backwardseperator.'Header.php'); ?></td>
	</tr> 
</table>
<table width="608" border="0"  align="center" class="tableBorder" bgcolor="#FFFFFF">
  <tr>
  	<td width="600" class="mainHeading">Allocate GL to main category</td>
  </tr>
  <tr>
    <td>
        <table width="600" border="0" cellpadding="0" cellspacing="0" class="normalfnt">
            <tr>
                <td>
                    <table width="600" border="0"  cellpadding="1" cellspacing="0">
                        <tr>
                            <td>
                                <!--<fieldset class="fieldsetStyle" style="width:800px;-moz-border-radius: 5px;">-->
                                <table width="600" border="0" align="center" cellpadding="1" cellspacing="4" class="normalfnt">
                                    <tr>
                                      <td width="1%" colspan="0"></td>
                                      <td width="9%">Search </td>
                                      <td width="90%"><input type="text" name="txtSearch" id="txtSearch" class="txtbox" style="width:200px;" onkeypress="searchCategory(this,event);" maxlength="30" /></td>
                                    </tr>
                                </table>
                                <!--</fieldset>-->
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td></td>
            </tr>
            <tr>
                <td height="17" class="containers"><div align="center"><b>Details</b></div></td>
            </tr>
            <tr>
                <td>	
                <!--<fieldset class="fieldsetStyle" style="width:800px;-moz-border-radius: 5px;">-->
                <div id="txtemp"  style="height:320px;">
              <table width="602" height="26" border="0" cellpadding="0" cellspacing="1" bgcolor="#F3E8FF" id="tblMain">
                <thead>
                <tr bgcolor="#498CC2" class="normaltxtmidb2">
                    
                    <td width="33" height="20" class="grid_header" >No</td>
                    <td width="368" class="grid_header" >Main Category </td>
                    <td width="197" class="grid_header" >Add GL</td>
                    </tr>
					
					
					                
                </thead>
                <tbody id="tblDet">
				
				<?php
					$sql="select intID,strDescription from genmatmaincategory where status=1 order by strDescription;";
					$result=$db->RunQuery($sql);
					$i=1;
					
					while($row=mysql_fetch_array($result))
						{
							$color=""; 
							if(($i%2)==1){$color='grid_raw';}else{$color='grid_raw2';}?>
							<tr class="bcgcolor-tblrowWhite" id="<?php echo $i;?>" >
							<td class="<?php echo $color;?>"><?php echo $i;?></td>
							<td style="width:300px;text-align:left;" class="<?php echo $color;?>"><?php echo $row['strDescription'];?></td>
							<td align="center" class="<?php echo $color;?>" id="<?php echo $row['intID'];?>"><img src="../../../images/additem2.png" onclick="loadGLPopUp(this,event);" style="cursor:pointer;"/></td>
							
							<?php $i++;} ?>
							</tr>
				
                </tbody>
               </table>
              </div>
               <!-- </fieldset>-->
                </td>
            </tr>
           
            <tr>
                <td width="600">
                    <table width="600" border="0" cellpadding="0" cellspacing="0" align="center">
                  <tr height="8">
                    <td></td>
                  </tr>
                  <tr>
                    <td>
                        <table width="600"align="center" class="tableBorder">
                            <tr>
                                <td width="600" height="26" align="center"><img src="../../../images/new.png" width="96" height="24" class="mouseover" id='btnNew' onclick="resetAll();" tabindex="22" /><a href="../../../main.php"><img src="../../../images/close.png" border="0" class="mouseover" id="closeIMG" style="display:inline"/></a>                                </td>
                            </tr>
                      </table>
                    </td>
                  </tr>
                </table>
                </td>
            </tr>
        </table>
    </td>
  </tr>
</table>
</body>
</html>