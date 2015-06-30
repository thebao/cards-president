//joueur=prompt("Nom du joueur:");
joueur=configuration.userName;
$(document).ready(function(){
    commands = ["ping", "help"];
    chatInputHistory = [];
    newMessages = 0;
    if(configuration.scrollPause){
        $("#tog-scroll").toggleClass("fa-pause").toggleClass("fa-play");
    }

    var client = new Faye.Client('http://192.168.0.40:3000/', {timeout: 1});
    var connCrashed = false;
    var n=0;

    client.subscribe('/chat', function (message) {
        if(message.type=="chat")
            $("#chat .cont ul").append("<li class='chat-text "+message.type+"'>"+message.author+": "+parseSmilies(message.text)+"</li>");
        else
            $("#chat .cont ul").append("<li class='chat-text "+message.type+"'>"+message.text+"</li>");

        if(!configuration.scrollPause){
            $("#chat .cont").animate({ scrollTop: $("#chat .cont")[0].scrollHeight}, 1000);
        }
        if($("#tog-chat").hasClass("fa-arrow-up")){
            newMessages++;
            if(newMessages>0){
                $("#new-msg").removeClass("hidden").html(newMessages);
            }
        }

    });

    client.subscribe('/'+configuration.userCred, function (message) {
        console.log(message)
    });

    client.on('transport:down', function() {
        connCrashed=true;
        $("#chat .cont ul").append("<li class='chat-text error'>Server is down =(</li>");
        runRetryLoop();
    });
    client.on('transport:up', function() {
        if(connCrashed){
            $("#chat .cont ul").append("<li class='chat-text notif'>Server is Backup =D</li>");
            connCrashed=false;
        }
    });
    function runRetryLoop(){
        n=1;
        setInterval(function(){
            if(!connCrashed)
                return;

            $("#chat .cont ul").append("<li class='chat-text error'>Retrying connection: Attempt #"+n+"</li>");
            n++;
        }, 5000);
    }
	$("#chat-form").submit(function(event){
		event.preventDefault();
		msg=$("#chat-text").val();
        n=1;
        if(msg.substring(0,1)=="/"){
            checkCommand(msg);
            $("#chat-text").val("");
            chatInputHistory.push(msg);
            return;
        }
        if(msg=="")
            return;
        var msg = msg.replace(/(<([^>]+)>)/ig,"");
        var publication = client.publish('/chat', {author: joueur, type:"chat", text:msg});

        publication.then(function() {
            $("#chat-text").val("");
            $(".smiley-table").addClass('hidden');
            chatInputHistory.push(msg);
            if (chatInputHistory.length>20)
                chatInputHistory.splice(0,1);
        }, function(error) {
            console.log(error);
        });
		return false;
	});
    $('#chat-form').bind('keydown', function(event) {
        if(event.keyCode == 38){
            $("#chat-text").val(chatInputHistory[chatInputHistory.length-n]);
            n++;
        }
        if(event.keyCode == 40){
            n=1;
            $("#chat-text").val(chatInputHistory[chatInputHistory.length-n]);
        }
    });
    $("#tog-chat").click(function(){
        if($(this).hasClass("fa-arrow-down")){
            $("#chat-wrapper").hide();
            $("#chat").css("height","auto");
        }
        else {
            newMessages=0;
            $("#new-msg").addClass('hidden');
            $("#chat-wrapper").show();
            $("#chat").css("height","50%");
        }
        $(this).toggleClass("fa-arrow-down").toggleClass("fa-arrow-up");
    })
    $("#tog-scroll").click(function(){
        if($(this).hasClass("fa-play")){
            $(this).attr('title','Auto-scroll');
            configuration.scrollPause=false;
        }
        else{
            $(this).attr('title','Pause scroll');
            configuration.scrollPause=true;
        }
        $(this).toggleClass("fa-play").toggleClass("fa-pause");
    });
    function checkCommand(text){
        command = text.substring(1,text.length)
        if(commands.indexOf(command)!=-1){
            if(command=="ping"){
                ping = new Date().getTime();
                $.post(configuration.pingUrl, function(data, status){
                }).done(function() {
                    pong = new Date().getTime();
                    pingPong = pong-ping;
                    console.log(ping);
                    console.log(pong);
                    $("#chat .cont ul").append("<li class='chat-text notif'>PING server time="+pingPong+"</li>");
                });
            }
        }
        else {
            $("#chat .cont ul").append("<li class='chat-text error'>Command \""+command+"\" unknown...</li>");
        }
    }
});


function appendscore(play){
	number=play.length;
	first=play[0]
	cards=[];
	for (i=0;i<play.length;i++){
		cards.push($(play[i]).attr("data-name"));
	}
	text=joueur+" a jou&eacute; "+cards.join(" ");
	$("#chat .cont ul").append("<li class='move-text'>"+text+"</li>");
}