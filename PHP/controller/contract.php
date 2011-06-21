<?php

require_once '../model/' . $_POST["contract_type"] . '.php';

$action = $_GET['action'];

switch ($action) {
    case 'create':
        $result = create($_POST["contractee_id"], $_POST["contractor_id"], $_POST["contract_type"]);
        if ($result != FALSE) {
            $type = $_POST["contract_type"];
            header("location:../../pages/contractor/contract/" . $type . "_edit.php?id=" . $result);
        }
        break;
    case 'update':
        $result = update($_POST["contract_id"], $_POST["compensation_min"], $_POST["compensation_max"], $_POST["contractor_signature"], $_POST["contractor_signdate"]);
        if ($result != FALSE) {
            $type = $_POST["contract_type"];
            header("location:../../pages/contractor/contract/" . $type . "_edit.php?id=" . $result);
        }
        break;
}

function create($contractorId, $contracteeId, $contractType) {
    switch ($contractType) {
        case 'photographer':
            $contract = new Photographer(NULL, $contractorId, $contracteeId, 'Incomplete', $contractType, NULL, NULL);
            break;
        case 'writer':
            $contract = new Writer($contractorId, $contracteeId, 'Incomplete', $contractType, NULL, NULL);
            break;
    }
    $contractId = $contract->create($contract);
    if ($contractId) {
        return $contractId;
    } else {
        return FALSE;
    }
}

function update($contractId, $compensationMin, $compensationMax, $contractorSignature, $contractorSigndate) {
    switch ($_POST['contract_type']) {
        case 'photographer':
            $contract = Photographer::getContractDetailById($contractId);
            break;
        case 'writer':
            $contract = Writer::getContractDetailById($contractId);
            break;
    }
    $contract->setCompensationMin($compensationMin);
    $contract->setCompensationMax($compensationMax);
    $update = $contract->update($contract);
    if ($update) {
        return $contractId;
    } else {
        return FALSE;
    }
}

?>
