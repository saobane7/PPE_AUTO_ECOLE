
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Espace Moniteur – SAT AUTO</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body class="dash-page">

<div class="dash-topbar">
  <div class="dash-topbar-inner">
    <div class="dash-title">
      <svg width="22" height="22" fill="currentColor" viewBox="0 0 24 24">
        <path d="M20 17v-8c0-2.21-3.58-4-8-4S4 6.79 4 9v8l-2 2v1h20v-1l-2-2zm-8 2c-.55 0-1-.45-1-1s.45-1 1-1 1 .45 1 1-.45 1-1 1zm6-2H6V9.1c.85-.74 2.69-1.6 6-1.6s5.15.86 6 1.6V17z"/>
      </svg>
      Espace Moniteur
    </div>
    <div style="display:flex;align-items:center;gap:16px;flex-wrap:wrap;">
      <span class="dash-user-info">
        <svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24">
          <path d="M12 12c2.7 0 4.8-2.1 4.8-4.8S14.7 2.4 12 2.4 7.2 4.5 7.2 7.2 9.3 12 12 12zm0 2.4c-3.2 0-9.6 1.6-9.6 4.8v2.4h19.2v-2.4c0-3.2-6.4-4.8-9.6-4.8z"/>
        </svg>
        <?php echo htmlspecialchars($_SESSION['prenom'].' '.$_SESSION['nom']); ?>
        <?php if (isset($_SESSION['agrement'])): ?>
          <span style="background:#ffd736;color:#072031;padding:2px 10px;border-radius:50px;font-size:.72rem;font-weight:800;margin-left:8px;"><?php echo htmlspecialchars($_SESSION['agrement']); ?></span>
        <?php endif; ?>
      </span>
      <a href="index.php?page=deconnexion" class="btn btn-outline-w">
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
      <button class="dash-nav-btn active" onclick="show('accueil',this)">
        <svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24">
          <path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z"/>
        </svg>
        Accueil
      </button>
      <button class="dash-nav-btn" onclick="show('profil',this)">
        <svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24">
          <path d="M12 12c2.7 0 4.8-2.1 4.8-4.8S14.7 2.4 12 2.4 7.2 4.5 7.2 7.2 9.3 12 12 12zm0 2.4c-3.2 0-9.6 1.6-9.6 4.8v2.4h19.2v-2.4c0-3.2-6.4-4.8-9.6-4.8z"/>
        </svg>
        Mon Profil
      </button>
      <button class="dash-nav-btn" onclick="show('eleves',this)">
        <svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24">
          <path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5z"/>
        </svg>
        Mes Élèves (<?php echo count($dash['eleves']); ?>)
      </button>
      <button class="dash-nav-btn" onclick="show('cours',this)">
        <svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24">
          <path d="M18.92 6.01C18.72 5.42 18.16 5 17.5 5h-11c-.66 0-1.21.42-1.42 1.01L3 12v8c0 .55.45 1 1 1h1c.55 0 1-.45 1-1v-1h12v1c0 .55.45 1 1 1h1c.55 0 1-.45 1-1v-8l-2.08-5.99z"/>
        </svg>
        Mes Cours (<?php echo count($dash['cours_pratiques']); ?>)
      </button>
      <button class="dash-nav-btn" onclick="show('stats',this)">
        <svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24">
          <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zM9 17H7v-7h2v7zm4 0h-2V7h2v10zm4 0h-2v-4h2v4z"/>
        </svg>
        Statistiques
      </button>
    </nav>
  </aside>

  <main class="dash-main">


    <div id="accueil" class="dash-section active">
      <h2 class="dash-sec-title">
        <svg width="22" height="22" fill="currentColor" viewBox="0 0 24 24">
          <path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z"/>
        </svg>
        Bonjour, <?php echo htmlspecialchars($_SESSION['prenom']); ?> !
      </h2>
      
      <div class="stat-cards">
        <div class="stat-card">
          <div class="stat-card-num"><?php echo $dash['stats']['nb_eleves']; ?></div>
          <div class="stat-card-lbl">Élèves</div>
        </div>
        <div class="stat-card">
          <div class="stat-card-num"><?php echo $dash['stats']['nb_cours_total']; ?></div>
          <div class="stat-card-lbl">Cours total</div>
        </div>
        <div class="stat-card">
          <div class="stat-card-num"><?php echo $dash['stats']['nb_cours_termines']; ?></div>
          <div class="stat-card-lbl">Cours terminés</div>
        </div>
        <div class="stat-card">
          <div class="stat-card-num"><?php echo $dash['stats']['heures_enseignees']; ?>h</div>
          <div class="stat-card-lbl">Heures enseignées</div>
        </div>
      </div>
      
      <?php if ($dash['prochain_cours']): ?>
      <div style="background:#072031; border-radius:16px; padding:28px; color:#fff; margin-top:20px;">
        <div style="display:flex; align-items:center; gap:20px;">
          <div style="background:#ffd736; color:#072031; width:64px; height:64px; border-radius:50%; display:flex; align-items:center; justify-content:center;">
            <svg width="32" height="32" fill="currentColor" viewBox="0 0 24 24">
              <path d="M18.92 6.01C18.72 5.42 18.16 5 17.5 5h-11c-.66 0-1.21.42-1.42 1.01L3 12v8c0 .55.45 1 1 1h1c.55 0 1-.45 1-1v-1h12v1c0 .55.45 1 1 1h1c.55 0 1-.45 1-1v-8l-2.08-5.99z"/>
            </svg>
          </div>
          <div>
            <div style="font-size:.8rem; text-transform:uppercase; color:#ffd736;">Prochain cours</div>
            <div style="font-size:1.4rem; font-weight:700;"><?php echo date('d/m/Y', strtotime($dash['prochain_cours']['date_seance'])); ?> à <?php echo substr($dash['prochain_cours']['heure_debut'],0,5); ?></div>
            <div>Avec <?php echo htmlspecialchars($dash['prochain_cours']['client_prenom'] . ' ' . $dash['prochain_cours']['client_nom']); ?></div>
          </div>
        </div>
      </div>
      <?php endif; ?>
    </div>

    <div id="profil" class="dash-section">
      <h2 class="dash-sec-title">
        <svg width="22" height="22" fill="currentColor" viewBox="0 0 24 24">
          <path d="M12 12c2.7 0 4.8-2.1 4.8-4.8S14.7 2.4 12 2.4 7.2 4.5 7.2 7.2 9.3 12 12 12zm0 2.4c-3.2 0-9.6 1.6-9.6 4.8v2.4h19.2v-2.4c0-3.2-6.4-4.8-9.6-4.8z"/>
        </svg>
        Mon Profil
      </h2>
      
      <div style="display:grid; grid-template-columns:1fr 1fr; gap:30px;">
        <div style="background:#fff; border-radius:16px; padding:32px;">
          <div style="text-align:center;">
            <div style="width:100px; height:100px; background:#072031; border-radius:50%; display:flex; align-items:center; justify-content:center; margin:0 auto 20px; color:#ffd736;">
              <svg width="50" height="50" fill="currentColor" viewBox="0 0 24 24">
                <path d="M12 12c2.7 0 4.8-2.1 4.8-4.8S14.7 2.4 12 2.4 7.2 4.5 7.2 7.2 9.3 12 12 12zm0 2.4c-3.2 0-9.6 1.6-9.6 4.8v2.4h19.2v-2.4c0-3.2-6.4-4.8-9.6-4.8z"/>
              </svg>
            </div>
            <h3 style="font-size:1.6rem; color:#072031;"><?php echo htmlspecialchars($_SESSION['prenom'] . ' ' . $_SESSION['nom']); ?></h3>
            <span class="tag tag-y">Agrément: <?php echo htmlspecialchars($_SESSION['agrement']); ?></span>
            
            <div style="text-align:left; margin-top:30px;">
              <div style="padding:10px 0; border-bottom:1px solid #eee;">
                <strong>Email:</strong> <?php echo htmlspecialchars($_SESSION['email']); ?>
              </div>
              <div style="padding:10px 0; border-bottom:1px solid #eee;">
                <strong>Téléphone:</strong> <?php echo htmlspecialchars($_SESSION['telephone']); ?>
              </div>
              <div style="padding:10px 0;">
                <strong>Date d'embauche:</strong> <?php echo date('d/m/Y', strtotime($dash['moniteur']['date_embauche'])); ?>
              </div>
            </div>
          </div>
        </div>
        
        <div style="background:#fff; border-radius:16px; padding:32px;">
          <h3 style="font-size:1.2rem; color:#072031; margin-bottom:20px;">Modifier mon profil</h3>
          <form method="POST" action="index.php?page=profil_moniteur">
            <div class="form-group">
              <label>Nom</label>
              <input type="text" name="nom" class="form-control" value="<?php echo htmlspecialchars($dash['moniteur']['nom']); ?>" required>
            </div>
            <div class="form-group">
              <label>Prénom</label>
              <input type="text" name="prenom" class="form-control" value="<?php echo htmlspecialchars($dash['moniteur']['prenom']); ?>" required>
            </div>
            <div class="form-group">
              <label>Téléphone</label>
              <input type="tel" name="telephone" class="form-control" value="<?php echo htmlspecialchars($dash['moniteur']['telephone']); ?>" required>
            </div>
            <button type="submit" name="Modifier" class="btn btn-blue" style="width:100%;">
              Mettre à jour
            </button>
          </form>
        </div>
      </div>
    </div>

    <div id="eleves" class="dash-section">
      <h2 class="dash-sec-title">
        <svg width="22" height="22" fill="currentColor" viewBox="0 0 24 24">
          <path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3z"/>
        </svg>
        Mes Élèves (<?php echo count($dash['eleves']); ?>)
      </h2>
      
      <?php if (count($dash['eleves']) > 0): ?>
      <div class="eleve-cards">
        <?php foreach ($profilComplet['stats_eleves'] as $stats): ?>
        <div class="eleve-card">
          <div class="eleve-av">
            <svg width="34" height="34" fill="currentColor" viewBox="0 0 24 24">
              <path d="M12 12c2.7 0 4.8-2.1 4.8-4.8S14.7 2.4 12 2.4 7.2 4.5 7.2 7.2 9.3 12 12 12z"/>
            </svg>
          </div>
          <div class="eleve-name"><?php echo htmlspecialchars($stats['eleve']['prenom'] . ' ' . $stats['eleve']['nom']); ?></div>
          <div style="margin:10px 0;">
            <span class="tag tag-y"><?php echo $stats['nb_cours']; ?> cours</span>
          </div>
          <div class="eleve-info">
            <?php echo htmlspecialchars($stats['eleve']['email']); ?>
          </div>
          <div class="eleve-info">
            <?php echo htmlspecialchars($stats['eleve']['telephone']); ?>
          </div>
          <?php if ($stats['dernier_cours']): ?>
          <div style="margin-top:10px; font-size:.8rem; color:#666;">
            Dernier cours: <?php echo date('d/m/Y', strtotime($stats['dernier_cours']['date_seance'])); ?>
          </div>
          <?php endif; ?>
        </div>
        <?php endforeach; ?>
      </div>
      <?php else: ?>
      <div class="empty-box">
        <p>Aucun élève pour le moment.</p>
      </div>
      <?php endif; ?>
    </div>

    <!-- COURS -->
    <div id="cours" class="dash-section">
      <h2 class="dash-sec-title">
        <svg width="22" height="22" fill="currentColor" viewBox="0 0 24 24">
          <path d="M18.92 6.01C18.72 5.42 18.16 5 17.5 5h-11c-.66 0-1.21.42-1.42 1.01L3 12v8c0 .55.45 1 1 1h1c.55 0 1-.45 1-1v-1h12v1c0 .55.45 1 1 1h1c.55 0 1-.45 1-1v-8l-2.08-5.99z"/>
        </svg>
        Mes Cours
      </h2>
      
      <?php if (count($dash['cours_pratiques']) > 0): ?>
      <div class="tbl-wrap">
        <table class="data-table">
          <thead>
            <tr>
              <th>Date</th>
              <th>Horaire</th>
              <th>Élève</th>
              <th>Statut</th>
              <th>Notes</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($dash['cours_pratiques'] as $cp): ?>
            <tr>
              <td><?php echo date('d/m/Y', strtotime($cp['date_seance'])); ?></td>
              <td><?php echo substr($cp['heure_debut'],0,5) . ' – ' . substr($cp['heure_fin'],0,5); ?></td>
              <td><strong><?php echo htmlspecialchars($cp['client_prenom'] . ' ' . $cp['client_nom']); ?></strong></td>
              <td>
                <span class="tag <?php echo $cp['statut'] === 'termine' ? 'tag-g' : ($cp['statut'] === 'annule' ? 'tag-r' : 'tag-y'); ?>">
                  <?php echo $cp['statut']; ?>
                </span>
              </td>
              <td><?php echo htmlspecialchars($cp['notes'] ?? '—'); ?></td>
              <td>
                <?php if ($cp['statut'] === 'planifie'): ?>
                <div style="display:flex; gap:5px;">
                  <a href="index.php?page=valider_cours&id=<?php echo $cp['id_seance']; ?>" class="btn btn-outline-y" style="padding:4px 8px;" onclick="return confirm('Terminer ce cours ?')">✓</a>
                  <a href="index.php?page=annuler_cours&id=<?php echo $cp['id_seance']; ?>" class="btn btn-outline-w" style="padding:4px 8px; background:#f44336;" onclick="return confirm('Annuler ce cours ?')">✗</a>
                </div>
                <?php endif; ?>
              </td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
      <?php else: ?>
      <div class="empty-box">
        <p>Aucun cours planifié.</p>
      </div>
      <?php endif; ?>
    </div>

    <div id="stats" class="dash-section">
      <h2 class="dash-sec-title">
        <svg width="22" height="22" fill="currentColor" viewBox="0 0 24 24">
          <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zM9 17H7v-7h2v7zm4 0h-2V7h2v10zm4 0h-2v-4h2v4z"/>
        </svg>
        Mes Statistiques
      </h2>
      
      <div style="display:grid; grid-template-columns:1fr 1fr; gap:30px;">
        <div style="background:#fff; border-radius:16px; padding:24px;">
          <h3>Résumé</h3>
          <div style="margin-top:20px;">
            <div style="display:flex; justify-content:space-between; padding:10px 0; border-bottom:1px solid #eee;">
              <span>Total cours</span>
              <strong><?php echo $dash['stats']['nb_cours_total']; ?></strong>
            </div>
            <div style="display:flex; justify-content:space-between; padding:10px 0; border-bottom:1px solid #eee;">
              <span>Cours terminés</span>
              <strong><?php echo $dash['stats']['nb_cours_termines']; ?></strong>
            </div>
            <div style="display:flex; justify-content:space-between; padding:10px 0; border-bottom:1px solid #eee;">
              <span>Cours à venir</span>
              <strong><?php echo $dash['stats']['nb_cours_a_venir']; ?></strong>
            </div>
            <div style="display:flex; justify-content:space-between; padding:10px 0;">
              <span>Heures enseignées</span>
              <strong><?php echo $dash['stats']['heures_enseignees']; ?>h</strong>
            </div>
          </div>
        </div>
        
        <div style="background:#fff; border-radius:16px; padding:24px;">
          <h3>Élèves</h3>
          <div style="margin-top:20px;">
            <div style="display:flex; justify-content:space-between; padding:10px 0; border-bottom:1px solid #eee;">
              <span>Nombre d'élèves</span>
              <strong><?php echo $dash['stats']['nb_eleves']; ?></strong>
            </div>
            <div style="display:flex; justify-content:space-between; padding:10px 0;">
              <span>Moyenne cours/élève</span>
              <strong>
                <?php 
                $moyenne = $dash['stats']['nb_eleves'] > 0 
                  ? round($dash['stats']['nb_cours_total'] / $dash['stats']['nb_eleves'], 1) 
                  : 0;
                echo $moyenne;
                ?>
              </strong>
            </div>
          </div>
        </div>
      </div>
    </div>

  </main>
</div>

<script>
function show(id, btn) {
  document.querySelectorAll('.dash-section').forEach(s => s.classList.remove('active'));
  document.querySelectorAll('.dash-nav-btn').forEach(b => b.classList.remove('active'));
  document.getElementById(id).classList.add('active');
  btn.classList.add('active');
}
</script>

</body>
</html>