

$(document).ready(function(){
    
    var styleCode = -1;
    var buyerCode = -1;
    
    // Load buyers to the select option
    // ==================================================================
    var url_buyer = "middle_ordercompletion.php?opt=b";
    
    var htmlObj = $.ajax({url:url_buyer, async:false});
    
    var XMLBuyerID = htmlObj.responseXML.getElementsByTagName("BUYER_ID");
    var XMLBuyerName = htmlObj.responseXML.getElementsByTagName("BUYER_NAME");
    
    $("#cboCustomer").append($('<option>', {value:-1, text:'Select Buyer'}));
    
    for(var loop=0; loop < XMLBuyerID.length; loop++){
        
        var buyerId = XMLBuyerID[loop].childNodes[0].nodeValue;
        var buyerName = XMLBuyerName[loop].childNodes[0].nodeValue;        
        $("#cboCustomer").append($('<option>', {value:buyerId, text:buyerName}));
        
    }
    // ==================================================================
    
    
    // Load style to the select option
    // ==================================================================
    var url_styles = "middle_ordercompletion.php?opt=s";
    
    var htmlObjStyles = $.ajax({url:url_styles, async:false});
    
    var XMLOrderID = htmlObjStyles.responseXML.getElementsByTagName("ORDER_ID");
    var XMLOrderName = htmlObjStyles.responseXML.getElementsByTagName("STYLE_NAME");
    
    $("#cboStyles").append($('<option>', {value:-1, text: 'Select Style'}));
    
    for(var loop=0; loop < XMLOrderID.length; loop++){
        
        var orderId = XMLOrderID[loop].childNodes[0].nodeValue;
        var styleName = XMLOrderName[loop].childNodes[0].nodeValue;
        
        $("#cboStyles").append($('<option>', {value:orderId, text: styleName}));
    }
    
    // ==================================================================
    
    // Load SC numbers to the select option
    // ==================================================================
    $("#cboSR").append($('<option>', {value:-1, text: 'Select SC number'}));
    var url_sc = "middle_ordercompletion.php?opt=SC";
    
    var htmlObjSC = $.ajax({url:url_sc, async:false});
    
    var XMLStyleID = htmlObjSC.responseXML.getElementsByTagName("STYLE_ID");
    var XMLSC = htmlObjSC.responseXML.getElementsByTagName("SC_NO");
    
    for(var loop=0; loop < XMLStyleID.length; loop++){
        
        var styleId = XMLStyleID[loop].childNodes[0].nodeValue;
        var sc_no = XMLSC[loop].childNodes[0].nodeValue;
        
        $("#cboSR").append($('<option>', {value:styleId, text: sc_no}));
        
        //$("#cboSR").val(5724);
    }
    
    // ==================================================================
    
    $("#cboStyles").change(function(e){
       styleCode = $(this).val();
       
   });   
   
    $("#cboSR").change(function(e){
       styleCode = $(this).val();
       
   });
   
   $("#btnSearch").click(function (e){       
       GetOrderList();
   });
   
   
   $("#btnSave").click(function(e){
       
       var tbOrderList = $("#tblCompleteOrders > tbody");
       
       tbOrderList.find('tr').each(function(key, val){
          
          var tdElement = $(this).find('td');
          
          var objCheckBox = $(tdElement).eq(0).find(':checkbox');
          
          if($(objCheckBox).is(':checked')){
              var styleCode = $(objCheckBox).attr('id');
              var strSC =  $(tdElement).eq(2).html().replace(/&nbsp;/gi,"");
              
              var objCheckBoxWriteOff = $(tdElement).eq(1).find(':checkbox');
              
              if($(objCheckBoxWriteOff).is(':checked')){
                  CompleteOrderProcess(styleCode, strSC);
              }else{
                  OrderSetAsComplete(styleCode, strSC);
              }
          }
           
       });
       GetOrderList();
   });
   
});


function GetOrderList(){
    
    var buyerCode = $("#cboCustomer").val();
    var styleCode = $("#cboStyles").val();
    
    if(styleCode == -1){ styleCode = $("#cboSR").val();}

    var url_orderlist = "";
    var htmlObjOrders = "";

    if(buyerCode != -1){

        url_orderlist = "middle_ordercompletion.php?opt=BUYER&buyerCode="+buyerCode;
        htmlObjOrders = $.ajax({url:url_orderlist, async:false});

        AddOrdersToGrid(htmlObjOrders);


    }else{

       url_orderlist = "middle_ordercompletion.php?opt=STYLE&styleCode="+styleCode;
       htmlObjOrders = $.ajax({url:url_orderlist, async:false}); 
       
       AddOrdersToGrid(htmlObjOrders);

    }
    
}

function CompleteOrderProcess(prmStyleCode, prmSCNo){
    
    /* Transfer all the stock_transaction details to the stock_transaction_history table
     * from relavant style    
    */
   
   var url_stocktransaction = "middle_ordercompletion.php?opt=SAVESTOCK&styleCode="+prmStyleCode;
   var htmlObjST = $.ajax({url:url_stocktransaction, async:false});
   
   if(htmlObjST.responseText != '1'){
       alert(htmlObjST.responseText);
       return;
   }else{
       
       alert("SC number " + prmSCNo + " update as a complete and transfer raw material to left over");
       
   }
}

function OrderSetAsComplete(prmStyleCode, prmSCNo){
    
    var url_completeorder = "middle_ordercompletion.php?opt=COMPORDER&styleCode="+prmStyleCode;
    var htmlObjOrder = $.ajax({url:url_completeorder, async:false});
    
    if(htmlObjOrder.responseText != '1'){
       alert(htmlObjOrder.responseText);
       return;
   }else{
       
       alert("SC number " + prmSCNo + " update as a complete");
       
   }
    
}

function AddOrdersToGrid(prmHtmlObj){
    
     $("#tblCompleteOrders > tbody").empty();
    
    var XMLStyleCode = prmHtmlObj.responseXML.getElementsByTagName("STYLE_ID");
    var XMLSCNo = prmHtmlObj.responseXML.getElementsByTagName("SC_NO");
    var XMLStyleID = prmHtmlObj.responseXML.getElementsByTagName("STYLE_NAME");
    var XMLDescription = prmHtmlObj.responseXML.getElementsByTagName("DESC");
    var XMLBuyer = prmHtmlObj.responseXML.getElementsByTagName("BUYER");
    var XMLOrderQty = prmHtmlObj.responseXML.getElementsByTagName("ORDER_QTY");
    
    for(var loop=0; loop < XMLStyleCode.length; loop++){
        
        var styleCode = XMLStyleCode[loop].childNodes[0].nodeValue;
        var scNo = XMLSCNo[loop].childNodes[0].nodeValue;
        var styleID = XMLStyleID[loop].childNodes[0].nodeValue;
        var styleDesc = XMLDescription[loop].childNodes[0].nodeValue;
        var buyerName = XMLBuyer[loop].childNodes[0].nodeValue;
        var orderQty = XMLOrderQty[loop].childNodes[0].nodeValue;
        
        $("#tblCompleteOrders > tbody:last-child").append("<tr class=\"info\"><td width=\"2%\" align=\"center\"><input type=\"checkbox\" id="+styleCode+"  /></td><td width=\"2%\" align=\"center\"><input type=\"checkbox\" /></td><td width=\"16%\" class=\"normalfnt\">&nbsp;"+scNo+"</td><td width=\"16%\" class=\"normalfnt\">&nbsp;"+styleID+"</td><td width=\"24%\" class=\"normalfnt\">&nbsp;"+styleDesc+"</td><td width=\"24%\" class=\"normalfnt\">&nbsp;"+buyerName+"</td><td width=\"11%\" class=\"normalfnt\">&nbsp;"+orderQty+"</td><td width=\"7%\" class=\"normalfnt\"><button class=\"btn btn-primary btn-view \" type=\"button\" id="+styleCode+" onclick=\"viewstock(this)\"><strong>View</strong></button></td></tr>");
        
    }    
}

function viewstock(prmObj){
    
    var styleCode = prmObj.id;
    
    var url  = "stockbalance.php?style="+styleCode;
    
    //var url = "../itemDispose/itemDispose_pop.php";
    htmlobj=$.ajax({url:url,async:false});

    drawPopupAreaLayer(920,460,'frmItemDisposal',1);				
    var HTMLText=htmlobj.responseText;
    document.getElementById('frmItemDisposal').innerHTML=HTMLText;	
    
}

function CloseWindow(){
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

/*

var index = 0;
var styles =new Array();
var rowArray = [];
var message = "Following Style Numbers has been confirmed.\n\n";
var pendingMsg= "Following Style Numbers have items to confirm dispose.\n\n";
var pending=0;
var completed=0;

function resetCompanyBuyer()
{
	document.getElementById("cboFactory").value = "Select One";
	document.getElementById("cboCustomer").value = "Select One";
}

function submitForm()
{
	document.frmcomplete.submit();
}

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

function GetScNo(obj)
{
    
	//alert(obj.value);
       //document.getElementById('cboSR').value = obj.value;
       //document.getElementById('cboSR').selectedIndex = 5;
}
function GetStyleNo(obj)
{
	document.getElementById('cboStyles').value = obj.value;
}
//-----------------------------------------------------------------
function startCompletionProcess()
{
	var booCheck = false;
	var pos = 0;
	var tbl = document.getElementById('tblCompleteOrders');
	for ( var loop = 1 ;loop < tbl.rows.length ; loop ++ )
	{
		if (tbl.rows[loop].cells[0].childNodes[0].checked)
		{
			booCheck = true;
			styles[pos] = tbl.rows[loop].cells[0].childNodes[0].id;
			pos ++;
		}
	}
	if(booCheck)
		processCompletion();
	else
		alert("Please select at least one 'Style No'.")
}

function processCompletion()
{
	if (index > styles.length -1)
	{
		alert("Process completed.");
		window.location = window.location;
		return;
	}
	var styleID = URLEncode(styles[index]);
	createXMLHttpRequest();
    xmlHttp.onreadystatechange = HandleProcessCompletion;
    xmlHttp.open("GET", 'ordercompletiondb.php?RequestType=competeOrders&styleID=' + styleID, true);
    xmlHttp.send(null);  
}

function HandleProcessCompletion()
{
    if(xmlHttp.readyState == 4) 
    {
        if(xmlHttp.status == 200) 
        {  
			if (xmlHttp.responseXML.getElementsByTagName("Status")[0].childNodes[0].nodeValue == "True")
			{
				message += styles[index] +", ";
				index ++;
				processCompletion();
			}
		}
	}
}
//---------------------------------------------------------------------
function startConfirmationProcess()
{
	var booCheck = false;
	var pos = 0;
	var tbl = document.getElementById('tblCompleteOrders');
	for ( var loop = 1 ;loop < tbl.rows.length ; loop ++ )
	{
		if (tbl.rows[loop].cells[0].childNodes[0].checked)
		{
			booCheck = true;
			styles[pos] = tbl.rows[loop].cells[0].childNodes[0].id;
			pos ++;
		}
	}
	if(booCheck)
		confirmationProcess();
	else
		alert("Please select at least one 'Style No'.")
}

function confirmationProcess()
{
	if (index > styles.length-1){
		// alert(styles.length-1 );
		//alert(index );
	 	//alert(pending);
		if(completed>0)
		alert(message);
		else
		pendingMsg = "No any items confirmed. ,"+pendingMsg; 
		
		if(pending>0){
			alert(pendingMsg);
		}
		    submitForm();
			return;
		
	}
	
	
	var styleID = URLEncode(styles[index]);
	createXMLHttpRequest();
    xmlHttp.onreadystatechange = HandleConfirmationProcess;
    xmlHttp.open("GET", 'ordercompletiondb.php?RequestType=confirmOrders&styleID=' + styleID, true);
    xmlHttp.send(null);  
}



function HandleConfirmationProcess()
{
    if(xmlHttp.readyState == 4) 
    {
        if(xmlHttp.status == 200) 
        {  
	//	alert(xmlHttp.responseText);
			if (xmlHttp.responseXML.getElementsByTagName("Status")[0].childNodes[0].nodeValue == "True")
			{
				if(completed==0)
				message += styles[index];
				else
				message += ", "+styles[index];
				index ++;
				completed++;
				confirmationProcess();
			}
			if (xmlHttp.responseXML.getElementsByTagName("Status")[0].childNodes[0].nodeValue == "Pending")
			{
				if(pending==0)
				pendingMsg += styles[index];
				else
				pendingMsg += ", "+styles[index];
				
				index ++;
				pending++;
				confirmationProcess();
				//alert(pending);
			}
			
		}
	}
}
//---------------------------------------------------------------------------------
function SelectAll(obj)
{
	var tbl  = document.getElementById('tblCompleteOrders');
	var check = true;
	if(obj.checked)	
		check = true;
	else 
		check = false;
		
	for(loop=1;loop<tbl.rows.length;loop++)
	{
		tbl.rows[loop].cells[0].childNodes[0].checked=check;
	}
}
//--------------------------------------------------------
//---------------------------------------------------------
function loadItemsForDisposal(style,file)
{
	
	var url  = "completeItemDispose.php?style="+style+"&file="+file;
	alert(url);
	//var url = "../itemDispose/itemDispose_pop.php";
	htmlobj=$.ajax({url:url,async:false});
	
	drawPopupAreaLayer(920,460,'frmItemDisposal',1);				
	var HTMLText=htmlobj.responseText;
	document.getElementById('frmItemDisposal').innerHTML=HTMLText;	
	
	
}
//---------------------------------------------------

//------------------------------------
function setArray(obj)
{
	//alert(obj.checked);
	var row  =obj.parentNode.parentNode.parentNode;
	var rowId = row.rowIndex;
	if(obj.checked)
	{
		rowArray[rowArray.length]				=	rowId;
		row.cells[7].childNodes[1].disabled=false;
		row.cells[7].childNodes[1].value = row.cells[6].innerHTML;
		row.cells[7].childNodes[1].select();
		//row.cells[4].childNodes[0].disabled	=	'disabled';
	}
	else
	{
		row.cells[7].childNodes[1].disabled=true;
		row.cells[7].childNodes[1].value = '0';
		var indexId = rowArray.indexOf(rowId);
		if(indexId!=-1)
			rowArray.splice(indexId,1);
	}
	
}
//---------------------------------------------------------------
function setBalQty(loop)
{
var tbl = document.getElementById('tblMain');
var Qty =parseFloat(tbl.rows[loop].cells[6].innerHTML.trim());
var disposeQty=parseFloat(tbl.rows[loop].cells[7].childNodes[1].value);

//alert(Qty);
//alert(disposeQty);

if(disposeQty > Qty){
alert("Invalid Dispose Qty");
tbl.rows[loop].cells[7].childNodes[1].value=Qty;
}

if(Qty ==0){
tbl.rows[loop].cells[4].childNodes[0].checked=false;
}
else{
tbl.rows[loop].cells[4].childNodes[0].checked=true;
}

var bal=parseFloat(tbl.rows[loop].cells[6].innerHTML.trim())-parseFloat(tbl.rows[loop].cells[7].childNodes[1].value);
var roundBal=Math.round(bal*Math.pow(10,4))/Math.pow(10,4)
//tbl.rows[loop].cells[6].innerHTML=roundBal;


}



//------------------------------------------------------------------------
function saveDisposedAndLeft()
{
	var tblMain=document.getElementById('tblMain');
	var count = rowArray.length;
	//alert(count);
/*	for(var i=rowArray[0];i<count;i++)
	{*/
/*	var i =0;
	var y = 0;
	var n = 0;
	var disNo = '';
	
		for(var x in  rowArray )
		{
			i = rowArray[x];
			//alert(tblMain.rows[i].cells[4].innerHTML);
			var disposeQty=parseFloat(tblMain.rows[i].cells[7].childNodes[1].value);
			if(disposeQty>0)
			{
			//alert(i);
		//alert(rowArray[$i]);	
                        var qty=parseFloat(tblMain.rows[i].cells[3].innerHTML);
                        
                        if(disposeQty > qty){
                            alert("Sorry cannot dispose more than the available quantity");
                            return;
                        }    
			path  = "ordercompletiondb.php?RequestType=saveDet";
			//alert(count+"="+c);
			//((count)==c)?tag=1:tag=0;
			var style=tblMain.rows[i].cells[0].innerHTML;
			var buyerPo=trim(tblMain.rows[i].cells[1].id);
			var maiID =tblMain.rows[i].cells[2].id;
			
			//alert(tblMain.rows[i].cells[4].innerHTML);
			
                        
			//var dispose=tblMain.rows[i].cells[5].innerHTML;
			
			var balanceQty=tblMain.rows[i].cells[6].innerHTML.trim();
			var mainStores=tblMain.rows[i].cells[9].id;
                        var subStores=tblMain.rows[i].cells[10].id;
			var location =tblMain.rows[i].cells[11].id;
			var bin=tblMain.rows[i].cells[12].id;
			/*var color=tblMain.rows[i].cells[11].innerHTML;
			var size=tblMain.rows[i].cells[12].innerHTML;
			var unitD=tblMain.rows[i].cells[13].innerHTML;*/
        /*                var color=tblMain.rows[i].cells[3].innerHTML;
			var size=tblMain.rows[i].cells[4].innerHTML;
			var unitD=tblMain.rows[i].cells[5].innerHTML
			
			path+="&style="+URLEncode(style)+"&buyerPo="+URLEncode(buyerPo)+"&maiID="+maiID+"&qty="+qty+"&disposeQty="+disposeQty+"&mainStores="+mainStores+"&subStores="+subStores+"&location="+location+"&bin="+bin+"&color="+URLEncode(color)+"&size="+URLEncode(size)+"&unitD="+unitD+'&disNo='+disNo+'&balanceQty='+balanceQty;
			htmlobj=$.ajax({url:path,async:false});
				
				var XMLDisVal = htmlobj.responseXML.getElementsByTagName("disVal");
				var x= XMLDisVal[0].childNodes[0].nodeValue				
				//alert(x);
				if(x>0)
				{
					y = y+1;
					disNo = x;
				}
				
			n++;
			}
			else
				count--;
	}//end of for
		rowArray = [];
		if(n==0)
			alert('Item not found.');
		else if(count ==y)
		{
			alert('Saved successfully.');
			CloseWindow();
		}
		else{
			alert('Fail');
		}
	
}*/
//---------------------------------------------------------------------------------------------