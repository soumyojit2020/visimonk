<?php
	include 'include/head.php';
	require_once 'include/dbConfig.php';
	checkLogin();

  if(isset($_GET) & !empty($_GET)){
    $form_id = clean($_GET['fd']);
		$location_level = clean($_GET['ll']);
		$location_id = clean($_GET['ld']);
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
                <h3>Success</h3>
              </div>
            </div>
            <div class="clearfix"></div>
            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Registered Succesfully!</h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                      You have been succesfully registered. Click on NEXT to register another visitor.
                      <div class="clearfix"></div><br>
                      <a href="form_location.php?fd=<?=$form_id;?>&ll=<?=$location_level;?>&ld=<?=$location_id?>" class="btn btn-success">NEXT</a>
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
