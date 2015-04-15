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
                    <form id="addTestForm" class="form">
                        <input type="hidden" name="<?php echo 'data[details]['.ChemicalPathologyRequestTable::cpreq_id.']'; ?>" value="<?php if (isset($view_bag['details'][ChemicalPathologyRequestTable::cpreq_id])) echo $view_bag['details'][ChemicalPathologyRequestTable::cpreq_id] ?>">
                        <input type="hidden" name="<?php echo 'data[details]['.ChemicalPathologyRequestTable::lab_attendant_id.']'; ?>" value="<?php if (isset($view_bag['details'][ChemicalPathologyRequestTable::lab_attendant_id])) echo $view_bag['details'][ChemicalPathologyRequestTable::lab_attendant_id] ?>">
                        <input type="hidden" name="intent" value="updateLabDetails">
                        <input type="hidden" name="labType" value="chemical_pathology">

                        <div class="row">
                            <div class="page-header">
                                <a id="back" href="#" class="btn btn-default btn-sm" style="float: left;margin-right: 10px;margin-top: 5px; margin-left: 20px;">← Go Back</a>
                                <h2 class="page-header__title">Chemical Pathology</h2>
                            </div>

                            <div class="col-sm-6">
                                <div class="center-block">
                                    <fieldset>
                                        <h4 class="title">Clinical Diagnosis</h4>
                                        <textarea readonly class="col-sm-12 form-control"><?php
                                            if(isset($view_bag['details'][ChemicalPathologyRequestTable::clinical_diagnosis])){
                                                echo $view_bag['details'][ChemicalPathologyRequestTable::clinical_diagnosis];
                                            }
                                            ?></textarea>
                                        <div class="test-label">Requesting Doctor: <span class="pad5 test-label">Date: <?php if(isset($view_bag['details']['created_date'])) echo $view_bag['details']['created_date'];?></span></div>
                                    </fieldset>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="center-block">
                                    <fieldset>
                                        <h4 class="title">Laboratory Report</h4>
                                        <textarea type="text" class="col-sm-12 form-control" name="<?php echo 'data[details]['.ChemicalPathologyRequestTable::laboratory_comment.']'; ?>"><?php
                                            if(isset($view_bag['details'][ChemicalPathologyRequestTable::laboratory_comment])){
                                                echo $view_bag['details'][ChemicalPathologyRequestTable::laboratory_comment];
                                            }
                                            ?></textarea>
                                        <div class="test-label">Laboratory Ref: <span><input type="text" class="form-inline form-margin" name="<?php echo 'data[details]['.ChemicalPathologyRequestTable::laboratory_ref.']'; ?>" value="<?php if (isset($view_bag['details'][ChemicalPathologyRequestTable::laboratory_ref])) echo $view_bag['details'][ChemicalPathologyRequestTable::laboratory_ref]; ?>"></span></div>
                                    </fieldset>
                                </div>
                            </div>

                            <?php
                            $electrolytes_label_list = new LabelList();
                            $electrolytes_label_list->addNode(new LabelNode("Na (120-140) mmol/L", 1, array('unit'=>'mmol/L', 'column'=>ChemicalPathologyDetailsTable::result)));
                            $electrolytes_label_list->addNode(new LabelNode("K (3-5) mmol/L", 2, array('unit'=>'mmol/L', 'column'=>ChemicalPathologyDetailsTable::result)));
                            $electrolytes_label_list->addNode(new LabelNode("Cl (95-100) mmol/L", 3, array('unit'=>'mmol/L','column'=>ChemicalPathologyDetailsTable::result)));
                            $electrolytes_label_list->addNode(new LabelNode("HCO3 (20-30) mmol/L", 4, array('unit'=>'mmol/L','column'=>ChemicalPathologyDetailsTable::result)));
                            $electrolytes_label_list->addNode(new LabelNode("Ca (2.25-2.75) mmol/L", 5, array('unit'=>'mmol/L','column'=>ChemicalPathologyDetailsTable::result)));
                            $electrolytes_label_list->addNode(new LabelNode("Creatinnie (50-132", 6, array('unit'=>'mmol/L','column'=>ChemicalPathologyDetailsTable::result)));
                            $electrolytes_label_list->addNode(new LabelNode("Urea (2.5-5.8) mmol/L", 7, array('unit'=>'mmol/L','column'=>ChemicalPathologyDetailsTable::result)));
                            $electrolytes_label_list->addNode(new LabelNode("Uric Acid (0.12-0.36) mmol/L", 8, array('unit'=>'mmol/L','column'=>ChemicalPathologyDetailsTable::result)));
                            ?>

                            <div class="col-sm-6">
                                <h4 class="title">ELECTROLYTES</h4>
                                <?php foreach($electrolytes_label_list->getList() as $label) {  $attr = $label->getAttribute(); ?>
                                <label class="test-label"><?php echo $label->getLabel(); ?></label>
                                <?php if (isset($attr['unit'])){ ?>
                                <div class="input-group">
                                    <?php } else { ?>
                                    <div class="center-block">
                                        <?php } ?>
                                        <input type="text" class="form-control col-sm-12" name="<?php echo ChemicalPathologyDetailsTable::table_name. '['.$label->getId().']' ?>">
                                        <?php if (isset($attr['unit'])){ ?>
                                            <span class="input-group-addon"><?php echo $attr['unit']; ?></span>
                                        <?php } ?>
                                    </div>
                                    <?php } ?>
                            </div>

                                <?php
                                $lft_label_list = new LabelList();
                                $lft_label_list->addNode(new LabelNode("Bilirubin (Total)", 15, array('unit'=>'mmol/L', 'column'=>ChemicalPathologyDetailsTable::result)));
                                $lft_label_list->addNode(new LabelNode("Bilirubin (Conj.)", 16, array('unit'=>'mmol/L', 'column'=>ChemicalPathologyDetailsTable::result)));
                                $lft_label_list->addNode(new LabelNode("Alk Phos", 17, array('unit'=>'Iu/L', 'column'=>ChemicalPathologyDetailsTable::result)));
                                $lft_label_list->addNode(new LabelNode("Acid Phos", 18, array('unit'=>'Iu/L', 'column'=>ChemicalPathologyDetailsTable::result)));
                                $lft_label_list->addNode(new LabelNode("ALT (SGPT)", 19, array('unit'=>'Iu/L', 'column'=>ChemicalPathologyDetailsTable::result)));
                                $lft_label_list->addNode(new LabelNode("AST (SGOT)", 20, array('unit'=>'Iu/L', 'column'=>ChemicalPathologyDetailsTable::result)));
                                $lft_label_list->addNode(new LabelNode("Bilirubin (Total)", 15, array('unit'=>'mmol/L', 'column'=>ChemicalPathologyDetailsTable::result)));
                                ?>

                                <div class="col-sm-6">
                                    <h4 class="title">LFT</h4>
                                    <?php foreach($lft_label_list->getList() as $label) {  $attr = $label->getAttribute(); ?>
                                    <label class="test-label"><?php echo $label->getLabel(); ?></label>
                                    <?php if (isset($attr['unit'])){ ?>
                                    <div class="input-group">
                                        <?php } else { ?>
                                        <div class="center-block">
                                            <?php } ?>
                                            <input type="text" class="form-control col-sm-12" name="<?php echo ChemicalPathologyDetailsTable::table_name. '['.$label->getId().']' ?>">
                                            <?php if (isset($attr['unit'])){ ?>
                                                <span class="input-group-addon"><?php echo $attr['unit']; ?></span>
                                            <?php } ?>
                                        </div>
                                        <?php } ?>
                                </div>

                                <div class="col-sm-6 col-sm-offset-6"></div>

                                <?php
                                $fasting_label_list = new LabelList();
                                $fasting_label_list->addNode(new LabelNode("Total Chol (2.5-5.17)", 9, array('unit'=>'mmol/L', 'column'=>ChemicalPathologyDetailsTable::result)));
                                $fasting_label_list->addNode(new LabelNode("TG < 2.3", 10, array('unit'=>'mmol/L', 'column'=>ChemicalPathologyDetailsTable::result)));
                                $fasting_label_list->addNode(new LabelNode("HDL > 1.04", 11, array('unit'=>'mmol/L', 'column'=>ChemicalPathologyDetailsTable::result)));
                                $fasting_label_list->addNode(new LabelNode("LDL > 3.9", 12, array('unit'=>'mmol/L', 'column'=>ChemicalPathologyDetailsTable::result)));
                                $fasting_label_list->addNode(new LabelNode("Glucose (Fatsing) 2.8-5.0", 13, array('unit'=>'mmol/L', 'column'=>ChemicalPathologyDetailsTable::result)));
                                $fasting_label_list->addNode(new LabelNode("Glucose (2HPP) 3.0-6.0", 14, array('unit'=>'mmol/L', 'column'=>ChemicalPathologyDetailsTable::result)));
                                ?>
                                <div class="col-sm-6">
                                    <h4 class="title">FASTING LIPIDS PROFILE</h4>
                                    <?php foreach($fasting_label_list->getList() as $label) { $attr = $label->getAttribute(); ?>
                                    <label class="test-label"><?php echo $label->getLabel(); ?></label>
                                    <?php if (isset($attr['unit'])){ ?>
                                    <div class="input-group">
                                        <?php } else { ?>
                                        <div class="center-block">
                                            <?php } ?>
                                            <input type="text" class="form-control col-sm-12" name="<?php echo ChemicalPathologyDetailsTable::table_name.'['.$label->getId().']'; ?>">
                                            <?php if (isset($attr['unit'])){ ?>
                                                <span class="input-group-addon"><?php echo $attr['unit']; ?></span>
                                            <?php } ?>
                                        </div>
                                        <?php } ?>
                                </div>

                                    <?php
                                    $proteins_label_list = new LabelList();
                                    $proteins_label_list->addNode(new LabelNode("Total Protein", 21, array('unit'=>'g/L', 'column'=>ChemicalPathologyDetailsTable::result)));
                                    $proteins_label_list->addNode(new LabelNode("Albumin", 22, array('unit'=>'g/L', 'column'=>ChemicalPathologyDetailsTable::result)));
                                    $proteins_label_list->addNode(new LabelNode("Globulin", 23, array('unit'=>'g/L', 'column'=>ChemicalPathologyDetailsTable::result)));
                                    $proteins_label_list->addNode(new LabelNode("Others", 24, array('unit'=>'g/L', 'column'=>ChemicalPathologyDetailsTable::result)));
                                    ?>

                                    <div class="col-sm-6">
                                        <h4 class="title">PROTEINS</h4>
                                        <?php foreach($proteins_label_list->getList() as $label) { $attr = $label->getAttribute(); ?>
                                        <label class="test-label"><?php echo $label->getLabel(); ?></label>
                                        <?php if (isset($attr['unit'])){ ?>
                                        <div class="input-group">
                                            <?php } else { ?>
                                            <div class="center-block">
                                                <?php } ?>
                                                <input type="text" class="form-control col-sm-12" name="<?php echo ChemicalPathologyDetailsTable::table_name.'['.$label->getId().']'; ?>">
                                                <?php if (isset($attr['unit'])){ ?>
                                                    <span class="input-group-addon"><?php echo $attr['unit']; ?></span>
                                                <?php } ?>
                                            </div>
                                            <?php } ?>
                                        </div>

                                <div class="col-sm-6 submit-test">
                                    <input type='submit' class='btn btn-default pull-right pad' value='Save & Continue' name='save_continue'>
                                    <input type='submit' class='btn btn-primary pull-right pad' value='Submit' name='submit'>
                                </div>
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

