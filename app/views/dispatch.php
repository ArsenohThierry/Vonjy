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
                    <p class="page-subtitle">Optimisation de l'allocation des ressources par ville</p>
                </div>
                <div class="header-actions">
                    <span class="simulation-badge">Simulation en cours</span>
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
                        <span class="card-value">23 500 000 <small>Ar</small></span>
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
                        <span class="card-value">32 450 000 <small>Ar</small></span>
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
                        <span class="card-value">72,4 <small>%</small></span>
                    </div>
                    <div class="card-progress">
                        <div class="progress-bar">
                            <div class="progress-fill" style="width: 72.4%"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ========== BOUTON CENTRAL DE SIMULATION ========== -->
            <div class="simulation-actions">
                <button class="btn-simulation">
                    <svg class="btn-icon" viewBox="0 0 24 24" width="20" height="20">
                        <path fill="currentColor" d="M8 5v14l11-7z"/>
                    </svg>
                    Lancer la simulation
                </button>
                <span class="simulation-hint">Cliquez pour actualiser la répartition</span>
            </div>

            <!-- ========== TABLEAU RÉCAPITULATIF ========== -->
            <div class="table-container">
                <table class="simulation-table">
                    <thead>
                        <tr>
                            <th>Ville</th>
                            <th>Besoin total (Ar)</th>
                            <th>Don attribué (Ar)</th>
                            <th>Reste à couvrir (Ar)</th>
                            <th>Statut</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Ambositra - Couvert -->
                        <tr>
                            <td>
                                <div class="ville-cell">
                                    <span class="ville-nom">Ambositra</span>
                                    <span class="ville-region">Amoron'i Mania</span>
                                </div>
                            </td>
                            <td class="montant">5 400 000</td>
                            <td class="montant attribue">5 400 000</td>
                            <td class="montant reste">0</td>
                            <td>
                                <span class="status-badge status-couvert">
                                    <span class="status-dot"></span>
                                    Couvert
                                </span>
                            </td>
                        </tr>
                        <!-- Morondava - Partiel -->
                        <tr>
                            <td>
                                <div class="ville-cell">
                                    <span class="ville-nom">Morondava</span>
                                    <span class="ville-region">Menabe</span>
                                </div>
                            </td>
                            <td class="montant">2 762 500</td>
                            <td class="montant attribue">1 850 000</td>
                            <td class="montant reste">912 500</td>
                            <td>
                                <span class="status-badge status-partiel">
                                    <span class="status-dot"></span>
                                    Partiel
                                </span>
                            </td>
                        </tr>
                        <!-- Fort-Dauphin - Partiel -->
                        <tr>
                            <td>
                                <div class="ville-cell">
                                    <span class="ville-nom">Fort-Dauphin</span>
                                    <span class="ville-region">Anosy</span>
                                </div>
                            </td>
                            <td class="montant">5 600 000</td>
                            <td class="montant attribue">3 200 000</td>
                            <td class="montant reste">2 400 000</td>
                            <td>
                                <span class="status-badge status-partiel">
                                    <span class="status-dot"></span>
                                    Partiel
                                </span>
                            </td>
                        </tr>
                        <!-- Nosy Be - Couvert -->
                        <tr>
                            <td>
                                <div class="ville-cell">
                                    <span class="ville-nom">Nosy Be</span>
                                    <span class="ville-region">Diana</span>
                                </div>
                            </td>
                            <td class="montant">975 000</td>
                            <td class="montant attribue">975 000</td>
                            <td class="montant reste">0</td>
                            <td>
                                <span class="status-badge status-couvert">
                                    <span class="status-dot"></span>
                                    Couvert
                                </span>
                            </td>
                        </tr>
                        <!-- Antananarivo - Non couvert -->
                        <tr>
                            <td>
                                <div class="ville-cell">
                                    <span class="ville-nom">Antananarivo</span>
                                    <span class="ville-region">Analamanga</span>
                                </div>
                            </td>
                            <td class="montant">15 000 000</td>
                            <td class="montant attribue">6 500 000</td>
                            <td class="montant reste">8 500 000</td>
                            <td>
                                <span class="status-badge status-non-couvert">
                                    <span class="status-dot"></span>
                                    Non couvert
                                </span>
                            </td>
                        </tr>
                        <!-- Toamasina - Partiel -->
                        <tr>
                            <td>
                                <div class="ville-cell">
                                    <span class="ville-nom">Toamasina</span>
                                    <span class="ville-region">Atsinanana</span>
                                </div>
                            </td>
                            <td class="montant">2 400 000</td>
                            <td class="montant attribue">1 800 000</td>
                            <td class="montant reste">600 000</td>
                            <td>
                                <span class="status-badge status-partiel">
                                    <span class="status-dot"></span>
                                    Partiel
                                </span>
                            </td>
                        </tr>
                        <!-- Fianarantsoa - Non couvert -->
                        <tr>
                            <td>
                                <div class="ville-cell">
                                    <span class="ville-nom">Fianarantsoa</span>
                                    <span class="ville-region">Haute Matsiatra</span>
                                </div>
                            </td>
                            <td class="montant">2 560 000</td>
                            <td class="montant attribue">875 000</td>
                            <td class="montant reste">1 685 000</td>
                            <td>
                                <span class="status-badge status-non-couvert">
                                    <span class="status-dot"></span>
                                    Non couvert
                                </span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- ========== LÉGENDE ET RÉCAPITULATIF ========== -->
            <div class="simulation-footer">
                <div class="stats-legend">
                    <div class="legend-item">
                        <span class="legend-dot couvert"></span>
                        <span>Couvert (2 villes)</span>
                    </div>
                    <div class="legend-item">
                        <span class="legend-dot partiel"></span>
                        <span>Partiel (3 villes)</span>
                    </div>
                    <div class="legend-item">
                        <span class="legend-dot non-couvert"></span>
                        <span>Non couvert (2 villes)</span>
                    </div>
                </div>
                <div class="simulation-stats">
                    <div class="stat-block">
                        <span class="stat-label">Total attribué</span>
                        <span class="stat-value">20 600 000 Ar</span>
                    </div>
                    <div class="stat-block">
                        <span class="stat-label">Reste global</span>
                        <span class="stat-value highlight">14 097 500 Ar</span>
                    </div>
                </div>
            </div>

            <!-- ========== NOTE D'INFORMATION ========== -->
            <div class="info-note">
                <svg class="info-icon" viewBox="0 0 24 24" width="18" height="18">
                    <path fill="#7A90A4" d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/>
                </svg>
                <span>Simulation basée sur les besoins prioritaires et la disponibilité des dons. Les montants sont indicatifs.</span>
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