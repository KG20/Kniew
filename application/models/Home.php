<?php
	
	/**
	* Model class for home (default class for model)
	*/
	class Home extends Model
	{

		public function getAll($page, $perPage = 6, $location = '')
		{
			$this->_fetch = fetchAll;
			$this->_fetchtype = PDO::FETCH_ASSOC;

			$start = ($page-1)*$perPage;
			if ($start<0) $start = 0;
			
			if(isset($location) && $location != '')
			{
				$this->_bind[':location'] = $location;
				$locatequery = ' AND :location OPERATOR(website.<%) formattedaddress ';
				// 'patti uttar' OPERATOR(website.<%) formattedaddress
			}


			$query = '(SELECT articleid::varchar as identity,articledetails->>\'title\' as title, articledetails->>\'filepath\' as displayimg, 0 as type, articledetails->\'tags\'->>0 as focus FROM ' . DB_SCHEMA . '.article ORDER BY articleid desc OFFSET ' . $start . ' LIMIT ' . $perPage . ')
					UNION all
				(SELECT username as identity, name as title, profilepic as displayimg, usertype as type, focus FROM '.DB_SCHEMA.'.professional INNER JOIN '.DB_SCHEMA.'.focus on mainfocus = focusid where usertype = 2 '.$locatequery.' ORDER BY  professional.rate desc nulls last OFFSET ' . $start . ' LIMIT ' . $perPage . ')
				UNION all
				(SELECT username as identity, name as title, profilepic as displayimg, usertype as type, focus FROM '.DB_SCHEMA.'.professional INNER JOIN '.DB_SCHEMA.'.focus on mainfocus = focusid  where usertype = 3 '.$locatequery.' ORDER BY  professional.rate desc nulls last OFFSET ' . $start . ' LIMIT ' . $perPage . ')
				UNION all
				(SELECT username as identity, name as title, profilepic as displayimg, usertype as type,focus FROM '.DB_SCHEMA.'.professional INNER JOIN '.DB_SCHEMA.'.focus on mainfocus = focusid  where usertype = 4 '.$locatequery.' ORDER BY  professional.rate desc nulls last OFFSET ' . $start . ' LIMIT ' . $perPage . ')
				UNION all
				(SELECT username as identity, name as title, profilepic as displayimg, usertype as type,focus FROM '.DB_SCHEMA.'.professional  INNER JOIN '.DB_SCHEMA.'.focus on mainfocus = focusid where usertype = 5 '.$locatequery.' ORDER BY  professional.rate desc nulls last OFFSET ' . $start . ' LIMIT ' . $perPage . ')
				';	


			$result = $this->custom($query);
			return $result;

		}

		public function getlatestarticles($page, $perPage = 6)
		{
			$this->_fetch = fetchAll;
			$this->_fetchtype = PDO::FETCH_ASSOC;

			$start = ($page-1)*$perPage;
			if ($start<0) $start = 0;

			$query = 'SELECT articleid, articledetails->>\'title\' as title, articledetails->>\'filepath\' as filepath, articledetails->\'tags\'->>0 as focus FROM ' . DB_SCHEMA . '.article ORDER BY articleid desc OFFSET ' . $start . ' LIMIT ' . $perPage . '';			
			

			$result = $this->custom($query);
			return $result;

		}

		public function gettopbyrole($type, $page, $perPage = 6, $locatequery = '', $bind)
		{
			$this->_fetch = fetchAll;
			$this->_fetchtype = PDO::FETCH_ASSOC;

			$start = ($page-1)*$perPage;
			if ($start<0) $start = 0;

			$query = 'SELECT username, name, profilepic, focus FROM '.DB_SCHEMA.'.professional INNER JOIN '.DB_SCHEMA.'.focus ON mainfocus = focusid where usertype = '.$type.' '.$locatequery.' ORDER BY  professional.rate desc nulls last OFFSET ' . $start . ' LIMIT ' . $perPage;	
			$this->_bind = $bind;				

			$result = $this->custom($query);
			return $result;

		}
		
		
	}