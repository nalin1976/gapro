

function saveThread()
{   
			if(trim(document.getElementById('txtCode').value)=="")
			{
			    alert("Please enter \"Code Number\".");
			    document.getElementById('txtCode').focus();
				return ;		
			}
			
			else if(trim(document.getElementById('txtDescription').value)=="")
			{
				alert("Please enter \"Description\".");
				document.getElementById('txtDescription').focus();
				return ;
							
			}				

           else if(!ValidateSave())
		   {
			return;
		   }
		   
		  
		    var url ="thread-db-set.php?type=save";
			url=url+"&cboSearch="+URLEncode(document.getElementById('cboSearch').value);			
			url=url+"&txtID="+URLEncode(document.getElementById('txtID').value);
			url=url+"&txtDescription="+URLEncode(document.getElementById('txtDescription').value);
			url=url+"&codeNumber="+URLEncode(document.getElementById('txtCode').value);
			
			var httpobj = $.ajax({url:url,async:false});
					  
		    alert(httpobj.responseText);
		    ClearForm();
		
 } 

function ConfirmDelete(strCommand)
{
		if(document.getElementById('cboSearch').value=="")		    
				alert("Please select \"Search\".");
		    
		else
		    {
				var Search =document.getElementById("cboSearch").options[document.getElementById('cboSearch').selectedIndex].text;
				var r=confirm("Are you sure you want to delete \'"+Search+"\' ?");
			if(r==true)		
				DeleteData();
				ClearForm();
			}
}			


function DeleteData()
{
	var url = "thread-db-set.php?type=delete&cboSearch="+document.getElementById('cboSearch').value;
	var httpobj = $.ajax({url:url,async:false});
	alert(httpobj.responseText);
	ClearForm();
}
	


function ClearForm()
{	
	
	 document.frmthread.reset();
	//document.getElementById('txtID').value = "";
	//document.getElementById('txtDescription').value = "";
	loadCombo('SELECT intID ,strthread FROM ws_thread ORDER BY strthread ASC','cboSearch');
	document.getElementById('txtCode').focus();
	
 }
	

function loadDetails(obj)
{	
	if(obj.value.trim()=="")
	   {
		return false;
	   } 
	   var url="thread-db-get.php?type=loadThreadDetails&threadId="+obj.value;
	 
	   var httpobj = $.ajax({url:url,async:false});
	   var xmlObj = httpobj.responseXML;
	 
       var XMLID=xmlObj.getElementsByTagName('ID');
	   var XMLDescription=xmlObj.getElementsByTagName('Description');
	    var XMLcodeNumber=xmlObj.getElementsByTagName('codeNumber');
									
	   document.getElementById('txtID').value=XMLID[0].childNodes[0].nodeValue;
	   document.getElementById('txtDescription').value=XMLDescription[0].childNodes[0].nodeValue;
	   document.getElementById('txtCode').value=XMLcodeNumber[0].childNodes[0].nodeValue;

}

function ValidateSave()
 {	
	var cboSearch=document.getElementById('cboSearch').value;
	var description=document.getElementById('txtDescription').value;
	var codeNumber=document.getElementById('txtCode').value;
	var x_find=checkInField('ws_thread','strCode',codeNumber,'intID',cboSearch);
	
	if(x_find)
	    {
			alert('Code Number "'+codeNumber+'" is already exist.');	
			document.getElementById('txtCode').focus();
			return false;
	    }
	else{
		var x_find=checkInField('ws_thread','strthread',description,'intID',cboSearch);
			if(x_find)
			{
				alert('Description "'+description+'" is already exist.');		
				document.getElementById('txtDescription').focus();
				return false;
			}
	    }  
       return true;	
}