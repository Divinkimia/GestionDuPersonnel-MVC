<?php
/*
require_once "../modeles/M_generique.php";

$m = new M_generique();
$m->Connexion();
$cnx = $m->GetCnx();

$login = $argv[1] ?? ($_POST['login'] ?? 'testuser');
$mdp   = $argv[2] ?? ($_POST['mdp'] ?? 'password');

$hash = password_hash($mdp, PASSWORD_BCRYPT);

$stmt = $cnx->prepare("INSERT INTO user (login, mot_de_passe) VALUES (?, ?)");
$stmt->bind_param("ss", $login, $hash);
$ok = $stmt->execute();
if ($ok) echo "User created: $login\n"; else echo "Erreur: ".$stmt->error."\n";
$stmt->close();
$m->Deconnexion();*/