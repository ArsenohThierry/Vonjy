<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.5">
    <title>BNGRC · Tableau de bord</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/index.css">
</head>
<body>
    <!-- ========== LAYOUT PRINCIPAL AVEC MENU LATERAL ========== -->
    <?php $activePage = 'dashboard'; ?>
    <div class="app-container">
        <!-- ========== MENU DE NAVIGATION GAUCHE ========== -->
        <?php include('partials/sidebar.php'); ?>

        <!-- ========== CONTENU PRINCIPAL ========== -->
        <main class="main-content">
            <!-- Header avec titre et boutons -->
            <header class="content-header">
                <h1 class="page-title">Vonjy BNGRC - Dashboard</h1>
                <div class="action-buttons">
                    <a href="<?= BASE_URL ?>/dispatch"><button class="btn">Simuler le dispatch</button></a>
                    <a href="<?= BASE_URL ?>/add-besoin"><button class="btn">Ajouter un besoin</button></a>
                    <a href="<?= BASE_URL ?>/add-don"><button class="btn">Ajouter un don</button></a>
                </div>
            </header>

            <!-- ========== STATISTIQUES GLOBALES (GRILLE DE CARDS) ========== -->
            <div class="stats-grid">
                <!-- Carte Total besoins -->
                <div class="card card-besoin">
                    <div class="card-title">Total des besoins</div>
                    <div class="card-value">2,45 <small>Mrd Ar</small></div>
                </div>
                <!-- Carte Total dons reçus -->
                <div class="card card-dons">
                    <div class="card-title">Total des dons reçus</div>
                    <div class="card-value">1,82 <small>Mrd Ar</small></div>
                </div>
                <!-- Carte Total attribué -->
                <div class="card card-attribue">
                    <div class="card-title">Total attribué</div>
                    <div class="card-value">1,24 <small>Mrd Ar</small></div>
                </div>
                <!-- Carte Reste à couvrir -->
                <div class="card card-reste">
                    <div class="card-title">Reste à couvrir</div>
                    <div class="card-value">1,21 <small>Mrd Ar</small></div>
                </div>
            </div>

            <!-- ========== SECTION SUIVI PAR VILLE ========== -->
            <h2 class="section-title">Suivi par ville</h2>
            
            <!-- Tableau avec scroll horizontal sur mobile -->
            <div class="table-responsive">
                <table class="dashboard-table">
                    <thead>
                        <tr>
                            <th>Ville</th>
                            <th>Estimation Besoins (Ar)</th>
                            <th>Total dons attribués (Ar)</th>
                            <th>Taux de couverture</th>
                            <th>Reste à couvrir (Ar)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Antananarivo</td>
                            <td>850 000 000</td>
                            <td>510 000 000</td>
                            <td>
                                <div class="progress-bar">
                                    <div class="progress-fill" style="width: 60%;">60%</div>
                                </div>
                            </td>
                            <td class="remaining">340 000 000</td>
                        </tr>
                        <tr>
                            <td>Toamasina</td>
                            <td>420 000 000</td>
                            <td>294 000 000</td>
                            <td>
                                <div class="progress-bar">
                                    <div class="progress-fill" style="width: 70%;">70%</div>
                                </div>
                            </td>
                            <td class="remaining">126 000 000</td>
                        </tr>
                        <tr>
                            <td>Antsiranana</td>
                            <td>290 000 000</td>
                            <td>116 000 000</td>
                            <td>
                                <div class="progress-bar">
                                    <div class="progress-fill" style="width: 40%;">40%</div>
                                </div>
                            </td>
                            <td class="remaining">174 000 000</td>
                        </tr>
                        <tr>
                            <td>Fianarantsoa</td>
                            <td>380 000 000</td>
                            <td>247 000 000</td>
                            <td>
                                <div class="progress-bar">
                                    <div class="progress-fill" style="width: 65%;">65%</div>
                                </div>
                            </td>
                            <td class="remaining">133 000 000</td>
                        </tr>
                        <tr>
                            <td>Mahajanga</td>
                            <td>315 000 000</td>
                            <td>189 000 000</td>
                            <td>
                                <div class="progress-bar">
                                    <div class="progress-fill" style="width: 60%;">60%</div>
                                </div>
                            </td>
                            <td class="remaining">126 000 000</td>
                        </tr>
                        <tr>
                            <td>Toliara</td>
                            <td>195 000 000</td>
                            <td>78 000 000</td>
                            <td>
                                <div class="progress-bar">
                                    <div class="progress-fill" style="width: 40%;">40%</div>
                                </div>
                            </td>
                            <td class="remaining">117 000 000</td>
                        </tr>
                    </tbody>
                </table>
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