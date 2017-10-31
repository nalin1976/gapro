var pubBulkAlloRptURL = 'gapro/allocation/list/';
function disableCombo(obj)
{
	if(obj == '1')
	{
		document.getElementById('cboBulkPO').disabled = 'disabled';
		document.getElementById('cboOrder').disabled = '';
		
		/*var sql = "SELECT DISTINCT  concat(CBulkDet.intBulkPOYear,'/',CBulkDet.intBulkPoNo) as BPONo,"+
								" concat(CBulkDet.intBulkPOYear,'/',CBulkDet.intBulkPoNo) as BPO"+
								" from commonstock_bulkdetails CBulkDet inner join commonstock_bulkheader CBulkH on"+
								" CBulkH.intTransferNo = CBulkDet.intTransferNo and "+
								" CBulkH.intTransferYear = CBulkDet.intTransferYear " +
								" where CBulkH.intStatus=1 and CBulkH.intCompanyId="+comID;
								"order by CBulkDet.intBulkPOYear,CBulkDet.intBulkPoNo";
								alert(sql);
					loadCombo(URLEncode(sql),'cboBulkPO');*/
	}
	if(obj == '0')
	{
		document.getElementById('cboBulkPO').disabled = '';
		document.getElementById('cboOrder').disabled = 'disabled';
		
		var sql = "SELECT distinct CBH.intToStyleId, O.strStyle	from commonstock_bulkheader CBH inner join orders O on"+
					" CBH.intToStyleId = O.intStyleId where CBH.intStatus=1 and CBH.intCompanyId ="+comID;
					loadCombo(URLEncode(sql),'cboOrder');
	}
}

function openStyleReport()
{
	
	var val;
	for(x=0;x<document.frmBulkAlloRpt.orderOrBulk.length;x++)
	{
		if(document.frmBulkAlloRpt.orderOrBulk[x].checked)
		{
			val = document.frmBulkAlloRpt.orderOrBulk[x].value;
			}
		}
		
	if(val == '1')	
	{
		var styleName = document.getElementById('cboOrder').options[document.getElementById('cboOrder').selectedIndex].text;
		var styleID = document.getElementById('cboOrder').value; 
		window.open("styleBulkAlloReport.php?styleID=" + styleID+'&styleName='+styleName,'frmBulkAlloRpt');
	}
	 		
}

function openBulkUtilizationReport()
{
	var matID = document.getElementById('cboItem').value; 
	var ItemName = document.getElementById('cboItem').options[document.getElementById('cboItem').selectedIndex].text;
	var Dfrom = document.getElementById('txtFromDate').value; 
	var Dto = document.getElementById('txtToDate').value;
	
	if(Dfrom == '')
	{
		alert('Please select \"From Date\"');
		document.getElementById('txtFromDate').focus();
		return false;
		
		}
	if(Dto == '')
	{
		alert('Please select \"To Date\"');
		document.getElementById('txtToDate').focus();
		return false;
		
		}
	window.open("bulkUtilizationRpt.php?matID=" + matID+'&ItemName='+ItemName+'&Dfrom='+Dfrom+'&Dto='+Dto,'frmBulkAlloRpt');
}

function viewAllocationData()
{
	var dfrom = document.getElementById('txtTodayAllFromDate').value; 
	var dTo   = document.getElementById('txtTodayAllToDate').value; 
	
	if(dfrom == '')
	{
		alert("Please select \"Date From \" ");
		document.getElementById('txtTodayAllFromDate').focus();
		return false;
	}
	if(dTo == '')
	{
		alert("Please select \"Date To \" ");
		document.getElementById('txtTodayAllToDate').focus();
		return false;
	}
	clearAlloData();
	var url = 'bulkAllodb.php?RequestType=viewAlloData';
							url += '&dfrom=' +dfrom;
							url += '&dTo='+dTo;
														
			var htmlobj=$.ajax({url:url,async:false});
			var XMLAlloNo = htmlobj.responseXML.getElementsByTagName("AlloNo");
						
			if(XMLAlloNo.length == '0')
			{
				alert("No records");
			}
			else
			{
				

				 for ( var loop = 0; loop < XMLAlloNo.length; loop ++)
				  {
					
					var AlloNo=htmlobj.responseXML.getElementsByTagName("AlloNo")[loop].childNodes[0].nodeValue;
					var styleID=htmlobj.responseXML.getElementsByTagName("StyleNo")[loop].childNodes[0].nodeValue;
					var user =htmlobj.responseXML.getElementsByTagName("Uname")[loop].childNodes[0].nodeValue;
					var alloDate =htmlobj.responseXML.getElementsByTagName("AlloDate")[loop].childNodes[0].nodeValue;
								
					createAllocationGrid(AlloNo,styleID,user,alloDate);
				  }
			}
	
}

function createAllocationGrid(AlloNo,styleID,user,alloDate)
{
	var tbl = document.getElementById('tblevents');
	var lastRow = tbl.rows.length;	
	var row = tbl.insertRow(lastRow);
	row.className="bcgcolor-tblrowWhite";	
	var cellf = row.insertCell(0);	
	cellf.className = "normalfnt";
	cellf.innerHTML = '';	
	
	var alloNo = row.insertCell(1);	
	alloNo.className = "normalfnt";
	alloNo.innerHTML = AlloNo;	
	
	var cellStyle=row.insertCell(2);	
	cellStyle.className = "normalfnt";
	cellStyle.innerHTML = styleID;
	
	var cellUser=row.insertCell(3);
	cellUser.className="normalfnt";
	cellUser.innerHTML=user;
	
	var cellDate=row.insertCell(4);
	cellDate.className="normalfnt";
	cellDate.innerHTML=alloDate;
	
	var cellDate=row.insertCell(5);
	cellDate.className="normalfnt";
	cellDate.innerHTML='';
}

 function clearAlloData()
 {
	 //document.getElementById('txtfindpo').value="";
	 var tbl = document.getElementById('tblevents');
	var rowCount=tbl.rows.length;
	
 	if(rowCount<2)return;
	for(var rowC=1; rowC<rowCount; rowC++)
	{
	tbl.deleteRow(1);  
	//rowCount=tbl.rows.length;
  }
}