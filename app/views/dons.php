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
                <a href="<?= BASE_URL ?>/add-don">
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
                    <span class="stat-mini-value"><?= $total_dons ?></span>
                </div>
                <div class="stat-mini-item">
                    <span class="stat-mini-label">Montant total</span>
                    <span class="stat-mini-value"><?= number_format($montant_total / 1000000, 1, ',', ' ') ?> M Ar</span>
                </div>
                <div class="stat-mini-item">
                    <label for="filter-categorie" class="stat-mini-label">Filtrer par catégorie</label>
                    <select id="filter-categorie" class="filter-select">
                        <option value="">Toutes les catégories</option>
                        <?php if (!empty($stats_by_category)): ?>
                            <?php foreach ($stats_by_category as $stat): ?>
                                <option value="<?= htmlspecialchars($stat['nom_categorie']) ?>">
                                    <?= htmlspecialchars($stat['nom_categorie']) ?> (<?= $stat['nombre_dons'] ?>)
                                </option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>
            </div>

            <!-- ========== TABLEAU DES DONS ========== -->
            <div class="table-container">
                <table class="dons-table">
                    <thead>
                        <tr>
                            <th>Catégorie</th>
                            <th>Produit</th>
                            <th>Donateur</th>
                            <th>Quantité</th>
                            <th>Montant</th>
                            <th>Date</th>
                            <th style="width: 180px; text-align: center;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($dons)): ?>
                            <tr>
                                <td colspan="7" style="text-align: center; padding: 40px; color: #999;">
                                    Aucun don enregistré pour le moment
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($dons as $don): ?>
                                <?php 
                                    $montant = $don['quantite_don'] * $don['pu'];
                                    $categorie = strtolower($don['nom_categorie']);
                                    $badgeClass = 'badge-nature'; // Par défaut
                                    
                                    if (strpos($categorie, 'nature') !== false) {
                                        $badgeClass = 'badge-nature';
                                    } elseif (strpos($categorie, 'materiau') !== false || strpos($categorie, 'matériau') !== false) {
                                        $badgeClass = 'badge-materiau';
                                    } elseif (strpos($categorie, 'argent') !== false) {
                                        $badgeClass = 'badge-argent';
                                    }
                                ?>
                                <tr data-categorie="<?= htmlspecialchars($don['nom_categorie']) ?>" data-id="<?= $don['id'] ?>">
                                    <td>
                                        <span class="badge <?= $badgeClass ?>">
                                            <?= htmlspecialchars($don['nom_categorie']) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <div class="description-cell">
                                            <span class="description-titre">
                                                <?= htmlspecialchars($don['nom_produit']) ?>
                                            </span>
                                            <span class="description-detail">
                                                Prix unitaire: <?= number_format($don['pu'], 0, ',', ' ') ?> Ar
                                            </span>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="description-detail">
                                            <?= htmlspecialchars($don['nom_donneur']) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <span class="quantite"><?= number_format($don['quantite_don'], 0, ',', ' ') ?> unités</span>
                                    </td>
                                    <td>
                                        <span class="montant"><?= number_format($montant, 0, ',', ' ') ?> Ar</span>
                                    </td>
                                    <td class="date-cell">
                                        <?php 
                                            $date = new DateTime($don['date_don']);
                                            echo $date->format('d/m/Y');
                                        ?>
                                    </td>
                                    <td style="text-align: center;">
                                        <div style="display: flex; gap: 0.5rem; justify-content: center;">
                                            <button class="action-btn edit-btn" onclick="editDon(<?= $don['id'] ?>)">
                                                <svg class="icon" viewBox="0 0 24 24" width="16" height="16">
                                                    <path fill="currentColor" d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/>
                                                </svg>
                                                Modifier
                                            </button>
                                            <button class="action-btn delete-btn" onclick="deleteDon(<?= $don['id'] ?>, '<?= htmlspecialchars($don['nom_donneur'], ENT_QUOTES) ?>')">
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
            </div>

            <!-- ========== LÉGENDE ET RÉCAPITULATIF ========== -->
            <div class="table-footer">
                <div class="footer-info">
                    <span class="info-badge">
                        <span class="dot"></span>
                        <?= $total_dons ?> don(s) enregistré(s)
                    </span>
                    <?php foreach ($stats_by_category as $stat): ?>
                        <?php 
                            $categorie = strtolower($stat['nom_categorie']);
                            $dotClass = 'dot';
                            
                            if (strpos($categorie, 'nature') !== false) {
                                $dotClass = 'dot dot-nature';
                            } elseif (strpos($categorie, 'materiau') !== false || strpos($categorie, 'matériau') !== false) {
                                $dotClass = 'dot dot-materiau';
                            } elseif (strpos($categorie, 'argent') !== false) {
                                $dotClass = 'dot dot-argent';
                            }
                        ?>
                        <span class="info-badge">
                            <span class="<?= $dotClass ?>"></span>
                            <?= htmlspecialchars($stat['nom_categorie']) ?>: <?= $stat['nombre_dons'] ?>
                        </span>
                    <?php endforeach; ?>
                </div>
                <div class="footer-total">
                    <span class="reste-indicator">
                        Montant total: <?= number_format($montant_total, 0, ',', ' ') ?> Ar
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
    
    <script>
        // Filtrage des dons par catégorie
        document.getElementById('filter-categorie').addEventListener('change', function() {
            const selectedCategorie = this.value;
            const rows = document.querySelectorAll('.dons-table tbody tr');
            
            rows.forEach(row => {
                if (!row.hasAttribute('data-categorie')) {
                    // Ne pas filtrer la ligne "Aucun don enregistré"
                    return;
                }
                
                const categorie = row.getAttribute('data-categorie');
                
                if (selectedCategorie === '' || categorie === selectedCategorie) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    </script>

    <!-- Modal pour éditer un don -->
    <div id="editDonModal" class="modal-overlay" style="display: none;">
        <div class="modal-content pastel-modal">
            <div class="modal-header">
                <h3>Modifier le don</h3>
                <button class="close-btn" onclick="closeEditDonModal()">&times;</button>
            </div>
            <form id="editDonForm" class="pastel-form">
                <input type="hidden" id="edit-don-id">
                
                <div class="form-group">
                    <label for="edit-produit">Produit</label>
                    <select id="edit-produit" required>
                        <option value="">Sélectionner un produit</option>
                        <?php foreach ($produits as $produit): ?>
                            <option value="<?= $produit['id'] ?>"><?= htmlspecialchars($produit['nom_produit']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="edit-donateur">Donateur</label>
                    <input type="text" id="edit-donateur" required placeholder="Nom du donateur">
                </div>

                <div class="form-group">
                    <label for="edit-quantite">Quantité</label>
                    <input type="number" id="edit-quantite" min="1" step="0.01" required>
                </div>

                <div class="form-group">
                    <label for="edit-date">Date du don</label>
                    <input type="date" id="edit-date" required>
                </div>

                <div class="form-buttons">
                    <button type="button" class="action-btn" onclick="closeEditDonModal()">Annuler</button>
                    <button type="submit" class="action-btn edit-btn">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Fonction pour afficher les messages
        function showMessage(message, type = 'success') {
            const messageDiv = document.createElement('div');
            messageDiv.className = `alert alert-${type}`;
            messageDiv.style.cssText = `
                position: fixed;
                top: 20px;
                right: 20px;
                padding: 15px 20px;
                background-color: ${type === 'success' ? '#d4edda' : '#f8d7da'};
                color: ${type === 'success' ? '#155724' : '#721c24'};
                border: 1px solid ${type === 'success' ? '#c3e6cb' : '#f5c6cb'};
                border-radius: 8px;
                box-shadow: 0 2px 8px rgba(0,0,0,0.1);
                z-index: 10000;
                max-width: 400px;
            `;
            messageDiv.textContent = message;
            document.body.appendChild(messageDiv);
            
            setTimeout(() => {
                messageDiv.remove();
            }, 3000);
        }

        // Ouvrir le modal d'édition
        async function editDon(id) {
            try {
                const response = await fetch(`/api/don/${id}`);
                const data = await response.json();
                
                if (data.success) {
                    const don = data.don;
                    document.getElementById('edit-don-id').value = don.id;
                    document.getElementById('edit-produit').value = don.id_produit;
                    document.getElementById('edit-donateur').value = don.nom_donneur;
                    document.getElementById('edit-quantite').value = don.quantite_don;
                    document.getElementById('edit-date').value = don.date_don;
                    
                    document.getElementById('editDonModal').style.display = 'flex';
                } else {
                    showMessage(data.message || 'Erreur lors du chargement du don', 'error');
                }
            } catch (error) {
                console.error('Erreur:', error);
                showMessage('Erreur lors du chargement du don', 'error');
            }
        }

        // Fermer le modal
        function closeEditDonModal() {
            document.getElementById('editDonModal').style.display = 'none';
            document.getElementById('editDonForm').reset();
        }

        // Soumettre le formulaire d'édition
        document.getElementById('editDonForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const donId = document.getElementById('edit-don-id').value;
            const formData = new FormData();
            formData.append('id_produit', document.getElementById('edit-produit').value);
            formData.append('nom_donneur', document.getElementById('edit-donateur').value);
            formData.append('quantite', document.getElementById('edit-quantite').value);
            formData.append('date_don', document.getElementById('edit-date').value);
            
            try {
                const response = await fetch(`/api/don/${donId}/update`, {
                    method: 'POST',
                    body: formData
                });
                
                const data = await response.json();
                
                if (data.success) {
                    showMessage('Don modifié avec succès');
                    closeEditDonModal();
                    setTimeout(() => window.location.reload(), 1000);
                } else {
                    showMessage(data.message || 'Erreur lors de la modification', 'error');
                }
            } catch (error) {
                console.error('Erreur:', error);
                showMessage('Erreur lors de la modification', 'error');
            }
        });

        // Supprimer un don
        async function deleteDon(id, nomDonateur) {
            if (!confirm(`Êtes-vous sûr de vouloir supprimer le don de "${nomDonateur}" ?`)) {
                return;
            }
            
            try {
                const response = await fetch(`/api/don/${id}`, {
                    method: 'DELETE'
                });
                
                const data = await response.json();
                
                if (data.success) {
                    showMessage('Don supprimé avec succès');
                    setTimeout(() => window.location.reload(), 1000);
                } else {
                    showMessage(data.message || 'Erreur lors de la suppression', 'error');
                }
            } catch (error) {
                console.error('Erreur:', error);
                showMessage('Erreur lors de la suppression', 'error');
            }
        }
    </script>
</body>
</html>