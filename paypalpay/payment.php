<?php
// CONFIG: Enable debug mode. This means we'll log requests into 'ipn.log' in the same directory.
// Especially useful if you encounter network errors or other intermittent problems with IPN (validation).
// // Set this to 0 once you go live or don't require logging.
define("DEBUG", 1);
// Set to 0 once you're ready to go live
define("USE_SANDBOX", 1);
// define("LOG_FILE", "ipn.log");



$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "paypal_pays";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
// Read POST data
// reading posted data directly from $_POST causes serialization
// issues with array data in POST. Reading raw POST data from input stream instead.
amt=6.99&cc=USD&item_name=Product%20name%20goes%20here&st=Pending&tx=2JR48589FX4864532

if($_GET['cm']) $user=$_GET['cm']; 
// The unique transaction id. 
if($_GET['tx']) $tx= $_GET['tx'];
 $identity = 'Your Identity'; 
// Init curl
 $ch = curl_init(); 
// Set request options 
curl_setopt_array($ch, array ( CURLOPT_URL => 'https://www.sandbox.paypal.com/cgi-bin/webscr',
  CURLOPT_POST => TRUE,
  CURLOPT_POSTFIELDS => http_build_query(array
    (
      'cmd' => '_notify-synch',
      'tx' => $tx,
      'at' => $identity,
    )),
  CURLOPT_RETURNTRANSFER => TRUE,
  CURLOPT_HEADER => FALSE,
  // CURLOPT_SSL_VERIFYPEER => TRUE,
  // CURLOPT_CAINFO => 'cacert.pem',
));
// Execute request and get response and status code
$res = curl_exec($ch);

echo json_encode($res);

// $req=json_encode($_REQUEST);
// $res_arr=json_encode($res);
// $sql = "INSERT INTO `payment` (`id`, `item_number`, `item_name`, `payment_status`, `payment_amount`, `payment_currency`, `txn_id`) VALUES (NULL, '', '".$req."', '".$res_arr."', '', '', '');";

// if ($conn->query($sql) === TRUE) {
//     echo "New record created successfully";
// } else {
//     echo "Error: " . $sql . "<br>" . $conn->error;
// }
?>