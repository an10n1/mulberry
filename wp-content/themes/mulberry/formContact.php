<?php
require_once("../../../wp-load.php");

if((isset($_POST['name'])&&$_POST['name']!="")&&(isset($_POST['email'])&&$_POST['email']!=""))
{
    $to = 'advertisers@Mulberry.com';
    $subject = 'Contact';
    $rdb_value = $_POST['type'];
    $message = '
                <html>
                    <head>
                        <title>'.$subject.'</title>
                    </head>
                    <body>
                        <p>Name: '.$_POST['name'].'</p>
                        <p>Surname: '.$_POST['surname'].'</p>
                        <p>Email: '.$_POST['email'].'</p>
                        <p>Name: '.$_POST['name'].'</p>
                        <p>Phone: '.$_POST['phone'].'</p>
                        <p>Type: '.$rdb_value.'</p>
                        <p>Text:<br> '.$_POST['comment'].'</p>
                    </body>
                </html>';

    $headers = "From: Contact ".$_POST['email'] . "\r\n" .
        'X-Mailer: PHP/' . phpversion();
    $headers  = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";

    //mail($to, $subject, $message, $headers);
    wp_mail( $to, $subject, $message, $headers);

    ?>

    <script>
      location.href = '/contact'
    </script>
<?php } ?>