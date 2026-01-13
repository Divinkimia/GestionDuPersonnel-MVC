<?php include_once 'v_entete.php'; ?>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">
            <i class="bi bi-people-fill"></i>
            <?php 
                if (is_null($this->data['leService'])) {
                    echo 'Tous les employés';
                } else {
                    echo 'Service : ' . htmlspecialchars($this->data['leService']->GetDesignation());
                }
            ?>
        </h2>
        <div>
            <a href="index.php?page=saisieEmploye" class="btn btn-primary">
                <i class="bi bi-person-plus"></i> Ajouter un employé
            </a>
        </div>
    </div>

    <!-- Filtre par service -->
    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title"><i class="bi bi-funnel"></i> Filtrer par service</h5>
            <div class="btn-group" role="group">
                <a href="index.php?page=listeEmployes&service=all" 
                   class="btn <?php echo (is_null($this->data['leService'])) ? 'btn-primary' : 'btn-outline-primary'; ?>">
                    Tous
                </a>
                <?php foreach ($this->data['lesServices'] as $unService): ?>
                    <a href="index.php?page=listeEmployes&service=<?php echo htmlspecialchars($unService->GetCode()); ?>" 
                       class="btn <?php echo (!is_null($this->data['leService']) && $this->data['leService']->GetCode() == $unService->GetCode()) ? 'btn-primary' : 'btn-outline-primary'; ?>">
                        <?php echo htmlspecialchars($unService->GetDesignation()); ?>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <!-- Tableau des employés -->
    <div class="card">
        <div class="card-body">
            <?php if (empty($this->data['lesEmployes'])): ?>
                <div class="alert alert-info">
                    <i class="bi bi-info-circle"></i> Aucun employé trouvé.
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-hover table-striped">
                        <thead class="table-dark">
                            <tr>
                                <th>Matricule</th>
                                <th>Nom</th>
                                <th>Prénom</th>
                                <th>Poste</th>
                                <th>Email</th>
                                <th>Téléphone</th>
                                <th>Service</th>
                                <th>Date embauche</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($this->data['lesEmployes'] as $unEmploye): ?>
                                <tr>
                                    <td><strong><?php echo htmlspecialchars($unEmploye->GetMatricule()); ?></strong></td>
                                    <td><?php echo htmlspecialchars($unEmploye->GetNom()); ?></td>
                                    <td><?php echo htmlspecialchars($unEmploye->GetPrenom()); ?></td>
                                    <td><?php echo htmlspecialchars($unEmploye->GetPoste() ?? '-'); ?></td>
                                    <td>
                                        <?php if ($unEmploye->GetEmail()): ?>
                                            <a href="mailto:<?php echo htmlspecialchars($unEmploye->GetEmail()); ?>">
                                                <i class="bi bi-envelope"></i> <?php echo htmlspecialchars($unEmploye->GetEmail()); ?>
                                            </a>
                                        <?php else: ?>
                                            -
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if ($unEmploye->GetTelephone()): ?>
                                            <i class="bi bi-telephone"></i> <?php echo htmlspecialchars($unEmploye->GetTelephone()); ?>
                                        <?php else: ?>
                                            -
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <span class="badge bg-secondary"><?php echo htmlspecialchars($unEmploye->GetService()); ?></span>
                                    </td>
                                    <td>
                                        <?php if ($unEmploye->GetDateEmbauche()): ?>
                                            <?php echo date('d/m/Y', strtotime($unEmploye->GetDateEmbauche())); ?>
                                        <?php else: ?>
                                            -
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <a href="index.php?page=modifierEmploye&matricule=<?php echo htmlspecialchars($unEmploye->GetMatricule()); ?>" 
                                           class="btn btn-sm btn-warning btn-action" title="Modifier">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <a href="index.php?page=supprimerEmploye&matricule=<?php echo htmlspecialchars($unEmploye->GetMatricule()); ?>" 
                                           class="btn btn-sm btn-danger btn-action" 
                                           onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet employé ?');" 
                                           title="Supprimer">
                                            <i class="bi bi-trash"></i>
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

<?php include_once 'v_piedPage.php'; ?>

