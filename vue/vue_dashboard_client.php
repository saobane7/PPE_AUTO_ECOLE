<?php

$client = $dash['client'] ?? [];
$stats = $dash['stats'] ?? [];
$cours_pratiques = $dash['cours_pratiques'] ?? [];
$cours_a_venir = $dash['cours_a_venir'] ?? [];
$cours_theoriques = $dash['cours_theoriques'] ?? [];
$cours_theoriques_disponibles = $dash['cours_theoriques_disponibles'] ?? [];
$examens = $dash['examens'] ?? [];
$moniteur_principal = $dash['moniteur_principal'] ?? null;
$prochain_cours = $dash['prochain_cours'] ?? null;
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Mon Espace Élève – SAT AUTO</title>
  <link rel="stylesheet" href="css/style.css">
  <style>
  
    .tab-content { display: none; }
    .tab-content.active-tab-content { display: block; }
    .active-tab { background: #ffd736 !important; color: #072031 !important; border-color: #ffd736 !important; }
  </style>
</head>
<body class="dash-page">


<?php if (isset($_SESSION['success'])): ?>
  <div style="max-width:1280px; margin:20px auto 0; padding:0 32px;">
    <div class="alert alert-success"><?php echo htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?></div>
  </div>
<?php endif; ?>
<?php if (isset($_SESSION['error'])): ?>
  <div style="max-width:1280px; margin:20px auto 0; padding:0 32px;">
    <div class="alert alert-error"><?php echo htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?></div>
  </div>
<?php endif; ?>


<div class="dash-topbar">
  <div class="dash-topbar-inner">
    <div class="dash-title">
      <svg width="22" height="22" fill="currentColor" viewBox="0 0 24 24" style="vertical-align:middle;margin-right:8px;">
        <path d="M12 3L1 9l11 6 9-4.91V17h2V9L12 3zM5 13.18v4L12 21l7-3.82v-4L12 17l-7-3.82z"/>
      </svg>
      Mon Espace Élève
    </div>
    <div style="display:flex;align-items:center;gap:16px;flex-wrap:wrap;">
      <span class="dash-user-info">
        <svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24">
          <path d="M12 12c2.7 0 4.8-2.1 4.8-4.8S14.7 2.4 12 2.4 7.2 4.5 7.2 7.2 9.3 12 12 12zm0 2.4c-3.2 0-9.6 1.6-9.6 4.8v2.4h19.2v-2.4c0-3.2-6.4-4.8-9.6-4.8z"/>
        </svg>
        <?php echo htmlspecialchars($_SESSION['prenom'] . ' ' . $_SESSION['nom']); ?>
        <span class="tag tag-y" style="margin-left:8px;"><?php echo htmlspecialchars($_SESSION['type_client']); ?></span>
      </span>
      <a href="index.php?page=deconnexion" class="btn btn-outline-w" style="font-size:.82rem;padding:9px 20px;">
        <svg width="14" height="14" fill="currentColor" viewBox="0 0 24 24">
          <path d="M17 7l-1.41 1.41L18.17 11H8v2h10.17l-2.58 2.58L17 17l5-5zM4 5h8V3H4c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h8v-2H4V5z"/>
        </svg>
        Déconnexion
      </a>
    </div>
  </div>
</div>

<div class="dash-layout">


  <aside class="dash-sidebar">
    <nav class="dash-nav">
      <button class="dash-nav-btn active" onclick="showSection('accueil', this)">
        <svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24">
          <path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z"/>
        </svg>
        Accueil
      </button>
      <button class="dash-nav-btn" onclick="showSection('profil', this)">
        <svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24">
          <path d="M12 12c2.7 0 4.8-2.1 4.8-4.8S14.7 2.4 12 2.4 7.2 4.5 7.2 7.2 9.3 12 12 12zm0 2.4c-3.2 0-9.6 1.6-9.6 4.8v2.4h19.2v-2.4c0-3.2-6.4-4.8-9.6-4.8z"/>
        </svg>
        Mon Profil
      </button>
      <button class="dash-nav-btn" onclick="showSection('pratiques', this)">
        <svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24">
          <path d="M18.92 6.01C18.72 5.42 18.16 5 17.5 5h-11c-.66 0-1.21.42-1.42 1.01L3 12v8c0 .55.45 1 1 1h1c.55 0 1-.45 1-1v-1h12v1c0 .55.45 1 1 1h1c.55 0 1-.45 1-1v-8l-2.08-5.99z"/>
        </svg>
        Cours pratiques (<?php echo count($cours_pratiques); ?>)
      </button>
      <button class="dash-nav-btn" onclick="showSection('theoriques', this)">
        <svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24">
          <path d="M18 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V4a2 2 0 00-2-2zM6 4h5v8l-2.5-1.5L6 12V4z"/>
        </svg>
        Cours théoriques (<?php echo count($cours_theoriques); ?>)
      </button>
      <button class="dash-nav-btn" onclick="showSection('examens', this)">
        <svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24">
          <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
        </svg>
        Examens (<?php echo count($examens); ?>)
      </button>
      <button class="dash-nav-btn" onclick="showSection('moniteur', this)">
        <svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24">
          <path d="M20 17v-8c0-2.21-3.58-4-8-4S4 6.79 4 9v8l-2 2v1h20v-1l-2-2zm-8 2c-.55 0-1-.45-1-1s.45-1 1-1 1 .45 1 1-.45 1-1 1zm6-2H6V9.1c.85-.74 2.69-1.6 6-1.6s5.15.86 6 1.6V17z"/>
        </svg>
        Mon Moniteur
      </button>
    </nav>
  </aside>

  <main class="dash-main">

    <div id="section-accueil" class="dash-section active">
      <h2 class="dash-sec-title">
        <svg width="22" height="22" fill="currentColor" viewBox="0 0 24 24">
          <path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z"/>
        </svg>
        Bienvenue, <?php echo htmlspecialchars($_SESSION['prenom']); ?> !
      </h2>
      
      <div class="stat-cards">
        <div class="stat-card">
          <div class="stat-card-num"><?php echo $stats['heures_conduite'] ?? 0; ?>h</div>
          <div class="stat-card-lbl">Heures de conduite</div>
        </div>
        <div class="stat-card">
          <div class="stat-card-num"><?php echo $stats['progression']['progression'] ?? 0; ?>%</div>
          <div class="stat-card-lbl">Progression</div>
        </div>
        <div class="stat-card">
          <div class="stat-card-num"><?php echo count($cours_a_venir); ?></div>
          <div class="stat-card-lbl">Cours à venir</div>
        </div>
        <div class="stat-card">
          <div class="stat-card-num"><?php echo $stats['nb_examens_reussis'] ?? 0; ?></div>
          <div class="stat-card-lbl">Examens réussis</div>
        </div>
      </div>
      
      <?php if ($prochain_cours): ?>
      <div style="background:#072031; border-radius:16px; padding:28px; color:#fff; margin-top:20px;">
        <div style="display:flex; align-items:center; gap:20px; flex-wrap:wrap;">
          <div style="background:#ffd736; color:#072031; width:64px; height:64px; border-radius:50%; display:flex; align-items:center; justify-content:center;">
            <svg width="32" height="32" fill="currentColor" viewBox="0 0 24 24">
              <path d="M18.92 6.01C18.72 5.42 18.16 5 17.5 5h-11c-.66 0-1.21.42-1.42 1.01L3 12v8c0 .55.45 1 1 1h1c.55 0 1-.45 1-1v-1h12v1c0 .55.45 1 1 1h1c.55 0 1-.45 1-1v-8l-2.08-5.99z"/>
            </svg>
          </div>
          <div>
            <div style="font-size:.8rem; text-transform:uppercase; letter-spacing:.15em; color:#ffd736; margin-bottom:5px;">Votre prochain cours</div>
            <div style="font-size:1.4rem; font-weight:700;"><?php echo date('d/m/Y', strtotime($prochain_cours['date_seance'])); ?> à <?php echo substr($prochain_cours['heure_debut'],0,5); ?></div>
            <div style="margin-top:5px;">Avec <?php echo htmlspecialchars($prochain_cours['moniteur_prenom'] . ' ' . $prochain_cours['moniteur_nom']); ?></div>
          </div>
        </div>
      </div>
      <?php endif; ?>
      
      <div style="background:#fff; border-radius:16px; padding:28px; margin-top:28px;">
        <div style="display:flex; justify-content:space-between; margin-bottom:15px;">
          <h3 style="font-size:1.1rem; font-weight:700; color:#072031;">Ma progression</h3>
          <span style="font-weight:800; color:#072031;"><?php echo $stats['progression']['heures_effectuees'] ?? 0; ?>h / <?php echo $stats['progression']['heures_minimum'] ?? 20; ?>h</span>
        </div>
        <div style="width:100%; height:14px; background:#eee; border-radius:50px; overflow:hidden;">
          <div style="width:<?php echo $stats['progression']['progression'] ?? 0; ?>%; height:100%; background:#ffd736; border-radius:50px;"></div>
        </div>
      </div>
    </div>


    <div id="section-profil" class="dash-section">
      <h2 class="dash-sec-title">
        <svg width="22" height="22" fill="currentColor" viewBox="0 0 24 24">
          <path d="M12 12c2.7 0 4.8-2.1 4.8-4.8S14.7 2.4 12 2.4 7.2 4.5 7.2 7.2 9.3 12 12 12zm0 2.4c-3.2 0-9.6 1.6-9.6 4.8v2.4h19.2v-2.4c0-3.2-6.4-4.8-9.6-4.8z"/>
        </svg>
        Mon Profil
      </h2>
      
      <div style="background:#fff; border-radius:16px; padding:32px;">
        <form method="POST" action="index.php?page=profil_client">
          <div style="display:grid; grid-template-columns:1fr 1fr; gap:20px;">
            <div class="form-group">
              <label for="nom">Nom</label>
              <input type="text" id="nom" name="nom" class="form-control" value="<?php echo htmlspecialchars($client['nom'] ?? $_SESSION['nom']); ?>" required>
            </div>
            <div class="form-group">
              <label for="prenom">Prénom</label>
              <input type="text" id="prenom" name="prenom" class="form-control" value="<?php echo htmlspecialchars($client['prenom'] ?? $_SESSION['prenom']); ?>" required>
            </div>
          </div>
          
          <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" class="form-control" value="<?php echo htmlspecialchars($client['email'] ?? $_SESSION['email']); ?>" disabled>
            <span class="form-hint">L'email ne peut pas être modifié</span>
          </div>
          
          <div class="form-group">
            <label for="telephone">Téléphone</label>
            <input type="tel" id="telephone" name="telephone" class="form-control" value="<?php echo htmlspecialchars($client['telephone'] ?? $_SESSION['telephone']); ?>" required>
          </div>
          
          <div class="form-group">
            <label for="date_naissance">Date de naissance</label>
            <input type="date" id="date_naissance" name="date_naissance" class="form-control" value="<?php echo $client['date_naissance'] ?? ''; ?>" required>
          </div>
          
          <div class="form-group">
            <label for="type">Profil</label>
            <select id="type" name="type" class="form-control" required>
              <option value="etudiant" <?php echo ($client['type'] ?? $_SESSION['type_client']) == 'etudiant' ? 'selected' : ''; ?>>Étudiant</option>
              <option value="particulier" <?php echo ($client['type'] ?? $_SESSION['type_client']) == 'particulier' ? 'selected' : ''; ?>>Particulier</option>
              <option value="professionnel" <?php echo ($client['type'] ?? $_SESSION['type_client']) == 'professionnel' ? 'selected' : ''; ?>>Professionnel</option>
            </select>
          </div>
          
          <div style="margin-top:30px;">
            <button type="submit" name="Modifier" class="btn btn-blue">
              Mettre à jour mon profil
            </button>
          </div>
        </form>
      </div>
    </div>


    <div id="section-pratiques" class="dash-section">
      <h2 class="dash-sec-title">
        <svg width="22" height="22" fill="currentColor" viewBox="0 0 24 24">
          <path d="M18.92 6.01C18.72 5.42 18.16 5 17.5 5h-11c-.66 0-1.21.42-1.42 1.01L3 12v8c0 .55.45 1 1 1h1c.55 0 1-.45 1-1v-1h12v1c0 .55.45 1 1 1h1c.55 0 1-.45 1-1v-8l-2.08-5.99z"/>
        </svg>
        Mes Cours de Conduite
      </h2>
      
      <div style="display:flex; gap:10px; margin-bottom:24px;">
        <button onclick="showTab('pratiques_tous', this)" class="btn btn-yellow active-tab">Tous</button>
        <button onclick="showTab('pratiques_a_venir', this)" class="btn btn-outline-y">À venir</button>
        <button onclick="showTab('pratiques_termines', this)" class="btn btn-outline-y">Passés</button>
      </div>
      
      <div id="pratiques_tous" class="tab-content active-tab-content">
        <?php if (count($cours_pratiques) > 0): ?>
        <div class="tbl-wrap">
          <table class="data-table">
            <thead><tr><th>Date</th><th>Horaire</th><th>Moniteur</th><th>Durée</th><th>Statut</th></tr></thead>
            <tbody>
            <?php foreach ($cours_pratiques as $cp): ?>
            <tr>
              <td><?php echo date('d/m/Y', strtotime($cp['date_seance'])); ?></td>
              <td><?php echo substr($cp['heure_debut'],0,5).' – '.substr($cp['heure_fin'],0,5); ?></td>
              <td><?php echo htmlspecialchars($cp['moniteur_prenom'].' '.$cp['moniteur_nom']); ?></td>
              <td><?php echo $cp['duree_heures'] ?? '1'; ?>h</td>
              <td><span class="tag <?php echo $cp['statut'] === 'termine' ? 'tag-g' : ($cp['statut'] === 'annule' ? 'tag-r' : 'tag-y'); ?>"><?php echo $cp['statut']; ?></span></td>
            </tr>
            <?php endforeach; ?>
            </tbody>
          </table>
        </div>
        <?php else: ?>
        <div class="empty-box"><p>Aucun cours pratique.</p></div>
        <?php endif; ?>
      </div>
      
      <div id="pratiques_a_venir" class="tab-content">
        <?php if (count($cours_a_venir) > 0): ?>
        <div class="tbl-wrap">
          <table class="data-table">
            <thead><tr><th>Date</th><th>Horaire</th><th>Moniteur</th><th>Téléphone</th></tr></thead>
            <tbody>
            <?php foreach ($cours_a_venir as $cp): ?>
            <tr>
              <td><?php echo date('d/m/Y', strtotime($cp['date_seance'])); ?></td>
              <td><?php echo substr($cp['heure_debut'],0,5).' – '.substr($cp['heure_fin'],0,5); ?></td>
              <td><?php echo htmlspecialchars($cp['moniteur_prenom'].' '.$cp['moniteur_nom']); ?></td>
              <td><?php echo htmlspecialchars($cp['moniteur_telephone'] ?? '—'); ?></td>
            </tr>
            <?php endforeach; ?>
            </tbody>
          </table>
        </div>
        <?php else: ?>
        <div class="empty-box"><p>Aucun cours à venir.</p></div>
        <?php endif; ?>
      </div>
      
      <div id="pratiques_termines" class="tab-content">
        <?php 
        $cours_passes = array_filter($cours_pratiques, fn($c) => $c['statut'] === 'termine');
        if (count($cours_passes) > 0): 
        ?>
        <div class="tbl-wrap">
          <table class="data-table">
            <thead><tr><th>Date</th><th>Moniteur</th><th>Notes</th></tr></thead>
            <tbody>
            <?php foreach ($cours_passes as $cp): ?>
            <tr>
              <td><?php echo date('d/m/Y', strtotime($cp['date_seance'])); ?></td>
              <td><?php echo htmlspecialchars($cp['moniteur_prenom'].' '.$cp['moniteur_nom']); ?></td>
              <td><?php echo htmlspecialchars($cp['notes'] ?? '—'); ?></td>
            </tr>
            <?php endforeach; ?>
            </tbody>
          </table>
        </div>
        <?php else: ?>
        <div class="empty-box"><p>Aucun cours terminé.</p></div>
        <?php endif; ?>
      </div>
    </div>

    <div id="section-theoriques" class="dash-section">
      <h2 class="dash-sec-title">
        <svg width="22" height="22" fill="currentColor" viewBox="0 0 24 24">
          <path d="M18 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V4a2 2 0 00-2-2zM6 4h5v8l-2.5-1.5L6 12V4z"/>
        </svg>
        Mes Cours Théoriques
      </h2>
      
      <h3 style="margin-bottom:15px;">Mes inscriptions</h3>
      <?php if (count($cours_theoriques) > 0): ?>
      <div class="tbl-wrap" style="margin-bottom:30px;">
        <table class="data-table">
          <thead><tr><th>Titre</th><th>Date</th><th>Horaire</th><th>Salle</th><th>Statut</th></tr></thead>
          <tbody>
          <?php foreach ($cours_theoriques as $ct): ?>
          <tr>
            <td><?php echo htmlspecialchars($ct['titre']); ?></td>
            <td><?php echo date('d/m/Y', strtotime($ct['date_cours'])); ?></td>
            <td><?php echo substr($ct['heure_debut'],0,5).' – '.substr($ct['heure_fin'],0,5); ?></td>
            <td><?php echo htmlspecialchars($ct['salle'] ?? '—'); ?></td>
            <td><span class="tag <?php echo $ct['statut'] === 'termine' ? 'tag-g' : 'tag-y'; ?>"><?php echo $ct['statut']; ?></span></td>
          </tr>
          <?php endforeach; ?>
          </tbody>
        </table>
      </div>
      <?php else: ?>
      <div class="empty-box" style="margin-bottom:30px;"><p>Vous n'êtes inscrit à aucun cours théorique.</p></div>
      <?php endif; ?>
      
      <h3 style="margin-bottom:15px;">Cours disponibles</h3>
      <?php if (count($cours_theoriques_disponibles) > 0): ?>
      <div class="tbl-wrap">
        <table class="data-table">
          <thead><tr><th>Titre</th><th>Date</th><th>Horaire</th><th>Salle</th><th>Action</th></tr></thead>
          <tbody>
          <?php foreach ($cours_theoriques_disponibles as $ct): ?>
          <tr>
            <td><?php echo htmlspecialchars($ct['titre']); ?></td>
            <td><?php echo date('d/m/Y', strtotime($ct['date_cours'])); ?></td>
            <td><?php echo substr($ct['heure_debut'],0,5).' – '.substr($ct['heure_fin'],0,5); ?></td>
            <td><?php echo htmlspecialchars($ct['salle'] ?? '—'); ?></td>
            <td><a href="index.php?page=inscription_cours_theorique&id_cours=<?php echo $ct['id_cours']; ?>" class="btn btn-yellow" style="padding:6px 12px;">S'inscrire</a></td>
          </tr>
          <?php endforeach; ?>
          </tbody>
        </table>
      </div>
      <?php else: ?>
      <div class="empty-box"><p>Aucun cours théorique disponible.</p></div>
      <?php endif; ?>
    </div>

    <div id="section-examens" class="dash-section">
      <h2 class="dash-sec-title">
        <svg width="22" height="22" fill="currentColor" viewBox="0 0 24 24">
          <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
        </svg>
        Mes Examens
      </h2>
      
      <?php if (count($examens) > 0): ?>
      <div class="tbl-wrap">
        <table class="data-table">
          <thead><tr><th>Type</th><th>Date</th><th>Heure</th><th>Lieu</th><th>Résultat</th></tr></thead>
          <tbody>
          <?php foreach ($examens as $e): ?>
          <tr>
            <td><span class="tag tag-b"><?php echo $e['type']; ?></span></td>
            <td><?php echo date('d/m/Y', strtotime($e['date_examen'])); ?></td>
            <td><?php echo substr($e['heure'],0,5); ?></td>
            <td><?php echo htmlspecialchars($e['lieu'] ?? '—'); ?></td>
            <td>
              <?php if ($e['resultat']): ?>
                <span class="tag <?php echo $e['resultat'] === 'reussi' ? 'tag-g' : 'tag-r'; ?>"><?php echo $e['resultat']; ?></span>
              <?php else: ?>
                <span class="tag tag-gr">En attente</span>
              <?php endif; ?>
            </td>
          </tr>
          <?php endforeach; ?>
          </tbody>
        </table>
      </div>
      <?php else: ?>
      <div class="empty-box"><p>Aucun examen programmé.</p></div>
      <?php endif; ?>
    </div>


    <div id="section-moniteur" class="dash-section">
      <h2 class="dash-sec-title">
        <svg width="22" height="22" fill="currentColor" viewBox="0 0 24 24">
          <path d="M20 17v-8c0-2.21-3.58-4-8-4S4 6.79 4 9v8l-2 2v1h20v-1l-2-2zm-8 2c-.55 0-1-.45-1-1s.45-1 1-1 1 .45 1 1-.45 1-1 1zm6-2H6V9.1c.85-.74 2.69-1.6 6-1.6s5.15.86 6 1.6V17z"/>
        </svg>
        Mon Moniteur
      </h2>
      
      <?php if ($moniteur_principal): ?>
      <div style="background:#fff; border-radius:16px; padding:32px; text-align:center;">
        <div style="width:120px; height:120px; background:#072031; border-radius:50%; display:flex; align-items:center; justify-content:center; margin:0 auto 20px; color:#ffd736; border:5px solid #ffd736;">
          <svg width="60" height="60" fill="currentColor" viewBox="0 0 24 24">
            <path d="M20 17v-8c0-2.21-3.58-4-8-4S4 6.79 4 9v8l-2 2v1h20v-1l-2-2zm-8 2c-.55 0-1-.45-1-1s.45-1 1-1 1 .45 1 1-.45 1-1 1zm6-2H6V9.1c.85-.74 2.69-1.6 6-1.6s5.15.86 6 1.6V17z"/>
          </svg>
        </div>
        <h3 style="font-size:1.6rem; color:#072031;"><?php echo htmlspecialchars($moniteur_principal['prenom'] . ' ' . $moniteur_principal['nom']); ?></h3>
        <span class="tag tag-y" style="margin-bottom:20px;">Agrément: <?php echo htmlspecialchars($moniteur_principal['numero_agrement']); ?></span>
        
        <div style="text-align:left; margin-top:20px;">
          <div style="padding:10px 0; border-bottom:1px solid #eee;">
            <strong>Email:</strong> <?php echo htmlspecialchars($moniteur_principal['email']); ?>
          </div>
          <div style="padding:10px 0; border-bottom:1px solid #eee;">
            <strong>Téléphone:</strong> <?php echo htmlspecialchars($moniteur_principal['telephone']); ?>
          </div>
          <div style="padding:10px 0;">
            <strong>Embauche:</strong> <?php echo date('d/m/Y', strtotime($moniteur_principal['date_embauche'])); ?>
          </div>
        </div>
      </div>
      <?php else: ?>
      <div class="empty-box"><p>Vous n'avez pas encore de moniteur attitré.</p></div>
      <?php endif; ?>
    </div>

  </main>
</div>

<script>

function showSection(sectionId, btn) {
  // Cacher toutes les sections
  document.querySelectorAll('.dash-section').forEach(s => {
    s.classList.remove('active');
  });
  

  document.querySelectorAll('.dash-nav-btn').forEach(b => {
    b.classList.remove('active');
  });
  

  document.getElementById('section-' + sectionId).classList.add('active');
  

  if (btn) {
    btn.classList.add('active');
  }
}


function showTab(tabId, btn) {
  // Désactiver tous les onglets du parent
  const parent = btn.closest('.dash-section');
  if (parent) {
    parent.querySelectorAll('.tab-content').forEach(t => {
      t.classList.remove('active-tab-content');
    });
    
    parent.querySelectorAll('.btn').forEach(b => {
      b.classList.remove('btn-yellow', 'active-tab');
      b.classList.add('btn-outline-y');
    });
  }
  

  document.getElementById(tabId).classList.add('active-tab-content');
  
  // Activer le bouton
  btn.classList.remove('btn-outline-y');
  btn.classList.add('btn-yellow', 'active-tab');
}


document.addEventListener('DOMContentLoaded', function() {
  // Vérifier s'il y a un hash dans l'URL pour ouvrir une section spécifique
  const hash = window.location.hash.substring(1);
  if (hash) {
    const sectionMap = {
      'profil': 'profil',
      'pratiques': 'pratiques',
      'theoriques': 'theoriques',
      'examens': 'examens',
      'moniteur': 'moniteur'
    };
    
    if (sectionMap[hash]) {
      const btn = document.querySelector(`.dash-nav-btn[onclick*="'${sectionMap[hash]}'"]`);
      if (btn) {
        showSection(sectionMap[hash], btn);
      }
    }
  }
});
</script>

</body>
</html>