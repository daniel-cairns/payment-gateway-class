<table border="1">
	<caption>You Cart Contents</caption>
	<tr>
		<th>Product Name</th>
		<th>Quantity</th>
		<th>Individual Price</th>
		<th>Total Price</th>
		<th>Change Quantity</th>
	</tr>

<?php 
// Loop over each item in the cart
foreach( $_SESSION['cart'] as $cartItem): ?>

<tr>
	<td><?= $cartItem['name'];?></td>
	<td><?= $cartItem['quantity'];?></td>
	<td>$<?= number_format($cartItem['price'], 2);?></td>
	<td>$<?= number_format($cartItem['quantity'] * $cartItem['price'], 2);?></td>
	<td><?= $cartItem['name'];?></td>
</tr>





<?php endforeach; ?>
</table>

<a href="make-payment.php">Proceed to payment</a>