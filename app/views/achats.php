<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.5">
    <title>BNGRC · Liste des achats</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/besoins.css">
</head>
<body>
    <?php $activePage = 'achats'; ?>
    <div class="app-container">
        <?php include('partials/sidebar.php'); ?>

        <main class="main-content">
            <header class="content-header">
                <div class="title-section">
                    <h1 class="page-title">Liste des achats</h1>
                    <p class="page-subtitle">Achats de besoins effectués via les dons en argent</p>
                </div>
                <a href="<?= BASE_URL ?>/besoins">
                    <button class="btn btn-secondary">
                        Retour aux besoins
                    </button>
                </a>
            </header>

            <!-- ========== CARTES RÉCAP ========== -->
            <div class="stats-grid" style="display: flex; gap: 20px; margin-bottom: 25px; flex-wrap: wrap;">
                <div class="stat-card" style="background: #d4edda; padding: 20px; border-radius: 10px; flex: 1; min-width: 200px;">
                    <div style="font-size: 0.9em; color: #155724;">Total dons argent</div>
                    <div style="font-size: 1.5em; font-weight: bold; color: #155724;"><?= number_format($totalDonsArgent, 0, ',', ' ') ?> Ar</div>
                </div>
                <div class="stat-card" style="background: #f8d7da; padding: 20px; border-radius: 10px; flex: 1; min-width: 200px;">
                    <div style="font-size: 0.9em; color: #721c24;">Total achats effectués</div>
                    <div style="font-size: 1.5em; font-weight: bold; color: #721c24;"><?= number_format($totalAchats, 0, ',', ' ') ?> Ar</div>
                </div>
                <div class="stat-card" style="background: #cce5ff; padding: 20px; border-radius: 10px; flex: 1; min-width: 200px;">
                    <div style="font-size: 0.9em; color: #004085;">Argent disponible</div>
                    <div style="font-size: 1.5em; font-weight: bold; color: #004085;"><?= number_format($argentDispo, 0, ',', ' ') ?> Ar</div>
                </div>
                <div class="stat-card" style="background: #fff3cd; padding: 20px; border-radius: 10px; flex: 1; min-width: 200px;">
                    <div style="font-size: 0.9em; color: #856404;">Frais d'achat</div>
                    <div style="font-size: 1.5em; font-weight: bold; color: #856404;"><?= $fraisPourcent ?>%</div>
                </div>
            </div>

            <!-- ========== FILTRE PAR VILLE ========== -->
            <div class="filters-bar" style="margin-bottom: 20px;">
                <form method="GET" action="<?= BASE_URL ?>/achats" style="display: flex; gap: 10px; align-items: center;">
                    <label for="ville">Filtrer par ville:</label>
                    <select name="ville" id="ville" onchange="this.form.submit()" style="padding: 8px 12px; border-radius: 6px; border: 1px solid #ddd;">
                        <option value="">Toutes les villes</option>
                        <?php foreach ($villes as $v): ?>
                            <option value="<?= $v['id'] ?>" <?= $villeSelectionnee == $v['id'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($v['nom_ville']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <?php if ($villeSelectionnee): ?>
                        <a href="<?= BASE_URL ?>/achats" style="color: #e74c3c; text-decoration: none;">Réinitialiser</a>
                    <?php endif; ?>
                </form>
            </div>

            <!-- ========== TABLEAU DES ACHATS ========== -->
            <div class="table-container">
                <table class="besoins-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Date</th>
                            <th>Ville</th>
                            <th>Produit</th>
                            <th>Catégorie</th>
                            <th>Qté achetée</th>
                            <th>Prix unit.</th>
                            <th>Montant HT</th>
                            <th>Frais</th>
                            <th>Total TTC</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($achats)): ?>
                            <tr>
                                <td colspan="10" style="text-align: center; padding: 40px; color: #999;">
                                    Aucun achat effectué<?= $villeSelectionnee ? ' pour cette ville' : '' ?>.
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($achats as $achat): ?>
                            <tr>
                                <td><?= $achat['id'] ?></td>
                                <td><?= date('d/m/Y H:i', strtotime($achat['date_achat'])) ?></td>
                                <td><?= htmlspecialchars($achat['nom_ville']) ?></td>
                                <td><?= htmlspecialchars($achat['nom_produit']) ?></td>
                                <td>
                                    <span class="badge badge-<?= $achat['nom_categorie'] ?>"><?= $achat['nom_categorie'] ?></span>
                                </td>
                                <td style="text-align: center;"><?= $achat['quantite_achetee'] ?></td>
                                <td class="prix-cell"><?= number_format($achat['prix_unitaire'], 0, ',', ' ') ?></td>
                                <td class="prix-cell"><?= number_format($achat['montant_ht'], 0, ',', ' ') ?></td>
                                <td style="color: #e67e22;"><?= number_format($achat['montant_frais'], 0, ',', ' ') ?> (<?= $achat['frais_pourcent'] ?>%)</td>
                                <td class="total-cell" style="font-weight: bold; color: #27ae60;"><?= number_format($achat['montant_total'], 0, ',', ' ') ?></td>
                            </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                    <?php if (!empty($achats)): ?>
                    <tfoot>
                        <tr style="background: #f8f9fa; font-weight: bold;">
                            <td colspan="7" style="text-align: right;">Total:</td>
                            <td><?= number_format(array_sum(array_column($achats, 'montant_ht')), 0, ',', ' ') ?></td>
                            <td><?= number_format(array_sum(array_column($achats, 'montant_frais')), 0, ',', ' ') ?></td>
                            <td style="color: #27ae60;"><?= number_format(array_sum(array_column($achats, 'montant_total')), 0, ',', ' ') ?></td>
                        </tr>
                    </tfoot>
                    <?php endif; ?>
                </table>
            </div>

            <!-- ========== INFO ========== -->
            <div class="info-note" style="margin-top: 20px; padding: 15px; background: #e8f4f8; border-radius: 8px; display: flex; align-items: center; gap: 10px;">
                <svg viewBox="0 0 24 24" width="20" height="20">
                    <path fill="#7A90A4" d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/>
                </svg>
                <span>Les achats sont effectués à partir des dons en argent. Le frais de <?= $fraisPourcent ?>% est ajouté au prix unitaire.</span>
            </div>

            <footer class="footer">
                <p>© 2026 BNGRC - Système de gestion des dons</p>
                <p>ETU004031 - ETU004273 - ETU004183</p>
            </footer>
        </main>
    </div>
</body>
</html>
