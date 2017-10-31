

function saveOperation()
{ 
			if(trim(document.getElementById('txtStitchType').value)=="")
			{
				alert("Please enter \"Stitch Type\".");
				document.getElementById('txtStitchType').focus();
				return ;				
			}

     else if(!ValidateSave())
		{
			return;
		}
		   
		    var url="stitchType-db-set.php?type=save"; 
		    	
			url=url+"&cboSearch="+URLEncode(document.getElementById('cboSearch').value);			
			url=url+"&txtID="+URLEncode(document.getElementById('txtID').value);
			url=url+"&txtStitchType="+URLEncode(document.getElementById('txtStitchType').value);	
						
			var httpobj = $.ajax({url:url,async:false});
					  
		   alert(httpobj.responseText);
		   ClearForm();
		
 } 		
		

 function deleteOperation()
{
		if(document.getElementById('cboSearch').value=="")		    
				alert("Please select \"Search\".");   
		else
		    {
				var Search =document.getElementById('cboSearch').options[document.getElementById('cboSearch').selectedIndex].text;
				var r=confirm("Are you sure you want to delete \'"+Search+"\'?");
			if(r==true)		
				DeleteData();
			}
}	

function DeleteData()
{
	    var url="stitchType-db-set.php?type=delete&cboSearch="+document.getElementById('cboSearch').value;
  
		var httpobj = $.ajax({url:url,async:false});
	    alert(httpobj.responseText);
		ClearForm();
} 
	


function ClearForm()
{	
	document.getElementById('txtStitchType').value = "";
	loadCombo('SELECT intID ,strStitchType FROM ws_stitchtype ORDER BY strStitchType ASC','cboSearch');
	document.getElementById('txtStitchType').focus();
	
 }


 
	 
function loadDetails(obj)
{	
	if(obj.value.trim()=="")
   	{
		return false;
   	} 
	 var url="stitchType-db-get.php?type=loadstitchTypeDetails&intId="+obj.value;
     var httpobj = $.ajax({url:url,async:false});
	 var xmlObj  = httpobj.responseXML;
     
	 var XMLID=xmlObj.getElementsByTagName('ID');
	 var XMLStitchType=xmlObj.getElementsByTagName('StitchType');
						
	 document.getElementById('txtID').value=XMLID[0].childNodes[0].nodeValue;
     document.getElementById('txtStitchType').value=XMLStitchType[0].childNodes[0].nodeValue;
}


function ClearFormc()
 {   	
 	   document.frmStitchType.reset();
	   document.getElementById('txtStitchType').focus();
 }

function ValidateSave()
 {	
	var intId=document.getElementById('cboSearch').value;	
	var stitchType=document.getElementById('txtStitchType').value;	
	var x_find=checkInField('ws_stitchType','strStitchType',stitchType,'intID',intId);
	
	if(x_find)
	    {   
		    alert('Stitch Type  "'+stitchType+'" is already exist.');	
			document.getElementById("txtStitchType").focus();
			return false;
	    }
       return true;	
 }