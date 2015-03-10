<?php

function resizeImage($file, $width, $height, $quality = 100)
{

    # We find the right file
    $pathinfo = pathinfo(trim($file));
    $output   = $pathinfo['dirname'] . '/' . $pathinfo['filename'] . '_' . $width . 'x' . $height . '.' . $pathinfo['extension'];

    # Setting defaults and meta
    $info = getimagesize($file);

    list($width_old, $height_old) = $info;

    # Create image ressource

    switch ($pathinfo['extension']) {
        case "gif":$image = imagecreatefromgif($file);
            break;
        case "jpg":
        case "jpeg":
            $image = imagecreatefromjpeg($file);
            break;
        case "png":$image = imagecreatefrompng($file);
            break;
        default:return false;
    }
    # We find the right ratio to resize the image before cropping
    $heightRatio  = $height_old / $height;
    $widthRatio   = $width_old / $width;
    $optimalRatio = $widthRatio;
    if ($heightRatio < $widthRatio) {
        $optimalRatio = $heightRatio;
    }
    $height_crop = ($height_old / $optimalRatio);
    $width_crop  = ($width_old / $optimalRatio);
    # The two image ressources needed (image resized with the good aspect ratio, and the one with the exact good dimensions)
    $image_crop    = imagecreatetruecolor($width_crop, $height_crop);
    $image_resized = imagecreatetruecolor($width, $height);

    # This is the resizing/resampling/transparency-preserving magic
    if (($info[2] == IMAGETYPE_GIF) || ($info[2] == IMAGETYPE_PNG)) {
        $transparency = imagecolortransparent($image);
        if ($transparency >= 0) {
            $transparent_color = imagecolorsforindex($image, $trnprt_indx);
            $transparency      = imagecolorallocate($image_crop, $trnprt_color['red'], $trnprt_color['green'], $trnprt_color['blue']);
            imagefill($image_crop, 0, 0, $transparency);
            imagecolortransparent($image_crop, $transparency);
            imagefill($image_resized, 0, 0, $transparency);
            imagecolortransparent($image_resized, $transparency);
        } elseif ($info[2] == IMAGETYPE_PNG) {
            imagealphablending($image_crop, false);
            imagealphablending($image_resized, false);
            $color = imagecolorallocatealpha($image_crop, 0, 0, 0, 127);
            imagefill($image_crop, 0, 0, $color);
            imagesavealpha($image_crop, true);
            imagefill($image_resized, 0, 0, $color);
            imagesavealpha($image_resized, true);
        }
    }
    imagecopyresampled($image_crop, $image, 0, 0, 0, 0, $width_crop, $height_crop, $width_old, $height_old);
    imagecopyresampled($image_resized, $image_crop, 0, 0, ($width_crop - $width) / 2, ($height_crop - $height) / 2, $width, $height, $width, $height);
    # Writing image according to type to the output destination and image quality
    switch ($pathinfo['extension']) {
        case "gif":imagegif($image_resized, $output, $quality);
            break;
        case "jpeg":
        case "jpg":
            imagejpeg($image_resized, $output, $quality);
            break;
        case "png":imagepng($image_resized, $output, 9);
            break;
        default:return false;
    }

    return true;
}

function resizedName($image_name)
{

    $info        = pathinfo(IMAGES_DIR . "/" . $image_name);
    $image_thumb = implode("", glob(IMAGES_DIR . "/" . $info['filename'] . "_*x*" . $info['extension']));
    $image_thumb = pathinfo($image_thumb, PATHINFO_FILENAME) . "." . pathinfo($image_thumb, PATHINFO_EXTENSION);

    return $image_thumb;
}