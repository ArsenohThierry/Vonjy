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
                    <h1 class="page-title">
                        <?php if (!empty($hasDistribution)): ?>
                            Besoins restants (non couverts)
                        <?php else: ?>
                            Liste des besoins
                        <?php endif; ?>
                    </h1>
                    <p class="page-subtitle">
                        <?php if (!empty($hasDistribution)): ?>
                            Seuls les besoins non couverts à 100% sont affichés
                        <?php else: ?>
                            Gestion des ressources nécessaires par ville
                        <?php endif; ?>
                    </p>
                </div>
                <a href="<?= BASE_URL ?>/add-besoin">
                                    <button class="btn btn-primary">
                    <svg class="btn-icon" viewBox="0 0 24 24" width="18" height="18">
                        <path fill="currentColor" d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/>
                    </svg>
                    Ajouter un besoin
                </button>
                </a>
            </header>

            <!-- ========== FILTRES RAPIDES (optionnels, pour l'ambiance) ========== -->
            <div class="filters-bar">
                <div class="filter-tabs">
                    <span class="filter-tab active">Tous les besoins</span>
                    <span class="filter-tab">Nature</span>
                    <span class="filter-tab">Matériau</span>
                    <span class="filter-tab">Argent</span>
                </div>
                <div class="filter-stats" style="display: flex; gap: 15px; align-items: center;">
                    <span class="stat-badge"><?= count($besoins ?? []) ?> besoins restants</span>
                    <span class="stat-badge" style="background: #d4edda; color: #155724;">
                        Argent dispo: <strong><?= number_format($argentDispo ?? 0, 0, ',', ' ') ?> Ar</strong>
                        (frais <?= $fraisPourcent ?? 10 ?>%)
                    </span>
                    <a href="<?= BASE_URL ?>/achats" class="btn btn-secondary" style="padding: 6px 12px; font-size: 0.85em;">Voir achats</a>
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
                            <?php if (!empty($hasDistribution) || !empty($hasAchats)): ?>
                                <th>Qté demandée</th>
                                <th>Qté attribuée</th>
                                <th>Qté achetée</th>
                                <th>Qté restante</th>
                                <th>Valeur restante (Ar)</th>
                            <?php else: ?>
                                <th>Quantité</th>
                                <th>Valeur totale (Ar)</th>
                            <?php endif; ?>
                            <th>Date</th>
                            <th>Action</th>
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
                            <?php if (!empty($hasDistribution) || !empty($hasAchats)): ?>
                                <td class="quantite-cell"><?= $besoin['quantite_besoin'] ?></td>
                                <td class="quantite-cell" style="color: #27ae60;"><?= $besoin['quantite_attribuee'] ?? 0 ?></td>
                                <td class="quantite-cell" style="color: #3498db;"><?= $besoin['quantite_achetee'] ?? 0 ?></td>
                                <td class="quantite-cell" style="color: #e74c3c; font-weight: bold;"><?= $besoin['quantite_restante'] ?? $besoin['quantite_besoin'] ?></td>
                                <td class="total-cell"><?= number_format(($besoin['quantite_restante'] ?? $besoin['quantite_besoin']) * $besoin['pu'], 0, ',', ' ') ?></td>
                            <?php else: ?>
                                <td class="quantite-cell"><?= $besoin['quantite_besoin'] ?></td>
                                <td class="total-cell"><?= number_format($besoin['pu'] * $besoin['quantite_besoin'], 0, ',', ' ') ?></td>
                            <?php endif; ?>
                            <td class="date-cell"><?= $besoin['date_besoin'] ?></td>
                            <td>
                                <?php if (strtolower($besoin['nom_categorie']) !== 'argent'): ?>
                                    <button class="btn-acheter" 
                                            onclick="ouvrirModalAchat(<?= $besoin['id'] ?>, '<?= htmlspecialchars($besoin['nom_produit']) ?>', '<?= htmlspecialchars($besoin['nom_ville']) ?>', <?= $besoin['pu'] ?>, <?= $besoin['quantite_restante'] ?? $besoin['quantite_besoin'] ?>)"
                                            title="Acheter avec dons argent">
                                        Acheter
                                    </button>
                                <?php else: ?>
                                    <span style="color: #999; font-size: 0.85em;">-</span>
                                <?php endif; ?>
                            </td>
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
                <p>ETU004031 - ETU004273 - ETU004183</p>
            </footer>
        </main>
    </div>

    <!-- ========== MODAL ACHAT ========== -->
    <div id="modal-achat" class="modal" style="display: none;">
        <div class="modal-overlay" onclick="fermerModal()"></div>
        <div class="modal-content">
            <div class="modal-header">
                <h2>Acheter un besoin</h2>
                <button class="modal-close" onclick="fermerModal()">&times;</button>
            </div>
            <div class="modal-body">
                <div class="achat-info">
                    <p><strong>Produit:</strong> <span id="achat-produit"></span></p>
                    <p><strong>Ville:</strong> <span id="achat-ville"></span></p>
                    <p><strong>Prix unitaire:</strong> <span id="achat-pu"></span> Ar</p>
                    <p><strong>Quantité restante:</strong> <span id="achat-qte-max"></span> unités</p>
                    <p><strong>Argent disponible:</strong> <span id="achat-argent-dispo"><?= number_format($argentDispo ?? 0, 0, ',', ' ') ?></span> Ar</p>
                    <p><strong>Frais d'achat:</strong> <?= $fraisPourcent ?? 10 ?>%</p>
                </div>
                <hr style="margin: 15px 0;">
                <div class="achat-form">
                    <input type="hidden" id="achat-id-besoin">
                    <input type="hidden" id="achat-prix-unitaire">
                    
                    <label for="achat-quantite">Quantité à acheter:</label>
                    <div style="display: flex; gap: 10px; align-items: center;">
                        <input type="number" id="achat-quantite" min="1" value="1" onchange="calculerCout()" oninput="calculerCout()">
                        <button type="button" class="btn-tout" onclick="acheterTout()">Tout acheter</button>
                    </div>
                    
                    <div class="cout-preview" id="cout-preview">
                        <p>Montant HT: <span id="montant-ht">0</span> Ar</p>
                        <p>Frais (<?= $fraisPourcent ?? 10 ?>%): <span id="montant-frais">0</span> Ar</p>
                        <p class="total"><strong>Total TTC: <span id="montant-total">0</span> Ar</strong></p>
                    </div>
                    
                    <div id="achat-erreur" class="erreur" style="display: none;"></div>
                    <div id="achat-succes" class="succes" style="display: none;"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" onclick="fermerModal()">Annuler</button>
                <button class="btn btn-primary" id="btn-confirmer-achat" onclick="confirmerAchat()">Confirmer l'achat</button>
            </div>
        </div>
    </div>

    <style>
        .btn-acheter {
            background: #3498db;
            color: white;
            border: none;
            padding: 5px 12px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 0.85em;
        }
        .btn-acheter:hover { background: #2980b9; }
        
        .modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 1000;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .modal-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
        }
        .modal-content {
            position: relative;
            background: white;
            border-radius: 12px;
            width: 90%;
            max-width: 500px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.3);
        }
        .modal-header {
            padding: 20px;
            border-bottom: 1px solid #eee;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .modal-header h2 { margin: 0; font-size: 1.3em; }
        .modal-close {
            background: none;
            border: none;
            font-size: 1.5em;
            cursor: pointer;
            color: #999;
        }
        .modal-body { padding: 20px; }
        .modal-footer {
            padding: 15px 20px;
            border-top: 1px solid #eee;
            display: flex;
            justify-content: flex-end;
            gap: 10px;
        }
        .achat-info p { margin: 8px 0; }
        .achat-form label { display: block; margin-bottom: 8px; font-weight: 500; }
        .achat-form input[type="number"] {
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 6px;
            width: 120px;
            font-size: 1em;
        }
        .btn-tout {
            background: #e67e22;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 6px;
            cursor: pointer;
        }
        .cout-preview {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            margin-top: 15px;
        }
        .cout-preview p { margin: 5px 0; }
        .cout-preview .total { font-size: 1.1em; color: #27ae60; margin-top: 10px; }
        .erreur {
            background: #f8d7da;
            color: #721c24;
            padding: 10px;
            border-radius: 6px;
            margin-top: 10px;
        }
        .succes {
            background: #d4edda;
            color: #155724;
            padding: 10px;
            border-radius: 6px;
            margin-top: 10px;
        }
        .btn { padding: 10px 20px; border-radius: 6px; cursor: pointer; border: none; }
        .btn-primary { background: #27ae60; color: white; }
        .btn-secondary { background: #95a5a6; color: white; }
    </style>

    <script>
        const BASE_URL = '<?= BASE_URL ?>';
        const FRAIS_POURCENT = <?= $fraisPourcent ?? 10 ?>;
        let argentDispo = <?= $argentDispo ?? 0 ?>;
        let qteMax = 0;
        let prixUnitaire = 0;

        function ouvrirModalAchat(idBesoin, nomProduit, nomVille, pu, qteRestante) {
            document.getElementById('achat-id-besoin').value = idBesoin;
            document.getElementById('achat-produit').textContent = nomProduit;
            document.getElementById('achat-ville').textContent = nomVille;
            document.getElementById('achat-pu').textContent = numberFormat(pu);
            document.getElementById('achat-qte-max').textContent = qteRestante;
            document.getElementById('achat-prix-unitaire').value = pu;
            document.getElementById('achat-quantite').max = qteRestante;
            document.getElementById('achat-quantite').value = 1;
            
            qteMax = qteRestante;
            prixUnitaire = pu;
            
            document.getElementById('achat-erreur').style.display = 'none';
            document.getElementById('achat-succes').style.display = 'none';
            document.getElementById('btn-confirmer-achat').disabled = false;
            
            calculerCout();
            document.getElementById('modal-achat').style.display = 'flex';
        }

        function fermerModal() {
            document.getElementById('modal-achat').style.display = 'none';
        }

        function acheterTout() {
            document.getElementById('achat-quantite').value = qteMax;
            calculerCout();
        }

        function calculerCout() {
            const quantite = parseInt(document.getElementById('achat-quantite').value) || 0;
            const montantHT = quantite * prixUnitaire;
            const montantFrais = montantHT * (FRAIS_POURCENT / 100);
            const montantTotal = montantHT + montantFrais;

            document.getElementById('montant-ht').textContent = numberFormat(montantHT);
            document.getElementById('montant-frais').textContent = numberFormat(montantFrais);
            document.getElementById('montant-total').textContent = numberFormat(montantTotal);

            const erreurEl = document.getElementById('achat-erreur');
            if (montantTotal > argentDispo) {
                erreurEl.textContent = 'Argent insuffisant !';
                erreurEl.style.display = 'block';
            } else if (quantite > qteMax) {
                erreurEl.textContent = 'Quantité supérieure au besoin restant !';
                erreurEl.style.display = 'block';
            } else {
                erreurEl.style.display = 'none';
            }
        }

        function confirmerAchat() {
            const idBesoin = document.getElementById('achat-id-besoin').value;
            const quantite = parseInt(document.getElementById('achat-quantite').value);

            if (quantite <= 0 || quantite > qteMax) {
                document.getElementById('achat-erreur').textContent = 'Quantité invalide';
                document.getElementById('achat-erreur').style.display = 'block';
                return;
            }

            document.getElementById('btn-confirmer-achat').disabled = true;
            document.getElementById('achat-erreur').style.display = 'none';

            fetch(BASE_URL + '/api/achat', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `id_besoin=${idBesoin}&quantite=${quantite}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    document.getElementById('achat-erreur').textContent = data.error;
                    document.getElementById('achat-erreur').style.display = 'block';
                    document.getElementById('btn-confirmer-achat').disabled = false;
                } else {
                    document.getElementById('achat-succes').textContent = data.message;
                    document.getElementById('achat-succes').style.display = 'block';
                    setTimeout(() => {
                        location.reload();
                    }, 1500);
                }
            })
            .catch(err => {
                document.getElementById('achat-erreur').textContent = 'Erreur réseau';
                document.getElementById('achat-erreur').style.display = 'block';
                document.getElementById('btn-confirmer-achat').disabled = false;
            });
        }

        function numberFormat(num) {
            return Math.round(num).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ' ');
        }
    </script>
</body>
</html>