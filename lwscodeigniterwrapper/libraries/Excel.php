<?php

class Excel {

    private $excel;

    public function __construct() {
        // initialise the reference to the codeigniter instance
        require_once 'PHPExcel/PHPExcel.php';
        $this->excel = new PHPExcel();
    }

    public function load($path, $auto_detect = FALSE) {
        $reader_type = 'Excel5';
        if ($auto_detect) {
            $reader_type = PHPExcel_IOFactory::identify($path);
        }

        $objReader = PHPExcel_IOFactory::createReader($reader_type);
        $this->excel = $objReader->load($path);
    }

    public function get_properties() {
        return $this->excel->getProperties();
    }

    public function get_active_sheet($to_array = FALSE) {
        if ($to_array) {
            return $this->excel->getActiveSheet()->toArray(null, true, true, true);
        }
        return $this->excel->getActiveSheet();
    }

    public function setActiveSheetIndexByName($sheet_name = '') {
        try {
            return $this->excel->setActiveSheetIndexByName($sheet_name);
        } catch (PHPExcel_Exception $excel_exception) {
            /**
             * Sheet Not Found
             */
            return FALSE;
        }
    }

    public function save($path) {
        // Write out as the new file
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
        $objWriter->save($path);
    }

    public function stream($filename) {
        header('Content-type: application/ms-excel');
        header("Content-Disposition: attachment; filename=\"" . $filename . "\"");
        header("Cache-control: private");
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
        $objWriter->save('php://output');
    }

    public function __call($name, $arguments) {
        // make sure our child object has this method  
        if (method_exists($this->excel, $name)) {
            // forward the call to our child object  
            return call_user_func_array(array($this->excel, $name), $arguments);
        }
        return null;
    }

}

?>