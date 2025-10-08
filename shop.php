<?php
session_start();
require_once 'includes/common.php';
require_once 'includes/product.php';

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $username = isset($_POST['username']) ? trim($_POST['username']) : '';
    if($username === ''){
        header('location: index.html');
        exit;
    }else {
        // save in session
        $_SESSION['userName'] = $username;
    }
}
     // an toàn khi in ra HTML
        $safeName = isset($_SESSION['userName']) && $_SESSION['userName'] !== '' ? htmlspecialchars($_SESSION['userName'], ENT_QUOTES, 'UTF-8'): 'Guest';
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
        <p>Session ID: <b> <?php echo session_id(); ?></b></p>
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

        <?php foreach($products as $product): ?>
        <tr>
            <td>
                <label for=""><?php echo htmlspecialchars($product['name']); ?></label>
            </td>

            <td>
                <label for=""><?php echo number_format($product['cost']); ?> VND</label>
            </td>
                <input type="hidden" name="id" value="<?= $product['id'] ?>">

            <td id="col1-row3">
                <form action="cart.php" method="post">
                    <input type="hidden" name="id" value="<?php echo $product['id']; ?>">
                    <button type="submit" name="add_to_cart">Add to Cart</button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>