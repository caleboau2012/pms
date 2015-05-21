<?php
class UserAuthTable {
  const table_name    = 'user_auth';
  const userid        = 'userid';
  const regNo         = 'regNo';
  const passcode      = 'passcode';
  const create_date   = 'created_date';
  const modified_date = 'modified_date';
  const status        = 'status';
  const active_fg     = 'active_fg';
  const online_status = 'online_status';
}

class StatusTable {
  const table_name = 'status';
  const status_id = 'status_id';
  const status_name = 'status_name';
  const active_fg = 'active_fg';
}

class StaffRoleTable {
  const table_name = 'staff_role';
  const staff_role_id = 'staff_role_id';
  const create_date = 'created_date';
  const modified_date = 'modified_date';
  const staff_role = 'staff_role';
  const role_label = 'role_label';
  const active_fg = 'active_fg';
}

class StaffPermissionTable {
  const table_name = 'staff_permission';
  const staff_permission_id = 'staff_permission_id';
  const staff_permission = 'staff_permission';
  const create_date = 'created_date';
  const modified_date = 'modified_date';
  const active_fg = 'active_fg';
}

class ProfileTable {
  const table_name = 'profile';
  const profile_id = 'profile_id';
  const userid = 'userid';
  const surname = 'surname';
  const firstname = 'firstname';
  const middlename = 'middlename';
  const department_id = 'department_id';
  const work_address = 'work_address';
  const home_address = 'home_address';
  const telephone = 'telephone';
  const sex = 'sex';
  const height = 'height';
  const weight = 'weight';
  const birth_date = 'birth_date';
  const create_date = 'created_date';
  const modified_date = 'modified_date';
  const active_fg = 'active_fg';
}

class PermissionRoleTable {
  const table_name = 'permission_role';
  const permission_role_id = 'permission_role_id';
  const userid = 'userid';
  const staff_permission_id = 'staff_permission_id';
  const staff_role_id = 'staff_role_id';
  const create_date = 'created_date';
  const modified_date = 'modified_date';
  const active_fg = 'active_fg';
}

class PatientTable{
    const table_name        = 'patient';
    const patient_id        = 'patient_id';
    const surname           = 'surname';
    const firstname         = 'firstname';
    const middlename        = 'middlename';
    const regNo             = 'regNo';
    const home_address      = 'home_address';
    const telephone         = 'telephone';
    const sex               = 'sex';
    const height            = 'height';
    const weight            = 'weight';
    const birth_date        = 'birth_date';
    const nok_firstname     = 'nok_firstname';
    const nok_middlename    = 'nok_middlename';
    const nok_surname       = 'nok_surname';
    const nok_address       = 'nok_address';
    const nok_telephone     = 'nok_telephone';
    const nok_relationship  = 'nok_relationship';
    const citizenship        = 'citizenship';
    const religion           = 'religion';
    const family_position    = 'family_position';
    const mother_status     = 'mother_status';
    const father_status      = 'father_status';
    const marital_status    = 'marital_status';
    const no_of_children    = 'no_of_children';
    const create_date       = 'created_date';
    const modified_date     = 'modified_date';
    const active_fg         = 'active_fg';
    const occupation        = 'occupation';
}

class PatientQueueTable {
  const table_name      = 'patient_queue';
  const patient_queue_id = 'patient_queue_id';
  const patient_id = 'patient_id';
  const doctor_id = 'doctor_id';
  const active_fg = 'active_fg';
  const create_date = 'created_date';
  const modified_date = 'modified_date';
}

class RosterTable {
    const table_name        = 'roster';

    const roster_id         = 'roster_id';
    const user_id           = 'user_id';
    const created_by        = 'created_by';
    const dept_id           = 'dept_id';
    const duty              = 'duty';
    const duty_date         = 'duty_date';
    const created_date      = 'created_date';
    const modified_date     = 'modified_date';
    const modified_by       = 'modified_by';
}

class CommunicationTable {
    const table_name = 'communication';

    const msg_id        = 'msg_id';
    const sender_id     = 'sender_id';
    const recipient_id  = 'recipient_id';
    const msg_subject   = 'msg_subject';
    const msg_body      = 'msg_body';
    const msg_status    = 'msg_status';
    const active_fg     = 'active_fg';
    const created_date  = 'created_date';
    const modified_date = 'modified_date';
}

class UnitsRefTable{
    const table_name = 'units_ref';

    const unit_ref_id  = 'unit_ref_id';
    const unit         = 'unit';
    const created_date = 'created_date';
    const active_fg    = 'active_fg';
}

class DrugRefTable{
    const table_name = 'drug_name_ref';

    const drug_ref_id  = 'drug_ref_id';
    const name         = 'name';
    const created_date = 'created_date';
    const active_fg    = 'active_fg';
}

class OutgoingDrugsTable{
    const table_name = 'outgoing_drugs_id';

    const outgoing_drugs_id = 'outgoing_drugs_id';
    const drug_id           = 'drug_id';
    const quantity          = 'qty';
    const unit_id           = 'unit_id';
    const created_date      = 'created_date';
    const modified_date     = 'modified_date';
    const active_fg         = 'active_fg';
}

class PharmacistOutgoingDrugTable{
    const table_name = 'pharmacist_outgoing_drug';

    const pharmacist_outgoing_drug = 'pharmacist_outgoing_drug';
    const pharmacist_id            = 'pharmacist_id';
    const outgoing_drug_id         = 'outgoing_drug_id';
    const created_date             = 'created_date';
    const active_fg                = 'active_fg';
}

class TreatmentTable{
    const table_name = 'treatment';

    const treatment_id      = 'treatment_id';
    const doctor_id         = 'doctor_id';
    const patient_id        = 'patient_id';
    const consultation      = 'consultation';
    const comments          = 'comments';
    const symptoms          = 'symptoms';
    const diagnosis         = 'diagnosis';
    const created_date      = 'created_date';
    const modified_date     = 'modified_date';
    const treatment_status  = 'treatment_status';
    const bill_status       = 'bill_status';
    const active_fg         = 'active_fg';
    const status_id         = 'status_id';          /*I think a status would be needed in this table.*/
}

class PrescriptionTable{
    const table_name = 'prescription';

    const prescription_id = 'prescription_id';
    const prescription    = 'prescription';
    const treatment_id    = 'treatment_id';
    const status          = 'status';
    const modified_by     = 'modified_by';
    const created_date    = 'created_date';
    const modified_date   = 'modified_date';
    const active_fg       = 'active_fg';
}

class PrescriptionOutgoingDrugTable{
    const table_name = 'prescription_outgoing_drug';

    const prescription_outgoing_drug_id = 'prescription_outgoing_drug_id';
    const prescription_id               = 'prescription_id';
    const outgoing_drug_id              = 'outgoing_drug_id';
    const created_date                  = 'created_date';
    const active_fg                     = 'active_fg';
}

class VitalsTable {
    const table_name = 'vitals';
    
    const vitals_id = 'vitals_id';
    const patient_id = 'patient_id';
    const encounter_id = 'encounter_id';
    const added_by = 'added_by';
    const temp = 'temp';
    const pulse = 'pulse';
    const respiratory_rate = 'respiratory_rate';
    const blood_pressure = 'blood_pressure';
    const height = 'height';
    const weight = 'weight';
    const bmi = 'bmi';
    const active_fg = 'active_fg';
    const created_date = 'created_date';
}

class HaematologyTable {

    const table_name                 = 'haematology';
    const haematology_id             = 'haematology_id';
    const clinical_diagnosis_details = 'clinical_diagnosis_details';
    const doctor                     = 'doctor_id';
    const lab_attendant_id           = 'lab_attendant_id';
    const laboratory_report          = 'laboratory_report';
    const laboratory_ref             = 'laboratory_ref';
    const create_date                = 'created_date';
    const modified_date              = 'modified_date';
    const treatment_id               = 'treatment_id';
    const active_fg                  = 'active_fg';
    const status_id                  = 'status_id';
    const doctor_id                  = 'doctor_id';
}

class UrineTable {

    const table_name                 = 'urine';
    const urine_d                    = 'urine_id';
    const treatment_id               = 'treatment_id';
    const lab_attendant_id           = 'lab_attendant_id';
    const clinical_diagnosis_details = 'clinical_diagnosis_details';
    const investigation_required     = 'investigation_required';
    const doctor                     = 'doctor_id';
    const laboratory_report          = 'laboratory_report';
    const laboratory_ref             = 'laboratory_ref';
    const culture_value              = 'culture_value';
    const create_date                = 'created_date';
    const modified_date              = 'modified_date';
    const status_id                  = 'status_id';
    const active_fg                  = 'active_fg';
    const doctor_id                 = 'doctor_id';
}

class ParasitologyRequestTable {

    const table_name = 'parasitology_req';
    const preq_id                = 'preq_id';
    const treatment_id           = 'treatment_id';
    const nature_of_specimen     = 'nature_of_specimen';
    const investigation_required = 'investigation_req';
    const diagnosis              = 'diagnosis';
    const date_reported          = 'date_reported';
    const created_date           = 'created_date';
    const modified_date          = 'modified_date';
    const active_fg              = 'active_fg';
    const doctor_id              = 'doctor_id';
    const lab_number            = 'lab_num';
    const lab_comment             = 'lab_comment';
    const lab_attendant_id       = 'lab_attendant_id';
    const status_id              = 'status_id';
    const pref_id = 'pref_id';
}

class ParasitologyDetailsTable {

    const table_name = 'parasitology_details';
    const pdetail_id    = 'pdetail_id';
    const preq_id       = 'preq_id';
    const pref_id       = 'pref_id';
    const created_date  = 'created_date';
    const modified_date = 'modified_date';
    const active_fg     = 'active_fg';
}

class UrinaryTable {

    const table_name = 'urinary';

    const patient_id        = 'patient_id';
    const urinaryproblem = 'urinaryproblem';
    const create_date    = 'created_date';
    const modified_date  = 'modified_date';
    const active_fg      = 'active_fg';

}

class BloodTestTable {

    const table_name        = 'blood_test';
    const bloodtest_id      = 'bloodtest_id';
    const haematology_id    = 'haematology_id';
    const pcv               = 'pcv';
    const hb                = 'hb';
    const hchc              = 'hchc';
    const wbc               = 'wbc';
    const eosinophils       = 'eosinophils';
    const platelets         = 'platelets';
    const rectis            = 'rectis';
    const rectis_index      = 'rectis_index';
    const e_s_r             = 'e_s_r';
    const microfilaria      = 'microfilaria';
    const malaria_parasites = 'malaria_parasites';
    const create_date       = 'created_date';
    const modified_date     = 'modified_date';
    const active_fg         = 'active_fg';
}

class VisualSkillsProfileTable {

    const table_name                = 'visual_skills_profile';
    const id                        = 'visual_profile_id';
    const treatment_id              = 'treatment_id';
    const distance_re               = 'distance_re';
    const distance_le               = 'distance_le';
    const distance_be               = 'distance_be';
    const near_re                   = 'near_re';
    const near_le                   = 'near_le';
    const near_be                   = 'near_be';
    const pinhole_acuity_re         = 'pinhole_acuity_re';
    const pinhole_acuity_le         = 'pinhole_acuity_le';
    const pinhole_acuity_be         = 'pinhole_acuity_be';
    const colour_vision             = 'colour_vision';
    const stereopsis                = 'stereopsis';
    const amplitude_of_accomodation = 'amplitude_of_accomodation';
    const create_date               = 'created_date';
    const modified_date             = 'modified_date';
    const active_fg                 = 'active_fg';
    const doctor_id                 = 'doctor_id';
    const lab_attendant_id          = 'lab_attendant_id';
    const status_id                 = 'status_id';
}

class ChemicalPathologyDetailsTable {
    const table_name    = 'chemical_pathology_details';
    const cpdetails_id  = 'cpdetails_id';
    const cpreq_id      = 'cpreq_id';
    const cpref_id      = 'cpref_id';
    const result        = 'result';
    const created_date  = 'created_date';
    const modified_date = 'modified_date';
    const active_fg     = 'active_fg';
}

class UrinalysisTable {

    const table_name    = 'urinalysis';
    const id            = 'urinalysis_id';
    const urine_id      = 'urine_id';
    const appearance    = 'appearance';
    const ph            = 'ph';
    const glucose       = 'glucose';
    const protein       = 'protein';
    const bilirubin     = 'bilirubin';
    const urobillinogen = 'urobillinogen';
    const create_date   = 'created_date';
    const modified_date = 'modified_date';
    const active_fg     = 'active_fg';
}

class MicroscopyTable {

    const table_name       = 'microscopy';
    const microscopy_id    = 'microscopy_id';
    const urine_id         = 'urine_id';
    const pus_cells        = 'pus_cells';
    const red_cells        = 'red_cells';
    const epithelial_cells = 'epithelial_cells';
    const casts            = 'casts';
    const crystals         = 'crystals';
    const others           = 'others';
    const create_date      = 'created_date';
    const modified_date    = 'modified_date';
    const active_fg        = 'active_fg';
}

class UrineSensitivityTable {

    const table_name            = 'urine_sensitivity';
    const urine_sensitivity_id  = 'urine_sensitivity_id';
    const urine_id              = 'urine_id';
    const isolates              = 'isolates';
    const isolates_degree       = 'isolates_degree';
    const create_date           = 'created_date';
    const active_fg             = 'active_fg';
}

class FilmAppearanceTable {

    const table_name         = 'film_appearance';
    const film_appearance_id = 'film_appearance_id';
    const haematology_id     = 'haematology_id';
    const aniscocytosis      = 'aniscocytosis';
    const poikilocytosis     = 'poikilocytosis';
    const polychromasia      = 'polychromasia';
    const macrocytosis       = 'macrocytosis';
    const microcytosis       = 'microcytosis';
    const hypochromia        = 'hypochromia';
    const sickle_cells       = 'sickle_cells';
    const target_cells       = 'target_cells';
    const spherocytes        = 'spherocytes';
    const nucleated_rbc      = 'nucleated_rbc';
    const sickling_test      = 'sickling_test';
    const create_date        = 'created_date';
    const modified_date      = 'modified_date';
    const active_fg          = 'active_fg';
}

class DifferentialCountTable {

    const table_name             = 'differential_count';
    const differential_count_id  = 'differential_count_id';
    const haematology_id         = 'haematology_id';
    const polymorphs_neutrophils = 'polymorphs_neutrophils';
    const lymphocytes            = 'lymphocytes';
    const monocytes              = 'monocytes';
    const eosinophils            = 'eosinophils';
    const basophils              = 'basophils';
    const widals_test            = 'widals_test';
    const blood_group            = 'blood_group';
    const rhesus_factor          = 'rhesus_factor';
    const genotype               = 'genotype';
    const create_date            = 'created_date';
    const active_fg              = 'active_fg';
}

class XrayNoTable {

    const table_name    = 'xray_no';
    const xray_id       = 'xray_id';
    const radiology_id  = 'radiology_id';
    const xray_number   = 'xray_number';
    const casual_no     = 'casual_no';
    const gp_no         = 'gp_no';
    const ante_natal_no = 'ante_natal_no';
    const create_date   = 'created_date';
    const modified_date = 'modified_date';
    const active_fg     = 'active_fg';
}

class XrayCaseTable {

    const table_name = 'xray_case_no';
    const lmp        = 'options';
    const active_fg  = 'active_fg';

}

class RadiologyRequestTable {
    const table_name                 = 'radiology_request';

    const radiology_request_id       = 'radiology_request_id';
    const radiology_id               = 'radiology_id';
    const clinical_diagnosis_details = 'clinical_diagnosis_details';
    const previous_operation         = 'previous_operation';
    const any_known_allergies        = 'any_known_allergies';
    const previous_xray              = 'previous_xray';
    const xray_number                = 'xray_number';
    const create_date                = 'created_date';
    const modified_date              = 'modified_date';
    const active_fg                  = 'active_fg';
}

class ChemicalPathologyRefTable {
    const table_name = 'chemical_pathology_ref';

    const cpref_id    = 'cpref_id';
    const status_name = 'status_name';
    const status_type = 'status_type';
    const active_fg   = 'active_fg';
}

class ParasitologyRefTable {
    const table_name = 'parasitology_ref';

    const pref_id       = 'pref_id';
    const parasite_name = 'parasite_name';
    const parasite_type = 'parasite_type';
    const active_fg     = 'active_fg';
}
class ParasitologyReqTable{
    const table_name = 'parasitology_req';

    const preq_id = 'preq_id';
    const user_id = 'user_id';
    const treatment_id = 'treatment_id';
    const nature_of_specimen = 'nature_of_specimen';
    const investigation_req = 'investigation_req';
    const diagnosis = 'diagnosis';
    const date_reported = 'date_reported';
    const created_date = 'created_date';
    const modified_date = 'modified_date';
    const doctor_id = 'doctor_id';
    const lab_attendant_id = 'lab_attendant_id';
    const lab_num = 'lab_num';
    const lab_comment = 'lab_comment';
    const status_id = 'status_id';
    const pref_id = 'pref_id';
    const active_fg = 'active_fg';

}

class RadiologyTable {
    const table_name           = 'radiology';

    const radiology_id         = 'radiology_id';
    const doctor_id            = 'doctor_id';
    const lab_attendant_id     = 'lab_attendant_id';
    const ward_clinic_id       = 'ward_clinic_id';
    const xray_case_id         = 'xray_case_id';
    const xray_size_id         = 'xray_size_id';
    const treatment_id         = 'treatment_id';
    const consultant_in_charge = 'consultant_in_charge';
    const checked_by           = 'checked_by';
    const radiographers_note   = 'radiographers_note';
    const radiologists_report  = 'radiologists_report';
    const create_date          = 'created_date';
    const modified_date        = 'modified_date';
    const lmp                  = 'lmp';
    const active_fg            = 'active_fg';
    const status_id            = 'status_id';
}

class ChemicalPathologyRequestTable {
    const table_name         = 'chemical_pathology_request';

    const cpreq_id           = 'cpreq_id';
    const patient_id         = 'patient_id';
    const treatment_id       = 'treatment_id';
    const laboratory_ref     = 'laboratory_ref';
    const laboratory_comment = 'laboratory_comment';
    const clinical_diagnosis = 'clinical_diagnosis';
    const created_date       = 'created_date';
    const modified_date      = 'modified_date';
    const active_fg          = 'active_fg';
    const doctor_id          = 'doctor_id';
    const lab_attendant_id   = 'lab_attendant_id';
    const status_id          = 'status_id';
    const cp_ref_id          = 'cp_ref_id';

}

class EncounterTable{
    const table_name = 'encounter';

    const encounter_id = 'encounter_id';
    const personnel_id = 'personnel_id';
    const patient_id   = 'patient_id';
    const admission_id = 'admission_id';
    const comments     = 'comments';
    const created_date = 'created_date';
    const active_fg    = 'active_fg';
}

class AdmissionReqTable {
    const table_name = 'admission_req';

    const admission_req_id = 'admission_req_id';
    const treatment_id     = 'treatment_id';
    const created_date     = 'created_date';
    const modified_date    = 'modified_date';
    const active_fg        = 'active_fg';
}

class AdmissionTable {
    const table_name = 'admission';

    const admission_id  = 'admission_id';
    const bed_id        = 'bed_id';
    const admitted_by   = 'admitted_by';
    const discharged_by = 'discharged_by';
    const patient_id    = 'patient_id';
    const entry_date    = 'entry_date';
    const exit_date     = 'exit_date';
    const comments      = 'comments';
    const created_date  = 'created_date';
    const modified_date = 'modified_date';
    const active_fg     = 'active_fg';
    const treatment_id  = 'treatment_id';
}

class BedTable {
    const table_name = 'bed';

    const bed_id = 'bed_id';
    const bed_description = 'bed_description';
    const bed_status = 'bed_status';
    const ward_id = 'ward_id';
    const created_date = 'created_date';
    const modified_date = 'modified_date';
    const active_fg = 'active_fg';
}

class AdmissionBedTable {
    const table_name = 'admission_bed';

    const admission_bed_id = 'admission_bed_id';
    const admission_id = 'admission_id';
    const bed_id = 'bed_id';
    const active_fg = 'active_fg';
    const created_date = 'created_date';
    const modified_date = 'modified_date';
}

class WardRefTable {
    const table_name = 'ward_ref';

    const ward_ref_id = 'ward_ref_id';
    const description = 'description';
    const created_date = 'created_date';
    const modified_date = 'modified_date';
    const active_fg = 'active_fg';
}

class ExaminationRequestedTable {

    const table_name                 = 'examination_requested';
    const examination_requested_id   = 'examination_requested_id';
    const radiology_id               = 'radiology_id';
    const clinical_diagnosis_details = 'clinical_diagnosis_details';
    const previous_operation         = 'previous_operation';
    const any_known_allergies        = 'any_known_allergies';
    const previous_xray              = 'previous_xray';
    const xray_number                = 'xray_number';
    const create_date                = 'create_date';
    const modified_date              = 'modified_date';
    const active_fg                  = 'active_fg';
}

class EmergencyTable {

    const table_name                 = 'emergency';
    const emergency_id               = 'emergency_id';
    const patient_id                 = 'patient_id';
    const emergency_status_id        = 'emergency_status_id';
    const created_date               = 'created_date';
    const modified_date              = 'modified_date';

}

class ConstantBillsTable {
    const table_name            = 'constant_bills';
    const constant_bill_id      = 'constant_bills_id';
    const item                  = 'item';
    const amount                = 'amount';
    const treatment_id          = 'treatment_id';
    const created_date          = 'created_date';
}

class HospitalInfoTable{
    const table_name = 'hospital_info';

    const hospital_info_id = 'hospital_info_id';
    const name             = 'name';
    const address          = 'address';
    const created_date     = 'created_date';
    const modified_date    = 'modified_date';
}