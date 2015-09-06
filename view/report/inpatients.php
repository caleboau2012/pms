<?php
/**
 * Created by PhpStorm.
 * User: Olaniyi
 * Date: 6/4/15
 * Time: 3:37 PM
 */
require_once 'includes/iframe-header.php';
require_once '../../_core/global/_require.php';

Crave::requireAll(GLOBAL_VAR);
Crave::requireAll(UTIL);
Crave::requireFiles(MODEL, array('BaseModel', 'ReportModel'));
Crave::requireFiles(CONTROLLER, array('ReportController'));

$inpatients = ReportController::inPatients();
?>

    <table class="table table-responsive dataTable">
        <thead>
        <tr>
            <th>S/N</th>
            <th>Name</th>
            <th>Registration Number</th>
        </tr>
        </thead>
        <tbody id="new_patient">
        <?php if (count($inpatients) == 0) {?>
            <tr>
                <td></td>
                <td class="text-center">No Inpatients</td>
                <td></td>
            </tr>
        <?php }else { $counter = 0;?>
            <?php foreach ($inpatients as $patient) { ?>
                <tr>
                    <td><?php echo ++$counter; ?></td>
                    <td><?php echo $patient['patient_name']; ?></td>
                    <td><?php echo $patient['regNo']; ?></td>
                </tr>
            <?php } ?>
        <?php } ?>
        </tbody>
        <tfoot id="total">
        <tr>
            <th></th>
            <th class="text-right">Total Number of  Inpatients</th>
            <th><?php echo count($inpatients); ?></th>
        </tr>

        </tfoot>
    </table>

<?php require_once 'includes/iframe-footer.php';