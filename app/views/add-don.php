<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.5">
    <title>BNGRC · Ajouter un don</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/add-don.css">
</head>
<body>
    <!-- ========== LAYOUT PRINCIPAL AVEC MENU LATERAL ========== -->
    <?php $activePage = 'dons'; ?>
    <div class="app-container">
        <!-- ========== MENU DE NAVIGATION GAUCHE ========== -->
        <?php include('partials/sidebar.php'); ?>

        <!-- ========== CONTENU PRINCIPAL ========== -->
        <main class="main-content">
            <!-- Header avec retour -->
            <header class="content-header">
                <div class="title-with-back">
                    <a href="dons" class="back-link">
                        <svg class="back-icon" viewBox="0 0 24 24" width="20" height="20">
                            <path fill="currentColor" d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"/>
                        </svg>
                        Retour à la liste
                    </a>
                    <h1 class="page-title">Ajouter un don</h1>
                </div>
                <div class="header-actions">
                    <span class="date-indicator">Nouvelle contribution</span>
                </div>
            </header>

            <!-- ========== CARD CENTRALE DU FORMULAIRE ========== -->
            <div class="form-card">
                <!-- En-tête décorative de la card -->
                <div class="form-card-header">
                    <div class="form-card-icon">
                        <svg viewBox="0 0 24 24" width="28" height="28">
                            <path fill="#137C8B" d="M20 6h-2v2h-2V6h-2V4h2V2h2v2h2v2zm-10 2H8V6h2v2zm0 8H6v-4h4v4zm2 0v-4h4v4h-4zm-6 4v-2h2v2H6zm8 0v-2h2v2h-2zm-6-8H4V8h4v4zM2 20V4h12v2h-2v2h2v2h-2v2h2v2h-2v2h2v2H2z"/>
                        </svg>
                    </div>
                    <h2 class="form-card-title">Enregistrer un don</h2>
                    <p class="form-card-subtitle">Saisissez les informations du don reçu</p>
                </div>

                <!-- Formulaire -->
                <form class="don-form">
                    <!-- Type (Nature / Matériau / Argent) -->
                    <div class="form-group">
                        <label class="form-label">
                            Type de don <span class="required">*</span>
                        </label>
                        <div class="radio-group">
                            <label class="radio-option">
                                <input type="radio" name="type" value="nature" checked>
                                <span class="radio-label radio-nature">
                                    <span class="radio-emoji">🌾</span> Nature
                                </span>
                            </label>
                            <label class="radio-option">
                                <input type="radio" name="type" value="materiau">
                                <span class="radio-label radio-materiau">
                                    <span class="radio-emoji">🔨</span> Matériau
                                </span>
                            </label>
                            <label class="radio-option">
                                <input type="radio" name="type" value="argent">
                                <span class="radio-label radio-argent">
                                    <span class="radio-emoji">💰</span> Argent
                                </span>
                            </label>
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="form-group">
                        <label for="description" class="form-label">
                            Description détaillée <span class="required">*</span>
                        </label>
                        <input type="text" id="description" name="description" class="form-input" 
                               placeholder="ex: Riz blanc, sacs de 50kg - Donateur: UNICEF" required>
                        <span class="form-hint">Indiquez le produit, les spécifications et le donateur</span>
                    </div>

                    <!-- Type de quantité (adaptatif) -->
                    <div class="form-group" id="quantite-group">
                        <label for="quantite" class="form-label">
                            Quantité <span class="required">*</span>
                        </label>
                        <div class="input-with-unit">
                            <input type="number" id="quantite" name="quantite" class="form-input" 
                                   placeholder="500" min="0" step="1" required>
                            <span class="input-unit" id="quantite-unit">sacs</span>
                        </div>
                        <span class="form-hint" id="quantite-hint">Nombre d'unités</span>
                    </div>

                    <!-- Montant (caché par défaut, apparaît si type Argent) -->
                    <div class="form-group" id="montant-group" style="display: none;">
                        <label for="montant" class="form-label">
                            Montant (Ariary) <span class="required">*</span>
                        </label>
                        <div class="input-with-unit">
                            <input type="number" id="montant" name="montant" class="form-input" 
                                   placeholder="15 000 000" min="0" step="1000">
                            <span class="input-unit">Ar</span>
                        </div>
                        <span class="form-hint">En Ariary malgache</span>
                    </div>

                    <!-- Date -->
                    <div class="form-group">
                        <label for="date" class="form-label">
                            Date de réception <span class="required">*</span>
                        </label>
                        <input type="date" id="date" name="date" class="form-input" 
                               value="2026-02-16" required>
                    </div>

                    <!-- Donateur (optionnel) -->
                    <div class="form-group">
                        <label for="donateur" class="form-label">Donateur / Organisation</label>
                        <input type="text" id="donateur" name="donateur" class="form-input" 
                               placeholder="ex: UNICEF, Croix-Rouge, Banque Mondiale...">
                        <span class="form-hint">Optionnel - Nom de l'organisation donatrice</span>
                    </div>

                    <!-- Notes (optionnel) -->
                    <div class="form-group">
                        <label for="notes" class="form-label">Notes additionnelles</label>
                        <textarea id="notes" name="notes" class="form-textarea" 
                                  rows="3" placeholder="Informations complémentaires, conditions particulières..."></textarea>
                    </div>

                    <!-- Boutons d'action -->
                    <div class="form-actions">
                        <button type="button" class="btn btn-secondary" onclick="window.location.href='dons.html'">Annuler</button>
                        <button type="submit" class="btn btn-primary">Ajouter ce don</button>
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

    <!-- Petit script pour l'interactivité des champs (optionnel, mais amélioration UX) -->
    <script>
        (function() {
            // Gestion de l'affichage Quantité / Montant selon le type sélectionné
            const radios = document.querySelectorAll('input[name="type"]');
            const quantiteGroup = document.getElementById('quantite-group');
            const montantGroup = document.getElementById('montant-group');
            const quantiteUnit = document.getElementById('quantite-unit');
            const quantiteHint = document.getElementById('quantite-hint');
            const quantiteInput = document.getElementById('quantite');
            const montantInput = document.getElementById('montant');

            function updateFields() {
                const selectedType = document.querySelector('input[name="type"]:checked').value;
                
                if (selectedType === 'argent') {
                    quantiteGroup.style.display = 'none';
                    montantGroup.style.display = 'block';
                    quantiteInput.removeAttribute('required');
                    montantInput.setAttribute('required', 'required');
                } else {
                    quantiteGroup.style.display = 'block';
                    montantGroup.style.display = 'none';
                    montantInput.removeAttribute('required');
                    quantiteInput.setAttribute('required', 'required');
                    
                    // Adapter le libellé selon le type
                    if (selectedType === 'nature') {
                        quantiteUnit.textContent = 'unités';
                        quantiteHint.textContent = 'Nombre d\'unités (sacs, kits, bouteilles...)';
                    } else if (selectedType === 'materiau') {
                        quantiteUnit.textContent = 'unités';
                        quantiteHint.textContent = 'Nombre d\'unités (tôles, sacs de ciment, boîtes...)';
                    }
                }
            }

            radios.forEach(radio => {
                radio.addEventListener('change', updateFields);
            });

            // Initialisation
            updateFields();
        })();
    </script>
</body>
</html>