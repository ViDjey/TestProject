<?php session_start();?>
<?php
    $chars = str_shuffle('abcdefghijkmnopqrstuvwxyzABCDEFGHJKLMNOPQRSTUVWXYZ1234567890');
    $length = rand(4, 7);
    
    $width = 120; $height = 40;
    $fontsize = 14;
    header('Content-type: image/png');
    $im = imagecreatetruecolor($width, $height);
    imagesavealpha($im, true);
    $bg = imagecolorallocatealpha($im, 0, 0, 100, 110);
    imagefill($im, 0, 0, $bg);
    $font = 'arial.ttf';

    $captcha = '';
    for ($i = 0; $i < $length; $i++)
      {
        $captcha .= $chars[rand(0, strlen($chars)-1)];
        $x = ($width - 20) / $length * $i + 10;
        $x = rand($x, $x+4);
        $y = $height - (($height - $fontsize) / 2);
        $curcolor = imagecolorallocate($im, rand(0, 100), rand(0, 100), rand(0, 100));
        $angle = rand(-15, 15);
        imagettftext($im, $fontsize, $angle, $x, $y, $curcolor,$font, $captcha[$i]);
      }
      imagepng($im);
      imagedestroy($im);
      $_SESSION['capcha'] = $captcha;
      session_write_close(); 
?> 




