<!doctype html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title') - LivestockID</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}" />
</head>

<body class="auth-page">
    <div class="container py-4">
        <div class="auth-shell">
            <div class="row g-0">
                <div class="col-md-6 auth-form-section">
                    <div class="auth-brand">
                        <span class="auth-brand-accent">Livestock</span><span>ID</span>
                    </div>

                    @yield('content')
                </div>

                <div class="col-md-6 d-none d-md-block">
                    <div class="auth-visual-section"></div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>

</html>