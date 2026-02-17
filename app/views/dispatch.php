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
                <div class="header-actions">
                    <?php if (!empty($simulated)): ?>
                        <span class="simulation-badge">Simulation terminée</span>
                    <?php else: ?>
                        <span class="simulation-badge" style="background: #f0f0f0; color: #666;">En attente de simulation</span>
                    <?php endif; ?>
                </div>
            </header>

            <!-- ========== RÉSUMÉ EN 3 CARDS ========== -->
            <div class="summary-cards">
                <!-- Card Total dons -->
                <div class="summary-card card-dons">
                    <div class="card-icon">
                        <svg viewBox="0 0 24 24" width="24" height="24">
                            <path fill="#137C8B" d="M20 6h-2v2h-2V6h-2V4h2V2h2v2h2v2zm-10 2H8V6h2v2zm0 8H6v-4h4v4zm2 0v-4h4v4h-4zm-6 4v-2h2v2H6zm8 0v-2h2v2h-2zm-6-8H4V8h4v4zM2 20V4h12v2h-2v2h2v2h-2v2h2v2h-2v2h2v2H2z"/>
                        </svg>
                    </div>
                    <div class="card-content">
                        <span class="card-label">Total dons disponibles</span>
                        <span class="card-value"><?= number_format($totalDons, 0, ',', ' ') ?> <small>Ar</small></span>
                    </div>
                </div>

                <!-- Card Total besoins -->
                <div class="summary-card card-besoins">
                    <div class="card-icon">
                        <svg viewBox="0 0 24 24" width="24" height="24">
                            <path fill="#E68A2E" d="M20 8h-2.81c-.45-.78-1.07-1.45-1.82-1.96L17 4.41 15.59 3l-2.17 2.17C12.96 5.06 12.49 5 12 5s-.96.06-1.41.17L8.41 3 7 4.41l1.62 1.63C7.88 6.55 7.26 7.22 6.81 8H4v2h2.09c-.05.33-.09.66-.09 1v1H4v2h2v1c0 .34.04.67.09 1H4v2h2.81c1.04 1.79 2.97 3 5.19 3s4.15-1.21 5.19-3H20v-2h-2.09c.05-.33.09-.66.09-1v-1h2v-2h-2v-1c0-.34-.04-.67-.09-1H20V8z"/>
                        </svg>
                    </div>
                    <div class="card-content">
                        <span class="card-label">Total besoins estimés</span>
                        <span class="card-value"><?= number_format($totalBesoins, 0, ',', ' ') ?> <small>Ar</small></span>
                    </div>
                </div>

                <!-- Card Taux de couverture -->
                <div class="summary-card card-couverture">
                    <div class="card-icon">
                        <svg viewBox="0 0 24 24" width="24" height="24">
                            <path fill="#709CA7" d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                        </svg>
                    </div>
                    <div class="card-content">
                        <span class="card-label">Taux de couverture global</span>
                        <span class="card-value"><?= $tauxCouverture ?> <small>%</small></span>
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
                <form method="POST" action="<?= BASE_URL ?>/dispatch/simuler" style="display: inline;">
                    <button type="submit" class="btn-simulation">
                        <svg class="btn-icon" viewBox="0 0 24 24" width="20" height="20">
                            <path fill="currentColor" d="M8 5v14l11-7z"/>
                        </svg>
                        Simuler le dispatch
                    </button>
                </form>
                <?php if (!empty($canDistribute)): ?>
                    <form method="POST" action="<?= BASE_URL ?>/dispatch/distribuer" style="display: inline;">
                        <button type="submit" class="btn-simulation" style="background: #27ae60;" onclick="return confirm('Confirmer la distribution ? Les dons disponibles seront attribués aux besoins restants.')">
                            <svg class="btn-icon" viewBox="0 0 24 24" width="20" height="20">
                                <path fill="currentColor" d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
                            </svg>
                            Distribuer les dons
                        </button>
                    </form>
                <?php else: ?>
                    <button class="btn-simulation" style="background: #ccc; color: #666; cursor: not-allowed;" disabled title="Aucun don disponible ou tous les besoins sont couverts">
                        Distribuer les dons
                    </button>
                <?php endif; ?>
                <?php if (!empty($hasDistribution)): ?>
                    <span class="simulation-badge" style="background: #d4edda; color: #155724; margin-left: 10px;">Distributions effectuées</span>
                <?php endif; ?>
                <br>
                <?php if (!empty($message)): ?>
                    <div style="margin-top: 10px; padding: 10px 15px; background: #d4edda; color: #155724; border-radius: 6px; font-size: 0.9em;"><?= htmlspecialchars($message) ?></div>
                <?php endif; ?>
                <?php if (!empty($error)): ?>
                    <div style="margin-top: 10px; padding: 10px 15px; background: #f8d7da; color: #721c24; border-radius: 6px; font-size: 0.9em;"><?= htmlspecialchars($error) ?></div>
                <?php endif; ?>
                <span class="simulation-hint">La simulation affiche les résultats sans modifier la base de données. La distribution enregistre les allocations.</span>
            </div>

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
                            <td class="montant attribue"><?= number_format($ville['total_attribue'], 0, ',', ' ') ?></td>
                            <td class="montant reste"><?= number_format($ville['reste'], 0, ',', ' ') ?></td>
                            <td><?= $ville['taux_couverture'] ?>%</td>
                            <td>
                                <span class="status-badge status-<?= $ville['statut'] ?>">
                                    <span class="status-dot"></span>
                                    <?php 
                                    if ($ville['statut'] === 'couvert') echo 'Couvert';
                                    elseif ($ville['statut'] === 'partiel') echo 'Partiel';
                                    else echo 'Non couvert';
                                    ?>
                                </span>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- ========== DÉTAIL DES ALLOCATIONS ========== -->
            <h2 style="margin: 30px 0 15px; color: #333; font-size: 1.1em;">Détail des allocations par ordre de priorité</h2>
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
                                <span class="badge badge-<?= $alloc['nom_categorie'] ?>"><?= $alloc['nom_categorie'] ?></span>
                            </td>
                            <td><?= number_format($alloc['quantite_demandee'], 0, ',', ' ') ?></td>
                            <td style="color: #137C8B; font-weight: 600;"><?= number_format($alloc['quantite_attribuee'], 0, ',', ' ') ?></td>
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
                        <span class="stat-value"><?= number_format($simulation['totaux']['total_attribue'], 0, ',', ' ') ?> Ar</span>
                    </div>
                    <div class="stat-block">
                        <span class="stat-label">Reste global</span>
                        <span class="stat-value highlight"><?= number_format($simulation['totaux']['total_reste'], 0, ',', ' ') ?> Ar</span>
                    </div>
                </div>
            </div>

            <?php else: ?>
            <!-- ========== MESSAGE QUAND PAS DE SIMULATION ========== -->
            <div class="info-note" style="text-align: center; padding: 40px;">
                <svg class="info-icon" viewBox="0 0 24 24" width="40" height="40">
                    <path fill="#7A90A4" d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/>
                </svg>
                <p style="margin-top: 15px; color: #666; font-size: 1.1em;">
                    Cliquez sur <strong>"Simuler le dispatch"</strong> pour voir la répartition des dons aux villes par ordre de date de besoin.
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
                    <path fill="#7A90A4" d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/>
                </svg>
                <span>Les dons sont répartis par ordre chronologique des besoins. Les besoins les plus anciens sont servis en priorité.</span>
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