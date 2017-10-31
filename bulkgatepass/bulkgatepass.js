// JavaScript Document
var Materials 		= [];
var Bindetails 		= [];
var mainArrayIndex 	= 0 ;
var ReqGatePassQty 	= 0;
var mainRw			= 0;
var id			    = 0;
var pub_commonBin   = 0;
var state			= 0;
function LoadGatePassItems()
{	
	
	if(document.getElementById("cboMainStore").value=="")
	{
		alert("Please select \"Main stores\"");
		document.getElementById("cboMainStore").focus();
		return;
	}
	var MstoresId = $('#cboMainStore').val();
	showBackGround('divBG',0);
	var url = "bulkgatepasspop.php?MstoresId="+MstoresId;
	htmlobj=$.ajax({url:url,async:false});
	drawPopupBox(950,413,'frmPopItem',1);
	document.getElementById('frmPopItem').innerHTML = htmlobj.responseText;
}
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
function LoadDetalisToMainPage()
{
	var tbl = document.getElementById('tblGatePassItems');
	for ( var loop = 1 ;loop < tbl.rows.length ; loop ++ )
	{
		var chkBx = tbl.rows[loop].cells[0].childNodes[0].childNodes[0];
		if (chkBx.checked)
		{
			var mainMaterial =  tbl.rows[loop].cells[1].childNodes[0].nodeValue;
			var itemDes		 =  tbl.rows[loop].cells[2].childNodes[0].nodeValue;
			var matDetailId  =  tbl.rows[loop].cells[2].id;
			var color		 =  tbl.rows[loop].cells[3].childNodes[0].nodeValue;
			var size		 =  tbl.rows[loop].cells[4].childNodes[0].nodeValue;
			var itemunit	 =  tbl.rows[loop].cells[5].childNodes[0].nodeValue;
			var stockBal	 =  tbl.rows[loop].cells[6].childNodes[0].nodeValue;
			var grnNo    	 =  tbl.rows[loop].cells[8].childNodes[0].nodeValue;
			var grnYear    	 =  tbl.rows[loop].cells[9].childNodes[0].nodeValue;
			
			var  tblMain = document.getElementById('tblGatePassMain');
			var booCheck =false;
				for (var mainLoop =1 ;mainLoop < tblMain.rows.length; mainLoop++ )
				{
					var GRNNo	 = tblMain.rows[mainLoop].cells[10].childNodes[0].nodeValue;;
					var GRNYear  = tblMain.rows[mainLoop].cells[11].childNodes[0].nodeValue;;
					var matDetId = tblMain.rows[mainLoop].cells[2].id;
					var stcolor	 = tblMain.rows[mainLoop].cells[3].childNodes[0].nodeValue;
					var stsize	 = tblMain.rows[mainLoop].cells[4].childNodes[0].nodeValue;
					var strunit	 = tblMain.rows[mainLoop].cells[5].childNodes[0].nodeValue;
					
  				 if ((GRNNo==grnNo) && (GRNYear==grnYear) && (matDetId==matDetailId) &&(stcolor==color) && (stsize==size) && (strunit==itemunit))
					{
						alert("Sorry !\nItem no "+ loop + "\nAlready added.");
						booCheck =true;
						
					}	
				}
				if (booCheck == false)
				{
					createGride(tblMain,mainMaterial,matDetailId,itemDes,color,size,itemunit,stockBal,grnNo,grnYear,mainArrayIndex,'',"bcgcolor-tblrowWhite",'','','');
					mainArrayIndex++ ;
				}
		}
	}
	CloseOSPopUp('popupLayer1');
}
function createGride(tblMain,mainMaterial,matDetailId,itemDes,color,size,itemunit,stockBal,grnNo,grnYear,mainArrayIndex,XMLintRTN,tblcolor,No,gatePassStatus,XMLGpQty)
{
	
					var lastRow 	= tblMain.rows.length;	
					var row 		= tblMain.insertRow(lastRow);
					row.className   = tblcolor;
					var cellDelete  = row.insertCell(0); 
					cellDelete.id   = No;
					if(gatePassStatus==1)
					{
					cellDelete.innerHTML = "<div align=\"center\"><img src=\"../images/del.png\" id=\"" + mainArrayIndex + "\" alt=\"del\" width=\"15\" height=\"15\" /></div>";
					}
					else
					{
					cellDelete.innerHTML = "<div align=\"center\"><img src=\"../images/del.png\" id=\"" + mainArrayIndex + "\" alt=\"del\" width=\"15\" height=\"15\" onclick=\"RemoveItem(this);\" /></div>";
					}
					
					var cellIssuelist 		= row.insertCell(1);
					cellIssuelist.className = "normalfnt";
					//cellIssuelist.id 		= grnYear;
					cellIssuelist.innerHTML = mainMaterial;
					
					var cellIssuelist 		= row.insertCell(2);
					cellIssuelist.className = "normalfnt";
					cellIssuelist.id 		= matDetailId;
					cellIssuelist.innerHTML = itemDes;
					
					var cellIssuelist 		= row.insertCell(3);
					cellIssuelist.className = "normalfnt";
					cellIssuelist.innerHTML = color;
					
					var cellIssuelist 		= row.insertCell(4);
					cellIssuelist.className = "normalfnt";
					cellIssuelist.innerHTML = size;
					
					var cellIssuelist 		= row.insertCell(5);
					cellIssuelist.className = "normalfnt";
					cellIssuelist.innerHTML = itemunit;
					
					var cellIssuelist 		= row.insertCell(6);
					cellIssuelist.className = "normalfnt";
					cellIssuelist.innerHTML = stockBal;
					
					var cellIssuelist 		= row.insertCell(7);
					if(gatePassStatus==1)
					{
				    cellIssuelist.innerHTML = "<input type=\"text\" size=\"8\" class=\"txtbox\" name=\"txtIssueQty\" id=\"txtIssueQty\" value =\""+XMLGpQty+"\" style=\"text-align:right\" readonly=\"readonly\"/>";
					}
					else
					{
					cellIssuelist.innerHTML = "<input type=\"text\" size=\"8\" class=\"txtbox\" name=\"txtIssueQty\" id=\"txtIssueQty\" value =\""+stockBal+"\" style=\"text-align:right\" onkeypress=\"return CheckforValidDecimal(this.value, 4,event);\" onfocus=\"GetQty(this);\" onkeydown=\"removeBinColor(this);\" onkeyup=\"ValidateQty(this," + mainArrayIndex  + ");SetItemQuantity(this," + mainArrayIndex  + ");\"/>";
					}
				
				
					var cellIssuelist 		= row.insertCell(8);
					cellIssuelist.className = "normalfntMid";
					if(gatePassStatus==1)
					{
						if(XMLintRTN==1)
						{
						cellIssuelist.innerHTML = "<input type=\"checkbox\"  id=\"chkRtn\" name=\"chkRtn\" size=\"1\" checked=\"checked\" disabled=\"disabled\"  />";	
						}
						else
						{
						cellIssuelist.innerHTML = "<input type=\"checkbox\"  id=\"chkRtn\" name=\"chkRtn\" size=\"1\" disabled=\"disabled\"  />";		
						}
					}
					else
					{
						if(XMLintRTN==1)
						{
					cellIssuelist.innerHTML = "<input type=\"checkbox\" checked=\"checked\"  id=\"chkRtn\" name=\"chkRtn\" size=\"1\" onclick=\"SetRtn(this," + mainArrayIndex  + ");\">";
						}
						else
						{
						cellIssuelist.innerHTML = "<input type=\"checkbox\"  id=\"chkRtn\" name=\"chkRtn\" size=\"1\" onclick=\"SetRtn(this," + mainArrayIndex  + ");\">";
						}
					}
					
					var cellIssuelist 		= row.insertCell(9);
					cellIssuelist.className = "normalfntMid";
					if(gatePassStatus==1)
					{
					cellIssuelist.innerHTML = "<img src=\"../images/plus_16.png\" alt=\"add\" />";
					}
					else
					{
						if(pub_commonBin==0)
						{
					cellIssuelist.innerHTML = "<img src=\"../images/plus_16.png\" alt=\"add\" onclick=\"LoadBinDetails(this," + mainArrayIndex  + ");SetItemQuantity(this," + mainArrayIndex  + ");\" onfocus=\"GetQty(this);\"/>";	
						}
						else
						cellIssuelist.innerHTML	= "&nbsp;";
					}
					
					var cellIssuelist 		= row.insertCell(10);
					cellIssuelist.className = "normalfnt";
					cellIssuelist.id	    = grnNo;
					cellIssuelist.innerHTML = grnNo;
					
					var cellIssuelist 		= row.insertCell(11);
					cellIssuelist.className = "normalfnt";
					cellIssuelist.id	    = grnYear;
					cellIssuelist.innerHTML = grnYear;
					
					var details = [];
					details[0]  = matDetailId; 		
					details[1]  = color; 			
					details[2]  = size ;			
					details[3]  = parseFloat(stockBal); 	
					details[4]  = itemunit; 			
					details[5] = grnNo; 			
					details[6] = grnYear; 
					if(XMLintRTN==1)
						details[7] =XMLintRTN ; 
					else
						details[7] =0;
						
					Materials[mainArrayIndex] = details;					
}
function GetQty(obj)
{
	var rw = obj.parentNode.parentNode;
	var stockBal =rw.cells[6].childNodes[0].nodeValue;	
	var GatePassQty = rw.cells[7].childNodes[0].value;
			
	if ((GatePassQty=="") ||(GatePassQty==0))
	{
		rw.cells[7].childNodes[0].value =stockBal;
	}
}
function ValidateQty(obj,index)
{
	var rw = obj.parentNode.parentNode;
	var Qty = rw.cells[7].childNodes[0].value;
	var StockQty =rw.cells[6].childNodes[0].nodeValue;	
	rw.cells[8].childNodes[0].checked="true";
	Materials[index][7] = (rw.cells[8].childNodes[0].checked==true ? "1":"0");
	if(parseInt(Qty)>parseInt(StockQty))
	{		
		rw.cells[7].childNodes[0].value=StockQty;
	}	
	
}
function SetRtn(obj,index)
{
		var rw = obj.parentNode.parentNode;
		var StockQty =rw.cells[6].childNodes[0].nodeValue;	
		Materials[index][7] = (rw.cells[8].childNodes[0].checked==true ? "1":"0");
		
		if(rw.cells[8].childNodes[0].checked==true){
			rw.cells[7].childNodes[0].value=StockQty;
		}
}
function SetItemQuantity(obj,index)
{
		var rw = obj.parentNode.parentNode;
		Materials[index][3] = parseInt(rw.cells[7].childNodes[0].value);		
}
function LoadBinDetails(rowNo,index)
{
	var mainStore = document.getElementById("cboMainStore").value;
	if(mainStore == '')
	{
		alert('Please select \'Main Store \'');
		document.getElementById("cboMainStore").focus();
		return false;
	}
	if(pub_commonBin==1)
	{
		alert("Common Bin System Activated.\nNo need to add bins.\nAll the bin details will save to Common Bin automatically.");
		return;
		}
	var rw = rowNo.parentNode.parentNode;
	mainRw = rowNo.parentNode.parentNode.rowIndex;
	
	var ReqGatePassQty = parseFloat(rw.cells[7].childNodes[0].value);
	var stockQty	   = parseFloat(rw.cells[6].childNodes[0].nodeValue);
	
	if (ReqGatePassQty=="" || ReqGatePassQty==0 || ReqGatePassQty==isNaN)
	{
		alert ("GatePass Qty can't be '0' or empty.");
		rw.cells[7].childNodes[0].value=stockQty
		 return false;
	}	
	else if (ReqGatePassQty > stockQty)
	{
		alert ("Can't issue more than stock balance.");
		rw.cells[7].childNodes[0].value =stockQty;
		return false;
	}

	var mainStId    = $('#cboMainStore').val();
	var matDetailId = rw.cells[2].id;
	var color 		= rw.cells[3].childNodes[0].nodeValue;
	var size 		= rw.cells[4].childNodes[0].nodeValue;
	var itemUnit 	= rw.cells[5].childNodes[0].nodeValue;
	var grnNo 		= rw.cells[10].id;
	var grnYear 	= rw.cells[11].id;
	var binArray	= Materials[index][8];

	showBackGround('divBG',0);
	var url = "binitempop.php?matDetailId="+matDetailId +'&color='+color +'&size='+size +'&itemUnit='+itemUnit +'&grnNo='+grnNo +'&grnYear='+grnYear +'&ReqGatePassQty='+ReqGatePassQty+'&mainStId='+mainStId +'&index='+index +'&binArray='+binArray ;
	
	htmlobj=$.ajax({url:url,async:false});
	drawPopupBox(600,413,'frmPopItem',1);
	document.getElementById('frmPopItem').innerHTML = htmlobj.responseText;
}
function RemoveItem(obj)
{
	if(confirm('Are you sure you want to remove this item?'))
	{
		obj.parentNode.parentNode.parentNode;

		var td = obj.parentNode;
		var tro = td.parentNode;
		var tt=tro.parentNode;		
		tt.parentNode.removeChild(tt);	
		Materials[obj.id] = null;		
	}
}
function LoadStores(obj)
{
    var url='bulkgatepassXML.php?RequestType=LoadStores&category='+ obj;
	htmlobj=$.ajax({url:url,async:false});
	var XMLItem = htmlobj.responseText;
	document.getElementById('cboDestination').innerHTML = XMLItem; 
}
function SelectAll(obj)
{

	var tbl = document.getElementById('tblGatePassItems');
		
	for(loop = 1;loop<tbl.rows.length;loop++)
	{
		if(obj.checked){
			tbl.rows[loop].cells[0].childNodes[0].childNodes[0].checked = true;
		}
		else
			tbl.rows[loop].cells[0].childNodes[0].childNodes[0].checked= false;
			
	}
	
} 
//Start - bin qty validate part
function GetStockQty(objbin)
{
	
	var tbl = document.getElementById('tblGatePassBinItem');
	var rw = objbin.parentNode.parentNode.parentNode;
	if (objbin.checked)
	{	
	    totReqQty = parseFloat(document.getElementById('txReqGatePassQty').value);	
		var reqQty = parseFloat(rw.cells[4].lastChild.nodeValue);
		var issueQty = rw.cells[5].childNodes[0].value;
		
		rw.cells[5].childNodes[0].value = 0;
		var GPLoopQty = 0 ;
		
			for ( var loop = 1 ;loop < tbl.rows.length ; loop ++ )
			{
				if (tbl.rows[loop].cells[6].childNodes[0].childNodes[0].checked)
					{		
						GPLoopQty +=  parseFloat(tbl.rows[loop].cells[5].childNodes[0].value);
					}
			}	
		
				var reduceQty = parseFloat(totReqQty) - parseFloat(GPLoopQty) ;

					if (reqQty <= reduceQty )
					{
						rw.cells[5].childNodes[0].value = reqQty ;
					}
					else 
					{
						 rw.cells[5].childNodes[0].value = reduceQty;
					}					
	}	
	else 
		rw.cells[5].childNodes[0].value = 0;
}
//End - bin qty validate part
function removeBinColor(rowNo)
{	
	var tblMain =document.getElementById("tblGatePassMain");
	Rw = rowNo.parentNode.parentNode.rowIndex;
	tblMain.rows[Rw].className = "bcgcolor-tblrowWhite";
	tblMain.rows[Rw].cells[0].id =0;
}
function SetBinItemQuantity(obj,index)
{	
	var tblMain =document.getElementById("tblGatePassMain");				
	var tblBin = document.getElementById('tblGatePassBinItem');
	var totReqQty = parseFloat(document.getElementById('txReqGatePassQty').value);	
	var GPLoopQty = 0;	
	
		for (loop =1; loop < tblBin.rows.length; loop++)
		{
			var chkBx = tblBin.rows[loop].cells[6].childNodes[0].childNodes[0];	
			if (chkBx.checked)
			{		
					GPLoopQty +=  parseFloat(tblBin.rows[loop].cells[5].childNodes[0].value);
			}	
		}
	
	if (GPLoopQty == totReqQty )
	{	
		var BinMaterials = [];
		var mainBinArrayIndex = 0;
			for ( var loop = 1 ;loop < tblBin.rows.length ; loop ++ )
			{
				var check =tblBin.rows[loop].cells[6].childNodes[0].childNodes[0];				
				if (check.checked)
				{					
						    Bindetails = [];
							Bindetails[0] =   tblBin.rows[loop].cells[0].id; // MainStores
							Bindetails[1] =   tblBin.rows[loop].cells[1].id; // SubStores
							Bindetails[2] =   tblBin.rows[loop].cells[2].id; // Location
							Bindetails[3] =   tblBin.rows[loop].cells[3].id; // Bin ID
							Bindetails[4] =   tblBin.rows[loop].cells[5].childNodes[0].value; // IssueQty								
							//Bindetails[5] =   tblBin.rows[loop].cells[4].id; //  MatSubCategoryId
							BinMaterials[mainBinArrayIndex] = Bindetails;
							mainBinArrayIndex ++ ;
							
						
				}
			}
			
		Materials[index][8] = BinMaterials;				
		tblMain.rows[mainRw].className = "osc2";
		tblMain.rows[mainRw].cells[0].id =1;
		CloseOSPopUp('popupLayer1');
				
	}
	else 
	{
		alert ("Allocated qty must equal with Issue Qty. \nIssue Qty =" + totReqQty + "\nAllocated Qty =" + GPLoopQty +"\nVariance is =" +(totReqQty-GPLoopQty));
		return false;
	}
}
//****************************** Save data *****************************************
function SaveValidation(obj)
{
	state = obj;
	if(document.getElementById('optInternal').checked)
		id = document.getElementById('optInternal').value;
	else if(document.getElementById('optExternal').checked)
	    id = document.getElementById('optExternal').value;
	
	var tblMain	    = document.getElementById("tblGatePassMain");	 
	var Destination = document.getElementById("cboDestination").value;
	
	if(Destination==""){
		alert ("Please select the 'Destination'.");
		document.getElementById("cboDestination").focus();
		return;
	}
	if (tblMain.rows.length<2)
	{
		alert ("No details to save.");
		return false;
	}
	for (loop = 1 ;loop < tblMain.rows.length; loop++)
	{
		var issueQty = parseFloat(tblMain.rows[loop].cells[7].childNodes[0].value);
		var stockQty = parseFloat(tblMain.rows[loop].cells[6].childNodes[0].nodeValue);
		var checkBinAllocate = tblMain.rows[loop].cells[0].id
		
			if(stockQty<issueQty)
			{
				alert("Issue qty can't exceed stock qty.")
				return false;
			}
			if ((issueQty=="")  || (issueQty==0))
			{
				alert ("Issue qty can't be '0' or empty.")
				return false;				
			}
			if(pub_commonBin == 0)
			{
				if (checkBinAllocate==0)
				{
					alert ("Cannot save without allocating bin \nPlease allocate the bin in line no : " + [loop] +"." )
					return false;				
				}	
			}
	
	}
	LoadGatePassNo();
}
function LoadGatePassNo()
{
	var GPNO = document.getElementById("cboGatePassNo").value
	if (GPNO=="")
	{
		var url = 'bulkgatepassXML.php?RequestType=LoadGatePassNo';
		var htmlobj=$.ajax({url:url,async:false});
		var XMLGatePassNo   = htmlobj.responseXML.getElementsByTagName("GatePassNo")[0].childNodes[0].nodeValue;
		var XMLGatePassYear = htmlobj.responseXML.getElementsByTagName("GatePassYear")[0].childNodes[0].nodeValue;
		gatePassNo 			= parseInt(XMLGatePassNo);
		gatePassYear 		= parseInt(XMLGatePassYear);
		document.getElementById("cboGatePassNo").value = gatePassYear + "/" + gatePassNo;
		SaveGatePassDetails();
	}
	else
	{		
		GPNO = GPNO.split("/");		
		gatePassNo   = parseInt(GPNO[1]);
		gatePassYear = parseInt(GPNO[0]);
		SaveGatePassDetails();
	}
}
function SaveGatePassDetails()
{
	validateCount 		= 0;
	validateBinCount	= 0;
	var Attention    = $('#txtAttention').val();
	var Destination  = $('#cboDestination').val();
	var Remarks  	 = $('#txtRemarks').val();
	var MainStore  	 = $('#cboMainStore').val();
	var noOfPackages = (document.getElementById('txtNoOfPackages').value == "" ? 0:document.getElementById('txtNoOfPackages').value);
	var url = 'bulkgatepassXML.php?RequestType=SaveHeaderDetails&gatePassNo=' +gatePassNo+ '&gatePassYear=' +gatePassYear+ '&Attention=' +URLEncode(Attention)+ '&Destination=' +Destination + '&Remarks=' +URLEncode(Remarks) + '&MainStore=' +MainStore+ '&category=' +id+ '&noOfPackages=' +noOfPackages;
	var htmlobj1=$.ajax({url:url,async:false});
	
	for (loop = 0 ; loop < Materials.length ; loop ++)
	{
		var details = Materials[loop] ;
		if(details!=null)
		{
			  var matDetailId  = details[0] ; 		
			  var color 	   = details[1] ; 			
			  var size 	       = details[2] ;			
			  var Qty		   = details[3] ;
			  var itemunit     = details[4] ; 			
			  var grnNo	   	   = details[5] ; 			
			  var grnYear	   = details[6] ; 
			  var RTN		   = details[7] ; 
			  var binArray	   = details[8] ; 
			   
			   var url = 'bulkgatepassXML.php?RequestType=SaveDetails&gatePassNo=' +gatePassNo+ '&gatePassYear=' +gatePassYear+ '&matDetailId=' +matDetailId+ '&color=' +URLEncode(color)+ '&size=' +URLEncode(size)+ '&Qty=' +Qty+ '&itemunit=' +itemunit+ '&grnNo=' +grnNo+ '&grnYear=' +grnYear+ '&RTN=' +RTN;
			   var htmlobj2=$.ajax({url:url,async:false});
			  
			  if(pub_commonBin == 0)
			  {
				  for (i = 0; i < binArray.length; i++)
					{
						var Bindetails 			= binArray[i];
						var mainStores 			= Bindetails[0]; // MainStores
						var subStores 			= Bindetails[1]; // SubStores
						var location 			= Bindetails[2];// Location
						var binId				= Bindetails[3]; // Bin ID
						var issueBinQty 		= Bindetails[4]; // IssueQty
						validateBinCount++;
						
						var url = 'bulkgatepassXML.php?RequestType=SaveBinDetails&mainStores=' +mainStores+ '&subStores=' +subStores+ '&location=' +location+ '&binId=' +binId+ '&gatePassNo=' +gatePassNo+ '&gatePassYear=' +gatePassYear+ '&matDetailId=' +matDetailId+ '&color=' +URLEncode(color)+ '&size=' +URLEncode(size)+ '&itemunit=' +itemunit+ '&issueBinQty=' +issueBinQty+ '&validateBinCount=' +validateBinCount+'&grnNo='+grnNo+'&grnYear='+grnYear+'&pub_commonBin='+pub_commonBin+'&MainStore='+MainStore;
						
						var htmlobj3=$.ajax({url:url,async:false});
					}
			  }
			  else
			  {
				  validateBinCount++;
				  var url = 'bulkgatepassXML.php?RequestType=SaveBinDetails&gatePassNo=' +gatePassNo+ '&gatePassYear=' +gatePassYear+ '&matDetailId=' +matDetailId+ '&color=' +URLEncode(color)+ '&size=' +URLEncode(size)+ '&itemunit=' +itemunit+ '&issueBinQty=' +Qty+ '&validateBinCount=' +validateBinCount+'&grnNo='+grnNo+'&grnYear='+grnYear+'&pub_commonBin='+pub_commonBin+'&MainStore='+MainStore;
						
						var htmlobj3=$.ajax({url:url,async:false});
			  }
			 
		}
	}
	
	 if((htmlobj1.responseText=="Header_Saved")&&(htmlobj2.responseText=="Detail_Saved") && (htmlobj3.responseText=="Bin_Saved"))
	 {
		if(state==0)
		{
			alert ("Gate Pass No : " + document.getElementById("cboGatePassNo").value +  " saved successfully.");
			
		}
		
	 }
	
	
}
function getCommonBinDetails(no)
{
	var MainStores = document.getElementById('cboMainStore').value;
	var url = 'bulkgatepassXML.php?RequestType=getCommonBin&MainStores='+MainStores;
	var htmlobj=$.ajax({url:url,async:false});
	pub_commonBin = htmlobj.responseXML.getElementsByTagName("CommBinDetails")[0].childNodes[0].nodeValue;

}
function Confirm()
{
	
	state = 1;
	var mainStore = $('#cboMainStore').val();
	if(mainStore == "")
	{
		alert ("Please select the 'Main Store'.");
		document.getElementById("cboMainStore").focus();
		return false;
	}
	var GPNO = $('#cboGatePassNo').val();
	
	if(SaveValidation(1)==false)
		return;
		
	if(confirmGP() == false)
	{
		return;	
	}
	else
	{
		GatePassComfirm();	
		
	}
}
function confirmGP()
{
	var GPNo = $("#cboGatePassNo").val();
	var url = 'bulkgatepassXML.php?RequestType=confirmGatePass&GPNo='+GPNo +'&validateBinCount='+validateBinCount;
	var htmlobj=$.ajax({url:url,async:false});
	
	var binres = htmlobj.responseXML.getElementsByTagName("stockValidation")[0].childNodes[0].nodeValue;
	if(binres == '')
	{
		var binCount = htmlobj.responseXML.getElementsByTagName("recCountBinDetails")[0].childNodes[0].nodeValue;
		if(binCount == 'TRUE')
		{
			return true;	
		}
		else
		{
			alert('Error in saving bins');
			return false;
			
		}
			
	}
	else
	{
		alert(binres);
		return false;
	}
	
}
function GatePassComfirm()
{
	var GPNO = $('#cboGatePassNo').val();
	var url = 'bulkgatepassXML.php?RequestType=GatePassComfirm&GPNO='+GPNO;
	var htmlobj=$.ajax({url:url,async:false});
	
	if(htmlobj.responseText=="Confirmed")
	{
		alert ("Gate Pass No : " + document.getElementById("cboGatePassNo").value +  " confirmed successfully.");
		RestrictInterface(1);
		var gatePassNo = document.getElementById("cboGatePassNo").value.trim();
				if(gatePassNo != '')
				{
					var GPNo = gatePassNo.split("/")[1];
					var GPyear = gatePassNo.split("/")[0];	
				}
				RemoveAllRows('tblGatePassMain');
				loadGatePassDetails(GPNo,GPyear,1);
		
	}
}
function RestrictInterface(Status)
{
	if (Status==1)
	{
		document.getElementById("cmdSave").style.display="none";
		document.getElementById("cmdConfirm").style.display="none";
		document.getElementById("cmdAutoBin").style.display="none";
		document.getElementById("cmdAddNew").style.display="none";
	}
	else if (Status==10)
	{
		document.getElementById("cmdSave").style.display="none";
		document.getElementById("cmdConfirm").style.display="none";
		document.getElementById("cmdAddNew").style.display="none";
	}
	else if (Status==0)
	{		
		document.getElementById("cmdAddNew").style.display="inline";
	}
}

function ViewReport()
{
	var GPNO =document.getElementById("cboGatePassNo").value;
	if(GPNO==""){alert("Sorry!\nNo GatePass No to view.");return}
	GPNO = GPNO.split("/");
	
	gatePassNo = parseInt(GPNO[1]);
	gatePassYear = parseInt(GPNO[0]);
		
	newwindow=window.open('rptgatepass.php?GatePassNo=' +gatePassNo+ '&GatePassYear=' +gatePassYear ,'rptgatepass');
	if (window.focus) {newwindow.focus()}
}
function loadGatePassDetails(intGPNO,intGPYear,intStatus)
{
	 Materials 	    = [];
	mainArrayIndex  = 0;
	var arrayIndex = 1;
	var tblMain	    = document.getElementById('tblGatePassMain');
	gatePassNo 		= intGPNO;
	gatePassYear 	= intGPYear;
	gatePassStatus  = intStatus;
	if (intGPNO=="")
		return false;
	var url = 'bulkgatepassXML.php?RequestType=LoadHeaderDetails&gatePassNo=' +gatePassNo+ '&gatePassYear=' +gatePassYear+ '&gatePassStatus=' +gatePassStatus;
	var htmlobj = $.ajax({url:url,async:false});
	
	var XMLGPNO   		 = htmlobj.responseXML.getElementsByTagName("GPNO")[0].childNodes[0].nodeValue;
	var XMLGPDate 		 = htmlobj.responseXML.getElementsByTagName("formatedGPDate")[0].childNodes[0].nodeValue;				
	var XMLDestinationID = htmlobj.responseXML.getElementsByTagName("DestinationID")[0].childNodes[0].nodeValue;			
	var XMLRemarks 		 = htmlobj.responseXML.getElementsByTagName("Remarks")[0].childNodes[0].nodeValue;
	var XMLAttention 	 = htmlobj.responseXML.getElementsByTagName("Attention")[0].childNodes[0].nodeValue;
	var XMLStatus 		 = htmlobj.responseXML.getElementsByTagName("Status")[0].childNodes[0].nodeValue;
	var XMLcategory 	 = htmlobj.responseXML.getElementsByTagName("category")[0].childNodes[0].nodeValue;
	var XMLnoOfPackage	 = htmlobj.responseXML.getElementsByTagName("intNoOfPackages")[0].childNodes[0].nodeValue;
	
	document.getElementById("cboGatePassNo").value =XMLGPNO;
	document.getElementById("gatePassDate").value=XMLGPDate;
	document.getElementById("txtRemarks").value =XMLRemarks;			
	document.getElementById("txtAttention").value =XMLAttention ;
	document.getElementById("txtNoOfPackages").value =XMLnoOfPackage ;
	if(XMLcategory=="I"){
		document.getElementById('optInternal').checked = true;
	}else if(XMLcategory=="E"){
		document.getElementById('optExternal').checked = true;
	}
	RestrictInterface(parseInt(XMLStatus));
	LoadStores(XMLcategory);			
	document.getElementById("cboDestination").value =XMLDestinationID ;
	
	var url = 'bulkgatepassXML.php?RequestType=LoadGatePassDetails&gatePassNo=' +gatePassNo+ '&gatePassYear=' +gatePassYear+ '&gatePassStatus=' +gatePassStatus;
	var htmlobj = $.ajax({url:url,async:false});
	
	var XMLstrDescription = htmlobj.responseXML.getElementsByTagName("MainCategory");
	for(var loop =0; loop < XMLstrDescription.length; loop ++)
	{
		
		var strDescription    = XMLstrDescription[loop].childNodes[0].nodeValue;
		var XMLItem	 		  = htmlobj.responseXML.getElementsByTagName("ItemDescription")[loop].childNodes[0].nodeValue;				
		var XMLMatDetailId	  = htmlobj.responseXML.getElementsByTagName("MatDetailId")[loop].childNodes[0].nodeValue;			
		var XMLColor   		  = htmlobj.responseXML.getElementsByTagName("Color")[loop].childNodes[0].nodeValue;
		var XMLSize 	      = htmlobj.responseXML.getElementsByTagName("Size")[loop].childNodes[0].nodeValue;
		var XMLGpQty 		  = htmlobj.responseXML.getElementsByTagName("GPQTY")[loop].childNodes[0].nodeValue;
		var XMLStockQty  	  = htmlobj.responseXML.getElementsByTagName("stockQty")[loop].childNodes[0].nodeValue;
		var XMLGrnNo	      = htmlobj.responseXML.getElementsByTagName("GRNno")[loop].childNodes[0].nodeValue;
		var XMLGrnYear	      = htmlobj.responseXML.getElementsByTagName("GRNYear")[loop].childNodes[0].nodeValue;
		var XMLintRTN	      = htmlobj.responseXML.getElementsByTagName("intRTN")[loop].childNodes[0].nodeValue;
		var XMLUnit	          = htmlobj.responseXML.getElementsByTagName("Unit")[loop].childNodes[0].nodeValue;
		
		createGride(tblMain,strDescription,XMLMatDetailId,XMLItem,XMLColor,XMLSize,XMLUnit,XMLStockQty,XMLGrnNo,XMLGrnYear,mainArrayIndex,XMLintRTN,"osc2",1,gatePassStatus,XMLGpQty);
		
		var details = Materials[mainArrayIndex] ;
		
		var url = 'bulkgatepassXML.php?RequestType=LoadPendingConfirmBinDetails&gatePassNo=' +gatePassNo+ '&gatePassYear=' +gatePassYear+ '&matDetailID=' +details[0]+ '&color=' +URLEncode(details[1])+ '&size=' +URLEncode(details[2])+'&gatePassStatus='+gatePassStatus+ '&GRNNo='+details[5]+ '&GRNYear='+details[6];
	
		var htmlobj_bin = $.ajax({url:url,async:false});
		mainArrayIndex ++ ;
		
			var XMLBinQty 		= htmlobj_bin.responseXML.getElementsByTagName("Qty");
			var XMLMainStoresID = htmlobj_bin.responseXML.getElementsByTagName("MainStoresID");
			var XMLSubStores 	= htmlobj_bin.responseXML.getElementsByTagName("SubStores");
			var XMLLocation 	= htmlobj_bin.responseXML.getElementsByTagName("Location");
			var XMLBin 			= htmlobj_bin.responseXML.getElementsByTagName("Bin");
			var XMLMatSubCatId 	= htmlobj_bin.responseXML.getElementsByTagName("MatSubCatId");
			
			var mainBinArrayIndex = 0;
			var BinMaterials = [];	
			for (var i =0;i<XMLMainStoresID.length;i++)
			{	
					
					var Bindetails = [];
					Bindetails[0]  =   XMLMainStoresID[i].childNodes[0].nodeValue; 
					Bindetails[1]  =   XMLSubStores[i].childNodes[0].nodeValue; 
					Bindetails[2]  =   XMLLocation[i].childNodes[0].nodeValue;
					Bindetails[3]  =   XMLBin[i].childNodes[0].nodeValue; 
					Bindetails[4]  =   XMLBinQty[i].childNodes[0].nodeValue; 
					Bindetails[5]  =   XMLMatSubCatId[i].childNodes[0].nodeValue; 
					BinMaterials[mainBinArrayIndex] = Bindetails;
					details[8] = BinMaterials;
					mainBinArrayIndex ++ ;
					
			}	
			document.getElementById('cboMainStore').value = XMLMainStoresID[0].childNodes[0].nodeValue;
	}
		
}
function LoadBulkGateDetails()
{
	document.frmBulkGPListing.submit();
}