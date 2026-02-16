<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.5">
    <title>BNGRC · Gestion des catégories</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/categorie.css">
</head>
<body>
    <!-- ========== LAYOUT PRINCIPAL AVEC MENU LATERAL ========== -->
    <?php $activePage = 'categories'; ?>
    <div class="app-container">
        <!-- ========== MENU DE NAVIGATION GAUCHE ========== -->
        <?php include('partials/sidebar.php'); ?>

        <!-- ========== CONTENU PRINCIPAL ========== -->
        <main class="main-content">
            <!-- Header avec retour -->
            <header class="content-header">
                <div class="title-with-back">
                    <a href="<?= BASE_URL ?>/add-produit" class="back-link">
                        <svg class="back-icon" viewBox="0 0 24 24" width="20" height="20">
                            <path fill="currentColor" d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"/>
                        </svg>
                        Retour aux produits
                    </a>
                    <h1 class="page-title">Gestion des catégories</h1>
                </div>
            </header>

            <!-- ========== MESSAGE DE RETOUR ========== -->
            <div id="message-container" style="display: none;"></div>

            <!-- ========== FORMULAIRE D'AJOUT RAPIDE ========== -->
            <div class="form-card">
                <div class="form-card-header">
                    <div class="form-card-icon">
                        <svg viewBox="0 0 24 24" width="28" height="28">
                            <path fill="#137C8B" d="M12 2l-5.5 9h11L12 2zm0 3.84L13.93 9h-3.87L12 5.84zM17.5 13c-2.49 0-4.5 2.01-4.5 4.5s2.01 4.5 4.5 4.5 4.5-2.01 4.5-4.5-2.01-4.5-4.5-4.5zm0 7c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5zM3 21.5h8v-8H3v8zm2-6h4v4H5v-4z"/>
                        </svg>
                    </div>
                    <h2 class="form-card-title">Ajouter une catégorie</h2>
                    <p class="form-card-subtitle">Créer une nouvelle catégorie de produits</p>
                </div>

                <form id="categorie-form" class="don-form">
                    <div class="form-group">
                        <label for="nom_categorie" class="form-label">
                            Nom de la catégorie <span class="required">*</span>
                        </label>
                        <div style="display: flex; gap: 10px;">
                            <input type="text" id="nom_categorie" name="nom_categorie" class="form-input" 
                                   placeholder="ex: Nature, Matériau, Argent..." required style="flex: 1;">
                            <button type="submit" class="btn btn-primary">
                                <svg class="btn-icon" viewBox="0 0 24 24" width="18" height="18">
                                    <path fill="currentColor" d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/>
                                </svg>
                                Ajouter
                            </button>
                        </div>
                        <span class="form-hint">La catégorie sera ajoutée instantanément</span>
                    </div>
                </form>
            </div>

            <!-- ========== LISTE DES CATEGORIES ========== -->
            <div class="table-container">
                <h2 class="section-title">Catégories existantes</h2>
                
                <table class="dons-table">
                    <thead>
                        <tr>
                            <th style="width: 100px;">ID</th>
                            <th>Nom de la catégorie</th>
                            <th style="width: 150px; text-align: center;">Supprimer</th>
                        </tr>
                    </thead>
                    <tbody id="categories-list">
                        <?php if (empty($categories)): ?>
                            <tr id="no-data-row">
                                <td colspan="3" style="text-align: center; padding: 40px; color: #999;">
                                    Aucune catégorie enregistrée
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($categories as $categorie): ?>
                                <tr data-id="<?= $categorie['id'] ?>">
                                    <td><?= $categorie['id'] ?></td>
                                    <td>
                                        <span class="badge" style="background: #e3f2fd; color: #1976d2; font-weight: 500;">
                                            <?= htmlspecialchars($categorie['nom_categorie']) ?>
                                        </span>
                                    </td>
                                    <td style="text-align: center;">
                                        <button class="action-btn delete-btn" onclick="deleteCategorie(<?= $categorie['id'] ?>, '<?= htmlspecialchars($categorie['nom_categorie'], ENT_QUOTES) ?>')">
                                            <svg class="icon" viewBox="0 0 24 24" width="16" height="16">
                                                <path fill="currentColor" d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"/>
                                            </svg>
                                            Supprimer
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
                
                <!-- Info footer -->
                <div class="table-footer">
                    <div class="footer-info">
                        <span class="info-badge">
                            <span class="dot"></span>
                            <span id="total-categories"><?= count($categories) ?></span> catégorie(s)
                        </span>
                    </div>
                </div>
            </div>

            <!-- ========== FOOTER ========== -->
            <footer class="footer">
                <p>© 2026 BNGRC - Système de gestion des dons</p>
                <p>ETU004031 - ETU004183 - ETU004273</p>
            </footer>
        </main>
    </div>

    <!-- Script pour l'ajout dynamique de catégories -->
    <script>
        (function() {
            const form = document.getElementById('categorie-form');
            const messageContainer = document.getElementById('message-container');
            const categoriesList = document.getElementById('categories-list');
            const totalCategories = document.getElementById('total-categories');
            const nomCategorieInput = document.getElementById('nom_categorie');

            form.addEventListener('submit', function(e) {
                e.preventDefault();

                // Récupérer la valeur
                const nomCategorie = nomCategorieInput.value.trim();
                
                if (!nomCategorie) {
                    showMessage('Veuillez saisir un nom de catégorie', 'error');
                    return;
                }

                // Désactiver le bouton de soumission
                const submitBtn = form.querySelector('button[type="submit"]');
                const originalHTML = submitBtn.innerHTML;
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<span>Ajout...</span>';

                // Préparer les données
                const formData = new FormData();
                formData.append('nom_categorie', nomCategorie);

                // Envoyer la requête AJAX
                fetch('<?= BASE_URL ?>/api/categorie', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Afficher message de succès
                        showMessage('Catégorie ajoutée avec succès !', 'success');
                        
                        // Réinitialiser le formulaire
                        form.reset();
                        
                        // Ajouter la nouvelle catégorie à la liste
                        addCategorieToList(data.categorie);
                        
                        // Mettre à jour le compteur
                        updateCounter();
                        
                    } else {
                        showMessage(data.message || 'Erreur lors de l\'ajout de la catégorie', 'error');
                    }
                    
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalHTML;
                })
                .catch(error => {
                    console.error('Erreur:', error);
                    showMessage('Une erreur s\'est produite. Veuillez réessayer.', 'error');
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalHTML;
                });
            });

            function addCategorieToList(categorie) {
                // Supprimer le message "Aucune catégorie" si présent
                const noDataRow = document.getElementById('no-data-row');
                if (noDataRow) {
                    noDataRow.remove();
                }

                // Créer la nouvelle ligne
                const newRow = document.createElement('tr');
                newRow.setAttribute('data-id', categorie.id);
                newRow.innerHTML = `
                    <td>${categorie.id}</td>
                    <td>
                        <span class="badge" style="background: #e3f2fd; color: #1976d2; font-weight: 500;">
                            ${escapeHtml(categorie.nom_categorie)}
                        </span>
                    </td>
                    <td style="text-align: center;">
                        <button class="action-btn delete-btn" onclick="deleteCategorie(${categorie.id}, '${escapeHtml(categorie.nom_categorie).replace(/'/g, "\\'")}')">
                            <svg class="icon" viewBox="0 0 24 24" width="16" height="16">
                                <path fill="currentColor" d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"/>
                            </svg>
                            Supprimer
                        </button>
                    </td>
                `;
                
                // Ajouter avec animation
                newRow.style.backgroundColor = '#d4edda';
                categoriesList.insertBefore(newRow, categoriesList.firstChild);
                
                // Retirer le surlignage après 2 secondes
                setTimeout(() => {
                    newRow.style.transition = 'background-color 1s';
                    newRow.style.backgroundColor = '';
                }, 2000);
            }

            function updateCounter() {
                const count = categoriesList.querySelectorAll('tr:not(#no-data-row)').length;
                totalCategories.textContent = count;
            }

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

            function escapeHtml(text) {
                const map = {
                    '&': '&amp;',
                    '<': '&lt;',
                    '>': '&gt;',
                    '"': '&quot;',
                    "'": '&#039;'
                };
                return text.replace(/[&<>"']/g, m => map[m]);
            }
        })();
        
        // Fonction de suppression de catégorie (globale)
        function deleteCategorie(id, nomCategorie) {
            if (!confirm(`Êtes-vous sûr de vouloir supprimer la catégorie "${nomCategorie}" ?\n\nAttention : cette action est irréversible.`)) {
                return;
            }
            
            // Envoyer la requête de suppression
            fetch('<?= BASE_URL ?>/api/categorie/' + id, {
                method: 'DELETE'
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Supprimer la ligne du tableau avec animation
                    const row = document.querySelector(`tr[data-id="${id}"]`);
                    if (row) {
                        row.style.transition = 'all 0.3s ease';
                        row.style.backgroundColor = '#f8d7da';
                        row.style.opacity = '0';
                        setTimeout(() => {
                            row.remove();
                            
                            // Mettre à jour le compteur
                            const totalCategories = document.getElementById('total-categories');
                            const count = document.querySelectorAll('#categories-list tr:not(#no-data-row)').length;
                            totalCategories.textContent = count;
                            
                            // Si plus de catégories, afficher le message
                            if (count === 0) {
                                document.getElementById('categories-list').innerHTML = `
                                    <tr id="no-data-row">
                                        <td colspan="3" style="text-align: center; padding: 40px; color: #999;">
                                            Aucune catégorie enregistrée
                                        </td>
                                    </tr>
                                `;
                            }
                        }, 300);
                    }
                    
                    // Afficher message de succès
                    const messageContainer = document.getElementById('message-container');
                    messageContainer.innerHTML = `
                        <div class="alert alert-success">
                            Catégorie supprimée avec succès !
                        </div>
                    `;
                    messageContainer.style.display = 'block';
                    setTimeout(() => {
                        messageContainer.style.display = 'none';
                    }, 3000);
                } else {
                    alert(data.message || 'Erreur lors de la suppression');
                }
            })
            .catch(error => {
                console.error('Erreur:', error);
                alert('Une erreur s\'est produite lors de la suppression');
            });
        }
    </script>
</body>
</html>
