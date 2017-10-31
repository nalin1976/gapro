<?php 

?>
<style type="text/css">
.menu_separator{
	border-bottom:#999 solid 1px;	
}
.menu_hoverz:hover{
	background-color:#DEE4F8;
	cursor: pointer;
}
.menu_css{
	border:#999 solid 1px;	
}
</style>
<script src="../../../../js/jquery-1.4.4.min.js" type="text/javascript"></script>
<script type="text/javascript">

$(document).ready(function(){ 
$(".body_bound").bind("contextmenu", function(e) {
		menu_rowindex =this.rowIndex;
		$('#grid_menu').css({
			top: e.pageY+'px',
			left: e.pageX+'px'
		}).show();
		return false;
	});
	
	$('#direct_print').click(function()
	{
		do_print();		
	});
	
	$('#indirect_print').click(function()
	{
		set_printer();		
	});
});

$(document).click(function() {
		$("#grid_menu").hide();
});	
	

	
function do_print()
{
	
	jsPrintSetup.setPrinter('ZDesigner 110Xi4 203 dpi');
	jsPrintSetup.getPrintersList();
	jsPrintSetup.setOption('orientation', jsPrintSetup.kPortraitOrientation);//kLandscapeOrientation & kPortraitOrientation
	jsPrintSetup.setPaperSizeUnit(jsPrintSetup.kPaperSizeInches);;
	jsPrintSetup.setOption('paperHeight', 1.8);
	jsPrintSetup.setOption('paperWidth', 3.00);
	jsPrintSetup.setOption('shrinkToFit', 1);
	jsPrintSetup.setOption('numCopies',1);
	
	jsPrintSetup.setOption('printBGImages', 1);
	
	jsPrintSetup.setSilentPrint(1);
	jsPrintSetup.setOption('headerStrCenter', 'bla bla frame');
	jsPrintSetup.setOption('headerStrRight', '');
	// here window is current frame!
	jsPrintSetup.printWindow(window);
	jsPrintSetup.setSilentPrint(0);
	
	
}

function set_printer()
{
	
	jsPrintSetup.setPrinter('');
	jsPrintSetup.getPrintersList();
	jsPrintSetup.setOption('orientation', <?php echo $orientation?>);//kLandscapeOrientation & kPortraitOrientation
	jsPrintSetup.setPaperSizeUnit(jsPrintSetup.kPaperSizeInches);;
	jsPrintSetup.setOption('paperHeight', 11.69);
	jsPrintSetup.setOption('paperWidth', 8.27);
	

	jsPrintSetup.setOption('marginTop',0);
	jsPrintSetup.setOption('marginBottom', 0);
	jsPrintSetup.setOption('marginLeft', 0);
	jsPrintSetup.setOption('marginRight', 0);


	jsPrintSetup.setOption('shrinkToFit', 1);
	jsPrintSetup.setOption('numCopies',1);
	
	jsPrintSetup.setOption('printBGImages', 1);
	
	jsPrintSetup.setSilentPrint(0);
	jsPrintSetup.setOption('headerStrCenter', 'bla bla frame');
	jsPrintSetup.setOption('headerStrRight', '');
	// here window is current frame!
	jsPrintSetup.printWindow(window);
	jsPrintSetup.setSilentPrint(0);
	
	
}

function set_printable()
{
	$(".body_bound").bind("contextmenu", function(e) {
		menu_rowindex =this.rowIndex;
		$('#grid_menu').css({
			top: e.pageY+'px',
			left: e.pageX+'px'
		}).show();
		return false;
	});
	
	$('#direct_print').click(function()
	{
		do_print();		
	});
	
	$('#indirect_print').click(function()
	{
		set_printer();		
	});
}

//setTimeout('window.close();',120000);
</script>

<div style=" padding: 1px; display: none; position: absolute; background-color: rgb(238, 238, 238); top: 667px; left: 330px;" id="grid_menu" class="menu_css">

			<table width="150" id='menu-hide' class="normalfnt" cellpadding="1">
            	
                <tr>
                    <td id="indirect_print" class="menu_separator menu_hoverz" height="15"><img src="../../../../images/print_icon.png"> &nbsp; Print</td>
                </tr>
                
                <tr style="display:none">
                    <td id="direct_print"  height="15" class="menu_hoverz"><img src="../../../../images/print_icon.png"> &nbsp; Direct Print</td>
                </tr>
               
            </table>
		
</div>