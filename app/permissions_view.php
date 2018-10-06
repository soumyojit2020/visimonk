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
              <div class="title_left">
                <h3>Permissions</h3>
              </div>
              <div class="title_right">
                <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right">
                  <div class="input-group">
                    <a href="new_permissions_view.php"><button class="btn btn-primary" type="button">Add New</button></a>
                  </div>
                </div>
              </div>
            </div>
            <div class="clearfix"></div>
            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_content">
                      <!--table start-->
                      <div class="table-responsive">
                        <table class="table table-striped">
                          <thead>
                            <tr>
                              <th>Name</th>
                              <th>Action</th>
                            </tr>
                          <thead>
                          <tbody>
                            <tr>
                              <td>Users</td>
                              <td>
                                <a class="btn btn-dark btn-xs">Edit</a>
                                <a class="btn btn-danger btn-xs">Deactivate</a>
                              </td>
                            </tr>
                            <tr>
                              <td>Roles</td>
                              <td>
                                <a class="btn btn-dark btn-xs">Edit</a>
                                <a class="btn btn-danger btn-xs">Deactivate</a>
                              </td>
                            </tr>
                            <tr>
                              <td>Permissions</td>
                              <td>
                                <a class="btn btn-dark btn-xs">Edit</a>
                                <a class="btn btn-danger btn-xs">Deactivate</a>
                              </td>
                            </tr>
                            <tr>
                              <td>Campus</td>
                              <td>
                                <a class="btn btn-dark btn-xs">Edit</a>
                                <a class="btn btn-danger btn-xs">Deactivate</a>
                              </td>
                            </tr>
                            <tr>
                              <td>Building</td>
                              <td>
                                <a class="btn btn-dark btn-xs">Edit</a>
                                <a class="btn btn-danger btn-xs">Deactivate</a>
                              </td>
                            </tr>
                            <tr>
                              <td>Floor</td>
                              <td>
                                <a class="btn btn-dark btn-xs">Edit</a>
                                <a class="btn btn-danger btn-xs">Deactivate</a>
                              </td>
                            </tr>
                            <tr>
                              <td>Area</td>
                              <td>
                                <a class="btn btn-dark btn-xs">Edit</a>
                                <a class="btn btn-danger btn-xs">Deactivate</a>
                              </td>
                            </tr>
                            <tr>
                              <td>Port</td>
                              <td>
                                <a class="btn btn-dark btn-xs">Edit</a>
                                <a class="btn btn-danger btn-xs">Deactivate</a>
                              </td>
                            </tr>
                            <tr>
                              <td>Forms</td>
                              <td>
                                <a class="btn btn-dark btn-xs">Edit</a>
                                <a class="btn btn-danger btn-xs">Deactivate</a>
                              </td>
                            </tr>
                            <tr>
                              <td>HQ</td>
                              <td>
                                <a class="btn btn-dark btn-xs">Edit</a>
                                <a class="btn btn-danger btn-xs">Deactivate</a>
                              </td>
                            </tr>
                            <tr>
                              <td>Logo</td>
                              <td>
                                <a class="btn btn-dark btn-xs">Edit</a>
                                <a class="btn btn-danger btn-xs">Deactivate</a>
                              </td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                      <!--table end-->
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
