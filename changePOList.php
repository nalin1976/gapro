<?php
 session_start();
include "authentication.inc";
include "Connector.php"; 

$dir_path = "";

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GaPro - Purchase Order Correction</title>
<link href="css/cssStyle.css" rel="stylesheet" type="text/css" />
<link href="bootstrap/css/bootstrap.min.css" type="text/css" rel="stylesheet" />

<script src="js/jquery.min.js"></script>
<script src="js/jquery-1.11.3.js"></script>
<script src="js/jquery.dataTables.min.js"></script>
<script src="bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script type="text/javascript" src="javascript/pocorrrection.js"></script>
<script>
   var dir_path =  <?php echo json_encode($dir_path); ?>
</script>

<style type="text/css">
table-fixed thead{
	width:95%;
}

.table-fixed tbody{
	height: 230px;
	overflow-y:auto;
	width:100%; 
}

.table-fixed thead, .table-fixed tbody, .table-fixed tr, .table-fixed td, .table-fixed th {
display: block;
}

.table-fixed tbody td, .table-fixed thead > tr> th {
  float: top;
  border-bottom-width: 0;

}

th{

	font-family: Futura, 'Trebuchet MS', Arial, sans-serif;
	font-size:09pt;
	font-weight: bold;
}

.table-fixed td{
	table-layout: fixed;
	word-wrap: break-word;
}

.table-fixed tr{
	font-family: Futura, 'Trebuchet MS', Arial, sans-serif;
	font-size:09pt;
	height: 90px;
}
.col-md-8{
    padding: 0px 0px 0px 0px;
}
</style>
</head>

<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td><?php include 'Header.php';  ?></td>
    </tr>
    <tr>
        <td width="100%">
            <div class="col-md-12">&nbsp;</div>
            <div class="col-md-2">&nbsp;</div>
            <div class="col-md-8 div-board">
                <div class="col-md-12  div-header">Purchase Orders (Confirmed) - Corrections</div>
                <div class="col-md-12">&nbsp;</div>
                <div class="col-md-2 div-pad">Style ID</div>
                <div class="col-md-3">
                    <select name="cboOrderNo" id="cboOrderNo" class="form-control select-md"></select>                    
                </div>
                <div class="col-md-1 div-pad">&nbsp;</div>
                <div class="col-md-2 div-pad">&nbsp;</div>
                <div class="col-md-1 div-pad">SC No</div>
                <div class="col-md-2">
                    <select name="cboSR" class="form-control select-sm"  id="cboSR"></select>
                </div>
                <div class="col-md-12">&nbsp;</div>
                <div class="col-md-2 div-pad" >Supplier Name</div>
                <div class="col-md-3">
                    <select name="cboSupplier" id="cboSupplier" class="form-control select-md"></select>                    
                </div>
                <div class="col-md-1 div-pad">PO Like</div>
                <div class="col-md-2 div-pad">
                    <input type="text" id="txtPOLike" name="txtPOLike" class="form-control" ></input>
                </div>
                <div class="col-md-1 div-pad">Year</div>
                <div class="col-md-2">
                    <select name="cboYear" class="form-control select"  id="cboYear"></select>
                </div>
                <div class="col-md-12">&nbsp;</div>
                <div class="col-md-10">&nbsp;</div>                
                <div class="col-md-1">
                    <button class="btn btn-warning" id="btnSearch" name="btnSearch">Search</button>
                </div>
                <div class="col-md-1">&nbsp;</div>
                
                <div class="col-md-12 div-seperator">&nbsp;</div>
                <div class="col-md-12 container">
                    <table class="table table-fixed" id="tbListing" border="0" cellpadding="0" cellspacing="0">
                        <thead>
                            <tr class="">
                                <th class="col-xs-1 th-lg" style="width:7%">PO No</th>
                                <th class="col-xs-1 th-lg" style="width:8%">Supplier</th>
                                <th class="col-xs-1 th-lg" style="width:7%">Delivery To</th>
                                <th class="col-xs-1 th-lg" style="width:7%">PO Date</th>
                                <th class="col-xs-1 th-lg">Delivery Date</th>
                                <th class="col-xs-1 th-lg">ETD</th>
                                <th class="col-xs-1 th-lg">User</th>
                                <th class="col-xs-1 th-lg">View</th>
                                <th class="col-xs-1" style="width:0.75%">&nbsp;</th>                                         
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                    
                </div>          
                <div class="col-md-12 div-seperator">&nbsp;</div>
            </div>
            <div class="col-md-2">&nbsp;</div>
            <div class="col-md-12">&nbsp;</div>
            
        </td>
    </tr>
    <tr>
        <td width="100%">
            <div class="col-md-3">&nbsp;</div>
            <div class="col-md-6">
                
                <div class="col-md-12">&nbsp;</div>
                
                
                
                
            </div>
            <div class="col-md-3">&nbsp;</div>
        </td>
    </tr>
</table>    

<script src="bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
</body>
</html>
