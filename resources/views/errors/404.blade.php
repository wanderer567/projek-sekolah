<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404-not found</title>
    <style>
        body { background-color: #ffffff; color: black; font-family: Arial, sans-serif; text-align: center; padding-top: 150px; }
        h1 { font-size: 5rem; margin: 140px; }
        h5 { font-size: 4;}
        p { font-size: 1.2rem; margin: 20px 0; }          
        a { color: #000000; text-decoration: none; font-weight: bold; }
    </style>
</head>
<body>
    <h1>404 | NOT FOUND</h1>
    <h5>You IP ADDRESS :</h5>
            <?php
                $ip = trim(shell_exec("dig +short myip.opendns.com @resolver1.opendns.com"));
                print_r($ip);
                die()
            ?>
    <a href="/">Kembali ke Beranda</a>
</body>
</html>   