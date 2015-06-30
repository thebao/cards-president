$(document).ready(function(){

    var client = new Faye.Client('http://192.168.0.40:3000/', {timeout: 1});
    client.subscribe('/lobby', function (message) {
        if(message.action=='add'){
            game=message.game;
            playerUi = $('*[data-game='+game+']').find("span.player-count");
            playerCount = playerUi.html();
            playerUi.html(parseInt(playerCount)+1);
        }
        if(message.action=='remove'){
            game=message.game;
            playerUi = $('*[data-game='+game+']').find("span.player-count");
            playerCount = playerUi.html();
            playerUi.html(parseInt(playerCount)-1);
        }

    });

    $("#game-list tr.game-row").click(function(){
        if(!$(this).hasClass("queued")){
            unQueue($("#game-list tr.game-row.queued"));
            queue(this);
        }
        else {
            unQueue(this);
        }
    });
    function queue(game){

        gameId=$(game).data('game');
        gameName=$(game).find("td.title").html();
        $(game).animate({backgroundColor: "#00FF7F"}, 1000).addClass('queued');

        var publication = client.publish('/lobby', {game: gameId, player:configuration.userName, action: 'add'});
        publication.then(function() {
            playersIn = $('*[data-game='+gameId+']').find("span.player-count").html();
            playersPot = $('*[data-game='+gameId+']').find("span.player-pot").html();
            if(playersIn==playersPot){
                $('#gameLaunchName').html(gameName);
                count = 2;
                timer = setInterval(function() { handleTimer(); }, 1000);
                $('#launchModal').modal();
            }
        }, function(error) {
        });

    }

    function unQueue(game){
        gameId=$(game).data('game');
        $(game).animate({backgroundColor: "#ffffff"}, 100).removeClass('queued');

        var publication = client.publish('/lobby', {game: gameId, player:configuration.userName, action: 'remove'});
        publication.then(function() {
        }, function(error) {
        });
    }
    function handleTimer() {
        if(count === 0) {
            clearInterval(timer);
            $('#countDown').html(0);
        } else {
            $('#countDown').html(count);
            count--;
        }
    }




})