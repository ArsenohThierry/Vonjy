<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.5">
    <title>BNGRC · Tableau de bord</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/index.css">
    <style>
        a {
            color: #137C8B;
            text-decoration: none;
        }
    </style>
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
                    <div class="card-value"><?= number_format($totalBesoins['estimation_totale_besoins'], 0, ',', ' ') ?> <small>Ar</small></div>
                </div>
                <!-- Carte Total dons reçus -->
                <div class="card card-dons">
                    <div class="card-title">Total des dons reçus</div>
                    <div class="card-value"><?= number_format($totalDons, 0, ',', ' ') ?> <small>Ar</small></div>
                </div>
                <!-- Carte Total attribué -->
                <div class="card card-attribue">
                    <div class="card-title">Total attribué</div>
                    <div class="card-value"><?= number_format($simulation['totaux']['total_attribue'], 0, ',', ' ') ?> <small>Ar</small></div>
                </div>
                <!-- Carte Reste à couvrir -->
                <div class="card card-reste">
                    <div class="card-title">Reste à couvrir</div>
                    <div class="card-value"><?= number_format($simulation['totaux']['total_reste'], 0, ',', ' ') ?> <small>Ar</small></div>
                </div>
            </div>

            <!-- ========== SECTION SUIVI PAR VILLE ========== -->
            <h2 class="section-title">Suivi par ville <span style="font-size: 60%;">(Cliquez sur le nom de la ville pour voir les details)</span> </h2>
            
            <!-- Tableau avec scroll horizontal sur mobile -->
            <div class="table-responsive">
                <table class="dashboard-table">
                    <thead>
                        <tr>
                            <th>Ville</th>
                            <th>Nombre de sinistrés</th>
                            <th>Estimation Besoins (Ar)</th>
                            <th>Total de dons recus</th>
                            <th>Reste à couvrir (Ar)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        foreach ($villes as $ville) { 
                            $villeId = $ville['id'];
                            $villeSimu = $simulation['par_ville'][$villeId] ?? null;
                            $totalAttribue = $villeSimu ? $villeSimu['total_attribue'] : 0;
                            $estimation = $estimations[$ville['nom_ville']][0]['estimation_totale'] ?? 0;
                            $reste = $estimation - $totalAttribue;
                        ?>
                         <tr>
                            <td><a href="<?= BASE_URL ?>/besoins/<?= $villeId ?>"><?= htmlspecialchars($ville['nom_ville']) ?></a></td>
                            <td><?= number_format($ville['nombre_sinistre'], 0, ',', ' ') ?></td>
                            <td><?= number_format($estimation, 0, ',', ' ') ?></td>
                            <td><?= number_format($totalAttribue, 0, ',', ' ') ?></td>
                            <td><?= number_format($reste, 0, ',', ' ') ?></td>
                         </tr>   
                       <?php } 
                        ?>
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