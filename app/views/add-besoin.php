<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.5">
    <title>BNGRC · Ajouter un besoin</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/add-besoin.css">
</head>
<body>
    <!-- ========== LAYOUT PRINCIPAL AVEC MENU LATERAL ========== -->
    <?php $activePage = 'besoins'; ?>
    <div class="app-container">
        <!-- ========== MENU DE NAVIGATION GAUCHE ========== -->
        <?php include('partials/sidebar.php'); ?>

        <!-- ========== CONTENU PRINCIPAL ========== -->
        <main class="main-content">
            <!-- Header avec retour -->
            <header class="content-header">
                <div class="title-with-back">
                    <a href="besoins.html" class="back-link">
                        <svg class="back-icon" viewBox="0 0 24 24" width="20" height="20">
                            <path fill="currentColor" d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"/>
                        </svg>
                        Retour à la liste
                    </a>
                    <h1 class="page-title">Ajouter un besoin</h1>
                </div>
                <div class="header-actions">
                    <span class="date-indicator">Nouvelle requête</span>
                </div>
            </header>

            <!-- ========== CARD CENTRALE DU FORMULAIRE ========== -->
            <div class="form-card">
                <div class="form-card-header">
                    <div class="form-card-icon">
                        <svg viewBox="0 0 24 24" width="24" height="24">
                            <path fill="#137C8B" d="M20 8h-2.81c-.45-.78-1.07-1.45-1.82-1.96L17 4.41 15.59 3l-2.17 2.17C12.96 5.06 12.49 5 12 5s-.96.06-1.41.17L8.41 3 7 4.41l1.62 1.63C7.88 6.55 7.26 7.22 6.81 8H4v2h2.09c-.05.33-.09.66-.09 1v1H4v2h2v1c0 .34.04.67.09 1H4v2h2.81c1.04 1.79 2.97 3 5.19 3s4.15-1.21 5.19-3H20v-2h-2.09c.05-.33.09-.66.09-1v-1h2v-2h-2v-1c0-.34-.04-.67-.09-1H20V8z"/>
                        </svg>
                    </div>
                    <h2 class="form-card-title">Détails du besoin</h2>
                    <p class="form-card-subtitle">Remplissez les informations ci-dessous</p>
                </div>

                <form class="besoin-form">
                    <!-- Ville (select) -->
                    <div class="form-group">
                        <label for="ville" class="form-label">
                            Ville <span class="required">*</span>
                        </label>
                        <div class="select-wrapper">
                            <select id="ville" name="ville" class="form-select" required>
                                <option value="" disabled selected>Choisir une ville</option>
                                <option value="ambositra">Ambositra (AMB)</option>
                                <option value="morondava">Morondava (MDV)</option>
                                <option value="fort-dauphin">Fort-Dauphin (FTD)</option>
                                <option value="nosy-be">Nosy Be (NSB)</option>
                                <option value="antananarivo">Antananarivo (TNR)</option>
                                <option value="toamasina">Toamasina (TMA)</option>
                                <option value="fianarantsoa">Fianarantsoa (FIA)</option>
                                <option value="mahajanga">Mahajanga (MJN)</option>
                            </select>
                        </div>
                    </div>

                    <!-- Type (Nature / Matériau / Argent) -->
                    <div class="form-group">
                        <label for="type" class="form-label">
                            Type <span class="required">*</span>
                        </label>
                        <div class="radio-group">
                            <label class="radio-option">
                                <input type="radio" name="type" value="nature" checked>
                                <span class="radio-label radio-nature">Nature</span>
                            </label>
                            <label class="radio-option">
                                <input type="radio" name="type" value="materiau">
                                <span class="radio-label radio-materiau">Matériau</span>
                            </label>
                            <label class="radio-option">
                                <input type="radio" name="type" value="argent">
                                <span class="radio-label radio-argent">Argent</span>
                            </label>
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="form-group">
                        <label for="description" class="form-label">
                            Description <span class="required">*</span>
                        </label>
                        <input type="text" id="description" name="description" class="form-input" 
                               placeholder="ex: Riz blanc, sac de 50kg" required>
                        <span class="form-hint">Indiquez le produit et ses spécifications</span>
                    </div>

                    <!-- Prix unitaire et Quantité (côte à côte) -->
                    <div class="form-row">
                        <div class="form-group half">
                            <label for="prix" class="form-label">
                                Prix unitaire (Ar)
                            </label>
                            <input type="number" id="prix" name="prix" class="form-input" 
                                   placeholder="45000" min="0" step="100">
                            <span class="form-hint">En Ariary</span>
                        </div>

                        <div class="form-group half">
                            <label for="quantite" class="form-label">
                                Quantité
                            </label>
                            <input type="number" id="quantite" name="quantite" class="form-input" 
                                   placeholder="120" min="0">
                            <span class="form-hint">Nombre d'unités</span>
                        </div>
                    </div>

                    <!-- Date -->
                    <div class="form-group">
                        <label for="date" class="form-label">
                            Date du besoin <span class="required">*</span>
                        </label>
                        <input type="date" id="date" name="date" class="form-input" 
                               value="2026-02-16" required>
                    </div>

                    <!-- Note optionnelle -->
                    <div class="form-group">
                        <label for="notes" class="form-label">Notes additionnelles</label>
                        <textarea id="notes" name="notes" class="form-textarea" 
                                  rows="3" placeholder="Informations complémentaires..."></textarea>
                    </div>

                    <!-- Boutons d'action -->
                    <div class="form-actions">
                        <button type="button" class="btn btn-secondary" onclick="window.location.href='besoins.html'">Annuler</button>
                        <button type="submit" class="btn btn-primary">Ajouter le besoin</button>
                    </div>
                </form>
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