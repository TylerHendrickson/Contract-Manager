<?php

require_once dirname(__FILE__) . './../util/db.php';
require_once dirname(__FILE__) . './../util/util.php';
require_once dirname(__FILE__) . './contract.php';

class Writer extends Contract {

    private $compensationMin;
    private $compensationMax;

    public function setCompensationMin($newCompensationMin) {
        $this->compensationMin = $newCompensationMin;
    }

    public function getCompensationMin() {
        return $this->compensationMin;
    }

    public function setCompensationMax($newCompensationMax) {
        $this->compensationMax = $newCompensationMax;
    }

    public function getCompensationMax() {
        return $this->compensationMax;
    }

    function __construct($contractId, $contractorId, $contracteeId, $status, $type, $compensationMin, $compensationMax) {
        parent::__construct($contractorId, $contracteeId, $status, $type);
        $this->setId($contractId);
        $this->setCompensationMin($compensationMin);
        $this->setCompensationMax($compensationMax);
    }
    
    private function buildContractDetailFromResult($result) {
        $writer = Writer::buildContractDetailsFromResult($result);
        return $writer[0];
    }

    private function buildContractDetailsFromResult($result) {
        //Define database columns
        $columns = array(
            'contract_id',
            'compensation_min',
            'compensation_max'
        );
        $map = $result->bindColumnsByArray($columns);
        $writers = array();
        while ($result->fetch()) {
            $writer = new Writer(NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
            $writer->setId($map['contract_id']);
            $writer->setCompensationMin($map['compensation_min']);
            $writer->setCompensationMax($map['compensation_max']);
            array_push($writers, $writer);
        }
        return $writers;
    }

    function getContractDetailById($writerId) {
        $db = new DB();
        $sql = "SELECT contract_id, compensation_min, compensation_max
            FROM writers WHERE contract_id = ?";
        $result = $db->execute($sql, array($writerId));
        if ($result->rowCount() == 0) {
            return new Writer();
        }
        return Writer::buildContractDetailFromResult($result);
    }

    function create($writer) {
        $writer->id = $this->createContract($writer);
        $db = new DB();
        $db->beginTransaction();
        $sql = "INSERT INTO writers
            (contract_id, compensation_min, compensation_max)
            VALUES (?, ?, ?);";
        $db->execute($sql, array(
            $writer->id,
            $writer->compensationMin,
            $writer->compensationMax
        ));
        $db->commit();
        $db->disconnect();
        return $writer->id;
    }

    function update($writer) {
        //$this->updateContract($writer);
        $db = new DB();
        $db->beginTransaction();
        $sql = "UPDATE writers
            SET compensation_min = ?, compensation_max = ?
            WHERE contract_id = ? LIMIT 1;";
        $db->execute($sql, array(
            $writer->getCompensationMin(),
            $writer->getCompensationMax(),
            $writer->getId()
        ));
        $db->commit();
        $db->disconnect();
        return TRUE;
    }

    function delete($writer) {
        //Delete child row first to protect against orphan records
        $db = new DB();
        $db->beginTransaction();
        $sql = "DELETE FROM writers WHERE id = ? LIMIT 1;";
        $db->execute($sql, array($writer->id));
        $db->commit();
        $db->disconnect();
        //Now delete parent
        $this->deleteContract($writer);
    }

}

?>
