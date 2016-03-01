<?php
$dpi = 82;
$factor = 100*2.54/$dpi;

$logo = '';

$dimension = ['width'  => 110 * $factor,
              'height' => 148 * $factor];

$margin = ['top' => 0.0 * $factor, 'right' => 2.0 * $factor, 'bottom' => 2.0 * $factor, 'left' => 2.0 * $factor];

$fields = [
    'title' => [
        'position'  => ['x' => 0.0 * $factor, 'y' => 0.0 * $factor],
        'dimension' => ['width' => $dimension['width'] - $margin['left'] - $margin['right'], 'height' => 11 * $factor],
        'margin'    => ['top' => 6.0 * $factor, 'right' => 0.0 * $factor, 'bottom' => 0.0 * $factor, 'left' => 0.0 * $factor],
    ],
];

$fields += [
    'receiver' => [
        'position'  => ['x' => 0.0 * $factor, 'y' => $fields['title']['position']['y'] + $fields['title']['dimension']['height']],
        'dimension' => ['width' => 75 * $factor - $margin['left'], 'height' => 35 * $factor],
        'margin'    => ['top' => 0.0 * $factor, 'right' => 0.0 * $factor, 'bottom' => 0.0 * $factor, 'left' => 0.0 * $factor],
    ],
];

$fields += [
    'sender' => [
        'position'  => ['x' => $fields['receiver']['dimension']['width'], 'y' => $fields['receiver']['position']['y']],
        'dimension' => ['width' => 20 * $factor - $margin['left'], 'height' => 35 * $factor],
        'margin'    => ['top' => 0.0 * $factor, 'right' => 0.0 * $factor, 'bottom' => 0.0 * $factor, 'left' => 0.0 * $factor],
    ],
];

$fields += [
    'depot' => [
        'position'  => ['x' => $fields['sender']['position']['x'] + $fields['sender']['dimension']['width'], 'y' => $fields['sender']['position']['y']],
        'dimension' => ['width' => 20 * $factor - $margin['left'], 'height' => 35 * $factor],
        'margin'    => ['top' => 0.0 * $factor, 'right' => 0.0 * $factor, 'bottom' => 0.0 * $factor, 'left' => 0.0 * $factor],
    ],
];

$fields += [
    'clientInfo' => [
        'position'  => ['x' => 0.0 * $factor, 'y' => $fields['receiver']['position']['y'] + $fields['receiver']['dimension']['height']],
        'dimension' => ['width' => 50 * $factor - $margin['left'], 'height' => 10 * $factor],
        'margin'    => ['top' => 0.0 * $factor, 'right' => 0.0 * $factor, 'bottom' => 0.0 * $factor, 'left' => 0.0 * $factor],
    ],
];

$fields += [
    'packageInfo' => [
        'position'  => ['x' => $fields['clientInfo']['dimension']['width'], 'y' => $fields['clientInfo']['position']['y']],
        'dimension' => ['width' => 20 * $factor, 'height' => 10 * $factor],
        'margin'    => ['top' => 0.0 * $factor, 'right' => 0.0 * $factor, 'bottom' => 0.0 * $factor, 'left' => 0.0 * $factor],
    ],
];

$fields += [
    'service' => [
        'position'  => ['x' => 0.0 * $factor, 'y' => $fields['clientInfo']['position']['y'] + $fields['clientInfo']['dimension']['height']],
        'dimension' => ['width' => 70 * $factor - $margin['left'], 'height' => 28 * $factor],
        'margin'    => ['top' => 0.0 * $factor, 'right' => 0.0 * $factor, 'bottom' => 0.0 * $factor, 'left' => 0.0 * $factor],
    ],
];

$fields += [
    'aztec' => [
        'position'  => ['x' => $fields['service']['dimension']['width'], 'y' => $fields['receiver']['position']['y'] + $fields['receiver']['dimension']['height']],
        'dimension' => ['width' => $dimension['width'] - $margin['left'] - $dimension['right'] - $fields['service']['dimension']['width'], 'height' => $fields['packageInfo']['dimension']['height'] + $fields['service']['dimension']['height']],
        'margin'    => ['top' => 0.0 * $factor, 'right' => 0.0 * $factor, 'bottom' => 0.0 * $factor, 'left' => 0.0 * $factor],
    ],
];

// Create a blank image and add some text
$im = imagecreatetruecolor($dimension['width'], $dimension['height']);
imagefill($im, 0, 0, imagecolorallocate($im, 255, 255, 255));
$textColor = imagecolorallocate($im, 0, 0, 0);

/* Title text */
imagestring($im, 1, $margin['left'] + $fields['title']['position']['left'] + $fields['title']['margin']['left'], $margin['top'] + $fields['title']['position']['top'] + $fields['title']['margin']['top'], 'CO -neutraler Versand Text oder Schadensermittlung', $textColor);
imagestring($im, 1, $margin['left'] + $fields['title']['position']['left'] + $fields['title']['margin']['left'] + 10, $margin['top'] + $fields['title']['position']['top'] + $fields['title']['margin']['top'] + 2, '2', $textColor);

imageline($im, 0, 0, $dimension['width'], 0, $textColor);
imageline($im, $dimension['width'] - 1, 0, $dimension['width'] - 1, $dimension['height'], $textColor);
imageline($im, 0, $dimension['height'] - 1, $dimension['width'], $dimension['height'] - 1, $textColor);
imageline($im, 0, 0, 0, $dimension['height'], $textColor);

imageline($im,
    $margin['left'] + $fields['title']['position']['left'] + $fields['title']['margin']['left'],
    $fields['title']['dimension']['height'],
    $dimension['width'] - $margin['right'] - $fields['title']['margin']['right'],
    $fields['title']['dimension']['height'],
    $textColor
);

imageline($im,
    $fields['receiver']['dimension']['width'],
    $fields['receiver']['position']['y'],
    $fields['receiver']['dimension']['width'],
    $fields['receiver']['position']['y'] + $fields['receiver']['dimension']['height'],
    $textColor
);

imageline($im,
    $margin['left'] + $fields['receiver']['position']['x'] + $fields['receiver']['margin']['left'],
    $fields['receiver']['position']['y'] + $fields['receiver']['dimension']['height'],
    $fields['receiver']['dimension']['width'],
    $fields['receiver']['position']['y'] + $fields['receiver']['dimension']['height'],
    $textColor
);

imageline($im,
    $fields['sender']['position']['x'] + $fields['sender']['dimension']['width'],
    $fields['sender']['position']['y'],
    $fields['sender']['position']['x'] + $fields['sender']['dimension']['width'],
    $fields['sender']['position']['y'] + $fields['sender']['dimension']['height'],
    $textColor
);

imageline($im,
    $fields['sender']['position']['x'],
    $fields['sender']['position']['y'] + $fields['sender']['dimension']['height'],
    $fields['sender']['position']['x'] + $fields['sender']['dimension']['width'],
    $fields['sender']['position']['y'] + $fields['sender']['dimension']['height'],
    $textColor
);

imageline($im,
    $fields['depot']['position']['x'],
    $fields['depot']['position']['y'] + $fields['depot']['dimension']['height'],
    $fields['depot']['position']['x'] + $fields['depot']['dimension']['width'],
    $fields['depot']['position']['y'] + $fields['depot']['dimension']['height'],
    $textColor
);

imageline($im,
    $fields['clientInfo']['dimension']['width'],
    $fields['clientInfo']['position']['y'],
    $fields['clientInfo']['dimension']['width'],
    $fields['clientInfo']['position']['y'] + $fields['clientInfo']['dimension']['height'],
    $textColor
);

imageline($im,
    $margin['left'] + $fields['clientInfo']['position']['x'] + $fields['clientInfo']['margin']['left'],
    $fields['clientInfo']['position']['y'] + $fields['clientInfo']['dimension']['height'],
    $fields['clientInfo']['dimension']['width'],
    $fields['clientInfo']['position']['y'] + $fields['clientInfo']['dimension']['height'],
    $textColor
);

imageline($im,
    $fields['packageInfo']['position']['x'] + $fields['packageInfo']['dimension']['width'],
    $fields['packageInfo']['position']['y'],
    $fields['packageInfo']['position']['x'] + $fields['packageInfo']['dimension']['width'],
    $fields['packageInfo']['position']['y'] + $fields['packageInfo']['dimension']['height'],
    $textColor
);

imageline($im,
    $fields['packageInfo']['position']['x'],
    $fields['packageInfo']['position']['y'] + $fields['packageInfo']['dimension']['height'],
    $fields['packageInfo']['position']['x'] + $fields['packageInfo']['dimension']['width'],
    $fields['packageInfo']['position']['y'] + $fields['packageInfo']['dimension']['height'],
    $textColor
);

imageline($im,
    $fields['service']['dimension']['width'],
    $fields['service']['position']['y'],
    $fields['service']['dimension']['width'],
    $fields['service']['position']['y'] + $fields['service']['dimension']['height'],
    $textColor
);

imageline($im,
    $margin['left'] + $fields['service']['position']['x'] + $fields['service']['margin']['left'],
    $fields['service']['position']['y'] + $fields['service']['dimension']['height'],
    $fields['service']['dimension']['width'],
    $fields['service']['position']['y'] + $fields['service']['dimension']['height'],
    $textColor
);

imageline($im,
    $fields['aztec']['position']['x'],
    $fields['aztec']['position']['y'] + $fields['aztec']['dimension']['height'],
    $fields['aztec']['position']['x'] + $fields['aztec']['dimension']['width'],
    $fields['aztec']['position']['y'] + $fields['aztec']['dimension']['height'],
    $textColor
);

// Set the content type header - in this case image/jpeg
header('Content-Type: image/jpeg');

// Output the image
imagejpeg($im);

// Free up memory
imagedestroy($im);
