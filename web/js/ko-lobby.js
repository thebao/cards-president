// Class to represent a row in the seat reservations grid
$(document).ready(function(){

    function genRemoveRoute(item) {
        return Routing.generate('ja_cards_removegame', { id: item });
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
        $.getJSON(configuration.getGameUrl, function(allData) {
            var mappedTasks = $.map(allData, function(item) { return new Game(item); });
            self.games(mappedTasks);
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
            game.players.push(self.me());
            self.queuedGame(game);
            self.queueing(true);
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



});