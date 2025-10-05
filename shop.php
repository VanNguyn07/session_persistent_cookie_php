<?php
session_start();
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $username = isset($_POST['username']) ? trim($_POST['username']) : '';
    if($username === ''){
        header('loction: index.html');
        exit;
    }else {
        // save in session
        $_SESSION['userName'] = $username;
        // an toàn khi in ra HTML
        $safeName = htmlspecialchars($username, ENT_QUOTES, 'UTF-8');
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <p>Hello, <?php echo $safeName; ?>!👋 </p>
</body>
</html>