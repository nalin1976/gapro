
// JavaScript Document
var xmlHttp 		= [];
var xmlHttpCommit;
var xmlHttpRollBack;
var pub_nextGridNo=0;
var pub_rowIndex = 0;

function createXMLHttpRequestOrderBook(index) 
{
	try
	 {
	 // Firefox, Opera 8.0+, Safari
	 xmlHttp[index]=new XMLHttpRequest();
	 }
	catch (e)
	 {
		 // Internet Explorer
		 try
		  {
		  	xmlHttp[index]=new ActiveXObject("Msxml2.XMLHTTP");
		  }
		 catch (e)
		  {
		  	xmlHttp[index]=new ActiveXObject("Microsoft.XMLHTTP");
		  }
	 }
}

function closeWindow()
{
	try
	{
		var box = document.getElementById('popupLayer');
		box.parentNode.removeChild(box);
		loca = 0;
	}
	catch(err)
	{        
	}	
}

function pageSubmitOrderBook()
{
	document.getElementById('frmCalender').submit();	
}
function refreshWindowOrderBook()
{
	createXMLHttpRequestOrderBook(0);
    xmlHttp[0].onreadystatechange = orderBookRequest;
    xmlHttp[0].open("GET", '../orderBook/orderBook.php', true);
    xmlHttp[0].send(null); 
}

function loadOrderBook()
{
	
	showPleaseWait();
	createXMLHttpRequestOrderBook(0);
	xmlHttp[0].onreadystatechange = orderBookRequest;
    xmlHttp[0].open("GET", '../orderBook/orderBook.php', true);
    xmlHttp[0].send(null);
    
	
	
}
function orderBookRequest()
{
    if((xmlHttp[0].readyState == 4) && (xmlHttp[0].status == 200)) 
    {
		var text = xmlHttp[0].responseText;
		//closeWindow();
		drawPopupAreaLayer(762,265,'frmOrderBook',1000);
		
		document.getElementById('frmOrderBook').innerHTML=text;
		
		checkRow();
		hidePleaseWait();
	}
}




//################CREATING A POP UP TO SELECT NEW ORDER STYLES##########################
function newOrderBookData()
{
	
	var url1  = "../orderBook/newOrderBook.php";
		
	htmlobj=$.ajax({url:url1,async:false});	
	//drawPopupArea(400,250,'newOrderBookPop');	
	drawPopupBox(408,346,'newOrderBookPop',1002)
	var HTMLText=htmlobj.responseText;	
	document.getElementById('newOrderBookPop').innerHTML=HTMLText;
}

function closePopupBox(index)
{
	try
	{
		var box = document.getElementById('popupLayer' + index);
		box.parentNode.removeChild(box);
	}
	catch(err)
	{        
	}	
}

//########################CLOSING NEW ORDER BOOK POP UP######################################
/*function closeWindow1()
{
	try
	{
		var box = document.getElementById('popupbox');
		
		box.parentNode.removeChild(box);
		loca = 0;
	}
	catch(err)
	{        
	}	
}
*/
//##################################VALIDATING newOrderBookPop##################################
function validateData()
{
	if(document.getElementById('txtStyleId').value=='')
	{
		alert("Please specify a StyleId");
	}
	else if(document.getElementById('txtQuantity').value=='')
	{
		alert("Please specify Quantity");
	}
	else if(document.getElementById('txtCutDate').value=='')
	{	
		alert("Please specify CutDate");
	}
	else 
		saveNewOrderBook();
}
//#################CHANGING the 'Description column' according to 'style Id' in pop up 2######################
function changeDescription(obj)
{	
	document.getElementById("txtDescription").value=obj.value;
}

//########################SAVING POP UP 2 DATA#############################
function saveNewOrderBook()
{
	if(document.getElementById('txtSMV').value=='')	
		var smv=0;
	else 
		var smv=document.getElementById('txtSMV').value;
	
	if(document.getElementById('txtSewingSMV').value=='')
		var sewingSmv=0;
	else
		var sewingSmv=document.getElementById('txtSewingSMV').value;
	
	 if(document.getElementById('txtCuttingSMV').value=='')
		var cuttingSmv=0;
	else
		var cuttingSmv=document.getElementById('txtCuttingSMV').value;
	
	if(document.getElementById('txtPackingSMV').value=='')
		var packingSmv=0;
	
			
	var url="../orderBook/newOrderBook-db.php?requestType=saveData";
	url+="&styleId="+document.getElementById('txtStyleId').value;
	url+="&quentity="+document.getElementById('txtQuantity').value;
	url+="&cutDate="+document.getElementById('txtCutDate').value;
	url+="&exFactory="+document.getElementById('txtExFacDate').value;
	url+="&smv="+smv;
	url+="&cuttingSmv="+cuttingSmv;
	url+="&sewingSmv="+sewingSmv;
	url+="&packingSmv="+packingSmv;
	
	var xmlhttp_obj = $.ajax({url:url,async:false})
	var variable = xmlhttp_obj.responseText;
	
	if(variable==1)
	{
		alert("Saved Successfully");
		var styleId=document.getElementById('txtStyleId').value;
		updatePopUp1(styleId);
		clearFields();
	}
	else
	{
		alert("Saving Failed.Data Exists");
		clearFields();
	}
	

}

//######################CLEARING THE FIELDS IN POP UP 1###########################################
function clearFields()
{
	document.getElementById('txtStyleId').value='';
	document.getElementById('txtDescription').value='';
	document.getElementById('txtQuantity').value='';
	document.getElementById('txtCutDate').value='';
	document.getElementById('txtExFacDate').value='';
	document.getElementById('txtSMV').value='';
	document.getElementById('txtSewingSMV').value='';
	document.getElementById('txtCuttingSMV').value='';
	document.getElementById('txtPackingSMV').value='';
	
}

///###########################UPDATING POP UP1 ACCORDING TO POP UP2###############################
function updatePopUp1(styleId)
{
	var xmlhttp_obj;
	
	var url="../orderBook/newOrderBook-db.php?requestType=loadNewRow";
	url+="&styleId="+styleId;
	xmlhttp_obj=$.ajax({url:url,async:false})
	
	var html = xmlhttp_obj.responseText;
	
	var arr=html.split(",");
	
	var innerString="";
	
	innerString+="<tr  ondblclick=\"createObject(this)\" class=\"mouseover\" onmouseover=\"this.style.backgroundColor=\'#A9F097\';\" onmouseout=\"this.style.backgroundColor=\'#FFFFFF\';\">";
             innerString+="<td align=\"center\" valign=\"middle\" class=\"normalfntMid\"><div align=\"center\"></div></td>";
             innerString+="<td style=\"white-space:normal\" width=\"56\" class=\"normalfntMid\" >"+arr[0]+"</td>";
             innerString+="<td width=\"125\" class=\"normalfntMid\">"+arr[0]+"</td>";
             innerString+="<td width=\"56\" class=\"normalfntMid\">"+arr[1]+"</td>";
			innerString+="<td  width=\"108\" class=\"normalfntMid\">"+arr[2].substr(0,10)+"</td>";
			innerString+="<td  width=\"89\" class=\"normalfntMid\">"+arr[3].substr(0,10)+"</td>";
			innerString+="<td  width=\"72\" class=\"normalfntMid\">"+arr[4]+"</td>";
			innerString+="<td  width=\"47\" class=\"normalfntMid\">"+arr[5]+"</td>";
			innerString+="<td  width=\"48\" class=\"normalfntMid\">"+arr[6]+"</td>";
			innerString+="<td  width=\"48\"><input type=\"text\" name=\"txt_cutSmv\" id=\"txt_cutSmv\" style=\"text-align:center\" size=\"8\"  value=\""+arr[7]+"\"  onkeypress=\"return isNumberKey(event);\" /></td>";
			innerString+="<td  width=\"48\"><input type=\"text\" name=\"txt_cutSmv\" id=\"txt_cutSmv\" style=\"text-align:center\" size=\"8\"  value=\""+arr[8]+"\"  onkeypress=\"return isNumberKey(event);\" /></td>";
			innerString+="<td  width=\"48\"><input type=\"text\" name=\"txt_cutSmv\" id=\"txt_cutSmv\" style=\"text-align:center\" size=\"8\"  value=\""+arr[9]+"\"  onkeypress=\"return isNumberKey(event);\" /></td>";
			innerString+="<td width=\"20\"><img src=\"../../images/accept.png\" onclick=\"saveNewSmvDetails(this)\" /></td>";
			
            innerString+="</tr>";
			
			
			//####################CREATING A NEW ROW IN "SELECT STYLE" POP UP############################## 
			$('#tblOrderBook tr:last').after(innerString);
		
}

function saveNewSmvDetails(obj)
{
	
	//alert(obj.id);
	//obj.parentNode.parentNode.cells[12].innerHTML="<img src=\"../../images/loadingimg.gif\" />";
	var par=obj.parentNode; 
 	while(par.nodeName.toLowerCase()!='tr')
	{ 
 	 	par=par.parentNode; 
 	} 
	 //alert(par.rowIndex);
	
	//var rowId=Number(obj.id);
	//rowId=rowId+1;
	//alert(rowId);
	var tblOrderBook=document.getElementById('tblOrderBook');
	
	var rowIndex=obj.parentNode.parentNode.rowIndex;
	//alert(rowIndex);
	
	var styleId=tblOrderBook.rows[par.rowIndex].cells[1].childNodes[0].nodeValue;
	//alert(styleId);
	var dblCuttingSmv=tblOrderBook.rows[par.rowIndex].cells[9].childNodes[0].value;
	var dblSewingSmv=tblOrderBook.rows[par.rowIndex].cells[10].childNodes[0].value;
	var dblPackingSmv=tblOrderBook.rows[par.rowIndex].cells[11].childNodes[0].value;
	
	//alert(dblCuttingSmv)
	
	if(dblCuttingSmv=='')
		dblCuttingSmv=0;
	if(dblSewingSmv=='')
		dblSewingSmv=0;
	if(dblPackingSmv=='')
		dblPackingSmv=0;
	
	var url = "../orderBook/orderBook-db.php?id=updateOrders";
	url  +="&styleId="+styleId;
	url	+="&dblCuttingSmv="+dblCuttingSmv;
	url +="&dblSewingSmv="+dblSewingSmv;
	url	+= "&dblPackingSmv="+dblPackingSmv;
	tblOrderBook.rows[rowIndex].cells[12].innerHTML="<img src=\"../../images/loading.gif\" width=\"20\" height=\"20\" />";	
	//obj.parentNode.parentNode.cells[12].innerHTML="";
	htmlobj=$.ajax({url:url,async:false});
	//alert(htmlobj.responseText);
	tblOrderBook.rows[rowIndex].cells[12].innerHTML="";
}

function isNumberKey(evt)
      {
        var charCode = (evt.which) ? evt.which : event.keyCode
          if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57))
             return false;

          return true;
      }
	  
	  
function loadSaveImage(obj)
{
	obj.parentNode.parentNode.cells[12].innerHTML="<img src=\"../../images/accept.png\" onclick=\"saveNewSmvDetails(this)\" />";
}