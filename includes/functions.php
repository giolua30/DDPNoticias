<?php
/**
 * Funciones de ayuda usadas por el panel de administración y el sitio público.
 */

/** Escapa texto para mostrarlo seguro en HTML */
function h($texto) {
    return htmlspecialchars($texto ?? '', ENT_QUOTES, 'UTF-8');
}

/** Convierte una fecha SQL (YYYY-MM-DD) a formato "28 agosto, 2026" */
function fecha_larga($fechaSql) {
    $meses = [1=>'enero','febrero','marzo','abril','mayo','junio','julio',
              'agosto','septiembre','octubre','noviembre','diciembre'];
    $ts = strtotime($fechaSql);
    return date('d', $ts) . ' de ' . $meses[(int)date('n', $ts)] . ', ' . date('Y', $ts);
}

/** Recorta un texto largo a $limite caracteres, cortando en palabra completa */
function resumir($texto, $limite = 180) {
    $texto = trim(strip_tags($texto ?? ''));
    if (mb_strlen($texto) <= $limite) return $texto;
    $cortado = mb_substr($texto, 0, $limite);
    $cortado = mb_substr($cortado, 0, mb_strrpos($cortado, ' '));
    return $cortado . '...';
}

/**
 * Sube una imagen a $carpetaDestino (dentro de /uploads) y devuelve el
 * nombre de archivo generado, o null si no se subió ningún archivo.
 * Lanza una excepción si el archivo no es una imagen válida.
 */
function subir_imagen($campo, $carpetaDestino) {
    if (empty($_FILES[$campo]['name'])) {
        return null; // no se seleccionó archivo
    }
    if ($_FILES[$campo]['error'] !== UPLOAD_ERR_OK) {
        throw new Exception('Error al subir el archivo (código ' . $_FILES[$campo]['error'] . ')');
    }

    $permitidas = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
    $ext = strtolower(pathinfo($_FILES[$campo]['name'], PATHINFO_EXTENSION));
    if (!in_array($ext, $permitidas)) {
        throw new Exception('Formato de imagen no permitido: ' . $ext);
    }

    $nombreFinal = uniqid('img_', true) . '.' . $ext;
    $rutaAbsoluta = __DIR__ . '/../uploads/' . $carpetaDestino . '/' . $nombreFinal;

    if (!move_uploaded_file($_FILES[$campo]['tmp_name'], $rutaAbsoluta)) {
        throw new Exception('No se pudo guardar la imagen en el servidor.');
    }
    return $nombreFinal;
}

/** Igual que subir_imagen() pero para archivos PDF */
function subir_pdf($campo, $carpetaDestino) {
    if (empty($_FILES[$campo]['name'])) {
        return null;
    }
    if ($_FILES[$campo]['error'] !== UPLOAD_ERR_OK) {
        throw new Exception('Error al subir el PDF (código ' . $_FILES[$campo]['error'] . ')');
    }
    $ext = strtolower(pathinfo($_FILES[$campo]['name'], PATHINFO_EXTENSION));
    if ($ext !== 'pdf') {
        throw new Exception('El archivo debe ser un PDF.');
    }
    $nombreFinal = uniqid('pdf_', true) . '.pdf';
    $rutaAbsoluta = __DIR__ . '/../uploads/' . $carpetaDestino . '/' . $nombreFinal;
    if (!move_uploaded_file($_FILES[$campo]['tmp_name'], $rutaAbsoluta)) {
        throw new Exception('No se pudo guardar el PDF en el servidor.');
    }
    return $nombreFinal;
}

/** Borra un archivo de /uploads/$carpeta si existe (usado al editar/eliminar) */
function borrar_archivo($carpeta, $nombreArchivo) {
    if (!$nombreArchivo) return;
    $ruta = __DIR__ . '/../uploads/' . $carpeta . '/' . $nombreArchivo;
    if (is_file($ruta)) unlink($ruta);
}
