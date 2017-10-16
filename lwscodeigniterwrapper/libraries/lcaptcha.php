<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require_once 'lterbilang.php';

/**
 * CI Library
 * required GD
 * required session library
 * @author Lahir Wisada Santoso <lahirwisada@gmail.com>
 */
class Lcaptcha {

    public $word = '';
    public $img_path = '';
    public $img_url = '';
    public $img_id = 'lcaptcha_image_random';
    public $img_width = '150';
    public $img_height = '30';
    public $font_path = '';
    public $expiration = '7200';
    public $random_word = true;
    public $label = "Tulis Kembali";
    public $random_number;
    public $random_min = 12;
    public $random_max = 99;
    private $now;

    /**
     * Constructor
     *
     * @access	public
     */
    public function __construct($props = array()) {
        $this->initialize($props);
    }

    /**
     * Initialize preferences
     *
     * @param	array
     * @return	void
     */
    public function initialize($config = array()) {
        $defaults = array(
            'word' => '',
            'img_path' => '',
            'img_url' => '',
            'img_id' => 'lcaptcha_image_random',
            'font_path' => APPPATH.'libraries/lcaptcha/Mom.ttf',
            'expiration' => 7200,
            'random_word' => true,
            'random_min' => 20,
            'random_max' => 99,
        );


        foreach ($defaults as $key => $val) {
            if (isset($config[$key])) {
                $method = 'set_' . $key;
                if (method_exists($this, $method)) {
                    $this->$method($config[$key]);
                } else {
                    $this->$key = $config[$key];
                }
            } else {
                $this->$key = $val;
            }
        }

        if ($this->random_word) {
            $this->set_random_word();
        }
    }

    private function config_valid() {

        if ($this->img_path == '' OR $this->img_url == '') {
            return FALSE;
        }

        if (!@is_dir($this->img_path)) {
            return FALSE;
        }

        if (!is_writable($this->img_path)) {
            return FALSE;
        }

        if (!extension_loaded('gd')) {
            return FALSE;
        }
        return TRUE;
    }

    private function remove_old_image() {
        list($usec, $sec) = explode(" ", microtime());
        $this->now = ((float) $usec + (float) $sec);

        $current_dir = @opendir($this->img_path);

        while ($filename = @readdir($current_dir)) {
            if ($filename != "." and $filename != ".." and $filename != "index.html") {
                $name = str_replace(".jpg", "", $filename);
                if (($name + $this->expiration) < $this->now) {
                    @unlink($img_path . $filename);
                }
            }
        }

        @closedir($current_dir);
        return;
    }

    public function refresh() {
        $this->word = '';
        return $this->generate();
    }

    public function generate() {
//        var_dump("ok");exit;
        if ($this->config_valid()) {
            $this->remove_old_image();
            if ($this->word == '') {
                $this->set_random_word();
            }
            /**
             * Determine angle and position
             */
            $length = strlen($this->word);
            $angle = ($length >= 6) ? rand(-($length - 6), ($length - 6)) : 0;
            $use_font = ($this->font_path != '' AND file_exists($this->font_path) AND function_exists('imagettftext')) ? TRUE : FALSE;
            $maxsize = 14;
            $minheight = 0;
            $minwidth = 80;
            if ($use_font) {
                $box = @imageTTFBbox($maxsize, $angle, $this->font_path, $this->word);
                $minwidth = abs($box[4] - $box[0]);
                $minheight = abs($box[5] - $box[1]);
            }

            $this->img_width = $minwidth + 150;
            $this->img_height = $minheight + 30;


            $x_axis = rand(6, (360 / $length) - 16);
            $y_axis = ($angle >= 0 ) ? rand($this->img_height, $this->img_width) : rand(6, $this->img_height);

            /**
             * create image
             */
            if (function_exists('imagecreatetruecolor')) {
                $im = imagecreatetruecolor($this->img_width, $this->img_height);
            } else {
                $im = imagecreate($this->img_width, $this->img_height);
            }

            if (function_exists('imageantialias')) {
                imageantialias($im, true);
            }

            /**
             * assign color
             */
            $bg_color = imagecolorallocate($im, 255, 255, 255);
            $border_color = imagecolorallocate($im, 153, 102, 102);
            $text_color = imagecolorallocate($im, 255, 106, 106);
            $grid_color = imagecolorallocate($im, 255, 208, 208);

            /**
             * create image rectangle
             */
            ImageFilledRectangle($im, 0, 0, $this->img_width, $this->img_height, $bg_color);

            /**
             * write text
             */
            $x = 0;
            $rotate = 20;
            $y = 0;
            if ($use_font == FALSE) {
                $font_size = 5;
                $x = rand(0, $this->img_width / ($length / 3));
                $y = 0;
            } else {
                $x = rand(10, 25);
                $font_size = $maxsize;
                $y = ($minheight - abs($box[1])) + (($this->img_height - $minheight) / 2);
            }

            for ($i = 0; $i < strlen($this->word); $i++) {
                $clr_white = ImageColorAllocate($im, rand($bg_color, $bg_color + 200), rand($bg_color, $bg_color + 200), rand($bg_color, $bg_color + 200));

                $angle = rand(0 - $rotate, $rotate);
                $letter = substr($this->word, $i, 1);

                if ($use_font == FALSE) {
                    $y = rand(0, $this->img_height / 2);
                    imagestring($im, $font_size, $x, $y, $letter, $clr_white);
                    $x += ($font_size * 2);
                } else {
                    $size = rand($maxsize - 3, $maxsize);
                    $tempbox = @imageTTFBbox($size, $angle, $this->font_path, $letter);

                    $y = (abs($tempbox[5] - $tempbox[1])) +
                            (($this->img_height - abs($tempbox[5] - $tempbox[1])) / 2);

                    imagettftext($im, $size, $angle, $x, $y, $clr_white, $this->font_path, $letter);
                    $x += abs($tempbox[4] - $tempbox[0]);
                }
            }

            /**
             * generate image
             */
//            $img_name = $this->now . '.jpg';
            $img_name = $this->now;

            ImageJPEG($im, $this->img_path . $img_name);

            $img = "<img id=\"$this->img_id\" src=\"$this->img_url$img_name\" width=\"$this->img_width\" height=\"$this->img_height\" style=\"border:0;\" alt=\" \" />";

            ImageDestroy($im);

            return array('word' => $this->word, 'img_src'=>$this->img_url.$img_name, 'random_number' => $this->random_number, 'time' => $this->now, 'image' => $img);
        }
        return FALSE;
    }

    public function set_random_word() {
        $this->random_number = rand($this->random_min, $this->random_max);
        $terbilang = new Lterbilang();
        $this->word = $terbilang->convert_number_to_words($this->random_number);
        $this->label = "Tulis dengan angka.";
        unset($terbilang);
        return array("random_number" => $this->random_number, "random_word" => $this->word);
    }

    public function set_attribute($property, $value) {
        if (property_exists($this, $property)) {
            $this->$property = $value;
        }
        return;
    }

}
?>