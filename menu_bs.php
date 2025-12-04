<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">
 <head>
   <title>BASES PWD</title>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.min.css">
  <link rel="stylesheet" href="bootstrap/css/style_chat.css" media="all"/>	
  <link rel="stylesheet" href="bootstrap/cust.css">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/js/bootstrap.min.js"></script>
  <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
  <script src="bootstrap/js/funciones_gral.js"></script>
     
   <!-----https://sourcecodesite.com/how-to-create-chat-system-in-php-using-ajax-2.html--->
   <!--Include Custom CSS-->
   <!---
   <script src="bootstrap/js/funciones_e.js"></script>
   <script src="bootstrap/js/funciones_d.js"></script>
   --->
   <script>
   function cargar(div,desde)
   {
   $(div).load(desde);
   } 
   </script>
   <script>
   function poner_nombre(div,nombre)
   {
   $(div).text(nombre);
   } 
   </script>
<style>
pre {
    display: block;
    font-family: arial;
    white-space: pre;
    margin: 2em 0;
} 
#background {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-image: url('images/b_bkg_3.jpg');
    background-repeat: no-repeat;
    background-attachment: fixed;
    background-size: 100%;
    opacity: 0.6;
    filter:alpha(opacity=80);
}
.online-users-indicator {
    position: relative;
    padding: 12px 14px;
    color: #fff;
    display: flex;
    align-items: center;
    gap: 8px;
}
.online-users-indicator .count {
    display: inline-block;
    min-width: 32px;
    text-align: center;
    font-weight: 600;
}
.online-users-indicator .status-dot {
    width: 10px;
    height: 10px;
    border-radius: 50%;
    display: inline-block;
    background: #aaa;
    box-shadow: 0 0 6px rgba(0,0,0,0.3);
}
.online-users-indicator--connected .status-dot {
    background: #5cb85c;
}
.online-users-indicator--disconnected .status-dot {
    background: #f0ad4e;
}
.online-users-indicator--connected .count {
    background-color: #5cb85c;
}
.online-users-indicator--disconnected .count {
    background-color: #f0ad4e;
}
.online-users-panel {
    display: none;
    position: absolute;
    right: 0;
    top: 48px;
    background: #222;
    color: #fff;
    padding: 8px 12px;
    border-radius: 4px;
    min-width: 220px;
    z-index: 1000;
    box-shadow: 0 4px 12px rgba(0,0,0,0.25);
}
.online-users-indicator:hover .online-users-panel {
    display: block;
}
.online-users-list {
    list-style: none;
    padding-left: 0;
    margin: 8px 0 0 0;
    max-height: 200px;
    overflow-y: auto;
}
.online-users-list li {
    padding: 2px 0;
    border-bottom: 1px solid rgba(255,255,255,0.1);
}
.online-users-list li:last-child {
    border-bottom: none;
}
.online-users-list small {
    display: block;
    font-size: 11px;
    color: rgba(255,255,255,0.65);
}
</style>
 </head>
 
 <!-----body style="padding: 0px 0px 0px 0px;background-image: url(images/b_bkg_4.jpg);" onload="cargar('#capa_P','txts/init_1.html');cargar('#capa_C','txts/init_2.html')"---->
 <body style="padding: 0px 0px 0px 0px;"  >
  <div id="background"></div>
 <div class="container-fluid" >
 
   <nav class="navbar navbar-inverse navbar-static-top navbar2" role="navigation" >
    
      <ul class="nav navbar-nav ">
        <li><a href="index.php"><span class="glyphicon glyphicon-home"></span></a></li>
		<li><a href="cartelera.php">Cartelera</a></li>
		<li><a href="cartelera.php?ayuda=1">Ayuda</a></li>
		<li><a href="abm_ld.php">Libros</a></li>
        <li><a href="abm_li.php">Material impreso</a></li>
        <?php 
        if (isset($_SESSION['username'])){
            echo '<li><a href="abm_prestamos.php">Préstamos</a></li>';
        }
        ?>
		<?php 
		if (isset($_SESSION['username']) && $_SESSION['rol']=='administrador'){
		 echo '<li><a href="abm_p.php">Usuarios</a></li>';
		 echo '<li><a href="abm_c.php">Carteles</a></li>';
		}
		?>
	  
	  
	  </ul>
	  <ul class="nav navbar-nav navbar-right" style="padding-right: 10px;">
      
	  <?php 
	  if (isset($_SESSION['username'])) {
	  echo ' <li class="navbar-brand">'.$_SESSION['rol'].' : '.$_SESSION['username'].'</li>'; 
      }
	  ?>
      <?php
      if (isset($_SESSION['username']) && $_SESSION['rol']=='administrador') {
          echo '
          <li class="online-users-indicator online-users-indicator--disconnected" id="onlineUsersIndicator">
            <span class="status-dot" aria-hidden="true"></span>
            <span class="label label-default count" aria-live="polite">0</span>
            <span class="status-text">Usuarios conectados</span>
            <div class="online-users-panel" role="status" aria-live="polite">
              <strong>Usuarios activos</strong>
              <ul class="online-users-list" id="onlineUsersList">
                <li class="text-muted">Sin usuarios activos</li>
              </ul>
            </div>
          </li>';
      }
      ?>
	  
      
<?php
	  if (!isset($_SESSION['username'])){
	    echo '	  
	        <li><a href="registro.php"  data-toggle="modal" data-target="#myModal"><span class="glyphicon glyphicon-user"></span> Registro</a></li>
             ';
        echo '	  
	        <li><a href="login.php" data-toggle="modal" data-target="#myModal"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
             ';
		  }	 
	  else{
	    echo '	  
		    <li><a href="i_chat.php">Chat</a></li>
	        <li><a href="logout.php" ><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
             ';
	       }
?>		   
	</ul>
	  
	  
	 
	 
   </nav>
  

  
  
 
  
 <!-- Modal -->
 
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Modal Header</h4>
      </div>
      <div class="modal-body">
        <p></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>



</div>
<?php if (isset($_SESSION['username'])): ?>
<?php
    $isHttps = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off');
    $wsScheme = $isHttps ? 'wss' : 'ws';
    $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
    $host = preg_replace('/:.*/', '', $host);
    $wsPort = getenv('WS_PORT') ? getenv('WS_PORT') : '8081';
    $wsUrl = $wsScheme . '://' . $host . ':' . $wsPort;
?>
<script>
  window.wsConfig = {
    url: '<?php echo $wsUrl; ?>',
    username: <?php echo json_encode($_SESSION['username']); ?>,
    role: <?php echo json_encode($_SESSION['rol']); ?>
  };
</script>
<script src="bootstrap/js/online-users.js"></script>
<?php endif; ?>
 
</body>
</html>
