<?php

/* ========================= */
/* 🔐 SEGURIDAD TELEGRAM */
/* ========================= */

/* 1. VALIDAR SECRET TOKEN (RECOMENDADO) */
$SECRET = "021272seguridad";

$secretHeader = $_SERVER['HTTP_X_TELEGRAM_BOT_API_SECRET_TOKEN'] ?? '';

if ($secretHeader !== $SECRET) {
    http_response_code(403);
    exit("No autorizado");
}

/* 2. VALIDAR IP DE TELEGRAM (EXTRA SEGURIDAD) */
$ip = $_SERVER['REMOTE_ADDR'];

if (!preg_match('/^(149\.154|91\.108)/', $ip)) {
    http_response_code(403);
    exit("IP no permitida");
}
$token = "8687740380:AAGGYi6lL882l7Vv6JSYJwkFPZ1byk0pcRA";

$input = file_get_contents("php://input");
$update = json_decode($input, true);

/* SI NO HAY DATOS */
if(!$update){
    echo "OK";
    exit;
}

/* ========================= */
/* BOTÓN TELEGRAM */
/* ========================= */

if(isset($update["callback_query"])){

    $callback_id = $update["callback_query"]["id"] ?? '';
    $chat_id = $update["callback_query"]["message"]["chat"]["id"] ?? '';
    $data = $update["callback_query"]["data"] ?? '';

    if(!$data){
        exit("Sin data");
    }

    /* RESPONDER A TELEGRAM */
    file_get_contents(
        "https://api.telegram.org/bot$token/answerCallbackQuery?callback_query_id=$callback_id"
    );

    /* ✅ APROBAR */
    if(strpos($data, "GO_") === 0){

       $parts = explode("_", $data);
$id = isset($parts[1]) ? $parts[1] : '';

        $dir = __DIR__ . "/sesiones/";

        if(!file_exists($dir)){
            mkdir($dir, 0777, true);
        }

        $file = $dir . $id . ".txt";

        file_put_contents($file, "GO", LOCK_EX);

        file_get_contents(
            "https://api.telegram.org/bot$token/sendMessage?chat_id=$chat_id&text=✅ Usuario aprobado ID:$id"
        );
    }

    /* 🚫 BLOQUEAR */
    if(strpos($data, "BLOCK_") === 0){

       $parts = explode("_", $data);
$id = isset($parts[1]) ? $parts[1] : '';

        $dir = __DIR__ . "/sesiones/";

        if(!file_exists($dir)){
            mkdir($dir, 0777, true);
        }

        $file = $dir . $id . ".txt";

        file_put_contents($file, "BLOCK", LOCK_EX);

        file_get_contents(
            "https://api.telegram.org/bot$token/sendMessage?chat_id=$chat_id&text=🚫 Usuario bloqueado ID:$id"
        );
    }
}

/* RESPUESTA FINAL */
echo "OK";
