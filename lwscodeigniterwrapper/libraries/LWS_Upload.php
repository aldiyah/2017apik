<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class LWS_Upload extends CI_Upload {
    
    public $ignore_mime_check = FALSE;

    /**
     * Constructor
     *
     * @access	public
     */
    public function __construct($props = array()) {
        parent::__construct($props);
        
        if(array_key_exists("ignore_mime_check", $props)){
            $this->ignore_mime_check = $props["ignore_mime_check"];
        }
    }

// --------------------------------------------------------------------

    /**
     * Perform the file upload
     *
     * @return	bool
     */
    public function do_upload($field = 'userfile') {

// Is $_FILES[$field] set? If not, no reason to continue.
        if (!isset($_FILES[$field])) {
            $this->set_error('upload_no_file_selected');
            return FALSE;
        }

// Is the upload path valid?
        if (!$this->validate_upload_path()) {
// errors will already be set by validate_upload_path() so just return FALSE
            return FALSE;
        }

// Was the file able to be uploaded? If not, determine the reason why.
        if (!is_uploaded_file($_FILES[$field]['tmp_name'])) {
            $error = (!isset($_FILES[$field]['error'])) ? 4 : $_FILES[$field]['error'];

            switch ($error) {
                case 1: // UPLOAD_ERR_INI_SIZE
                    $this->set_error('upload_file_exceeds_limit');
                    break;
                case 2: // UPLOAD_ERR_FORM_SIZE
                    $this->set_error('upload_file_exceeds_form_limit');
                    break;
                case 3: // UPLOAD_ERR_PARTIAL
                    $this->set_error('upload_file_partial');
                    break;
                case 4: // UPLOAD_ERR_NO_FILE
                    $this->set_error('upload_no_file_selected');
                    break;
                case 6: // UPLOAD_ERR_NO_TMP_DIR
                    $this->set_error('upload_no_temp_directory');
                    break;
                case 7: // UPLOAD_ERR_CANT_WRITE
                    $this->set_error('upload_unable_to_write_file');
                    break;
                case 8: // UPLOAD_ERR_EXTENSION
                    $this->set_error('upload_stopped_by_extension');
                    break;
                default : $this->set_error('upload_no_file_selected');
                    break;
            }

            return FALSE;
        }


// Set the uploaded data as class variables
        $this->file_temp = $_FILES[$field]['tmp_name'];
        $this->file_size = $_FILES[$field]['size'];
        $this->_file_mime_type($_FILES[$field]);
        $this->file_type = preg_replace("/^(.+?);.*$/", "\\1", $this->file_type);
        $this->file_type = strtolower(trim(stripslashes($this->file_type), '"'));
        $this->file_name = $this->_prep_filename($_FILES[$field]['name']);
        $this->file_ext = $this->get_extension($this->file_name);
        $this->client_name = $this->file_name;

// Is the file type allowed to be uploaded?
        if (!$this->is_allowed_filetype($this->ignore_mime_check)) {
            $this->set_error('upload_invalid_filetype');
            return FALSE;
        }

// if we're overriding, let's now make sure the new name and type is allowed
        if ($this->_file_name_override != '') {
            $this->file_name = $this->_prep_filename($this->_file_name_override);

// If no extension was provided in the file_name config item, use the uploaded one
            if (strpos($this->_file_name_override, '.') === FALSE) {
                $this->file_name .= $this->file_ext;
            }

// An extension was provided, lets have it!
            else {
                $this->file_ext = $this->get_extension($this->_file_name_override);
            }

            if (!$this->is_allowed_filetype(TRUE)) {
                $this->set_error('upload_invalid_filetype');
                return FALSE;
            }
        }

// Convert the file size to kilobytes
        if ($this->file_size > 0) {
            $this->file_size = round($this->file_size / 1024, 2);
        }

// Is the file size within the allowed maximum?
        if (!$this->is_allowed_filesize()) {
            $this->set_error('upload_invalid_filesize');
            return FALSE;
        }

// Are the image dimensions within the allowed size?
// Note: This can fail if the server has an open_basdir restriction.
        if (!$this->is_allowed_dimensions()) {
            $this->set_error('upload_invalid_dimensions');
            return FALSE;
        }

// Sanitize the file name for security
        $this->file_name = $this->clean_file_name($this->file_name);

// Truncate the file name if it's too long
        if ($this->max_filename > 0) {
            $this->file_name = $this->limit_filename_length($this->file_name, $this->max_filename);
        }

// Remove white spaces in the name
        if ($this->remove_spaces == TRUE) {
            $this->file_name = preg_replace("/\s+/", "_", $this->file_name);
        }

        /*
         * Validate the file name
         * This function appends an number onto the end of
         * the file if one with the same name already exists.
         * If it returns false there was a problem.
         */
        $this->orig_name = $this->file_name;

        if ($this->overwrite == FALSE) {
            $this->file_name = $this->set_filename($this->upload_path, $this->file_name);

            if ($this->file_name === FALSE) {
                return FALSE;
            }
        }

        /*
         * Run the file through the XSS hacking filter
         * This helps prevent malicious code from being
         * embedded within a file.  Scripts can easily
         * be disguised as images or other file types.
         */
        if ($this->xss_clean) {
            if ($this->do_xss_clean() === FALSE) {
                $this->set_error('upload_unable_to_write_file');
                return FALSE;
            }
        }

        /*
         * Move the file to the final destination
         * To deal with different server configurations
         * we'll attempt to use copy() first.  If that fails
         * we'll use move_uploaded_file().  One of the two should
         * reliably work in most environments
         */
        if (!@copy($this->file_temp, $this->upload_path . $this->file_name)) {
            if (!@move_uploaded_file($this->file_temp, $this->upload_path . $this->file_name)) {
                $this->set_error('upload_destination_error');
                return FALSE;
            }
        }

        /*
         * Set the finalized image dimensions
         * This sets the image width/height (assuming the
         * file was an image).  We use this information
         * in the "data" function.
         */
        $this->set_image_properties($this->upload_path . $this->file_name);

        return TRUE;
    }

// --------------------------------------------------------------------

    /**
     * Validate the image
     *
     * @return	bool
     */
    public function is_image() {
// IE will sometimes return odd mime-types during upload, so here we just standardize all
// jpegs or pngs to the same file type.

        $png_mimes = array('image/x-png');
        $jpeg_mimes = array('image/jpg', 'image/jpe', 'image/jpeg', 'image/pjpeg');

        if (in_array($this->file_type, $png_mimes)) {
            $this->file_type = 'image/png';
        }

        if (in_array($this->file_type, $jpeg_mimes)) {
            $this->file_type = 'image/jpeg';
        }

        $img_mimes = array(
            'image/gif',
            'image/jpeg',
            'image/png',
        );

        return (in_array($this->file_type, $img_mimes, TRUE)) ? TRUE : FALSE;
    }

// --------------------------------------------------------------------

    /**
     * Verify that the filetype is allowed
     *
     * @return	bool
     */
    public function is_allowed_filetype($ignore_mime = FALSE) {

        if ($this->allowed_types == '*') {
            return TRUE;
        }

        if (count($this->allowed_types) == 0 OR ! is_array($this->allowed_types)) {
            $this->set_error('upload_no_file_types');
            return FALSE;
        }

        $ext = strtolower(ltrim($this->file_ext, '.'));

        if (!in_array($ext, $this->allowed_types)) {
            return FALSE;
        }

        if ($ignore_mime === TRUE) {
            return TRUE;
        }

        $mime = $this->mimes_types($ext);

        if (is_array($mime)) {
            if (in_array($this->file_type, $mime, TRUE)) {
                return TRUE;
            }
        } elseif ($mime == $this->file_type) {
            return TRUE;
        }

        return FALSE;
    }

// --------------------------------------------------------------------

    /**
     * Verify that the file is within the allowed size
     *
     * @return	bool
     */
    public function is_allowed_filesize() {
        if ($this->max_size != 0 AND $this->file_size > $this->max_size) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

// --------------------------------------------------------------------

    /**
     * Verify that the image is within the allowed width/height
     *
     * @return	bool
     */
    public function is_allowed_dimensions() {
        if (!$this->is_image()) {
            return TRUE;
        }

        if (function_exists('getimagesize')) {
            $D = @getimagesize($this->file_temp);

            if ($this->max_width > 0 AND $D['0'] > $this->max_width) {
                return FALSE;
            }

            if ($this->max_height > 0 AND $D['1'] > $this->max_height) {
                return FALSE;
            }

            return TRUE;
        }

        return TRUE;
    }

// --------------------------------------------------------------------

    /**
     * File MIME type
     *
     * Detects the (actual) MIME type of the uploaded file, if possible.
     * The input array is expected to be $_FILES[$field]
     *
     * @param	array
     * @return	void
     */
    protected function _file_mime_type($file) {
// We'll need this to validate the MIME info string (e.g. text/plain; charset=us-ascii)
        $regexp = '/^([a-z\-]+\/[a-z0-9\-\.\+]+)(;\s.+)?$/';

        /* Fileinfo extension - most reliable method
         *
         * Unfortunately, prior to PHP 5.3 - it's only available as a PECL extension and the
         * more convenient FILEINFO_MIME_TYPE flag doesn't exist.
         */
        if (function_exists('finfo_file')) {
            $finfo = finfo_open(FILEINFO_MIME);
            if (is_resource($finfo)) { // It is possible that a FALSE value is returned, if there is no magic MIME database file found on the system
                $mime = @finfo_file($finfo, $file['tmp_name']);
                finfo_close($finfo);

                /* According to the comments section of the PHP manual page,
                 * it is possible that this function returns an empty string
                 * for some files (e.g. if they don't exist in the magic MIME database)
                 */
                if (is_string($mime) && preg_match($regexp, $mime, $matches)) {
                    $this->file_type = $matches[1];
                    return;
                }
            }
        }

        /* This is an ugly hack, but UNIX-type systems provide a "native" way to detect the file type,
         * which is still more secure than depending on the value of $_FILES[$field]['type'], and as it
         * was reported in issue #750 (https://github.com/EllisLab/CodeIgniter/issues/750) - it's better
         * than mime_content_type() as well, hence the attempts to try calling the command line with
         * three different functions.
         *
         * Notes:
         * 	- the DIRECTORY_SEPARATOR comparison ensures that we're not on a Windows system
         * 	- many system admins would disable the exec(), shell_exec(), popen() and similar functions
         * 	  due to security concerns, hence the function_exists() checks
         */
        if (DIRECTORY_SEPARATOR !== '\\') {
            $cmd = 'file --brief --mime ' . escapeshellarg($file['tmp_name']) . ' 2>&1';

            if (function_exists('exec')) {
                /* This might look confusing, as $mime is being populated with all of the output when set in the second parameter.
                 * However, we only neeed the last line, which is the actual return value of exec(), and as such - it overwrites
                 * anything that could already be set for $mime previously. This effectively makes the second parameter a dummy
                 * value, which is only put to allow us to get the return status code.
                 */
                $mime = @exec($cmd, $mime, $return_status);
                if ($return_status === 0 && is_string($mime) && preg_match($regexp, $mime, $matches)) {
                    $this->file_type = $matches[1];
                    return;
                }
            }

            if ((bool) @ini_get('safe_mode') === FALSE && function_exists('shell_exec')) {
                $mime = @shell_exec($cmd);
                if (strlen($mime) > 0) {
                    $mime = explode("\n", trim($mime));
                    if (preg_match($regexp, $mime[(count($mime) - 1)], $matches)) {
                        $this->file_type = $matches[1];
                        return;
                    }
                }
            }

            if (function_exists('popen')) {
                $proc = @popen($cmd, 'r');
                if (is_resource($proc)) {
                    $mime = @fread($proc, 512);
                    @pclose($proc);
                    if ($mime !== FALSE) {
                        $mime = explode("\n", trim($mime));
                        if (preg_match($regexp, $mime[(count($mime) - 1)], $matches)) {
                            $this->file_type = $matches[1];
                            return;
                        }
                    }
                }
            }
        }

// Fall back to the deprecated mime_content_type(), if available (still better than $_FILES[$field]['type'])
        if (function_exists('mime_content_type')) {
            $this->file_type = @mime_content_type($file['tmp_name']);
            if (strlen($this->file_type) > 0) { // It's possible that mime_content_type() returns FALSE or an empty string
                return;
            }
        }
        $this->file_type = $file['type'];
    }

// --------------------------------------------------------------------
}

// END Upload Class

/* End of file Upload.php */
/* Location: ./system/libraries/Upload.php */
