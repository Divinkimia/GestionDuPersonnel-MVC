<?php include_once 'v_entete.php'; ?>

<div class="container mt-4">
    <div class="card">
        <div class="card-header bg-info text-white">
            <h3 class="mb-0"><i class="bi bi-search"></i> Rechercher des employés</h3>
        </div>
        <div class="card-body">
            <form action="index.php?page=rechercherEmployes" method="get" class="mb-4">
                <input type="hidden" name="page" value="rechercherEmployes">
                <div class="input-group">
                    <input type="text" class="form-control form-control-lg" 
                           name="q" id="q" 
                           placeholder="Rechercher par nom, prénom, matricule, email ou poste..." 
                           value="<?php echo htmlspecialchars($this->data['critere'] ?? ''); ?>">
                    <button class="btn btn-primary" type="submit">
                        <i class="bi bi-search"></i> Rechercher
                    </button>
                </div>
            </form>

            <?php if (!empty($this->data['critere'])): ?>
                <div class="alert alert-info">
                    <i class="bi bi-info-circle"></i> 
                    Résultats de la recherche pour : <strong><?php echo htmlspecialchars($this->data['critere']); ?></strong>
                </div>
            <?php endif; ?>

            <?php if (empty($this->data['lesEmployes'])): ?>
                <?php if (!empty($this->data['critere'])): ?>
                    <div class="alert alert-warning">
                        <i class="bi bi-exclamation-triangle"></i> Aucun résultat trouvé pour votre recherche.
                    </div>
                <?php else: ?>
                    <div class="alert alert-secondary">
                        <i class="bi bi-info-circle"></i> Entrez un terme de recherche pour commencer.
                    </div>
                <?php endif; ?>
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
