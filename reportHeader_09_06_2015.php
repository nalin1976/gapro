<script src="<?php echo $backwardseperator;?>js/jquery-1.4.2.min.js"></script>
<table width="100%" border="0" align="center" cellpadding="0">
	<tr>
		<td width="100%" colspan="3"><table width="100%" cellpadding="0" cellspacing="0">
	<tr>
		<td class="tophead"><table width="100%" cellpadding="0" cellspacing="0">
	<tr>
		<td width="15%"><img src="<?php echo $backwardseperator?>images/helalogo.gif" width="175" height="85" alt="" class="mainImage" align="right" /></td>
		<td align="center" valign="top" width="68%" class="topheadBLACK"><?php
	$SQL = "select CO.strName,CO.strAddress1,CO.strAddress2,CO.strStreet,CO.strCity,CO.strState,CU.strCountry,CU.strZipCode,CO.strPhone,CO.strEMail,CO.strFax,CO.strWeb 
			from companies CO
			inner join country CU on CU.intConID=CO.intCountry
			where intCompanyID=$report_companyId;";
			
	//echo $SQL;		
	
	$result = $db->RunQuery($SQL);
	$row = mysql_fetch_array($result);
	$companyName		= $row["strName"];
	$companyAddress1	= $row["strAddress1"];
	$companyAddress2	= $row["strAddress2"];
	$companyStreet		= $row["strStreet"];
	$companyCity		= $row["strCity"];
	$companyCountry		= $row["strCountry"];
	$companyZipCode		= $row["strZipCode"];
	$companyPhone		= "(".$companyZipCode.")".$row["strPhone"];
	$companyFax		 	= "(".$companyZipCode.")".$row["strFax"];
	$companyEmail		= $row["strEMail"];
	$companyWeb		 	= $row["strWeb"];
	
	?>
	<?php echo $companyName; ?><p class="normalfntMid">
	<?php echo $companyAddress1." ".$companyAddress2." ".$companyStreet." ".$companyCity." ".$companyCountry."."."<br><b>Tel : </b>".$companyPhone." <b>Fax : </b>".$companyFax." <br><b>E-Mail : </b>".$companyEmail." <b>Web : </b>".$companyWeb;?></p>
		</td>
		<td width="16%" class="tophead">&nbsp;</td>
	</tr>
	</table></td>
	</tr>
	</table></td>
	</tr>
</table>