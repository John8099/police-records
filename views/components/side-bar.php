<nav id="sidebar" class="sidebar js-sidebar">
  <div class="sidebar-content js-simplebar">
    <a class="sidebar-brand" href="index.html">
      <span class="align-middle">Police Records</span>
    </a>
    <ul class="sidebar-nav">
      <?php
      $get_sidebar_data = $helpers->side_bar_data($USER->role);

      foreach ($get_sidebar_data as $menu) :
        $menu = (object)$menu;
        $config = (object)$menu->config;
      ?>
        <li class="sidebar-item <?= $helpers->is_active_menu($config->url, $_SERVER["PHP_SELF"]) ?>">
          <a href="<?= $config->url ?>" class="sidebar-link">
            <i class="align-middle" data-feather="<?= $config->icon ?>"></i>
            <span class="align-middle"><?= $menu->title ?></span>
          </a>
        </li>
      <?php endforeach; ?>
    </ul>
  </div>
</nav>