<?php
include '../../../includes/auth_check.php';
if ($_SESSION['login'] == null) {
    Header("Location: ./auth.php ");
} else {
    $accessReq = 'contractor';
    include '../../../includes/check_access.php';
}



$contractId = $_GET['id'];

$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = 'admin';
$conn = mysql_connect($dbhost, $dbuser, $dbpass) or die('Error connecting to mysql');
$dbname = 'jettison_contract';
mysql_select_db($dbname);

$contractResult = mysql_query("SELECT * FROM contracts WHERE id='$contractId'");
while ($row = mysql_fetch_array($contractResult)) {
    $contractType = $row["type"];
    $contractorId = $row["contractor_id"];
    $contracteeId = $row["contractee_id"];
    $contractorSignature = $row["contractor_signature"];
    $contractorSigndate = $row["contractor_signdate"];
}

$detailResult = mysql_query("SELECT * FROM photographers WHERE contract_id='$contractId'");
while ($row = mysql_fetch_array($detailResult)) {
    $compensationMin = $row["compensation_min"];
    $compensationMax = $row["compensation_max"];
}

$contractorName = mysql_result(mysql_query("SELECT name FROM users WHERE id='$contractorId'"), 0);
$contracteeName = mysql_result(mysql_query("SELECT name FROM users WHERE id='$contracteeId'"), 0);
?>

<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
<html xmlns='http://www.w3.org/1999/xhtml'>
    <head>
        <meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
        <title>Jettison Quarterly - Services Contract Agreement</title>
    </head>

    <body>
        <br /><br />
        <form id='contract_form' name='contract_form' method='post' action='../../../php/controller/contract.php?action=update'>
            <table id='table1' width='90%' border='0' cellspacing='2' cellpadding='1' align='center'>
                <tr><td colspan='4'>
                        <div align='center'>AGREEMENT FOR  EMPLOYMENT AND PHOTOGRAPHY SERVICES<br /><br /></div>
                    </td></tr>
                <br /><tr><td colspan='4'>
                <p>III. Compensation and benefits to the  employee. </p>
                <p>   1. Payment of contributor’s byline and  masthead credit for written and/or graphic content contributed <em>Jettison </em>Quarterly,  with the possibility of <b>$<input type="text" id="compensation_min" name="compensation_min" value="<?php echo $compensationMin ?>" /></b> per assignment of less than 2  hours duration and/or <b>$<input type="text" id="compensation_max" name="compensation_max" value="<?php echo $compensationMax ?>" /></b> per assignment of greater than  2 hours duration should the employer’s financial resources permit such payment. </p>
                <p>   2. The ability of the employee to use any  materials created in the execution of this contract, as well as any  representations of the employee’s work used by the employer, as portfolio  references and work examples. </p>
                <p>   3. The employer agrees to reimburse the  employee for physical materials and expenses required to reasonably complete  the agreed-upon services. The employee will, in turn, provide verification of  the cost of such materials and expenditures to the employer upon request. This  includes office supplies, all travel necessary to complete the above-listed  services, and the acquisition/purchase of any equipment required for the  completion of the above-listed services.<br />
                    4. The employee is to be eligible for  increases in salary, bonus incentives, options to participate in group plans if  eligible (i.e. various insurance coverage, 401K/profit-sharing, et cetera, as  made available to all employees), and annual renegotiations/renewals of  employment contracting in the company or companies that encompass the business  entities currently manifesting as a Website <em>Jettison </em>Quarterly.com and  any print versions of the publication <em>Jettison </em>Quarterly</p>
                <p>   5. The abovementioned compensation and  incentives will commence no later than June 1, 2009 and end no later than  December 31, 2009. </p>
                <p>   6. All compensation and payment from the  employer to the employee relating to the above-delineated services will be  rendered on a biweekly or monthly basis, as agreed upon by both parties, unless  otherwise discussed and confirmed in writing by the employer and employee. The  employee enters into this agreement with the employer under good faith and  understands that the employer will make a similar good faith effort to deliver  the agreed-upon compensation as delineated in this contract. However, the  employee acknowledges the current lack of resources for the proper operation of <em>Jettison </em>Quarterly and agrees to allow a reasonable timeframe before  utilizing outside (i.e., legal or debt collection) means to obtain the promised  compensation. </p>
                <p align='center'>***</p>
                <p>It is understood that both parties agree  the aforementioned payment will serve as complete and total satisfaction with  regard to the agreed-upon services and no further payment or compensation can  be expected by the employee from the employer in connection to those services  in any form. </p>
                <p>The employee’s signature and return of one  (1) signed and dated copy of this agreement to the employer will indicate  acceptance of the foregoing terms as the entire understanding between <em>Jettison </em>Quarterly and <b><u><?php echo $contracteeName ?></u></b> concerning the agreed-upon services,  and will constitute a legal and binding contract between said parties.</p><br />
                <p>
                    <strong>Employer’s Verification:</strong>
                    <i><input type="text" id="contractor_signature" name="contractor_signature" value="<?php echo $contractorSignature ?>" /></i>
                        <strong>Date:</strong>
                    <input type="text" id="contractor_signdate" name="contractor_signdate" value="<?php echo $contractorSigndate ?>" />  <br />
                    <em>Jettison </em>Quarterly<br />
                    <?php echo $contractorName ?><br />
                    1038 West 18th Street <br />
                    Chicago, IL 60608-2357 <br />
                    (312) 526-3377 <br />
                    info@jettisonquarterly.com</p>
                <p>&nbsp;</p></td></tr>
                <tr><td width='12%' align='right'>
                        <strong>Employee’s Verification:</strong></td>
                    <td width='16%' align='left'>
                        <input name='contractee_signature' type='text' id='contractee_signature' value='' size='40' style='font-style:italic' disabled /></td>
                    <td width='3%' align='right'><strong>Date:</strong></td>
                    <td width='68%' align='left'>(<b><i>Pending</i></b>)</td>
                <tr><td align='right'>
                        <strong>Employee's Full Name: </strong></td>
                    <td align='left' colspan='3'>$contracteeName</td>
                    <td width='0%'></strong><td width='1%'></p>

                <tr><td align='right'>
                        <strong>Street Address:</strong></td>
                    <td align='left' colspan='3'><input name='address_street' type='text' id='address_street' size='50' disabled /></td>
                </tr>
                <tr>
                    <td align='right'>
                        <strong>City:</strong></td>
                    <td align='left' colspan='3'>
                        <input name='address_city' type='text' id='address_city' size='30' disabled /></td>
                </tr>
                <tr><td align='right'>
                        <strong>State:</strong></td>
                    <td align='left' colspan='3'>
                        <input name='address_state' type='text' id='address_state' size='30' disabled /></td>
                </tr>
                <tr><td align='right'>
                        <strong>Zip-Code:</strong></td>
                    <td align='left' colspan='3'>
                        <input name='address_zip' type='text' id='address_zip' size='30' disabled /></td>
                </tr>
                <tr><td align='right'>
                        <strong>Phone:</strong></td>
                    <td align='left' colspan='3'>
                        ( <input name='phone1' type='text' id='phone1' size='5' maxlength='3' disabled />
                        ) <input name='phone2' type='text' id='phone2' size='5' maxlength='3' disabled />-<input name='phone3' type='text' id='phone3' size='8' maxlength='4' disabled /></td>
                </tr>
                <tr><td align='right'>
                        <strong>E-mail Address:</strong></td>
                    <td align='left' colspan='3'>
                        <input name='email' type='text' id='email' value='$contractee_email' size='50' disabled /></td>
                </tr>
                <tr>
                    <input type="hidden" id="contract_id" name="contract_id" value="<?php echo $contractId ?>" />
                    <input type="hidden" id="contract_type" name="contract_type" value="<?php echo $contractType ?>" />
                    <td colspan='4' align='center'><br /><input name='submit' id="submit" type='submit' value='Agree &amp; Submit' /></td></tr>
            </table>
        </form>
    </body>
</html>