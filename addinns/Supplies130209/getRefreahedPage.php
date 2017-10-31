<?php
/************************************************************
Author:Hemanthi Buddhini Gonsal Korala
File Name:gapzgetOperators.php.
Date:2009-12-
Targets:
		(1).Operators ID wise searching facility to view relevant operators informations  
		
Related Files:
		(1). gapzoperators.php		
		
Related tables:
		(1). tbloperators		

************************************************************/
include "../../Connector.php";
$q=$_GET["q"];
$arr=explode("*",$q);
$val=$arr[0];
$cbo=$arr[1];

if($cbo==1){
?>
<select name="cbocurrency" class="txtbox" id="cbocurrency" style="width:100px">
							<?php
			$SQL="SELECT currencytypes.strCurrency,currencytypes.strTitle,currencytypes.dblRate FROM currencytypes WHERE (((currencytypes.intStatus)=1));";
			
		$result = $db->RunQuery($SQL);
		
		echo "<option value=\"". "" ."\">" . "" ."</option>" ;
	
	while($row = mysql_fetch_array($result))
	{
	if($val==$row["strCurrency"]){
		echo "<option value=\"". $row["strCurrency"] ."\"  selected=\""."selected"."\">" . $row["strCurrency"] ."</option>" ;
		}
		else{
		echo "<option value=\"". $row["strCurrency"] ."\">" . $row["strCurrency"] ."</option>" ;
		}
	}
		  
					?> 	
						
						
						
						
                        </select>
                          <img  src="../../images/addmark.png" size="1" onclick="openr('currency')" />
			<?php
	}
//-----------------------------------------------------------------------------------------			
if($cbo==2){
?>
<select name="cboshipment" class="txtbox" id="cboshipment" style="width:100px">
                          <option value="0" selected="selected">Select One</option>
                          <?php
	
	$SQL = "SELECT strDescription,intShipmentModeId FROM shipmentmode s where intStatus='1';";	
	$result = $db->RunQuery($SQL);		
	while($row = mysql_fetch_array($result))
	{
	if($val==$row["intShipmentModeId"]){
	echo "<option value=\"". $row["intShipmentModeId"] ."\" selected=\""."selected"."\">" . $row["strDescription"] ."</option>" ;
		}
		else{
	echo "<option value=\"". $row["intShipmentModeId"] ."\">" . $row["strDescription"] ."</option>" ;
	}
	}
	
	?>
                        </select>  <img  src="../../images/addmark.png" size="1" onclick="openr('shipment')" />
			<?php
	}
//-----------------------------------------------------------------------------------------			
if($cbo==3){
?>
<select name="cboshipmentTerm" class="txtbox" id="cboshipmentTerm" style="width:100px">
                          <option value="0" selected="selected">Select One</option>
                          <?php
	
	$SQL = "SELECT strShipmentTerm,strShipmentTermId FROM shipmentterms s where intStatus='1';";	
	$result = $db->RunQuery($SQL);		
	while($row = mysql_fetch_array($result))	{
	if($val==$row["strShipmentTermId"]){
		echo "<option value=\"". $row["strShipmentTermId"] ."\"  selected=\""."selected"."\">" . $row["strShipmentTerm"] ."</option>" ;
		}
		else{
	echo "<option value=\"". $row["strShipmentTermId"] ."\">" . $row["strShipmentTerm"] ."</option>" ;
		}
	}
		  
					?> 	
						
						
						
						
                        </select>
                          <img  src="../../images/addmark.png" size="1" onclick="openr('shipmentTerms')" />
			<?php
	}
//-----------------------------------------------------------------------------------------			
if($cbo==4){
?>
<select name="cbopaymode" class="txtbox" id="cbopaymode" style="width:100px">
                          <?php
	
	$SQL = "SELECT strPayModeId,strDescription FROM popaymentmode p where intstatus='1';";	
	$result = $db->RunQuery($SQL);		
	while($row = mysql_fetch_array($result))	{
	if($val==$row["strPayModeId"]){
			echo "<option selected=\"selected\" value=\"". $row["strPayModeId"] ."\">" . $row["strDescription"] ."</option>" ;
		}
		else{
			echo "<option value=\"". $row["strPayModeId"] ."\">" . $row["strDescription"] ."</option>" ;
		}
	}
		  
					?> 	
						
						
						
						
                        </select>
                          <img  src="../../images/addmark.png" size="1" onclick="openr('payMode')" />
			<?php
	}
//-----------------------------------------------------------------------------------------			
if($cbo==5){
?>
<select name="cbopayterms" class="txtbox" id="cbopayterms" style="width:100px">
                          <?php
	
	$SQL = "SELECT strPayTermId,strDescription FROM popaymentterms p where intStatus='1';";	
	$result = $db->RunQuery($SQL);		
	while($row = mysql_fetch_array($result))	{
	if($val==$row["strPayTermId"]){
			echo "<option selected=\"selected\" value=\"". $row["strPayTermId"] ."\">" . $row["strDescription"] ."</option>" ;
		}
		else{
			echo "<option value=\"". $row["strPayTermId"] ."\">" . $row["strDescription"] ."</option>" ;
		}
	}
		  
					?> 	
						
						
						
						
                        </select>
                         <img  src="../../images/addmark.png" size="1" onclick="openr('payTerms')" />
			<?php
	}
//-----------------------------------------------------------------------------------------			
if($cbo==6){
?>
<select name="cbotax" class="txtbox" id="cbotax" style="width:100px">
                      <?php
					  $SQL_taxtype="SELECT taxtypes.strTaxTypeID,taxtypes.strTaxType FROM taxtypes";
					  $result_taxtype = $db->RunQuery($SQL_taxtype);
						
					  echo "<option value=\"". "" ."\">" . "" ."</option>" ;	
					  while($row = mysql_fetch_array($result_taxtype))	{
	if($val==$row["strTaxTypeID"]){
		echo "<option value=\"". $row["strTaxTypeID"] ."\"  selected=\""."selected"."\">" . $row["strTaxType"] ."</option>" ;
		}
		else{
	echo "<option value=\"". $row["strTaxTypeID"] ."\">" . $row["strTaxType"] ."</option>" ;
		}
	}
		  
					?> 	
						
						
						
						
                        </select>
                          <img  src="../../images/addmark.png" size="1" onclick="openr('taxType')" />
			<?php
	}
//-----------------------------------------------------------------------------------------			
if($cbo==7){
?>
<select name="cbocredit" class="txtbox" id="cbocredit" style="width:100px">
					<?php
$SQL_creditper="SELECT creditperiods.intSerialNO,creditperiods.strDescription FROM creditperiods";
$result_creditper = $db->RunQuery($SQL_creditper);

echo "<option value=\"". "" ."\">" . "" ."</option>" ;	
while($row = mysql_fetch_array($result_creditper))	{
	if($val==$row["intSerialNO"]){
		echo "<option value=\"". $row["intSerialNO"] ."\"  selected=\""."selected"."\">" . $row["strDescription"] ."</option>" ;
		}
		else{
	echo "<option value=\"". $row["intSerialNO"] ."\">" . $row["strDescription"] ."</option>" ;
		}
	}
		  
					?> 	
						
						
						
						
                        </select>
                          <img  src="../../images/addmark.png" size="1" onclick="openr('creditPeriod')" />
			<?php
	}
//-----------------------------------------------------------------------------------------			
			?>