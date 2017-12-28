<?php
class XskCheckCode{
	private $img_w = '90';
	private $img_h = '90';
	private $rnd_len = '4';
	private $rnd_type = 1; // 生成验证码的类型,1为字母,2为纯数字,3字母混合
	private $img_bgcolor = '#ffffff';
	private $img_bordercolor = '#6699CC';
	private $img_border = true;
	private $img_noisenum = 30;
	private $img_noise = true;

	public function __construct($img_w, $img_h, $len, $type, $noisenum=20, $bgcolor = '#ffffff', $bordercolor = '#6699CC')
	{
		$this->img_w = $img_w;
		$this->img_h = $img_h;
		$this->rnd_len = $len;
		$this->rnd_type = $type;
		$this->img_bgcolor = $bgcolor;
		$this->img_bordercolor = $bordercolor;
		$this->img_noisenum = $noisenum;
	}

	public function createCheckImg()
	{
		!$this->img_w && $this->img_w = $this->rnd_len * $this->img_noisenum * 4 / 5 + 5;
		!$this->img_h && $this->img_h = $this->img_noisenum + 10; 
		// 去掉了 0 1 O l 等
		$strarr = array(
				0=>array('23456789',0),
				);
		$str = $strarr[0][0];
		
		$font = array(
				0=>array('name' => __DIR__ . '/font/NiseSonicShuffle.TTF','x'=>$strarr[$strkey][1], 'y'=>8),
				);
		$fontkey = 0;
		
		// 画图像
		$im = imagecreatetruecolor($this->img_w, $this->img_h); 
		// 定义要用到的颜色
		$back_color = imagecolorallocate($im, 255, 255, 255);
// 		$boer_color = imagecolorallocate($im, 118, 151, 199);
		$text_color = imagecolorallocate($im, mt_rand(0, 200), mt_rand(0, 120), mt_rand(0, 120)); 
		// 画背景
		imagefilledrectangle($im, 0, 0, $this->img_w, $this->img_h, $back_color); 
		// 画边框
// 		imagerectangle($im, 0, 0, $this->img_w-1, $this->img_h-1, $boer_color); 
		// 画干扰线
		for($i = 0;$i < 3;$i++) {
			$font_color = imagecolorallocate($im, mt_rand(0, 255), mt_rand(0, 255), mt_rand(0, 255));
			imagearc($im, mt_rand(-$this->img_w, $this->img_w), mt_rand($this->img_h, $this->img_h), mt_rand(30, $this->img_w * 2), mt_rand(20, $this->img_h * 2), mt_rand(0, 360), mt_rand(0, 360), $font_color);
		} 
		// 画干扰点
		for($i = 0;$i < 50;$i++) {
			$font_color = imagecolorallocate($im, mt_rand(0, 255), mt_rand(0, 255), mt_rand(0, 255));
			imagesetpixel($im, mt_rand(0, $this->img_w), mt_rand(0, $this->img_h), $font_color);
		} 

		$code = '';
		$x = rand(0, 5);
		for ($i = 0; $i < $this->rnd_len; $i++) {
			$tem = $str[mt_rand(0, strlen($str)-1)];
			// 画验证码
			imagefttext($im, $this->img_noisenum , 0, $font[$fontkey]['x'] + $x, $this->img_noisenum + $font[$fontkey]['y'], $text_color, $font[$fontkey]['name'], $tem);
			$x+=rand(18,28);
			$code .= $tem;
		}
		
		$_SESSION["xsk_code"]=$code; 
		header("Cache-Control: max-age=1, s-maxage=1, no-cache, must-revalidate");
		header("Content-type: image/png;charset=utf-8");
		imagepng($im);
		imagedestroy($im);
	}
}
?>