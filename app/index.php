<?php
	include 'include/head.php';
	require_once 'include/dbConfig.php';
	checkLogin();

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
            <div class="clearfix"></div>
            <div class="row">
              <div class="col-md-12">
                <div class="">
                  <div class="x_content">

                    <br />
                    <div class="row">
											<div class="col-md-6 col-sm-6 col-xs-12">
					              <div class="x_panel tile">
													<ul class="list-inline">
                            <li>
															<a href="form_edit_view.php">
                              	<img src="images/visitor_in.png" alt="..." class="img-circle profile_img">
															</a>
                            </li>
														<li>
															<a href="form_edit_view.php">
                              	<h1>In</h1>
															<p>Use this module for visitor entry.</p>
                            </li>
														</a>
                          </ul>
					              </div>
					            </div>
											<div class="col-md-6 col-sm-6 col-xs-12">
					              <div class="x_panel tile">
													<ul class="list-inline">
                            <li>
															<a href="exit_visitor.php">
                              	<img src="images/visitor_out.png" alt="..." class="img-circle profile_img">
															</a>
                            </li>
														<li>
															<a href="exit_visitor.php">
                              	<h1>Out</h1>
																<p>Use this module for visitor exit.</p>
															</a>
                            </li>
                          </ul>
					              </div>
					            </div>
											<div class="col-md-6 col-sm-6 col-xs-12">
					              <div class="x_panel tile">
													<ul class="list-inline">
                            <li>
															<a href="schedule_view.php">
                              	<img src="images/schedule.png" alt="..." class="img-circle profile_img">
															</a>
                            </li>
														<li>
															<a href="schedule_view.php">
                              	<h1>Schedule</h1>
																<p>Schedule visits in advance.</p>
															</a>
                            </li>
                          </ul>
					              </div>
					            </div>
											<div class="col-md-6 col-sm-6 col-xs-12">
					              <div class="x_panel tile">
													<ul class="list-inline">
                            <li>
															<a href="visitor_view.php">
                              	<img src="images/visitor.png" alt="..." class="img-circle profile_img">
															</a>
                            </li>
														<li>
															<a href="visitor_view.php">
                              	<h1>Visitors</h1>
																<p>See all visitors.</p>
															</a>
                            </li>
                          </ul>
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
