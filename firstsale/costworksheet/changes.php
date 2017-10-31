<table width="100%" border="0" cellspacing="1" cellpadding="0" bgcolor="#000000">
            
            <tr class="normalfnt" bgcolor="#F7635B">
            <th colspan="5" height="20">Deleted Items</th>
            </tr>
          <tr class="normalfntMid" bgcolor="#CCCCCC">
           <th>Costs of Assists</th>
			<th width="63">Unit</th>
			<th width="83">Unit Price for Assist in USD ($)</th>
			<th width="111">Quantity Consumed Per Product Unit of Measure:</th>
			<th width="111">Unit Price X Qty Consumed = Per Product Cost in USD</th>
          </tr>
          <?php
		  $sql = "select MIL.strItemDescription,OD.strUnit,OD.dblUnitPrice,round(OD.reaConPc,4) as  reaConPc,round(OD.dblUnitPrice*OD.reaConPc,4) as productCost
					from orders O
					inner join orderdetails OD on OD.intStyleId=O.intStyleId
					inner join matitemlist MIL on MIL.intItemSerial=OD.intMatDetailID
					where OD.intMatDetailID not in (select intMatDetailID from firstsalecostworksheetdetail where  intStyleId='$styleId')
					and O.intStyleId='$styleId'";
		$result = $db->RunQuery($sql);	
		while($row = mysql_fetch_array($result))
		{
		?>	
      	    <tr bgcolor="#FFFFFF">
            <td class="normalfnt">&nbsp;<?php echo $row["strItemDescription"];?>&nbsp;</td>
            <td class="normalfntRite">&nbsp;<?php echo $row["strUnit"];?>&nbsp;</td>
            <td class="normalfntRite">&nbsp;<?php echo $row["dblUnitPrice"];?>&nbsp;</td>
            <td class="normalfntRite">&nbsp;<?php echo $row["reaConPc"];?>&nbsp;</td>
            <td class="normalfntRite">&nbsp;<?php echo $row["productCost"];?>&nbsp;</td>
         	 </tr>
        <?php
		}
		?>
        </table>
