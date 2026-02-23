<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../../login.php");
    exit();
}

// Load alphabet JSON
$alphabet = json_decode(file_get_contents(__DIR__ . '/data/alphabet.json'), true);

// Pick 5 random letters
$letters = [];
$indexes = array_rand($alphabet, 5);
foreach ($indexes as $i) {
    $letters[] = $alphabet[$i];
}
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Tracing Game — NeuroLearn</title>
<script src="https://cdn.tailwindcss.com"></script>
<script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>
<style>
body {
    font-family: 'Poppins', sans-serif;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: flex-start;
    min-height: 100vh;
    margin: 0;
    background: url('../../kids/engbk.jpg') no-repeat center center fixed;
    background-size: cover;
    color: #fff;
    padding-top: 50px;
    text-align: center;
}
body::before {
    content: "";
    position: fixed; top:0; left:0; right:0; bottom:0;
    background: rgba(0,0,0,0.3); z-index:-1;
}
h1 {
    font-size: 4rem; 
    font-weight: 800;
    margin-bottom: 1rem;
    color: #ff6b6b;
    text-shadow: 2px 2px 10px rgba(0,0,0,0.5);
}
p { font-size: 1.5rem; margin-bottom: 2rem; }
canvas {
    border: 4px dashed #fff;
    border-radius: 15px;
    background: rgba(255,255,255,0.1);
    margin-top: 20px;
    touch-action: none;
}
button {
    margin-top: 20px;
    padding: 12px 25px;
    border: none;
    border-radius: 12px;
    font-weight: bold;
    background: #ff6b6b;
    color: white;
    cursor: pointer;
    font-size: 1.1rem;
}
button:hover { background: #e05555; }
</style>
</head>
<body>
<h1>Trace the Letters ✍</h1>
<p>Follow the letter shapes! Complete all 5 letters.</p>

<canvas id="tracingCanvas" width="400" height="400"></canvas>
<div>
    <button onclick="nextLetter()">Next Letter →</button>
</div>

<!-- Popup Modal -->
<div id="popup" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
  <div class="bg-white rounded-2xl p-8 shadow-2xl max-w-md text-center">
    <h2 class="text-2xl font-bold text-purple-700 mb-4">🎉 Congratulations!</h2>
    <p class="text-gray-700 mb-6">
      You have successfully completed all the tracing letters.<br>
      Keep up the great learning!
    </p>
    <button onclick="closePopup()" class="bg-purple-600 hover:bg-purple-700 text-white px-6 py-2 rounded-lg font-semibold">
      Back to Games
    </button>
  </div>
</div>

<script>
let letters = <?= json_encode($letters); ?>;
let index = 0;

const canvas = document.getElementById('tracingCanvas');
const ctx = canvas.getContext('2d');
let drawing = false;

function showLetter() {
    ctx.clearRect(0,0,canvas.width,canvas.height);
    let letter = letters[index];
    ctx.font = "bold 200px Arial";
    ctx.textAlign = "center";
    ctx.textBaseline = "middle";
    ctx.fillStyle = "rgba(255,255,255,0.3)";
    ctx.fillText(letter.letter, canvas.width/2, canvas.height/2);
}
showLetter();

// Drawing events
canvas.addEventListener('mousedown', () => drawing = true);
canvas.addEventListener('mouseup', () => { drawing = false; celebrate(); });
canvas.addEventListener('mouseleave', () => drawing = false);
canvas.addEventListener('mousemove', draw);
canvas.addEventListener('touchstart', e => { drawing=true; drawTouch(e); });
canvas.addEventListener('touchend', () => { drawing=false; celebrate(); });
canvas.addEventListener('touchmove', e => { drawTouch(e); e.preventDefault(); });

function draw(e){
    if(!drawing) return;
    const rect = canvas.getBoundingClientRect();
    ctx.fillStyle = '#ffcc66';
    ctx.beginPath();
    ctx.arc(e.clientX - rect.left, e.clientY - rect.top, 10, 0, Math.PI*2);
    ctx.fill();
}

function drawTouch(e){
    if(!drawing) return;
    const rect = canvas.getBoundingClientRect();
    for(let touch of e.touches){
        ctx.fillStyle = '#ffcc66';
        ctx.beginPath();
        ctx.arc(touch.clientX - rect.left, touch.clientY - rect.top, 10, 0, Math.PI*2);
        ctx.fill();
    }
}

function nextLetter(){
    index++;
    if(index >= letters.length){
        showPopup();
        return;
    }
    showLetter();
}

function celebrate(){
    confetti({
        particleCount: 40,
        spread: 80,
        origin: { y: 0.6 },
        colors: ['#ff6b6b','#ffcc66','#6bffb8','#66ccff','#ff66d9']
    });
}

function showPopup() {
    document.getElementById("popup").classList.remove("hidden");

    // Confetti burst
    confetti({
        particleCount: 150,
        spread: 120,
        origin: { y: 0.6 }
    });

    // Voice feedback
    let utter = new SpeechSynthesisUtterance("Congratulations! You have completed all the tracing letters. Keep up the great learning!");
    utter.rate = 0.9;
    utter.pitch = 1.2;
    window.speechSynthesis.speak(utter);
}

function closePopup() {
    window.location.href = 'games.php';
}
</script>
</body>
</html>