<?php
  require_once 'dbConfig.php';
  //checkLogin();
?>

<!-- sidebar menu -->
            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
              <div class="menu_section">
                <ul class="nav side-menu">
                  <li><a href="index.php"><i class="fa fa-tag"></i> Home</a>
                  </li>
                </ul>
              </div>
              <div class="menu_section">
                <ul class="nav side-menu">
                <?php if(in_array("campus_read", $permission) || in_array("building_read", $permission) || in_array("floor_read", $permission) || in_array("area_read", $permission) || in_array("port_read", $permission)): ?>
                <li><a><i class="fa fa-home"></i> Location <span class="fa fa-chevron-down"></span></a>
                  <ul class="nav child_menu">
                    <?php
                    if(in_array("campus_read",$permission)){
                      echo '<li><a href="campus_view.php">Campus</a></li>';
                    }
                    if(in_array("building_read",$permission)){
                      echo '<li><a href="building_view.php">Building</a></li>';
                    }
                    if(in_array("floor_read",$permission)){
                      echo '<li><a href="floor_view.php">Floor</a></li>';
                    }
                    if(in_array("area_read",$permission)){
                      echo '<li><a href="area_view.php">Area</a></li>';
                    }
                    if(in_array("port_read",$permission)){
                      echo '<li><a href="port_view.php">Port</a></li>';
                    }
                    ?>
                  </ul>
                </li>
                <?php endif; ?>
                  <?php if(in_array("user_read", $permission) || in_array("roles_read", $permission)): ?>
                  <li><a><i class="fa fa-users"></i> Users <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <?php if(in_array("user_read",$permission)){
                        echo '<li><a href="users_view.php">Users</a></li>';
                      }
                      if(in_array("roles_read",$permission)){
                        echo '<li><a href="roles_view.php">Roles</a></li>';
                      }
                      ?>
                    </ul>
                  </li>
                  <?php endif; ?>
                  <?php if(in_array("forms_create", $permission) || in_array("forms_read", $permission)): ?>
                  <li><a><i class="fa fa-building"></i> Forms <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <?php
                      if(in_array("forms_create",$permission)){
                        echo '<li><a href="new_form_view.php">Create New</a></li>';
                      }
                      if(in_array("forms_read",$permission)){
                        echo '<li><a href="form_edit_view.php">View/Edit</a></li>';
                      }
                      ?>
                    </ul>
                  </li>
                  <?php endif; ?>
                  <?php if(in_array("hq_create", $permission) || in_array("logo_create", $permission)): ?>
                  <li><a><i class="fa fa-black-tie"></i> Brand <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <?php
                      if(in_array("hq_create",$permission)){
                        echo '<li><a href="hq_view.php">HQ</a></li>';
                      }
                      if(in_array("logo_create",$permission)){
                        echo '<li><a href="logo_view.php">Logo</a></li>';
                      }
                      ?>
                    </ul>
                  </li>
                  <?php endif; ?>
                  <li><a><i class="fa fa-user-secret"></i> Visitors <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="visitor_view.php">Visitors</a></li>
                    </ul>
                  </li>
                  <li><a href="javascript:void(0)"><i class="fa fa-laptop"></i> Reporting <span class="label label-success pull-right">Coming Soon</span></a></li>
                </ul>
              </div>


            </div>
            <!-- /sidebar menu -->

            <!-- /menu footer buttons
            <div class="sidebar-footer hidden-small">
              <a data-toggle="tooltip" data-placement="top" title="Settings">
                <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="FullScreen">
                <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="Lock">
                <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="Logout" href="login.html">
                <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
              </a>
            </div>
            <!-- /menu footer buttons -->
