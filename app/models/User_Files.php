<?php
class User_Files extends Base
{

	private $__pdo;
	const DBTable = 'files';

	public function __construct()
	{
		//parent class __constructed included
		parent::__construct();

		$this->__pdo = new DB_PDO;
	}

	public function Get_all()
	{	
		$sql= 'select u.email,
		f.id,
		f.title,
		f.original_filename,
		f.createdate 	
		FROM '.self::DBTable.' f 
		left join users u on u.user_id = f.user_id
		where f.user_id = '.$_SESSION['login_id'].' and
		f.is_deleted = 0
		order by f.title asc';
		
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

	public function Update($params = array(), $where = array())
	{
		$params['updatedate'] = $this->updatedate;

		$this->__pdo->Update(self::DBTable, $params, $where);

		//output the data that was updated
		return $this->Select($where);
	}

	public function Select($where = array(), $limit = null, $start = null, $order_by = null, $select_cols = null)
	{
		$data = $this->__pdo->Select(self::DBTable, $where, $limit, $start, $order_by, $select_cols);
		return $data;
	}
}