<?php
include "../../Connector.php";

$backwardseperator = "../../";
session_start();
$intPubCompanyId		=$_SESSION["FactoryID"];

$calanderId = $_POST["cboCalander"];
$previous = $_POST["cboprevious"];

$h = 0;
									$sql_holiday = "SELECT * FROM holiday_calender WHERE dtmDate>= '$cellDate'";
									$result_holiday = $db->RunQuery($sql_holiday);
									while($rowHolidy = mysql_fetch_array($result_holiday))
									{
										$holiday[$h] =  $rowHolidy["dtmDate"];
										echo  $holiday[$h];
										$h++;
									}
?>
												
												
												
	