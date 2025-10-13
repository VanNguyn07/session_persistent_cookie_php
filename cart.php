<?php
session_start();
require_once 'includes/common.php';
require_once 'includes/product.php';
require_once 'includes/end_sesstion.php';

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

if(isset($_POST['update_cart'])){
    if(isset($_POST['quantity']) && is_array($_POST['quantity'])){
        foreach($_POST['quantity'] as $id => $qty){
            if(isset($_SESSION['cart'][$id])){
                $newQty = intval($qty);
                if($newQty >= 1){
                    $_SESSION['cart'][$id]['quantity'] = $newQty;
                }else {
                    unset($_SESSION['cart'][$id]);
                }
            }
        }
    }
}

if (isset($_GET['action']) && $_GET['action'] == 'remove' && isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Duyệt qua giỏ hàng và xóa sản phẩm có id trùng khớp
    foreach ($_SESSION['cart'] as $key => $item) {
        if ($item['id'] == $id) {
            unset($_SESSION['cart'][$key]);
            break;
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
    <script>
        document.addEventListener('DOMContentLoaded', function(){
            const  quantityInputs = document.querySelectorAll('.quantity-input');

            function updateCart(){
                let total = 0;
                document.querySelectorAll('.cart-item').forEach(function(row){
                    const input = row.querySelector('.quantity-input'); // trong mỗi hàng thì tìm ô nhập số lượng
                    const unitPrice = parseFloat(input.dataset.unitPrice); // lấy giá gốc của sản phẩm từ dữ liệu tùy chỉnh data-unit-price 
                    let getQuantityNumber = parseInt(input.value) || 1; // Sửa: dùng let thay const, và ||1 để mặc định nếu NaN/empty
                    if(getQuantityNumber < 1){
                        getQuantityNumber = 1; // Bây giờ có thể assign vì là let
                    }
                    const subtotal = unitPrice * getQuantityNumber;
                    const showCostInRow = row.querySelector('.subtotal');
                    showCostInRow.textContent = subtotal.toLocaleString('vi-VN') + 'VND';
                    total += subtotal;
                });
                const showTotalCost = document.querySelector('.total-price');
                if(showTotalCost){
                    showTotalCost.textContent = total.toLocaleString('vi-VN') + 'VND';
                }
            }
            quantityInputs.forEach(function(input){
                input.addEventListener('input', updateCart);
            })
            updateCart();
        });
    </script>
</head>
<body>
    <h1>My Shoes Store!</h1>
    <div class="session">
        <p>Hello: <b> <?php echo $safeName; ?>! </b>👋 </p>
        <p>Session ID: <b> <?php echo session_id(); ?> </b> </p>
    </div>

    <form action="" method="post">
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
            <?php $total = 0;?>

            <?php
            foreach($_SESSION['cart'] as $id => $item): 
            $subTotal = $item['cost'] * $item['quantity'];
            $total += $subTotal;
            ?>

        <tr class="cart-item">
            <td><?php echo htmlspecialchars($item['name']) ?></td>
            <td class="unit-price"><?php echo number_format($item['cost']) ?> VND</td>

            <td><input type="number" name="quantity[<?php echo $id; ?>]" 
            class="quantity-input" value="<?php echo ($item['quantity']) ?>" 
            data-unit-price="<?php echo $item['cost'] ?>"  
            min="1" 
            style="width: 40px;">
            </td>

            <td class="subtotal"><?php echo number_format($subTotal) ?> VND</td>
            <td><a href="./cart.php?action=remove&id=<?php echo $item['id'] ?>" class="btn-remove">Remove</a></td>
        </tr>
        <?php endforeach; ?>

            <tr>
                <td colspan="3"><b>Total:</b></td>
                <td class="total-price"><b><?php echo number_format($total); ?> VND</b></td>
            </tr>

        <?php endif; ?> 

        <tr>
            <td colspan="5"> 
                <button type="submit" name="update_cart" value="1">Update Cart</button>
                <button type="submit" class="btn-endSession" name="clear-session">End Session and Delete Cookie</button>
                <button type="button" class="btn-goBack" onclick="window.location.href='./shop.php'">Go back Shop</button>  
            </td>
        </tr>
    </table>
    </form>
</body>
</html>