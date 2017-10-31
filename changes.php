<table width="100%" border="0" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC" class="tablez">
	 <tr>
          <td colspan="13" class="normalfnBLD1TAB" >Modifications</td> 
           </tr>
<tr>
          <td colspan="13" class="normalfnBLD1TAB" >&nbsp;</td> 
           </tr>
	<?php
		$styleID = $_GET["styleID"];
		$latestRevision = -1;
	
		$isBasicInfoRequired = false;
		$orderQtyChanged = false;
		$excessChanged = false;
		$subcontractQtyChanged = false;
		$financeChanged = false;
		$effLevelChanged = false;
		$smvChanged = false;
		$fobChaned = false;
		$upchargeChanged = false;
		$labourCostChanged = false;
		
		$newOrderQty = 0;
		$newExcessqty = 0 ;
		$newSubContractQty = 0;
		$newFinance = 0;
		$newEffLevel = 0;
		$newSMV = 0;
		$newFOB = 0;
		$newUpCharge = 0;
		$newLabourCost = 0;
		
		$previousOrderQty = 0;
		$previousExcessqty = 0 ;
		$previousSubContractQty = 0;
		$previousFinance = 0;
		$previousEffLevel = 0;
		$previousSMV = 0;
		$previousFOB = 0;
		$previousUpCharge = 0;
		$previousLabourCost = 0;
		$strRevicedReason = "";
		
		
		$hasHistory = false;
		
		$sql = "SELECT intQty, reaSMV,reaSMVRate,reaFOB,reaFinance, strRevisedReason, reaExPercentage,reaFinPercntage,reaEfficiencyLevel,intSubContractQty,reaUPCharges,reaLabourCost 
FROM orders
WHERE intStyleId = '$styleID'";
		$result = $db->RunQuery($sql);
		
		while($row = mysql_fetch_array($result))
		{	
			$newOrderQty = $row["intQty"] ;
			$newExcessqty = $row["reaExPercentage"]  ;
			$newSubContractQty = $row["intSubContractQty"] ;
			$newFinance = $row["reaFinance"] ;
			$newEffLevel = $row["reaEfficiencyLevel"] ;
			$newSMV = $row["reaSMV"] ;
			$newFOB = $row["reaFOB"] ;
			$newUpCharge = $row["reaUPCharges"] ;
			$newLabourCost = $row["reaLabourCost"] ;	
			$strRevicedReason= $row["strRevisedReason"] ;	
			
		}
		
		$sql = "SELECT  intQty, reaSMV,reaSMVRate,reaFOB,reaFinance,reaExPercentage,reaFinPercntage,reaEfficiencyLevel,intSubContractQty,reaUPCharges,reaLabourCost,intApprovalNo   
FROM history_orders 
WHERE intStyleId = '$styleID'  ORDER BY intApprovalNo DESC  LIMIT 1";
		$result = $db->RunQuery($sql);
		while($row = mysql_fetch_array($result))
		{
			$hasHistory = true;
			$previousOrderQty = $row["intQty"] ;
			$previousExcessqty = $row["reaExPercentage"]  ;
			$previousSubContractQty = $row["intSubContractQty"] ;
			$previousFinance = $row["reaFinance"] ;
			$previousEffLevel = $row["reaEfficiencyLevel"] ;
			$previousSMV = $row["reaSMV"] ;
			$previousFOB = $row["reaFOB"] ;
			$previousUpCharge = $row["reaUPCharges"] ;
			$previousLabourCost = $row["reaLabourCost"] ;
			$latestRevision = $row["intApprovalNo"] ;

			if ($newOrderQty != $previousOrderQty)
			{
				$isBasicInfoRequired = true;
				$orderQtyChanged = true;
			}
			
			if ($newExcessqty != $previousExcessqty)
			{
				$isBasicInfoRequired = true;
				$excessChanged = true;
			}
			if ($newSubContractQty != $previousSubContractQty)
			{
				$isBasicInfoRequired = true;
				$subcontractQtyChanged = true;
			}
			if ($newFinance != $previousFinance)
			{
				$isBasicInfoRequired = true;
				$financeChanged = true;
			}
			if ($newEffLevel != $previousEffLevel)
			{
				$isBasicInfoRequired = true;
				$effLevelChanged = true;
			}
			if ($newSMV != $previousSMV)
			{
				$isBasicInfoRequired = true;
				$smvChanged = true;
			}
			if ($newFOB != $previousFOB)
			{
				$isBasicInfoRequired = true;
				$fobChaned = true;
			}
			if ($newUpCharge != $previousUpCharge)
			{
				$isBasicInfoRequired = true;
				$upchargeChanged = true;
			}
			if ($newLabourCost != $previousLabourCost)
			{
				$isBasicInfoRequired = true;
				$labourCostChanged = true;
			}
		}
		if($isBasicInfoRequired)
		{
	?>
          <tr>
          <td colspan="13" bgcolor="#CCCCCC" class="normalfnBLD1TAB" >Previous Revision Information</td> 
           </tr>
          <?php
          if($orderQtyChanged)
          {
          ?>
            <tr>
          <td class="normalfntTAB" colspan="11">Order Quantity</td> 
           <td class="normalfntRiteTAB"><?php echo $previousOrderQty; ?></td>
           </tr>
           <?php
           }
            if($excessChanged)
          {
          ?>
            <tr>
          <td class="normalfntTAB" colspan="11">Excess Percentage</td> 
           <td class="normalfntRiteTAB"><?php echo $previousExcessqty; ?></td>
           </tr>
           <?php
           }
           if($subcontractQtyChanged)
          {
          ?>
            <tr>
          <td class="normalfntTAB" colspan="11">Sub Contract Quantity</td> 
           <td class="normalfntRiteTAB"><?php echo $previousSubContractQty; ?></td>
           </tr>
           <?php
           }
			if($financeChanged)
          {
          ?>
            <tr>
          <td class="normalfntTAB" colspan="11">Finance Percentage</td> 
           <td class="normalfntRiteTAB"><?php echo $previousFinance; ?></td>
           </tr>
           <?php
           }
			if($effLevelChanged)
          {
          ?>
            <tr>
          <td class="normalfntTAB" colspan="11">Efficiency Level</td> 
           <td class="normalfntRiteTAB"><?php echo $previousEffLevel; ?></td>
           </tr>
           <?php
           }
           if($smvChanged)
          {
          ?>
            <tr>
          <td class="normalfntTAB" colspan="11">SMV</td> 
           <td class="normalfntRiteTAB"><?php echo $previousSMV; ?></td>
           </tr>
           <?php
           }
            if($fobChaned)
          {
          ?>
            <tr>
          <td class="normalfntTAB" colspan="11">FOB</td> 
           <td class="normalfntRiteTAB"><?php echo $previousFOB; ?></td>
           </tr>
           <?php
           }
            if($upchargeChanged)
          {
          ?>
            <tr>
          <td class="normalfntTAB" colspan="11">Up Charge</td> 
           <td class="normalfntRiteTAB"><?php echo $previousUpCharge; ?></td>
           </tr>
           <?php
           }
           if($labourCostChanged)
          {
          ?>
            <tr>
          <td class="normalfntTAB" colspan="11">Labour Cost</td> 
           <td class="normalfntRiteTAB"><?php echo $previousLabourCost; ?></td>
           </tr>
           <?php
           }
           ?>
           
           <?php
           }
           	if ($hasHistory)
           	{
           $sql = "SELECT intMatDetailID,orderdetails.strUnit, dblTotalValue, orderdetails.dblUnitPrice,reaConPc,reaWastage,strOriginType,dblFreight, matitemlist. strItemDescription
FROM orderdetails   
INNER JOIN itempurchasetype ON orderdetails.intOriginNo = itempurchasetype.intOriginNo
INNER JOIN matitemlist ON orderdetails.intMatDetailID = matitemlist.intItemSerial
WHERE  
intMatDetailID NOT IN (SELECT intMatDetailID FROM history_orderdetails WHERE intStyleId = '$styleID' AND  intApprovalNo = '$latestRevision'  ) AND  intStyleId = '$styleID' ";
				$result = $db->RunQuery($sql);
				if( mysql_num_rows($result) > 0)
				{
				?>
				<tr>
          <td colspan="13" bgcolor="#CCFF33" class="normalfnBLD1TAB" >Newly Added Items</td> 
           </tr>
           <tr bgcolor="#CCCCCC">
          <td class="normalfntTAB" colspan="6">Item Description</td>
           <td class="normalfntMidTAB">Origin</td>
           <td class="normalfntMidTAB">Unit</td>
           <td class="normalfntRiteTAB" >Consumption</td>
           <td class="normalfntRiteTAB" >Wastage</td>
           <td class="normalfntRiteTAB" >Unit Price</td>
           <td class="normalfntRiteTAB">Freight</td>
           <td class="normalfntRiteTAB">Tot Value</td>
           </tr>
				<?php
				}
				while($row = mysql_fetch_array($result))
				{
           ?>
            <tr>
          <td class="normalfntTAB" colspan="6"><?php echo $row["strItemDescription"]; ?></td>
           <td class="normalfntMidTAB"><?php echo $row["strOriginType"]; ?></td>
           <td class="normalfntMidTAB"><?php echo $row["strUnit"]; ?></td>
           <td class="normalfntRiteTAB" ><?php echo $row["reaConPc"]; ?></td>
           <td class="normalfntRiteTAB" ><?php echo $row["reaWastage"]; ?></td>
           <td class="normalfntRiteTAB" ><?php echo $row["dblUnitPrice"]; ?></td>
           <td class="normalfntRiteTAB"><?php echo $row["dblFreight"]; ?></td>
           <td class="normalfntRiteTAB"><?php echo $row["dblTotalValue"]; ?></td>
           </tr>
           <?php
           }
           }
            $sql = "SELECT intMatDetailID,history_orderdetails.strUnit,dblTotalValue, history_orderdetails.dblUnitPrice,reaConPc,reaWastage,strOriginType,dblFreight, matitemlist. strItemDescription
FROM history_orderdetails   
INNER JOIN itempurchasetype ON history_orderdetails.intOriginNo = itempurchasetype.intOriginNo
INNER JOIN matitemlist ON history_orderdetails.intMatDetailID = matitemlist.intItemSerial
WHERE 
intMatDetailID NOT IN (SELECT intMatDetailID FROM orderdetails WHERE intStyleId = '$styleID'  ) AND  intStyleId = '$styleID'  AND  intApprovalNo = '$latestRevision' ";
				$result = $db->RunQuery($sql);
				if( mysql_num_rows($result) > 0)
				{
				?>
				<tr>
          <td colspan="13" bgcolor="#FF6633" class="normalfnBLD1TAB" >Deleted Items</td> 
           </tr>
           <tr bgcolor="#CCCCCC">
          <td class="normalfntTAB" colspan="6">Item Description</td>
           <td class="normalfntMidTAB">Origin</td>
           <td class="normalfntMidTAB">Unit</td>
           <td class="normalfntRiteTAB" >Consumption</td>
           <td class="normalfntRiteTAB" >Wastage</td>
           <td class="normalfntRiteTAB" >Unit Price</td>
           <td class="normalfntRiteTAB">Freight</td>
           <td class="normalfntRiteTAB">Tot Value</td>
           </tr>
				<?php
				}
				while($row = mysql_fetch_array($result))
				{
           ?>
            <tr>
          <td class="normalfntTAB" colspan="6"><?php echo $row["strItemDescription"]; ?></td>
           <td class="normalfntMidTAB"><?php echo $row["strOriginType"]; ?></td>
           <td class="normalfntMidTAB"><?php echo $row["strUnit"]; ?></td>
           <td class="normalfntRiteTAB" ><?php echo $row["reaConPc"]; ?></td>
           <td class="normalfntRiteTAB" ><?php echo $row["reaWastage"]; ?></td>
           <td class="normalfntRiteTAB" ><?php echo $row["dblUnitPrice"]; ?></td>
           <td class="normalfntRiteTAB"><?php echo $row["dblFreight"]; ?></td>
           <td class="normalfntRiteTAB"><?php echo $row["dblTotalValue"]; ?></td>
           </tr>
           <?php
           }
           $sql = "SELECT  history_orderdetails.intMatDetailID,
history_orderdetails.strUnit AS oldUnit, orderdetails.strUnit AS newunit, orderdetails.dblTotalValue as newtotvalue,history_orderdetails.dblTotalValue as oldtotvalue , 
history_orderdetails.dblUnitPrice AS oldPrice , orderdetails.dblUnitPrice AS newPrice ,
history_orderdetails.reaConPc AS oldConPC,  orderdetails.reaConPc AS newConPc ,
history_orderdetails.reaWastage AS oldWastage, orderdetails.reaWastage AS newWastage,
(SELECT strOriginType FROM itempurchasetype WHERE   itempurchasetype.intOriginNo =  history_orderdetails.intOriginNo ) AS oldOrigin , 
(SELECT strOriginType FROM itempurchasetype WHERE   itempurchasetype.intOriginNo =  orderdetails.intOriginNo ) AS newOrigin , 
history_orderdetails.dblFreight AS oldFreight , orderdetails.dblFreight AS newFreight ,
matitemlist. strItemDescription
FROM history_orderdetails   
INNER JOIN matitemlist ON history_orderdetails.intMatDetailID = matitemlist.intItemSerial
INNER JOIN orderdetails ON orderdetails.intStyleId = history_orderdetails.intStyleId AND orderdetails.intMatDetailID = history_orderdetails.intMatDetailID  AND  orderdetails.intMatDetailID = matitemlist.intItemSerial
WHERE 
history_orderdetails.intStyleId = '$styleID'  AND  history_orderdetails.intApprovalNo = '$latestRevision'  ";

				$result = $db->RunQuery($sql);
				$firstRow = true;
				while($row = mysql_fetch_array($result))
				{
				$foundMismatch = false;
				if ($row["oldUnit"] != $row["newunit"] || $row["oldPrice"] != $row["newPrice"] || $row["oldConPC"] != $row["newConPc"] || $row["oldWastage"] != $row["newWastage"] || $row["oldOrigin"] != $row["newOrigin"] || $row["oldFreight"] != $row["newFreight"])
				{
						$foundMismatch = true;
				}
				if ($foundMismatch )
				{
				
				if($firstRow)
				{
           ?>
           	<tr>
          <td colspan="<?php
           if ($displayShortage == "true")
           		echo "14";
           else
           		echo "13";
           ?>" bgcolor="#7A7AFF" class="normalfnBLD1TAB" >Modified Items</td> 
           </tr>
           <tr bgcolor="#CCCCCC">
          <td class="normalfntTAB" colspan="6">Item Description</td>
           <td class="normalfntMidTAB">Origin</td>
           <td class="normalfntMidTAB">Unit</td>
           <td class="normalfntRiteTAB" >Consumption</td>
           <td class="normalfntRiteTAB" >Wastage</td>
           <td class="normalfntRiteTAB" >Unit Price</td>
           <td class="normalfntRiteTAB">Freight</td>
           <td class="normalfntRiteTAB">Tot Value</td>
           <?php
           if ($displayShortage == "true")
           {
           ?>
           <td class="normalfntRiteTAB">Shortage</td>
           <?php
           }
           ?>
           </tr>
           	<?php
           		$firstRow = false;
           	}
           		?>
				
			<?php
			if($displayVariationInDeferentColor=="true"){
				$red	= "error1";
				$green	= "txtgreen";
			}
			else{
				$red	= "error1";
				$green	= "error1";
			}
			?>
			 <tr>
          <td class="normalfntTAB" colspan="6"><?php echo $row["strItemDescription"]; ?></div></td>
           <td class="normalfntMidTAB"><div <?php if ($row["oldOrigin"] != $row["newOrigin"]) {  ?>class="error1" <?php } ?>><?php echo $row["oldOrigin"]; ?></div></td>
           <td class="normalfntMidTAB"><div <?php if ($row["oldUnit"] != $row["newunit"]) {  ?>class="error1" <?php } ?>><?php echo $row["oldUnit"]; ?></div></td>
           <td class="normalfntRiteTAB" ><div 
		   <?php if ($row["oldConPC"] < $row["newConPc"]) {  ;?>
		   		class="<?php echo $red;?>"
		   <?php }elseif ($row["oldConPC"] > $row["newConPc"]){;?>
		    	class="<?php echo $green;?>" 
		   <?php } ?> >
		   <?php echo number_format($row["oldConPC"],4); ?></div></td>
		   
           <td class="normalfntRiteTAB" ><div 
		   <?php if ($row["oldWastage"] < $row["newWastage"]) {  ?>
		   		class="<?php echo $red;?>" 
		   <?php }else if ($row["oldWastage"] > $row["newWastage"]){ ?>
		   		class="<?php echo $green;?>" 
		   <?php } ?>>
		   <?php echo round($row["oldWastage"]); ?></div></td>
		   
           <td class="normalfntRiteTAB" ><div 
		   <?php if ($row["oldPrice"] < $row["newPrice"]) {  ?>
		   		class="<?php echo $red;?>" 
			<?php }elseif(($row["oldPrice"] > $row["newPrice"])){?>
				class="<?php echo $green;?>"
				<?php } ?>>
			<?php echo number_format($row["oldPrice"],4); ?></div></td>
			
           <td class="normalfntRiteTAB"><div 
		   <?php if ($row["oldFreight"] < $row["newFreight"]) {  ?>
		   		class="<?php echo $red;?>"
			<?php }elseif($row["oldFreight"] > $row["newFreight"]){?>
				class="<?php echo $green;?>"
			<?php } ?>> 
			<?php echo round($row["oldFreight"],4); ?></div></td>
			
           <td class="normalfntRiteTAB"><div 
		   <?php if ($row["oldtotvalue"] < $row["newtotvalue"]) {  ?>
		   		class="<?php echo $red;?>"
			<?php }elseif($row["oldtotvalue"] > $row["newtotvalue"]){?>
				class="<?php echo $green;?>"	
			<?php } ?>> 
			<?php echo number_format($row["oldtotvalue"],4); ?></div></td>
           
		   <?php
           if ($displayShortage == "true")
           {
           	 if ($row["oldtotvalue"] != $row["newtotvalue"]) 
           	 {		 
           	 	$shortage = $row["newtotvalue"] - $row["oldtotvalue"];
           ?>
           <td class="normalfntRiteTAB"><div
		   <?php if ($row["oldtotvalue"] < $row["newtotvalue"]) {  ?>
		   		class="<?php echo $red;?>"
			<?php }elseif($row["oldtotvalue"] > $row["newtotvalue"]){?>
				class="<?php echo $green;?>"	
			<?php } ?>> 
		   
		   <?php echo number_format($shortage,4); ?></div></td>
            <?php
            }
           }
           ?>
           </tr>
           <?php
           }
           }
           ?>
				<tr>
          <td colspan="<?php
           if ($displayShortage == "true")
           		echo "14";
           else
           		echo "13";
           ?>" class="normalfntTAB" >Revised Reason : <br> <?php echo $strRevicedReason; ?></td> 
           </tr>
          </table>