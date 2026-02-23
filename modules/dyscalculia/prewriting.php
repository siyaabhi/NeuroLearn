<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Prewriting Practice — NeuroLearn</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>
  <style>
    body {
      background: url('../../kids/numbg.jpg') center/cover no-repeat fixed;
      font-family: 'Poppins', sans-serif;
      margin: 0;
      padding: 0;
      height: 100vh;
      overflow: hidden; /* no scroll */
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .flashcard {
      background: linear-gradient(145deg, #fff8f0, #ffffff);
      border-radius: 25px;
      padding: 20px;
      width: 750px;
      height: 520px;
      box-shadow: 0 10px 25px rgba(0,0,0,0.15);
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: space-between;
    }

    .heading {
      font-size: 2rem;
      font-weight: bold;
      color: #ff4d6d;
    }

    .progress {
      font-size: 1rem;
      font-weight: 600;
      color: #555;
      margin-bottom: 5px;
    }

    .instruction {
      font-size: 1.1rem;
      font-weight: 600;
      color: #444;
      margin: 5px 0 10px;
      text-align: center;
      min-height: 35px;
    }

    canvas {
      border: 2px dashed #ccc;
      border-radius: 15px;
      background: #fdfdfd;
      cursor: crosshair;
    }

    .buttons {
      display: flex;
      justify-content: center;
      flex-wrap: wrap;
      gap: 15px;
      margin-top: 10px;
    }

    button {
      padding: 14px 28px;
      border-radius: 30px;
      border: none;
      font-size: 1.2rem;
      font-weight: bold;
      cursor: pointer;
      transition: transform 0.2s ease;
    }

    button:hover { transform: scale(1.1); }

    .prev-btn { background: #4cd4c0; color: white; }
    .next-btn { background: #ff6b6b; color: white; }
    .speak-btn { background: #ffd93d; color: black; }
    .clear-btn { background: #6bcbee; color: white; }

    /* Popup */
    .popup {
      position: fixed;
      top: 0; left: 0; right: 0; bottom: 0;
      background: rgba(255,255,255,0.05);  
      backdrop-filter: blur(6px);
      display: none;
      justify-content: center;
      align-items: center;
      z-index: 1000;
    }

    .popup-content {
      background: linear-gradient(135deg, #fff1f3, #ffe7ba);
      padding: 40px 60px;
      border-radius: 25px;
      text-align: center;
      box-shadow: 0 10px 30px rgba(0,0,0,0.2);
      animation: popIn 0.5s ease;
      max-width: 500px;
    }

    .popup-title {
      font-size: 2.5rem;
      font-weight: bold;
      color: #ff4d6d;
      margin-bottom: 10px;
    }

    .popup-message {
      font-size: 1.4rem;
      font-weight: 600;
      color: #444;
      margin-bottom: 25px;
    }

    .popup-content button {
      padding: 14px 28px;
      border-radius: 30px;
      border: none;
      font-size: 1.2rem;
      font-weight: bold;
      background: #4cd4c0;
      color: white;
      cursor: pointer;
      transition: transform 0.2s ease, background 0.3s;
    }

    .popup-content button:hover {
      transform: scale(1.1);
      background: #34bfa3;
    }

    @keyframes popIn {
      0% { transform: scale(0.7); opacity: 0; }
      100% { transform: scale(1); opacity: 1; }
    }
  </style>
</head>
<body>

  <div class="flashcard">
    <div class="heading">✍️ Let's Practice Prewriting</div>
    <div class="progress" id="progress">Pattern 1 of 8</div>
    <div class="instruction" id="instruction">Instruction goes here</div>
    <canvas id="traceCanvas" width="600" height="250"></canvas>
    <div class="buttons">
      <button class="prev-btn" onclick="prevCard()">⬅ Previous</button>
      <button class="speak-btn" onclick="speakInstruction()">🔊 Speak</button>
      <button class="clear-btn" onclick="clearCanvas()">🧹 Clear</button>
      <button class="next-btn" onclick="nextCard()">Next ➡</button>
    </div>
  </div>

  <!-- Popup -->
  <div class="popup" id="popup">
    <div class="popup-content">
      <div class="popup-title">🎉 Great Job! 🎉</div>
      <p class="popup-message">You finished all patterns!</p>
      <button onclick="goBack()">Go to Dyscalculia Page</button>
    </div>
  </div>

  <script>
    const canvas = document.getElementById("traceCanvas");
    const ctx = canvas.getContext("2d");
    let drawing = false;

    const patterns = [
      { instruction: "Draw a straight line from top to bottom.", draw: () => {
        ctx.beginPath(); ctx.moveTo(300,20); ctx.lineTo(300,230); ctx.stroke();
      }},
      { instruction: "Draw a zig-zag line.", draw: () => {
        ctx.beginPath();
        ctx.moveTo(50,50);
        for (let i=0; i<6; i++) {
          ctx.lineTo(50+(i*90), i%2===0?200:50);
        }
        ctx.stroke();
      }},
      { instruction: "Draw a big circle.", draw: () => {
        ctx.beginPath(); ctx.arc(300,120,80,0,Math.PI*2); ctx.stroke();
      }},
      { instruction: "Draw a wave line.", draw: () => {
        ctx.beginPath();
        for(let x=0;x<=600;x+=15){
          ctx.lineTo(x,120+40*Math.sin(x*0.08));
        }
        ctx.stroke();
      }},
      { instruction: "Draw a spiral.", draw: () => {
        ctx.beginPath();
        for (let i=0; i<360; i+=5) {
          let angle = i * Math.PI/180;
          let radius = i*0.4;
          ctx.lineTo(300 + radius*Math.cos(angle), 120 + radius*Math.sin(angle));
        }
        ctx.stroke();
      }},
      { instruction: "Draw small loops.", draw: () => {
        ctx.beginPath();
        for (let x=50; x<=550; x+=40) {
          ctx.arc(x,120,20,0,Math.PI*2);
        }
        ctx.stroke();
      }},
      { instruction: "Draw a triangle.", draw: () => {
        ctx.beginPath();
        ctx.moveTo(300,40); ctx.lineTo(200,200); ctx.lineTo(400,200); ctx.closePath(); ctx.stroke();
      }},
      { instruction: "Draw curved hills.", draw: () => {
        ctx.beginPath();
        ctx.moveTo(50,180);
        ctx.quadraticCurveTo(150,50,250,180);
        ctx.quadraticCurveTo(350,50,450,180);
        ctx.quadraticCurveTo(550,50,650,180);
        ctx.stroke();
      }}
    ];

    let current = 0;

    function drawPattern() {
      ctx.clearRect(0,0,canvas.width,canvas.height);
      ctx.lineWidth = 3;
      ctx.strokeStyle = "#aaa";
      patterns[current].draw();
      document.getElementById("instruction").innerText = patterns[current].instruction;
      document.getElementById("progress").innerText = `Pattern ${current+1} of ${patterns.length}`;
    }

    // ✅ Fixed Drawing
    canvas.addEventListener("mousedown", startDraw);
    canvas.addEventListener("mouseup", stopDraw);
    canvas.addEventListener("mousemove", drawFree);

    canvas.addEventListener("touchstart", startDraw);
    canvas.addEventListener("touchend", stopDraw);
    canvas.addEventListener("touchmove", drawFree);

    function startDraw(e) {
      drawing = true;
      let rect = canvas.getBoundingClientRect();
      let x, y;

      if (e.touches) {
        x = e.touches[0].clientX - rect.left;
        y = e.touches[0].clientY - rect.top;
      } else {
        x = e.clientX - rect.left;
        y = e.clientY - rect.top;
      }

      ctx.beginPath();
      ctx.moveTo(x, y);  // start where pointer goes down
    }

    function stopDraw() {
      drawing = false;
    }

    function drawFree(e) {
      if (!drawing) return;

      ctx.lineWidth = 4;
      ctx.strokeStyle = "#ff4d6d";
      ctx.lineCap = "round";
      ctx.lineJoin = "round";

      let rect = canvas.getBoundingClientRect();
      let x, y;

      if (e.touches) {
        x = e.touches[0].clientX - rect.left;
        y = e.touches[0].clientY - rect.top;
      } else {
        x = e.clientX - rect.left;
        y = e.clientY - rect.top;
      }

      ctx.lineTo(x, y);
      ctx.stroke();
      ctx.moveTo(x, y);  
      e.preventDefault();
    }

    function clearCanvas() {
      ctx.clearRect(0,0,canvas.width,canvas.height);
      ctx.lineWidth = 3;
      ctx.strokeStyle = "#aaa";
      patterns[current].draw();
    }

    function speakInstruction() {
      const msg = new SpeechSynthesisUtterance(patterns[current].instruction);
      msg.lang = "en-US";
      msg.rate = 0.9;
      msg.pitch = 1.1;
      window.speechSynthesis.cancel();
      window.speechSynthesis.speak(msg);
    }

    function nextCard() {
      if (current < patterns.length - 1) {
        current++;
        drawPattern();
        speakInstruction();
      } else {
        showPopup();
      }
    }

    function prevCard() {
      if (current > 0) {
        current--;
        drawPattern();
        speakInstruction();
      }
    }

    function showPopup() {
      document.getElementById("popup").style.display = "flex";

      // 🎉 Confetti
      const duration = 3 * 1000;
      const end = Date.now() + duration;

      (function frame() {
        confetti({ particleCount: 5, angle: 60, spread: 55, origin: { x: 0 } });
        confetti({ particleCount: 5, angle: 120, spread: 55, origin: { x: 1 } });

        if (Date.now() < end) {
          requestAnimationFrame(frame);
        }
      })();
    }

    function goBack() {
      window.location.href = "select_subject.php";
    }

    drawPattern();
  </script>
</body>
</html>
