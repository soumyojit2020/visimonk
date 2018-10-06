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

  if(isset($_GET) && !empty($_GET)){
    $building_id = clean($_GET['building_id']);
    $campus_id = clean($_GET['campus_id']);


    $sql_search_building = "SELECT b.building_id, b.building_description, b.campus_id, b.account_id, c.campus_description
                            FROM building b JOIN campus c
                            ON b.campus_id = c.campus_id
                            WHERE b.building_id=? AND b.campus_id=? AND b.account_id=?";
    if($stmt_search_building = mysqli_prepare($conn, $sql_search_building)){
      mysqli_stmt_bind_param($stmt_search_building, "sss", $param_building_id, $param_campus_id, $param_account_id);
      $param_building_id = $building_id;
      $param_campus_id = $campus_id;
      $param_account_id = $accountId;
      if(mysqli_stmt_execute($stmt_search_building)){
        $result_search_building = mysqli_stmt_get_result($stmt_search_building);
        if(mysqli_num_rows($result_search_building) == 1){
          $row_search_building = mysqli_fetch_array($result_search_building, MYSQLI_ASSOC);
        }
      }
    }

  }//GET

  if(isset($_POST) && !empty($_POST)){
    $errors = array();
    $building_id = clean($_POST['building_id']);
    $building_name = clean($_POST['building_name']);
    $campus_id = clean($_POST['campus_name']);

    if(empty($building_name)){
      $errors[] .= 'Please fill in Building Name.';
    }

    if(empty($building_id)){
      $error[] .= 'Please select a Campus.';
    }

    $sql_building_search = "SELECT building_description FROM building WHERE account_id=? AND campus_id=? AND building_description=? AND building_id!=?";
		if($stmt_building_search = mysqli_prepare($conn, $sql_building_search)){
			mysqli_stmt_bind_param($stmt_building_search, "ssss", $param_account_id, $param_campus_id, $param_building_description, $param_building_id);
			$param_account_id = $accountId;
			$param_campus_id = $campus_id;
			$param_building_description = $building_name;
      $param_building_id = $building_id;
			if(mysqli_stmt_execute($stmt_building_search)){
				$result_building_search = mysqli_stmt_get_result($stmt_building_search);
				if(mysqli_num_rows($result_building_search) == 1){
					$errors[] .= $building_name .' already exists!';
				}
			}
		}

    if(empty($errors)){
      $sql_update_building = "UPDATE building SET building_description='$building_name', campus_id=$campus_id, account_id='$accountId' WHERE building_id=$building_id ";
      $query1 = mysqli_query($conn, $sql_update_building);
      header("location: building_view.php");
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
                <h3>Edit Building</h3>
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
                      <form data-parsley-validate class="form-horizontal form-label-left" action="edit_building_view.php" method="POST">
                        <input type="hidden" name="building_id" value="<?=$row_search_building['building_id']?>"/>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="building-name">Building Name <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" id="building-name" name="building_name" required="required" class="form-control col-md-7 col-xs-12" value="<?=(isset($_POST['building_name']))?$building_name:$row_search_building['building_description']?>"/>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="campus-name">Campus Name <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
													<select class="form-control" name="campus_name">
                              <?php while($row_campus_view = mysqli_fetch_array($result_campus_view)): ?>
  														<option <?=($campus_id == $row_campus_view['campus_id'])?'selected':''?> value="<?=$row_campus_view['campus_id']?>"><?=$row_campus_view['campus_description']?></option>
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
