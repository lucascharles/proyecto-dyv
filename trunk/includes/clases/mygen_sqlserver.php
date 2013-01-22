<?php
class mssql_db
{

	var $db_connect_id;
	var $query_result;
	var $row = array();
	var $rowset = array();
	var $num_queries = 0;

	// Constructor
	function mssql_db($sqlserver, $sqluser, $sqlpassword, $database, $persistency = true)
	{

		$this->persistency = $persistency;
		$this->user = $sqluser;
		$this->password = $sqlpassword;
		$this->server = $sqlserver;
		$this->dbname = $database;

		if($this->persistency)
		{
			//$this->db_connect_id = mssql_pconnect($this->server, $this->user, $this->password);
			$this->db_connect_id = mssql_connect($this->server, $this->user, $this->password);
		}
		else
		{
			//$this->db_connect_id = mssql_connect($this->server, $this->user, $this->password);
			$this->db_connect_id = mssql_connect($this->server, $this->user, $this->password);
		}
		
		if($this->db_connect_id)
		{
			if($database != "")
			{
				$this->dbname = $database;
				//$dbselect = mssql_select_db($this->dbname);
				$dbselect = mssql_select_db($this->dbname);

				if(!$dbselect)
				{
					//mssql_close($this->db_connect_id);
					mssql_close($this->db_connect_id);
					$this->db_connect_id = $dbselect;
				}
			}

			return $this->db_connect_id;
		}
		else
		{
			return false;
		}
	}

	// Other base methods
	function sql_close()
	{
		if($this->db_connect_id)
		{
			if($this->query_result)
			{
				//mssql_free_result($this->query_result);
				mssql_free_result($this->query_result);
			}
			$result = mssql_close($this->db_connect_id);
			return $result;
		}
		else
		{
			return false;
		}
	}

	// Base query method
	function sql_query($query = "", $transaction = FALSE)
	{
		// Remove any pre-existing queries
		unset($this->query_result);
		if($query != "")
		{
			$this->num_queries++;
			//echo "<h2>QUERY:</h2><br>".$query;
			$this->query_result = mssql_query($query, $this->db_connect_id);
		}
		if($this->query_result)
		{
			unset($this->row[$this->query_result]);
			unset($this->rowset[$this->query_result]);
			return $this->query_result;
		}
		else
		{
			return ( $transaction == END_TRANSACTION ) ? true : false;
		}
	}

	// Other query methods
	function sql_numrows($query_id = 0)
	{
		if(!$query_id)
		{
			$query_id = $this->query_result;
		}
		if($query_id)
		{
			$result = mssql_num_rows($query_id);
			return $result;
		}
		else
		{
			return false;
		}
	}
	function sql_affectedrows()
	{
		if($this->db_connect_id)
		{
			$result = mssql_affected_rows($this->db_connect_id);
			return $result;
		}
		else
		{
			return false;
		}
	}
	function sql_numfields($query_id = 0)
	{
		if(!$query_id)
		{
			$query_id = $this->query_result;
		}
		if($query_id)
		{
			$result = mssql_num_fields($query_id);
			return $result;
		}
		else
		{
			return false;
		}
	}
	function sql_fieldname($offset, $query_id = 0)
	{
		if(!$query_id)
		{
			$query_id = $this->query_result;
		}
		if($query_id)
		{
			$result = mssql_field_name($query_id, $offset);
			return $result;
		}
		else
		{
			return false;
		}
	}
	function sql_fieldtype($offset, $query_id = 0)
	{
		if(!$query_id)
		{
			$query_id = $this->query_result;
		}
		if($query_id)
		{
			$result = mssql_field_type($query_id, $offset);
			return $result;
		}
		else
		{
			return false;
		}
	}
	function sql_fetchrow($query_id = 0)
	{
		if(!$query_id)
		{
			$query_id = $this->query_result;
		}
		if($query_id)
		{
			$this->row[$query_id] = mssql_fetch_array($query_id);
			return $this->row[$query_id];
		}
		else
		{
			return false;
		}
	}
	function sql_fetchrowset($query_id = 0)
	{
		if(!$query_id)
		{
			$query_id = $this->query_result;
		}
		if($query_id)
		{
			unset($this->rowset[$query_id]);
			unset($this->row[$query_id]);
			while($this->rowset[$query_id] = mssql_fetch_array($query_id))
			{
				$result[] = $this->rowset[$query_id];
			}
			return $result;
		}
		else
		{
			return false;
		}
	}
	function sql_fetchfield($field, $rownum = -1, $query_id = 0)
	{
		if(!$query_id)
		{
			$query_id = $this->query_result;
		}
		if($query_id)
		{
			if($rownum > -1)
			{
				$result = mssql_result($query_id, $rownum, $field);
			}
			else
			{
				if(empty($this->row[$query_id]) && empty($this->rowset[$query_id]))
				{
					if($this->sql_fetchrow())
					{
						$result = $this->row[$query_id][$field];
					}
				}
				else
				{
					if($this->rowset[$query_id])
					{
						$result = $this->rowset[$query_id][$field];
					}
					else if($this->row[$query_id])
					{
						$result = $this->row[$query_id][$field];
					}
				}
			}
			return $result;
		}
		else
		{
			return false;
		}
	}
	function sql_rowseek($rownum, $query_id = 0){
		if(!$query_id)
		{
			$query_id = $this->query_result;
		}
		if($query_id)
		{
			$result = mssql_data_seek($query_id, $rownum);
			return $result;
		}
		else
		{
			return false;
		}
	}
	function sql_nextid(){
		if($this->db_connect_id)
		{
			$result = mssql_insert_id($this->db_connect_id);
			return $result;
		}
		else
		{
			return false;
		}
	}
	function sql_freeresult($query_id = 0){
		if(!$query_id)
		{
			$query_id = $this->query_result;
		}

		if ( $query_id )
		{
			unset($this->row[$query_id]);
			unset($this->rowset[$query_id]);

			mssql_free_result($query_id);

			return true;
		}
		else
		{
			return false;
		}
	}
	function sql_error($query_id = 0)
	{
		$result["message"] = mssql_error($this->db_connect_id);
		$result["code"] = mssql_errno($this->db_connect_id);

		return $result;
	}
	function sql_escape_fieldname($field)
	{
		//return "`" . $field . "`";
		return $field;
	}
	
	function sql_escape_tablename($table)
	{
		//return "`" . $table . "`";
		return $table ;
	}

	function sql_escape_value($datatype, $value)
	{
		$datatype = strtolower($datatype);
			
		if (is_null($value))
		{
			$value = "NULL";
		}
		else if ($datatype == 'bool')
		{
			$value = ($value ? "'t'" : "'f'");
		}
		else if ( ($datatype == 'varchar') ||
			($datatype == 'text') ||
			($datatype == 'char') ||
			($datatype == 'datetime') ||
			($datatype == 'date') )
		{
			// $value = "'" . mysql_escape_string($value) . "'";
			$value = "'" . $value . "'";
		}
		return $value;
	}

} // class mssql_db

?>