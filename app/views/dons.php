<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.5">
    <title>BNGRC · Liste des dons</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/dons.css">
</head>
<body>
    <!-- ========== LAYOUT PRINCIPAL AVEC MENU LATERAL ========== -->
    <?php $activePage = 'dons'; ?>
    <div class="app-container">
        <!-- ========== MENU DE NAVIGATION GAUCHE ========== -->
        <?php include('partials/sidebar.php'); ?>

        <!-- ========== CONTENU PRINCIPAL ========== -->
        <main class="main-content">
            <!-- Header avec titre et bouton d'ajout -->
            <header class="content-header">
                <div class="title-section">
                    <h1 class="page-title">Liste des dons</h1>
                    <p class="page-subtitle">Gestion des contributions et ressources disponibles</p>
                </div>
                <a href="add-don">
                    <button class="btn btn-primary">
                    <svg class="btn-icon" viewBox="0 0 24 24" width="18" height="18">
                        <path fill="currentColor" d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/>
                    </svg>
                    Ajouter un don
                </button>
                </a>
            </header>

            <!-- ========== STATISTIQUES RAPIDES ========== -->
            <div class="stats-mini">
                <div class="stat-mini-item">
                    <span class="stat-mini-label">Total dons</span>
                    <span class="stat-mini-value">5</span>
                </div>
                <div class="stat-mini-item">
                    <span class="stat-mini-label">Montant total</span>
                    <span class="stat-mini-value">23,5 M Ar</span>
                </div>
                <div class="stat-mini-item">
                    <span class="stat-mini-label">Disponible</span>
                    <span class="stat-mini-value highlight">8,2 M Ar</span>
                </div>
            </div>

            <!-- ========== TABLEAU DES DONS ========== -->
            <div class="table-container">
                <table class="dons-table">
                    <thead>
                        <tr>
                            <th>Type</th>
                            <th>Description</th>
                            <th>Quantité / Montant</th>
                            <th>Date</th>
                            <th>Reste disponible</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Don 1 : Riz (nature) -->
                        <tr>
                            <td>
                                <span class="badge badge-nature">Nature</span>
                            </td>
                            <td>
                                <div class="description-cell">
                                    <span class="description-titre">Riz blanc</span>
                                    <span class="description-detail">Sac de 50kg · Grade A · Donateur: UNICEF</span>
                                </div>
                            </td>
                            <td>
                                <span class="quantite">500 sacs</span>
                                <span class="montant-secondaire">(22 500 000 Ar)</span>
                            </td>
                            <td class="date-cell">15/02/2026</td>
                            <td>
                                <div class="reste-cell">
                                    <span class="reste-badge reste-positif">120 sacs</span>
                                    <span class="reste-detail">5 400 000 Ar</span>
                                </div>
                            </td>
                        </tr>
                        <!-- Don 2 : Tôles (matériau) -->
                        <tr>
                            <td>
                                <span class="badge badge-materiau">Matériau</span>
                            </td>
                            <td>
                                <div class="description-cell">
                                    <span class="description-titre">Tôles ondulées</span>
                                    <span class="description-detail">2m x 1m · Galvanisées · Donateur: Croix-Rouge</span>
                                </div>
                            </td>
                            <td>
                                <span class="quantite">300 unités</span>
                                <span class="montant-secondaire">(8 400 000 Ar)</span>
                            </td>
                            <td class="date-cell">12/02/2026</td>
                            <td>
                                <div class="reste-cell">
                                    <span class="reste-badge reste-positif">85 unités</span>
                                    <span class="reste-detail">2 380 000 Ar</span>
                                </div>
                            </td>
                        </tr>
                        <!-- Don 3 : Argent -->
                        <tr>
                            <td>
                                <span class="badge badge-argent">Argent</span>
                            </td>
                            <td>
                                <div class="description-cell">
                                    <span class="description-titre">Fonds d'urgence</span>
                                    <span class="description-detail">Contribution financière · Donateur: Banque Mondiale</span>
                                </div>
                            </td>
                            <td>
                                <span class="montant">15 000 000 Ar</span>
                            </td>
                            <td class="date-cell">10/02/2026</td>
                            <td>
                                <div class="reste-cell">
                                    <span class="reste-badge reste-positif">3 750 000 Ar</span>
                                </div>
                            </td>
                        </tr>
                        <!-- Don 4 : Kits médicaux (nature) -->
                        <tr>
                            <td>
                                <span class="badge badge-nature">Nature</span>
                            </td>
                            <td>
                                <div class="description-cell">
                                    <span class="description-titre">Kits médicaux</span>
                                    <span class="description-detail">Antibiotiques + antipaludiques · Donateur: OMS</span>
                                </div>
                            </td>
                            <td>
                                <span class="quantite">50 kits</span>
                                <span class="montant-secondaire">(6 250 000 Ar)</span>
                            </td>
                            <td class="date-cell">08/02/2026</td>
                            <td>
                                <div class="reste-cell">
                                    <span class="reste-badge reste-positif">12 kits</span>
                                    <span class="reste-detail">1 500 000 Ar</span>
                                </div>
                            </td>
                        </tr>
                        <!-- Don 5 : Eau (nature) - reste épuisé -->
                        <tr>
                            <td>
                                <span class="badge badge-nature">Nature</span>
                            </td>
                            <td>
                                <div class="description-cell">
                                    <span class="description-titre">Eau potable</span>
                                    <span class="description-detail">Bouteille 1.5L · Pack de 6 · Donateur: Entreprises solidaires</span>
                                </div>
                            </td>
                            <td>
                                <span class="quantite">1 000 packs</span>
                                <span class="montant-secondaire">(4 800 000 Ar)</span>
                            </td>
                            <td class="date-cell">05/02/2026</td>
                            <td>
                                <div class="reste-cell">
                                    <span class="reste-badge reste-epuise">Épuisé</span>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- ========== LÉGENDE ET RÉCAPITULATIF ========== -->
            <div class="table-footer">
                <div class="footer-info">
                    <span class="info-badge">
                        <span class="dot"></span>
                        5 dons enregistrés
                    </span>
                    <span class="info-badge">
                        <span class="dot dot-nature"></span>
                        Nature: 3
                    </span>
                    <span class="info-badge">
                        <span class="dot dot-materiau"></span>
                        Matériau: 1
                    </span>
                    <span class="info-badge">
                        <span class="dot dot-argent"></span>
                        Argent: 1
                    </span>
                </div>
                <div class="footer-total">
                    <span class="reste-indicator">
                        <span class="indicator-vert"></span>
                        Reste disponible
                    </span>
                </div>
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