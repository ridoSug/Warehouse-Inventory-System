  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <!-- Brand Logo -->
      <a href="index3.html" class="brand-link">
          <img src="<?= base_url('assets/') ?>dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
          <span class="brand-text font-weight-light">AdminLTE 3</span>
      </a>

      <!-- Sidebar -->
      <div class="sidebar">
          <!-- Sidebar user panel (optional) -->
          <div class="user-panel mt-3 pb-3 mb-3 d-flex">
              <div class="image">
                  <img src="<?= base_url('assets/') ?>dist/img/avatar5.png" class="img-circle elevation-2" alt="User Image">
              </div>
              <div class="info">
                  <a href="#" class="d-block"><?= $this->session->userdata('wh_name'); ?></a>
              </div>
          </div>

          <!-- Sidebar Menu -->
          <nav class="mt-2">
              <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                  <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                  <!-- <li class="nav-item has-treeview menu-open">
                      <a href="#" class="nav-link active">
                          <i class="nav-icon fas fa-tachometer-alt"></i>
                          <p>
                              Dashboard
                              <i class="right fas fa-angle-left"></i>
                          </p>
                      </a>
                      <ul class="nav nav-treeview">
                          <li class="nav-item">
                              <a href="./index.html" class="nav-link active">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Dashboard v1</p>
                              </a>
                          </li>
                      </ul>
                  </li> -->

                  <li class="nav-item has-treeview">
                      <a href="#" class="nav-link">
                          <i class="nav-icon fas fa-copy"></i>
                          <p>
                              Master Data
                              <i class="right fas fa-angle-left"></i>
                          </p>
                      </a>
                      <ul class="nav nav-treeview">
                          <li class="nav-item">
                              <a href="<?= site_url('user') ?>" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>User</p>
                              </a>
                          </li>
                          <li class="nav-item">
                              <a href="<?= site_url('origin') ?>" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Origin</p>
                              </a>
                          </li>
                          <li class="nav-item has-treeview">
                              <a href="#" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>
                                      Warehouse
                                      <i class="right fas fa-angle-left"></i>
                                  </p>
                              </a>
                              <ul class="nav nav-treeview">
                                  <li class="nav-item">
                                      <a href="<?= site_url('warehouse') ?>" class="nav-link">
                                          <i class="far fa-dot-circle nav-icon"></i>
                                          <p>Manage Warehouse</p>
                                      </a>
                                  </li>
                                  <li class="nav-item">
                                      <a href="<?= site_url('warehouse/locator') ?>" class="nav-link">
                                          <i class="far fa-dot-circle nav-icon"></i>
                                          <p>Manage Locator</p>
                                      </a>
                                  </li>
                                  <li class="nav-item">
                                      <a href="<?= site_url('warehouse/role') ?>" class="nav-link">
                                          <i class="far fa-dot-circle nav-icon"></i>
                                          <p>Manage Role</p>
                                      </a>
                                  </li>
                              </ul>
                          </li>
                          <li class="nav-item has-treeview">
                              <a href="#" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>
                                      Product
                                      <i class="right fas fa-angle-left"></i>
                                  </p>
                              </a>
                              <ul class="nav nav-treeview">
                                  <li class="nav-item">
                                      <a href="<?= site_url('product/uom') ?>" class="nav-link">
                                          <i class="far fa-dot-circle nav-icon"></i>
                                          <p>Manage Unit Product</p>
                                      </a>
                                  </li>
                                  <li class="nav-item">
                                      <a href="<?= site_url('product') ?>" class="nav-link">
                                          <i class="far fa-dot-circle nav-icon"></i>
                                          <p>Manage Product</p>
                                      </a>
                                  </li>
                              </ul>
                          </li>
                      </ul>
                  </li>
                  <li class="nav-item has-treeview">
                      <a href="#" class="nav-link">
                          <i class="nav-icon fas fa-copy"></i>
                          <p>
                              Transactions Data
                              <i class="right fas fa-angle-left"></i>
                          </p>
                      </a>
                      <ul class="nav nav-treeview">
                          <li class="nav-item has-treeview">
                              <a href="#" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>
                                      Inbound
                                      <i class="right fas fa-angle-left"></i>
                                  </p>
                              </a>
                              <ul class="nav nav-treeview">
                                  <li class="nav-item">
                                      <a href="<?= site_url('inbound/add_order') ?>" class="nav-link">
                                          <i class="far fa-dot-circle nav-icon"></i>
                                          <p>Add Order Inbound</p>
                                      </a>
                                  </li>
                                  <li class="nav-item">
                                      <a href="<?= site_url('inbound') ?>" class="nav-link">
                                          <i class="far fa-dot-circle nav-icon"></i>
                                          <p>Manage Inbound</p>
                                      </a>
                                  </li>
                              </ul>
                          </li>

                          <li class="nav-item has-treeview">
                              <a href="#" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>
                                      Outbound
                                      <i class="right fas fa-angle-left"></i>
                                  </p>
                              </a>
                              <ul class="nav nav-treeview">
                                  <li class="nav-item">
                                      <a href="<?= site_url('outbound/add_order') ?>" class="nav-link">
                                          <i class="far fa-dot-circle nav-icon"></i>
                                          <p>Add Order Outbound</p>
                                      </a>
                                  </li>
                                  <li class="nav-item">
                                      <a href="<?= site_url('outbound') ?>" class="nav-link">
                                          <i class="far fa-dot-circle nav-icon"></i>
                                          <p>Manage Outbound</p>
                                      </a>
                                  </li>
                              </ul>
                          </li>

                          <li class="nav-item">
                              <a href="<?= site_url('product/inventory') ?>" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Inventory</p>
                              </a>
                          </li>
                      </ul>
                  </li>
              </ul>
          </nav>
          <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
  </aside>