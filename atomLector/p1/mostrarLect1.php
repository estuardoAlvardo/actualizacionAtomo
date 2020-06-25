<?php
session_start();
require("../../conection/conexion.php");

  $pisa='pisa';
  $cnb='cnb';


      $q1 = ("SELECT * FROM atomolector where idLectura=:idLectura");
      $mostrarLectura=$dbConn->prepare($q1);
      $mostrarLectura->bindParam(':idLectura',$_GET['idLectura'], PDO::PARAM_INT); 
      $mostrarLectura->execute();


      $_SESSION['gradoEnviar']=$_GET['idLectura'];


 ?>


<!doctype html>
<!--[if lt IE 7 ]> <html lang="en" class="ie6"> <![endif]-->
<!--[if IE 7 ]>    <html lang="en" class="ie7"> <![endif]-->
<!--[if IE 8 ]>    <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9 ]>    <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="es"> <!--<![endif]-->
<head>
 <title><?php echo $_SESSION["nombre"]; ?> | Lecturas Diarias</title>
<meta name="viewport" content="width = 1050, user-scalable = no" />

 <script type="text/javascript" src="../extras/jquery.min.1.7.js"></script>
<script type="text/javascript" src="../extras/modernizr.2.5.3.min.js"></script>
<script type="text/javascript" src="../turn/lib/hash.js"></script>


   <!-- CSS de Bootstrap -->
<link href="../../css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="../../css/navLateralesModPedagogico.css" rel="stylesheet" media="screen">
    <link rel="icon" type="image/png" href="https://atomolector.com/img/icons/icon2.ico"/>

    <link href="../../css/centroPagina.css" rel="stylesheet" media="screen">
    <link href="../css/rol5FuncCursos.css" rel="stylesheet" media="screen">
    <link href="https://fonts.googleapis.com/css?family=Ubuntu" rel="stylesheet">

 <link href="https://fonts.googleapis.com/css?family=Indie+Flower|Ubuntu" rel="stylesheet"><!-- habilitar font famili font-family: 'Indie Flower', cursive;-->

    <link href="https://fonts.googleapis.com/css?family=Indie+Flower|Nunito+Sans|Ubuntu" rel="stylesheet">
    
    <script src="../../js/artyom/artyom.min.js"></script>
  <script src="../../js/artyom/artyom.window.js"></script>
  <script src="../../js/artyom/artyomCommands.js"></script>   

</head>
<body>

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
  .masCentrado{
    margin-left: -15%;
    margin-top: 34%;

    margin-bottom:200px;
  }

  .cajaDescripcion{
                     box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24);
                     transition: all 0.3s cubic-bezier(.25,.8,.25,1);
                    }

/*estilos para liston titulo*/

  .cajaDescripcion{
                     box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24);
                     transition: all 0.3s cubic-bezier(.25,.8,.25,1);
                    }

/*estilos para liston titulo*/

.container1 {
  width: 80%;
  max-width: 1000px;
  height: 80px;
  margin: 40px auto; 
  position: relative;
}

.one > div {
  height: 50px;

}

.main {
  background: #e67e22; 
  position: relative;
  display: block;
  width: 95%;
  left: 50%;
  top: 0;
  padding: 5px;
  margin-left: -47%;
  z-index: 10;
}

.main > div {
  border: 1px dashed #fff;
  border-color: rgba(255, 255, 255, 0.5);
  height: 40px;
}

.bk {
 background:#e67e22;
 position: absolute;
 width: 8%;
 top: 12px;
}

.bk.l {
 left: 0;
}

.bk.r {
 right: 0;
}

.skew {
  position: absolute;
  background: #e15f41;
  width: 3%;
  top: 6px;
  z-index: 5;
}

.skew.l {
  left: 5%;
  transform: skew(00deg,20deg);
}

.skew.r {
  right: 5%;
  transform: skew(00deg,-20deg);
}

.bk.l > div {
  left: -30px;
}

.bk.r > div {
  right: -30px;
}

.arrow {
  height: 25px !important;
  position: absolute;
  z-index: 2;
  width: 0; 
  height: 0; 
}

.arrow.top {
  top: 0px;
  border-top: 0px solid transparent;
  border-bottom: 25px solid transparent;  
  border-right: 30px solid #e67e22; 
}

.arrow.bottom {
  top: 25px;
  border-top: 25px solid transparent;
  border-bottom:0px solid transparent;  
  border-right: 30px solid #e67e22; 
}

.r .bottom {
  border-top: 25px solid transparent;
  border-bottom: 0px solid transparent;   
  border-left: 30px solid #e67e22; 
  border-right: none;
}

.r .top {
  border-bottom: 25px solid transparent;
  border-top: 0px solid transparent;  
  border-left: 30px solid #e67e22; 
  border-right: none;
}

@media all and (max-width: 1020px) {
  .skew.l {
    left: 5%;
    transform: skew(00deg,25deg);
  }

  .skew.r {
    right: 5%;
    transform: skew(00deg,-25deg);
  }
}

@media all and (max-width: 680px) {
  .skew.l {
    left: 5%;
    transform: skew(00deg,30deg);
  }

  .skew.r {
    right: 5%;
    transform: skew(00deg,-30deg);
  }
}

@media all and (max-width: 460px) {
  .skew.l {
    left: 5%;
    transform: skew(00deg,40deg);
  }
  .skew.r {
    right: 5%;
    transform: skew(00deg,-40deg);
  }
}



/*Estilos para chips */



.md-chip {

 
  border-radius: 42px;
  padding: 0;
  height: 42px;
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
  width: 42px;
  height: 42px;
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
  margin-left: 21px;
  height: 42px;
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

/* For the sake of this demo */


</style>

  <!--NAVEGACION CONTENIDO FIJO -->
  <?php include '../../static/nav.php'; $nivell=2; directorioNivelesNav($nivell);?>
<!-- //NAVEGACION CONTENIDO FIJO -->


           <div class="col-md-12" style="margin-top: 10px;">
          <?php while(@$row1=$mostrarLectura->fetch(PDO::FETCH_ASSOC)){  
           
           ?>
    
<div class="container1 one">
                <div class="bk l">
                  <div class="arrow top" ></div> 
                  <div class="arrow bottom"></div>
                </div>
                <div class="skew l"></div>
                <div class="main">
                  <div style="text-align:center; color: white;"><h3 style="margin-top:6px">Lectura: <?php echo $row1['nombreLectura']; ?></h3></div>   
                </div>
                <div class="skew r"></div>                
                <div class="bk r">
                  <div class="arrow top"></div> 
                  <div class="arrow bottom" style="margin-left: 80px;"></div>
                </div>
              </div> 
              <hr>

<h4 class="cajaDescripcion" style=" text-align: center; border-radius: 5px; width: 150px; background-color:#ffffff; margin-left: 50%;">Actividades</h4>
  <div style="margin-top: 30px; margin-left: 43%;">
 <a href="lecturaDiariaJuego.php?idLectura=<?php echo $_SESSION['gradoEnviar']; ?>&gradoB=<?php echo $_GET['gradoB']; ?>" class="btn btn-default botonAgg-1" style="background-color: #e67e22; border:1px solid #e67e22; color:white; ">Juego</a>

 <?php if($_GET['gradoB']>=13 and $_GET['gradoB']<=15){
  $_SESSION['audio']=$row1['audio'];
  ?>
  <h4>Audio</h4>
  <p id="audioText" style="display: none;"><?php echo $_SESSION['audio']; ?></p>
<audio controls  id="audio" style="border-radius: 25px;" class="cajaDescripcion">
                  <source src="<?php echo $_SESSION['uri'].$row1['audio']; ?>" />
                </audio> 


<?php } ?>
  

 <?php if($_GET['gradoB']>=1 and $_GET['gradoB']<=4){ ?> 
  <a href="miCofre.php?idLectura=<?php echo $_GET['idLectura']; ?>&gradoB=<?php echo $_GET['gradoB']; ?>" class="btn btn-default botonAgg-1" style="background-color: #3498db; border:1px solid #3498db; color:white;">Mi cofre</a>
  <a href="lmNivel1CrearTexto.php?idLectura=<?php echo $_GET['idLectura'];?>&gradoB=<?php echo $_GET['gradoB'];  ?>" class="btn btn-default botonAgg-1" style="background-color: #27ae60;  border:1px solid  #27ae60; color:white;">Escritura Madura n1</a>

 
<?php } if($_GET['gradoB']>=5 and $_GET['gradoB']<=8){ ?>
<a href="miCofre.php?idLectura=<?php echo $_GET['idLectura']; ?>&gradoB=<?php echo $_GET['gradoB']; ?>" class="btn btn-default botonAgg-1" style="background-color: #3498db; border:1px solid #3498db; color:white;">Mi cofre</a>
  
  <a href="lmNivel2CrearTexto.php?idLectura=<?php echo $_GET['idLectura'];?>&gradoB=<?php echo $_GET['gradoB'];?>" class="btn btn-default botonAgg-1" style="background-color: #27ae60;  border:1px solid  #27ae60; color:white;">Escritura Madura n2</a>
 
<?php } if($_GET['gradoB']>=9 and $_GET['gradoB']<=12){?>
<a href="miCofre.php?idLectura=<?php echo $_GET['idLectura']; ?>&gradoB=<?php echo $_GET['gradoB']; ?>" class="btn btn-default botonAgg-1" style="background-color: #3498db; border:1px solid #3498db; color:white;">Mi cofre</a>

  
  <a href="lmNivel3CrearTexto.php?idLectura=<?php echo $_GET['idLectura']; ?>&gradoB=<?php echo $_GET['gradoB']; ?>" class="btn btn-default botonAgg-1" style="background-color: #27ae60;  border:1px solid  #27ae60; color:white;">Escritura Madura n3</a>

<?php } ?>
</div><br><br>

               <a href="<?php echo '../lecturasDiarias.php?gradoB='.$_GET['gradoB']; ?>" class="btn btn-default botonAgg-1" style=" margin-left:48%; background-color: #30336b; border:1px solid #30336b; color:white; ">volver a las lecturas diarias</a><br><br>

        <div class="md-chip blue" style="margin-left: 50px; ">
          <div class="md-chip-img">
            <img src="../../img/noti.png">
          </div>
          <span style="color: white;"><h4 style="padding-top: 5px; padding-right: 10px; padding-left:60px;">Instrucciones: Puedes cambiar de página útilizando las teclas de izquierda y derecha, si quieres hacer zoom en la lectura debes de dar clic en la parte del texto a observar.</h4></span>
        </div><hr>
                


  <div id="canvas" style="margin-bottom: 200px;">

<div class="zoom-icon zoom-icon-in"></div>

<div class="magazine-viewport " >
  <div class="container" style="">
    <div class="magazine" style="">
      <!-- Next button -->
      <div ignore="1" class="next-button" style="height: 600px;"></div>
      <!-- Previous button -->
      <div ignore="1" class="previous-button" style="height: 600px;"></div>
    </div>
  </div>
</div>
</div>


<!--- datos para enviar de prescolar-->
<?php $fecha_actual=date("d/m/Y");
$hora_actual=date('h:i:s'); ?>

<form style="display:none;" id="formularioDiariasPresco" method="post" action="controllador/lecturasDiariasPresco.php">
  <input type="text" name="fecha" value="<?php echo $fecha_actual; ?>">
  <input type="text" name="hora" value="<?php echo $hora_actual; ?>">
  <input type="text" name="idLectura" value="<?php echo $_GET['idLectura']; ?>">
  <input type="text" name="grado" value="<?php echo $_GET['gradoB']; ?>">
  <input type="submit" name="" value="enviar datos lecturas presco">
</form>


<script>
var aud = document.getElementById("audio");
var formulario=$('#formularioDiariasPresco');
aud.onended = function() {
 formulario.submit();
};
</script>


<?php 

$ficheros=$row1['cantidadFicheros']+2;//se añade dos porque la portada y contraportada no funcionana como el turn anterior

//direccion de ficheros

$contenido=$_SESSION['uri'].$row1['rutaLectura'];

//direccion pastas
$portada=$_SESSION['uri'].$row1['rutaPasta']; 
$contraportada=$_SESSION['uri'].$row1['rutaPasta'];

 ?>

<script type="text/javascript">
  var ficheros='<?php echo $ficheros; ?>';
  ficheros+2;
  var portada='<?php echo $portada; ?>';
  var contraportada='<?php echo $contraportada; ?>';
  var contenido='<?php echo $contenido ?>';

//validacion de datos de php
 //alert('ficheros----  '+ficheros);
  //alert('portada----  '+portada);
 //alert('contenido----  '+contenido);
  //alert('contraportada----  '+contraportada);




function loadApp() {
    $('#canvas').fadeIn(1000);

  var flipbook = $('.magazine');

  // Check if the CSS was already loaded
  
  if (flipbook.width()==0 || flipbook.height()==0) {
    setTimeout(loadApp, 10);
    return;
  }
  
  // Create the flipbook

  flipbook.turn({
      
      // Magazine width

      width: 900,

      // Magazine height

      height: 600,

      // Duration in millisecond

      duration: 1000,

      // Hardware acceleration

      acceleration: !isChrome(),

      // Enables gradients

      gradients: true,
      
      // Auto center this flipbook

      autoCenter: true,

      // Elevation from the edge of the flipbook when turning a page

      elevation: 50,

      // The number of pages

      pages: ficheros,



      // Events

      when: {
        turning: function(event, page, view) {
          
          var book = $(this),
          currentPage = book.turn('page'),
          pages = book.turn('pages');
      
          // Update the current URI

          Hash.go('page/' + page).update();

          // Show and hide navigation buttons

          disableControls(page);
          

          $('.thumbnails .page-'+currentPage).
            parent().
            removeClass('current');

          $('.thumbnails .page-'+page).
            parent().
            addClass('current');



        },

        turned: function(event, page, view) {

          disableControls(page);

          $(this).turn('center');

          if (page==1) { 
            $(this).turn('peel', 'br');
          }

        },

        missing: function (event, pages) {

          // Add pages that aren't in the magazine

          for (var i = 0; i < pages.length; i++)
            addPage(pages[i], $(this),pages.length);

        }
      }

  });

  // Zoom.js

  $('.magazine-viewport').zoom({
    flipbook: $('.magazine'),

    max: function() { 
      
      return largeMagazineWidth()/$('.magazine').width();

    }, 

    when: {

      swipeLeft: function() {

        $(this).zoom('flipbook').turn('next');

      },

      swipeRight: function() {
        
        $(this).zoom('flipbook').turn('previous');

      },

      resize: function(event, scale, page, pageElement) {

        if (scale==1)
          loadSmallPage(page, pageElement);
        else
          loadLargePage(page, pageElement);

      },

      zoomIn: function () {

        $('.thumbnails').hide();
        $('.made').hide();
        $('.magazine').removeClass('animated').addClass('zoom-in');
        $('.zoom-icon').removeClass('zoom-icon-in').addClass('zoom-icon-out');
        
        if (!window.escTip && !$.isTouch) {
          escTip = true;

          $('<div />', {'class': 'exit-message'}).
            html('<div>Preciona ESC para Salir</div>').
              appendTo($('body')).
              delay(2000).
              animate({opacity:0}, 500, function() {
                $(this).remove();
              });
        }
      },

      zoomOut: function () {

        $('.exit-message').hide();
        $('.thumbnails').fadeIn();
        $('.made').fadeIn();
        $('.zoom-icon').removeClass('zoom-icon-out').addClass('zoom-icon-in');

        setTimeout(function(){
          $('.magazine').addClass('animated').removeClass('zoom-in');
          resizeViewport();
        }, 0);

      }
    }
  });

  // Zoom event

  if ($.isTouch)
    $('.magazine-viewport').bind('zoom.doubleTap', zoomTo);
  else
    $('.magazine-viewport').bind('zoom.tap', zoomTo);


  // Using arrow keys to turn the page

  $(document).keydown(function(e){

    var previous = 37, next = 39, esc = 27;

    switch (e.keyCode) {
      case previous:

        // left arrow
        $('.magazine').turn('previous');
        e.preventDefault();

      break;
      case next:

        //right arrow
        $('.magazine').turn('next');
        e.preventDefault();

      break;
      case esc:
        
        $('.magazine-viewport').zoom('zoomOut');  
        e.preventDefault();

      break;
    }
  });

  // URIs - Format #/page/1 

  Hash.on('^page\/([0-9]*)$', {
    yep: function(path, parts) {
      var page = parts[1];

      if (page!==undefined) {
        if ($('.magazine').turn('is'))
          $('.magazine').turn('page', page);
      }

    },
    nop: function(path) {

      if ($('.magazine').turn('is'))
        $('.magazine').turn('page', 1);
    }
  });


  $(window).resize(function() {
    resizeViewport();
  }).bind('orientationchange', function() {
    resizeViewport();
  });

  // Events for thumbnails

  $('.thumbnails').click(function(event) {
    
    var page;

    if (event.target && (page=/page-([0-9]+)/.exec($(event.target).attr('class'))) ) {
    
      $('.magazine').turn('page', page[1]);
    }
  });

  $('.thumbnails li').
    bind($.mouseEvents.over, function() {
      
      $(this).addClass('thumb-hover');

    }).bind($.mouseEvents.out, function() {
      
      $(this).removeClass('thumb-hover');

    });

  if ($.isTouch) {
  
    $('.thumbnails').
      addClass('thumbanils-touch').
      bind($.mouseEvents.move, function(event) {
        event.preventDefault();
      });

  } else {

    $('.thumbnails ul').mouseover(function() {

      $('.thumbnails').addClass('thumbnails-hover');

    }).mousedown(function() {

      return false;

    }).mouseout(function() {

      $('.thumbnails').removeClass('thumbnails-hover');

    });

  }


  // Regions

  if ($.isTouch) {
    $('.magazine').bind('touchstart', regionClick);
  } else {
    $('.magazine').click(regionClick);
  }

  // Events for the next button

  $('.next-button').bind($.mouseEvents.over, function() {
    
    $(this).addClass('next-button-hover');

  }).bind($.mouseEvents.out, function() {
    
    $(this).removeClass('next-button-hover');

  }).bind($.mouseEvents.down, function() {
    
    $(this).addClass('next-button-down');

  }).bind($.mouseEvents.up, function() {
    
    $(this).removeClass('next-button-down');

  }).click(function() {
    
    $('.magazine').turn('next');

  });

  // Events for the next button
  
  $('.previous-button').bind($.mouseEvents.over, function() {
    
    $(this).addClass('previous-button-hover');

  }).bind($.mouseEvents.out, function() {
    
    $(this).removeClass('previous-button-hover');

  }).bind($.mouseEvents.down, function() {
    
    $(this).addClass('previous-button-down');

  }).bind($.mouseEvents.up, function() {
    
    $(this).removeClass('previous-button-down');

  }).click(function() {
    
    $('.magazine').turn('previous');

  });


  resizeViewport();

  $('.magazine').addClass('animated');

}

// Zoom icon

 $('.zoom-icon').bind('mouseover', function() { 
  
  if ($(this).hasClass('zoom-icon-in'))
    $(this).addClass('zoom-icon-in-hover');

  if ($(this).hasClass('zoom-icon-out'))
    $(this).addClass('zoom-icon-out-hover');
 
 }).bind('mouseout', function() { 
  
   if ($(this).hasClass('zoom-icon-in'))
    $(this).removeClass('zoom-icon-in-hover');
  
  if ($(this).hasClass('zoom-icon-out'))
    $(this).removeClass('zoom-icon-out-hover');

 }).bind('click', function() {

  if ($(this).hasClass('zoom-icon-in'))
    $('.magazine-viewport').zoom('zoomIn');
  else if ($(this).hasClass('zoom-icon-out')) 
    $('.magazine-viewport').zoom('zoomOut');

 });

 $('#canvas').hide();

// Load the HTML4 version if there's not CSS transform

yepnope({
  test : Modernizr.csstransforms,
  yep: ['../turn/lib/turn.js'],
  nope: ['../turn/lib/turn.html4.min.js'],
  both: ['../turn/lib/zoom.min.js', '../turn/css/magazine.css'],
  complete: loadApp
});


// borramos magazin y agregamos aqui 

/*
 * Magazine sample
*/

function addPage(page, book,pages1) {

  var id, pages = book.turn('pages');
  var cantidadPaginas=ficheros;

  // Create a new element for this page
  var element = $('<div />', {});

  // Add the page to the flipbook
  if (book.turn('addPage', element, page)) {

    // Add the initial HTML
    // It will contain a loader indicator and a gradient
    element.html('<div class="gradient"></div><div class="loader"></div>');

    // Load the page
    loadPage(page, element,cantidadPaginas);
  }

}

function loadPage(page, pageElement,cantidadPaginas) {

  // Create an image element

  var img = $('<img />');


  img.mousedown(function(e) {
    e.preventDefault();
  });

  img.load(function() {
    
    // Set the size
    $(this).css({width: '100%', height: '100%'});

    // Add the image to the page after loaded

    $(this).appendTo(pageElement);

    // Eliminar el indicador del cargador
    
    pageElement.find('.loader').remove();
  });

// Carga la página
//alert(cantidadPaginas);
  
  if(page==1){
     img.attr('src', portada +  1 + '.jpg');
  
  }else if(page==cantidadPaginas){
    img.attr('src', contraportada +  2 + '.jpg');
  }else{
    var page=page-1;

  img.attr('src', contenido +  page + '.jpg');
  
  }




  loadRegions(page, pageElement);

}

// Ampliar reducir

function zoomTo(event) {

    setTimeout(function() {
      if ($('.magazine-viewport').data().regionClicked) {
        $('.magazine-viewport').data().regionClicked = false;
      } else {
        if ($('.magazine-viewport').zoom('value')==1) {
          $('.magazine-viewport').zoom('zoomIn', event);
        } else {
          $('.magazine-viewport').zoom('zoomOut');
        }
      }
    }, 1);

}



// Regiones de carga

function loadRegions(page, element) {

  $.getJSON('pages/'+page+'-regions.json').
    done(function(data) {

      $.each(data, function(key, region) {
        addRegion(region, element);
      });
    });
}

// Añadir región

function addRegion(region, pageElement) {
  
  var reg = $('<div />', {'class': 'region  ' + region['class']}),
    options = $('.magazine').turn('options'),
    pageWidth = options.width/2,
    pageHeight = options.height;

  reg.css({
    top: Math.round(region.y/pageHeight*100)+'%',
    left: Math.round(region.x/pageWidth*100)+'%',
    width: Math.round(region.width/pageWidth*100)+'%',
    height: Math.round(region.height/pageHeight*100)+'%'
  }).attr('region-data', $.param(region.data||''));


  reg.appendTo(pageElement);
}

// Procesar clic en una región

function regionClick(event) {

  var region = $(event.target);

  if (region.hasClass('region')) {

    $('.magazine-viewport').data().regionClicked = true;
    
    setTimeout(function() {
      $('.magazine-viewport').data().regionClicked = false;
    }, 100);
    
    var regionType = $.trim(region.attr('class').replace('region', ''));

    return processRegion(region, regionType);

  }

}

// Procesar los datos de cada región



function processRegion(region, regionType) {

  data = decodeParams(region.attr('region-data'));

  switch (regionType) {
    case 'link' :

      window.open(data.url);

    break;
    case 'zoom' :

      var regionOffset = region.offset(),
        viewportOffset = $('.magazine-viewport').offset(),
        pos = {
          x: regionOffset.left-viewportOffset.left,
          y: regionOffset.top-viewportOffset.top
        };

      $('.magazine-viewport').zoom('zoomIn', pos);

    break;
    case 'to-page' :

      $('.magazine').turn('page', data.page);

    break;
  }

}

// Load large page

function loadLargePage(page, pageElement) {
  
  var img = $('<img />');

  img.load(function() {

    var prevImg = pageElement.find('img');
    $(this).css({width: '100%', height: '100%'});
    $(this).appendTo(pageElement);
    prevImg.remove();
    
  });

// Cargar página nueva
 if(page==1){
     img.attr('src',portada +  1 + '.jpg');
  
  }else if(page==ficheros){
    img.attr('src', contraportada +  2 + '.jpg');
  }else{
    var page=page-1;

  img.attr('src', contenido +  page + '.jpg');
  
  }
 
}

// Load small page

function loadSmallPage(page, pageElement) {
  
  var img = pageElement.find('img');

  img.css({width: '100%', height: '100%'});

  img.unbind('load');
  // Loadnew page

   if(page==1){
     img.attr('src', portada +  1 + '.jpg');
  
  }else if(page==ficheros){
    img.attr('src', contraportada +  2 + '.jpg');
  }else{
    var page=page-1;

  img.attr('src', contenido +  page + '.jpg');
  
  }
 

}

//  

function isChrome() {

  return navigator.userAgent.indexOf('Chrome')!=-1;

}

function disableControls(page) {
    if (page==1)
      $('.previous-button').hide();
    else
      $('.previous-button').show();
          
    if (page==$('.magazine').turn('pages'))
      $('.next-button').hide();
    else
      $('.next-button').show();
}

// Set the width and height for the viewport

function resizeViewport() {

  var width = $(window).width(),
    height = $(window).height(),
    options = $('.magazine').turn('options');

  $('.magazine').removeClass('animated');

  $('.magazine-viewport').css({
    width: width,
    height: height
  }).
  zoom('resize');


  if ($('.magazine').turn('zoom')==1) {
    var bound = calculateBound({
      width: options.width,
      height: options.height,
      boundWidth: Math.min(options.width, width),
      boundHeight: Math.min(options.height, height)
    });

    if (bound.width%2!==0)
      bound.width-=1;

      
    if (bound.width!=$('.magazine').width() || bound.height!=$('.magazine').height()) {

      $('.magazine').turn('size', bound.width, bound.height);

      if ($('.magazine').turn('page')==1)
        $('.magazine').turn('peel', 'br');

      $('.next-button').css({height: bound.height, backgroundPosition: '-38px '+(bound.height/2-32/2)+'px'});
      $('.previous-button').css({height: bound.height, backgroundPosition: '-4px '+(bound.height/2-32/2)+'px'});
    }

    $('.magazine').css({top: -bound.height/2, left: -bound.width/2});
  }

  var magazineOffset = $('.magazine').offset(),
    boundH = height - magazineOffset.top - $('.magazine').height(),
    marginTop = (boundH - $('.thumbnails > div').height()) / 2;

  if (marginTop<0) {
    $('.thumbnails').css({height:1});
  } else {
    $('.thumbnails').css({height: boundH});
    $('.thumbnails > div').css({marginTop: marginTop});
  }

  if (magazineOffset.top<$('.made').height())
    $('.made').hide();
  else
    $('.made').show();

  $('.magazine').addClass('animated');
  
}


// Number of views in a flipbook

function numberOfViews(book) {
  return book.turn('pages') / 2 + 1;
}

// Current view in a flipbook

function getViewNumber(book, page) {
  return parseInt((page || book.turn('page'))/2 + 1, 10);
}

function moveBar(yes) {
  if (Modernizr && Modernizr.csstransforms) {
    $('#slider .ui-slider-handle').css({zIndex: yes ? -1 : 10000});
  }
}

function setPreview(view) {

  var previewWidth = 112,
    previewHeight = 73,
    previewSrc = 'pages/preview.jpg',
    preview = $(_thumbPreview.children(':first')),
    numPages = (view==1 || view==$('#slider').slider('option', 'max')) ? 1 : 2,
    width = (numPages==1) ? previewWidth/2 : previewWidth;

  _thumbPreview.
    addClass('no-transition').
    css({width: width + 15,
      height: previewHeight + 15,
      top: -previewHeight - 30,
      left: ($($('#slider').children(':first')).width() - width - 15)/2
    });

  preview.css({
    width: width,
    height: previewHeight
  });

  if (preview.css('background-image')==='' ||
    preview.css('background-image')=='none') {

    preview.css({backgroundImage: 'url(' + previewSrc + ')'});

    setTimeout(function(){
      _thumbPreview.removeClass('no-transition');
    }, 0);

  }

  preview.css({backgroundPosition:
    '0px -'+((view-1)*previewHeight)+'px'
  });
}

// Width of the flipbook when zoomed in

function largeMagazineWidth() {
  
  return 2214;

}

// decode URL Parameters

function decodeParams(data) {

  var parts = data.split('&'), d, obj = {};

  for (var i =0; i<parts.length; i++) {
    d = parts[i].split('=');
    obj[decodeURIComponent(d[0])] = decodeURIComponent(d[1]);
  }

  return obj;
}

// Calculate the width and height of a square within another square

function calculateBound(d) {
  
  var bound = {width: d.width, height: d.height};

  if (bound.width>d.boundWidth || bound.height>d.boundHeight) {
    
    var rel = bound.width/bound.height;

    if (d.boundWidth/rel>d.boundHeight && d.boundHeight*rel<=d.boundWidth) {
      
      bound.width = Math.round(d.boundHeight*rel);
      bound.height = d.boundHeight;

    } else {
      
      bound.width = d.boundWidth;
      bound.height = Math.round(d.boundWidth/rel);
    
    }
  }
    
  return bound;
}



</script>

<?php } ?>
</body>
</html>