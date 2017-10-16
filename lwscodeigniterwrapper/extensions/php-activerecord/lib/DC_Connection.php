<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

abstract class DC_Connection extends Connection {
    
    public function __construct()
    {
        $CI = &get_instance();
        if (!isset($CI->db))
        {
            $CI->load->database();             
        }
        $this->connection = $CI->db;
    }

    static function load_adapter_class($adapter)
	{
		$class = ucwords($adapter) . 'Adapter';
//		$fqclass = 'ActiveRecord\\' . $class;
        $fqclass = $class;
		$source = dirname(__FILE__) . "/adapters-ci/$class.php";
		if (!file_exists($source))
			throw new DatabaseException("$class not found!");

		require_once($source);
		return $fqclass;
	}        
    
    public function query($sql, &$values=array())
    {
        return $this->connection->query($sql, $values);
    }
    
	public function columns($table)
	{
		$columns = array();
		$sth = $this->query_column_info($table);
        foreach ($sth->result_array() as $row)
        {
            foreach ($row as $key => $value)
            {
                $row[strtolower($key)] = $value;
                unset($row[$key]);
            }
			$c = $this->create_column($row);
			$columns[$c->name] = $c;
        }
		return $columns;
	}    
    
	public function escape($string)
	{
		return $this->connection->escape($string);
	}    
    
	public function insert_id($sequence=null)
	{
		return $this->connection->insert_id();
	}    
    
	public function query_and_fetch_one($sql, &$values=array())
	{
		$sth = $this->query($sql, $values);
		$row = $sth->result_array();
		return $row[0];
	}    
    
	public function query_and_fetch($sql, Closure $handler)
	{
		$sth = $this->query($sql);
        foreach ($sth->result_array() as $row)
        {
            $handler($row);
        }
	}    
    
	public function tables()
	{
		$tables = array();
		$sth = $this->query_for_tables();
        foreach ($sth->result_array() as $row)
        {
            $tables[] = current($row);
        }
		return $tables;
	}    
    
	public function transaction()
	{
		$this->connection->trans_start();
	}

	/**
	 * Commits the current transaction.
	 */
	public function commit()
	{
		$this->connection->trans_commit();
	}

	/**
	 * Rollback a transaction.
	 */
	public function rollback()
	{
		$this->connection->trans_rollback();
	}    
    
}