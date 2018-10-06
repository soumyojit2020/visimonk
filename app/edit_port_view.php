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

  //get processing start
  if(isset($_GET) && !empty($_GET)){
    $port_id = clean($_GET['port_id']);
    $area_id = clean($_GET['area_id']);
    $floor_id = clean($_GET['floor_id']);
    $building_id = clean($_GET['building_id']);
    $campus_id = clean($_GET['campus_id']);

    $sql_port_view = "SELECT p.port_id, p.port_description, p.area_id, a.area_description, p.floor_id, f.floor_description,
  										p.building_id, b.building_description, p.campus_id, c.campus_description, p.account_id
  										FROM port p LEFT JOIN area a
  										ON p.area_id = a.area_id
  										LEFT JOIN floor f
  										ON a.floor_id = f.floor_id
  										LEFT JOIN building b
  										ON f.building_id = b.building_id
  										LEFT JOIN campus c
  										ON b.campus_id = c.campus_id
  										WHERE p.port_id=? AND p.area_id=? AND p.floor_id=? AND p.building_id=? AND p.campus_id=? AND p.account_id=?";


      if($stmt_port_view = mysqli_prepare($conn, $sql_port_view)){
        mysqli_stmt_bind_param($stmt_port_view,"ssssss", $param_port_id, $param_area_id, $param_floor_id, $param_building_id, $param_campus_id, $param_account_id);
        $param_port_id = $port_id;
        $param_area_id = $area_id;
        $param_floor_id = $floor_id;
        $param_building_id = $building_id;
        $param_campus_id = $campus_id;
        $param_account_id = $accountId;
        if(mysqli_stmt_execute($stmt_port_view)){
          $result_port_view = mysqli_stmt_get_result($stmt_port_view);
          $row_port_search = mysqli_fetch_array($result_port_view, MYSQLI_ASSOC);
        }
      }
  }
  //get processing stop

	if(isset($_POST) && !empty($_POST)){
		$port_name = clean($_POST['port_name']);
		$area_id = clean($_POST['area_name']);
		$campus_id = clean($_POST['campus_name']);
		$building_id = clean($_POST['building_name']);
		$floor_id = clean($_POST['floor_name']);
    $port_id = clean($_POST['port_id']);

		$errors = array();

		if(empty($port_name)){
			$errors[] .= "Port Name cannot be blank!";
		}

		if(empty($area_id)){
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

		$sql_port_search = "SELECT port_description FROM port WHERE port_description=? AND area_id=? AND account_id=? AND port_id!=?";
		if($stmt_port_search = mysqli_prepare($conn, $sql_port_search)){
			mysqli_stmt_bind_param($stmt_port_search,"ssss",$param_port_description, $param_area_id, $param_account_id, $param_port_id);
			$param_port_description = $port_name;
			$param_area_id = $area_id;
			$param_account_id = $accountId;
      $param_port_id = $port_id;
			if(mysqli_stmt_execute($stmt_port_search)){
				$result_port_search = mysqli_stmt_get_result($stmt_port_search);
				if(mysqli_num_rows($result_port_search) == 1){
					$errors[] .= $port_name. " already exists!";
				}
			}
		}

		if(empty($errors)){
			$sql_port_update = "UPDATE port SET port_description='$port_name', campus_id=$campus_id, building_id=$building_id, floor_id=$floor_id, area_id=$area_id, account_id='$accountId' WHERE port_id = $port_id";
			$query1 = mysqli_query($conn,$sql_port_update);
			header('location: port_view.php');
		}

	}//POST
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
                <h3>Edit Port</h3>
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
                      <form data-parsley-validate class="form-horizontal form-label-left" action="edit_port_view.php" method="POST">
                        <input type="hidden" name="port_id" value="<?=$row_port_search['port_id']?>"/>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="port_name">Port Name <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" id="port_name" name="port_name" required="required" class="form-control col-md-7 col-xs-12" value="<?=(isset($_POST['port_name']))?$port_name:$row_port_search['port_description']?>">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="campus-name">Campus Name <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
													<select class="form-control" id="campus_name" name="campus_name" onclick="fetch_building(this.value);">
														<?php while($row_campus_view = mysqli_fetch_array($result_campus_view)): ?>
														<option <?=($campus_id == $row_campus_view['campus_id'])?'selected':''?> value="<?=$row_campus_view['campus_id']?>"><?=$row_campus_view['campus_description']?></option>
														<?php endwhile; ?>
													</select>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="building-name">Building Name <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
													<select class="form-control" id="building_name" name="building_name" onclick="fetch_floor(this.value);">
														<option value="<?=$row_port_search['building_id']?>"><?=$row_port_search['building_description']?><option/>
													</select>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="floor-name">Floor Name <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
													<select class="form-control" id="floor_name" name="floor_name" onclick="fetch_area(this.value);">
														<option value="<?=$row_port_search['floor_id']?>"><?=$row_port_search['floor_description']?><option/>
													</select>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="area-name">Area Name <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
													<select class="form-control" id="area_name" name="area_name">
														<option value="<?=$row_port_search['area_id']?>"><?=$row_port_search['area_description']?><option/>
													</select>
                        </div>
                      </div>
                      <div class="ln_solid"></div>
                      <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                          <a class="btn btn-warning" href="port_view.php" type="button">Cancel</a>
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

	function fetch_area(val){
		$.ajax({
			type: 'post',
			url: 'include/fetch_area.php',
			data: {get_area:val},
			success: function(response){
				document.getElementById("area_name").innerHTML = response;
			}
		});
	}
</script>
