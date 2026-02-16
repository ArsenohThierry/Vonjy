<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.5">
    <title>BNGRC · Liste des produits</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/categorie.css">
</head>
<body>
    <!-- ========== LAYOUT PRINCIPAL AVEC MENU LATERAL ========== -->
    <?php $activePage = 'produits'; ?>
    <div class="app-container">
        <!-- ========== MENU DE NAVIGATION GAUCHE ========== -->
        <?php include('partials/sidebar.php'); ?>

        <!-- ========== CONTENU PRINCIPAL ========== -->
        <main class="main-content">
            <!-- Header avec titre et bouton d'ajout -->
            <header class="content-header">
                <div class="title-section">
                    <h1 class="page-title">Liste des produits</h1>
                    <p class="page-subtitle" style="font-size: 0.95rem; color: #7A90A4; margin-top: 0.3rem;">Gestion du catalogue de produits</p>
                </div>
                <a href="<?= BASE_URL ?>/add-produit">
                    <button class="btn btn-primary">
                        <svg class="btn-icon" viewBox="0 0 24 24" width="18" height="18">
                            <path fill="currentColor" d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/>
                        </svg>
                        Ajouter un produit
                    </button>
                </a>
            </header>

            <!-- ========== MESSAGE DE RETOUR ========== -->
            <div id="message-container" style="display: none;"></div>

            <!-- ========== TABLEAU DES PRODUITS ========== -->
            <div class="table-container">
                <table class="dons-table">
                    <thead>
                        <tr>
                            <th style="width: 80px;">ID</th>
                            <th>Nom du produit</th>
                            <th>Catégorie</th>
                            <th style="width: 150px; text-align: right;">Prix unitaire</th>
                            <th style="width: 200px; text-align: center;">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="produits-list">
                        <?php if (empty($produits)): ?>
                            <tr id="no-data-row">
                                <td colspan="5" style="text-align: center; padding: 40px; color: #999;">
                                    Aucun produit enregistré
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($produits as $produit): ?>
                                <tr data-id="<?= $produit['id'] ?>">
                                    <td><?= $produit['id'] ?></td>
                                    <td>
                                        <span style="font-weight: 500; color: #2c3e50;">
                                            <?= htmlspecialchars($produit['nom_produit']) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge" style="background: #e3f2fd; color: #1976d2; font-weight: 500;">
                                            <?= htmlspecialchars($produit['nom_categorie']) ?>
                                        </span>
                                    </td>
                                    <td style="text-align: right;">
                                        <span style="font-weight: 600; color: #137C8B;">
                                            <?= number_format($produit['pu'], 0, ',', ' ') ?> Ar
                                        </span>
                                    </td>
                                    <td style="text-align: center;">
                                        <div style="display: flex; gap: 0.5rem; justify-content: center;">
                                            <button class="action-btn edit-btn" onclick="editProduit(<?= $produit['id'] ?>)">
                                                <svg class="icon" viewBox="0 0 24 24" width="16" height="16">
                                                    <path fill="currentColor" d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/>
                                                </svg>
                                                Modifier
                                            </button>
                                            <button class="action-btn delete-btn" onclick="deleteProduit(<?= $produit['id'] ?>, '<?= htmlspecialchars($produit['nom_produit'], ENT_QUOTES) ?>')">
                                                <svg class="icon" viewBox="0 0 24 24" width="16" height="16">
                                                    <path fill="currentColor" d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"/>
                                                </svg>
                                                Supprimer
                                            </button>
                                        </div>
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
                            <span id="total-produits"><?= count($produits) ?></span> produit(s)
                        </span>
                    </div>
                </div>
            </div>

            <!-- ========== MODAL DE MODIFICATION ========== -->
            <div id="edit-modal" class="modal" style="display: none;">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2>Modifier le produit</h2>
                        <button class="modal-close" onclick="closeEditModal()">&times;</button>
                    </div>
                    <form id="edit-form" class="don-form">
                        <input type="hidden" id="edit-id">
                        
                        <div class="form-group">
                            <label for="edit-nom" class="form-label">
                                Nom du produit <span class="required">*</span>
                            </label>
                            <input type="text" id="edit-nom" class="form-input" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="edit-pu" class="form-label">
                                Prix unitaire (Ar) <span class="required">*</span>
                            </label>
                            <input type="number" id="edit-pu" class="form-input" step="0.01" min="0" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="edit-categorie" class="form-label">
                                Catégorie <span class="required">*</span>
                            </label>
                            <select id="edit-categorie" class="form-input" required>
                                <option value="">Sélectionnez une catégorie</option>
                                <?php foreach ($categories as $categorie): ?>
                                    <option value="<?= $categorie['id'] ?>">
                                        <?= htmlspecialchars($categorie['nom_categorie']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        
                        <div style="display: flex; gap: 1rem; justify-content: flex-end; margin-top: 1.5rem;">
                            <button type="button" class="btn btn-secondary" onclick="closeEditModal()">Annuler</button>
                            <button type="submit" class="btn btn-primary">Enregistrer</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- ========== FOOTER ========== -->
            <footer class="footer">
                <p>© 2026 BNGRC - Système de gestion des dons</p>
                <p>ETU004031 - ETU004183 - ETU004273</p>
            </footer>
        </main>
    </div>

    <script>
        // Fonction de suppression de produit
        function deleteProduit(id, nomProduit) {
            if (!confirm(`Êtes-vous sûr de vouloir supprimer le produit "${nomProduit}" ?\n\nAttention : cette action est irréversible.`)) {
                return;
            }
            
            fetch('<?= BASE_URL ?>/api/produit/' + id, {
                method: 'DELETE'
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Supprimer la ligne
                    const row = document.querySelector(`tr[data-id="${id}"]`);
                    if (row) {
                        row.style.transition = 'all 0.3s ease';
                        row.style.backgroundColor = '#f8d7da';
                        row.style.opacity = '0';
                        setTimeout(() => {
                            row.remove();
                            updateCounter();
                            checkEmptyList();
                        }, 300);
                    }
                    
                    showMessage('Produit supprimé avec succès !', 'success');
                } else {
                    alert(data.message || 'Erreur lors de la suppression');
                }
            })
            .catch(error => {
                console.error('Erreur:', error);
                alert('Une erreur s\'est produite lors de la suppression');
            });
        }
        
        // Fonction d'édition de produit
        function editProduit(id) {
            fetch('<?= BASE_URL ?>/api/produit/' + id)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const produit = data.produit;
                        document.getElementById('edit-id').value = produit.id;
                        document.getElementById('edit-nom').value = produit.nom_produit;
                        document.getElementById('edit-pu').value = produit.pu;
                        document.getElementById('edit-categorie').value = produit.id_categorie;
                        document.getElementById('edit-modal').style.display = 'flex';
                    } else {
                        alert('Erreur lors du chargement du produit');
                    }
                })
                .catch(error => {
                    console.error('Erreur:', error);
                    alert('Une erreur s\'est produite');
                });
        }
        
        // Fermer le modal
        function closeEditModal() {
            document.getElementById('edit-modal').style.display = 'none';
        }
        
        // Soumettre la modification
        document.getElementById('edit-form').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const id = document.getElementById('edit-id').value;
            const formData = new FormData();
            formData.append('nom_produit', document.getElementById('edit-nom').value);
            formData.append('pu', document.getElementById('edit-pu').value);
            formData.append('id_categorie', document.getElementById('edit-categorie').value);
            
            fetch('<?= BASE_URL ?>/api/produit/' + id + '/update', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showMessage('Produit modifié avec succès !', 'success');
                    closeEditModal();
                    // Recharger la page après 1 seconde
                    setTimeout(() => {
                        window.location.reload();
                    }, 1000);
                } else {
                    alert(data.message || 'Erreur lors de la modification');
                    // Afficher les détails de debug si disponibles
                    if (data.debug) {
                        console.log('Debug:', data.debug);
                    }
                }
            })
            .catch(error => {
                console.error('Erreur:', error);
                alert('Une erreur s\'est produite');
            });
        });
        
        function updateCounter() {
            const count = document.querySelectorAll('#produits-list tr:not(#no-data-row)').length;
            document.getElementById('total-produits').textContent = count;
        }
        
        function checkEmptyList() {
            const count = document.querySelectorAll('#produits-list tr:not(#no-data-row)').length;
            if (count === 0) {
                document.getElementById('produits-list').innerHTML = `
                    <tr id="no-data-row">
                        <td colspan="5" style="text-align: center; padding: 40px; color: #999;">
                            Aucun produit enregistré
                        </td>
                    </tr>
                `;
            }
        }
        
        function showMessage(message, type) {
            const messageContainer = document.getElementById('message-container');
            messageContainer.innerHTML = `
                <div class="alert alert-${type}">
                    ${message}
                </div>
            `;
            messageContainer.style.display = 'block';
            setTimeout(() => {
                messageContainer.style.display = 'none';
            }, 3000);
        }
    </script>
    
    <style>
        /* Modal styles */
        .modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1000;
        }
        
        .modal-content {
            background: white;
            border-radius: var(--radius);
            max-width: 600px;
            width: 90%;
            max-height: 90vh;
            overflow-y: auto;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        }
        
        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1.5rem 2rem;
            border-bottom: 2px solid var(--border-light);
            background: linear-gradient(135deg, #f0f8fa 0%, #e8f4f7 100%);
        }
        
        .modal-header h2 {
            margin: 0;
            color: var(--primary-deep);
            font-size: 1.5rem;
        }
        
        .modal-close {
            background: none;
            border: none;
            font-size: 2rem;
            color: var(--neutral-gray);
            cursor: pointer;
            line-height: 1;
            padding: 0;
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .modal-close:hover {
            color: var(--primary-deep);
        }
        
        .btn-secondary {
            background: linear-gradient(135deg, #7A90A4 0%, #5d6f82 100%);
            color: white;
        }
        
        .btn-secondary:hover {
            background: linear-gradient(135deg, #5d6f82 0%, #4a5766 100%);
        }
        
        .page-subtitle {
            font-size: 0.95rem;
            color: #7A90A4;
            margin-top: 0.3rem;
        }
        
        .title-section {
            display: flex;
            flex-direction: column;
            gap: 0.3rem;
        }
    </style>
</body>
</html>
