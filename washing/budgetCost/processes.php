<?php
$backwardseperator = "../../";
session_start();
include('../../Connector.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>

<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<style type="text/css">
    #tblPrcBody { height:270px;overflow:scroll;}
</style>
</head>
<body>
<table width="500"  border="0" align="center" bgcolor="#FFFFFF">
    <tr>
    	<td>
        	<table  width="100%" border="0">
            	<tr>
                	<td>
                    	<table width="100%" border="0" class="tableBorder">
                        	
                        	<tr class="cursercross mainHeading" >
                            	<td height="25" colspan="2">Processes</td>
                                <td width="10%" height="25" ><img src="../../images/cross.png" onclick="CloseWindowInBC();" /></td>
                        	</tr>
                           <tr>
                            	<td width="8%" class="normalfnt">Search</td>
                            	<td width="82%" align="left"><input type="text" id="txtPrcSearch" onkeyup="searchProcess(this,event);" style="width:250px"/></td><td>&nbsp;</td>
                          </tr>
                            <tr>
                            	<td colspan="3">
                                	<table style="width:500px" border="0" cellpadding="0" cellspacing="1" bgcolor="#F3E8FF" id="tblPrc">
									<thead>				
                                    	<tr bgcolor="#498CC2" class="normaltxtmidb2" height="20px;">
                                        	<th width="56" class="grid_header" style="width:10px;">Serial</th>
											<th width="143" class="grid_header" style="width:300px;">Process Description</th>
											<th width="60" class="grid_header" style="width:10px;">Liquor</th>
											<th width="53" class="grid_header" style="width:10px;">Temp</th>
											<th width="82" class="grid_header" style="width:10px;">Time</th>
											<th width="79" class="grid_header" style="width:10px;">Time<br/>(Hand)</th>
                                    	</tr>
										</thead>
                                        <tbody >
                                        <?php 
										$SQL_Processes="SELECT intSerialNo,strProcessName,dblLiqour,dblTemp,dblTime,dblHTime FROM was_washformula WHERE intStatus='1' order by strProcessName;";
										$resPrc=$db->RunQuery($SQL_Processes);
										$i=1;
										while($row=mysql_fetch_array($resPrc))
										{
										$color=""; 
											if(($i%2)==1){$color='grid_raw';}else{$color='grid_raw2';}?>
                                        
                                        <tr class="bcgcolor-tblrowWhite" id="<?php echo $i;?>" style="height:20px;cursor:pointer;" ondblclick="addProcesses(this.id);">
                                        	<td class="<?php echo $color;?>"><?php echo $row['intSerialNo'];?></td>
                                            <td style="width:300px;text-align:left;" class="<?php echo $color;?>"><?php echo $row['strProcessName'];?></td>
                                            <td style="width:10px;text-align:right" class="<?php echo $color;?>"><?php echo $row['dblLiqour'];?></td>
                                            <td style="width:10px;text-align:right" class="<?php echo $color;?>"><?php echo $row['dblTemp'];?></td>
                                            <td style="width:10px;text-align:right" class="<?php echo $color;?>"><?php echo $row['dblTime'];?></td>
                                            <td style="width:10px;text-align:right" class="<?php echo $color;?>"><?php echo $row['dblHTime'];?></td>
                                        </tr>
                                        <?php $i++;}?>
                                      </tbody>
                                    </table>                                </td>
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