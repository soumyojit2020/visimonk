<?php
	include 'include/head.php';
	require_once 'include/dbConfig.php';
	checkLogin();


	//once the form is submitted
	if(isset($_POST) && !empty($_POST)){
		$errors = array();
		$role_name = clean($_POST['role_name']);

		if(isset($_POST['user_create'])){
		$user_create = clean($_POST['user_create']);
			}else{
					$user_create='';
				}

		if(isset($_POST['user_read'])){
		$user_read = clean($_POST['user_read']);
		}else{
		$user_read='';
		}

		if(isset($_POST['user_update'])){
		$user_update = clean($_POST['user_update']);
	}else{
		$user_update='';
	}

		if(isset($_POST['roles_create'])){
		$roles_create = clean($_POST['roles_create']);
	}else{
		$roles_create='';
	}

		if(isset($_POST['roles_read'])){
		$roles_read = clean($_POST['roles_read']);
	}else{
		$roles_read='';
	}

		if(isset($_POST['roles_update'])){
		$roles_update = clean($_POST['roles_update']);
	}else{
		$roles_update='';
	}

		if(isset($_POST['campus_create'])){
		$campus_create = clean($_POST['campus_create']);
	}else{
		$campus_create='';
	}

		if(isset($_POST['campus_read'])){
		$campus_read = clean($_POST['campus_read']);
	}else{
		$campus_read='';
	}

	if(isset($_POST['campus_update'])){
		$campus_update = clean($_POST['campus_update']);
	}else{
		$campus_update='';
	}

	if(isset($_POST['building_create'])){
		$building_create = clean($_POST['building_create']);
	}else{
		$building_create='';
	}

	if(isset($_POST['building_read'])){
		$building_read = clean($_POST['building_read']);
	}else{
		$building_read='';
	}

	if(isset($_POST['building_update'])){
		$building_update = clean($_POST['building_update']);
	}else{
		$building_update='';
	}

	if(isset($_POST['floor_create'])){
		$floor_create = clean($_POST['floor_create']);
	}else{
		$floor_create='';
	}

	if(isset($_POST['floor_read'])){
		$floor_read = clean($_POST['floor_read']);
	}else{
		$floor_read='';
	}

	if(isset($_POST['floor_update'])){
		$floor_update = clean($_POST['floor_update']);
	}else{
		$floor_update='';
	}

	if(isset($_POST['area_create'])){
		$area_create = clean($_POST['area_create']);
	}else{
		$area_create='';
	}

	if(isset($_POST['area_read'])){
		$area_read = clean($_POST['area_read']);
	}else{
		$area_read='';
	}

	if(isset($_POST['area_update'])){
		$area_update = clean($_POST['area_update']);
	}else{
		$area_update='';
	}

	if(isset($_POST['port_create'])){
		$port_create = clean($_POST['port_create']);
	}else {
		$port_create='';
	}

	if(isset($_POST['port_read'])){
		$port_read = clean($_POST['port_read']);
	}else{
		$port_read='';
	}

	if(isset($_POST['port_update'])){
		$port_update = clean($_POST['port_update']);
	}else{
		$port_update='';
	}

	if(isset($_POST['forms_create'])){
		$forms_create = clean($_POST['forms_create']);
	}else{
		$forms_create='';
	}

	if(isset($_POST['forms_read'])){
		$forms_read = clean($_POST['forms_read']);
	}else{
		$forms_read='';
	}

	if(isset($_POST['forms_update'])){
		$forms_update = clean($_POST['forms_update']);
	}else{
		$forms_update='';
	}

	if(isset($_POST['hq_create'])){
		$hq_create = clean($_POST['hq_create']);
	}else{
		$hq_create='';
	}

	if(isset($_POST['hq_read'])){
		$hq_read = clean($_POST['hq_read']);
	}else{
		$hq_read='';
	}

	if(isset($_POST['hq_update'])){
		$hq_update = clean($_POST['hq_update']);
	}else{
		$hq_update='';
	}

	if(isset($_POST['logo_create'])){
		$logo_create = clean($_POST['logo_create']);
	}else{
		$logo_create='';
	}

	if(isset($_POST['logo_read'])){
		$logo_read = clean($_POST['logo_read']);
	}else{
		$logo_read='';
	}

	if(isset($_POST['logo_update'])){
		$logo_update = clean($_POST['logo_update']);
}else{
	$logo_update='';
}


		if(empty($role_name)){
			$errors[] .= 'Please enter a role name';
		}

		if(empty($user_create || $user_read || $user_read || $roles_create || $roles_read || $roles_update ||
							$campus_create || $campus_read || $campus_update || $building_create || $building_read || $building_update ||
								$floor_create || $floor_read || $floor_update || $area_create || $area_read || $area_update ||
									$port_create || $floor_read || $floor_update || $forms_create || $forms_read || $forms_update ||
										$hq_create || $hq_read || $hq_update || $logo_create || $logo_read ||$logo_update)){
			$errors[] .= 'Please select atleast one permission!';
		}

		//check if duplicate role name within same account
		if(!empty($role_name)){
			$sql = "SELECT role_description FROM role WHERE role_description=? AND account_id=?";
			if($stmt = mysqli_prepare($conn,$sql)){
				mysqli_stmt_bind_param($stmt,"ss",$param_rd,$param_ac_id);
				$param_rd = $role_name;
				$param_ac_id = $accountId;
				if(mysqli_stmt_execute($stmt)){
					mysqli_stmt_store_result($stmt);
					if(mysqli_stmt_num_rows($stmt) == 1){
						$errors[] .= $role_name. ' already exists';
					}else{
						$role_name = clean($_POST['role_name']);
					}
				}
			}
			mysqli_stmt_close($stmt);
		}//role duplicate check

		if(empty($errors)){
			$sql_role = "INSERT INTO role (role_description, account_id) VALUES(?, ?)";
			if($stmt_role = mysqli_prepare($conn, $sql_role)){
				mysqli_stmt_bind_param($stmt_role, "ss", $param_role_description, $param_account_id);
				$param_role_description = $role_name;
				$param_account_id = $accountId;
				if(mysqli_stmt_execute($stmt_role)){
					$sql_role_id = "SELECT role_id, role_description, account_id FROM role WHERE role_description=? AND account_id=?";
					if($stmt_role_id = mysqli_prepare($conn, $sql_role_id)){
						mysqli_stmt_bind_param($stmt_role_id, "ss", $param_role_description, $param_account_id);
						$param_role_description = $role_name;
						$param_account_id = $accountId;
						if(mysqli_stmt_execute($stmt_role_id)){
							$result_role_id = mysqli_stmt_get_result($stmt_role_id);
							if(mysqli_num_rows($result_role_id) == 1){
								$row_role_id = mysqli_fetch_array($result_role_id, MYSQLI_ASSOC);
								$result_role_id1 = $row_role_id['role_id'];
								$result_role_id_description = $row_role_id['role_description'];
								$result_role_id_account_id = $row_role_id['account_id'];

								if(!empty($user_create)){
									$sql1 = "INSERT INTO role_permission (role_id, permission_id) VALUES($result_role_id1, 2),
									($result_role_id1, 3), ($result_role_id1, 1) ";
									$query1 = mysqli_query($conn,$sql1);
								}

								if(!empty($user_update)){
									$sql1 = "INSERT INTO role_permission (role_id, permission_id) VALUES
									($result_role_id1, 3), ($result_role_id1, 1) ";
									$query1 = mysqli_query($conn,$sql1);
								}

								if(!empty($user_read)){
									$sql1 = "INSERT INTO role_permission (role_id, permission_id) VALUES ($result_role_id1, 1)";
									$query1 = mysqli_query($conn,$sql1);
								}

								if(!empty($roles_create)){
									$sql1 = "INSERT INTO role_permission (role_id, permission_id) VALUES($result_role_id1, 4),
									($result_role_id1, 6), ($result_role_id1, 5) ";
									$query1 = mysqli_query($conn,$sql1);
								}

								if(!empty($roles_update)){
									$sql1 = "INSERT INTO role_permission (role_id, permission_id) VALUES
									($result_role_id1, 6), ($result_role_id1, 5) ";
									$query1 = mysqli_query($conn,$sql1);
								}

								if(!empty($roles_read)){
									$sql1 = "INSERT INTO role_permission (role_id, permission_id) VALUES ($result_role_id1, 5)";
									$query1 = mysqli_query($conn,$sql1);
								}

								if(!empty($campus_create)){
									$sql1 = "INSERT INTO role_permission (role_id, permission_id) VALUES($result_role_id1, 7),
									($result_role_id1, 9), ($result_role_id1, 8) ";
									$query1 = mysqli_query($conn,$sql1);
								}

								if(!empty($campus_update)){
									$sql1 = "INSERT INTO role_permission (role_id, permission_id) VALUES
									($result_role_id1, 9), ($result_role_id1, 8) ";
									$query1 = mysqli_query($conn,$sql1);
								}

								if(!empty($campus_read)){
									$sql1 = "INSERT INTO role_permission (role_id, permission_id) VALUES ($result_role_id1, 8)";
									$query1 = mysqli_query($conn,$sql1);
								}

								if(!empty($building_create)){
									$sql1 = "INSERT INTO role_permission (role_id, permission_id) VALUES($result_role_id1, 10),
									($result_role_id1, 12), ($result_role_id1, 11) ";
									$query1 = mysqli_query($conn,$sql1);
								}

								if(!empty($building_update)){
									$sql1 = "INSERT INTO role_permission (role_id, permission_id) VALUES
									($result_role_id1, 12), ($result_role_id1, 11) ";
									$query1 = mysqli_query($conn,$sql1);
								}

								if(!empty($building_read)){
									$sql1 = "INSERT INTO role_permission (role_id, permission_id) VALUES ($result_role_id1, 11)";
									$query1 = mysqli_query($conn,$sql1);
								}

								if(!empty($floor_create)){
									$sql1 = "INSERT INTO role_permission (role_id, permission_id) VALUES($result_role_id1, 13),
									($result_role_id1, 15), ($result_role_id1, 14) ";
									$query1 = mysqli_query($conn,$sql1);
								}

								if(!empty($floor_update)){
									$sql1 = "INSERT INTO role_permission (role_id, permission_id) VALUES
									($result_role_id1, 15), ($result_role_id1, 14) ";
									$query1 = mysqli_query($conn,$sql1);
								}

								if(!empty($floor_read)){
									$sql1 = "INSERT INTO role_permission (role_id, permission_id) VALUES ($result_role_id1, 14)";
									$query1 = mysqli_query($conn,$sql1);
								}

								if(!empty($area_create)){
									$sql1 = "INSERT INTO role_permission (role_id, permission_id) VALUES($result_role_id1, 16),
									($result_role_id1, 18), ($result_role_id1, 17) ";
									$query1 = mysqli_query($conn,$sql1);
								}

								if(!empty($area_update)){
									$sql1 = "INSERT INTO role_permission (role_id, permission_id) VALUES
									($result_role_id1, 18), ($result_role_id1, 17) ";
									$query1 = mysqli_query($conn,$sql1);
								}

								if(!empty($area_read)){
									$sql1 = "INSERT INTO role_permission (role_id, permission_id) VALUES ($result_role_id1, 17)";
									$query1 = mysqli_query($conn,$sql1);
								}

								if(!empty($port_create)){
									$sql1 = "INSERT INTO role_permission (role_id, permission_id) VALUES($result_role_id1, 19),
									($result_role_id1, 21), ($result_role_id1, 20) ";
									$query1 = mysqli_query($conn,$sql1);
								}

								if(!empty($port_update)){
									$sql1 = "INSERT INTO role_permission (role_id, permission_id) VALUES
									($result_role_id1, 21), ($result_role_id1, 20) ";
									$query1 = mysqli_query($conn,$sql1);
								}

								if(!empty($port_read)){
									$sql1 = "INSERT INTO role_permission (role_id, permission_id) VALUES ($result_role_id1, 20)";
									$query1 = mysqli_query($conn,$sql1);
								}

								if(!empty($forms_create)){
									$sql1 = "INSERT INTO role_permission (role_id, permission_id) VALUES($result_role_id1, 22),
									($result_role_id1, 24), ($result_role_id1, 23) ";
									$query1 = mysqli_query($conn,$sql1);
								}

								if(!empty($forms_update)){
									$sql1 = "INSERT INTO role_permission (role_id, permission_id) VALUES
									($result_role_id1, 24), ($result_role_id1, 23) ";
									$query1 = mysqli_query($conn,$sql1);
								}

								if(!empty($forms_read)){
									$sql1 = "INSERT INTO role_permission (role_id, permission_id) VALUES ($result_role_id1, 23)";
									$query1 = mysqli_query($conn,$sql1);
								}

								if(!empty($hq_create)){
									$sql1 = "INSERT INTO role_permission (role_id, permission_id) VALUES($result_role_id1, 25),
									($result_role_id1, 27), ($result_role_id1, 26) ";
									$query1 = mysqli_query($conn,$sql1);
								}

								if(!empty($hq_update)){
									$sql1 = "INSERT INTO role_permission (role_id, permission_id) VALUES
									($result_role_id1, 27), ($result_role_id1, 26) ";
									$query1 = mysqli_query($conn,$sql1);
								}

								if(!empty($hq_read)){
									$sql1 = "INSERT INTO role_permission (role_id, permission_id) VALUES ($result_role_id1, 26)";
									$query1 = mysqli_query($conn,$sql1);
								}

								if(!empty($logo_create)){
									$sql1 = "INSERT INTO role_permission (role_id, permission_id) VALUES($result_role_id1, 28),
									($result_role_id1, 30), ($result_role_id1, 29) ";
									$query1 = mysqli_query($conn,$sql1);
								}

								if(!empty($logo_update)){
									$sql1 = "INSERT INTO role_permission (role_id, permission_id) VALUES
									($result_role_id1, 30), ($result_role_id1, 29) ";
									$query1 = mysqli_query($conn,$sql1);
								}

								if(!empty($logo_read)){
									$sql1 = "INSERT INTO role_permission (role_id, permission_id) VALUES ($result_role_id1, 29)";
									$query1 = mysqli_query($conn,$sql1);
								}
								header("location: roles_view.php");
							}
						}
					}
				}else{
					$errors[] .= 'Something went wrong. Please try again.';
				}
			}
		}//empty errors

	}
?>
  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col">
          <div class="left_col scroll-view">
            <?php include 'include/brand.php'; ?>
            <div class="clearfix"></div>
            <br />
            <?php
				include 'include/sidebarMenu.php';
			?>
          </div>
        </div>
        <?php
			include 'include/topNav.php';
		?>
        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Add Role</h3>
              </div>
            </div>
            <div class="clearfix"></div>
            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_content">
										<div>
											<?php
												if(!empty($errors)){
													echo display_errors($errors);
												}
											?>
										</div>
                      <!--form start-->
                      <form action="new_roles_view.php" method="POST" data-parsley-validate class="form-horizontal form-label-left">
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="role-name">Role Name <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" id="role-name" required="required" name="role_name" class="form-control col-md-7 col-xs-12" value="<?=($_POST)?$role_name:'';?>">
                        </div>
                      </div>
                      <div class="ln_solid"></div>
                      <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                          <!--table start-->
                          <div class="table-responsive">
                            <table class="table table-striped">
                              <thead>
                                <tr>
                                  <th>Name</th>
                                  <th>Create</th>
                                  <th>Read</th>
                                  <th>Update</th>
                                </tr>
                              <thead>
                              <tbody>
                                <tr>
                                  <td>Users</td>
                                  <td><input type="checkbox" class="flat" name="user_create" value="2" <?=(isset($_POST['user_create']))?'checked':''?>/></td>
                                  <td><input type="checkbox" class="flat" name="user_read" value="1" <?=(isset($_POST['user_read']))?'checked':''?>/></td>
                                  <td><input type="checkbox" class="flat" name="user_update" value="3" <?=(isset($_POST['user_update']))?'checked':''?>/></td>
                                </tr>
                                <tr>
                                  <td>Roles</td>
                                  <td><input type="checkbox" class="flat" name="roles_create" value="4" <?=(isset($_POST['roles_create']))?'checked':''?>/></td>
                                  <td><input type="checkbox" class="flat" name="roles_read" value="5" <?=(isset($_POST['roles_read']))?'checked':''?>/></td>
                                  <td><input type="checkbox" class="flat" name="roles_update" value="6" <?=(isset($_POST['roles_update']))?'checked':''?>/></td>
                                </tr>
                                <tr>
                                  <td>Campus</td>
                                  <td><input type="checkbox" class="flat" name="campus_create" value="7" <?=(isset($_POST['campus_create']))?'checked':''?>/></td>
                                  <td><input type="checkbox" class="flat" name="campus_read" value="8" <?=(isset($_POST['campus_read']))?'checked':''?>/></td>
                                  <td><input type="checkbox" class="flat" name="campus_update" value="9" <?=(isset($_POST['campus_update']))?'checked':''?>/></td>
                                </tr>
                                <tr>
                                  <td>Building</td>
                                  <td><input type="checkbox" class="flat" name="building_create" value="10" <?=(isset($_POST['building_create']))?'checked':''?>/></td>
                                  <td><input type="checkbox" class="flat" name="building_read" value="11" <?=(isset($_POST['building_read']))?'checked':''?>/></td>
                                  <td><input type="checkbox" class="flat" name="building_update" value="12" <?=(isset($_POST['building_update']))?'checked':''?>/></td>
                                </tr>
                                <tr>
                                  <td>Floor</td>
                                  <td><input type="checkbox" class="flat" name="floor_create"value="13" <?=(isset($_POST['floor_create']))?'checked':''?>/></td>
                                  <td><input type="checkbox" class="flat" name="floor_read"value="14" <?=(isset($_POST['floor_read']))?'checked':''?>/></td>
                                  <td><input type="checkbox" class="flat" name="floor_update"value="15" <?=(isset($_POST['floor_update']))?'checked':''?>/></td>
                                </tr>
                                <tr>
                                  <td>Area</td>
                                  <td><input type="checkbox" class="flat" name="area_create" value="16" <?=(isset($_POST['area_create']))?'checked':''?>/></td>
                                  <td><input type="checkbox" class="flat" name="area_read" value="17" <?=(isset($_POST['area_read']))?'checked':''?>/></td>
                                  <td><input type="checkbox" class="flat" name="area_update" value="18" <?=(isset($_POST['area_update']))?'checked':''?>/></td>
                                </tr>
                                <tr>
                                  <td>Port</td>
                                  <td><input type="checkbox" class="flat" name="port_create" value="19" <?=(isset($_POST['port_create']))?'checked':''?>/></td>
                                  <td><input type="checkbox" class="flat" name="port_read" value="20" <?=(isset($_POST['port_read']))?'checked':''?>/></td>
                                  <td><input type="checkbox" class="flat" name="port_update" value="21" <?=(isset($_POST['port_update']))?'checked':''?>/></td>
                                </tr>
                                <tr>
                                  <td>Forms</td>
                                  <td><input type="checkbox" class="flat" name="forms_create" value="22" <?=(isset($_POST['forms_create']))?'checked':''?>/></td>
                                  <td><input type="checkbox" class="flat" name="forms_read" value="23" <?=(isset($_POST['forms_read']))?'checked':''?>/></td>
                                  <td><input type="checkbox" class="flat" name="forms_update" value="24" <?=(isset($_POST['forms_update']))?'checked':''?>/></td>
                                </tr>
                                <tr>
                                  <td>HQ</td>
                                  <td><input type="checkbox" class="flat" name="hq_create" value="25" <?=(isset($_POST['hq_create']))?'checked':''?>/></td>
                                  <td><input type="checkbox" class="flat" name="hq_read" value="26" <?=(isset($_POST['hq_read']))?'checked':''?>/></td>
                                  <td><input type="checkbox" class="flat" name="hq_update" value="27" <?=(isset($_POST['hq_update']))?'checked':''?>/></td>
                                </tr>
                                <tr>
                                  <td>Logo</td>
                                  <td><input type="checkbox" class="flat" name="logo_create" value="28" <?=(isset($_POST['logo_create']))?'checked':''?>/></td>
                                  <td><input type="checkbox" class="flat" name="logo_read" value="29" <?=(isset($_POST['logo_read']))?'checked':''?>/></td>
                                  <td><input type="checkbox" class="flat" name="logo_update" value="30" <?=(isset($_POST['logo_update']))?'checked':''?>/></td>
                                </tr>
                              </tbody>
                            </table>
                          </div>
                          <!--table end-->
                        </div>
                      </div>
                      <div class="ln_solid"></div>
                      <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                          <a class="btn btn-warning" href="roles_view.php">Cancel</a>
                          <button type="submit" name="new_role" class="btn btn-success">Submit</button>
                        </div>
                      </div>
                    </form>
                      <!--form end-->
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- /page content -->
        <?php
			include 'include/footer.php';
		?>
      </div>
    </div>
<?php
	include 'include/script.php';
?>
