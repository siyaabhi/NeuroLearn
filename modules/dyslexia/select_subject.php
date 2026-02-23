<?php
// modules/dyslexia/select_subject.php
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
<title>Choose Your Subject — Dyslexia Path</title>
<script src="https://cdn.tailwindcss.com"></script>
<link href="https://fonts.googleapis.com/css2?family=Fredoka+One:wght@400&family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
<style>
  :root{
    --card-w: 340px;
    --track-h: 480px;
  }
  html,body{height:100%;margin:0;font-family:'Poppins',sans-serif;}
  body{
    background: url('../../kids/background.jpg') center/cover no-repeat fixed;
    color:#1a1a2e;
  }

  .page-wrap{
    max-width:1400px;
    margin: 2rem auto 4rem;
    padding: 0 20px;
  }
  .title {
    font-family:'Fredoka One',cursive;
    text-align:center;
    font-size:3rem;
    color:#6a5acd; /* purple tone */
    margin-bottom:.25rem;
  }
  .subtitle {
    text-align:center;
    font-style:italic;
    color:#374151;
    margin-bottom:1.6rem;
    font-size:1.05rem;
  }

  .scroll-viewport{
    width:100%;
    overflow-x:auto;
    -webkit-overflow-scrolling:touch;
    padding: 2rem 0;
  }
  .scroll-viewport::-webkit-scrollbar{ height:10px; }
  .scroll-viewport::-webkit-scrollbar-thumb{ background:#c4c4c4;border-radius:6px; }

  .scroll-track{
    position:relative;
    width: 1800px;
    min-height: var(--track-h);
    margin: 0 40px;
    display:flex;
    align-items:center;
    gap: 70px;
    padding: 40px 64px;
  }

  .track-path{
    position:absolute;
    left:0;
    top:50%;
    transform:translateY(-50%);
    width:100%;
    height:160px;
    z-index:1;
    pointer-events:none;
    filter: drop-shadow(0 6px 10px rgba(0,0,0,0.06));
  }

  .subject-card{
    position:relative;
    z-index:2;
    width: var(--card-w);
    min-width: var(--card-w);
    background: rgba(255,255,255,0.95);
    border-radius:18px;
    padding:22px;
    display:flex;
    flex-direction:column;
    align-items:center;
    gap:12px;
    box-shadow: 0 20px 40px rgba(0,0,0,0.08);
    text-decoration:none;
    transition: transform .28s ease, box-shadow .28s ease;
    border:3px solid transparent;
  }
  .subject-card:hover{ transform: translateY(-10px); box-shadow:0 25px 55px rgba(0,0,0,0.12); }

  .subject-image{
    width:180px;
    height:auto;
    display:block;
    margin:0 auto;
  }
  .subject-title{
    font-family:'Fredoka One',cursive;
    font-size:1.5rem;
    margin-top:4px;
  }
  .subject-sub{
    font-size:0.95rem;
    color:#4b5563;
    text-align:center;
    line-height:1.4;
  }
  .cta {
    margin-top:8px;
    padding:10px 16px;
    border-radius:999px;
    font-weight:600;
    font-size:.95rem;
  }

  /* subject colors */
  .english-card{ border-color:#ff6b6b; }
  .english-card .subject-title{ color:#ff6b6b; }
  .english-card .cta{ background:#ffe4e6; color:#b91c1c; }

  .evs-card{ border-color:#4ecdc4; }
  .evs-card .subject-title{ color:#059669; }
  .evs-card .cta{ background:#d1fae5; color:#065f46; }

  .maths-card{ border-color:#3b82f6; }
  .maths-card .subject-title{ color:#2563eb; }
  .maths-card .cta{ background:#dbeafe; color:#1e3a8a; }

  /* premium locked */
  .locked-card{
    border-color:#d97706;
    opacity:0.85;
    background: linear-gradient(135deg, #fff7ed, #fef3c7);
  }
  .locked-card .subject-title{ color:#b45309; }
  .locked-card .lock-icon{
    font-size:2rem;
    color:#f59e0b;
    margin-bottom:6px;
    animation: shimmer 2s infinite linear;
  }
  @keyframes shimmer{
    0%{opacity:0.5;}
    50%{opacity:1;}
    100%{opacity:0.5;}
  }

  @media (max-width:900px){
    .scroll-track{ width:1200px; gap:40px; }
    .subject-image{ width:140px; }
  }
</style>
</head>
<body>
  <div class="page-wrap">
    <h1 class="title">Choose Your Subject 📚</h1>
    <p class="subtitle">“Words are windows to the world — let’s open them together!”</p>

    <div class="scroll-viewport">
      <div class="scroll-track">

        <!-- Wavy Path -->
        <svg class="track-path" viewBox="0 0 1800 160" preserveAspectRatio="none">
          <path d="M0 100
                   C150 30, 300 170, 450 100
                   C600 30, 750 170, 900 100
                   C1050 30, 1200 170, 1350 100
                   L1800 100"
                stroke="url(#grad)" stroke-width="8" fill="none"
                stroke-linecap="round" stroke-dasharray="20 12" opacity="0.85"/>
          <defs>
            <linearGradient id="grad" x1="0%" y1="0%" x2="100%" y2="0%">
              <stop offset="0%" stop-color="#6a5acd"/>
              <stop offset="50%" stop-color="#a78bfa"/>
              <stop offset="100%" stop-color="#3b82f6"/>
            </linearGradient>
          </defs>
        </svg>

        <!-- English -->
        <a href="english.php" class="subject-card english-card">
          <img src="../../kids/english.png" alt="English" class="subject-image" />
          <div class="subject-title">English</div>
          <div class="subject-sub">Boost reading, spelling & vocabulary with fun stories and activities.</div>
          <div class="cta">Start Reading →</div>
        </a>

        <!-- EVS -->
        <a href="evs.php" class="subject-card evs-card">
          <img src="../../kids/evs.png" alt="EVS" class="subject-image" />
          <div class="subject-title">EVS</div>
          <div class="subject-sub">Discover nature, environment & science with playful exploration.</div>
          <div class="cta">Explore Nature →</div>
        </a>

        <!-- Maths -->
        <a href="maths.php" class="subject-card maths-card">
          <img src="../../kids/maths.png" alt="Maths" class="subject-image" />
          <div class="subject-title">Maths</div>
          <div class="subject-sub">Learn numbers, shapes & problem-solving through fun challenges.</div>
          <div class="cta">Play with Numbers →</div>
        </a>

        <!-- Premium Placeholder 1 -->
        <div class="subject-card locked-card">
          <div class="lock-icon">🔒</div>
          <div class="subject-title">Coming Soon</div>
          <div class="subject-sub">Unlock more exciting content with <b>Premium Membership</b>.</div>
        </div>

        <!-- Premium Placeholder 2 -->
        <div class="subject-card locked-card">
          <div class="lock-icon">🔒</div>
          <div class="subject-title">Coming Soon</div>
          <div class="subject-sub">Exclusive Dyslexia-friendly games & resources for premium learners.</div>
        </div>

      </div>
    </div>
  </div>
</body>
</html>