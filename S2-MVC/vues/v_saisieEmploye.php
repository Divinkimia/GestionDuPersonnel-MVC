<?php include_once ('v_entete.php');?>
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h3 class="mb-0"><i class="bi bi-person-plus"></i> Ajout d'un employé</h3>
                </div>
                <div class="card-body">
                    <form action="index.php?page=ajoutEmploye" method="post">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="matricule" class="form-label">Matricule <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="matricule" id="matricule" 
                                       maxlength="4" required placeholder="Ex: e001">
                                <small class="form-text text-muted">4 caractères maximum</small>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="service" class="form-label">Service <span class="text-danger">*</span></label>
                                <select class="form-select" name="service" id="service" required>
                                    <option value="">Sélectionner un service</option>
                                    <?php foreach ($this->data['lesServices'] as $unService): ?>
                                        <option value="<?php echo htmlspecialchars($unService->GetCode()); ?>">
                                            <?php echo htmlspecialchars($unService->GetDesignation()); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="nom" class="form-label">Nom <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="nom" id="nom" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="prenom" class="form-label">Prénom <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="prenom" id="prenom" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" name="email" id="email" 
                                       placeholder="exemple@email.com">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="telephone" class="form-label">Téléphone</label>
                                <input type="tel" class="form-control" name="telephone" id="telephone" 
                                       placeholder="01.23.45.67.89">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="poste" class="form-label">Poste</label>
                                <input type="text" class="form-control" name="poste" id="poste" 
                                       placeholder="Ex: Développeur, Chef de projet...">
                            </div>

                            <div class="col-md-3 mb-3">
                                <label for="date_embauche" class="form-label">Date d'embauche</label>
                                <input type="date" class="form-control" name="date_embauche" id="date_embauche">
                            </div>

                            <div class="col-md-3 mb-3">
                                <label for="salaire" class="form-label">Salaire (€)</label>
                                <input type="number" class="form-control" name="salaire" id="salaire" 
                                       step="0.01" min="0" placeholder="3000.00">
                            </div>
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <a href="index.php?page=listeEmployes&service=all" class="btn btn-secondary">
                                <i class="bi bi-arrow-left"></i> Annuler
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle"></i> Enregistrer
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include_once('v_piedPage.php');?>


