<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Notification System</title>

    <!-- ✅ Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    <!-- ✅ Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">📣 Notification System</a>
        </div>
    </nav>

    <!-- ✅ Main content -->
    <main class="py-4">
        <div class="container">
            @yield('content') 
        </div>
    </main>

    <!-- ✅ Footer -->
    <footer class="text-center text-muted py-3">
        <small>© {{ date('Y') }} Notification System</small>
    </footer>

</body>
</html>
