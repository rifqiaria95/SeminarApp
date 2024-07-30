<!-- Layout wrapper -->
<div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">
      <!-- Menu -->
  
      <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
        <div class="app-brand demo">
          <a href="index.html" class="app-brand-link">
            <span class="app-brand-text demo menu-text fw-bold"><img src="{{ asset('Template/master/img/menarasyariah-logo-2.png') }}" alt="" srcset="" style="width: 15%"></span>
          </a>
          <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
            <i class="ti menu-toggle-icon d-none d-xl-block ti-sm align-middle"></i>
            <i class="ti ti-x d-block d-xl-none ti-sm align-middle"></i>
          </a>
        </div>
  
        <div class="menu-inner-shadow"></div>
  
        <ul class="menu-inner py-1">
          <!-- Dashboards -->
          <li class="menu-item  {{ Request::is('dashboard')?'active':'' }}">
            <a href="/dashboard" class="menu-link">
              <i class="menu-icon tf-icons ti ti-smart-home"></i>
              <div data-i18n="Dashboard">Dashboard</div>
            </a>
          </li>
          <!-- SKP -->
          <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Master Data</span>
          </li>
          @if(auth()->user()->role == 'owner' || auth()->user()->role == 'admin')
            <li class="menu-item {{ Request::is('peserta')?'active':'' }}">
              <a href="/peserta" class="menu-link">
                <i class="menu-icon tf-icons ti ti-users"></i>
                <div data-i18n="Peserta">Peserta</div>
              </a>
            </li>
            <li class="menu-item {{ Request::is('pembicara')?'active':'' }}">
              <a href="/pembicara" class="menu-link">
                <i class="menu-icon tf-icons ti ti-microphone"></i>
                <div data-i18n="Pembicara">Pembicara</div>
              </a>
            </li>
            @if(auth()->user()->role == 'karyawan' || auth()->user()->role == 'admin' || auth()->user()->role == 'owner')
              <li class="menu-item {{ Request::is('seminar', 'konfirmasi', 'report')?'active':'' }}">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                  <i class="menu-icon tf-icons ti ti-file-dollar"></i>
                  <div data-i18n="Data Seminar">Data Seminar</div>
                </a>
                <ul class="menu-sub">
                  <li class="menu-item {{ Request::is('seminar')?'active':'' }}">
                    <a href="/seminar" class="menu-link">
                      <i class="menu-icon tf-icons ti ti-layout-navbar"></i>
                      <div data-i18n="List Seminar">List Seminar</div>
                    </a>
                  </li>
                  <li class="menu-item {{ Request::is('konfirmasi')?'active':'' }}">
                    <a href="/konfirmasi" class="menu-link">
                      <div data-i18n="Konfirmasi Pembayaran">Konfirmasi Pembayaran</div>
                    </a>
                  </li>
                  <li class="menu-item {{ Request::is('report')?'active':'' }}">
                    <a href="/report" class="menu-link">
                      <i class="menu-icon tf-icons ti ti-file"></i>
                      <div data-i18n="Report Kehadiran">Report Kehadiran</div>
                    </a>
                  </li>
                </ul>
              </li>
            @endif
            <li class="menu-item {{ Request::is('tiket')?'active':'' }}">
              <a href="/tiket" class="menu-link">
                <i class="menu-icon tf-icons ti ti-ticket"></i>
                <div data-i18n="Tiket">Tiket</div>
              </a>
            </li>
          @endif
          @if(auth()->user()->role == 'peserta' || auth()->user()->role == 'admin' || auth()->user()->role == 'owner')
            <!-- Apps & Pages -->
            <li class="menu-header small text-uppercase">
              <span class="menu-header-text">Misc</span>
            </li>
          @endif
          @if(auth()->user()->role == 'owner')
            <li class="menu-item {{ Request::is('user')?'active':'' }}">
              <a href="/user" class="menu-link">
                <i class="menu-icon tf-icons ti ti-users"></i>
                <div data-i18n="Users">Users</div>
              </a>
            </li>
            <li class="menu-item {{ Request::is('activitylog')?'active':'' }}">
              <a href="/activitylog" class="menu-link">
                <i class="menu-icon tf-icons ti ti-activity"></i>
                <div data-i18n="Activity Log">Activity Log</div>
              </a>
            </li>
          @endif
        </ul>
      </aside>
      <!-- / Menu -->
  
      <!-- Layout container -->
      <div class="layout-page">
        
  <!-- / Layout wrapper -->