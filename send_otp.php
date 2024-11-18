<?php


require_once 'PHPMailer/src/Exception.php';
require_once 'PHPMailer/src/PHPMailer.php';
require_once 'PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;
header('Content-Type: application/json; charset=UTF-8');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");


$response = array('status' => 'error', 'message' => 'An error occurred.');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $postData = json_decode(file_get_contents('php://input'), true);

    if (isset($postData['****'])) {
        $**** = $postData['****'];

        $sql = "SELECT **** FROM ****** WHERE ****** = :******";

        $statement = oci_parse($conn, $sql);

        oci_bind_by_name($statement, ':****', $email);

        $result = oci_execute($statement);

        if ($result) {
            $row = oci_fetch_assoc($statement);
            if ($row) {
                $pinCode = $row['*****'];

                $emailSent = sendEmail($*******, $*******);

                if ($emailSent) {
                    $response = array(
                        'status' => 'success',
                        'message' => 'OTP and PIN_CODE sent successfully to your email.'
                    );
                } else {
                    $response = array('status' => 'error', 'message' => 'Failed to send email.');
                }
            } else {
                $response = array('status' => 'error', 'message' => 'No PIN_CODE found for the provided email.');
            }
        } else {
            $error = oci_error($statement);
            $response = array('status' => 'error', 'message' => 'Failed to execute SQL query: ' );
        }

        oci_free_statement($statement);
    } else {
        $response = array('status' => 'error', 'message' => 'Invalid request. Email is missing.');
    }
} else {
    $response = array('status' => 'error', 'message' => 'Invalid request method. Only POST method is allowed.');
}

oci_close($conn);

echo json_encode($response);
header('Content-Type: application/json; charset=UTF-8');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
function sendEmail($recipient, $pinCode) {
    $subject = 'PIN_CODE for Password ';
    $message = 'Your PIN_CODE is: ' . $pinCode;

    $mail = new PHPMailer(true); 

    try {
        $mail->SMTPDebug = SMTP::DEBUG_SERVER;

        $mail->isSMTP();
        $mail->Host = '****';
        $mail->SMTPAuth = true;
        $mail->Username = 'mayyas@gmail.com';
        $mail->Password = '****';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom('****', '**'); 
        $mail->addAddress($recipient); 

        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $message;

        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}
?>
