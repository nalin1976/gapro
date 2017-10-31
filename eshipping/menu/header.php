<?php
	include "HeaderConnector.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html>
  <head>
    <title>Header</title>
    <meta name="description" content="" />
    <meta name="keywords" content="" />
	  <script type='text/javascript' src='assets/jquery.js'></script>
    <!--<link rel="stylesheet" href="assets/project-page.css" type="text/css" />-->
    
    <!-- per Project stuff -->
      <script type='text/javascript' src='javascripts/jquery.droppy.js'></script>
      <!--<link rel="stylesheet" href="stylesheets/droppy.css" type="text/css" />-->
    <!-- END per project stuff -->
  
  </head>
  <body>
<table width="952" border="0" cellpadding="0" cellspacing="0">
<tr bgcolor="#FFFFFF" >
<td width="12"></td>
      <td width="940" >
	  <table width="100%" cellpadding="0" cellspacing="0">
          <tr>
            <td width="43%"><img src="../images/eplan_logo.png" alt="logo" width="215" height="46" /></td>
			<td width="28%">&nbsp;</td>
			<td width="29%"><div align="right">
			  <div align="right"><a href="../logout.php"><img src="../images/logout.png" alt="Logout" width="92" height="25" border="0" class="noborderforlink" /></a> </div>
			  Welcome <span class="normalfnth2">
			  <?php
			  

		$SQL = "select Name from useraccounts where intUserID  =" . $_SESSION["UserID"] ;
		$result = $db->RunQuery($SQL);
	
		while($row = mysql_fetch_array($result))
		{
			echo $row["Name"];
		}
		
		?>
		    ! </span></div></td>
        </tr>
      </table> 
	  </td>
  </tr>
    <tr>
	<td align="center" bgcolor="#6AA6E8" style="width:30px;"><a href="main.php" title="Home"><img src="images/house.png" alt="Home" width="16" height="16" border="0" /></a></td>
      <td bgcolor="#6AA6E8">
<ul id='nav'>
  <li><a href='#' >Master Data</a></li>
  <li><a href='#' >Imports</a></li>
  <li><a href='#' >Exports</a></li>
  <li><a href='#' >Final Document</a></li>
  <li><a href='#' >Quota</a></li>
  <li><a href='#'>Reports</a>
    <ul>
      <li><a href='#'>Sub 2 - 1</a></li>
      <li>
        <a href='#'>Sub 2 - 2</a>
        <ul>
          <li>
            <a href='#'>Sub 2 - 2 - 1</a>
            <ul>
              <li><a href='#'>Sub 2 - 2 - 1 - 1</a></li>
              <li><a href='#'>Sub 2 - 2 - 1 - 2</a></li>
              <li><a href='#'>Sub 2 - 2 - 1 - 3</a></li>
              <li><a href='#'>Sub 2 - 2 - 1 - 4</a></li>
            </ul>
          </li>
          <li><a href='#'>Sub 2 - 2 - 2</a></li>
          <li>
            <a href='#'>Sub 2 - 2 - 3</a>
            <ul>
              <li><a href='#'>Sub 2 - 2 - 3 - 1</a></li>
              <li><a href='#'>Sub 2 - 2 - 3 - 2</a></li>
              <li><a href='#'>Sub 2 - 2 - 3 - 3</a></li>
              <li><a href='#'>Sub 2 - 2 - 3 - 4</a></li>
            </ul>
          </li>
        </ul>
      </li>
      <li><a href='#'>Sub 2 - 3</a></li>
    </ul>
  </li>
</ul>
</td>
  </tr>
</table>

<script type='text/javascript'>
  $(function() {
    $('#nav').droppy();
  });
</script>
</body>
</html>