<?php

function upload_image($image, $folder) {
    // Undefined | Multiple Files | $_FILES Corruption Attack
    // If this request falls under any of them, treat it invalid.
    if (!isset($image['error']) || is_array($image['error']) ) {
        throw new RuntimeException('Invalid parameters.');
    }

    // Check $image['error'] value.
    switch ($image['error']) {
        case UPLOAD_ERR_OK:
            break;
        case UPLOAD_ERR_NO_FILE:
            throw new RuntimeException('No file sent.');
        case UPLOAD_ERR_INI_SIZE:
        case UPLOAD_ERR_FORM_SIZE:
            throw new RuntimeException('Exceeded filesize limit.');
        default:
            throw new RuntimeException('Unknown errors.');
    }

    // You should also check filesize here.
    if ($image['size'] > 1000000) {
        throw new RuntimeException('Exceeded filesize limit.');
    }

    // DO NOT TRUST $image['mime'] VALUE !!
    // Check MIME Type by yourself.
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mime_type = $finfo->file($image['tmp_name']);
    $valid_image_types = [
        'jpg' => 'image/jpeg',
        'png' => 'image/png',
        'gif' => 'image/gif'
    ];

    if (($ext = array_search($mime_type, $valid_image_types, true)) === false) {
        throw new RuntimeException('Invalid file format.');
    }

    // You should name it uniquely.
    // DO NOT USE $image['name'] WITHOUT ANY VALIDATION !!
    // On this example, obtain safe unique name from its binary data.
    $filename = sprintf("$folder/%s.%s", sha1_file($image['tmp_name']), $ext);

    if (!move_uploaded_file($image['tmp_name'], $filename)) {
        var_dump(!move_uploaded_file($image['tmp_name'], $filename));
        die();
        throw new RuntimeException('Failed to move uploaded file.');
    }

    return $filename;
}

function getUploadPath() {
    return $_SERVER["DOCUMENT_ROOT"].'/uploads';
}

function getServerName() {
    return $_SERVER['HTTP_HOST'];
}