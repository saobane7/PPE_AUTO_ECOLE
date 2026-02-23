<?php

$clients = $dash['clients'] ?? [];
$moniteurs = $dash['moniteurs'] ?? [];
$cours_theoriques = $dash['cours_theoriques'] ?? [];
$cours_pratiques = $dash['cours_pratiques'] ?? [];
$examens = $dash['examens'] ?? [];
$stats = $dash['stats'] ?? [];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard Admin – SAT AUTO</title>
  <link rel="stylesheet" href="css/style.css">
  <style>
    .modal {
      display: none;
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0,0,0,0.7);
      z-index: 1000;
      overflow-y: auto;
    }
    .modal-content {
      background: #fff;
      max-width: 600px;
      margin: 50px auto;
      padding: 30px;
      border-radius: 16px;
      position: relative;
    }
    .close {
      position: absolute;
      right: 20px;
      top: 20px;
      font-size: 24px;
      cursor: pointer;
      color: #666;
    }
    .close:hover { color: #f44336; }
    .action-buttons {
      display: flex;
      gap: 5px;
      justify-content: flex-end;
    }
    .btn-icon {
      padding: 6px 12px;
      border-radius: 6px;
      border: none;
      cursor: pointer;
      font-size: .8rem;
      display: inline-flex;
      align-items: center;
      gap: 5px;
    }
    .btn-edit { background: #ffd736; color: #072031; }
    .btn-delete { background: #f44336; color: white; }
    .btn-view { background: #072031; color: #ffd736; }
    .alert {
      padding: 12px 16px;
      border-radius: 8px;
      margin-bottom: 20px;
    }
    .alert-success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
    .alert-error { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
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
      <svg width="22" height="22" fill="currentColor" viewBox="0 0 24 24">
        <path d="M3 13h8V3H3v10zm0 8h8v-6H3v6zm10 0h8V11h-8v10zm0-18v6h8V3h-8z"/>
      </svg>
      Dashboard Administrateur
    </div>
    <div style="display:flex;align-items:center;gap:16px;">
      <span class="dash-user-info">
        <svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24">
          <path d="M12 12c2.7 0 4.8-2.1 4.8-4.8S14.7 2.4 12 2.4 7.2 4.5 7.2 7.2 9.3 12 12 12z"/>
        </svg>
        <?php echo htmlspecialchars($_SESSION['prenom'].' '.$_SESSION['nom']); ?>
        <span style="background:#ffd736;color:#072031;padding:2px 10px;border-radius:50px;font-size:.72rem;">ADMIN</span>
      </span>
      <a href="index.php?page=deconnexion" class="btn btn-outline-w">Déconnexion</a>
    </div>
  </div>
</div>

<div class="dash-layout">

  <aside class="dash-sidebar">
    <nav class="dash-nav">
      <button class="dash-nav-btn active" onclick="show('accueil',this)">
        <svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24"><path d="M3 13h8V3H3v10zm0 8h8v-6H3v6zm10 0h8V11h-8v10zm0-18v6h8V3h-8z"/></svg>
        Vue d'ensemble
      </button>
      <button class="dash-nav-btn" onclick="show('clients',this)">
        <svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24"><path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3z"/></svg>
        Clients (<?php echo count($clients); ?>)
      </button>
      <button class="dash-nav-btn" onclick="show('moniteurs',this)">
        <svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24"><path d="M20 17v-8c0-2.21-3.58-4-8-4S4 6.79 4 9v8l-2 2v1h20v-1l-2-2z"/></svg>
        Moniteurs (<?php echo count($moniteurs); ?>)
      </button>
      <button class="dash-nav-btn" onclick="show('cours',this)">
        <svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24"><path d="M18.92 6.01C18.72 5.42 18.16 5 17.5 5h-11c-.66 0-1.21.42-1.42 1.01L3 12v8c0 .55.45 1 1 1h1c.55 0 1-.45 1-1v-1h12v1c0 .55.45 1 1 1h1c.55 0 1-.45 1-1v-8l-2.08-5.99z"/></svg>
        Cours
      </button>
      <button class="dash-nav-btn" onclick="show('examens',this)">
        <svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
        Examens (<?php echo count($examens); ?>)
      </button>
      <button class="dash-nav-btn" onclick="show('statistiques',this)">
        <svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zM9 17H7v-7h2v7zm4 0h-2V7h2v10zm4 0h-2v-4h2v4z"/></svg>
        Statistiques
      </button>
    </nav>
  </aside>

  <main class="dash-main">

    <div id="accueil" class="dash-section active">
      <h2 class="dash-sec-title">Vue d'ensemble</h2>
      <div class="stat-cards">
        <div class="stat-card">
          <div class="stat-card-num"><?php echo $stats['nb_clients'] ?? 0; ?></div>
          <div class="stat-card-lbl">Clients</div>
          <a href="#" onclick="show('clients', document.querySelectorAll('.dash-nav-btn')[1]); return false;" style="color:#ffd736; font-size:.8rem; margin-top:10px; display:block;">Gérer →</a>
        </div>
        <div class="stat-card">
          <div class="stat-card-num"><?php echo $stats['nb_moniteurs'] ?? 0; ?></div>
          <div class="stat-card-lbl">Moniteurs</div>
          <a href="#" onclick="show('moniteurs', document.querySelectorAll('.dash-nav-btn')[2]); return false;" style="color:#ffd736; font-size:.8rem; margin-top:10px; display:block;">Gérer →</a>
        </div>
        <div class="stat-card">
          <div class="stat-card-num"><?php echo $stats['nb_cours_pratiques'] ?? 0; ?></div>
          <div class="stat-card-lbl">Cours pratiques</div>
        </div>
        <div class="stat-card">
          <div class="stat-card-num"><?php echo $stats['nb_cours_theoriques'] ?? 0; ?></div>
          <div class="stat-card-lbl">Cours théoriques</div>
        </div>
        <div class="stat-card">
          <div class="stat-card-num"><?php echo $stats['nb_examens'] ?? 0; ?></div>
          <div class="stat-card-lbl">Examens</div>
        </div>
      </div>
      

      <div style="background:#fff; border-radius:16px; padding:24px; margin-top:30px;">
        <h3 style="margin-bottom:20px; display:flex; align-items:center; gap:10px;">
          <svg width="20" height="20" fill="#ffd736" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8z"/></svg>
          Dernières activités
        </h3>
        <div style="display:flex; flex-direction:column; gap:10px;">
          <?php foreach ($tableauDeBord['dernieres_activites'] as $activite): ?>
          <div style="display:flex; align-items:center; gap:15px; padding:10px; border-bottom:1px solid #eee;">
            <span class="tag <?php 
              echo $activite['type'] === 'client' ? 'tag-y' : 
                ($activite['type'] === 'moniteur' ? 'tag-b' : 
                  ($activite['type'] === 'cours' ? 'tag-g' : 'tag-gr')); 
            ?>">
              <?php echo $activite['type']; ?>
            </span>
            <div style="flex:1;">
              <span style="font-weight:600;"><?php echo htmlspecialchars($activite['nom']); ?></span>
              <span style="color:#666; margin-left:10px;"><?php echo $activite['action']; ?></span>
            </div>
            <span style="font-size:.8rem; color:#999;"><?php echo date('d/m/Y H:i', strtotime($activite['date'])); ?></span>
          </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>


    <div id="clients" class="dash-section">
      <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:24px;">
        <h2 class="dash-sec-title" style="margin-bottom:0;">
          <svg width="22" height="22" fill="currentColor" viewBox="0 0 24 24"><path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3z"/></svg>
          Gestion des Clients
        </h2>
        <button onclick="openModal('ajouterClient')" class="btn btn-yellow">
          <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24"><path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/></svg>
          Nouveau client
        </button>
      </div>
      
      <div style="margin-bottom:20px;">
        <input type="text" id="searchClient" placeholder="Rechercher un client (nom, email, téléphone)..." class="form-control" style="max-width:400px;" onkeyup="filterTable('clientsTable', this.value)">
      </div>
      
      <?php if (count($clients) > 0): ?>
      <div class="tbl-wrap">
        <table class="data-table" id="clientsTable">
          <thead>
            <tr>
              <th>ID</th>
              <th>Nom</th>
              <th>Prénom</th>
              <th>Email</th>
              <th>Téléphone</th>
              <th>Profil</th>
              <th>Date naissance</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
          <?php foreach ($clients as $c): ?>
          <tr id="client-<?php echo $c['id_client']; ?>">
            <td>#<?php echo $c['id_client']; ?></td>
            <td><strong><?php echo htmlspecialchars($c['nom']); ?></strong></td>
            <td><?php echo htmlspecialchars($c['prenom']); ?></td>
            <td><?php echo htmlspecialchars($c['email']); ?></td>
            <td><?php echo htmlspecialchars($c['telephone']); ?></td>
            <td><span class="tag tag-y"><?php echo htmlspecialchars($c['type']); ?></span></td>
            <td><?php echo date('d/m/Y', strtotime($c['date_naissance'])); ?></td>
            <td>
              <div class="action-buttons">
                <button onclick="openEditClientModal(<?php echo $c['id_client']; ?>, '<?php echo htmlspecialchars(addslashes($c['nom'])); ?>', '<?php echo htmlspecialchars(addslashes($c['prenom'])); ?>', '<?php echo htmlspecialchars(addslashes($c['telephone'])); ?>', '<?php echo $c['date_naissance']; ?>', '<?php echo $c['type']; ?>')" class="btn-icon btn-edit">
                  ✏️ Modifier
                </button>
                <button onclick="deleteClient(<?php echo $c['id_client']; ?>)" class="btn-icon btn-delete">
                  🗑️ Supprimer
                </button>
              </div>
            </td>
          </tr>
          <?php endforeach; ?>
          </tbody>
        </table>
      </div>
      <?php else: ?>
      <div class="empty-box">
        <p>Aucun client enregistré.</p>
      </div>
      <?php endif; ?>
    </div>

    

    <div id="moniteurs" class="dash-section">
      <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:24px;">
        <h2 class="dash-sec-title" style="margin-bottom:0;">
          <svg width="22" height="22" fill="currentColor" viewBox="0 0 24 24"><path d="M20 17v-8c0-2.21-3.58-4-8-4S4 6.79 4 9v8l-2 2v1h20v-1l-2-2z"/></svg>
          Gestion des Moniteurs
        </h2>
        <button onclick="openModal('ajouterMoniteur')" class="btn btn-yellow">
          <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24"><path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/></svg>
          Nouveau moniteur
        </button>
      </div>
      
      <div style="margin-bottom:20px;">
        <input type="text" id="searchMoniteur" placeholder="Rechercher un moniteur..." class="form-control" style="max-width:400px;" onkeyup="filterTable('moniteursTable', this.value)">
      </div>
      

      <?php if (count($moniteurs) > 0): ?>
      <div class="tbl-wrap">
        <table class="data-table" id="moniteursTable">
          <thead>
            <tr>
              <th>ID</th>
              <th>Nom</th>
              <th>Prénom</th>
              <th>Email</th>
              <th>Téléphone</th>
              <th>Agrément</th>
              <th>Embauche</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
          <?php foreach ($moniteurs as $m): ?>
          <tr id="moniteur-<?php echo $m['id_moniteur']; ?>">
            <td>#<?php echo $m['id_moniteur']; ?></td>
            <td><strong><?php echo htmlspecialchars($m['nom']); ?></strong></td>
            <td><?php echo htmlspecialchars($m['prenom']); ?></td>
            <td><?php echo htmlspecialchars($m['email']); ?></td>
            <td><?php echo htmlspecialchars($m['telephone']); ?></td>
            <td><span class="tag tag-b"><?php echo htmlspecialchars($m['numero_agrement']); ?></span></td>
            <td><?php echo date('d/m/Y', strtotime($m['date_embauche'])); ?></td>
            <td>
              <div class="action-buttons">
                <button onclick="openEditMoniteurModal(<?php echo $m['id_moniteur']; ?>, '<?php echo htmlspecialchars(addslashes($m['nom'])); ?>', '<?php echo htmlspecialchars(addslashes($m['prenom'])); ?>', '<?php echo htmlspecialchars(addslashes($m['email'])); ?>', '<?php echo htmlspecialchars(addslashes($m['telephone'])); ?>', '<?php echo $m['date_embauche']; ?>', '<?php echo htmlspecialchars(addslashes($m['numero_agrement'])); ?>')" class="btn-icon btn-edit">
                  ✏️ Modifier
                </button>
                <button onclick="deleteMoniteur(<?php echo $m['id_moniteur']; ?>)" class="btn-icon btn-delete">
                  🗑️ Supprimer
                </button>
              </div>
            </td>
          </tr>
          <?php endforeach; ?>
          </tbody>
        </table>
      </div>
      <?php else: ?>
      <div class="empty-box">
        <p>Aucun moniteur enregistré.</p>
      </div>
      <?php endif; ?>
    </div>


    <div id="cours" class="dash-section">
      <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:24px;">
        <h2 class="dash-sec-title" style="margin-bottom:0;">
          <svg width="22" height="22" fill="currentColor" viewBox="0 0 24 24"><path d="M18.92 6.01C18.72 5.42 18.16 5 17.5 5h-11c-.66 0-1.21.42-1.42 1.01L3 12v8c0 .55.45 1 1 1h1c.55 0 1-.45 1-1v-1h12v1c0 .55.45 1 1 1h1c.55 0 1-.45 1-1v-8l-2.08-5.99z"/></svg>
          Gestion des Cours
        </h2>
        <div style="display:flex; gap:10px;">
          <button onclick="openModal('ajouterCoursPratique')" class="btn btn-yellow">
            <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24"><path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/></svg>
            Nouveau cours pratique
          </button>
          <button onclick="openModal('ajouterCoursTheorique')" class="btn btn-outline-y">
            <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24"><path d="M18 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V4a2 2 0 00-2-2zM6 4h5v8l-2.5-1.5L6 12V4z"/></svg>
            Cours théorique
          </button>
        </div>
      </div>
      

      <div style="display:flex; gap:10px; margin-bottom:20px;">
        <button onclick="showTab('pratiques', this)" class="btn btn-yellow active-tab">Cours pratiques</button>
        <button onclick="showTab('theoriques', this)" class="btn btn-outline-y">Cours théoriques</button>
      </div>
      

      <div id="pratiques" class="tab-content active-tab-content">
        <?php if (count($cours_pratiques) > 0): ?>
        <div class="tbl-wrap">
          <table class="data-table">
            <thead>
              <tr>
                <th>Date</th>
                <th>Horaire</th>
                <th>Client</th>
                <th>Moniteur</th>
                <th>Véhicule</th>
                <th>Statut</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
            <?php foreach ($cours_pratiques as $cp): ?>
            <tr>
              <td><?php echo date('d/m/Y', strtotime($cp['date_seance'])); ?></td>
              <td><?php echo substr($cp['heure_debut'],0,5).' – '.substr($cp['heure_fin'],0,5); ?></td>
              <td><?php echo htmlspecialchars($cp['client_prenom'].' '.$cp['client_nom']); ?></td>
              <td><?php echo htmlspecialchars($cp['moniteur_prenom'].' '.$cp['moniteur_nom']); ?></td>
              <td><?php echo htmlspecialchars($cp['type_vehicule']); ?></td>
              <td><span class="tag <?php echo $cp['statut'] === 'termine' ? 'tag-g' : ($cp['statut'] === 'annule' ? 'tag-r' : 'tag-y'); ?>"><?php echo $cp['statut']; ?></span></td>
              <td>
                <div class="action-buttons">
                  <button onclick="deleteCours(<?php echo $cp['id_seance']; ?>)" class="btn-icon btn-delete">🗑️</button>
                </div>
              </td>
            </tr>
            <?php endforeach; ?>
            </tbody>
          </table>
        </div>
        <?php else: ?>
        <div class="empty-box">
          <p>Aucun cours pratique planifié.</p>
        </div>
        <?php endif; ?>
      </div>
      

      <div id="theoriques" class="tab-content">
        <?php if (count($cours_theoriques) > 0): ?>
        <div class="tbl-wrap">
          <table class="data-table">
            <thead>
              <tr>
                <th>Titre</th>
                <th>Date</th>
                <th>Horaire</th>
                <th>Salle</th>
                <th>Places</th>
                <th>Inscrits</th>
                <th>Statut</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
            <?php foreach ($cours_theoriques as $ct): ?>
            <tr>
              <td><strong><?php echo htmlspecialchars($ct['titre']); ?></strong></td>
              <td><?php echo date('d/m/Y', strtotime($ct['date_cours'])); ?></td>
              <td><?php echo substr($ct['heure_debut'],0,5).' – '.substr($ct['heure_fin'],0,5); ?></td>
              <td><?php echo htmlspecialchars($ct['salle'] ?? '—'); ?></td>
              <td><?php echo $ct['places_max']; ?></td>
              <td><?php echo $ct['nb_inscrits']; ?></td>
              <td><span class="tag <?php echo $ct['statut'] === 'termine' ? 'tag-g' : ($ct['statut'] === 'annule' ? 'tag-r' : 'tag-y'); ?>"><?php echo $ct['statut']; ?></span></td>
              <td>
                <div class="action-buttons">
                  <button onclick="deleteCoursTheorique(<?php echo $ct['id_cours']; ?>)" class="btn-icon btn-delete">🗑️</button>
                </div>
              </td>
            </tr>
            <?php endforeach; ?>
            </tbody>
          </table>
        </div>
        <?php else: ?>
        <div class="empty-box">
          <p>Aucun cours théorique planifié.</p>
        </div>
        <?php endif; ?>
      </div>
    </div>


    <div id="examens" class="dash-section">
      <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:24px;">
        <h2 class="dash-sec-title" style="margin-bottom:0;">
          <svg width="22" height="22" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
          Gestion des Examens
        </h2>
        <button onclick="openModal('ajouterExamen')" class="btn btn-yellow">
          <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24"><path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/></svg>
          Planifier un examen
        </button>
      </div>
      
      <?php if (count($examens) > 0): ?>
      <div class="tbl-wrap">
        <table class="data-table">
          <thead>
            <tr>
              <th>Type</th>
              <th>Date</th>
              <th>Heure</th>
              <th>Client</th>
              <th>Lieu</th>
              <th>Résultat</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
          <?php foreach ($examens as $e): ?>
          <tr>
            <td><span class="tag tag-b"><?php echo $e['type']; ?></span></td>
            <td><?php echo date('d/m/Y', strtotime($e['date_examen'])); ?></td>
            <td><?php echo substr($e['heure'],0,5); ?></td>
            <td><?php echo htmlspecialchars($e['client_prenom'].' '.$e['client_nom']); ?></td>
            <td><?php echo htmlspecialchars($e['lieu'] ?? '—'); ?></td>
            <td>
              <?php if ($e['resultat']): ?>
                <span class="tag <?php echo $e['resultat'] === 'reussi' ? 'tag-g' : 'tag-r'; ?>"><?php echo $e['resultat']; ?></span>
              <?php else: ?>
                <span class="tag tag-gr">En attente</span>
              <?php endif; ?>
            </td>
            <td>
              <div class="action-buttons">
                <?php if (!$e['resultat']): ?>
                <button onclick="openResultatModal(<?php echo $e['id_examen']; ?>)" class="btn-icon btn-edit">📝 Résultat</button>
                <?php endif; ?>
                <button onclick="deleteExamen(<?php echo $e['id_examen']; ?>)" class="btn-icon btn-delete">🗑️</button>
              </div>
            </td>
          </tr>
          <?php endforeach; ?>
          </tbody>
        </table>
      </div>
      <?php else: ?>
      <div class="empty-box">
        <p>Aucun examen planifié.</p>
      </div>
      <?php endif; ?>
    </div>


    <div id="statistiques" class="dash-section">
      <h2 class="dash-sec-title">Statistiques</h2>
      
      <div style="display:grid; grid-template-columns:1fr 1fr; gap:30px;">
        <div style="background:#fff; border-radius:16px; padding:24px;">
          <h3 style="margin-bottom:20px;">Répartition des clients</h3>
          <?php 
          $total_clients = array_sum($tableauDeBord['clients_par_type']);
          foreach ($tableauDeBord['clients_par_type'] as $type => $count): 
            $pourcentage = $total_clients > 0 ? round(($count / $total_clients) * 100) : 0;
          ?>
          <div style="margin-bottom:15px;">
            <div style="display:flex; justify-content:space-between; margin-bottom:5px;">
              <span><?php echo ucfirst($type); ?></span>
              <span><?php echo $count; ?> (<?php echo $pourcentage; ?>%)</span>
            </div>
            <div style="width:100%; height:10px; background:#eee; border-radius:5px;">
              <div style="width:<?php echo $pourcentage; ?>%; height:100%; background:#ffd736; border-radius:5px;"></div>
            </div>
          </div>
          <?php endforeach; ?>
        </div>
        
        <div style="background:#fff; border-radius:16px; padding:24px;">
          <h3 style="margin-bottom:20px;">Examens</h3>
          <div style="display:flex; justify-content:space-around; text-align:center;">
            <div>
              <div style="font-size:2rem; font-weight:700; color:#072031;"><?php echo $tableauDeBord['examens_par_resultat']['reussi']; ?></div>
              <div>Réussis</div>
            </div>
            <div>
              <div style="font-size:2rem; font-weight:700; color:#072031;"><?php echo $tableauDeBord['examens_par_resultat']['echoue']; ?></div>
              <div>Échoués</div>
            </div>
            <div>
              <div style="font-size:2rem; font-weight:700; color:#072031;"><?php echo $tableauDeBord['examens_par_resultat']['en_attente']; ?></div>
              <div>En attente</div>
            </div>
          </div>
          <?php 
          $total_resultats = $tableauDeBord['examens_par_resultat']['reussi'] + $tableauDeBord['examens_par_resultat']['echoue'];
          $taux_reussite = $total_resultats > 0 ? round(($tableauDeBord['examens_par_resultat']['reussi'] / $total_resultats) * 100) : 0;
          ?>
          <div style="margin-top:20px; text-align:center;">
            <span class="tag tag-g">Taux de réussite: <?php echo $taux_reussite; ?>%</span>
          </div>
        </div>
        
        <div style="background:#fff; border-radius:16px; padding:24px; grid-column:span 2;">
          <h3 style="margin-bottom:20px;">Statut des cours</h3>
          <div style="display:flex; gap:30px; justify-content:space-around;">
            <?php foreach ($tableauDeBord['cours_par_statut'] as $statut => $count): ?>
            <div style="text-align:center;">
              <div style="font-size:2rem; font-weight:700; color:#072031;"><?php echo $count; ?></div>
              <div style="text-transform:uppercase; font-size:.8rem;"><?php echo $statut; ?></div>
            </div>
            <?php endforeach; ?>
          </div>
        </div>
      </div>
    </div>

  </main>
</div>



<div id="modal-ajouterClient" class="modal">
  <div class="modal-content">
    <span class="close" onclick="closeModal('ajouterClient')">&times;</span>
    <h2 style="margin-bottom:20px; color:#072031;">Ajouter un client</h2>
    <form method="POST" action="index.php?page=ajouter_client">
      <div style="display:grid; grid-template-columns:1fr 1fr; gap:15px;">
        <div class="form-group">
          <label>Nom *</label>
          <input type="text" name="nom" class="form-control" required>
        </div>
        <div class="form-group">
          <label>Prénom *</label>
          <input type="text" name="prenom" class="form-control" required>
        </div>
      </div>
      <div class="form-group">
        <label>Email *</label>
        <input type="email" name="email" class="form-control" required>
      </div>
      <div class="form-group">
        <label>Mot de passe *</label>
        <input type="password" name="mdp" class="form-control" required minlength="6">
      </div>
      <div class="form-group">
        <label>Téléphone *</label>
        <input type="tel" name="telephone" class="form-control" required>
      </div>
      <div class="form-group">
        <label>Date de naissance *</label>
        <input type="date" name="date_naissance" class="form-control" required>
      </div>
      <div class="form-group">
        <label>Profil *</label>
        <select name="type" class="form-control" required>
          <option value="particulier">Particulier</option>
          <option value="etudiant">Étudiant</option>
          <option value="professionnel">Professionnel</option>
        </select>
      </div>
      <div style="margin-top:20px;">
        <button type="submit" name="AjouterClient" class="btn btn-yellow" style="width:100%;">Ajouter le client</button>
      </div>
    </form>
  </div>
</div>



<div id="modal-ajouterMoniteur" class="modal">
  <div class="modal-content">
    <span class="close" onclick="closeModal('ajouterMoniteur')">&times;</span>
    <h2 style="margin-bottom:20px; color:#072031;">Ajouter un moniteur</h2>
    <form method="POST" action="index.php?page=ajouter_moniteur">
      <div style="display:grid; grid-template-columns:1fr 1fr; gap:15px;">
        <div class="form-group">
          <label>Nom *</label>
          <input type="text" name="nom" class="form-control" required>
        </div>
        <div class="form-group">
          <label>Prénom *</label>
          <input type="text" name="prenom" class="form-control" required>
        </div>
      </div>
      <div class="form-group">
        <label>Email *</label>
        <input type="email" name="email" class="form-control" required>
      </div>
      <div class="form-group">
        <label>Mot de passe *</label>
        <input type="password" name="mdp" class="form-control" required minlength="6">
      </div>
      <div class="form-group">
        <label>Téléphone *</label>
        <input type="tel" name="telephone" class="form-control" required>
      </div>
      <div class="form-group">
        <label>Date d'embauche *</label>
        <input type="date" name="date_embauche" class="form-control" required>
      </div>
      <div class="form-group">
        <label>Numéro d'agrément *</label>
        <input type="text" name="numero_agrement" class="form-control" required>
      </div>
      <div style="margin-top:20px;">
        <button type="submit" name="AjouterMoniteur" class="btn btn-yellow" style="width:100%;">Ajouter le moniteur</button>
      </div>
    </form>
  </div>
</div>



<div id="modal-ajouterCoursPratique" class="modal">
  <div class="modal-content">
    <span class="close" onclick="closeModal('ajouterCoursPratique')">&times;</span>
    <h2 style="margin-bottom:20px; color:#072031;">Planifier un cours pratique</h2>
    <form method="POST" action="index.php?page=ajouter_cours_pratique">
      <div class="form-group">
        <label>Date *</label>
        <input type="date" name="date_seance" class="form-control" required>
      </div>
      <div style="display:grid; grid-template-columns:1fr 1fr; gap:15px;">
        <div class="form-group">
          <label>Heure début *</label>
          <input type="time" name="heure_debut" class="form-control" required>
        </div>
        <div class="form-group">
          <label>Heure fin *</label>
          <input type="time" name="heure_fin" class="form-control" required>
        </div>
      </div>
      <div class="form-group">
        <label>Client *</label>
        <select name="id_client" class="form-control" required>
          <option value="">Sélectionner un client</option>
          <?php foreach ($clients as $client): ?>
          <option value="<?php echo $client['id_client']; ?>"><?php echo htmlspecialchars($client['prenom'].' '.$client['nom']); ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="form-group">
        <label>Moniteur *</label>
        <select name="id_moniteur" class="form-control" required>
          <option value="">Sélectionner un moniteur</option>
          <?php foreach ($moniteurs as $moniteur): ?>
          <option value="<?php echo $moniteur['id_moniteur']; ?>"><?php echo htmlspecialchars($moniteur['prenom'].' '.$moniteur['nom']); ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="form-group">
        <label>Véhicule</label>
        <input type="text" name="type_vehicule" class="form-control" value="voiture">
      </div>
      <div class="form-group">
        <label>Notes</label>
        <textarea name="notes" class="form-control" rows="2"></textarea>
      </div>
      <div style="margin-top:20px;">
        <button type="submit" name="AjouterCoursPratique" class="btn btn-yellow" style="width:100%;">Planifier le cours</button>
      </div>
    </form>
  </div>
</div>


<div id="modal-ajouterCoursTheorique" class="modal">
  <div class="modal-content">
    <span class="close" onclick="closeModal('ajouterCoursTheorique')">&times;</span>
    <h2 style="margin-bottom:20px; color:#072031;">Ajouter un cours théorique</h2>
    <form method="POST" action="index.php?page=ajouter_cours_theorique">
      <div class="form-group">
        <label>Titre *</label>
        <input type="text" name="titre" class="form-control" required>
      </div>
      <div class="form-group">
        <label>Date *</label>
        <input type="date" name="date_cours" class="form-control" required>
      </div>
      <div style="display:grid; grid-template-columns:1fr 1fr; gap:15px;">
        <div class="form-group">
          <label>Heure début *</label>
          <input type="time" name="heure_debut" class="form-control" required>
        </div>
        <div class="form-group">
          <label>Heure fin *</label>
          <input type="time" name="heure_fin" class="form-control" required>
        </div>
      </div>
      <div class="form-group">
        <label>Salle</label>
        <input type="text" name="salle" class="form-control">
      </div>
      <div class="form-group">
        <label>Places maximum</label>
        <input type="number" name="places_max" class="form-control" value="20" min="1">
      </div>
      <div style="margin-top:20px;">
        <button type="submit" name="AjouterCoursTheorique" class="btn btn-yellow" style="width:100%;">Ajouter le cours</button>
      </div>
    </form>
  </div>
</div>


<div id="modal-ajouterExamen" class="modal">
  <div class="modal-content">
    <span class="close" onclick="closeModal('ajouterExamen')">&times;</span>
    <h2 style="margin-bottom:20px; color:#072031;">Planifier un examen</h2>
    <form method="POST" action="index.php?page=ajouter_examen">
      <div class="form-group">
        <label>Type *</label>
        <select name="type" class="form-control" required>
          <option value="theorique">Théorique (Code)</option>
          <option value="pratique">Pratique (Conduite)</option>
        </select>
      </div>
      <div class="form-group">
        <label>Date *</label>
        <input type="date" name="date_examen" class="form-control" required>
      </div>
      <div class="form-group">
        <label>Heure *</label>
        <input type="time" name="heure" class="form-control" required>
      </div>
      <div class="form-group">
        <label>Client *</label>
        <select name="id_client" class="form-control" required>
          <option value="">Sélectionner un client</option>
          <?php foreach ($clients as $client): ?>
          <option value="<?php echo $client['id_client']; ?>"><?php echo htmlspecialchars($client['prenom'].' '.$client['nom']); ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="form-group">
        <label>Lieu</label>
        <input type="text" name="lieu" class="form-control" placeholder="Ex: Paris, Créteil...">
      </div>
      <div class="form-group">
        <label>Notes</label>
        <textarea name="notes" class="form-control" rows="2"></textarea>
      </div>
      <div style="margin-top:20px;">
        <button type="submit" name="AjouterExamen" class="btn btn-yellow" style="width:100%;">Planifier l'examen</button>
      </div>
    </form>
  </div>
</div>


<div id="modal-editClient" class="modal">
  <div class="modal-content">
    <span class="close" onclick="closeModal('editClient')">&times;</span>
    <h2 style="margin-bottom:20px; color:#072031;">Modifier le client</h2>
    <form method="POST" action="index.php?page=modifier_client">
      <input type="hidden" name="id_client" id="edit_client_id">
      <div style="display:grid; grid-template-columns:1fr 1fr; gap:15px;">
        <div class="form-group">
          <label>Nom *</label>
          <input type="text" name="nom" id="edit_client_nom" class="form-control" required>
        </div>
        <div class="form-group">
          <label>Prénom *</label>
          <input type="text" name="prenom" id="edit_client_prenom" class="form-control" required>
        </div>
      </div>
      <div class="form-group">
        <label>Téléphone *</label>
        <input type="tel" name="telephone" id="edit_client_telephone" class="form-control" required>
      </div>
      <div class="form-group">
        <label>Date de naissance *</label>
        <input type="date" name="date_naissance" id="edit_client_date_naissance" class="form-control" required>
      </div>
      <div class="form-group">
        <label>Profil *</label>
        <select name="type" id="edit_client_type" class="form-control" required>
          <option value="particulier">Particulier</option>
          <option value="etudiant">Étudiant</option>
          <option value="professionnel">Professionnel</option>
        </select>
      </div>
      <div style="margin-top:20px;">
        <button type="submit" name="ModifierClient" class="btn btn-yellow" style="width:100%;">Mettre à jour</button>
      </div>
    </form>
  </div>
</div>


<div id="modal-editMoniteur" class="modal">
  <div class="modal-content">
    <span class="close" onclick="closeModal('editMoniteur')">&times;</span>
    <h2 style="margin-bottom:20px; color:#072031;">Modifier le moniteur</h2>
    <form method="POST" action="index.php?page=modifier_moniteur">
      <input type="hidden" name="id_moniteur" id="edit_moniteur_id">
      <div style="display:grid; grid-template-columns:1fr 1fr; gap:15px;">
        <div class="form-group">
          <label>Nom *</label>
          <input type="text" name="nom" id="edit_moniteur_nom" class="form-control" required>
        </div>
        <div class="form-group">
          <label>Prénom *</label>
          <input type="text" name="prenom" id="edit_moniteur_prenom" class="form-control" required>
        </div>
      </div>
      <div class="form-group">
        <label>Email</label>
        <input type="email" name="email" id="edit_moniteur_email" class="form-control" readonly style="background:#f5f5f5;">
      </div>
      <div class="form-group">
        <label>Téléphone *</label>
        <input type="tel" name="telephone" id="edit_moniteur_telephone" class="form-control" required>
      </div>
      <div class="form-group">
        <label>Date d'embauche</label>
        <input type="date" name="date_embauche" id="edit_moniteur_date_embauche" class="form-control" required>
      </div>
      <div class="form-group">
        <label>Numéro d'agrément</label>
        <input type="text" name="numero_agrement" id="edit_moniteur_agrement" class="form-control" required>
      </div>
      <div style="margin-top:20px;">
        <button type="submit" name="ModifierMoniteur" class="btn btn-yellow" style="width:100%;">Mettre à jour</button>
      </div>
    </form>
  </div>
</div>


<div id="modal-resultatExamen" class="modal">
  <div class="modal-content">
    <span class="close" onclick="closeModal('resultatExamen')">&times;</span>
    <h2 style="margin-bottom:20px; color:#072031;">Enregistrer le résultat</h2>
    <form method="POST" action="index.php?page=resultat_examen">
      <input type="hidden" name="id_examen" id="resultat_examen_id">
      <div class="form-group">
        <label>Résultat *</label>
        <select name="resultat" class="form-control" required>
          <option value="reussi">Réussi</option>
          <option value="echoue">Échoué</option>
        </select>
      </div>
      <div class="form-group">
        <label>Notes</label>
        <textarea name="notes" class="form-control" rows="3" placeholder="Observations..."></textarea>
      </div>
      <div style="margin-top:20px;">
        <button type="submit" name="EnregistrerResultat" class="btn btn-yellow" style="width:100%;">Enregistrer</button>
      </div>
    </form>
  </div>
</div>

<script>

function show(id, btn) {
  document.querySelectorAll('.dash-section').forEach(s => s.classList.remove('active'));
  document.querySelectorAll('.dash-nav-btn').forEach(b => b.classList.remove('active'));
  document.getElementById(id).classList.add('active');
  btn.classList.add('active');
}


function showTab(tabId, btn) {
  const parent = btn.closest('#cours');
  parent.querySelectorAll('.tab-content').forEach(t => t.classList.remove('active-tab-content'));
  parent.querySelectorAll('.btn').forEach(b => {
    b.classList.remove('btn-yellow', 'active-tab');
    b.classList.add('btn-outline-y');
  });
  document.getElementById(tabId).classList.add('active-tab-content');
  btn.classList.remove('btn-outline-y');
  btn.classList.add('btn-yellow', 'active-tab');
}


function openModal(modalName) {
  document.getElementById('modal-' + modalName).style.display = 'block';
}

function closeModal(modalName) {
  document.getElementById('modal-' + modalName).style.display = 'none';
}


window.onclick = function(event) {
  if (event.target.classList.contains('modal')) {
    event.target.style.display = 'none';
  }
}

function filterTable(tableId, searchText) {
  const table = document.getElementById(tableId);
  const rows = table.getElementsByTagName('tr');
  const filter = searchText.toLowerCase();
  
  for (let i = 1; i < rows.length; i++) {
    const row = rows[i];
    let text = '';
    const cells = row.getElementsByTagName('td');
    for (let j = 0; j < cells.length - 1; j++) {
      text += cells[j].textContent.toLowerCase() + ' ';
    }
    row.style.display = text.includes(filter) ? '' : 'none';
  }
}


function openEditClientModal(id, nom, prenom, telephone, dateNaissance, type) {
  document.getElementById('edit_client_id').value = id;
  document.getElementById('edit_client_nom').value = nom;
  document.getElementById('edit_client_prenom').value = prenom;
  document.getElementById('edit_client_telephone').value = telephone;
  document.getElementById('edit_client_date_naissance').value = dateNaissance;
  document.getElementById('edit_client_type').value = type;
  openModal('editClient');
}

function deleteClient(id) {
  if (confirm('Êtes-vous sûr de vouloir supprimer ce client ?')) {
    window.location.href = 'index.php?page=supprimer_client&id=' + id;
  }
}


function openEditMoniteurModal(id, nom, prenom, email, telephone, dateEmbauche, agrement) {
  document.getElementById('edit_moniteur_id').value = id;
  document.getElementById('edit_moniteur_nom').value = nom;
  document.getElementById('edit_moniteur_prenom').value = prenom;
  document.getElementById('edit_moniteur_email').value = email;
  document.getElementById('edit_moniteur_telephone').value = telephone;
  document.getElementById('edit_moniteur_date_embauche').value = dateEmbauche;
  document.getElementById('edit_moniteur_agrement').value = agrement;
  openModal('editMoniteur');
}

function deleteMoniteur(id) {
  if (confirm('Êtes-vous sûr de vouloir supprimer ce moniteur ?')) {
    window.location.href = 'index.php?page=supprimer_moniteur&id=' + id;
  }
}


function deleteCours(id) {
  if (confirm('Supprimer ce cours pratique ?')) {
    window.location.href = 'index.php?page=supprimer_cours_pratique&id=' + id;
  }
}

function deleteCoursTheorique(id) {
  if (confirm('Supprimer ce cours théorique ?')) {
    window.location.href = 'index.php?page=supprimer_cours_theorique&id=' + id;
  }
}


function openResultatModal(id) {
  document.getElementById('resultat_examen_id').value = id;
  openModal('resultatExamen');
}

function deleteExamen(id) {
  if (confirm('Supprimer cet examen ?')) {
    window.location.href = 'index.php?page=supprimer_examen&id=' + id;
  }
}
</script>

</body>
</html>