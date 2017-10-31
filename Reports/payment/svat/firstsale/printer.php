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
<script src="../../../../js/jquery-1.4.2.min.js" type="text/javascript"></script>
<script type="text/javascript">

$(document).ready(function(){ 
$(".trclass").bind("contextmenu", function(e) {
		menu_rowindex =this.rowIndex;
		$('#grid_menu').css({
			top: e.pageY+'px',
			left: e.pageX+'px'
		}).show();
		return false;
	});
		
	$('#indirect_print').click(function()
	{
		set_printer();		
	});
});

$(document).click(function() {
		$("#grid_menu").hide();
});	
	
function set_printer()
{
	
	jsPrintSetup.setPrinter('ZDesigner 110Xi4 203 dpi');
	jsPrintSetup.getPrintersList();
	jsPrintSetup.setOption('orientation', jsPrintSetup.kPortraitOrientation);//kLandscapeOrientation & kPortraitOrientation
	jsPrintSetup.setPaperSizeUnit(jsPrintSetup.kPaperSizeInches);;
	jsPrintSetup.setOption('paperHeight', 842);
	jsPrintSetup.setOption('paperWidth', 595);
	jsPrintSetup.setOption('shrinkToFit', 1);
	jsPrintSetup.setOption('numCopies',1);
	
	jsPrintSetup.setOption('printBGImages', 1);
	
	jsPrintSetup.setSilentPrint(0);
	jsPrintSetup.setOption('headerStrCenter', '');
	jsPrintSetup.setOption('headerStrRight', '');
	// here window is current frame!
	jsPrintSetup.printWindow(window);
	jsPrintSetup.setSilentPrint(0);
}
</script>

<div style=" padding: 1px; display: none; position: absolute; background-color: rgb(238, 238, 238); top: 667px; left: 330px;" id="grid_menu" class="menu_css">

			<table width="150" id='menu-hide' class="normalfnt" cellpadding="1">
            	
                <tr>
                    <td id="indirect_print" class=" menu_hoverz" height="15"><img src="../../../../images/print_icon.png"> &nbsp; Print to PDF</td>
                </tr>  
            </table>
		
</div>