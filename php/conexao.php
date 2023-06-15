<?php

$host = "server-cc-shirt-v1-db-mysql.mysql.database.azure.com";
$db = "cc_shirt";
$user = "dhpe";
$pass = "1592485236459@Abc";

$mysqli = mysqli_init();
mysqli_ssl_set($mysqli, NULL, NULL, "C:\xampp\xampp\htdocs\site_php-main\DigiCertGlobalRootCA.crt.pem", NULL, NULL);
mysqli_real_connect($mysqli, "$host", "$user", "$pass", "$db", 3306, MYSQLI_CLIENT_SSL);

if ($mysqli -> connect_errno) {
    die ("Falha na conexão com o banco de dados");
}