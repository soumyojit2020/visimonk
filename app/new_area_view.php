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

	//form processing Start
		if(isset($_POST) && !empty($_POST)){
			$area_name = clean($_POST['area_name']);
			$campus_id = clean($_POST['campus_name']);
			$building_id = clean($_POST['building_name']);
			$floor_id = clean($_POST['floor_name']);

			$errors = array();

			if(empty($area_name)){
				$errors[] .= "Area Name cannot be blank!";
			}

			if(empty($campus_id)){
				$errors[] .= "Campus Name cannot be blank!";
			}

			if(empty($building_id)){
				$errors[] .= "Building Name cannot be blank!";
			}

			if(empty($floor_id)){
				$errors[] .= "Floor Name cannot be blank!";
			}

			$sql_area_search = "SELECT area_description FROM area WHERE area_description=? AND floor_id=? AND account_id=?";
			if($stmt_area_search = mysqli_prepare($conn, $sql_area_search)){
				mysqli_stmt_bind_param($stmt_area_search,"sss",$param_area_description, $param_floor_id, $param_account_id);
				$param_area_description = $area_name;
				$param_floor_id = $floor_id;
				$param_account_id = $accountId;
				if(mysqli_stmt_execute($stmt_area_search)){
					$result_area_search = mysqli_stmt_get_result($stmt_area_search);
					if(mysqli_num_rows($result_area_search) == 1){
						$errors[] .= $area_name. " already exists!";
					}
				}
			}

			if(empty($errors)){
				$sql_area_insert = "INSERT INTO area (area_description, campus_id, building_id, floor_id, account_id) VALUES('$area_name', $campus_id, $building_id, $floor_id, '$accountId')";
				if($query1 = mysqli_query($conn,$sql_area_insert)){
					$sql_find_area = "SELECT * FROM area WHERE area_description=? AND campus_id=? AND building_id=? AND floor_id=? AND account_id=?";
					if($stmt_find_area = mysqli_prepare($conn, $sql_find_area)){
						mysqli_stmt_bind_param($stmt_find_area, "sssss", $param_area_description, $param_campus_id, $param_building_id, $param_floor_id, $param_account_id);
						$param_area_description = $area_name;
						$param_campus_id = $campus_id;
						$param_building_id = $building_id;
						$param_floor_id = $floor_id;
						$param_account_id = $accountId;
						if(mysqli_stmt_execute($stmt_find_area)){
							$result_find_area = mysqli_stmt_get_result($stmt_find_area);
							$row_find_area = mysqli_fetch_array($result_find_area);
							$area_id_find = $row_find_area['area_id'];
							$sql_user_area = "INSERT INTO user_area(user_id, area_id, account_id) VALUES($userId, $area_id_find, '$accountId')";
							$query2 = mysqli_query($conn, $sql_user_area);
							header("location: area_view.php");
						}
					}
				}
			}
		}
	//form processing stop
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
                <h3>Add Area</h3>
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
                      <form data-parsley-validate class="form-horizontal form-label-left" action="new_area_view.php" method="POST">
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="area_name">Area Name <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" id="area_name"  name="area_name" required="required" class="form-control col-md-7 col-xs-12" value="<?=(isset($_POST['area_name']))?$area_name:''?>">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="campus-name">Campus Name <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
													<select class="form-control" id="campus_name" name="campus_name" onclick="fetch_building(this.value);" onchange="fetch_building(this.value);">
														<option value="0">Select Campus<option/>
														<?php while($row_campus_view = mysqli_fetch_array($result_campus_view)): ?>
														<option value="<?=$row_campus_view['campus_id']?>"><?=$row_campus_view['campus_description']?></option>
														<?php endwhile; ?>
													</select>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="building_name">Building Name <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
													<select class="form-control" id="building_name" name="building_name" onclick="fetch_floor(this.value);" onchange="fetch_floor(this.value);">
														<option value="0">Select Building<option/>
													</select>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="floor_name">Floor Name <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
													<select class="form-control" id="floor_name" name="floor_name">
														<option value="0">Select Floor<option/>
													</select>
                        </div>
                      </div>
                      <div class="ln_solid"></div>
                      <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
													<a class="btn btn-warning" href="area_view.php" type="button">Cancel</a>
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
<script>
	function fetch_building(val){
		$.ajax({
			type: 'post',
			url: 'include/fetch_building.php',
			data: {get_building:val},
			success: function(response){
				document.getElementById("building_name").innerHTML = response;
			}
		});
	}

	function fetch_floor(val){
		$.ajax({
			type: 'post',
			url: 'include/fetch_floor.php',
			data: {get_floor:val},
			success: function(response){
				document.getElementById("floor_name").innerHTML = response;
			}
		});
	}
</script>
