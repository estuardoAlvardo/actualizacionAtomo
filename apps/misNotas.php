<?php 
session_start();


//validacion session

if(!isset($_SESSION['idUsuario'])) {
header('Location: ../index.html');
}


require("../conection/conexion.php");

$_SESSION['idUsuario'];
$_SESSION['grado'];
$gradoReporte =$_SESSION['grado'];

$noSemanaActual = date("W"); //produccion
$semanaPrueba=$noSemanaActual-6;
$semana=$semanaPrueba;

//seleccionamos todas las lecturas de comprension lectora, esta es la maestra
//esta mostrara todas las pruebas de compnresion primer intento
$q1=("SELECT * ,registropruebacomprension.idRegistro as registroCnb FROM registropruebacomprension join atomolector on registropruebacomprension.idLectura=atomolector.idLectura join registropruebapersonajes on registropruebapersonajes.idLectura=atomolector.idLectura join contuspalabras on contuspalabras.idLectura=atomolector.idLectura where registropruebacomprension.idUsuario=:idUsuario and nivelObtenido='' AND registropruebapersonajes.idUsuario=:idUsuario and contuspalabras.idUsuario=:idUsuario AND registropruebacomprension.intento=1");
$mostrarLecturas=$dbConn->prepare($q1);
$mostrarLecturas->bindParam(':idUsuario', $_SESSION['idUsuario'], PDO::PARAM_INT);
$mostrarLecturas->execute();
$totalEncontrado=$mostrarLecturas->rowCount();




//mostramos las lecturas de velocidad

/*
SELECT * FROM atomolectorvelocidad JOIN velocidadLectora on atomolectorvelocidad.noLectura=velocidadLectora.idLectura where idUsuario=17 and intento=1 and idLectura=2
*/

$consulta1=("SELECT * FROM atomolectorvelocidad JOIN velocidadlectora on atomolectorvelocidad.noLectura=velocidadlectora.idLectura where idUsuario=1 and intento=1;");
$mostrarVelocidad=$dbConn->prepare($consulta1);
$mostrarVelocidad->bindParam(':idUsuario', $_SESSION['idUsuario'], PDO::PARAM_INT);
$mostrarVelocidad->execute();

$fecha_actual=date("d/m/Y");
 $hora_actual=date('h:i:s');




switch ($gradoReporte) {
  case 1:
    $gradoDiseño='1ero Primaria';
    break;
   case 2:
    $gradoDiseño='2do Primaria';
    break;
   case 3:
    $gradoDiseño='3ero Primaria';
    break;
  case 4:
    $gradoDiseño='4to Primaria';
    break;
  case 5:
    $gradoDiseño='5to Primaria';
    break;
  case 6:
    $gradoDiseño='6to Primaria';
    break;
   case 7:
    $gradoDiseño='1ero Básico';
    break;
   case 8:
    $gradoDiseño='2do Básico';
    break;
  case 9:
    $gradoDiseño='3ero Básico';
    break;
  case 10:
    $gradoDiseño='4to Diver';
    break;
  case 11:
    $gradoDiseño='5to Diver';
    break;
  case 12:
    $gradoDiseño='6to Diver';
    break;
  case 13:
    $gradoDiseño='Prekinder';
    break;
  case 14:
    $gradoDiseño='kinder';
    break;
  case 15:
    $gradoDiseño='Preparatoria';
    break;
  
  default:
    # code...
    break;
}


?>


<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0,maximum-scale=1.0">
    <title><?php echo $_SESSION["nombre"]; ?> | Mis Notas</title>
 
    <!-- CSS de Bootstrap -->
    <link href="../css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link rel="icon" type="image/png" href="https://atomolector.com/img/icons/icon2.ico"/>
    <link href="../css/navLateralesModPedagogico.css" rel="stylesheet" media="screen">
    <link href="../css/centroPagina.css" rel="stylesheet" media="screen">
    <link href="../css/rol5FuncCursos.css" rel="stylesheet" media="screen">
    <link href="https://fonts.googleapis.com/css?family=Ubuntu" rel="stylesheet"><!-- habilitar font famili font-family: 'Ubuntu', sans-serif;-->
    <link href="https://fonts.googleapis.com/css?family=Indie+Flower|Ubuntu" rel="stylesheet"><!-- habilitar font famili font-family: 'Indie Flower', cursive;-->

    <link href="https://fonts.googleapis.com/css?family=Indie+Flower|Nunito+Sans|Ubuntu" rel="stylesheet">
 
    <!-- CDN PARA BOTONES DE EXPORTACION -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.16/datatables.min.css"/>
    <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.16/datatables.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.5.1/css/buttons.dataTables.min.css">
    
 <!-- jquery funcional -->
    <script src='../js/jquery.min.js'></script>

  </head>
  <body class="txt-fuente">

  
<!--NAVEGACION CONTENIDO FIJO -->
<?php include '../static/nav.php'; $nivell=1; directorioNivelesNav($nivell); ?>
<!-- //NAVEGACION CONTENIDO FIJO -->

<!-- LATERAL IZQUIERDO CONTENIDO FIJO -->
 <?php include '../static/lat-izquierdo.php'; $nivel=1; directoriosNiveles($nivel); ?>
<!-- //LATERAL IZQUIERDO CONTENIDO FIJO -->

<!--CENTRANDO CONTENIDO ROL 1 -->
 <style type="text/css">
.botonAgg {
  background: #fff;
  border-radius: 10px;
  display: inline-block;
  margin: 1rem;
  position: relative;
  
}
.botonAgg-1 {
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12), 0 1px 2px rgba(0, 0, 0, 0.24);
  transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
}

.botonAgg-1:hover {
  box-shadow: 0 14px 28px rgba(0, 0, 0, 0.25), 0 10px 10px rgba(0, 0, 0, 0.22);
}

.sombra{
   box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12), 0 1px 2px rgba(0, 0, 0, 0.24);
}

 </style>



 			<div class="col-md-8 col-xs-8 pag-center">
         <div class="col-md-12" style=" margin-bottom: 50px;">
              <h3 class="text-center">Mis Notas</h3>
         </div>

          <div class="col-md-12 sombra text-left" style="height:25px; margin-bottom: 15px;">Reporte Comprensión / <strong>*Nota: tienes que terminar todas las actividades de la lectura</strong></div>
         

         <div class="col-md-2 sombra text-left" style="height:25px; margin-top:50px; margin-bottom: -170px; background-color: #2980b9; color: white; border-radius: 5px;">Lecturas Diarias</div>

            <button class="btn btn-default botonAgg botonAgg-1" type="button" style="margin-left:730px; margin-bottom: -150px; background-color: #16a085; color: white; border:white;" onclick = "exportTableToExcel ('lectDiaria','LecturasDiarias')">EXCEL</button>
           <p id="gradoPdf" style="display:none;"><?php echo $gradoReporte; ?></p> 

           <h2  style="display: block;"><?php echo 'Grado: '.$gradoDiseño.'- Reporte General: '.@$semana.'<br> Reporte a fecha: '.$fecha_actual.' '.$hora_actual;  ?></h2>


<?php if($gradoReporte>=13 and $gradoReporte<=15){?>
       <div class="col-md-12 sombra"  id="customers" style=" min-height:100px; margin-bottom: 30px;">

                    <table class="table table-hover" id="lectDiaria">
                       <caption style="display: none;"><?php echo 'Grado: '.$gradoReporte.'-- Reporte hasta la semana '.$semana.'<br> Reporte a fecha: '.$fecha_actual.' '.$hora_actual; ; ?></caption>
                      <thead>

                        <?php
                        for($n=1; $n<=$semana;$n++){
                          $buscarLecturasDiarias= ("SELECT * FROM atomolector where grado=:grado and semana=:semana and estatus=1");
                            $lecturasSemana=$dbConn->prepare($buscarLecturasDiarias);
                            $lecturasSemana->bindParam(':grado',$gradoReporte, PDO::PARAM_INT);
                            $lecturasSemana->bindParam(':semana',$n);
                            $lecturasSemana->execute();
                            $contadorLecturas=$lecturasSemana->rowCount();


                         ?>
                        <tr>
                          <th scope="col">Alumno</th>
                          <th scope="col">Registros</th>
                          
                          <?php  while(@$lectSemana=$lecturasSemana->fetch(PDO::FETCH_ASSOC)){
                            //mostramos los dias y la lectura Correspondiente
                            switch ($lectSemana['noLecturaDiaria']) {
                              case 1:
                                $diaMostrar='Lunes';
                                $lecturaM=$lectSemana['nombreLectura'];
                                $_SESSION['idLecturaL']=$lectSemana['idLectura'];
                                break;
                              case 2:
                                $diaMostrar='Martes';
                                $lecturaM=$lectSemana['nombreLectura'];
                                $_SESSION['idLecturaM']=$lectSemana['idLectura'];
                                break;
                               case 3:
                                $diaMostrar='Miercoles';
                                $lecturaM=$lectSemana['nombreLectura'];
                                $_SESSION['idLecturaX']=$lectSemana['idLectura'];
                                break;
                              case 4:
                                $diaMostrar='Jueves';
                                $lecturaM=$lectSemana['nombreLectura'];
                                $_SESSION['idLecturaJ']=$lectSemana['idLectura'];
                                break;
                              case 5:
                                $diaMostrar='viernes';
                                $lecturaM=$lectSemana['nombreLectura'];
                                $_SESSION['idLecturaV']=$lectSemana['idLectura'];
                                break;
                              
                              default:
                                # code...
                                break;
                            }

                            ?>
                          <th title="<?php echo $lecturaM; ?>" scope="col"><?php echo $diaMostrar.'<br>'.$lecturaM; ?></th>
                         <?php } ?>
                         <th scope="col">Avance Semanal</th>
                        </tr>
                      </thead>

                      <tbody class="text-left">
                         <?php    
                          $sumaSemana=0;
                          $incremetoDia=0;

                          ?>
                        <tr>
                            
                          <td><?php echo $_SESSION['nombre'].' '.$_SESSION['apellido']; ?></td>
                          <td><a href="reportesDetalles.php?idUsuario=<?php echo $_SESSION['idUsuario']; ?>&semana=<?php echo $semana; ?>&grado=<?php echo $gradoReporte; ?>&nombreUsuario=<?php echo $_SESSION['nombre'].' '.$_SESSION['apellido']; ?>" target="_blank">Detalle</a></td>
                          <td><?php 
                            //verificamos si ha realizad las lecturas diarias

                            if($_SESSION['idLecturaL']){
                            $q1 = ("SELECT * FROM registroLectDiaria where  idLectura=:idLectura and idUsuario=:idUsuario");
                              $buscarPrescoInicial=$dbConn->prepare($q1);
                              $buscarPrescoInicial->bindParam(':idLectura',$_SESSION['idLecturaL'], PDO::PARAM_INT); 
                              $buscarPrescoInicial->bindParam(':idUsuario',$_SESSION['idUsuario'], PDO::PARAM_STR); 
                              $buscarPrescoInicial->execute();
                              $hizoLecturaNL=$buscarPrescoInicial->rowCount(); 

                              if($hizoLecturaNL!=0){
                                @$hizoLecturaL='ok';

                                $incremetoDia=20;
                                $sumaSemana+=$incremetoDia;
                              }else{
                                $hizoLecturaL='no';
                                $incremetoDia+=0;
                              }
                          }

                          echo @$hizoLecturaL;
                              
                          ?>
                            </td>
                            <td><?php 
                            //verificamos si ha realizad las lecturas diarias

                            if($_SESSION['idLecturaM']){
                            $q1 = ("SELECT * FROM registroLectDiaria where  idLectura=:idLectura and idUsuario=:idUsuario");
                              $buscarPrescoInicial=$dbConn->prepare($q1);
                              $buscarPrescoInicial->bindParam(':idLectura',$_SESSION['idLecturaM'], PDO::PARAM_INT); 
                              $buscarPrescoInicial->bindParam(':idUsuario',$_SESSION['idUsuario'], PDO::PARAM_STR); 
                              $buscarPrescoInicial->execute();
                              $hizoLecturaNM=$buscarPrescoInicial->rowCount(); 

                              if($hizoLecturaNM!=0){
                                $hizoLecturaM='ok';
                                $incremetoDia=20;
                                $sumaSemana+=$incremetoDia;
                              }else{
                                $hizoLecturaM='no';
                                $incremetoDia+=0;
                              }
                          }
                          echo @$hizoLecturaM;

                            ?></td>
                          <td><?php 
                            //verificamos si ha realizad las lecturas diarias

                           $q1 = ("SELECT * FROM registroLectDiaria where  idLectura=:idLectura and idUsuario=:idUsuario");
                              $buscarPrescoInicial=$dbConn->prepare($q1);
                              $buscarPrescoInicial->bindParam(':idLectura',$_SESSION['idLecturaX'], PDO::PARAM_INT); 
                              $buscarPrescoInicial->bindParam(':idUsuario',$_SESSION['idUsuario'], PDO::PARAM_STR); 
                              $buscarPrescoInicial->execute();
                              $hizoLecturaNX=$buscarPrescoInicial->rowCount(); 

                              if($hizoLecturaNX!=0){
                                $hizoLecturaX='ok';
                                 $incremetoDia=20;
                                 $sumaSemana+=$incremetoDia;
                              }else{
                                $hizoLecturaX='no';
                                 $incremetoDia+=0;
                              }
                            echo $hizoLecturaX;

                            ?></td>
                          <td><?php 
                            //verificamos si ha realizad las lecturas diarias

                            $q1 = ("SELECT * FROM registroLectDiaria where  idLectura=:idLectura and idUsuario=:idUsuario");
                              $buscarPrescoInicial=$dbConn->prepare($q1);
                              $buscarPrescoInicial->bindParam(':idLectura',$_SESSION['idLecturaJ'], PDO::PARAM_INT); 
                              $buscarPrescoInicial->bindParam(':idUsuario',$_SESSION['idUsuario'], PDO::PARAM_STR); 
                              $buscarPrescoInicial->execute();
                              $hizoLecturaNJ=$buscarPrescoInicial->rowCount(); 

                              if($hizoLecturaNJ!=0){
                                $hizoLecturaJ='ok';
                                 $incremetoDia=20;
                                 $sumaSemana+=$incremetoDia;
                              }else{
                                $hizoLecturaJ='no';
                                 $incremetoDia+=0;
                              }
                              echo $hizoLecturaJ;

                            ?></td>
                            <td><?php 
                            //verificamos si ha realizad las lecturas diarias

                            $q1 = ("SELECT * FROM registroLectDiaria where  idLectura=:idLectura and idUsuario=:idUsuario");
                              $buscarPrescoInicial=$dbConn->prepare($q1);
                              $buscarPrescoInicial->bindParam(':idLectura',$_SESSION['idLecturaV'], PDO::PARAM_INT); 
                              $buscarPrescoInicial->bindParam(':idUsuario',$_SESSION['idUsuario'], PDO::PARAM_STR); 
                              $buscarPrescoInicial->execute();
                              $hizoLecturaNJ=$buscarPrescoInicial->rowCount(); 

                              if($hizoLecturaNJ!=0){
                                $hizoLecturaJ='ok';
                                 $incremetoDia=20;
                                 $sumaSemana+=$incremetoDia;
                              }else{
                                $hizoLecturaJ='no';
                                 $incremetoDia+=0;
                              }
                              echo $hizoLecturaJ;

                            ?></td>


                          <td><?php echo $sumaSemana.'%'; ?></td>
                        </tr>
                              <?php } ?>                    
                                                        
                      </tbody>
                    </table>         
          </div>    


<?php }else{ ?>



          <div class="col-md-12 sombra"  id="customers" style=" min-height:100px; margin-bottom: 30px;">

                    <table class="table table-hover" id="lectDiaria">
                       <caption style="display: none;"><?php echo 'Grado: '.$gradoReporte.'-- Reporte hasta la semana '.$semana.'<br> Reporte a fecha: '.$fecha_actual.' '.$hora_actual; ; ?></caption>
                      <thead>

                        <?php
                        for($n=1; $n<=$semana;$n++){
                          $buscarLecturasDiarias= ("SELECT * FROM atomolector where grado=:grado and semana=:semana and estatus=1");
                            $lecturasSemana=$dbConn->prepare($buscarLecturasDiarias);
                            $lecturasSemana->bindParam(':grado',$gradoReporte, PDO::PARAM_INT);
                            $lecturasSemana->bindParam(':semana',$n);
                            $lecturasSemana->execute();
                            $contadorLecturas=$lecturasSemana->rowCount();


                         ?>
                        <tr>
                          <th scope="col">Alumno</th>
                          <th scope="col">Semana Registro</th>
                          
                          <?php  while(@$lectSemana=$lecturasSemana->fetch(PDO::FETCH_ASSOC)){
                            //mostramos los dias y la lectura Correspondiente
                            switch ($lectSemana['noLecturaDiaria']) {
                              case 1:
                                $diaMostrar='Lunes';
                                $lecturaM=$lectSemana['nombreLectura'];
                                $_SESSION['idLecturaL']=$lectSemana['idLectura'];
                                break;
                              case 2:
                                $diaMostrar='Martes';
                                $lecturaM=$lectSemana['nombreLectura'];
                                $_SESSION['idLecturaM']=$lectSemana['idLectura'];
                                break;
                               case 3:
                                $diaMostrar='Miercoles';
                                $lecturaM=$lectSemana['nombreLectura'];
                                $_SESSION['idLecturaX']=$lectSemana['idLectura'];
                                break;
                              case 4:
                                $diaMostrar='Jueves';
                                $lecturaM=$lectSemana['nombreLectura'];
                                $_SESSION['idLecturaJ']=$lectSemana['idLectura'];
                                break;
                              case 5:
                                $diaMostrar='viernes';
                                $lecturaM=$lectSemana['nombreLectura'];
                                $_SESSION['idLecturaV']=$lectSemana['idLectura'];
                                break;
                              
                              default:
                                # code...
                                break;
                            }

                            ?>
                          <th title="<?php echo $lecturaM; ?>" scope="col"><?php echo $diaMostrar.'<br>'.$lecturaM; ?></th>
                         <?php } ?>
                         <th scope="col">Avance Semanal</th>
                        </tr>
                      </thead>

                      <tbody class="text-left">
                         <?php    
                          $sumaSemana=0;
                          $incremetoDia=0;

                          ?>
                        <tr>
                            
                          <td><?php echo $_SESSION['nombre'].' '.$_SESSION['apellido']; ?></td>
                          <td><a href="reportesDetalles.php?idUsuario=<?php echo $_SESSION['idUsuario']; ?>&semana=<?php echo $n; ?>&grado=<?php echo $gradoReporte; ?>&nombreUsuario=<?php echo $_SESSION['nombre'].' '.$_SESSION['apellido']; ?>" target="_blank"><?php echo  'Semana '.$n.' -- '; ?>Detalle</a></td>
                          <td><?php 
                            //verificamos si ha realizad las lecturas diarias

                            $buscarLunes= ("SELECT * FROM atomolector JOIN micofre on atomolector.idLectura=micofre.idLectura where micofre.idUsuario=:idUsuario and atomolector.idLectura=:idLectura");
                            
                            $palabrasMiCofrel=$dbConn->prepare($buscarLunes);
                            $palabrasMiCofrel->bindParam(':idUsuario',$_SESSION['idUsuario'], PDO::PARAM_INT);
                            $palabrasMiCofrel->bindParam(':idLectura',$_SESSION['idLecturaL'], PDO::PARAM_INT);
                            $palabrasMiCofrel->execute();
                            $hayPalabrasL=$palabrasMiCofrel->rowCount();

                            if($hayPalabrasL>=5){
                              echo 'ok';
                              $incremetoDia=20;
                              $sumaSemana+=$incremetoDia;
                            }else{echo 'No';}?></td>
                            <td><?php 
                            //verificamos si ha realizad las lecturas diarias

                            $buscarMartes= ("SELECT * FROM atomolector JOIN micofre on atomolector.idLectura=micofre.idLectura where micofre.idUsuario=:idUsuario and atomolector.idLectura=:idLectura");
                            
                            $palabrasMiCofreM=$dbConn->prepare($buscarMartes);
                            $palabrasMiCofreM->bindParam(':idUsuario',$_SESSION['idUsuario'], PDO::PARAM_INT);
                            $palabrasMiCofreM->bindParam(':idLectura',$_SESSION['idLecturaM'], PDO::PARAM_INT);
                            $palabrasMiCofreM->execute();
                            $hayPalabrasM=$palabrasMiCofreM->rowCount();

                            if($hayPalabrasM>=5){
                              echo 'ok';
                              $incremetoDia=20;
                              $sumaSemana+=$incremetoDia;
                            }else{echo 'No';}?></td>
                          <td><?php 
                            //verificamos si ha realizad las lecturas diarias

                            $buscarMiercoles= ("SELECT * FROM atomolector JOIN micofre on atomolector.idLectura=micofre.idLectura where micofre.idUsuario=:idUsuario and atomolector.idLectura=:idLectura");
                            
                            $palabrasMiCofreX=$dbConn->prepare($buscarMiercoles);
                            $palabrasMiCofreX->bindParam(':idUsuario',$_SESSION['idUsuario'], PDO::PARAM_INT);
                            $palabrasMiCofreX->bindParam(':idLectura',$_SESSION['idLecturaX'], PDO::PARAM_INT);
                            $palabrasMiCofreX->execute();
                            $hayPalabrasX=$palabrasMiCofreX->rowCount();

                            if($hayPalabrasX>=5){
                              echo 'ok';
                              $incremetoDia=20;
                              $sumaSemana+=$incremetoDia;
                            }else{echo 'No';}?></td>
                          <td><?php 
                            //verificamos si ha realizad las lecturas diarias

                            $buscarJueves= ("SELECT * FROM atomolector JOIN micofre on atomolector.idLectura=micofre.idLectura where micofre.idUsuario=:idUsuario and atomolector.idLectura=:idLectura");
                            
                            $palabrasMiCofreJ=$dbConn->prepare($buscarJueves);
                            $palabrasMiCofreJ->bindParam(':idUsuario',$_SESSION['idUsuario'], PDO::PARAM_INT);
                            $palabrasMiCofreJ->bindParam(':idLectura',$_SESSION['idLecturaJ'], PDO::PARAM_INT);
                            $palabrasMiCofreJ->execute();
                            $hayPalabrasJ=$palabrasMiCofreJ->rowCount();

                            if($hayPalabrasJ>=5){
                              echo 'ok';
                              $incremetoDia=20;
                              $sumaSemana+=$incremetoDia;
                            }else{echo 'No';}?></td>
                            <td><?php 
                            //verificamos si ha realizad las lecturas diarias

                            $buscarViernes= ("SELECT * FROM atomolector JOIN micofre on atomolector.idLectura=micofre.idLectura where micofre.idUsuario=:idUsuario and atomolector.idLectura=:idLectura");
                            
                            $palabrasMiCofreV=$dbConn->prepare($buscarViernes);
                            $palabrasMiCofreV->bindParam(':idUsuario',$_SESSION['idUsuario'], PDO::PARAM_INT);
                            $palabrasMiCofreV->bindParam(':idLectura',$_SESSION['idLecturaV'], PDO::PARAM_INT);
                            $palabrasMiCofreV->execute();
                            $hayPalabrasV=$palabrasMiCofreV->rowCount();

                            if($hayPalabrasV>=5){
                              echo 'ok';
                              $incremetoDia=20;
                              $sumaSemana+=$incremetoDia;
                            }else{echo 'No';}?></td>
                          <td><?php echo $sumaSemana.'%'; ?></td>
                        </tr>
                              <?php } ?>                    
                                                        
                      </tbody>
                    </table>         
          </div>    
<?php } ?>
         
          <div class="col-md-3 sombra text-left" style="height:25px; margin-bottom: 15px; background-color:#1abc9c; color: white; border-radius: 5px;">Lecturas de medición</div>
          
            <button class="btn btn-default botonAgg botonAgg-1" type="button"style="margin-left:510px;background-color: #16a085; color: white; border:white; " onclick = "exportTableToExcel ('lecturasMedicion','Reporte Medición')">EXCEL</button>



<?php 
  //validacion prescolar  meidicion
if($gradoReporte>=13 and $gradoReporte<=15){?>

         
          <div class="col-md-3 sombra text-left" style="height:25px; margin-bottom: 15px; background-color:#1abc9c; color: white; border-radius: 5px;">Lecturas de medición</div>
          
            <button class="btn btn-default botonAgg botonAgg-1" type="button"style="margin-left:510px;background-color: #16a085; color: white; border:white; " onclick = "exportTableToExcel ('lecturasMedicion','Reporte Medición')">EXCEL</button>




         <div class="col-md-12 sombra" style=" min-height:100px;  margin-bottom: 50px; overflow: auto; ">

                    <table class="table table-hover" id="lecturasMedicion">
                       <caption style="display: none;"><?php echo 'Grado: '.$gradoReporte.'-- Reporte hasta la semana no: '.$semana.'<br> Reporte a fecha: '.$fecha_actual.' '.$hora_actual; ; ?></caption>
                        <thead>
                        <tr>
                          <th scope="col">Alumno</th>
                          <th scope="col">Semana</th>
                          <th scope="col">Lectura</th>
                          <th scope="col">Test Inicial</th>
                          <th scope="col">Con Tus Palabras</th>
                         <th scope="col">Total Promedio Actividades</th>
                        </tr>
                      </thead>
                       <?php       
                          $sumaGlobal=0;

                          //buscamos lectura Correspondiente a la semana;
                         $buscarLecturas= ("SELECT * FROM atomolector where grado=:grado and noLecturaDiaria=0;");
                          $buscarLect=$dbConn->prepare($buscarLecturas);
        
                            $buscarLect->bindParam(':grado',$gradoReporte, PDO::PARAM_INT);
                           
                            $buscarLect->execute();

                            while(@$mostLect=$buscarLect->fetch(PDO::FETCH_ASSOC)){
                              @$js+=1;

                              if($js<=$semana){
                                                         
                               $_SESSION['lectura']=$mostLect['nombreLectura'];
                               $_SESSION['idLectura']=$mostLect['idLectura'];
                              
                          //buscamos el primer intento de CNB para lo cual necesitaremos el grado para hacer el filtro

                               

                            ?> 

                       <tr> 
                       <td><strong><?php echo $_SESSION['nombre'].' '.$_SESSION['apellido']; ?></strong></td>  
                        <td><strong><?php echo $js; ?></strong></td>   
                          <td><strong><?php echo $_SESSION['lectura']; ?></strong></td>
                          <td>
                           <?php 

                      
                            if($gradoReporte>=13 and $gradoReporte<=15){


                          $buscarInCnb= ("SELECT * FROM registropruebacomprension JOIN cuestionario on registropruebacomprension.idLectura=cuestionario.idLectura where registropruebacomprension.idUsuario=:idUsuario and registropruebacomprension.intento=1 and cuestionario.fundamento='cnb' and registropruebacomprension.idLectura=:idLectura and registropruebacomprension.nivelObtenido is null ");
                               $buscarCnb=$dbConn->prepare($buscarInCnb);
                                  $buscarCnb->bindParam(':idLectura',$_SESSION['idLectura'], PDO::PARAM_INT);
                                  $buscarCnb->bindParam(':idUsuario',$_SESSION['idUsuario'], PDO::PARAM_INT);
                                   $buscarCnb->execute(); 
                                   $hayIntentoCnb=$buscarCnb->rowCount();

                                   $link='../atomLector/p1/resultadoCnb.php';

                            }

                             
           
      

                                   if($hayIntentoCnb!=0){

                                    while(@$mostrarCnb=$buscarCnb->fetch(PDO::FETCH_ASSOC)){
                                echo '<a href="'.$link.'?idLectura='.$_SESSION['idLectura'].'&nombre='.$_SESSION['nombre'].'&apellido='.$_SESSION['apellido'].'&intento=1&idUsuario='.$_SESSION['idUsuario'].'&intentoABuscar='.$mostrarCnb['idRegistro'].'" target="_blank">'.$mostrarCnb['totalObtenido'].'</a> | ';
                                @$totalCnb=$mostrarCnb['totalObtenido'];
                                @$sumaGlobal+=$totalCnb;
                              }
                            }else{
                              echo '0';
                              $sumaGlobal+=0;
                            }

                           ?>                     
                        
                          </td>
                         
                          
                           <td>
                           <?php $buscarReflexivo1= ("SELECT * FROM contuspalabras JOIN atomolector ON contuspalabras.idLectura=atomolector.idLectura WHERE atomolector.idLectura=:idLectura AND contuspalabras.idUsuario=:idUsuario");
                            $reflixivoSi=$dbConn->prepare($buscarReflexivo1);
                            $reflixivoSi->bindParam(':idLectura',$_SESSION['idLectura'], PDO::PARAM_INT);
                            $reflixivoSi->bindParam(':idUsuario',$_SESSION['idUsuario'], PDO::PARAM_INT);
                            $reflixivoSi->execute();
                            $reflexivoHay=$reflixivoSi->rowCount(); 
                            if($reflexivoHay>=1){
                              echo 'Ok';
                            }else{
                              echo 'No';
                            }

                            ?>

                          </td>
                            
                             <td>
                               <?php echo round($sumaGlobal/1); ?>

                             </td>
                        </tr> 
        <?php $sumaGlobal=0; } } ?>
                      </tbody>
                    </table>         
          </div>

        <?php }else{ ?>







            

          <div class="col-md-12 sombra" style=" min-height:100px;  margin-bottom: 50px; overflow: auto; ">

                    <table class="table table-hover" id="lecturasMedicion">
                       <caption style="display: none;"><?php echo 'Grado: '.$gradoReporte.'-- Reporte hasta la semana no: '.$semana.'<br> Reporte a fecha: '.$fecha_actual.' '.$hora_actual; ; ?></caption>
                        <thead>
                        <tr>
                          <th scope="col">Alumno</th>
                          <th scope="col">Semana</th>
                          <th scope="col">Lectura</th>
                          <th scope="col">Comprensión CNB (*)</th>
                          <th scope="col">Comprensión PISA</th>
                          <th scope="col">Glosario (*)</th>
                          <th scope="col">Con Tus Palabras</th>
                          <th scope="col">Evaluación Personajes (*)</th>
                          <th scope="col">Total Promedio Actividades</th>
                        </tr>
                      </thead>
                       <?php       
                          $sumaGlobal=0;

                          //buscamos lectura Correspondiente a la semana;
                         $buscarLecturas= ("SELECT * FROM atomolector where grado=:grado and noLecturaDiaria=0;");
                          $buscarLect=$dbConn->prepare($buscarLecturas);
        
                            $buscarLect->bindParam(':grado',$gradoReporte, PDO::PARAM_INT);
                           
                            $buscarLect->execute();

                            while(@$mostLect=$buscarLect->fetch(PDO::FETCH_ASSOC)){
                              @$js+=1;

                              if($js<=$semana){
                                                         
                               $_SESSION['lectura']=$mostLect['nombreLectura'];
                               $_SESSION['idLectura']=$mostLect['idLectura'];
                              
                          //buscamos el primer intento de CNB para lo cual necesitaremos el grado para hacer el filtro

                               

                            ?> 

                       <tr> 
                       <td><strong><?php echo $_SESSION['nombre'].' '.$_SESSION['apellido']; ?></strong></td>  
                        <td><strong><?php echo $js; ?></strong></td>   
                          <td><strong><?php echo $_SESSION['lectura']; ?></strong></td>
                          <td>
                           <?php 

                      
                            if($gradoReporte>=13 and $gradoReporte<=15){


                          $buscarInCnb= ("SELECT * FROM registropruebacomprension JOIN cuestionario on registropruebacomprension.idLectura=cuestionario.idLectura where registropruebacomprension.idUsuario=:idUsuario and registropruebacomprension.intento=1 and cuestionario.fundamento='cnb' and registropruebacomprension.idLectura=:idLectura and registropruebacomprension.nivelObtenido is null ");
                               $buscarCnb=$dbConn->prepare($buscarInCnb);
                                  $buscarCnb->bindParam(':idLectura',$_SESSION['idLectura'], PDO::PARAM_INT);
                                  $buscarCnb->bindParam(':idUsuario',$_SESSION['idUsuario'], PDO::PARAM_INT);
                                   $buscarCnb->execute(); 
                                   $hayIntentoCnb=$buscarCnb->rowCount();

                                   $link='../atomLector/p1/resultadoCnb.php';

                            }

                           if($gradoReporte>=1 and $gradoReporte<=2){


                          $buscarInCnb= ("SELECT * FROM registropruebacomprension JOIN cuestionario on registropruebacomprension.idLectura=cuestionario.idLectura where registropruebacomprension.idUsuario=:idUsuario and registropruebacomprension.intento=1 and cuestionario.fundamento='cnb' and registropruebacomprension.idLectura=:idLectura and registropruebacomprension.nivelObtenido is null ");
                               $buscarCnb=$dbConn->prepare($buscarInCnb);
                                  $buscarCnb->bindParam(':idLectura',$_SESSION['idLectura'], PDO::PARAM_INT);
                                  $buscarCnb->bindParam(':idUsuario',$_SESSION['idUsuario'], PDO::PARAM_INT);
                                   $buscarCnb->execute(); 
                                   $hayIntentoCnb=$buscarCnb->rowCount();

                                   $link='../atomLector/p1/resultadoCnb.php';

                            }

                           


                            
                            if($gradoReporte==3){
                               $buscarInCnb= ("SELECT * FROM registropruebacomprension3p JOIN cuestionario on registropruebacomprension3p.idLectura=cuestionario.idLectura where registropruebacomprension3p.idUsuario=:idUsuario and registropruebacomprension3p.intento=1 and cuestionario.fundamento='cnb' and registropruebacomprension3p.idLectura=:idLectura and registropruebacomprension3p.nivelObtenido is null");
                               $buscarCnb=$dbConn->prepare($buscarInCnb);
                                  $buscarCnb->bindParam(':idLectura',$_SESSION['idLectura'], PDO::PARAM_INT);
                                  $buscarCnb->bindParam(':idUsuario',$_SESSION['idUsuario'], PDO::PARAM_INT);
                                   $buscarCnb->execute(); 
                                   $hayIntentoCnb=$buscarCnb->rowCount();
                                   $link='../atomLector/p1/resultadoCnb3p.php';

                            

                            }  


                            if($gradoReporte==4){
                               $buscarInCnb= ("SELECT * FROM registropruebacomprension4p JOIN cuestionario on registropruebacomprension4p.idLectura=cuestionario.idLectura where registropruebacomprension4p.idUsuario=:idUsuario and registropruebacomprension4p.intento=1 and cuestionario.fundamento='cnb' and registropruebacomprension4p.idLectura=:idLectura and registropruebacomprension4p.nivelObtenido is null");
                               $buscarCnb=$dbConn->prepare($buscarInCnb);
                                  $buscarCnb->bindParam(':idLectura',$_SESSION['idLectura'], PDO::PARAM_INT);
                                  $buscarCnb->bindParam(':idUsuario',$_SESSION['idUsuario'], PDO::PARAM_INT);
                                   $buscarCnb->execute(); 
                                   $hayIntentoCnb=$buscarCnb->rowCount();
                                   $link='../atomLector/p1/resultadoCnb4p.php';

                            

                            }  

                             if($gradoReporte==5){
                               $buscarInCnb= ("SELECT * FROM registropruebacomprension5p JOIN cuestionario on registropruebacomprension5p.idLectura=cuestionario.idLectura where registropruebacomprension5p.idUsuario=:idUsuario and registropruebacomprension5p.intento=1 and cuestionario.fundamento='cnb' and registropruebacomprension5p.idLectura=:idLectura and registropruebacomprension5p.nivelObtenido is null");
                               $buscarCnb=$dbConn->prepare($buscarInCnb);
                                  $buscarCnb->bindParam(':idLectura',$_SESSION['idLectura'], PDO::PARAM_INT);
                                  $buscarCnb->bindParam(':idUsuario',$_SESSION['idUsuario'], PDO::PARAM_INT);
                                   $buscarCnb->execute(); 
                                   $hayIntentoCnb=$buscarCnb->rowCount();
                                    $link='../atomLector/p1/resultadoCnb5p.php';

                            

                            } 

                            if($gradoReporte>=6 and $gradoReporte<=11){
                               $buscarInCnb= ("SELECT * FROM registropruebacomprension6p JOIN cuestionario on registropruebacomprension6p.idLectura=cuestionario.idLectura where registropruebacomprension6p.idUsuario=:idUsuario and registropruebacomprension6p.intento=1 and cuestionario.fundamento='cnb' and registropruebacomprension6p.idLectura=:idLectura and registropruebacomprension6p.nivelObtenido is null");
                               $buscarCnb=$dbConn->prepare($buscarInCnb);
                                  $buscarCnb->bindParam(':idLectura',$_SESSION['idLectura'], PDO::PARAM_INT);
                                  $buscarCnb->bindParam(':idUsuario',$_SESSION['idUsuario'], PDO::PARAM_INT);
                                   $buscarCnb->execute(); 
                                   $hayIntentoCnb=$buscarCnb->rowCount();
                                    $link='../atomLector/p1/resultadoCnb6p.php';                    

                            }      
           
      

                                   if($hayIntentoCnb!=0){

                                    while(@$mostrarCnb=$buscarCnb->fetch(PDO::FETCH_ASSOC)){
                                echo '<a href="'.$link.'?idLectura='.$_SESSION['idLectura'].'&nombre='.$_SESSION['nombre'].'&apellido='.$_SESSION['apellido'].'&intento=1&idUsuario='.$_SESSION['idUsuario'].'&intentoABuscar='.$mostrarCnb['idRegistro'].'" target="_blank">'.$mostrarCnb['totalObtenido'].'</a> | ';
                                @$totalCnb=$mostrarCnb['totalObtenido'];
                                @$sumaGlobal+=$totalCnb;
                              }
                            }else{
                              echo '0';
                              $sumaGlobal+=0;
                            }

                           ?>                     
                        
                          </td>
                          <td>
                           
                           <?php 

                            $buscarPisa= ("SELECT * FROM registropruebacomprension JOIN cuestionario on registropruebacomprension.idLectura=cuestionario.idLectura where registropruebacomprension.idUsuario=:idUsuario and registropruebacomprension.intento=1 and cuestionario.fundamento='pisa' and registropruebacomprension.idLectura=:idLectura and registropruebacomprension.nivelObtenido is not null limit 1");
                               $pisaEncontrado=$dbConn->prepare($buscarPisa);
                                  $pisaEncontrado->bindParam(':idLectura',$_SESSION['idLectura'], PDO::PARAM_INT);
                                  $pisaEncontrado->bindParam(':idUsuario',$_SESSION['idUsuario'], PDO::PARAM_INT);
                                   $pisaEncontrado->execute(); 
                                   $hayIntentoPisa=$pisaEncontrado->rowCount();

                                   $link='../atomLector/p1/resultado.php';

                                   if($hayIntentoPisa!=0){

                                    while(@$mostrarPisaM=$pisaEncontrado->fetch(PDO::FETCH_ASSOC)){
                                echo '<a href="'.$link.'?idLectura='.$_SESSION['idLectura'].'&gradoB='.$gradoReporte.'&nombre='.$_SESSION['nombre'].'&apellido='.$_SESSION['apellido'].'&intento=1&idUsuario='.$_SESSION['idUsuario'].'&intentoABuscar='.$mostrarPisaM['idRegistro'].'" target="_blank">'.$mostrarPisaM['estandarEvaluado'].'</a> | ';

                                @$_SESSION['estandarEvaluado']=$mostrarPisaM['estandarEvaluado'];
                              }
                            }else{
                              echo @$_SESSION['estandarEvaluado'];
                            }


                           ?>
                        
                        
                          </td>
                          <td>
                           <?php 

                           $buscarCantidadPalabras= ("SELECT * FROM palabrasglosario as palabras JOIN glosario as glo on palabras.idGlosario=glo.idglosario WHERE glo.idLectura=:idLectura limit 1");
                               $palabrasEncontradas=$dbConn->prepare($buscarCantidadPalabras);
                               $palabrasEncontradas->bindParam(':idLectura',$_SESSION['idLectura'], PDO::PARAM_INT);
                               $palabrasEncontradas->execute();  
                               $totalPalabras=$palabrasEncontradas->rowCount();
                           //consultar cuantas palabras son a completar
                           
                           //consulta para ver cuantas palabras lleva
                               $buscarRegistroP= ("SELECT * from registroglosario as re JOIN glosario as glo on re.idGlosario=glo.idglosario where   re.idUsuario=:idUsuario and glo.idLectura=:idLectura limit 1");
                               $registroP=$dbConn->prepare($buscarRegistroP);
                               $registroP->bindParam(':idLectura',$_SESSION['idLectura'], PDO::PARAM_INT);
                               $registroP->bindParam(':idUsuario',$_SESSION['idUsuario'], PDO::PARAM_INT);
                               $registroP->execute();  
                               $totalRegistro=$registroP->rowCount();

                              
                              if($totalRegistro>=1){
                                
                                $porcentajeDiv=100/$totalPalabras;
                               $porcentajeRealizado=$porcentajeDiv*$totalRegistro;

                               echo round($porcentajeRealizado).'%';
                               $sumaGlobal+=$porcentajeRealizado;

                              }else{

                                echo '0%';
                                $sumaGlobal+=0;
                              }

                           


                           ?>
                              

                          </td>
                           <td>
                           <?php $buscarReflexivo1= ("SELECT * FROM contuspalabras JOIN atomolector ON contuspalabras.idLectura=atomolector.idLectura WHERE atomolector.idLectura=:idLectura AND contuspalabras.idUsuario=:idUsuario");
                            $reflixivoSi=$dbConn->prepare($buscarReflexivo1);
                            $reflixivoSi->bindParam(':idLectura',$_SESSION['idLectura'], PDO::PARAM_INT);
                            $reflixivoSi->bindParam(':idUsuario',$_SESSION['idUsuario'], PDO::PARAM_INT);
                            $reflixivoSi->execute();
                            $reflexivoHay=$reflixivoSi->rowCount(); 
                            if($reflexivoHay>=1){
                              echo 'Ok';
                            }else{
                              echo 'No';
                            }

                            ?>

                          </td>
                            <td>
                           <?php 

                  $personajes = ("SELECT * FROM registropruebapersonajes where idLectura=:idLectura and idUsuario=:idUsuario");
                  $relizoPersonajes = $dbConn->prepare($personajes);
                   $relizoPersonajes->bindparam(':idLectura', $_SESSION['idLectura']);
                   $relizoPersonajes->bindparam(':idUsuario', $_SESSION['idUsuario']);
                  $relizoPersonajes->execute();
                  $registroReflexivo= $relizoPersonajes->rowCount();

                  if($registroReflexivo>=1){
                    while(@$quizPersonaje=$relizoPersonajes->fetch(PDO::FETCH_ASSOC)){
                      echo $quizPersonaje['totalResultado'];
                      $_SESSION['totalPersonaje']=$quizPersonaje['totalResultado'];
                       $sumaGlobal+=$quizPersonaje['totalResultado'];

                    }
                  }else{
                    echo '0';
                  }


                           ?>

                          </td>
                             <td>
                               <?php echo round($sumaGlobal/3); ?>

                             </td>
                        </tr> 
        <?php $sumaGlobal=0; } } ?>
                      </tbody>
                    </table>         
          </div>
<?php } ?>

          <div class="col-md-4 sombra text-left" style="height:25px; margin-bottom: 15px; background-color: #9b59b6; color: white; border-radius: 5px;">Medición Fluidez Verbal y Velocidad</div>
        
            <button class="btn btn-default botonAgg botonAgg-1" type="button" style="margin-left:510px;background-color: #16a085; color: white; border:white; " onclick = "exportTableToExcel ('lecturasVelocidad','Reporte Medición Velocidad')">EXCEL</button>

          <div class="col-md-12 sombra" style=" min-height:100px;  margin-bottom: 50px; ">

                    <table class="table table-hover" id="lecturasVelocidad">
                      <thead>
                        <tr>
                          <th scope="col">Alumno</th>
                          <th scope="col">Semana</th>
                          <th scope="col">Lectura </th>
                          <th scope="col">Velocidad Lectora(palabras por minuto)</th>
                          <th scope="col">Fluidez Verbal en porcentaje</th>
                         <!-- <th scope="col">Más detalle Graficos</th> Desbloquear con tiempo-->
                        </tr>
                      </thead>
                      <tbody class="text-left">
                        <?php    
                          for($bn=1; $bn<=$semana; $bn++){
                           $qin1= ("SELECT * FROM velocidadlectora where grado=:grado and semana=:semana");
                            $lecturaVelocidad=$dbConn->prepare($qin1);
                            $lecturaVelocidad->bindParam(':grado',$gradoReporte, PDO::PARAM_INT);
                            $lecturaVelocidad->bindParam(':semana',$bn, PDO::PARAM_INT);
                            $lecturaVelocidad->execute();
                            while(@$rowr3=$lecturaVelocidad->fetch(PDO::FETCH_ASSOC)){ 
                              $_SESSION['idVelocidad']=$rowr3['idLectura'];
                              $_SESSION['lectura']=$rowr3['lectura']

                          

                          ?>
                          
                        <tr>     
                          <td><?php echo $_SESSION['nombre'].' '.$_SESSION['apellido']; $_SESSION['nombreUsuario']=$_SESSION['nombre'].' '.$_SESSION['apellido'];?></td>
                          <td><?php echo $bn; ?></td>
                          <td><?php echo $rowr3['nombreLectura']; ?></td>

                          <?php

                            $registroVelocidad= ("SELECT * FROM   atomolectorvelocidad where idUsuario=:idUsuario  and noLectura=:noLectura and intento=1");
                            $registroVelocidad=$dbConn->prepare($registroVelocidad);
                            $registroVelocidad->bindParam(':idUsuario',$_SESSION['idUsuario'], PDO::PARAM_INT);
                            $registroVelocidad->bindParam(':noLectura',$_SESSION['idVelocidad'], PDO::PARAM_INT);

                            $registroVelocidad->execute();
                            $cantidadRegistrosV=$registroVelocidad->rowCount();

                           if($cantidadRegistrosV>=1){
                            while(@$detalleV=$registroVelocidad->fetch(PDO::FETCH_ASSOC)){ 
                             

                            ?>
                            <td><?php echo $detalleV['velocidadLectora']; ?></td>
                            <td><?php similar_text($_SESSION['lectura'], $detalleV['fluidez'],$porcentaje); echo round($porcentaje,0).'%'; ?></td>
                          <?php } }else{ ?>
                            <td>0</td>
                            <td>0</td>
                          <?php } ?>

                          <!--

                          <td> 
                            <?php  

                            //if($cantidadRegistrosV>=1){ 
                              

                              //echo   '<a href="../atomLector/p1/velocidad1p.php?nombreUsuario='.$_SESSION['nombreUsuario'].'&idLectura='.$_SESSION['idVelocidad'].'&intento100=1&idUsuario='.$rowr2['idUsuario'].'&numeroLectura='.$_SESSION['idVelocidad'].'&gradoB='.$gradoReporte.'" target="_blank">Detalle</a>';
                              //}else{ echo 'Detalle'; }
                              ?>
 
                     <!- </td>   -->
                          </tr> 
                       <?php } }?>
                      </tbody>
                    </table>         
          </div>    

         
     
             
      </div>
<!--//CENTRANDO CONTENIDO ROL 1 -->

<!--LATERAL DERECHO CONTENIDO FIJO -->
		<?php include '../static/lat-derecho.php';  $nivelll=1; directoriosNivelesDer($nivelll);?>
 <!-- //LATERAL IZQUIERDO CONTENIDO FIJO -->  

 
    <!-- Librería jQuery requerida por los plugins de JavaScript -->
    <script src="../js/jquery-3.2.1.js"></script>

    <!-- Todos los plugins JavaScript de Bootstrap (también puedes
         incluir archivos JavaScript individuales de los únicos
         plugins que utilices) -->
    <script src="../js/bootstrap.min.js"></script>
<script>

    //funcion para exportar desde excel
    function exportTableToExcel(tableID, filename = ''){
    var downloadLink;
    var dataType = 'application/vnd.ms-excel';
    var tableSelect = document.getElementById(tableID);
    var tableHTML = tableSelect.outerHTML.replace(/ /g, '%20');
    
    // Specify file name
    filename = filename?filename+'.xls':'excel_data.xls';
    
    // Create download link element
    downloadLink = document.createElement("a");
    
    document.body.appendChild(downloadLink);
    
    if(navigator.msSaveOrOpenBlob){
        var blob = new Blob(['\ufeff', tableHTML], {
            type: dataType
        });
        navigator.msSaveOrOpenBlob( blob, filename);
    }else{
        // Create a link to the file
        downloadLink.href = 'data:' + dataType + ', ' + tableHTML;
    
        // Setting the file name
        downloadLink.download = filename;
        
        //triggering the function
        downloadLink.click();
    }
}  


//funcion para exportar en pdf
 function demoFromHTML() {
            var fechaPdf=$('#fechaPdf').text();
            var grado=$('#gradoPdf').text();

            var pdf = new jsPDF('p', 'pt', 'letter');
           
            //source can be HTML-formatted string, or a reference
            //to an actual DOM element from which the text will be scraped.
            source = $('#customers')[0];
            pdf.text(20, 20, 'Reporte LecturasDiarias'+fechaPdf);
             pdf.text(20, 45, 'Grado: '+grado+' Primaria');


            //we support special element handlers. Register them with jQuery-style 
            //ID selector for either ID or node name. ("#iAmID", "div", "span" etc.)
            //There is no support for any other type of selectors 
            //(class, of compound) at this time.
            specialElementHandlers = {
                //element with id of "bypass" - jQuery style selector
                '#bypassme': function(element, renderer) {
                    //true = "handled elsewhere, bypass text extraction"
                    return true
                }
            };
            margins = {
                top: 50,
                bottom: 20,
                left: 20,
                width: 800
            };
            //all coords and widths are in jsPDF instance's declared units
            //'inches' in this case
            pdf.fromHTML(
                    source, //HTML string or DOM elem ref.
                    margins.left, //x coord
                    margins.top, {//y coord
                        'width': margins.width, //max width of content on PDF
                        'elementHandlers': specialElementHandlers
                    },
            function(dispose) {
                //dispose: object with X, Y of the last line add to the PDF 
                //         this allow the insertion of new lines after html
                pdf.save('Reporte Lecturas Diarias.pdf');
            }
            , margins);
        }
 </script> 

  </body>
</html>
