<?php
session_start();
$backwardseperator = "../../../";
include "../../../authentication.inc";
include "../../../Connector.php"; 
?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Supplier OTD</title>
<link href="../../../css/cssStyle.css" rel="stylesheet" type="text/css" />
<link href="../../../bootstrap/css/bootstrap.min.css" type="text/css" rel="stylesheet" />

<script src="../../../js/jquery.min.js"></script>
<script src="../../../js/jquery-1.11.3.js"></script>
<script src="../../../js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="../../../javascript/pocorrrection.js"></script>
<script>
    var dir_path = <?php echo json_encode($backwardseperator); ?>
</script>   
<style>
 .col-md-8{
    padding: 0px 0px 0px 0px;
}
</style>
</head>
    
<body>
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td><?php include '../../../Header.php';  ?></td>
        </tr>
        <tr>
            <td width="100%">
                <div class="col-md-12">&nbsp;</div>
                <div class="col-md-2">&nbsp;</div>
                <div class="col-md-8 div-board">
                    <div class="col-md-12 div-header">Supplier OTD (Ontime Delivery)</div>
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
                    <div class="col-md-2 div-pad" >Selection Criteria</div>
                    <div class="col-md-3">
                        <select name="cboSelection" id="cboSelection" class="form-control select-md">
                            <option value="1">PO Create Date</option>
                            <option value="2">ETA Date</option>
                        </select>                    
                    </div>
                    <div class="col-md-1 div-pad">Date From</div>
                    <div class="col-md-2 div-pad">
                        <input type="text" id="txtdtfrom" name="txtdtfrom" class="form-control" readonly="readonly" ></input>
                    </div>
                    <div class="col-md-1 div-pad">Date To</div>
                    <div class="col-md-2 div-pad">
                        <input type="text" id="txtdtto" name="txtdtto" class="form-control" readonly="readonly" ></input>
                    </div>
                    <div class="col-md-12">&nbsp;</div>
                    <div class="col-md-10">&nbsp;</div>                
                    <div class="col-md-1">
                        <button class="btn btn-warning" id="btnViewInfo" name="btnSearch "onclick="LoadInfo()">View Report</button>
                    </div>
                    <div class="col-md-1">&nbsp;</div>

                    <div class="col-md-12 div-seperator">&nbsp;</div>
                    <div class="col-md-12 container">
                     <!--   <table class="table table-fixed" id="tbListing" border="0" cellpadding="0" cellspacing="0">
                            <thead>
                                <tr class="">
                                    <th class="col-xs-1 th-lg">PO No</th>
                                    <th class="col-xs-1 th-lg">Supplier</th>
                                    <th class="col-xs-1 th-lg">Delivery To</th>
                                    <th class="col-xs-1 th-lg">PO Date</th>
                                    <th class="col-xs-1 th-lg">ETA</th>
                                    <th class="col-xs-1 th-lg">PO Qty</th>
                                    <th class="col-xs-1 th-lg">GRN Qty</th>
                                    <th class="col-xs-1 th-lg">GRN Date</th>
                                    <th class="col-xs-1 th-lg">NO. of days reached</th>
                                    

                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                     -->
                    </div>          
                    <div class="col-md-12 div-seperator">&nbsp;</div>
                </div>
                <div class="col-md-2">&nbsp;</div>
                <div class="col-md-12">&nbsp;</div>

            </td>
        </tr>
    </table>
    
    
<script src="../../../bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
</body>    
</html>