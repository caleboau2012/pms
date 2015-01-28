<?php
class UserAuthTable {

  const regNo         = 'regNo';
  const userid        = 'userid';
  const usertype      = 'usertype';
  const passcode      = 'passcode';
  const create_date   = 'create_date';
  const modified_date = 'modified_date';
  const status        = 'status';
  const active_fg     = 'active_fg';
  const online_status = 'online_status';
}

class UserTypeTable {

  const usertype_id = 'usertype_id';
  const type = 'type';
  const active_fg = 'active_fg';
}

class StatusTable {

  const status_id = 'status_id';
  const status_name = 'status_name';
  const active_fg = 'active_fg';
}

class StaffRoleTable {

  const staff_role_id = 'staff_role_id';
  const create_date = 'create_date';
  const modified_date = 'modified_date';
  const staff_role = 'staff_role';
  const role_label = 'role_label';
  const active_fg = 'active_fg';
}

class StaffPermissionTable {

  const staff_permission_id = 'staff_permission_id';
  const create_date = 'create_date';
  const modified_date = 'modified_date';
  const staff_permission = 'staff_permission';
  const active_fg = 'active_fg';
}

class ProfileTable {

  const profile_id = 'profile_id';
  const userid = 'userid';
  const surname = 'surname';
  const firstname = 'firstname';
  const middlename = 'middlename';
  const department_id = 'department_id';
  const local_address = 'local_address';
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

  const permission_role_id = 'permission_role_id';
  const userid = 'userid';
  const staff_permission_id = 'staff_permission_id';
  const staff_role_id = 'staff_role_id';
  const create_date = 'create_date';
  const modified_date = 'modified_date';
  const active_fg = 'active_fg';
}