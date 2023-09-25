<?php 
$this->db->distinct();
$this->db->select('tahun_masuk')->from('user');
$this->db->where('tahun_masuk <',2030);
$this->db->where('tahun_masuk >',2018);
$this->db->order_by('tahun_masuk','DESC');
$angkatan = $this->db->get()->result_array();
$tahun = $this->uri->segment('4');
$kelas = $this->uri->segment('5');
$uri2 = $this->uri->segment('2');
$uri3 = $this->uri->segment('3');
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
  <?php if (($this->session->userdata('level') == "Admin") OR ($this->session->userdata('level') == "Kesiswaan") 
   OR ($this->session->userdata('level') == "BK")){ ?>
  <ul class="menu-inner">
    <li class="menu-item <?php echo activate_menu('home');  ?>">
      <a href="<?php echo site_url('admin/home');?>" class="menu-link">
        <i class="menu-icon tf-icons bx bx-home-circle"></i>
        <div data-i18n="Analytics">Dashboard</div>
      </a>
    </li>
    <?php if ($this->session->userdata('level') == "Admin") { ?>
    <li class="menu-item <?php echo activate_menu('admin');  ?>">
      <a href="<?php echo site_url('admin/admin');?>" class="menu-link">
        <i class="menu-icon tf-icons bx bx-user"></i>
        <div data-i18n="Analytics">Data Admin</div>
      </a>
    </li>
    <li class="menu-item <?php echo activate_menu('pelanggaran');  ?>">
      <a href="<?php echo site_url('admin/pelanggaran');?>" class="menu-link">
        <i class="menu-icon tf-icons bx bx-run"></i>
        <div data-i18n="Analytics">Jenis Pelanggaran</div>
      </a>
    </li>
    <?php } ?>
    <li class="menu-item <?php echo activate_menu('peringatan');  ?>">
      <a href="<?php echo site_url('admin/peringatan');?>" class="menu-link">
        <i class="menu-icon tf-icons bx bx-bell"></i>
        <div data-i18n="Analytics">Peringatan Poin</div>
      </a>
    </li>
    <li class="menu-item <?php if($uri2=='laporan'){ echo 'active open'; } ?>">
      <a href="javascript:void(0);" class="menu-link menu-toggle">
      <i class="menu-icon tf-icons bx bx-book"></i>
        <div data-i18n="Authentications">Rekap Laporan</div>
      </a>
      <ul class="menu-sub">
        <li class="menu-item <?php if($uri3=='pelanggaran'){ echo 'active'; } ?>">
          <a href="<?php echo site_url('admin/laporan/pelanggaran');?>" class="menu-link">
            <div data-i18n="Basic">Pelanggaran</div>
          </a>
        </li>
        <li class="menu-item <?php if($uri3=='izin'){ echo 'active'; } ?>">
          <a href="<?php echo site_url('admin/laporan/izin');?>" class="menu-link">
            <div data-i18n="Basic">Izin Siswa</div>
          </a>
        </li>
        <li class="menu-item <?php if($uri3=='prestasi'){ echo 'active'; } ?>">
          <a href="<?php echo site_url('admin/laporan/prestasi');?>" class="menu-link">
            <div data-i18n="Basic">Prestasi</div>
          </a>
        </li>

      </ul>
    </li>
    <li class="menu-item <?php if(($kelas=='MA') OR ($kelas=='MB') OR ($kelas=='MC')){ echo 'active open'; } ?>">
      <a class="menu-link menu-toggle" ><i class="menu-icon bx bx-cog"></i>Mesin</a>
      <ul class="menu-sub">
        <?php foreach ($angkatan as $uu) { ?>
        <li class="menu-item <?php if($tahun==$uu['tahun_masuk']){ echo 'open active'; } ?>">
          <a class="menu-link menu-toggle">Kelas <?php echo $this->Absensi_model->cek_kelas($uu['tahun_masuk']); ?></a>
          <ul class="menu-sub">
            <li class="menu-item <?php if(($kelas=='MA') AND ($tahun==$uu['tahun_masuk'])){ echo 'active open'; } ?>">
              <a class="menu-link" href="<?php echo site_url('admin/siswa/absen/'.$uu['tahun_masuk'].'/MA');?>"><?php echo $this->Absensi_model->cek_kelas($uu['tahun_masuk']); ?> MA</a>
            </li>
            <li class="menu-item <?php if(($kelas=='MB') AND ($tahun==$uu['tahun_masuk'])){ echo 'active open'; } ?>">
              <a class="menu-link" href="<?php echo site_url('admin/siswa/absen/'.$uu['tahun_masuk'].'/MB');?>"><?php echo $this->Absensi_model->cek_kelas($uu['tahun_masuk']); ?> MB</a>
            </li>
            <li class="menu-item <?php if(($kelas=='MC') AND ($tahun==$uu['tahun_masuk'])){ echo 'active open'; } ?>">
              <a class="menu-link" href="<?php echo site_url('admin/siswa/absen/'.$uu['tahun_masuk'].'/MC');?>"><?php echo $this->Absensi_model->cek_kelas($uu['tahun_masuk']); ?> MC</a>
            </li>
          </ul>
        </li>
        <?php }   ?>
      </ul>
    </li>
    <li class="menu-item <?php if(($kelas=='OA') OR ($kelas=='OB') OR ($kelas=='OC')){ echo 'active open'; } ?>">
      <a class="menu-link menu-toggle" href="javascript:void(0)"><i class="menu-icon bx bxs-car-crash"></i>Ototronik</a>
      <ul class="menu-sub">
        <?php foreach ($angkatan as $uu) { ?>
        <li class="menu-item <?php if($tahun==$uu['tahun_masuk']){ echo 'open active'; } ?>">
          <a class="menu-link menu-toggle" href="javascript:void(0)">Kelas <?php echo $this->Absensi_model->cek_kelas($uu['tahun_masuk']); ?></a>
          <ul class="menu-sub">
            <li class="menu-item">
              <a class="menu-link <?php if(($kelas=='OA') AND ($tahun==$uu['tahun_masuk'])){ echo 'active open'; } ?>" href="<?php echo site_url('admin/siswa/absen/'.$uu['tahun_masuk'].'/OA');?>"><?php echo $this->Absensi_model->cek_kelas($uu['tahun_masuk']); ?> OA</a>
            </li>
            <li class="menu-item <?php if(($kelas=='OB') AND ($tahun==$uu['tahun_masuk'])){ echo 'active open'; } ?>">
              <a class="menu-link" href="<?php echo site_url('admin/siswa/absen/'.$uu['tahun_masuk'].'/OB');?>"><?php echo $this->Absensi_model->cek_kelas($uu['tahun_masuk']); ?> OB</a>
            </li>
            <li class="menu-item <?php if(($kelas=='OC') AND ($tahun==$uu['tahun_masuk'])){ echo 'active open'; } ?>">
              <a class="menu-link" href="<?php echo site_url('admin/siswa/absen/'.$uu['tahun_masuk'].'/OC');?>"><?php echo $this->Absensi_model->cek_kelas($uu['tahun_masuk']); ?> OC</a>
            </li>
          </ul>
        </li>
        <?php }   ?>
      </ul>
    </li>
    <li class="menu-item <?php if(($kelas=='TA') OR ($kelas=='TB') OR ($kelas=='TC')){ echo 'active open'; } ?>">
      <a class="menu-link menu-toggle" href="javascript:void(0)"><i class='menu-icon bx bxl-medium-old'></i>Pembuatan Kain</a>
      <ul class="menu-sub">
        <?php foreach ($angkatan as $uu) { ?>
        <li class="menu-item <?php if($tahun==$uu['tahun_masuk']){ echo 'open active'; } ?>">
          <a class="menu-link menu-toggle" href="javascript:void(0)">Kelas <?php echo $this->Absensi_model->cek_kelas($uu['tahun_masuk']); ?></a>
          <ul class="menu-sub">
            <li class="menu-item <?php if(($kelas=='TA') AND ($tahun==$uu['tahun_masuk'])){ echo 'active open'; } ?>">
              <a class="menu-link" href="<?php echo site_url('admin/siswa/absen/'.$uu['tahun_masuk'].'/TA');?>"><?php echo $this->Absensi_model->cek_kelas($uu['tahun_masuk']); ?> TA</a>
            </li>
            <li class="menu-item <?php if(($kelas=='TB') AND ($tahun==$uu['tahun_masuk'])){ echo 'active open'; } ?>">
              <a class="menu-link" href="<?php echo site_url('admin/siswa/absen/'.$uu['tahun_masuk'].'/TB');?>"><?php echo $this->Absensi_model->cek_kelas($uu['tahun_masuk']); ?> TB</a>
            </li>
            <li class="menu-item <?php if(($kelas=='TC') AND ($tahun==$uu['tahun_masuk'])){ echo 'active open'; } ?>">
              <a class="menu-link" href="<?php echo site_url('admin/siswa/absen/'.$uu['tahun_masuk'].'/TC');?>"><?php echo $this->Absensi_model->cek_kelas($uu['tahun_masuk']); ?> TC</a>
            </li>
          </ul>
        </li>
        <?php }   ?>
      </ul>
    </li>
    <li class="menu-item <?php if(($kelas=='RA') OR ($kelas=='RB') OR ($kelas=='RC')){ echo 'active open'; } ?>">
      <a class="menu-link menu-toggle" href="javascript:void(0)" style="font-size: -5px;"><i class='menu-icon bx bx-code-alt'></i>Rekayasa Perangkat Lunak</a>
      <ul class="menu-sub">
        <?php foreach ($angkatan as $uu) { ?>
        <li class="menu-item <?php if($tahun==$uu['tahun_masuk']){ echo 'open active'; } ?>">
          <a class="menu-link menu-toggle" href="javascript:void(0)">Kelas <?php echo $this->Absensi_model->cek_kelas($uu['tahun_masuk']); ?></a>
          <ul class="menu-sub">
            <li class="menu-item <?php if(($kelas=='RA') AND ($tahun==$uu['tahun_masuk'])){ echo 'active open'; } ?>">
              <a class="menu-link" href="<?php echo site_url('admin/siswa/absen/'.$uu['tahun_masuk'].'/RA');?>"><?php echo $this->Absensi_model->cek_kelas($uu['tahun_masuk']); ?> RA</a>
            </li>
            <li class="menu-item <?php if(($kelas=='RB') AND ($tahun==$uu['tahun_masuk'])){ echo 'active open'; } ?>">
              <a class="menu-link" href="<?php echo site_url('admin/siswa/absen/'.$uu['tahun_masuk'].'/RB');?>"><?php echo $this->Absensi_model->cek_kelas($uu['tahun_masuk']); ?> RB</a>
            </li>
            <li class="menu-item <?php if(($kelas=='RC') AND ($tahun==$uu['tahun_masuk'])){ echo 'active open'; } ?>">
              <a class="menu-link" href="<?php echo site_url('admin/siswa/absen/'.$uu['tahun_masuk'].'/RC');?>"><?php echo $this->Absensi_model->cek_kelas($uu['tahun_masuk']); ?> RC</a>
            </li>
          </ul>
        </li>
        <?php }   ?>
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