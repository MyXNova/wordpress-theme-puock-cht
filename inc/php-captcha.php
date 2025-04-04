<?php
/**
 * @link https://github.com/lifei6671/php-captcha
 * @author lifei6671
 * @license MIT
 */

class CaptchaBuilder
{
    /**
     * @var resource 驗證碼圖片
     */
    protected $image;
    /**
     * @var string 驗證碼文字
     */
    protected $text ;
    /**
     * @var string 隨機字元
     */
    protected $characters = '2346789abcdefghjmnpqrtuxyzABCDEFGHJMNPQRTUXYZ';
    /**
     * @var int 圖片寬度
     */
    protected $width = 150;
    /**
     * @var int 圖片高度
     */
    protected $height = 40;

    private $fonts = [];
    /**
     * @var int 驗證碼字元的個數
     */
    private $number = 4;
    /**
     * @var int 字型大小
     */
    private $fontSize = 24;
    /**
     * @var string 驗證碼字型
     */
    private $textFont;

    private $noiseLevel = 30;

    private $backColor;
    /**
     * @var bool 是否新增干擾線
     */
    private $isDrawLine = false;
    /**
     * @var bool 是否啟用曲線
     */
    private $isDrawCurve = true;
    /**
     * @var bool 是否啟用背景噪音
     */
    private $isDrawNoise = true;


    public function __construct()
    {
        setlocale(LC_ALL, 'zh_TW.UTF-8');

        $this->initialize([]);
    }

    public function initialize(array $config){

        isset($config['width']) && $this->width = $config['width'] ;
        $this->height = isset($config['height']) ? $config['height'] : 40;
        $this->number = isset($config['number']) ? $config['number'] : 4;
        $this->fontSize = intval($this->width / floatval($this->number*1.5));
        isset($config['line']) && $this->isDrawLine = boolval($config['line']);
        isset($config['curve']) && $this->isDrawCurve = boolval($config['curve']);
        isset($config['noise']) && $this->isDrawNoise = boolval($config['noise']);

        if(isset($config['fonts']) && empty($config['fonts']) === false){
            $this->fonts = $config['fonts'];
        }else {
            $fontDir = __DIR__ . '/fonts/';
            $scan_dir = scandir($fontDir);
            if($scan_dir){
                $this->fonts = array_filter(array_slice(scandir($fontDir), 2), function ($file) use ($fontDir) {
                    return is_file($fontDir . $file) && strcasecmp(pathinfo($file, PATHINFO_EXTENSION), 'ttf') === 0;
                });
            }
            if (empty($this->fonts) === false) {
                foreach ($this->fonts as &$font) {
                    $font = $fontDir . $font;
                }
                unset($font);
            }
        }
        $this->noiseLevel = $this->width*10 / $this->height;
    }

    public function create()
    {
        $this->image = imagecreate($this->width, $this->height);

        list($red, $green, $blue) = $this->getLightColor();

        $this->backColor = imagecolorallocate($this->image, $red, $green, $blue);

        imagefill($this->image,0,0,$this->backColor);
        if (empty($this->fonts)) {
            throw new \Exception('字型不存在');
        }

        $this->textFont = $this->fonts[array_rand($this->fonts)];

        $this->isDrawNoise && $this->drawNoise();

        if($this->isDrawLine){
            $square = $this->width * $this->height;
            $effects = mt_rand($square/3000, $square/2000);
            for ($e = 0; $e < $effects; $e++) {
                $this->drawLine($this->image, $this->width, $this->height);
            }
        }
        $this->isDrawCurve && $this->drawSineLine();

        $codeNX = 0; // 驗證碼第 N 個字元的左邊距
        $code = [];

        for ($i = 0; $i < $this->number; $i++) {
            $code[$i] = $this->characters[mt_rand(0, strlen($this->characters) - 1)];
            $codeNX += mt_rand($this->fontSize * 1, $this->fontSize * 1.3);

            list($red, $green, $blue) = $this->getDeepColor();
            $color = imagecolorallocate($this->image, $red, $green, $blue);
            if($color === false){
                $color = mt_rand(50,200);
            }
            imagettftext($this->image, $this->fontSize, mt_rand(-40, 40), $codeNX, $this->fontSize * 1.2, $color, $this->textFont, $code[$i]);
        }

        $this->text = strtolower(implode('',$code));
        return $this;
    }

    public function save($filename, $quality)
    {
        return imagepng($this->image,$filename,$quality);
    }

    public function output($quality = 1)
    {
        header('Cache-Control: private, max-age=0, no-store, no-cache, must-revalidate');
        header('Cache-Control: post-check=0, pre-check=0', false);
        header('Pragma: no-cache');
        header("content-type: image/png");
        imagepng($this->image,null,$quality);
    }

    public function getText()
    {
        return $this->text;
    }

    public function destroy()
    {
        @imagedestroy($this->image);
    }
    public function __destruct()
    {
        $this->destroy();
    }

    private function getFontColor()
    {
        list($red, $green, $blue) = $this->getDeepColor();

        return imagecolorallocate($this->image, $red, $green, $blue);
    }
    /**
     *  畫曲線
     */
    protected function drawSineLine() {
        $px = $py = 0;

        // 曲線前部分
        $A = mt_rand(1, $this->height/2);                  // 振幅
        $b = mt_rand(-$this->height/4, $this->height/4);   // Y 軸方向偏移量
        $f = mt_rand(-$this->height/4, $this->height/4);   // X 軸方向偏移量
        $T = mt_rand($this->height, $this->width*2);  // 週期
        $w = (2* M_PI)/$T;

        $px1 = 0;  // 曲線橫座標起始位置
        $px2 = mt_rand($this->width/2, $this->width * 0.8);  // 曲線橫座標結束位置

        $color = imagecolorallocate($this->image, mt_rand(1, 150), mt_rand(1, 150), mt_rand(1, 150));

        for ($px=$px1; $px<=$px2; $px = $px + 1) {
            if ($w!=0) {
                $py = $A * sin($w*$px + $f)+ $b + $this->height/2;  // y = Asin(ωx+φ) + b
                $i = (int) ($this->fontSize/5);
                while ($i > 0) {
                    imagesetpixel($this->image, $px + $i , $py + $i, $color);  // 這裡 (while) 循環畫畫素點比 imagettftext 和 imagestring 用字型大小一次畫出（不用這 while 循環）效能要好很多
                    $i--;
                }
            }
        }

        // 曲線後部分
        $A = mt_rand(1, $this->height/2);                  // 振幅
        $f = mt_rand(-$this->height/4, $this->height/4);   // X 軸方向偏移量
        $T = mt_rand($this->height, $this->width*2);  // 週期
        $w = (2* M_PI)/$T;
        $b = $py - $A * sin($w*$px + $f) - $this->height/2;
        $px1 = $px2;
        $px2 = $this->width;

        for ($px=$px1; $px<=$px2; $px=$px+ 1) {
            if ($w!=0) {
                $py = $A * sin($w*$px + $f)+ $b + $this->height/2;  // y = Asin(ωx+φ) + b
                $i = (int) ($this->fontSize/5);
                while ($i > 0) {
                    imagesetpixel($this->image, $px + $i, $py + $i, $color);
                    $i--;
                }
            }
        }
    }

    /**
     * Draw lines over the image
     */
    protected function drawLine($image, $width, $height, $tcol = null)
    {
        if ($tcol === null) {
            $tcol = imagecolorallocate($image, mt_rand(100, 255), mt_rand(100, 255), mt_rand(100, 255));
        }
        if (mt_rand(0, 1)) { // Horizontal
            $Xa   = mt_rand(0, $width/2);
            $Ya   = mt_rand(0, $height);
            $Xb   = mt_rand($width/2, $width);
            $Yb   = mt_rand(0, $height);
        } else { // Vertical
            $Xa   = mt_rand(0, $width);
            $Ya   = mt_rand(0, $height/2);
            $Xb   = mt_rand(0, $width);
            $Yb   = mt_rand($height/2, $height);
        }
        imagesetthickness($image, mt_rand(1, 3));
        imageline($image, $Xa, $Ya, $Xb, $Yb, $tcol);
    }

    /**
     * 畫雜點
     * 往圖片上寫不同顏色的字母或數字
     */
    private function drawNoise() {

        $codeSet = '2345678abcdefhijkmnpqrstuvwxyz';
        for($i = 0; $i < $this->noiseLevel; $i++){
            list($red,$green,$blue) = $this->getLightColor();

            //雜點顏色
            $noiseColor = imagecolorallocate($this->image, $red,$green,$blue);
            for($j = 0; $j < 5; $j++) {
                // 繪雜點
                imagestring($this->image, 5, mt_rand(-10, $this->width),  mt_rand(-10, $this->height), $codeSet[mt_rand(0, 29)], $noiseColor);
            }
        }
    }

    /**
     * 獲取隨機淺色
     * @return array
     */
    private function getLightColor()
    {
        $colors[0] = 200 + mt_rand(1,55);
        $colors[1] = 200 + mt_rand(1,55);
        $colors[2]= 200 + mt_rand(1,55);

        return $colors;
    }

    /**
     * 獲取隨機顏色
     * @return array
     */
    private function getRandColor()
    {
        $red = mt_rand(1,254);
        $green = mt_rand(1,254);

        if($red + $green > 400){
            $blue = 0;
        }else{
            $blue = 400 -$green - $red;
        }
        return [$red,$green,$blue];
    }

    /**
     * 獲取隨機深色
     * @return array
     */
    private function getDeepColor()
    {
        list($red,$green,$blue) = $this->getRandColor();
        $increase  = 30 + mt_rand(1,254);

        $red = abs(min(255,abs($red - $increase)));
        $green = abs(min(255,abs($green - $increase)));
        $blue = abs(min(255,abs($blue - $increase)));

        return [$red,$green,$blue];
    }
}
