<?php
// evs_learn.php
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>EVS Learning - NeuroLearn</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Baloo+2:wght@600&family=Fredoka+One&display=swap" rel="stylesheet">

  <style>
    body {
      background: url('../../kids/evsbg.jpg') no-repeat center center fixed;
      background-size: cover;
      font-family: 'Baloo 2', cursive;
    }

    .content-box {
      background: #fff8dc;
      border: 4px dashed #ff9800;
      border-radius: 30px;
      padding: 40px;
      text-align: center;
      max-width: 1000px;
      margin: 40px auto;
      box-shadow: 0 8px 25px rgba(0,0,0,0.2);
      animation: fadeIn 1s ease-in-out;
    }

    h6 {
      font-family: 'Fredoka One', cursive;
      color: #ff5722;
      font-size: 3rem;
      margin-bottom: 20px;
      text-shadow: 2px 2px #ffe0b2;
    }

    p {
      font-size: 1.5rem;
      margin-bottom: 20px;
    }

    .flashcard {
      width: 100%;
      max-width: 850px;
      height: 500px;
      background: #fff;
      border-radius: 25px;
      border: 4px solid #ff9800;
      box-shadow: 0 8px 20px rgba(0,0,0,0.3);
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      margin: 0 auto 20px auto;
      padding: 20px;
      animation: fadeIn 1s ease-in-out;
    }

    .flashcard img {
      max-height: 280px;
      margin-bottom: 15px;
    }

    .flashcard h6 {
      font-size: 2.5rem;
      color: #ff4081;
      margin-bottom: 10px;
    }

    .flashcard p {
      font-size: 1.4rem;
      color: #333;
    }

    .video-box {
      width: 100%;
      max-width: 850px;
      height: 480px;
      margin: 0 auto 20px auto;
      border: 6px solid #ff9800;
      border-radius: 25px;
      overflow: hidden;
      box-shadow: 0 6px 20px rgba(0,0,0,0.3);
    }

    .video-box video {
      width: 100%;
      height: 100%;
    }

    /* Playful Buttons */
    button {
      font-family: 'Baloo 2', cursive;
      font-size: 1.5rem;
      font-weight: bold;
      padding: 14px 28px;
      border-radius: 50px;
      border: none;
      cursor: pointer;
      transition: transform 0.2s, background 0.3s;
      margin: 10px;
      box-shadow: 0 6px 15px rgba(0,0,0,0.2);
    }

    button:hover {
      transform: scale(1.1);
    }

    .next-btn {
      background: linear-gradient(135deg, #ff9800, #ff5722);
      color: white;
    }

    .prev-btn {
      background: linear-gradient(135deg, #8bc34a, #4caf50);
      color: white;
    }

    .speak-btn {
      background: linear-gradient(135deg, #03a9f4, #0288d1);
      color: white;
    }

    .start-btn {
      background: linear-gradient(135deg, #e91e63, #f44336);
      color: white;
    }

    .end-btn {
      background: linear-gradient(135deg, #9c27b0, #673ab7);
      color: white;
    }

    @keyframes fadeIn {
      from {opacity: 0; transform: translateY(30px);}
      to {opacity: 1; transform: translateY(0);}
    }

    /* Confetti animation */
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

<div id="learningSection" class="content-box">
  <h6>🌿 Welcome to EVS Learning! 🌿</h6>
  <p>Let's explore My Body, Plants, and Animals in a fun way!</p>
  <button class="start-btn" onclick="startLearning()">Start Learning 🚀</button>
</div>

<canvas id="confetti"></canvas>

<script>
  const lessons = [
    // My Body Section
    { type: "flashcard", title: "My Body", text: "This is our body. Let's learn the sense organs!", img: "../../kids/body.jpg" },
    { type: "flashcard", title: "Eyes", text: "We see the world with our eyes.", img: "../../kids/eyes.jpg", speak: "We see the world with our eyes" },
    { type: "flashcard", title: "Ears", text: "We hear sounds with our ears.", img: "../../kids/ears.jpg", speak: "We hear sounds with our ears" },
    { type: "flashcard", title: "Nose", text: "We smell with our nose.", img: "../../kids/nose.jpg", speak: "We smell with our nose" },
    { type: "flashcard", title: "Tongue", text: "We taste with our tongue.", img: "../../kids/tongue.jpg", speak: "We taste with our tongue" },
    { type: "flashcard", title: "Skin", text: "We feel with our skin.", img: "../../kids/skin.jpg", speak: "We feel with our skin" },
    { type: "video", title: "My Body Video", url: "../../kids/mybody.mp4" },

    // Plants Section
    { type: "flashcard", title: "Parts of a Plant", text: "Plants have roots, stems, leaves, flowers, and fruits.", img: "../../kids/partsofplant.jpg", speak: "Plants have roots, stems, leaves, flowers, and fruits" },
    { type: "flashcard", title: "Types of plants", text: "Herbs are small plants like mint and tulsi.", img: "../../kids/herbs.jpg", speak: "Herbs are small plants like mint and tulsi" },
    { type: "flashcard", title: "Types of Plants", text: "Shrubs are bushy plants like hibiscus.", img: "../../kids/shrubs.jpg", speak: "Shrubs are bushy plants like hibiscus" },
    { type: "flashcard", title: "Types of Plants", text: "Trees are big plants like mango and banyan.", img: "../../kids/trees.jpg", speak: "Trees are big plants like mango and banyan" },
    { type: "flashcard", title: "Types of Plants", text: "Climbers need support to grow like money plant.", img: "../../kids/climbers.jpg", speak: "Climbers need support to grow like money plant" },
    { type: "flashcard", title: "Types of Plants", text: "Creepers grow along the ground like pumpkin.", img: "../../kids/creepers.jpg", speak: "Creepers grow along the ground like pumpkin" },
    { type: "video", title: "Plants Video", url: "../../kids/plantsvideo.mp4" },

    // Animals Section
    { type: "flashcard", title: "Domestic Animals ", text: "These animals live with us .", img: "../../kids/domesticanimals.jpg", speak: "These animals live with us" },
    { type: "flashcard", title: "Dog", text: "Dogs are friendly.", img: "../../kids/dog.jpg", speak: "This is a dog. It lives with us." },
    { type: "flashcard", title: "Cat", text: "Cats are cute pets.", img: "../../kids/cat.jpg", speak: "Cats are cute pets." },
    { type: "flashcard", title: "Cow", text: "Cows give us milk.", img: "../../kids/cow.jpg", speak: "Cows give us milk." },
    { type: "flashcard", title: "Goat", text: "Goats give us milk and are helpful.", img: "../../kids/goat.jpg", speak: "Goats give us milk and are helpful." },
    { type: "flashcard", title: "Horse", text: "Horses are strong animals used for riding.", img: "../../kids/horse.jpg", speak: "Horses are strong animals used for riding." },

    { type: "flashcard", title: "Wild Animals ", text: "These animals live in forests.", img: "../../kids/wildanimals.jpg", speak: "These animals live in forests" },
    { type: "flashcard", title: "Lion", text: "Lion is the king of the jungle.", img: "../../kids/lion.jpg", speak: "Lion is the king of the jungle" },
    { type: "flashcard", title: "Tiger", text: "Tiger is our national animal.", img: "../../kids/tiger.jpg", speak: "Tiger is our national animal" },
    { type: "flashcard", title: "Elephant", text: "Elephants are the largest land animals.", img: "../../kids/elephant.jpg", speak: "Elephants are the largest land animals" },
    { type: "flashcard", title: "Zebra", text: "Zebras have black and white stripes.", img: "../../kids/zebra.jpg", speak: "Zebras have black and white stripes." },
    { type: "flashcard", title: "Bear", text: "Bears are strong wild animals.", img: "../../kids/bear.jpg", speak: "Bears are strong wild animals." },

    { type: "video", title: "Domestic Animals Video", url: "../../kids/domesticanimalsvideo.mp4" },
    { type: "video", title: "Wild Animals Video", url: "../../kids/wildanimalsvideo.mp4" },

    { type: "end", title: "🎉 Congratulations!", text: "You completed the EVS journey! Great job 🎊" }
  ];

  let index = 0;

  function startLearning() {
    showLesson(index);
  }

  function showLesson(i) {
    const section = document.getElementById("learningSection");
    const lesson = lessons[i];

    if (lesson.type === "flashcard") {
      section.innerHTML = `
        <h6>${lesson.title}</h6>
        <div class="flashcard">
          <img src="${lesson.img}" alt="${lesson.title}">
          <h6>${lesson.title}</h6>
          <p>${lesson.text}</p>
        </div>
        <div>
          ${i > 0 ? `<button class="prev-btn" onclick="prevLesson()">⬅ Previous</button>` : ""}
          ${lesson.speak ? `<button class="speak-btn" onclick="speakText('${lesson.speak}')">🔊 Speak</button>` : ""}
          ${i < lessons.length - 1 ? `<button class="next-btn" onclick="nextLesson()">Next ➡</button>` : ""}
        </div>
      `;
    }

    if (lesson.type === "video") {
      section.innerHTML = `
        <h6>${lesson.title}</h6>
        <div class="video-box">
          <video controls>
            <source src="${lesson.url}" type="video/mp4">
            Your browser does not support video.
          </video>
        </div>
        <div>
          <button class="prev-btn" onclick="prevLesson()">⬅ Previous</button>
          <button class="next-btn" onclick="nextLesson()">Next ➡</button>
        </div>
      `;
    }

    if (lesson.type === "end") {
      section.innerHTML = `
        <h6>${lesson.title}</h6>
        <p>${lesson.text}</p>
        <button class="end-btn" onclick="window.location.href='evs.php'">⬅ Go to EVS Page</button>
      `;
      launchConfetti();
    }
  }

  function nextLesson() {
    if (index < lessons.length - 1) {
      index++;
      showLesson(index);
    }
  }

  function prevLesson() {
    if (index > 0) {
      index--;
      showLesson(index);
    }
  }

  function speakText(text) {
    const utterance = new SpeechSynthesisUtterance(text);
    speechSynthesis.speak(utterance);
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
      color: `hsl(${Math.random() * 360}, 100%, 50%)`,
      tilt: Math.random() * 10 - 10
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
        p.x += Math.sin(p.d);
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
