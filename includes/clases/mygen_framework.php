<?php
	// Defined constants for the field_metadata property of 
	define('IDX_DATATYPE', 0);
	define('IDX_IN_KEY', 1);
	define('IDX_IS_NULLABLE', 2);
	define('IDX_IS_AUTOKEY', 3);
	define('IDX_IS_COMPUTED', 4);
	define('IDX_HAS_DEFAULT', 5);
	define('DEFAULT_DB_ID', $db_name);
	
	// Global database connections stuff!
	global $data_objects;
	$data_objects = array();
	
	function add_database($dataobject, $moniker = DEFAULT_DB_ID) 
	{
		global $data_objects;
		$data_objects[$moniker] = $dataobject;
	}
	
	function close_databases() 
	{
		global $data_objects;
		
		foreach ($data_objects as $key => $value) 
		{
			$value->sql_close();
		}
	}
	
	class SqlSoporte
	{
		var $items = array();
		var $sql_select = "";
		var $sql_where = "";
		var $sql_from = "";
		var $db_connect_id_s = null; 
		var $host = "";
		var $user = "";
		var $pass = "";
		
		function SqlSoporte($h, $u, $p)
		{
			$this->items = array();
			$this->sql_select = "";
			$this->sql_where = "";
			$this->sql_from = "";
			$this->sql_completo = "";
			$this->sql_top = 0;
			$this->sql_limit_i = 0;
			$this->sql_limit_f = 0;
			$this->host = $h;
			$this->user = $u; 
			$this->pass = $p;
//			$this->db_connect_id_s = mssql_connect($this->host, $this->user, $this->pass);  //Sql Server
			$this->db_connect_id_s = mysql_connect($this->host, $this->user, $this->pass);  //MySql
		}
		
		function get_count()
		{
			return count($this->items);
		}
		
		function set_sqlcompleto($sql)
		{
			$this->sql_completo= $sql;
		}
		
		function set_select($sql_s)
		{
			$this->sql_select = $sql_s;
		}
		
		function set_from($sql_m)
		{
			$this->sql_from = $sql_m;
		}
		
		function set_where($sql_w)
		{
			$this->sql_where = $sql_w;
		}
		
		function set_top($sql_t)
		{
			$this->sql_top = $sql_t;
		}
		
		function set_limit($sql_i, $sql_f)
		{
			$this->sql_limit_i = $sql_i;
			$this->sql_limit_f = $sql_f;
		}
		//$sqlpersonal->set_limit(0,3); // PARA MYSQL
		
		function load()
		{
			$sql = " SELECT ";
			if($this->sql_top <> NULL)
			{
				$sql .= " TOP(".$this->sql_top.") ";
			}
			$sql .= $this->sql_select;
			$sql .= " FROM ".$this->sql_from;
			if(trim($this->sql_where) <> "")
			{
				$sql .= " WHERE ".$this->sql_where;
			}
			if($this->sql_limit_f <> NULL)
			{
				$sql .= " LIMIT ";
				if($this->sql_limit_i <> NULL)
				{
					$sql .= $this->sql_limit_i;
				}
				else
				{
					$sql .= "0";
				}
				$sql .= ", ".$this->sql_limit_f;
			}
			$sql .= ";";
			
//			echo("<br>sql: ".$sql);
			
//			$select = mssql_query($sql,$this->db_connect_id_s);//sql_server
			$select = mysql_query($sql,$this->db_connect_id_s);
			
//			while($fila=mssql_fetch_array($select))  //sql server
			while($fila=mysql_fetch_array($select))
			{
				$datas = new dataSqlSoporte();
				$arrayaux = array();
				$col = explode(",",$this->sql_select);
				
				for($i = 0; $i<count($col); $i++)
				{
					$ascol = explode(" ",trim($col[$i]));
					if(count($ascol) > 1)
					{
						$arrayaux[trim($ascol[1])] = $fila[trim($ascol[1])];
					}
					else
					{
						$arrayaux[trim($ascol[0])] = $fila[trim($ascol[0])];
					}
				}
				
				$datas->set_data($arrayaux);
				
				$this->items[] = $datas;
			}
		}
		
		function loadSqlCompleto()
		{

			$sql = $this->sql_completo;
			$sql .= ";";
		
//			$select = mssql_query($sql,$this->db_connect_id_s);   //sql server
			$select = mysql_query($sql,$this->db_connect_id_s);
			
			while($fila=mysql_fetch_array($select))
			{
				$datas = new dataSqlSoporte();
				$arrayaux = array();
				$col = explode(",",$this->sql_select);
				
				for($i = 0; $i<count($col); $i++)
				{
					$ascol = explode(" ",trim($col[$i]));
					if(count($ascol) > 1)
					{
						$arrayaux[trim($ascol[1])] = $fila[trim($ascol[1])];
					}
					else
					{
						$arrayaux[trim($ascol[0])] = $fila[trim($ascol[0])];
					}
				}
				
				$datas->set_data($arrayaux);
				
				$this->items[] = $datas;
			}
		}
	}
	
	class dataSqlSoporte
	{
		var $datasoporte = array();
		
		function set_data($arr)
		{
			$this->datasoporte = $arr;
		}
		
		function get_data($field)
		{
			if (array_key_exists($field, $this->datasoporte))
			{
				return utf8_encode($this->datasoporte[$field]);
			}
			else

			{
				return null;
			}
		}
	}
	
	
	class BusinessObject
	{
		var $db_key = DEFAULT_DB_ID;
		var $table_name = null;
		var $is_new = true;
		var $is_deleted = false;
		var $data = null;
		var $original_data = null;
		
		var $field_metadata = null;
		var $primary_keys = array();
		var $required_for_insert = array();
		
		var $filter = array();
		
		function BusinessObject()
		{	
			foreach ($this->field_metadata as $field => $metadata) 
			{
				if ($metadata[IDX_IN_KEY]) 
				{
					array_push($this->primary_keys, $field);
				}
				if (!$metadata[IDX_IS_NULLABLE] && 
					!$metadata[IDX_IS_AUTOKEY] && 
					!$metadata[IDX_IS_COMPUTED] && 
					!$metadata[IDX_HAS_DEFAULT]) 
				{
					array_push($this->required_for_insert, $field);
				}
			}
		}
		
		function get_data($field)
		{
			if (is_null($this->data)) 
			{
				return null;
			}
			else if (array_key_exists($field, $this->data))
			{
				return utf8_encode($this->data[$field]);
			}
			else
			{
				return null;
			}
		}
		
		function set_data($field, $value)
		{
			$this->data[$field] = $value;
		}
		
		function load_from_list($row) 
		{
			if (is_null($row)) 
			{
				$this->is_new = true;
				$row = array();
			}
			else 
			{
				$this->is_new = false;
				$this->data = array();
				$this->original_data = array();
		
				foreach ($row as $field => $value)
				{
					$this->data[$field] = $value;
					$this->original_data[$field] = $value;
				}
			}
		}
		
		function is_dirty() 
		{
			$returnVal = false;
			foreach ($this->data as $field => $value) 
			{
				$old_value = $this->original_data[$field];
				if ( $old_value != $value) $returnVal = true;
			}
			
			return $returnVal;
		}
		
		function fill_ids()
		{
			// Needs to be overridden
			global $data_objects;
			
			$sql = "SELECT @@identity as id FROM " . $data_objects[$this->db_key]->sql_escape_tablename($this->table_name);
			
			$result = $data_objects[$this->db_key]->sql_query($sql);
			
			if ($result) 
			{
				$this->clear_filter();
				$id = $data_objects[$this->db_key]->sql_fetchfield("id", 0, $result);	
				$this->add_filter("id","=",$id);
				$this->load();
			}
		}
		
		function clear_filter()
		{
			$this->filter = array();
		}
		
		function add_filter()
		{
			global $data_objects;
			
			$arg_count = func_num_args();
			
			if ($arg_count == 5) 
			{
				// This could be between 2 other fields as opposed to values.
				$field = func_get_arg(0);
				$op1 = strtoupper(func_get_arg(1));
				$value1 = func_get_arg(2);
				$op2 = strtoupper(func_get_arg(3));
				$value2 = func_get_arg(4);
				
				$value1 = $this->sql_escape($field, $value1);
				$value2 = $this->sql_escape($field, $value2);
				$field = $data_objects[$this->db_key]->sql_escape_fieldname($field);
				
				array_push($this->filter, $field);
				array_push($this->filter, $op1);
				array_push($this->filter, $value1);
				array_push($this->filter, $op2);
				array_push($this->filter, $value2);
			}
			if ($arg_count == 4) 
			{
				$sqlFunction = func_get_arg(0);
				$field = func_get_arg(1);
				$op = strtoupper(func_get_arg(2));
				$value = func_get_arg(3);
				
				$value = $this->sql_escape($field, $value);
				$field = $data_objects[$this->db_key]->sql_escape_fieldname($field);
				
				array_push($this->filter, $sqlFunction . "(" . $field . ")");
				array_push($this->filter, $op);
				array_push($this->filter, $value);
			}
			if ($arg_count == 3) 
			{
				//TODO: need to validate fieldname, operator, and escape the value
				$field = func_get_arg(0);
				$op = strtoupper(func_get_arg(1));
				$value = func_get_arg(2);
				
				$value = $this->sql_escape($field, $value);
				$field = $data_objects[$this->db_key]->sql_escape_fieldname($field);
				
				array_push($this->filter, $field);
				array_push($this->filter, $op);
				array_push($this->filter, $value);
			}
			else if ($arg_count == 1) 
			{
				//TODO: add code to check if it's a supported logical operator
				$op = func_get_arg(0);
				
				array_push($this->filter, $op);
			}
			else 
			{
				return false;
			}
		}
		
		function build_where_clause() 
		{
			$sql = "";
			foreach ($this->filter as $token) 
			{
				$sql .= " " . $token;
			}
			
			return $sql;
		}
		
		function load() 
		{
			global $data_objects;
			
			// If we are loading data, this object is not new.
			$this->is_new = false;
			
	//		$sql = "SELECT * FROM " . $data_objects[$this->db_key]->sql_escape_tablename($this->table_name);
	
			//$sql = "SELECT * FROM " .$this->db_key.".".$data_objects[$this->db_key]->sql_escape_tablename($this->table_name);
			$sql = "SELECT * FROM " .$data_objects[$this->db_key]->sql_escape_tablename($this->table_name);
	
			
	
			// add where clause if any filters where set.
			$where_sql = $this->build_where_clause();
			if ($where_sql != "") 
			{
				$sql .= " WHERE" . $where_sql;
			}
			$sql .= ";";
			//echo("<br> sql: ".$sql);
			$result = $data_objects[$this->db_key]->sql_query($sql);
			if (!$result) 
			{
				echo "ERROR WITH THIS SQL: " . $sql;
				exit;
			}
			else
			{
				$row = $data_objects[$this->db_key]->sql_fetchrow($result);
				
				if (!$row) 
				{
					// Nothing was returned here, so return false
					//echo("Nothing was returned here, so return false");
					return false;
				}
				else
				{
					$this->original_data = $row;
					$this->data = $row;
				}
			}
			
			return true;
		}
		
		
		
		function mark_deleted()
		{
			$this->is_deleted = true;
		}
	
		function save()
		{
			if (!$this->is_deleted)
			{
				if ($this->is_new)
				{
//					echo "insert";
					return $this->_insert();
				}
				else if ($this->is_dirty())
				{
					//echo "<br>update";
					return $this->_update();
				}
			}
			else if ($this->is_deleted && !$this->is_new)
			{
				return $this->_delete();
			}
		}
		
		function _update()
		{
			global $data_objects;
				
			//TODO: Need to add validation/checks here!
			$first = true;
			$sql_set = "";
			
			foreach ($this->data as $field => $value) 
			{
				if (array_key_exists($field, $this->field_metadata))
				{
					
					$org_value = $this->original_data[$field];
					
					if ($org_value != $value)
					{
						$value = $this->sql_escape($field, $value);
						$field = $data_objects[$this->db_key]->sql_escape_fieldname($field);
						
						if ($first) $first = false;
						else 
						{
							$sql_set .= ", ";
						}
							
						$sql_set .= $field . " = " . $value;
					}
				}
			}
			
			if ($sql_set != "") 
			{
				$sql = "UPDATE " . $data_objects[$this->db_key]->sql_escape_tablename($this->table_name) . " SET " . $sql_set;
				
				// add where clause if any filters where set.
				$where_sql = $this->build_where_clause();
				if ($where_sql != "") 
				{
					$sql .= " WHERE" . $where_sql;
				}
				$sql .= ";";
			
				//echo "<h1>SQL:</h1> " . $sql;
				//exit;
	
				
				$result = $data_objects[$this->db_key]->sql_query($sql);
				if (!$result) 
				{
					echo "ERROR WITH THIS SQL: " . $sql;
					exit;
				}
							
				return true;
			}
			else
			{
				return false;
			}
		}
		
		function _insert()
		{
			global $data_objects;
			$existeId = false;
				
			//TODO: Need to add validation/checks here!
			$first = true;
			$sql_fields = "";
			$sql_values = "";
			
			foreach ($this->data as $field => $value) 
			{
				if (array_key_exists($field, $this->field_metadata))
				{
					//echo("field: ".$field." / ".$this->field_metadata[0]."<br>");
					if(array_key_exists("id", $this->field_metadata))
					
					{
						$existeId = true;
					}
					
					$value = $this->sql_escape($field, $value);
					$field = $data_objects[$this->db_key]->sql_escape_fieldname($field);
					
					if ($first) $first = false;
					else 
					{
						$sql_fields .= ", ";
						$sql_values .= ", ";
					}
						
					$sql_fields .= $field;
					$sql_values .= $value;
				}
			}
			
			if ($sql_fields != "")
			{
				$sql = "INSERT INTO " . $data_objects[$this->db_key]->sql_escape_tablename($this->table_name) . " (" . $sql_fields . ") VALUES (" . $sql_values . ");";
				//echo("<br>sql: ".$sql);
				$result = $data_objects[$this->db_key]->sql_query($sql);
				if (!$result) 
				{
					echo "ERROR WITH THIS SQL: " . $sql;
					exit;
				}
				
				if($existeId)
				{
					$this->fill_ids();
				}
				return true;
			}
			else
			{
				return false;
			}
		}
	
		// This doesn't work if deleted from a list.. need to build where clause off of keys, not filter?
		function _delete()
		{
			global $data_objects;
				
			//TODO: Need to add validation/checks here!
			$first = true;
			$sql_set = "";
			
			foreach ($this->data as $field => $value) 
			{
				if (array_key_exists($field, $this->field_metadata))
				{
					
					$org_value = $this->original_data[$field];
					
					if ($org_value != $value)
					{
						$value = $this->sql_escape($field, $value);
						$field = $data_objects[$this->db_key]->sql_escape_fieldname($field);
						
						if ($first) $first = false;
						else 
						{
							$sql_set .= ", ";
						}
							
						$sql_set .= $field . " = " . $value;
					}
				}
			}
			
			$sql = "DELETE FROM " . $data_objects[$this->db_key]->sql_escape_tablename($this->table_name);
				
			// add where clause if any filters where set.
			$where_sql = $this->build_where_clause();
			if ($where_sql != "") 
			{
				$sql .= " WHERE" . $where_sql;
			}
			
			$sql .= ";";
					
			$result = $data_objects[$this->db_key]->sql_query($sql);
			if (!$result) 
			{
				echo "ERROR WITH THIS SQL: " . $sql;
				exit;
			}
			
			return true;
		}
	
		function get_datatype($field)
		{
			return $this->field_metadata[$field][IDX_DATATYPE];
		}
		
		function sql_escape($field, $value)
		{
			global $data_objects;
				
			if (array_key_exists($field, $this->field_metadata))
			{
				$datatype = $this->get_datatype($field);
				$value = $data_objects[$this->db_key]->sql_escape_value($datatype, $value);
			}
			
			return $value;
		}
	}
	
	
	
	class BusinessObjectCollection
	{
		var $db_key = DEFAULT_DB_ID;
		var $table_name = null;
		var $field_metadata = null;
		
		var $is_loaded = false;
		var $filter = array();
		var $sort = array();
		var $items = array();
		
		var $inicio = NULL;
		var $fin = NULL;
		var $top = NULL;
		
		
		function BusinessObjectCollection() 
		{
			$singular = $this->create_singular(null);
			
			$this->db_key = $singular->db_key;
			$this->table_name = $singular->table_name;
			$this->field_metadata = $singular->field_metadata;
		}
		
		// MUST overload this in inheriting class
		function create_singular ($row) { return null; }
		
		function get_count() 
		{
			return count($this->items);
		}
		
		function is_dirty() 
		{
			foreach ($this->items as $obj) 
			{
				if ($obj.is_dirty()) return true;
			}
			return false;
		}
		
		function clear_sort()
		{
			$this->filter = array();
		}
		
		function add_sort()
		{
			global $data_objects;
			
			$arg_count = func_num_args();
			
			if (($arg_count == 2) || ($arg_count == 1))
			{
				$sortAsc = true;
				if ($arg_count == 2) $sortAsc = func_get_arg(1);
	
				//TODO: need to validate fieldname
				$field = func_get_arg(0);
				
				$field = $data_objects[$this->db_key]->sql_escape_fieldname($field);
				
				$this->sort[$field] = ($sortAsc ? "ASC" : "DESC");
			}
			else 
			{
				return false;
			}
		}
		
		function build_sort_clause() 
		{
			$sql = "";
			foreach ($this->sort as $field => $direction) 
			{
				if ($sql != "") $sql .= ",";
				
				$sql .= " " . $field . " " . $direction;
			}
			
			return $sql;
		}
		
		function clear_filter()
		{
			$this->filter = array();
		}
		
		function add_filter()
		{
			global $data_objects;
			
			$arg_count = func_num_args();
			
			if ($arg_count == 5) 
			{
				// This could be between 2 other fields as opposed to values.
				$field = func_get_arg(0);
				$op1 = strtoupper(func_get_arg(1));
				$value1 = func_get_arg(2);
				$op2 = strtoupper(func_get_arg(3));
				$value2 = func_get_arg(4);
				
				$value1 = $this->sql_escape($field, $value1);
				$value2 = $this->sql_escape($field, $value2);
				$field = $data_objects[$this->db_key]->sql_escape_fieldname($field);
				
				array_push($this->filter, $field);
				array_push($this->filter, $op1);
				array_push($this->filter, $value1);
				array_push($this->filter, $op2);
				array_push($this->filter, $value2);
			}
			if ($arg_count == 3) 
			{
				//TODO: need to validate fieldname, operator, and escape the value
				$field = func_get_arg(0);
				$op = func_get_arg(1);
				$value = func_get_arg(2);
				
				$value = $this->sql_escape($field, $value);
				$field = $data_objects[$this->db_key]->sql_escape_fieldname($field);
				
				array_push($this->filter, $field);
				array_push($this->filter, $op);
				array_push($this->filter, $value);
			}
			else if ($arg_count == 1) 
			{
				//TODO: add code to check if it's a supported logical operator
				$op = func_get_arg(0);
				
				array_push($this->filter, $op);
			}
			else 
			{
				return false;
			}
		}
		
		function add_limit()
		{		
			$arg_count = func_num_args();
			
			if ($arg_count == 1)
			{
				$this->inicio = 0;
				$this->fin = func_get_arg(0);
				
			}else if ($arg_count == 2)
			{
				$this->inicio = func_get_arg(0);
				$this->fin = func_get_arg(1);
			}
			else 
			{
				return false;
			}
		}
		
		function add_top()
		{		
			$arg_count = func_num_args();
			
			if ($arg_count == 1)
			{
				$this->top = func_get_arg(0);
			}
			else 
			{
				return false;
			}
		}
		
		function build_select()
		{
			global $data_objects;
			
			$sql = "SELECT id FROM " . $data_objects[$this->db_key]->sql_escape_tablename($this->table_name);
	
			// add where clause if any filters where set.
			$where_sql = $this->build_where_clause();
			if ($where_sql != "") 
			{
				$sql .= " WHERE" . $where_sql;
			}
			$sort_sql = $this->build_sort_clause();
			if ($sort_sql != "") 
			{
				$sql .= " ORDER BY" . $sort_sql;
			}
			
			if($this->fin != NULL)
			{
				$sql .= " LIMIT " . $this->inicio . "," . $this->fin;
			}
		
	//			echo $sql;
			return $sql;
		}
		
		function build_where_clause() 
		{
			$sql = "";
			foreach ($this->filter as $token) 
			{
				$sql .= " " . $token;
			}
			
			return $sql;
		}
		
		
		function delete() 
		{
			global $data_objects;
			
			// If we are loading data, this object is not new.
			$this->is_new = false;
			
			$sql = "DELETE FROM " . $data_objects[$this->db_key]->sql_escape_tablename($this->table_name);
	
			// add where clause if any filters where set.
			$where_sql = $this->build_where_clause();
			if ($where_sql != "") 
			{
				$sql .= " WHERE" . $where_sql;
			}
			
			$result = $data_objects[$this->db_key]->sql_query($sql);
			if (!$result) 
			{
				echo "ERROR WITH THIS SQL: " . $sql;
				exit;
			}
			
			return true;
		}
				
		function loadWhitJoin($objectJoin, $claveforeanea, $whereextra) 
		{
			global $data_objects;
			
			// If we are loading data, this object is not new.
			$this->is_new = false;
			
			//$sql = "SELECT * FROM " . $data_objects[$this->db_key]->sql_escape_tablename($this->table_name);
			$sql = "SELECT * FROM " .$this->db_key.".".$data_objects[$this->db_key]->sql_escape_tablename($this->table_name);
			$sql .= ", ".$this->db_key.".`".$objectJoin->table_name."`";
			
			// add where clause if any filters where set.
			$where_sql = $this->build_where_clause();
			if ($where_sql != "") 
			{
				$sql .= " WHERE" . $where_sql;
			}
			
			$sql .= " AND ".$this->db_key.".".$this->table_name.".id = ".$objectJoin->db_key.".".$objectJoin->table_name.".".$claveforeanea;
			
			$sql .= $whereextra;
			
			$sort_sql = $this->build_sort_clause();
			
			if ($sort_sql != "") 
			{
				$sql .= " ORDER BY" . $sort_sql;
			}
			if($this->fin != NULL)
			{
				$sql .= " LIMIT " . $this->inicio . "," . $this->fin;
			}		
			$sql .= ";";
			
		//	echo("SQL: $sql");
			
			$result = $data_objects[$this->db_key]->sql_query($sql);
			if (!$result) 
			{
				echo "ERROR WITH THIS SQL: " . $sql;
				exit;
			}
			else
			{
				$rows = $data_objects[$this->db_key]->sql_fetchrowset($result);
				
				if (!$rows) 
				{
					// Nothing was returned here, so return false
					return false;
				}
				else
				{
					$this->is_loaded = true;
					foreach ($rows as $row) 
					{
						array_push($this->items, $this->create_singular($row));
					}
				}
			}
			
			return true;
		}
		
		function load() // load collection 
		{
			global $data_objects;
			
			// If we are loading data, this object is not new.
			$this->is_new = false;
			
			$sql = "SELECT ";
			
			if($this->top != NULL)
			{
				$sql .= " TOP(" . $this->top . ") ";
			}
			else
			{
				$sql .= " * ";
			}
			
			$sql .= " FROM " . $data_objects[$this->db_key]->sql_escape_tablename($this->table_name);
	
			// add where clause if any filters where set.
			$where_sql = $this->build_where_clause();
			if ($where_sql != "") 
			{
				$sql .= " WHERE" . $where_sql;
			}
			$sort_sql = $this->build_sort_clause();
			if ($sort_sql != "") 
			{
				$sql .= " ORDER BY" . $sort_sql;
			}
			if($this->fin != NULL)
			{
				$sql .= " LIMIT " . $this->inicio . "," . $this->fin;
			}		
			$sql .= ";";
			
			//echo("<br> sql: ".$sql);
			
			$result = $data_objects[$this->db_key]->sql_query($sql);
			if (!$result) 
			{
				echo "ERROR WITH THIS SQL: " . $sql;
				exit;
			}
			else
			{
				$rows = $data_objects[$this->db_key]->sql_fetchrowset($result);
				
				if (!$rows) 
				{
					// Nothing was returned here, so return false
					return false;
				}
				else
				{
					$this->is_loaded = true;
					foreach ($rows as $row) 
					{
						array_push($this->items, $this->create_singular($row));
					}
				}
			}
			
			return true;
		}
		
		function add_new()
		{
			$obj = $this->create_singular(null);
			array_push($this->items, $obj);
			
			return $obj;
		}
		
		function mark_deleted()
		{
			for ($i = 0; $i < $this->get_count(); $i++)
			{
				$obj = &$this->items[$i];
				$obj->mark_deleted();
			}
		}
	
		function save()
		{
			for ($i = 0; $i < $this->get_count(); $i++)
			{
				$obj = &$this->items[$i];
				$obj->save();
			}
		}
	
		function get_datatype($field)
		{
			return $this->field_metadata[$field][IDX_DATATYPE];
		}
			
		function sql_escape($field, $value)
		{
			global $data_objects;
				
			if (array_key_exists($field, $this->field_metadata))
			{
				$datatype = $this->get_datatype($field);
				//$isnullable = $this->get_required($field)
				$value = $data_objects[$this->db_key]->sql_escape_value($datatype, $value);
			}
			
			return $value;
		}
	}
	
	//-----------------------------------------------------
	//-----------------------------------------------------
	//-- EXPERIMENTAL -------------------------------------
	//-----------------------------------------------------
	//-----------------------------------------------------
	
	
	class QueryObject
	{
		var $db_key = DEFAULT_DB_ID;
		var $table_name = null;
		var $data = null;
		var $original_data = null;
		
		var $field_metadata = null;
		
		var $filter = array();
		
		function QueryObject()
		{	
			// Nada
		}
		
		function get_data($field)
		{
			if (is_null($this->data)) 
			{
				return null;
			}
			else if (array_key_exists($field, $this->data))
			{
				return $this->data[$field];
			}
			else
			{
				return null;
			}
		}
		
		function load_from_list($row) 
		{
			if (is_null($row)) 
			{
				$this->is_new = true;
				$row = array();
			}
			else 
			{
				$this->is_new = false;
				$this->data = array();
				$this->original_data = array();
		
				foreach ($row as $field => $value)
				{
					$this->data[$field] = $value;
					$this->original_data[$field] = $value;
				}
			}
		}
		
		function clear_filter()
		{
			$this->filter = array();
		}
		
		function add_filter()
		{
			global $data_objects;
			
			$arg_count = func_num_args();
			
			if ($arg_count == 5) 
			{
				// This could be between 2 other fields as opposed to values.
				$field = func_get_arg(0);
				$op1 = strtoupper(func_get_arg(1));
				$value1 = func_get_arg(2);
				$op2 = strtoupper(func_get_arg(3));
				$value2 = func_get_arg(4);
				
				$value1 = $this->sql_escape($field, $value1);
				$value2 = $this->sql_escape($field, $value2);
				$field = $data_objects[$this->db_key]->sql_escape_fieldname($field);
				
				array_push($this->filter, $field);
				array_push($this->filter, $op1);
				array_push($this->filter, $value1);
				array_push($this->filter, $op2);
				array_push($this->filter, $value2);
			}
			if ($arg_count == 3) 
			{
				//TODO: need to validate fieldname, operator, and escape the value
				$field = func_get_arg(0);
				$op = strtoupper(func_get_arg(1));
				$value = func_get_arg(2);
				
				$value = $this->sql_escape($field, $value);
				$field = $data_objects[$this->db_key]->sql_escape_fieldname($field);
				
				array_push($this->filter, $field);
				array_push($this->filter, $op);
				array_push($this->filter, $value);
			}
			else if ($arg_count == 1) 
			{
				//TODO: add code to check if it's a supported logical operator
				$op = func_get_arg(0);
				
				array_push($this->filter, $op);
			}
			else 
			{
				return false;
			}
		}
		
		function build_where_clause() 
		{
			$sql = "";
			foreach ($this->filter as $token) 
			{
				$sql .= " " . $token;
			}
			
			return $sql;
		}
		
		function load() // experimental
		{
			global $data_objects;
			
			// If we are loading data, this object is not new.
			$this->is_new = false;
			
			// $sql = "SELECT * FROM " . $data_objects[$this->db_key]->sql_escape_tablename($this->table_name);
			$sql = "SELECT * FROM " . $data_objects[$this->db_key]->sql_escape_tablename($this->table_name);
	
			// add where clause if any filters where set.
			$where_sql = $this->build_where_clause();
			if ($where_sql != "") 
			{
				$sql .= " WHERE" . $where_sql;
			}
			$sql .= ";";
			//echo "sql: ".$sql;
			
			$result = $data_objects[$this->db_key]->sql_query($sql);
			if (!$result) 
			{
				echo "ERROR WITH THIS SQL: " . $sql;
				exit;
			}
			else
			{
				$row = $data_objects[$this->db_key]->sql_fetchrow($result);
				
				if (!$row) 
				{
					// Nothing was returned here, so return false
					return false;
				}
				else
				{
					$this->original_data = $row;
					$this->data = $row;
				}
			}
			
			return true;
		}
		
		function get_datatype($field)
		{
			return $this->field_metadata[$field][IDX_DATATYPE];
		}
		
		function sql_escape($field, $value)
		{
			global $data_objects;
				
			if (array_key_exists($field, $this->field_metadata))
			{
				$datatype = $this->get_datatype($field);
				$value = $data_objects[$this->db_key]->sql_escape_value($datatype, $value);
			}
			
			return $value;
		}
	}
	
	
	
	class QueryCollection
	{
		var $db_key = DEFAULT_DB_ID;
		var $table_name = null;
		var $field_metadata = null;
		
		var $is_loaded = false;
		var $filter = array();
		var $sort = array();
		var $items = array();
		
		function QueryCollection() 
		{
			$singular = $this->create_singular(null);
			
			$this->db_key = $singular->db_key;
			$this->table_name = $singular->table_name;
			$this->field_metadata = $singular->field_metadata;
		}
		
		// MUST overload this in inheriting class
		function create_singular ($row) { return null; }
		
		function get_count() 
		{
			return count($this->items);
		}
		
		function clear_sort()
		{
			$this->filter = array();
		}
		
		function add_sort()
		{
			global $data_objects;
			
			$arg_count = func_num_args();
			
			if (($arg_count == 2) || ($arg_count == 1))
			{
				$sortAsc = true;
				if ($arg_count == 1) $sortAsc = func_get_arg(1);
	
				//TODO: need to validate fieldname
				$field = func_get_arg(0);
				
				$field = $data_objects[$this->db_key]->sql_escape_fieldname($field);
				
				$this->sort[$field] = ($sortAsc ? "ASC" : "DESC");
			}
			else 
			{
				return false;
			}
		}
		
		function build_sort_clause() 
		{
			$sql = "";
			foreach ($this->sort as $field => $direction) 
			{
				if ($sql != "") $sql .= ",";
				
				$sql .= " " . $field . " " . $direction;
			}
			
			return $sql;
		}
		
		function clear_filter()
		{
			$this->filter = array();
		}
		
		function add_filter()
		{
			global $data_objects;
			
			$arg_count = func_num_args();
			
			if ($arg_count == 5) 
			{
				// This could be between 2 other fields as opposed to values.
				$field = func_get_arg(0);
				$op1 = strtoupper(func_get_arg(1));
				$value1 = func_get_arg(2);
				$op2 = strtoupper(func_get_arg(3));
				$value2 = func_get_arg(4);
				
				$value1 = $this->sql_escape($field, $value1);
				$value2 = $this->sql_escape($field, $value2);
				$field = $data_objects[$this->db_key]->sql_escape_fieldname($field);
				
				array_push($this->filter, $field);
				array_push($this->filter, $op1);
				array_push($this->filter, $value1);
				array_push($this->filter, $op2);
				array_push($this->filter, $value2);
			}
			if ($arg_count == 3) 
			{
				//TODO: need to validate fieldname, operator, and escape the value
				$field = func_get_arg(0);
				$op = func_get_arg(1);
				$value = func_get_arg(2);
				
				$value = $this->sql_escape($field, $value);
				$field = $data_objects[$this->db_key]->sql_escape_fieldname($field);
				
				array_push($this->filter, $field);
				array_push($this->filter, $op);
				array_push($this->filter, $value);
			}
			else if ($arg_count == 1) 
			{
				//TODO: add code to check if it's a supported logical operator
				$op = func_get_arg(0);
				
				array_push($this->filter, $op);
			}
			else 
			{
				return false;
			}
		}
		
		function build_where_clause() 
		{
			$sql = "";
			foreach ($this->filter as $token) 
			{
				$sql .= " " . $token;
			}
			
			return $sql;
		}
		
		function load() // experimental no se usa
		{
			global $data_objects;
			
			// If we are loading data, this object is not new.
			$this->is_new = false;
			
			$sql = "SELECT * FROM " . $data_objects[$this->db_key]->sql_escape_tablename($this->table_name);
	
			// add where clause if any filters where set.
			$where_sql = $this->build_where_clause();
			if ($where_sql != "") 
			{
				$sql .= " WHERE" . $where_sql;
			}
			$sort_sql = $this->build_sort_clause();
			if ($sort_sql != "") 
			{
				$sql .= " ORDER BY" . $sort_sql;
			}
			$sql .= ";";
			//echo("<br> sql: ".$sql);
			$result = $data_objects[$this->db_key]->sql_query($sql);
			if (!$result) 
			{
				echo "ERROR WITH THIS SQL: " . $sql;
				exit;
			}
			else
			{
				$rows = $data_objects[$this->db_key]->sql_fetchrowset($result);
				
				if (!$rows) 
				{
					// Nothing was returned here, so return false
					return false;
				}
				else
				{
					$this->is_loaded = true;
					foreach ($rows as $row) 
					{
						array_push($this->items, $this->create_singular($row));
					}
				}
			}
			
			return true;
		}
		
		function get_datatype($field)
		{
			return $this->field_metadata[$field][IDX_DATATYPE];
		}
			
		function sql_escape($field, $value)
		{
			global $data_objects;
				
			if (array_key_exists($field, $this->field_metadata))
			{
				$datatype = $this->get_datatype($field);
				//$isnullable = $this->get_required($field)
				$value = $data_objects[$this->db_key]->sql_escape_value($datatype, $value);
			}
			
			return $value;
		}
	}
?>