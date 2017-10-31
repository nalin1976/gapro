// JavaScript Document
function getSubCat()
{
	var mainCat = $("#cboMainCat").val();
	var url = 'itemConfirmMiddle.php?RequestType=LoadSubcat';	
		url += '&mainCat='+mainCat;
		
		htmlobj=$.ajax({url:url,async:false});
				 
		 $("#cboSubCat").html(htmlobj.responseXML.getElementsByTagName("SubCat")[0].childNodes[0].nodeValue);
}

function submitPage()
{
	document.frmItemconfirm.submit();
	
}

function confirmItem()
{
	var tbl = document.getElementById('tblValues');	
	//alert($('#tblValues tr').length);
	/*var tblRwCnt = $('#tblValues tr').length;
	for ( var loop = 1 ;loop < tblRwCnt ; loop ++ )
	{
		//var chk =  $('#tblValues').rows[loop].cells[1].text();  
		//var chk = $('#tblValues tr:eq('+loop+') td:eq(1)').html();//working
		//var id = $('#tblValues tr:eq('+loop+') td:eq(1)').attr("id"); //working
		var chk = $('#tblValues tr:eq('+loop+') td:eq(0)').children(1).attr("checked")//working
		alert(chk);
	}
	return false;*/
	var cnt =1;
	for ( var loop = 1 ;loop < tbl.rows.length ; loop ++ )
	{
		var chk = tbl.rows[loop].cells[0].childNodes[0].checked;
		if(chk == false)
			cnt++;
	}
	
	if(cnt == tbl.rows.length)
	{
		alert("Please select item(s) to be confirm");
		return false;
	}
	else
	{
		var reccount = 0;
		var responseCnt =0;
		for ( var loop = 1 ;loop < tbl.rows.length ; loop ++ )
			{
				var chk = tbl.rows[loop].cells[0].childNodes[0].checked;
				
				if(chk == true)
				{
					reccount++;
					var rowid = tbl.rows[loop].cells[0].id;
					var itemID = tbl.rows[loop].cells[1].id;
					var itemName = tbl.rows[loop].cells[1].childNodes[0].nodeValue;
					var url = 'itemConfirmMiddle.php?RequestType=confirmItem';	
					url += '&itemID='+itemID;
					url += '&itemName='+URLEncode(itemName);
		
					htmlobj=$.ajax({url:url,async:false});
					var xmlresponse = htmlobj.responseXML.getElementsByTagName("Result")[0].childNodes[0].nodeValue;
					if(xmlresponse == 'false')
					{
						alert(htmlobj.responseXML.getElementsByTagName("Message")[0].childNodes[0].nodeValue);	
						
						
					}
					else
					{
						
						responseCnt++;
						//RemoveAllRows(rowid);
					}
				}	
			}
	}
	var mainCatgory = $("#cboMainCat").val();
		var subCategory = $("#cboSubCat").val();
		var description = $("#txtMatItem").val();
		//document.frmItemconfirm.submit();
		RemoveAllRows('tblValues');
		var url = 'itemConfirmMiddle.php?RequestType=loadPendingItemReq';	
					url += '&mainCatgory='+mainCatgory;
					url += '&subCategory='+subCategory;
					url += '&description='+URLEncode(description);
		
					htmlobj=$.ajax({url:url,async:false});
					var tblhtml = $("#tblValues").html();
	tblhtml += htmlobj.responseXML.getElementsByTagName("pendingItem")[0].childNodes[0].nodeValue;
	$("#tblValues").html(tblhtml);
	if(reccount == responseCnt)
	{
		
		alert("Item(s) confirmed successfully");
		
		return false;
		}
}
function RemoveAllRows(tableName){
	var tbl = document.getElementById(tableName);
	for ( var loop = tbl.rows.length-1 ;loop >= 1 ; loop -- )
	{
		 tbl.deleteRow(loop);
		// alert(1);
	}	
}

function checkAll()
{
	var tbl = document.getElementById('tblValues');	
	if($('#chlAll').attr('checked'))
	{
		
		for ( var loop = 1 ;loop < tbl.rows.length ; loop ++ )
		{
			 tbl.rows[loop].cells[0].childNodes[0].checked = true;
			
		}
	}
	else
	{
		for ( var loop = 1 ;loop < tbl.rows.length ; loop ++ )
		{
			 tbl.rows[loop].cells[0].childNodes[0].checked = false;
			
		}
	}
}