<?php

//defined('BASEPATH') OR exit('No direct script access allowed');

// Load the files we need:
use PhpOffice\PhpWord\Autoloader;
use PhpOffice\PhpWord\Settings;
use PhpOffice\PhpWord\IOFactory;

require_once 'PhpWord/Autoloader.php';
require_once 'simplehtmldom/simple_html_dom.php';
require_once 'htmltodocx_converter/h2d_htmlconverter.php';
require_once 'style/styles.inc';

// Functions to support this example.
require_once 'documentation/support_functions.inc';

/**
 * @author Lahir Wisada Santoso <lahirwisada@gmail.com>
 */
class lwphpword {

    public $php_word_object = FALSE;
    public $save_path = FALSE;
    public $expiration = '7200';
    public $app_path = FALSE;
    public $document = FALSE;
    protected $html_string = "";
    protected $html_dom = FALSE;
    private $path = array();
    private $now;
    private $initial_state = array(
        // Required parameters:
        'phpword_object'                  => FALSE, // Must be passed by reference.
        // 'base_root' => 'http://test.local', // Required for link elements - change it to your domain.
        // 'base_path' => '/htmltodocx/documentation/', // Path from base_root to whatever url your links are relative to.
        'base_root'                       => FALSE,
        'base_path'                       => FALSE,
        // Optional parameters - showing the defaults if you don't set anything:
        'current_style'                   => array('size' => '11'), // The PHPWord style on the top element - may be inherited by descendent elements.
        'parents'                         => array(0 => 'body'), // Our parent is body.
        'list_depth'                      => 0, // This is the current depth of any current list.
        'context'                         => 'section', // Possible values - section, footer or header.
        'pseudo_list'                     => TRUE, // NOTE: Word lists not yet supported (TRUE is the only option at present).
        'pseudo_list_indicator_font_name' => 'Wingdings', // Bullet indicator font.
        'pseudo_list_indicator_font_size' => '7', // Bullet indicator size.
        'pseudo_list_indicator_character' => 'l ', // Gives a circle bullet point with wingdings.
        'table_allowed'                   => TRUE, // Note, if you are adding this html into a PHPWord table you should set this to FALSE: tables cannot be nested in PHPWord.
        'treat_div_as_paragraph'          => TRUE, // If set to TRUE, each new div will trigger a new line in the Word document.
        // Optional - no default:    
        'style_sheet'                     => FALSE, // This is an array (the "style sheet") - returned by htmltodocx_styles_example() here (in styles.inc) - see this function for an example of how to construct this array.
    );

    public function __construct($app_path = FALSE) {

        if (is_array($app_path)) {
            $this->app_path = $app_path;
        }

        $this->init();
    }

    private function deploy_initial_state() {
        $this->initial_state["phpword_object"] = $this->php_word_object;
        $this->initial_state["base_path"] = $this->get_path("base_path");
        $this->initial_state["base_root"] = $this->get_path("base_root");

        $this->initial_state["style_sheet"] = htmltodocx_styles_example();
    }

    private function init_path() {
        if ($this->app_path) {
            $this->path = $this->app_path;
            return;
        }
        $this->path = htmltodocx_paths();
        return;
    }

    public function get_path($key = FALSE) {
        if (empty($this->path)) {
            $this->init_path();
        }
        if (!$key) {
            return $this->path;
        }

        if (array_key_exists($key, $this->path)) {
            return $this->path[$key];
        }
        return FALSE;
    }

    private function init() {

        Autoloader::register();
        Settings::loadConfig();

        /* create php_word_object */
        if (!$this->php_word_object) {
            $this->php_word_object = new PhpOffice\PhpWord\PhpWord();
        }

        /* create simple html dom object */
        if (!$this->html_dom) {
            $this->html_dom = new simple_html_dom();
        }

        /* path */
        $this->path = $this->get_path();

        $this->deploy_initial_state();
    }

    public function set_html_string($html_string = "") {
        $this->html_string = $html_string;
    }

    public function load_template($location = FALSE, $image_replace = array()) {
        if (!$location) {
            return FALSE;
        }
        $this->document = $this->php_word_object->loadTemplate($location, $image_replace);
        return TRUE;
    }

    public function set_value($key = FALSE, $value = FALSE) {
        if (!$key || !$value) {
            return FALSE;
        }

        $this->document->setValue($key, $value);
        return TRUE;
    }
    
    public function set_image_value($searchimage = FALSE, $valueimage = FALSE) {
        $this->document->setImageValue($searchimage, $valueimage);
        return TRUE;
    }

    public function clone_block($key_template = FALSE, $number_of_rows = FALSE) {
        if ($number_of_rows == FALSE || $key_template == FALSE) {
            return FALSE;
        }

        $this->document->cloneBlock($key_template, $number_of_rows);
        return TRUE;
    }

    public function clone_row($key_template = FALSE, $number_of_rows = FALSE) {
        if ($number_of_rows == FALSE || $key_template == FALSE) {
            return FALSE;
        }

        $this->document->cloneRow($key_template, $number_of_rows);
        return TRUE;
    }
    
    public function remove_table_row($key_template = FALSE){
        if ($key_template == FALSE) {
            return FALSE;
        }
        
        $this->document->removeTableRow($key_template);
        return TRUE;
    }

    public function download($document_path = FALSE, $output_filename = 'document', $as = 'word') {
        if (!$document_path) {
            return FALSE;
        }
        header('Content-Description: File Transfer');
        $ext = '.docx';
        if ($as == 'pdf') {
            header('Content-Type: application/pdf');
            $ext = '.pdf';
        }else{
            header('Content-Type: application/octet-stream');
        }
        header('Content-Disposition: attachment; filename=' . $output_filename . $ext);
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Pragma: public');
        header('Content-Length: ' . filesize($document_path));
        readfile($document_path);
    }

    public function save_document($download = TRUE, $prefix = '', $return_detail = FALSE) {
        $this->remove_old_document();
        list($usec, $sec) = explode(" ", microtime());
        $this->now = ((float) $usec + (float) $sec);
        $document_name = $this->now;
        if (!$this->document || !$this->save_path) {
            return FALSE;
        }
        if ($prefix != '') {
            $prefix .= '_';
        }
        $document_path = $this->path['base_path'] . $prefix . $document_name . '.docx';
        $this->document->saveAs($document_name . '.docx');
        rename($document_name . '.docx', $document_path);

        if (!$return_detail) {
            return $document_path;
        }
        return (object) array(
                    "document_name" => $document_name,
                    "document_path" => $document_path
        );
    }

    public function save_to_pdf($prefix = '') {
        $document_detail = $this->save_document(FALSE, $prefix, TRUE);

        //Load temp file
        $phpWord = \PhpOffice\PhpWord\IOFactory::load($document_detail->document_path);

        PhpOffice\PhpWord\Settings::setPdfRendererName('TCPDF');
        $PDFlib_path = LWSPATH . 'libraries/tcpdf';
        PhpOffice\PhpWord\Settings::setPdfRendererPath($PDFlib_path);

        $pdf_name = $document_path = $this->path['base_path'] . $prefix . $document_detail->document_name . ".pdf";

        $xmlWriter = PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'PDF');
        $xmlWriter->save($pdf_name);
        return $pdf_name;
    }

    private function remove_old_document() {
        list($usec, $sec) = explode(" ", microtime());
        $this->now = ((float) $usec + (float) $sec);

        $current_dir = @opendir($this->save_path);

        while ($filename = @readdir($current_dir)) {
            if ($filename != "." and $filename != ".." and $filename != "index.html") {
                $name = str_replace(".docx", "", $filename);
                if (($name + $this->expiration) < $this->now) {
                    @unlink($save_path . $filename);
                }
            }
        }

        @closedir($current_dir);
        return;
    }

    public function create_document($html_string = FALSE, $output_filename = "dokumen.docx") {

        if ($html_string != FALSE) {
            $this->set_html_string($html_string);
        }

        $section = $this->php_word_object->createSection();
        $this->html_dom->load('<html><body>' . $this->html_string . '</body></html>');
        $html_dom_array = $this->html_dom->find('html', 0)->children();

        /* Convert the HTML and put it into the PHPWord object */
        htmltodocx_insert_html($section, $html_dom_array[0]->nodes, $this->initial_state);

        // Clear the HTML dom object:
        $this->html_dom->clear();
        unset($html_dom);

// Save File
        $h2d_file_uri = tempnam('', 'htd');
        $objWriter = IOFactory::createWriter($this->php_word_object, 'Word2007');
        $objWriter->save($h2d_file_uri);

        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=' . $output_filename);
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Pragma: public');
        header('Content-Length: ' . filesize($h2d_file_uri));
        ob_clean();
        flush();
        $status = readfile($h2d_file_uri);
        unlink($h2d_file_uri);
        return;
    }

}

?>