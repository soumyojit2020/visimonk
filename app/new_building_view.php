<?php
	include 'include/head.php';
	require_once 'include/dbConfig.php';
	checkLogin();

	$sql_campus_view = "SELECT campus_id, campus_description FROM campus WHERE account_id = ?";
	if($stmt_campus_view = mysqli_prepare($conn, $sql_campus_view)){
		mysqli_stmt_bind_param($stmt_campus_view, "s", $param_account_id);
		$param_account_id = $accountId;
		if(mysqli_stmt_execute($stmt_campus_view)){
			$result_campus_view = mysqli_stmt_get_result($stmt_campus_view);
		}
	}

	if(isset($_POST) && !empty($_POST)){
		$errors = array();
		$building_name = clean($_POST['building_name']);
		$campus_id = clean($_POST['campus_name']);
		if(empty($building_name)){
			$errors[] .= 'Please fill in building name.';
		}

		if(empty($campus_id)){
			$errors[] .= 'Please select Campus.';
		}

		$sql_building_search = "SELECT building_description FROM building WHERE account_id=? AND campus_id=? AND building_description=?";
		if($stmt_building_search = mysqli_prepare($conn, $sql_building_search)){
			mysqli_stmt_bind_param($stmt_building_search, "sss", $param_account_id, $param_campus_id, $param_building_description);
			$param_account_id = $accountId;
			$param_campus_id = $campus_id;
			$param_building_description = $building_name;
			if(mysqli_stmt_execute($stmt_building_search)){
				$result_building_search = mysqli_stmt_get_result($stmt_building_search);
				if(mysqli_num_rows($result_building_search) == 1){
					$errors[] .= $building_name .' already exists!';
				}
			}
		}

		if(empty($errors)){
			$sql_insert_building = "INSERT INTO building (building_description, campus_id, account_id) VALUES('$building_name', $campus_id, '$accountId')";
			if($query1 = mysqli_query($conn, $sql_insert_building)){
				$sql_find_building = "SELECT * FROM building WHERE building_description=? AND campus_id=? AND account_id=?";
				if($stmt_find_building = mysqli_prepare($conn, $sql_find_building)){
					mysqli_stmt_bind_param($stmt_find_building, "sss", $param_building_description, $param_campus_id, $param_account_id);
					$param_building_description = $building_name;
					$param_campus_id = $campus_id;
					$param_account_id = $accountId;
					if(mysqli_stmt_execute($stmt_find_building)){
						$result_find_building = mysqli_stmt_get_result($stmt_find_building);
						$row_find_building = mysqli_fetch_array($result_find_building);
						$building_id_find = $row_find_building['building_id'];
						$sql_user_building = "INSERT INTO user_building(user_id, building_id, account_id) VALUES($userId, $building_id_find, '$accountId')";
						$query2 = mysqli_query($conn, $sql_user_building);
						header("location: building_view.php");
					}
				}
			}
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
                <h3>Add Building</h3>
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
                      <form data-parsley-validate class="form-horizontal form-label-left" action="new_building_view.php" method="POST">
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="building-name">Building Name <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" id="building-name" name="building_name" required="required" class="form-control col-md-7 col-xs-12" value="<?=(isset($_POST['building_name']))?$building_name:''?>"/>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="campus-name">Campus Name <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
													<select class="form-control" name="campus_name">
														<?php while($row_campus_view = mysqli_fetch_array($result_campus_view)): ?>
														<option value="<?=$row_campus_view['campus_id']?>"><?=$row_campus_view['campus_description']?></option>
														<?php endwhile; ?>
													</select>
                        </div>
                      </div>
                      <div class="ln_solid"></div>
                      <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                          <a class="btn btn-warning" href="building_view.php" type="button">Cancel</a>
                          <button type="submit" class="btn btn-success">Submit</button>
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
