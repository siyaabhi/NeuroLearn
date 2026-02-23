<?php
include 'includes/db.php';
session_start();

// Redirect to login if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Handle form submission
if (isset($_POST['issue'])) {
    $issue = $_POST['issue'];

    // Update user's selected issue
    $stmt = $conn->prepare("UPDATE users SET issue = ? WHERE id = ?");
    $stmt->bind_param("si", $issue, $user_id);
    $stmt->execute();

    $_SESSION['issue'] = $issue;

    // Redirect to relevant page
    switch ($issue) {
        case 'ADHD':
            header("Location: modules/adhd/select_subject.php");
            break;
        case 'Dyslexia':
            header("Location: modules/dyslexia/select_subject.php");
            break;
        case 'Dyscalculia':
            header("Location: modules/dyscalculia/select_subject.php");
            break;
        case 'None':   
            header("Location: modules/none/about.php");
            break;
        default:
            header("Location: dashboard.php");
    }
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Select Learning Path - NeuroLearn</title>
<script src="https://cdn.tailwindcss.com"></script>
<style>
    body {
        background: linear-gradient(to bottom right, #fdfdfd, #f9f9ff);
        font-family: 'Poppins', sans-serif;
        overflow-x: hidden;
    }

    .section-card {
        border-radius: 15px;
        padding: 20px;
        color: white;
        cursor: pointer;
        animation: bounceIn 1s ease-in-out;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    /* Hover wiggle effect */
    .section-card:hover {
        transform: scale(1.05) rotate(-1deg);
        box-shadow: 0 15px 30px rgba(0,0,0,0.2);
        animation: wiggle 0.3s ease-in-out;
    }

    @keyframes wiggle {
        0%, 100% { transform: rotate(0deg) scale(1.05); }
        25% { transform: rotate(1deg) scale(1.05); }
        50% { transform: rotate(-1deg) scale(1.05); }
        75% { transform: rotate(1deg) scale(1.05); }
    }

    /* Bounce on load */
    @keyframes bounceIn {
        0% { transform: scale(0.8); opacity: 0; }
        60% { transform: scale(1.05); opacity: 1; }
        100% { transform: scale(1); }
    }

    .adhd { background-color: #f87171; }
    .dyslexia { background-color: #fbbf24; }
    .dyscalculia { background-color: #60a5fa; }
    .none { background-color: #34d399; }

    .kid-img {
        width: 100px;
        height: auto;
        margin: 0 auto 10px;
    }

    /* Floating Shapes */
    .floating-shape {
        position: absolute;
        border-radius: 50%;
        opacity: 0.6;
        animation: float 8s ease-in-out infinite;
        z-index: -1;
    }
    .shape1 { width: 80px; height: 80px; background: #fcd34d; top: 5%; left: 10%; animation-delay: 0s; }
    .shape2 { width: 60px; height: 60px; background: #f9a8d4; top: 20%; right: 15%; animation-delay: 2s; }
    .shape3 { width: 100px; height: 100px; background: #a7f3d0; bottom: 10%; left: 5%; animation-delay: 4s; }
    .shape4 { width: 50px; height: 50px; background: #bfdbfe; bottom: 20%; right: 20%; animation-delay: 6s; }

    @keyframes float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-20px); }
    }
</style>

    
</head>
<body class="relative">

<!-- Navigation Bar -->
<nav class="bg-purple-600 p-4 text-white shadow-md flex justify-between items-center">
    <h1 class="text-2xl font-bold">🌟 NeuroLearn</h1>
    <div class="space-x-6">
        <a href="dashboard.php" class="hover:underline">Home</a>
        <a href="#about" class="hover:underline">About Us</a>
        <a href="#contact" class="hover:underline">Contact</a>
    </div>
</nav>

<!-- Floating Shapes -->
<div class="floating-shape shape1"></div>
<div class="floating-shape shape2"></div>
<div class="floating-shape shape3"></div>
<div class="floating-shape shape4"></div>

<!-- Header -->
<div class="text-center mt-10 px-4">
    <h2 class="text-4xl font-extrabold text-purple-700 drop-shadow-md">
        Welcome, <?= htmlspecialchars($_SESSION['name']) ?>! 🌟
    </h2>
    <p class="mt-4 text-lg text-gray-600 max-w-2xl mx-auto">
        At NeuroLearn, we create personalized, fun, and interactive learning paths for children with unique learning needs — from ADHD to Dyslexia and beyond.
        Pick your path and let’s begin this exciting journey together!
    </p>
</div>

<!-- Learning Path Selection -->
<form method="POST" class="grid grid-cols-1 md:grid-cols-4 gap-6 max-w-6xl mx-auto mt-10">

    <!-- ADHD -->
    <button type="submit" name="issue" value="ADHD" class="section-card adhd">
        <img src="kids/adhd.png" alt="ADHD" class="kid-img">
        <h2 class="text-2xl font-bold">ADHD</h2>
        <p class="text-sm mt-2">Attention Deficit Hyperactivity Disorder — helps with focus, attention, and impulse control through fun learning activities.</p>
    </button>

    <!-- Dyslexia -->
    <button type="submit" name="issue" value="Dyslexia" class="section-card dyslexia">
        <img src="kids/dyslexia.png" alt="Dyslexia" class="kid-img">
        <h2 class="text-2xl font-bold">Dyslexia</h2>
        <p class="text-sm mt-2">Helps with reading, spelling, and comprehension through interactive exercises and phonics-based games.</p>
    </button>

    <!-- Dyscalculia -->
    <button type="submit" name="issue" value="Dyscalculia" class="section-card dyscalculia">
        <img src="kids/dyscalculia.png" alt="Dyscalculia" class="kid-img">
        <h2 class="text-2xl font-bold">Dyscalculia</h2>
        <p class="text-sm mt-2">Supports number understanding and math problem-solving through visual aids and playful challenges.</p>
    </button>

    <!-- No Specific -->
    <button type="submit" name="issue" value="None" class="section-card none">
        <img src="kids/none.png" alt="No Specific" class="kid-img">
        <h2 class="text-2xl font-bold">Calm Zone</h2>
        <p class="text-sm mt-2">Here you can take a breath, clear your mind, and get ready to learn again..</p>
    </button>

</form>

<!-- About Us -->
<section id="about" class="mt-16 bg-white py-10 shadow-inner">
    <div class="max-w-4xl mx-auto text-center px-4">
        <h3 class="text-3xl font-bold text-purple-700">About NeuroLearn</h3>
        <p class="mt-4 text-gray-600">
            NeuroLearn is dedicated to providing customized learning experiences for children with diverse needs.
            We blend engaging games, interactive lessons, and positive reinforcement to help every learner shine.
        </p>
    </div>
</section>

<!-- Contact -->
<section id="contact" class="bg-purple-100 py-10 mt-10">
    <div class="max-w-4xl mx-auto text-center px-4">
        <h3 class="text-3xl font-bold text-purple-700">Contact Us</h3>
        <p class="mt-2 text-gray-600">Have questions or suggestions? We’d love to hear from you!</p>
        <p class="mt-4 font-semibold text-gray-800">📧 Email: support@neurolearn.com</p>
        <p class="font-semibold text-gray-800">📞 Phone: +91 98765 43210</p>
    </div>
</section>

<!-- Footer -->
<footer class="bg-purple-600 text-white py-4 text-center mt-6">
    &copy; <?= date("Y") ?> NeuroLearn. All rights reserved.
</footer>

</body>
</html>