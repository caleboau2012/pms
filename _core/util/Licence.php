<?php
    // require_once '../global/_require.php';

    Crave::requireAll(GLOBAL_VAR);
    Crave::requireAll(UTIL);
    Crave::requireFiles(MODEL, array('BaseModel'));

    class Licence extends BaseModel {
        public static function withinUserLimit(){
            $licence = new Licence();
            $stmt = "SELECT COUNT(*) AS count FROM user_auth WHERE active_fg = 1";
            $data = array();
            $result = $licence->conn->fetch($stmt, $data);

            $existing_user_count = $result['count'];

            // Get user count allowed in licence file
            $project_name = 'pms';

            $path_arr = explode($project_name, __DIR__);
            $project_root = $path_arr[0] . $project_name;

            $licence_file_path = $project_root . '/lic.pms';
            $passkey_file_path = $project_root . '/pass.pms';
            // AES decrypt file
            $decryption_command = "openssl aes-256-cbc -in " . $licence_file_path . " -d -pass file:" . $passkey_file_path;
            $licence_string = shell_exec($decryption_command);
            if (!empty($licence_string)) {
                $licence_obj = json_decode($licence_string, true);
                $licenced_user_count = $licence_obj["user_count"];
                return $existing_user_count < $licenced_user_count;
            }
            return false;
        }
    }
?>