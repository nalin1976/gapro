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
<style type="text/css">
    #tblPrcBody { height:170px;  overflow:scroll;}
</style>
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
                        	<tr class="cursercross" onmousedown="grab(document.getElementById('frmProcess'),event);">
                            	<td height="35" class="mainHeading" colspan="3">Processes</td>
                            </tr>
                           <tr>
                            	<td class="normalfnt">Search</td><td><input type="text" id="txtPrcSearch" onkeypress="searchProcess(this);" /></td><td>&nbsp;<img src="../../../images/search.png" /></td>
                            </tr>
                            <tr>
                            	<td colspan="3">
                                	<table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#F3E8FF" id="tblPrc">					
                                    	<tr bgcolor="#498CC2" class="normaltxtmidb2" height="20px;">
                                        	<td style="width:10px;">Serial</td><td style="width:100px;">Process Description</td><td style="width:50px;">Liquor</td><td style="width:50px;">Temp</td><td style="width:50px;">Time</td><td style="width:50px;">Time(Hand)</td>
                                 		</tr>
                                        <tbody id="tblPrcBody">
                                        <?php 
										$SQL_Processes="SELECT intSerialNo,strProcessName,dblLiqour,dblTemp,dblTime,dblHTime FROM was_washformula;";
										$resPrc=$db->RunQuery($SQL_Processes);
										$i=1;
										while($row=mysql_fetch_array($resPrc))
										{
										$color=""; 
											if(($i%2)==1){$color='#CCC';}else{$color='#CCF';}?>
                                        
                                        <tr class="bcgcolor-tblrowWhite" id="<?php echo $i;?>" style="height:20px;cursor:pointer;" ondblclick="addProcesses(this.id);">
                                        	<td class="normalfnt"><?php echo $row['intSerialNo'];?></td>
                                            <td style="width:100px;" class="normalfnt"><?php echo $row['strProcessName'];?></td>
                                            <td style="width:50px;" class="normalfnt"><?php echo $row['dblLiqour'];?></td>
                                            <td style="width:50px;" class="normalfnt"><?php echo $row['dblTemp'];?></td>
                                            <td style="width:50px;" class="normalfnt"><?php echo $row['dblTime'];?></td>
                                            <td style="width:50px;" class="normalfnt"><?php echo $row['dblHTime'];?></td>
                                 		</tr>
                                        <?php $i++;}?>
                                      </tbody>
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