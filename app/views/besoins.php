<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.5">
    <title>BNGRC · Liste des besoins</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/besoins.css">
</head>
<body>
    <!-- ========== LAYOUT PRINCIPAL AVEC MENU LATERAL ========== -->
    <?php $activePage = 'besoins'; ?>
    <div class="app-container">
        <!-- ========== MENU DE NAVIGATION GAUCHE ========== -->
        <?php include('partials/sidebar.php'); ?>

        <!-- ========== CONTENU PRINCIPAL ========== -->
        <main class="main-content">
            <!-- Header avec titre et bouton d'ajout -->
            <header class="content-header">
                <div class="title-section">
                    <h1 class="page-title">Liste des besoins</h1>
                    <p class="page-subtitle">Gestion des ressources nécessaires par ville</p>
                </div>
                <button class="btn btn-primary">
                    <svg class="btn-icon" viewBox="0 0 24 24" width="18" height="18">
                        <path fill="currentColor" d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/>
                    </svg>
                    Ajouter un besoin
                </button>
            </header>

            <!-- ========== FILTRES RAPIDES (optionnels, pour l'ambiance) ========== -->
            <div class="filters-bar">
                <div class="filter-tabs">
                    <span class="filter-tab active">Tous les besoins</span>
                    <span class="filter-tab">Nature</span>
                    <span class="filter-tab">Matériau</span>
                    <span class="filter-tab">Argent</span>
                </div>
                <div class="filter-stats">
                    <span class="stat-badge">24 besoins actifs</span>
                </div>
            </div>

            <!-- ========== TABLEAU DES BESOINS ========== -->
            <div class="table-container">
                <table class="besoins-table">
                    <thead>
                        <tr>
                            <th>Ville</th>
                            <th>Type</th>
                            <th>Produit</th>
                            <th>Prix unitaire (Ar)</th>
                            <th>Quantité</th>
                            <th>Valeur totale (Ar)</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Besoin 1 : Riz - Nature -->
                        <?php
                        if (isset($besoins)) {
                             foreach ($besoins as $besoin) { ?>
                            <tr>
                            <td>
                                <div class="ville-cell">
                                    <span class="ville-nom"><?= $besoin['nom_ville'] ?></span>
                                    <span class="ville-code">101</span>
                                </div>
                            </td>
                            <td>
                                <span class="badge badge-<?= $besoin['nom_categorie'] ?>"><?= $besoin['nom_categorie'] ?></span>
                            </td>
                            <td>
                                <div class="description-cell">
                                    <span class="description-titre"><?= $besoin['nom_produit'] ?></span>
                                    <span class="description-detail">Bruh</span>
                                </div>
                            </td>
                            <td class="prix-cell"><?= number_format($besoin['pu'], 0, ',', ' ') ?></td>
                            <td class="quantite-cell"><?= $besoin['quantite_besoin'] ?></td>
                            <td class="total-cell"><?= number_format($besoin['pu'] * $besoin['quantite_besoin'], 0, ',', ' ') ?></td>
                            <td class="date-cell"><?= $besoin['date_besoin'] ?></td>
                        </tr>
                       <?php }
                        }
                        ?>
                    </tbody>
                </table>
            </div>

            <!-- ========== PIED DE TABLEAU ========== -->
            <div class="table-footer">
                <div class="footer-info">
                    <span class="info-badge">
                        <span class="dot"></span>
                        8 besoins affichés
                    </span>
                    <span class="info-badge">
                        <span class="dot dot-nature"></span>
                        Nature: 4
                    </span>
                    <span class="info-badge">
                        <span class="dot dot-materiau"></span>
                        Matériau: 3
                    </span>
                    <span class="info-badge">
                        <span class="dot dot-argent"></span>
                        Argent: 1
                    </span>
                </div>
                <div class="footer-total">
                    Valeur totale: <strong>37 822 500 Ar</strong>
                </div>
            </div>

            <!-- ========== FOOTER ========== -->
            <footer class="footer">
                <p>© 2026 BNGRC - Système de gestion des dons</p>
                <p>ETU004035 - ETU004273 - ETU004183</p>
            </footer>
        </main>
    </div>
</body>
</html>