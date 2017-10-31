<?php
session_start();
$mainCatId	= $_GET["MainCatId"];
$costId		= $_GET["CostId"];
$itemId		= $_GET["ItemId"];
include('../Connector.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>

<link href="../css/erpstyle.css" rel="stylesheet" type="text/css" />
<style type="text/css">
    #tblPrcBody { height:270px;overflow:scroll;}
</style>
</head>
<body>
<table width="550"  border="0" align="center" bgcolor="#FFFFFF">
    <tr>
    	<td>
        	<table  width="100%" border="0">
            	<tr>
                	<td>
                    	<table width="100%" border="0" class="tableBorder">
                        	
                        	<tr class="cursercross mainHeading" >
                            	<td width="94%" height="25">Multiple GL Allocation Listing</td>
                                <td width="6%" height="25" ><img src="../images/cross.png" onclick="ClosePRPopUp('popupLayer2');" /></td>
                        	</tr>
                           <tr>
                            	<td colspan="2" class="normalfnt">&nbsp;</td>
                       	  </tr>
                            <tr>
                            	<td colspan="2">
                                	<table style="width:550px" border="0" cellpadding="0" cellspacing="1" bgcolor="#F3E8FF" id="tblPopItem1">
									<thead>				
                                    	<tr class="mainHeading4">
                                        	<th width="23" height="25" ><input type="checkbox" onclick="CheckAll(this,'tblPopItem');" style="visibility:hidden"/></th>
											<th width="436" >GL Account Description</th>
											<th width="87" >GL Code</th>
										</tr>
										</thead>
                                        <tbody >
<?php 
$sql="select BAMC.intGlId,GA.strAccID,GA.strDescription,C.strCode,GF.GLAccAllowNo
from budget_glallocationtomaincategory BAMC 
inner join glaccounts GA on GA.intGLAccID = BAMC.intGlId 
inner join glallowcation GF on GF.GLAccNo=GA.intGLAccID
inner join costcenters C on C.intCostCenterId=GF.FactoryCode
where intMatCatId='$mainCatId'  and GF.FactoryCode='$costId' ";
$resPrc=$db->RunQuery($sql);
$i=1;
while($row=mysql_fetch_array($resPrc))
{
?>                                   
<tr class="bcgcolor-tblrowWhite">
<td height="20" class="normalfntMid" id="<?php echo $row['GLAccAllowNo'];?>"><input name="checkbox" type="checkbox" onclick="AddDetailsToMainTbl_Multiple(this)"></td>
<td class="normalfnt" id="<?php echo $itemId;?>"><?php echo $row['strDescription'];?></td>
<td class="normalfnt" id="<?php echo $row['GLAccAllowNo'];?>"><?php echo $row['strAccID'].''.$row['strCode'];?></td>
</tr>
                                        <?php $i++;}?>
                                      </tbody>
                                    </table>                                </td>
                            </tr>
                         </table>                    </td>
                </tr>
            </table>         </td>
     </tr>
</table>
</body>
</html>