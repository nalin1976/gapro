function deleterows(tableName)
	{	
		var tbl = document.getElementById(tableName);
		for ( var loop = tbl.rows.length-1 ;loop >= 1 ; loop -- )
		{
			 tbl.deleteRow(loop);
		}		
	
	}	
function ReloadPage()
{
	document.FrmFactoryWiseWIP.submit();
}
function loadwipdata()
{	
	deleterows("tblwip_foot");
	var tbl=document.getElementById("tblwip_foot");
	var factory=document.getElementById("cmbFactory").value;
	var style=document.getElementById("cmbStyle").value;
	var url="wipdb.php?request=getwip&style="+style+"&factory="+factory;
	htmlobj=$.ajax({url:url,async:false});
	
	
	var xml_styleid=htmlobj.responseXML.getElementsByTagName('StyleID');
	var xml_OrderNo=htmlobj.responseXML.getElementsByTagName('OrderNo');
	var xml_style=htmlobj.responseXML.getElementsByTagName('style');
	var xml_Color=htmlobj.responseXML.getElementsByTagName('Color');
	var xml_CutQty=htmlobj.responseXML.getElementsByTagName('CutQty');
	var xml_CutIssueQty=htmlobj.responseXML.getElementsByTagName('CutIssueQty');
	var xml_CutReceiveQty=htmlobj.responseXML.getElementsByTagName('CutReceiveQty');
	var xml_CutReturnQty=htmlobj.responseXML.getElementsByTagName('CutReturnQty');
	var xml_InputQty=htmlobj.responseXML.getElementsByTagName('InputQty');
	var xml_OutPutQty=htmlobj.responseXML.getElementsByTagName('OutPutQty');
	var xml_WashReady=htmlobj.responseXML.getElementsByTagName('WashReady');
	var xml_FGgatePass=htmlobj.responseXML.getElementsByTagName('FGgatePass');
	var xml_FGReceived=htmlobj.responseXML.getElementsByTagName('FGReceived');
	var xml_orderQty=htmlobj.responseXML.getElementsByTagName('orderQty');
	var xml_season=htmlobj.responseXML.getElementsByTagName('season');
	var xml_factory_name=htmlobj.responseXML.getElementsByTagName('factory_name');
	
	//var OutPutQty=htmlobj.responseXML.getElementsByTagName('OutPutQty');
	
	for(var loop=0;loop<xml_styleid.length;loop++)
			{
				var lastRow 		= tbl.rows.length;	
				var row 			= tbl.insertRow(lastRow);
																		
				if(lastRow % 2 ==0)
					row.className ="bcgcolor-tblrowWhite";//row.className ="bcgcolor-tblrow";			
				else
					row.className ="bcgcolor-tblrowWhite";	
				
				var rowCell = row.insertCell(0);
				rowCell.className ="normalfntMid";			
				rowCell.innerHTML ="<img src=\"../../images/icn_print.jpg\"alt=\"Report\"onclick=\"print_wip()\" />";
				
				var rowCell = row.insertCell(1);
				rowCell.className ="normalfnt";		
				rowCell.noWrap	  ='noWrap'
				rowCell.innerHTML =xml_factory_name[loop].childNodes[0].nodeValue;
				
				var rowCell = row.insertCell(2);
				rowCell.className ="normalfnt";	
				rowCell.noWrap	  ='noWrap'	
				rowCell.innerHTML =xml_OrderNo[loop].childNodes[0].nodeValue;	
				
				var rowCell = row.insertCell(3);
				rowCell.className ="normalfnt";		
				rowCell.noWrap	  ='noWrap'	
				rowCell.innerHTML =xml_style[loop].childNodes[0].nodeValue;
								
				var rowCell = row.insertCell(4);
				rowCell.className ="normalfntRite";			
				rowCell.innerHTML =xml_orderQty[loop].childNodes[0].nodeValue;
				
				var rowCell = row.insertCell(5);
				rowCell.className ="normalfnt";		
				rowCell.noWrap	  ='noWrap'	
				rowCell.innerHTML =xml_Color[loop].childNodes[0].nodeValue;
				
				var rowCell = row.insertCell(6);
				rowCell.className ="normalfntMid";
				rowCell.noWrap	  ='noWrap'			
				rowCell.innerHTML =xml_season[loop].childNodes[0].nodeValue;
				
				var rowCell = row.insertCell(7);
				rowCell.className ="normalfntRite";			
				rowCell.innerHTML =xml_CutQty[loop].childNodes[0].nodeValue;
				
				var rowCell = row.insertCell(8);
				rowCell.className ="normalfntRite";			
				rowCell.innerHTML ="1.1";
				
				var rowCell = row.insertCell(9);
				rowCell.className ="normalfntRite";			
				rowCell.innerHTML =xml_CutQty[loop].childNodes[0].nodeValue;
				
				var rowCell = row.insertCell(10);
				rowCell.className ="normalfntRite";			
				rowCell.innerHTML =xml_CutIssueQty[loop].childNodes[0].nodeValue;
				
				var rowCell = row.insertCell(11);
				rowCell.className ="normalfntRite";	
				var balance		  =xml_CutQty[loop].childNodes[0].nodeValue-xml_CutIssueQty[loop].childNodes[0].nodeValue;		
				rowCell.innerHTML =(balance>=0?balance:0)
				
				var rowCell = row.insertCell(12);
				rowCell.className ="normalfntRite";	
				var balance		  =xml_CutQty[loop].childNodes[0].nodeValue-xml_CutIssueQty[loop].childNodes[0].nodeValue;		
				rowCell.innerHTML =(balance<0?(balance*-1):0)
				
				var rowCell = row.insertCell(13);
				rowCell.className ="normalfntRite";			
				rowCell.innerHTML =xml_CutReceiveQty[loop].childNodes[0].nodeValue;
				
				var rowCell = row.insertCell(14);
				rowCell.className ="normalfntRite";			
				rowCell.innerHTML =xml_CutReturnQty[loop].childNodes[0].nodeValue;
				
				var rowCell = row.insertCell(15);
				rowCell.className ="normalfntRite";			
				rowCell.innerHTML =0;
				
				var rowCell = row.insertCell(16);
				rowCell.className ="normalfntRite";			
				rowCell.innerHTML =xml_InputQty[loop].childNodes[0].nodeValue;
				
				var rowCell = row.insertCell(17);
				rowCell.className ="normalfntRite";			
				rowCell.innerHTML =xml_OutPutQty[loop].childNodes[0].nodeValue;
				
				var rowCell = row.insertCell(18);
				rowCell.className ="normalfntRite";			
				rowCell.innerHTML =xml_InputQty[loop].childNodes[0].nodeValue-xml_OutPutQty[loop].childNodes[0].nodeValue;
				
				var rowCell = row.insertCell(19);
				rowCell.className ="normalfntRite";			
				rowCell.innerHTML =0;
				
				var rowCell = row.insertCell(20);
				rowCell.className ="normalfntRite";			
				rowCell.innerHTML =xml_WashReady[loop].childNodes[0].nodeValue;
			
				var rowCell = row.insertCell(21);
				rowCell.className ="normalfntRite";			
				rowCell.innerHTML =xml_FGgatePass[loop].childNodes[0].nodeValue;
				
				var rowCell = row.insertCell(22);
				rowCell.className ="normalfntRite";			
				rowCell.innerHTML =xml_FGReceived[loop].childNodes[0].nodeValue;
				
	
				for(var i=23; i<54;i++)	
				{							
				var rowCell = row.insertCell(i);
				rowCell.className ="normalfntRite";			
				rowCell.innerHTML =0;
				}
			}
			set_selective()
}

function disable_time()
{
	if(document.getElementById("checkwipdate").checked==false){
			document.getElementById("txtWipTDate").disabled=true;
			document.getElementById("txtWipFDate").disabled=true;}
	else{
			document.getElementById("txtWipTDate").disabled=false;
			document.getElementById("txtWipFDate").disabled=false;}
}

function print_wip()
{
	var wip_report=window.open("wip_report.php",'wip');
	wip_report.focus();
}

function get_wip_data()
{
	/*var factory=document.getElementById("cmbFactory").value;
	var style=document.getElementById("cmbStyle").value;
	var url="wipdb.php?request=getwip";
	htmlobj=$.ajax({url:url,async:false});
	var styleid=responseXML.getElementsByTagName('StyleID');
	for(var loop=0;loop<.length)*/
	
}

var prev_row_no=-99;
var pub_bg_color_click='';

function set_selective()
{
	/*$('#tblER tbody tr').mouseover(function(){
			if($(this).attr('bgColor')!='#D2E355'){
			pub_bg_olor_over=$(this).attr('bgColor')
			$(this).attr('bgColor','#D2E3B7')}
	})
	$('#tblER tbody tr').mouseout(function(){
			if($(this).attr('bgColor')!='#D2E355'){
			$(this).attr('bgColor',pub_bg_olor_over)}
			//$(this).removeAttr('bgColor')
	})*/
	
	$('#tblwip_foot tr').click(function(){
			$(this).css('background-color','#EBE9FE')
			if(prev_row_no!=-99&&prev_row_no!=$(this).index()){
			$('#tblwip_foot')[0].rows[prev_row_no].style.background='#ffffff'
			}
			prev_row_no=$(this).index()			
			
			
			
			
			
	})
}