<?php include_once('v_entete.php'); ?>

<div class="container mt-4">
    <h2>Connexion</h2>

    <?php if (!empty($_GET['registered'])): ?>
        <div class="alert alert-success">Inscription réussie. Vous pouvez maintenant vous connecter.</div>
    <?php endif; ?>

    <?php if (!empty($message)): ?>
        <div class="alert alert-danger"><?php echo htmlspecialchars($message); ?></div>
    <?php endif; ?>

    <form action="index.php?page=loginAction" method="post" class="w-50">
        <div class="mb-3">
            <label class="form-label">Login :</label>
            <input type="text" name="login" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Mot de passe :</label>
            <input type="password" name="mdp" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Se connecter</button>
        <a href="index.php?page=register" class="btn btn-link">S'inscrire</a>
    </form>
</div>

<?php include_once('v_piedPage.php'); ?>