<?php include 'includes/db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Sign Up - NeuroLearn</title>
  <script src="https://cdn.tailwindcss.com">
</script>
</head>
<!-- Floating Shapes -->
<div class="absolute inset-0 -z-10 overflow-hidden">
  <div class="animate-float-slow absolute w-8 h-8 bg-yellow-300 rounded-full top-10 left-10 opacity-70"></div>
  <div class="animate-float-fast absolute w-10 h-10 bg-pink-300 rounded-full top-1/4 left-1/3 opacity-60"></div>
  <div class="animate-float-slow absolute w-6 h-6 bg-green-300 rounded-full bottom-10 right-16 opacity-50"></div>
  <div class="animate-float-fast absolute w-12 h-12 bg-blue-300 rounded-full bottom-24 left-10 opacity-50"></div>
  <div class="animate-float-slow absolute w-6 h-6 bg-purple-300 rounded-full top-1/2 right-10 opacity-60"></div>
  <div class="animate-float-fast absolute w-7 h-7 bg-red-300 rounded-full bottom-8 left-1/4 opacity-70"></div>
</div>
<body class="bg-gradient-to-br from-green-100 to-yellow-100 min-h-screen flex items-center justify-center">
  <div class="bg-white p-8 rounded-xl shadow-lg w-full max-w-md text-center">
    <h2 class="text-3xl font-bold text-green-700 mb-6">Create Your Account</h2>

    <form method="POST" class="space-y-4 text-left">
      <input type="text" name="name" required placeholder="Full Name"
             class="w-full px-4 py-2 border border-green-300 rounded-lg" />

      <select name="age" required class="w-full px-4 py-2 border border-green-300 rounded-lg bg-white text-gray-700">
        <option value="" disabled selected>Select Age</option>
        <?php for ($i = 4; $i <= 10; $i++): ?>
          <option value="<?= $i ?>"><?= $i ?></option>
        <?php endfor; ?>
      </select>

      <input type="email" name="email" required placeholder="Email"
             class="w-full px-4 py-2 border border-green-300 rounded-lg" />

      <input type="password" name="password" required placeholder="Password"
             class="w-full px-4 py-2 border border-green-300 rounded-lg" />

      <!-- Avatar Selection -->
<label class="block font-semibold text-sm text-gray-600">Choose an Avatar:</label>
<div class="grid grid-cols-3 gap-4 mt-2">
  <?php
  for ($i = 1; $i <= 15; $i++) {
    $filename = "avatar$i.png";
    echo "
      <label class='cursor-pointer text-center'>
        <input type='radio' name='avatar' value='$filename' required class='hidden peer'>
        <img src='avatars/$filename' class='w-20 h-20 rounded-full border-4 border-transparent peer-checked:border-green-500 shadow-md'>
      </label>
    ";
  }
  ?>
</div>
      <button type="submit" name="signup"
              class="w-full bg-green-600 text-white py-2 rounded-lg hover:bg-green-700 transition mt-4">Sign Up</button>
    </form>

    <p class="text-sm text-gray-600 mt-4">
      Already have an account?
      <a href="login.php" class="text-green-700 font-semibold hover:underline">Login here</a>
    </p>
  </div>

<?php
if (isset($_POST['signup'])) {
  $name = $_POST['name'];
  $age = $_POST['age'];
  $email = $_POST['email'];
  $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
  $avatar = $_POST['avatar'];

  $check = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
  if (mysqli_num_rows($check)) {
    echo "<script>alert('Email already registered');</script>";
  } else {
    $query = "INSERT INTO users (name, age, email, password, avatar)
              VALUES ('$name', $age, '$email', '$password', '$avatar')";
    if (mysqli_query($conn, $query)) {
      echo "<script>alert('Account created!'); window.location='login.php';</script>";
    } else {
      echo "<script>alert('Something went wrong');</script>";
    }
  }
}
?>
</body>
</html>
