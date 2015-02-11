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
        const ADD = 'INSERT INTO user_auth (regNo, passcode, create_date, modified_date, status) VALUES (:regNo, SHA1(:passcode), NOW(), NOW(), :status)';
        const GET = 'SELECT userid, regNo, create_date, modified_date, status, online_status
                                FROM user_auth
                                WHERE regNo = :regNo AND userid = :userid';
        const GET_ALL = 'SELECT p.surname, p.firstname, p.middlename, p.userid, p.work_address, p.home_address, p.telephone, p.sex, p.birth_date, ua.regNo FROM profile as p RIGHT JOIN user_auth as ua ON (p.userid = ua.userid)';

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
                LEFT JOIN PROFILE AS p
                    ON(u.userid=p.userid)
            WHERE regNo=:regNo AND passcode=SHA1(:passcode)";

        const GET_USER_BY_ID = 'SELECT u.userid, u.regNo, u.online_status, p.profile_id, p.surname, p.firstname, p.middlename, p.department_id, p.sex
        FROM user_auth AS u
            LEFT JOIN PROFILE AS p
                ON(u.userid=p.userid)
        WHERE u.userid=:userid';

        const FLAG_USER_ONLINE = 'UPDATE user_auth SET online_status = 1 WHERE userid=:userid';

        const FLAG_USER_OFFLINE = 'UPDATE user_auth SET online_status = 0 WHERE userid=:userid';

        const GET_BY_REGNO = 'SELECT userid FROM user_auth WHERE regNo=:regNo';

        const GET_STATUS = "SELECT status FROM user_auth WHERE userid = :userid";
}

class ProfileSqlStatement {
        const ADD = 'INSERT INTO profile (userid, surname, firstname, middlename, department_id, work_address, home_address, telephone, sex,
                                        height, weight, birth_date, create_date, modified_date)
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
                                        p.height, p.weight, p.birth_date, p.create_date, p.modified_date FROM profile as p LEFT JOIN user_auth as ua ON(p.userid = ua.userid) WHERE ua.regNo = :regNo';
        const GET_USER_AND_DEPT = 'SELECT dept.department_name, p.firstname, p.middlename, p.surname, FROM PROFILE AS p
                                   LEFT JOIN department AS dept
                                    ON p.department_id = dept.department_id
                                    WHERE p.active_fg = 1
                                    GROUP BY department_name';
}

class PermissionRoleSqlStatement {
        const DELETE_STAFF_ROLE = 'UPDATE permission_role SET active_fg = 0, modified_date = NOW() WHERE permission_role_id = :permission_role_id';
        const UPDATE_ROLE_PERMISSION = 'UPDATE permission_role SET staff_permission_id = :staff_permission_id, modified_date = NOW() WHERE permission_role_id = :permission_role_id';
        const ADD_STAFF_ROLE = 'INSERT INTO permission_role (userid, staff_permission_id, staff_role_id, create_date, modified_date, active_fg)
                                                        VALUES (:userid, :staff_permission_id, :staff_role_id, NOW(), NOW(), 1)';
        const GET_STAFF_ROLE = "SELECT pr.permission_role_id, pr.staff_role_id, pr.staff_permission_id, pr.userid, sr.role_label, sp.staff_permission FROM permission_role AS pr INNER JOIN staff_role AS sr on pr.staff_role_id = sr.staff_role_id INNER JOIN staff_permission AS sp ON pr.staff_permission_id = sp.staff_permission_id WHERE pr.userid = :userid AND pr.active_fg = 1";
        const GET_ALL_ROLES = "SELECT staff_role_id, role_label FROM staff_role";
        const GET_ALL_PERMISSIONS = "SELECT staff_permission_id, staff_permission FROM staff_permission";
        const CHECK_PERMISSION = "SELECT COUNT(*) AS count FROM staff_permission WHERE staff_permission_id = :staff_permission_id";
        const CHECK_ROLE = "SELECT COUNT(*) AS count FROM staff_role WHERE staff_role_id = :staff_role_id";
}

class PatientSqlStatement {
        const ADD = 'INSERT INTO patient (surname, firstname, middlename, regNo, home_address, telephone, sex, height, weight, birth_date, nok_firstname, nok_middlename, nok_surname, nok_address, nok_telephone, nok_relationship, create_date, modified_date)
                                 VALUES (LOWER(:surname), LOWER(:firstname), LOWER(:middlename), :regNo, :home_address, :telephone, :sex, :height, :weight, :birth_date, :nok_firstname, :nok_middlename, :nok_surname, :nok_address, :nok_telephone, :nok_relationship, NOW(), NOW() )';
        const GET = 'SELECT surname, firstname, middlename, regNo, home_address, telephone, sex, height, weight, birth_date, nok_firstname, nok_middlename, nok_surname, nok_address, nok_telephone, nok_relationship, create_date, modified_date
                                    FROM patient WHERE patient_id = :patient_id';
        const UPDATE = 'UPDATE patient SET surname = LOWER(:surname), firstname = LOWER(:firstname), middlename = LOWER(:middlename), regNo = :regNo, home_address = :home_address, telephone = :telephone, sex = :sex, height = :height, weight = :weight, birth_date = :birth_date, nok_firstname = :nok_firstname, nok_middlename = :nok_middlename, nok_surname = :nok_surname, nok_address = :nok_address, nok_telephone = :nok_telephone, nok_relationship = :nok_relationship, modified_date = NOW()';

        const GET_ALL = 'SELECT patient_id, surname, firstname, middlename, regNo, home_address, telephone, sex, height, weight, birth_date, nok_firstname, nok_middlename, nok_surname, nok_address, nok_telephone, nok_relationship, create_date, modified_date
                                    FROM patient';

        const SEARCH = "SELECT p.patient_id, p.surname, p.middlename, p.regNo, p.sex, pq.active_fg AS queue_status
            FROM patient AS p
                LEFT JOIN patient_queue AS pq
                    ON p.patient_id = pq.patient_id
            WHERE surname LIKE :wildcard
            OR firstname LIKE :wildcard
            OR middlename LIKE :wildcard
            OR regNo = :parameter";
}

class PatientQueueSqlStatement {
    const ADD = "INSERT INTO patient_queue (patient_id, doctor_id, active_fg, create_date, modified_date) VALUES (:patient_id, :doctor_id, 1, NOW(), NOW())";

    const REMOVE = "UPDATE patient_queue SET active_fg = 0, modified_date = NOW() WHERE patient_id = :patient_id";

    const ONLINE_DOCTORS = "SELECT ua.userid, ua.online_status, p.surname, p.firstname, p.middlename
        FROM user_auth AS ua
            LEFT JOIN profile AS p
                ON ua.userid = p.userid
            LEFT JOIN permission_role AS pr
                ON ua.userid = pr.userid
        WHERE ua.online_status = 1
        AND pr.staff_role_id = 2
        AND pr.active_fg = 1
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
}

class RosterSqlStatement {
    const ADD = 'INSERT INTO roster (user_id, duty, begin_at, end_at, created_date, created_by, modified_date, modified_by)
                    VALUES (:user_id, :duty, :begin_at, :end_at, NOW(), :created_by, NOW(), :modified_by)';
    const GET_BY_ID = 'SELECT user_id, duty, begin_at, end_at, created_date, created_by, modified_date, modified_by
                FROM roster WHERE roster_id=:roster_id';
    const GET_BY_DOCTOR = 'SELECT user_id, duty, begin_at, end_at, created_date, created_by, modified_date, modified_by
                FROM roster WHERE user_id=:user_id';
    const UPDATE = 'UPDATE roster SET duty=:duty, begin_at=:begin_at, end_at=:end_at, modified_date = :modified_date, modified_by = :modified_by
                        WHERE roster_id = :roster_id';
    const DELETE_ROSTER = 'UPDATE roster SET active_fg = 0, modified_date = :modified_date, modified_by = :modified_by';
}