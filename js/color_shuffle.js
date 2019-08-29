var cArray = ['rgba(50, 172, 209, 0.3)', 'rgba(50, 93, 209, 0.3)', 'rgba(50, 209, 166, 0.3)', 'rgba(209, 87, 50, 0.1)', 'rgba(172, 209, 50, 0.1)', 'rgba(209, 50, 172, 0.1)', 'rgba(50, 172, 209, 0.3)'];
var rand = cArray[Math.floor(Math.random() * cArray.length)];

$("body").css("background-color", rand);
