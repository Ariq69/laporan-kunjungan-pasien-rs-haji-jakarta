@extends('layouts.dashboard')

@section('content')
<main class="content px-3 py-2">
    <div class="container-fluid">
        <div class="mb-3 mt-3">
            <div class="row">
                <div class="col-lg-6 ">
                    <h4>Daftar Pengguna</h4>
                </div>
            </div>
            <div class="row mt-4">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form action="{{ route('setting-pengguna.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <div class="form-group">
                                    <label class="form-label">Nama</label>
                                    <input type="text" name="name" class="form-control" placeholder="Nama Pengguna"
                                        required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <div class="form-group">
                                    <label class="form-label">Email</label>
                                    <input type="email" name="email" class="form-control" placeholder="name@example.com"
                                        required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <div class="form-group">
                                    <label class="form-label">Password</label>
                                    <input type="password" name="password" class="form-control" placeholder="Password"
                                        required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <div class="form-group">
                                    <label class="form-label">Role</label>
                                    <select name="roles" class="form-control" required>
                                        <option value="tech">Tech</option>
                                        <!-- <option value="admin">Admin</option>
                                    <option value="dokter">Dokter</option>
                                    <option value="perawat">Perawat</option>
                                    <option value="pegawai">Pegawai</option> -->
                                        <option value="direksi">Direksi</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col text-right mt-3">
                            <button type="submit" class="btn btn-success px-5 py-2 ml-2">
                                Save Now
                            </button>
                            <a href="{{ route('setting-pengguna.index') }}" class="btn btn-danger px-5 py-2">
                                Batal
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>
@endsection