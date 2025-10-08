<?php
require_once 'includes/common.php';
session_start();

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $username = isset($_POST['username']) ? trim($_POST['username']) : '';
    if($username === ''){
        header('location: index.html');
        exit;
    }else {
        // save in session
        $_SESSION['userName'] = $username;
    }
            // an toàn khi in ra HTML
        $safeName = isset($username) && $username !== '' ? htmlspecialchars($username, ENT_QUOTES, 'UTF-8'): 'Guest';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="assets/css/shop_and_cart.css">
</head>
<body>
        <h1>My Shoes Store!</h1>

    <div class="session">
        <p>Hello: <b> <?php echo $safeName; ?>! </b>👋 </p>
        <p>Session ID: </p>
    </div>

    <table>
        <th colspan="3">Lists Product!</th>
        <tr>
            <td>
                <label for="">Product Name </label>
            </td>

            <td>
                <label for="">Product cost </label>
            </td>

            <td>
                <label for="">Cart </label>
            </td>
        </tr>

        <tr>
            <td>
                <label for="">Canvas Shoes</label>
            </td>

            <td>
                <label for="">500.000VND </label>
            </td>

            <td id="col1-row3">
                <button type="submit">Add to Cart</button>
            </td>
        </tr>

        <tr>
            <td>
                <label for="">Nike Shoes</label>
            </td>

            <td>
                <label for="">1.000.000VND </label>
            </td>

            <td id="col1-row3">
                <button type="submit">Add to Cart</button>
            </td>

        </tr>

        <tr>
            <td>
                <label for="">Sport Shoes</label>
            </td>

            <td>
                <label for="">300.000VND </label>
            </td>

            <td id="col1-row3">
                <button type="submit">Add to Cart</button>
            </td>

        </tr>

        <tr>
            <td class="col-border-none"></td>
            <td class="col-border-none"></td>

            <td id="col2-row3">
                <button type="button" onclick="window.location.href='./cart.php'">
                    Go to Cart
                </button>
            </td>
        </tr>

    </table>
</body>
</html>