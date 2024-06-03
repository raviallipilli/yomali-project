<?php
class Visits extends Base
{
	private $__pdo;
	const DBTable = 'visits';

	public function __construct()
	{
		//parent class __constructed included
		parent::__construct();

		$this->__pdo = new DB_PDO;
	}

	public function getUniqueVisits($startDate = null, $endDate = null, $user_id = null)
	{
		$sql = 'SELECT 
				v.user_id,
				u.email,
				v.url,
				v.page_name,
				v.ip,
				COUNT(v.ip) AS total_visits,
				COUNT(DISTINCT v.ip) AS unique_visits,
				SUM(TIMESTAMPDIFF(SECOND, v.entry_timestamp, v.exit_timestamp)) / COUNT(v.ip) AS avg_duration_seconds,
				v.user_agent,
				v.entry_timestamp
			FROM 
				'.self::DBTable.' v
			LEFT JOIN users u ON v.user_id = u.user_id
			WHERE 
				v.entry_timestamp BETWEEN "'.$startDate.'" AND "'.$endDate.'"';

		// Add condition to filter by user_id if provided
		if ($user_id !== null) {
			$sql .= ' AND v.user_id = ' .$user_id;
		}

		$sql .= ' GROUP BY 
					v.user_id, u.email, v.url, v.page_name
				ORDER BY 
					v.entry_timestamp DESC';
					
		$this->__pdo->Prepare_query($sql);
		return $data = $this->__pdo->Get_data_array_assoc();
	}

	public function Save($params = array(), $primary_key_column = null)
	{
		$params['createdate'] = $this->createdate;
		$params['updatedate'] = $this->updatedate;

		$primary_key = $this->__pdo->Insert(self::DBTable, $params);

		//output the data that was inserted
		if(!is_null($primary_key_column))
		{
			$where = array();
			$where[$primary_key_column] = $primary_key;
			return $this->Select($where);
		}
		return array();
	}

}