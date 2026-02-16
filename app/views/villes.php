<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.5">
    <title>BNGRC · Villes sinistrées</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/villes.css">
</head>
<body>
    <!-- ========== LAYOUT PRINCIPAL AVEC MENU LATERAL ========== -->
    <?php $activePage = 'villes'; ?>
    <div class="app-container">
        <!-- ========== MENU DE NAVIGATION GAUCHE ========== -->
        <?php include('partials/sidebar.php'); ?>

        <!-- ========== CONTENU PRINCIPAL ========== -->
        <main class="main-content">
            <!-- Header avec titre et bouton d'ajout -->
            <header class="content-header">
                <h1 class="page-title">Villes sinistrées</h1>
                <button class="btn btn-primary">+ Ajouter une ville</button>
            </header>

            <!-- ========== TABLEAU DES VILLES ========== -->
            <div class="table-container">
                <table class="villes-table">
                    <thead>
                        <tr>
                            <th>Ville</th>
                            <th>Région</th>
                            <th>Nombre de besoins</th>
                            <th>Total estimé (Ar)</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Ville 1 : Ambositra -->
                        <tr>
                            <td>
                                <div class="ville-info">
                                    <span class="ville-nom">Ambositra</span>
                                    <span class="ville-code">AMB</span>
                                </div>
                            </td>
                            <td>Amoron'i Mania</td>
                            <td>
                                <span class="badge">12 besoins</span>
                            </td>
                            <td>
                                <span class="montant">345 000 000</span>
                                <span class="devise">Ar</span>
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <button class="action-btn edit-btn" title="Modifier">
                                        <svg class="icon" viewBox="0 0 24 24" width="16" height="16">
                                            <path fill="currentColor" d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/>
                                        </svg>
                                        Modifier
                                    </button>
                                    <button class="action-btn delete-btn" title="Supprimer">
                                        <svg class="icon" viewBox="0 0 24 24" width="16" height="16">
                                            <path fill="currentColor" d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"/>
                                        </svg>
                                        Supprimer
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <!-- Ville 2 : Morondava -->
                        <tr>
                            <td>
                                <div class="ville-info">
                                    <span class="ville-nom">Morondava</span>
                                    <span class="ville-code">MDV</span>
                                </div>
                            </td>
                            <td>Menabe</td>
                            <td>
                                <span class="badge">8 besoins</span>
                            </td>
                            <td>
                                <span class="montant">215 000 000</span>
                                <span class="devise">Ar</span>
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <button class="action-btn edit-btn" title="Modifier">
                                        <svg class="icon" viewBox="0 0 24 24" width="16" height="16">
                                            <path fill="currentColor" d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/>
                                        </svg>
                                        Modifier
                                    </button>
                                    <button class="action-btn delete-btn" title="Supprimer">
                                        <svg class="icon" viewBox="0 0 24 24" width="16" height="16">
                                            <path fill="currentColor" d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"/>
                                        </svg>
                                        Supprimer
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <!-- Ville 3 : Fort-Dauphin -->
                        <tr>
                            <td>
                                <div class="ville-info">
                                    <span class="ville-nom">Fort-Dauphin</span>
                                    <span class="ville-code">FTD</span>
                                </div>
                            </td>
                            <td>Anosy</td>
                            <td>
                                <span class="badge">15 besoins</span>
                            </td>
                            <td>
                                <span class="montant">428 000 000</span>
                                <span class="devise">Ar</span>
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <button class="action-btn edit-btn" title="Modifier">
                                        <svg class="icon" viewBox="0 0 24 24" width="16" height="16">
                                            <path fill="currentColor" d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/>
                                        </svg>
                                        Modifier
                                    </button>
                                    <button class="action-btn delete-btn" title="Supprimer">
                                        <svg class="icon" viewBox="0 0 24 24" width="16" height="16">
                                            <path fill="currentColor" d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"/>
                                        </svg>
                                        Supprimer
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <!-- Ville 4 : Nosy Be -->
                        <tr>
                            <td>
                                <div class="ville-info">
                                    <span class="ville-nom">Nosy Be</span>
                                    <span class="ville-code">NSB</span>
                                </div>
                            </td>
                            <td>Diana</td>
                            <td>
                                <span class="badge">6 besoins</span>
                            </td>
                            <td>
                                <span class="montant">180 000 000</span>
                                <span class="devise">Ar</span>
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <button class="action-btn edit-btn" title="Modifier">
                                        <svg class="icon" viewBox="0 0 24 24" width="16" height="16">
                                            <path fill="currentColor" d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/>
                                        </svg>
                                        Modifier
                                    </button>
                                    <button class="action-btn delete-btn" title="Supprimer">
                                        <svg class="icon" viewBox="0 0 24 24" width="16" height="16">
                                            <path fill="currentColor" d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"/>
                                        </svg>
                                        Supprimer
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- ========== LÉGENDE DOUCE ========== -->
            <div class="table-footer">
                <p><span class="dot"></span> 4 villes enregistrées · Mis à jour le 16 février 2026</p>
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