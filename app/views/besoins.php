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
                            <th>Description</th>
                            <th>Prix unitaire (Ar)</th>
                            <th>Quantité</th>
                            <th>Valeur totale (Ar)</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Besoin 1 : Riz - Nature -->
                        <tr>
                            <td>
                                <div class="ville-cell">
                                    <span class="ville-nom">Ambositra</span>
                                    <span class="ville-code">AMB</span>
                                </div>
                            </td>
                            <td>
                                <span class="badge badge-nature">Nature</span>
                            </td>
                            <td>
                                <div class="description-cell">
                                    <span class="description-titre">Riz blanc</span>
                                    <span class="description-detail">Sac de 50kg · Grade A</span>
                                </div>
                            </td>
                            <td class="prix-cell">45 000</td>
                            <td class="quantite-cell">120</td>
                            <td class="total-cell">5 400 000</td>
                            <td class="date-cell">15/02/2026</td>
                        </tr>
                        <!-- Besoin 2 : Huile - Nature -->
                        <tr>
                            <td>
                                <div class="ville-cell">
                                    <span class="ville-nom">Morondava</span>
                                    <span class="ville-code">MDV</span>
                                </div>
                            </td>
                            <td>
                                <span class="badge badge-nature">Nature</span>
                            </td>
                            <td>
                                <div class="description-cell">
                                    <span class="description-titre">Huile végétale</span>
                                    <span class="description-detail">Bidon de 5L · Premium</span>
                                </div>
                            </td>
                            <td class="prix-cell">32 500</td>
                            <td class="quantite-cell">85</td>
                            <td class="total-cell">2 762 500</td>
                            <td class="date-cell">14/02/2026</td>
                        </tr>
                        <!-- Besoin 3 : Tôles - Matériau -->
                        <tr>
                            <td>
                                <div class="ville-cell">
                                    <span class="ville-nom">Fort-Dauphin</span>
                                    <span class="ville-code">FTD</span>
                                </div>
                            </td>
                            <td>
                                <span class="badge badge-materiau">Matériau</span>
                            </td>
                            <td>
                                <div class="description-cell">
                                    <span class="description-titre">Tôles ondulées</span>
                                    <span class="description-detail">2m x 1m · Galvanisées</span>
                                </div>
                            </td>
                            <td class="prix-cell">28 000</td>
                            <td class="quantite-cell">200</td>
                            <td class="total-cell">5 600 000</td>
                            <td class="date-cell">12/02/2026</td>
                        </tr>
                        <!-- Besoin 4 : Clous - Matériau -->
                        <tr>
                            <td>
                                <div class="ville-cell">
                                    <span class="ville-nom">Nosy Be</span>
                                    <span class="ville-code">NSB</span>
                                </div>
                            </td>
                            <td>
                                <span class="badge badge-materiau">Matériau</span>
                            </td>
                            <td>
                                <div class="description-cell">
                                    <span class="description-titre">Clous de charpente</span>
                                    <span class="description-detail">Boîte de 1kg · 100mm</span>
                                </div>
                            </td>
                            <td class="prix-cell">6 500</td>
                            <td class="quantite-cell">150</td>
                            <td class="total-cell">975 000</td>
                            <td class="date-cell">10/02/2026</td>
                        </tr>
                        <!-- Besoin 5 : Argent - Argent -->
                        <tr>
                            <td>
                                <div class="ville-cell">
                                    <span class="ville-nom">Antananarivo</span>
                                    <span class="ville-code">TNR</span>
                                </div>
                            </td>
                            <td>
                                <span class="badge badge-argent">Argent</span>
                            </td>
                            <td>
                                <div class="description-cell">
                                    <span class="description-titre">Fonds d'urgence</span>
                                    <span class="description-detail">Aide directe aux sinistrés</span>
                                </div>
                            </td>
                            <td class="prix-cell">-</td>
                            <td class="quantite-cell">-</td>
                            <td class="total-cell">15 000 000</td>
                            <td class="date-cell">08/02/2026</td>
                        </tr>
                        <!-- Besoin 6 : Eau - Nature -->
                        <tr>
                            <td>
                                <div class="ville-cell">
                                    <span class="ville-nom">Toamasina</span>
                                    <span class="ville-code">TMA</span>
                                </div>
                            </td>
                            <td>
                                <span class="badge badge-nature">Nature</span>
                            </td>
                            <td>
                                <div class="description-cell">
                                    <span class="description-titre">Eau potable</span>
                                    <span class="description-detail">Bouteille 1.5L · Pack de 6</span>
                                </div>
                            </td>
                            <td class="prix-cell">4 800</td>
                            <td class="quantite-cell">500</td>
                            <td class="total-cell">2 400 000</td>
                            <td class="date-cell">05/02/2026</td>
                        </tr>
                        <!-- Besoin 7 : Ciment - Matériau -->
                        <tr>
                            <td>
                                <div class="ville-cell">
                                    <span class="ville-nom">Fianarantsoa</span>
                                    <span class="ville-code">FIA</span>
                                </div>
                            </td>
                            <td>
                                <span class="badge badge-materiau">Matériau</span>
                            </td>
                            <td>
                                <div class="description-cell">
                                    <span class="description-titre">Ciment</span>
                                    <span class="description-detail">Sac de 50kg · Portland</span>
                                </div>
                            </td>
                            <td class="prix-cell">32 000</td>
                            <td class="quantite-cell">80</td>
                            <td class="total-cell">2 560 000</td>
                            <td class="date-cell">03/02/2026</td>
                        </tr>
                        <!-- Besoin 8 : Médicaments - Nature -->
                        <tr>
                            <td>
                                <div class="ville-cell">
                                    <span class="ville-nom">Mahajanga</span>
                                    <span class="ville-code">MJN</span>
                                </div>
                            </td>
                            <td>
                                <span class="badge badge-nature">Nature</span>
                            </td>
                            <td>
                                <div class="description-cell">
                                    <span class="description-titre">Kits médicaux</span>
                                    <span class="description-detail">Antibiotiques + antipaludiques</span>
                                </div>
                            </td>
                            <td class="prix-cell">125 000</td>
                            <td class="quantite-cell">25</td>
                            <td class="total-cell">3 125 000</td>
                            <td class="date-cell">01/02/2026</td>
                        </tr>
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