<?php 
session_start();

//validacion session

if(!isset($_SESSION['idUsuario'])) {
header('Location: ../../index.html');
}

require("../../conection/conexion.php");




//validación si venimos de reportes
if(@$_GET['idUsuario']!=0){
  $idUsuario=$_GET['idUsuario'];
}else{

  $idUsuario=$_SESSION['idUsuario'];
}


    $q1 = ("SELECT * FROM palabrasglosario AS palabras JOIN glosario AS glosa ON palabras.idGlosario=glosa.idglosario WHERE glosa.idLectura=:idLectura");
      $mostrarGlosario=$dbConn->prepare($q1);
      $mostrarGlosario->bindParam(':idLectura',$_GET['noLectura'], PDO::PARAM_INT); 
      $mostrarGlosario->execute();
      $cantidadPalabras=$mostrarGlosario->rowCount();
    

    $q2= ("SELECT * FROM palabrasglosario as glo JOIN registroglosario as registro on glo.idPalabras=registro.idPalabra JOIN glosario on registro.idGlosario=glosario.idGlosario WHERE registro.idUsuario=:idUsuario and glosario.idLectura=:idLectura");
      $yaRealizo=$dbConn->prepare($q2);
      $yaRealizo->bindParam(':idUsuario',$idUsuario, PDO::PARAM_INT);
      $yaRealizo->bindParam(':idLectura',$_GET['noLectura'], PDO::PARAM_INT);
      $yaRealizo->execute();
      $hayRegistros=$yaRealizo->rowCount();


//verificar si hay palabras si no mostrar mensaje
    if($cantidadPalabras>=1){
     
      $mostrarMensaje='display:none;';
    }else{
      
      $mostrarMensaje='display:block;';
    }

 ?>


<!DOCTYPE html>
<html lang="es">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0,maximum-scale=1.0">
    <title><?php echo $_SESSION["nombre"]; ?> | Mis Cursos</title>
 
    <!-- CSS de Bootstrap -->
    <link href="../../css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link rel="icon" type="image/png" href="https://atomolector.com/img/icons/icon2.ico"/>
    <link href="../../css/navLateralesModPedagogico.css" rel="stylesheet" media="screen">
    <link href="../../css/centroPagina.css" rel="stylesheet" media="screen">
    <link href="../css/rol5FuncCursos.css" rel="stylesheet" media="screen">
    <link href="https://fonts.googleapis.com/css?family=Ubuntu" rel="stylesheet"><!-- habilitar font famili font-family: 'Ubuntu', sans-serif;-->
    <link href="https://fonts.googleapis.com/css?family=Indie+Flower|Ubuntu" rel="stylesheet"><!-- habilitar font famili font-family: 'Indie Flower', cursive;-->

    <link href="https://fonts.googleapis.com/css?family=Indie+Flower|Nunito+Sans|Ubuntu" rel="stylesheet">
 
    <!-- librerias para el funcionamiento del calendario -->
     <!-- JQUERY FUNCIONAL -->
   <script src='../../js/jquery.min.js'></script>

    <!-- LIBRERIAS RECONOCIMIENTO DE VOZ -->
  

  <script src="../../js/artyom/artyom.min.js"></script>
  <script src="../../js/artyom/artyom.window.js"></script>
  <script src="../../js/artyom/artyomCommands.js"></script>

 <script type="text/javascript" src="../extras/jquery.min.1.7.js"></script>
<script type="text/javascript" src="../extras/modernizr.2.5.3.min.js"></script>


 
  </head>
  <body class="txt-fuente">

  
<!--NAVEGACION CONTENIDO FIJO -->
<?php include '../../static/nav.php'; $nivell=2; directorioNivelesNav($nivell);?>
<!-- //NAVEGACION CONTENIDO FIJO -->

<!-- LATERAL IZQUIERDO CONTENIDO FIJO -->
 <?php include '../../static/lat-izquierdo.php'; $nivel=2; directoriosNiveles($nivel);?>
<!-- //LATERAL IZQUIERDO CONTENIDO FIJO -->

<!--CENTRANDO CONTENIDO ROL 1 -->

<style type="text/css">

body{
  overflow-x: none;
}
.cardGlosario {
 
  box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24);
  margin: 20px;
  
  margin-bottom: 50px;
  transition: all .2s ease-in-out;
  text-decoration: none;
  color: black; 
  border-radius:5px;
}

.cardGlosario:hover {
  /*box-shadow: 0 5px 22px 0 rgba(0,0,0,.25);*/
  box-shadow: 0 10px 20px rgba(0,0,0,0.19), 0 6px 6px rgba(0,0,0,0.23);
  
}

.recodinggN {
 
  box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24);
transition: all .2s ease-in-out;
}

.recodinggN:hover {
  /*box-shadow: 0 5px 22px 0 rgba(0,0,0,.25);*/
  box-shadow: 0 10px 20px rgba(0,0,0,0.19), 0 6px 6px rgba(0,0,0,0.23);
  
}

.card-style{
  
  transition: all 0.3s cubic-bezier(.25,.8,.25,1);
  box-shadow: 0 14px 28px rgba(0, 0, 0, 0.25), 0 10px 10px rgba(0, 0, 0, 0.22);
}

.card-style:hover{
 box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12), 0 1px 2px rgba(0, 0, 0, 0.24);
}


/*estilos alerta */
@import url(https://fonts.googleapis.com/css?family=PT+Sans:400,700,400italic);
@-webkit-keyframes popUpEntrada {
  0%{opacity: 0; margin-top: -20%;}
  75%{margin-top: 5%;}
  100%{opacity: 1;}
}
@keyframes popUpEntrada {
  0%{opacity: 0; margin-top: -20%;}
  75%{margin-top: 5%;}
  100%{opacity: 1;}
}
@-webkit-keyframes popUpSaida {
  0%{opacity: 1;}
  75%{opacity: 1; margin-top: -20%;}
  100%{opacity: 0;margin-top: 40%;}
}
@keyframes popUpSaida {
  0%{opacity: 1;}
  75%{opacity: 1; margin-top: -20%;}
  100%{opacity: 0;margin-top: 40%;}
}
body, html, root, document{
  display: block
  height: 500px;
}
 .popUpFundo{
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    margin: 0;
    padding: 0;
    background-color:#4879c3;
    opacity: 0.8;
    z-index: 50;
}
.popUp{
    box-sizing: border-box;
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    display: none;
    position: fixed;
    top: 40%;
    left: 50%;
    padding: 0;
    font-size: 14px;
    font-family: 'PT Sans', sans-serif;
    color: #fff;
    border-style:none;
    z-index: 999;
    overflow: hidden;
}
.popUp button:focus{
    outline-style: none;
}
.popUp>h1{
    box-sizing: border-box;
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    margin: 0;
    padding: 5px;
    min-height: 40px;
    font-size: 1.2em;
    font-weight: bold;
    text-align: center;
    color: #fff;
    background-color: transparent;
    border-style: none;
    border-width: 5px;
    border-color: black;
}
.vermelha>h1{
    border-color: #fa5032;
}
.verde>h1{
    border-color: #42ad4f;
}
.azul>h1{
    border-color: #659cff;
}

.popUp>div{
    display: block;
    box-sizing: border-box;
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    width: 100%;
    padding: 5%;
    text-align: center;
    vertical-align: middle;
    border-width: 1px;
    border-color: #ccc;
    border-style: none none solid none;
    overflow: auto;
}
.popUp>div>span{
    display: table-cell;
    box-sizing: border-box;
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    margin: 0;
    padding: 0;
    vertical-align: middle;
}
.popUp>button{
    box-sizing: border-box;
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    margin: 0;
    padding: 10px;
    width: 50%;
    border: 1px none #ccc;
    color: #fff;
    font-family: inherit;
    cursor: pointer;
}
.alert{
    width: 100% !important;
}
.popUp .puCancelar{
    float: left;
}

.popUp .puEnviar{
    float: right;
}

.p{
    margin: 0;
    width: 100%;
    max-width: 300px;
    height: 100%;
    max-height: 200px;
    transform: translate(-50%, -50%);
}

.p>div{
    box-sizing: border-box;
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    width: 100%;
    height: calc(100% -108px);
    margin: 0;
    padding: 0;
    border-style: none;
    
}
.p>div>div, .p span{
    box-sizing: border-box;
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    width: 300px;
    height: 108px;
    margin: 0;
    padding: 0;
    border-style: none;

}

.p>button{
    height: 50px;
    
}
.puEnviar{
    margin: 5px 0;
}
.puCancelar{
    margin: 5px 0;
}


.m{
    margin: 0;
    width: 100%;
    max-width: 400px;
    height: 100%;
    max-height: 300px;
    transform: translate(-50%, -50%);
}
.m>div{
    box-sizing: border-box;
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    width: 100%;
    height: calc(100% -108px);
    margin: 0;
    padding: 0;
    border-style: none;
    border-color:#ccc;
}
.m>div>div, .m>span, .m>div>span{
    box-sizing: border-box;
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    width: 400px;
    height: 208px;
    margin: 0;
    padding: 0;
    border-style: none;
}

.m>button{
    height: 50px;
}

.g{
    margin: 0;
    width: 100%;
    max-width: 600px;
    height: 100%;
    max-height: 500px;
    transform: translate(-50%, -50%);
}
.g>div{
    box-sizing: border-box;
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    width: 100%;
    height: calc(100% -108px);
    margin: 0;
    padding: 0;
    border-style: none;
    border-color: #ccc;
}
.g>div>div, .g span{
    box-sizing: border-box;
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    width: 600px;
    height: 408px;
    margin: 0;
    padding: 0;
    border-style: none;
}
.g>button{
   height: 60px;
}


.alert.puEnviar{
    display: none;
}

.popUpEntrada{
    display: block !important;
    animation: popUpEntrada 0.5s;
    -webkit-animation: popUpEntrada 0.5s;
}
.popUpSaida{
    display: block !important;
    animation: popUpSaida 0.5s;
    -webkit-animation: popUpSaida 0.5s;
    -webkit-animation-fill-mode: forwards;
    animation-fill-mode: forwards;
}

.blue{
    background-color:#51b2d6;
}
.blue>button{
    background-color:#38a7d0;
}
.blue>button:hover{
    background-color:#72c1de;
}
.popUpFundo.blue{
    background-color:#134152;
}
.green{
    background-color: #43b649;
}
.green>button{
    background-color:#3da743;
}
.green>button:hover{
    background-color:#4fbe55;
}
.popUpFundo.green{
    background-color:#173f19;
}
.red{
    background-color: #d55c4b;
}
.red>button{
    background-color: #d04b38;
}
.red>button:hover{
    background-color: #d86959;
}
.popUpFundo.red{
    background-color:#4a1811;
}
.orange{
    background-color: #f9a025;
}
.orange>button{
    background-color: #f89710;
}
.orange>button:hover{
    background-color: #f9ac42;
}
.popUpFundo.orange{
    background-color: #8c5b02;
}
.purple{
    background-color: #ab4bd5;
}
.purple>button{
    background-color: #a238d0;
}
.purple>button:hover{
    background-color: #b159d8;
}
.popUpFundo.purple{
    background-color: #3f114a;
}
.white{
    background-color: #fff;
    color: #555;
}
.white>h1{
  color: #000;
}
.white>button{
    background-color: #f3f3f3;
    color: #555;
}
.white>button:hover{
    background-color: #e3e3e3;
}

.popUpFundo.white{
    background-color:#555;
}


/*
That part is just for the form
*/
.colorfulForm{
  width: 350px;
  margin: 60px auto;
}
.colorfulForm input, .colorfulForm textarea, .colorfulForm select{
  box-sizing: border-box;
  -webkit-box-sizing: border-box;
  -moz-box-sizing: border-box;
  width: 350px;
  padding: 5px;
  background-color: #f3f3f3;
  border: 1px solid #ccc;
  border-radius: 2px; 
}

.colorfulForm label{
  display: block;
  font-family: Verdana, Arial;
  margin: 10px 0 5px 0;
}
.colorfulForm button{
  width: 100px;
  margin: 3px 7px;
  padding: 5px;
  color: #fff;
  border-style: none;
}


/*Estilo chips*/
.md-chip {

 
  border-radius: 42px;
  padding: 0;
  height: 62px;
  box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.16), 0 2px 10px 0 rgba(0, 0, 0, 0.12);
  -webkit-transition: .2s ease-out;
          transition: .2s ease-out;
}

.md-chip:hover {
  box-shadow: 0 5px 11px 0 rgba(0, 0, 0, 0.18), 0 4px 15px 0 rgba(0, 0, 0, 0.15);
  cursor: pointer;
}

.md-chip-img {
  border-radius: 50%;
  width: 62px;
  height: 62px;
  overflow: hidden;
  float: left;
  box-shadow: 2px 0px rgba(0,0,0,.3);
}

.md-chip-img .md-chip-span {
  display: block;
  height: 42px;
}

.md-chip-img img {
  -webkit-transform: translate(-50%);
  margin-left: 30px;
  height: 62px;
  
}

.md-chip-text {
  
  font-weight: 400;
  font-size: 16px;
  height: 42px;
  float: left;
  padding: 12px 18px 12px 10px;
  color: rgba(255, 255, 255, .87);
}

/* Colors */
.pink {
  background-color: #E91E63;
}

.orange {
  background-color: #ff9800;
}

.indigo {
  background-color: #3f51b5;
}

.teal {
  background-color: #009688;
}

.purple {
  background-color: #9C27B0;
}

.deep-purple {
  background-color: #512DA8;
}

.white {
  background-color: #fff;
}

.white .md-chip-text {
  color: rgba(0, 0, 0, .87);
}

.red {
  background-color: #f44336;
}

.blue {
  background-color: #2196f3;
 
}

.green {
  background-color: #4caf50
}

</style>






      <div class="col-md-8 col-xs-8 pag-center">
         <div class="card-style" style="width:60px; height: 60px; border-radius:100px; border:4px solid #f39c12; margin-left: 90%; margin-top: 20px; color: #d35400; cursor:pointer; position: absolute; z-index:6;" onclick="informacion();" title="¿Cómo Funciona?"><h1 style="margin-top:7px;">?</h1></div>
        <h3 style="margin-top: 50px;">Aprendo nuevas palabras - Vocabulario</h4>
          

           <a href="lect1p.php?gradoB=<?php echo @$_GET['gradoB']; ?>&idLectura=<?php echo @$_GET['noLectura']; ?>" class="btn botonAgg-1" style="color: white; background-color: #3498db;">Regresar a la lectura</a>
         


                <div class="md-chip blue" style="margin-left: 50px; margin-top: 20px; ">
          <div class="md-chip-img">
            <img src="../../img/noti.png">
          </div>

          <span style="color: white;"><h4 style="padding-top: 5px; padding-right: 10px; padding-left:60px;">Instrucciones: Puedes utilizar el micrófono o puedes redactar la palabra, el objetivo es memorizar para enriquecer nuestro vocabulario.</u></h4></span>
        </div><hr>









          <input type="text" name="nombre" id="nombre" value="<?php echo $_SESSION['nombre']; ?>" style="display: none;">


         <div class="row" style="margin-top: 20px;">
            <h4>Progresión de Aprendizaje</h4>
            <?php  

            @$punetoPregunta=100/$cantidadPalabras;
            @$porcentaje=$hayRegistros*$punetoPregunta;

              ?>
              <div class="progress">
              <div class="progress-bar progress-bar-striped" role="progressbar"  style="width: <?php echo @round($porcentaje)."%"; ?>" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"><?php echo round(@$porcentaje)."%"; ?> </div>
            </div>

        

            


         <?php while(@$row1=$mostrarGlosario->fetch(PDO::FETCH_ASSOC)){?> 
          <div class="row">
              <div class="col-md-3 cardGlosario" id="<?php echo 'card'.$row1['idPalabras']; ?>" style="background-color:#3498db; color: white; min-height:240px; box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24); word-wrap: break-word;">
                <div style="width: 100%; height:150; padding: 0px 0px; border-radius: 5px; ">
                  <h5 style="text-align: right;"><?php echo "Pts:".$row1['ponderacionPalabra'] ?></h5>
                  <h3><?php echo $row1['concepto']; ?></h3>

                <p> <?php echo  $row1['definicion']; ?></p>
                </div>
                <div class="recodinggN" id="<?php echo 'on'.$row1['idPalabras']; ?>" title="Graba el concepto" style="cursor: pointer; padding-top:3px;  width: 50px; height: 50px; border-radius: 100%; margin-top: 10px; background-color: #e67e22; margin-left: 40%;" onclick="inicio(this.id)"><img src="../../img/micro.png" width="40" height="40" ></div>


                <div id="<?php echo 'ofon'.$row1['idPalabras']; ?>" class="recodinggN" title="Graba el concepto" style="cursor: pointer; padding-top:3px;  width: 50px; height: 50px; border-radius: 100%; margin-top: 10px; background-color: #F72626; margin-left: 40%; display: none" onclick="finGrabacion(this.id)"><img src="../../img/microOf.png" width="40" height="40" ></div>

                <div id="<?php echo 'bloq'.$row1['idPalabras']; ?>" class="recodinggN" title="Felicidades!" style="padding-top:3px;  width: 50px; height: 50px; border-radius: 100%; margin-top: 10px; background-color:#9b59b6; margin-left: 40%; display: none"><img src="../../img/star.png" width="40" height="40" ></div>


             </div>
              <div class="col-md-7 cardGlosario" id="<?php echo 'offf'.$row1['idPalabras']; ?>" >
                  <h4>Sin micrófono: redacta la palabra en la caja de abajo, para guardar debes dar doble clic en el botón guardar.</h4>
                 <input type="text"  class="col-md-10 cardGlosario" id="<?php echo $row1['idPalabras']."span-preview" ?>" style="color:black; display: block; border:1px solid #3498db; height:50px; text-align: center;box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24); border-radius:5px;margin-left:30px; margin-bottom: 40px; margin-top:40px;" placeholder="Escribe aqui">
                 <button class="col-md-3 btn botonAgg-1" id="<?php echo 'inputT'.$row1['idPalabras']; ?>" style="margin-bottom: 20px; border: 1px solid #e67e22; background-color: #e67e22; color: white;" onclick="limpiarCajaGlosario(this.id);">Borrar</button>
                  <div class="col-md-1" style="margin-bottom: 20px;"></div>
                   <button class="col-md-3 btn botonAgg-1" id="<?php echo 'caja'.$row1['idPalabras']; ?>" style="margin-bottom: 20px; background-color: #3498db; border:1px solid #3498db; color: white;" onclick="finGrabacion(this.id);">Guardar Palabra</button>
                 </div>

              </div>

            
          <?php $_SESSION['idGlosarioForm']=$row1['idGlosario']; $_SESSION['lect']=$row1['idLectura'];  } ?>
         </div>

<!-- AQUI VERIFICAMOS SI YA REALIZO ALGUNA LECTURA Y CAMBIAMOS ESTILOS TARJETAS -->

        <input id="cantidadIteracion" type="text" name="cantidadRealizada" value="<?php echo $hayRegistros; ?>" style="display: none;">
        <?php while(@$row2=$yaRealizo->fetch(PDO::FETCH_ASSOC)){ @$i+=1; ?>

          <input id="<?php echo "cambiar".$i; ?>" type="text" name="cambiarcolor" value="<?php echo "palabra".$row2['idPalabras']; ?>" style="display: none;">
        <?php } ?> 

<!-- AQUI VERIFICAMOS SI YA REALIZO ALGUNA LECTURA  Y CAMBIAMOS ESTILOS TARJETAS -->


   <form id="formularioE" action="controllador/guardarGlosario.php" method="post" style="display: none;">
            <input id="textoEnviar" type="text" name="textRecord" value="">
            <input type="text" name="idGlosario" value="<?php echo $_SESSION['idGlosarioForm']; ?>">
            <input type="text" name="idUsuario" value="<?php echo $idUsuario; ?>">
            <input type="text" name="lectura" value="<?php echo $_SESSION['lect']; ?>">
              <input id="idGlosarioEnviar" type="text" name="idPalabra" value="">      
              <input id="gradoEnviar" type="text" name="gradoEnviar"  value="<?php echo $_GET['gradoB']; ?>">         
          </form>

         
<div class="card col-md-12" style="background-color: #3498db; color:white; border-radius: 5px; <?php echo $mostrarMensaje; ?>">
 <h1 style="text-align: center;">Glosario aún no disponible, se habilitará en la semana que corresponda. :) </h1>

</div>

<!-- TROZO DE CODIGO NOS VA A SERVIR PARA LANZAR LAS NOTIFICACIONES AL USUARIO --->
         <section class="colorfulForm" style="display: none;">
            <label>Title</label>
            <input type="text" id="title" value="Esto es lo que grabamos ¿Lo deseas Guardar?" class="l2"/><br>
            <label>Text</label>
          <textarea id="myText" class="l2" id="palabraAguardar"></textarea><br>
            <label>Mode</label>
            <select class="l2" id="mode">
                <option value="">confirm</option>
                <option value="alert">alert</option>
            </select><br>
            <label>Size</label>
            <select class="l2" id="size">
              
                <option value="m">medium</option>
              
            </select><br>
          <label>Color</label>
          <button id="activarNoti" class="l1 blue">blue</button> 
          <button class="l1 green">green</button> 
          <button class="l1 red">red</button>  
          <button class="l1 white" style="border: 1px solid #555; color: #555;">white</button>
          <button class="l1 orange">orange</button> 
          <button class="l1 purple">purple</button> 
        </section> 


<!-- TROZO DE CODIGO NOS VA A SERVIR PARA LANZAR LAS NOTIFICACIONES AL USUARIO ---->

   <script type="text/javascript">
    
//fraccion de codigo para cambiar de color las cards --> inicio
  var iteracion = $('#cantidadIteracion').val();
  
  for(var i=1; i<=iteracion; i++ ){


     var cardCambiar= $('#cambiar'+i).val(); //obtenemos el id como no puede ser numero le agregamos una palabra
     var idModificar= cardCambiar.substring(7,60000); // quitamos la palabra y nos queda el id modificar
      $('#card'+idModificar).css('background-color','#2ecc71');
      $('#card'+idModificar).css('background-color','#2ecc71');
      $('#on'+idModificar).css('display','none');
       $('#bloq'+idModificar).css('display','block');
       //$('#caja'+idModificar).css('cursos','not-allowed');
        //$('#caja'+idModificar).css('filter','grayscale(100%)');
        //$('#caja'+idModificar).css('pointer-events','none');

        $('#offf'+idModificar).css('cursos','not-allowed');
        $('#offf'+idModificar).css('filter','grayscale(100%)');
        $('#offf'+idModificar).css('pointer-events','none');


  }



//fraccion de codigo para cambiar de color las cards --> fin


 $('.cardGlosario').bind('cut copy paste', function (e) {
        e.preventDefault();
        alert("LOLA dice: Si lo haces de esta manera no aprenderás. No copies ni pegues. ");
    });

 $(".cardGlosario").on("contextmenu",function(e){
        return false;
          alert("LOLA dice: Si lo haces de esta manera no aprenderás. Creo que quieres copiar. ");
    });


 $('.cardGlosario').bind('cut copy paste', function (e) {
        e.preventDefault();
          alert("LOLA dice: Si lo haces de esta manera no aprenderás. No copies ni pegues. ");
    });

 $(".cardGlosario").on("contextmenu",function(e){
        return false;
         alert("LOLA dice: Si lo haces de esta manera no aprenderás. Creo que quieres copiar. ");
    });



     function startArtyom(){

    artyom.initialize({
        lang: "es-ES",
        continuous:true,// Reconoce 1 solo comando y para de escuchar
              listen:true, // Iniciar !
              debug:true, // Muestra un informe en la consola
              speed:1 // Habla normalmente
      });
  
    };

    function informacion(){
          var name = $('#nombre').val(); 
            startArtyom();
            artyom.say("Hola "+name+" te explicaré como realizar esta actividad, antes de empezar quiero que sepas que si mejoras tu vocabulario podrás incrementar tu comprensión lectora, te ayudaré a comprender, para eso te presentamos las palabras mas difíciles de la lectura, hay dentro de cada tarjeta un micrófono dale clic, y repite la palabra y el concepto por favor. La plataforma guardara cada palabra que dictes, esto te ayudara a guardar mejor las palabras en tú memoria.");
            finAsistente();

          }


        function finAsistente(){
    artyom.fatality();// Detener cualquier instancia previa
  }    

function inicio(clicked_id){
            
            //enviar idPalabra seleccionada para registrarlo en la base de datos          
            var idPalabra= clicked_id.substring(2,60000); 

            startArtyom();
            capturarFluidez(idPalabra);
            
            $('#'+clicked_id).css("display","none");
            $('#of'+clicked_id).css("display","block"); 
            $('#idGlosarioEnviar').val(idPalabra);


           };
    function capturarFluidez(idPalabra){
    // Escribir lo que escucha.
    artyom.redirectRecognizedTextOutput(function(text,isFinal){
      if (isFinal) {
        texto.val(text);
            
      }else{
        var fluidez=[text];

        $("#"+idPalabra+"span-preview").val(fluidez);
        
      }
      
    });

   }
  

function limpiarCajaGlosario(clicked_id){
var idPalabra= clicked_id.substring(6,60000);
//alert(idPalabra);
$('#'+idPalabra+'span-preview').val('');



}



function finGrabacion(clicked_id){
  var idPalabra= clicked_id.substring(4,60000);
  var validacion= clicked_id.substring(0,4);
  var palabraEsp= $("#"+idPalabra+"span-preview").val();
  var gradoEnviar= $("#gradoEnviar").val()
  //alert("#"+validacion+idPalabra);

  if(validacion=="caja"){

    
    if(palabraEsp===""){

      alert("No ingresaste nada en la caja de texto, intenta nuevamente :(");
      location.reload();
    }

    if(palabraEsp!=''){
            var texto = $("#"+idPalabra+"span-preview").val();
           // alert(gradoEnviar);
            $('#idGlosarioEnviar').val(idPalabra);
             $('#textoEnviar').val(texto);
             $("#gradoEnviar").val(gradoEnviar);
             $("#activarNoti").click();
             palabrasAceptar(texto);
             


    }

  }

  if(validacion=="ofon"){
    //alert('datos desde microfono');

  

   var texto = $("#"+idPalabra+"span-preview").val();
   var ocultar= clicked_id;
   var mostrar= ocultar.substring(2,60000); 

   palabrasAceptar(texto);


   $('#'+ocultar).css("display","none");
  $('#'+mostrar).css("display","block"); 
  
  $('#textoEnviar').val(texto);

    //confirmar guardado de grabacion
  $("#activarNoti").click();
    finAsistente();

    }
}


//FUNCIONES PARA LA ALERTA
var janelaPopUp = new Object();
janelaPopUp.abre = function(id, classes, titulo, corpo, functionCancelar, functionEnviar, textoCancelar, textoEnviar){
    var cancelar = (textoCancelar !== undefined)? textoCancelar: 'volver a grabar';
    var enviar = (textoEnviar !== undefined)? textoEnviar: 'Guardar';
    classes += ' ';
    var classArray = classes.split(' ');
    classes = '';
    classesFundo = '';
    var classBot = '';
    $.each(classArray, function(index, value){
        switch(value){
            case 'alert' : classBot += ' alert '; break;
            case 'blue' : classesFundo += this + ' ';
            case 'green' : classesFundo += this + ' ';
            case 'red' : classesFundo += this + ' ';
            case 'white': classesFundo += this + ' ';
            case 'orange': classesFundo += this + ' ';
            case 'purple': classesFundo += this + ' ';
            default : classes += this + ' '; break;
        }
    });
    var popFundo = '<div id="popFundo_' + id + '" class="popUpFundo ' + classesFundo + '"></div>'
    var janela = '<div id="' + id + '" class="popUp ' + classes + '"><h1>' + titulo + "</h1><div><span>" + corpo + "</span></div><button class='puCancelar " + classBot + "' id='" + id +"_cancelar' data-parent=" + id + ">" + cancelar + "</button><button class='puEnviar " + classBot + "' data-parent=" + id + " id='" + id +"_enviar'>" + enviar + "</button></div>";
    $("window, body").css('overflow', 'hidden');
    
    $("body").append(popFundo);
    $("body").append(janela);
    $("body").append(popFundo);
     //alert(janela);
    $("#popFundo_" + id).fadeIn("fast");
    $("#" + id).addClass("popUpEntrada");
    
    $("#" + id + '_cancelar').on("click", function(){
        if((functionCancelar !== undefined) && (functionCancelar !== '')){
            functionCancelar();
            location.reload();
        }else{
            janelaPopUp.fecha(id);
location.reload();            
//alert('rechazo'); //aqui es donde limpiamos la caja
        }
    });
    $("#" + id + '_enviar').on("click", function(){
        if((functionEnviar !== undefined) && (functionEnviar !== '')){

            functionEnviar();

        }else{
            janelaPopUp.fecha(id);
             //si le guardar a la notificacion ejecutamos formulario
             $('#formularioE').submit();
        }
    });
    
};
janelaPopUp.fecha = function(id){
    if(id !== undefined){
        $("#" + id).removeClass("popUpEntrada").addClass("popUpSaida"); 
        
            $("#popFundo_" + id).fadeOut(1000, function(){
                $("#popFundo_" + id).remove();
                $("#" + $(this).attr("id") + ", #" + id).remove();
                if (!($(".popUp")[0])){
                    $("window, body").css('overflow', 'auto');
                }
            });
            
      
    }
    else{
        $(".popUp").removeClass("popUpEntrada").addClass("popUpSaida"); 
        
            $(".popUpFundo").fadeOut(1000, function(){
                $(".popUpFundo").remove();
                $(".popUp").remove();
                $("window, body").css('overflow', 'auto');
            });
            
       
    }
}

function palabrasAceptar(texto){
$("button").on("click", function(){
  var myText = texto;
    //alert(myText);
  janelaPopUp.abre( "asdf", $("#size").val() + " "  + $(this).html() + ' ' + $("#mode").val(),  $("#title").val() ,  myText)
});
}
setTimeout(function(){janelaPopUp.fecha('example');}, 2000);


  </script> 
    
        </div>

<!--//CENTRANDO CONTENIDO ROL 1 -->

<!--LATERAL DERECHO CONTENIDO FIJO -->
    <?php include '../../static/lat-derecho.php';  $nivelll=2; directoriosNivelesDer($nivelll);  ?>
 <!-- //LATERAL IZQUIERDO CONTENIDO FIJO -->  

 
    <!-- Librería jQuery requerida por los plugins de JavaScript -->
    <script   src="https://code.jquery.com/jquery-3.3.1.js"
  integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60="
  crossorigin="anonymous"></script>
 
    <!-- Todos los plugins JavaScript de Bootstrap (también puedes
         incluir archivos JavaScript individuales de los únicos
         plugins que utilices) -->
    <script src="../../js/bootstrap.min.js"></script>
  </body>
</html>
