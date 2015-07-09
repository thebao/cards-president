rowColor = "#5C5C5C";
activeRowColor = "#41A773";
n=0;
hiddenAdder = '<div class="hidden gameChanged" style="position:absolute;bottom:24px;left:50px;font-size:0;color:#303030;">+1</div>';

function flashLine(line){
    $(line).find('.players').append(hiddenAdder);
    gCh = $(line).find('.gameChanged');
    $(gCh).toggleClass('hidden');
    $(gCh).animate({
        opacity: 0,
        top: "-=150",
        left: "-=150",
        fontSize: "15em"

    }, 800, function() {
        $(gCh).remove();
    });
    count=0
    var color = $().css('backgroundColor');
    var backgroundInterval = setInterval(function(){
        $(line).toggleClass("flash");
        count++;
        if(count==2)
            clearInterval(backgroundInterval);
    },400);
}

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
        if(message.action=='message'){
        }
    });

    $("#test").click(function(){
        flashLine(".game-row:nth("+n+")");
        n++;
        if(n==4)
            n=0;

    });

    $("#game-list tr.game-row").click(function(){
        alert(bao);
        if(!$(this).hasClass("queued")){
            unQueue($("#game-list tr.game-row.queued"));
            queue(this);
        }
        else {
            unQueue(this);
        }
    });

    function queue(game){
        flashLine(game);

        gameId=$(game).data('game');
        gameName=$(game).find("td.title").html();
        $(game).addClass('queued');

        var publication = client.publish('/lobby', {game: gameId, player:configuration.userName, action: 'add'});
        publication.then(function() {
            //$('#launchModal').modal();
            $('#launchModal').on('hidden.bs.modal', function (e) {
                unQueue(game);
            });

        }, function(error) {});
    }

    function unQueue(game){
        gameId=$(game).data('game');
        $(game).removeClass('queued');

        var publication = client.publish('/lobby', {game: gameId, player:configuration.userName, action: 'remove'});
        publication.then(function() {
        }, function(error) {});
    }
});