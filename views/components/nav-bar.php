<nav class="navbar navbar-expand navbar-light navbar-bg">
  <a class="sidebar-toggle js-sidebar-toggle">
    <i class="hamburger align-self-center"></i>
  </a>

  <div class="navbar-collapse collapse">
    <ul class="navbar-nav navbar-align">

      <li class="nav-item dropdown">
        <a class="nav-icon dropdown-toggle d-inline-block d-sm-none" href="#" data-bs-toggle="dropdown">
          <i class="align-middle" data-feather="settings"></i>
        </a>

        <a class="nav-link dropdown-toggle d-none d-sm-inline-block" href="#" data-bs-toggle="dropdown">
          <img src="<?= $helpers->get_avatar_link($USER->id) ?>" class=" avatar img-fluid rounded me-1" />
          <span class="text-dark">
            <?= $helpers->get_full_name($USER->id) ?>
          </span>
        </a>

        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownMenuLink">
          <a class="dropdown-item" href="<?= SERVER_NAME . "/views/profile?id=$USER->id" ?>">
            <i class="align-middle me-1" data-feather="user"></i>
            Profile
          </a>
          <a class="dropdown-item" href="<?= SERVER_NAME . "/views/change-password" ?>">
            <i class="align-middle me-1" data-feather="shield"></i>
            Change Password
          </a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="<?= SERVER_NAME . "/backend/nodes?action=logout" ?>">
            <i class="align-middle me-1" data-feather="log-out"></i>
            Log out</a>
        </div>
      </li>
    </ul>
  </div>
</nav>