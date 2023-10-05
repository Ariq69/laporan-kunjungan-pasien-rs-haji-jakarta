@extends('layouts.dashboard')

@section('content')
<main class="content px-3 py-2">
    <div class="container-fluid">
    <div class="mb-3">
        <div class="row">
        <div class="col-12 col-md-6 d-flex">
            <div class="flex-fill border-0 illustration">
            <div class="card-body p-1 d-flex flex-fill">
                <div class="row g-0 w-100">
                <div class="p-3 m-2">
                    <h4>Welcome back, {{ Auth::user()->name }}!</h4>
                    <p class="mb-0">Apa yang akan kamu lakukan?</p>
                </div>
                </div>
            </div>
            </div>
        </div>
        </div>
    </div>
    </div>
</main>
@endsection