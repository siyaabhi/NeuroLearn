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

// Shuffle small letters
$smallLetters = array_map(fn($l)=>$l['small'], $letters);
$shuffled = $smallLetters;
shuffle($shuffled);
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Matching Letters — NeuroLearn</title>
<script src="https://cdn.tailwindcss.com"></script>
<script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>
<style>
body {
    font-family: 'Poppins', sans-serif;
    text-align: center;
    background: url('../../kids/engbk.jpg') no-repeat center center fixed;
    background-size: cover;
    color: #fff;
    padding: 40px 10px;
}
h1 {
    font-size: 3.5rem;
    font-weight: 800;
    color: #ff6b6b;
    margin-bottom: 20px;
    text-shadow: 2px 2px 10px rgba(0,0,0,0.5);
}
.container {
    display:flex;
    justify-content: center;
    gap: 60px;
    flex-wrap: wrap;
    margin-top: 30px;
}
.letters, .boxes {
    display:flex;
    flex-direction: column;
    gap: 20px;
}
.letter {
    font-size: 2.5rem;
    font-weight: bold;
    padding: 20px 30px;
    border-radius: 15px;
    background: #ffd6d6;
    color: #ff6b6b;
    cursor: grab;
    user-select: none;
    transition: transform 0.2s;
    display: flex;
    align-items: center;
    justify-content: center;
}
.letter:hover { transform: scale(1.05); }

.box {
    font-size: 2.5rem;
    font-weight: bold;
    padding: 20px 30px;
    border-radius: 15px;
    background: #fff6b2;
    color: #ff6b6b;
    border: 3px dashed #ff6b6b;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: grab;
    user-select: none;
    transition: transform 0.2s, background 0.3s, color 0.3s;
    min-width: 60px;
    min-height: 60px;
}
.box:hover {
    transform: scale(1.1);
    background: #ffe066;
    color: #e05555;
}
.correct {
    background: #6bffb8 !important;
    color: #064635 !important;
    border: 3px solid #064635 !important;
}
button {
    margin-top: 30px;
    padding: 12px 25px;
    border: none;
    border-radius: 12px;
    font-weight: bold;
    background: #ff6b6b;
    color: white;
    cursor: pointer;
    font-size: 1.2rem;
}
button:hover { background: #e05555; }

/* Popup modal */
#popup {
    transition: all 0.3s ease-in-out;
}
</style>
</head>
<body>
<h1>Match Capital & Small Letters 🧩</h1>

<div class="container">
    <div class="letters" id="capitalLetters">
        <?php foreach($letters as $i=>$l): ?>
            <div class="letter" draggable="true" data-letter="<?= $l['small'] ?>"><?= $l['letter'] ?></div>
        <?php endforeach; ?>
    </div>
    <div class="boxes" id="smallBoxes">
        <?php foreach($shuffled as $i=>$s): ?>
            <div class="box" data-letter="<?= $s ?>"><?= $s ?></div>
        <?php endforeach; ?>
    </div>
</div>

<div>
    <button onclick="restartGame()">Restart Game</button>
</div>

<!-- Popup Modal -->
<div id="popup" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
  <div class="bg-white rounded-2xl p-8 shadow-2xl max-w-md text-center">
    <h2 class="text-2xl font-bold text-purple-700 mb-4">🎉 Well Done!</h2>
    <p class="text-gray-700 mb-6">
      You matched all the letters correctly.<br>
      Excellent work!
    </p>
    <button onclick="closePopup()" class="bg-purple-600 hover:bg-purple-700 text-white px-6 py-2 rounded-lg font-semibold">
      Back to Games
    </button>
  </div>
</div>

<script>
let dragged;

// Add random colors to boxes for fun
document.querySelectorAll('.box').forEach((b,i)=>{
    const colors = ['#ffcc66','#66ccff','#ff66d9','#6bffb8','#ff6b6b'];
    b.style.background = colors[i%colors.length];
    b.style.border = `3px dashed ${colors[i%colors.length]}`;
});

document.addEventListener('dragstart', e => {
    if(e.target.classList.contains('letter')) dragged = e.target;
});
document.addEventListener('dragover', e => {
    if(e.target.classList.contains('box')) e.preventDefault();
});
document.addEventListener('drop', e => {
    if(e.target.classList.contains('box')) {
        e.preventDefault();
        if(dragged.dataset.letter === e.target.dataset.letter){
            e.target.classList.add('correct');
            dragged.style.visibility = 'hidden';
            celebrate();
            checkCompletion();
        }
    }
});

function celebrate(){
    confetti({
        particleCount: 50,
        spread: 100,
        origin: { y: 0.6 },
        colors: ['#ff6b6b','#ffcc66','#6bffb8','#66ccff','#ff66d9']
    });
    let utter = new SpeechSynthesisUtterance("Awesome!");
    utter.rate = 0.9;
    utter.pitch = 1.2;
    window.speechSynthesis.speak(utter);
}

function checkCompletion(){
    const all = document.querySelectorAll('.box');
    const done = [...all].every(b=>b.classList.contains('correct'));
    if(done){
        setTimeout(()=> showPopup(), 600);
    }
}

function restartGame(){
    location.reload();
}

function showPopup(){
    document.getElementById("popup").classList.remove("hidden");

    // Burst confetti 🎉
    confetti({
        particleCount: 150,
        spread: 120,
        origin: { y: 0.6 }
    });

    // Voice congratulation
    let utter = new SpeechSynthesisUtterance("Congratulations! You matched all the letters. Excellent work!");
    utter.rate = 0.9;
    utter.pitch = 1.2;
    window.speechSynthesis.speak(utter);
}

function closePopup(){
    window.location.href = 'games.php';
}
</script>
</body>
</html>