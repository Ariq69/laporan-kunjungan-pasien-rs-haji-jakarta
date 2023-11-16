<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1, shrink-to-fit=no"
    />
    <meta name="description" content="" />
    <meta name="author" content="" />

    <title>Rumah Sakit Haji</title>

    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet" />
    <link href="style/main.css" rel="stylesheet" />
  </head>
  <body>
    <!----------------------- Main Container -------------------------->

    <div
      class="container d-flex justify-content-center align-items-center min-vh-100"
    >
      <!----------------------- Login Container -------------------------->

      <div class="row border rounded-5 p-3 bg-white shadow box-area">
        <!--------------------------- Left Box ----------------------------->

        <div
          class="col-md-6 rounded-4 d-flex justify-content-center align-items-center flex-column left-box"
          style="background: #a0c492"
        >
          <div class="featured-image mb-4">
            <img
              src="images/logo-hd.webp"
              class="img-fluid"
              style="width: 250px"
            />
          </div>
          <p
            class="text-white fs-2"
            style="font-family: 'Poppins', sans-serif; font-weight: 600"
          >
            Rumah Sakit Haji
          </p>
        </div>

        <!-------------------- ------ Right Box ---------------------------->

        <div class="col-md-6 right-box">
          <div class="row align-items-center">
            <div class="header-text mb-4">
              <h2>Rumah Sakit Haji</h2>
              <p>UIN Syarif Hidayatullah Jakarta</p>
            </div>
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <!-- Email -->
            <div class="input-group mb-3">
              <input id="email" type="email" class="form-control form-control-lg bg-light fs-6 @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Email">

              @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
            </div>
            <!-- Password -->
            <div class="input-group mb-5">
              <input id="password" type="password" class="form-control form-control-lg bg-light fs-6 @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Password">
            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
            </div>
            <!-- Button Log In-->
            <div class="input-group mb-3">
              <button type="submit" class="btn btn-lg text-white w-100 fs-6 kotak-login"
                style="background-color: #a0c492">
                {{ __('Login') }}
            </button>
            </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>
