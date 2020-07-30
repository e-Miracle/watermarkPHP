<?php
/**VARIABLES EXPLANATIONS
 * pass in the varriables through a key value array
 * $variables = array('imagepath'=>$imgPath, 'text'=>$string, 'x'=>'distance from side'
 * , 'y'=> 'distance from top', 'break'=>'line break distance', 'color'=>array(R,G,B), 'font_size'=>'sixe of font from 1-5');
 */

 class Watermark
 {
     private $imgPath;
     private $string;
     private $x;
     private $y;
     private $break;
     private $color;
     private $fontSize;
     //private $fontPath;

     public function __construct($variables)
     {
        //checking to make sure array is in order
        if (array_count_values($variables)<1) {
            return 'input must be an array';
        }

        //checking if image path exist
        if (!array_key_exists('imagepath', $variables)) 
        {
            return 'please provide an image to be written on';
        }
        else if (!file_exists($variables['imagePath'])) {
            return 'given file path is invalid';
        }
        else if ($variables['imagePath']=='') {
            return 'file path is cumpolsory';
        }
        else
        {
            $this->imgPath = $variables['imagepath'];
        }

        //checking if text is in array
        if (!array_key_exists('text', $variables)) 
        {
           return 'please provide a text to write on the image';
        }
        else if ($variables['text']=='') 
        {
            return 'text is cumpolsory';
        }
        else
        {
            $this->string = $variables['text'];
        }

        //checking if x height was defined
        if (array_key_exists('x', $variables) && $variables['x']!='') 
        {
            $this->x = $variables['x'];
        }
        else
        {
            $this->x = 0;
        }

        //checking if y height was defined
        if (array_key_exists('y', $variables) && $variables['y']!='') 
        {
            $this->y = $variables['y'];
        }
        else
        {
            $this->y = 0;
        }

        //checking if line break was defined
        if (array_key_exists('break', $variables) && $variables['break']!='') 
        {
            $this->break = $variables['break'];
        }
        else
        {
            $this->break = 15;
        }

        //checking if color was defined
        if (array_key_exists('color', $variables) && $variables['color']!=array()) 
        {
            $this->color = $variables['color'];
        }
        else
        {
            $this->color = array(255, 255, 255);
        }

        //checking if color was defined
        if (array_key_exists('font_size', $variables) && $variables['font_size']!=array()) 
        {
            $this->fontSize = $variables['font_size'];
        }
        else
        {
            $this->fontSize = 5;
        }
     }

     public function image()
     {
        $imgPath = $this->imgPath;
        $image = imagecreatefromjpeg($imgPath);

        if ($image == false) {
            return 'could not load image';
        }

        $color = imagecolorallocate($image, $this->color[0], $this->color[1], $this->color[2]);

        if ($color==false) {
            return 'failed to allocate color';
        }

        $strings = $this->string;
        $strings = explode('|', wordwrap($strings, 15, '|'));

        
        foreach ($strings as $string) {
            
            imagestring($image, $this->fontSize, $this->x, $this->y, $string, $color);

            $y+=$this->break;
        }
        imagejpeg($image) or die('error');
        imagedestroy($image);
     }

 }
 
header("Content-type: image/jpeg");

$color = new Watermark($bube);
$color = $color->image();
exit;
?>