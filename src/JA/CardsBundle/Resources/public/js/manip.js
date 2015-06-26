stacksize = "3.5em";
deck = $("#south");
stacked = true;
flippedback=false;
toolbarviz=true;

function stack(deck){
	$("#"+deck+" .card").animate({marginLeft: "-="+stacksize});
	$("#"+deck).animate({paddingLeft: "+="+stacksize});
	$("#stacker span").html("unstack");
	$("#stacker").toggleClass("stack-open");
	$("#stacker i").toggleClass("glyphicon-resize-small").toggleClass("glyphicon-resize-full");
	stacked = true;
}
function unstack(deck){
	$("#"+deck+" .card").animate({marginLeft: "+="+stacksize});
	$("#"+deck).animate({paddingLeft: "-="+stacksize});
	$("#stacker span").html("stack");
	$("#stacker").toggleClass("stack-open");
	$("#stacker i").toggleClass("glyphicon-resize-small").toggleClass("glyphicon-resize-full");
	stacked = false;
}
function cleardeck(deck){
	$(".deck").empty();
}

function justflip(deck){
	$("#"+deck+" .card-back").css("visibility","visible");
}
function juststack(deck){
	$("#south .card").animate({marginLeft: "-="+stacksize});
	$("#south").animate({paddingLeft: "+="+stacksize});
	stacked = true;
}

function flipcards(deck){
	if (!flippedback){
		$("#"+deck+" .card-back").css("visibility","visible");
		flippedback=true;
	}
	else{
		$("#"+deck+" .card-back").css("visibility","hidden");
		flippedback=false;
	}	
}

function toggletoolbar(){
	if (toolbarviz){
		$("#toolbar").animate({top: "+="+83});
		toolbarviz=false;
	}
	else{
		$("#toolbar").animate({top: "-="+83});
		toolbarviz=true;
	}
}

function sortcards(){
	var $cards = $('#south'),
	$card = $cards.children('div.card');

	$card.sort(function(a,b){
	var an = parseInt(a.getAttribute('data-val')),
		bn = parseInt(b.getAttribute('data-val'));

	if(an > bn) {
		return 1;
	}
	if(an < bn) {
		return -1;
	}
	return 0;
});

$card.detach().appendTo($cards);
	
	
}

$("#stacker").click(function(){
	if ($(this).hasClass("stack-open")){
		stack("south");
	}
	else {
		unstack("south");
	}
});

$("#clearer").click(function(){cleardeck(deck)});
$("#decker").click(function(){
	unstack("south");
	cleardeck(deck);
	newdeck();
	});
$("#flipper").click(function(){flipcards("#south")});
$("#toggle-toolbar").click(function(){toggletoolbar()});
$("#sorter").click(function(){sortcards()});

/*$("#south").sortable({
	sort:function(event,ui){ui.item.addClass("drag-shadow");},
	stop:function(event,ui){ui.item.removeClass("drag-shadow").css({"margin-top":0});}
	});*/
$( "#resizer" ).slider({min:9,max:15,value:12, slide: function(event, ui){$("#south").css("font-size", ui.value/10+"em");}});

