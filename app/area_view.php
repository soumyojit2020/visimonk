<?php
	include 'include/head.php';
	require_once 'include/dbConfig.php';
	checkLogin();

	$sql_area_view = "SELECT ua.area_id, a.area_description, a.floor_id,a.active, f.floor_description, a.building_id, b.building_description,
                                        a.campus_id, c.campus_description, ua.account_id
																				FROM user_area ua
																				LEFT JOIN area a
																				ON ua.area_id = a.area_id
																				LEFT JOIN floor f
                                        ON a.floor_id = f.floor_id
                                        LEFT JOIN building b
                                        ON f.building_id = b.building_id
                                        LEFT JOIN campus c
                                        ON b.campus_id = c.campus_id
																				WHERE ua.user_id=$userId AND ua.account_id=?
																				ORDER BY a.campus_id";
	if($stmt_area_view = mysqli_prepare($conn, $sql_area_view)){
		mysqli_stmt_bind_param($stmt_area_view,"s", $param_account_id);
		$param_account_id = $accountId;
		if(mysqli_stmt_execute($stmt_area_view)){
			$result_area_view = mysqli_stmt_get_result($stmt_area_view);
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
                <h3>Area</h3>
              </div>
							<?php
								if(in_array("area_create", $permission)){
									echo '<div class="title_right">
		                <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right">
		                  <div class="input-group">
		                    <a href="new_area_view.php"><button class="btn btn-primary" type="button">Add New</button></a>
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
										<?php if(in_array("area_read", $permission)):?>
                      <!--table start-->
                      <div class="table-responsive">
                        <table class="table table-striped">
                          <thead>
                            <tr>
                              <th>Name</th>
                              <th>Floor</th>
                              <th>Building</th>
                              <th>Campus</th>
                              <?php if(in_array("area_update", $permission)):?><th>Action</th><?php endif; ?>
                            </tr>
                          <thead>
                          <tbody>
														<?php while($row_area_view = mysqli_fetch_array($result_area_view)): ?>
                            <tr>
                              <td><?=$row_area_view['area_description']?></td>
                              <td><?=$row_area_view['floor_description']?></td>
                              <td><?=$row_area_view['building_description']?></td>
                              <td><?=$row_area_view['campus_description']?></td>
															<?php if(in_array("area_update", $permission)):?>
                              <td>
                                <a href="edit_area_view.php?area_id=<?=$row_area_view['area_id']?>&floor_id=<?=$row_area_view['floor_id']?>&building_id=<?=$row_area_view['building_id']?>&campus_id=<?=$row_area_view['campus_id']?>" class="btn btn-dark btn-xs">Edit</a>
																<?php if($row_area_view['active'] == 1):?>
																	<a href="deactivate_area.php?area_id=<?=$row_area_view['area_id']?>" class="btn btn-danger btn-xs">Deactivate</a>
																<?php endif; ?>
																<?php if($row_area_view['active'] == 0):?>
																	<a href="activate_area.php?area_id=<?=$row_area_view['area_id']?>"class="btn btn-success btn-xs">Activate</a>
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
