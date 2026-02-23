<?php
session_start();
if (!isset($_SESSION['user_id'])) {
  header("Location: ../../login.php");
  exit();
}
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8" />
<title>Memory Games — NeuroLearn</title>
<meta name="viewport" content="width=device-width,initial-scale=1" />
<script src="https://cdn.tailwindcss.com"></script>
<style>
  /* page bg */
  body{
    font-family: 'Poppins', sans-serif;
    background: url('../../kids/numbg.jpg') center/cover no-repeat fixed;
    min-height:100vh;
    margin:0;
  }

  /* card */
  .game-box{
    max-width:1000px;
    margin:48px auto;
    background: linear-gradient(180deg,#ffffff,#fff8f5);
    border-radius:22px;
    padding:26px;
    box-shadow:0 16px 40px rgba(13,30,60,0.12);
    border:6px solid transparent;
    background-clip: padding-box, border-box;
    background-origin: border-box;
    background-image:
      linear-gradient(180deg,#ffffff,#fff8f5),
      linear-gradient(45deg,#ff6b6b,#ffd93d,#6bcbee);
  }

  .game-title{
    font-size:2.2rem;
    font-weight:800;
    color:#ff4d6d;
    text-align:center;
    margin-bottom:18px;
  }

  /* Canvas */
  #traceCanvas{
    display:block;
    margin:0 auto;
    width:90%;
    max-width:720px;
    height:320px;
    border-radius:14px;
    background:#fffdfd;
    border:3px dashed #e6e6e6;
    cursor:crosshair;
  }

  /* Buttons */
  .buttons{ margin-top:22px; display:flex; gap:18px; justify-content:center; flex-wrap:wrap; }
  .btn{
    padding:14px 36px; border-radius:999px; font-weight:800; font-size:1.05rem; border:none; cursor:pointer;
    box-shadow:0 8px 20px rgba(0,0,0,0.08); transition:transform .15s;
  }
  .btn:hover{ transform:translateY(-3px) scale(1.03); }
  .btn-clear{ background:#4cd4c0; color:#fff; }
  .btn-next{ background:#ff6b6b; color:#fff; }
  .btn-sound{ background:#ffd93d; color:#111827; }

  /* Matching layout */
  .match-wrap{ display:grid; grid-template-columns:1fr 1fr; gap:22px; margin-top:18px; }
  .match-col{ background:#fff; border-radius:12px; padding:14px; border:3px solid #f1f1f1; }
  .col-title{ font-weight:800; color:#374151; margin-bottom:12px; }

  /* grid of cards (2 columns x 5 rows each column) */
  .grid{ display:grid; grid-template-columns: repeat(2,1fr); gap:12px; }
  .card{
    background:#fff; border:3px solid #e6e6e6; border-radius:12px; padding:12px;
    min-height:96px; display:flex; align-items:center; justify-content:center; cursor:pointer;
    user-select:none; font-weight:700; font-size:1.35rem; transition:all .18s;
  }
  .card:hover{ transform: translateY(-6px); box-shadow:0 12px 30px rgba(0,0,0,0.08); }
  .card.correct{ background:#4cd4c0; color:#fff; border-color:#37b3a1; pointer-events:none; }
  .card.wrong{ background:#ff6b6b; color:#fff; border-color:#ef4444; }

  /* icons container inside object card */
  .icons{ display:flex; flex-wrap:wrap; gap:6px; justify-content:center; align-items:center; }
  .icons .icon{ font-size:20px; line-height:1; display:inline-block; }

  /* final popup overlay */
  #final-popup{
    display:none; /* hidden by default */
    position:fixed; inset:0; z-index:1200; background:rgba(0,0,0,0.55);
    justify-content:center; align-items:center; padding:18px;
  }
  #final-popup.show{ display:flex; }
  .popup{
    width: min(560px,94%); background:#fff; border-radius:18px; padding:28px; text-align:center;
    box-shadow:0 20px 50px rgba(0,0,0,0.28);
    border:6px solid transparent;
    background-clip: padding-box, border-box;
    background-image: linear-gradient(180deg,#ffffff,#fff7f8), linear-gradient(45deg,#ff6b6b,#ffd93d,#6bcbee);
  }
  .popup h2{ font-size:2rem; color:#ff4d6d; margin:6px 0 8px; font-weight:900; }
  .popup p{ color:#374151; font-weight:700; margin-bottom:14px; }
  .popup .popup-buttons{ display:flex; gap:12px; justify-content:center; margin-top:8px; }

  /* confetti */
  .confetti{ position:fixed; top:-40px; left:0; pointer-events:none; z-index:1250; font-size:22px; animation:fall 2.8s linear forwards; }
  @keyframes fall { to { transform: translateY(115vh) rotate(720deg); opacity:0.95; } }
</style>
</head>
<body>

  <!-- TRACE -->
  <div class="game-box" id="traceBox">
    <div class="game-title">✏️ Trace the Number</div>
    <canvas id="traceCanvas" width="720" height="320"></canvas>
    <div class="buttons">
      <button class="btn btn-clear" id="btnClear">Clear</button>
      <button class="btn btn-next" id="btnNext">Next</button>
    </div>
  </div>

  <!-- MATCH -->
  <div class="game-box" id="matchBox" style="display:none;">
    <div class="game-title">🔢 Match Numbers with Objects</div>
    <div class="match-wrap">
      <div class="match-col">
        <div class="col-title">Numbers</div>
        <div class="grid" id="numberGrid"></div>
      </div>
      <div class="match-col">
        <div class="col-title">Objects</div>
        <div class="grid" id="objectGrid"></div>
      </div>
    </div>
  </div>

  <!-- FINAL POPUP -->
  <div id="final-popup">
    <div class="popup" role="dialog">
      <h2>🎉 Great Job! 🎉</h2>
      <p>You matched all the numbers correctly!</p>
      <div class="popup-buttons">
        <button class="btn btn-next" id="goDys">Go to Dyscalculia</button>
        <button class="btn btn-clear" id="replay">Replay</button>
      </div>
    </div>
  </div>

<script>
/* ---------- Sounds: ensure these exist in ../../kids/ -------- */
const dingSound  = new Audio("../../kids/ding.mp3");
const errorSound = new Audio("../../kids/error.mp3");
const cheerSound = new Audio("../../kids/cheer.mp3");
const clickSound = new Audio("../../kids/click.mp3");

/* quick button sound */
document.addEventListener("click", e=>{
  if(e.target.tagName==='BUTTON'){
    try{ clickSound.currentTime=0; clickSound.play(); }catch(e){}
  }
});

/* ---------- Trace canvas ---------- */
const canvas = document.getElementById('traceCanvas');
const ctx = canvas.getContext('2d');
const btnClear = document.getElementById('btnClear');
const btnNext  = document.getElementById('btnNext');
let drawing=false;
let traceIndex=1;

function showGuideline(n){
  ctx.clearRect(0,0,canvas.width,canvas.height);
  ctx.fillStyle="#fcfcfc";
  ctx.fillRect(0,0,canvas.width,canvas.height);
  ctx.font = "220px Fredoka, Poppins, Arial";
  ctx.textAlign = "center";
  ctx.fillStyle = "#eee";
  ctx.fillText(String(n), canvas.width/2, 240);
}
showGuideline(traceIndex);

/* drawing */
canvas.addEventListener('mousedown', ()=> drawing=true);
canvas.addEventListener('mouseup', ()=> drawing=false);
canvas.addEventListener('mouseleave', ()=> drawing=false);
canvas.addEventListener('mousemove', function(e){
  if(!drawing) return;
  const r = canvas.getBoundingClientRect();
  const x = e.clientX - r.left;
  const y = e.clientY - r.top;
  ctx.fillStyle = "#ff4d6d";
  ctx.beginPath(); ctx.arc(x,y,8,0,Math.PI*2); ctx.fill();
});

btnClear.addEventListener('click', ()=> {
  showGuideline(traceIndex);
});

btnNext.addEventListener('click', ()=>{
  if(traceIndex < 10){
    traceIndex++;
    showGuideline(traceIndex);
    // scroll a bit to keep canvas visible on smaller screens
    window.scrollTo({ top: 0, behavior: 'smooth' });
  } else {
    // end of tracing -> start matching
    document.getElementById('traceBox').style.display = 'none';
    document.getElementById('matchBox').style.display = 'block';
    startMatching();
    window.scrollTo({ top: 0, behavior: 'smooth' });
  }
});

/* ---------- Matching: numbers 1..10 ---------- */
const numberGrid = document.getElementById('numberGrid');
const objectGrid = document.getElementById('objectGrid');
let selectedNumber = null;
let solvedPairs = 0;

/* emoji set used for objects (one symbol repeated num times) */
const emojiSet = ["🍎","⭐","🎈","🧸","🍬","🌟","🐠","⚽","🍓","🚗"];

function shuffle(arr){ return arr.slice().sort(()=>Math.random()-0.5); }

function startMatching(){
  solvedPairs = 0;
  selectedNumber = null;
  numberGrid.innerHTML = '';
  objectGrid.innerHTML = '';

  const nums = shuffle([1,2,3,4,5,6,7,8,9,10]);
  const objs = shuffle([1,2,3,4,5,6,7,8,9,10]);

  // create number cards (left)
  nums.forEach(n=>{
    const card = document.createElement('div');
    card.className = 'card';
    card.textContent = n;
    card.dataset.num = n;
    card.onclick = ()=> selectNumber(card, n);
    numberGrid.appendChild(card);
  });

  // create object cards on right with exact count of icons
  objs.forEach(n=>{
    const card = document.createElement('div');
    card.className = 'card';
    card.dataset.num = n;
    const icons = document.createElement('div');
    icons.className = 'icons';
    // create n icon spans so they wrap and display correctly
    for(let i=0;i<n;i++){
      const span = document.createElement('span');
      span.className = 'icon';
      span.textContent = emojiSet[(n-1) % emojiSet.length];
      icons.appendChild(span);
    }
    card.appendChild(icons);
    card.onclick = ()=> selectObject(card, n);
    objectGrid.appendChild(card);
  });
}

function selectNumber(card, num){
  // clear other highlights
  Array.from(numberGrid.children).forEach(c=>{
    if(!c.classList.contains('correct')) c.style.background = '#fff';
  });
  selectedNumber = {card, num};
  card.style.background = '#ffd93d';
}

function selectObject(card, num){
  if(!selectedNumber) return;
  // prevent re-selecting already-correct cards
  if(card.classList.contains('correct') || selectedNumber.card.classList.contains('correct')) {
    selectedNumber = null;
    return;
  }

  if(selectedNumber.num === num){
    // correct
    selectedNumber.card.classList.add('correct');
    selectedNumber.card.style.background = '';
    selectedNumber.card.onclick = null;
    card.classList.add('correct');
    card.onclick = null;
    solvedPairs++;
    try{ dingSound.currentTime = 0; dingSound.play(); }catch(e){}
    selectedNumber = null;
    if(solvedPairs === 10){
      setTimeout(()=> showFinal(true), 600);
    }
  } else {
    // wrong
    card.classList.add('wrong');
    try{ errorSound.currentTime = 0; errorSound.play(); }catch(e){}
    setTimeout(()=> card.classList.remove('wrong'), 900);
    if(selectedNumber && !selectedNumber.card.classList.contains('correct')){
      selectedNumber.card.style.background = '#fff';
    }
    selectedNumber = null;
  }
}

/* ---------- Final popup / confetti / actions ---------- */
const popup = document.getElementById('final-popup');
const goDys = document.getElementById('goDys');
const replay = document.getElementById('replay');

goDys.addEventListener('click', ()=>{
  // redirect to the Dyscalculia main page in the same folder (select_subject.php)
  window.location.href = 'select_subject.php';
});
replay.addEventListener('click', ()=>{
  // hide popup and restart from trace
  popup.classList.remove('show');
  traceIndex = 1;
  showGuideline(traceIndex);
  document.getElementById('traceBox').style.display = 'block';
  document.getElementById('matchBox').style.display = 'none';
  window.scrollTo({ top: 0, behavior: 'smooth' });
});

/* show final popup (with cheer & confetti) */
function showFinal(playCheer = true){
  popup.classList.add('show');
  if(playCheer){ try{ cheerSound.currentTime=0; cheerSound.play(); }catch(e){} }
  launchConfetti(60, 2000);
}

/* confetti generator (emoji confetti) */
function launchConfetti(count=40, duration=2200){
  const shapes = ["✨","🌟","🎉"];
  const end = Date.now() + duration;
  (function frame(){
    const el = document.createElement('div');
    el.className = 'confetti';
    el.style.left = (Math.random()*100) + '%';
    el.style.fontSize = (14 + Math.random()*24) + 'px';
    el.textContent = shapes[Math.floor(Math.random()*shapes.length)];
    document.body.appendChild(el);
    setTimeout(()=> el.remove(), 2600);
    if(Date.now() < end) requestAnimationFrame(frame);
  })();
}

</script>
</body>
</html>
