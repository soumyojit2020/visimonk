<?php
	include 'include/head.php';
	require_once 'include/dbConfig.php';
	checkLogin();

  if(isset($_GET['campus_id']) && !empty($_GET['campus_id'])){
    $campus_id = clean($_GET['campus_id']);
    $sql_campus_search = "SELECT campus_id, campus_description FROM campus WHERE campus_id=? AND account_id=?";
    if($stmt_campus_search = mysqli_prepare($conn, $sql_campus_search)){
      mysqli_stmt_bind_param($stmt_campus_search, "ss", $param_campus_id, $param_account_id);
      $param_campus_id = $campus_id;
      $param_account_id = $accountId;
      if(mysqli_stmt_execute($stmt_campus_search)){
        $result_campus_search = mysqli_stmt_get_result($stmt_campus_search);
        if(mysqli_num_rows($result_campus_search) == 1){
          $row_campus_search = mysqli_fetch_array($result_campus_search, MYSQLI_ASSOC);
          $campus_name = $row_campus_search['campus_description'];
        }
      }
    }
  }//GET

  if(isset($_POST) && !empty($_POST)){
    $errors = array();

    $campus_id = clean($_POST['campus_id']);
    $campus_name = clean($_POST['campus_name']);

    if(empty($campus_name)){
			$errors[] .= 'Please enter a campus name';
		}

    $sql_campus = "SELECT campus_description FROM campus WHERE account_id = ? AND campus_description = ? AND campus_id != ?";
		if($stmt_campus = mysqli_prepare($conn, $sql_campus)){
			mysqli_stmt_bind_param($stmt_campus, "sss", $param_account_id, $param_campus_description, $param_campus_id);
			$param_account_id = $accountId;
			$param_campus_description = $campus_name;
      $param_campus_id = $campus_id;
			if(mysqli_stmt_execute($stmt_campus)){
				$result_campus = mysqli_stmt_get_result($stmt_campus);
				if(mysqli_num_rows($result_campus) == 1){
					$errors[] .= $campus_name. ' already exists';
				}
			}
		}

    if(empty($errors)){
			$sql_update_campus = "UPDATE campus SET campus_description='$campus_name' WHERE campus_id=$campus_id";
			$query1 = mysqli_query($conn, $sql_update_campus);
			header("location: campus_view.php");
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
                <h3>Edit Campus</h3>
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
                      <form data-parsley-validate class="form-horizontal form-label-left" action="edit_campus_view.php" method="POST">
                        <input type="hidden" name="campus_id" value="<?=$campus_id?>"/>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="campus-name">Campus Name <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" id="campus-name" name="campus_name" required="required" class="form-control col-md-7 col-xs-12" value="<?=$campus_name?>" />
                        </div>
                      </div>
                      <div class="ln_solid"></div>
                      <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                          <a class="btn btn-warning" type="button" href="campus_view.php">Back</a>
                          <button type="submit" class="btn btn-success">Save</button>
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
