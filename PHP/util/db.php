<?php
require_once 'resultset.php';

/*
 * This class is a wrapper class of PDO (PHP Data Objects).
 * PDO provides several function of database connections, sql executions, and so on.
 * This class makes PDO easier to use.
 */
class DB{
	const SERVER = 'localhost';
	const USER = 'root';
        const PASS = 'admin';
	const DATABASE = 'jettison_contract';
	private $connection = null;
	/*
	 * The constructor gets a connection from database.
	 */
	function __construct(){
		$dsn = 'mysql:dbname='.DB::DATABASE.';host='.DB::SERVER.';charset=utf8';
		$this->connection = $pdo = new PDO($dsn, DB::USER, DB::PASS);
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}

	/*
	 * This function disconnects the connection.
	 */
	function disconnect(){
		$this->connection = null;
	}

	/*
	 * This function begins a transaction.
	 * You should use transactions when changing tables with several statements
	 * because, if an error happens, the transaction can be rollback.
	 * Otherwise, the changes are immidiately commited and your executions are stuck in the middle.
	 * And make sure comming after execute SQL.
	 */
	function beginTransaction(){
		$this->connection->beginTransaction();
	}

	/*
	 * This function executes a prepared statement with parameters.
	 * Prepared statements can avoid SQL injections.
	 *
	 * It looks like "Select id, firstname, lastname, age From user Where lastname = ? and age = ?;"
	 * and the parameters are like this "array(Smith, 22)"
	 *
	 * If the statement is either add, update, or delete, the returned resultset can be ignored.
	 */
	function execute($sql,$param=array()){
		$stmt = $this->connection->prepare($sql);
		$stmt->execute($param);
		return new ResultSet($stmt);
	}

	/*
	 * This function returns the ID when the insert statement was executed.
	 */
	function lastInsertId(){
		return $this->connection->lastInsertId();
	}

	/*
	 * This function commits a transaction.
	 */
	function commit(){
		$this->connection->commit();
	}

	/*
	 * This function makes a transaction rollback.
	 */
	function rollback(){
		$this->connection->rollback();
	}
}
