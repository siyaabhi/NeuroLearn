<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../../login.php");
    exit();
}

// Load alphabet JSON
$alphabet = json_decode(file_get_contents(__DIR__ . '/data/alphabet.json'), true);
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Learn English Alphabet — NeuroLearn</title>
<script src="https://cdn.tailwindcss.com"></script>
<style>
body {
    font-family: 'Poppins', sans-serif;
    text-align: center;
    padding: 30px;
    background: url('../../kids/engbk.jpg') no-repeat center center fixed;
    background-size: cover;
    color: #fff;
}
body::before {
    content: "";
    position: fixed;
    top:0; left:0; right:0; bottom:0;
    background: rgba(0,0,0,0.3);
    z-index:-1;
}
#content-wrapper {
    display:flex; 
    flex-direction:column; 
    align-items:center; 
    justify-content:center;
}
#letter-display {
    font-size:4rem; 
    font-weight:bold; 
    text-shadow:2px 2px 5px rgba(0,0,0,0.5);
    animation: bounce 0.5s;
    margin-bottom: 15px;
}
@keyframes bounce {
  0% { transform: translateY(0); }
  50% { transform: translateY(-15px); }
  100% { transform: translateY(0); }
}
#image {
    width:50%; max-width:300px; height:auto; border-radius:12px; margin-top:10px;
    animation: fadeIn 0.5s;
}
@keyframes fadeIn { from {opacity:0} to {opacity:1} }
button {
    padding:12px 25px; margin:10px; border:none; border-radius:10px;
    cursor:pointer; background:#ff6b6b; color:white; font-weight:bold;
    transition: background 0.3s;
}
button:hover { background:#e05555; }
#progress-container {
    width:80%; height:15px; background:rgba(255,255,255,0.3); margin:20px auto; border-radius:10px;
}
#progress-bar {
    width:0%; height:100%; background:#ff6b6b; border-radius:10px; transition:width 0.3s;
}
@media screen and (max-width:600px){
    #letter-display { font-size:3rem; }
    #image { width:70%; max-width:250px; }
    button { padding:10px 18px; font-size:0.9rem; }
}
#confetti-canvas {
    position: fixed;
    top:0; left:0; width:100%; height:100%; pointer-events:none; z-index:9999;
}
#post-video-choice {
    display:none; 
    margin-top:40px; 
    text-align:center;
}
.choice-btn {
    padding: 15px 25px;
    font-size: 1.2rem;
    border: none;
    border-radius: 12px;
    cursor: pointer;
    color: white;
    transition: transform 0.3s;
}
.choice-btn:hover { transform: translateY(-5px); }
.choice-learn { background:#ff6b6b; }
.choice-games { background:#2fbdb9; }
</style>
</head>
<body>
<h1 class="text-4xl font-bold mb-4">Learn the English Alphabet</h1>
<p class="mb-6 text-lg italic">Say with me! Learn both capital and small letters A–Z.</p>

<div id="content-wrapper">
    <div id="letter-display"></div>
    <img id="image" src="" alt="Letter Image">
</div>

<div>
    <button onclick="prevLetter()">← Previous</button>
    <button onclick="playAudio()">🔊 Listen</button>
    <button onclick="nextLetter()">Next →</button>
</div>

<div id="progress-container">
    <div id="progress-bar"></div>
</div>

<canvas id="confetti-canvas"></canvas>

<!-- Post-video choice (hidden initially) -->
<div id="post-video-choice">
    <h2 style="font-size:2rem; font-weight:bold; margin-bottom:20px;">Great Job! 🎉</h2>
    <p style="font-size:1.1rem; margin-bottom:30px;">What would you like to do next?</p>
    <div style="display:flex; justify-content:center; gap:40px; flex-wrap:wrap;">
        <button onclick="location.href='select_subject.php'" class="choice-btn choice-learn">Continue Learning 📚</button>
        <button onclick="location.href='games.php'" class="choice-btn choice-games">Play Games 🎮</button>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>
<script>
let alphabet = <?= json_encode($alphabet); ?>;
let index = 0;
let voices = [];

// Load voices
function loadVoices() {
    voices = window.speechSynthesis.getVoices();
    if(voices.length === 0) {
        window.speechSynthesis.onvoiceschanged = () => { voices = window.speechSynthesis.getVoices(); };
    }
}
loadVoices();

function showLetter(i){
    if(i < 0) i = 0;
    if(i >= alphabet.length){
        document.getElementById('letter-display').innerText = "🎉 Congrats! You completed A–Z!";
        document.getElementById('image').style.display = "none";
        document.getElementById('progress-bar').style.width = "100%";
        launchConfetti();

        // Show ABC Song Video (centered)
        const videoContainer = document.createElement('div');
        videoContainer.style.marginTop = "20px";
        videoContainer.style.display = "flex";
        videoContainer.style.flexDirection = "column";
        videoContainer.style.alignItems = "center";
        videoContainer.style.justifyContent = "center";
        videoContainer.innerHTML = `
            <h2 style="font-size:1.8rem; font-weight:bold; margin-bottom:10px;">Sing Along with ABC Song! 🎵</h2>
            <video id="abc-video" width="80%" controls autoplay style="border-radius:12px; box-shadow:0 8px 20px rgba(0,0,0,0.3);">
                <source src="../../assets/videos/abc_song.mp4" type="video/mp4">
                Your browser does not support the video tag.
            </video>
        `;
        document.body.appendChild(videoContainer);

        // Show post-video choice after video ends
        document.getElementById('abc-video').addEventListener('ended', ()=>{
            document.getElementById('post-video-choice').style.display = 'block';
        });

        return;
    }
    document.getElementById('letter-display').innerText = `Capital ${alphabet[i].letter} / Small ${alphabet[i].small}`;
    document.getElementById('image').src = "../../assets/images/" + alphabet[i].image;
    document.getElementById('image').style.display = "block";

    // Progress bar
    let progress = ((i+1)/alphabet.length)*100;
    document.getElementById('progress-bar').style.width = progress + "%";

    launchConfetti();
}

function playAudio(){
    // Cancel any currently speaking audio
    window.speechSynthesis.cancel();

    let text = `Say with me! Capital ${alphabet[index].letter}. Small ${alphabet[index].small}.`;
    let utter = new SpeechSynthesisUtterance(text);

    // Pick female US voice if available
    let selected = voices.find(v => v.lang === 'en-US' && v.name.toLowerCase().includes('female'));
    if(selected) utter.voice = selected;

    utter.rate = 0.6;   // slow for kids
    utter.pitch = 1.5;  // cheerful
    window.speechSynthesis.speak(utter);
}

// Navigation
function nextLetter(){ 
    index++; 
    showLetter(index); 
    window.speechSynthesis.cancel(); 
    setTimeout(playAudio, 300); 
}
function prevLetter(){ 
    index--; 
    showLetter(index); 
    window.speechSynthesis.cancel(); 
    setTimeout(playAudio, 300); 
}

// Initialize
showLetter(index);

function launchConfetti(){
    confetti({
        particleCount: 30,
        spread: 70,
        origin: { y: 0.6 },
        colors: ['#ff6b6b','#ffcc66','#6bffb8','#66ccff','#ff66d9']
    });
}
</script>
</body>
</html>