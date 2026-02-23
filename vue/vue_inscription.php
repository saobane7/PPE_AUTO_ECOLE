<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Inscription – SAT AUTO</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body class="auth-bg">

  <header class="header">
    <div class="nav-inner">
      <a href="index.php" class="logo-wrap">
        <span class="logo-name">SAT AUTO</span>
      </a>
      <a href="index.php?page=connexion" class="btn btn-outline-y" style="font-size:.82rem;padding:10px 22px;">
        <svg width="14" height="14" fill="currentColor" viewBox="0 0 24 24"><path d="M11 7L9.6 8.4l2.6 2.6H2v2h10.2l-2.6 2.6L11 17l5-5-5-5zm9 12h-8v2h8c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2h-8v2h8v14z"/></svg>
        Déjà inscrit ? Connexion
      </a>
    </div>
  </header>

  <div class="auth-body">
    <div class="auth-card">
      <h2>
        <svg width="28" height="28" fill="#ffd736" viewBox="0 0 24 24" style="vertical-align:middle;margin-right:8px;"><path d="M15 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm-9-2V7H4v3H1v2h3v3h2v-3h3v-2H6zm9 4c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
        Inscription Client
      </h2>

      <?php
        if (isset($_SESSION['error'])) { echo '<div class="alert alert-error">' . htmlspecialchars($_SESSION['error']) . '</div>'; unset($_SESSION['error']); }
      ?>

      <form method="POST" action="index.php?page=inscription">

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">
          <div class="form-group">
            <label for="nom">Nom *</label>
            <input type="text" id="nom" name="nom" class="form-control" placeholder="DUPONT" required>
          </div>
          <div class="form-group">
            <label for="prenom">Prénom *</label>
            <input type="text" id="prenom" name="prenom" class="form-control" placeholder="Jean" required>
          </div>
        </div>

        <div class="form-group">
          <label for="email">Email *</label>
          <input type="email" id="email" name="email" class="form-control" placeholder="jean.dupont@email.com" required>
        </div>

        <div class="form-group">
          <label for="mdp">Mot de passe *</label>
          <input type="password" id="mdp" name="mdp" class="form-control" placeholder="Minimum 6 caractères" required minlength="6">
          <span class="form-hint">Au moins 6 caractères</span>
        </div>

        <div class="form-group">
          <label for="telephone">Téléphone *</label>
          <input type="tel" id="telephone" name="telephone" class="form-control" placeholder="06 12 34 56 78" required>
        </div>

        <div class="form-group">
          <label for="date_naissance">Date de naissance *</label>
          <input type="date" id="date_naissance" name="date_naissance" class="form-control" required>
        </div>

        <div class="form-group">
          <label for="type">Profil *</label>
          <select id="type" name="type" class="form-control" required>
            <option value="">— Choisir —</option>
            <option value="etudiant">Étudiant</option>
            <option value="particulier">Particulier</option>
            <option value="professionnel">Professionnel</option>
          </select>
        </div>

        <button type="submit" name="Inscription" class="btn btn-blue" style="width:100%;justify-content:center;padding:15px;">
          <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24"><path d="M15 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm-9-2V7H4v3H1v2h3v3h2v-3h3v-2H6zm9 4c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
          Créer mon compte
        </button>
      </form>

      <div class="auth-switch">
        Déjà un compte ? <a href="index.php?page=connexion">Se connecter</a>
      </div>
    </div>
  </div>

</body>
</html>