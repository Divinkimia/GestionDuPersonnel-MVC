<?php include_once('v_entete.php');?>
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body text-center">
                    <i class="bi bi-info-circle text-primary" style="font-size: 3rem;"></i>
                    <h4 class="mt-3"><?php echo htmlspecialchars($this->data['leMessage']); ?></h4>
                    <div class="mt-4">
                        <a href="index.php?page=listeEmployes&service=all" class="btn btn-primary">
                            <i class="bi bi-arrow-left"></i> Retour à la liste
                        </a>
                        <a href="index.php?page=dashboard" class="btn btn-outline-secondary">
                            <i class="bi bi-speedometer2"></i> Tableau de bord
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include_once('v_piedPage.php');?>