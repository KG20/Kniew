<?php

/**
*
*/
class Search extends Model
{

	public function searchall($fields, $search ='' , $location = '', $type = null, $focus ='', $page = 1, $perPage= 10)
	{
		$this->_fetch = fetchAll;
		$this->_fetchtype = PDO::FETCH_ASSOC;
		$where = '';
		$order = '';


		$query = "SELECT ".$fields." FROM " . DB_SCHEMA . ".search_index  ";
		$this->_bind = [];

		if(isset($search) && $search != '' && $search != ' ')
		{
			$where .= " AND document @@ to_tsquery('english' , :search)";
			$this->_bind[':search'] = $search;
			$order = " ORDER BY ts_rank(document, to_tsquery('english', :search)) DESC ";
		}

		if(isset($location) && $location != '')
		{
			$location = preg_replace('/[^a-zA-Z]+/', ' ', $location);
			$where .= " AND :location OPERATOR(".DB_SCHEMA.".<%) location";
			$this->_bind[':location'] = $location;
		}

		if($type)
		{
			$where .= " and type = :type ";
			$this->_bind[':type'] = $type;
		}

		if(isset($focus) && $focus != '')
		{
			$focus = preg_replace('/[^a-zA-Z]+/', ' ', $focus);
			$where .= " AND :focus OPERATOR(".DB_SCHEMA.".<%) focus";
			$this->_bind[':focus'] = $focus;
		}

		if($where != '')
		{
		    $where = substr($where, 4);

			$where = ' where ' . $where;
		}
		$start = ($page-1)*$perPage;
		if ($start<0) $start = 0;

		$query .= $where . $order . ' OFFSET ' . $start . ' LIMIT ' . $perPage . ';';


		$result = $this->custom($query);
		return $result;

	}



}
