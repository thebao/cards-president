$(document).ready(function(){
	var DELAY = 700, clicks = 0, timer = null;
	$("#play-button").click(function(){checkmove();});
	$(".close-rev").click(function(){$("#revolution").addClass('hide');});
});

cardsselected=0;

revolution_allowed=true;
revolution_active=false;
revolution_needed=4;

first_round=true;
last_play=[];

function collapseothers(){
	
}

function activateSelectable(){
    $("#south .card").addClass("selectable");
    $("#south .card").on("click", function(e){
        if ($(this).attr("data-potential")=="yes")
            handleselect(this);
    });

}
function selectme(card){
	cardsselected++;
	$(card).attr("data-state","on");
	val=$(card).attr("data-val");
	$(card).css({"margin-top": "-4em"});
    $("#play-button").removeClass("hide");
	$("#south .card").each(function(i,v){
		if ($(this).attr("data-val")!=val && $(this).attr("data-val")!=15 && val!=15){
			$(this).addClass("gray-card")
			$(this).attr("data-potential","no");
		}
	});
}

function releaseme(card){
	cardsselected--;
	if (cardsselected==0){
		$("#south .card").removeClass("gray-card");
		$("#south .card").attr("data-potential","yes");
		$("#play-button").addClass("hide");
	}
	$(card).attr("data-state","off");
	$(card).css({"margin-top": 0});
}

function handleselect(card){
	if ($(card).attr("data-state")=="off"){
		selectme(card);
	}
	else {
		releaseme(card);
	}
}

function randomangle(){
	return Math.round(Math.random()*28-14);
}

function checkmove(){
    play=[];
    cardIds=[];
    $("#south .card").each(function(i,v){
        if ($(this).attr("data-state")=="on"){
            play.push(this);
            cardIds.push($(this).attr("uid"));
        }
    });


    $.post(configuration.cardCheckUrl, {cards:cardIds, gameid:gameId}, function(data, status){
        if(data.status=="error"){
            alert(data.error);
        }
        else if(data.status=="ok"){
            execmove(play);
        }
    });

}

function execmove(play){
	first_round=false;
    cardIds=[];
	if (cardsselected==revolution_needed&&revolution_allowed){
		$("#revolution").removeClass("hide");
	}
	$("#flop").empty();
	$(play).each(function(i,v){
		if ($(this).attr("data-state")=="on"){
			$(this).appendTo("#flop");
			play.push(this);
            cardIds.push($(this).attr("uid"));
			$(this).css({ WebkitTransform: 'rotate(' + randomangle() + 'deg)'});
			$(this).css({ '-moz-transform': 'rotate(' + randomangle() + 'deg)'});
			$(this).attr("data-potential","no");
			$("#south .card").removeClass("gray-card");
			$("#south .card").attr("data-potential","yes");
			$("#play-button").addClass("hide");
		}
	});


	last_play=play.slice(0);
	cardsselected=0;
			
}