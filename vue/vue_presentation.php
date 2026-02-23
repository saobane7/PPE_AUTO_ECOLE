<?php $moniteurs = isset($moniteurs) ? $moniteurs : []; ?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>SAT AUTO – Auto-École Professionnelle</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="css/style.css">
</head>
<body>


<header class="header">
  <div class="nav-inner">

    <a href="index.php" class="logo-wrap">
      <div class="logo-anim">
        
        <svg width="54" height="24" viewBox="0 0 54 24" fill="none">
          <rect x="6" y="8" width="42" height="14" rx="4" fill="#ffd736"/>
          <path d="M10 8 L18 2 H36 L44 8" fill="#ffd736" stroke="#072031" stroke-width="1.5"/>
          <rect x="4"  y="14" width="8"  height="4" rx="1" fill="#072031" opacity=".4"/>
          <rect x="42" y="14" width="8"  height="4" rx="1" fill="#072031" opacity=".4"/>
          <circle cx="14" cy="22" r="4" fill="#072031" stroke="#ffd736" stroke-width="2"/>
          <circle cx="40" cy="22" r="4" fill="#072031" stroke="#ffd736" stroke-width="2"/>
          <rect x="20" y="4" width="8" height="5" rx="1" fill="rgba(7,32,49,.25)"/>
          <rect x="30" y="4" width="8" height="5" rx="1" fill="rgba(7,32,49,.25)"/>
        </svg>
        <div class="logo-wheels">
          <span class="logo-wheel"></span>
          <span class="logo-wheel"></span>
        </div>
      </div>
      <div class="logo-text-wrap">
        <span class="logo-name">SAT AUTO</span>
        <span class="logo-tagline">Auto-École Professionnelle</span>
      </div>
    </a>


    <nav class="nav-right" id="navRight">
      <a href="index.php?page=inscription" class="btn btn-outline-y">
        <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24"><path d="M12 12c2.7 0 4.8-2.1 4.8-4.8S14.7 2.4 12 2.4 7.2 4.5 7.2 7.2 9.3 12 12 12zm0 2.4c-3.2 0-9.6 1.6-9.6 4.8v2.4h19.2v-2.4c0-3.2-6.4-4.8-9.6-4.8z"/></svg>
        Inscription
      </a>
      <a href="index.php?page=connexion" class="btn btn-yellow">
        <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24"><path d="M11 7L9.6 8.4l2.6 2.6H2v2h10.2l-2.6 2.6L11 17l5-5-5-5zm9 12h-8v2h8c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2h-8v2h8v14z"/></svg>
        Connexion
      </a>
    </nav>

    <button class="hamburger" onclick="document.getElementById('navRight').classList.toggle('open')" aria-label="Menu">
      <span></span><span></span><span></span>
    </button>
  </div>
</header>


<section class="hero">
  <div class="hero-badge">Auto-École Certifiée depuis 2010</div>
  <h1>Votre Permis,<br><em>Notre Excellence</em></h1>
  <p class="hero-sub">Rejoignez SAT AUTO et passez votre permis avec les meilleurs moniteurs de France. Méthodes modernes, taux de réussite exceptionnel.</p>
  <div class="hero-cta">
    <a href="index.php?page=inscription" class="btn btn-yellow">
      <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24"><path d="M12 12c2.7 0 4.8-2.1 4.8-4.8S14.7 2.4 12 2.4 7.2 4.5 7.2 7.2 9.3 12 12 12zm0 2.4c-3.2 0-9.6 1.6-9.6 4.8v2.4h19.2v-2.4c0-3.2-6.4-4.8-9.6-4.8z"/></svg>
      S'inscrire maintenant
    </a>
    <a href="#moniteurs" class="btn btn-outline-w">
      <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 14v-4H7l5-8v4h4l-5 8z"/></svg>
      Découvrir nos moniteurs
    </a>
  </div>
</section>


<div class="stats-strip">
  <div class="stats-inner">
    <div><div class="stat-n">5 000+</div><div class="stat-l">Élèves formés</div></div>
    <div><div class="stat-n">87%</div><div class="stat-l">Taux de réussite</div></div>
    <div><div class="stat-n">15 ans</div><div class="stat-l">D'expérience</div></div>
    <div><div class="stat-n">8</div><div class="stat-l">Agences en France</div></div>
  </div>
</div>


<section class="pres-section">
  <div class="pres-inner container">
    <div class="pres-img-wrap">
      <img src="https://images.unsplash.com/photo-1449965408869-eaa3f722e40d?w=800&q=80" alt="Conduite SAT AUTO">
      <div class="pres-badge">⭐ 87% de réussite</div>
    </div>
    <div>
      <span class="section-tag tag-on-white">Notre histoire</span>
      <h2 class="section-heading">SAT AUTO — Votre Partenaire de Réussite</h2>
      <p style="font-size:1rem;line-height:1.9;color:#072031;margin-bottom:20px;">
        Depuis 2010, SAT AUTO forme des conducteurs responsables et confiants. Notre équipe de moniteurs diplômés d'État vous accompagne à chaque étape, du premier cours de code jusqu'au passage de l'examen pratique.
      </p>
      <p style="font-size:1rem;line-height:1.9;color:#072031;margin-bottom:36px;">
        Nos formules sur-mesure s'adaptent à votre rythme : particulier, étudiant ou professionnel, nous avons l'offre qu'il vous faut. Avec plus de 5 000 élèves formés, SAT AUTO est la référence en matière de formation à la conduite.
      </p>
      <a href="index.php?page=inscription" class="btn btn-blue">
        <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24"><path d="M12 4l-1.41 1.41L16.17 11H4v2h12.17l-5.58 5.59L12 20l8-8z"/></svg>
        Commencer maintenant
      </a>
    </div>
  </div>
</section>


<section class="moniteurs-section" id="moniteurs">
  <div class="moniteurs-inner">
    <div style="text-align:center;margin-bottom:60px;">
      <span class="section-tag tag-on-blue">Nos experts</span>
      <h2 class="section-heading" style="color:#fff;">Un Bon Moniteur, Ça Change Tout</h2>
      <p class="section-sub center" style="color:rgba(255,255,255,.75);">Des professionnels diplômés d'État, passionnés par la pédagogie</p>
    </div>

    <?php
    $photos = [
      'https://images.unsplash.com/photo-1560250097-0b93528c311a?w=400&q=80',
      'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?w=400&q=80',
      'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=400&q=80',
    ];
    $descs = [
      "Expert de la pédagogie avec plus de 12 ans d'expérience. Patient et à l'écoute, Jean adapte chaque leçon au niveau de l'élève pour garantir une progression rapide et sereine.",
      "Spécialiste de la conduite accompagnée et de la conduite en ville. Sophie est reconnue pour sa bienveillance et son efficacité. Elle a formé plus de 500 élèves.",
      "Moniteur senior avec une approche méthodique et rassurante. Lucas excelle dans la gestion du stress et accompagne les élèves les plus anxieux vers la réussite.",
    ];
    if (count($moniteurs) === 0) {
      $moniteurs = [
        ['prenom'=>'Jean','nom'=>'Dupont','telephone'=>'06 12 34 56 78','numero_agrement'=>'AG123456'],
        ['prenom'=>'Sophie','nom'=>'Martin','telephone'=>'06 98 76 54 32','numero_agrement'=>'AG789012'],
        ['prenom'=>'Lucas','nom'=>'Bernard','telephone'=>'06 55 44 33 22','numero_agrement'=>'AG345678'],
      ];
    }
    foreach ($moniteurs as $i => $m):
      $flip  = ($i % 2 === 1) ? 'flip' : '';
      $photo = $photos[$i % count($photos)];
      $desc  = $descs[$i % count($descs)];
    ?>
    <div class="moniteur-row <?php echo $flip; ?>">

      <div class="m-circle-col">
        <img src="<?php echo $photo; ?>"
             alt="<?php echo htmlspecialchars($m['prenom'].' '.$m['nom']); ?>"
             class="m-circle">
        <span class="m-agr"><?php echo htmlspecialchars($m['numero_agrement']); ?></span>
      </div>

      <div class="m-info">
        <h3 class="m-nom"><?php echo htmlspecialchars($m['prenom'].' '.$m['nom']); ?></h3>
        <span class="m-poste">Moniteur Diplômé d'État</span>
        <p class="m-desc"><?php echo $desc; ?></p>
        <div class="m-tel">
          <svg width="16" height="16" fill="#ffd736" viewBox="0 0 24 24"><path d="M6.62 10.79a15.05 15.05 0 006.59 6.59l2.2-2.2a1 1 0 011.01-.24 11.47 11.47 0 003.58.57 1 1 0 011 1V20a1 1 0 01-1 1A17 17 0 013 4a1 1 0 011-1h3.5a1 1 0 011 1 11.47 11.47 0 00.57 3.57 1 1 0 01-.24 1.01l-2.21 2.21z"/></svg>
          <?php echo htmlspecialchars($m['telephone']); ?>
        </div>
        <a href="index.php?page=inscription" class="btn btn-yellow">
          <svg width="15" height="15" fill="currentColor" viewBox="0 0 24 24"><path d="M12 12c2.7 0 4.8-2.1 4.8-4.8S14.7 2.4 12 2.4 7.2 4.5 7.2 7.2 9.3 12 12 12zm0 2.4c-3.2 0-9.6 1.6-9.6 4.8v2.4h19.2v-2.4c0-3.2-6.4-4.8-9.6-4.8z"/></svg>
          S'inscrire avec ce moniteur
        </a>
      </div>
    </div>
    <?php endforeach; ?>
  </div>
</section>


<section class="offres-section">
  <div class="offres-inner">
    <div style="text-align:center;margin-bottom:60px;">
      <span class="section-tag tag-on-yellow">Nos formules</span>
      <h2 class="section-heading">Code &amp; Conduite – Choisissez votre Forfait</h2>
      <p class="section-sub center">Des tarifs transparents, sans mauvaise surprise</p>
    </div>
    <div class="g3">

      <div class="offre-card">
        <div class="offre-icon">
          <svg width="28" height="28" fill="currentColor" viewBox="0 0 24 24"><path d="M18 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V4a2 2 0 00-2-2zM6 4h5v8l-2.5-1.5L6 12V4z"/></svg>
        </div>
        <div class="offre-name">Forfait Code</div>
        <div class="offre-price">299€</div>
        <p class="offre-desc">Réussissez votre code du premier coup</p>
        <ul class="offre-list">
          <li><svg width="14" height="14" fill="#072031" viewBox="0 0 24 24"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z"/></svg> Accès salle illimité</li>
          <li><svg width="14" height="14" fill="#072031" viewBox="0 0 24 24"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z"/></svg> Plateforme en ligne 24/7</li>
          <li><svg width="14" height="14" fill="#072031" viewBox="0 0 24 24"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z"/></svg> Application mobile incluse</li>
          <li><svg width="14" height="14" fill="#072031" viewBox="0 0 24 24"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z"/></svg> Suivi personnalisé</li>
          <li><svg width="14" height="14" fill="#072031" viewBox="0 0 24 24"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z"/></svg> Présentation à l'examen</li>
        </ul>
        <a href="index.php?page=inscription" class="btn btn-blue" style="width:100%;justify-content:center;">Choisir ce forfait</a>
      </div>

      <div class="offre-card popular">
        <div class="pop-badge">⭐ Le Plus Populaire</div>
        <div class="offre-icon">
          <svg width="28" height="28" fill="currentColor" viewBox="0 0 24 24"><path d="M18.92 6.01C18.72 5.42 18.16 5 17.5 5h-11c-.66 0-1.21.42-1.42 1.01L3 12v8c0 .55.45 1 1 1h1c.55 0 1-.45 1-1v-1h12v1c0 .55.45 1 1 1h1c.55 0 1-.45 1-1v-8l-2.08-5.99zM6.85 7h10.29l1.08 3.11H5.77L6.85 7zM19 17H5v-5h14v5zM7.5 14c-.83 0-1.5.67-1.5 1.5S6.67 17 7.5 17 9 16.33 9 15.5 8.33 14 7.5 14zm9 0c-.83 0-1.5.67-1.5 1.5s.67 1.5 1.5 1.5 1.5-.67 1.5-1.5-.67-1.5-1.5-1.5z"/></svg>
        </div>
        <div class="offre-name">Forfait 20h</div>
        <div class="offre-price">1 190€</div>
        <p class="offre-desc">La formule parfaite pour débuter</p>
        <ul class="offre-list">
          <li><svg width="14" height="14" fill="#ffd736" viewBox="0 0 24 24"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z"/></svg> 20 heures de conduite</li>
          <li><svg width="14" height="14" fill="#ffd736" viewBox="0 0 24 24"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z"/></svg> Évaluation offerte</li>
          <li><svg width="14" height="14" fill="#ffd736" viewBox="0 0 24 24"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z"/></svg> Véhicules récents</li>
          <li><svg width="14" height="14" fill="#ffd736" viewBox="0 0 24 24"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z"/></svg> Livret pédagogique</li>
          <li><svg width="14" height="14" fill="#ffd736" viewBox="0 0 24 24"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z"/></svg> Présentation examen incluse</li>
        </ul>
        <a href="index.php?page=inscription" class="btn btn-yellow" style="width:100%;justify-content:center;">Choisir ce forfait</a>
      </div>


      <div class="offre-card">
        <div class="offre-icon">
          <svg width="28" height="28" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
        </div>
        <div class="offre-name">Forfait Complet</div>
        <div class="offre-price">1 399€</div>
        <p class="offre-desc">Code + Conduite — tout inclus, économisez 90€</p>
        <ul class="offre-list">
          <li><svg width="14" height="14" fill="#072031" viewBox="0 0 24 24"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z"/></svg> Formation code complète</li>
          <li><svg width="14" height="14" fill="#072031" viewBox="0 0 24 24"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z"/></svg> 20h de conduite</li>
          <li><svg width="14" height="14" fill="#072031" viewBox="0 0 24 24"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z"/></svg> Suivi renforcé</li>
          <li><svg width="14" height="14" fill="#072031" viewBox="0 0 24 24"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z"/></svg> 2 passages à l'examen</li>
          <li><svg width="14" height="14" fill="#072031" viewBox="0 0 24 24"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z"/></svg> <strong>Économisez 90€ !</strong></li>
        </ul>
        <a href="index.php?page=inscription" class="btn btn-blue" style="width:100%;justify-content:center;">Choisir ce forfait</a>
      </div>

    </div>
  </div>
</section>


<section class="lieux-section">
  <div class="lieux-inner">
    <div style="text-align:center;margin-bottom:60px;">
      <span class="section-tag tag-on-blue">Nos agences</span>
      <h2 class="section-heading" style="color:#fff;">8 Points de Rendez-vous en France</h2>
      <p class="section-sub center" style="color:rgba(255,255,255,.72);">Proche de chez vous, partout en France</p>
    </div>
    <div class="g4">

      <?php
      $villes = [
        ['Paris',    '123 Av. des Champs-Élysées, 75008','01 23 45 67 89','images/paris_image.jpeg'],
        ['Lyon',     '45 Rue de la République, 69002',   '04 78 90 12 34','images/lyon_image.jpeg'],
        ['Marseille','78 La Canebière, 13001',            '04 91 23 45 67','images/marseille_image.jpeg'],
        ['Toulouse', '32 Place du Capitole, 31000',       '05 61 12 34 56','images/toulouse_image.jpeg'],
        ['Bordeaux', "56 Cours de l'Intendance, 33000",  '05 56 78 90 12','images/bordeau_image.jpeg'],
        ['Nice',     '12 Prom. des Anglais, 06000',       '04 93 45 67 89','images/nice_image.jpeg'],
        ['Lille',    '89 Rue Nationale, 59000',           '03 20 45 67 89','images/lille_image.jpeg'],
        ['Nantes',   '15 Cours des 50 Otages, 44000',     '02 40 12 34 56','images/nante_image.jpeg'],
      ];
      foreach ($villes as $v): ?>
      <div class="lieu-card">
        <div class="lieu-img-wrap">
          <img src="<?php echo $v[3]; ?>" alt="<?php echo $v[0]; ?>" class="lieu-img" loading="lazy">
        </div>
        <div class="lieu-body">
          <div class="lieu-ville"><?php echo $v[0]; ?></div>
          <div class="lieu-row">
            <svg width="14" height="14" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/></svg>
            <?php echo $v[1]; ?>
          </div>
          <div class="lieu-row">
            <svg width="14" height="14" fill="currentColor" viewBox="0 0 24 24"><path d="M6.62 10.79a15.05 15.05 0 006.59 6.59l2.2-2.2a1 1 0 011.01-.24 11.47 11.47 0 003.58.57A1 1 0 0121 18.5V21a1 1 0 01-1 1A17 17 0 013 5a1 1 0 011-1h2.5a1 1 0 011 .88c.12.84.37 1.65.57 2.45a1 1 0 01-.24 1.01l-2.21 2.45z"/></svg>
            <?php echo $v[2]; ?>
          </div>
          <div class="lieu-row">
            <svg width="14" height="14" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2a10 10 0 100 20A10 10 0 0012 2zm.5 5v5.25l4.5 2.67-.75 1.23L11 13V7h1.5z"/></svg>
            Lun – Sam : 8h – 20h
          </div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>


<section class="pourquoi-section">
  <div class="pourquoi-inner">
    <div style="text-align:center;margin-bottom:60px;">
      <span class="section-tag tag-on-yellow">Nos atouts</span>
      <h2 class="section-heading">Pourquoi Choisir SAT AUTO ?</h2>
      <p class="section-sub center">Ce qui nous distingue depuis 15 ans</p>
    </div>
    <div class="g4">

      <div class="pq-card">
        <div class="pq-icon">
          <svg width="32" height="32" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2l2.4 7.4H22l-6.2 4.5 2.4 7.4L12 17l-6.2 4.3 2.4-7.4L2 9.4h7.6z"/></svg>
        </div>
        <h3>Moniteurs Diplômés</h3>
        <p>Tous nos moniteurs sont titulaires du BEPECASER et formés en continu aux dernières méthodes pédagogiques.</p>
      </div>

      <div class="pq-card">
        <div class="pq-icon">
          <svg width="32" height="32" fill="currentColor" viewBox="0 0 24 24"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-7 3c1.93 0 3.5 1.57 3.5 3.5S13.93 13 12 13s-3.5-1.57-3.5-3.5S10.07 6 12 6zm7 13H5v-.23c0-.62.28-1.2.76-1.58C7.47 15.82 9.64 15 12 15s4.53.82 6.24 2.19c.48.38.76.97.76 1.58V19z"/></svg>
        </div>
        <h3>87% de Réussite</h3>
        <p>Notre taux de réussite dépasse la moyenne nationale grâce à une pédagogie adaptée et un suivi individualisé.</p>
      </div>

      <div class="pq-card">
        <div class="pq-icon">
          <svg width="32" height="32" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2a10 10 0 100 20A10 10 0 0012 2zm.5 5v5.25l4.5 2.67-.75 1.23L11 13V7h1.5z"/></svg>
        </div>
        <h3>Horaires Flexibles</h3>
        <p>Cours 7j/7 de 7h à 21h. Planifiez vos leçons en ligne selon votre emploi du temps, sans contrainte.</p>
      </div>

      <div class="pq-card">
        <div class="pq-icon">
          <svg width="32" height="32" fill="currentColor" viewBox="0 0 24 24"><path d="M11.8 10.9c-2.27-.59-3-1.2-3-2.15 0-1.09 1.01-1.85 2.7-1.85 1.78 0 2.44.85 2.5 2.1h2.21c-.07-1.72-1.12-3.3-3.21-3.81V3h-3v2.16c-1.94.42-3.5 1.68-3.5 3.61 0 2.31 1.91 3.46 4.7 4.13 2.5.6 3 1.48 3 2.41 0 .69-.49 1.79-2.7 1.79-2.06 0-2.87-.92-2.98-2.1h-2.2c.12 2.19 1.76 3.42 3.68 3.83V21h3v-2.15c1.95-.37 3.5-1.5 3.5-3.55 0-2.84-2.43-3.81-4.7-4.4z"/></svg>
        </div>
        <h3>Tarifs Transparents</h3>
        <p>Pas de frais cachés. Nos forfaits incluent tout, avec des facilités de paiement adaptées à chaque budget.</p>
      </div>

    </div>
  </div>
</section>


<section class="cta-section">
  <h2>Prêt à Prendre le <span>Volant ?</span></h2>
  <p>Rejoignez des milliers d'élèves satisfaits et obtenez votre permis avec SAT AUTO.</p>
  <div class="cta-btns">
    <a href="index.php?page=inscription" class="btn btn-yellow">
      <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24"><path d="M12 12c2.7 0 4.8-2.1 4.8-4.8S14.7 2.4 12 2.4 7.2 4.5 7.2 7.2 9.3 12 12 12zm0 2.4c-3.2 0-9.6 1.6-9.6 4.8v2.4h19.2v-2.4c0-3.2-6.4-4.8-9.6-4.8z"/></svg>
      S'inscrire gratuitement
    </a>
    <a href="index.php?page=connexion" class="btn btn-outline-w">
      <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24"><path d="M11 7L9.6 8.4l2.6 2.6H2v2h10.2l-2.6 2.6L11 17l5-5-5-5zm9 12h-8v2h8c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2h-8v2h8v14z"/></svg>
      Se connecter
    </a>
  </div>
</section>


<footer>
  <div class="footer-inner">
    <div class="footer-brand">
      <a href="index.php" class="logo-wrap" style="margin-bottom:4px;">
        <span class="logo-name" style="font-size:1.6rem;">SAT AUTO</span>
      </a>
      <p>Auto-école professionnelle depuis 2010. Plus de 5 000 élèves formés à travers toute la France avec un taux de réussite de 87%.</p>
    </div>
    <div class="footer-col">
      <h4>Contact</h4>
      <p><svg width="14" height="14" fill="currentColor" viewBox="0 0 24 24"><path d="M6.62 10.79a15.05 15.05 0 006.59 6.59l2.2-2.2a1 1 0 011.01-.24 11.47 11.47 0 003.58.57A1 1 0 0121 18.5V21a1 1 0 01-1 1A17 17 0 013 5a1 1 0 011-1h2.5a1 1 0 011 .88z"/></svg> 01 23 45 67 89</p>
      <p><svg width="14" height="14" fill="currentColor" viewBox="0 0 24 24"><path d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/></svg> contact@satauto.fr</p>
    </div>
    <div class="footer-col">
      <h4>Horaires</h4>
      <p><svg width="14" height="14" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2a10 10 0 100 20A10 10 0 0012 2zm.5 5v5.25l4.5 2.67-.75 1.23L11 13V7h1.5z"/></svg> Lun – Ven : 8h – 20h</p>
      <p><svg width="14" height="14" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2a10 10 0 100 20A10 10 0 0012 2zm.5 5v5.25l4.5 2.67-.75 1.23L11 13V7h1.5z"/></svg> Sam : 8h – 18h</p>
    </div>
    <div class="footer-col">
      <h4>Navigation</h4>
      <a href="index.php?page=inscription"><svg width="12" height="12" fill="currentColor" viewBox="0 0 24 24"><path d="M12 4l-1.41 1.41L16.17 11H4v2h12.17l-5.58 5.59L12 20l8-8z"/></svg> S'inscrire</a>
      <a href="index.php?page=connexion"><svg width="12" height="12" fill="currentColor" viewBox="0 0 24 24"><path d="M12 4l-1.41 1.41L16.17 11H4v2h12.17l-5.58 5.59L12 20l8-8z"/></svg> Se connecter</a>
    </div>
  </div>
  <div class="footer-bottom">&copy; <?php echo date('Y'); ?> SAT AUTO — Tous droits réservés</div>
</footer>

</body>
</html>