<?php
session_start();
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title> Not Connect 4 </title>
		<link href="css/style.css" type="text/css" rel="stylesheet" />
		<script src="js/jquery-3.2.0.js"></script>
	</head>
	<body>
		<header>
			<h1> Definitely Not Connect 4 </h1>
		</header>
		<canvas id="myCanvas" width="700" height="600" style="border:10px solid #bcbcbc;"> </canvas>
		<script>

var conn = new WebSocket('ws://150.252.118.208:10000');
conn.onopen = function(e) {
  console.log("Connection established!");
};

conn.onmessage = function(e) {
	if(e.data >= 0 || e.data < 10){
		otherPlay(e.data)
  		console.log(e.data);
	}
	else{
		console.log()
	}
};
function send(X) {
  console.log("send begin: " + X );
  	conn.send( X );
  console.log("send end");
}

var canvas = document.getElementById("myCanvas");
var context = canvas.getContext("2d");
var photo = new Image();
photo.onload = function() {
    context.drawImage(photo,0,0,700,600);
}       
photo.src ="img/background2.png";

var message;
function getMousePos(canvas, evt) {
    var rect = canvas.getBoundingClientRect();
    return {
      x: evt.clientX - rect.left,
      y: evt.clientY - rect.top
    };
}

// var canvas = document.getElementById('myCanvas');
// var context = canvas.getContext('2d');
canvas.addEventListener('mousemove', function(evt) {
	var mousePos = getMousePos(canvas, evt);
	var message = 'Mouse position: ' + mousePos.x + ',' + mousePos.y;
});

var currentplayer = "blue";
var player = 1;
var otherplayer = 2;

var width = 7, height = 6; 
var pieces = [
    [0, 0, 0, 0, 0, 0, 0],
    [0, 0, 0, 0, 0, 0, 0],
    [0, 0, 0, 0, 0, 0, 0],
    [0, 0, 0, 0, 0, 0, 0],
    [0, 0, 0, 0, 0, 0, 0],
    [0, 0, 0, 0, 0, 0, 0]
];

$("#myCanvas").click(function(e){

    if(player == 1){            
        var x = Math.floor((e.pageX-$("#myCanvas").offset().left) / 100);
        var y;

        for(var i = 5; i >=0; i-- ){
            if(pieces[i][x] == 0){
                pieces[i][x] = 1;
                y=i;
                break;
            }
        }

        context.fillStyle = "rgb(0,0,255)";
        context.fillRect(x*100, y*100, 100, 100);
        conn.send( x );

        console.log(x,y);
        var win = chkWinner( pieces );
        if(win == player){
            alert("YOU WIN");                
            location.reload();
        }
        player = 2;
        otherplayer = 1;
    }
});

function otherPlay(X){

	var canvas = document.getElementById('myCanvas');
	var context = canvas.getContext('2d');

    var x = X;
    var y;

    for(var i=5; i >=0; i--){
    	console.log(pieces[i][x]);
        if(pieces[i][x] == 0){
            pieces[i][x] = 2;
            y=i;
            break;
        }
    }

    context.fillStyle = "rgb(255,0,0)";
    context.fillRect(x*100, y*100, 100, 100);

    console.log(x,y);

    var win = chkWinner2( pieces );
    if(win == player){
        alert("YOU LOSE!");
        location.reload();
    }

    player = 1;
    otherplayer = 2;
};

function chkLine(a,b,c,d,e) {
    // Check first cell non-zero and all cells match
    return ((a != 0) && (a == b) && (a == c) && (a == d) && (a==e));
}

function chkWinner(bd) {
// Check down
    for (r = 0; r < 3; r++)
        for (c = 0; c < 7; c++)
            if (chkLine(bd[r][c], bd[r+1][c], bd[r+2][c], bd[r+3][c]v, bd[r+4][c]))
                return bd[r][c];
// Check right
    for (r = 0; r < 6; r++)
        for (c = 0; c < 4; c++)
            if (chkLine(bd[r][c], bd[r][c+1], bd[r][c+2], bd[r][c+3], bd[c][r+4]))
                return bd[r][c];
// Check down-right
    for (r = 0; r < 3; r++)
        for (c = 0; c < 4; c++)
            if (chkLine(bd[r][c], bd[r+1][c+1], bd[r+2][c+2], bd[r+3][c+3], bd[r+4][c+4]))
                return bd[r][c];
// Check down-left
    for (r = 3; r < 6; r++)
        for (c = 0; c < 4; c++)
            if (chkLine(bd[r][c], bd[r-1][c+1], bd[r-2][c+2], bd[r-3][c+3], bd[r-4][c+4]))
                return bd[r][c];
    return 0;
}

function chkLine2(a,b,c,d) {
    return ((a == 2) && (a == b) && (a == c) && (a == d));
}

function chkWinner2(bd) {
    for (r = 0; r < 3; r++)
        for (c = 0; c < 7; c++)
            if (chkLine2(bd[r][c], bd[r+1][c], bd[r+2][c], bd[r+3][c]v, bd[r+4][c]))
                return bd[r][c];
    for (r = 0; r < 6; r++)
        for (c = 0; c < 4; c++)
            if (chkLine2(bd[r][c], bd[r][c+1], bd[r][c+2], bd[r][c+3], bd[c][r+4]))
                return bd[r][c];
    for (r = 0; r < 3; r++)
        for (c = 0; c < 4; c++)
            if (chkLine2(bd[r][c], bd[r+1][c+1], bd[r+2][c+2], bd[r+3][c+3], bd[r+4][c+4]))
                return bd[r][c];
    for (r = 3; r < 6; r++)
        for (c = 0; c < 4; c++)
            if (chkLine2(bd[r][c], bd[r-1][c+1], bd[r-2][c+2], bd[r-3][c+3], bd[r-4][c+4]))
                return bd[r][c];
    return 0;
}
		</script>
	</body>
</html>