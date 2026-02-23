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
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Fun Games — NeuroLearn</title>
<script src="https://cdn.tailwindcss.com"></script>
<style>
body {
    font-family: 'Poppins', sans-serif;
    background: url('../../kids/engbk.jpg') no-repeat center center fixed;
    background-size: cover;
    text-align: center;
    padding: 50px 20px;
    color: #fff;
}
h1 {
    font-size: 5rem; /* Big fun heading */
    font-weight: 900;
    margin-bottom: 60px;
    color: #ff6b6b;
    text-shadow: 2px 2px 15px rgba(0,0,0,0.6);
}
.container {
    display: flex;
    justify-content: center;
    flex-wrap: wrap;
    gap: 50px;
    margin-bottom: 50px;
}
.game-card {
    background: rgba(255,255,255,0.95);
    color: #214;
    width: 320px; /* Fixed box size */
    padding: 30px;
    border-radius: 25px;
    box-shadow: 0 15px 40px rgba(0,0,0,0.25);
    display: flex;
    flex-direction: column;
    align-items: center;
    transition: transform 0.3s, box-shadow 0.3s;
    cursor: pointer;
}
.game-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 25px 50px rgba(0,0,0,0.35);
}
.game-card img {
    width: 140px;
    height: 140px;
    object-fit: contain;
    margin-bottom: 20px;
}
.game-card h2 {
    font-size: 2rem; /* Bigger title */
    font-weight: 800;
    margin-bottom: 10px;
}
.game-card p {
    font-size: 1.1rem;
    font-weight: 500;
    color: #555;
    text-align: center;
}
button {
    margin: 30px 0;
    padding: 18px 40px;
    border-radius: 20px;
    font-size: 1.8rem;
    font-weight: bold;
    border: none;
    cursor: pointer;
    color: white;
    background: #ff6b6b;
    transition: background 0.3s, transform 0.3s;
}
button:hover { 
    background: #e05555; 
    transform: scale(1.05);
}
</style>
</head>
<body>

<h1>🎉 Fun Games 🎉</h1>

<div class="container">
    <div class="game-card" onclick="location.href='tracing.php'">
        <img src="../../kids/english.png" alt="Tracing Game">
        <h2>Tracing Letters</h2>
        <p>Practice drawing letters in a fun way!</p>
    </div>

    <div class="game-card" onclick="location.href='matching.php'">
        <img src="../../kids/english.png" alt="Matching Game">
        <h2>Match Letters</h2>
        <p>Match capital letters with their small letters!</p>
    </div>
</div>

<!-- Fixed Back button -->
<button onclick="window.location.href='select_subject.php'">⬅ Back to Subjects</button>

</body>
</html>