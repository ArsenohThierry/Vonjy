<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.5">
    <title>BNGRC · Ajouter un besoin</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/add-besoin.css">
    <style>
        .alert { padding: 15px; margin: 20px 0; border-radius: 5px; }
        .alert-success { background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .alert-error { background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
    </style>
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
                    <a href="/besoins" class="back-link">
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

            <?php if (!empty($message)): ?>
                <div class="alert alert-success"><?= htmlspecialchars($message, ENT_QUOTES, 'UTF-8') ?></div>
            <?php endif; ?>
            
            <?php if (!empty($error)): ?>
                <div class="alert alert-error"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></div>
            <?php endif; ?>

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

                <form class="besoin-form" method="POST" action="<?= BASE_URL ?>/save-besoin">
                    <!-- Ville (select) -->
                    <div class="form-group">
                        <label for="id_ville" class="form-label">
                            Ville <span class="required">*</span>
                        </label>
                        <div class="select-wrapper">
                            <select id="id_ville" name="id_ville" class="form-select" required>
                                <option value="" disabled selected>Choisir une ville</option>
                                <?php foreach ($villes as $ville): ?>
                                    <option value="<?= $ville['id'] ?>">
                                        <?= htmlspecialchars($ville['nom_ville'], ENT_QUOTES, 'UTF-8') ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <!-- Produit (select) -->
                    <div class="form-group">
                        <label for="id_produit" class="form-label">
                            Produit <span class="required">*</span>
                        </label>
                        <div class="select-wrapper">
                            <select id="id_produit" name="id_produit" class="form-select" required>
                                <option value="" disabled selected>Choisir un produit</option>
                                <?php 
                                $currentCategory = '';
                                foreach ($produits as $produit): 
                                    if ($currentCategory !== $produit['nom_categorie']):
                                        if ($currentCategory !== '') echo '</optgroup>';
                                        $currentCategory = $produit['nom_categorie'];
                                        echo '<optgroup label="' . htmlspecialchars($currentCategory, ENT_QUOTES, 'UTF-8') . '">';
                                    endif;
                                ?>
                                    <option value="<?= $produit['id'] ?>">
                                        <?= htmlspecialchars($produit['nom_produit'], ENT_QUOTES, 'UTF-8') ?> 
                                        (<?= number_format($produit['pu'], 0, ',', ' ') ?> Ar)
                                    </option>
                                <?php 
                                endforeach; 
                                if ($currentCategory !== '') echo '</optgroup>';
                                ?>
                            </select>
                        </div>
                    </div>

                    <!-- Quantité -->
                    <div class="form-group">
                        <label for="quantite_besoin" class="form-label">
                            Quantité <span class="required">*</span>
                        </label>
                        <input type="number" id="quantite_besoin" name="quantite_besoin" class="form-input" 
                               placeholder="120" min="1" required>
                        <span class="form-hint">Nombre d'unités nécessaires</span>
                    </div>

                    <!-- Date -->
                    <div class="form-group">
                        <label for="date_besoin" class="form-label">
                            Date du besoin <span class="required">*</span>
                        </label>
                        <input type="datetime-local" id="date_besoin" name="date_besoin" class="form-input" 
                               value="<?= date('Y-m-d\TH:i') ?>" required>
                    </div>

                    <!-- Boutons d'action -->
                    <div class="form-actions">
                        <button type="button" class="btn btn-secondary" onclick="window.location.href='/besoins'">Annuler</button>
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