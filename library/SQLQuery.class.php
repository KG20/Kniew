<?php

/***
*POSTGRES ABSTRACTION LAYER,
*HEART OF THE FRAMEWORK
*****/


class SQLQuery
{
	protected $_dbHandle;
	protected $_result;
	protected $_table;
	protected $_query;
	protected $_queryEx;
	protected $_bind;
	protected $_fetch;
	protected $_fetchtype;
	protected $_db;

	protected $_describe = array();

	protected $_orderBy;
	protected $_order;
	protected $_extraConditions;
	protected $_hO;
	protected $_hM;
	protected $_hMABTM;
	protected $_page;
	protected $_limit;


	/**** Connects to database ****/


	function connect($host, $username, $password, $db)
	{
		try{
			$this->_dbHandle = new \PDO("pgsql:dbname=$db;host=$host;user=$username;password=$password;");
			$this->_db = $db;
			$this->_dbHandle->exec('SET search_path TO website');

			// *** echo a message saying we have connected ***/

	        $this->_dbHandle->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	        // $this->_dbHandle-> exec("SET time_zone TO ". TIMEZONE );

	            // echo 'Connected to database';
	        return 1;
		}
		catch (PDOException $e) {
            echo $e->getMessage();
            return 0;
        }

	}



    /** Disconnects from database **/

    function disconnect() {
    	$this->_dbhandle = 0;
        if ($this->_dbHandle->getAttribute(PDO::ATTR_CONNECTION_STATUS) ){ // for pdo $_dbhandle = 0 to close
            return 1;
        }  else {
            return 0;
        }
    }

    /***SELECT QUERY****/

    function where($field, $value)
    {
		$this->_extraConditions .= $this->_table.'.'.$field.' = :'.$field.' AND ';
		$this->_bind[':field'] = $value;
	}

	function like($field, $value) {
		$this->_extraConditions .= ''.$this->_table.'.'.$field.' LIKE %:'.$field.'% AND ';
		$this->_bind[':field'] = $value;
	}

	function showHasOne() {
		$this->_hO = 1; //has 1 to 1 relation, 1 foreign key per row? like appointment settings?
	}

	function showHasMany() {
		$this->_hM = 1; //has 1 to many, many rows can have same foriegn key,
	}

	function showHMABTM() {
		$this->_hMABTM = 1; //hasManyAndBelongsToMany many to many relationships,
	}

	function setLimit($limit) {
		$this->_limit = $limit;
	}

	function setPage($page) {
		$this->_page = $page;
	}

	function orderBy($orderBy, $order = 'ASC') {
		$this->_orderBy = $orderBy;
		$this->_order = $order;
	}


	function search()
	{

		global $inflect;

		$from = $this->_db.$this->_table.' ';
		$conditions = '"1"="1" AND ';
		$conditionsChild = '';
		$fromChild = '';

		if ($this->_hO == 1 && isset($this->hasOne))
		{

			foreach ($this->hasOne as $alias => $table)
			{
				$table = strtolower($table);

				$from .= 'LEFT JOIN '.$table.' as '.$alias;
				$firstColumn ='';
				$secondColumn = '';

				if(strtolower($this->_table) == 'userall' || strtolower($this->_table) == 'usernormal' || strtolower($this->_table) == 'professional')
				{
					$firstColumn = 'id';
				}
				else
				{
					$firstColumn = $alias.'id';
				}

				if($alias == 'userall' || $alias == 'usernormal' || $alias == 'professional')
				{
					$secondColumn = 'id';

				}
				else
				{
					$secondColumn = $alias.'id';
				}

				$from .= 'ON "'.$this->_table.'"."'.$firstColumn.'" = "'. $alias .'"."' . $secondColumn.'"';


			}
		}

		if ($this->id)
		{
			if($this->_table == 'userall' || $this->_table == 'usernormal' || $this->_table == 'professional')
			{
				$conditions .= $this->_table.'.id = :id AND ';
				$this->bind[':id'] = $this->id;
			}
			else
			{
				$conditions .= $this->_table.'.'.$this->_table.'id = :'.$this->_table.'id AND ';
				$this->bind[':'.$this->_table.'id']	=$this->id;

			}
		}

		if ($this->_extraConditions)
		{
			$conditions .= $this->_extraConditions;
		}

		$conditions = substr($conditions,0,-4);

		if (isset($this->_orderBy))
		{
			$conditions .= ' ORDER BY '.$this->_table.'.'.$this->_orderBy.' '.$this->_order;
		}

		if (isset($this->_page))
		{
			$offset = ($this->_page-1)*$this->_limit;
			$conditions .= ' LIMIT '.$this->_limit.' OFFSET '.$offset;
		}
		if($this->_columnNames)
		{
			$this->_query = 'SELECT ' .$this->_columnNames. ' FROM '.$from.' WHERE '.$conditions;
		}
		else
		{
			$this->_query = 'SELECT * FROM '.$from.' WHERE '.$conditions;
		}
		#echo '<!--'.$this->_query.'-->';
		$this->_queryEx = $this->_dbHandle->prepare($query);
		$this->_queryEx->bindParam($this->bind);
		$this->_result = $this->_queryEx->execute();
		$result = array();
		$table = array();
		$field = array();
		$tempResults = array();
		$numOfFields = $this->_queryEx->columnCount();
		for ($i = 0; $i < $numOfFields; ++$i)
		{
			$meta = $this->_result->getColumnMeta($i);
			array_push($table, $meta['table']);
			array_push($field, $meta['name']);
		}
		if ($numOfFields > 0 )
		{
			while ($row = $this->_queryEx->fetch(PDO::FETCH_NUM))
			{
				for ($i = 0;$i < $numOfFields; ++$i)
				{
					$tempResults[$table[$i]][$field[$i]] = $row[$i];
				}

				if ($this->_hM == 1 && isset($this->hasMany))
				{
					foreach ($this->hasMany as $aliasChild => $tableChild)
					{
						$queryChild = '';
						$conditionsChild = '';
						$fromChild = '';
						$bindChild =array();

						$tableChild = strtolower($tableChild);

						$fromChild .= $tableChild.' as '.$aliasChild;


						if(strtolower($this->_table) == 'userall' || strtolower($this->_table) == 'usernormal' || strtolower($this->_table) == 'professional')
						{
							$conditionsChild .= $aliasChild.'.id = :id';
							$bindChild[':id'] = $tempResults[$this->_table]['id'];
						}
						else
						{
							$conditionsChild .= $aliasChild.'.'.strtolower($this->_table).'id = :'.strtolower($this->_table).'id';
							$bindChild[':'.strtolower($this->_table).'id']	= $tempResults[$this->_table][$this->_table . 'id'];

						}

						if($this->_columnNames)
						{
							$queryChild =  'SELECT '. $this_columnNames .' FROM '.$fromChild.' WHERE '.$conditionsChild;
						}
						else
						{
							$queryChild =  'SELECT * FROM '.$fromChild.' WHERE '.$conditionsChild;
						}

						$queryExChild = $this->_dbHandle->prepare($queryChild);
						$queryExChild->bindParam($bindChild);

						#echo '<!--'.$queryChild.'-->';
						$resultChild = $queryExChild->execute();

						$tableChild = array();
						$fieldChild = array();
						$tempResultsChild = array();
						$resultsChild = array();
						$metaChild = array();

						if ($resultChild->fetchColumn() > 0)
						{
							$numOfFieldsChild =  $queryExChild->columnCount();
							for ($j = 0; $j < $numOfFieldsChild; ++$j)
							{
								$metaChild = $resultChild->getColumnMeta($j);
								array_push($tableChild, $metaChild['table']);
								array_push($fieldChild, $metaChild['name']);
							}

							while ($rowChild = $queryExChild->fetch(PDO::FETCH_NUM))
							{
								for ($j = 0;$j < $numOfFieldsChild; ++$j)
								{
									$tempResultsChild[$tableChild[$j]][$fieldChild[$j]] = $rowChild[$j];
								}
								array_push($resultsChild,$tempResultsChild);
							}
						}

						$tempResults[$aliasChild] = $resultsChild;

						$queryExChild->closeCursor();
					}
				}

				// if showHMABTM() function has been called, then for each result returned by the first query and for each hasManyAndBelongsToMany relationship, it will find all those records which match the current result’s id . For example, if teachers hasManyAndBelongsToMany students, then $this->Teacher->showHMABTM() will search for teacher_id in students_teachers table.


				// if ($this->_hMABTM == 1 && isset($this->hasManyAndBelongsToMany))
				// {
				// 	foreach ($this->hasManyAndBelongsToMany as $aliasChild => $tableChild)
				// 	{
				// 		$queryChild = '';
				// 		$queryExChild = '';
				// 		$conditionsChild = '';
				// 		$fromChild = '';
				// 		$bindChild = array();
				// 		$firstColumnChild = '';
				// 		$secondColumnChild = '';


				// 		$tableChild = strtolower($tableChild);
				// 		// $pluralAliasChild = strtolower($inflect->pluralize($aliasChild));
				// 		// $singularAliasChild = strtolower($aliasChild);

				// 		$sortTables = array($this->_table,$aliasChild);
				// 		sort($sortTables);
				// 		$joinTable = implode('_',$sortTables);

				// 		$fromChild .= $tableChild.' as '.$aliasChild.',';
				// 		$fromChild .= $joinTable.',';



				// 		if($aliasChild == 'userall' || $aliasChild == 'usernormal' || $aliasChild == 'professional')
				// 		{
				// 			$firstColumnChild = 'id';

				// 		}
				// 		else
				// 		{
				// 			$sirstColumnChild = $aliasChild.'id';
				// 		}

				// 		if(strtolower($this->_table) == 'userall' || strtolower($this->_table) == 'usernormal' || strtolower($this->_table) == 'professional')
				// 		{
				// 			$seconfColumnChild = 'id';
				// 		}
				// 		else
				// 		{
				// 			$secondColumnChild = strtolower($this->_table).'id';
				// 		}



				// 		$conditionsChild .= $joinTable.'.'.$firstColumnChild.' = '. $aliasChild .'.' .$firstColumnChild.' AND ';
				// 		$conditionsChild .= $joinTable.'.'. $secondColumnChild .' = :'. $secondColumnChild;
				// 		$bindChild[':' . $secondColumnChild] = $tempResults[$this->_table]['id'];
				// 		$fromChild = substr($fromChild,0,-1);

				// 		if($this->_columnNames)
					// {
					// 	$queryChild =  'SELECT '.$this->columnNames.' FROM '.$fromChild.' WHERE '.$conditionsChild;
					// }
					// else
					// {
					// 	$queryChild =  'SELECT * FROM '.$fromChild.' WHERE '.$conditionsChild;

					// }
				// 		$queryExChild = $this->_dbHandle->prepare($queryChild);
				// 		$queryExChild->bindParam($bindChild);
				// 		#echo '<!--'.$queryChild.'-->';
				// 		$resultChild = $queryExChild->execute();

				// 		$tableChild = array();
				// 		$fieldChild = array();
				// 		$tempResultsChild = array();
				// 		$resultsChild = array();
				// 		if ($resultChild->fetchColumn() > 0)
				// 		{
				// 			$numOfFieldsChild =  $queryExChild->columnCount();

				// 			for ($j = 0; $j < $numOfFieldsChild; ++$j)
				// 			{
				// 				$metaChild = $resultChild->getColumnMeta($j);
				// 				array_push($tableChild, $metaChild['table']);
				// 				array_push($fieldChild, $metaChild['name']);
				// 			}

							// while ($rowChild = $queryExChild->fetch(PDO::FETCH_NUM))
				// 			{
				// 				for ($j = 0;$j < $numOfFieldsChild; ++$j)
				// 				{
				// 					$tempResultsChild[$tableChild[$j]][$fieldChild[$j]] = $rowChild[$j];
				// 				}
				// 				array_push($resultsChild,$tempResultsChild);
				// 			}
				// 		}

				// 		$tempResults[$aliasChild] = $resultsChild;

				// 		$queryExChild->closeCursor();
				// 	}


				// }

				array_push($result,$tempResults);
			}

			if ($this->_result->fetchColumn() == 1 && $this->id != null) //if id is set, then it will return a single result
																		//(and not an array), else it will return an array
			{
				$this->_queryEx->closeCursor();
				$this->clear();
				return($result[0]);
			}
			else
			{
				$this->_queryEx->closeCursor();
				$this->clear();
				return($result);
			}
		}
		else
		{
			$this->_queryEx->closeCursor();
			$this->clear();
			return $result;
		}

	}

	/** Custom SQL Query **/
	// CHANGEDNOV19 : ADDED ismultiple

	function custom($query, $ismultiple = false)
	{

		global $inflect;

		if($ismultiple == true) $this->_dbHandle->setAttribute(PDO::ATTR_EMULATE_PREPARES, 1);
		else $this->_dbHandle->setAttribute(PDO::ATTR_EMULATE_PREPARES, 0);

		$this->_queryEx = $this->_dbHandle->prepare($query);
		if(isset($this->_bind))
		{
			$this->_result = $this->_queryEx->execute($this->_bind);
		}
		else
		{
			$this->_result = $this->_queryEx->execute();

		}
		if($this->_fetch !== NULL)
		{
			if($this->_fetch == '0')
			{
				$row = $this->_result;
			}
			else
			{

				$fetch = $this->_fetch;
				$fetchtype = $this->_fetchtype;
				$row = $this->_queryEx->$fetch($fetchtype);
			}

		}
		else
		{
			$row = $this->_queryEx->fetch(PDO::FETCH_NUM);

		}




		$this->_queryEx->closeCursor();
		$this->clear();
		return $row;


	}


	 /** Describes a Table **/

	protected function _describe()
	{
		global $cache;

		$this->_describe = $cache->get('describe'.$this->_table);


		if (!$this->_describe)
		{
			$this->_describe = array();
			$query = 'SELECT * FROM  information_schema.COLUMNS WHERE table_name = \''.$this->_table . '\'';
			$this->_queryEx = $this->_dbHandle->prepare($query);
			$this->_result = $this->_queryEx->execute();

			while ($row = $this->_queryEx->fetch(PDO::FETCH_NUM))
			{
				 array_push($this->_describe,$row[0]);
			}

			$this->_queryEx->closeCursor();
			$cache->set('describe'.$this->_table,$this->_describe);
		}

		foreach ($this->_describe as $field)
		{
			$this->$field = null;
		}
	}


	/** Delete an Object **/

	function delete()
	{
		if ($this->id)
		{
			$query = 'DELETE FROM '.$this->_db.$this->_table.' WHERE id=:id';
			$this->_queryEx = $this->_dbHandle->prepare($query);
			$this->_queryEx->bindParam(':id', $this->id);
			$this->_result = $this->_queryEx->execute();
			$this->clear();
			if ($this->_result == 0) {
			    /** Error Generation **/
				return -1;
		   }
		} else {
			/** Error Generation **/
			return -1;
		}

	}


	/** Saves an Object i.e. Updates/Inserts Query **/

	function save()
	{
		$query = '';
		$whereIdColumn = '';
		if (isset($this->id))
		{
			$updates = '';
			foreach ($this->_describe as $field)
			{
				if ($this->$field) {
					$updates .= $field.' = :'.$field.',';
					$this->_bind[':' . $field] = $this->$field;
				}
			}

			$updates = substr($updates,0,-1);

			if($this->table == 'userall' || $this->table == 'professional' || $this->table == 'usernormal')
			{
				$whereIdColumn = 'id';
			}
			else
			{
				$whereIdColumn = $this->table . 'id';
			}

			$query = 'UPDATE '.$this->_db.$this->_table.' SET '.$updates.' WHERE ' . $whereIdColumn . '= :'.$whereIdColumn;
			$this->_bind[':' . $whereIdColumn] = $this->id;

		}
		else
		{
			$fields = '';
			$values = '';
			foreach ($this->_describe as $field)
			{
				if ($this->$field)
				{
					$fields .= $field.',';
					$bindParamFields = ':'.$field.',';
					$this->_bind[':'.$field ] = $this->field;
				}
			}
			$values = substr($values,0,-1);
			$fields = substr($fields,0,-1);

			$query = 'INSERT INTO '.$this->_db.$this->_table.' ('.$fields.') VALUES ('.$bindParamFields.')';
		}
		$this->_queryEx = $this->_dbHandle->prepare($query);
		$this->_queryEx->bindParam($this->_bind);
		$this->_result = $this->_queryEx->execute();
		$this->clear();
		if ($this->_result == 0) {
            /** Error Generation **/
			return -1;
        }
	}

	/** Clear All Variables **/

	function clear()
	{
		foreach($this->_describe as $field) {
			$this->$field = null;
		}

		$this->_queryEx= null;
		$this->_bind=null;

		$this->_orderby = null;
		$this->_extraConditions = null;
		$this->_hO = null;
		$this->_hM = null;
		$this->_hMABTM = null;
		$this->_page = null;
		$this->_order = null;
	}


	/** Pagination Count **/

	function totalPages()
	{
		if ($this->_query && $this->_limit)
		{
			$pattern = '/SELECT (.*?) FROM (.*)LIMIT(.*)/i';
			$replacement = 'SELECT COUNT(*) FROM $2';
			$countQuery = preg_replace($pattern, $replacement, $this->_query);
			$this->_queryEx = $this->_dbHandle->prepare($countQuery);
			if($this->_bind)
			{
				$this->_queryEx->bindParam($this->_bind);

			}
			$this->_result = $this->_queryEx->execute();
			$count = $this->_queryEx->fetch(PDO::FETCH_NUM);
			$totalPages = ceil($count[0]/$this->_limit);
			return $totalPages;
		}
		else
		{
			/* Error Generation Code Here */
			return -1;
		}
	}

	/** Get error string **/

    function getError()
    {
        return $this->_dbHandle->errorInfo();
    }



}
