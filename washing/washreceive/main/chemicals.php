<?php
$backwardseperator = "../../../";
session_start();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>

<link href="../../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<script src=".js"></script>
</head>

<body>

<?php
include "../../../Connector.php";

?>
<table width="100%"  border="0" align="center" bgcolor="#FFFFFF">
    <tr>
    	<td>
        	<table  width="100%" border="0">
            	<tr>
                	<td>
                    	<table width="100%" border="0" class="tableBorder">
                        	<tr><td align="right" colspan="3"><img src="../../../images/closelabel.gif" onclick="CloseWindow();" style="width:40px;" /></td></tr>
                        	<tr class="cursercross" onmousedown="grab(document.getElementById('frmChemicals'),event);">
                            	<td height="35" class="mainHeading" colspan="3">Chemicals</td>
                            </tr>
                            <tr>
                            	<td colspan="3">
                                    <div style="overflow:scroll;height:170px;">
                                	<table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#F3E8FF" id="tblChm">
                                    	<tr bgcolor="#498CC2" class="normaltxtmidb2">
                                        	<td>Nc</td><td style="width:100px;">Chemical Description</td><td style="width:50px;">Unit</td><td style="width:50px;">Qty</td><td style="width:50px;">Unit Price</td><td style="width:50px;">Time(Hand)</td>
                                 		</tr>
                                        <?php 
										$prcId=$_GET['prcId'];
										$SQL_Chemicals="SELECT 
														wc.intSerialNo,
														wcl.strItemDescription,
														wcl.strUnit,
														wc.dblQty,
														wc.dblUnitPrice 
														FROM was_chemmatitemlist wcl,
														was_chemical wc
														WHERE 
														wcl.intSerialNo = wc.intSerialNo 
														AND intStatus=1 
														AND 
														wc.intProcessId= $prcId;";
										$resChm=$db->RunQuery($SQL_Chemicals);
										$i=1;
										while($row=mysql_fetch_array($resChm))
										{
										$color=""; 
											if(($i%2)==1){$color='#CCC';}else{$color='#CCF';}?>
                                        
                                        <tr class="bcgcolor-tblrowWhite" id="<?php echo $i;?>" style="height:20px;cursor:pointer;">
                                        	<td class="normalfnt"><?php echo $row['intSerialNo'];?></td>
                                            <td style="width:100px;" class="normalfnt">
                                            	<?php echo $row['strItemDescription'];?>"
                                            </td>
                                            <td style="width:50px;" class="normalfnt">
                                            	<?php echo $row['strUnit'];?>"
                                            </td>
                                            <td style="width:50px;"  class="normalfnt">
                                                <input type="text" id="<?php echo "txtQty$i";?>"  value="<?php echo $row['dblQty'];?>" style="width:50px;" onkeypress="return CheckforValidDecimal(this.value,3,event)"/>
                                            </td>
                                            <td style="width:50px;"  class="normalfnt">
												<input type="text" style="width:50px;" value="<?php echo $row['dblUnitPrice'];?>" onkeypress="return CheckforValidDecimal(this.value,2,event)" />
                                            </td>
                                            <td style="width:50px;"  class="normalfnt"><input type="checkbox" id="<?php echo "chkChm$i";?>" /></td>
                                 		</tr>
                                        <?php $i++;}?>
                                      
                                    </table>  
                                    </div>
                                </td>
                            </tr>
                            <tr><td> <img src="../../../images/save.png" onclick="selectChemicals();" /><input type="hidden" id="hdnVal" /> </td></tr>
                         </table>
                    </td>
                </tr>
            </table>
         </td>
     </tr>
</table>
</body>
</html>