<?php
	include 'include/head.php';
	require_once 'include/dbConfig.php';
	checkLogin();

	$sql_floor_view = "SELECT uf.floor_id, f.floor_description, f.building_id, b.building_description, f.campus_id,f.active, c.campus_description, uf.account_id
											FROM user_floor uf
											LEFT JOIN floor f
											ON uf.floor_id = f.floor_id
											LEFT JOIN building b
											ON f.building_id = b.building_id
											LEFT JOIN campus c
											ON f.campus_id = c.campus_id
											WHERE uf.user_id=$userId AND uf.account_id=?
											ORDER BY f.campus_id";
	if($stmt_floor_view = mysqli_prepare($conn, $sql_floor_view)){
		mysqli_stmt_bind_param($stmt_floor_view,"s",$param_account_id);
		$param_account_id = $accountId;
		if(mysqli_stmt_execute($stmt_floor_view)){
			$result_floor_view = mysqli_stmt_get_result($stmt_floor_view);
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
                <h3>Floor</h3>
              </div>
							<?php if(in_array("floor_create", $permission)){
									echo '<div class="title_right">
		                <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right">
		                  <div class="input-group">
		                    <a href="new_floor_view.php"><button class="btn btn-primary" type="button">Add New</button></a>
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
										<?php if(in_array("floor_read", $permission)):?>
                      <!--table start-->
                      <div class="table-responsive">
                        <table class="table table-striped">
                          <thead>
                            <tr>
                              <th>Name</th>
                              <th>Building</th>
                              <th>Campus</th>
                              <?php if(in_array("floor_update", $permission)):?><th>Action</th><?php endif; ?>
                            </tr>
                          <thead>
                          <tbody>
														<?php while($row_floor_view = mysqli_fetch_array($result_floor_view)): ?>
                            <tr>
                              <td><?=$row_floor_view['floor_description']?></td>
                              <td><?=$row_floor_view['building_description']?></td>
                              <td><?=$row_floor_view['campus_description']?></td>
															<?php if(in_array("floor_update", $permission)):?>
                              <td>
                                <a href="edit_floor_view.php?floor_id=<?=$row_floor_view['floor_id']?>&building_id=<?=$row_floor_view['building_id']?>&campus_id=<?=$row_floor_view['campus_id']?>" class="btn btn-dark btn-xs">Edit</a>
																<?php if($row_floor_view['active'] == 1):?>
																	<a href="deactivate_floor.php?floor_id=<?=$row_floor_view['floor_id']?>" class="btn btn-danger btn-xs">Deactivate</a>
																<?php endif; ?>
																<?php if($row_floor_view['active'] == 0):?>
																	<a href="activate_floor.php?floor_id=<?=$row_floor_view['floor_id']?>"class="btn btn-success btn-xs">Activate</a>
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
