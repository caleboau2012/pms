<?php
require_once '../_core/global/_require.php';

Crave::requireAll(GLOBAL_VAR);
Crave::requireAll(UTIL);
Crave::requireFiles(MODEL, array('BaseModel', 'ChemicalPathologyModel', 'HaematologyModel', 'MicroscopyModel', 'ParasitologyModel', 'VisualModel', 'RadiologyModel'));
Crave::requireFiles(CONTROLLER, array('LaboratoryController'));

if (!isset($_SESSION[UserAuthTable::userid])) {
    header("Location: ../index.php");
}

$lab = new LaboratoryController();

$view_bag = array();


$view_bag = $lab->getLabDetails($_POST['labType'], $_POST['treatment_id']);
var_dump($view_bag);

if ($view_bag[HaematologyTable::status_id] == 7){
    $disabled = 'disabled="disabled"';
}else { $disabled = '';}
?>

<body>

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12 well">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2 class="panel-title"><?php echo $_POST['surname'] .' '. $_POST['firstname'].' '. $_POST['middlename'];  ?></h2>
                </div>
                <div class="panel-body">
                    <p><?php echo $_POST['regNo']; ?></p>
                    <span><?php echo $_POST['sex']; ?></span>
                    <span></span>
                </div>
            </div>

            <div class="haematology">
                <div class="add-haematology">
                    <form id="addTestForm" class="form" method="post">
                        <input type="hidden" name="<?php echo 'data[details]['.RadiologyTable::radiology_id.']'; ?>"value="<?php echo $view_bag['radiology_id'] ?>">
                        <input type="hidden" name="<?php echo 'data[details]['.RadiologyTable::lab_attendant_id.']'; ?>" value="<?php echo $view_bag['lab_attendant_id'] ?>">
                        <input type="hidden" name="intent" value="updateLabDetails">
                        <input type="hidden" name="labType" value="radiology">

                        <div class="row">
                            <div class="page-header">
                                <a id="back" href="#" class="btn btn-default btn-sm" style="float: left;margin-right: 10px;margin-top: 5px; margin-left: 20px;">← Go Back</a>
                                <h2 class="page-header__title">Radiology (X-ray)</h2>
                            </div>

                            <div class="col-sm-12">
                                <div>
                                    <div class="test-label"> WARD / CLINIC : <input type="text" class="form-horizontal" name="<?php echo RadiologyTable::table_name . "[" . RadiologyTable::ward_clinic_id . "]"; ?>" /></div>
                                    <fieldset class="barX"><legend class="test-label">X-Ray Details</legend>
                                        <div class="form-group">
                                            <label for="xray-no" class="test-label col-sm-1 text-right">X-ray No:</label>
                                            <div class="col-sm-2">
                                                <input type="text" <?php echo $disabled; ?> id="xray-no" class="form-control" name="<?php echo XrayNoTable::table_name . "[" . XrayNoTable::xray_number . "]";  ?>">
                                            </div>
                                            <label for="casual-no" class="test-label col-sm-1 text-right">Casual No:</label>
                                            <div class="col-sm-2">
                                                <input type="text" <?php echo $disabled; ?> id="casual-no" class="form-control" name="<?php echo XrayNoTable::table_name . "[" . XrayNoTable::casual_no . "]"; ?>">
                                            </div>
                                            <label for="gp-no" class="test-label col-sm-1 text-right">G.P No:</label>
                                            <div class="col-sm-2">
                                                <input type="text" <?php echo $disabled; ?> id="gp-no" class="form-control" name="<?php echo XrayNoTable::table_name . "[" . XrayNoTable::gp_no . "]"; ?>">
                                            </div>
                                            <label for="ante-natal-no" class="test-label col-sm-1 text-right">Ante-Natal No:</label>
                                            <div class="col-sm-2">
                                                <input type="text" <?php echo $disabled; ?> id="ante-natal-no" class="form-control" name="<?php echo XrayNoTable::table_name . "[" . XrayNoTable::ante_natal_no . "]"; ?>">
                                            </div>
                                        </div>
                                    </fieldset>
                                    <fieldset class="barX"><legend class="test-label">Movement</legend>
                                        <?php
                                        $movement_list = new LabelList();

                                        $movement_list->addNode(new LabelNode("W. Case", 1));
                                        $movement_list->addNode(new LabelNode("W.Chair", 2));
                                        $movement_list->addNode(new LabelNode("Trolley", 3));
                                        $movement_list->addNode(new LabelNode("Theatre", 4));
                                        $movement_list->addNode(new LabelNode("Portable", 5));
                                        ?>

                                        <?php foreach ($movement_list->getList() as $label){?>
                                            <label class="test-label col-sm-1"><input type="radio" class="form" name="<?php RadiologyTable::table_name.'['.RadiologyTable::xray_case_id.']'; ?>">
                                                <?php echo $label->getLabel(); ?>
                                            </label>
                                        <?php } ?>
                                        <label class="test-label col-sm-1 text-right">L.M.P:</label>
                                        <div class="col-sm-3">
                                            <input type="text" <?php echo $disabled; ?> placeholder="L.M.P." class="form-control" name="<?php echo RadiologyTable::table_name . "[" . RadiologyTable::lmp . "]"; ?>"/>
                                        </div>
                                    </fieldset>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <fieldset class="barX"><legend class="test-label">If Examination is Requested</legend>
                                    <label class="test-label">Previous Operation</label>
                                    <div class="center-block">
                                        <input type="text" <?php echo $disabled; ?> class="col-sm-12 form-control" name="<?php echo ExaminationRequestedTable::table_name . "[" . ExaminationRequestedTable::previous_operation . "]"; ?>"/>
                                    </div>
                                    <label class="test-label">Any Known Allergies</label>
                                    <div class="center-block">
                                        <input type="text" <?php echo $disabled; ?> class="col-sm-12 form-control" name="<?php echo ExaminationRequestedTable::table_name . "[" . ExaminationRequestedTable::any_known_allergies . "]"; ?>"/>
                                    </div>
                                    <div class="test-label">Previous X-ray:
                                        <input type="radio" <?php echo $disabled; ?> value="1" name="<?php echo ExaminationRequestedTable::table_name . "[" . ExaminationRequestedTable::previous_xray . "]"; ?>"/> Yes
                                        <input  type="radio" <?php echo $disabled; ?> name="<?php echo ExaminationRequestedTable::table_name . "[" . ExaminationRequestedTable::previous_xray . "]"; ?>" value="0"/> No
                                    </div>
                                    <label class="test-label">Quote X-ray Number</label>
                                    <div class="center-block">
                                        <input type="text" <?php echo $disabled; ?> class="col-sm-12 form-control" name="<?php echo ExaminationRequestedTable::table_name . "[" . ExaminationRequestedTable::xray_number . "]"; ?>"/>
                                    </div>
                                </fieldset>
                                <fieldset class="barX"><legend class="test-label">For Completion By Physician:</legend>
                                    <div class="center-block">
                                        <textarea class="col-sm-12 form-control" <?php echo $disabled; ?> name="<?php echo ExaminationRequestedTable::table_name . "[" . ExaminationRequestedTable::clinical_diagnosis_details . "]"; ?>"></textarea>
                                    </div>
                                </fieldset>
                            </div>
                            <div class="col-sm-6">
                                <?php
                                $dimension_list = new LabelList();

                                $dimension_list->addNode(new LabelNode("17X14", 1));
                                $dimension_list->addNode(new LabelNode("14X4", 2));
                                $dimension_list->addNode(new LabelNode("15X12", 3));
                                $dimension_list->addNode(new LabelNode("12X10", 4));
                                $dimension_list->addNode(new LabelNode("10X8", 5));
                                $dimension_list->addNode(new LabelNode("15X6", 6));
                                $dimension_list->addNode(new LabelNode("8X6", 7));
                                ?>
                                <fieldset class="barX"><legend class="test-label">Dimension</legend>
                                    <div class="center-block">
                                        <table class="table table-striped table-responsive">
                                            <?php foreach ($dimension_list->getList() as $label) { ?>
                                                <tr>
                                                    <td class="test-label">&nbsp;<?php echo $label->getLabel(); ?> </td>
                                                    <td><input type="radio" <?php echo $disabled; ?> name="<?php echo RadiologyTable::table_name . "[" . RadiologyTable::xray_size_id . "]"; ?>"/></td>
                                                </tr>
                                            <?php } ?>
                                        </table>
                                    </div>
                                    <div class="test-label">Checked by:  <input type="text" <?php echo $disabled; ?> class="form-horizontal" name="<?php echo RadiologyTable::table_name . "[" . RadiologyTable::checked_by . "]"; ?>"/></div>
                                </fieldset>
                            </div>
                            <div class="col-sm-6 col-sm-offset-6"></div>
                            <div class="col-sm-6">
                                <fieldset class="barX"><legend class="test-label">Radiographer's Note:</legend>
                                    <div class="center-block">
                                        <textarea class="col-sm-12 form-control" <?php echo $disabled; ?> name="<?php echo RadiologyTable::table_name . "[" . RadiologyTable::radiographers_note . "]"; ?>" ></textarea>
                                    </div>
                                </fieldset>
                            </div>
                            <div class="col-sm-6">
                                <fieldset class="barX"><legend class="test-label">Radiologist's Report:</legend>
                                    <div class="center-block">
                                        <textarea class="col-sm-12 form-control" <?php echo $disabled; ?> name="<?php echo RadiologyTable::table_name . "[" . RadiologyTable::radiologists_report . "]"; ?>" ></textarea>
                                    </div>
                                </fieldset>
                            </div>
                            <div class="col-sm-6">
                                <fieldset class="barX"><legend class="test-label">Signed:</legend>
                                    <label class="test-label">Consultant In Charge of Case</label>
                                    <div class="center-block">
                                        <input type="text" <?php echo $disabled; ?> class="form-control col-sm-12" name="<?php echo RadiologyTable::table_name . "[" . RadiologyTable::consultant_in_charge . "]"; ?>" >
                                    </div>
                                </fieldset>
                            </div>
                            <?php
                            if ($view_bag['details'][HaematologyTable::status_id] == 5 || $view_bag['details'][HaematologyTable::status_id] == 6){?>
                                <div class="col-sm-6 submit-test">
                                    <input type='submit' id="submit" class='btn btn-primary pull-right pad' value='Submit' name='submit'>
                                    <input type='submit' id="save" class='btn btn-default pull-right pad' value='Save & Continue' name='save_continue'>
                                </div>
                            <?php } ?>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="../js/bootstrap/jquery-1.10.2.min.js"></script>
<script src="../js/bootstrap/jquery-ui.min.js"></script>
<script src="../js/bootstrap/bootstrap.min.js"></script>
<script src="../js/bootstrap/bootstrap-datepicker.min.js"></script>
<script src="../js/constants.js"></script>
<script src="../js/laboratory.js" type="text/javascript"></script>
</body>
</html>
