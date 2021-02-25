   <!-- Sidebar menu-->
    <div class="app-sidebar__overlay" data-toggle="sidebar"></div>
    <aside class="app-sidebar">
      <div class="app-sidebar__user">
        <img class="app-sidebar__user-avatar" src="<?= media();?>/images/avatar.png"  width="65" height="50" alt="User Image">
        <div>
          <p class="app-sidebar__user-name"><?= $_SESSION['userData']['nombreusu']; ?></p>
          <p class="app-sidebar__user-designation"><?= $_SESSION['userData']['nombre']; ?></p>
        </div>
      </div>
      <ul class="app-menu">
        <?php if(!empty($_SESSION['permisos'][1]['r'])){ ?>
        <li>
          <a class="app-menu__item" href="<?= base_url(); ?>/dashboard">
            <i class="app-menu__icon fa fa-dashboard"></i>
            <span class="app-menu__label">Dashboard</span>
          </a>
        </li>
        <?php } ?>

        <?php if(!empty($_SESSION['permisos'][2]['r'])){ ?>
        <li>
          <a class="app-menu__item" href="<?= base_url(); ?>/usuarios">
             <i class="app-menu__icon fa fa-users" aria-hidden="true"></i>
            <span class="app-menu__label">Usuarios</span>
          </a>
        </li>
        <?php } ?>

        <?php if(!empty($_SESSION['permisos'][3]['r'])){ ?>
        <li>
          <a class="app-menu__item" href="<?= base_url(); ?>/roles">
            <i class="app-menu__icon fa fa-handshake-o" aria-hidden="true"></i>
            <span class="app-menu__label">Roles</span>
          </a>
        </li>
        <?php } ?>
        <?php if(!empty($_SESSION['permisos'][4]['r'])){ ?>
        <li>
          <a class="app-menu__item" href="<?= base_url(); ?>/clientes">
            <i class="app-menu__icon fa fa-user" aria-hidden="true"></i>
            <span class="app-menu__label">Clientes</span>
          </a>
        </li>
        <?php } ?>
        <?php if(!empty($_SESSION['permisos'][7]['r'])){ ?>
        <li>
          <a class="app-menu__item" href="<?= base_url(); ?>/cotizacion">
            <i class="app-menu__icon fa fa-server" aria-hidden="true"></i>
            <span class="app-menu__label">Cotizacion</span>
          </a>
        </li>
        <?php } ?>
         <?php if(!empty($_SESSION['permisos'][6]['r']) || !empty($_SESSION['permisos'][5]['r'])){ ?>
        <li class="treeview">
          <a class="app-menu__item" href="#" data-toggle="treeview">
            <i class="app-menu__icon fa fa-archive" aria-hidden="true"></i>
            <span class="app-menu__label">Servicios</span>
            <i class="treeview-indicator fa fa-angle-right"></i>
          </a>
          <ul class="treeview-menu">
            <?php if(!empty($_SESSION['permisos'][6]['r'])){ ?>
            <li>
              <a class="treeview-item" href="<?= base_url(); ?>/servicios">
                <i class="icon fa fa-circle-o"></i>Servicios</a>
            </li>
            <?php } ?>
            <?php if(!empty($_SESSION['permisos'][5]['r'])){ ?>
            <li>
              <a class="treeview-item" href="<?= base_url(); ?>/categorias">
                <i class="icon fa fa-circle-o"></i>Categorias</a>
            </li>
            <?php } ?>
          </ul>
        </li>
        <?php } ?>
        <li>
          <a class="app-menu__item" href="<?= base_url(); ?>/logout">
            <i class="app-menu__icon fa fa-sign-in" aria-hidden="true"></i>
            <span class="app-menu__label">Logout</span>
          </a>
        </li>
      </ul>
    </aside>