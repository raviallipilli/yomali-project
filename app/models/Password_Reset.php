<?php
class Password_Reset extends Base
{
	private $__pdo;
	const DBTable = 'password_reset';

	public function __construct()
	{
		//parent class __constructed included
		parent::__construct();

		$this->__pdo = new DB_PDO;
	}

	public function Select($where = array(), $limit = null, $start = null, $order_by = null, $select_cols = null)
	{
		$data = $this->__pdo->Select(self::DBTable, $where, $limit, $start, $order_by, $select_cols);
		return $data;
	}
}