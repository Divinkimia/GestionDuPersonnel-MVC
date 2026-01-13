<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="Content-Language" content="fr" />
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Gestion du personnel</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        :root {
            --primary-color: #0d6efd;
            --secondary-color: #6c757d;
            --success-color: #198754;
            --danger-color: #dc3545;
            --warning-color: #ffc107;
            --info-color: #0dcaf0;
        }
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .navbar-brand {
            font-weight: 600;
            font-size: 1.3rem;
        }
        .card {
            border: none;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            transition: box-shadow 0.15s ease-in-out;
        }
        .card:hover {
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        }
        .table {
            background-color: white;
        }
        .btn-action {
            margin: 0 2px;
        }
        .stat-card {
            border-left: 4px solid var(--primary-color);
        }
        .stat-card.success {
            border-left-color: var(--success-color);
        }
        .stat-card.warning {
            border-left-color: var(--warning-color);
        }
        .stat-card.info {
            border-left-color: var(--info-color);
        }
    </style>
</head>
<body>
    <!-- Header noir -->
    <nav class="navbar navbar-expand-lg bg-dark navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="index.php?page=accueil">Gestion du personnel</a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="mainNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?page=dashboard">
                            <i class="bi bi-speedometer2"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?page=accueil">
                            <i class="bi bi-house"></i> Accueil
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?page=saisieEmploye">
                            <i class="bi bi-person-plus"></i> Ajouter un employé
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?service=all&page=listeEmployes">
                            <i class="bi bi-people"></i> Liste des employés
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?page=rechercherEmployes">
                            <i class="bi bi-search"></i> Rechercher
                        </a>
                    </li>
                </ul>

                <ul class="navbar-nav ms-auto">
                    <?php if (!empty($_SESSION['loginU'])): ?>
                        <li class="nav-item">
                            <span class="navbar-text me-2">
                                <i class="bi bi-person-circle"></i> Bonjour, <?php echo htmlspecialchars($_SESSION['loginU']); ?>
                            </span>
                        </li>
                        <li class="nav-item">
                            <a class="btn btn-outline-light btn-sm" href="index.php?page=logout">
                                <i class="bi bi-box-arrow-right"></i> Déconnexion
                            </a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item me-2">
                            <a class="btn btn-outline-light btn-sm" href="index.php?page=login">
                                <i class="bi bi-box-arrow-in-right"></i> Connexion
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="btn btn-outline-light btn-sm" href="index.php?page=register">
                                <i class="bi bi-person-plus"></i> Inscription
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>

            </div>
        </div>
    </nav>

    <div class="container mt-4">