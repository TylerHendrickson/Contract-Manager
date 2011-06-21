<?php
include '../../../includes/auth_check.php';
if ($_SESSION['login'] == null) {
    Header("Location: ./auth.php ");
} else {
    $accessReq = 'contractor';
    include '../../../includes/check_access.php';
}

$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = 'admin';
$conn = mysql_connect($dbhost, $dbuser, $dbpass) or die('Error connecting to mysql');
$dbname = 'jettison_contract';
mysql_select_db($dbname);

$result = mysql_query("SELECT id, name FROM users");
$contractee_options = "";

while ($row = mysql_fetch_array($result)) {
    $id = $row["id"];
    $name = $row["name"];
    $contractee_options.="<OPTION VALUE=\"$id\">" . $name . "</option>";
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Create New Contract</title>
        <link rel="stylesheet" href="../../../style.css" type="text/css" />
    </head>
    <body>
        <div id="tab">
            <?php include '../../../includes/contractor_top_tabs.php'; ?>
            <div class="bottom">
            </div>
        </div>
        <div id="content">
            <form name="createcontract" id="createcontract" method="post" action="../../../php/controller/contract.php?action=create">
                <div align="center">
                    <h3>Create New Contract</h3><br />
                        Select Contractee: 
                        <select name="contractee_id" id="contractee_id">
                            <option value="0">Select user...</option>
                            <?php echo $contractee_options ?>
                        </select><br />
                        Select Contract Type: 
                        <select name="contract_type" id="contract_type">
                            <option value="0">Select type...</option>
                            <option value="photographer">Photographer Contract</option>
                            <option value="writer">Writer Contract</option>
                        </select><br />
                        <input type="hidden" id="contractor_id" name="contractor_id" value="<?php echo $_SESSION['login']; ?>" />
                        <input type="submit" id="submit" name="submit" value="Create Contract" />
                    </div>
                </div>
            </form>
        </div>
    </body>
</html>