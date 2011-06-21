<?php

require_once dirname(__FILE__) . './../util/db.php';
require_once dirname(__FILE__) . './../util/util.php';

class Contract {

    private $id;
    private $contractorId;
    private $contracteeId;
    private $status; //Incomplete, Unsent, Pending, Finalized
    private $type;
    private $contractorSignature;
    private $contractorSigndate;
    private $contracteeSignature;
    private $contracteeSigndate;

    public function setId($newId) {
        $this->id = $newId;
    }

    public function getId() {
        return $this->id;
    }

    public function setContractorId($newContractorId) {
        $this->contractorId = $newContractorId;
    }

    public function getContractorId() {
        return $this->contractorId;
    }

    public function setContracteeId($newContracteeId) {
        $this->contracteeId = $newContracteeId;
    }

    public function getContracteeId() {
        return $this->contracteeId;
    }

    public function setStatus($newStatus) {
        $this->status = $newStatus;
    }

    public function getStatus() {
        return $this->status;
    }

    public function setType($newType) {
        $this->type = $newType;
    }

    public function getType() {
        return $this->type;
    }

    public function setContractorSignature($newContractorSignature) {
        $this->contractorSignature = $newContractorSignature;
    }

    public function getContractorSignature() {
        return $this->contractorSignature;
    }

    public function setContractorSigndate($newContractorSigndate) {
        $this->contractorSigndate = $newContractorSigndate;
    }

    public function getContractorSigndate() {
        return $this->contractorSigndate;
    }

    public function setContracteeSignature($newContracteeSignature) {
        $this->contracteeSignature = $newContracteeSignature;
    }

    public function getContracteeSignature() {
        return $this->contracteeSignature;
    }

    public function setContracteeSigndate($newContracteeSigndate) {
        $this->contracteeSigndate = $newContracteeSigndate;
    }

    public function getContracteeSigndate() {
        return $this->contracteeSigndate;
    }

    function __construct($contractorId, $contracteeId, $status, $type) {
        $this->setContractorId($contractorId);
        $this->setContracteeId($contracteeId);
        $this->setStatus($status);
        $this->setType($type);
    }

    private function buildContractFromResult($result) {
        $contract = Contract::buildContractsFromResult($result);
        return $contract[0];
    }

    private function buildContractsFromResult($result) {
        //Define database columns
        $columns = array(
            'id',
            'contractor_id',
            'contractee_id',
            'status',
            'type',
            'contractor_signature',
            'contractor_signdate',
            'contractee_signature',
            'contractee_signdate'
        );
        $map = $result->bindColumnsByArray($columns);
        $contracts = array();
        while ($result->fetch()) {
            $contract = new Contract(NULL, NULL, NULL, NULL);
            $contract->setId($map['id']);
            $contract->setContractorId($map['contractor_id']);
            $contract->setContracteeId($map['contractee_id']);
            $contract->setStatus($map['status']);
            $contract->setContractorSignature($map['contractor_signature']);
            $contract->setContractorSigndate($map['contractor_signdate']);
            $contract->setContracteeSignature($map['contractee_signature']);
            $contract->setContracteeSigndate($map['contractee_signdate']);
            array_push($contracts, $contract);
        }
        return $contracts;
    }

    function getAllContracts() {
        $db = new DB();
        $sql = "SELECT id, contractor_id, contractee_id, status, type, contractor_signature, contractor_signdate, contractee_signature, contractee_signdate 
            FROM contracts";
        $result = $db->execute($sql);
        return Contract::buildContractsFromResult($result);
    }

    function getContractsByContractorId($contractorId) {
        $db = new DB();
        $sql = "SELECT id, contractor_id, contractee_id, status, type, contractor_signature, contractor_signdate, contractee_signature, contractee_signdate 
            FROM contracts WHERE contractor_id = ?";
        $result = $db->execute($sql, array($contractorId));
        if ($result->rowCount() == 0) {
            return new Contract();
        }
        return Contract::buildContractsFromResult($result);
    }

    function getContractsByContracteeId($contracteeId) {
        $db = new DB();
        $sql = "SELECT id, contractor_id, contractee_id, status, type, contractor_signature, contractor_signdate, contractee_signature, contractee_signdate 
            FROM contracts WHERE contractee_id = ?";
        $result = $db->execute($sql, array($contracteeId));
        if ($result->rowCount() == 0) {
            return new Contract();
        }
        return Contract::buildContractsFromResult($result);
    }

    function getContractById($contractId) {
        $db = new DB();
        $sql = "SELECT id, contractor_id, contractee_id, status, type, contractor_signature, contractor_signdate, contractee_signature, contractee_signdate 
            FROM contracts WHERE id = ?";
        $result = $db->execute($sql, array($contractId));
        if ($result->rowCount() == 0) {
            return new Contract();
        }
        return Contract::buildContractFromResult($result);
    }

    function createContract($contract) {
        $db = new DB();
        $id = -1;
        $db->beginTransaction();
        $sql = "INSERT INTO contracts 
            (id, contractor_id, contractee_id, status, type, contractor_signature, contractor_signdate, contractee_signature, contractee_signdate) 
            VALUES (NULL, ?, ?, ?, ?, ?, ?, ?, ?);";
        $db->execute($sql, array(
            $contract->contractorId,
            $contract->contracteeId,
            $contract->status,
            $contract->type,
            $contract->contractor_signature,
            $contract->contractor_signdate,
            $contract->contractee_signature,
            $contract->contractee_signdate
        ));
        $id = $db->lastInsertId();
        $db->commit();
        $db->disconnect();
        return $id;
    }

    function updateContract($contract) {
        $db = new DB();
        $db->beginTransaction();
        $sql = "UPDATE contracts
            SET contractor_id = ?, contractee_id = ?, status = ?, type = ?, contractor_signature = ?, contractor_signdate = ?, contractee_signature = ?, contractee_signdate = ?
            WHERE id = ? LIMIT 1;";
        $db->execute($sql, array(
            $contract->contractorId,
            $contract->contracteeId,
            $contract->status,
            $contract->type,
            $contract->contractor_signature,
            $contract->contractor_signdate,
            $contract->contractee_signature,
            $contract->contractee_signdate,
            $contract->id
        ));
        $db->commit();
        $db->disconnect();
        return TRUE;
    }

    function deleteContract($contract) {
        $db = new DB();
        $db->beginTransaction();
        $sql = "DELETE FROM contracts WHERE id = ? LIMIT 1;";
        $db->execute($sql, array($contract->id));
        $db->commit();
        $db->disconnect();
        return TRUE;
    }

}

?>
