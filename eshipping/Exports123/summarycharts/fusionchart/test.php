<?php 
$frmDate=$_GET["frmDate"];
$toDate=$_GET["toDate"];
$country=$_GET["country"];
$destination=$_GET["destination"];
$buyer=$_GET["buyer"];
$Exhi1=$_GET["Exhi1"];
$Exhi2=$_GET["Exhi2"];
$Exhi3=$_GET["Exhi3"];
$Exhi4=$_GET["Exhi4"];

$Exhi1_array		=explode("/",$Exhi1);
$Exhi1_request		=$Exhi1_array[1];
$Exhi1_yAxisName	=$Exhi1_array[0];

$Exhi2_array		=explode("/",$Exhi2);
$Exhi2_request		=$Exhi2_array[1];
$Exhi2_yAxisName	=$Exhi2_array[0];

$Exhi3_array		=explode("/",$Exhi3);
$Exhi3_request		=$Exhi3_array[1];
$Exhi3_yAxisName	=$Exhi3_array[0];

$Exhi4_array		=explode("/",$Exhi4);
$Exhi4_request		=$Exhi4_array[1];
$Exhi4_yAxisName	=$Exhi4_array[0];
?>
<html>
  <head>        
    <title>eShipping Web | Shipment Summaries</title>  
    <link href="../../../css/erpstyle.css" rel="stylesheet" type="text/css" />  
    <script type="text/javascript" src="lib/FusionCharts.js">
    </script>
    <script src="../../../js/jquery-1.4.4.min.js"></script>
    <script type="text/javascript">
	var url_para			="&frmDate=<?php echo $frmDate; ?>&toDate=<?php echo $toDate; ?>&country=<?php echo $country; ?>&destination=<?php echo $destination; ?>&buyer=<?php echo $buyer; ?>";
		
    var url_exhi1		 	="data.php?request=<?php echo $Exhi1_request;?>&yAxisName=<?php echo $Exhi1_yAxisName;?>"+url_para;
	var xml_http_obj_exhi1	=$.ajax({url:url_exhi1,async:false});
	var htmltext_exhi1		=xml_http_obj_exhi1.responseText;
	
	var url_exhi2		 	="data.php?request=<?php echo $Exhi2_request;?>&yAxisName=<?php echo $Exhi2_yAxisName;?>"+url_para;
	var xml_http_obj_exhi2	=$.ajax({url:url_exhi2,async:false});
	var htmltext_exhi2		=xml_http_obj_exhi2.responseText;
	
	var url_exhi3		 	="data.php?request=<?php echo $Exhi3_request;?>&yAxisName=<?php echo $Exhi3_yAxisName;?>"+url_para;
	var xml_http_obj_exhi3	=$.ajax({url:url_exhi3,async:false});
	var htmltext_exhi3		=xml_http_obj_exhi3.responseText;
	
	var url_exhi4		 	="data.php?request=<?php echo $Exhi4_request;?>&yAxisName=<?php echo $Exhi4_yAxisName;?>"+url_para;
	var xml_http_obj_exhi4	=$.ajax({url:url_exhi4,async:false});
	var htmltext_exhi4		=xml_http_obj_exhi4.responseText;
	
    </script>
  </head>   
  <body>
  <table width="100%" border="0" cellspacing="0" cellpadding="0"  class="normalfnt">
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td width="50%"><div id="chartContainer">FusionCharts will load here!</div></td>
    <td width="50%"><div id="chartContainer2">FusionCharts will load here!</div></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="1" class="normalfnt">
      <tr>
        <td colspan="2" class="normalfntMid"><strong>Exhibit 1</strong></td>
        </tr>
      <tr>
        <td width="30%">Period:</td>
        <td width="70%">&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </table></td>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="1" class="normalfnt">
      <tr>
        <td colspan="2" class="normalfntMid"><strong>Exhibit 2</strong></td>
      </tr>
      <tr>
        <td width="30%">Period:</td>
        <td width="70%">&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><div id="chartContainer3" style="">FusionCharts will load here!</div></td>
    <td><div id="chartContainer4">FusionCharts will load here!</div></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="1" class="normalfnt">
      <tr>
        <td colspan="2" class="normalfntMid"><strong>Exhibit 3</strong></td>
      </tr>
      <tr>
        <td width="30%">Period:</td>
        <td width="70%">&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </table></td>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="1" class="normalfnt">
      <tr>
        <td colspan="2" class="normalfntMid"><strong>Exhibit 4</strong></td>
      </tr>
      <tr>
        <td width="30%">Period:</td>
        <td width="70%">&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  </table>
  <script type="text/javascript"> 
	  var myChart = new FusionCharts( "lib/Column3D.swf","myChartId", "600", "400", "0", "1" );
      myChart.setXMLData(htmltext_exhi1);
      myChart.render("chartContainer");      
   
	  var myChart = new FusionCharts( "lib/Column3D.swf","myChartId", "600", "400", "0", "1" );
      myChart.setXMLData(htmltext_exhi2);
      myChart.render("chartContainer2"); 
	  
	  var myChart = new FusionCharts( "lib/Column3D.swf","myChartId", "600", "400", "0", "1" );
      myChart.setXMLData(htmltext_exhi3);
      myChart.render("chartContainer3"); 
	  
	  var myChart = new FusionCharts( "lib/Column3D.swf","myChartId", "600", "400", "0", "1" );
      myChart.setXMLData(htmltext_exhi4);
      myChart.render("chartContainer4"); 
    </script>
  </body> 
</html>