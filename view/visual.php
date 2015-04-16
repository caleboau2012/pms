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
//var_dump($view_bag);

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
                    <form id="addTestForm" class="form" method="POST">
                        <input type="hidden" name="<?php echo 'data[details]['.VisualSkillsProfileTable::id.']' ?>" value="<?php echo $view_bag[VisualSkillsProfileTable::id] ?>" />
                        <input type="hidden" name="<?php  echo 'data[details]['.VisualSkillsProfileTable::lab_attendant_id.']' ?>" value="<?php if(isset($view_bag[VisualSkillsProfileTable::lab_attendant_id])) echo $view_bag[VisualSkillsProfileTable::lab_attendant_id] ?>" />
                        <input type="hidden" name="intent" value="updateLabDetails">
                        <input type="hidden" name="labType" value="visual">
                        <input type="hidden" id="status" name="status" value="">

                        <div class="row">
                            <div class="page-header">
                                <a id="back" href="#" class="btn btn-default btn-sm" style="float: left;margin-right: 10px;margin-top: 5px; margin-left: 20px;">← Go Back</a>
                                <h2 class="page-header__title">Visual Acuity</h2>
                            </div>

                            <div class="col-sm-12">
                                <table class="table table-striped table-responsive">
                                    <thead>
                                    <tr>
                                        <th colspan="4" class="title text-center">Step One</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="test-label"><span>Distance &raquo;</td>
                                            <td class="test-label"><input type="text" <?php echo $disabled; ?> class="form-control" placeholder="BE" name="<?php echo 'data[details]['.VisualSkillsProfileTable::distance_be.']'; ?>" value="<?php  if(isset($view_bag[VisualSkillsProfileTable::distance_be])) echo $view_bag[VisualSkillsProfileTable::distance_be]; ?>"></td>
                                            <td class="test-label"><input type="text" <?php echo $disabled; ?> class="form-control" placeholder="RE" name="<?php echo 'data[details]['.VisualSkillsProfileTable::distance_re.']'; ?>" value="<?php if(isset($view_bag[VisualSkillsProfileTable::distance_re])) echo $view_bag[VisualSkillsProfileTable::distance_re]; ?>"></td>
                                            <td class="test-label"><input type="text" <?php echo $disabled; ?> class="form-control" placeholder="LE" name="<?php echo 'data[details]['.VisualSkillsProfileTable::distance_le.']'; ?>" value="<?php if(isset($view_bag[VisualSkillsProfileTable::distance_le])) echo $view_bag[VisualSkillsProfileTable::distance_le]; ?>"></td>

                                        </tr>
                                        <tr>
                                            <td class="test-label"><span>Near &raquo;</td>
                                            <td class="test-label"><input type="text" <?php echo $disabled; ?> class="form-control" placeholder="BE" name="<?php echo 'data[details]['.VisualSkillsProfileTable::near_be.']'; ?>" value="<?php  if(isset($view_bag[VisualSkillsProfileTable::near_be])) echo $view_bag[VisualSkillsProfileTable::near_be]; ?>"></td>
                                            <td class="test-label"><input type="text" <?php echo $disabled; ?> class="form-control" placeholder="RE" name="<?php echo 'data[details]['.VisualSkillsProfileTable::near_re.']'; ?>" value="<?php if(isset($view_bag[VisualSkillsProfileTable::near_re])) echo $view_bag[VisualSkillsProfileTable::near_be]; ?>"></td>
                                            <td class="test-label"><input type="text" <?php echo $disabled; ?> class="form-control" placeholder="LE" name="<?php echo 'data[details]['.VisualSkillsProfileTable::near_le.']'; ?>" value="<?php if(isset($view_bag[VisualSkillsProfileTable::near_le])) echo $view_bag[VisualSkillsProfileTable::near_be]; ?>"></td>

                                        </tr>
                                        <tr>
                                            <td class="test-label"><span>Pinhole Acuity &raquo;</td>
                                            <td class="test-label"><input type="text" <?php echo $disabled; ?> class="form-control" placeholder="BE" name="<?php echo 'data[details]['.VisualSkillsProfileTable::pinhole_acuity_be.']'; ?>" value="<?php  if(isset($view_bag[VisualSkillsProfileTable::pinhole_acuity_be])) echo $view_bag[VisualSkillsProfileTable::pinhole_acuity_be]; ?>"></td>
                                            <td class="test-label"><input type="text" <?php echo $disabled; ?> class="form-control" placeholder="RE" name="<?php echo 'data[details]['.VisualSkillsProfileTable::pinhole_acuity_re.']'; ?>" value="<?php if(isset($view_bag[VisualSkillsProfileTable::pinhole_acuity_re])) echo $view_bag[VisualSkillsProfileTable::pinhole_acuity_re]; ?>"></td>
                                            <td class="test-label"><input type="text" <?php echo $disabled; ?> class="form-control" placeholder="LE" name="<?php echo 'data[details]['.VisualSkillsProfileTable::pinhole_acuity_le.']'; ?>" value="<?php if(isset($view_bag[VisualSkillsProfileTable::pinhole_acuity_le])) echo $view_bag[VisualSkillsProfileTable::pinhole_acuity_le]; ?>"></td>

                                        </tr>
                                    </tbody>
                                </table>
                                <table class="table table-striped table-responsive">
                                    <thead>
                                    <tr>
                                        <th colspan="2" class="title text-center">Step Two</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td class="test-label"><span>Colour Vision</td>
                                        <td><input class="form-control" type="text" <?php echo $disabled; ?> name="<?php echo 'data[details]['.VisualSkillsProfileTable::colour_vision.']'; ?>" value="<?php  if(isset($view_bag[VisualSkillsProfileTable::colour_vision])) echo $view_bag[VisualSkillsProfileTable::colour_vision]; ?>"></td>
                                    </tr>
                                    <tr>
                                        <td class="test-label"><span>Stereopsis</td>
                                        <td><input class="form-control" type="text" <?php echo $disabled; ?> name="<?php echo 'data[details]['.VisualSkillsProfileTable::stereopsis.']'; ?>" value="<?php  if(isset($view_bag[VisualSkillsProfileTable::stereopsis])) echo $view_bag[VisualSkillsProfileTable::stereopsis]; ?>"></td>
                                    </tr>
                                    <tr>
                                        <td class="test-label"><span>Amplitude of Accommodation</td>
                                        <td><input class="form-control" type="text" <?php echo $disabled; ?> name="<?php echo 'data[details]['.VisualSkillsProfileTable::amplitude_of_accomodation.']'; ?>" value="<?php  if(isset($view_bag[VisualSkillsProfileTable::amplitude_of_accomodation])) echo $view_bag[VisualSkillsProfileTable::amplitude_of_accomodation]; ?>"></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>

                            <?php
                            if ($view_bag[VisualSkillsProfileTable::status_id] == 5 || $view_bag[VisualSkillsProfileTable::status_id] == 6){?>
                                <div class="col-sm-12 submit-test">
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
