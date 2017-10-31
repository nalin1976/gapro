<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
<script type="text/javascript">

function goPage()
{

	var names = [1,2,3,4,5,6];
	
	window.location = "jsget.php?names=" + names;
}


</script>

</head>

<body>
<input type="submit" name="Submit" value="Submit" onclick="goPage();" />
</body>
</html>
