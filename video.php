<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Sorteo Automóvil 2026</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Poppins', sans-serif;
}

/* FONDO LIMPIO */
body{
    background: url('fondo.png') no-repeat center center fixed;
    background-size: 100%;
    min-height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
}

/* CONTENEDOR PRINCIPAL */
.container{
    width:100%;
    max-width:420px;
    background:white;
    border-radius:20px;
    box-shadow:0 10px 40px rgba(0,0,0,0.15);
    overflow:hidden;
}

/* HEADER VERDE */
.header{
    position:relative;
    background:linear-gradient(135deg,#00a651,#008f45);
    padding:30px 20px;
    text-align:center;
    color:white;
    overflow:hidden;
}

/* TRIANGULOS DECORATIVOS */
.header::before{
    content:"";
    position:absolute;
    top:-50px;
    left:-50px;
    width:150px;
    height:150px;
    background:rgba(255,255,255,0.1);
    transform:rotate(45deg);
}

.header::after{
    content:"";
    position:absolute;
    bottom:-60px;
    right:-60px;
    width:180px;
    height:180px;
    background:rgba(255,255,255,0.08);
    transform:rotate(45deg);
}

.header h1{
    font-size:20px;
}

/* CONTENIDO */
.content{
    padding:20px;
    text-align:center;
}

/* TEXTO */
p{
    font-size:14px;
    color:#334155;
    margin-bottom:15px;
}

/* CONTADOR */
.countdown{
    display:flex;
    justify-content:space-between;
    margin-bottom:15px;
}

.time-box{
    background:#ecfdf5;
    padding:10px;
    border-radius:10px;
    width:23%;
}

.time-box span{
    display:block;
    font-weight:600;
    color:#008f45;
}

.time-box small{
    font-size:11px;
}

/* VIDEO */
.video-box{
    border-radius:12px;
    overflow:hidden;
    margin-bottom:10px;
}

video{
    width:100%;
}

/* PROGRESO */
.progress{
    height:5px;
    background:#e2e8f0;
    border-radius:10px;
    overflow:hidden;
    margin-bottom:15px;
}

.progress-bar{
    height:100%;
    width:0%;
    background:#00a651;
}

/* BOTON */
button{
    width:100%;
    padding:14px;
    border:none;
    border-radius:10px;
    font-weight:600;
    font-size:15px;
    background:#cbd5e1;
    color:#64748b;
}

button.active{
    background:#00a651;
    color:white;
}
.car-image{
    margin-bottom:15px;
}

.car-image img{
    width:100%;
    border-radius:12px;
    box-shadow:0 10px 25px rgba(0,0,0,0.2);
    transform:scale(1.02);
}

/* MOBILE EXTRA */
@media(max-width:400px){
    .header h1{
        font-size:18px;
    }
}

</style>

</head>

<body>

<div class="container">

    <div class="header">
        <h1>Sorteo Familiar</h1>
    </div>

    <div class="content">
        <div class="car-image">
    <img src="fondo.png" alt="Toyota">
</div>

        <p>
            Estas Participando por un automóvil para tu familia.<br>
         <strong id="fechaSorteo">30 de abril de 2026</strong>
        </p>

        <!-- CONTADOR -->
        <div class="countdown">
            <div class="time-box"><span id="d">0</span><small>Días</small></div>
            <div class="time-box"><span id="h">0</span><small>Horas</small></div>
            <div class="time-box"><span id="m">0</span><small>Min</small></div>
            <div class="time-box"><span id="s">0</span><small>Seg</small></div>
        </div>

        <!-- VIDEO -->
        <div class="video-box">
            <video id="video" autoplay muted playsinline>
                <source src="video.mp4" type="video/mp4">
            </video>
        </div>

        <!-- PROGRESO -->
        <div class="progress">
            <div class="progress-bar" id="progress"></div>
        </div>

    </div>

</div>

<script>

/* ========================= */
/* CONTADOR DINÁMICO */
/* ========================= */

// MESES EN ESPAÑOL
const meses = {
    "enero":0,
    "febrero":1,
    "marzo":2,
    "abril":3,
    "mayo":4,
    "junio":5,
    "julio":6,
    "agosto":7,
    "septiembre":8,
    "octubre":9,
    "noviembre":10,
    "diciembre":11
};

// LEER FECHA DESDE HTML
const textoFecha = document.getElementById("fechaSorteo").innerText.toLowerCase();

// EJEMPLO: "30 de abril de 2026"
const partes = textoFecha.split(" ");

const dia = parseInt(partes[0]);
const mes = meses[partes[2]];
const anio = parseInt(partes[4]);

// CREAR FECHA EN ZONA NICARAGUA
const targetDate = new Date(anio, mes, dia, 0, 0, 0).getTime();

// CONTADOR
setInterval(()=>{
    const now = new Date().getTime();
    const diff = targetDate - now;

    const d = Math.floor(diff / (1000*60*60*24));
    const h = Math.floor((diff % (1000*60*60*24)) / (1000*60*60));
    const m = Math.floor((diff % (1000*60*60)) / (1000*60));
    const s = Math.floor((diff % (1000*60)) / 1000);

    document.getElementById("d").innerText = d;
    document.getElementById("h").innerText = h;
    document.getElementById("m").innerText = m;
    document.getElementById("s").innerText = s;

},1000);

/* VIDEO */
const video = document.getElementById("video");
const btn = document.getElementById("btn");
const progress = document.getElementById("progress");

/* CONTROL DE REPETICIÓN Y REDIRECCIÓN */
let contador = 0;

video.addEventListener("ended", ()=>{
    contador++;

    if(contador < 2){
        video.currentTime = 0;
        video.play();
    }else{
        window.location.href = "registro.html";
    }
});

/* BOTON */
btn.addEventListener("click", ()=>{
    window.location.href = "registro.html";
});

</script>

</body>
</html>

