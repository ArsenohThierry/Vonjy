<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.5">
    <title>BNGRC · Simulation de répartition</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/dispatch.css">
</head>

<body>
    <!-- ========== LAYOUT PRINCIPAL AVEC MENU LATERAL ========== -->
    <?php $activePage = 'dashboard'; ?>
    <div class="app-container">
        <!-- ========== MENU DE NAVIGATION GAUCHE ========== -->
        <?php include('partials/sidebar.php'); ?>

        <!-- ========== CONTENU PRINCIPAL ========== -->
        <main class="main-content">
            <!-- Header avec titre -->
            <header class="content-header">
                <div class="title-section">
                    <h1 class="page-title">Simulation de répartition des dons</h1>
                    <p class="page-subtitle">Répartition des dons par ordre de date de besoin</p>
                </div>
                <div class="header-actions" style="display: flex; align-items: center; gap: 10px;">
                    <?php if (!empty($simulated)): ?>
                        <span class="simulation-badge">Simulation terminée</span>
                    <?php else: ?>
                        <span class="simulation-badge" style="background: #f0f0f0; color: #666;">En attente de
                            simulation</span>
                    <?php endif; ?>
<<<<<<< HEAD
                    <a href="<?= BASE_URL ?>/add-don" class="btn btn-primary" style="display: inline-flex; align-items: center; gap: 6px; padding: 8px 14px; background: #27ae60; color: white; text-decoration: none; border-radius: 6px; font-size: 0.9em;">
                        <svg viewBox="0 0 24 24" width="16" height="16">
                            <path fill="currentColor" d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/>
=======
                    <a href="<?= BASE_URL ?>/add-don" class="btn btn-primary"
                        style="display: inline-flex; align-items: center; gap: 6px; padding: 8px 14px; background: #27ae60; color: white; text-decoration: none; border-radius: 6px; font-size: 0.9em;">
                        <svg viewBox="0 0 24 24" width="16" height="16">
                            <path fill="currentColor" d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z" />
>>>>>>> dev_aina
                        </svg>
                        Ajouter un don
                    </a>
                </div>
            </header>

            <!-- ========== RÉSUMÉ EN 3 CARDS ========== -->
            <div class="summary-cards">
                <!-- Card Total dons -->
<<<<<<< HEAD
                <div class="summary-card card-dons" <?php if (!empty($simulated)): ?>style="border: 2px solid #137C8B;"<?php endif; ?>>
=======
                <div class="summary-card card-dons" <?php if (!empty($simulated)): ?>style="border: 2px solid #137C8B;"
                    <?php endif; ?>>
>>>>>>> dev_aina
                    <div class="card-icon">
                        <svg viewBox="0 0 24 24" width="24" height="24">
                            <path fill="#137C8B"
                                d="M20 6h-2v2h-2V6h-2V4h2V2h2v2h2v2zm-10 2H8V6h2v2zm0 8H6v-4h4v4zm2 0v-4h4v4h-4zm-6 4v-2h2v2H6zm8 0v-2h2v2h-2zm-6-8H4V8h4v4zM2 20V4h12v2h-2v2h2v2h-2v2h2v2h-2v2h2v2H2z" />
                        </svg>
                    </div>
                    <div class="card-content">
<<<<<<< HEAD
                        <span class="card-label">Total dons disponibles <?php if (!empty($simulated)): ?><em style="color: #137C8B; font-size: 0.75em;">(après simulation)</em><?php endif; ?></span>
                        <span class="card-value"><?= number_format($totalDons, 0, ',', ' ') ?> <small>Ar</small></span>
                        <?php if (!empty($simulated) && isset($totalDonsInitial)): ?>
                            <span style="font-size: 0.75em; color: #666;">Initial : <?= number_format($totalDonsInitial, 0, ',', ' ') ?> Ar</span>
=======
                        <span class="card-label">Total dons disponibles <?php if (!empty($simulated)): ?><em
                                    style="color: #137C8B; font-size: 0.75em;">(après simulation)</em><?php endif; ?></span>
                        <span class="card-value"><?= number_format($totalDons, 0, ',', ' ') ?> <small>Ar</small></span>
                        <?php if (!empty($simulated) && isset($totalDonsInitial)): ?>
                            <span style="font-size: 0.75em; color: #666;">Initial :
                                <?= number_format($totalDonsInitial, 0, ',', ' ') ?> Ar</span>
>>>>>>> dev_aina
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Card Total besoins -->
<<<<<<< HEAD
                <div class="summary-card card-besoins" <?php if (!empty($simulated)): ?>style="border: 2px solid #E68A2E;"<?php endif; ?>>
=======
                <div class="summary-card card-besoins" <?php if (!empty($simulated)): ?>style="border: 2px solid #E68A2E;" <?php endif; ?>>
>>>>>>> dev_aina
                    <div class="card-icon">
                        <svg viewBox="0 0 24 24" width="24" height="24">
                            <path fill="#E68A2E"
                                d="M20 8h-2.81c-.45-.78-1.07-1.45-1.82-1.96L17 4.41 15.59 3l-2.17 2.17C12.96 5.06 12.49 5 12 5s-.96.06-1.41.17L8.41 3 7 4.41l1.62 1.63C7.88 6.55 7.26 7.22 6.81 8H4v2h2.09c-.05.33-.09.66-.09 1v1H4v2h2v1c0 .34.04.67.09 1H4v2h2.81c1.04 1.79 2.97 3 5.19 3s4.15-1.21 5.19-3H20v-2h-2.09c.05-.33.09-.66.09-1v-1h2v-2h-2v-1c0-.34-.04-.67-.09-1H20V8z" />
                        </svg>
                    </div>
                    <div class="card-content">
<<<<<<< HEAD
                        <span class="card-label">Total besoins estimés <?php if (!empty($simulated)): ?><em style="color: #E68A2E; font-size: 0.75em;">(après simulation)</em><?php endif; ?></span>
                        <span class="card-value"><?= number_format($totalBesoins, 0, ',', ' ') ?> <small>Ar</small></span>
                        <?php if (!empty($simulated) && isset($totalBesoinsInitial)): ?>
                            <span style="font-size: 0.75em; color: #666;">Initial : <?= number_format($totalBesoinsInitial, 0, ',', ' ') ?> Ar</span>
=======
                        <span class="card-label">Total besoins estimés <?php if (!empty($simulated)): ?><em
                                    style="color: #E68A2E; font-size: 0.75em;">(après simulation)</em><?php endif; ?></span>
                        <span class="card-value"><?= number_format($totalBesoins, 0, ',', ' ') ?>
                            <small>Ar</small></span>
                        <?php if (!empty($simulated) && isset($totalBesoinsInitial)): ?>
                            <span style="font-size: 0.75em; color: #666;">Initial :
                                <?= number_format($totalBesoinsInitial, 0, ',', ' ') ?> Ar</span>
>>>>>>> dev_aina
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Card Taux de couverture -->
<<<<<<< HEAD
                <div class="summary-card card-couverture" <?php if (!empty($simulated)): ?>style="border: 2px solid #709CA7;"<?php endif; ?>>
=======
                <div class="summary-card card-couverture" <?php if (!empty($simulated)): ?>style="border: 2px solid #709CA7;" <?php endif; ?>>
>>>>>>> dev_aina
                    <div class="card-icon">
                        <svg viewBox="0 0 24 24" width="24" height="24">
                            <path fill="#709CA7"
                                d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z" />
                        </svg>
                    </div>
                    <div class="card-content">
<<<<<<< HEAD
                        <span class="card-label">Taux de couverture global <?php if (!empty($simulated)): ?><em style="color: #709CA7; font-size: 0.75em;">(après simulation)</em><?php endif; ?></span>
=======
                        <span class="card-label">Taux de couverture global <?php if (!empty($simulated)): ?><em
                                    style="color: #709CA7; font-size: 0.75em;">(après simulation)</em><?php endif; ?></span>
>>>>>>> dev_aina
                        <span class="card-value"><?= $tauxCouverture ?> <small>%</small></span>
                        <?php if (!empty($simulated) && isset($tauxCouvertureInitial)): ?>
                            <span style="font-size: 0.75em; color: #666;">Initial : <?= $tauxCouvertureInitial ?> %</span>
                        <?php endif; ?>
                    </div>
                    <div class="card-progress">
                        <div class="progress-bar">
                            <div class="progress-fill" style="width: <?= min($tauxCouverture, 100) ?>%"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ========== BOUTONS DE SIMULATION ========== -->
            <div class="simulation-actions">
                <!-- Bouton pour ouvrir le modal de simulation -->
                <button type="button" class="btn-simulation" onclick="openModeModal('simuler')">
                    <svg class="btn-icon" viewBox="0 0 24 24" width="20" height="20">
                        <path fill="currentColor" d="M8 5v14l11-7z" />
                    </svg>
                    Simuler le dispatch
                </button>
                <?php if (!empty($simulated)): ?>
                    <a href="<?= BASE_URL ?>/dispatch" class="btn-simulation"
                        style="background: #6c757d; text-decoration: none; display: inline-flex;">
                        <svg class="btn-icon" viewBox="0 0 24 24" width="20" height="20">
                            <path fill="currentColor"
                                d="M12.5 8c-2.65 0-5.05.99-6.9 2.6L2 7v9h9l-3.62-3.62c1.39-1.16 3.16-1.88 5.12-1.88 3.54 0 6.55 2.31 7.6 5.5l2.37-.78C21.08 11.03 17.15 8 12.5 8z" />
                        </svg>
<<<<<<< HEAD
                        Simuler le dispatch
                    </button>
                </form>
                <?php if (!empty($simulated)): ?>
                    <a href="<?= BASE_URL ?>/dispatch" class="btn-simulation" style="background: #6c757d; text-decoration: none; display: inline-flex;">
                        <svg class="btn-icon" viewBox="0 0 24 24" width="20" height="20">
                            <path fill="currentColor" d="M12.5 8c-2.65 0-5.05.99-6.9 2.6L2 7v9h9l-3.62-3.62c1.39-1.16 3.16-1.88 5.12-1.88 3.54 0 6.55 2.31 7.6 5.5l2.37-.78C21.08 11.03 17.15 8 12.5 8z"/>
                        </svg>
                        Retour état initial
                    </a>
=======
                        Retour état initial
                    </a>
                    <?php if (!empty($modeDispatch)): ?>
                        <span class="simulation-badge" style="background: #e3f2fd; color: #1565c0; margin-left: 10px;">
                            Mode : <?php
                            if ($modeDispatch === 'date')
                                echo 'Par date (ancienneté)';
                            elseif ($modeDispatch === 'petit')
                                echo 'Petit à petit (plus petits besoins)';
                            else
                                echo 'Proportionnel (équité)';
                            ?>
                        </span>
                    <?php endif; ?>
>>>>>>> dev_aina
                <?php endif; ?>
                <?php if (!empty($canDistribute)): ?>
                    <!-- Bouton pour ouvrir le modal de distribution -->
                    <button type="button" class="btn-simulation" style="background: #27ae60;"
                        onclick="openModeModal('distribuer')">
                        <svg class="btn-icon" viewBox="0 0 24 24" width="20" height="20">
                            <path fill="currentColor" d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z" />
                        </svg>
                        Distribuer les dons
                    </button>
                <?php else: ?>
                    <button class="btn-simulation" style="background: #ccc; color: #666; cursor: not-allowed;" disabled
                        title="Aucun don disponible ou tous les besoins sont couverts">
                        Distribuer les dons
                    </button>
                <?php endif; ?>
                <?php if (!empty($hasDistribution)): ?>
                    <span class="simulation-badge"
                        style="background: #d4edda; color: #155724; margin-left: 10px;">Distributions effectuées</span>
                <?php endif; ?>
                <br>
                <?php if (!empty($message)): ?>
                    <div
                        style="margin-top: 10px; padding: 10px 15px; background: #d4edda; color: #155724; border-radius: 6px; font-size: 0.9em;">
                        <?= htmlspecialchars($message) ?></div>
                <?php endif; ?>
                <?php if (!empty($error)): ?>
                    <div
                        style="margin-top: 10px; padding: 10px 15px; background: #f8d7da; color: #721c24; border-radius: 6px; font-size: 0.9em;">
                        <?= htmlspecialchars($error) ?></div>
                <?php endif; ?>

                <span class="simulation-hint">La simulation affiche les résultats sans modifier la base de données. La
                    distribution enregistre les allocations.</span>
                <p class="alert-warning">
                    La distribution impacte réellement la base de données.
                    Veuillez utiliser la simulation pour les tests.
                </p>

            </div>

<<<<<<< HEAD
            <!-- ========== TABLEAU DES BESOINS EN COURS ========== -->
            <?php 
=======
            <!-- ========== MODAL CHOIX DU MODE DE DISPATCH ========== -->
            <div id="modeModal"
                style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1000; justify-content: center; align-items: center;">
                <div
                    style="background: white; border-radius: 12px; padding: 30px; max-width: 500px; width: 90%; box-shadow: 0 10px 40px rgba(0,0,0,0.3);">
                    <h3
                        style="margin: 0 0 20px; color: #333; font-size: 1.2em; display: flex; align-items: center; gap: 10px;">
                        <svg viewBox="0 0 24 24" width="24" height="24">
                            <path fill="#137C8B"
                                d="M3 13h2v-2H3v2zm0 4h2v-2H3v2zm0-8h2V7H3v2zm4 4h14v-2H7v2zm0 4h14v-2H7v2zM7 7v2h14V7H7z" />
                        </svg>
                        Choisir le mode de dispatch
                    </h3>
                    <p style="color: #666; margin-bottom: 20px; font-size: 0.9em;">Sélectionnez l'ordre de priorité pour
                        la répartition des dons :</p>

                    <form id="modeForm" method="POST" action="">
                        <div style="display: flex; flex-direction: column; gap: 12px; margin-bottom: 25px;">
                            <!-- Mode 1 : Par date -->
                            <label
                                style="display: flex; align-items: flex-start; gap: 12px; padding: 15px; border: 2px solid #e0e0e0; border-radius: 8px; cursor: pointer; transition: all 0.2s;"
                                onmouseover="this.style.borderColor='#137C8B'"
                                onmouseout="this.style.borderColor=document.getElementById('mode_date').checked ? '#137C8B' : '#e0e0e0'">
                                <input type="radio" name="mode" id="mode_date" value="date" checked
                                    style="margin-top: 3px;">
                                <div>
                                    <strong style="color: #333;">📅 Par date (ancienneté)</strong>
                                    <p style="margin: 5px 0 0; color: #666; font-size: 0.85em;">
                                        Les besoins les plus anciens sont servis en premier. L'ordre est basé sur la
                                        date de saisie.
                                    </p>
                                </div>
                            </label>

                            <!-- Mode 2 : Petit à petit -->
                            <label
                                style="display: flex; align-items: flex-start; gap: 12px; padding: 15px; border: 2px solid #e0e0e0; border-radius: 8px; cursor: pointer; transition: all 0.2s;"
                                onmouseover="this.style.borderColor='#137C8B'"
                                onmouseout="this.style.borderColor=document.getElementById('mode_petit').checked ? '#137C8B' : '#e0e0e0'">
                                <input type="radio" name="mode" id="mode_petit" value="petit" style="margin-top: 3px;">
                                <div>
                                    <strong style="color: #333;">📊 Petit à petit (plus petits besoins)</strong>
                                    <p style="margin: 5px 0 0; color: #666; font-size: 0.85em;">
                                        Les villes avec les besoins les plus petits sont servis en premier. Permet de
                                        couvrir plus de villes.
                                    </p>
                                </div>
                            </label>

                            <!-- Mode 3 : Proportionnel -->
                            <label
                                style="display: flex; align-items: flex-start; gap: 12px; padding: 15px; border: 2px solid #e0e0e0; border-radius: 8px; cursor: pointer; transition: all 0.2s;"
                                onmouseover="this.style.borderColor='#137C8B'"
                                onmouseout="this.style.borderColor=document.getElementById('mode_proportionnel').checked ? '#137C8B' : '#e0e0e0'">
                                <input type="radio" name="mode" id="mode_proportionnel" value="proportionnel"
                                    style="margin-top: 3px;">
                                <div>
                                    <strong style="color: #333;">⚖️ Proportionnel (équité)</strong>
                                    <p style="margin: 5px 0 0; color: #666; font-size: 0.85em;">
                                        Chaque ville reçoit une part proportionnelle à ses besoins. Le reste est
                                        distribué aux plus fortes décimales (méthode du plus fort reste).
                                    </p>
                                </div>
                            </label>
                        </div>

                        <div style="display: flex; gap: 10px; justify-content: flex-end;">
                            <button type="button" onclick="closeModeModal()"
                                style="padding: 10px 20px; border: 1px solid #ccc; background: white; border-radius: 6px; cursor: pointer; font-size: 0.9em;">
                                Annuler
                            </button>
                            <button type="submit"
                                style="padding: 10px 20px; background: #137C8B; color: white; border: none; border-radius: 6px; cursor: pointer; font-size: 0.9em; font-weight: 600;">
                                Confirmer
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <script>
                let currentAction = 'simuler';

                function openModeModal(action) {
                    currentAction = action;
                    const modal = document.getElementById('modeModal');
                    const form = document.getElementById('modeForm');

                    if (action === 'simuler') {
                        form.action = '<?= BASE_URL ?>/dispatch/simuler';
                    } else {
                        form.action = '<?= BASE_URL ?>/dispatch/distribuer';
                    }

                    modal.style.display = 'flex';
                }

                function closeModeModal() {
                    document.getElementById('modeModal').style.display = 'none';
                }

                // Fermer le modal en cliquant à l'extérieur
                document.getElementById('modeModal').addEventListener('click', function (e) {
                    if (e.target === this) {
                        closeModeModal();
                    }
                });

                // Confirmation pour distribuer
                document.getElementById('modeForm').addEventListener('submit', function (e) {
                    if (currentAction === 'distribuer') {
                        if (!confirm('Confirmer la distribution ? Les dons disponibles seront attribués aux besoins restants.')) {
                            e.preventDefault();
                        }
                    }
                });
            </script>

            <!-- ========== TABLEAU DES BESOINS EN COURS ========== -->
            <?php
>>>>>>> dev_aina
            // En mode simulation, utiliser les allocations avec quantités restantes
            if (!empty($simulated) && !empty($simulation['allocations'])) {
                $besoinsAffiches = array_filter($simulation['allocations'], fn($a) => $a['quantite_manquante'] > 0);
                $isSimulationMode = true;
            } else {
                $besoinsAffiches = $besoins ?? [];
                $isSimulationMode = false;
            }
            ?>
            <?php if (!empty($besoinsAffiches)): ?>
<<<<<<< HEAD
            <div style="margin: 25px 0;">
                <h2 style="margin: 0 0 15px; color: #333; font-size: 1.1em; display: flex; align-items: center; gap: 10px;">
                    <svg viewBox="0 0 24 24" width="20" height="20">
                        <path fill="#E68A2E" d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                    </svg>
                    Besoins des villes à couvrir
                    <?php if ($isSimulationMode): ?>
                        <em style="color: #137C8B; font-size: 0.75em;">(après simulation)</em>
                    <?php endif; ?>
                    <span style="background: <?= $isSimulationMode ? '#e3f2fd' : '#fef3e6' ?>; color: <?= $isSimulationMode ? '#137C8B' : '#E68A2E' ?>; padding: 3px 10px; border-radius: 12px; font-size: 0.8em; font-weight: 500;"><?= count($besoinsAffiches) ?> besoins restants</span>
                </h2>
                <div class="table-container" style="max-height: 350px; overflow-y: auto;">
                    <table class="simulation-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Date besoin</th>
                                <th>Ville</th>
                                <th>Produit</th>
                                <th>Catégorie</th>
                                <?php if ($isSimulationMode): ?>
                                    <th>Qté initiale</th>
                                    <th>Attribué</th>
                                    <th>Qté restante</th>
                                <?php else: ?>
                                    <th>Quantité</th>
                                <?php endif; ?>
                                <th>P.U.</th>
                                <th>Montant restant (Ar)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $index = 0; foreach ($besoinsAffiches as $besoin): $index++; ?>
                            <tr>
                                <td><?= $index ?></td>
                                <td class="date-cell"><?= date('d/m/Y H:i', strtotime($besoin['date_besoin'])) ?></td>
                                <td>
                                    <div class="ville-cell">
                                        <span class="ville-nom"><?= htmlspecialchars($besoin['nom_ville']) ?></span>
                                        <?php if (isset($besoin['nom_region'])): ?>
                                            <span class="ville-region"><?= htmlspecialchars($besoin['nom_region']) ?></span>
                                        <?php endif; ?>
                                    </div>
                                </td>
                                <td><?= htmlspecialchars($besoin['nom_produit']) ?></td>
                                <td>
                                    <span class="badge badge-<?= $besoin['nom_categorie'] ?>"><?= $besoin['nom_categorie'] ?></span>
                                </td>
                                <?php if ($isSimulationMode): ?>
                                    <td style="text-align: center; color: #999;"><?= number_format($besoin['quantite_demandee'], 0, ',', ' ') ?></td>
                                    <td style="text-align: center; color: #27ae60; font-weight: 600;">-<?= number_format($besoin['quantite_attribuee'], 0, ',', ' ') ?></td>
                                    <td style="text-align: center; font-weight: 700; color: #e74c3c;"><?= number_format($besoin['quantite_manquante'], 0, ',', ' ') ?></td>
                                <?php else: ?>
                                    <td style="text-align: center;"><?= number_format($besoin['quantite_besoin'], 0, ',', ' ') ?></td>
                                <?php endif; ?>
                                <td style="text-align: right;"><?= number_format($besoin['pu'], 0, ',', ' ') ?></td>
                                <?php 
                                $montant = $isSimulationMode 
                                    ? ($besoin['quantite_manquante'] * $besoin['pu']) 
                                    : $besoin['montant_estime'];
                                ?>
                                <td style="text-align: right; font-weight: 600; color: #E68A2E;"><?= number_format($montant, 0, ',', ' ') ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php elseif (!empty($simulated)): ?>
            <div style="margin: 25px 0; padding: 20px; background: #d4edda; border-radius: 8px; text-align: center; color: #155724;">
                <strong>Simulation : Tous les besoins seraient couverts !</strong> Tous les besoins peuvent être satisfaits avec les dons disponibles.
            </div>
            <?php else: ?>
            <div style="margin: 25px 0; padding: 20px; background: #d4edda; border-radius: 8px; text-align: center; color: #155724;">
                <strong>Tous les besoins sont couverts !</strong> Aucun besoin en attente de distribution.
            </div>
=======
                <div style="margin: 25px 0;">
                    <h2
                        style="margin: 0 0 15px; color: #333; font-size: 1.1em; display: flex; align-items: center; gap: 10px;">
                        <svg viewBox="0 0 24 24" width="20" height="20">
                            <path fill="#E68A2E"
                                d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z" />
                        </svg>
                        Besoins des villes à couvrir
                        <?php if ($isSimulationMode): ?>
                            <em style="color: #137C8B; font-size: 0.75em;">(après simulation)</em>
                        <?php endif; ?>
                        <span
                            style="background: <?= $isSimulationMode ? '#e3f2fd' : '#fef3e6' ?>; color: <?= $isSimulationMode ? '#137C8B' : '#E68A2E' ?>; padding: 3px 10px; border-radius: 12px; font-size: 0.8em; font-weight: 500;"><?= count($besoinsAffiches) ?>
                            besoins restants</span>
                    </h2>
                    <div class="table-container" style="max-height: 350px; overflow-y: auto;">
                        <table class="simulation-table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Date besoin</th>
                                    <th>Ville</th>
                                    <th>Produit</th>
                                    <th>Catégorie</th>
                                    <?php if ($isSimulationMode): ?>
                                        <th>Qté initiale</th>
                                        <th>Attribué</th>
                                        <th>Qté restante</th>
                                    <?php else: ?>
                                        <th>Quantité</th>
                                    <?php endif; ?>
                                    <th>P.U.</th>
                                    <th>Montant restant (Ar)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $index = 0;
                                foreach ($besoinsAffiches as $besoin):
                                    $index++; ?>
                                    <tr>
                                        <td><?= $index ?></td>
                                        <td class="date-cell"><?= date('d/m/Y H:i', strtotime($besoin['date_besoin'])) ?></td>
                                        <td>
                                            <div class="ville-cell">
                                                <span class="ville-nom"><?= htmlspecialchars($besoin['nom_ville']) ?></span>
                                                <?php if (isset($besoin['nom_region'])): ?>
                                                    <span class="ville-region"><?= htmlspecialchars($besoin['nom_region']) ?></span>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                        <td><?= htmlspecialchars($besoin['nom_produit']) ?></td>
                                        <td>
                                            <span
                                                class="badge badge-<?= $besoin['nom_categorie'] ?>"><?= $besoin['nom_categorie'] ?></span>
                                        </td>
                                        <?php if ($isSimulationMode): ?>
                                            <td style="text-align: center; color: #999;">
                                                <?= number_format($besoin['quantite_demandee'], 0, ',', ' ') ?></td>
                                            <td style="text-align: center; color: #27ae60; font-weight: 600;">
                                                -<?= number_format($besoin['quantite_attribuee'], 0, ',', ' ') ?></td>
                                            <td style="text-align: center; font-weight: 700; color: #e74c3c;">
                                                <?= number_format($besoin['quantite_manquante'], 0, ',', ' ') ?></td>
                                        <?php else: ?>
                                            <td style="text-align: center;">
                                                <?= number_format($besoin['quantite_besoin'], 0, ',', ' ') ?></td>
                                        <?php endif; ?>
                                        <td style="text-align: right;"><?= number_format($besoin['pu'], 0, ',', ' ') ?></td>
                                        <?php
                                        $montant = $isSimulationMode
                                            ? ($besoin['quantite_manquante'] * $besoin['pu'])
                                            : $besoin['montant_estime'];
                                        ?>
                                        <td style="text-align: right; font-weight: 600; color: #E68A2E;">
                                            <?= number_format($montant, 0, ',', ' ') ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            <?php elseif (!empty($simulated)): ?>
                <div
                    style="margin: 25px 0; padding: 20px; background: #d4edda; border-radius: 8px; text-align: center; color: #155724;">
                    <strong>Simulation : Tous les besoins seraient couverts !</strong> Tous les besoins peuvent être
                    satisfaits avec les dons disponibles.
                </div>
            <?php else: ?>
                <div
                    style="margin: 25px 0; padding: 20px; background: #d4edda; border-radius: 8px; text-align: center; color: #155724;">
                    <strong>Tous les besoins sont couverts !</strong> Aucun besoin en attente de distribution.
                </div>
>>>>>>> dev_aina
            <?php endif; ?>

            <?php if (!empty($simulated) && $simulation): ?>
                <!-- ========== TABLEAU PAR VILLE ========== -->
                <div class="table-container">
                    <table class="simulation-table">
                        <thead>
                            <tr>
                                <th>Ville</th>
                                <th>Besoin total (Ar)</th>
                                <th>Don attribué (Ar)</th>
                                <th>Reste à couvrir (Ar)</th>
                                <th>Taux</th>
                                <th>Statut</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($simulation['par_ville'] as $ville): ?>
                                <tr>
                                    <td>
                                        <div class="ville-cell">
                                            <span class="ville-nom"><?= htmlspecialchars($ville['nom_ville']) ?></span>
                                            <span class="ville-region"><?= htmlspecialchars($ville['nom_region']) ?></span>
                                        </div>
                                    </td>
                                    <td class="montant"><?= number_format($ville['total_besoins'], 0, ',', ' ') ?></td>
                                    <td class="montant attribue"><?= number_format($ville['total_attribue'], 0, ',', ' ') ?>
                                    </td>
                                    <td class="montant reste"><?= number_format($ville['reste'], 0, ',', ' ') ?></td>
                                    <td><?= $ville['taux_couverture'] ?>%</td>
                                    <td>
                                        <span class="status-badge status-<?= $ville['statut'] ?>">
                                            <span class="status-dot"></span>
                                            <?php
                                            if ($ville['statut'] === 'couvert')
                                                echo 'Couvert';
                                            elseif ($ville['statut'] === 'partiel')
                                                echo 'Partiel';
                                            else
                                                echo 'Non couvert';
                                            ?>
                                        </span>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <!-- ========== DÉTAIL DES ALLOCATIONS ========== -->
                <h2 style="margin: 30px 0 15px; color: #333; font-size: 1.1em;">Détail des allocations par ordre de priorité
                </h2>
                <div class="table-container">
                    <table class="simulation-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Date besoin</th>
                                <th>Ville</th>
                                <th>Produit</th>
                                <th>Catégorie</th>
                                <th>Demandé</th>
                                <th>Attribué</th>
                                <th>Manquant</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($simulation['allocations'] as $i => $alloc): ?>
                                <tr>
                                    <td><?= $i + 1 ?></td>
                                    <td class="date-cell"><?= date('d/m/Y H:i', strtotime($alloc['date_besoin'])) ?></td>
                                    <td><?= htmlspecialchars($alloc['nom_ville']) ?></td>
                                    <td><?= htmlspecialchars($alloc['nom_produit']) ?></td>
                                    <td>
                                        <span
                                            class="badge badge-<?= $alloc['nom_categorie'] ?>"><?= $alloc['nom_categorie'] ?></span>
                                    </td>
                                    <td><?= number_format($alloc['quantite_demandee'], 0, ',', ' ') ?></td>
                                    <td style="color: #137C8B; font-weight: 600;">
                                        <?= number_format($alloc['quantite_attribuee'], 0, ',', ' ') ?></td>
                                    <td style="color: <?= $alloc['quantite_manquante'] > 0 ? '#e74c3c' : '#27ae60' ?>;">
                                        <?= number_format($alloc['quantite_manquante'], 0, ',', ' ') ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <!-- ========== LÉGENDE ET RÉCAPITULATIF ========== -->
                <div class="simulation-footer">
                    <div class="stats-legend">
                        <div class="legend-item">
                            <span class="legend-dot couvert"></span>
                            <span>Couvert (<?= $simulation['totaux']['nb_couvert'] ?> villes)</span>
                        </div>
                        <div class="legend-item">
                            <span class="legend-dot partiel"></span>
                            <span>Partiel (<?= $simulation['totaux']['nb_partiel'] ?> villes)</span>
                        </div>
                        <div class="legend-item">
                            <span class="legend-dot non-couvert"></span>
                            <span>Non couvert (<?= $simulation['totaux']['nb_non_couvert'] ?> villes)</span>
                        </div>
                    </div>
                    <div class="simulation-stats">
                        <div class="stat-block">
                            <span class="stat-label">Total attribué</span>
                            <span
                                class="stat-value"><?= number_format($simulation['totaux']['total_attribue'], 0, ',', ' ') ?>
                                Ar</span>
                        </div>
                        <div class="stat-block">
                            <span class="stat-label">Reste global</span>
                            <span
                                class="stat-value highlight"><?= number_format($simulation['totaux']['total_reste'], 0, ',', ' ') ?>
                                Ar</span>
                        </div>
                    </div>
                </div>

            <?php else: ?>
                <!-- ========== MESSAGE QUAND PAS DE SIMULATION ========== -->
                <div class="info-note" style="text-align: center; padding: 40px;">
                    <svg class="info-icon" viewBox="0 0 24 24" width="40" height="40">
                        <path fill="#7A90A4"
                            d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z" />
                    </svg>
                    <p style="margin-top: 15px; color: #666; font-size: 1.1em;">
                        Cliquez sur <strong>"Simuler le dispatch"</strong> pour voir la répartition des dons aux villes par
                        ordre de date de besoin.
                    </p>
                    <p style="color: #999; font-size: 0.9em;">
                        La simulation ne modifie pas la base de données.
                    </p>
                </div>
            <?php endif; ?>

            <!-- ========== HISTORIQUE DES DISTRIBUTIONS ========== -->
            <?php if (!empty($historique)): ?>
                <h2 style="margin: 30px 0 15px; color: #333; font-size: 1.1em;">Historique des distributions</h2>
                <div class="table-container">
                    <table class="simulation-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Date</th>
                                <th>Dons disponibles</th>
                                <th>Total attribué</th>
                                <th>Nb allocations</th>
                                <th>Besoins couverts</th>
                                <th>Besoins partiels</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($historique as $i => $h): ?>
                                <tr>
                                    <td><?= $h['id'] ?></td>
                                    <td><?= date('d/m/Y H:i', strtotime($h['date_distribution'])) ?></td>
                                    <td class="montant"><?= number_format($h['total_dons_disponibles'], 0, ',', ' ') ?> Ar</td>
                                    <td class="montant attribue"><?= number_format($h['total_attribue'], 0, ',', ' ') ?> Ar</td>
                                    <td><?= $h['nb_allocations'] ?></td>
                                    <td style="color: #27ae60;"><?= $h['nb_besoins_couverts'] ?></td>
                                    <td style="color: #e67e22;"><?= $h['nb_besoins_partiels'] ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>

            <!-- ========== NOTE D'INFORMATION ========== -->
            <div class="info-note">
                <svg class="info-icon" viewBox="0 0 24 24" width="18" height="18">
                    <path fill="#7A90A4"
                        d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z" />
                </svg>
                <span>Les dons sont répartis par ordre chronologique des besoins. Les besoins les plus anciens sont
                    servis en priorité.</span>
            </div>

            <!-- ========== FOOTER ========== -->
            <footer class="footer">
                <p>© 2026 BNGRC - Système de gestion des dons</p>
                <p>ETU004031 - ETU004183 - ETU004273</p>
            </footer>
        </main>
    </div>
</body>

</html>