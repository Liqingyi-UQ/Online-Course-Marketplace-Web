<?php namespace App\Models;
//Week 6
use CodeIgniter\Model;

class Picture_Model extends Model {

    protected $allowedFields = ['filename', 'path'];

    // Crop image
    public function crop($path, $filename) {
        echo $path, $filename;
        $imagick = new \Imagick($path.$filename);
        $width = $imagick->getImageWidth();
        $height = $imagick->getImageHeight();
        $imagick->cropImage($width/2, $height/2, $width/4, $height/4);
        //echo str_replace('jpeg','crop.jpeg',$filename);
        $imagick->writeImage($path.'crop_'.$filename);
        $imagick->clear();
        $imagick->destroy();
        return 'crop_'.$filename;
    }

    // Resize image
    public function resize($filename, $width, $height) {
      // add your code here
    }

    // Rotate image
    public function rotate($path,$filename, $degrees=180) {
        $imagick = new \Imagick($path.$filename);
        $imagick->rotateImage(new \ImagickPixel(), $degrees);
        $imagick->writeImage($path.'rot_'.$filename);
        $imagick->clear();
        $imagick->destroy();
        return 'rot_'.$filename;
    }

    // Add text watermark
    public function addTextWatermark($path, $filename,$watermark_text) {
        // add your code here
         // 创建 Imagick 对象
         $imagick = new \Imagick($path . $filename);
         // 创建 ImagickDraw 对象，用于绘制水印文字
         $draw = new \ImagickDraw();
         $draw->setFontSize(20);
         // 设置文字颜色
         $draw->setFillColor('red');
         $draw->setFillOpacity(0.5);
         // 设置文字水印位置
         $horizontal_offset = 40;
         $vertical_offset = 40;
         $draw->annotation($horizontal_offset, $vertical_offset, $watermark_text);
         // 将水印文字添加到图像上
         $imagick->drawImage($draw);
         // 保存添加了水印的图像
         $imagick->writeImage($path . 'watermarked_' . $filename);
         $imagick->clear();
         $imagick->destroy();
         $draw->clear();
         $draw->destroy();
         return 'watermarked_' . $filename;
        }

}