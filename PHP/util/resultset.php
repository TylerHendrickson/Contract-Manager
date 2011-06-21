<?php
/*
 * This class is a wrapper class of PDOStatement class.
 * PDOStatement is a SQL statement class, but after executed, it becomes a result of the execution.
 * This class makes the result easier to use.
 */
class ResultSet{
	private $result = null;
	function __construct($result){
		$this->result = $result;
	}
	
	/*
	 * This function return how many rows are in the result.
	 */
	function rowCount(){
		return $this->result->rowCount();
	}

	/*
	 * This function binds a column to a variant.
	 * The binded variants become column values as the fetch function is called.
	 */
	private function bindColumn($i, &$val){
		$this->result->bindColumn($i, $val);
	}
	
	/*
	 * This function binds columns to variants using an array containing refered names.
	 * It returns a hashmap that has keys(referred name) and values(column value after fetched).
	 * Notice that referred names can differ from the actual column names. 
	 * 
	 * Ex.
	 * $sql = "Select firstname, lastname, age From user;";
	 * $result = $db->execute($sql);
	 * $map = $result->bindColumnByArray(array("first","last","age"));
	 * 
	 * $result->fetch();
	 * $first = $map['first'];
	 * $last = $map['last'];
	 * $age = $map['age'];
	 */
	function bindColumnsByArray($arr){
		$hash = array();
		for ($i = 0; $i < count($arr); $i++) {
			$hash[$arr[$i]] = null;
			$this->bindColumn($i+1, $hash[$arr[$i]]);
		}
		return $hash;
	}
	
	/*
	 * This function fetches the value from result.
	 * The values should be binded by bind- functions.
	 * The FETCH_BOUND returns if there is the next row.
	 */
	function fetch($type=PDO::FETCH_BOUND){
		return $this->result->fetch($type);
	}
}

