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

var canvas = document.getElementById('myCanvas');
var context = canvas.getContext('2d');

canvas.addEventListener('mousemove', function(evt) {
var mousePos = getMousePos(canvas, evt);
var message = 'Mouse position: ' + mousePos.x + ',' + mousePos.y;
});

var currentplayer = "blue";
var player = 1;

var width = 7, height = 6; 
var array = Create2DArray(height,width);

$("#myCanvas").click(function(e){

    if(player == 1){            
        var x = Math.floor((e.pageX-$("#myCanvas").offset().left) / 100);
        var y;

        for(var i = 5; i >=0; i-- ){
            if(array[i][x] == "blank"){
                array[i][x] = "blue";
                y=i;
                break;
            }
        }
        context.fillStyle = "rgb(0,0,255)";
        context.fillRect(x*100, y*100, 100, 100);

        console.log(x,y);
        // var win = check( x, y, currentplayer );
        // if(win == true){
        //     alert("Blue Wins!");
        //     //location.reload();
        // }

        currentplayer = "red";
        player=2;
    }
    else {
        var x = Math.floor((e.pageX-$("#myCanvas").offset().left) / 100);
        var y;
        for(var i=5; i >=0; i-- ){
            if(array[i][x] == "blank"){
                array[i][x] = "red";
                y=i;
                break;
            }
        }
        context.fillStyle = "rgb(255,0,0)";
        context.fillRect(x*100, y*100, 100, 100);

        console.log(x,y);
        // var win = check( x,y,currentplayer );
        // if(win == true){
        //     alert("Red Wins!");
        //     //location.reload();
        // }

        player = 1;
        currentplayer = "blue";
    }

});

// make the array
function Create2DArray(rows,columns) {
    var array = new Array(rows);
    for (var i = 0; i < rows; i++) {
    array[i] = new Array(columns);
        for (var k=0; k<columns; k++){
            array[i][k] = "blank";
        }
    }
    return array;
}

// function check(x, y, playerval) {
//     // check length in each direction
//     var l = 0, b = 0;

//     // top to bottom
//     while( (array[x][y-b] == playerval)  && ((y - b) >= 0)  ) { 
//         l += 1; b += 1; 
//     };

//     b = 0;
//     while( (array[x][y+b] == playerval)  && ((y + b) <= 5) ) { 
//         l += 1; b += 1; 
//     };

//     if ( l >= 4 ) { 
//         return true; 
//     }

//     // left to right
//     l = 0;
//     while( (array[x-b][y] == playerval) && ((x - b) >= 0) ) { 
//         l += 1; b += 1; 
//     };
//     b = 0;
//     while( (array[x+b][y] == playerval) && ((x + b) <= 6) ) { 
//         l += 1; b += 1; 
//     };

//     if ( l >= 4 ) {
//         return true; 
//     }
//     return false;
// }