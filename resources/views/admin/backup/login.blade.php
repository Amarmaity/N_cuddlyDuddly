<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CuddlyDuddly Admin Control - Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/admin-login.css') }}">
</head>

<body>
    <div class="login-container">
        <div class="login-box">
            <div class="login-header">
                <h2>CuddlyDuddly <span>Admin</span></h2>
                <p>Control Panel Access</p>
            </div>
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show shadow-sm">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
                </div>
            @endif

            <form method="POST" action="{{ route('admin.login.submit') }}" id="loginForm">
                @csrf

                <div class="form-group mb-3">
                    <label for="emailOrPhone">Email or Phone</label>
                    <input type="text" class="form-control @error('email_or_phone') is-invalid @enderror"
                        id="emailOrPhone" name="email_or_phone" value="{{ old('email_or_phone') }}"
                        placeholder="Enter your email or phone" required>
                    @error('email_or_phone')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="password">Password</label>
                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password"
                        name="password" placeholder="Enter password" required>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-4">
                    <label for="userType">User Type</label>

                    <select class="form-select @error('user_type') is-invalid @enderror" id="userType" name="user_type"
                        required>

                        <option value="">-- Select User Type --</option>

                        @foreach ($userTypes as $type)
                            <option value="{{ $type->slug }}" {{ old('user_type') == $type->slug ? 'selected' : '' }}>
                                {{ $type->name }}
                            </option>
                        @endforeach
                    </select>

                    @error('user_type')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>


                <button type="submit" id="loginBtn"
                    class="btn-login w-100 d-flex justify-content-center align-items-center">
                    <span id="btnText">Login</span>
                    <div id="btnLoader" class="spinner-border spinner-border-sm d-none" role="status"></div>
                </button>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('loginForm').addEventListener('submit', function() {
            const btn = document.getElementById('loginBtn');
            const text = document.getElementById('btnText');
            const loader = document.getElementById('btnLoader');
            btn.disabled = true;
            text.classList.add('d-none');
            loader.classList.remove('d-none');
        });
    </script>

</body>

</html>
