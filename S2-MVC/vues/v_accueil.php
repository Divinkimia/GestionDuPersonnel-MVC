<?php include_once ('v_entete.php');?>
<div class="container mt-4">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body text-center">
                    <h1 class="display-4 mb-4">
                        <i class="bi bi-building text-primary"></i> 
                        Système de Gestion du Personnel
                    </h1>
                    <p class="lead mb-4">
                        Bienvenue dans votre espace de gestion du personnel professionnel
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-4 mb-3">
            <div class="card h-100">
                <div class="card-body text-center">
                    <i class="bi bi-speedometer2 text-primary" style="font-size: 3rem;"></i>
                    <h5 class="card-title mt-3">Tableau de bord</h5>
                    <p class="card-text">Consultez les statistiques et indicateurs clés</p>
                    <a href="index.php?page=dashboard" class="btn btn-primary">
                        <i class="bi bi-arrow-right"></i> Accéder
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-3">
            <div class="card h-100">
                <div class="card-body text-center">
                    <i class="bi bi-people text-success" style="font-size: 3rem;"></i>
                    <h5 class="card-title mt-3">Gestion des employés</h5>
                    <p class="card-text">Consultez, ajoutez, modifiez ou supprimez des employés</p>
                    <a href="index.php?page=listeEmployes&service=all" class="btn btn-success">
                        <i class="bi bi-arrow-right"></i> Accéder
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-3">
            <div class="card h-100">
                <div class="card-body text-center">
                    <i class="bi bi-search text-info" style="font-size: 3rem;"></i>
                    <h5 class="card-title mt-3">Recherche avancée</h5>
                    <p class="card-text">Recherchez rapidement un employé dans la base</p>
                    <a href="index.php?page=rechercherEmployes" class="btn btn-info">
                        <i class="bi bi-arrow-right"></i> Accéder
                    </a>
                </div>
            </div>
        </div>
    </div>

    <?php if (file_exists('./images/accueil.jpg')): ?>
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card">
                <img src="./images/accueil.jpg" class="card-img-top" alt="Accueil">
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>
<?php include_once('v_piedPage.php');?>
