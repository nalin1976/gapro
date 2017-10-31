$(function(){

	SetCalendarDate();
        
        var arrRemarks = [];
        var iRemarksPos  = 0;
        var tbRowObj    = '';

	// =============================================================
	// Load buyers to the buyers dropdown list
	// =============================================================
	var url 		= "salesmiddle.php?RequestType=LoadBuyers";
	var htmlObj 		= $.ajax({url:url, async:false});

	var XMLBuyers 		= htmlObj.responseXML.getElementsByTagName("BuyerID");	
	var XMLBuyerName 	= htmlObj.responseXML.getElementsByTagName("BuyerName");

	var optBuyers	= $("#cmbBuyers");
	optBuyers.append($('<option></option>').val(-1).text(""));

	for ( var loop = 0; loop < XMLBuyers.length; loop ++){

		var buyerID 	= XMLBuyers[loop].childNodes[0].nodeValue;
		var buyerName 	= XMLBuyerName[loop].childNodes[0].nodeValue

		optBuyers.append($('<option></option>').val(buyerID).text(buyerName));
	}
	// =============================================================
        
        
        // =============================================================
	// Load manufacturing locations to the manufacturing dropdown list
	// =============================================================
        var url 		= "salesmiddle.php?RequestType=LoadCompanies";
	var htmlObj 		= $.ajax({url:url, async:false});
        
	var XMLCompanyId 	= htmlObj.responseXML.getElementsByTagName("CompanyID");	
	var XMLCompanyName 	= htmlObj.responseXML.getElementsByTagName("CompanyName");

	var optBuyers	= $("#cmbManuLocation");
	optBuyers.append($('<option></option>').val(-1).text(""));

	for ( var loop = 0; loop < XMLCompanyId.length; loop ++){

            var companyID 	= XMLCompanyId[loop].childNodes[0].nodeValue;
            var companyName 	= XMLCompanyName[loop].childNodes[0].nodeValue

            optBuyers.append($('<option></option>').val(companyID).text(companyName));
	}
        
	
	// =============================================================
	// Add selected value to selection box
	// =============================================================
	$(".dropdown-menu li a").click(function(){
		var selText = $(this).text();

		$(this).parents(".dropdown").find(".dropdown-toggle").html(selText+" &nbsp;<span class='caret caret-right'></span>");
	});

	// =============================================================

	$("#btnSearch").click(function(e){

            LoadGrid();

	});


	$("#btnSave").click(function(e){

            var tbDeliveryListing = $("#tbListing > tbody");

            tbDeliveryListing.find('tr').each(function(key, val){

            var this_td = $(this).find('td');

            var styleId = $(this_td).eq(0).attr('id');
            var bpoNo   = $(this_td).eq(4).attr('id');
            //var bpoNo   = $(this_td).eq(4).html();     
            //alert(bpoNo); 
            // Check if check box element exist in the column 9 for factory planner confirmation	
            // ===========================================================================		
            var chkAccMgr = $(this_td).eq(9).find(':checkbox');
            if(chkAccMgr.length > 0){
                
                if($(chkAccMgr).is(":checked")){
                    
                    // If factory planner confirm update the status.
                    var url         = "salesmiddle.php?RequestType=PlanConfirm&styleId="+styleId+"&bpono="+bpoNo;
                    var htmlObj1    = $.ajax({url:url, async:false});

                }
            }
            // ===========================================================================

            // Check if check box element exist in the column 10 for account manager confirmation	
            // ===========================================================================		
            var chkAccMgr = $(this_td).eq(10).find(':checkbox');
            if(chkAccMgr.length > 0){

                    if($(chkAccMgr).is(":checked")){

                            // If account manager confirm update the status.
                            var url 		= "salesmiddle.php?RequestType=AccConfirm&styleId="+styleId+"&bpono="+bpoNo;
                            var htmlObj1 	= $.ajax({url:url, async:false});

                    }
            }
            // ===========================================================================


            // Check if check box element exist in the column 11 for shipping manager confirmation	
            // ===========================================================================		
            var chkShipStatus = $(this_td).eq(11).find(':checkbox');

            if(chkShipStatus.length > 0){

                if($(chkShipStatus).is(":checked")){

                    // If account manager confirm update the status.
                    var url         = "salesmiddle.php?RequestType=ShipStatusConfirm&styleId="+styleId+"&bpono="+bpoNo;
                    var htmlObj1    = $.ajax({url:url, async:false});

                }
            }

            //=============================================================================
            });
            
            // Add Remarks entered by factory planner 
            //=========================================
            
            for(i=0; i<arrRemarks.length; i++){
                
                var styleId     = arrRemarks[i][0];
                var bpoNo       = arrRemarks[i][1];
                var strRemarks  = arrRemarks[i][2];
                
                var url         = "salesmiddle.php?RequestType=AddRemarks&styleId="+styleId+"&bpono="+bpoNo+"&remark="+strRemarks;
                var htmlObj1    = $.ajax({url:url, async:false});
                
            }

            LoadGrid();
 
	});


	$("#btnReport").click(function(){

            var buyerCode = $("#cmbBuyers").val();
            var dtFrom    = $("#txtFrmDate").val();
            var dtTo 	  = $("#txtToDate").val();

            var url  = "salesrep.php"+"?Buyer="+buyerCode+"&delDfrom="+dtFrom+"&delDto="+dtTo;
            window.open(url);
	

	});
        
        $('#tbListing tbody').on('dblclick', 'tr', function(){
            
            var url = "salesmiddle.php?RequestType=IsRemarkPermission";
            var htmlObj1 = $.ajax({url:url, async:false})
            
            var XMLPermission = htmlObj1.responseXML.getElementsByTagName("PermissionAllowed");
            
            var IsAllow = XMLPermission[0].childNodes[0].nodeValue;
            
            if(IsAllow == '1'){
                $('#remark').modal('show');
                tbRowObj  = this;
            }
                       
            
            
                       
            
        });
        
        $("#btnAddRemark").click(function(){
            
            var this_td = $(tbRowObj).find('td');

            var styleId = $(this_td).eq(0).attr('id');
            var bpoNo   = $(this_td).eq(4).attr('id');
            
            arrRemarks[iRemarksPos] = [3];
            
            arrRemarks[iRemarksPos][0] = styleId;
            arrRemarks[iRemarksPos][1] = bpoNo;
            arrRemarks[iRemarksPos][2] = $("#txtRemark").val();
            
            iRemarksPos++;
            
            $("#txtRemark").val('');
            $('#remark .close').click();
            
        });
});

function GetDateFormat(prmDate){

	var arrDate = prmDate.split("/");

	var reFormatDate = arrDate[2]+"-"+arrDate[1]+"-"+arrDate[0];

	return reFormatDate;

}

function IsSalesExist(styleId, buyerPOId){


	var url = "salesmiddle.php?RequestType=SalesExist&styleid="+styleId+"&bpono="+buyerPOId;
	var htmlObj = $.ajax({url:url, async:false});

	

	return htmlObj;	

}

function LoadGrid(){
    
    $("#tbListing > tbody").html("");

    var buyerId     = $("#cmbBuyers").val();
    var fromDate    = GetDateFormat($("#txtFrmDate").val());
    var toDate      = GetDateFormat($("#txtToDate").val());
    var companyId   = $("#cmbManuLocation").val();

    //if(buyerId == '-1'){alert("Select buyer from the listing"); return;}

    // Get Total frozen value of the given date range
    // =====================================================
    var urlF        = "salesmiddle.php?RequestType=GetFrozenValue&FromDate="+fromDate+"&ToDate="+toDate;
    var htmlObjF    = $.ajax({url:urlF, async:false});
    $("#lblFrozenValue").text(htmlObjF.responseText);
    // =====================================================
                
                
    // Get total frozen value of the given date range and selected buyer
    // =====================================================
    $("#lblBuyer").text($("#cmbBuyers option:selected").text());
    var urlB        = "salesmiddle.php?RequestType=GetFrozenValueBuyer&BuyerID="+buyerId+"&FromDate="+fromDate+"&ToDate="+toDate;
    var htmlObjB    = $.ajax({url:urlB, async:false});
    $("#lblFrozenBuyer").text(htmlObjB.responseText);
    // =====================================================
                
    // List all the frozen deliveries in given date range and by buyer
    // =====================================================
    var url 	= "salesmiddle.php?RequestType=LoadDeliveries&BuyerID="+buyerId+"&FromDate="+fromDate+"&ToDate="+toDate+"&compId="+companyId;
    var htmlObj 	= $.ajax({url:url, async:false});

    var XMLStyle 	= htmlObj.responseXML.getElementsByTagName("StyleID");	
    var XMLSCNo 	= htmlObj.responseXML.getElementsByTagName("SCNO");	
    var XMLBPO 	= htmlObj.responseXML.getElementsByTagName("BPONo");	
    var XMLDelQty 	= htmlObj.responseXML.getElementsByTagName("DelQty");	
    var XMLFOB 	= htmlObj.responseXML.getElementsByTagName("FOB");		
    var XMLHODDate 	= htmlObj.responseXML.getElementsByTagName("HOD");	
    var XMLWeek 	= htmlObj.responseXML.getElementsByTagName("WEEK");	
    var XMLStyleID 	= htmlObj.responseXML.getElementsByTagName("STYLE_CODE");
    var XMLFGStock  = htmlObj.responseXML.getElementsByTagName("FG_STOCK");
    var XMLApprove  = htmlObj.responseXML.getElementsByTagName("APPROVE");
    var XMLConfirm  = htmlObj.responseXML.getElementsByTagName("CONFIRM");
    var XMLPlanner  = htmlObj.responseXML.getElementsByTagName("PLANNER");

    for ( var loop = 0; loop < XMLStyle.length; loop ++)
    {

            var styleName 	= XMLStyle[loop].childNodes[0].nodeValue;
            var SCNo 	= XMLSCNo[loop].childNodes[0].nodeValue;
            var BPONo 	= XMLBPO[loop].childNodes[0].nodeValue;
            var DelQty	= XMLDelQty[loop].childNodes[0].nodeValue;	
            var dblFOB 	= XMLFOB[loop].childNodes[0].nodeValue;	
            var dtHOD 	= XMLHODDate[loop].childNodes[0].nodeValue;	
            var weekno 	= XMLWeek[loop].childNodes[0].nodeValue;
            var styleId 	= XMLStyleID[loop].childNodes[0].nodeValue;
            var fgStock 	= XMLFGStock[loop].childNodes[0].nodeValue;
            var isApprove   = XMLApprove[loop].childNodes[0].nodeValue;
            var isConfirm   = XMLConfirm[loop].childNodes[0].nodeValue;
            var isCanPlanner = XMLPlanner[loop].childNodes[0].nodeValue;

            var objSaleExist = IsSalesExist(styleId, BPONo);

            var XMLAccConfirm   = objSaleExist.responseXML.getElementsByTagName("AccConfirm");
            var XMLShipConfirm  = objSaleExist.responseXML.getElementsByTagName("ShipConfirm");
            var XMLPlanConfirm  = objSaleExist.responseXML.getElementsByTagName("PlanConfirm");

            var IsAccMgrConfirm     = XMLAccConfirm[0].childNodes[0].nodeValue; 
            var IsShipConfirm       = XMLShipConfirm[0].childNodes[0].nodeValue; 
            var IsPlanConfirm   = XMLPlanConfirm[0].childNodes[0].nodeValue; 


            if(IsAccMgrConfirm == "1"){

                if(IsPlanConfirm == 1){                   
                    if(IsShipConfirm == 1){
                        $("#tbListing > tbody:last-child").append("<tr class='Completed'><td id="+styleId+">&nbsp;</td><td class='col-xs-1'>&nbsp;"+weekno+"</td><td class='col-xs-1'>&nbsp;"+styleName+"</td><td class='col-xs-1'>&nbsp;"+SCNo+"</td><td class='col-xs-1' id='"+BPONo+"'>&nbsp;"+BPONo+"</td><td class='col-xs-1'>&nbsp;"+DelQty+"</td><td class='col-xs-1'>&nbsp;"+fgStock+"</td><td class='col-xs-1'>&nbsp;"+dblFOB+"</td><td class='col-xs-1'>&nbsp;"+dtHOD+"</td><td class='col-xs-1 textalign'>&nbsp;Confirmed</td><td class='col-xs-1 textalign'>&nbsp;Confirmed</td><td class='col-xs-1 textalign'>&nbsp;Confirmed</td></tr>");
                    }else{
                        if(isConfirm == 1){
                            $("#tbListing > tbody:last-child").append("<tr><td  id="+styleId+">&nbsp;</td><td class='col-xs-1'>&nbsp;"+weekno+"</td><td class='col-xs-1'>&nbsp;"+styleName+"</td><td class='col-xs-1'>&nbsp;"+SCNo+"</td><td class='col-xs-1' id='"+BPONo+"'>&nbsp;"+BPONo+"</td><td class='col-xs-1'>&nbsp;"+DelQty+"</td><td class='col-xs-1'>&nbsp;"+fgStock+"</td><td class='col-xs-1'>&nbsp;"+dblFOB+"</td><td class='col-xs-1'>&nbsp;"+dtHOD+"</td><td class='col-xs-1 textalign'>&nbsp;Confirmed</td><td class='col-xs-1 textalign'>&nbsp;Confirmed</td><td class='col-xs-1 textalign'>&nbsp;<input type='checkbox'></td></tr>");	
                        }else{
                            $("#tbListing > tbody:last-child").append("<tr><td  id="+styleId+">&nbsp;</td><td class='col-xs-1'>&nbsp;"+weekno+"</td><td class='col-xs-1'>&nbsp;"+styleName+"</td><td class='col-xs-1'>&nbsp;"+SCNo+"</td><td class='col-xs-1' id='"+BPONo+"'>&nbsp;"+BPONo+"</td><td class='col-xs-1'>&nbsp;"+DelQty+"</td><td class='col-xs-1'>&nbsp;"+fgStock+"</td><td class='col-xs-1'>&nbsp;"+dblFOB+"</td><td class='col-xs-1'>&nbsp;"+dtHOD+"</td><td class='col-xs-1 textalign'>&nbsp;Confirmed</td><td class='col-xs-1 textalign'>&nbsp;Confirmed</td><td class='col-xs-1 textalign'>&nbsp;</td></tr>");
                        }
                    }
                }else{

                    if(isCanPlanner == "1"){
                        if(IsShipConfirm == 1){
                            $("#tbListing > tbody:last-child").append("<tr><td id="+styleId+">&nbsp;</td><td class='col-xs-1'>&nbsp;"+weekno+"</td><td class='col-xs-1'>&nbsp;"+styleName+"</td><td class='col-xs-1'>&nbsp;"+SCNo+"</td><td class='col-xs-1' id='"+BPONo+"'>&nbsp;"+BPONo+"</td><td class='col-xs-1'>&nbsp;"+DelQty+"</td><td class='col-xs-1'>&nbsp;"+fgStock+"</td><td class='col-xs-1'>&nbsp;"+dblFOB+"</td><td class='col-xs-1'>&nbsp;"+dtHOD+"</td><td class='col-xs-1 textalign'>&nbsp;<input type='checkbox'></td><td class='col-xs-1 textalign'>&nbsp;Confirmed</td><td class='col-xs-1 textalign'>&nbsp;Confirmed</td></tr>");
                        }else{
                            if(isConfirm == 1){
                                $("#tbListing > tbody:last-child").append("<tr><td id="+styleId+">&nbsp;</td><td class='col-xs-1'>&nbsp;"+weekno+"</td><td class='col-xs-1'>&nbsp;"+styleName+"</td><td class='col-xs-1'>&nbsp;"+SCNo+"</td><td class='col-xs-1' id='"+BPONo+"'>&nbsp;"+BPONo+"</td><td class='col-xs-1'>&nbsp;"+DelQty+"</td><td class='col-xs-1'>&nbsp;"+fgStock+"</td><td class='col-xs-1'>&nbsp;"+dblFOB+"</td><td class='col-xs-1'>&nbsp;"+dtHOD+"</td><td class='col-xs-1 textalign'>&nbsp;<input type='checkbox'></td><td class='col-xs-1 textalign'>&nbsp;Confirmed</td><td class='col-xs-1 textalign'>&nbsp;<input type='checkbox'></td></tr>");
                            }else{
                                $("#tbListing > tbody:last-child").append("<tr><td id="+styleId+">&nbsp;</td><td class='col-xs-1'>&nbsp;"+weekno+"</td><td class='col-xs-1'>&nbsp;"+styleName+"</td><td class='col-xs-1'>&nbsp;"+SCNo+"</td><td class='col-xs-1' id='"+BPONo+"'>&nbsp;"+BPONo+"</td><td class='col-xs-1'>&nbsp;"+DelQty+"</td><td class='col-xs-1'>&nbsp;"+fgStock+"</td><td class='col-xs-1'>&nbsp;"+dblFOB+"</td><td class='col-xs-1'>&nbsp;"+dtHOD+"</td><td class='col-xs-1 textalign'>&nbsp;<input type='checkbox'></td><td class='col-xs-1 textalign'>&nbsp;Confirmed</td><td class='col-xs-1 textalign'>&nbsp;</td></tr>");
                            }
                        } 

                    }else{
                        if(IsShipConfirm == 1){
                            $("#tbListing > tbody:last-child").append("<tr><td id="+styleId+">&nbsp;</td><td class='col-xs-1'>&nbsp;"+weekno+"</td><td class='col-xs-1'>&nbsp;"+styleName+"</td><td class='col-xs-1'>&nbsp;"+SCNo+"</td><td class='col-xs-1' id='"+BPONo+"'>&nbsp;"+BPONo+"</td><td class='col-xs-1'>&nbsp;"+DelQty+"</td><td class='col-xs-1'>&nbsp;"+fgStock+"</td><td class='col-xs-1'>&nbsp;"+dblFOB+"</td><td class='col-xs-1'>&nbsp;"+dtHOD+"</td><td class='col-xs-1 textalign'>&nbsp;</td><td class='col-xs-1 textalign'>&nbsp;Confirmed</td><td class='col-xs-1 textalign'>&nbsp;Confirmed</td></tr>");
                        }else{
                            if(isConfirm == 1){
                                $("#tbListing > tbody:last-child").append("<tr><td id="+styleId+">&nbsp;</td><td class='col-xs-1'>&nbsp;"+weekno+"</td><td class='col-xs-1'>&nbsp;"+styleName+"</td><td class='col-xs-1'>&nbsp;"+SCNo+"</td><td class='col-xs-1' id='"+BPONo+"'>&nbsp;"+BPONo+"</td><td class='col-xs-1'>&nbsp;"+DelQty+"</td><td class='col-xs-1'>&nbsp;"+fgStock+"</td><td class='col-xs-1'>&nbsp;"+dblFOB+"</td><td class='col-xs-1'>&nbsp;"+dtHOD+"</td><td class='col-xs-1 textalign'>&nbsp;</td><td class='col-xs-1 textalign'>&nbsp;Confirmed</td><td class='col-xs-1 textalign'>&nbsp;<input type='checkbox'></td></tr>");
                            }else{
                                $("#tbListing > tbody:last-child").append("<tr><td id="+styleId+">&nbsp;</td><td class='col-xs-1'>&nbsp;"+weekno+"</td><td class='col-xs-1'>&nbsp;"+styleName+"</td><td class='col-xs-1'>&nbsp;"+SCNo+"</td><td class='col-xs-1' id='"+BPONo+"'>&nbsp;"+BPONo+"</td><td class='col-xs-1'>&nbsp;"+DelQty+"</td><td class='col-xs-1'>&nbsp;"+fgStock+"</td><td class='col-xs-1'>&nbsp;"+dblFOB+"</td><td class='col-xs-1'>&nbsp;"+dtHOD+"</td><td class='col-xs-1 textalign'>&nbsp;</td><td class='col-xs-1 textalign'>&nbsp;Confirmed</td><td class='col-xs-1 textalign'>&nbsp;</td></tr>");
                            }
                        }

                    }
                }
            }else{

                if(IsPlanConfirm == 1){     
                    
                    if(isApprove == "1"){
                        $("#tbListing > tbody:last-child").append("<tr><td  id="+styleId+">&nbsp;</td><td class='col-xs-1'>&nbsp;"+weekno+"</td><td class='col-xs-1'>&nbsp;"+styleName+"</td><td class='col-xs-1'>&nbsp;"+SCNo+"</td><td class='col-xs-1' id='"+BPONo+"'>&nbsp;"+BPONo+"</td><td class='col-xs-1'>&nbsp;"+DelQty+"</td><td class='col-xs-1'>&nbsp;"+fgStock+"</td><td class='col-xs-1'>&nbsp;"+dblFOB+"</td><td class='col-xs-1'>&nbsp;"+dtHOD+"</td><td class='col-xs-1 textalign'>&nbsp;Confirmed</td><td class='col-xs-1 textalign'>&nbsp;<input type='checkbox'></td><td class='col-xs-1 textalign'>&nbsp;</td></tr>");
                    }else{
                        $("#tbListing > tbody:last-child").append("<tr><td  id="+styleId+">&nbsp;</td><td class='col-xs-1'>&nbsp;"+weekno+"</td><td class='col-xs-1'>&nbsp;"+styleName+"</td><td class='col-xs-1'>&nbsp;"+SCNo+"</td><td class='col-xs-1' id='"+BPONo+"'>&nbsp;"+BPONo+"</td><td class='col-xs-1'>&nbsp;"+DelQty+"</td><td class='col-xs-1'>&nbsp;"+fgStock+"</td><td class='col-xs-1'>&nbsp;"+dblFOB+"</td><td class='col-xs-1'>&nbsp;"+dtHOD+"</td><td class='col-xs-1 textalign'>&nbsp;Confirmed</td><td class='col-xs-1 textalign'>&nbsp;</td><td class='col-xs-1 textalign'>&nbsp;</td></tr>");
                    }
                }else{

                    if(isCanPlanner == "1"){                                    
                        if(isApprove == "1"){
                            $("#tbListing > tbody:last-child").append("<tr><td  id="+styleId+">&nbsp;</td><td class='col-xs-1'>&nbsp;"+weekno+"</td><td class='col-xs-1'>&nbsp;"+styleName+"</td><td class='col-xs-1'>&nbsp;"+SCNo+"</td><td class='col-xs-1' id='"+BPONo+"'>&nbsp;"+BPONo+"</td><td class='col-xs-1'>&nbsp;"+DelQty+"</td><td class='col-xs-1'>&nbsp;"+fgStock+"</td><td class='col-xs-1'>&nbsp;"+dblFOB+"</td><td class='col-xs-1'>&nbsp;"+dtHOD+"</td><td class='col-xs-1 textalign'>&nbsp;<input type='checkbox'></td><td class='col-xs-1 textalign'>&nbsp;<input type='checkbox'></td><td class='col-xs-1 textalign'>&nbsp;</td></tr>");
                        }else{
                            $("#tbListing > tbody:last-child").append("<tr><td  id="+styleId+">&nbsp;</td><td class='col-xs-1'>&nbsp;"+weekno+"</td><td class='col-xs-1'>&nbsp;"+styleName+"</td><td class='col-xs-1'>&nbsp;"+SCNo+"</td><td class='col-xs-1' id='"+BPONo+"'>&nbsp;"+BPONo+"</td><td class='col-xs-1'>&nbsp;"+DelQty+"</td><td class='col-xs-1'>&nbsp;"+fgStock+"</td><td class='col-xs-1'>&nbsp;"+dblFOB+"</td><td class='col-xs-1'>&nbsp;"+dtHOD+"</td><td class='col-xs-1 textalign'>&nbsp;<input type='checkbox'></td><td class='col-xs-1 textalign'>&nbsp;</td><td class='col-xs-1 textalign'>&nbsp;</td></tr>");
                        }                                    
                    }else{
                        if(isApprove == "1"){
                            $("#tbListing > tbody:last-child").append("<tr><td  id="+styleId+">&nbsp;</td><td class='col-xs-1'>&nbsp;"+weekno+"</td><td class='col-xs-1'>&nbsp;"+styleName+"</td><td class='col-xs-1'>&nbsp;"+SCNo+"</td><td class='col-xs-1' id='"+BPONo+"'>&nbsp;"+BPONo+"</td><td class='col-xs-1'>&nbsp;"+DelQty+"</td><td class='col-xs-1'>&nbsp;"+fgStock+"</td><td class='col-xs-1'>&nbsp;"+dblFOB+"</td><td class='col-xs-1'>&nbsp;"+dtHOD+"</td><td class='col-xs-1 textalign'>&nbsp;</td><td class='col-xs-1 textalign'>&nbsp;<input type='checkbox'></td><td class='col-xs-1 textalign'>&nbsp;</td></tr>");
                        }else{
                            $("#tbListing > tbody:last-child").append("<tr><td  id="+styleId+">&nbsp;</td><td class='col-xs-1'>&nbsp;"+weekno+"</td><td class='col-xs-1'>&nbsp;"+styleName+"</td><td class='col-xs-1'>&nbsp;"+SCNo+"</td><td class='col-xs-1' id='"+BPONo+"'>&nbsp;"+BPONo+"</td><td class='col-xs-1'>&nbsp;"+DelQty+"</td><td class='col-xs-1'>&nbsp;"+fgStock+"</td><td class='col-xs-1'>&nbsp;"+dblFOB+"</td><td class='col-xs-1'>&nbsp;"+dtHOD+"</td><td class='col-xs-1 textalign'>&nbsp;</td><td class='col-xs-1 textalign'>&nbsp;</td><td class='col-xs-1 textalign'>&nbsp;</td></tr>");
                        }
                    }
                }



            }	

    }
    
    
}
