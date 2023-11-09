<aside id="sidebar">
  <!--Content Sidebar-->
  <div class="h-100">
    <div class="sidebar-logo">
      <a href="#">Rumah Sakit Haji</a>
    </div>
    <ul class="sidebar-nav">
      <li class="sidebar-item">
        <a href="{{ route('dashboard', ['role' => Auth::user()->roles]) }}" class="sidebar-link">
          <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="24" height="24" viewBox="0 0 24 24" style="fill: #ffffff">
              <path d="M 12 2.0996094 L 1 12 L 4 12 L 4 21 L 10 21 L 10 14 L 14 14 L 14 21 L 20 21 L 20 12 L 23 12 L 12 2.0996094 z"></path>
          </svg>
          Dashboard
      </a>
      </li>
      <li class="sidebar-header">Keuangan</li>

      <!--Pendapatan-->
      <li class="sidebar-item">
        <a
          href="#"
          class="sidebar-link collapsed"
          data-bs-target="#pendapatan"
          data-bs-toggle="collapse"
          aria-expanded="false"
        >
          <img src="{{ asset('../images/icon-kasir.png') }}" alt="" class="icon-sidebar" />
          Pendapatan
        </a>
        <ul
          id="pendapatan"
          class="sidebar-dropdown list-unstyled collapse"
          data-bs-parents="#sidebar"
        >
          <li class="sidebar-item">
            <a href="#" class="sidebar-link">Cara Bayar</a>
          </li>
          <li class="sidebar-item">
            <a href="#" class="sidebar-link">Poliklinik</a>
          </li>
          <li class="sidebar-item">
            <a href="#" class="sidebar-link">Dokter</a>
          </li>
          <li class="sidebar-item">
            <a href="#" class="sidebar-link">IGD</a>
          </li>
        </ul>
      </li>

      <!--Kasir-->
      <li class="sidebar-item">
        <a
          href="#"
          class="sidebar-link collapsed"
          data-bs-target="#kasir"
          data-bs-toggle="collapse"
          aria-expanded="false"
        >
          <img src="{{ asset('../images/icon-kasir.png') }}" alt="" class="icon-sidebar" />
          Kasir
        </a>
        <ul
          id="kasir"
          class="sidebar-dropdown list-unstyled collapse"
          data-bs-parents="#sidebar"
        >
          <li class="sidebar-item">
            <a href="#" class="sidebar-link">Sentral</a>
          </li>
          <li class="sidebar-item">
            <a href="#" class="sidebar-link">Farmasi</a>
          </li>
          <li class="sidebar-item">
            <a href="#" class="sidebar-link">IGD</a>
          </li>
        </ul>
      </li>
      <!--Kasir-->
      <li class="sidebar-item">
        <a
          href="#"
          class="sidebar-link collapsed"
          data-bs-target="#asuransi"
          data-bs-toggle="collapse"
          aria-expanded="false"
        >
          <img src="{{ asset('../images/icon-kasir.png') }}" alt="" class="icon-sidebar" />
          Asuransi
        </a>
        <ul
          id="asuransi"
          class="sidebar-dropdown list-unstyled collapse"
          data-bs-parents="#sidebar"
        >
          <li class="sidebar-item">
            <a href="{{ route('informasi-asuransi') }}" class="sidebar-link">Informasi Asuransi</a>
          </li>
        </ul>
      </li>

      <li class="sidebar-header">Pengguna</li>
      <!--Dokter-->
      <li class="sidebar-item">
        <a
          href="#"
          class="sidebar-link collapsed"
          data-bs-target="#dokter"
          data-bs-toggle="collapse"
          aria-expanded="false"
        >
          <img src="{{ asset('../images/icon-dokter.png') }}" alt="" class="icon-sidebar" />
          Dokter
        </a>
        <ul
          id="dokter"
          class="sidebar-dropdown list-unstyled collapse"
          data-bs-parents="#sidebar"
        >
          <li class="sidebar-item">
            <a href="{{ route('data-dokter') }}" class="sidebar-link">Data Dokter</a>
          </li>

          <li class="sidebar-item">
            <a href="{{ route('jadwal-dokter') }}" class="sidebar-link">Jadwal Dokter</a>
          </li>

          <li class="sidebar-item">
            <a href="#" class="sidebar-link"
              >Indikator Keselamatan Pasien</a
            >
          </li>
        </ul>
      </li>

      <!--Perawat-->
      <li class="sidebar-item">
        <a
          href="#"
          class="sidebar-link collapsed"
          data-bs-target="#perawat"
          data-bs-toggle="collapse"
          aria-expanded="false"
        >
          <img
            src="{{ asset('../images/icon-perawat.png') }}"
            alt=""
            class="icon-sidebar"
          />
          Perawat
        </a>
        <ul
          id="perawat"
          class="sidebar-dropdown list-unstyled collapse"
          data-bs-parents="#sidebar"
        >
          <li class="sidebar-item">
            <a href="{{ route('data-perawat') }}" class="sidebar-link">Data Perawat</a>
          </li>

          <li class="sidebar-item">
            <a href="{{ route('jadwal-perawat') }}" class="sidebar-link">Jadwal Perawat</a>
          </li>
        </ul>
      </li>

      <!--Pegawai-->
      <li class="sidebar-item">
        <a
          href="#"
          class="sidebar-link collapsed"
          data-bs-target="#pegawai"
          data-bs-toggle="collapse"
          aria-expanded="false"
        >
          <img
            src="{{ asset('../images/icon-pegawai.png') }}"
            alt=""
            class="icon-sidebar"
          />
          Pegawai
        </a>
        <ul
          id="pegawai"
          class="sidebar-dropdown list-unstyled collapse"
          data-bs-parents="#sidebar"
        >
          <li class="sidebar-item">
            <a href="{{ route('data-pegawai') }}" class="sidebar-link">Data Pegawai</a>
          </li>

          <li class="sidebar-item">
            <a href="#" class="sidebar-link">Jadwal Pegawai</a>
          </li>
        </ul>
      </li>

      <!--Section Pelayanan-->
      <li class="sidebar-header">Pelayanan</li>

      <!--Registrasi-->
      <li class="sidebar-item">
        <a
          href="#"
          class="sidebar-link collapsed"
          data-bs-target="#registrasi"
          data-bs-toggle="collapse"
          aria-expanded="false"
        >
          <img
            src="{{ asset('../images/icon-registrasi.png') }}"
            alt=""
            class="icon-sidebar"
          />
          Registrasi
        </a>
        <ul
          id="registrasi"
          class="sidebar-dropdown list-unstyled collapse"
          data-bs-parents="#sidebar"
        >
          <li class="sidebar-item">
            <a href="{{ route('pasien') }}" class="sidebar-link">Pasien</a>
          </li>
        </ul>
      </li>
      <!--Administrasi-->
      <li class="sidebar-item">
        <a
          href="#"
          class="sidebar-link collapsed"
          data-bs-target="#laporan"
          data-bs-toggle="collapse"
          aria-expanded="false"
        >
          <img
            src="{{ asset('../images/icon-kunjungan.png') }}"
            alt=""
            class="icon-sidebar"
          />
          Kunjungan
        </a>
        <ul
          id="laporan"
          class="sidebar-dropdown list-unstyled collapse"
          data-bs-parents="#sidebar"
        >
          <li class="sidebar-item">
            <a href="{{ route('informasi-kamar') }}" class="sidebar-link">Informasi Kamar</a>
          </li>
          <li class="sidebar-item">
            <a href="{{ route('rawat-inap') }}" class="sidebar-link">Rawat Inap</a>
          </li>
          <li class="sidebar-item">
            <a href="{{ route('rawat-jalan') }}" class="sidebar-link">Rawat Jalan</a>
          </li>
          <li class="sidebar-item">
            <a href="{{ route('penyakit') }}" class="sidebar-link">Penyakit</a>
          </li>
        </ul>
      </li>

      <!--Section Pemantauan-->
      <li class="sidebar-header">Pemantauan</li>

      <!--Pemakaian Air-->
      <li class="sidebar-item">
        <a
          href="#"
          class="sidebar-link collapsed"
          data-bs-target="#pemakaian-air"
          data-bs-toggle="collapse"
          aria-expanded="false"
        >
          <img src="{{ asset('../images/icon-dokter.png') }}" alt="" class="icon-sidebar" />
          Pemakaian Air
        </a>
        <ul
          id="pemakaian-air"
          class="sidebar-dropdown list-unstyled collapse"
          data-bs-parents="#sidebar"
        >
          <li class="sidebar-item">
            <a href="{{ route('air-pdam') }}" class="sidebar-link">Air PDAM</a>
          </li>

          <li class="sidebar-item">
            <a href="{{ route('air-tanah') }}" class="sidebar-link">Air Tanah</a>
          </li>
          </li>
        </ul>
      </li>

      <!--Limbah-->
      <li class="sidebar-item">
        <a
          href="#"
          class="sidebar-link collapsed"
          data-bs-target="#limbah"
          data-bs-toggle="collapse"
          aria-expanded="false"
        >
          <img
            src="{{ asset('../images/icon-perawat.png') }}"
            alt=""
            class="icon-sidebar"
          />
          Limbah
        </a>
        <ul
          id="limbah"
          class="sidebar-dropdown list-unstyled collapse"
          data-bs-parents="#sidebar"
        >
          <li class="sidebar-item">
            <a href="#" class="sidebar-link">B3 Medis</a>
          </li>

          <li class="sidebar-item">
            <a href="#" class="sidebar-link">B3 Cair</a>
          </li>

          <li class="sidebar-item">
            <a href="#" class="sidebar-link">Padat Domestik</a>
          </li>
        </ul>
      </li>

      <!--K3-->
      <li class="sidebar-item">
        <li class="sidebar-item">
            <a href="{{ route('k3') }}" class="sidebar-link">
            <img src="{{ asset('../images/icon-k3.png') }}" alt="" class="icon-sidebar">
            K3</a>
          </li>
      </li>

      <!--Section Inventaris-->
      <li class="sidebar-header">Inventaris</li>

      <!--Pengajuan Aset-->
      <li class="sidebar-item">
        <li class="sidebar-item">
            <a href="#" class="sidebar-link">
            <img src="{{ asset('../images/icon-k3.png') }}" alt="" class="icon-sidebar">
            Pengajuan Aset</a>
          </li>
      </li>

      <!--Perbaikan Inventaris-->
      <li class="sidebar-item">
        <li class="sidebar-item">
            <a href="#" class="sidebar-link">
            <img src="{{ asset('../images/icon-k3.png') }}" alt="" class="icon-sidebar">
            Perbaikan Inventaris</a>
          </li>
      </li>

      <!--Jumlah Inventaris-->
      <li class="sidebar-item">
        <li class="sidebar-item">
            <a href="#" class="sidebar-link">
            <img src="{{ asset('../images/icon-k3.png') }}" alt="" class="icon-sidebar">
            Jumlah Inventaris</a>
          </li>
      </li>

      <!--Section Setting Pengguna-->
      <li class="sidebar-header">Setting Pengguna</li>

      <!--Akun Pengguna-->
      <li class="sidebar-item">
        <a
          href="#"
          class="sidebar-link collapsed"
          data-bs-target="#akun-pengguna"
          data-bs-toggle="collapse"
          aria-expanded="false"
        >
          <img src="{{ asset('../images/icon-user.png') }}" alt="" class="icon-sidebar" />
          Akun Pengguna
        </a>
        <ul
          id="akun-pengguna"
          class="sidebar-dropdown list-unstyled collapse"
          data-bs-parents="#sidebar"
        >
          <li class="sidebar-item">
            <a href="{{ route('setting-pengguna.index') }}" class="sidebar-link">Daftar Pengguna</a>
          </li>
          </li>
        </ul>
      </li>

      <li class="sidebar-header">Multi Menu</li>

      <li class="sidebar-item">
        <a
          href="#"
          class="sidebar-link collapsed"
          data-bs-target="#obat"
          data-bs-toggle="collapse"
          aria-expanded="false"
        >
          <svg
            xmlns="http://www.w3.org/2000/svg"
            x="0px"
            y="0px"
            width="24"
            height="24"
            viewBox="0 0 64 64"
            style="fill: #ffffff"
          >
            <path
              d="M 13 6 C 9.1 6 6 9.1 6 13 L 6 51 C 6 54.9 9.1 58 13 58 L 51 58 C 54.9 58 58 54.9 58 51 L 58 45 L 58 39 L 58 13 C 58 9.1 54.9 6 51 6 L 13 6 z M 13 8 L 51 8 C 53.8 8 56 10.2 56 13 L 56 39 L 23.537109 39 L 26.748047 37.394531 A 1.0001 1.0001 0 0 0 26.994141 35.78125 L 24.09375 32.980469 A 1.0001 1.0001 0 0 0 23.367188 32.701172 A 1.0001 1.0001 0 0 0 22.507812 33.246094 L 19.609375 38.947266 A 1.0001 1.0001 0 0 0 19.566406 39.042969 C 18.124724 39.257175 17 40.502773 17 42 C 17 43.645455 18.354545 45 20 45 L 56 45 L 56 51 C 56 53.8 53.8 56 51 56 L 13 56 C 10.2 56 8 53.8 8 51 L 8 13 C 8 10.2 10.2 8 13 8 z M 46.099609 10.927734 C 45.334444 10.927734 44.568964 11.216192 43.992188 11.792969 L 41.892578 13.892578 A 1.0001 1.0001 0 0 0 41.892578 15.306641 L 44.693359 18.107422 A 1.0001 1.0001 0 0 0 46.107422 18.107422 L 48.207031 16.007812 C 49.360585 14.854259 49.360585 12.946522 48.207031 11.792969 C 47.630255 11.216192 46.864774 10.927734 46.099609 10.927734 z M 46.099609 12.873047 C 46.334444 12.873047 46.569745 12.983808 46.792969 13.207031 C 47.239415 13.653478 47.239415 14.147303 46.792969 14.59375 L 45.400391 15.986328 L 44.013672 14.599609 L 45.40625 13.207031 C 45.629473 12.983808 45.864774 12.873047 46.099609 12.873047 z M 40.365234 15.769531 A 1.0001 1.0001 0 0 0 39.673828 16.0625 L 24.824219 30.912109 A 1.0001 1.0001 0 0 0 24.824219 32.326172 L 27.652344 35.154297 A 1.0001 1.0001 0 0 0 29.066406 35.154297 L 43.916016 20.304688 A 1.0001 1.0001 0 0 0 43.916016 18.890625 L 41.087891 16.0625 A 1.0001 1.0001 0 0 0 40.365234 15.769531 z M 40.380859 18.183594 L 41.794922 19.597656 L 28.359375 33.033203 L 26.945312 31.619141 L 40.380859 18.183594 z M 23.677734 35.359375 L 24.589844 36.238281 L 22.767578 37.148438 L 23.677734 35.359375 z M 20 41 L 56 41 L 56 43 L 20 43 C 19.445455 43 19 42.554545 19 42 C 19 41.445455 19.445455 41 20 41 z M 12 48 C 11.4 48 11 48.4 11 49 L 11 51 C 11 51.6 11.4 52 12 52 C 12.6 52 13 51.6 13 51 L 13 49 C 13 48.4 12.6 48 12 48 z M 17 48 C 16.4 48 16 48.4 16 49 L 16 51 C 16 51.6 16.4 52 17 52 C 17.6 52 18 51.6 18 51 L 18 49 C 18 48.4 17.6 48 17 48 z M 22 48 C 21.4 48 21 48.4 21 49 L 21 51 C 21 51.6 21.4 52 22 52 C 22.6 52 23 51.6 23 51 L 23 49 C 23 48.4 22.6 48 22 48 z M 27 48 C 26.4 48 26 48.4 26 49 L 26 51 C 26 51.6 26.4 52 27 52 C 27.6 52 28 51.6 28 51 L 28 49 C 28 48.4 27.6 48 27 48 z M 32 48 C 31.4 48 31 48.4 31 49 L 31 51 C 31 51.6 31.4 52 32 52 C 32.6 52 33 51.6 33 51 L 33 49 C 33 48.4 32.6 48 32 48 z M 37 48 C 36.4 48 36 48.4 36 49 L 36 51 C 36 51.6 36.4 52 37 52 C 37.6 52 38 51.6 38 51 L 38 49 C 38 48.4 37.6 48 37 48 z M 42 48 C 41.4 48 41 48.4 41 49 L 41 51 C 41 51.6 41.4 52 42 52 C 42.6 52 43 51.6 43 51 L 43 49 C 43 48.4 42.6 48 42 48 z M 47 48 C 46.4 48 46 48.4 46 49 L 46 51 C 46 51.6 46.4 52 47 52 C 47.6 52 48 51.6 48 51 L 48 49 C 48 48.4 47.6 48 47 48 z M 52 48 C 51.4 48 51 48.4 51 49 L 51 51 C 51 51.6 51.4 52 52 52 C 52.6 52 53 51.6 53 51 L 53 49 C 53 48.4 52.6 48 52 48 z"
            ></path>
          </svg>
          Obat
        </a>

        <ul
          id="obat"
          class="sidebar-dropdown list-unstyled collapse"
          data-bs-parents="#sidebar"
        >
          <li class="sidebar-item">
            <a
              href="#"
              class="sidebar-link collapsed"
              data-bs-target="#obat-1"
              data-bs-toggle="collapse"
              aria-expanded="false"
              >Obat 1</a
            >
            <ul
              id="obat-1"
              class="sidebar-dropdown list-unstyled collapse"
              data-bs-parents="#sidebar"
            >
              <li class="sidebar-item">
                <a href="#" class="sidebar-link">Obat A</a>
              </li>
              <li class="sidebar-item">
                <a href="#" class="sidebar-link">Obat B</a>
              </li>
            </ul>
          </li>
          <li class="sidebar-item">
            <a
              href="#"
              class="sidebar-link collapsed"
              data-bs-target="#obat-2"
              data-bs-toggle="collapse"
              aria-expanded="false"
              >Obat 2</a
            >
            <ul
              id="obat-2"
              class="sidebar-dropdown list-unstyled collapse"
              data-bs-parents="#sidebar"
            >
              <li class="sidebar-item">
                <a href="#" class="sidebar-link">Obat C</a>
              </li>
              <li class="sidebar-item">
                <a href="#" class="sidebar-link">Obat D</a>
              </li>
            </ul>
          </li>
        </ul>
      </li>
    </ul>
  </div>
</aside>