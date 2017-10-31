
<?php 
	include "../../../Connector.php";
	$request=$_GET["request"];
	$buyer=$_GET["buyer"];
	$request=($buyer!=''?'month':$request);
	$country=$_GET["country"];
	$destination=$_GET["destination"];
	$frmDate=$_GET["frmDate"];
	$toDate=$_GET["toDate"];
	$toDate=$_GET["toDate"];
	$yAxisName=$_GET["yAxisName"];
	if($yAxisName=='amount'){
		$yAxisName='dblAmount';
		$yAxisTitle='Amount';
	}
	else if($yAxisName=='cbm'){
		$yAxisName='dblCBM';
		$yAxisTitle='CBM';
	}
	else if($yAxisName=='qty'){
		$yAxisName='dblQuantity';
		$yAxisTitle='Quantity';
	}
		$where.=($buyer!=''?" and strBuyerId=$buyer":"");
	if($frmDate!=""&&$toDate!="")
	{
		$frmDate_array=explode('/',$frmDate);
		$frmDate=$frmDate_array[2]."-".$frmDate_array[1]."-".$frmDate_array[0];
		$toDate_array=explode('/',$toDate);
		$toDate=$toDate_array[2]."-".$toDate_array[1]."-".$toDate_array[0];
		$where.=" and dtmInvoiceDate between '$frmDate' and '$toDate'";	
	}
	
	if($request=='month'){
		echo "<chart caption=\"$yAxisTitle Over Month\"xAxisName=\"Month\"yAxisName=\"$yAxisTitle\">"; 
		$str="select 
			concat(YEAR(dtmInvoiceDate),' ',MONTHNAME(dtmInvoiceDate))as months,
			SUM($yAxisName) as amount
			from commercial_invoice_detail cid
			inner join  
			commercial_invoice_header cih on cih.strInvoiceNo=cid.strInvoiceNo
			where cid.strInvoiceNo!='' $where
			group by YEAR(dtmInvoiceDate),MONTHNAME(dtmInvoiceDate)
			order by dtmInvoiceDate";
	$result=$db->RunQuery($str);
	//die($str);
	while($row=mysql_fetch_array($result))
		{?>
			<set label="<?php echo $row['months']?>" value="<?php echo $row['amount']?>" /> 
		<?php	}
	}
	else if($request=='buyer')
	{
		echo "<chart caption=\"$yAxisTitle Over Buyer\"xAxisName=\"Buyer\"yAxisName=\"$yAxisTitle\">"; 
		$str="select 
			SUBSTRING(strName,1,3) as codea,
			strName as buyer,
			SUM($yAxisName) as amount
			from commercial_invoice_detail cid
			inner join  
			commercial_invoice_header cih on cih.strInvoiceNo=cid.strInvoiceNo
			inner join 
			buyers b on b.strBuyerID=cih.strBuyerID
			where cid.strInvoiceNo!='' $where
			group by codea
			order by codea";
	$result=$db->RunQuery($str);
	//die($str);
	while($row=mysql_fetch_array($result))
		{?>
			<set label="<?php echo $row['codea']?>" value="<?php echo $row['amount']?>" /> 
		<?php }
		
	}
	else if($request=='dest')
	{
		echo "<chart caption=\"$yAxisTitle Over Destination\"xAxisName=\"Destination\"yAxisName=\"$yAxisTitle\">";
		$str="select 
			strCountry as country,
			SUM($yAxisName) as amount
			from commercial_invoice_detail cid
			inner join  
			commercial_invoice_header cih on cih.strInvoiceNo=cid.strInvoiceNo
			inner join 
			city c on c.strCityCode=cih.strFinalDest
			inner join
			country on country.strCountryCode=c.strCountryCode
			where cid.strInvoiceNo!='' 
			group by country
			order by country";
	$result=$db->RunQuery($str);
	while($row=mysql_fetch_array($result))
		{?>
			<set label="<?php echo $row['country']?>" value="<?php echo $row['amount']?>" /> 
		<?php }
		
		
	}


?>
</chart>