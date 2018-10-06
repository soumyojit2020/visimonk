<?php
	include 'include/head.php';
	require_once 'include/dbConfig.php';
	checkLogin();

	$sql_campus_view = "SELECT uc.campus_id, c.campus_description, c.active
											FROM user_campus uc
											LEFT JOIN campus c ON uc.campus_id = c.campus_id
											WHERE uc.user_id=$userId AND uc.account_id=?";
	if($stmt_campus_view = mysqli_prepare($conn, $sql_campus_view)){
		mysqli_stmt_bind_param($stmt_campus_view, "s", $param_account_id);
		$param_account_id = $accountId;
		if(mysqli_stmt_execute($stmt_campus_view)){
			$result_campus_view = mysqli_stmt_get_result($stmt_campus_view);
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
                <h3>Campus</h3>
              </div>
							<?php
								if(in_array("campus_create", $permission)){
									echo '<div class="title_right">
		                <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right">
		                  <div class="input-group">
		                    <a href="new_campus_view.php"><button class="btn btn-primary" type="button">Add New</button></a>
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
										<?php if(in_array("campus_read", $permission)):?>
                      <!--table start-->
                      <div class="table-responsive">
                        <table class="table table-striped">
                          <thead>
                            <tr>
                              <th>Name</th>
                              <?php if(in_array("campus_update", $permission)):?><th>Action</th><?php endif;?>
                            </tr>
                          <thead>
                          <tbody>
														<?php while($row_campus_view = mysqli_fetch_array($result_campus_view)): ?>
                            <tr>
                              <td><?=$row_campus_view['campus_description']?></td>
															<?php if(in_array("campus_update", $permission)):?>
                              <td>
                                <a  href= "edit_campus_view.php?campus_id=<?=$row_campus_view['campus_id']?>" class="btn btn-dark btn-xs">Edit</a>
																<?php if($row_campus_view['active'] == 1):?>
																	<a href="deactivate_campus.php?campus_id=<?=$row_campus_view['campus_id']?>" class="btn btn-danger btn-xs">Deactivate</a>
																<?php endif; ?>
																<?php if($row_campus_view['active'] == 0):?>
																	<a href="activate_campus.php?campus_id=<?=$row_campus_view['campus_id']?>"class="btn btn-success btn-xs">Activate</a>
																<?php endif; ?>
                              </td>
														<?php endif;?>
                            </tr>
													<?php endwhile; ?>
                          </tbody>
                        </table>
                      </div>
										<?php endif; ?>
                      <!--table end-->
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
