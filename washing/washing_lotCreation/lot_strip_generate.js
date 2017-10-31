var strLen=hh=0;
var pub_Qty = 0;
function createStrLen(){
	alert(strLen)
}
/*function mOver(){*/
		$('document').ready(init);
	//}
		function init(){
		$('.board').bind('dragstart', function(event) {
				event.originalEvent.dataTransfer.setData("Text", $(event.target).closest('a[id]').attr('id'));
			});
			// bind the dragover event on the board sections
			$('.board').bind('dragover', function(event) {
			
			if ($(event.target).closest('.droptarget').hasClass('droptarget')) {

				event.preventDefault();
			}
			}).bind('drop', function(event) {
			var notecard = event.originalEvent.dataTransfer.getData("Text");
			
			var drop = $(event.target).closest('.droptarget');				
			var ctr=drop.closest('tr');
			var cdiv=drop.closest('div');
			
			//var ntcId=notecard.
		
			//drag to Po pool
			// 
					
					if(ctr.children(0)[1].id=="lot_StripPool"){
						var noteCardId=$("#"+notecard).attr('id');
						if(noteCardId.substr(0,3)=='lot'){
							return false;
						}
     					var pQty=$($("#"+notecard).children(0).children(0)[10]).text();
						var balQty=parseFloat($($("#"+notecard).children(0).children(0)[13]).text());
						var TotQty=parseFloat($($("#"+notecard).children(0).children(0)[7]).text());		
						var oNo		=	$('#' + notecard).children(0)[0].innerHTML;
						var oQty	=	$('#' + notecard).children(0).attr("alter").split('~')[0];
						var exQty	=	$('#' + notecard).children(0).attr("alter").split('~')[1];
					
						/*var newDiv="<div draggable=\"true\" alter=\""+oQty+"~"+exQty+"\" class=\"drag\" id=\""+notecard+"\" ondblclick=\"openSeparater(this)\">"+oNo+"</div>";
						$('#' + notecard).html("");
						$('#' + notecard).append(newDiv);*/
						if(TotQty-balQty==0)
							$("#"+notecard).children(0).css("background","#EDABE8");
						else
							$("#"+notecard).children(0).css("background","#3F6");
							
						$("#"+notecard).children(0).css("height","90px");
						$("#"+notecard).children(0).css("width","100px");
						$("#"+notecard).children(0).css("cursor","arm");
						$("#"+notecard).children(0).css("position","static");
						$("#"+notecard).children(0).css("z-index",10);
						$("#"+notecard).children(0).css("float","left");
						$($("#"+notecard).children(0).children(0)[3]).css("display","inline");
						$($("#"+notecard).children(0).children(0)[4]).css("display","inline");
						$($("#"+notecard).children(0).children(0)[6]).css("display","inline");
						$($("#"+notecard).children(0).children(0)[7]).css("display","inline");
						$($("#"+notecard).children(0).children(0)[9]).css("display","inline");
						$($("#"+notecard).children(0).children(0)[10]).css("display","inline");
						$($("#"+notecard).children(0).children(0)[12]).css("display","inline");
						$($("#"+notecard).children(0).children(0)[13]).css("display","inline");
					
						drop.append($('#' + notecard));	

						$("#"+notecard).dblclick(function(){
 						 openSeparater($(this))
						 });
						
						
					}
					
					if(cdiv.attr("id")=="lot_crt_poList")
					{
						var noteCardId = $('#'+notecard).attr('id');
						if(noteCardId.substr(0,3)=='lot')
						{
							return false;
						}
						$("#"+notecard).children(0).css("background","#EDABE8");
						$("#"+notecard).children(0).css("height","25px");
						$("#"+notecard).children(0).css("width","150px");
						$("#"+notecard).children(0).css("cursor","arm");
						$("#"+notecard).children(0).css("position","static");
						$("#"+notecard).children(0).css("z-index",10);
						$("#"+notecard).children(0).css("float","left");
						$($("#"+notecard).children(0).children(0)[3]).css("display","none");
						$($("#"+notecard).children(0).children(0)[4]).css("display","none");
						$($("#"+notecard).children(0).children(0)[6]).css("display","none");
						$($("#"+notecard).children(0).children(0)[7]).css("display","none");
						$($("#"+notecard).children(0).children(0)[9]).css("display","none");
						$($("#"+notecard).children(0).children(0)[10]).css("display","none");
						$($("#"+notecard).children(0).children(0)[12]).css("display","none");
						$($("#"+notecard).children(0).children(0)[13]).css("display","none");
					//	$('#lot_crt_poList').append($('#' + notecard));	
						$("#"+notecard).children(0).css("background","#EDABE8");
						$("#"+notecard).children(0).css("height","25px");
						$("#"+notecard).children(0).css("width","160px");
						$("#"+notecard).children(0).css("cursor","arm");
						$("#"+notecard).children(0).css("position","static");
						$("#"+notecard).children(0).css("z-index",10);
						$("#"+notecard).children(0).css("float","left");
						
						$($("#"+notecard).children(0).children(0)[3]).css("display","none");
						$($("#"+notecard).children(0).children(0)[4]).css("display","none");
						$($("#"+notecard).children(0).children(0)[6]).css("display","none");
						$($("#"+notecard).children(0).children(0)[7]).css("display","none");
						$($("#"+notecard).children(0).children(0)[9]).css("display","none");
						$($("#"+notecard).children(0).children(0)[10]).css("display","none");
						$($("#"+notecard).children(0).children(0)[12]).css("display","none");
						$($("#"+notecard).children(0).children(0)[13]).css("display","none");
						drop.append($('#' + notecard));	
						return;
						//$('#lot_crt_poList').append($('#' + notecard));	
					//	console.log($("#"+notecard));	
						/*$("#"+notecard).dblclick(function(){
 						 return false;
						 });*/
					}
					if($(ctr.children(0)[1]).attr("alter")=="lot_crt_machineList")
					{
						var LmachineNo = 0;
						var newArry = "";
						var newLotNo = "";
						var arrynotecard = notecard.split('_');
						var tbl = document.getElementById('tblmid');
						if(arrynotecard[0]!="Mdiv")
						{
							var catId = $($('#' + notecard)).children(0).attr("alter").split('-')[1];
							var MacQty = $($('#' + notecard)).children(0).attr("alter").split('-')[0];
							var trCatId = $(ctr).attr("id").split('/')[0];
							if(catId==trCatId)
							{
									
								var tdId = $(ctr.children(0)[1]).attr("id");
								//var machineNo = tdId.substr(0,1);
								var lotLength = parseFloat($('#'+tdId).children(0).length);
								var strRowlength = 0;
								var NewstrRowlength = 0;
								for(var i=0;i<lotLength;i++)
								{
									var len = $($('#'+tdId).children(i)[i]).children(0).css("width").length;
									var lotWidth = $($('#'+tdId).children(i)[i]).children(0).css("width").substr(0,len-2);
									strRowlength = strRowlength+parseFloat(lotWidth);
								}
								var newlen = $('#' + notecard).children(0).css("width").length;
								var newlotWidth = $('#' + notecard).children(0).css("width").substr(0,len-2);
								
								var NewstrRowlength =strRowlength+parseFloat(newlotWidth);
								if(parseFloat(NewstrRowlength)< 1420 || isNaN(NewstrRowlength))
								{
									drop.append($('#' + notecard));
									for(var x=0;x<tbl.rows.length;x++)
									{
										var LottblId = tbl.rows[x].cells[1].id;
										var LotTblLen = parseFloat($('#'+LottblId).children(0).length);
										LmachineNo = parseFloat(LottblId.substr(0,1));
										for(var i=0;i<LotTblLen;i++)
										{
											var lotId = $($('#'+LottblId).children(i)[i]).attr('id');
											if(lotId.substr(0,3)!="lot")
											{
												continue;
											}
											$($('#'+LottblId).children(i)[i]).attr('id',"lot_"+LmachineNo+"_"+i)
	
										}
										
									}
								}
								else
								{
									return;
								}

							}
						}
						else
						{
							for(var i=0;i<arrynotecard[1];i++)
							{
								var catId = $($('#' + notecard)).children(0).attr("alter").split('~');
								var newCatId = catId[i].split('-');
								var trCatId = $(ctr).attr("id").split('/')[0];
								if(trCatId==newCatId[1])
									drop.append($('#' + notecard));	
							}
							
							
						}
						
					}
					if($(ctr.children(0)[1]).attr("alter")=="merge_lotList")
					{
						var macQty = 0;
						var macId = 0;
						var pub_totQty = 0;
						var tbl = document.getElementById('tblmid'); 
						var macCatergory = $($('#' + notecard)).children(0).attr("alter").split('-')[1];
						var LotQty = $($('#' + notecard)).children(0).attr("alter").split('-')[0];
						if($('#mac').children(0).length==0)
						{
							document.getElementById('mac').abbr = 0;
							drop.append($('#' + notecard));
							document.getElementById('mac').abbr = macCatergory ;
						}
						
						if(document.getElementById('mac').abbr==0)
						{
							document.getElementById('mac').abbr = macCatergory ;
							drop.append($('#' + notecard));
						}
						else
						{
							var mergeTDabbr = $('#mac').attr("abbr");
							if(macCatergory==mergeTDabbr)
							{
									drop.append($('#' + notecard));
							}
							else
							{
								alert("Please merge lots which belong to same machine category.");	
								return;
							}
						}
						
							
					}
					if($(ctr.children(0)[2]).attr("id")=="lot_crt_recycle")
					{
						//drop.append($('#' + notecard));	
						var color = "";
						var lotPoolId = $('#'+notecard).attr('id');
						var poNoArr=$('#'+notecard).attr('alter').split('~');
						var poolLength=$("#lot_StripPool").children().length;
						if(lotPoolId.substr(0,4)!='item')
						{
						if(poNoArr.length<=1)
						{
							var poNo = poNoArr[0].split('|')[0];
			
							for(var p=0;p<poolLength;p++)
							{
								var po=$($("#lot_StripPool").children(p)[p]).attr("id");
								var pId=po.substr(4,po.length)
								if( pId == poNo )
								{	
								
									var QANew = $($('#' + notecard)).children(0).attr("alter").split('-');				
									var Qa = QANew[0];
									var Qb=$($($("#"+po).children(0)).children(p)[10]).text();
									var Qc=$($($("#"+po).children(0)).children(p)[13]).text();
									var TotQty=parseInt($($($("#"+po).children(0)).children(p)[7]).text());
									
									
									$($($("#"+po).children(0)).children(p)[10]).text(parseInt(Qb)-parseInt(Qa));
									$($($("#"+po).children(0)).children(p)[13]).text(parseInt(Qc)+parseInt(Qa));
									
									var balQty = parseInt(Qc)+parseInt(Qa);
									if((TotQty-balQty)==0)
									{
										color ="#EDABE8";
										$("#"+po).children(0).css("background",color);
									}
									else
									{
										color ="#3F6";
										$("#"+po).children(0).css("background",color);
									}
								}
								
							}
						}
						else
						{
							for(var i=0;i<poNoArr.length;i++)
							{
								for(var p=0;p<poolLength;p++)
								{
									var po=$($("#lot_StripPool").children(p)[p]).attr("id");
									var pId=po.substr(4,po.length)
									if( pId == poNoArr[i].split('|')[0])
									{	
										var QANew = $($('#' + notecard)).children(0).attr("alter").split('~');	
										var arryQANew = QANew[i].split('-');				
										var Qa = arryQANew[0];
										var Qb=$($($("#"+po).children(0)).children(p)[10]).text();
										var Qc=$($($("#"+po).children(0)).children(p)[13]).text();
										
										$($($("#"+po).children(0)).children(p)[10]).text(parseInt(Qb)-parseInt(Qa));
										$($($("#"+po).children(0)).children(p)[13]).text(parseInt(Qc)+parseInt(Qa));
		
										if($($($("#"+po).children(0)).children(p)[10]).text()==0)
										{
											color ="#EDABE8";
											$("#"+po).children(0).css("background",color);
										}
									}
									
								}
							}
						}
					}
					else
					{
						var poNo=$('#'+notecard).attr('alter').split('~');
						for(var p=0;p<poolLength;p++)
						{
							
							var poNew=$($($("#lot_StripPool").children(0)).children(p)[p]).attr("id");
							var po=$($("#lot_StripPool").children(p)[p]).attr("id");
							if(poNo==poNew)
							{
								var Qb=$($($("#"+po).children(0)).children(p)[10]).text();
								var Qc=$($($("#"+po).children(0)).children(p)[13]).text();
								var TotQty=parseInt($($($("#"+po).children(0)).children(p)[7]).text());
								//alert(Qb+'/'+Qc);
								$($($("#"+po).children(0)).children(p)[10]).text(parseInt(Qb)-parseInt(Qb));
								$($($("#"+po).children(0)).children(p)[13]).text(parseInt(Qc)+parseInt(Qb));
								
								var balQty = parseInt(Qc)+parseInt(Qb);
								if((TotQty-balQty)==0)
								{
									color ="#EDABE8";
							
								}
								else
								{
									color ="#3F6";
						
								}
							}
						}
					}
						try
						{
							if(($("#"+notecard).attr('id').substr(0,3))!='lot')
							{
								
								$("#"+notecard).children(0).css("background",color);
								$("#"+notecard).children(0).css("height","25px");
								$("#"+notecard).children(0).css("width","160px");
								$("#"+notecard).children(0).css("cursor","arm");
								$("#"+notecard).children(0).css("position","static");
								$("#"+notecard).children(0).css("z-index",10);
								$("#"+notecard).children(0).css("float","left");
								
								$($("#"+notecard).children(0).children(0)[3]).css("display","none");
								$($("#"+notecard).children(0).children(0)[4]).css("display","none");
								$($("#"+notecard).children(0).children(0)[6]).css("display","none");
								$($("#"+notecard).children(0).children(0)[7]).css("display","none");
								$($("#"+notecard).children(0).children(0)[9]).css("display","none");
								$($("#"+notecard).children(0).children(0)[10]).css("display","none");
								$($("#"+notecard).children(0).children(0)[12]).css("display","none");
								$($("#"+notecard).children(0).children(0)[13]).css("display","none");
								$('#lot_crt_poList').append($('#' + notecard));	
							}
							else
						$("#"+notecard).remove();	
						}
						catch(e)
						{
							$("#"+notecard).remove();	
						}
					}
					
					//if(lot_crt_recycle)
			
			// Turn off the default behaviour
			// without this, FF will try and go to a URL with your id's name
			event.preventDefault();
			}).bind('click', function(event) {
			event.preventDefault();
		});
		}