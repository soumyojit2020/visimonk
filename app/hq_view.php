<?php
	include 'include/head.php';
	require_once 'include/dbConfig.php';
	checkLogin();
	$errors = array();
	$address_line_1 = '';
	$address_line_2 = '';
	$city = '';
	$state = '';
	$country = '';
	$pin_code = '';
	$email = '';
	$phone = '';

	$sql_hq = "SELECT * FROM hq WHERE account_id=?";
	if($stmt_hq = mysqli_prepare($conn, $sql_hq)){
		mysqli_stmt_bind_param($stmt_hq, "s", $param_account_id);
		$param_account_id = $accountId;
		if(mysqli_stmt_execute($stmt_hq)){
			$result_hq = mysqli_stmt_get_result($stmt_hq);
			$row_hq = mysqli_fetch_array($result_hq, MYSQLI_ASSOC);
			$address_line_1 = $row_hq['address_line_1'];
			$address_line_2 = $row_hq['address_line_2'];
			$city = $row_hq['city'];
			$state = $row_hq['state'];
			$country = $row_hq['country'];
			$pin_code = $row_hq['pin_code'];
			$email = $row_hq['email'];
			$phone = $row_hq['phone'];
		}
	}

	if(isset($_POST) && !empty($_POST)){
		$address_line_1 = clean($_POST['address_line_1']);
		$address_line_2 = clean($_POST['address_line_2']);
		$city = clean($_POST['city']);
		$state = clean($_POST['state']);
		$country = clean($_POST['country']);
		$pin_code = clean($_POST['pin_code']);
		$email = clean($_POST['email']);
		$phone = clean($_POST['phone']);

		$sql_hq = "UPDATE `hq` SET `address_line_1`='$address_line_1',
								`address_line_2`='$address_line_2',
								`city`='$city',
								`state`='$state',
								`country`='$country',
								`pin_code`=$pin_code,
								`email`='$email',
								`phone`='$phone'
								 WHERE account_id=?";
			if($stmt_hq = mysqli_prepare($conn, $sql_hq)){
				mysqli_stmt_bind_param($stmt_hq, "s", $param_account_id);
				$param_account_id = $accountId;
				if(mysqli_stmt_execute($stmt_hq)){
					$result_hq_update = mysqli_stmt_get_result($stmt_hq);
					header('location: index.php');
				}
			}
		}//post

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
                <h3>HQ/Registered Address</h3>
              </div>
            </div>
            <div class="clearfix"></div>
            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_content">
                      <!--form start-->
                      <form data-parsley-validate class="form-horizontal form-label-left" action="hq_view.php" method="POST">
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="line1">Address Line1 <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" id="line1" required="required" class="form-control col-md-7 col-xs-12" <?=(!in_array("hq_update",$permission))?'disabled':'';?> name="address_line_1" value="<?=$address_line_1;?>"/>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="line2">Line2
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" id="line2" class="form-control col-md-7 col-xs-12" <?=(!in_array("hq_update",$permission))?'disabled':'';?> name="address_line_2" value="<?=$address_line_2;?>"/>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="city">City <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" id="city" required="required" class="form-control col-md-7 col-xs-12" <?=(!in_array("hq_update",$permission))?'disabled':'';?> name="city" value="<?=$city;?>"/>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="state">State <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" id="state" required="required" class="form-control col-md-7 col-xs-12" <?=(!in_array("hq_update",$permission))?'disabled':'';?> name="state" value="<?=$state;?>"/>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="country">Country <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" id="country" required="required" class="form-control col-md-7 col-xs-12" <?=(!in_array("hq_update",$permission))?'disabled':'';?> name="country" value="<?=$country;?>"/>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="pincode">Pin Code <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" id="pincode" required="required" class="form-control col-md-7 col-xs-12" <?=(!in_array("hq_update",$permission))?'disabled':'';?> name="pin_code" value="<?=$pin_code;?>"/>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Email
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="email" id="email"  class="form-control col-md-7 col-xs-12" <?=(!in_array("hq_update",$permission))?'disabled':'';?> name="email" value="<?=$email;?>"/>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="phone">Phone
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" id="phone" class="form-control col-md-7 col-xs-12" <?=(!in_array("hq_update",$permission))?'disabled':'';?> name="phone" value="<?=$phone;?>"/>
                        </div>
                      </div>
                      <div class="ln_solid"></div>
                      <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                          <a href="index.php" class="btn btn-warning" type="button">Cancel</a>
                          <?php if(in_array("hq_update", $permission)):?><button type="submit" class="btn btn-success">Submit</button><?php endif;?>
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
