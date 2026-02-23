<?php
session_start();
if(!isset($_SESSION['user_id'])){
    header("Location: ../../login.php");
    exit();
}

// Load alphabet data
$data_file = __DIR__ . "/data/alphabet.json";
$letters = json_decode(file_get_contents($data_file), true);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Learn Alphabet</title>
<style>
#alphabet-container { text-align:center; margin-top:50px; }
#letter { font-size:100px; color:#4a90e2; }
#word-image { width:200px; margin-top:20px; }
button { padding:10px 20px; margin:10px; font-size:16px; cursor:pointer; }
</style>
</head>
<body>

<div id="alphabet-container">
    <div id="letter"></div>
    <img id="word-image" src="" alt="">
    <div>
        <button onclick="playAudio()">🔊 Listen</button>
        <button onclick="nextLetter()">Next</button>
    </div>
</div>

<script>
// Get alphabet data from PHP
let letters = <?php echo json_encode($letters); ?>;
let index = 0;

// Show current letter and image
function showLetter(i){
    document.getElementById('letter').innerText = letters[i].letter;
    document.getElementById('word-image').src = "../../assets/images/" + letters[i].image;
}

// Play Text-to-Speech
function playAudio(){
    const text = letters[index].letter + " as in " + letters[index].word;
    const utterance = new SpeechSynthesisUtterance(text);
    utterance.lang = 'en-US';
    utterance.rate = 0.8;
    utterance.pitch = 1.2;
    window.speechSynthesis.speak(utterance);
}

// Go to next letter
function nextLetter(){
    index++;
    if(index >= letters.length) index = 0; // loop back
    showLetter(index);
}

// Initialize first letter
showLetter(index);
</script>

</body>
</html>