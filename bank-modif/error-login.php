<?php
// Warning Error To Login Admin Page
$error_login = "Maaf, Username & Password Salah! Atau ID Anda Sedang Di Blokir Oleh Admin.";

// View Error Message To Browser
echo "
<html>
<head>
<title>Login Administrator</title>
<link rel=\"stylesheet\" type=\"text/css\" href=\"style_login.css\" />

</head>
<body>
<br />
<center>
<h1>$error_login</h1>
<a href=\"index.php\" class=\"clickhere\">ULANGI LAGI</a></center>

</body>
</html>
";
?>
