<?php
	include 'include/head.php';
	require_once 'include/dbConfig.php';
	checkLogin();

	$sql_campus_search = "SELECT * FROM form_campus fc LEFT JOIN user_campus uc ON fc.campus_id = uc.campus_id
												 LEFT JOIN campus c ON c.campus_id = uc.campus_id
												 LEFT JOIN form_structure f ON fc.form_id = f.form_id
												 WHERE uc.user_id = ? AND uc.account_id = ? AND f.active=1";
	if($stmt_campus_search = mysqli_prepare($conn, $sql_campus_search)){
		mysqli_stmt_bind_param($stmt_campus_search, "ss", $param_user_id, $param_account_id);
		$param_user_id = $userId;
		$param_account_id = $accountId;
		if(mysqli_stmt_execute($stmt_campus_search)){
			$result_campus_search = mysqli_stmt_get_result($stmt_campus_search);
		}
	}

	$sql_building_search = "SELECT * FROM form_building fc LEFT JOIN user_building uc ON fc.building_id = uc.building_id
												 LEFT JOIN building c ON c.building_id = uc.building_id
												 LEFT JOIN form_structure f ON fc.form_id = f.form_id
												 WHERE uc.user_id = ? AND uc.account_id = ? AND f.active=1";
	if($stmt_building_search = mysqli_prepare($conn, $sql_building_search)){
		mysqli_stmt_bind_param($stmt_building_search, "ss", $param_user_id, $param_account_id);
		$param_user_id = $userId;
		$param_account_id = $accountId;
		if(mysqli_stmt_execute($stmt_building_search)){
			$result_building_search = mysqli_stmt_get_result($stmt_building_search);
		}
	}

	$sql_floor_search = "SELECT * FROM form_floor fc LEFT JOIN user_floor uc ON fc.floor_id = uc.floor_id
												 LEFT JOIN floor c ON c.floor_id = uc.floor_id
												 LEFT JOIN form_structure f ON fc.form_id = f.form_id
												 WHERE uc.user_id = ? AND uc.account_id = ? AND f.active=1";
	if($stmt_floor_search = mysqli_prepare($conn, $sql_floor_search)){
		mysqli_stmt_bind_param($stmt_floor_search, "ss", $param_user_id, $param_account_id);
		$param_user_id = $userId;
		$param_account_id = $accountId;
		if(mysqli_stmt_execute($stmt_floor_search)){
			$result_floor_search = mysqli_stmt_get_result($stmt_floor_search);
		}
	}

	$sql_area_search = "SELECT * FROM form_area fc LEFT JOIN user_area uc ON fc.area_id = uc.area_id
												 LEFT JOIN area c ON c.area_id = uc.area_id
												 LEFT JOIN form_structure f ON fc.form_id = f.form_id
												 WHERE uc.user_id = ? AND uc.account_id = ? AND f.active=1";
	if($stmt_area_search = mysqli_prepare($conn, $sql_area_search)){
		mysqli_stmt_bind_param($stmt_area_search, "ss", $param_user_id, $param_account_id);
		$param_user_id = $userId;
		$param_account_id = $accountId;
		if(mysqli_stmt_execute($stmt_area_search)){
			$result_area_search = mysqli_stmt_get_result($stmt_area_search);
		}
	}

	$sql_port_search = "SELECT * FROM form_port fc LEFT JOIN user_port uc ON fc.port_id = uc.port_id
												 LEFT JOIN port c ON c.port_id = uc.port_id
												 LEFT JOIN form_structure f ON fc.form_id = f.form_id
												 WHERE uc.user_id = ? AND uc.account_id = ? AND f.active=1";
	if($stmt_port_search = mysqli_prepare($conn, $sql_port_search)){
		mysqli_stmt_bind_param($stmt_port_search, "ss", $param_user_id, $param_account_id);
		$param_user_id = $userId;
		$param_account_id = $accountId;
		if(mysqli_stmt_execute($stmt_port_search)){
			$result_port_search = mysqli_stmt_get_result($stmt_port_search);
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
                <h3>Use/Edit Form</h3>
              </div>
            </div>
            <div class="clearfix"></div>
            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_content">
										<?php if(in_array("forms_read", $permission)): ?>
                      <!--table start-->
                      <div class="table-responsive">
                        <table class="table table-striped">
                          <thead>
                            <tr>
                              <th>Form Name</th>
															<th>Location Level</th>
															<th>Location Name</th>
                              <?php if(in_array("forms_update", $permission)): ?><th>Action</th><?php endif; ?>
                            </tr>
                          <thead>
                          <tbody>
														<?php while($row_campus_search = mysqli_fetch_array($result_campus_search)): ?>
                            <tr>
                              <td><?=$row_campus_search['form_name'];?></td>
															<td>Campus</td>
															<td><?=$row_campus_search['campus_description'];?></td>
                              <td>
                                <?php if(in_array("forms_read", $permission)): ?><a href="form_location.php?fd=<?=$row_campus_search['form_id'];?>&ll=campus&ld=<?=$row_campus_search['campus_id'];?>" class="btn btn-default btn-xs">Use</a><?php endif; ?>
                                <?php if(in_array("forms_update", $permission)): ?><a href="edit_form.php?form_id=<?=$row_campus_search['form_id'];?>" class="btn btn-dark btn-xs">Edit</a><?php endif; ?>
                                <?php if(in_array("forms_update", $permission)): ?><a href="deactivate_form.php?form_id=<?=$row_campus_search['form_id'];?>" class="btn btn-danger btn-xs">Deactivate</a><?php endif; ?>
                              </td>
                            </tr>
														<?php endwhile; ?>
														<?php while($row_building_search = mysqli_fetch_array($result_building_search)): ?>
                            <tr>
                              <td><?=$row_building_search['form_name'];?></td>
															<td>Building</td>
															<td><?=$row_building_search['building_description'];?></td>
                              <td>
                                <?php if(in_array("forms_read", $permission)): ?><a href="form_location.php?fd=<?=$row_building_search['form_id'];?>&ll=building&ld=<?=$row_building_search['building_id'];?>" class="btn btn-default btn-xs">Use</a><?php endif; ?>
                                <?php if(in_array("forms_update", $permission)): ?><a href="edit_form.php?form_id=<?=$row_building_search['form_id'];?>" class="btn btn-dark btn-xs">Edit</a><?php endif; ?>
                                <?php if(in_array("forms_update", $permission)): ?><a href="deactivate_form.php?form_id=<?=$row_building_search['form_id'];?>" class="btn btn-danger btn-xs">Deactivate</a><?php endif; ?>
                              </td>
                            </tr>
														<?php endwhile; ?>
														<?php while($row_floor_search = mysqli_fetch_array($result_floor_search)): ?>
                            <tr>
                              <td><?=$row_floor_search['form_name'];?></td>
															<td>Floor</td>
															<td><?=$row_floor_search['floor_description'];?></td>
                              <td>
                                <?php if(in_array("forms_read", $permission)): ?><a href="form_location.php?fd=<?=$row_floor_search['form_id'];?>&ll=floor&ld=<?=$row_floor_search['floor_id'];?>" class="btn btn-default btn-xs">Use</a><?php endif; ?>
                                <?php if(in_array("forms_update", $permission)): ?><a href="edit_form.php?form_id=<?=$row_floor_search['form_id'];?>" class="btn btn-dark btn-xs">Edit</a><?php endif; ?>
                                <?php if(in_array("forms_update", $permission)): ?><a href="deactivate_form.php?form_id=<?=$row_floor_search['form_id'];?>" class="btn btn-danger btn-xs">Deactivate</a><?php endif; ?>
                              </td>
                            </tr>
														<?php endwhile; ?>
														<?php while($row_area_search = mysqli_fetch_array($result_area_search)): ?>
                            <tr>
                              <td><?=$row_area_search['form_name'];?></td>
															<td>Area</td>
															<td><?=$row_area_search['area_description'];?></td>
                              <td>
                                <?php if(in_array("forms_read", $permission)): ?><a href="form_location.php?fd=<?=$row_area_search['form_id'];?>&ll=area&ld=<?=$row_area_search['area_id'];?>" class="btn btn-default btn-xs">Use</a><?php endif; ?>
                                <?php if(in_array("forms_update", $permission)): ?><a href="edit_form.php?form_id=<?=$row_area_search['form_id'];?>" class="btn btn-dark btn-xs">Edit</a><?php endif; ?>
                                <?php if(in_array("forms_update", $permission)): ?><a href="deactivate_form.php?form_id=<?=$row_area_search['form_id'];?>" class="btn btn-danger btn-xs">Deactivate</a><?php endif; ?>
                              </td>
                            </tr>
														<?php endwhile; ?>
														<?php while($row_port_search = mysqli_fetch_array($result_port_search)): ?>
                            <tr>
                              <td><?=$row_port_search['form_name'];?></td>
															<td>Port</td>
															<td><?=$row_port_search['port_description'];?></td>
                              <td>
                                <?php if(in_array("forms_read", $permission)): ?><a href="form_location.php?fd=<?=$row_port_search['form_id'];?>&ll=port&ld=<?=$row_port_search['port_id'];?>" class="btn btn-default btn-xs">Use</a><?php endif; ?>
                                <?php if(in_array("forms_update", $permission)): ?><a href="edit_form.php?form_id=<?=$row_port_search['form_id'];?>" class="btn btn-dark btn-xs">Edit</a><?php endif; ?>
                                <?php if(in_array("forms_update", $permission)): ?><a href="deactivate_form.php?form_id=<?=$row_port_search['form_id'];?>" class="btn btn-danger btn-xs">Deactivate</a><?php endif; ?>
                              </td>
                            </tr>
														<?php endwhile; ?>
                          </tbody>
                        </table>
                      </div>
                      <!--campus table end-->

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
