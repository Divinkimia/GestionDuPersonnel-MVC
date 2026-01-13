<?php include_once('v_entete.php'); ?>

<div class="container mt-4">
    <h2>Inscription</h2>

    <?php if (!empty($message)): ?>
        <div class="alert alert-danger"><?php echo htmlspecialchars($message); ?></div>
    <?php endif; ?>

    <form action="index.php?page=registerAction" method="post" class="w-50">
        <div class="mb-3">
            <label class="form-label">Nom</label>
            <input type="text" name="nom" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Prénom</label>
            <input type="text" name="prenom" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Identifiant (login)</label>
            <input type="text" name="login" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Mot de passe</label>
            <input type="password" name="mdp" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">S'inscrire</button>
        <a href="index.php?page=login" class="btn btn-primary">Déjà inscrit ? Se connecter</a>
    </form>
</div>

<?php include_once('v_piedPage.php'); ?>