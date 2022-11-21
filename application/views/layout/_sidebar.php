<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
  <div class="app-brand demo">
    <a href="<?php echo site_url('/');?>" class="app-brand-link" target="_blank">
      <span class="app-brand-text demo  fw-bolder ms-2">skanda-kra</span>
    </a>
    <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
      <i class="bx bx-chevron-left bx-sm align-middle"></i>
    </a>
  </div>
  <div class="menu-inner-shadow"></div>
  <?php if ($this->session->userdata('level') == "Admin"){ ?>
  <ul class="menu-inner py-1">
    <li class="menu-item <?php echo activate_menu('home');  ?>">
      <a href="<?php echo site_url('admin/home');?>" class="menu-link">
        <i class="menu-icon tf-icons bx bx-home-circle"></i>
        <div data-i18n="Analytics">Dashboard</div>
      </a>
    </li>
    <li class="menu-item <?php echo open_menu('order'); ?> <?php echo activate_menu('order');  ?>">
      <a href="javascript:void(0);" class="menu-link menu-toggle">
        <i class="menu-icon tf-icons bx bx-cart"></i>
        <div data-i18n="Layouts">Data Siswa</div>
      </a>
      <ul class="menu-sub">
        <li class="menu-item <?php if($this->uri->segment('4')=='0'){ echo "active"; } ?>">
          <a href="<?php echo site_url('admin/order/status/0');?>" class="menu-link">
            <div data-i18n="Without menu"> Pesanan Masuk</div>
          </a>
        </li>
        <li class="menu-item <?php if($this->uri->segment('4')=='2'){ echo "active"; } ?>">
          <a href="<?php echo site_url('admin/order/status/2');?>" class="menu-link">
            <div data-i18n="Without menu"> Pesanan Dalam Perjalanan</div>
          </a>
        </li>
        <li class="menu-item <?php if($this->uri->segment('4')=='3'){ echo "active"; } ?>">
          <a href="<?php echo site_url('admin/order/status/3');?>" class="menu-link">
            <div data-i18n="Without menu"> Pesanan Selesai</div>
          </a>
        </li>
        <li class="menu-item <?php if($this->uri->segment('4')=='1'){ echo "active"; } ?>">
          <a href="<?php echo site_url('admin/order/status/1');?>" class="menu-link">
            <div data-i18n="Without menu"> Pesanan Dibatalkan</div>
          </a>
        </li>
      </ul>
    </li>
  </ul>
  <?php }  elseif ($this->session->userdata('level') == "Siswa"){ ?>
  <ul class="menu-inner py-1">
    <li class="menu-item <?php echo activate_menu('home');  ?>">
      <a href="<?php echo site_url('siswa/home');?>" class="menu-link">
        <i class="menu-icon tf-icons bx bx-home-circle"></i>
        <div data-i18n="Analytics">Presensi Siswa</div>
      </a>
    </li>
  </ul>
  <?php }   ?>
</aside>