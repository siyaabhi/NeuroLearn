<?php
// modules/dyscalculia/select_subject.php
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
<meta name="viewport" content="width=device-width,initial-scale=1" />
<title>Dyscalculia Path — NeuroLearn</title>
<script src="https://cdn.tailwindcss.com"></script>
<link href="https://fonts.googleapis.com/css2?family=Fredoka+One&family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
<style>
  body {
    margin:0;
    font-family:'Poppins',sans-serif;
    background:#f0f8ff;
    overflow:hidden;
  }
  .hero {
    position: relative;
    width:100%;
    height:100vh;
    background: url('../../kids/dyscalculia-bg.png') center/cover no-repeat;
    display:flex;
    justify-content:center;
    align-items:center;
    flex-direction:column;
    text-align:center;
    padding:20px;
  }
  .overlay {
    background: linear-gradient(135deg, #fff7e6, #e6faff);
    border: 4px dashed #ffd966;
    padding: 40px;
    border-radius: 30px;
    box-shadow:0 12px 25px rgba(0,0,0,0.1);
    max-width:640px;
    animation: floatBox 4s ease-in-out infinite;
    z-index:2;
    position:relative;
  }
  @keyframes floatBox {
    0%,100% { transform: translateY(0); }
    50% { transform: translateY(-6px); }
  }
  .title {
    font-family:'Fredoka One',cursive;
    font-size:2.7rem;
    color:#ff914d;
    margin-bottom:.5rem;
  }
  .subtitle {
    font-size:1.2rem;
    font-style:italic;
    color:#444;
    margin: 0 auto 1.5rem;
    background: #fffacd;
    padding: 10px 14px;
    border-radius: 12px;
    display:inline-block;
    box-shadow: 0 3px 6px rgba(0,0,0,0.1);
  }
  .buttons {
    display:flex;
    flex-direction:column;
    gap:18px;
    margin-top:10px;
  }
  .btn {
    display:block;
    padding:16px 26px;
    font-weight:600;
    font-size:1.2rem;
    border-radius:15px;
    text-decoration:none;
    transition:transform 0.25s ease, box-shadow 0.25s ease;
  }
  .btn:hover {
    transform:translateY(-6px) scale(1.05);
    box-shadow:0 8px 18px rgba(0,0,0,0.15);
  }
  .btn-red { background:#ff6b6b; color:#fff; }
  .btn-green { background:#4ecdc4; color:#fff; }
  .btn-blue { background:#45b7d1; color:#fff; }

  /* Floating doodles */
  .doodle {
    position:absolute;
    font-size:2.5rem;
    opacity:0.7;
    animation: floatDoodle 6s ease-in-out infinite;
    z-index:1;
  }
  @keyframes floatDoodle {
    0%,100% { transform: translateY(0) rotate(0deg); }
    50% { transform: translateY(-20px) rotate(12deg); }
  }
  .d1 { top:15%; left:10%; animation-delay:0s; color:#ff6b6b; }
  .d2 { top:25%; right:15%; animation-delay:1s; color:#4ecdc4; }
  .d3 { bottom:20%; left:20%; animation-delay:2s; color:#45b7d1; }
  .d4 { bottom:15%; right:20%; animation-delay:3s; color:#ff914d; }
</style>
</head>
<body>

<div class="hero">
  <!-- Floating doodles -->
  <div class="doodle d1">➕</div>
  <div class="doodle d2">✖</div>
  <div class="doodle d3">➗</div>
  <div class="doodle d4">🔢</div>

  <!-- Main overlay -->
  <div class="overlay">
    <h1 class="title">Dyscalculia Learning Path 🔢</h1>
    <p class="subtitle">“Math isn’t about speed — it’s about understanding. Let’s make numbers your friends!”</p>

    <div class="buttons">
      <a href="numbers.php" class="btn btn-red">📊 Numbers</a>
      <a href="prewriting.php" class="btn btn-green">🧩 Pre-writing</a>
      <a href="memory.php" class="btn btn-blue">🧠 Memory Games</a>
    </div>
  </div>
</div>

</body>
</html>