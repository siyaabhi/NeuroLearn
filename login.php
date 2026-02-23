<?php
include 'includes/db.php';
session_start();

$error = "";

if (isset($_POST['login'])) {
  $email = trim($_POST['email']);
  $password = $_POST['password'];

  $query = "SELECT * FROM users WHERE email = ?";
  $stmt = $conn->prepare($query);
  $stmt->bind_param("s", $email);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();
    if (password_verify($password, $user['password'])) {
      // Save login info in session
      $_SESSION['user_id'] = $user['id'];
      $_SESSION['name'] = $user['name'];
      $_SESSION['avatar'] = $user['avatar'];
      $_SESSION['issue'] = $user['issue'];

      // ✅ Always redirect to select_learning.php
      header("Location: select_learning.php");
      exit();
    } else {
      $error = "Incorrect password!";
    }
  } else {
    $error = "Email not registered!";
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login - NeuroLearn</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    body {
      background: linear-gradient(to bottom right, #fce3f3, #dbeafe);
      overflow: hidden;
    }
    .bubble {
      position: absolute;
      border-radius: 50%;
      opacity: 0.3;
      animation: float 12s infinite ease-in-out;
    }
    @keyframes float {
      0% { transform: translateY(0) scale(1); }
      50% { transform: translateY(-100px) scale(1.2); }
      100% { transform: translateY(0) scale(1); }
    }
    .floating-emoji {
      animation: floatEmoji 10s ease-in-out infinite alternate;
      position: absolute;
    }
    @keyframes floatEmoji {
      0% { transform: translateY(0px) rotate(0deg); opacity: 0.9; }
      50% { transform: translateY(-20px) rotate(10deg); opacity: 1; }
      100% { transform: translateY(0px) rotate(-10deg); opacity: 0.9; }
    }
    .form-container { animation: fadeIn 1s ease-out; }
    @keyframes fadeIn {
      from { opacity: 0; transform: scale(0.95); }
      to { opacity: 1; transform: scale(1); }
    }
  </style>
</head>
<body class="flex items-center justify-center min-h-screen relative">

  <!-- Background Bubbles -->
  <?php for ($i = 0; $i < 8; $i++): ?>
    <div class="bubble" style="
      width: <?= rand(60, 130) ?>px;
      height: <?= rand(60, 130) ?>px;
      background-color: rgba(<?= rand(200,255) ?>, <?= rand(100,255) ?>, <?= rand(200,255) ?>, 0.4);
      top: <?= rand(5, 90) ?>%;
      left: <?= rand(5, 90) ?>%;
      animation-delay: -<?= rand(0, 20) ?>s;"></div>
  <?php endfor; ?>

  <!-- Floating Emojis -->
  <?php $icons = ['🧸', '📚', '☁', '⭐', '🪐', '🎈', '🧠', '🎨'];
    foreach ($icons as $emoji): ?>
    <div class="floating-emoji text-3xl sm:text-4xl lg:text-5xl"
         style="top: <?= rand(5, 90) ?>%; left: <?= rand(5, 90) ?>%; animation-delay: -<?= rand(0, 15) ?>s;">
      <?= $emoji ?>
    </div>
  <?php endforeach; ?>

  <!-- Login Form -->
  <div class="bg-white p-8 rounded-3xl shadow-2xl w-full max-w-md z-10 form-container border-4 border-purple-200">
    <h2 class="text-3xl font-bold mb-6 text-center text-purple-600 font-sans">🌈 Welcome Back to NeuroLearn!</h2>

    <?php if (!empty($error)): ?>
      <div class="bg-red-100 text-red-700 px-4 py-2 mb-4 rounded-lg text-center">
        <?= htmlspecialchars($error) ?>
      </div>
    <?php endif; ?>

    <form method="POST" class="space-y-4">
      <input type="email" name="email" required placeholder="📧 Email Address"
             class="w-full px-4 py-2 rounded-full border-2 border-pink-200 focus:ring-4 focus:ring-pink-300 focus:outline-none transition" />

      <input type="password" name="password" required placeholder="🔐 Password"
             class="w-full px-4 py-2 rounded-full border-2 border-blue-200 focus:ring-4 focus:ring-blue-300 focus:outline-none transition" />

      <button type="submit" name="login"
              class="w-full bg-purple-500 hover:bg-purple-600 text-white py-2 rounded-full text-lg font-semibold shadow-md transition">
        🚀 Login
      </button>
    </form>

    <p class="text-sm text-center text-gray-600 mt-6">
      Don’t have an account? <a href="signup.php" class="text-purple-700 font-semibold hover:underline">Sign up</a>
    </p>
  </div>
</body>
</html>