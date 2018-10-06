<?php
	include 'include/head.php';
	require_once 'include/dbConfig.php';
	checkLogin();

	$sql_user_find = "SELECT u.user_id, u.user_name, ru.role_id, r.role_description
										FROM user u
										LEFT JOIN role_user ru
										ON u.user_id = ru.user_id
										LEFT JOIN role r
										ON ru.role_id = r.role_id
										WHERE u.account_id = ?";
	if($stmt_user_find = mysqli_prepare($conn, $sql_user_find)){
		mysqli_stmt_bind_param($stmt_user_find, "s", $param_account_id);
		$param_account_id = $accountId;
		if(mysqli_stmt_execute($stmt_user_find)){
			$result_user_find = mysqli_stmt_get_result($stmt_user_find);
		}
	}

	$sql_user_campus_find = "SELECT DISTINCT uc.user_id, u.user_name, u.active, ru.role_id, r.role_description
										FROM user_campus uc
										LEFT JOIN user u ON uc.user_id = u.user_id
										LEFT JOIN role_user ru ON u.user_id = ru.user_id
										LEFT JOIN role r ON ru.role_id = r.role_id
										WHERE uc.campus_id IN
										(SELECT campus_id FROM user_campus WHERE user_id=$userId)
 										AND uc.account_id = ?
										ORDER BY u.user_name ASC";
	if($stmt_user_campus_find = mysqli_prepare($conn, $sql_user_campus_find)){
		mysqli_stmt_bind_param($stmt_user_campus_find, "s", $param_account_id);
		$param_account_id = $accountId;
		if(mysqli_stmt_execute($stmt_user_campus_find)){
			$result_user_campus_find = mysqli_stmt_get_result($stmt_user_campus_find);
		}
	}

	$sql_user_building_find = "SELECT DISTINCT uc.user_id, u.user_name, u.active, ru.role_id, r.role_description
										FROM user_building uc
										LEFT JOIN user u ON uc.user_id = u.user_id
										LEFT JOIN role_user ru ON u.user_id = ru.user_id
										LEFT JOIN role r ON ru.role_id = r.role_id
										WHERE uc.building_id IN
										(SELECT building_id FROM user_building WHERE user_id=$userId)
 										AND uc.account_id = ?
										ORDER BY u.user_name ASC";
	if($stmt_user_building_find = mysqli_prepare($conn, $sql_user_building_find)){
		mysqli_stmt_bind_param($stmt_user_building_find, "s", $param_account_id);
		$param_account_id = $accountId;
		if(mysqli_stmt_execute($stmt_user_building_find)){
			$result_user_building_find = mysqli_stmt_get_result($stmt_user_building_find);
		}
	}

	$sql_user_floor_find = "SELECT DISTINCT uc.user_id, u.user_name, u.active, ru.role_id, r.role_description
										FROM user_floor uc
										LEFT JOIN user u ON uc.user_id = u.user_id
										LEFT JOIN role_user ru ON u.user_id = ru.user_id
										LEFT JOIN role r ON ru.role_id = r.role_id
										WHERE uc.floor_id IN
										(SELECT floor_id FROM user_floor WHERE user_id=$userId)
 										AND uc.account_id = ?
										ORDER BY u.user_name ASC";
	if($stmt_user_floor_find = mysqli_prepare($conn, $sql_user_floor_find)){
		mysqli_stmt_bind_param($stmt_user_floor_find, "s", $param_account_id);
		$param_account_id = $accountId;
		if(mysqli_stmt_execute($stmt_user_floor_find)){
			$result_user_floor_find = mysqli_stmt_get_result($stmt_user_floor_find);
		}
	}

	$sql_user_area_find = "SELECT DISTINCT uc.user_id, u.user_name, u.active, ru.role_id, r.role_description
										FROM user_area uc
										LEFT JOIN user u ON uc.user_id = u.user_id
										LEFT JOIN role_user ru ON u.user_id = ru.user_id
										LEFT JOIN role r ON ru.role_id = r.role_id
										WHERE uc.area_id IN
										(SELECT area_id FROM user_area WHERE user_id=$userId)
 										AND uc.account_id = ?
										ORDER BY u.user_name ASC";
	if($stmt_user_area_find = mysqli_prepare($conn, $sql_user_area_find)){
		mysqli_stmt_bind_param($stmt_user_area_find, "s", $param_account_id);
		$param_account_id = $accountId;
		if(mysqli_stmt_execute($stmt_user_area_find)){
			$result_user_area_find = mysqli_stmt_get_result($stmt_user_area_find);
		}
	}

	$sql_user_port_find = "SELECT DISTINCT uc.user_id, u.user_name, u.active, ru.role_id, r.role_description
										FROM user_port uc
										LEFT JOIN user u ON uc.user_id = u.user_id
										LEFT JOIN role_user ru ON u.user_id = ru.user_id
										LEFT JOIN role r ON ru.role_id = r.role_id
										WHERE uc.port_id IN
										(SELECT port_id FROM user_port WHERE user_id=$userId)
 										AND uc.account_id = ?
										ORDER BY u.user_name ASC";
	if($stmt_user_port_find = mysqli_prepare($conn, $sql_user_port_find)){
		mysqli_stmt_bind_param($stmt_user_port_find, "s", $param_account_id);
		$param_account_id = $accountId;
		if(mysqli_stmt_execute($stmt_user_port_find)){
			$result_user_port_find = mysqli_stmt_get_result($stmt_user_port_find);
		}
	}

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
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Users</h3>
              </div>
							<?php
								if(in_array("user_create", $permission)){
									echo'<div class="title_right">
			                <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right">
			                  <div class="input-group">
			                    <a href="new_user_view.php"><button class="btn btn-primary" type="button">Add New</button></a>
			                  </div>
			                </div>
			              </div>';
								}
							?>
            </div>
            <div class="clearfix"></div>
            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_content">
										<?php if(in_array("user_read", $permission)):?>
                      <!--table start-->
                      <div class="table-responsive">
                        <table class="table table-striped">
                          <thead>
                            <tr>
                              <th>Name</th>
															<th>Level</th>
                              <th>Role</th>
                              <?php if(in_array("user_update", $permission)):?><th>Action</th><?php endif; ?>
                            </tr>
                          <thead>
                          <tbody>
														<?php while($row_user_campus_find = mysqli_fetch_array($result_user_campus_find, MYSQLI_ASSOC)): ?>
                            <tr>
                              <td><?=$row_user_campus_find['user_name'];?></td>
															<td>Campus</td>
                              <td><?=$row_user_campus_find['role_description'];?></td>
															<?php if(in_array("user_update", $permission)):?>
                              <td>
                                <a href="edit_user_view.php?user_id=<?=$row_user_campus_find['user_id'];?>" class="btn btn-dark btn-xs">Edit</a>
																<?php if($row_user_campus_find['active'] == 1):?>
																	<a href="deactivate_user.php?user_id=<?=$row_user_campus_find['user_id'];?>" class="btn btn-danger btn-xs">Deactivate</a>
																<?php endif; ?>
																<?php if($row_user_campus_find['active'] == 0):?>
																	<a href="activate_user.php?user_id=<?=$row_user_campus_find['user_id'];?>" class="btn btn-success btn-xs">Activate</a>
																<?php endif; ?>
                              </td>
															<?php endif; ?>
                            </tr>
													<?php endwhile; ?>
													<?php while($row_user_building_find = mysqli_fetch_array($result_user_building_find, MYSQLI_ASSOC)): ?>
													<tr>
														<td><?=$row_user_building_find['user_name'];?></td>
														<td>Building</td>
														<td><?=$row_user_building_find['role_description'];?></td>
														<?php if(in_array("user_update", $permission)):?>
														<td>
															<a href="edit_user_view.php?user_id=<?=$row_user_building_find['user_id'];?>" class="btn btn-dark btn-xs">Edit</a>
															<?php if($row_user_building_find['active'] == 1):?>
																<a href="deactivate_user.php?user_id=<?=$row_user_building_find['user_id'];?>" class="btn btn-danger btn-xs">Deactivate</a>
															<?php endif; ?>
															<?php if($row_user_building_find['active'] == 0):?>
																<a href="activate_user.php?user_id=<?=$row_user_building_find['user_id'];?>" class="btn btn-success btn-xs">Activate</a>
															<?php endif; ?>
														</td>
														<?php endif; ?>
													</tr>
												<?php endwhile; ?>
												<?php while($row_user_floor_find = mysqli_fetch_array($result_user_floor_find, MYSQLI_ASSOC)): ?>
												<tr>
													<td><?=$row_user_floor_find['user_name'];?></td>
													<td>Floor</td>
													<td><?=$row_user_floor_find['role_description'];?></td>
													<?php if(in_array("user_update", $permission)):?>
													<td>
														<a href="edit_user_view.php?user_id=<?=$row_user_floor_find['user_id'];?>" class="btn btn-dark btn-xs">Edit</a>
														<?php if($row_user_floor_find['active'] == 1):?>
															<a href="deactivate_user.php?user_id=<?=$row_user_floor_find['user_id'];?>" class="btn btn-danger btn-xs">Deactivate</a>
														<?php endif; ?>
														<?php if($row_user_floor_find['active'] == 0):?>
															<a href="activate_user.php?user_id=<?=$row_user_floor_find['user_id'];?>" class="btn btn-success btn-xs">Activate</a>
														<?php endif; ?>
													</td>
													<?php endif; ?>
												</tr>
											<?php endwhile; ?>
											<?php while($row_user_area_find = mysqli_fetch_array($result_user_area_find, MYSQLI_ASSOC)): ?>
											<tr>
												<td><?=$row_user_area_find['user_name'];?></td>
												<td>Area</td>
												<td><?=$row_user_area_find['role_description'];?></td>
												<?php if(in_array("user_update", $permission)):?>
												<td>
													<a href="edit_user_view.php?user_id=<?=$row_user_area_find['user_id'];?>" class="btn btn-dark btn-xs">Edit</a>
													<?php if($row_user_area_find['active'] == 1):?>
														<a href="deactivate_user.php?user_id=<?=$row_user_area_find['user_id'];?>" class="btn btn-danger btn-xs">Deactivate</a>
													<?php endif; ?>
													<?php if($row_user_area_find['active'] == 0):?>
														<a href="activate_user.php?user_id=<?=$row_user_area_find['user_id'];?>" class="btn btn-success btn-xs">Activate</a>
													<?php endif; ?>
												</td>
												<?php endif; ?>
											</tr>
										<?php endwhile; ?>
										<?php while($row_user_port_find = mysqli_fetch_array($result_user_port_find, MYSQLI_ASSOC)): ?>
										<tr>
											<td><?=$row_user_port_find['user_name'];?></td>
											<td>Port</td>
											<td><?=$row_user_port_find['role_description'];?></td>
											<?php if(in_array("user_update", $permission)):?>
											<td>
												<a href="edit_user_view.php?user_id=<?=$row_user_port_find['user_id'];?>" class="btn btn-dark btn-xs">Edit</a>
												<?php if($row_user_port_find['active'] == 1):?>
													<a href="deactivate_user.php?user_id=<?=$row_user_port_find['user_id'];?>" class="btn btn-danger btn-xs">Deactivate</a>
												<?php endif; ?>
												<?php if($row_user_port_find['active'] == 0):?>
													<a href="activate_user.php?user_id=<?=$row_user_port_find['user_id'];?>" class="btn btn-success btn-xs">Activate</a>
												<?php endif; ?>
											</td>
											<?php endif; ?>
										</tr>
									<?php endwhile; ?>
                          </tbody>
                        </table>
                      </div>
                      <!--table end-->
										<?php endif; ?>
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
