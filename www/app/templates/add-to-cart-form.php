<?php 
	// If the user already has the this item in the cart
	// then we want to make sure they can't add more tan what's in the database
	// If we subtract the cart quantity against the database quantity,
	// then we can help prevent this problem
	for( $i=0; $i<count($_SESSION['cart']); $i++){
		// If the ID of of this product is the same as the one iin the cart
		if($row['id'] == $_SESSION['cart'][$i]['id']){
			$newQuantity = $row['quantity'] -= $_SESSION['cart'][$i]['quantity'];
			$inCart = $_SESSION['cart'][$i]['quantity'];
		}
	}
	// If the $newQuantity variable doesn't exist 
	// Create it and apply the default database quantity
	if( !isset($newQuantity)){
		$newQuantity = $row['quantity'];
	}
?>


<form action="index.php" method="post"> <!--using post to stop the cart add function running if the user bookmarked a get method -->
	
	<label for="quantity<?= $row['id']; ?>">Quantity:</label>
	<input type="number" id="quantity<?= $row['id']; ?>" name="quantity" value="1" min="1" max="<?= $newQuantity; ?>">
	<input type="hidden" name="product-id" value="<?= $row['id'];?>">
	<input type="submit" value="add-to-cart" name="add-to-cart">

</form>

<?php 
	// If the user has this item in their cart tel them
	if( isset($inCart)){
		echo '<ul>';
		echo '<li>Already in cart!</li>';
		echo '<li>In cart: '.$inCart.'</li>';
		echo '</ul>';
		unset($inCart);
	} 

	unset($newQuantity);

 ?>