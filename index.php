<html lang="pl">
<head>
    <title>Viweb - symulacja kolizji</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <link rel="stylesheet" href="/assets/css/style.css" />
    <script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
</head>
<body>
    <div class="menu">
        <button onclick="simulation.move()">Move</button>
        <button onclick="addPlayer('top')">Nowy Top</button>
        <button onclick="addPlayer('bottom')">Nowy Bottom</button>
    </div>

    <div class="simulate-box" id="street">
        <div class="street top" id="top_street">

        </div>
        <div class="street bottom" id="bottom_street">

        </div>
    </div>

    <script>

        var simulation = {
            count: 0,
            maxPlayers: 10,
            addPlayer: function(type){
                var max = $('.player').length;
                var time = 1000 * this.rng(10,20);
                if(type === 'top'){
                    var street = $('#top_street');
                    var playerClass = "player top";
                }else{
                    var street = $('#bottom_street');
                    var playerClass = "player";
                }
                if(max < this.maxPlayers){
                    this.count++;
                    street.append("<div class='"+ playerClass +"' id='player_"+ this.count +"' data-time='"+time+"'></div>");
                    return $('#player_' + this.count);
                }
            },
            move: function() {
                var maxWidth = $('#street');
                setInterval(function(){
                    var player;
                    if(true){
                        if(simulation.checkExist('top')){
                            player = simulation.addPlayer('top');
                            simulation.moveThis(player, 'top');
                        }
                    }else{
                        player = simulation.addPlayer('bottom');
                        simulation.moveThis(player, 'bottom');
                    }
                }, 1000);
            },
            animateAgain: function(player, time){
                var maxWidth = $('#street');
                var players = $('.player');
                $(player).css({ 'left': '' }).animate({
                    'right' : maxWidth.width(),
                }, {
                    duration: time,
                    step: function( now, fx ) {
                        for(var i = 0;i < players.length; i++){
                            if($(player).attr('id') !== $(players[i]).attr('id')){
                                var actual = $(this).offset();
                                var postion = $(players[i]).offset();
                                if((actual.left < postion.left+30) && (actual.left > postion.left)) {
                                    $(this).stop();
                                    var newDuration = $(players[i]).data("time");
                                    $(player).animate({'right' : maxWidth.width() - actual.left-30-1}, {
                                        duration : 1000,
                                        complete: function() {
                                            simulation.animateAgain(this, newDuration);
                                        },
                                    });
                                }
                            }
                        }
                    },
                    complete: function() {
                        this.remove();
                    }
                });
            },
            moveThis: function (player, type) {
                var maxWidth = $('#street');
                var players = $('.player');
                var time = $(player).data("time");
                if(type === 'top'){
                    var animationCss = { 'right': '-30px', 'left': '' };
                    $(player).css(animationCss).animate({
                        'right' : maxWidth.width(),
                    }, {
                        duration: time,
                        step: function( now, fx ) {
                            for(var i = 0;i < players.length; i++){
                                if($(player).attr('id') != $(players[i]).attr('id')){
                                    var actual = $(this).offset();
                                    var postion = $(players[i]).offset();
                                    if((actual.left < postion.left+30) && (actual.left > postion.left-30)) {
                                        $(this).stop();
                                        var newDuration = $(players[i]).data("time");
                                        console.log("tak");
                                        simulation.animateAgain(this, newDuration);
                                        /*$(this).animate({'right' : maxWidth.width()}, newDuration, function() {
                                            this.remove();
                                        });*/
                                    }
                                }
                            }
                        },
                        complete: function() {
                            this.remove();
                        }
                    });
                }else{
                    $(player).css({ 'right': '', 'left': '-30px' }).animate({
                        'left' : maxWidth.width(),
                    }, {
                        duration: time,
                        step: function( now, fx ) {
                            for(var i = 0;i < players.length; i++){
                                if($(player).attr('id') != $(players[i]).attr('id')){
                                    var actual = $(this).offset();
                                    var postion = $(players[i]).offset();
                                    if((actual.left < postion.left+30) && (actual.left > postion.left-30)) {
                                        $(this).stop();
                                        var newDuration = $(players[i]).data("time");
                                        console.log("nie");
                                        $(this).animate({'left' : maxWidth.width(),}, newDuration, function() {
                                            this.remove();
                                        });
                                    }
                                }
                            }
                        },
                        complete: function() {
                            this.remove();
                        }
                    });
                }
            },
            rng: function (min, max) {
                return Math.floor(Math.random() * (max - min + 1)) + min;
            },
            checkExist: function(type){
                var players = $('.player');
                for(var i = 0;i < players.length; i++){
                    var place = $(players[i]).offset();
                    if(type === 'top' && place.left > 1800 && $(players[i]).hasClass( "top" )){
                        return 0;
                    }
                    if(type === 'bottom' && place.left > 30 && !$(players[i]).hasClass( "top" )){
                        return 0;
                    }
                }
                return 1;
            }
        };
    </script>
</body>
</html>