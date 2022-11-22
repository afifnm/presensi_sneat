<?php 
$this->db->distinct();
$this->db->select('tahun_masuk')->from('user');
$this->db->where('tahun_masuk <',2030);
$this->db->where('tahun_masuk >',2018);
$this->db->order_by('tahun_masuk','DESC');
$angkatan = $this->db->get()->result_array();
?>
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
  <ul class="menu-inner">
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
        <?php foreach ($angkatan as $uu) { ?>
        <li class="menu-item <?php if($this->uri->segment('4')=='0'){ echo "active"; } ?>">
          <a href="<?php echo site_url('admin/siswa/'.$uu['tahun_masuk'].'/MA');?>" class="menu-link">
            <div data-i18n="Without menu"> <?php echo $this->Absensi_model->cek_kelas($uu['tahun_masuk']); ?> MA
            </div>
          </a>
        </li>
        <li class="menu-item <?php if($this->uri->segment('4')=='0'){ echo "active"; } ?>">
          <a href="<?php echo site_url('admin/siswa/'.$uu['tahun_masuk'].'/MB');?>" class="menu-link">
            <div data-i18n="Without menu"> <?php echo $this->Absensi_model->cek_kelas($uu['tahun_masuk']); ?> MB
            </div>
          </a>
        </li>
        <li class="menu-item <?php if($this->uri->segment('4')=='0'){ echo "active"; } ?>">
          <a href="<?php echo site_url('admin/siswa/'.$uu['tahun_masuk'].'/MC');?>" class="menu-link">
            <div data-i18n="Without menu"> <?php echo $this->Absensi_model->cek_kelas($uu['tahun_masuk']); ?> MC
            </div>
          </a>
        </li>
        <?php } ?>
      </ul>
    </li>
    <li class="menu-item">
      <a class="menu-link menu-toggle" href="javascript:void(0)"><i class="menu-icon bx bx-dock-top"></i>
          Mesin
      </a>
      <ul class="menu-sub">
        <?php foreach ($angkatan as $uu) { ?>
        <li class="menu-item">
          <a class="menu-link menu-toggle" href="javascript:void(0)">Authentication</a>
          <ul class="menu-sub">
            <li class="menu-item">
              <a class="menu-link" href="javascript:void(0)">Login</a>
            </li>
            <li class="menu-item">
              <a class="menu-link" href="javascript:void(0)">Register</a>
            </li>
            <li class="menu-item">
              <a class="menu-link" href="javascript:void(0)">Forgot Password</a>
            </li>
          </ul>
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
  <div class="menu menu-vertical bg-menu-theme py-3" id="menu-1" style="height: 450px">
    <ul class="menu-inner">


    </ul>
  </div>
</aside>