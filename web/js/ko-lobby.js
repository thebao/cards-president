// Cancel first modals trigger
var modFix = 0;


var client = new Faye.Client('http://192.168.0.40:3000/', {timeout: 1});
$(document).ready(function(){

    function genRemoveRoute(item) {
        return Routing.generate('ja_cards_removegame', { id: item });
    }

    function Player(data){
        var self = this;
        self.id = data.id;
        self.name = data.name;

    }

    function Game(data) {
        var self = this;
        self.id = data.id;
        self.uniqueId = data.uniqueId;
        self.maxPlayers = data.maxPlayers;
        self.players = ko.observableArray(data.players);
        self.private = data.private;
        self.chat = data.chat;
        self.owner = data.owner;
        self.name = data.name;
        self.volts = data.volts;
        self.amps = data.amps;
        self.type = data.type;
        self.length = data.length;
        self.imageUrl = data.imageUrl;
        self.snippet = data.snippet;
        self.remRoute = genRemoveRoute(data.id);
    }

    function LobbyViewModel() {
        var self = this;
        self.queueing = ko.observable(false);
        self.queuedGame = ko.observable(
            {
                id: "",
                owner: "",
                players: ko.observableArray([]),
                maxPlayers: ""

            }
        );
        self.me = ko.observable(
            {
                id: configuration.user.id,
                name: configuration.user.name
            }
        )
        self.games = ko.observableArray([]);
        self.players = ko.observableArray([]);
        $.getJSON(configuration.getGameUrl, function(allData) {
            var mappedTasks = $.map(allData, function(item) { return new Game(item); });
            self.games(mappedTasks);
        });
        $.getJSON(configuration.getPlayersUrl, function(allData) {
            var mappedTasks = $.map(allData, function(item) { return new Player(item); });
            self.players(mappedTasks);
        });

        self.currentFilter = ko.observable();


        self.filteredGames = ko.computed(function() {
            if(!self.currentFilter() || self.currentFilter() == "all") {
                return self.games();
            } else {
                return ko.utils.arrayFilter(self.games(), function(game) {
                    return game.type == self.currentFilter();
                });
            }
        });

        self.filterType = ko.observable("all");
        this.filterType.subscribe(function(newValue){
            this.currentFilter(newValue);
        }, this);

        self.manageGame = function(game){
            if(self.queueing()){
                self.unqueue();
            }
            self.queue(game);
        }

        self.queue = function(game){
            self.queuedGame(game);
            self.queueing(true);
            var publication = client.publish('/lobby', {game: game, player: self.me(), action: 'join'});
            publication.then(function() {
            });
        }

        self.unqueue = function(game){
            self.queueing(false);
            console.log(modFix);
            if(modFix==0){

                modFix+=1;
                return;
            }
            var publication = client.publish('/lobby', {game: game, player: self.me(), action: 'leave'});
            publication.then(function() {
            });
        }

        self.addGame = function(item){
            self.games.push(new Game(item));
        }
        self.removeGame = function(game){
            self.games.remove(game);
        }




        if(configuration.waitId){
            alert(configuration.waitId);
            var game = ko.utils.arrayFirst(self.games(), function(game) {
                return game.id === configuration.waitId;
            });
            self.queue(game);
        }
    }
    LobbyViewModel = new LobbyViewModel();
    ko.applyBindings(LobbyViewModel);


    client.subscribe('/lobby', function (message) {
        if(message.action=='join'){
            gameId = message.game.id;
            var game = ko.utils.arrayFirst(LobbyViewModel.games(), function(game) {
                return game.id === gameId;
            });
            game.players.push(message.player);
            flashLine(game.id,"join");
        }
        if(message.action=='leave'){
            gameId = message.game.id;
            var game = ko.utils.arrayFirst(LobbyViewModel.games(), function(game) {
                return game.id === gameId;
            });
            console.log(game.players());
            game.players.remove(function(player) {
                return player.id == message.player.id;
            });
            flashLine(game.id,"leave");
        }
        if(message.action=='remove'){
            console.log(message);
            gameId = message.game;
            LobbyViewModel.games.remove(function(game) {
                return game.id == gameId
            });
        }
        if(message.action=='add'){
            console.log(message);
            LobbyViewModel.games.push(new Game(message.game));
        }
        if(message.action=='message'){
        }
    });


});