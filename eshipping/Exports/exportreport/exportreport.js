$(document).ready(function() 
{
	$('#btnAdd').click(function()
		{
			
			
			var url			='popexportreport.php'
			var http_obj	=$.ajax({url:url,async:false});
			drawPopupArea(650,300,'frmAddInd');
			$('#frmAddInd').html(http_obj.responseText)
				
				$('#btnSearch').click(function()
					{
						
								checkurl();
									
		
					});	
				
			
				$('#btnView').click(function()
					{	
			
						view_detail();
						
				
					});
				
				
				$('#btnReport').click(function()
					{	
			
						ShowExcelReport();
				
					});
			
				$('#btnNew').click(function()
					{	
			
						refresh_page();
						var title_txt="<input type=\"text\" class=\"txtbox\" name=\"textTitle\" id=\"txtTitle\" width=\"width:148px\" >";
	$('#title_cell').html(title_txt);
				
					});
			
			
		});
	
		
			
});

function load_grid(req)
{	
	var urlcheck		=req
	del_tbl_pop();
	
	
	var url				=urlcheck ;
	var xml_http_obj	=$.ajax({url:url,async:false});
	var xml_ino			=xml_http_obj.responseXML.getElementsByTagName('INVNo');
	var xml_isd			=xml_http_obj.responseXML.getElementsByTagName('ISD');
	var xml_date		=xml_http_obj.responseXML.getElementsByTagName('DATE');
	var xml_vessel		=xml_http_obj.responseXML.getElementsByTagName('VESSEL');
	var xml_voyage		=xml_http_obj.responseXML.getElementsByTagName('VOYAGE');
	
	var tbl				=$('#tblCommodityCode')
	var pos=0;
		for(var r_loop=0; r_loop<xml_ino.length;r_loop++)
			{
		
				var lastRow 		= $('#tblCommodityCode tr').length;
				var row 			= tbl[0].insertRow(lastRow);
				row.className		='bcgcolor-tblrowWhite';
				pos++;
		
				row.onclick	= rowclickColorChangeIou;	
				if(r_loop % 2 ==0)
					row.className ="bcgcolor-tblrow mouseover";
				else
					row.className ="bcgcolor-tblrowWhite mouseover";
		
		
				var rowCell 	  	= row.insertCell(0);
				rowCell.className 	= "normalfntMid";
				rowCell.innerHTML 	="<input type=\"checkbox\" id=\"checkboxgrid\" name=\"checkboxgrid\" /> ";	
							  
		
				var rowCell 	  	= row.insertCell(1);
				rowCell.className 	= "normalfntMid";
				rowCell.innerHTML 	=xml_ino[r_loop].childNodes[0].nodeValue;
				rowCell.height	  	="25"
				rowCell.noWrap		='nowrap';
		
				var rowCell 	  	= row.insertCell(2);
				rowCell.className 	= "normalfntMid";
				rowCell.innerHTML 	=xml_isd[r_loop].childNodes[0].nodeValue;
						
				var rowCell 	  	= row.insertCell(3);
				rowCell.className 	= "normalfntMid";
				rowCell.innerHTML 	=xml_date[r_loop].childNodes[0].nodeValue;
				rowCell.noWrap	  	="nowrap"
		
				var rowCell 	  	= row.insertCell(4);
				rowCell.className 	= "normalfntMid";
				rowCell.innerHTML 	=xml_vessel[r_loop].childNodes[0].nodeValue;
				rowCell.noWrap	  	="nowrap"
				
				var rowCell 	  	= row.insertCell(5);
				rowCell.className 	= "normalfntMid";
				rowCell.innerHTML 	=xml_voyage[r_loop].childNodes[0].nodeValue;
				rowCell.noWrap	  	="nowrap"
				
		
			}
	
}

function checkAll(obj)
{
	var tblpop = document.getElementById("tblCommodityCode");
	if(obj.checked)
		var check = true;
	else
		var check = false;
		
	for(loop=1;loop<tblpop.rows.length;loop++)
	{
		tblpop.rows[loop].cells[0].childNodes[0].checked = check;		
	}
}

function checkurl()
{
	var  des			=$('#cboDestination').val();
	var  datefrom		=$('#txtInvoiceDate2').val();
	var  dateto			=$('#txtInvoiceDate3').val();
	
	var req='exportreportdb.php?request=load_pl_grid&des='+des+'&datefrom='+datefrom+'&dateto='+dateto ;
	load_grid(req);	
		
}

function del_tbl_pop()

{
	$('#tblCommodityCode tr:gt(0)').remove()
	//$('#tblTitle tr:gt(0)').remove()
	
}
function del_Maintbl_pop()

{
	$('#tblTitle tr:gt(0)').remove()	
}


function sendData()

{
	var row_source 			=$('#tblCommodityCode tr')
	var tbl					=$('#tblTitle')
	var tbl_row_source 		=$('#tblTitle tr')

	for(var loopz=1;loopz<=row_source.length-1;loopz++)
		{
			if(row_source[loopz].cells[0].childNodes[0].checked==true)
				{
					var INO					 =row_source[loopz].cells[1].childNodes[0].nodeValue;
					var ISD   				 =row_source[loopz].cells[2].childNodes[0].nodeValue;
					var DATE				 =row_source[loopz].cells[3].childNodes[0].nodeValue;
					var VESSEL				 =row_source[loopz].cells[4].childNodes[0].nodeValue;
					var VOYAGE				 =row_source[loopz].cells[5].childNodes[0].nodeValue;
					
					var booCheck = false;
					for(var j=1;j <=tbl_row_source.length-1; j++ )
					{
						
						if(tbl_row_source[j].cells[1].childNodes[0].nodeValue==INO && tbl_row_source[j].cells[2].childNodes[0].nodeValue==ISD)
						{
							booCheck = true;
								
						}
					}
					
					
				if(!booCheck)
				{
				
					var lastRow 			 = $('#tblTitle tr').length;
					var row 				 = tbl[0].insertRow(lastRow);
		
		
					var cellDelete = row.insertCell(0); 
					cellDelete.className ="normalfntMid";	
					cellDelete.innerHTML = "<img src=\"../../images/del.png\" alt=\"del\" width=\"15\" height=\"15\" id=\"delItem\" onclick=\"RemoveItem(this);\"/>";
		
	
					var rowCell 	  	= row.insertCell(1);
					rowCell.className 	= "normalfntMid";
					rowCell.innerHTML 	=INO;
					rowCell.noWrap		='nowrap';
					rowCell.height	  	="25";
		
					var rowCell 	  	= row.insertCell(2);
					rowCell.className 	= "normalfntMid";
					rowCell.innerHTML 	=ISD;
				
					var rowCell 	  	= row.insertCell(3);
					rowCell.className 	= "normalfntMid";
					rowCell.innerHTML 	=DATE;
		
					var rowCell 	  	= row.insertCell(4);
					rowCell.className 	= "normalfntMid";
					rowCell.innerHTML 	=VESSEL;
		
					var rowCell 	  	= row.insertCell(5);
					rowCell.className 	= "normalfntMid";
					rowCell.innerHTML 	=VOYAGE;
				}
			
					
				}
		
		}
	
		rowclickColorChangeIou2();
		hidePleaseWait();
		closeWindow();	
}
	
	
/*function del_tbl()
	{
		$('#tblTitle tr:gt(0)').remove()
	}

function validatePop()
	{
		if(document.getElementById("cboDestination").value=="")
			{
				alert("Please select a destination.");
				document.getElementById("cboDestination").focus();
			}
	
		else
			{
				return true;
			}
	}*/



function rowclickColorChangeIou()

{	
	var rowIndex = this.rowIndex;
	var tbl = document.getElementById('tblCommodityCode');
	
	for ( var i = 1; i < tbl.length; i ++)
		{
			tbl.rows[i].className = "";
			
			if ((i % 2) == 1)
				{
					tbl.rows[i].className="bcgcolor-tblrow mouseover";
				}
			else
				{
					tbl.rows[i].className="bcgcolor-tblrowWhite mouseover";
				}
				
		if( i == rowIndex)
			tbl.rows[i].className = "bcgcolor-highlighted mouseover";
		}
	
}

function rowclickColorChangeIou2()
{	
	var rowIndex = this.rowIndex;
	var tbl = document.getElementById('tblTitle');
	
	for ( var i = 1; i < tbl.rows.length; i ++)
		{
			tbl.rows[i].className = "";
			if ((i % 2) == 1)
				{
					tbl.rows[i].className="bcgcolor-tblrow mouseover";
				}
			else
				{
					tbl.rows[i].className="bcgcolor-tblrowWhite mouseover";
				}
				
			if( i == rowIndex)
			tbl.rows[i].className = "bcgcolor-highlighted mouseover";
		}
	
}

function saveData()
{
	var titleid="";
	if(document.getElementById("txtTitle").type=='text')
	{			
			
			if(document.getElementById("txtTitle").value=="")
			{
				alert("Please enter a title.");
				document.getElementById("txtTitle").focus();
				return;					
			}		
		var  title			=$('#txtTitle').val();
		var  date			=$('#txtInvoiceDate').val();
		
		var url				='exportreportdb.php?request=save_header&title='+title+'&date='+date;
		var xml_http_obj	=$.ajax({url:url,async:false});	
		view_detail()
		var xml_resp		=xml_http_obj.responseXML.getElementsByTagName('response')[0].childNodes[0].nodeValue;
		titleid			=xml_http_obj.responseXML.getElementsByTagName('ID')[0].childNodes[0].nodeValue;
		$('#txtTitle').val(titleid);	
	}
	else
	{
		titleid		=$('#txtTitle').val();
		var url				='exportreportdb.php?request=del_details&titleid='+titleid;
		var xml_http_obj	=$.ajax({url:url,async:false});	
				
	}
	
	var row_source 		=$('#tblTitle tr');	
	
	for(var loopz=1;loopz<=row_source.length-1;loopz++)
	{
		
		var INO	=row_source[loopz].cells[1].childNodes[0].nodeValue;
		var url='exportreportdb.php?request=save_detail&xml_id='+titleid+'&INO='+INO;
		var xml_http_obj	=$.ajax({url:url,async:false});
					
	}
	
	alert("Saved successfully.")	
}

function RemoveItem(cell)
	{
		if(confirm("Are you sure, you want to delete this record?"))
		$('#tblTitle tbody')[0].deleteRow(cell.parentNode.parentNode.rowIndex);
	
		rowclickColorChangeIou2();
	}

function deleterows(tblTitle)
{	
	var tbl = document.getElementById("tblTitle");
	for ( var loop = tbl.rows.length-1 ;loop >= 0 ; loop -- )
		{
			tbl.deleteRow(loop);
		}		
}

function view_detail()
{
	
	var title_combo	="<select name=\"txtTitle\"  class=\"txtbox\" style=\"width:148px\" id=\"txtTitle\"onchange=\"getData()\" tabindex=\"1\">";

	$('#title_cell').html(title_combo);	
	loadCombo('SELECT strTitleid, concat(strTitle,\'->\',strDate)as Titledesc FROM exportreport_header order by strTitleid','txtTitle');	
	
}

function refresh_page()
{
	 
	setTimeout("location.reload(true);");
}

function getData()
{
	var searchid = $('#txtTitle').val();
	del_Maintbl_pop();
	var url				='exportreportdb.php?request=getData&searchid='+searchid ; 
	var xml_http_obj	=$.ajax({url:url,async:false});
	var xml_ino				=xml_http_obj.responseXML.getElementsByTagName('INVNo');
	var xml_isd				=xml_http_obj.responseXML.getElementsByTagName('ISD');
	var xml_date			=xml_http_obj.responseXML.getElementsByTagName('DATE');
	var xml_vessel			=xml_http_obj.responseXML.getElementsByTagName('VESSEL');
	var xml_voyage			=xml_http_obj.responseXML.getElementsByTagName('VOYAGE');
	
	var tbl				=$('#tblTitle')
	
	for(var r_loop=0; r_loop<xml_ino.length;r_loop++)
	
		{
			var lastRow 		= $('#tblTitle tr').length;
			var row 			= tbl[0].insertRow(lastRow);
			row.className		='bcgcolor-tblrowWhite';
		
			row.onclick	= rowclickColorChangeIou2;	
			if(r_loop % 2 ==0)
					row.className ="bcgcolor-tblrow mouseover";
				else
					row.className ="bcgcolor-tblrowWhite mouseover";
		
			var cellDelete = row.insertCell(0); 
			cellDelete.className ="normalfntMid";	
			cellDelete.innerHTML = "<img src=\"../../images/del.png\" alt=\"del\" width=\"15\" height=\"15\" id=\"delItem\" onclick=\"RemoveItem(this);\"/>";
							  
			var rowCell 	  	= row.insertCell(1);
			rowCell.className 	= "normalfntMid";
			rowCell.innerHTML 	= xml_ino[r_loop].childNodes[0].nodeValue;
			rowCell.height	  	="25";
			rowCell.noWrap		='nowrap';
			
		
			var rowCell 	  	= row.insertCell(2);
			rowCell.className 	= "normalfntMid";
			rowCell.innerHTML 	= xml_isd[r_loop].childNodes[0].nodeValue;
						
			var rowCell 	  	= row.insertCell(3);
			rowCell.className 	= "normalfntMid";
			rowCell.innerHTML 	= xml_date[r_loop].childNodes[0].nodeValue;
			rowCell.noWrap	  	="nowrap"
		
			var rowCell 	  	= row.insertCell(4);
			rowCell.className 	= "normalfntMid";
			rowCell.innerHTML 	= xml_vessel[r_loop].childNodes[0].nodeValue;
			rowCell.noWrap	  	="nowrap"
				
			var rowCell 	  	= row.insertCell(5);
			rowCell.className 	= "normalfntMid";
			rowCell.innerHTML 	= xml_voyage[r_loop].childNodes[0].nodeValue;
			rowCell.noWrap	  	="nowrap"
		
		}
	
}
function ShowExcelReport()
{
	
		if(document.getElementById('txtTitle').value=="")
		{
			alert("please select a title");
			document.getElementById("txtTitle").focus();
			return;
		}
		else
		{
			
			document.getElementById('reportPopUp').style.visibility = "visible";
			
			
	
		}
	
	
}

function getReport()
{
	var titleid		= document.getElementById('txtTitle').value;
	var reportid	= $('#cboReport').val();
	
	if(reportid==1)
	{
		newwindow=window.open('rptexcelexportreport.php?titleid='+URLEncode(titleid));	
		document.getElementById('reportPopUp').style.visibility = "hidden";
	}
	if(reportid==2)
	{
		newwindow=window.open('rptexcelwebtool.php?titleid='+URLEncode(titleid));	
		document.getElementById('reportPopUp').style.visibility = "hidden";
	}
	
	if(reportid==3)
	{
		newwindow=window.open('inspectioncertificate.php?titleid='+URLEncode(titleid));	
		document.getElementById('reportPopUp').style.visibility = "hidden";
	}
	
	if(reportid==4)
	{
		newwindow=window.open('rptexcellevis.php?titleid='+URLEncode(titleid));	
		document.getElementById('reportPopUp').style.visibility = "hidden";
	}
	if(reportid==5)
	{
		newwindow=window.open('non_insured.php?titleid='+URLEncode(titleid));	
		document.getElementById('reportPopUp').style.visibility = "hidden";
	}
	$('#cboReport').val("");
	}