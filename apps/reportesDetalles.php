<?php 
session_start();


if(!isset($_SESSION['idUsuario'])) {
header('Location: ../index.html');
}



require("../conection/conexion.php");

$_GET['idUsuario'];


//variables de niveles
$nivelPrimaria=1;
$nivelBasico=2;
$nivelDiver=3;

$buscarLecturasDiarias= ("SELECT * FROM atomolector where grado=:grado and semana=:semana and estatus=1");
                            $lecturasSemana=$dbConn->prepare($buscarLecturasDiarias);
                            $lecturasSemana->bindParam(':grado',$_GET['grado'], PDO::PARAM_INT);
                            $lecturasSemana->bindParam(':semana',$_GET['semana']);
                            $lecturasSemana->execute();
                            $contadorLecturas=$lecturasSemana->rowCount();


//Buscar todos los cursos de este usuario primaria

$fecha_actual=date("d/m/Y");
 $hora_actual=date('h:i:s');

//funcion encargada de asignar imagen segun primer letra del nombre del curso

 ?>


<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0,maximum-scale=1.0">
    <title><?php echo $_SESSION["nombre"]; ?> | Detalle Diarias</title>
 
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
<?php include '../static/nav.php'; $nivell=1; directorioNivelesNav($nivell);?>
<!-- //NAVEGACION CONTENIDO FIJO -->

<!-- LATERAL IZQUIERDO CONTENIDO FIJO -->
 <?php include '../static/lat-izquierdo.php';  $nivel=1; directoriosNiveles($nivel);?>
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
         <div class="col-md-12" style=" margin-bottom: 50px; margin-top: 50px;">
              <h3 class="text-center">Átomo Reportes - Detalle - <?php echo $_GET['nombreUsuario'] ?></h3>
         </div>
          <div class="col-md-3 sombra text-left" style="height:25px; margin-bottom: 15px;">Lecturas Diarias Semana <?php echo $_GET['semana']; ?></div>
           <button class="btn btn-default botonAgg botonAgg-1" type="button"style="margin-left:510px;background-color: #16a085; color: white; border:white;" onclick = "exportTableToExcel ('Detalle','LecturasDiarias')">EXCEL</button>


  <?php

        if(!empty($_GET['gradoB'])){
          //echo 'no hay grado';
       // echo  $_GET['gradoB'];
        
        ?>

        <div class="col-md-12 sombra" style=" min-height:100px; margin-bottom: 30px; ">

                    <table class="table table-hover" id="Detalle">
                      <caption style="display: none;"><?php echo 'Alumno: '.$_GET['nombreUsuario'].'<br>Grado: '.$_GET['grado'].'<br> Semana: '.$_GET['semana'].'<br> Reporte a fecha: '.$fecha_actual.' '.$hora_actual; ?></caption>
                      <thead>
                        <tr>
                          <th scope="col">Lectura</th>
                          <th scope="col">Día</th>
                          <th scope="col">Fecha </th>
                          <th scope="col">Hora</th>
                          <th scope="col">Estado</th>
                          <th scope="col">Porcentaje Obtenido</th>
                         
                        </tr>
                      </thead>
                      <tbody class="text-left">
                       
                        <tr>     
                         <?php  
                         $suma=0;
                            $incremento=0;

                         while(@$lectSemana=$lecturasSemana->fetch(PDO::FETCH_ASSOC)){

                            
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
                                $_SESSION['idLecturaL']=$lectSemana['idLectura'];
                                break;
                               case 3:
                                $diaMostrar='Miercoles';
                                $lecturaM=$lectSemana['nombreLectura'];
                                $_SESSION['idLecturaL']=$lectSemana['idLectura'];
                                break;
                              case 4:
                                $diaMostrar='Jueves';
                                $lecturaM=$lectSemana['nombreLectura'];
                                $_SESSION['idLecturaL']=$lectSemana['idLectura'];
                                break;
                              case 5:
                                $diaMostrar='Viernes';
                                $lecturaM=$lectSemana['nombreLectura'];
                                $_SESSION['idLecturaL']=$lectSemana['idLectura'];
                                break;
                              
                              default:
                                # code...
                                break;
                            }


                            ?>
                          <td title="<?php echo $lecturaM; ?>" scope="col"><?php echo $lecturaM; ?></td>
                          <td title="<?php echo $lecturaM; ?>" scope="col"><?php echo $diaMostrar; ?></td>
                          <td title="<?php echo $lecturaM; ?>" scope="col"><?php

                           $incremetoDia=0;
                          $sumaSemana=0;


                            $q1 = ("SELECT * FROM registroLectDiaria where  idLectura=:idLectura and idUsuario=:idUsuario");
                              $buscarPrescoInicial=$dbConn->prepare($q1);
                              $buscarPrescoInicial->bindParam(':idLectura',$_SESSION['idLecturaL'], PDO::PARAM_INT); 
                              $buscarPrescoInicial->bindParam(':idUsuario',$_GET['idUsuario'], PDO::PARAM_STR); 
                              $buscarPrescoInicial->execute();
                              $hizoLecturaNL=$buscarPrescoInicial->rowCount(); 

                            if($hizoLecturaNL==0){
                              echo '--';
                            }else{
                              while(@$rowNew11=$buscarPrescoInicial->fetch(PDO::FETCH_ASSOC)){
                           
                                  echo $rowNew11['fecha'].'<br>';
                                  }

                                  
                              }
                            
                           
                           ?></td>
                          <td title="<?php echo $lecturaM; ?>" scope="col"><?php 
                             $q1 = ("SELECT * FROM registroLectDiaria where  idLectura=:idLectura and idUsuario=:idUsuario");
                            
                            $buscarPrescoInicial=$dbConn->prepare($q1);
                              $buscarPrescoInicial->bindParam(':idLectura',$_SESSION['idLecturaL'], PDO::PARAM_INT); 
                              $buscarPrescoInicial->bindParam(':idUsuario',$_GET['idUsuario'], PDO::PARAM_STR); 
                              $buscarPrescoInicial->execute();
                              $hizoLecturaNL=$buscarPrescoInicial->rowCount(); 

                            if($hizoLecturaNL==0){
                              echo '--';
                            }else{
                              while(@$rowNew11=$buscarPrescoInicial->fetch(PDO::FETCH_ASSOC)){
                           
                                  echo $rowNew11['hora'].'<br>';
                                  }

                                  
                              }
                            
                       
                           
                           ?></td>
                          <td title="<?php echo $lecturaM; ?>" scope="col"><?php 
                               $incremetoDia=0;
                          $sumaSemana=0;

                          if($_SESSION['idLecturaL']){
                            $q1 = ("SELECT * FROM registroLectDiaria where  idLectura=:idLectura and idUsuario=:idUsuario");
                              $buscarPrescoInicial=$dbConn->prepare($q1);
                              $buscarPrescoInicial->bindParam(':idLectura',$_SESSION['idLecturaL'], PDO::PARAM_INT); 
                              $buscarPrescoInicial->bindParam(':idUsuario',$_GET['idUsuario'], PDO::PARAM_STR); 
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
                           ?></td>
                          

                          <td title="" scope="col"><?php echo $incremetoDia.'%'; $suma+=$incremetoDia;?></td>
                         </tr>

                         <?php    }         ?>

                        <tr>     
                          <td colspan="5">Total</td>
                          
                          <td><?php if($suma==99){$suma+=1;} echo $suma.'%'; ?></td>
                        </tr>

                       
                                  
                      </tbody>
                    </table>         
          </div> 

        <?php  } else{ ?>

          <div class="col-md-12 sombra" style=" min-height:100px; margin-bottom: 30px; ">

                    <table class="table table-hover" id="Detalle">
                      <caption style="display: none;"><?php echo 'Alumno: '.$_GET['nombreUsuario'].'<br>Grado: '.$_GET['grado'].'<br> Semana: '.$_GET['semana'].'<br> Reporte a fecha: '.$fecha_actual.' '.$hora_actual; ?></caption>
                      <thead>
                        <tr>
                          <th scope="col">Lectura</th>
                          <th scope="col">Día</th>
                          <th scope="col">Fecha </th>
                          <th scope="col">Hora</th>
                          <th scope="col">Estado</th>
                          <th scope="col">Porcentaje Obtenido</th>
                         
                        </tr>
                      </thead>
                      <tbody class="text-left">
                       
                        <tr>     
                         <?php  
                         $suma=0;
                            $incremento=0;

                         while(@$lectSemana=$lecturasSemana->fetch(PDO::FETCH_ASSOC)){

                            
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
                                $_SESSION['idLecturaL']=$lectSemana['idLectura'];
                                break;
                               case 3:
                                $diaMostrar='Miercoles';
                                $lecturaM=$lectSemana['nombreLectura'];
                                $_SESSION['idLecturaL']=$lectSemana['idLectura'];
                                break;
                              case 4:
                                $diaMostrar='Jueves';
                                $lecturaM=$lectSemana['nombreLectura'];
                                $_SESSION['idLecturaL']=$lectSemana['idLectura'];
                                break;
                              case 5:
                                $diaMostrar='Viernes';
                                $lecturaM=$lectSemana['nombreLectura'];
                                $_SESSION['idLecturaL']=$lectSemana['idLectura'];
                                break;
                              
                              default:
                                # code...
                                break;
                            }


                            ?>
                          <td title="<?php echo $lecturaM; ?>" scope="col"><?php echo $lecturaM; ?></td>
                          <td title="<?php echo $lecturaM; ?>" scope="col"><?php echo $diaMostrar; ?></td>
                          <td title="<?php echo $lecturaM; ?>" scope="col"><?php 
                             $buscarLunes= ("SELECT * FROM micofre  where idUsuario=:idUsuario and idLectura=:idLectura limit 1");
                            
                            $palabrasMiCofrel=$dbConn->prepare($buscarLunes);
                            $palabrasMiCofrel->bindParam(':idUsuario',$_GET['idUsuario'], PDO::PARAM_INT);
                            $palabrasMiCofrel->bindParam(':idLectura',$_SESSION['idLecturaL'], PDO::PARAM_INT);
                            $palabrasMiCofrel->execute();
                            $hayPalabrasL=$palabrasMiCofrel->rowCount();

                            if($hayPalabrasL==0){
                              echo '--';
                            }else{
                              while(@$rowNew11=$palabrasMiCofrel->fetch(PDO::FETCH_ASSOC)){
                                
                                
                                  echo $rowNew11['fecha'].'<br>';
                                  

                                 
                              }
                            }
                           
                           ?></td>
                          <td title="<?php echo $lecturaM; ?>" scope="col"><?php 
                             $buscarLunes= ("SELECT * FROM micofre  where idUsuario=:idUsuario and idLectura=:idLectura limit 1");
                            
                            $palabrasMiCofrel=$dbConn->prepare($buscarLunes);
                            $palabrasMiCofrel->bindParam(':idUsuario',$_GET['idUsuario'], PDO::PARAM_INT);
                            $palabrasMiCofrel->bindParam(':idLectura',$_SESSION['idLecturaL'], PDO::PARAM_INT);
                            $palabrasMiCofrel->execute();
                            $hayPalabrasL=$palabrasMiCofrel->rowCount();

                            if($hayPalabrasL==0){
                              echo '--';
                            }else{
                              while(@$rowNew11=$palabrasMiCofrel->fetch(PDO::FETCH_ASSOC)){

                                
                                 
                                  echo $rowNew11['hora'].'<br>';
                                  
                                  

                              }
                            }
                           
                           ?></td>
                          <td title="<?php echo $lecturaM; ?>" scope="col"><?php 
                             $buscarLunes= ("SELECT * FROM micofre  where idUsuario=:idUsuario and idLectura=:idLectura");
                            
                            $palabrasMiCofrel=$dbConn->prepare($buscarLunes);
                            $palabrasMiCofrel->bindParam(':idUsuario',$_GET['idUsuario'], PDO::PARAM_INT);
                            $palabrasMiCofrel->bindParam(':idLectura',$_SESSION['idLecturaL'], PDO::PARAM_INT);
                            $palabrasMiCofrel->execute();
                            $hayPalabrasL=$palabrasMiCofrel->rowCount();

                            if($hayPalabrasL==0){
                              echo 'No';
                              $incremento=0;
                            }else{                        
                                  echo 'Ok';
                                  $incremento=20;
                                                             
                              
                            }
                           
                           ?></td>
                          

                          <td title="" scope="col"><?php echo $incremento.'%'; $suma+=$incremento;?></td>
                         </tr>

                         <?php    }         ?>

                        <tr>     
                          <td colspan="5">Total</td>
                          
                          <td><?php if($suma==99){$suma+=1;} echo $suma.'%'; ?></td>
                        </tr>

                       
                                  
                      </tbody>
                    </table>         
          </div> 

<?php } //fin corchete if validacion presco ?>   

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

     
             
      </div>
<!--//CENTRANDO CONTENIDO ROL 1 -->

<!--LATERAL DERECHO CONTENIDO FIJO -->
		<?php include '../static/lat-derecho.php'; $nivelll=1; directoriosNivelesDer($nivelll);?>
 <!-- //LATERAL IZQUIERDO CONTENIDO FIJO -->  

 
    <!-- Librería jQuery requerida por los plugins de JavaScript -->
    <script src="../js/jquery-3.2.1.js"></script>

    <!-- Todos los plugins JavaScript de Bootstrap (también puedes
         incluir archivos JavaScript individuales de los únicos
         plugins que utilices) -->
    <script src="../js/bootstrap.min.js"></script>
    <script type="text/javascript">
     
    </script>
  </body>
</html>
