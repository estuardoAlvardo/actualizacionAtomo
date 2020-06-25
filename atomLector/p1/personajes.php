<?php 
session_start();

//validacion session

if(!isset($_SESSION['idUsuario'])) {
header('Location: ../../index.html');
}


require("../../conection/conexion.php");


@$_GET['noLectura'];
  $sq1 = ("SELECT *  FROM quizpersonajes where idLectura=:idLectura");
    $obtenerQuiz = $dbConn->prepare($sq1);
     $obtenerQuiz->bindparam(':idLectura', $_GET['noLectura']);
    $obtenerQuiz->execute();
    $hayPreguntas=$obtenerQuiz->rowCount();


 $verificarTipoLectura = ("SELECT *  FROM quizpersonajes where idLectura=:idLectura");
    $tipoLectura = $dbConn->prepare($verificarTipoLectura);
     $tipoLectura->bindparam(':idLectura', $_GET['noLectura']);
    $tipoLectura->execute();

  while(@$tipoTexto=$tipoLectura->fetch(PDO::FETCH_ASSOC)){

@$_SESSION['tipoTexto']=$tipoTexto['punteoQuiz'];

}


 if(@$_SESSION['tipoTexto']!=0 ){
     
          if($hayPreguntas>=1 ){
      $bntTerminarQuiz='display:block;';
      $mostrarMensaje='display:none;';

      $mensaje="Custionario aún no disponible, se habilitará en la semana que corresponde. :)";
    }else{
      $bntTerminarQuiz='display:none;';
      $mostrarMensaje='display:block;';
    }


     
    }else{
      $bntTerminarQuiz='display:none;';
      $mostrarMensaje='display:block;';
       $mensaje="Texto no literario, este tipo de texto no cuenta con prueba de personajes por no ser un género narrativo.";
    }

//eliminar boto para terminar cuestionario

 


    
   
   $sql2=("SELECT * FROM preguntaspersonajes JOIN quizpersonajes ON preguntaspersonajes.idquizpersonaje=quizpersonajes.idQuiz JOIN atomolector ON quizpersonajes.idLectura=atomolector.idLectura WHERE atomolector.idLectura=:idLectura");
   $obtenerCuestionario = $dbConn->prepare($sql2);
     $obtenerCuestionario->bindparam(':idLectura', $_GET['noLectura']);
    $obtenerCuestionario->execute();
    $consulta=$obtenerCuestionario->rowCount();

    


//si ya realizo la actividad se le mostrara la nota y su retroalimentacion 

    $sq3 = ("SELECT * FROM registropruebapersonajes where idLectura=:idLectura and idUsuario=:idUsuario");
    $realizoActividad = $dbConn->prepare($sq3);
     $realizoActividad->bindparam(':idLectura', $_GET['noLectura']);
     $realizoActividad->bindparam(':idUsuario', $_SESSION['idUsuario']);
    $realizoActividad->execute();
    $econtreRegistro= $realizoActividad->rowCount();
   


//solucionario
     $sql4=("SELECT * FROM preguntaspersonajes JOIN quizpersonajes ON preguntaspersonajes.idquizpersonaje=quizpersonajes.idQuiz JOIN atomolector ON quizpersonajes.idLectura=atomolector.idLectura   WHERE atomolector.idLectura=:idLectura");
   $quizAcomparar = $dbConn->prepare($sql4);
     $quizAcomparar->bindparam(':idLectura', $_GET['noLectura']);
    $quizAcomparar->execute();


 ?>


<!DOCTYPE html>
<html lang="es">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0,maximum-scale=1.0">
    <title><?php echo $_SESSION["nombre"]; ?> | Personajes</title>
 
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

<!-- libreria para drag an drop ------>
<script src="https://unpkg.com/interactjs@next/dist/interact.min.js"></script>
 
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
  
  margin-bottom: 5px;
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




/* Radio Button –––––––––––––––––––––––––––––––––––––––––––––––––– */

/* Variables
–––––––––––––––––––––––––––––––––––––––––––––––––– */
:root {
  --colorfondo-c: #2980b9;
  --primary-c: #74b9ff;
  --secondary-c: #74b9ff;
  --tercery-c: #74b9ff;
  --fort-c: #74b9ff;
  
  --white: #FDFBFB;
  
  --text: #082943;  
  --bg: var(--colorfondo-c);
}
ul {
  list-style-type: none;
  padding-left: 50px;
  margin: 0;
}

li {
  display: block;
  position: relative;
  padding: 20px 0px;
}

h2 {
  margin: 10px 0;
  font-weight: 900;
}


/* Card
–––––––––––––––––––––––––––––––––––––––––––––––––– */
.card {
  display: flex;
  flex-direction: column; 
  background: var(--white);
 
  padding: 20px 25px;
  border-radius: 20px;
  box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24);
                     transition: all 0.3s cubic-bezier(.25,.8,.25,1);
  margin-top: 20px;
  text-align: left;

}
input[type=radio] {
  position: absolute;
  visibility: block;
  margin-left: -45px; 
  z-index: 6;
  width:30px;height:30px;
  opacity: 0;
  cursor: pointer;
}



.check {
  width: 40px; height: 40px;
  position: absolute;
  border-radius: 50%;
  transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
  box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24);


}

.check:hover{
  box-shadow: 0 14px 28px rgba(0, 0, 0, 0.25), 0 10px 10px rgba(0, 0, 0, 0.22);
  background-color: #3498db;
}

input:hover  ~ .check {
  box-shadow: 0 14px 28px rgba(0, 0, 0, 0.25), 0 10px 10px rgba(0, 0, 0, 0.22);
  background-color: #3498db;
}

/* Reset */
input#one ~ .check { 
  transform: translate(-50px, -30px); 
  background: var(--primary-c); 

}
input#two ~ .check { 
  transform: translate(-50px,-30px); 
  background: var(--secondary-c);
  
}
input#tree ~ .check { 
  transform: translate(-50px, -30px); 
  background: var(--tercery-c);
  
}
input#fort ~ .check { 
  transform: translate(-50px, -30px); 
  background: var(--fort-c);
  
  
}

/* Radio Input #1 */
input#one:checked ~ .check { transform: translate(-50px, -35px); 
  box-shadow: 0 14px 28px rgba(0, 0, 0, 0.25), 0 10px 10px rgba(0, 0, 0, 0.22);
  background: var(--colorfondo-c);



}
input#one:checked ~ label  {
  padding:5px;
  box-shadow: 0 14px 28px rgba(0, 0, 0, 0.25), 0 10px 10px rgba(0, 0, 0, 0.22);
  background-color: #3498db;
  color: white;
  border-radius: 10px;


}


/* Radio Input #2  */
input#two:checked ~ .check { transform: translate(-50px, -35px);
box-shadow: 0 6px 12px rgba(33, 150, 243, 0.35);
  background: var(--colorfondo-c);
}

input#two:checked ~ label  {
  padding:5px;
  box-shadow: 0 14px 28px rgba(0, 0, 0, 0.25), 0 10px 10px rgba(0, 0, 0, 0.22);
  background-color: #3498db;
  color: white;
  border-radius: 10px;


}

/* Radio Input #3  */

input#tree:checked ~ .check { transform: translate(-50px, -35px);
  box-shadow: 0 6px 12px rgba(33, 150, 243, 0.35);
  background: var(--colorfondo-c);
  
  

}
input#tree:checked ~ label  {
  padding:5px;
  box-shadow: 0 14px 28px rgba(0, 0, 0, 0.25), 0 10px 10px rgba(0, 0, 0, 0.22);
  background-color: #3498db;
  color: white;
  border-radius: 10px;


}

/* Radio Input #4  */

input#fort:checked ~ .check { transform: translate(-50px, -35px);
  box-shadow: 0 6px 12px rgba(33, 150, 243, 0.35);
  background: var(--colorfondo-c);

}
input#fort:checked ~ label  {
  padding:5px;
  box-shadow: 0 14px 28px rgba(0, 0, 0, 0.25), 0 10px 10px rgba(0, 0, 0, 0.22);
  background-color: #3498db;
  color: white;
  border-radius: 10px;


}


/*estilo tiempo*/
  .card11{
    position: relative;
    width: 60px;
    height: 60px;
   
    background: #fff;
    box-shadow: 0 15px 60px rgba(0,0,0, .5);
    border-radius: 15px;
  }
  
  .card11 .face{
    position: absolute;
    bottom: 0;
    left: 0;
    width: 100%;
    height: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
  }
  
  .card11 .face.face1{
    box-sizing: border-box;
    padding: 20px;
  }
  
  .card11 .face.face1 h2{
    margin: 0;
    padding: 0;
    
  }
  
  .card11.face.face1 .content{
    font-size:1.2em;
    margin:0;
    padding:0 0 1em 0;
    font-weight:500;
  }
  
  .card11 .face.face2{
    background: #111;
    transition: 0.5s;
  }
  
  .card11:nth-child(1) .face.face2{
    background: linear-gradient(45deg, #3503ad, #f7308c);
    border-radius: 15px;
  }
  
  .card11:nth-child(2) .face.face2{
    background: linear-gradient(45deg, #ccff00, #09afff);
    border-radius: 15px;
  }
  
  .card11:nth-child(2) .face.face2{
    background: linear-gradient(45deg, #e91e63, #ffeb3b);
    border-radius: 15px;
  }
  

  .card11 .face.face2:before{
    content:'';
    position: absolute;
    top:0;
    left:0;
    width: 50%;
    height: 100%;
    background: rgba(255,255,255, 0.1);
    border-radius: 15px 0 0 15px;
  }
  
  .card11 .face.face2 h2{
    margin: 0;
    padding: 0;
    font-size: 2em;
    color: #fff;
    transition: 0.5s;
    text-shadow: 0 2px 5px rgba(0,0,0, .2);
  }




</style>






      <div class="col-md-8 col-xs-8 pag-center">
         <div class="card-style" style="width:60px; height: 60px; border-radius:100px; border:4px solid #f39c12; margin-left: 90%; margin-top: 20px; color: #d35400; cursor:pointer; position: absolute; z-index:6;" onclick="informacion();" title="¿Cómo Funciona?"><h1 style="margin-top:7px;">?</h1></div>

      <h3 style="margin-top: 50px;">Identifica a los personajes</h4>

        <a href="lect1p.php?gradoB=<?php echo @$_GET['gradoB']; ?>&idLectura=<?php echo @$_GET['noLectura']; ?>" class="btn botonAgg-1" style="color: white; background-color: #3498db;">Regresar a la lectura</a>

        <input id="hayDatosenBD" type="text" name="" value="<?php echo @$econtreRegistro ?>" style="display: none;">


<!-- AQUI MOSTRAMOS EL RESULTADO DE LA PRUEBA EN CASO HABER REALIZADO LA PRUEBA inicio-->


        <div class="col-md-12 card-style reporteQuiz" style="min-height: 200px; margin-top: 50px; background-color: #3498db; color: white;">
           <h3>Tú resultado obtenido en está actividad es de: </h3>
           <div id="" class="recodinggN" title="Felicidades!" style="padding-top:3px;  width: 50px; height: 50px; border-radius: 100%; margin-top: -30px; background-color:#9b59b6; margin-left: 95%; display: block;"><img src="../../img/star.png" width="40" height="40" ></div>
          <?php  while(@$fila=$realizoActividad->fetch(PDO::FETCH_ASSOC)){ @$m+=1;
                $_SESSION['punetoTotaln']=$fila['totalResultado'];

             ?>
           <div class="recodinggN" style="margin-left:40%;height: 150px; width: 150px; border-radius: 100px; background-color: #2ecc71; color: white; font-size: 15pt; font-weight: bold; margin-bottom: 20px;"><h3 style="padding-top: 60px;"><?php echo $_SESSION['punetoTotaln']."pts"; ?></h3></div>
         </div>

         <div class="col-md-12 recodinggN reporteQuiz" style="min-height: 200px; margin-top: 30px;">

          <h3>Retroalimentación</h3>
              
          <div style="text-align: left;">  
          <h4>Se registro la prueba: <?php echo $fila['fechaRegistro']." ".$fila['horaRegistro']; ?> </h4>
          <h4>Tiempo usado en evaluación: <?php echo $fila['tiempo']; ?> </h4>
          </div>
          <?php  $_SESSION['rPregunta1']=$fila['rPregunta1']; 
                 $_SESSION['rPregunta2']=$fila['rPregunta2'];
                 $_SESSION['rPregunta3']=$fila['rPregunta3'];
                 $_SESSION['rPregunta4']=$fila['rPregunta4'];
                 $_SESSION['rPregunta5']=$fila['rPregunta5'];
        } ?>
          <table class="table table-hover" style="">
            <thead>
              <tr>
                <th scope="col">Pregunta #</th>
                <th scope="col">Pregunta</th>
                <th scope="col">Respuesta Correcta</th>
                <th scope="col">Tú Respuesta</th>
                <th scope="col">Punteo Obtenido</th>
              </tr>
            </thead>
            <tbody>
            
              <tr>
                <?php  while(@$fila2=$quizAcomparar->fetch(PDO::FETCH_ASSOC)){
                  @$e+=1;
                  ?>
                <th scope="row"><?php echo $e; ?></th>
                <td><?php echo $fila2['pregunta']; ?></td>
                <td><?php  echo $fila2['respuesta'.$fila2['respuestaCorrecta']]; ?></td>
                <td><?php echo $fila2["respuesta".$_SESSION['rPregunta'.$e]]; ?></td>
                <td><?php if($_SESSION['rPregunta'.$e]==$fila2['respuestaCorrecta']){echo $fila2['punteoItem']; }else{ echo 0; }   ?></td>
              </tr>
            <?php } ?>
            </tbody>
          </table>
                     
         </div>
<!-- AQUI MOSTRAMOS EL RESULTADO DE LA PRUEBA EN CASO HABER REALIZADO LA PRUEBA FIN-->

<!-- AQUI MOSTRAMOS EL QUIZ EN CASO DE NO HABERLO REALIZADO inicio-->

<?php 

switch ($_GET['gradoB']) {
  case 1:
    $estiloGrado='display:block';
    break;
  case 2:
    $estiloGrado='display:block';
    break;
  case 3:
    $estiloGrado='display:block';
    break;
  case 4:
    $estiloGrado='display:block';
    break;
  case 5:
    $estiloGrado='display:block';
    break;
  case 6:
    $estiloGrado='display:block';
    break;  

  default:
    $estiloGrado='display:none;';
    break;
}


?>


<div class="row mostrarQuiz" style="margin-top: 50px; display: none;">
  <div id="pistas"  style="<?php echo $estiloGrado; ?>">
      <h4 class="cardGlosario" style=" background: linear-gradient(to right, #C6426E, #642B73); color:white;">PISTAS </h4>
          <div class="col-md-2 cardGlosario" style="border-radius: 5px; background-color: #e67e22; color: white; height: 60px; cursor: pointer; margin-left: 70px;" onclick="personajePrimario();">
                  <h4>Personaje Primario</h4>
          </div>
           <div class="col-md-2 cardGlosario" style="border-radius: 5px; background-color: #e67e22; color: white; height: 60px; cursor: pointer;" onclick="personajeSecundario();">
                  <h4>Personaje Secundario</h4>
          </div>
           <div class="col-md-2 cardGlosario" style="border-radius: 5px; background-color: #e67e22; color: white; height: 60px; cursor: pointer;" onclick="personajeTerciario();">
                  <h4>Personaje Terciario</h4>
          </div>
          <div class="col-md-2 cardGlosario" style="border-radius: 5px; background-color: #e67e22; color: white; height: 60px; cursor: pointer;" onclick="personajeProtagonista();">
                  <h4>Protagonista</h4>
          </div>
          <div class="col-md-2 cardGlosario" style="border-radius: 5px; background-color: #e67e22; color: white; height: 60px; cursor: pointer; margin-left: 70px;" onclick="personajeAntagonista();">
                  <h4>Antagonista</h4>
          </div>

           <div class="col-md-2 cardGlosario" style="border-radius: 5px; background-color: #e67e22; color: white; height: 60px; cursor: pointer;" onclick="personajeColectivos();">
                  <h4>Personajes Colectivos</h4>
          </div>
          <div class="col-md-2 cardGlosario" style="border-radius: 5px; background-color: #e67e22; color: white; height: 60px; cursor: pointer;" onclick="personajesFugaces();">
                  <h4>Personajes Fugaces</h4>
          </div>
    </div>
</div>

 <?php while(@$row2=$obtenerQuiz->fetch(PDO::FETCH_ASSOC)){  
 
 ?>
      <div class="col-md-12 mostrarQuiz" style="border:2px solid; border-image: linear-gradient(to right, #C6426E, #642B73)1; box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24); margin-top:30px;min-height:100px; text-align: left; border-radius: 5px; margin-left:-0px; display: none">
        <img src="https://ionicframework.com/img/getting-started/ionic-native-card.png" style=" transform: rotate(-180deg); position: absolute; height: 100%; margin-left: -15px;">
        <h4 style="text-align: center; font-weight: bold;">Datos de la lectura</h4>
        <div style="margin-left: 120px; margin-top: 60px;">
        <h4 style="font-weight: bold;">Nombre Lectura:<span  style="font-weight: normal;"> <?php echo '"'.$row2['nombreQuiz'].'"'; ?></span></h4>
        <p id="idLectura" style="display: none;"><?php echo $row2['idLectura']; ?></p>
        <h4 style="font-weight: bold;">Nombre Alumno: <span style="font-weight: normal;"><?php echo strtoupper($_SESSION['nombre'])." ".strtoupper($_SESSION['apellido']); ?></span> </h4>
        </div>  
        <div style="border:0px  pink; margin-bottom: 30px; margin-top: -50px; ">

            <h1  style="margin-top:-40px; margin-left: 80%;">Tiempo:</h1>
            <div class="row" style="margin-left:80%;">
    <div class="card11 col-md-1" style="">
      <div class="face face2">
        <h2 id="minutos">00</h2>
        <p style="margin-left:3px; font-size: 12px; text-align: center; color: white;">min</p>
      </div>
    </div>

    <div class="card11 col-md-1" style="margin-left:10px;">
      
      <div class="face face2">
        <h2 id="segundos">00</h2>
        <p style="margin-left:3px; font-size: 12px; text-align: center; color: white;"> seg</p>
      </div>
    </div>
          </div> 
          </div> 
        
      </div>
  <?php } ?>   

<form class="mostrarQuiz" action="controllador/calificarquizPersonaje.php" method="post" id="cuestionarioEnviar2" style="display: none;">

<?php while(@$row1=$obtenerCuestionario->fetch(PDO::FETCH_ASSOC)){  
 @$noPregunta+=1;
 ?>
    
<div class="card col-md-12">
  <div style="display: inline-block; border: 3px solid white; border-radius: 20rem; color: white; text-align: center; padding: 0.5rem; box-shadow: rgba(0, 0, 0, 0.15) 0px 1px 3px 0px; font-weight: 600; min-width: 4rem; font-size: 2rem; background: linear-gradient(to right, #C6426E, #642B73); position: absolute; margin-top: 15%; margin-left: 90%;" ><?php echo @$noPregunta; ?></div>
  <h4 style="text-align: center;"><?php echo "Pregunta no.".$noPregunta.": ".$row1['pregunta']; ?></h4>
  
  <ul>
    <li >
      <input value="1" type="radio" name="<?php echo 'name'.$noPregunta; ?>" id="one" style="" />
      <label ><?php echo $row1['respuesta1']; ?></label>
      
      
      <div class="check"></div>
    </li>
    
    <li>
      <input type="radio" value="2" name="<?php echo 'name'.$noPregunta; ?>" id="two" />
      <label ><?php echo $row1['respuesta2']; ?></label>
      
      <div class="check"></div>
    </li>
    <li>
      <input type="radio" value="3" name="<?php echo 'name'.$noPregunta; ?>" id="tree" />
      <label ><?php echo $row1['respuesta3']; ?></label>
      
      <div class="check"></div>
    </li>
  </ul>
</div>

 <?php } ?>


 <input type="text" name="idUsuario" id="" value="<?php echo $_SESSION['idUsuario']; ?>" style="display: none;">

 <input type="text" name="idLecturaEnviado" id="idLecturaEnviar" value="" style="display: none;">
 <input type="text" name="cantidadPreguntas" value="<?php echo $consulta; ?>" style="display: none;">
  <input type="text" name="tiempo" id="tiempo" value="" style="display: none;">
  <input type="text" name="gradoB" id="tiempo" value="<?php echo $_GET['gradoB']; ?>" style="display: none;">
 <input style="<?php echo $bntTerminarQuiz; ?>margin-top: 20px; margin-bottom: 50px; border:1px solid #2980b9; background-color: #2980b9; color:white; margin-left: 280px;border: 1px solid #3498db;font-size: 30px;" onclick="obtenerTiempoSubmit();"  value="Calificar Test" name="" class="btn btn-default botonAgg-1">
  </form>



<div class="card col-md-12" style="background-color: #3498db; color:white; <?php echo $mostrarMensaje; ?>">
 <h1 style="text-align: center;"><?php echo $mensaje; ?> </h1>

</div>
<!-- AQUI MOSTRAMOS EL QUIZ EN CASO DE NO HABERLO REALIZADO fin-->



   <script type="text/javascript">


//funcion para mostrar el resultado o mostrar el quiz en caso de que no lo halla echo 

var hayregistro = $('#hayDatosenBD').val();

if(hayregistro!=0){
  $('.reporteQuiz').css("display","block");
  $('.mostrarQuiz').css("display","none");


}else{
$('.reporteQuiz').css("display","none");
  $('.mostrarQuiz').css("display","block");


}




//obtener tiempo en que realiza el cuestionario
function obtenerTiempoSubmit(){
    minutos = $("#minutos").text();
    segundos= $("#segundos").text();
    idLectura=$("#idLectura").text();
    
    $("#tiempo").val(minutos+":"+segundos);
    $("#idLecturaEnviar").val(idLectura);
    $("#cuestionarioEnviar2").submit();
  }
  //obtener tiempo en que realiza el cuestionario



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
            artyom.say("Hola "+name+" estoy para ayudarte, te explicaré para que sirve está actividad, quiero contarte que para poder comprender de mejor manera la lectura, tienes que reflexionar en ella, reflexionar significa, pensar en lo que más té gusto de la lectura, cuando ya sepas que fue lo que más te gusto, pulsa el micrófono y cuéntame por favor.");
            finAsistente();

          }


        function finAsistente(){
    artyom.fatality();// Detener cualquier instancia previa
  }    

function inicio(clicked_id){
            
            //enviar idPalabra seleccionada para registrarlo en la base de datos          
            var idPalabra= clicked_id.substring(2,6);
            startArtyom();
            capturarFluidez();            
            $('#microOn').css("display","none");
            $('#microOf').css("display","block"); 
            $('#idGlosarioEnviar').val(idPalabra);

           };

    function capturarFluidez(){
    // Escribir lo que escucha.
    artyom.redirectRecognizedTextOutput(function(text,isFinal){
      if (isFinal) {
        texto.val(text);
            
      }else{
        var fluidez=[text];
        $("#span-preview").text(fluidez);
     
      }
      
    });

   }
  

function finGrabacion(clicked_id){
   var texto = $("#span-preview").text();
   var ocultar= clicked_id;
   var mostrar= ocultar.substring(2,6); 

  
  $('#textoEnviar').val(texto);

    //confirmar guardado de grabacion
  $("#activarNoti").click();
    finAsistente();
}




//funciones para reloj
 window.onload=carga();

  function carga()
  {
    contador_s =0;
    contador_m =0;
    s = document.getElementById("segundos");
    m = document.getElementById("minutos");

    cronometro = setInterval(
      function(){
        if(contador_s==60)
        {
          contador_s=0;
          contador_m++;
          m.innerHTML = contador_m;

          if(contador_m==60)
          {
            contador_m=0;
          }
        }

        s.innerHTML = contador_s;
        contador_s++;

      }
      ,1000);

  }


//funcion para darle la pista de los personajes al user



function personajePrimario(){
  startArtyom();
  artyom.say("Muy bien te daré una pista sobre un personaje primario, es aquél o a quéllos que destacan sobre los demás en toda la lectura, son el centro de la acción. Tedare algunas caracteristicas, sufren cambios a lo largo del proceso narrativo, Poseen un móvil para sus actos: su acción puede provenir de un deseo, de un temor, de una necesidad que les obliga a luchar contra las circunstancias. Pero no tienen por qué ser heroicos.");
   finAsistente();

}

function personajeSecundario(){
  startArtyom();
  artyom.say("okey té ayudaré, un personaje secundario, es aquél o a quéllos cuya importancia es menor, aunque a veces adquieren relevancia en ciertas partes de la lectura, sirven para conocer mejor a los personajes principales o son importantes para que la acción avance. Muchos personajes secundarios van apareciendo aquí o allá y son utilizados por el escritor como fondo de la narración.  ");
   finAsistente();

}

function personajeTerciario(){
  startArtyom();
  artyom.say("Estoy para ayudarte, aquí una pista, Los personajes terciarios son aquellos cuya importancia es menor, sus apariciones son pocas. Son personajes incluidos para una broma y relleno de la trama de la historia, pueden ser individuales o colectivos.");
   finAsistente();
}


function personajeProtagonista(){
    startArtyom();
  artyom.say("Veo que quieres aprender , aquí tienes la pista, El protagonista, es aquel que  lleva a cabo las acciones más importantes de la historia. Sin su participación, la trama carecería de sentido. Un protagonista generalmente se enfrenta a un antagonista de algún tipo, ya sea en la forma de otro personaje, una fuerza de la naturaleza o sus propias dudas internas.");
   finAsistente();

}

function personajeAntagonista(){
    startArtyom();
  artyom.say("Te daré una pista, un antagonista se interpone en el camino de los objetivos del protagonista en una historia, pero no siempre son malvados o destruyen al protagonista; a veces, simplemente se interponen en el camino. Comparten muchos de los mismos rasgos de los protagonistas, incluidos la valentía, la inteligencia, impulsada por un objetivo y la lealtad feroz.");
   finAsistente();

}


function personajeAntagonista(){
    startArtyom();
  artyom.say("Te daré una pista, un antagonista se interpone en el camino de los objetivos del protagonista en una historia, pero no siempre son malvados o destruyen al protagonista; a veces, simplemente se interponen en el camino. Comparten muchos de los mismos rasgos de los protagonistas, incluidos la valentía, la inteligencia, impulsada por un objetivo y la lealtad feroz.");
   finAsistente();

}

function personajeAntagonista(){
    startArtyom();
  artyom.say("Te daré una pista, un antagonista se interpone en el camino de los objetivos del protagonista en una historia, pero no siempre son malvados o destruyen al protagonista; a veces, simplemente se interponen en el camino. Comparten muchos de los mismos rasgos de los protagonistas, incluidos la valentía, la inteligencia, impulsada por un objetivo y la lealtad feroz.");
   finAsistente();

}



function personajeColectivos(){
  startArtyom();
  artyom.say("Te daré la pista con mucho gusto,los personajes colectivos reciben ese nombre cualquier grupo que cubre una sola función dentro de la historia, y en donde si bien cada uno de ellos son poco importantes a nivel narrativo, en conjunto cubren un papel primordial.");
  finAsistente();
}


function personajesFUgaces(){
  startArtyom();
  artyom.say("Me gusta que seas curioso, está es la pista. Un personaje fugaz o tambien llamado incidental es aquel que aparece fugazmente dentro de la trama, con un objetivo específico respecto a los otros personajes y dentro de la historia principal. La participación del personaje incidental suele ser breve, bien sea para realizar una observación puntual sobre una situación, comentar algo llamativo o hacer una pregunta a alguno de los protagonistas de la historia.");
  finAsistente();
}
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