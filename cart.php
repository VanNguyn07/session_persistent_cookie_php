<?php
session_start();
require_once 'includes/common.php';
require_once 'includes/product.php';

if(!isset($_SESSION['userName']) || $_SESSION['userName'] == ''){
    $safeName = 'Guest';
}else {
    $safeName = htmlspecialchars($_SESSION['userName'], ENT_QUOTES, "UTF-8");
}

if(!isset($_SESSION['cart'])){
    $_SESSION['cart'] = [];
}

if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_to_cart'])){
    $id = $_POST['id'];

    if(isset($products[$id])){
        if(!isset($_SESSION['cart'][$id])){
            $_SESSION['cart'][$id] = $products[$id];
            $_SESSION['cart'][$id]['quantity'] = 1;
        }else {
            $_SESSION['cart'][$id]['quantity']++;
        }
    }
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
        <p>Session ID: <b> <?php echo session_id(); ?> </b> </p>
    </div>

    <table>
        <th colspan="5">Lists Product!</th>
        <tr>
            <td>
                <label for="">Product Name </label>
            </td>

            <td>
                <label for="">Product cost </label>
            </td>

            <td>
                <label for="">Quantity</label>
            </td>

            <td>
                <label for="">Subtotal</label>
            </td>

            <td>
                <label for="">Action</label>
            </td>
            
        </tr>

        <?php if (empty($_SESSION['cart'])): ?>
            <tr><td colspan="4">Your cart is empty!</td></tr>

        <?php else: ?>
            <?php $total = 0;

            foreach($_SESSION['cart'] as $item): 
            $subTotal = $item['cost'] * $item['quantity'];
            $total += $subTotal;
        ?>

        <tr>
            <td><?php echo htmlspecialchars($item['name']) ?></td>
            <td><?php echo number_format($item['cost']) ?> VND</td>
            <td><?php echo ($item['quantity']) ?></td>
            <td><?php echo number_format($subTotal) ?> VND</td>
        </tr>
        <?php endforeach; ?>

            <tr>
                <td colspan="3"><b>Total:</b></td>
                <td><b><?php echo number_format($total); ?> VND</b></td>
            </tr>

        <?php endif; ?>

        <tr>
            <td colspan="5"> 
                <button class="btn-endSession">End Session and Delete Cookie</button>
                <button class="btn-goBack" onclick="window.location.href='./shop.php'">Go back Shop</button>  
            </td>
        </tr>

    </table>
</body>
</html>