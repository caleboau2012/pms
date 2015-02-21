<?php
class UserAuthTable {
  const table_name    = 'user_auth';
  const userid        = 'userid';
  const regNo         = 'regNo';
  const passcode      = 'passcode';
  const create_date   = 'create_date';
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
  const create_date = 'create_date';
  const modified_date = 'modified_date';
  const staff_role = 'staff_role';
  const role_label = 'role_label';
  const active_fg = 'active_fg';
}

class StaffPermissionTable {
  const table_name = 'staff_permission';
  const staff_permission_id = 'staff_permission_id';
  const staff_permission = 'staff_permission';
  const create_date = 'create_date';
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
  const create_date = 'create_date';
  const modified_date = 'modified_date';
  const active_fg = 'active_fg';
}

class PermissionRoleTable {
  const table_name = 'permission_role';
  const permission_role_id = 'permission_role_id';
  const userid = 'userid';
  const staff_permission_id = 'staff_permission_id';
  const staff_role_id = 'staff_role_id';
  const create_date = 'create_date';
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
    const create_date       = 'create_date';
    const modified_date     = 'modified_date';
    const active_fg         = 'active_fg';
}

class PatientQueueTable {
  const table_name      = 'patient_queue';
  const patient_queue_id = 'patient_queue_id';
  const patient_id = 'patient_id';
  const doctor_id = 'doctor_id';
  const active_fg = 'active_fg';
  const create_date = 'create_date';
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
    const outgoing_drug_id         = 'prescription_id';
    const created_date             = 'created_date';
    const active_fg                = 'active_fg';
}

class TreatmentTable{
    const table_name = 'drug_inventory';

    const treatment_id      = 'treatment_id';
    const doctor_id         = 'doctor_id';
    const patient_id        = 'patient_id';
    const consultation      = 'consultation';
    const comments          = 'comments';
    const symptoms          = 'symptoms';
    const diagnosis         = 'diagnosis';
    const created_date      = 'created_date';
    const modified_date     = 'modified_date';
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
