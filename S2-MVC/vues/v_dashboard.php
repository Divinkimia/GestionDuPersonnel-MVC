<?php include_once 'v_entete.php'; ?>

<div class="container mt-4">
    <h2 class="mb-4"><i class="bi bi-speedometer2"></i> Tableau de bord</h2>

    <?php 
        $stats = $this->data['statistiques'];
    ?>

    <!-- Cartes statistiques -->
    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-2">Total employés</h6>
                            <h2 class="mb-0"><?php echo $stats['total']; ?></h2>
                        </div>
                        <div class="text-primary" style="font-size: 2.5rem;">
                            <i class="bi bi-people-fill"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card stat-card success">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-2">Services actifs</h6>
                            <h2 class="mb-0"><?php echo count($stats['par_service']); ?></h2>
                        </div>
                        <div class="text-success" style="font-size: 2.5rem;">
                            <i class="bi bi-building"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card stat-card info">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-2">Moyenne/service</h6>
                            <h2 class="mb-0">
                                <?php 
                                    $moyenne = count($stats['par_service']) > 0 
                                        ? round($stats['total'] / count($stats['par_service']), 1) 
                                        : 0; 
                                    echo $moyenne;
                                ?>
                            </h2>
                        </div>
                        <div class="text-info" style="font-size: 2.5rem;">
                            <i class="bi bi-graph-up"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card stat-card warning">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-2">Actions rapides</h6>
                            <a href="index.php?page=saisieEmploye" class="btn btn-sm btn-primary">
                                <i class="bi bi-person-plus"></i> Ajouter
                            </a>
                        </div>
                        <div class="text-warning" style="font-size: 2.5rem;">
                            <i class="bi bi-lightning-charge"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Répartition par service -->
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="bi bi-pie-chart"></i> Répartition des employés par service</h5>
                </div>
                <div class="card-body">
                    <?php if (empty($stats['par_service'])): ?>
                        <div class="alert alert-info">Aucun service trouvé.</div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Service</th>
                                        <th>Nombre d'employés</th>
                                        <th>Pourcentage</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($stats['par_service'] as $service): ?>
                                        <tr>
                                            <td><strong><?php echo htmlspecialchars($service['sce_designation']); ?></strong></td>
                                            <td>
                                                <span class="badge bg-primary"><?php echo $service['nb']; ?></span>
                                            </td>
                                            <td>
                                                <div class="progress" style="height: 25px;">
                                                    <?php 
                                                        $pourcentage = $stats['total'] > 0 
                                                            ? round(($service['nb'] / $stats['total']) * 100, 1) 
                                                            : 0;
                                                    ?>
                                                    <div class="progress-bar" role="progressbar" 
                                                         style="width: <?php echo $pourcentage; ?>%" 
                                                         aria-valuenow="<?php echo $pourcentage; ?>" 
                                                         aria-valuemin="0" 
                                                         aria-valuemax="100">
                                                        <?php echo $pourcentage; ?>%
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <a href="index.php?page=listeEmployes&service=<?php echo htmlspecialchars($service['sce_code'] ?? ''); ?>" 
                                                   class="btn btn-sm btn-outline-primary">
                                                    <i class="bi bi-eye"></i> Voir
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0"><i class="bi bi-list-check"></i> Actions rapides</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="index.php?page=saisieEmploye" class="btn btn-primary">
                            <i class="bi bi-person-plus"></i> Ajouter un employé
                        </a>
                        <a href="index.php?page=listeEmployes&service=all" class="btn btn-outline-primary">
                            <i class="bi bi-people"></i> Liste des employés
                        </a>
                        <a href="index.php?page=rechercherEmployes" class="btn btn-outline-info">
                            <i class="bi bi-search"></i> Rechercher
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include_once 'v_piedPage.php'; ?>
