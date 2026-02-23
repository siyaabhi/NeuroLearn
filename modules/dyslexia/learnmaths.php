<!DOCTYPE html> 
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Learn Maths — NeuroLearn</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    body {
      background: url('../../kids/dyslexiamaths.jpg') center/cover no-repeat fixed;
      font-family: 'Poppins', sans-serif;
    }
    .flashcard, .video-container {
      background: linear-gradient(145deg, #fff8f0, #ffffff);
      border-radius: 40px;
      padding: 30px 40px;
      width: 950px;
      height: 480px;
      box-shadow: 0 15px 35px rgba(0,0,0,0.15);
      margin: 100px auto;
      border: 6px solid transparent;
      background-clip: padding-box, border-box;
      background-origin: border-box;
      background-image:
        linear-gradient(145deg, #fff8f0, #ffffff),
        linear-gradient(45deg, #ff6b6b, #6bcbee, #ffd93d, #a1e887);
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: space-around;
      text-align: center;
    }
    .heading {
      font-size: 2.5rem;
      font-weight: bold;
      color: #ff4d6d;
      margin-bottom: 15px;
      text-shadow: 1px 1px #fff;
    }
    .card-content {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 40px;
      flex: 1;
    }
    .card-img {
      width: 200px;
      height: auto;
      border-radius: 20px;
      box-shadow: 0 8px 20px rgba(0,0,0,0.1);
    }
    .digit {
      font-size: 9rem;
      font-weight: 900;
      color: #ff4d6d;
    }
    .word {
      font-size: 2.5rem;
      font-weight: bold;
      margin-top: 15px;
      color: #333;
    }
    .instruction {
      font-size: 1.3rem;
      color: #444;
      font-weight: 600;
      margin-top: 20px;
    }
    .buttons, .video-buttons {
      margin-top: 25px;
      display: flex;
      justify-content: center;
      gap: 40px;
      flex-wrap: wrap;
    }
    button {
      padding: 15px 35px;
      border-radius: 999px;
      border: none;
      font-size: 1.3rem;
      font-weight: bold;
      cursor: pointer;
      transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    button:hover {
      transform: scale(1.1);
      box-shadow: 0 6px 15px rgba(0,0,0,0.2);
    }
    .prev-btn { background: #4cd4c0; color: white; }
    .next-btn { background: #ff6b6b; color: white; }
    .speak-btn { background: #ffd93d; color: black; }
    .replay-btn { background: #6bcbee; color: white; }
    .home-btn { background: #ff6b6b; color: white; }

    /* Popup */
    .popup {
      display: none;
      position: fixed;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      background: white;
      padding: 50px;
      border-radius: 30px;
      text-align: center;
      box-shadow: 0 15px 40px rgba(0,0,0,0.3);
      z-index: 1000;
      animation: pop 0.5s ease;
    }
    .popup img { width: 200px; margin-bottom: 20px; }
    .popup h2 { font-size: 2.5rem; font-weight: bold; color: #ff4d6d; }

    @keyframes pop {
      0% { transform: translate(-50%, -50%) scale(0.5); opacity: 0; }
      100% { transform: translate(-50%, -50%) scale(1); opacity: 1; }
    }

    /* Video Modal (hidden initially) */
    .video-container {
      display: none;
    }
    .video-container video {
      width: 100%;
      height: 100%;
      border-radius: 20px;
    }
  </style>
</head>
<body>

  <!-- Flashcard -->
  <div class="flashcard" id="flashcard">
    <div class="heading" id="heading">Let's Learn Numbers</div>
    <div class="card-content">
      <img src="../../kids/num1.jpg" id="cardImg" class="card-img" alt="Card">
      <div>
        <div class="digit" id="digit">1</div>
        <div class="word" id="word">One</div>
      </div>
    </div>
    <p class="instruction" id="instruction">Count 1 apple.</p>
  </div>

  <div class="buttons" id="navButtons">
    <button class="prev-btn" onclick="prevCard()">⬅ Previous</button>
    <button class="speak-btn" onclick="speakContent()">🔊 Speak</button>
    <button class="next-btn" onclick="nextCard()">Next ➡</button>
  </div>

  <!-- Popup -->
  <div class="popup" id="popup">
    <img src="../../kids/greatjob.png" alt="Great Job">
    <h2>Great Job! 🎉</h2>
  </div>

  <!-- Video Containers -->
  <div class="video-container" id="videoNumbers">
    <video id="learningVideoNumbers" controls>
      <source src="../../kids/numbersvideo.mp4" type="video/mp4">
    </video>
    <div class="video-buttons">
      <button class="prev-btn" onclick="backToFlashcards()">⬅ Previous</button>
      <button class="replay-btn" onclick="replayVideo('Numbers')">🔄 Replay</button>
      <button class="next-btn" onclick="goToShapes()">Next ➡</button>
    </div>
  </div>

  <div class="video-container" id="videoShapes">
    <video id="learningVideoShapes" controls>
      <source src="../../kids/shapesvideo.mp4" type="video/mp4">
    </video>
    <div class="video-buttons">
      <button class="prev-btn" onclick="goBackToNumbers()">⬅ Previous</button>
      <button class="replay-btn" onclick="replayVideo('Shapes')">🔄 Replay</button>
      <button class="next-btn" onclick="goToComparison()">Next ➡</button>
    </div>
  </div>

  <div class="video-container" id="videoComparison">
    <video id="learningVideoComparison" controls>
      <source src="../../kids/comparisonvideo.mp4" type="video/mp4">
    </video>
    <div class="video-buttons">
      <button class="prev-btn" onclick="goBackToShapes()">⬅ Previous</button>
      <button class="replay-btn" onclick="replayVideo('Comparison')">🔄 Replay</button>
      <button class="home-btn" onclick="goHome()">🏠 Go to Maths Page</button>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>
  <script>
    const sections = {
      numbers: [
        {digit:"1", word:"One", img:"../../kids/num1.jpg", instruction:"Count 1 pineapple."},
        {digit:"2", word:"Two", img:"../../kids/num2.jpg", instruction:"Count 2 cherries."},
        {digit:"3", word:"Three", img:"../../kids/num3.jpg", instruction:"Count 3 apples."},
        {digit:"4", word:"Four", img:"../../kids/num4.jpg", instruction:"Count 4 tomatoes."},
        {digit:"5", word:"Five", img:"../../kids/num5.jpg", instruction:"Count 5 blueberries."},
        {digit:"6", word:"Six", img:"../../kids/num6.jpg", instruction:"Count 6 strawberries."},
        {digit:"7", word:"Seven", img:"../../kids/num7.jpg", instruction:"Count 7 mangoes."},
        {digit:"8", word:"Eight", img:"../../kids/num8.jpg", instruction:"Count 8 lemons."},
        {digit:"9", word:"Nine", img:"../../kids/num9.jpg", instruction:"Count 9 eggplants."},
        {digit:"10", word:"Ten", img:"../../kids/num10.jpg", instruction:"Count 10 bananas."}
      ],
      shapes: [
        {digit:"●", word:"Circle", img:"../../kids/circle_ball.jpg", instruction:"A circle is round, like a ball."},
        {digit:"■", word:"Square", img:"../../kids/square_box.jpg", instruction:"A square has 4 equal sides, like a box."},
        {digit:"▲", word:"Triangle", img:"../../kids/triangle_pizza.jpg", instruction:"A triangle has 3 sides, like a pizza slice."},
        {digit:"▬", word:"Rectangle", img:"../../kids/rectangle_book.jpg", instruction:"A rectangle looks like a book cover."}
      ],
      comparison: [
        {digit:"5 > 3", word:"Greater Than", img:"../../kids/apples.png", instruction:"5 apples are more than 3 apples."},
        {digit:"2 < 7", word:"Less Than", img:"../../kids/oranges.png", instruction:"2 oranges are less than 7 oranges."},
        {digit:"4 = 4", word:"Equal To", img:"../../kids/bananas.png", instruction:"4 bananas are equal to 4 bananas."}
      ]
    };

    let currentSection = "numbers";
    let current = 0;

    function updateCard() {
      const card = sections[currentSection][current];
      document.getElementById("digit").innerText = card.digit;
      document.getElementById("word").innerText = card.word;
      document.getElementById("cardImg").src = card.img;
      document.getElementById("instruction").innerText = card.instruction;

      if(currentSection==="numbers") document.getElementById("heading").innerText = "Let's Learn Numbers";
      if(currentSection==="shapes") document.getElementById("heading").innerText = "Let's Learn Shapes";
      if(currentSection==="comparison") document.getElementById("heading").innerText = "Let's Learn Comparison";

      speakContent();
    }

    function nextCard() {
      if(current < sections[currentSection].length-1){
        current++;
        updateCard();
      } else {
        showPopup();
      }
    }

    function prevCard() {
      if(current > 0){
        current--;
        updateCard();
      }
    }

    function speakContent() {
      const card = sections[currentSection][current];
      const msg = new SpeechSynthesisUtterance(card.word);
      msg.lang = "en-US";
      msg.rate = 0.9;
      msg.pitch = 1.1;
      window.speechSynthesis.cancel();
      window.speechSynthesis.speak(msg);
    }

    function showPopup() {
      document.getElementById("popup").style.display="block";
      confetti({ particleCount:200, spread:100, origin:{y:0.6} });

      setTimeout(()=>{
        document.getElementById("popup").style.display="none";
        document.getElementById("flashcard").style.display="none";
        document.getElementById("navButtons").style.display="none";

        if(currentSection==="numbers") document.getElementById("videoNumbers").style.display="flex";
        if(currentSection==="shapes") document.getElementById("videoShapes").style.display="flex";
        if(currentSection==="comparison") document.getElementById("videoComparison").style.display="flex";

        playVideo(currentSection);
      }, 3000);
    }

    function playVideo(section){
      const video = document.getElementById("learningVideo"+capitalize(section));
      if(video){ video.currentTime = 0; video.play(); }
    }

    function replayVideo(section){
      const vid = document.getElementById("learningVideo"+section);
      if(vid){ vid.currentTime=0; vid.play(); }
    }

    function stopAllVideos() {
      ["Numbers","Shapes","Comparison"].forEach(type=>{
        const v=document.getElementById("learningVideo"+type);
        const c=document.getElementById("video"+type);
        if(v){ v.pause(); v.currentTime=0; }
        if(c){ c.style.display="none"; }
      });
    }

    function backToFlashcards(){
      stopAllVideos();
      currentSection="numbers"; current=0;
      document.getElementById("flashcard").style.display="block";
      document.getElementById("navButtons").style.display="flex";
      updateCard();
    }
    function goToShapes(){
      stopAllVideos();
      currentSection="shapes"; current=0;
      document.getElementById("flashcard").style.display="block";
      document.getElementById("navButtons").style.display="flex";
      updateCard();
    }
    function goBackToNumbers(){
      stopAllVideos();
      currentSection="numbers"; current=0;
      document.getElementById("flashcard").style.display="block";
      document.getElementById("navButtons").style.display="flex";
      updateCard();
    }
    function goToComparison(){
      stopAllVideos();
      currentSection="comparison"; current=0;
      document.getElementById("flashcard").style.display="block";
      document.getElementById("navButtons").style.display="flex";
      updateCard();
    }
    function goBackToShapes(){
      stopAllVideos();
      currentSection="shapes"; current=0;
      document.getElementById("flashcard").style.display="block";
      document.getElementById("navButtons").style.display="flex";
      updateCard();
    }

    function goHome(){ window.location.href="maths.php"; }
    function capitalize(str){ return str.charAt(0).toUpperCase()+str.slice(1); }

    // On load
    document.addEventListener("DOMContentLoaded", () => {
      document.getElementById("flashcard").style.display = "block";
      document.getElementById("navButtons").style.display = "flex";
      ["videoNumbers","videoShapes","videoComparison"].forEach(id=>{
        document.getElementById(id).style.display = "none";
      });
      updateCard();
    });
  </script>
</body>
</html>
