<?php
/**
 * Created by PhpStorm.
 * User: Olaniyi
 * Date: 3/6/15
 * Time: 2:03 PM
 */

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

if ($view_bag['details'][HaematologyTable::status_id] == 7){
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

            <div class="parasitology">
                <div class="add-parasitology">
                    <form id="addTestForm" class="form">
                        <input type="hidden" name="<?php echo 'data[details]'.'['.ParasitologyRequestTable::preq_id.']'; ?>" value="<?php echo $view_bag['details']['preq_id'] ?>" />
                        <input type="hidden" name="<?php  echo 'data[details]'.'['.ParasitologyRequestTable::lab_attendant_id.']' ?>" value="<?php if(isset($view_bag['details']['lab_attendant_id'])) echo $view_bag['details']['lab_attendant_id'] ?>" />
                        <input type="hidden" name="<?php echo 'data['.ParasitologyRequestTable::treatment_id.']'; ?>"  value="<?php echo $view_bag['details']['treatment_id'] ?>">
                        <input type="hidden" name="intent" value="updateLabDetails">
                        <input type="hidden" name="labType" value="parasitology">
                        <input type="hidden" id="status" name="status" value="">

                        <div class="row">
                            <div class="page-header">
                                <a id="back" href="#" class="btn btn-default btn-sm" style="float: left;margin-right: 10px;margin-top: 5px; margin-left: 20px;">← Go Back</a>
                                <h2 class="page-header__title">Parasitology</h2>
                            </div>

                            <div class="col-sm-12">
                                <div class="center-block">
                                    <fieldset>
                                        <h4 class="title">Clinical Diagnosis</h4>
                                        <textarea disabled="disabled" class="col-sm-12 form-control"><?php
                                            if(isset($view_bag['details']['diagnosis'])){
                                                echo $view_bag['details']['diagnosis'];
                                            }
                                            ?></textarea>
                                        <div class="test-label">Requesting Doctor:<span class="pad5 test-label">Date: <?php if(isset($view_bag['details']['created_date'])) echo $view_bag['details']['created_date']; ?></span></div>
                                    </fieldset>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="center-block">
                                    <div class="col-sm-12"><h4 class="title">Other Relevant Details</h4></div>
                                    <div class="col-sm-6">
                                        <fieldset>
                                            <label class="test-label">Nature of Specimen</label>
                                            <textarea class="col-sm-12 form-control" <?php echo $disabled; ?> placeholder="Nature of Specimen" name="<?php echo 'data[details]['.ParasitologyRequestTable::nature_of_specimen.']'; ?>"><?php
                                                if (isset($view_bag['details'][ParasitologyRequestTable::nature_of_specimen])){
                                                    echo $view_bag['details'][ParasitologyRequestTable::nature_of_specimen];
                                                }
                                                ?></textarea>
                                        </fieldset>
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="test-label">Investigation Required</label>
                                        <textarea class="col-sm-12 form-control" <?php echo $disabled; ?> placeholder="Investigation Required" name="<?php echo 'data[details]['.ParasitologyRequestTable::investigation_required.']'; ?>"><?php
                                            if (isset($view_bag['details']['investigation_req'])) {
                                                echo $view_bag['details']['investigation_req'];
                                            }
                                            ?></textarea>
                                        <div class="test-label">Date of Collection: <?php if (isset($view_bag['details']['created_date'])) echo $view_bag['details']['created_date']; ?><span class="pad5 test-label">Date Reported: <?php if (isset($view_bag['details']['date_reported'])) echo $view_bag['details']['date_reported']; ?></span></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="center-block">
                                    <fieldset>
                                        <h4 class="title">Laboratory Report</h4>
                                        <textarea class="col-sm-12 form-control" <?php echo $disabled; ?> placeholder="Laboratory Report" name="<?php echo 'data[details]['.ParasitologyRequestTable::lab_comment.']'; ?>"><?php
                                            if (isset($view_bag['details'][ParasitologyRequestTable::lab_comment])){
                                                echo $view_bag['details'][ParasitologyRequestTable::lab_comment];
                                            }
                                            ?></textarea>
                                        <div class="test-label">Laboratory Ref: <span><input type="text" <?php echo $disabled; ?> class="form-inline form-margin" name="<?php echo 'data[details]['.ParasitologyRequestTable::lab_number.']'; ?>" value="<?php if (isset($view_bag['details'][ParasitologyRequestTable::lab_number])) echo $view_bag['details'][ParasitologyRequestTable::lab_number]; ?>"></span> </div>
                                    </fieldset>
                                </div>
                            </div>

                            <?php
                            $ova_of_parasites = new LabelList();
                            $ova_of_parasites->addNode(new LabelNode("Hook worm" , 1));
                            $ova_of_parasites->addNode(new LabelNode("A. lumbricoides" , 2));
                            $ova_of_parasites->addNode(new LabelNode("T. Trichuris" , 3));
                            $ova_of_parasites->addNode(new LabelNode("E. vemicularis" , 4));
                            $ova_of_parasites->addNode(new LabelNode("S. haematobium" , 5));
                            $ova_of_parasites->addNode(new LabelNode("No cysts. ova" , 6));

                            $trophozoites_cyts_parasites = new LabelList();
                            $trophozoites_cyts_parasites->addNode(new LabelNode("E. coli", 7));
                            $trophozoites_cyts_parasites->addNode(new LabelNode("E. histolytica", 8));
                            $trophozoites_cyts_parasites->addNode(new LabelNode("G. lamblia", 9));

                            $larvae_of_parasites = new LabelList();
                            $larvae_of_parasites->addNode(new LabelNode("Hook worm", 10));
                            $larvae_of_parasites->addNode(new LabelNode("S. stercoralis", 11));

                            $cells_parasites = new LabelList();
                            $cells_parasites->addNode(new LabelNode("RBC's", 12));
                            $cells_parasites->addNode(new LabelNode("WBC's", 13));

                            $occult_blood_parasites = new LabelList();
                            $occult_blood_parasites->addNode(new LabelNode("Positive", 14));
                            $occult_blood_parasites->addNode(new LabelNode("Negative", 15));
                            ?>

                            <div class="col-sm-12">
                                <h4 class="title text-center">Appearance</h4>
                                <p class="text-center">The Following Parasites seen</p>
                            </div>
                            <div class="col-sm-6">
                                <table class="table table-responsive">
                                    <thead>
                                    <tr>
                                        <th scope="col" colspan="2" class="test-label text-center">Cells</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($cells_parasites->getList() as $label){ ?>
                                        <tr>
                                            <td class="test-label"><?php echo $label->getLabel(); ?></td>
                                            <td class="text-center"><input type="checkbox" <?php echo $disabled; ?> name="<?php echo 'data[parasites]['.$label->getId().']'; ?>" <?php if (isset($view_bag['parasites'][$label->getId()])) {echo "checked='checked'";} ?>></td>
                                        </tr>
                                        <?php
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>

                            <div class="col-sm-6">
                                <table class="table table-responsive">
                                    <thead>
                                    <tr>
                                        <th scope="col" colspan="2" class="test-label text-center">Larvae of</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    foreach($larvae_of_parasites->getList() as $label){
                                        ?>
                                        <tr>
                                            <td class="test-label"><?php echo $label->getLabel();?></td>
                                            <td class="text-center"><input type="checkbox" <?php echo $disabled; ?> name="<?php echo  'data[parasites]['.$label->getId().']'; ?>" <?php if (isset($view_bag['parasites'][$label->getId()])) {echo "checked";} ?>> </td>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                    </tbody>
                                </table>
                            </div>

                            <div class="col-sm-6">
                                <table class="table table-responsive">
                                    <thead>
                                    <tr>
                                        <th scope="col" colspan="2" class="test-label text-center">Oval Of</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    foreach($ova_of_parasites->getList() as $label){
                                        ?>
                                        <tr>
                                            <td class="test-label"><?php echo $label->getLabel();?></td>
                                            <td class="text-center"><input <?php echo $disabled; ?> name="<?php echo  'data[parasites]['.$label->getId().']'; ?>" type="checkbox" <?php if (isset($view_bag['parasites'][$label->getId()])) {echo "checked";} ?>> </td>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                    </tbody>
                                </table>
                            </div>

                            <div class="col-sm-6">
                                <table class="table table-responsive">
                                    <thead>
                                    <tr>
                                        <th scope="col" colspan="2" class="test-label text-center">Trophozoites/cyts of</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    foreach($trophozoites_cyts_parasites->getList() as $label){
                                        ?>
                                        <tr>
                                            <td class="test-label"><?php echo $label->getLabel();?></td>
                                            <td class="text-center"><input type="checkbox" <?php echo $disabled; ?> name="<?php echo  'data[parasites]['.$label->getId().']'; ?>" <?php if (isset($view_bag['parasites'][$label->getId()])) {echo "checked";} ?>> </td>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                    <tr>
                                        <th scope="col" colspan="2" class="test-label text-center">Occult Blood</th>
                                    </tr>
                                    <?php
                                    foreach($occult_blood_parasites->getList() as $label){
                                    ?>
                                    <tr>
                                        <td class="test-label"><?php echo $label->getLabel();?></td>
                                        <td class="text-center"><input type="checkbox"  <?php echo $disabled; ?> name="<?php echo 'data[parasites]['.$label->getId().']'; ?>" <?php if (isset($view_bag['parasites'][$label->getId()])) {echo "checked";} ?>> </td>
                                    </tr>
                                    <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                            <?php
                            if ($view_bag['details'][ParasitologyRequestTable::status_id] == 5 || $view_bag['details'][ParasitologyRequestTable::status_id] == 6){?>
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
<script src="../js/bootstrap/jquery.dataTables.js"></script>
<script src="../js/bootstrap/bootstrap.min.js"></script>
<script src="../js/bootstrap/jquery-ui.min.js"></script>
<script src="../js/constants.js"></script>
<script src="../js/laboratory.js" type="text/javascript"></script>
</body>