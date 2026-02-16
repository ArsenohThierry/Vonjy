<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.5">
    <title>BNGRC · Ajouter un produit</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/add-don.css">
</head>
<body>
    <!-- ========== LAYOUT PRINCIPAL AVEC MENU LATERAL ========== -->
    <?php $activePage = 'produits'; ?>
    <div class="app-container">
        <!-- ========== MENU DE NAVIGATION GAUCHE ========== -->
        <?php include('partials/sidebar.php'); ?>

        <!-- ========== CONTENU PRINCIPAL ========== -->
        <main class="main-content">
            <!-- Header avec retour -->
            <header class="content-header">
                <div class="title-with-back">
                    <a href="<?= BASE_URL ?>/add-don" class="back-link">
                        <svg class="back-icon" viewBox="0 0 24 24" width="20" height="20">
                            <path fill="currentColor" d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"/>
                        </svg>
                        Retour au formulaire don
                    </a>
                    <h1 class="page-title">Ajouter un produit</h1>
                </div>
                <div class="header-actions">
                    <a href="<?= BASE_URL ?>/categorie">
                        <button class="btn btn-secondary">
                            <svg class="btn-icon" viewBox="0 0 24 24" width="18" height="18">
                                <path fill="currentColor" d="M12 2l-5.5 9h11L12 2zm0 3.84L13.93 9h-3.87L12 5.84zM17.5 13c-2.49 0-4.5 2.01-4.5 4.5s2.01 4.5 4.5 4.5 4.5-2.01 4.5-4.5-2.01-4.5-4.5-4.5zm0 7c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5zM3 21.5h8v-8H3v8zm2-6h4v4H5v-4z"/>
                            </svg>
                            Ajouter catégorie
                        </button>
                    </a>
                </div>
            </header>

            <!-- ========== MESSAGE DE RETOUR ========== -->
            <div id="message-container" style="display: none;"></div>

            <!-- ========== CARD CENTRALE DU FORMULAIRE ========== -->
            <div class="form-card">
                <!-- En-tête décorative de la card -->
                <div class="form-card-header">
                    <div class="form-card-icon">
                        <svg viewBox="0 0 24 24" width="28" height="28">
                            <path fill="#137C8B" d="M20 6h-4V4c0-1.11-.89-2-2-2h-4c-1.11 0-2 .89-2 2v2H4c-1.11 0-1.99.89-1.99 2L2 19c0 1.11.89 2 2 2h16c1.11 0 2-.89 2-2V8c0-1.11-.89-2-2-2zm-6 0h-4V4h4v2z"/>
                        </svg>
                    </div>
                    <h2 class="form-card-title">Nouveau produit</h2>
                    <p class="form-card-subtitle">Enregistrer un produit dans le système</p>
                </div>

                <!-- Formulaire -->
                <form id="produit-form" class="don-form">
                    <!-- Nom du produit -->
                    <div class="form-group">
                        <label for="nom_produit" class="form-label">
                            Nom du produit <span class="required">*</span>
                        </label>
                        <input type="text" id="nom_produit" name="nom_produit" class="form-input" 
                               placeholder="ex: Riz blanc, Tôle ondulée, Kit médical..." required>
                        <span class="form-hint">Nom descriptif du produit</span>
                    </div>

                    <!-- Prix unitaire -->
                    <div class="form-group">
                        <label for="pu" class="form-label">
                            Prix unitaire <span class="required">*</span>
                        </label>
                        <div class="input-with-unit">
                            <input type="number" id="pu" name="pu" class="form-input" 
                                   placeholder="45000" min="0" step="0.01" required>
                            <span class="input-unit">Ar</span>
                        </div>
                        <span class="form-hint">Prix unitaire en Ariary</span>
                    </div>

                    <!-- Catégorie -->
                    <div class="form-group">
                        <label for="id_categorie" class="form-label">
                            Catégorie <span class="required">*</span>
                        </label>
                        <select id="id_categorie" name="id_categorie" class="form-input" required>
                            <option value="">-- Sélectionner une catégorie --</option>
                            <?php foreach ($categories as $categorie): ?>
                                <option value="<?= $categorie['id'] ?>">
                                    <?= htmlspecialchars($categorie['nom_categorie']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <span class="form-hint">Type de produit (Nature, Matériau, Argent...)</span>
                    </div>

                    <!-- Boutons d'action -->
                    <div class="form-actions">
                        <button type="button" class="btn btn-secondary" onclick="window.location.href='<?= BASE_URL ?>/add-don'">Annuler</button>
                        <button type="submit" class="btn btn-primary">Ajouter le produit</button>
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

    <!-- Script pour la soumission du formulaire -->
    <script>
        (function() {
            const form = document.getElementById('produit-form');
            const messageContainer = document.getElementById('message-container');

            form.addEventListener('submit', function(e) {
                e.preventDefault();

                // Récupérer les données du formulaire
                const formData = new FormData(form);

                // Désactiver le bouton de soumission
                const submitBtn = form.querySelector('button[type="submit"]');
                const originalText = submitBtn.textContent;
                submitBtn.disabled = true;
                submitBtn.textContent = 'Ajout en cours...';

                // Envoyer la requête AJAX
                fetch('<?= BASE_URL ?>/add-produit', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Afficher message de succès
                        showMessage('Produit ajouté avec succès !', 'success');
                        
                        // Réinitialiser le formulaire
                        form.reset();
                        
                        // Rediriger vers la page d'ajout de don après 1.5 secondes
                        setTimeout(() => {
                            window.location.href = '<?= BASE_URL ?>/add-don';
                        }, 1500);
                    } else {
                        showMessage(data.message || 'Erreur lors de l\'ajout du produit', 'error');
                        submitBtn.disabled = false;
                        submitBtn.textContent = originalText;
                    }
                })
                .catch(error => {
                    console.error('Erreur:', error);
                    showMessage('Une erreur s\'est produite. Veuillez réessayer.', 'error');
                    submitBtn.disabled = false;
                    submitBtn.textContent = originalText;
                });
            });

            function showMessage(message, type) {
                messageContainer.innerHTML = `
                    <div class="alert alert-${type}">
                        ${message}
                    </div>
                `;
                messageContainer.style.display = 'block';
                
                // Masquer le message après 5 secondes
                setTimeout(() => {
                    messageContainer.style.display = 'none';
                }, 5000);
            }
        })();
    </script>

    <style>
        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 8px;
            font-weight: 500;
        }
        .alert-success {
            background-color: #d4edda;
            border: 1px solid #c3e6cb;
            color: #155724;
        }
        .alert-error {
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
            color: #721c24;
        }
    </style>
</body>
</html>
