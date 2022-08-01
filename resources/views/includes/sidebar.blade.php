<!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
      <img src="{{ asset ("/../dist/img/AdminLTELogo.png") }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">Admin</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{ asset ("/../dist/img/user2-160x160.jpg") }}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">Alexander Pierce</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
          <a href="/dashboard" class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p> Dashboard </p>
            </a>
          </li>

          <li class="nav-item">
                <a href="/mentor" class="nav-link {{ request()->is('mentor') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Mentor</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="/mentee" class="nav-link {{ request()->is('mentee') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Mentee</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="/leaderboard" class="nav-link {{ request()->is('leaderboard') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Leaderboard</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/top-question" class="nav-link {{ request()->is('top-question') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Top Questions</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/ask-question" class="nav-link {{ request()->is('ask-question') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Ask A Question</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/postmanagement" class="nav-link {{ request()->is('postmanagement') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Job Post</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/user/post" class="nav-link {{ request()->is('user/post') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Post</p>
                </a>
              </li>
         
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Control Sidebar -->
  <!-- <aside class="control-sidebar control-sidebar-dark">
    Control sidebar content goes here
  </aside> -->
  <!-- /.control-sidebar -->