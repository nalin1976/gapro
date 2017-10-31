
var xmlHttp=[];
var pub_mainCatId = 0;

function searchCategory(obj,e)
{
	if(e.keyCode==13)
	{
		var url="allocatemainMiddle.php?req=searchCategory&id="+obj.value;
		htmlobj=$.ajax({url:url,async:false});
		document.getElementById('tblMain').tBodies[0].innerHTML=htmlobj.responseText;
	}
	
}
function searchGLAcc(obj,e)
{
	var cboid=  $('#cboGL').val();
	if(e.keyCode==13)
	{
		var url='allocatemainMiddle.php?req=searchGLAcc&id='+obj.value+'&cboid='+cboid+ '&MainCat='+pub_mainCatId;
		htmlobj=$.ajax({url:url,async:false});
		document.getElementById('tblPrc').tBodies[0].innerHTML=htmlobj.responseText;
		
	}
	
}

function loadGLPopUp(obj,e)
{
	
	var url  = "popglaccount.php?id="+obj.parentNode.id;
	pub_mainCatId = obj.parentNode.id;
	htmlobj=$.ajax({url:url,async:false});
	drawPopupAreaLayer(500,448,'frmGL',1);				
	//drawPopupArea(500,310,'frmProcess');
	var HTMLText=htmlobj.responseText;
	document.getElementById('frmGL').innerHTML=HTMLText;
	
}

function CloseWindowInBC()
{
	try
	{
		var box = document.getElementById('popupLayer');
		box.parentNode.removeChild(box);
		loca = 0;
		hideBackGroundBalck();
	}
	catch(err)
	{        
	}
}
function SelectAll(obj)
{	
	var tbl=document.getElementById('tblPrc');
	var rc=tbl.rows.length;
	if(obj.checked){
		for(var i=1;i<rc;i++){
			tbl.rows[i].cells[0].childNodes[0].checked=true;	
		}
	}
	else{
		for(var i=1;i<rc;i++){
			tbl.rows[i].cells[0].childNodes[0].checked=false;
		}
	}
	
	
	
}
function saveData()
{
	var row_source 		=$('#tblPrc tr')

	for(var loopz=1;loopz<=row_source.length-1;loopz++)
		{
			if(row_source[loopz].cells[0].childNodes[0].checked==true)
			{
				var glcode	= row_source[loopz].cells[1].id;
				var mainCat	= pub_mainCatId;
				var url='allocatemaindb.php?request=save_detail&glcode='+glcode+ '&mainCat='+mainCat;
				var xml_http_obj	=$.ajax({url:url,async:false});
			}
			else if(row_source[loopz].cells[0].childNodes[0].checked==false)
			{
				var glcode	= row_source[loopz].cells[1].id;
				var mainCat	= pub_mainCatId;
				var url='allocatemaindb.php?request=delete_detail&glcode='+glcode+ '&mainCat='+mainCat;
				var xml_http_obj	=$.ajax({url:url,async:false});
			}
		}
			if(xml_http_obj.responseText=="saved")
				{
					
					
					alert("Saved successfully");
					CloseWindowInBC();
					
				
				}
			else
				{
					alert(xml_http_obj.responseText);
				}
}

function resetAll()
{
	setTimeout("location.reload(true);");	
}