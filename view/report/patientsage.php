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

$patient_with_age = ReportController::patientsAge();

?>

    <table class="table table-responsive dataTable">
        <thead>
        <tr>
            <th>S/N</th>
            <th>Name</th>
            <th>Registration Number</th>
            <th>Age</th>
        </tr>
        </thead>
        <tbody id="new_patient">
        <?php if (count($patient_with_age) == 0) {?>
            <tr>
                <td></td>
                <td></td>
                <td class="text-center">No patients found</td>
                <td></td>
            </tr>
        <?php }else { $counter = 0;?>
            <?php foreach ($patient_with_age as $patient) { ?>
                <tr>
                    <td><?php echo ++$counter; ?></td>
                    <td><?php echo $patient['patient_name']; ?></td>
                    <td><?php echo $patient['regNo']; ?></td>
                    <td><?php echo $patient['age']; ?></td>
                </tr>
            <?php } ?>
        <?php } ?>
        </tbody>
        <tfoot id="total">
        <tr>

            <th></th>
            <th class="text-right">Total Number of Patients</th>
            <th><?php echo count($patient_with_age); ?></th>
            <th></th>
        </tr>

        </tfoot>
    </table>



<?php require_once 'includes/iframe-footer.php';