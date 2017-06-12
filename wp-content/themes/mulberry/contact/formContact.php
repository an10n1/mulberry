<?php
require_once( "../../../../wp-load.php" );

if ( ( isset( $_POST['name'] ) && $_POST['name'] != "" ) && ( isset( $_POST['email'] ) && $_POST['email'] != "" ) && ( isset( $_POST['msg'] ) && $_POST['msg'] != "" ) ) {
	$to      = 'mulberryadv@gmail.com';
	$subject = 'Contact';
	$message = '
                <html>
                    <head>
                        <title>' . $subject . '</title>
                    </head>
                    <body>
                        <p>Name: ' . $_POST['name'] . '</p><br />
                        <p>Email: ' . $_POST['email'] . '</p><br />
                        <p>Phone: ' . $_POST['phone'] . '</p><br />
                        <p>Text:<br> ' . $_POST['msg'] . '</p>
                    </body>
                </html>';

	$headers = "From: Contact " . $_POST['email'] . "\r\n" .
	           'X-Mailer: PHP/' . phpversion();
	$headers = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";

	wp_mail( $to, $subject, $message, $headers );

} else {
	return false;
}