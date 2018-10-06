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

  //form processing GET
  if(isset($_GET) && !empty($_GET)){
    $floor_id = clean($_GET['floor_id']);
		$campus_id = clean($_GET['campus_id']);
		$building_id = clean($_GET['building_id']);

    $sql_floor_view = "SELECT f.floor_id, f.floor_description, f.building_id, b.building_description, f.campus_id, c.campus_description, f.account_id
  											FROM floor f LEFT JOIN building b
  											ON f.building_id = b.building_id
  											LEFT JOIN campus c
  											ON f.campus_id = c.campus_id
  											WHERE f.floor_id=? AND f.building_id=? AND f.campus_id=? AND f.account_id = ?";
    if($stmt_floor_view = mysqli_prepare($conn, $sql_floor_view)){
      mysqli_stmt_bind_param($stmt_floor_view, "ssss", $param_floor_id, $param_building_id, $param_campus_id, $param_account_id);
      $param_floor_id = $floor_id;
      $param_building_id = $building_id;
      $param_campus_id = $campus_id;
      $param_account_id = $accountId;
      if(mysqli_stmt_execute($stmt_floor_view)){
        $result_floor_view = mysqli_stmt_get_result($stmt_floor_view);
        if(mysqli_num_rows($result_floor_view) == 1){
          $row_floor_view = mysqli_fetch_array($result_floor_view, MYSQLI_ASSOC);
        }
      }
    }
  }
  //form processing GET

	//form processing POST
	if(isset($_POST) && !empty($_POST)){
    $floor_id = clean($_POST['floor_id']);
		$floor_name = clean($_POST['floor_name']);
		$campus_id = clean($_POST['campus_name']);
		$building_id = clean($_POST['building_name']);

		$errors = array();
		if(empty($floor_name)){
			$errors[] .= 'Please enter a floor name';
		}
		if(empty($campus_id)){
			$errors[] .= 'Please enter a campus name';
		}
		if(empty($building_id)){
			$errors[] .= 'Please enter a building name';
		}

		$sql_floor_search = "SELECT floor_description FROM floor WHERE floor_description=? AND building_id=? AND account_id=? AND floor_id!=?";
		if($stmt_floor_search = mysqli_prepare($conn,$sql_floor_search)){
			mysqli_stmt_bind_param($stmt_floor_search,"ssss", $param_floor_description, $param_building_id, $param_account_id, $param_floor_id);
			$param_floor_description = $floor_name;
			$param_building_id = $building_id;
			$param_account_id = $accountId;
      $param_floor_id = $floor_id;
			if(mysqli_stmt_execute($stmt_floor_search)){
				$result_floor_search = mysqli_stmt_get_result($stmt_floor_search);
				if(mysqli_num_rows($result_floor_search) == 1){
					$errors[] .= $floor_name.' already exists!';
				}
			}
		}

		if(empty($errors)){
			$sql_update_floor = "UPDATE floor SET floor_description='$floor_name', building_id = $building_id, campus_id = $campus_id, account_id = '$accountId' WHERE floor_id = $floor_id";
			$query1 = mysqli_query($conn, $sql_update_floor);
			header("location: floor_view.php");
		}

	}//form processing POST

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
                <h3>Edit Floor</h3>
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
                      <form data-parsley-validate class="form-horizontal form-label-left" action = "edit_floor_view.php" method="POST">
                        <input type="hidden" name="floor_id" value="<?=$row_floor_view['floor_id']?>"/>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="floor_name">Floor Name <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" name="floor_name" id="floor_name" required="required" class="form-control col-md-7 col-xs-12" value="<?=(isset($_POST['floor_name']))?$floor_name:$row_floor_view['floor_description']?>">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="campus_name">Campus Name <span class="required">*</span>
                        </label>
												<div class="col-md-6 col-sm-6 col-xs-12">
													<select class="form-control" id="campus_name" name="campus_name" onchange="fetch_building(this.value);" onclick="fetch_building(this.value);">

														<?php while($row_campus_view = mysqli_fetch_array($result_campus_view)): ?>
														<option <?=($campus_id == $row_campus_view['campus_id'])?'selected':''?> value="<?=$row_campus_view['campus_id']?>"><?=$row_campus_view['campus_description']?></option>
														<?php endwhile; ?>
													</select>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="building_name">Building Name <span class="required">*</span>
                        </label>
												<div class="col-md-6 col-sm-6 col-xs-12">
													<select class="form-control" id="building_name" name="building_name">
														<option value="<?=$row_floor_view['building_id']?>"><?=$row_floor_view['building_description']?><option/>
													</select>
                        </div>
                      </div>
                      <div class="ln_solid"></div>
                      <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                          <a class="btn btn-warning" href="floor_view.php" type="button">Cancel</a>
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
</script>
