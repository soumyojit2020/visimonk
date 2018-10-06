<?php
	include 'include/head.php';
	require_once 'include/dbConfig.php';
	checkLogin();

	$sql1 = "SELECT * FROM role WHERE account_id=?";
	if($stmt1 = mysqli_prepare($conn, $sql1)){
		mysqli_stmt_bind_param($stmt1,"s", $param_account_id);
		$param_account_id = $accountId;
		if(mysqli_stmt_execute($stmt1)){
			$result = mysqli_stmt_get_result($stmt1);
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
                <h3>Roles</h3>
              </div>
							<?php
							if(in_array("roles_create", $permission)){
								echo '<div class="title_right">
	                <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right">
	                  <div class="input-group">
	                    <a href="new_roles_view.php"><button class="btn btn-primary" type="button">Add New</button></a>
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
										<?php if(in_array("roles_read", $permission)):?>
											<!--table start-->
                      <div class="table-responsive">
                        <table class="table table-striped">
                          <thead>
                            <tr>
                              <th>Name</th>
                              <?php if(in_array("roles_update", $permission)):?><th>Permissions</th><?php endif;?>
                              <?php if(in_array("roles_update", $permission)):?><th>Action</th><?php endif;?>
                            </tr>
                          <thead>
                          <tbody>
														<?php while($row = mysqli_fetch_array($result)): ?>
                            <tr>
                              <td><?=$row['role_description'];?></td>
                              <?php if(in_array("roles_update", $permission)):?>
																<td><a class="btn btn-default btn-xs" href="roles_permissions_view.php?role_id=<?=$row['role_id'];?>">Permissions</a></td>
															<td>
                                <a class="btn btn-dark btn-xs" href="roles_permissions_view.php?role_id=<?=$row['role_id'];?>">Edit</a>
																<?php if($row['active'] == 1):?>
																	<a href="deactivate_role.php?role_id=<?=$row['role_id'];?>" class="btn btn-danger btn-xs">Deactivate</a>
																<?php endif; ?>
																<?php if($row['active'] == 0):?>
																	<a href="activate_role.php?role_id=<?=$row['role_id'];?>" class="btn btn-success btn-xs">Activate</a>
																<?php endif; ?>
                              </td>
															<?php endif?>
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
