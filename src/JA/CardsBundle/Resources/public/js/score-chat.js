joueur="Th&eacute;o";
$(document).ready(function(){
	$("#chat-form").submit(function(event){
		event.preventDefault();
		text=joueur+": "+$("#chat-text").val();
		$("#chat .cont ul").append("<li class='chat-text'>"+text+"</li>");
		$("#chat-text").val("");
		return false;
	});
});


function appendscore(play){
	number=play.length;
	alert
	first=play[0]
	cards=[];
	for (i=0;i<play.length;i++){
		cards.push($(play[i]).attr("data-name"));
	}
	text=joueur+" a jou&eacute; "+cards.join(" ");
	$("#chat .cont ul").append("<li class='move-text'>"+text+"</li>");
}