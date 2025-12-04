<?php
$file_path = '';
$tipo = '';

if (!empty($_POST)) {
    $file_path = isset($_POST['archivo']) ? $_POST['archivo'] : '';
    $tipo = isset($_POST['tipo']) ? $_POST['tipo'] : '';
}

$extension = strtolower(pathinfo($file_path, PATHINFO_EXTENSION));
$tipo_normalizado = strtolower($tipo);

if ($tipo_normalizado === '' && $extension !== '') {
    $tipo_normalizado = $extension;
}

$media = 'pdf';
$mime = 'application/pdf';

$mapa_mime = array(
    'mp3' => 'audio/mpeg',
    'wav' => 'audio/wav',
    'ogg' => 'audio/ogg',
    'oga' => 'audio/ogg',
    'm4a' => 'audio/mp4',
    'aac' => 'audio/aac',
    'mp4' => 'video/mp4',
    'webm' => 'video/webm',
    'ogv' => 'video/ogg',
    'mov' => 'video/quicktime',
    'mkv' => 'video/x-matroska',
    'avi' => 'video/x-msvideo',
    'pdf' => 'application/pdf'
);

if (in_array($tipo_normalizado, array('audio', 'sonido'))) {
    $media = 'audio';
} elseif (in_array($tipo_normalizado, array('video', 'multimedia'))) {
    $media = 'video';
} elseif (isset($mapa_mime[$extension])) {
    if (strpos($mapa_mime[$extension], 'audio/') === 0) {
        $media = 'audio';
    } elseif (strpos($mapa_mime[$extension], 'video/') === 0) {
        $media = 'video';
    }
    $mime = $mapa_mime[$extension];
}

if ($media === 'audio' && strpos($mime, 'audio/') !== 0) {
    $mime = 'audio/mpeg';
}

if ($media === 'video' && strpos($mime, 'video/') !== 0) {
    $mime = 'video/mp4';
}

$file_safe = htmlspecialchars($file_path, ENT_QUOTES, 'UTF-8');
?>

<div class="container">
  <div class="row">
	  <div class="col-sm-12">
		  <div id="capa_d">
              <?php if ($file_safe === ''): ?>
                  <div class="alert alert-warning">No se encontró el archivo solicitado para la vista previa.</div>
              <?php elseif ($media === 'audio'): ?>
                  <audio controls preload="metadata" style="width:100%;">
                      <source src="<?php echo $file_safe; ?>" type="<?php echo $mime; ?>">
                      Tu navegador no soporta audio embebido. <a href="<?php echo $file_safe; ?>" target="_blank" rel="noopener">Descargar archivo</a>
                  </audio>
              <?php elseif ($media === 'video'): ?>
                  <video controls preload="metadata" style="width:100%;max-height:500px;">
                      <source src="<?php echo $file_safe; ?>" type="<?php echo $mime; ?>">
                      Tu navegador no soporta video embebido. <a href="<?php echo $file_safe; ?>" target="_blank" rel="noopener">Descargar archivo</a>
                  </video>
              <?php else: ?>
			      <object data="<?php echo $file_safe; ?>" type="application/pdf" width="100%" height="500">
				      <p>Tu navegador no puede mostrar el documento. <a href="<?php echo $file_safe; ?>" target="_blank" rel="noopener">Abrir PDF</a></p>
			      </object>
              <?php endif; ?>
		  </div>
	   </div>
  </div> 
</div>