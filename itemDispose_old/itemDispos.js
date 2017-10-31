// JavaScript Document
var xmlHttp;
var pub_intxmlHttp_count=0;
function createXMLHttpRequest() 
{
	if (window.ActiveXObject) 
	{
		xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
	}
	else if (window.XMLHttpRequest) 
	{
		xmlHttp = new XMLHttpRequest();
	}
}

function GetXmlHttpObject()
{
	var xmlHttp=null;
	try
 	{
 	// Firefox, Opera 8.0+, Safari
 		xmlHttp=new XMLHttpRequest();
 	}
	catch (e)
 	{
 	// Internet Explorer
 		try
  		{
  			xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
  		}
 	catch (e)
  	{
  		xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
  	}
 	}
return xmlHttp;
}

function LoadSC(obj)
{
	document.getElementById('cmbSC').value = obj.value;
	}
	
function LoadStyle(obj)
{
	document.getElementById('cmbStyle').value = obj.value;
	}
	
function LoadSubCat()
{
	var mainCat = document.getElementById('cmbMainCat').value;
	createXMLHttpRequest();
	xmlHttp.onreadystatechange = DisplaySubCat;
	xmlHttp.open("GET",'itemDisposeXml.php?RequestType=getSubCat&mainCat='+ mainCat,true);
	xmlHttp.send(null);	
}

function DisplaySubCat()
{
	if (xmlHttp.readyState==4)
		{
			if (xmlHttp.status==200)	
			{
				var XMLMainID =xmlHttp.responseXML.getElementsByTagName("SubCatId");
				var XMLName =xmlHttp.responseXML.getElementsByTagName("SubCatName");
				document.getElementById("cmbSubCat").innerHTML="";
					/*var opt = document.createElement("option");
						opt.text = "Select SubCategory";						
						document.getElementById("cmbSubCat").options.add(opt);	
					*/					
					for ( var loop = 0; loop < XMLName.length; loop ++)
			 		{	
						
						var opt = document.createElement("option");
						opt.text = XMLName[loop].childNodes[0].nodeValue;
						opt.value = XMLMainID[loop].childNodes[0].nodeValue;
						document.getElementById("cmbSubCat").options.add(opt);			
			 		}
			}
		}
	
}

function loadSubStores(obj)
{

	if(obj.value.trim()=="")
	{
		document.getElementById("cboSubStore").innerHTML="<option value=\"0\">Select SubStore</option>";
		return false;
	}
	var path  = "itemDisposeXml.php?req=loadSubStore&mainStore="+obj.value.trim();
	htmlobj=$.ajax({url:path,async:false});
	
	var XMLSubID 			=	htmlobj.responseXML.getElementsByTagName("strSubID");
	var XMLSubStoresName 	=	htmlobj.responseXML.getElementsByTagName("strSubStoresName");

	document.getElementById("cboSubStore").innerHTML="";
	//document.getElementById("cboSubStore").innerHTML="<option value=\"0\">Select SubStore</option>";
	var opt = document.createElement("option");					
		document.getElementById("cboSubStore").options.add(opt);	
		for ( var loop = 0; loop < XMLSubID.length; loop++)
		{	
			//alert(XMLSubID[loop].childNodes[0].nodeValue);
			var opt = document.createElement("option");
			opt.text =XMLSubStoresName[loop].childNodes[0].nodeValue;
			opt.value =  XMLSubID[loop].childNodes[0].nodeValue;
			document.getElementById("cboSubStore").options.add(opt);			
		}
	
}

function LoadItemData()
{
	if(document.getElementById('cmbStyle').value.trim() == "")
	{
		alert("Select style.");
		return false;
	}
	document.getElementById('frmItemDispose').submit();
}

function saveGrid()
{
	var path="";  // = "itemDispose_db.php?req=saveDet";
	var tblMain=document.getElementById('tblMain').tBodies[0];
	var rowCount=tblMain.rows.length;
	
	htmlobj=$.ajax();
	var tag='';
	var count=0;
	for(var i=0;i<rowCount;i++)
	{
		if(tblMain.rows[i].cells[5].childNodes[0].checked)
		{
			
			if(tblMain.rows[i].cells[4].childNodes[1].value.trim()==""){
				alert("Fill Dispose Qty.");
				tblMain.rows[i].cells[4].childNodes[1].focus();
				return false;
				}
				count++;
		}
	}
	pub_intxmlHttp_count = count;
	var c=0;
	for(var i=0;i<rowCount;i++)
	{
		if(tblMain.rows[i].cells[5].childNodes[0].checked)
		{
			c++;
			path  = "itemDispose_db.php?req=saveDet";
			//alert(count+"="+c);
			((count)==c)?tag=1:tag=0;
			var style=tblMain.rows[i].cells[0].id;
			var buyerPo=tblMain.rows[i].cells[1].id;
			var maiID =tblMain.rows[i].cells[2].id;
			var qty=tblMain.rows[i].cells[3].innerHTML;
			var disposeQty=tblMain.rows[i].cells[4].childNodes[1].value;
			//var dispose=tblMain.rows[i].cells[5].innerHTML;
			var mainStores=tblMain.rows[i].cells[6].id;
			var subStores=tblMain.rows[i].cells[7].id;
			var location =tblMain.rows[i].cells[8].id;
			var bin=tblMain.rows[i].cells[9].id;
			var color=tblMain.rows[i].cells[10].innerHTML;
			var size=tblMain.rows[i].cells[11].innerHTML;
			var unitD=tblMain.rows[i].cells[12].innerHTML;
			
			path+="&style="+style+"&buyerPo="+buyerPo+"&maiID="+maiID+"&qty="+qty+"&disposeQty="+disposeQty+"&mainStores="+mainStores+"&subStores="+subStores+"&location="+location+"&bin="+bin+"&color="+color+"&size="+size+"&unitD="+unitD+"&tag="+tag;
			htmlobj=$.ajax({url:path,async:false});
			
		}
		
	}
	if(htmlobj.responseText==1)
	{
		alert("Saved successfully.");
	}
	
}
function setBalance(obj)
{
	var tblMain=document.getElementById('tblMain').tBodies[0];
	var td=obj.parentNode;
	var cell3=td.parentNode.cells[3].innerHTML;
	var cell4=td.parentNode.cells[4].childNodes[1].value;
	//alert(parseInt(cell4)< parseInt(cell3));
	if( parseFloat(cell4) <= parseFloat(cell3))
	{
		td.parentNode.cells[4].childNodes[1].value="";
		td.parentNode.cells[4].childNodes[1].value=cell4;
	}
	else
	{
		var myStr = cell4;
		var strLen = myStr.length;
		td.parentNode.cells[4].childNodes[1].value=myStr = myStr.slice(0,strLen-1);
		//alert("Issued qty not exceed to Recieve qty.");
	}
	
}

function loadReport()
{
	var docNo=document.getElementById('cboDisposeNo').value.trim();
	if(docNo=="")
	{
		alert("Select Dispose Number.");
		return false;
	}
	else
	{
		window.open("itemDisposalReport.php?req="+docNo+"",'new'); 
	}
}

function loadDisposedItems(obj)
{
	if(obj.value.trim()=="")
	{
		return false;
	}
	var path  = "itemDisposeXml.php?req=loadListing&docNo="+obj.value.trim();
	htmlobj=$.ajax({url:path,async:false});
	var XMLDocumentNo 	=	htmlobj.responseXML.getElementsByTagName("DocumentNo");
	var XMLStyle		=	htmlobj.responseXML.getElementsByTagName("Style");
	var XMLBuyerPoName 	=	htmlobj.responseXML.getElementsByTagName("BuyerPoName");
	var XMLDescription	=	htmlobj.responseXML.getElementsByTagName("Description");
	var XMLQty 			=	htmlobj.responseXML.getElementsByTagName("Qty");
	var tblMain=document.getElementById('tblMain').tBodies[0];
	tblMain.innerHTML="";
	for(var i=0;i<XMLDocumentNo.length;i++)
	{
		var rowCount = tblMain.rows.length;
        var row = tblMain.insertRow(rowCount);
		(i%2==1)?row.className="grid_raw":row.className="grid_raw2";
		
		var htm="";
			htm="<td>"+XMLDocumentNo[i].childNodes[0].nodeValue+"</td>";
			htm+="<td>"+XMLStyle[i].childNodes[0].nodeValue+"</td>";
			htm+="<td>"+XMLBuyerPoName[i].childNodes[0].nodeValue+"</td>";
			htm+="<td>"+XMLDescription[i].childNodes[0].nodeValue+"</td>";
			htm+="<td>"+XMLQty[i].childNodes[0].nodeValue+"</td>";
			row.innerHTML =htm;	
	}
}

