<?php
// clear_cart.php
session_start();
unset($_SESSION['cart']); // Assuming 'cart' is the session variable for the cart

// Return a response to the AJAX call
http_response_code(200); // Send success status
