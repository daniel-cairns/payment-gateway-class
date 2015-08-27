<h1>All Products</h1>

<?php
	
	// SQL to get all products
	$sql = "SELECT id, name, price, quantity FROM products";

	// Run the SQL
	$result = $dbc->query($sql);

	// Loop through the result
	while($row = $result->fetch_assoc()) {

		echo '<h2>'.$row['name'].'</h2>';

		echo '<ul>';
		echo '<li>Price: $'.$row['price'].'</li>';
		echo '<li>Quantity: '.$row['quantity'].'</li>';
		echo '</ul>';

		// Include the "add item to cart" form
		include 'app/templates/add-to-cart-form.php';

	}

?>