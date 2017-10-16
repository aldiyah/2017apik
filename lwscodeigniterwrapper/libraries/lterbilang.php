<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/**
 * CI Library
 * required lang_helper to call t function -> t()
 */

class Lterbilang {

    private $_dictionary = array(
        0 => 'zero',
        1 => 'one',
        2 => 'two',
        3 => 'three',
        4 => 'four',
        5 => 'five',
        6 => 'six',
        7 => 'seven',
        8 => 'eight',
        9 => 'nine',
        10 => 'ten',
        11 => 'eleven',
        12 => 'twelve',
        13 => 'thirteen',
        14 => 'fourteen',
        15 => 'fifteen',
        16 => 'sixteen',
        17 => 'seventeen',
        18 => 'eighteen',
        19 => 'nineteen',
        20 => 'twenty',
        30 => 'thirty',
        40 => 'fourty',
        50 => 'fifty',
        60 => 'sixty',
        70 => 'seventy',
        80 => 'eighty',
        90 => 'ninety',
        100 => 'hundred',
        1000 => 'thousand',
        1000000 => 'million',
        1000000000 => 'billion',
        1000000000000 => 'trillion',
        1000000000000000 => 'quadrillion',
        1000000000000000000 => 'quintillion'
    );
    public $_special_dictionary = array(
        'less_than_200' => "seratus",
        'less_than_2000' => "seribu"
    );
    public $_conjunction = ' and ';
    public $_negative = ' negative ';
    public $_decimal = ' point ';
    public $hyphen = '-';
    public $separator = ', ';
    public $dictionary;
    public $conjunction;
    public $negative;
    public $decimal;
    public $error_msg = array();

    public function __construct() {
        $this->initialize();
    }

    private function initialize() {
        foreach ($this->_dictionary as $key => $number_word) {
            $this->dictionary[$key] = t("lterbilang_" . $key, 'lterbilang');
        }

        foreach ($this->_special_dictionary as $key => $number_word) {
            $this->dictionary[$key] = t("lterbilang_" . $key, 'lterbilang');
        }

        $this->conjunction = t('lterbilang_conjunction', 'lterbilang');
        $this->negative = t('lterbilang_negative', 'lterbilang');
        $this->decimal = t('lterbilang_decimal', 'lterbilang');
        $this->hyphen = t('lterbilang_hyphen', 'lterbilang');
        $this->separator = t('lterbilang_separator', 'lterbilang');
    }

    public function convert_number_to_words($number) {
        if (!is_numeric($number)) {
            return false;
        }

        if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
            // overflow
            $this->set_error('error_integer');
            return false;
        }

        if ($number < 0) {
            return $this->negative . $this->convert_number_to_words(abs($number));
        }

        $string = $fraction = null;

        if (strpos($number, '.') !== false) {
            list($number, $fraction) = explode('.', $number);
        }

        switch (true) {
            case $number < 21:
                $string = $this->dictionary[$number];
                break;
            case $number < 100:
                $tens = ((int) ($number / 10)) * 10;
                $units = $number % 10;
                $string = $this->dictionary[$tens];
                if ($units) {
                    $string .= $this->hyphen . $this->dictionary[$units];
                }
                break;
            case $number < 1000:
                $hundreds = $number / 100;
                $remainder = $number % 100;
                if ($number < 200) {
                    $string = $this->dictionary["less_than_200"];
                } else {
                    $string = $this->dictionary[$hundreds] . ' ' . $this->dictionary[100];
                }
                if ($remainder) {
                    $string .= $this->conjunction . $this->convert_number_to_words($remainder);
                }
                break;
            default:
                $baseUnit = pow(1000, floor(log($number, 1000)));
                $numBaseUnits = (int) ($number / $baseUnit);
//                var_dump($baseUnit, $numBaseUnits);exit;
                $remainder = $number % $baseUnit;
                if (($numBaseUnits * 1000) < 2000) {
                    $string = $this->dictionary["less_than_2000"];
                } else {
                    $string = $this->convert_number_to_words($numBaseUnits) . ' ' . $this->dictionary[$baseUnit];
                }
                if ($remainder) {
                    $string .= $remainder < 100 ? $this->conjunction : $this->separator;
                    $string .= $this->convert_number_to_words($remainder);
                }
                break;
        }

        if (null !== $fraction && is_numeric($fraction)) {
            $string .= $this->decimal;
            $words = array();
            foreach (str_split((string) $fraction) as $number) {
                $words[] = $this->dictionary[$number];
            }
            $string .= implode(' ', $words);
        }

        return $string;
    }

    public function set_error($msg) {

        if (is_array($msg)) {
            foreach ($msg as $val) {
                $msg = (t('lterbilang_' . $val, 'lterbilang') == FALSE) ? $val : t('lterbilang_' . $val, 'lterbilang');
                $this->error_msg[] = $msg;
                log_message('error', $msg);
            }
        } else {
            $msg = (t('lterbilang_' . $msg, 'lterbilang') == FALSE) ? $msg : t('lterbilang_' . $msg, 'lterbilang');
            $this->error_msg[] = $msg;
            log_message('error', $msg);
        }
    }

}
?>