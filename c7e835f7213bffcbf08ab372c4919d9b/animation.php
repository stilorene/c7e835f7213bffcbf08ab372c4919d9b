<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    


<div class="circle"></div>
<div class="circle"></div>
<div class="circle"></div>
<div class="circle"></div>
<div class="circle"></div>
<div class="circle"></div>
<div class="circle"></div>
<div class="circle"></div>





<style>

.circle{
        position: absolute;
        height: 24px;
        width: 24px;
        border-radius: 24px;
        background-color: white;
        top: 0;
        left: 0;
        
    }

</style>

<script>
const coords = {x: 0, y: 0};
const circles = document.querySelectorAll(".circle");

const colors = ['#0c0a5c', '#530762', '#811264', '#a82b63', '#c84960', '#e16b5f', '#f39062', '#ffb56b'];

circles.forEach(function (circle, index) {
    circle.x = 100;
    circle.y = 100;
    circle.style.backgroundColor = colors[index % colors.length];
});

window.addEventListener("mousemove", function(e) {
    coords.x = e.clientX;
    coords.y = e.clientY;

    
});

function animateCircles() {
    let x = coords.x;
    let y = coords.y; 

    circles.forEach(function (circle, index) {
        circle.style.left = x + "px";
        circle.style.top = y + "px";

        circle.style.scale = (circles.length -  index )/ circles.length;

        circle.x = x;
        circle.y = y;

        const nextCircle = circles[index + 1] || circles[0]; // Korrigierte Zeile
        x += (nextCircle.x - x + window.scrollX) * 0.3 ;
        y += (nextCircle.y - y + window.scrollY) * 0.3; // Korrigierte Zeile
    });

    requestAnimationFrame(animateCircles);
}

animateCircles();
</script>
</body>
</html>