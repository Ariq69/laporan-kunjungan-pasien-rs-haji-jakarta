<nav class="navbar navbar-expand px-3 border-bottom">
  <button class="btn btn-close" id="sidebar-toggler" type="button">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="navbar-collapse navbar">
    <ul class="navbar-nav">
      <li class="nav-item dropdown">
        <a href="#" data-bs-toggle="dropdown" class="nav-icon pe-md-3">
          <img
            src="{{ asset('../images/profile.jpg') }}"
            alt=""
            class="avatar img-fluid rounded"
          />
        </a>
        <div class="dropdown-menu dropdown-menu-end">
          <a href="#" class="dropdown-item">Profile</a>
          <a href="#" class="dropdown-item">Settings</a>
          <a href="{{ route('logout') }}" class="dropdown-item" 
              onclick="event.preventDefault();
              document.getElementById('logout-form').submit();">
              {{ __('Logout') }}
          </a>

          <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
              @csrf
          </form>
        </div>
      </li>
    </ul>
  </div>
</nav>