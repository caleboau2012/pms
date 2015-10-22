<?php
/**
 * Created by PhpStorm.
 * User: Olaniyi
 * Date: 10/22/15
 * Time: 5:08 PM
 */
require_once 'includes/iframe-header.php';
require_once '../../_core/global/_require.php';

Crave::requireAll(GLOBAL_VAR);
Crave::requireAll(UTIL);
Crave::requireFiles(MODEL, array('BaseModel', 'ReportModel'));
Crave::requireFiles(CONTROLLER, array('ReportController'));

$all_patients = ReportController::allPatients();

?>

    <table class="table table-responsive dataTable">
        <thead>
        <tr>
            <th>S/N</th>
            <th>Name</th>
            <th>Registration Number</th>
            <th>Gender</th>
        </tr>
        </thead>
        <tbody id="new_patient">
        <?php if (count($all_patients) == 0) {?>
            <tr>
                <td></td>
                <td></td>
                <td class="text-center">No new patients</td>
                <td></td>
            </tr>
        <?php }else { $counter = 0;?>
            <?php foreach ($all_patients as $patient) { ?>
                <tr>
                    <td><?php echo ++$counter; ?></td>
                    <td><?php echo $patient['patient_name']; ?></td>
                    <td><?php echo $patient['regNo']; ?></td>
                    <td><?php echo $patient['sex']; ?></td>
                </tr>
            <?php } ?>
        <?php } ?>
        </tbody>
        <tfoot id="total">
        <tr>
            <th></th>
            <th></th>
            <th class="text-right">Total Number of All Patients</th>
            <th><?php echo count($all_patients); ?></th>
        </tr>

        </tfoot>
    </table>

<?php require_once 'includes/iframe-footer.php';