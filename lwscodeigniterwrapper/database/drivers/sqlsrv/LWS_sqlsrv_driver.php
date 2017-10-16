<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 5.1.6 or newer
 *
 * @package		CodeIgniter
 * @author		EllisLab Dev Team
 * @copyright		Copyright (c) 2008 - 2014, EllisLab, Inc.
 * @copyright		Copyright (c) 2014 - 2015, British Columbia Institute of Technology (http://bcit.ca/)
 * @license		http://codeigniter.com/user_guide/license.html
 * @link		http://codeigniter.com
 * @since		Version 1.0
 * @filesource
 */
// ------------------------------------------------------------------------

/**
 * SQLSRV Database Adapter Class
 *
 * Note: _DB is an extender class that the app controller
 * creates dynamically based on whether the active record
 * class is being used or not.
 *
 * @package		CodeIgniter
 * @subpackage	Drivers
 * @category	Database
 * @author		EllisLab Dev Team
 * @link		http://codeigniter.com/user_guide/database/
 */

/**
 * SQLSRV Enabling pconnect
 * @author Lahir Wisada <lahirwisada@gmail.com>
 */
class LWS_DB_sqlsrv_driver extends CI_DB_sqlsrv_driver {

    /**
     * ORDER BY random keyword
     *
     * @var	array
     */
    public $_random_keyword = array('NEWID()', 'RAND(%d)');

    /**
     * Quoted identifier flag
     *
     * Whether to use SQL-92 standard quoted identifier
     * (double quotes) or brackets for identifier escaping.
     *
     * @var	bool
     */
    protected $_quoted_identifier = TRUE;

    /**
     * Scrollable flag
     *
     * Determines what cursor type to use when executing queries.
     *
     * FALSE or SQLSRV_CURSOR_FORWARD would increase performance,
     * but would disable num_rows() (and possibly insert_id())
     *
     * @var	mixed
     */
    public $scrollable;

    public function __construct($params) {
        parent::__construct($params);
        // This is only supported as of SQLSRV 3.0
        if ($this->scrollable === NULL) {
            $this->scrollable = defined('SQLSRV_CURSOR_CLIENT_BUFFERED') ? SQLSRV_CURSOR_CLIENT_BUFFERED : FALSE;
        }
    }

    /**
     * Escape the SQL Identifiers
     *
     * This function escapes column and table names
     *
     * @param	mixed
     * @return	mixed
     */
    public function escape_identifiers($item) {
        if ($this->_escape_char === '' OR empty($item) OR in_array($item, $this->_reserved_identifiers)) {
            return $item;
        } elseif (is_array($item)) {
            foreach ($item as $key => $value) {
                $item[$key] = $this->escape_identifiers($value);
            }
            return $item;
        }
        // Avoid breaking functions and literal values inside queries
        elseif (ctype_digit($item) OR $item[0] === "'" OR ( $this->_escape_char !== '"' && $item[0] === '"') OR strpos($item, '(') !== FALSE) {
            return $item;
        }
        static $preg_ec = array();
        if (empty($preg_ec)) {
            if (is_array($this->_escape_char)) {
                $preg_ec = array(
                    preg_quote($this->_escape_char[0], '/'),
                    preg_quote($this->_escape_char[1], '/'),
                    $this->_escape_char[0],
                    $this->_escape_char[1]
                );
            } else {
                $preg_ec[0] = $preg_ec[1] = preg_quote($this->_escape_char, '/');
                $preg_ec[2] = $preg_ec[3] = $this->_escape_char;
            }
        }
        foreach ($this->_reserved_identifiers as $id) {
            if (strpos($item, '.' . $id) !== FALSE) {
                return preg_replace('/' . $preg_ec[0] . '?([^' . $preg_ec[1] . '\.]+)' . $preg_ec[1] . '?\./i', $preg_ec[2] . '$1' . $preg_ec[3] . '.', $item);
            }
        }
        return preg_replace('/' . $preg_ec[0] . '?([^' . $preg_ec[1] . '\.]+)' . $preg_ec[1] . '?(\.)?/i', $preg_ec[2] . '$1' . $preg_ec[3] . '$2', $item);
    }

    /**
     * Persistent database connection
     *
     * @access	private called by the base class
     * @return	resource
     */
    function db_pconnect() {
        return $this->db_connect(TRUE);
    }

    /**
     * Database connection
     *
     * @param	bool	$pooling
     * @return	resource
     */
    public function db_connect($pooling = FALSE) {
        $charset = in_array(strtolower($this->char_set), array('utf-8', 'utf8'), TRUE) ? 'UTF-8' : SQLSRV_ENC_CHAR;
        $connection = array(
            'UID' => empty($this->username) ? '' : $this->username,
            'PWD' => empty($this->password) ? '' : $this->password,
            'Database' => $this->database,
            'ConnectionPooling' => ($pooling === TRUE) ? 1 : 0,
            'CharacterSet' => $charset,
            'Encrypt' => (isset($this->encrypt) && $this->encrypt === TRUE) ? 1 : 0,
            'ReturnDatesAsStrings' => 1
        );
        // If the username and password are both empty, assume this is a
        // 'Windows Authentication Mode' connection.
        if (empty($connection['UID']) && empty($connection['PWD'])) {
            unset($connection['UID'], $connection['PWD']);
        }
        if (FALSE !== ($this->conn_id = sqlsrv_connect($this->hostname, $connection))) {
            // Determine how identifiers are escaped
            $query = $this->query('SELECT CASE WHEN (@@OPTIONS | 256) = @@OPTIONS THEN 1 ELSE 0 END AS qi');
            $query = $query->row_array();
            $this->_quoted_identifier = empty($query) ? FALSE : (bool) $query['qi'];
            $this->_escape_char = ($this->_quoted_identifier) ? '"' : array('[', ']');
        }
        return $this->conn_id;
    }

    /**
     * Select the database
     *
     * @param	string	$database
     * @return	bool
     */
    public function db_select($database = '') {
        if ($database === '') {
            $database = $this->database;
        }
        if ($this->_execute('USE ' . $this->escape_identifiers($database))) {
            $this->database = $database;
            return TRUE;
        }
        return FALSE;
    }

    /**
     * Execute the query
     *
     * @param	string	$sql	an SQL query
     * @return	resource
     */
    public function _execute($sql) {
        return ($this->scrollable === FALSE OR $this->is_write_type($sql)) ? sqlsrv_query($this->conn_id, $sql) : sqlsrv_query($this->conn_id, $sql, NULL, array('Scrollable' => $this->scrollable));
    }

    /**
     * Begin Transaction
     *
     * @return	bool
     */
    protected function _trans_begin() {
        return sqlsrv_begin_transaction($this->conn_id);
    }

    // --------------------------------------------------------------------
    /**
     * Commit Transaction
     *
     * @return	bool
     */
    protected function _trans_commit() {
        return sqlsrv_commit($this->conn_id);
    }

    /**
     * Rollback Transaction
     *
     * @return	bool
     */
    protected function _trans_rollback() {
        return sqlsrv_rollback($this->conn_id);
    }

    // --------------------------------------------------------------------
    /**
     * Affected Rows
     *
     * @return	int
     */
    public function affected_rows() {
        return sqlsrv_rows_affected($this->result_id);
    }

    /**
     * Insert ID
     *
     * Returns the last id created in the Identity column.
     *
     * @return	string
     */
    public function insert_id() {
        return $this->query('SELECT SCOPE_IDENTITY() AS insert_id')->row()->insert_id;
    }

    // --------------------------------------------------------------------
    /**
     * Database version number
     *
     * @return	string
     */
    public function version() {
        if (isset($this->data_cache['version'])) {
            return $this->data_cache['version'];
        }
        if (!$this->conn_id OR ( $info = sqlsrv_server_info($this->conn_id)) === FALSE) {
            return FALSE;
        }
        return $this->data_cache['version'] = $info['SQLServerVersion'];
    }

    /**
     * List table query
     *
     * Generates a platform-specific query string so that the table names can be fetched
     *
     * @param	bool
     * @return	string	$prefix_limit
     */
    public function _list_tables($prefix_limit = FALSE) {
        $sql = 'SELECT ' . $this->escape_identifiers('name')
                . ' FROM ' . $this->escape_identifiers('sysobjects')
                . ' WHERE ' . $this->escape_identifiers('type') . " = 'U'";
        if ($prefix_limit === TRUE && $this->dbprefix !== '') {
            $sql .= ' AND ' . $this->escape_identifiers('name') . " LIKE '" . $this->escape_like_str($this->dbprefix) . "%' "
                    . sprintf($this->_escape_like_str, $this->_escape_like_chr);
        }
        return $sql . ' ORDER BY ' . $this->escape_identifiers('name');
    }

    // --------------------------------------------------------------------
    /**
     * List column query
     *
     * Generates a platform-specific query string so that the column names can be fetched
     *
     * @param	string	$table
     * @return	string
     */
    public function _list_columns($table = '') {
        return 'SELECT COLUMN_NAME
			FROM INFORMATION_SCHEMA.Columns
			WHERE UPPER(TABLE_NAME) = ' . $this->escape(strtoupper($table));
    }

    // --------------------------------------------------------------------
    /**
     * Returns an object with field data
     *
     * @param	string	$table
     * @return	array
     */
    public function field_data($table) {
        $sql = 'SELECT COLUMN_NAME, DATA_TYPE, CHARACTER_MAXIMUM_LENGTH, NUMERIC_PRECISION, COLUMN_DEFAULT
			FROM INFORMATION_SCHEMA.Columns
			WHERE UPPER(TABLE_NAME) = ' . $this->escape(strtoupper($table));
        if (($query = $this->query($sql)) === FALSE) {
            return FALSE;
        }
        $query = $query->result_object();
        $retval = array();
        for ($i = 0, $c = count($query); $i < $c; $i++) {
            $retval[$i] = new stdClass();
            $retval[$i]->name = $query[$i]->COLUMN_NAME;
            $retval[$i]->type = $query[$i]->DATA_TYPE;
            $retval[$i]->max_length = ($query[$i]->CHARACTER_MAXIMUM_LENGTH > 0) ? $query[$i]->CHARACTER_MAXIMUM_LENGTH : $query[$i]->NUMERIC_PRECISION;
            $retval[$i]->default = $query[$i]->COLUMN_DEFAULT;
        }
        return $retval;
    }

    /**
     * Error
     *
     * Returns an array containing code and message of the last
     * database error that has occured.
     *
     * @return	array
     */
    public function error() {
        $error = array('code' => '00000', 'message' => '');
        $sqlsrv_errors = sqlsrv_errors(SQLSRV_ERR_ERRORS);
        if (!is_array($sqlsrv_errors)) {
            return $error;
        }
        $sqlsrv_error = array_shift($sqlsrv_errors);
        if (isset($sqlsrv_error['SQLSTATE'])) {
            $error['code'] = isset($sqlsrv_error['code']) ? $sqlsrv_error['SQLSTATE'] . '/' . $sqlsrv_error['code'] : $sqlsrv_error['SQLSTATE'];
        } elseif (isset($sqlsrv_error['code'])) {
            $error['code'] = $sqlsrv_error['code'];
        }
        if (isset($sqlsrv_error['message'])) {
            $error['message'] = $sqlsrv_error['message'];
        }
        return $error;
    }

    // --------------------------------------------------------------------
    /**
     * Truncate statement
     *
     * Generates a platform-specific truncate string from the supplied data
     *
     * If the database does not support the TRUNCATE statement,
     * then this method maps to 'DELETE FROM table'
     *
     * @param	string	$table
     * @return	string
     */
    public function _truncate($table) {
        return 'TRUNCATE TABLE ' . $table;
    }

    // --------------------------------------------------------------------
    /**
     * LIMIT
     *
     * Generates a platform-specific LIMIT clause
     *
     * @param	string	$sql	SQL Query
     * @return	string
     */
    public function _limit($sql, $limit, $offset) {

        if ($offset === FALSE) {
            $offset = 0;
        }

        // As of SQL Server 2012 (11.0.*) OFFSET is supported
        if (version_compare($this->version(), '11', '>=')) {
            // SQL Server OFFSET-FETCH can be used only with the ORDER BY clause
            if(count($this->ar_orderby) > 0){
                $this->ar_orderby[0] = "1, ".$this->ar_orderby[0];
            }else{
                empty($this->qb_orderby) && $sql .= ' ORDER BY 1';
            }
//            
            return $sql . ' OFFSET ' . (int) $offset . ' ROWS FETCH NEXT ' . $limit . ' ROWS ONLY';
        }
        $limit = $offset + $this->qb_limit;
        // An ORDER BY clause is required for ROW_NUMBER() to work
        if ($offset && !empty($this->qb_orderby)) {
            $orderby = $this->_compile_order_by();
            // We have to strip the ORDER BY clause
            $sql = trim(substr($sql, 0, strrpos($sql, $orderby)));
            // Get the fields to select from our subquery, so that we can avoid CI_rownum appearing in the actual results
            if (count($this->qb_select) === 0) {
                $select = '*'; // Inevitable
            } else {
                // Use only field names and their aliases, everything else is out of our scope.
                $select = array();
                $field_regexp = ($this->_quoted_identifier) ? '("[^\"]+")' : '(\[[^\]]+\])';
                for ($i = 0, $c = count($this->qb_select); $i < $c; $i++) {
                    $select[] = preg_match('/(?:\s|\.)' . $field_regexp . '$/i', $this->qb_select[$i], $m) ? $m[1] : $this->qb_select[$i];
                }
                $select = implode(', ', $select);
            }
            return 'SELECT ' . $select . " FROM (\n\n"
                    . preg_replace('/^(SELECT( DISTINCT)?)/i', '\\1 ROW_NUMBER() OVER(' . trim($orderby) . ') AS ' . $this->escape_identifiers('CI_rownum') . ', ', $sql)
                    . "\n\n) " . $this->escape_identifiers('CI_subquery')
                    . "\nWHERE " . $this->escape_identifiers('CI_rownum') . ' BETWEEN ' . ($offset + 1) . ' AND ' . $limit;
        }
        return preg_replace('/(^\SELECT (DISTINCT)?)/i', '\\1 TOP ' . $limit . ' ', $sql);
    }

    /**
     * Insert batch statement
     *
     * Generates a platform-specific insert string from the supplied data.
     *
     * @param	string	$table	Table name
     * @param	array	$keys	INSERT keys
     * @param	array	$values	INSERT values
     * @return	string|bool
     */
    public function _insert_batch($table, $keys, $values) {
        // Multiple-value inserts are only supported as of SQL Server 2008
        if (version_compare($this->version(), '10', '>=')) {
            return parent::_insert_batch($table, $keys, $values);
        }
        return ($this->db->db_debug) ? $this->db->display_error('db_unsupported_feature') : FALSE;
    }

    /**
     * Affected Rows
     *
     * @access	public
     * @return	integer
     */
//    function affected_rows() {
//        return @sqlrv_num_affected($this->conn_id);
//    }

    public function get_procedure_parameters_values($param_value = array()) {
        if (is_array($param_value) && count($param_value) > 0) {
            if (array_key_exists("type", $param_value) && $param_value["type"] == 'nvarchar') {
                return "N'" . $param_value["value"] . "'";
            }
            return "'" . $param_value["value"] . "'";
        }

        return "'" . $param_value . "'";
    }

    /**
     * Limit string
     *
     * Generates a platform-specific LIMIT clause
     *
     * @access	public
     * @param	string	the sql query string
     * @param	integer	the number of rows to limit the query to
     * @param	integer	the offset value
     * @return	string
     */
//    function _limit($sql, $limit, $offset) {
//
//        if ($offset === FALSE) {
//            $offset = 0;
//        }
//
//        $i = $limit + $offset;
//
//        return preg_replace('/(^\SELECT (DISTINCT)?)/i', '\\1 TOP ' . $i . ' ', $sql);
//    }

    public function configure_procedure_parameters($parameters = array()) {
        $result_param = array();
        foreach ($parameters as $param_name => $param_value) {
            if (is_array($param_value) && array_key_exists("type", $param_value) && array_key_exists("value", $param_value)) {
                $_param_value = $this->get_procedure_parameters_values($param_value);
                $result_param[] = "@" . $param_name . " = " . $_param_value;
                unset($_param_value);
            } else {
                $result_param[] = "@" . $param_name . " = " . $param_value;
            }
        }

        return implode(", ", $result_param);
    }

    public function get_procedure_executor() {
        return "";
    }

}

/* End of file sqlsrv_driver.php */
/* Location: ./system/database/drivers/sqlsrv/sqlsrv_driver.php */