rowColor = "#5C5C5C";
activeRowColor = "#41A773";
n=0;
hiddenAdder = '<div class="hidden gameChanged" style="position:absolute;bottom:24px;left:50px;font-size:0;color:#303030;">+1</div>';
hiddenRemover = '<div class="hidden gameChanged" style="position:absolute;bottom:24px;left:50px;font-size:0;color:#303030;">-1</div>';

function flashLine(game,action){
    line = $("tr[data-game='"+game+"']");
    if(action=="join"){
        $(line).find('.players').append(hiddenAdder);
        $class = "flash";
    }
    if(action=="leave"){
        $(line).find('.players').append(hiddenRemover);
        $class = "flash-neg";
    }
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
        $(line).toggleClass($class);
        count++;
        if(count==2)
            clearInterval(backgroundInterval);
    },400);
}

$(document).ready(function(){


    $("#test").click(function(){
        flashLine(".game-row:nth("+n+")");
        n++;
        if(n==4)
            n=0;

    });
    $("#cancelQueue").click(function(){

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