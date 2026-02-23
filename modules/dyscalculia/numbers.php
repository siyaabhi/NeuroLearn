<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Learn Numbers — NeuroLearn</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    body {
      background: url('../../kids/numbg.jpg') center/cover no-repeat fixed;
      font-family: 'Poppins', sans-serif;
    }
    .flashcard {
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
        linear-gradient(45deg, #ff6b6b, #ffd93d, #6bcbee, #a1e887);
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: space-around;
      text-align: center;
    }
    .heading {
      font-size: 2.2rem;
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
    .buttons {
      margin-top: 25px;
      display: flex;
      justify-content: center;
      gap: 40px;
    }
    button {
      padding: 20px 45px;
      border-radius: 999px;
      border: none;
      font-size: 1.5rem;
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

    /* Congrats Popup */
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
    .popup img {
      width: 200px;
      margin-bottom: 20px;
    }
    .popup h2 {
      font-size: 2.5rem;
      font-weight: bold;
      color: #ff4d6d;
    }
    @keyframes pop {
      0% { transform: translate(-50%, -50%) scale(0.5); opacity: 0; }
      100% { transform: translate(-50%, -50%) scale(1); opacity: 1; }
    }
    /* Video Modal */
    .video-container {
      display: none;
      position: fixed;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      width: 80%;
      background: #fff;
      padding: 20px;
      border-radius: 20px;
      box-shadow: 0 15px 40px rgba(0,0,0,0.3);
      z-index: 1000;
      text-align: center;
    }
    .video-container video {
      width: 100%;
      border-radius: 20px;
    }
    .video-buttons {
      margin-top: 15px;
      display: flex;
      justify-content: center;
      gap: 30px;
    }
    .video-buttons button {
      padding: 15px 35px;
      font-size: 1.2rem;
      border-radius: 25px;
      border: none;
      cursor: pointer;
      font-weight: bold;
    }
    .replay-btn { background: #6bcbee; color: white; }
    .home-btn { background: #ff6b6b; color: white; }
  </style>
</head>
<body>

  <div class="flashcard" id="flashcard">
    <div class="heading">Let's Learn Numbers</div>
    <div class="card-content">
      <img src="../../kids/num1.jpg" id="cardImg" class="card-img" alt="Number Card">
      <div>
        <div class="digit" id="digit">1</div>
        <div class="word" id="word">One</div>
      </div>
    </div>
    <p class="instruction" id="instruction">Draw a straight line down from top to bottom.</p>
  </div>

  <div class="buttons">
    <button class="prev-btn" onclick="prevCard()">⬅ Previous</button>
    <button class="speak-btn" onclick="speakNumber()">🔊 Speak</button>
    <button class="next-btn" onclick="nextCard()">Next ➡</button>
  </div>

  <!-- Congrats Popup -->
  <div class="popup" id="popup">
    <img src="../../kids/greatjob.png" alt="Great Job">
    <h2>Great Job! 🎉</h2>
  </div>

  <!-- Video Modal -->
  <div class="video-container" id="videoContainer">
    <video id="learningVideo" controls>
      <source src="../../kids/numbersvideo.mp4" type="video/mp4">
      Your browser does not support video.
    </video>
    <div class="video-buttons">
      <button class="replay-btn" onclick="replayVideo()">🔄 Replay</button>
      <button class="home-btn" onclick="goHome()">🏠 Go to Dyscalculia</button>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>
  <script>
    const flashcards = [
      {digit: "1", word: "One", img: "../../kids/num1.jpg", instruction: "Draw a straight line down from top to bottom."},
      {digit: "2", word: "Two", img: "../../kids/num2.jpg", instruction: "Curve around and go across to make number 2."},
      {digit: "3", word: "Three", img: "../../kids/num3.jpg", instruction: "Draw two big curves, one on top of the other."},
      {digit: "4", word: "Four", img: "../../kids/num4.jpg", instruction: "Draw a small line down, then across, then a big line down."},
      {digit: "5", word: "Five", img: "../../kids/num5.jpg", instruction: "Start across, down, then make a curve at the bottom."},
      {digit: "6", word: "Six", img: "../../kids/num6.jpg", instruction: "Make a curve around and join it with a loop."},
      {digit: "7", word: "Seven", img: "../../kids/num7.jpg", instruction: "Draw a line across and then slant it down."},
      {digit: "8", word: "Eight", img: "../../kids/num8.jpg", instruction: "Make two small circles, one on top of the other."},
      {digit: "9", word: "Nine", img: "../../kids/num9.jpg", instruction: "Make a small circle and then a straight line down."},
      {digit: "10", word: "Ten", img: "../../kids/num10.jpg", instruction: "Draw a straight line for 1 and a circle for 0."}
    ];

    let current = 0;

    function updateCard() {
      const card = flashcards[current];
      document.getElementById("digit").innerText = card.digit;
      document.getElementById("word").innerText = card.word;
      document.getElementById("cardImg").src = card.img;
      document.getElementById("instruction").innerText = card.instruction;
      speakNumber();
    }

    function nextCard() {
      if (current < flashcards.length - 1) {
        current++;
        updateCard();
      } else {
        showPopup();
      }
    }

    function prevCard() {
      if (current > 0) {
        current--;
        updateCard();
      }
    }

    function speakNumber() {
      const word = flashcards[current].word;
      const msg = new SpeechSynthesisUtterance(word);
      msg.lang = "en-US";
      msg.rate = 0.9;
      msg.pitch = 1.1;
      window.speechSynthesis.cancel();
      window.speechSynthesis.speak(msg);
    }

    function showPopup() {
      const popup = document.getElementById("popup");
      popup.style.display = "block";

      // Confetti burst
      confetti({
        particleCount: 200,
        spread: 100,
        origin: { y: 0.6 }
      });

      // Hide popup after 5 sec and show video
      setTimeout(() => {
        popup.style.display = "none";
        document.getElementById("videoContainer").style.display = "block";
        document.getElementById("learningVideo").play();
      }, 5000);
    }

    function replayVideo() {
      const video = document.getElementById("learningVideo");
      video.currentTime = 0;
      video.play();
    }

    function goHome() {
      window.location.href = "select_subject.php"; // ✅ Redirect to Dyscalculia main page
    }

    updateCard();
  </script>
</body>
</html>
