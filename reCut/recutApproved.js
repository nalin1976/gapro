function recutFirstApp(recutNo,recutYear)
{
	var strRemarks = document.getElementById('txtRemarks').value;
	var url = "recutApprovedResult.php?status="+2+"&remarks="+URLEncode(strRemarks);
	url += "&recutNo="+recutNo+"&recutYear="+recutYear;
	location=url;
}

function rejectRecut(recutNo,recutYear)
{
	var strRemarks = document.getElementById('txtRemarks').value;
	var url = "recutApprovedResult.php?status="+0+"&remarks="+URLEncode(strRemarks);
	url += "&recutNo="+recutNo+"&recutYear="+recutYear;
	location=url;	
}

function confirmRecutOrder(recutNo,recutYear)
{
	var strRemarks = document.getElementById('txtRemarks').value;
	var url = "recutApprovedResult.php?status="+3+"&remarks="+URLEncode(strRemarks);
	url += "&recutNo="+recutNo+"&recutYear="+recutYear;
	location=url;
}