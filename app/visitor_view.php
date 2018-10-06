<?php
	include 'include/head.php';
	require_once 'include/dbConfig.php';
	checkLogin();

	$sql_visitor = "SELECT * FROM visitor WHERE account_id = ?";
	if($stmt_visitor = mysqli_prepare($conn, $sql_visitor)){
		mysqli_stmt_bind_param($stmt_visitor, "s", $param_account_id);
		$param_account_id = $accountId;
		if(mysqli_stmt_execute($stmt_visitor)){
			$result_visitor = mysqli_stmt_get_result($stmt_visitor);
			$row_visitor = mysqli_fetch_array($result_visitor, MYSQLI_ASSOC);
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
                <h3>Visitors</h3>
              </div>
              <div class="title_right">
                <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                  <div class="input-group">
                    <input type="text" class="form-control" placeholder="Search Visitor...">
                    <span class="input-group-btn">
                      <button class="btn btn-primary" type="button">Go!</button>
                    </span>
                  </div>
                </div>
              </div>
            </div>
            <div class="clearfix"></div>
            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_content">
										<!--table start-->
										<div class="table-responsive">
											<table class="table table-striped">
												<thead>
													<tr>
														<th>Name</th>
														<th>Phone</th>
														<th>Email</th>
														<th>Time In</th>
														<th>Time Out</th>
														<th>Action</th>
													</tr>
												<thead>
												<tbody>
													<?php while($row_visitor = mysqli_fetch_array($result_visitor, MYSQLI_ASSOC)):?>
														<tr>
														<td><?=$row_visitor['visitor_name'];?></td>
														<td><?=$row_visitor['visitor_phone'];?></td>
														<td><?=$row_visitor['visitor_email'];?></td>
														<td><?=$row_visitor['date_time_in'];?></td>
														<td><?=$row_visitor['date_time_out'];?></td>
														<td>
															<a  href="visitor_out.php?visitor_id=<?=$row_visitor['visitor_id'];?>&form_id=<?=$row_visitor['form_id'];?>" class="btn btn-danger btn-xs">Out</a>
															<a href="visitor_detail.php?visitor_id=<?=$row_visitor['visitor_id'];?>" class="btn btn-dark btn-xs">Details</a>
														</td>
													</tr>
													<?php endwhile; ?>
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
        <!-- /page content -->
        <?php
			include 'include/footer.php';
		?>
      </div>
    </div>
<?php
	include 'include/script.php';
?>
