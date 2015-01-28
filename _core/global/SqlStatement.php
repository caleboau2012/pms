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
    const ADD = 'INSERT INTO user_auth (usertype, regNo, passcode, create_date, modified_date, status) VALUES (:usertype, :regNo, SHA1(:passcode), NOW(), NOW(), :status)';
    const GET = 'SELECT userid, usertype, regNo, create_date, modified_date, status, online_status
                FROM user_auth
                WHERE regNo = :regNo AND userid = :userid';
    const GET_ALL = 'SELECT p.surname, p.firstname, p.middlename, p.userid, p.local_address, p.home_address, p.telephone, p.sex, p.birth_date, ua.usertype FROM profile as p LEFT JOIN user_auth as ua ON (p.userid = ua.userid)';

    const CHANGE_PASSCODE = 'UPDATE user_auth SET passcode = SHA1(:passcode) WHERE regNo = :regNo';
    const CHANGE_ONLINE_STATUS = 'UPDATE user_auth SET online_status = :online_status WHERE userid = :userid';
    const CHANGE_STATUS = 'UPDATE user_auth SET status = :status WHERE regNo = :regNo';
    const GET_USER_ROLE = 'SELECT u.userid, u.usertype, u.regNo, p.surname, p.firstname, p.middlename, pr.staff_role_id AS staff_role, pr.staff_permission_id AS staff_permission
                           FROM user_auth AS u
                            LEFT JOIN profile AS p
                              ON(u.userid = p.userid)
                            LEFT JOIN permission_role AS pr
                              ON (p.userid = pr.userid)
                           WHERE u.usertype IN (2,3) AND pr.staff_role_id = :staff_role_id
                              ORDER by p.surname, p.firstname, p.middlename';

    const UPDATE_STATUS = 'UPDATE user_auth SET status = :status WHERE userid = :userid LIMIT 1';
    const GET_USER_BY_CREDENTIALS = "SELECT u.userid, u.regNo, u.usertype, u.online_status, p.profile_id, p.surname, p.firstname, p.middlename, p.department_id, p.sex
                                          FROM user_auth AS u
                                            LEFT JOIN PROFILE AS p
                                              ON(u.userid=p.userid)
                                          WHERE regNo=:regNo AND passcode=SHA1(:passcode)";

    const GET_USER_BY_ID = 'SELECT u.userid, u.regNo, u.usertype, u.online_status,
                                                p.profile_id, p.surname, p.firstname, p.middlename, p.department_id, p.sex
                                      FROM user_auth AS u
                                        LEFT JOIN PROFILE AS p
                                          ON(u.userid=p.userid)
                                      WHERE u.userid=:userid';

    const FLAG_USER_ONLINE = 'UPDATE user_auth SET online_status = 1 WHERE userid=:userid';

    const GET_BY_REGNO = 'SELECT userid FROM user_auth WHERE regNo=:regNo';
}

class ProfileSqlStatement {
    const ADD = 'INSERT INTO profile (userid, surname, firstname, middlename, department_id, work_address, home_address, telephone, sex,
                    height, weight, birth_date, create_date, modified_date)
                 VALUES (:userid, LOWER(:surname), LOWER(:firstname), LOWER(:middlename), :department_id, LOWER(:work_address), LOWER(:home_address), :telephone, :sex
                            :height, :weight, :birth_date, NOW(), NOW()) ';
    const GET = 'SELECT userid, surname, firstname, middlename, department_id, work_address, home_address, telephone, sex,
                    height, weight, birth_date, create_date, modified_date FROM profile WHERE userid=:userid';
    const UPDATE = 'UPDATE profile SET surname = :surname, firstname = :firstname, middlename = :middlename, work_address = :local_address, home_address = :home_address, telephone = :telephone, sex = :sex, height = :height, weight = :weight,department_id = :department_id, birth_date = :birth_date, modified_date = NOW() WHERE userid = :userid';
    const UPDATE_BASIC_INFO = 'UPDATE profile SET surname = LOWER(:surname), firstname = LOWER(:firstname), middlename = LOWER(:middlename), sex = :sex, birth_date = :birth_date, modified_date = now() WHERE userid = :userid';
    const GET_PROFILE = 'SELECT ua.regNo, p.userid, p.surname, p.firstname, p.middlename, p.department, p.work_address, p.home_address, p.telephone, p.sex,
                    p.height, p.weight, p.birth_date, p.create_date, p.modified_date FROM profile as p LEFT JOIN user_auth as ua ON(p.userid = ua.userid) WHERE ua.regNo = :regNo';
}

class PermissionRoleSqlStatement {
    const DELETE_STAFF_ROLE = 'UPDATE permission_role SET active_fg = 0, modified_date = NOW() WHERE permission_role_id = :permission_role_id AND userid = :userid';
    const UPDATE_ROLE_PERMISSION = 'UPDATE permission_role SET staff_role_id = :staff_role_id, modified_date = NOW() WHERE userid = :userid AND permission_role_id = 1';
    const ADD_STAFF_ROLE = 'INSERT INTO (userid, staff_permission_id, staff_role_id, create_date, modified_date)
                            VALUES (:userid, :staff_permission_id, :staff_role_id, NOW(), NOW() )';
    const GET_STAFF_ROLE = "SELECT pr.staff_role_id, pr.staff_permission_id, pr.userid, sr.role_label, sp.staff_permission FROM permission_role AS pr INNER JOIN staff_role AS sr on pr.staff_role_id = sr.staff_role_id INNER JOIN staff_permission AS sp ON pr.staff_permission_id = sp.staff_permission_id WHERE pr.userid = :userid AND pr.active_fg = 1";
    const GET_ALL_ROLES = "SELECT staff_role_id, role_label FROM staff_role";
}

class PatientSqlStatement {
    const ADD = 'INSERT INTO patient (surname, firstname, middlename, regNo, home_address, telephone, sex, height, weight, birth_date, create_date, modified_date)
                 VALUES (LOWER(:surname), LOWER(:firstname), LOWER(:middlename), :regNo, :home_address, :telephone, :sex, :height, :weight, :birth_date, NOW(), NOW() )';
    const GET = 'SELECT surname, firstname, middlename, regNo, home_address, telephone, sex, height, weight, birth_date, create_date, modified_date
                  FROM patient WHERE patient_id = :patient_id';
    const UPDATE = 'UPDATE patient SET surname = LOWER(:surname), firstname = LOWER(:firstname), middlename = LOWER(:middlename), regNo = :regNo, home_address = :home_address, telephone = :telephone, sex = :sex, height = :height, weight = :weight, birth_date = :birth_date, modified_date = NOW()';
}