<?php

require_once dirname(__FILE__) . './../util/db.php';
require_once dirname(__FILE__) . './../util/util.php';
require_once dirname(__FILE__) . './contract.php';

class Photographer extends Contract {

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
        //Define database columns
        $columns = array(
            'contract_id',
            'compensation_min',
            'compensation_max',
        );
        $map = $result->bindColumnsByArray($columns);
        $photographers = array();
        while ($result->fetch()) {
            $photographer = new Photographer(NULL, NULL, NULL, NULL, NULL, NULL, NULL);
            $photographer->setId($map['contract_id']);
            $photographer->setCompensationMin($map['compensation_min']);
            $photographer->setCompensationMax($map['compensation_max']);
            array_push($photographers, $photographer);
        }
        return $photographers;
    }

    function getContractDetailById($photographerId) {
        $db = new DB();
        $db->beginTransaction();
        $sql = "SELECT contract_id, compensation_min, compensation_max
            FROM photographers WHERE contract_id = ?";
        $result = $db->execute($sql, array($photographerId));
        if ($result->rowCount() == 0) {
            return new Photographer();
        }
        return Photographer::buildContractDetailFromResult($result);
    }

    function create($photographer) {
        $photographer->id = $this->createContract($photographer);
        $db = new DB();
        $db->beginTransaction();
        $sql = "INSERT INTO photographers
            (contract_id, compensation_min, compensation_max)
            VALUES (?, ?, ?);";
        $db->execute($sql, array(
            $photographer->id,
            $photographer->compensationMin,
            $photographer->compensationMax
        ));
        $db->commit();
        $db->disconnect();
        return $photographer->id;
    }

    function update($photographer) {
        $this->updateContract($photographer);
        $db = new DB();
        $db->beginTransaction();
        $sql = "UPDATE photographers
            SET compensation_min = ?, compensation_max = ?
            WHERE id = ? LIMIT 1;";
        $db->execute($sql, array(
            $photographer->compensationMin,
            $photographer->compensationMax,
            $photographer->id
        ));
        $db->commit();
        $db->disconnect();
        return TRUE;
    }

    function delete($photographer) {
        //Delete child row first to protect against orphan records
        $db = new DB();
        $db->beginTransaction();
        $sql = "DELETE FROM photographers WHERE id = ? LIMIT 1;";
        $db->execute($sql, array($photographer->id));
        $db->commit();
        $db->disconnect();
        //Now delete parent
        $this->deleteContract($photographer);
    }

}

?>
