<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Giày Hiện Đại</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --accent-color: #DC2626;
            --bg-light: #f8f9fa;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-light);
        }

        .text-accent {
            color: var(--accent-color) !important;
        }

        .nav-pills .nav-link {
            color: #495057;
            font-weight: 500;
            padding: 12px 20px;
            margin-bottom: 4px;
            border-radius: 8px;
        }

        .nav-pills .nav-link:hover {
            background-color: #e9ecef;
        }

        .nav-pills .nav-link.active {
            background-color: white;
            color: var(--accent-color);
            border-left: 4px solid var(--accent-color);
            font-weight: 700;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .card {
            border: none;
            border-radius: 16px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        }

        main {
            padding-top: 100px;
            padding-bottom: 80px;
        }
    </style>
</head>

<body>

    <header class="bg-white fixed-top py-3 border-bottom">
        <div class="container-fluid px-lg-5">
            <div class="d-flex justify-content-between align-items-center">
                <a href="index.php" class="navbar-brand">
                    <span class="h4 fw-bold text-accent">Giày Hiện Đại</span>
                </a>
                <div class="d-flex align-items-center gap-3">
                    <span class="fw-medium text-secondary d-none d-md-block">Xin chào, Admin</span>
                    <a href="index.php?ctrl=user&act=logout" class="btn btn-outline-danger btn-sm rounded-pill">Đăng
                        xuất</a>
                </div>
            </div>
        </div>
    </header>