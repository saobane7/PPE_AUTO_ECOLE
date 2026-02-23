<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Connexion – SAT AUTO</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body class="auth-bg">

  <header class="header">
    <div class="nav-inner">
      <a href="index.php" class="logo-wrap">
        <span class="logo-name">SAT AUTO</span>
      </a>
      <a href="index.php" class="btn btn-outline-y" style="font-size:.82rem;padding:10px 22px;">
        <svg width="14" height="14" fill="currentColor" viewBox="0 0 24 24"><path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"/></svg>
        Retour à l'accueil
      </a>
    </div>
  </header>

  <div class="auth-body">
    <div class="auth-card">
      <h2>
        <svg width="28" height="28" fill="#ffd736" viewBox="0 0 24 24" style="vertical-align:middle;margin-right:8px;"><path d="M11 7L9.6 8.4l2.6 2.6H2v2h10.2l-2.6 2.6L11 17l5-5-5-5zm9 12h-8v2h8c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2h-8v2h8v14z"/></svg>
        Connexion
      </h2>

      <?php
        if (isset($_SESSION['error']))   { echo '<div class="alert alert-error">'  . htmlspecialchars($_SESSION['error'])   . '</div>'; unset($_SESSION['error']); }
        if (isset($_SESSION['success'])) { echo '<div class="alert alert-success">' . htmlspecialchars($_SESSION['success']) . '</div>'; unset($_SESSION['success']); }
      ?>

      <form method="POST" action="index.php?page=connexion">
        <div class="form-group">
          <label for="type_user">Je suis :</label>
          <select id="type_user" name="type_user" class="form-control" required>
            <option value="">— Choisir mon profil —</option>
            <option value="client">Client / Élève</option>
            <option value="moniteur">Moniteur</option>
            <option value="admin">Administrateur</option>
          </select>
        </div>

        <div class="form-group">
          <label for="email">Adresse email</label>
          <input type="email" id="email" name="email" class="form-control" placeholder="exemple@email.com" required>
        </div>

        <div class="form-group">
          <label for="mdp">Mot de passe</label>
          <input type="password" id="mdp" name="mdp" class="form-control" placeholder="••••••••" required>
        </div>

        <button type="submit" name="Connexion" class="btn btn-blue" style="width:100%;justify-content:center;padding:15px;">
          <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24"><path d="M11 7L9.6 8.4l2.6 2.6H2v2h10.2l-2.6 2.6L11 17l5-5-5-5zm9 12h-8v2h8c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2h-8v2h8v14z"/></svg>
          Se connecter
        </button>
      </form>

      <div class="auth-switch">
        Pas encore de compte ? <a href="index.php?page=inscription">S'inscrire</a>
      </div>
    </div>
  </div>

</body>
</html>