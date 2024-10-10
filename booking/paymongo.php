<?php


require_once('../paymentmethod/vendor/autoload.php');

$client = new \GuzzleHttp\Client();

// Check if the session variable 'pay' is set
$amountInCents = isset($_SESSION['pay']) ? $_SESSION['pay'] : 0; // Use the session value or default to 0

// Define payment data
$paymentData = [
    'data' => [
        'attributes' => [
            'amount' => $amountInCents, // Amount in cents
            'currency' => 'PHP',
            'description' => 'Payment for booking', // Description of the payment
            'payment_method' => [
                'type' => isset($_POST['payment_method']) ? $_POST['payment_method'] : 'gcash', // Get payment method from POST data
            ],
        ],
    ],
];

try {
    // Make request to PayMongo API
    $response = $client->request('POST', 'https://api.paymongo.com/v1/links', [
        'headers' => [
            'accept' => 'application/json',
            'content-type' => 'application/json',
            'Authorization' => 'sk_test_8FHikGJxuzFP3ix4itFTcQCv', // Replace with your actual PayMongo secret key
        ],
        'json' => $paymentData,
    ]);

    // Decode the response
    $responseData = json_decode($response->getBody(), true);
    $paymentLink = $responseData['data']['attributes']['url']; // Get the payment link

} catch (\GuzzleHttp\Exception\RequestException $e) {
    echo "Error: " . $e->getMessage();
    exit;
}
?>

   