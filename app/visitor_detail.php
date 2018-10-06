<?php
	include 'include/head.php';
	require_once 'include/dbConfig.php';
	checkLogin();

  if(isset($_GET) && !empty($_GET)){
    $visitor_id = clean($_GET['visitor_id']);
    $sql_visitor_detail = "SELECT * FROM visitor WHERE visitor_id=?";
    if($stmt_visitor_detail = mysqli_prepare($conn, $sql_visitor_detail)){
      mysqli_stmt_bind_param($stmt_visitor_detail, "s", $param_visitor_id);
      $param_visitor_id = $visitor_id;
      if(mysqli_stmt_execute($stmt_visitor_detail)){
        $result_visitor_detail = mysqli_stmt_get_result($stmt_visitor_detail);
        $row_visitor_detail = mysqli_fetch_array($result_visitor_detail, MYSQLI_ASSOC);
      }
			$location_level = $row_visitor_detail['location_level'];
			$location_id = $row_visitor_detail['location_id'];

			$text = $location_level.'_id';

			$sql_location = "SELECT * FROM `$location_level` WHERE $text=?";
			if($stmt_location = mysqli_prepare($conn, $sql_location)){
				mysqli_stmt_bind_param($stmt_location, "s", $param_location_id);
				$param_location_id = $location_id;
				if(mysqli_stmt_execute($stmt_location)){
					$result_location = mysqli_stmt_get_result($stmt_location);
					$row_location = mysqli_fetch_array($result_location);
					$location_name = $row_location[$location_level."_description"];
				}
			}
    }
  }//GET
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
                <h3>Visitor Detail</h3>
              </div>
              <div class="title_right">
                <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right">
                  <div class="input-group">
                    <a href="visitor_view.php"><button class="btn btn-primary" type="button">Back</button></a>
                  </div>
                </div>
              </div>
            <div class="clearfix"></div>
            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="clearfix"></div>
                  <div class="x_content">
										<div class="table-responsive">
											<table class="table table-bordered">
												<tbody>
													<tr>
														<td><b>Visitor Name</b></td>
														<td><?=$row_visitor_detail['visitor_name']?></td>
														<td><b>Host Name</b></td>
														<td><?=$row_visitor_detail['host_name']?></td>
													</tr>
													<tr>
														<td><b>Visitor Email</b></td>
														<td><?=$row_visitor_detail['visitor_email']?></td>
														<td><b>Host Email</b></td>
														<td><?=$row_visitor_detail['host_email']?></td>
													</tr>
													<tr>
														<td><b>Visitor Phone</b></td>
														<td><?=$row_visitor_detail['visitor_phone']?></td>
														<td><b>Host Phone</b></td>
														<td><?=$row_visitor_detail['host_phone']?></td>
													</tr>
													<tr>
														<td><b>In</b></td>
														<td><?=$row_visitor_detail['date_time_in']?></td>
														<td><b>Location Level</b></td>
														<td><?=$location_level?></td>
													</tr>
													<tr>
														<td><b>Out</b></td>
														<td><?=$row_visitor_detail['date_time_out']?></td>
														<td><b>Location Name</b></td>
														<td><?=$location_name?></td>
													</tr>
													<tr>
														<td><b>ID</b></td>
														<td><?=$row_visitor_detail['id']?></td>
														<td><b>Notes</b></td>
														<td><?=$row_visitor_detail['notes']?></td>
													</tr>
												</tbody>
											</table>
										</div>
										<div class="table-responsive">
											<table class="table table-bordered">
												<tbody>
													<tr>
														<td><b>Visitor Photo</b></td>
														<td><b>ID Card Photo</b></td>
													</tr>
													<tr>
														<td><div class="image view view-first"><img style="width:100%" src="<?=$row_visitor_detail['image_path']?>" alt="VisiMonk - Visitor Image Not Available." /></div></td>
														<td><div class="image view view-first"><img style="width:100%" src="<?=$row_visitor_detail['photo_id_path']?>" alt="VisiMonk - Visitor ID Image Not Available." /></div></td>
													</tr>
												</tbody>
											</table>
										</div>
                  </div>
                </div>
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
