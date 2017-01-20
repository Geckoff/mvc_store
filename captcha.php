<?php
    session_start();
    $height = 50;
    $width = 110;

    $im = imageCreateTrueColor($width, $height);

    $bg = imageColorAllocate($im, 255, getRandColor(), getRandColor());
    imageFilledRectangle($im, 0, 0, $width, $height, $bg);
    $border = imageColorAllocate($im, getRandColor() , getRandColor(), 255);
    imageRectangle($im, 0, 0, $width - 1, $height - 1, $border);

    $fonts = array('fonts/verdana.ttf', 'fonts/arial.ttf', 'fonts/times.ttf', 'fonts/gara.ttf', 'fonts/frs.ttf');
    $alphabet = range('a', 'z');
    $char_count = mt_rand(5, 6);
    $step = floor(($width - 10) / ($char_count - 1));
    $key = '';
    for ($i = 0; $i < $char_count - 1; $i++) {
        $letornum = mt_rand(1, 2);
        if ($letornum == 1) {
            $char = mt_rand(0, 9);
        }
        else {
            $char = $alphabet[mt_rand(0, 25)];
        }
        $key .= $char;

        $charcol =  imageColorAllocate($im, getRandColor(), getRandColor(), getRandColor());
        $size = mt_rand(20, 30);
        $angle = mt_rand(-15, 15);
        $x = $step * $i + 5;
        $y = mt_rand($size, $height);
        $font = $fonts[mt_rand(0, 4)];
        imageTtfText($im, $size, -$angle, $x, $y, $charcol, $font, $char);
    }
    $_SESSION["captcha"] = $key;

    $line_count = mt_rand(2, 4);
    for ($i = 0; $i < $line_count; $i++) {
        $linecol =  imageColorAllocate($im, getRandColor(), getRandColor(), getRandColor());
        $x1 = getRandWidth();
        $x2 = getRandWidth();
        $y1 = getRandHeight();
        $y2 = getRandHeight();
        imageline($im, $x1, $y1, $x2, $y2, $linecol);
        imageline($im, $x1 + 1, $y1 + 1, $x2 + 1, $y2 + 1, $linecol);
    }

    $polygon_count = mt_rand(2, 6);
    for ($i = 0; $i < $polygon_count; $i++) {
        $polcol =  imageColorAllocate($im, getRandColor(), getRandColor(), getRandColor());
        $num_points = mt_rand(3, 6);
        $x1 = getRandWidth();
        $y1 = getRandHeight();
        $points = array($x1, $y1);
        for ($i = 0; $i < $num_points - 1; $i++) {
            $x = $x1 + mt_rand(1, 20);
            $y = $y1 + mt_rand(1, 20);
            array_push($points, $x, $y);
        }
        imagefilledpolygon ($im, $points, $num_points, $polcol);
    }


    header("Content-type: image/png");
    imagePng($im);
    imageDestroy($im);

    function getRandColor() {
        return mt_rand(0, 255);
    }

    function getRandWidth() {
        global $width;
        return mt_rand(0, $width);
    }

    function getRandHeight() {
        global $height;
        return mt_rand(0, $height);
    }


?>