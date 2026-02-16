<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.5">
    <title>BNGRC · Ajouter un don</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/add-don.css">
</head>
<body>
    <?php $activePage = 'dons'; ?>
    <div class="app-container">

        <?php include('partials/sidebar.php'); ?>


        <main class="main-content">
            <header class="content-header">
                <div class="title-with-back">
                    <a href="<?= BASE_URL ?>/dons" class="back-link">
                        <svg class="back-icon" viewBox="0 0 24 24" width="20" height="20">
                            <path fill="currentColor" d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"/>
                        </svg>
                        Retour à la liste
                    </a>
                    <h1 class="page-title">Ajouter un don</h1>
                </div>
                <div class="header-actions">
                    <a href="<?= BASE_URL ?>/add-produit">
                        <button class="btn btn-secondary">
                            <svg class="btn-icon" viewBox="0 0 24 24" width="18" height="18">
                                <path fill="currentColor" d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/>
                            </svg>
                            Ajouter nouveau produit
                        </button>
                    </a>
                </div>
            </header>

            <div id="message-container" style="display: none;"></div>

            <div class="form-card">
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
                <form id="don-form" class="don-form">
                    <!-- Donateur / Organisation -->
                    <div class="form-group">
                        <label for="nom_donneur" class="form-label">
                            Donateur / Organisation <span class="required">*</span>
                        </label>
                        <input type="text" id="nom_donneur" name="nom_donneur" class="form-input" 
                               placeholder="ex: UNICEF, Croix-Rouge, Banque Mondiale..." required>
                        <span class="form-hint">Nom de l'organisation ou personne donatrice</span>
                    </div>

                    <!-- Produit -->
                    <div class="form-group">
                        <label for="id_produit" class="form-label">
                            Produit <span class="required">*</span>
                        </label>
                        <select id="id_produit" name="id_produit" class="form-input" required>
                            <option value="">-- Sélectionner un produit --</option>
                            <?php foreach ($produits as $produit): ?>
                                <option value="<?= $produit['id'] ?>" data-pu="<?= $produit['pu'] ?>" data-categorie="<?= htmlspecialchars($produit['nom_categorie']) ?>">
                                    <?= htmlspecialchars($produit['nom_produit']) ?> (<?= htmlspecialchars($produit['nom_categorie']) ?>) - <?= number_format($produit['pu'], 0, ',', ' ') ?> Ar
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <span class="form-hint">Sélectionnez le produit donné</span>
                    </div>

                    <!-- Quantité -->
                    <div class="form-group">
                        <label for="quantite_don" class="form-label">
                            Quantité <span class="required">*</span>
                        </label>
                        <div class="input-with-unit">
                            <input type="number" id="quantite_don" name="quantite_don" class="form-input" 
                                   placeholder="500" min="1" step="1" required>
                            <span class="input-unit">unités</span>
                        </div>
                        <span class="form-hint">Nombre d'unités</span>
                    </div>

                    <!-- Montant estimé (calculé automatiquement) -->
                    <div class="form-group">
                        <label class="form-label">
                            Montant estimé
                        </label>
                        <div class="input-with-unit">
                            <input type="text" id="montant_estime" class="form-input" 
                                   placeholder="0" readonly style="background-color: #f5f5f5;">
                            <span class="input-unit">Ar</span>
                        </div>
                        <span class="form-hint">Calculé automatiquement : Quantité × Prix unitaire</span>
                    </div>

                    <!-- Date -->
                    <div class="form-group">
                        <label for="date_don" class="form-label">
                            Date de réception <span class="required">*</span>
                        </label>
                        <input type="date" id="date_don" name="date_don" class="form-input" 
                               value="<?= date('Y-m-d') ?>" required>
                    </div>

                    <!-- Boutons d'action -->
                    <div class="form-actions">
                        <button type="button" class="btn btn-secondary" onclick="window.location.href='<?= BASE_URL ?>/dons'">Annuler</button>
                        <button type="submit" class="btn btn-primary">Ajouter ce don</button>
                    </div>
                </form>
            </div>

            <!-- footer-->
            <footer class="footer">
                <p>© 2026 BNGRC - Système de gestion des dons</p>
                <p>ETU004031 - ETU004183 - ETU004273</p>
            </footer>
        </main>
    </div>

    <!-- Script pour la gestion du formulaire -->
    <script>
        (function() {
            const form = document.getElementById('don-form');
            const messageContainer = document.getElementById('message-container');
            const produitSelect = document.getElementById('id_produit');
            const quantiteInput = document.getElementById('quantite_don');
            const montantEstime = document.getElementById('montant_estime');

            // Calculer le montant estimé quand le produit ou la quantité change
            function calculateMontant() {
                const selectedOption = produitSelect.options[produitSelect.selectedIndex];
                if (selectedOption && selectedOption.value) {
                    const pu = parseFloat(selectedOption.getAttribute('data-pu')) || 0;
                    const quantite = parseInt(quantiteInput.value) || 0;
                    const montant = pu * quantite;
                    montantEstime.value = montant > 0 ? formatNumber(montant) : '0';
                } else {
                    montantEstime.value = '0';
                }
            }

            produitSelect.addEventListener('change', calculateMontant);
            quantiteInput.addEventListener('input', calculateMontant);

            // Soumission du formulaire
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
                fetch('<?= BASE_URL ?>/add-don', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Afficher message de succès
                        showMessage('Don ajouté avec succès !', 'success');
                        
                        // Réinitialiser le formulaire
                        form.reset();
                        montantEstime.value = '0';
                        
                        // Rediriger vers la liste des dons après 1.5 secondes
                        setTimeout(() => {
                            window.location.href = '<?= BASE_URL ?>/dons';
                        }, 1500);
                    } else {
                        showMessage(data.message || 'Erreur lors de l\'ajout du don', 'error');
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
                window.scrollTo(0, 0);
                
                // Masquer le message après 5 secondes
                setTimeout(() => {
                    messageContainer.style.display = 'none';
                }, 5000);
            }

            function formatNumber(num) {
                return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ' ');
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