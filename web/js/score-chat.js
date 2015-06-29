joueur=prompt("Nom du joueur:");
$(document).ready(function(){
    var client = new Faye.Client('http://localhost:3000/');

    client.subscribe('/chat', function (message) {
        if(message.type=="chat")
            $("#chat .cont ul").append("<li class='chat-text "+message.type+"'>"+message.author+": "+message.text+"</li>");
        else
            $("#chat .cont ul").append("<li class='chat-text "+message.type+"'>"+message.text+"</li>");

    });
	$("#chat-form").submit(function(event){
		event.preventDefault();
		msg=$("#chat-text").val();
        var publication = client.publish('/chat', {author: joueur, type:"chat", text:msg});

        publication.then(function() {
            $("#chat-text").val("");
        }, function(error) {
            console.log(error);
        });
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