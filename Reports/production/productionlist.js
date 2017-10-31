function showdiv(type,permission)
{
	if(type==1)
	{
		
		switch(permission)
		{
			case "1":
			{
				$("#div2").fadeOut("fast");
				$("#div3").fadeOut("fast");
				$("#div4").fadeOut("fast");
				$("#div5").fadeOut("fast");
				$("#div6").fadeOut("fast");
				$("#div7").fadeOut("fast");
				$("#div9").fadeOut("fast");
				$("#div8").fadeOut("fast");
				$("#div1").fadeIn(1500);
				document.getElementById("cutQty").bgColor="#C4E9F2";
				document.getElementById("washPlan").bgColor="";
				document.getElementById("WIP").bgColor="";
				document.getElementById("GatePass").bgColor="";
				document.getElementById("ProductionSum").bgColor="";
				document.getElementById("ProductionDet").bgColor="";
				document.getElementById("ProductionBM").bgColor="";
				break;	
			}
			case "":
			{
				$("#div2").fadeOut("fast");
				$("#div3").fadeOut("fast");
				$("#div4").fadeOut("fast");
				$("#div5").fadeOut("fast");
				$("#div6").fadeOut("fast");
				$("#div7").fadeOut("fast");
				$("#div1").fadeOut("fast");
				$("#div9").fadeOut("fast");
				$("#div8").fadeIn(1500);
				document.getElementById("cutQty").bgColor="#C4E9F2";
				document.getElementById("washPlan").bgColor="";
				document.getElementById("WIP").bgColor="";
				document.getElementById("GatePass").bgColor="";
				document.getElementById("ProductionSum").bgColor="";
				document.getElementById("ProductionDet").bgColor="";
				document.getElementById("ProductionBM").bgColor="";
				break;	
			}
		}
		

	}
	if(type==2)
	{
		switch(permission)
		{
			case "1":
			{
				$("#div1").fadeOut("fast");
				$("#div3").fadeOut("fast");
				$("#div4").fadeOut("fast");
				$("#div5").fadeOut("fast");
				$("#div6").fadeOut("fast");
				$("#div7").fadeOut("fast");
				$("#div9").fadeOut("fast");
				$("#div8").fadeOut("fast");
				$("#div2").fadeIn(1500);
				document.getElementById("washPlan").bgColor="#C4E9F2";
				document.getElementById("cutQty").bgColor="";
				document.getElementById("WIP").bgColor="";
				document.getElementById("GatePass").bgColor="";
				document.getElementById("ProductionSum").bgColor="";
				document.getElementById("ProductionDet").bgColor="";
				document.getElementById("ProductionBM").bgColor="";
				break;	
			}
			case "":
			{
				$("#div1").fadeOut("fast");
				$("#div3").fadeOut("fast");
				$("#div4").fadeOut("fast");
				$("#div5").fadeOut("fast");
				$("#div6").fadeOut("fast");
				$("#div7").fadeOut("fast");
				$("#div2").fadeOut("fast");
				$("#div9").fadeOut("fast");
				$("#div8").fadeIn(1500);
				document.getElementById("washPlan").bgColor="#C4E9F2";
				document.getElementById("cutQty").bgColor="";
				document.getElementById("WIP").bgColor="";
				document.getElementById("GatePass").bgColor="";
				document.getElementById("ProductionSum").bgColor="";
				document.getElementById("ProductionDet").bgColor="";
				document.getElementById("ProductionBM").bgColor="";
				break;	
			}
		}
	}
		
	if(type==3)
	{
		switch(permission)
		{
			case "1":
			{
				$("#div1").fadeOut("fast");
				$("#div8").fadeOut("fast");
				$("#div2").fadeOut("fast");
				$("#div4").fadeOut("fast");
				$("#div5").fadeOut("fast");
				$("#div6").fadeOut("fast");
				$("#div7").fadeOut("fast");
				$("#div9").fadeOut("fast");
				$("#div3").fadeIn(1500);
				document.getElementById("WIP").bgColor="#C4E9F2";
				document.getElementById("cutQty").bgColor="";
				document.getElementById("washPlan").bgColor="";
				document.getElementById("GatePass").bgColor="";
				document.getElementById("ProductionSum").bgColor="";
				document.getElementById("ProductionDet").bgColor="";
				document.getElementById("ProductionBM").bgColor="";
				break;	
			}
			case "":
			{
				$("#div1").fadeOut("fast");
				$("#div2").fadeOut("fast");
				$("#div4").fadeOut("fast");
				$("#div5").fadeOut("fast");
				$("#div6").fadeOut("fast");
				$("#div7").fadeOut("fast");
				$("#div3").fadeOut("fast");
				$("#div9").fadeOut("fast");
				$("#div8").fadeIn(1500);
				document.getElementById("WIP").bgColor="#C4E9F2";
				document.getElementById("cutQty").bgColor="";
				document.getElementById("washPlan").bgColor="";
				document.getElementById("GatePass").bgColor="";
				document.getElementById("ProductionSum").bgColor="";
				document.getElementById("ProductionDet").bgColor="";
				document.getElementById("ProductionBM").bgColor="";
				break;	
			}
		}
	}
	if(type==4)
	{
		switch(permission)
		{
			case "1":
			{
				$("#div2").fadeOut("fast");
				$("#div3").fadeOut("fast");
				$("#div1").fadeOut("fast");
				$("#div5").fadeOut("fast");
				$("#div6").fadeOut("fast");
				$("#div7").fadeOut("fast");
				$("#div9").fadeOut("fast");
				$("#div8").fadeOut("fast");
				$("#div4").fadeIn(1500);
				document.getElementById("GatePass").bgColor="#C4E9F2";
				document.getElementById("washPlan").bgColor="";
				document.getElementById("WIP").bgColor="";
				document.getElementById("cutQty").bgColor="";
				document.getElementById("ProductionSum").bgColor="";
				document.getElementById("ProductionDet").bgColor="";
				document.getElementById("ProductionBM").bgColor="";
				break;	
			}
			case "":
			{
				$("#div2").fadeOut("fast");
				$("#div3").fadeOut("fast");
				$("#div1").fadeOut("fast");
				$("#div5").fadeOut("fast");
				$("#div6").fadeOut("fast");
				$("#div7").fadeOut("fast");
				$("#div4").fadeOut("fast");
				$("#div9").fadeOut("fast");
				$("#div8").fadeIn(1500);
				document.getElementById("GatePass").bgColor="#C4E9F2";
				document.getElementById("washPlan").bgColor="";
				document.getElementById("WIP").bgColor="";
				document.getElementById("cutQty").bgColor="";
				document.getElementById("ProductionSum").bgColor="";
				document.getElementById("ProductionDet").bgColor="";
				document.getElementById("ProductionBM").bgColor="";
				break;	
			}
		}
	}
	if(type==5)
	{
		switch(permission)
		{
			case "1":
			{
				$("#div2").fadeOut("fast");
				$("#div3").fadeOut("fast");
				$("#div4").fadeOut("fast");
				$("#div1").fadeOut("fast");
				$("#div6").fadeOut("fast");
				$("#div7").fadeOut("fast");
				$("#div9").fadeOut("fast");
				$("#div8").fadeOut("fast");
				$("#div5").fadeIn(1500);
				document.getElementById("ProductionSum").bgColor="#C4E9F2";
				document.getElementById("washPlan").bgColor="";
				document.getElementById("WIP").bgColor="";
				document.getElementById("GatePass").bgColor="";
				document.getElementById("cutQty").bgColor="";
				document.getElementById("ProductionDet").bgColor="";
				document.getElementById("ProductionBM").bgColor="";
				break;	
			}
			case "":
			{
				$("#div2").fadeOut("fast");
				$("#div3").fadeOut("fast");
				$("#div4").fadeOut("fast");
				$("#div1").fadeOut("fast");
				$("#div6").fadeOut("fast");
				$("#div7").fadeOut("fast");
				$("#div5").fadeOut("fast");
				$("#div9").fadeOut("fast");
				$("#div8").fadeIn(1500);
				document.getElementById("ProductionSum").bgColor="#C4E9F2";
				document.getElementById("washPlan").bgColor="";
				document.getElementById("WIP").bgColor="";
				document.getElementById("GatePass").bgColor="";
				document.getElementById("cutQty").bgColor="";
				document.getElementById("ProductionDet").bgColor="";
				document.getElementById("ProductionBM").bgColor="";
				break;	
			}
		}
	}
	if(type==6)
	{
		switch(permission)
		{
			case "1":
			{
				$("#div7").fadeOut("fast");
				$("#div5").fadeOut("fast");
				$("#div2").fadeOut("fast");
				$("#div3").fadeOut("fast");
				$("#div4").fadeOut("fast");
				$("#div1").fadeOut("fast");
				$("#div9").fadeOut("fast");
				$("#div8").fadeOut("fast");
				$("#div6").fadeIn(1500);
				document.getElementById("ProductionDet").bgColor="#C4E9F2";
				document.getElementById("washPlan").bgColor="";
				document.getElementById("WIP").bgColor="";
				document.getElementById("GatePass").bgColor="";
				document.getElementById("cutQty").bgColor="";
				document.getElementById("ProductionSum").bgColor="";
				document.getElementById("ProductionBM").bgColor="";
				break;	
			}
			case "":
			{
				$("#div7").fadeOut("fast");
				$("#div5").fadeOut("fast");
				$("#div2").fadeOut("fast");
				$("#div3").fadeOut("fast");
				$("#div4").fadeOut("fast");
				$("#div1").fadeOut("fast");
				$("#div6").fadeOut("fast");
				$("#div9").fadeOut("fast");
				$("#div8").fadeIn(1500);
				document.getElementById("ProductionDet").bgColor="#C4E9F2";
				document.getElementById("washPlan").bgColor="";
				document.getElementById("WIP").bgColor="";
				document.getElementById("GatePass").bgColor="";
				document.getElementById("cutQty").bgColor="";
				document.getElementById("ProductionSum").bgColor="";
				document.getElementById("ProductionBM").bgColor="";
				break;	
			}
		}
	}
	if(type==7)
	{
		switch(permission)
		{
			case "1":
			{
				$("#div6").fadeOut("fast");
				$("#div5").fadeOut("fast");
				$("#div2").fadeOut("fast");
				$("#div3").fadeOut("fast");
				$("#div4").fadeOut("fast");
				$("#div1").fadeOut("fast");
				$("#div9").fadeOut("fast");
				$("#div8").fadeOut("fast");
				$("#div7").fadeIn(1500);
				document.getElementById("ProductionBM").bgColor="#C4E9F2";
				document.getElementById("washPlan").bgColor="";
				document.getElementById("WIP").bgColor="";
				document.getElementById("GatePass").bgColor="";
				document.getElementById("cutQty").bgColor="";
				document.getElementById("ProductionSum").bgColor="";
				document.getElementById("ProductionDet").bgColor="";
				break;	
			}
			case "":
			{
				$("#div6").fadeOut("fast");
				$("#div5").fadeOut("fast");
				$("#div2").fadeOut("fast");
				$("#div3").fadeOut("fast");
				$("#div4").fadeOut("fast");
				$("#div7").fadeOut("fast");
				$("#div9").fadeOut("fast");
				$("#div8").fadeIn(1500);
				document.getElementById("ProductionBM").bgColor="#C4E9F2";
				document.getElementById("washPlan").bgColor="";
				document.getElementById("WIP").bgColor="";
				document.getElementById("GatePass").bgColor="";
				document.getElementById("cutQty").bgColor="";
				document.getElementById("ProductionSum").bgColor="";
				document.getElementById("ProductionDet").bgColor="";
				break;	
			}
		}
	}
}
function viewReport(type)
{
	if(type==1)
	{
		var orderNo 	= document.getElementById('cboOrderNoCut').value;
		var division 	= document.getElementById('cboDivisionCut').value; 
		var styleNo 	= document.getElementById('cboStyleIDCut').value; 
		var Factory 	= document.getElementById('cboFactoryCut').value;

		var url  = "cutqtyrpt.php?";
		url += "&orderNo="+URLEncode(orderNo);
		url	+= "&division="+division;
		url	+= "&Factory="+Factory;
		url	+= "&styleNo="+URLEncode(styleNo);
		url += "&CheckDate="+(document.getElementById('checkDateC').checked ? 1:0);
		url += "&DateFrom="+document.getElementById('txtDfromCut').value;
		url += "&DateTo="+document.getElementById('txtDtoCut').value
		window.open(url,'cutqtyrpt.php');
	}
	if(type==2)
	{
		var orderNo 	= document.getElementById('cboOrderNoWash').value;
		var buyer 		= document.getElementById('cboBuyerWash').value; 
		var styleNo 	= document.getElementById('cboStyleIDWash').value; 
		
		var url  = "washingplan/rptwashingplan.php?";
		url += "&OrderNo="+URLEncode(orderNo);
		url	+= "&Buyer="+buyer;
		url	+= "&StyleNo="+URLEncode(styleNo);
		url += "&CheckDate="+(document.getElementById('checkDateW').checked ? 1:0);
		url += "&DateFrom="+document.getElementById('txtDfromW').value;
		url += "&DateTo="+document.getElementById('txtDtoW').value
		window.open(url,'rptwashingplan.php');
	}
	if(type==3)
	{
		var orderNo 	= document.getElementById('cboOrderNoWip').value;
		var buyer 		= document.getElementById('cboBuyerWip').value; 
		var styleNo 	= document.getElementById('cboStyleIDWip').value; 
		var sewFactory 	= document.getElementById('cboFactoryWip').value; 
		
		var url  = "rptCuttingWorkInProgress.php?";
		url += "&orderNo="+URLEncode(orderNo);
		url	+= "&buyer="+buyer;
		url	+= "&styleNo="+URLEncode(styleNo);
		url	+= "&sewFactory="+sewFactory;
		url += "&CheckDate="+(document.getElementById('checkDateWip').checked ? 1:0);
		url += "&DateFrom="+document.getElementById('txtDfromWip').value;
		url += "&DateTo="+document.getElementById('txtDtoWip').value
		window.open(url,'rptCuttingWorkInProgress.php');
	}
	if(type==4)
	{
		var orderNo 	= document.getElementById('cboOrderNoGP').value;
		var tofactory 	= document.getElementById('cboToFactory').value; 
		var styleNo 	= document.getElementById('cboStyleIDGP').value; 
		var fromfactory = document.getElementById('cboFromFactory').value;

		var url  = "rptGatePassRatio.php?";
		url += "&orderNo="+URLEncode(orderNo);
		url	+= "&tofactory="+tofactory;
		url	+= "&fromfactory="+fromfactory;
		url	+= "&styleNo="+URLEncode(styleNo);
		url += "&CheckDate="+(document.getElementById('checkDateGP').checked ? 1:0);
		url += "&DateFrom="+document.getElementById('txtDfromGP').value;
		url += "&DateTo="+document.getElementById('txtDtoGP').value
		window.open(url,'rptGatePassRatio.php');
	}
	if(type==5)
	{
		var styleId 	= document.getElementById('cboOrderNoPS').value;
		var lineNo 		= document.getElementById('cboLineNoPS').value; 
		var styleNo 	= document.getElementById('cboStyleIDPS').value; 

		var url  = "productionSummary/productSummaryRpt.php?";
		url += "&styleId="+URLEncode(styleId);
		url	+= "&lineNo="+lineNo;
		url	+= "&styleNo="+URLEncode(styleNo);
		url += "&dateFrom="+document.getElementById('txtDfromPS').value;
		url += "&dateTo="+document.getElementById('txtDtoPS').value
		window.open(url,'productSummaryRpt.php');
	}
	if(type==6)
	{
		var styleId 	= document.getElementById('cboOrderNoPD').value;
		var lineNo 		= document.getElementById('cboLineNoPD').value; 
		var styleNo 	= document.getElementById('cboStyleIDPD').value;
		var cutNo 		= document.getElementById('cboCutNoPD').value;
		 

		var url  = "productionSummary/productDetailRpt.php?";
		url += "&styleId="+URLEncode(styleId);
		url	+= "&lineNo="+lineNo;
		url	+= "&styleNo="+URLEncode(styleNo);
		url	+= "&cutNo="+URLEncode(cutNo);
		url += "&dateFrom="+document.getElementById('txtDfromPD').value;
		url += "&dateTo="+document.getElementById('txtDtoPD').value
		window.open(url,'productDetailRpt.php');
	}
	if(type==7)
	{
		var styleId 	= document.getElementById('cboOrderNoPBM').value;
		var lineNo 		= document.getElementById('cboLineNoPBM').value; 
		var styleNo 	= document.getElementById('cboStyleIDPBM').value;
		var cutNo 		= document.getElementById('cboCutNoPBM').value;
		var bundleNo 	= document.getElementById('cboBundleNoPBM').value;
		 

		var url  = "productionSummary/bundleMovementRpt.php?";
		url += "&styleId="+URLEncode(styleId);
		url	+= "&lineNo="+lineNo;
		url	+= "&styleNo="+URLEncode(styleNo);
		url	+= "&cutNo="+URLEncode(cutNo);
		url	+= "&bundleNo="+bundleNo;
		url += "&dateFrom="+document.getElementById('txtDfromPBM').value;
		url += "&dateTo="+document.getElementById('txtDtoPBM').value
		window.open(url,'bundleMovementRpt.php');
	}
}
function setDateChecked(objChk)
{
	if(!objChk.checked)
	{
		document.getElementById("txtDfromCut").disabled= true;
		document.getElementById("txtDtoCut").disabled= true;		
	}
	else
	{
		document.getElementById("txtDfromCut").disabled=false;
		document.getElementById("txtDtoCut").disabled= false;
	}	
}

/*function ShowExcelReport()
{
	var checkDate 	= document.getElementById("checkDate").checked;
	var txtDfrom  	= document.getElementById("txtDfrom").value;
	var txtDto    	= document.getElementById("txtDto").value;
	var buyer    	= document.getElementById("cboBuyer").value;
	var chkDelDate	= document.getElementById("chkDelDate").checked;
	var delDfrom  	= document.getElementById("txtDelDfrom").value;
	var delDto    	= document.getElementById("txtDelDto").value;
	
	if(document.getElementById("cboReportCategory").value=='0')
		var reportName = "xclrptOrderBook.php";
	else if(document.getElementById("cboReportCategory").value=='1')
		var reportName = "xclSalesReport.php";
		
	var url  = reportName+"?txtDfrom="+txtDfrom+"&txtDto="+txtDto+"&checkDate="+checkDate+"&Buyer="+buyer+"&chkDelDate="+chkDelDate+"&delDfrom="+delDfrom+"&delDto="+delDto;
	window.open(url);
	
}
*/

function SetOrderNo(obj,type)
{
	if(type=="Wash")
	$('#cboOrderNoWash').val(obj.value);
	
	if(type=="Wip")
	$('#cboOrderNoWip').val(obj.value);
	
	if(type=="GP")
	$('#cboOrderNoGP').val(obj.value);
	
}

function SetSCNo(obj,type)
{
	if(type=="Wash")
	$('#cboScNoWash').val(obj.value);
	
	if(type=="Wip")
	$('#cboScNoWip').val(obj.value);
}

function SetDate(obj)
{
	if(!obj.checked)
	{
		document.getElementById("txtDfromW").disabled= true;
		document.getElementById("txtDtoW").disabled= true;		
	}
	else
	{
		document.getElementById("txtDfromW").disabled=false;
		document.getElementById("txtDtoW").disabled= false;
	}	
}
function setDateCheckedGP(obj)
{
	if(!obj.checked)
	{
		document.getElementById("txtDfromGP").disabled= true;
		document.getElementById("txtDtoGP").disabled= true;		
	}
	else
	{
		document.getElementById("txtDfromGP").disabled=false;
		document.getElementById("txtDtoGP").disabled= false;
	}	
}
function SetDateWip(obj)
{
	if(!obj.checked)
	{
		document.getElementById("txtDfromWip").disabled= true;
		document.getElementById("txtDtoWip").disabled= true;		
	}
	else
	{
		document.getElementById("txtDfromWip").disabled=false;
		document.getElementById("txtDtoWip").disabled= false;
	}	
}
function SetDatePS(obj)
{
	if(!obj.checked)
	{
		document.getElementById("txtDfromPS").disabled= true;
		document.getElementById("txtDtoPS").disabled= true;		
	}
	else
	{
		document.getElementById("txtDfromPS").disabled=false;
		document.getElementById("txtDtoPS").disabled= false;
	}	
}
function SetDatePD(obj)
{
	if(!obj.checked)
	{
		document.getElementById("txtDfromPD").disabled= true;
		document.getElementById("txtDtoPD").disabled= true;		
	}
	else
	{
		document.getElementById("txtDfromPD").disabled=false;
		document.getElementById("txtDtoPD").disabled= false;
	}	
}
function SetDatePBM(obj)
{
	if(!obj.checked)
	{
		document.getElementById("txtDfromPBM").disabled= true;
		document.getElementById("txtDtoPBM").disabled= true;		
	}
	else
	{
		document.getElementById("txtDfromPBM").disabled=false;
		document.getElementById("txtDtoPBM").disabled= false;
	}	
}

function ClearForm()
{

	document.frmProductionList.reset();
}

function loadOrderNo(styleNo,type)
{
	url = "productionListXML.php?Request=loadOrderNo&styleNo="+styleNo;
	htmlobj=$.ajax({url:url,async:false});
	var XMLItem = htmlobj.responseText;
	if(type=='cut')
	document.getElementById('cboOrderNoCut').innerHTML = XMLItem;
	if(type=='wash')
	document.getElementById('cboOrderNoWash').innerHTML = XMLItem;
	if(type=='wip')
	document.getElementById('cboOrderNoWip').innerHTML = XMLItem;
	if(type=='GP')
	document.getElementById('cboOrderNoGP').innerHTML = XMLItem;
	if(type=='PS')
	document.getElementById('cboOrderNoPS').innerHTML = XMLItem;
	if(type=='PD')
	document.getElementById('cboOrderNoPD').innerHTML = XMLItem;
	if(type=='PBM')
	document.getElementById('cboOrderNoPBM').innerHTML = XMLItem;
}
function loadCutNoDetails(styleId,type)
{
	var url = "productionSummary/productionDetailxml.php?RequestType=loadOrderNowiseCutDetails&styleId="+styleId;
	htmlobj = $.ajax({url:url,async:false});
	if(type=='PD')
	document.getElementById('cboCutNoPD').innerHTML = htmlobj.responseText;
	if(type=='PBM')
	document.getElementById('cboCutNoPBM').innerHTML = htmlobj.responseText;
}
function loadBundleNo()
{
	var cutNo = document.getElementById('cboCutNoPBM').value;
	var url = "productionSummary/productionDetailxml.php?RequestType=loadCutwiseBundleDetails";
	url += "&cutNo="+cutNo;
	htmlobj = $.ajax({url:url,async:false});
	document.getElementById('cboBundleNoPBM').innerHTML = htmlobj.responseText;
}