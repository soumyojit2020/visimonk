<?php
	include 'include/head.php';
	require_once 'include/dbConfig.php';
	checkLogin();

	//get processing
	if(isset($_GET['role_id']) && !empty($_GET['role_id'])){
		$roleId = clean($_GET['role_id']);
		$sqlRole = "SELECT * FROM role WHERE role_id=? AND account_id=? ";
		if($stmtRole = mysqli_prepare($conn, $sqlRole)){
			mysqli_stmt_bind_param($stmtRole,"ss",$param_roleId, $param_accountId);
			$param_roleId = $roleId;
			$param_accountId = $accountId;
			if(mysqli_stmt_execute($stmtRole)){
				$resultRole = mysqli_stmt_get_result($stmtRole);
				$rowRole = mysqli_fetch_array($resultRole, MYSQLI_ASSOC);
				$roleId = $rowRole['role_id'];
				$roleDescription = $rowRole['role_description'];
			}
		}
		global $permission1;
		$permission1 = array();
		$sqlPermission = "SELECT * FROM role_permission WHERE role_id=?";
		if($stmtPermission = mysqli_prepare($conn, $sqlPermission)){
			mysqli_stmt_bind_param($stmtPermission,"s",$param_roleId);
			$param_roleId = $roleId;
			if(mysqli_stmt_execute($stmtPermission)){
				$resultPermission = mysqli_stmt_get_result($stmtPermission);
				if(mysqli_num_rows($resultPermission) >= 1){
					while($rowPermission = mysqli_fetch_array($resultPermission, MYSQLI_ASSOC)){
						$permission1[$rowPermission["permission_id"]] = $rowPermission["permission_id"];
					}
				}
			}
		}
}//GET


//post processing (not the image one :)
if(isset($_POST) && !empty($_POST)){
	$errors = array();
	$permission1 = array();
	$roleId1 = clean($_POST['role_id']);
	$roleDescription = $_POST['role_name'];
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


	if(empty($roleDescription)){
		$errors[] .= 'Please enter a role name';
	}

	if(empty($user_create || $user_read || $user_read || $roles_create || $roles_read || $roles_update ||
						$campus_create || $campus_read || $campus_update || $building_create || $building_read || $building_update ||
							$floor_create || $floor_read || $floor_update || $area_create || $area_read || $area_update ||
								$port_create || $floor_read || $floor_update || $forms_create || $forms_read || $forms_update ||
									$hq_create || $hq_read || $hq_update || $logo_create || $logo_read ||$logo_update)){
		$errors[] .= 'Please select atleast one permission!';
	}

	//check if the changed name already exists
	$sql_name_check = "SELECT role_description FROM role WHERE role_description=? AND role_id!=? AND account_id=?";
	if($stmt_name_check = mysqli_prepare($conn, $sql_name_check)){
		mysqli_stmt_bind_param($stmt_name_check,"sss", $param_role_description, $param_role_id, $param_account_id);
		$param_role_description = $roleDescription;
		$param_role_id = $roleId1;
		$param_account_id = $accountId;
		if(mysqli_stmt_execute($stmt_name_check)){
			$result_name_check = mysqli_stmt_get_result($stmt_name_check);
			if(mysqli_num_rows($result_name_check) == 1){
				$errors[] .= $roleDescription.' already exists!';
			}
		}
	}

	if(empty($errors)){
		$sql_role_update = "UPDATE role SET role_description='$roleDescription' WHERE role_id=$roleId1";
		$query1 = mysqli_query($conn, $sql_role_update);

		$sql_role_delete = "DELETE FROM role_permission WHERE role_id=$roleId1";
		$query2 = mysqli_query($conn, $sql_role_delete);

		if(!empty($user_create)){
			$sql1 = "INSERT INTO role_permission (role_id, permission_id) VALUES($roleId1, 2),
			($roleId1, 3), ($roleId1, 1) ";
			$query1 = mysqli_query($conn,$sql1);
		}

		if(!empty($user_update)){
			$sql1 = "INSERT INTO role_permission (role_id, permission_id) VALUES
			($roleId1, 3), ($roleId1, 1) ";
			$query1 = mysqli_query($conn,$sql1);
		}

		if(!empty($user_read)){
			$sql1 = "INSERT INTO role_permission (role_id, permission_id) VALUES ($roleId1, 1)";
			$query1 = mysqli_query($conn,$sql1);
		}

		if(!empty($roles_create)){
			$sql1 = "INSERT INTO role_permission (role_id, permission_id) VALUES($roleId1, 4),
			($roleId1, 6), ($roleId1, 5) ";
			$query1 = mysqli_query($conn,$sql1);
		}

		if(!empty($roles_update)){
			$sql1 = "INSERT INTO role_permission (role_id, permission_id) VALUES
			($roleId1, 6), ($roleId1, 5) ";
			$query1 = mysqli_query($conn,$sql1);
		}

		if(!empty($roles_read)){
			$sql1 = "INSERT INTO role_permission (role_id, permission_id) VALUES ($roleId1, 5)";
			$query1 = mysqli_query($conn,$sql1);
		}

		if(!empty($campus_create)){
			$sql1 = "INSERT INTO role_permission (role_id, permission_id) VALUES($roleId1, 7),
			($roleId1, 9), ($roleId1, 8) ";
			$query1 = mysqli_query($conn,$sql1);
		}

		if(!empty($campus_update)){
			$sql1 = "INSERT INTO role_permission (role_id, permission_id) VALUES
			($roleId1, 9), ($roleId1, 8) ";
			$query1 = mysqli_query($conn,$sql1);
		}

		if(!empty($campus_read)){
			$sql1 = "INSERT INTO role_permission (role_id, permission_id) VALUES ($roleId1, 8)";
			$query1 = mysqli_query($conn,$sql1);
		}

		if(!empty($building_create)){
			$sql1 = "INSERT INTO role_permission (role_id, permission_id) VALUES($roleId1, 10),
			($roleId1, 12), ($roleId1, 11) ";
			$query1 = mysqli_query($conn,$sql1);
		}

		if(!empty($building_update)){
			$sql1 = "INSERT INTO role_permission (role_id, permission_id) VALUES
			($roleId1, 12), ($roleId1, 11) ";
			$query1 = mysqli_query($conn,$sql1);
		}

		if(!empty($building_read)){
			$sql1 = "INSERT INTO role_permission (role_id, permission_id) VALUES ($roleId1, 11)";
			$query1 = mysqli_query($conn,$sql1);
		}

		if(!empty($floor_create)){
			$sql1 = "INSERT INTO role_permission (role_id, permission_id) VALUES($roleId1, 13),
			($roleId1, 15), ($roleId1, 14) ";
			$query1 = mysqli_query($conn,$sql1);
		}

		if(!empty($floor_update)){
			$sql1 = "INSERT INTO role_permission (role_id, permission_id) VALUES
			($roleId1, 15), ($roleId1, 14) ";
			$query1 = mysqli_query($conn,$sql1);
		}

		if(!empty($floor_read)){
			$sql1 = "INSERT INTO role_permission (role_id, permission_id) VALUES ($roleId1, 14)";
			$query1 = mysqli_query($conn,$sql1);
		}

		if(!empty($area_create)){
			$sql1 = "INSERT INTO role_permission (role_id, permission_id) VALUES($roleId1, 16),
			($roleId1, 18), ($roleId1, 17) ";
			$query1 = mysqli_query($conn,$sql1);
		}

		if(!empty($area_update)){
			$sql1 = "INSERT INTO role_permission (role_id, permission_id) VALUES
			($roleId1, 18), ($roleId1, 17) ";
			$query1 = mysqli_query($conn,$sql1);
		}

		if(!empty($area_read)){
			$sql1 = "INSERT INTO role_permission (role_id, permission_id) VALUES ($roleId1, 17)";
			$query1 = mysqli_query($conn,$sql1);
		}

		if(!empty($port_create)){
			$sql1 = "INSERT INTO role_permission (role_id, permission_id) VALUES($roleId1, 19),
			($roleId1, 21), ($roleId1, 20) ";
			$query1 = mysqli_query($conn,$sql1);
		}

		if(!empty($port_update)){
			$sql1 = "INSERT INTO role_permission (role_id, permission_id) VALUES
			($roleId1, 21), ($roleId1, 20) ";
			$query1 = mysqli_query($conn,$sql1);
		}

		if(!empty($port_read)){
			$sql1 = "INSERT INTO role_permission (role_id, permission_id) VALUES ($roleId1, 20)";
			$query1 = mysqli_query($conn,$sql1);
		}

		if(!empty($forms_create)){
			$sql1 = "INSERT INTO role_permission (role_id, permission_id) VALUES($roleId1, 22),
			($roleId1, 24), ($roleId1, 23) ";
			$query1 = mysqli_query($conn,$sql1);
		}

		if(!empty($forms_update)){
			$sql1 = "INSERT INTO role_permission (role_id, permission_id) VALUES
			($roleId1, 24), ($roleId1, 23) ";
			$query1 = mysqli_query($conn,$sql1);
		}

		if(!empty($forms_read)){
			$sql1 = "INSERT INTO role_permission (role_id, permission_id) VALUES ($roleId1, 23)";
			$query1 = mysqli_query($conn,$sql1);
		}

		if(!empty($hq_create)){
			$sql1 = "INSERT INTO role_permission (role_id, permission_id) VALUES($roleId1, 25),
			($roleId1, 27), ($roleId1, 26) ";
			$query1 = mysqli_query($conn,$sql1);
		}

		if(!empty($hq_update)){
			$sql1 = "INSERT INTO role_permission (role_id, permission_id) VALUES
			($roleId1, 27), ($roleId1, 26) ";
			$query1 = mysqli_query($conn,$sql1);
		}

		if(!empty($hq_read)){
			$sql1 = "INSERT INTO role_permission (role_id, permission_id) VALUES ($roleId1, 26)";
			$query1 = mysqli_query($conn,$sql1);
		}

		if(!empty($logo_create)){
			$sql1 = "INSERT INTO role_permission (role_id, permission_id) VALUES($roleId1, 28),
			($roleId1, 30), ($roleId1, 29) ";
			$query1 = mysqli_query($conn,$sql1);
		}

		if(!empty($logo_update)){
			$sql1 = "INSERT INTO role_permission (role_id, permission_id) VALUES
			($roleId1, 30), ($roleId1, 29) ";
			$query1 = mysqli_query($conn,$sql1);
		}

		if(!empty($logo_read)){
			$sql1 = "INSERT INTO role_permission (role_id, permission_id) VALUES ($roleId1, 29)";
			$query1 = mysqli_query($conn,$sql1);
		}
		header("location: roles_view.php");
	}

}//POST
?>
  <body class="nav-md footer_fixed">
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
			<form action="roles_permissions_view.php" method="POST">
				<input type="hidden" name="role_id" value="<?=$roleId?>"/>
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <input type="text" name="role_name" value="<?=$roleDescription?>"/>
              </div>
              <div class="title_right">
                <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right">
                  <div class="input-group">
                    <a><button class="btn btn-success" type="submit">Save</button></a>
                    <a href="roles_view.php"><button class="btn btn-danger" type="button">Back</button></a>
                  </div>
                </div>
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
                              <td><input type="checkbox" class="flat" name="user_create" <?=(in_array(2,$permission1))?'checked':''?> <?=(isset($_POST['user_create']))?'checked':''?> value="2"/></td>
                              <td><input type="checkbox" class="flat" name="user_read"  <?=(in_array(1,$permission1))?'checked':''?> <?=(isset($_POST['user_read']))?'checked':''?> value="1"/></td>
                              <td><input type="checkbox" class="flat" name="user_update"  <?=(in_array(3,$permission1))?'checked':''?> <?=(isset($_POST['user_update']))?'checked':''?> value="3"/></td>
                            </tr>
                            <tr>
                              <td>Roles</td>
                              <td><input type="checkbox" class="flat" name="roles_create" <?=(in_array(4,$permission1))?'checked':''?> <?=(isset($_POST['roles_create']))?'checked':''?> value="4"/></td>
                              <td><input type="checkbox" class="flat" name="roles_read" <?=(in_array(5,$permission1))?'checked':''?> <?=(isset($_POST['roles_read']))?'checked':''?> value="5"/></td>
                              <td><input type="checkbox" class="flat" name="roles_update" <?=(in_array(6,$permission1))?'checked':''?> <?=(isset($_POST['roles_update']))?'checked':''?> value="6"/></td>
                            </tr>
                            <tr>
                              <td>Campus</td>
                              <td><input type="checkbox" class="flat" name="campus_create" <?=(in_array(7,$permission1))?'checked':''?> <?=(isset($_POST['campus_create']))?'checked':''?> value="7"/></td>
                              <td><input type="checkbox" class="flat" name="campus_read" <?=(in_array(8,$permission1))?'checked':''?> <?=(isset($_POST['campus_read']))?'checked':''?> value="8"/></td>
                              <td><input type="checkbox" class="flat" name="campus_update" <?=(in_array(9,$permission1))?'checked':''?> <?=(isset($_POST['campus_update']))?'checked':''?> value="9"/></td>
                            </tr>
                            <tr>
                              <td>Building</td>
                              <td><input type="checkbox" class="flat" name="building_create" <?=(in_array(10,$permission1))?'checked':''?> <?=(isset($_POST['building_create']))?'checked':''?> value="10"/></td>
                              <td><input type="checkbox" class="flat" name="building_read" <?=(in_array(11,$permission1))?'checked':''?> <?=(isset($_POST['building_read']))?'checked':''?> value="11"/></td>
                              <td><input type="checkbox" class="flat" name="building_update" <?=(in_array(12,$permission1))?'checked':''?> <?=(isset($_POST['building_update']))?'checked':''?> value="12"/></td>
                            </tr>
                            <tr>
                              <td>Floor</td>
                              <td><input type="checkbox" class="flat" name="floor_create" <?=(in_array(13,$permission1))?'checked':''?> <?=(isset($_POST['floor_create']))?'checked':''?> value="13"/></td>
                              <td><input type="checkbox" class="flat" name="floor_read" <?=(in_array(14,$permission1))?'checked':''?> <?=(isset($_POST['floor_read']))?'checked':''?> value="14"/></td>
                              <td><input type="checkbox" class="flat" name="floor_update" <?=(in_array(15,$permission1))?'checked':''?> <?=(isset($_POST['floor_update']))?'checked':''?> value="15"/></td>
                            </tr>
                            <tr>
                              <td>Area</td>
                              <td><input type="checkbox" class="flat" name="area_create" <?=(in_array(16,$permission1))?'checked':''?> <?=(isset($_POST['area_create']))?'checked':''?> value="16"/></td>
                              <td><input type="checkbox" class="flat" name="area_read" <?=(in_array(17,$permission1))?'checked':''?> <?=(isset($_POST['area_read']))?'checked':''?> value="17"/></td>
                              <td><input type="checkbox" class="flat" name="area_update" <?=(in_array(18,$permission1))?'checked':''?> <?=(isset($_POST['area_update']))?'checked':''?> value="18"/></td>
                            </tr>
                            <tr>
                              <td>Port</td>
                              <td><input type="checkbox" class="flat" name="port_create" <?=(in_array(19,$permission1))?'checked':''?> <?=(isset($_POST['port_create']))?'checked':''?> value="19"/></td>
                              <td><input type="checkbox" class="flat" name="port_read" <?=(in_array(20,$permission1))?'checked':''?> <?=(isset($_POST['port_read']))?'checked':''?> value="20"/></td>
                              <td><input type="checkbox" class="flat" name="port_update" <?=(in_array(21,$permission1))?'checked':''?> <?=(isset($_POST['port_update']))?'checked':''?> value="21"/></td>
                            </tr>
                            <tr>
                              <td>Forms</td>
                              <td><input type="checkbox" class="flat" name="forms_create" <?=(in_array(22,$permission1))?'checked':''?> <?=(isset($_POST['forms_create']))?'checked':''?> value="22"/></td>
                              <td><input type="checkbox" class="flat" name="forms_read" <?=(in_array(23,$permission1))?'checked':''?> <?=(isset($_POST['forms_read']))?'checked':''?> value="23"/></td>
                              <td><input type="checkbox" class="flat" name="forms_update" <?=(in_array(24,$permission1))?'checked':''?> <?=(isset($_POST['forms_update']))?'checked':''?> value="24"/></td>
                            </tr>
                            <tr>
                              <td>HQ</td>
                              <td><input type="checkbox" class="flat" name="hq_create" <?=(in_array(25,$permission1))?'checked':''?> <?=(isset($_POST['hq_create']))?'checked':''?> value="25"/></td>
                              <td><input type="checkbox" class="flat" name="hq_read" <?=(in_array(26,$permission1))?'checked':''?> <?=(isset($_POST['hq_read']))?'checked':''?> value="26"/></td>
                              <td><input type="checkbox" class="flat" name="hq_update" <?=(in_array(27,$permission1))?'checked':''?> <?=(isset($_POST['hq_update']))?'checked':''?> value="27"/></td>
                            </tr>
                            <tr>
                              <td>Logo</td>
                              <td><input type="checkbox" class="flat" name="logo_create" <?=(in_array(28,$permission1))?'checked':''?> <?=(isset($_POST['logo_create']))?'checked':''?> value="28"/></td>
                              <td><input type="checkbox" class="flat" name="logo_read" <?=(in_array(29,$permission1))?'checked':''?> <?=(isset($_POST['logo_read']))?'checked':''?> value="29"/></td>
                              <td><input type="checkbox" class="flat" name="logo_update" <?=(in_array(30,$permission1))?'checked':''?> <?=(isset($_POST['logo_update']))?'checked':''?> value="30"/></td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                      <!--table end-->
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
			</form>
        <!-- /page content -->
        <?php
			include 'include/footer.php';
		?>
      </div>
    </div>
<?php
	include 'include/script.php';
?>
