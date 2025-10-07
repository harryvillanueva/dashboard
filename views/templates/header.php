<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Agencia Web - Panel de Administración</title>
    
    <!-- AdminLTE -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Dark/Light Mode Styles -->
    <style>
        :root {
            --primary-color: #007bff;
            --secondary-color: #6c757d;
            --success-color: #28a745;
            --danger-color: #dc3545;
            --warning-color: #ffc107;
            --info-color: #17a2b8;
            --light-color: #f8f9fa;
            --dark-color: #343a40;
            --body-bg: #f4f6f9;
            --body-color: #343a40;
            --card-bg: #ffffff;
            --card-border: rgba(0,0,0,.125);
            --sidebar-bg: #343a40;
            --sidebar-color: #c2c7d0;
            --navbar-bg: #ffffff;
            --navbar-color: #343a40;
        }

        [data-theme="dark"] {
            --body-bg: #1a1a1a;
            --body-color: #e9ecef;
            --card-bg: #2d3748;
            --card-border: #4a5568;
            --sidebar-bg: #1f2937;
            --sidebar-color: #cbd5e0;
            --navbar-bg: #2d3748;
            --navbar-color: #e9ecef;
        }

        body {
            background-color: var(--body-bg);
            color: var(--body-color);
            transition: all 0.3s ease;
        }

        .main-sidebar {
            background-color: var(--sidebar-bg) !important;
        }

        .main-sidebar .brand-link,
        .main-sidebar .nav-sidebar .nav-link {
            color: var(--sidebar-color) !important;
        }

        .main-header {
            background-color: var(--navbar-bg) !important;
        }

        .navbar-light .navbar-nav .nav-link {
            color: var(--navbar-color) !important;
        }

        .card {
            background-color: var(--card-bg);
            border-color: var(--card-border);
        }

        .table {
            color: var(--body-color);
        }

        .table th,
        .table td {
            border-color: var(--card-border);
        }

        .form-control {
            background-color: var(--card-bg);
            border-color: var(--card-border);
            color: var(--body-color);
        }

        .form-control:focus {
            background-color: var(--card-bg);
            border-color: var(--primary-color);
            color: var(--body-color);
        }

        .custom-file-label {
            background-color: var(--card-bg);
            border-color: var(--card-border);
            color: var(--body-color);
        }

        .input-group-text {
            background-color: var(--sidebar-bg);
            border-color: var(--card-border);
            color: var(--sidebar-color);
        }

        .btn-toggle-theme {
            background: transparent;
            border: 2px solid var(--secondary-color);
            color: var(--body-color);
            border-radius: 50%;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-toggle-theme:hover {
            border-color: var(--primary-color);
            transform: rotate(30deg);
        }

        .theme-icon {
            transition: all 0.3s ease;
        }

        [data-theme="dark"] .theme-icon.sun {
            display: block;
        }

        [data-theme="dark"] .theme-icon.moon {
            display: none;
        }

        [data-theme="light"] .theme-icon.sun {
            display: none;
        }

        [data-theme="light"] .theme-icon.moon {
            display: block;
        }

        /* Ajustes específicos para elementos de AdminLTE en dark mode */
        [data-theme="dark"] .small-box {
            color: #fff !important;
        }

        [data-theme="dark"] .bg-secondary {
            background-color: #4a5568 !important;
        }

        [data-theme="dark"] .bg-light {
            background-color: #4a5568 !important;
            color: #e9ecef !important;
        }

        [data-theme="dark"] .text-dark {
            color: #e9ecef !important;
        }

        [data-theme="dark"] .text-muted {
            color: #a0aec0 !important;
        }

        [data-theme="dark"] .alert-light {
            background-color: #4a5568;
            border-color: #718096;
            color: #e9ecef;
        }

        [data-theme="dark"] pre {
            background-color: #2d3748;
            border-color: #4a5568;
            color: #e9ecef;
        }

        [data-theme="dark"] code {
            background-color: #2d3748;
            color: #e9ecef;
        }

        [data-theme="dark"] .custom-control-label::before {
            background-color: var(--card-bg);
            border-color: var(--card-border);
        }
    </style>
</head>
<body class="hold-transition sidebar-mini" data-theme="<?= $_COOKIE['theme'] ?? 'light' ?>">
<div class="wrapper">