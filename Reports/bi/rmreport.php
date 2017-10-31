<?php
session_start();
$backwardseperator = "../../";
include "../../Connector.php";

global $db;


$mainCategoryId = $_GET["mc"];

$reportType = $_GET["reportType"];

switch($reportType){
	
	case 1: // Month wise in all years
	
		// Get selected main category by month wise
		$sql = " SELECT Sum(stocktransactions.dblQty) as qty,
						case month(stocktransactions.dtmDate) 
						when 1 then 'JAN'
						when 2 then 'FEB'
						when 3 then 'MAR'
						when 4 then 'APR'
						when 5 then 'MAY'
							when 6 then 'JUN'
						when 7 then 'JUL'
						when 8 then 'AUG'
						when 9 then 'SEP'
						when 10 then 'OCT'
						when 11 then 'NOV'
						when 12 then 'DEC'
						   
					end as gmonth
					FROM
					stocktransactions
					Inner Join matitemlist ON stocktransactions.intMatDetailId = matitemlist.intItemSerial
					WHERE
					stocktransactions.strType =  'GRN' AND
					matitemlist.intMainCatID =  '$mainCategoryId'
					GROUP BY
					month(stocktransactions.dtmDate)";

			$result = $db->RunQuery($sql);

			$value = array();
			
			while($row=mysql_fetch_array($result)){
					
				$value[] = array("qty"=>$row["qty"], "month"=>$row["gmonth"]);
			}

	
	// Get selected main category by sotres location wise
	
			$sql_stores = " SELECT Sum(stocktransactions.dblQty) AS qty, mainstores.strName
							FROM
							stocktransactions
							Inner Join matitemlist ON stocktransactions.intMatDetailId = matitemlist.intItemSerial
							Inner Join mainstores ON stocktransactions.strMainStoresID = mainstores.strMainID
							WHERE
												stocktransactions.strType =  'GRN' AND
												matitemlist.intMainCatID =  '$mainCategoryId'
							GROUP BY
							mainstores.strName";
					
			$result_stores = $db->RunQuery($sql_stores);

			$valueStores = array();
			
			while($row_stores=mysql_fetch_array($result_stores)){
					
				$valueStores[] = array("qty"=>$row_stores["qty"], "stores"=>$row_stores["strName"]);
			}		
	
	break;	
	
	
	
}




?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<script>
  	 function t(){
    
    	var data1 = <?php echo json_encode($value); ?>
		
		var x = [['year', 'qty']];
		
		for(var i=0;i<data1.length;i++){
			 x.push([data1[i].month,data1[i].qty]);  			
		}
		

		alert(x);
    
    }
  </script> 


 <script type="text/javascript"
          src="https://www.google.com/jsapi?autoload={
            'modules':[{
              'name':'visualization',
              'version':'1',
              'packages':['corechart']
            }]
          }"></script>

    <script type="text/javascript">
	
	 
	
      google.setOnLoadCallback(drawChart);

		// var data;

      function drawChart() {
		  
		 var data1 = <?php echo json_encode($value); ?>
		
		var x = [['year', 'Quantities']];
		//var q = 1000
		for(var i=0;i<data1.length;i++){
			 x.push([data1[i].month,parseFloat(data1[i].qty)]);  			
		}
       
		//alert(x);
		 var data = google.visualization.arrayToDataTable(x);
		
		<?php switch($mainCategoryId){
			case 1:
		?>
			var options = {
          title: 'Fabric Inhouse Flow',
          curveType: 'function',
          legend: { position: 'bottom' }
        };
		
		<?php break; 
		
			case 2:
		?>
			var options = {
          title: 'Accessories Inhouse Flow',
          curveType: 'function',
          legend: { position: 'bottom' }
        };
		<?php break; 
			case 3:
		?>	
			var options = {
          title: 'Packing Inhouse Flow',
          curveType: 'function',
          legend: { position: 'bottom' }
        };
		<?php break; ?>	
	<?php } // end switch statment?>

		
        var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));
		
		

        chart.draw(data, options);
		
      }
	  
	  google.setOnLoadCallback(drawPieChart);
	  
	  function drawPieChart(){
		  
		var data1 = <?php echo json_encode($valueStores); ?>
		
		var xStores = [['stores', 'Quantities']];
		//var q = 1000
		for(var i=0;i<data1.length;i++){
			 xStores.push([data1[i].stores,parseFloat(data1[i].qty)]);  			
		}
       
		var dataPie = google.visualization.arrayToDataTable(xStores);
		
		<?php switch($mainCategoryId){
			case 1:
		?>
			var options = {
          title: 'Fabric Inhouse Flow',
          curveType: 'function',
          legend: { position: 'bottom' }
        };
		
		<?php break; 
		
			case 2:
		?>
			var options = {
          title: 'Accessories Inhouse Flow',
          curveType: 'function',
          legend: { position: 'bottom' }
        };
		<?php break; 
			case 3:
		?>	
			var options = {
          title: 'Packing Inhouse Flow',
          curveType: 'function',
          legend: { position: 'bottom' }
        };
		<?php break; ?>
	<?php } // end switch statment?>
		  
		  
		  
		  var piechart = new google.visualization.PieChart(document.getElementById('curve_chart1'));
		  
		  piechart.draw(dataPie, options);
	  }
	
    </script>
    
  
</head>

<body>
<div id="curve_chart" style="width: 900px; height: 500px"></div>
<div id="curve_chart1" style="width: 350px; height: 200px; position:absolute; left: 912px; top: 17px;"></div>

</body>
</html>