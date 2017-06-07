<?php
require_once("../../../wp-load.php");

if((isset($_POST['name'])&&$_POST['name']!="")&&(isset($_POST['email'])&&$_POST['email']!=""))
{
    $to = 'advertisers@Mulberry.com';
    $subject = 'Advertiser';
    $message = '
                <html>
                    <head>
                        <title>'.$subject.'</title>
                    </head>
                    <body>
                        <p>Name: '.$_POST['name'].'</p>
                        <p>Email: '.$_POST['email'].'</p>
                    </body>
                </html>';

    $headers = "From: Advertiser ".$_POST['email'] . "\r\n" .
        'X-Mailer: PHP/' . phpversion();
    $headers  = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";

    //mail($to, $subject, $message, $headers);
    wp_mail( $to, $subject, $message, $headers);

    ?>

    <script>
      location.href = '/'
    </script>
<?php } ?>