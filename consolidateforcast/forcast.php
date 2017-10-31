<?php

session_start();
include "../Connector.php";	
$companyId=$_SESSION["FactoryID"];
$backwardseperator = "../";

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Consolidate Forcast Upload</title>

<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css" rel="stylesheet">
<link href="fileinput.css" media="all" rel="stylesheet" type="text/css" />
<!--<link href="../bootstrap/css/bootstrap.min.css" type="text/css" rel="stylesheet" />-->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script type="text/javascript" src="js/fileinput.js"></script>
<!--<script type="text/javascript" src="../js/jquery-1.10.2.js"></script>-->


<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js" type="text/javascript"></script>


<style type="text/css">
	#wrapper{
		border-left-color: #DDDDFD;
		border-left-width: 1px;
		border-left-style: solid;

		border-right-color: #DDDDFD;
		border-right-width: 1px;
		border-right-style: solid;

		border-bottom-color: #DDDDFD;
		border-bottom-width: 1px;
		border-bottom-style: solid;

		border-bottom-left-radius: 5px;
		border-bottom-right-radius: 5px;

		height: 450px;
		
	}

	.col-height{
		height: 50px;
	}

	
</style>
<script type="text/javascript">
	
$(function(){

	$("#btnViewReport").click(function(){
		window.open("consolidatereport.php", '_blank');
	});
});

</script>


</head>
<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td><?php include '../Header.php';  ?></td>
    </tr>
    <tr>
    	<td>
    		<table width="100%">
    			<tr><td border="1" width="15%">&nbsp;</td>
    			<td border="1" width="70%">
    				<div class="container" id="wrapper">
	    				<div class="col-md-12 col-height">&nbsp;</div>
	    				<div class="col-md-12 ">
	    					<form enctype="multipart/form-data" action="fileread.php" method="post" name="frmStyle" id="frmStyle">
	    					 	
	    					 	<input id="file-0a" name="file-0a" class="file" type="file">
                <br>
               
	    					</form>

	    				</div>
	    				<div class="col-sm-12">&nbsp;</div>
	    				<div class="col-md-11"></div><div class="col-md-1"></div>
	    				<div class="col-md-11"></div><div class="col-md-1"></div>

	    				<div class="col-sm-10">&nbsp;</div>
	    				<div class="col-sm-2"><button id="btnViewReport" name="btnViewReport" type="" class="btn btn-info">View Report</button></div>
	    					 
	    			</div>	

    			</td>
    			<td border="1" width="15%">&nbsp;</td></tr>
    		</table>	
    	</td>
    </tr>
</table>
</body>
<script>
    
    
    $("#file-0a").fileinput({

    	'showPreview' : false,
        'allowedFileExtensions' : ['jpg', 'png','gif'],
    });
    $("#file-1").fileinput({
        uploadUrl: '#', // you must set a valid URL here else you will get an error
        allowedFileExtensions : ['jpg', 'png','gif'],
        overwriteInitial: false,
        maxFileSize: 1000,
        maxFilesNum: 10,
        //allowedFileTypes: ['image', 'video', 'flash'],
        slugCallback: function(filename) {
            return filename.replace('(', '_').replace(']', '_');
        }
	});
    /*
    $(".file").on('fileselect', function(event, n, l) {
        alert('File Selected. Name: ' + l + ', Num: ' + n);
    });
    */
	$("#file-3").fileinput({
		showUpload: false,
		showCaption: false,
		browseClass: "btn btn-primary btn-lg",
		fileType: "any"
        //previewFileIcon: "<i class='glyphicon glyphicon-king'></i>"
	});
	$("#file-4").fileinput({
		uploadExtraData: {kvId: '10'}
	});
    $(".btn-warning").on('click', function() {
        if ($('#file-4').attr('disabled')) {
            $('#file-4').fileinput('enable');
        } else {
            $('#file-4').fileinput('disable');
        }
    });    
    $(".btn-info").on('click', function() {
        $('#file-4').fileinput('refresh', {previewClass:'bg-info'});
    });
    /*
    $('#file-4').on('fileselectnone', function() {
        alert('Huh! You selected no files.');
    });
    $('#file-4').on('filebrowse', function() {
        alert('File browse clicked for #file-4');
    });
    */
    $(document).ready(function() {
    	
        $("#file-0a").fileinput({
            'showPreview' : false,
            'allowedFileExtensions' : ['jpg', 'png','gif'],
            'elErrorContainer': '#errorBlock'
        });
        /*
        $("#test-upload").on('fileloaded', function(event, file, previewId, index) {
            alert('i = ' + index + ', id = ' + previewId + ', file = ' + file.name);
        });
        */
    });
	</script>
</html>

