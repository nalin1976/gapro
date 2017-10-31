var RollPopupxmlHttp		= [];

var pub_rollSerialNo		= 0;
var pub_rollSerialYear		= 0;

var validateCount			= 0;

function ClearForm(){	
	setTimeout("location.reload(true);",0);
}

function RollPopupcreateXMLHttpRequest20(index){
	if (window.ActiveXObject) 
	{
		RollPopupxmlHttp[index] = new ActiveXObject("Microsoft.XMLHTTP");
	}
	else if (window.XMLHttpRequest) 
	{
		RollPopupxmlHttp[index] = new XMLHttpRequest();
	}
}

function RomoveData(data){
	var index = document.getElementById(data).options.length;
	while(document.getElementById(data).options.length > 0) 
	{
		index --;
		document.getElementById(data).options[index] = null;
	}
}

function RemoveAllRows(tableName){
	var tbl = document.getElementById(tableName);
	for ( var loop = tbl.rows.length-1 ;loop >= 1 ; loop -- )
	{
		 tbl.deleteRow(loop);
	}	
}

var AllowableCharators=new Array("38","37","39","40","8");
function isNumberKey(evt){
	var charCode = (evt.which) ? evt.which : evt.keyCode;
	 
	  for (x in AllowableCharators)
	  {
		  if (AllowableCharators[x] == charCode)
		  return true;		
	  }

	 if (charCode > 31 && (charCode < 48 || charCode > 57))
		return false;

	 return true;
  }

function closeWindow(){
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

/*function RemoveItem(obj){
	if(confirm('Are you sure you want to remove this item?')){
		obj.parentNode.parentNode.parentNode;

		var td = obj.parentNode;
		var tro = td.parentNode;
		//var tt=tro.parentNode;		
		tro.parentNode.removeChild(tro);
	}
}*/

function ChangeIssueQty(obj){
	var rw 			= obj.parentNode.parentNode.parentNode;
	if(obj.checked){		
		var BalanceQty 	= rw.cells[7].lastChild.nodeValue;		
		rw.cells[8].childNodes[0].value=BalanceQty;
	}
	else{
		rw.cells[8].childNodes[0].value=0;
	}
	CalculateTotalIssueQty();
}

function CalculateTotalIssueQty(){
	var tblPopUp=document.getElementById('tblMatPopUp');
	var issueLoopQty=0;
		for (loop =1; loop < tblPopUp.rows.length; loop++)
		{
			if (tblPopUp.rows[loop].cells[0].childNodes[0].childNodes[1].checked)
			{		
					var issueLoop =  parseFloat(tblPopUp.rows[loop].cells[8].childNodes[0].value);
					issueLoopQty += isNaN(issueLoop) ? 0:issueLoop;
			}	
		}
		document.getElementById('txtPopUpIssueQty').value="";
		document.getElementById('txtPopUpIssueQty').value =issueLoopQty;
}

function GetPopUpIssueQtyToText(){
	var tblPopUp		= document.getElementById('tblMatPopUp');
	var HeaderTitle		= document.getElementById('titHeaderCategory').title;
	var popUpIssueQty	= parseFloat(document.getElementById('txtPopUpIssueQty').value);
	var fabricRollArray = [];
	var fabricRollArrayIndex = 0;
	
		if(HeaderTitle=="ISSUE")
		{
			var tblIssueList = document.getElementById("tblIssueList");	
			tblIssueList.rows[Pub_PopUprowIndex].cells[6].childNodes[0].value = popUpIssueQty;
			var MrnQty	= parseFloat(tblIssueList.rows[Pub_PopUprowIndex].cells[8].childNodes[0].nodeValue);
			
			if(popUpIssueQty>MrnQty)
			{
				alert('Sorry!\nFabric roll qty cannot exceed Mrn Qty\nFabric roll Qty is ='+popUpIssueQty+'\nMrn Qty is ='+MrnQty+'\nVariance is ='+(MrnQty-popUpIssueQty))
				return;
			}
				tblIssueList.rows[Pub_PopUprowIndex].className = "bcgcolor-tblrowWhite";
				tblIssueList.rows[Pub_PopUprowIndex].cells[2].id =0;
		}
		
		if(HeaderTitle=="GATEPASS")
		{
			var tblGatePassMain = document.getElementById("tblGatePassMain");	
			tblGatePassMain.rows[Pub_PopUprowIndex].cells[9].childNodes[0].value = popUpIssueQty;
			var StockBal	= parseFloat(tblGatePassMain.rows[Pub_PopUprowIndex].cells[8].childNodes[0].nodeValue);
			
			if(popUpIssueQty>StockBal)
			{
				alert('Sorry!\nFabric roll qty cannot exceed Stock Balance\nFabric roll Qty is ='+popUpIssueQty+'\nStock Balance is ='+StockBal+'\nVariance is ='+(StockBal-popUpIssueQty))
				return;
			}
		}

//Start-Create a Fabric Roll Array
		for ( var loop = 1 ;loop < tblPopUp.rows.length ; loop ++ ){				
				if (tblPopUp.rows[loop].cells[0].childNodes[0].childNodes[1].checked){					
					var fabricRolldetails = [];
					fabricRolldetails[0] =   tblPopUp.rows[loop].cells[1].lastChild.nodeValue;	
					fabricRolldetails[1] =   tblPopUp.rows[loop].cells[2].lastChild.nodeValue;
					fabricRolldetails[2] =   tblPopUp.rows[loop].cells[3].lastChild.nodeValue;
					fabricRolldetails[3] =   parseFloat(tblPopUp.rows[loop].cells[8].childNodes[0].value);				
					fabricRollArray[fabricRollArrayIndex] = fabricRolldetails;
					fabricRollArrayIndex ++ ;							
				}
			}
		Materials[Pub_popUoRollIndex][9] = fabricRollArray;		
//End-Create a Fabric Roll Array
		closeWindow();
}

function ValidatePopUpQty(obj){
	var rw 				= obj.parentNode.parentNode;
	var BalanceQty 		= parseFloat(rw.cells[7].lastChild.nodeValue);	
	var RollIssueQty 	= parseFloat(obj.value);
		if(BalanceQty<RollIssueQty){
				obj.value	= BalanceQty;
		}
		CalculateTotalIssueQty();
}