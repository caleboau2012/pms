<?php
/**
 * SqlStatement.php
 * -------------
 * It should contain classes which contain constants that represent the SQL queries for that table.
 * in the following format
 * class <database_table>SqlStatement {
 *      ...
 * }
 */

class UserAuthSqlStatement {
        const VERIFY_USER = "SELECT COUNT(*) AS count FROM user_auth WHERE regNo = :regNo AND passcode = :passcode";
        const ADD = 'INSERT INTO user_auth (regNo, passcode, created_date, modified_date, status) VALUES (:regNo, SHA1(:passcode), NOW(), NOW(), :status)';
        const GET = 'SELECT userid, regNo, created_date, modified_date, status, online_status
                                FROM user_auth
                                WHERE regNo = :regNo AND userid = :userid';
        const GET_ALL = 'SELECT p.surname, p.firstname, p.middlename, p.userid, p.department_id, p.work_address, p.home_address, p.telephone, p.sex, p.birth_date, ua.regNo FROM profile as p RIGHT JOIN user_auth as ua ON (p.userid = ua.userid)';

        const CHANGE_PASSCODE = 'UPDATE user_auth SET passcode = SHA1(:passcode), status = :status, modified_date = NOW(), online_status = :online_status WHERE userid = :userid';
        const CHANGE_ONLINE_STATUS = 'UPDATE user_auth SET online_status = :online_status WHERE userid = :userid';
        const CHANGE_STATUS = 'UPDATE user_auth SET status = :status WHERE regNo = :regNo';
        const GET_USER_ROLE = 'SELECT u.userid, u.regNo, p.surname, p.firstname, p.middlename, pr.staff_role_id AS staff_role, pr.staff_permission_id AS staff_permission
            FROM user_auth AS u
                LEFT JOIN profile AS p
                    ON(u.userid = p.userid)
                LEFT JOIN permission_role AS pr
                    ON (p.userid = pr.userid)
            WHERE pr.staff_role_id = :staff_role_id
                    ORDER by p.surname, p.firstname, p.middlename';

        const UPDATE_STATUS = 'UPDATE user_auth SET status = :status WHERE userid = :userid LIMIT 1';
        const GET_USER_BY_CREDENTIALS = "SELECT u.userid, u.regNo, u.status, u.online_status, p.profile_id, p.surname, p.firstname, p.middlename, p.department_id, p.sex
            FROM user_auth AS u
                LEFT JOIN profile AS p
                    ON(u.userid=p.userid)
            WHERE regNo=:regNo AND passcode=SHA1(:passcode)";

        const GET_USER_BY_ID = 'SELECT u.userid, u.regNo, u.online_status, p.profile_id, p.surname, p.firstname, p.middlename, p.department_id, p.sex
        FROM user_auth AS u
            LEFT JOIN profile AS p
                ON(u.userid=p.userid)
        WHERE u.userid=:userid';

        const FLAG_USER_ONLINE = 'UPDATE user_auth SET online_status = 1 WHERE userid=:userid';

        const FLAG_USER_OFFLINE = 'UPDATE user_auth SET online_status = 0 WHERE userid=:userid';

        const GET_BY_REGNO = 'SELECT userid FROM user_auth WHERE regNo=:regNo';

        const GET_STATUS = "SELECT status FROM user_auth WHERE userid = :userid";
}

class ProfileSqlStatement {
        const ADD = 'INSERT INTO profile (userid, surname, firstname, middlename, department_id, work_address, home_address, telephone, sex,
                                        height, weight, birth_date, created_date, modified_date)
                                 VALUES (:userid, LOWER(:surname), LOWER(:firstname), LOWER(:middlename), :department_id, LOWER(:work_address), LOWER(:home_address), :telephone, :sex,
                                                        :height, :weight, :birth_date, NOW(), NOW()) ';
        const GET = 'SELECT ua.regNo, p.userid, surname, firstname, middlename, department_id, work_address, home_address, telephone, sex, height, weight, birth_date
            FROM profile AS p
                INNER JOIN user_auth AS ua
                    ON p.userid = ua.userid
            WHERE regNo = :regNo';
        const UPDATE = 'UPDATE profile SET surname = :surname, firstname = :firstname, middlename = :middlename, work_address = :work_address, home_address = :home_address, telephone = :telephone, sex = :sex, height = :height, weight = :weight,department_id = :department_id, birth_date = :birth_date, modified_date = NOW() WHERE userid = :userid';
        const UPDATE_BASIC_INFO = 'UPDATE profile SET surname = LOWER(:surname), firstname = LOWER(:firstname), middlename = LOWER(:middlename), sex = :sex, birth_date = :birth_date, modified_date = now() WHERE userid = :userid';
        const GET_PROFILE = 'SELECT ua.regNo, p.userid, p.surname, p.firstname, p.middlename, p.department, p.work_address, p.home_address, p.telephone, p.sex,
                                        p.height, p.weight, p.birth_date, p.created_date, p.modified_date FROM profile as p LEFT JOIN user_auth as ua ON(p.userid = ua.userid) WHERE ua.regNo = :regNo';
        const GET_USER_AND_DEPT = 'SELECT dept.department_name, p.firstname, p.middlename, p.surname, FROM profile AS p
                                   LEFT JOIN department AS dept
                                    ON p.department_id = dept.department_id
                                    WHERE p.active_fg = 1
                                    GROUP BY department_name';

        const SEARCH_BY_NAME = "SELECT userid, CONCAT_WS(' ' , surname, firstname, middlename) AS name
            FROM profile
            WHERE (surname LIKE  :name
            OR middlename LIKE  :name
            OR firstname LIKE  :name)
            AND userid != :userid
            LIMIT 0 , 30";

        const BUILD_CONTACT_LIST = "SELECT userid, surname, firstname, middlename FROM profile";
}

class PermissionRoleSqlStatement {
        const DELETE_STAFF_ROLE = 'UPDATE permission_role SET active_fg = 0, modified_date = NOW() WHERE permission_role_id = :permission_role_id';
        const UPDATE_ROLE_PERMISSION = 'UPDATE permission_role SET staff_permission_id = :staff_permission_id, modified_date = NOW() WHERE permission_role_id = :permission_role_id';
        const ADD_STAFF_ROLE = 'INSERT INTO permission_role (userid, staff_permission_id, staff_role_id, created_date, modified_date, active_fg)
                                                        VALUES (:userid, :staff_permission_id, :staff_role_id, NOW(), NOW(), 1)';
        const GET_STAFF_ROLE = "SELECT pr.permission_role_id, pr.staff_role_id, pr.staff_permission_id, pr.userid, sr.role_label, sp.staff_permission FROM permission_role AS pr INNER JOIN staff_role AS sr on pr.staff_role_id = sr.staff_role_id INNER JOIN staff_permission AS sp ON pr.staff_permission_id = sp.staff_permission_id WHERE pr.userid = :userid AND pr.active_fg = 1";
        const GET_ALL_ROLES = "SELECT staff_role_id, role_label FROM staff_role";
        const GET_ALL_PERMISSIONS = "SELECT staff_permission_id, staff_permission FROM staff_permission";
        const CHECK_PERMISSION = "SELECT COUNT(*) AS count FROM staff_permission WHERE staff_permission_id = :staff_permission_id";
        const CHECK_ROLE = "SELECT COUNT(*) AS count FROM staff_role WHERE staff_role_id = :staff_role_id";
        const HAS_ROLE = "SELECT COUNT(*) AS count FROM permission_role WHERE userid = :userid AND staff_role_id = :staff_role_id AND active_fg = 1";
}

class PatientSqlStatement {
        const ADD = 'INSERT INTO patient (surname, firstname, middlename, regNo, home_address, telephone, sex, height, weight, birth_date, nok_firstname, nok_middlename, nok_surname, nok_address, nok_telephone, nok_relationship,
                                          citizenship,  religion,  family_position,  mother_status,  father_status,    marital_status,  no_of_children, created_date, modified_date)
                                 VALUES (LOWER(:surname), LOWER(:firstname), LOWER(:middlename), :regNo, :home_address, :telephone, :sex, :height, :weight, :birth_date, :nok_firstname, :nok_middlename, :nok_surname, :nok_address, :nok_telephone, :nok_relationship,
                                          :citizenship,  :religion,  :family_position,  :mother_status,  :father_status,    :marital_status,  :no_of_children, NOW(), NOW() )';

        const GET = 'SELECT surname, firstname, middlename, regNo, home_address, telephone, sex, height, weight, birth_date, nok_firstname, nok_middlename, nok_surname, nok_address, nok_telephone, nok_relationship, created_date, modified_date
                                    FROM patient WHERE patient_id = :patient_id';
        const UPDATE = 'UPDATE patient SET surname = LOWER(:surname), firstname = LOWER(:firstname), middlename = LOWER(:middlename), regNo = :regNo, home_address = :home_address, telephone = :telephone, sex = :sex, height = :height, weight = :weight, birth_date = :birth_date, nok_firstname = :nok_firstname, nok_middlename = :nok_middlename, nok_surname = :nok_surname, nok_address = :nok_address, nok_telephone = :nok_telephone, nok_relationship = :nok_relationship, modified_date = NOW()';

        const GET_ALL = 'SELECT patient_id, surname, firstname, middlename, regNo, home_address, telephone, sex, height, weight, birth_date, nok_firstname, nok_middlename, nok_surname, nok_address, nok_telephone, nok_relationship, created_date, modified_date
                                    FROM patient';

        const SEARCH = "SELECT p.patient_id, p.surname, p.firstname, p.middlename, p.regNo, p.sex, pq.active_fg AS queue_status
            FROM patient AS p
                LEFT JOIN patient_queue AS pq
                    ON p.patient_id = pq.patient_id
            WHERE (surname LIKE :wildcard
            OR firstname LIKE :wildcard
            OR middlename LIKE :wildcard
            OR regNo = :parameter)
            AND(pq.active_fg IS NULL
            OR pq.active_fg = 0)";
        const SEARCH_BY_NAME_OR_REG_NO = 'SELECT p.patient_id, p.surname, p.firstname, p.middlename, p.regNo, p.sex, pq.active_fg AS queue_status
            FROM patient AS p WHERE (surname LIKE :wildcard OR firstname LIKE :wildcard OR middlename LIKE :wildcard OR regNo = :regNo)';
}

class PatientQueueSqlStatement {
    const ADD = "INSERT INTO patient_queue (patient_id, doctor_id, active_fg, created_date, modified_date) VALUES (:patient_id, :doctor_id, 1, NOW(), NOW())";

    const ADD_TO_GENERAL_QUEUE = "INSERT INTO patient_queue (patient_id, doctor_id, active_fg, created_date, modified_date) VALUES (:patient_id, NULL, 1, NOW(), NOW())";

    const REMOVE = "UPDATE patient_queue SET active_fg = 0, modified_date = NOW() WHERE patient_id = :patient_id AND active_fg != 0";

    const ONLINE_DOCTORS = "SELECT ua.userid, ua.online_status, p.surname, p.firstname, p.middlename
        FROM user_auth AS ua
            LEFT JOIN profile AS p
                ON ua.userid = p.userid
            LEFT JOIN permission_role AS pr
                ON ua.userid = pr.userid
        WHERE ua.online_status = 1
            AND pr.staff_role_id = 2
            AND pr.active_fg = 1
            AND ua.status = 1
            AND ua.active_fg = 1";

    const OFFLINE_DOCTORS_WITH_QUEUE = "SELECT ua.userid, ua.online_status, p.surname, p.firstname, p.middlename
        FROM patient_queue AS pq
            INNER JOIN profile AS p
                ON pq.doctor_id = p.userid
            INNER JOIN user_auth AS ua
                ON ua.userid = pq.doctor_id
        WHERE pq.active_fg = 1
            AND ua.online_status != 1";

    const DOCTOR_QUEUE = "SELECT p.patient_id, p.surname, p.firstname, p.middlename, p.regNo, p.sex
        FROM patient_queue AS pq
            INNER JOIN patient AS p
                ON pq.patient_id = p.patient_id
        WHERE pq.active_fg = 1
            AND p.active_fg = 1
            AND pq.doctor_id = :doctor_id";

    const GET_LAST_MODIFIED_TIME = "SELECT MAX(modified_date) AS LMT FROM patient_queue";

    const PATIENT_ON_QUEUE = "SELECT COUNT(*) AS count FROM patient_queue WHERE patient_id = :patient_id AND active_fg = 1";

    const CHANGE_IN_QUEUE = "SELECT COUNT(*) AS count FROM patient_queue WHERE modified_date > :modified_date";
}

class RosterSqlStatement {
    const ADD = 'INSERT INTO roster (user_id, created_by, dept_id, duty, duty_date, created_date, modified_date)
                    VALUES (:user_id, :created_by, :dept_id, :duty, :duty_date, now(), now())';
    const GET_BY_ID = 'SELECT user_id, created_by, dept_id, duty, duty_date, created_date, modified_date, modified_by
                FROM roster WHERE roster_id=:roster_id';

    const GET_ALL = 'SELECT r.roster_id, r.user_id, r.created_by, r.dept_id, r.duty, r.duty_date, r.created_date, r.modified_date, r.modified_by, p.surname, p.firstname, r.user_id, p.middlename
                FROM roster AS r INNER JOIN profile AS p ON p.userid = r.user_id WHERE r.active_fg = 1';
    const GET_BY_STAFF_ID = 'SELECT r.roster_id, r.user_id, r.created_by, r.dept_id, r.duty, r.duty_date, r.created_date, r.modified_date, r.modified_by, p.surname, p.firstname, r.user_id, p.middlename
                FROM roster AS r INNER JOIN profile AS p ON p.userid = r.user_id WHERE r.user_id = :user_id AND r.active_fg = 1';
    const GET_BY_DOCTOR = 'SELECT user_id, created_by, dept_id, duty, duty_date, created_date, modified_date, modified_by
                FROM roster WHERE user_id=:user_id';
    const UPDATE = 'UPDATE roster SET  duty_date=:duty_date, modified_date= now(), modified_by=:modified_by
                        WHERE roster_id = :roster_id';
    const DELETE_ROSTER = 'UPDATE roster SET active_fg = 0, modified_date = now(), modified_by = :modified_by
                            WHERE roster_id = :roster_id';
}

class DepartmentSqlStatment{
    const GET_ALL = 'SELECT department_id, department_name FROM department';
}

class CommunicationSqlStatement {
    const GET_INBOX = "SELECT profile.surname, profile.middlename, profile.firstname, msg_id, sender_id, msg_subject, msg_body, msg_status, communication.created_date 
        FROM communication 
            INNER JOIN profile 
                ON communication.sender_id = profile.userid
        WHERE recipient_id = :recipient_id 
        ORDER BY communication.created_date DESC
        LIMIT @offset, @count";

    const GET_SENT_MESSAGES = "SELECT profile.surname, profile.middlename, profile.firstname, msg_id, recipient_id, msg_subject, msg_body, communication.created_date
        FROM communication 
            INNER JOIN profile 
                ON communication.recipient_id = profile.userid
        WHERE sender_id = :sender_id 
        ORDER BY communication.created_date DESC
        LIMIT @offset, @count";

    const COUNT_INBOX = "SELECT 
        (SELECT COUNT(*) FROM communication WHERE recipient_id = :recipient_id) AS count, 
        (SELECT COUNT(*) FROM communication WHERE recipient_id = :recipient_id AND msg_status = 1) AS unread";

    const COUNT_SENT = "SELECT COUNT(*) AS count FROM communication WHERE sender_id = :sender_id";

    const SEND_MESSAGE = "INSERT INTO communication (sender_id, recipient_id, msg_subject, msg_body, msg_status, active_fg, created_date, modified_date) VALUES (:sender_id, :recipient_id, :msg_subject, :msg_body, 1, 1, NOW(), NOW())";

    const CHECK_INBOX_MESSAGE = "SELECT COUNT(*) AS count FROM communication WHERE msg_id = :msg_id AND recipient_id = :recipient_id";

    const CHECK_SENT_MESSAGE = "SELECT COUNT(*) AS count FROM communication WHERE msg_id = :msg_id AND sender_id = :sender_id";

    const GET_INBOX_MESSAGE = "SELECT CONCAT_WS(' ', profile.surname, profile.middlename, profile.firstname) AS sender_name, msg_id, sender_id, msg_subject, msg_body, msg_status, communication.created_date 
        FROM communication
            INNER JOIN profile
                ON communication.sender_id = profile.userid
        WHERE recipient_id = :recipient_id
        AND msg_id = :msg_id";

    const GET_SENT_MESSAGE = "SELECT CONCAT_WS(' ', profile.surname, profile.middlename, profile.firstname) AS recipient_name, msg_id, recipient_id, msg_subject, msg_body, communication.created_date
        FROM communication
            INNER JOIN profile
                ON communication.recipient_id = profile.userid
        WHERE sender_id = :sender_id
        AND msg_id = :msg_id";

    const MARK_AS_READ = "UPDATE communication SET msg_status = 0, modified_date = NOW() WHERE msg_id = :msg_id AND recipient_id = :recipient_id";

    const MARK_AS_UNREAD = "UPDATE communication SET msg_status = 1, modified_date = NOW() WHERE msg_id = :msg_id AND recipient_id = :recipient_id";

    const CHECK_NEW_MESSAGE = "SELECT COUNT(*) AS count FROM communication WHERE created_date > :created_date AND recipient_id = :recipient_id";

    const CHECK_MSG_STATUS = "SELECT msg_status FROM communication WHERE msg_id = :msg_id AND recipient_id = :recipient_id";
}

class PrescriptionSqlStatement{
    const GET_PRESCRIPTION = "SELECT * FROM prescription AS p WHERE p.treatment_id = :treatment_id AND status = 1";
    const GET_QUEUE = "SELECT t.treatment_id, t.patient_id, pa.firstname, pa.surname, pa.middlename, pa.regNo FROM
                      treatment AS t INNER JOIN prescription as p ON (t.treatment_id = p.treatment_id)  INNER JOIN
                      patient as pa ON (t.patient_id = pa.patient_id) WHERE p.status = :status GROUP BY t.treatment_id";
    const UPDATE_STATUS = "UPDATE prescription AS p SET p.status = :status WHERE prescription_id = :prescription_id";
    const PRESCRIPTION_DRUG = "INSERT INTO outgoing_drugs AS od ";
}

class DrugSqlStatement{
    const GET = "SELECT drug_ref_id, name drug FROM drug_ref";
    const GET_DRUG_ID = "SELECT d.drug_ref_id FROM drug_ref AS d WHERE d.name = :name";
    const ADD_DRUG = "INSERT INTO drug_ref (name, created_date) VALUES (:name, NOW())";
    const ADD_OUTGOING_DRUG = "INSERT INTO outgoing_drugs (drug_id, qty, unit_id, created_date, modified_date)
                              VALUES (:drug_id, :qty, :unit_id, NOW(), NOW())";
    const MAP_PHARMACIST_OUTGOING_DRUG = "INSERT INTO pharmacist_outgoing_drug (pharmacist_id, outgoing_drug_id, created_date)
                              VALUES (:pharmacist_id, :outgoing_drug_id, NOW())";
    const MAP_PRESCRIPTION_TO_OUTGOING_DRUG = "INSERT INTO prescription_outgoing_drug (prescription_id, outgoing_drug_id, created_date)
                              VALUES (:prescription_id, :outgoing_drug_id, NOW())";
}

class VitalsSqlStatement {
    const ADD = "INSERT INTO vitals (patient_id, encounter_id, added_by, temp, pulse, respiratory_rate, blood_pressure, height, weight, bmi, active_fg, created_date) VALUES (:patient_id, :encounter_id, :added_by, :temp, :pulse, :respiratory_rate, :blood_pressure, :height, :weight, :bmi, 1, NOW())";
    const GET_VITALS = "SELECT patient_id, encounter_id, added_by, temp, pulse, respiratory_rate, blood_pressure, height, weight, bmi, created_date FROM vitals WHERE patient_id = :patient_id";
}

class UnitsSqlStatement{
    const GET = "SELECT unit_ref_id, unit FROM unit_ref";
}

class HaematologySqlStatement {

    const ADD = 'INSERT INTO haematology(clinical_diagnosis_details,doctor_id,lab_attendant_id,laboratory_report,laboratory_ref,create_date, modified_date,treatment_id)
                                        VALUES(:clinical_diagnosis_details, :doctor_id, :lab_attendant_id, :laboratory_report, :laboratory_ref, now(), now(), :treatment_id)';
    const DELETE = 'DELETE FROM haematology WHERE treatment_id = :treatment_id';
    const GET = 'SELECT * FROM haematology WHERE treatment_id = :treatment_id ORDER BY create_date DESC LIMIT 1';
    const GET_TEST = 'SELECT * FROM haematology WHERE haematology_id = :haematology_id LIMIT 1';
    const GET_HISTORY = 'SELECT p.patient_id AS patient_id,
    p.regNo AS regNo,
    h.haematology_id AS testid,
    h.clinical_diagnosis_details AS diagnosis,
    h.create_date AS created_date
FROM
    haematology h
    LEFT JOIN treatment t ON (t.treatment_id = h.treatment_id)
    LEFT JOIN patient p ON (p.patient_id = t.patient_id)
    WHERE h.treatment_id = :treatment_id
    ORDER BY h.modified_date DESC';

    const UPDATE = 'UPDATE haematology
                    SET laboratory_report = :laboratory_report, laboratory_ref = :laboratory_ref, status_id=:status_id, modified_date = now()
                    WHERE treatment_id=:treatment_id AND haematology_id=:haematology_id';

    const GET_ALL_TEST = 'SELECT h.haematology_id, p.surname, p.middlename, p.firstname, p.regNo, h.status_id, h.treatment_id, h.modified_date FROM haematology h
    LEFT JOIN treatment t ON (h.treatment_id=t.treatment_id)
    LEFT JOIN patient p ON (p.patient_id=t.patient_id)
    ORDER BY h.modified_date DESC';

    const GET_EACH_TEST = "SELECT h.*, fa.*, dc.*, bt.* FROM haematology h
 LEFT JOIN film_appearance fa ON (fa.haematology_id=h.haematology_id)
 LEFT JOIN blood_test bt ON (bt.haematology_id= h.haematology_id)
 LEFT JOIN differential_count dc ON (dc.haematology_id=h.haematology_id)
 WHERE h.haematology_id=:haematolgy_id AND h.active_fg= 1";

    const GET_STATUS = "SELECT h.active_fg FROM treatment t
      LEFT JOIN haematology h ON (t.treatment_id=h.treatment_id)
      WHERE h.treatment_id=:treatment_id";

    const GET_TEST_BY_REGNO = 'SELECT h.haematology_id, p.surname, p.middlename, p.firstname, p.regNo, h.status_id, h.treatment_id FROM haematology h
    LEFT JOIN treatment t ON (t.treatment_id=h.treatment_id)
    LEFT JOIN patient p (p.patient_id=t.patient_id)
    WHERE h.treatment_id=:treatment_id
    ORDER BY h.modified_date DESC';

    const GET_TEST_BY_SEARCHQUERY = 'SELECT p.surname, p.middlename, p.firstname, p.regNo, h.status_id, h.treatment_id, h.modified_date FROM haematology h
    LEFT JOIN treatment t ON (t.treatment_id=h.treatment_id)
    LEFT JOIN patient p ON (p.patient_id=t.treatment_id)
    WHERE p.regNo LIKE "%":search_query"%"
    ORDER BY h.modified_date DESC';

    const PENDING_TEST = 'SELECT h.haematology_id AS testid, p.surname, p.firstname, p.middlename, h.treatment_id, h.status_id, h.modified_date FROM haematology h
    LEFT JOIN treatment t ON (t.treatment_id=h.treatment_id)
    LEFT JOIN patient p ON (p.patient_id=t.patient_id)
    WHERE h.status_id=5
    ORDER BY h.modified_date DESC';

    const CHANGE_IN_QUEUE = 'SELECT COUNT(modified_date) AS counter FROM haematology WHERE modified_date > :change_time';
    const LAST_MODIFIED_DATE = 'SELECT MAX(modified_date) AS maxim FROM haematology WHERE status_id=5';
}


class UrineSqlStatement {

    const ADD = 'INSERT INTO urine(treatment_id,lab_attendant_id,clinical_diagnosis_details,investigation_required,doctor_id,laboratory_report,laboratory_ref,culture_value,create_date,modified_date)
                                        VALUES(:treatment_id, :lab_attendant_id, :clinical_diagnosis_details,:investigation_required,:doctor_id,:laboratory_report,:laboratory_ref,:culture_value, now(), now())';
    const DELETE = 'DELETE FROM urine WHERE userid = :userid';
    const GET = 'SELECT treatment_id,lab_attendant_id,clinical_diagnosis_details,investigation_required,doctor_id,laboratory_report,laboratory_ref,culture_value,create_date,modified_date FROM urine WHERE userid = :userid ORDER BY create_date DESC LIMIT 1';
    const GET_TEST = 'SELECT treatment_id,lab_attendant_id,clinical_diagnosis_details,investigation_required,doctor_id,laboratory_report,laboratory_ref,culture_value,create_date,modified_date FROM urine WHERE urine_id=:urine_id LIMIT 1';
    const GET_HISTORY = 'SELECT p.patient_id, p.regNo, u.urine_id AS testid, u.clinical_diagnosis_details AS diagnosis, u.create_date
        FROM urine u
        LEFT JOIN treatment t ON (t.treatment_id=u.treatment_id)
        LEFT JOIN patient p ON (p.patient_id=t.treatment_id)
        WHERE u.treatment_id= :treatment_id
        ORDER BY u.modified_date DESC';

    const UPDATE = 'UPDATE urine SET clinical_diagnosis_details = :clinical_diagnosis_details ,
                    investigation_required = :investigation_required,laboratory_report = :laboratory_report,
                    laboratory_ref = :laboratory_ref,culture_value =:culture_value, lab_attendant_id = :lab_attendant_id,
                    modified_date = NOW(), status_id =:status_id
                    WHERE urine_id=:urine_id';

    const GET_URINE_ID = 'SELECT urine_id from urine where treatment_id = :treatment_id';
    const GET_TEST_BY_REG_NUM = 'SELECT p.surname, p.middlename, p.firstname, p.regNo FROM urine u
                                 LEFT JOIN treatment t ON (t.treatment_id=u.treatment_id)
                                 LEFT JOIN patient p ON (p.patient_id=t.patient_id)
                                 WHERE (u.status_id=1) AND (p.regNo=:regNo)
                                 ORDER BY u.modified_date DESC';

    const GET_ALL_TEST = 'SELECT u.urine_id, p.surname, p.middlename, p.firstname, p.regNo, u.status_id, u.treatment_id, u.modified_date FROM urine u
                          LEFT JOIN treatment t ON (t.treatment_id=u.treatment_id)
                          LEFT JOIN patient p ON (p.patient_id=t.patient_id)
                          ORDER BY u.modified_date DESC';

    const GET_TEST_BY_REGNO = 'SELECT p.surname, p.middlename, p.firstname, p.regNo, u.status_id, u.treatment_id FROM urine u
                               LEFT JOIN treatment t ON (t.treatment_id=u.treatment_id)
                               LEFT JOIN patient p ON (p.patient_id=t.patient_id)
                               WHERE u.treatment_id=:treatment_id
                               ORDER BY u.modified_date DESC';

    const GET_TEST_BY_SEARCHQUERY= 'SELECT p.surname, p.middlename, p.firstname, p.regNo, u.status_id, u.treatment_id, u.modified_date FROM urine u
                                    LEFT JOIN treatment t ON (t.treatment_id=u.treatment_id)
                                    LEFT JOIN patient p ON (p.patient_id=t.patient_id)
                                    WHERE p.regNo = LIKE "%":search_query"%"
                                    ORDER BY u.modified_date DESC';

    const PENDING_TEST = 'SELECT u.urine_id AS test_id, p.surname, p.firstname, p.middlename, u.treatment_id, u.status_id, u.modified_date FROM urine u
                          LEFT JOIN treatment t ON (t.treatment_id=u.treatment_id)
                          LEFT JOIN patient p ON (p.patient_id=t.patient_id)
                          WHERE u.status_id=5
                          ORDER BY u.modified_date DESC';
    const CHANGE_IN_QUEUE = 'SELECT COUNT(modified_date) AS counter FROM urine WHERE modified_date > :change_time';
    const LAST_MODIFIED_DATE = 'SELECT MAX(modified_date) AS maxim FROM urine WHERE status_id=5';

}

class UrinalysisSqlStatement {

    const ADD    = 'INSERT INTO urinalysis(urine_id, appearance, ph, glucose, protein, bilirubin, urobillinogen, created_date, modified_date) VALUES(:urine_id, :appearance, :ph, :glucose, :protein, :bilirubin, :urobillinogen, NOW(), NOW())';
    const DELETE = 'DELETE FROM urinalysis WHERE treatment_id = :treatment_id';
    const GET    = 'SELECT * FROM urinalysis u WHERE u.urine_id IN (SELECT urine_id FROM urine WHERE treatment_id = :treatment_id)
                    ORDER BY u.created_date DESC LIMIT 1';
    const GET_TEST = 'SELECT ur.*, u.urine_id FROM urine u, urinalysis ur WHERE ur.urine_id=:urine_id AND u.urine_id=ur.urine_id LIMIT 1';
    const ADD_UPDATE = 'INSERT INTO urinalysis(urine_id, appearance, ph, glucose, protein, bilirubin, urobillinogen, created_date, modified_date) VALUES(:urine_id, :appearance, :ph, :glucose, :protein, :bilirubin, :urobillinogen, NOW(), NOW())
                        ON DUPLICATE KEY
                        UPDATE appearance = :appearance, ph = :ph, glucose = :glucose, protein = :protein, bilirubin = :bilirubin, urobillinogen = :urobillinogen, modified_date = now()';
}

class UrineSensitivitySqlStatement {
    const ADD    = 'INSERT INTO urine_sensitivity(urine_id,isolates,isolates_degree, create_date, modified_date) VALUES(:urine_id,:isolates,:isolates_degree, now(), now())';
    const GET    = 'SELECT ur.urine_sensitivity_id, ur.urine_id, ur.isolates, ur.isolates_degree,ur.created_date,ur.modified_date
                        FROM urine_sensitivity ur
                        WHERE ur.urine_id IN (SELECT urine_id FROM urine WHERE treatment_id = :treatment_id)
                        ORDER BY ur.created_date';
    const GET_TEST = 'SELECT us.isolates, us.isolates_degree, us.modified_date, u.urine_id
                        FROM urine u, urine_sensitivity us
                        WHERE us.urine_id=:urine_id AND u.urine_id=us.urine_id LIMIT 1';
    // const UPDATE = 'UPDATE urine_sensitivity SET isolates = :isolates,isolates_degree = :isolates_degree, modified_date = now() WHERE urine_id IN (SELECT urine_id from urine where userid = :userid)';
    const UPDATE = 'UPDATE urine_sensitivity SET isolates_degree = :isolates_degree, modified_date = NOW() WHERE isolates = :isolates AND urine_id = :urine_id';
    const GET_URINE_ID = 'SELECT urine_id FROM urine WHERE treatment_id = :treatment_id';
    const ADD_ISOLATES = 'INSERT INTO urine_sensitivity (urine_id, isolates, isolates_degree, created_date, modified_date)
                          VALUES :vals';
    const DELETE_ISOLATE = 'UPDATE urine_sensitivity SET active_fg = :active_fg WHERE urine_id = :urine_id AND isolates = :isolates';
    const UPDATE_ISOLATES = 'UPDATE urine_sensitivity SET isolates_degree = :isolates_degree, modified_date = NOW(),
                             active_fg = :active_fg WHERE urine_id = :urine_id AND isolates = :isolates';
    const GET_ISOLATES = 'SELECT isolates FROM urine_sensitivity WHERE urine_id = :urine_id';
}

class UrineSensitivityRefSqlStatement {

    const GET = 'SELECT * FROM urine_sensitivity_ref';

}

class MicroscopySqlStatement {

    const ADD = 'INSERT INTO microscopy(urine_id,pus_cells,red_cells,epithelial_cells,casts,crystals,others, created_date, modified_date)
                                        VALUES(:urine_id,:pus_cells,:red_cells,:epithelial_cells,:casts,:crystals,:others, NOW(), NOW())';
    const DELETE = 'DELETE FROM microscopy WHERE urine_id = :urine_id';
    const GET    = 'SELECT m.urine_id, m.pus_cells, m.red_cells, m.epithelial_cells, m.casts, m.crystals, m.others, m.created_date, m.modified_date
                        FROM microscopy m
                        WHERE m.urine_id IN (SELECT urine_id FROM urine WHERE treatment_id = :treatment_id)
                        ORDER BY m.modified_date DESC LIMIT 1';
    const GET_TEST = 'SELECT m.pus_cells,m.red_cells,m.epithelial_cells,m.casts,m.crystals,m.others, m.modified_date, u.urine_id FROM urine u, microscopy m
                            WHERE m.urine_id=:urine_id AND u.urine_id=m.urine_id LIMIT 1';
    const ADD_UPDATE = 'INSERT INTO microscopy (urine_id,pus_cells,red_cells,epithelial_cells,casts,crystals,others, created_date, modified_date)
                        VALUES(:urine_id,:pus_cells,:red_cells,:epithelial_cells,:casts,:crystals,:others, NOW(), NOW())
                        ON DUPLICATE KEY
                        UPDATE pus_cells = :pus_cells,red_cells = :red_cells,epithelial_cells = :epithelial_cells,casts = :casts,crystals = :crystals,others = :others, modified_date = now()';

}

class ChemicalPathologyRequestSqlStatement2 {
    const ADD    = 'INSERT INTO chemical_pathology_request(treatment_id, laboratory_ref, laboratory_comment, clinical_diagnosis,created_date,modified_date,doctor_id,lab_attendant_id) VALUES(:treatment_id, :laboratory_ref, :laboratory_comment, :clinical_diagnosis,now(),now(),:doctor_id,:lab_attendant_id)';
    const DELETE = 'DELETE FROM chemical_pathology_request where cpreg_id = :cpreg_id';
    const GET    = 'SELECT treatment_id, laboratory_ref, laboratory_comment, clinical_diagnosis,modified_date,doctor_id,lab_attendant_id
                        FROM chemical_pathology_request WHERE cpreg_id = :cpreg_id';
    const GET_TEST = 'SELECT treatment_id, laboratory_ref, laboratory_comment, clinical_diagnosis,modified_date,doctor_id,lab_attendant_id FROM chemical_pathology_request WHERE cpreq_id = :cpreq_id LIMIT 1';

    const GET_CHEMICAL_PATH_REQ_ID = 'SELECT preq_id from parasitology_reg where preq_id = :preq_id ';

    const GET_ALL_TEST = 'SELECT p.surname, p.middlename, p.firstname, p.regNo, cpr.status_id, cpr.treatment_id AS testid, cpr.modified_date, cpr.cpreq_id
                            FROM chemical_pathology_request cpr
                            LEFT JOIN treatment t ON (t.treatment_id=cpr.treatment_id)
                            LEFT JOIN patient p ON (p.patient_id=t.patient_id)
                            ORDER BY cpr.modified_date DESC';

    const GET_TEST_BY_REGNO = 'SELECT p.surname, p.middlename, p.firstname, p.regNo, cpr.status_id, cpr.treatment_id AS testid, cpr.modified_date
                                    FROM chemical_pathology_request cpr
                                    LEFT JOIN treatment t ON (t.treatment_id=cpr.treatment_id)
                                    LEFT JOIN patient p ON (p.patient_id=t.patient_id)
                                    WHERE cpr.treatment_id=:treatment_id
                                    ORDER BY cpr.modified_date DESC';

    const GET_TEST_BY_SEARCHQUERY = 'SELECT p.surname, p.middlename, p.firstname, p.regNo, cpr.status_id, cpr.treatment_id AS testid, cpr.modified_date
	FROM chemical_pathology_request cpr
	LEFT JOIN treatment t ON (t.treatment_id=cpr.treatment_id)
	LEFT JOIN patient p ON (p.patient_id=t.patient_id)
	WHERE p.regNo LIKE "%":search_query"%"
	ORDER BY cpr.modified_date DESC';

    const PENDING_TEST = 'SELECT  cpr.cpreq_id AS test_id, i.surname, i.firstname, i.middlename, ua.regNo, cpr.status_id, cpr.patient_id AS userid FROM chemical_pathology_request cpr
    LEFT JOIN user_auth ua ON (ua.userid=cpr.patient_id)
    LEFT JOIN identification i ON (i.userid=ua.userid)
    WHERE cpr.status_id=5
    ORDER BY cpr.modified_date DESC';

    const GET_HISTORY = 'SELECT user_auth.userid AS userid
    , user_auth.regNo AS regNo
    , chemical_pathology_request.cpreq_id AS testid
    , chemical_pathology_request.clinical_diagnosis AS diagnosis
        , chemical_pathology_request.created_date AS `date`
        FROM
            user_auth
            INNER JOIN chemical_pathology_request
                ON (user_auth.userid = chemical_pathology_request.patient_id)
            WHERE chemical_pathology_request.patient_id = :userid
        ORDER BY chemical_pathology_request.modified_date DESC;
    ';
    const CHANGE_IN_QUEUE = 'SELECT COUNT(modified_date) AS counter FROM chemical_pathology_request WHERE modified_date > :change_time';
    const LAST_MODIFIED_DATE = 'SELECT MAX(modified_date) AS maxim FROM chemical_pathology_request WHERE status_id=5';
}


class ParasitologyRefSqlStatement {
    const ADD    = 'INSERT INTO parasitology_ref(pref_id, parasite_name, parasite_type, activ_fg) VALUES(:pref_id, :parasite_name, :parasite_type, :activ_fg)';
    const DELETE = 'DELETE FROM parasitology_ref where pref_id = :pref_id';
    const GET    = 'SELECT * FROM parasitology_ref where pref_id = :pref_id';
}

class ParasitologyRequestSqlStatement {
    const ADD_REQ_INFO = "INSERT INTO parasitology_req (doctor_id, treatment_id, diagnosis, created_date, modified_date)
                          VALUES (:doctor_id, :treatment_id, ::diagnosis, NOW(), NOW())";
    const GET_HISTORY = "SELECT * FROM parasitology_req WHERE treatment_id IN (SELECT treatment_id FROM treatment AS t WHERE t.patient_id = :patient_id)";
    const GET_PATIENT_QUEUE = "SELECT * FROM parasitology_req AS pr INNER JOIN treatment AS t ON pr.treatment_id  = t.treatment_id
                               INNER JOIN patient AS p ON t.patient_id = p.patient_id WHERE pr.status_id = :status_id
                               AND pr.active_fg = :active_fg";
    const GET_ALL_TEST = "SELECT * FROM parasitology_req AS pr INNER JOIN treatment AS t ON pr.treatment_id  = t.treatment_id
                          INNER JOIN patient AS p ON t.patient_id = p.patient_id WHERE pr.active_fg = :active_fg";
    const GET_DETAILS = "SELECT * FROM parasitology_req WHERE treatment_id = :treatment_id AND active_fg = :active_fg";
    const GET_PARASITES = "SELECT pref_id FROM parasitology_details WHERE preq_id IN (SELECT preq_id FROM parasitology_req WHERE treatment_id = :treatment_id) AND active_fg = :active_fg";
    const UPDATE_DETAILS = "UPDATE parasitology_req SET nature_of_specimen = :nature_of_specimen,
                            investigation_req = :investigation_req, lab_num = :lab_num, lab_comment = :lab_comment,
                            lab_attendant_id = :lab_attendant_id, status_id =:status_id, modified_date = NOW() WHERE preq_id = :preq_id";
    const ADD    = 'INSERT INTO parasitology_req(treatment_id, nature_of_specimen, investigation_req, diagnosis, date_reported, created_date, modified_date, doctor_id, lab_attendant_id) VALUES(:treatment_id, :nature_of_specimen, :investigation_req, :diagnosis, now(), now(), now(),:doctor_id,:lab_attendant_id)';
    const DELETE = 'DELETE FROM parasitology_req where preg_id = :preg_id';
    const GET    = 'SELECT * FROM parasitology_req where preq_id = :preq_id';
    const UPDATE = 'UPDATE parasitology_req
                    SET
                    nature_of_specimen = :nature_of_specimen,
                    investigation_req = :investigation_req,
                    lab_num = :lab_num,
                    lab_comment = :lab_comment,
                    status_id =:status_id,
                    modified_date = NOW()
                    WHERE preq_id = :preq_id';
    const GET_PARASITOLOGY_REQ_ID = 'SELECT preq_id from parasitology_req where preq_id = :preq_id ';

    const GET_BY_REGNO = 'SELECT i.surname, i.middlename, i.firstname, ua.regNo, pr.status_id, pr.user_id FROM parasitology_req pr
    LEFT JOIN user_auth ua ON (ua.userid=pr.user_id)
    LEFT JOIN identification i ON (i.userid=ua.userid)
    WHERE pr.user_id=:userid
    ORDER BY pr.modified_date DESC';

    const PENDING_TEST = 'SELECT pr.preq_id AS test_id, i.surname, i.firstname, i.middlename, ua.regNo, pr.status_id, pr.user_id AS userid, pr.modified_date FROM parasitology_req pr
    LEFT JOIN user_auth ua ON (ua.userid=pr.user_id)
    LEFT JOIN identification i ON (i.userid=ua.userid)
    WHERE pr.status_id=5
    ORDER BY pr.modified_date DESC';

    const GET_TEST_BY_SEARCHQUERY = 'SELECT i.surname, i.middlename, i.firstname, ua.regNo, pr.status_id, pr.user_id AS userid, pr.modified_date FROM parasitology_req pr
    LEFT JOIN user_auth ua ON (ua.userid=pr.user_id)
    LEFT JOIN identification i ON (i.userid=ua.userid)
    WHERE ua.regNo LIKE "%":search_query"%"
    ORDER BY pr.modified_date DESC';
    const GET_HISTORY2 = 'SELECT user_auth.userid AS userid
    , user_auth.regNo AS regNo
    , parasitology_req.preq_id AS testid
    , parasitology_req.diagnosis AS diagnosis
        , parasitology_req.created_date AS `date`
        FROM
            user_auth
            INNER JOIN parasitology_req
                ON (user_auth.userid = parasitology_req.user_id)
            WHERE parasitology_req.user_id = :userid
        ORDER BY parasitology_req.modified_date DESC;
    ';
    const CHANGE_IN_QUEUE = 'SELECT COUNT(modified_date) AS counter FROM parasitology_req WHERE modified_date > :change_time';
    const LAST_MODIFIED_DATE = 'SELECT MAX(modified_date) AS maxim FROM parasitology_req WHERE status_id=5';

}

class ParasitologyDetailsSqlStatement {
    const UPDATE_PARASITE_STATUS = 'UPDATE parasitology_details SET active_fg = IF(pref_id IN :ids, 1, 0),
                                    modified_date = NOW() WHERE preq_id = :preq_id';
    const ADD_IF_NEW = 'INSERT INTO parasitology_details (preq_id, pref_id, created_date, modified_date)
                        VALUES (:preq_id, :pref_id, NOW(), NOW()) WHERE ';
    const ADD    = 'INSERT INTO parasitology_details(preq_id, pref_id, created_date, modified_date) VALUES(:preq_id, :pref_id, now(), now())';
    const DELETE = 'DELETE FROM parasitology_details where preq_id = :preq_id and pref_id = :pref_id';
    const GET    = 'SELECT * FROM parasitology_details where preq_id = :preq_id';
    const UPDATE = 'UPDATE parasitology_details
                    SET
                    modified_date = NOW()
                    WHERE preq_id = :preq_id AND  pref_id = :pref_id';
    const RECORD_CHECK = 'SELECT COUNT(*) as num  FROM parasitology_details
                    WHERE preq_id = :preq_id AND  pref_id = :pref_id';
    const GET_IDS = 'SELECT pref_id FROM parasitology_details WHERE preq_id = :preq_id';
    const UPDATE_IDS = 'UPDATE parasitology_details SET active_fg = :active_fg, modified_date = NOW() WHERE preq_id = :preq_id AND pref_id = :pref_id';
    const ADD_VALUES = 'INSERT into parasitology_details (preq_id, pref_id, created_date, modified_date) VALUES :vals';
}

class EncounterSqlStatement{
    const GET_HISTORY = 'SELECT * FROM encounter AS e WHERE admission_id = :admission_id ORDER BY e.created_date DESC';
    const ADD = "INSERT INTO encounter(personnel_id, patient_id, admission_id, comments, created_date, active_fg) VALUES(:personnel_id, :patient_id, :admission_id, :comments, NOW(), 1)";
}

class RadiologyRequestSqlStatement{
    const ADD_RAD_INFO = "INSERT INTO radiology (doctor_id, treatment_id, created_date, modified_date) VALUES (:doctor_id, :treatment_id, NOW(), NOW())";
    const ADD_RAD_REQ_INFO = "INSERT INTO radiology_request (radiology_id, clinical_diagnosis_details, created_date, modified_date)
                              VALUES (:radiology_id, :clinical_diagnosis_details, NOW(), NOW())";
    const GET_HISTORY = "SELECT * FROM radiology AS r INNER JOIN radiology_request AS rr ON(r.radiology_id = rr.radiology_id) WHERE treatment_id IN (SELECT treatment_id FROM treatment AS t WHERE t.patient_id = :patient_id)";
    const GET_PATIENT_QUEUE = "SELECT * FROM radiology_request AS rr INNER JOIN radiology AS r ON
                               rr.radiology_id = r.radiology_id INNER JOIN treatment AS t ON
                               r.treatment_id  = t.treatment_id INNER JOIN patient AS p ON t.patient_id = p.patient_id
                               WHERE r.status_id = :status_id AND rr.active_fg = :active_fg";
    const GET_ALL_TEST = "SELECT * FROM radiology_request AS rr INNER JOIN radiology AS r ON
                          rr.radiology_id = r.radiology_id INNER JOIN treatment AS t ON
                          r.treatment_id  = t.treatment_id INNER JOIN patient AS p ON t.patient_id = p.patient_id
                          WHERE rr.active_fg = :active_fg";
    const GET_DETAILS = "SELECT * FROM radiology AS r INNER JOIN radiology_request as rr ON
                         r.radiology_id = rr.radiology_id LEFT JOIN xray_no AS x ON x.radiology_id INNER JOIN treatment
                         AS t on r.treatment_id = t.treatment_id WHERE t.treatment_id = :treatment_id";
    const UPDATE_DETAILS = "UPDATE radiology_request SET clinical_diagnosis_details = :clinical_diagnosis_details,
                            previous_operation = :previous_operation, any_known_allergies = :any_known_allergies,
                            previous_xray = :previous_xray, xray_number = :xray_number, modified_date = NOW()
                            WHERE radiology_id = :radiology_id";
}

class RadiologySqlStatement{
    const UPDATE = "UPDATE radiology SET lab_attendant_id = :lab_attendant_id, xray_case_id = :xray_case_id,
                    xray_size_id = :xray_size_id, consultant_in_charge = :consultant_in_charge, checked_by = :checked_by,
                    radiographers_note = :radiographers_note, radiologists_report = :radiologists_report, lmp = :lmp
                    modified_date = NOW() WHERE radiology_id = :radiology_id";
}

class HaematologyRequestSqlStatement{
    const ADD_REQ_INFO = "INSERT INTO haematology (doctor_id, treatment_id, clinical_diagnosis_details, created_date, modified_date)
                          VALUES (:doctor_id, :treatment_id, :clinical_diagnosis_details, NOW(), NOW())";
    const GET_HISTORY = "SELECT * FROM haematology AS h WHERE treatment_id IN (SELECT treatment_id FROM treatment AS t
                         WHERE t.patient_id = :patient_id)";
    const GET_PATIENT_QUEUE = "SELECT * FROM haematology AS h INNER JOIN treatment AS t ON h.treatment_id  = t.treatment_id
                               INNER JOIN patient AS p ON t.patient_id = p.patient_id WHERE h.status_id = :status_id
                               AND h.active_fg = :active_fg";
    const GET_ALL_TEST = "SELECT * FROM haematology AS h INNER JOIN treatment AS t ON h.treatment_id  = t.treatment_id
                          INNER JOIN patient AS p ON t.patient_id = p.patient_id WHERE h.active_fg = :active_fg";
    const GET_DETAILS = "SELECT * FROM haematology AS h INNER JOIN treatment AS t on h.treatment_id = t.treatment_id
                         WHERE  h.treatment_id = :treatment_id";
    const UPDATE_DETAILS = "UPDATE haematology SET clinical_diagnosis_details = :clinical_diagnosis_details,
                            lab_attendant_id = :lab_attendant_id, laboratory_report = :laboratory_report,
                            laboratory_ref = :laboratory_ref, modified_date = NOW() WHERE haematology_id = :haematology_id";
}

class BloodTestSqlStatement {

    const ADD_UPDATE = 'INSERT INTO blood_test(haematology_id, pcv, hb, hchc, wbc, eosinophils, platelets, rectis, rectis_index,
                 e_s_r, microfilaria, malaria_parasites, created_date,modified_date)
                 VALUES(:haematology_id, :pcv, :hb, :hchc, :wbc, :eosinophils, :platelets, :rectis, :rectis_index,
                 :e_s_r, :microfilaria, :malaria_parasites, NOW(), NOW())
                 ON DUPLICATE KEY UPDATE pcv = :pcv, hb = :hb, hchc = :hchc, wbc = :wbc, eosinophils = :eosinophils,
                 platelets = :platelets, rectis = :rectis, rectis_index = :rectis_index, e_s_r = :e_s_r,
                 microfilaria = :microfilaria, malaria_parasites = :malaria_parasites, modified_date = NOW()';
    const DELETE = 'DELETE FROM blood_test WHERE haematology_id = :haematology_id';
    const GET_TEST = 'SELECT h.haematology_id,bt.pcv,bt.hb,bt.hchc,bt.wbc,bt.eosinophils,bt.platelets,bt.rectis,bt.rectis_index,bt.e_s_r,bt.microfilaria,bt.malaria_parasites,bt.create_date,bt.modified_date FROM blood_test bt
                        LEFT JOIN haematology h ON (h.haematology_id=bt.haematology_id)
                        WHERE bt.haematology_id=:haematology_id AND h.haematology_id=bt.haematology_id LIMIT 1';
    const UPDATE = 'UPDATE blood_test SET pcv = :pcv,hb = :hb, hchc = :hchc,wbc = :wbc,eosinophils = :eosinophils,platelets = :platelets,rectis = :rectis ,rectis_index = :rectis_index,e_s_r = :e_s_r,microfilaria = :microfilaria,malaria_parasites = :malaria_parasites, modified_date = now() WHERE haematology_id = :haematology_id';
    const GET    = 'SELECT haematology_id, pcv, hb, hchc, wbc, eosinophils, platelets, rectis, rectis_index, e_s_r, microfilaria, malaria_parasites, created_date, modified_date
                    FROM blood_test
                    WHERE haematology_id IN (SELECT haematology_id FROM haematology WHERE treatment_id = :treatment_id)
                    ORDER BY created_date DESC LIMIT 1';

}

class FilmAppearanceSqlStatement {

    const ADD_UPDATE = 'INSERT INTO film_appearance(haematology_id,aniscocytosis,poikilocytosis,polychromasia,macrocytosis,
                 microcytosis,hypochromia,sickle_cells,target_cells,spherocytes,nucleated_rbc,sickling_test,created_date,modified_date)
                 VALUES(:haematology_id,:aniscocytosis,:poikilocytosis,:polychromasia,:macrocytosis,:microcytosis,
                 :hypochromia,:sickle_cells,:target_cells,:spherocytes,:nucleated_rbc,:sickling_test,NOW(), NOW())
                 ON DUPLICATE KEY UPDATE aniscocytosis = :aniscocytosis, poikilocytosis = :poikilocytosis,
                 polychromasia = :polychromasia, macrocytosis = :macrocytosis, microcytosis = :microcytosis,
                 hypochromia = :hypochromia, sickle_cells = :sickle_cells, target_cells = :target_cells,
                 spherocytes = :spherocytes, nucleated_rbc = :nucleated_rbc, sickling_test = :sickling_test, modified_date = NOW()';
    const DELETE = 'DELETE FROM film_appearance WHERE haematology_id= :haematology_id';
    const GET    = 'SELECT film_appearance_id, haematology_id,aniscocytosis,poikilocytosis,polychromasia,macrocytosis,microcytosis,hypochromia,sickle_cells,target_cells,spherocytes,nucleated_rbc,sickling_test,created_date,modified_date FROM film_appearance f WHERE f.haematology_id = :haematology_id ORDER BY f.created_date DESC LIMIT 1';
    const GET_TEST = 'SELECT f.haematology_id,f.aniscocytosis,f.poikilocytosis,f.polychromasia,f.macrocytosis,f.microcytosis,f.hypochromia,f.sickle_cells,f.target_cells,f.spherocytes,f.nucleated_rbc,f.sickling_test,f.create_date,f.modified_date, h.haematology_id FROM haematology h, film_appearance f WHERE f.haematology_id=:haematology_id AND h.haematology_id=f.haematology_id LIMIT 1';
    const UPDATE = 'UPDATE film_appearance SET aniscocytosis = :aniscocytosis,poikilocytosis = :poikilocytosis,polychromasia = :polychromasia,macrocytosis = :macrocytosis,microcytosis = :microcytosis,hypochromia = :hypochromia,sickle_cells =:sickle_cells,target_cells = :target_cells,spherocytes = :spherocytes,nucleated_rbc = :nucleated_rbc,sickling_test = :sickling_test, modified_date = NOW() WHERE haematology_id=:haematology_id';
}

class DifferentialCountSqlStatement {

    const ADD_UPDATE = 'INSERT INTO differential_count(haematology_id, polymorphs_neutrophils,lymphocytes,monocytes,eosinophils,basophils,widals_test,blood_group,rhesus_factor,genotype, created_date,modified_date)
                 VALUES(:haematology_id, :polymorphs_neutrophils,:lymphocytes,:monocytes,:eosinophils,:basophils,:widals_test,:blood_group,:rhesus_factor,:genotype, NOW(),NOW())
                 ON DUPLICATE KEY UPDATE polymorphs_neutrophils = :polymorphs_neutrophils, lymphocytes = :lymphocytes,
                 monocytes = :monocytes, eosinophils = :eosinophils, basophils = :basophils, widals_test = :widals_test,
                 blood_group = :blood_group, rhesus_factor = :rhesus_factor, genotype = :genotype, modified_date = NOW()';
    const DELETE = 'DELETE FROM differential_count WHERE haematology_id = :haematology_id';
    const GET    = 'SELECT * FROM differential_count d WHERE d.haematology_id = :haematology_id ORDER BY d.create_date DESC LIMIT 1';
    const GET_TEST = 'SELECT dc.polymorphs_neutrophils,dc.lymphocytes,dc.monocytes,dc.eosinophils,dc.basophils,dc.widals_test,dc.blood_group,dc.rhesus_factor,dc.genotype, dc.modified_date, h.haematology_id FROM haematology h, differential_count dc WHERE dc.haematology_id=:haematology_id AND h.haematology_id=dc.haematology_id LIMIT 1';
    const UPDATE = 'UPDATE differential_count SET polymorphs_neutrophils = :polymorphs_neutrophils, lymphocytes = :lymphocytes, monocytes = :monocytes, eosinophils = :eosinophils, basophils = :basophils, widals_test = :widals_test, blood_group = :blood_group, rhesus_factor = :rhesus_factor, genotype = :genotype, modified_date = NOW() WHERE haematology_id = :haematology_id';

}

class MicroscopyRequestSqlStatment{
    const ADD_REQ_INFO = "INSERT INTO urine (doctor_id, treatment_id, clinical_diagnosis_details, created_date, modified_date)
                          VALUES (:doctor_id, :treatment_id, :clinical_diagnosis_details, NOW(), NOW())";
    const GET_HISTORY = "SELECT * FROM urine WHERE treatment_id IN (SELECT treatment_id FROM treatment AS t WHERE t.patient_id = :patient_id)";
    const GET_PATIENT_QUEUE = "SELECT * FROM urine AS u INNER JOIN treatment AS t ON u.treatment_id  = t.treatment_id
                               INNER JOIN patient AS p ON t.patient_id = p.patient_id WHERE u.status_id = :status_id
                               AND u.active_fg = :active_fg";
    const GET_ALL_TEST = "SELECT * FROM urine AS u INNER JOIN treatment AS t ON u.treatment_id  = t.treatment_id
                          INNER JOIN patient AS p ON t.patient_id = p.patient_id WHERE u.active_fg = :active_fg";
    const GET_DETAILS = "SELECT * FROM urine AS u INNER JOIN treatment AS t ON t.treatment_id  WHERE u.treatment_id = :treatment_id";
}

class ChemicalPathologyRequestSqlStatement{
    const ADD_REQ_INFO = "INSERT INTO chemical_pathology_request (doctor_id, treatment_id, clinical_diagnosis_details, created_date, modified_date)
                          VALUES (:doctor_id, :treatment_id, :clinical_diagnosis_details, NOW(), NOW())";
    const GET_HISTORY = "SELECT * FROM chemical_pathology_request WHERE treatment_id IN (SELECT treatment_id FROM treatment AS t WHERE t.patient_id = :patient_id)";
    const GET_PATIENT_QUEUE = "SELECT * FROM chemical_pathology_request AS c INNER JOIN treatment AS t ON c.treatment_id  = t.treatment_id
                               INNER JOIN patient AS p ON t.patient_id = p.patient_id WHERE c.status_id = :status_id
                               AND c.active_fg = :active_fg";
    const GET_ALL_TEST = "SELECT * FROM chemical_pathology_request AS c INNER JOIN treatment AS t ON c.treatment_id  = t.treatment_id
                          INNER JOIN patient AS p ON t.patient_id = p.patient_id WHERE c.active_fg = :active_fg";
    const GET_DETAIL = "SELECT * FROM chemical_pathology_request AS c INNER JOIN treatment AS t on
                        c.treatment_id = t.treatment_id WHERE c.treatment_id = :treatment_id";
    const GET_DETAILS = "SELECT c.cpreq_id, c.cpref_id, c.result FROM chemical_pathology_details AS c INNER JOIN
                         chemical_pathology_request AS cr ON c.cpreq_id = cr.cpreq_id WHERE cr.treatment_id = :treatment_id";
    const DELETE = 'UPDATE chemical_pathology_details SET active_fg = 0, modified_date = NOW() WHERE cpreq_id = :cpreq_id AND cpref_id = :cpref_id';
    const ADD_VALUES = 'INSERT into chemical_pathology_details (cpreq_id, cpref_id, result, created_date, modified_date) VALUES :vals';
    const UPDATE_VALUES = 'UPDATE chemical_pathology_details SET result = :result, active_fg = :active_fg, modified_date = NOW() WHERE cpreq_id = :cpreq_id AND cpref_id = :cpref_id';
    const GET_IDS = 'SELECT cpref_id FROM chemical_pathology_details WHERE cpreq_id = :cpreq_id';
    const UPDATE_DETAILS = 'UPDATE chemical_pathology_request SET laboratory_comment = :laboratory_comment,
                            laboratory_ref = :laboratory_ref, status_id=:status_id, modified_date = NOW(),
                            lab_attendant_id = :lab_attendant_id WHERE cpreq_id=:cpreq_id';
}

class VisualRequestSqlStatement{
    const ADD_REQ_INFO = "INSERT INTO visual_skills_profile (doctor_id, treatment_id, created_date, modified_date)
                          VALUES (:doctor_id, :treatment_id, NOW(), NOW())";
    const GET_HISTORY = "SELECT * FROM visual_skills_profile WHERE treatment_id IN (SELECT treatment_id FROM treatment AS t WHERE t.patient_id = :patient_id)";
    const GET_PATIENT_QUEUE = "SELECT * FROM visual_skills_profile AS v INNER JOIN treatment AS t ON v.treatment_id  = t.treatment_id INNER JOIN patient AS p ON t.patient_id = p.patient_id WHERE v.status_id = :status_id AND v.active_fg = :active_fg";
    const GET_ALL_TEST = "SELECT * FROM visual_skills_profile AS v INNER JOIN treatment AS t ON v.treatment_id  = t.treatment_id
                          INNER JOIN patient AS p ON t.patient_id = p.patient_id WHERE v.active_fg = :active_fg";
    const GET_DETAILS = "SELECT * FROM visual_skills_profile WHERE treatment_id = :treatment_id";
    const UPDATE_DETAILS = "UPDATE visual_skills_profile SET distance_re = :distance_re, distance_le = :distance_le,
                            distance_be = :distance_be, near_re  = :near_re, near_le = :near_le, near_be = :near_be,
                            pinhole_acuity_re = :pinhole_acuity_re, pinhole_acuity_le = :pinhole_acuity_le,
                            pinhole_acuity_be = :pinhole_acuity_be, colour_vision = :colour_vision, stereopsis = :stereopsis,
                            amplitude_of_accomodation = :amplitude_of_accomodation, modified_date = NOW(),
                            status_id = :status_id, lab_attendant_id = :lab_attendant_id WHERE treatment_id = :treatment_id";
}

class AdmissionReqSqlStatement {
    const REQUEST_ADMISSION = "INSERT INTO admission_req(treatment_id, created_date, modified_date, active_fg) VALUES(:treatment_id, NOW(), NOW(), 1)";

    const DISMISS_REQUEST = "UPDATE admission_req SET active_fg = 0 WHERE treatment_id = :treatment_id";

    const GET_ALL_REQUESTS = "SELECT ar.admission_req_id, ar.treatment_id, t.doctor_id, CONCAT_WS(' ', p.surname, p.firstname, p.middlename) AS doctor, t.patient_id, CONCAT_WS(' ', pt.surname, pt.firstname, pt.middlename) AS patient, pt.regNo
        FROM admission_req AS ar
            INNER JOIN treatment AS t
                ON t.treatment_id = ar.treatment_id
            INNER JOIN profile AS p
                ON p.userid = t.doctor_id
            INNER JOIN patient AS pt
                ON pt.patient_id = t.patient_id
        WHERE ar.active_fg = 1
            AND t.active_fg = 1
            AND p.active_fg = 1
            AND pt.active_fg = 1
        ORDER BY ar.created_date DESC";

    const SEARCH_REQUESTS = "SELECT ar.admission_req_id, ar.treatment_id, t.doctor_id, CONCAT_WS(' ', p.surname, p.firstname, p.middlename) AS doctor, t.patient_id, CONCAT_WS(' ', pt.surname, pt.firstname, pt.middlename) AS patient, pt.regNo
        FROM admission_req AS ar
            INNER JOIN treatment AS t
                ON t.treatment_id = ar.treatment_id
            INNER JOIN profile AS p
                ON p.userid = t.doctor_id
            INNER JOIN patient AS pt
                ON pt.patient_id = t.patient_id
        WHERE ar.active_fg = 1
            AND t.active_fg = 1
            AND p.active_fg = 1
            AND pt.active_fg = 1
            AND (
                pt.surname LIKE :wildcard
                OR pt.surname LIKE :wildcard
                OR pt.middlename LIKE :wildcard
                OR pt.regNo = :parameter
            )
        ORDER BY ar.created_date DESC";
}

class AdmissionSqlStatement {
    const ADMIT = "INSERT INTO admission(treatment_id, admitted_by, patient_id, entry_date, exit_date, comments, created_date, modified_date, active_fg) VALUES(:treatment_id, :admitted_by, :patient_id, NOW(), NULL, :comments, NOW(), NOW(), 1)";

    const ASSIGN_BED = "INSERT INTO admission_bed(admission_id, bed_id, active_fg
        , created_date, modified_date) VALUES (:admission_id, :bed_id, 1, NOW(), NOW())";

    const REMOVE_FROM_BED = "UPDATE admission_bed SET active_fg = 0 WHERE admission_id = :admission_id AND bed_id = :bed_id AND active_fg = 1";

    const GET_ADMISSION_DETAILS = "SELECT ad.admission_id, adb.bed_id
        FROM admission AS ad
            INNER JOIN admission_bed AS adb
                ON ad.admission_id = adb.admission_id
        WHERE adb.active_fg = 1
            AND ad.patient_id = :patient_id
            AND ad.active_fg = 1";

    const DISCHARGE = "UPDATE admission SET active_fg = 0, discharged_by = :discharged_by, modified_date = NOW() WHERE admission_id = :admission_id AND active_fg = 1";

    const IS_ADMITTED = "SELECT COUNT(*) AS count FROM admission WHERE patient_id = :patient_id AND active_fg = 1";

    const SEARCH_PATIENTS = "SELECT ad.admission_id, ad.treatment_id, ad.entry_date, CONCAT_WS(' ', p.surname, p.firstname, p.middlename) AS doctor, t.patient_id, CONCAT_WS(' ', pt.surname, pt.firstname, pt.middlename) AS patient, pt.regNo
        FROM admission AS ad
            INNER JOIN treatment AS t
                ON t.treatment_id = ad.treatment_id
            INNER JOIN profile AS p
                ON p.userid = t.doctor_id
            INNER JOIN patient AS pt
                ON pt.patient_id = t.patient_id
        WHERE ad.active_fg = 1
            AND t.active_fg = 1
            AND p.active_fg = 1
            AND pt.active_fg = 1
            AND (
                pt.surname LIKE :wildcard
                OR pt.surname LIKE :wildcard
                OR pt.middlename LIKE :wildcard
                OR pt.regNo = :parameter
            )
        ORDER BY ad.created_date DESC";

    const GET_PATIENTS = "SELECT ad.admission_id, ad.treatment_id, ad.entry_date, CONCAT_WS(' ', p.surname, p.firstname, p.middlename) AS doctor, t.patient_id, CONCAT_WS(' ', pt.surname, pt.firstname, pt.middlename) AS patient, pt.regNo
        FROM admission AS ad
            INNER JOIN treatment AS t
                ON t.treatment_id = ad.treatment_id
            INNER JOIN profile AS p
                ON p.userid = t.doctor_id
            INNER JOIN patient AS pt
                ON pt.patient_id = t.patient_id
        WHERE ad.active_fg = 1
            AND t.active_fg = 1
            AND p.active_fg = 1
            AND pt.active_fg = 1
        ORDER BY ad.created_date DESC";
}

class BedSqlStatement {
    const OCCUPY = "UPDATE bed SET bed_status = 1 WHERE bed_id = :bed_id AND bed_status = 0";

    const VACATE = "UPDATE bed SET bed_status = 0 WHERE bed_id = :bed_id AND bed_status = 1";

    const BED_STATUS = "SELECT bed_status FROM bed WHERE bed_id = :bed_id";

}

class WardRefSqlStatement {
    const GET_ALL = "SELECT ward_ref_id, description FROM ward_ref";

    const GET_WARD_BEDS = "SELECT bed_id, bed_description, bed_status, ward_id FROM bed WHERE ward_id = :ward_id";
}