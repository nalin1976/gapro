// JavaScript Document

function addToGrid(){
document.getElementById("frmSupInvUploadData").submit();
}
//-----------------------------------------------------------------------------
function grid_fix_header()
{
	$("#tblMain").fixedHeader({
	width: 800,height: 600
	});	
}

//-----------------------------------------------------------------------------


function saveSupInvoiceUploadData(){
var tblMain = document.getElementById("tblMain");
var count = 1;
for(var a=1;a<tblMain.rows.length;a++){
	if(tblMain.rows[a].cells[3].childNodes[0].nodeValue != 'a'){
	count++;	
	}
}

 var path = "SupInvUploadDataGrid-db-get.php?RequestType=loadSerialNo";
 htmlobj1=$.ajax({url:path,async:false});
 
 var XMLserialNo = htmlobj1.responseXML.getElementsByTagName("serialNo");
 var serialNo = XMLserialNo[0].childNodes[0].nodeValue;
 
    var hiddenSupId = document.getElementById("hiddenSupId").value;
    var hiddenFileName = document.getElementById("hiddenFileName").value;
	var path = "SupInvUploadDataGrid-db-set.php?RequestType=saveHeader";
		path += "&serialNo="+serialNo;
		path += "&hiddenSupId="+hiddenSupId;
		path += "&hiddenFileName="+hiddenFileName;
		htmlobj2=$.ajax({url:path,async:false});
		
		if(htmlobj2.responseText == '1'){
		 var tblMain = document.getElementById("tblMain");
		 var count = 1;
		  for(var a=1;a<tblMain.rows.length;a++){
			var poNo = tblMain.rows[a].cells[0].lastChild.nodeValue;  
			var date = tblMain.rows[a].cells[2].lastChild.nodeValue; 
			var invoiceNo = tblMain.rows[a].cells[3].lastChild.nodeValue;  
			var amount = tblMain.rows[a].cells[4].lastChild.nodeValue;  
			
			var saveCount = 1;
			if(tblMain.rows[a].cells[3].childNodes[0].nodeValue != 'a'){
				var path = "SupInvUploadDataGrid-db-set.php?RequestType=saveDetails";
				    path += "&serialNo="+serialNo;
				    path += "&poNo="+poNo;
				    path += "&date="+date;
				    path += "&invoiceNo="+invoiceNo;
					path += "&amount="+amount;
				
			    htmlobj3=$.ajax({url:path,async:false});

			}
		  }
		  		if(saveCount == count){
				 alert("Saved successfully");	
				}
		}
}

//---------------------------------------------------------------------------------------------------------

function loadProcessPopUp(){
	var url = "processPopUp.php";
	
	htmlobj=$.ajax({url:url,async:false});
	drawPopupBox(0,0,'processPopUp',1);
	document.getElementById('processPopUp').innerHTML = htmlobj.responseText;
}

//---------------------------------------------------------------------------------------------------------

function CloseOSPopUp(LayerId)
{
	try
	{
		var box = document.getElementById(LayerId);
		box.parentNode.removeChild(box);
		hideBackGround('divBG');
	}
	catch(err)
	{        
	}	
}

//--------------------------------------------------------------------------------------------------------

function loadSupInvoice(){
	var hiddenSupId = document.getElementById("hiddenSupId").value;
	
	var path = "SupInvUploadDataGrid-db-get.php?RequestType=loadSupInvoice";
	path += "&hiddenSupId="+hiddenSupId;
	
	htmlobj=$.ajax({url:path,async:false});
	
	document.getElementById('tblInvoices').innerHTML = htmlobj.responseText;
}

