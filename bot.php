<?php

$token = "8687740380:AAGWDU18CPeXsMWhpzy1n6uZ-MkeTxWYYUo";

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

    $callback_id = $update["callback_query"]["id"];
    $chat_id = $update["callback_query"]["message"]["chat"]["id"];
    $data = $update["callback_query"]["data"];

    /* RESPONDER A TELEGRAM */
    file_get_contents(
        "https://api.telegram.org/bot$token/answerCallbackQuery?callback_query_id=$callback_id"
    );

    /* ✅ APROBAR */
    if(strpos($data, "GO_") === 0){

       $parts = explode("_", $data);
$id = isset($parts[1]) ? $parts[1] : '';

      $dir = sys_get_temp_dir() . "/sesiones/";

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
