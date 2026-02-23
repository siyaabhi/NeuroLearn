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
<meta name="viewport" content="width=device-width,initial-scale=1" />
<title>Choose Your Subject — NeuroLearn</title>
<script src="https://cdn.tailwindcss.com"></script>
<link href="https://fonts.googleapis.com/css2?family=Fredoka+One:wght@400&family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
<style>
  :root{
    --card-w: 340px;
    --track-h: 460px;
  }
  html,body{height:100%;margin:0;font-family:'Poppins',sans-serif;}
  body{
    background: url('../../kids/background.jpg') center/cover no-repeat fixed;
    -webkit-font-smoothing:antialiased;
    -moz-osx-font-smoothing:grayscale;
    color:#214;
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
    color:#2fbdb9;
    margin-bottom:.25rem;
  }
  .subtitle {
    text-align:center;
    font-style:italic;
    color:#2b3b3b;
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
  .scroll-viewport::-webkit-scrollbar-thumb{ background:#cfcfcf;border-radius:6px; }
  .scroll-track{
    position:relative;
    width: 2000px;
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
  .subject-card, .locked-card{
    position:relative;
    z-index:2;
    width: var(--card-w);
    min-width: var(--card-w);
    border-radius:16px;
    padding:20px;
    display:flex;
    flex-direction:column;
    align-items:center;
    gap:10px;
    box-shadow: 0 18px 40px rgba(16,32,64,0.08);
    text-decoration:none;
    color:inherit;
    transition: transform .28s cubic-bezier(.2,.8,.2,1), box-shadow .28s;
    border:3px solid transparent;
  }
  .subject-card:hover{ transform: translateY(-12px); box-shadow: 0 30px 60px rgba(16,32,64,0.12); }
  .subject-image{
    width:190px;
    height:auto;
    display:block;
    margin:0 auto;
    object-fit:contain;
  }
  .subject-title{
    font-family:'Fredoka One',cursive;
    font-size:1.5rem;
    margin:6px 0 0;
    text-align:center;
  }
  .subject-sub{
    font-size:0.98rem;
    color:#4b5563;
    text-align:center;
    line-height:1.45;
    padding: 0 6px;
  }
  .mini-quote {
    font-size:0.85rem;
    font-style:italic;
    color:#6b7280;
    text-align:center;
    margin-top:4px;
  }
  .cta {
    margin-top:8px;
    padding:10px 16px;
    border-radius:999px;
    font-weight:600;
    font-size:.95rem;
    cursor:pointer;
    border:none;
  }
  /* subject colors */
  .english-card{ background: rgba(255,255,255,0.98); border-color:#ff6b6b; }
  .english-card .subject-title{ color:#ff6b6b; }
  .english-card .cta{ background:#ffdceb; color:#e05587; }
  .evs-card{ background: rgba(255,255,255,0.98); border-color:#4ecdc4; }
  .evs-card .subject-title{ color:#2fbdb9; }
  .evs-card .cta{ background:#e6fffb; color:#06998f; }
  .maths-card{ background: rgba(255,255,255,0.98); border-color:#45b7d1; }
  .maths-card .subject-title{ color:#45b7d1; }
  .maths-card .cta{ background:#e8f4ff; color:#1677ff; }
  /* Locked Premium Cards */
  .locked-card{
    background: linear-gradient(135deg, #FFD700, #FFC107, #FFD700);
    background-size: 300% 300%;
    animation: shimmer 3s infinite linear;
    color: white;
    text-align: center;
  }
  .locked-card .subject-sub{ color: rgba(255,255,255,0.9); }
  .unlock-text {
    font-size:0.85rem;
    margin-top:6px;
    background: rgba(255,255,255,0.25);
    padding:4px 10px;
    border-radius:12px;
  }
  @keyframes shimmer {
    0% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
    100% { background-position: 0% 50%; }
  }
</style>
</head>
<body>
  <div class="page-wrap">
    <h1 class="title">Choose Your Subject 📚</h1>
    <p class="subtitle">“Every big journey begins with a small step — let’s take yours today!”</p>

    <div class="scroll-viewport">
      <div class="scroll-track">
        <!-- Path -->
        <svg class="track-path" viewBox="0 0 2000 160" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
          <defs>
            <linearGradient id="g1" x1="0" x2="1">
              <stop offset="0%" stop-color="#ff6b6b"/>
              <stop offset="40%" stop-color="#ffd1d6"/>
              <stop offset="60%" stop-color="#bfeee6"/>
              <stop offset="100%" stop-color="#45b7d1"/>
            </linearGradient>
          </defs>
          <path d="M0 100 C120 20, 240 140, 360 80 C480 20, 600 140, 720 80 C840 20, 960 140, 1080 80 C1200 20, 1320 140, 1440 80 C1560 20, 1680 140, 1800 80 L2000 80"
                stroke="url(#g1)" stroke-width="8" fill="none" stroke-linecap="round"
                stroke-dasharray="18 12" opacity="0.9"/>
        </svg>
        <!-- English -->
        <a href="english.php" class="subject-card english-card">
          <img src="../../kids/english.png" alt="English" class="subject-image" />
          <div class="subject-title">English</div>
          <div class="subject-sub">Learn ABCs, reading, and storytelling with fun interactive activities.</div>
          <div class="mini-quote">"Words are the wings of imagination."</div>
          <div class="cta">Start Reading →</div>
        </a>
        <!-- EVS -->
        <a href="evs.php" class="subject-card evs-card">
          <img src="../../kids/evs.png" alt="EVS" class="subject-image" />
          <div class="subject-title">EVS</div>
          <div class="subject-sub">Discover nature, animals, and the environment through playful exploration.</div>
          <div class="mini-quote">"The Earth is full of stories — let's read them."</div>
          <div class="cta">Explore Nature →</div>
        </a>
        <!-- Maths -->
        <a href="maths.php" class="subject-card maths-card">
          <img src="../../kids/maths.png" alt="Maths" class="subject-image" />
          <div class="subject-title">Maths</div>
          <div class="subject-sub">Fun with numbers, shapes, and puzzles for an exciting learning journey.</div>
          <div class="mini-quote">"Numbers are the poetry of logic."</div>
          <div class="cta">Play with Numbers →</div>
        </a>
        <!-- Locked Placeholder 1 -->
        <div class="locked-card">
          <div style="font-size:2rem;">🔑</div>
          <div class="subject-title">Coming Soon</div>
          <div class="subject-sub">An exciting adventure is on the horizon.</div>
          <div class="mini-quote">"Stay curious — magic is coming."</div>
          <div class="unlock-text">Unlock with Premium Membership</div>
        </div>
        <!-- Locked Placeholder 2 -->
        <div class="locked-card">
          <div style="font-size:2rem;">🔑</div>
          <div class="subject-title">Coming Soon</div>
          <div class="subject-sub">Something special is being prepared for you.</div>
          <div class="mini-quote">"Adventure awaits just beyond the lock."</div>
          <div class="unlock-text">Unlock with Premium Membership</div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>