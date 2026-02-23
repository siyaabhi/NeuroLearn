<?php
// evs games.php
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>EVS Games - NeuroLearn</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Baloo+2:wght@700&family=Fredoka+One&display=swap" rel="stylesheet">

  <style>
    body {
      background: url('../../kids/evsbg.jpg') no-repeat center center fixed;
      background-size: cover;
      font-family: 'Baloo 2', cursive;
    }

    .content-box {
      background: #fff8dc;
      border: 5px solid #ff9800;
      border-radius: 35px;
      padding: 30px;
      text-align: center;
      max-width: 1000px;
      margin: 40px auto;
      box-shadow: 0 8px 25px rgba(0,0,0,0.3);
      animation: fadeIn 1s ease-in-out;
    }

    h6 {
      font-family: 'Fredoka One', cursive;
      color: #ff4081;
      font-size: 3rem;
      margin-bottom: 20px;
      text-shadow: 3px 3px #ffe0b2;
    }

    p {
      font-size: 1.4rem;
      margin-bottom: 20px;
      font-weight: bold;
    }

    .game-box {
      background: #fff;
      border-radius: 25px;
      padding: 15px;
      margin: 20px auto;
      box-shadow: 0 8px 20px rgba(0,0,0,0.3);
      max-width: 900px;
      animation: fadeIn 0.8s ease-in-out;
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      gap: 10px;
    }

    .option, .dropzone {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      margin: 8px;
      padding: 8px;
      border: 3px dashed #ff9800;
      border-radius: 20px;
      cursor: grab;
      background: #fff3e0;
      font-size: 1rem;
      font-weight: bold;
      width: 120px;
      height: 120px;
      text-align: center;
      transition: all 0.3s ease;
      flex-direction: column;
    }

    .option img {
      width: 90px;
      height: 90px;
      object-fit: cover;
      border-radius: 12px;
    }

    .dropzone {
      min-width: 120px;
      min-height: 120px;
      background: #f1f8e9;
      flex-wrap: wrap;
    }

    /* Correct/Wrong animations */
    .dropzone.correct {
      animation: correctAnim 0.8s forwards;
      border-color: #388e3c !important;
    }
    .dropzone.wrong {
      animation: wrongAnim 0.8s forwards;
      border-color: #d32f2f !important;
    }

    @keyframes correctAnim {
      0% { background-color: #f1f8e9; transform: scale(1); }
      50% { background-color: #a5d6a7; transform: scale(1.1); }
      100% { background-color: #a5d6a7; transform: scale(1); }
    }

    @keyframes wrongAnim {
      0% { background-color: #f1f8e9; transform: scale(1); }
      50% { background-color: #ef9a9a; transform: scale(1.1); }
      100% { background-color: #f1f8e9; transform: scale(1); }
    }

    .btn {
      font-family: 'Baloo 2', cursive;
      font-size: 1.4rem;
      padding: 10px 25px;
      border-radius: 50px;
      border: none;
      cursor: pointer;
      margin: 10px;
      box-shadow: 0 6px 15px rgba(0,0,0,0.25);
      transition: transform 0.2s;
    }

    .btn:hover { transform: scale(1.1); }
    .next-btn { background: linear-gradient(135deg, #ff9800, #ff5722); color: #fff; }
    .prev-btn { background: linear-gradient(135deg, #8bc34a, #4caf50); color: #fff; }
    .start-btn { background: linear-gradient(135deg, #e91e63, #f44336); color: #fff; }

    @keyframes fadeIn {
      from {opacity: 0; transform: translateY(30px);}
      to {opacity: 1; transform: translateY(0);}
    }

    #confetti {
      position: fixed;
      top: 0; left: 0;
      width: 100%; height: 100%;
      pointer-events: none;
      display: none;
    }
  </style>
</head>
<body>

<div id="gameSection" class="content-box">
  <h6>🎮 EVS Fun Games 🎮</h6>
  <p>Test what you learned about My Body, Plants, and Animals!</p>
  <button class="start-btn" onclick="startGames()">Start Playing 🚀</button>
</div>

<canvas id="confetti"></canvas>

<script>
const games = [
  { type: "matching", title: "Game 1: Match the Body Parts", 
    text: "Drag the body part to its function!", 
    items: [
      {img: "../../kids/eyes.jpg", match: "See"},
      {img: "../../kids/ears.jpg", match: "Hear"},
      {img: "../../kids/nose.jpg", match: "Smell"},
      {img: "../../kids/tongue.jpg", match: "Taste"},
      {img: "../../kids/skin.jpg", match: "Feel"},
    ]
  },
  { type: "sort", title: "Game 2: Domestic or Wild?", 
    text: "Drag each animal to the correct group!",
    domestic: ["../../kids/dog.jpg", "../../kids/cow.jpg", "../../kids/cat.jpg"],
    wild: ["../../kids/lion.jpg", "../../kids/tiger.jpg", "../../kids/elephant.jpg"]
  },
  { type: "end", title: "🎉 Congratulations!", text: "You completed all games! Great job 🎊" }
];

let index = 0;

function startGames() { showGame(index); }

function showGame(i) {
  const section = document.getElementById("gameSection");
  const game = games[i];

  if (game.type === "matching") {
    let options = game.items.map(it => `<div class="option" draggable="true" data-match="${it.match}"><img src="${it.img}"></div>`).join("");
    let zones = game.items.map(it => `<div class="dropzone" data-answer="${it.match}">${it.match}</div>`).join("");
    section.innerHTML = `
      <h6>${game.title}</h6>
      <p>${game.text}</p>
      <div class="game-box">${options}</div>
      <div class="game-box">${zones}</div>
      <button class="next-btn" onclick="nextGame()">Next ➡</button>
    `;
    enableDragDrop();
  }

  if (game.type === "sort") {
    let animals = [...game.domestic, ...game.wild].map(a => `<div class="option" draggable="true" data-animal="${a}"><img src="${a}"></div>`).join("");
    section.innerHTML = `
      <h6>${game.title}</h6>
      <p>${game.text}</p>
      <div class="game-box">${animals}</div>
      <div class="game-box">
        <h6>Domestic</h6>
        <div class="dropzone" data-group="domestic"></div>
      </div>
      <div class="game-box">
        <h6>Wild</h6>
        <div class="dropzone" data-group="wild"></div>
      </div>
      <button class="prev-btn" onclick="prevGame()">⬅ Previous</button>
      <button class="next-btn" onclick="nextGame()">Next ➡</button>
    `;
    enableDragDrop();
  }

  if (game.type === "end") {
    section.innerHTML = `
      <h6>${game.title}</h6>
      <p>${game.text}</p>
      <button class="start-btn" onclick="window.location.href='evs.php'">⬅ Go to EVS Page</button>
    `;
    launchConfetti();
  }
}

function nextGame() { if (index < games.length - 1) { index++; showGame(index); } }
function prevGame() { if (index > 0) { index--; showGame(index); } }

function enableDragDrop() {
  const options = document.querySelectorAll('.option');
  const dropzones = document.querySelectorAll('.dropzone');

  options.forEach(opt => {
    opt.addEventListener('dragstart', e => {
      e.dataTransfer.setData("html", opt.outerHTML);
      e.dataTransfer.setData("match", opt.dataset.match || "");
      e.dataTransfer.setData("animal", opt.dataset.animal || "");
    });
  });

  dropzones.forEach(zone => {
    zone.addEventListener('dragover', e => e.preventDefault());
    zone.addEventListener('drop', e => {
      e.preventDefault();
      const match = e.dataTransfer.getData("match");
      const animal = e.dataTransfer.getData("animal");
      const html = e.dataTransfer.getData("html");

      const tempDiv = document.createElement("div");
      tempDiv.innerHTML = html;
      const draggedElem = tempDiv.firstChild;

      const isCorrect = (zone.dataset.answer === match) ||
                        (zone.dataset.group === "domestic" && ["../../kids/dog.jpg","../../kids/cat.jpg","../../kids/cow.jpg"].includes(animal)) ||
                        (zone.dataset.group === "wild" && ["../../kids/lion.jpg","../../kids/tiger.jpg","../../kids/elephant.jpg"].includes(animal));

      if (isCorrect) {
        zone.classList.add("correct");
        zone.appendChild(draggedElem);
        draggedElem.setAttribute("draggable", "false");
      } else {
        zone.classList.add("wrong");
        setTimeout(() => zone.classList.remove("wrong"), 800);
      }
    });
  });
}

function launchConfetti() {
  const confetti = document.getElementById("confetti");
  confetti.style.display = "block";
  const ctx = confetti.getContext("2d");
  confetti.width = window.innerWidth;
  confetti.height = window.innerHeight;

  const pieces = Array.from({ length: 200 }).map(() => ({
    x: Math.random() * confetti.width,
    y: Math.random() * confetti.height,
    r: Math.random() * 10 + 5,
    d: Math.random() * 10 + 5,
    color: `hsl(${Math.random() * 360}, 100%, 50%)`
  }));

  function draw() {
    ctx.clearRect(0,0,confetti.width, confetti.height);
    pieces.forEach(p => {
      ctx.beginPath();
      ctx.arc(p.x, p.y, p.r, 0, Math.PI*2, false);
      ctx.fillStyle = p.color;
      ctx.fill();
    });
    update();
    requestAnimationFrame(draw);
  }

  function update() {
    pieces.forEach(p => {
      p.y += Math.cos(p.d) + p.r/2;
      if (p.y > confetti.height) {
        p.y = -10;
        p.x = Math.random() * confetti.width;
      }
    });
  }

  draw();
}
</script>

</body>
</html>
