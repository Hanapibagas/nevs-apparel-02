@extends('layouts.app')

@section('content')
@if (session('success'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'Sukses!',
        text : "{{ session('success') }}",
    });
</script>
@endif

@if (session('error'))
<script>
    Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: "{{ session('error') }}",
    })
</script>
@endif

<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Tables /</span> Update Password
    </h4>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="container-xxl flex-grow-1 container-p-y">
                    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Input </span>Update password</h4>
                    <form id="submissionForm" action="{{ route('postUpdatePassword', $users->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card mb-4">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="mb-3 col-md-5">
                                                <label for="password" class="form-label">Masukkan Password Baru</label>
                                                <div class="input-group">
                                                    <input required class="form-control" type="password" id="password"
                                                        name="password" autofocus placeholder="Masukkan Password baru">
                                                    <button class="btn btn-outline-secondary" type="button"
                                                        id="togglePassword">Tampilkan</button>
                                                </div>
                                            </div>
                                            <div class="mb-3 col-md-5">
                                                <label for="password_confirmation" class="form-label">Masukkan Ulang
                                                    Password Baru</label>
                                                <div class="input-group">
                                                    <input required class="form-control" type="password"
                                                        id="password_confirmation" name="password_confirmation"
                                                        autofocus placeholder="Masukkan Ulang Password Baru">
                                                    <button class="btn btn-outline-secondary" type="button"
                                                        id="togglePasswordConfirmation">Tampilkan</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button id="submitButton" type="submit" class="btn btn-primary">
                            <i id="submitIcon" class="menu-icon tf-icons bx bx-send"></i>
                            Update password
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


@push('js')
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const togglePassword = document.getElementById("togglePassword");
        const passwordInput = document.getElementById("password");
        togglePassword.addEventListener("click", function () {
            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                togglePassword.textContent = "Sembunyikan";
            } else {
                passwordInput.type = "password";
                togglePassword.textContent = "Tampilkan";
            }
        });

        const togglePasswordConfirmation = document.getElementById("togglePasswordConfirmation");
        const passwordConfirmationInput = document.getElementById("password_confirmation");
        togglePasswordConfirmation.addEventListener("click", function () {
            if (passwordConfirmationInput.type === "password") {
                passwordConfirmationInput.type = "text";
                togglePasswordConfirmation.textContent = "Sembunyikan";
            } else {
                passwordConfirmationInput.type = "password";
                togglePasswordConfirmation.textContent = "Tampilkan";
            }
        });
    });
</script>
<script>
    document.getElementById('submissionForm').addEventListener('submit', function () {
        document.getElementById('submitButton').setAttribute('disabled', 'true');
        var icon = document.getElementById('submitIcon');
        icon.classList.remove('bx-send');
        icon.classList.add('bx-loader');
    });
</script>
@endpush