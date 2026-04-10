<?php
$id = $_GET['id'] ?? '';
file_put_contents("go_$id.txt", "GO");
echo "OK";
?>