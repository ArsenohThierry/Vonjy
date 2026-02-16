<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.5">
    <title>BNGRC · Ajouter une ville</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/style-ville-form.css">
</head>
<body>
    <!-- ========== LAYOUT PRINCIPAL AVEC MENU LATERAL ========== -->
    <?php $activePage = 'villes'; ?>
    <div class="app-container">
        <!-- ========== MENU DE NAVIGATION GAUCHE ========== -->
        <?php include('partials/sidebar.php'); ?>

        <!-- ========== CONTENU PRINCIPAL ========== -->
        <main class="main-content">
            <!-- Header avec titre et bouton de retour -->
            <header class="content-header">
                <div class="title-with-back">
                    <a href="villes.html" class="back-link">
                        <svg class="back-icon" viewBox="0 0 24 24" width="20" height="20">
                            <path fill="currentColor" d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"/>
                        </svg>
                        Retour aux villes
                    </a>
                    <h1 class="page-title">Ajouter une ville</h1>
                </div>
                <div class="header-actions">
                    <span class="date-indicator">Nouvelle localité</span>
                </div>
            </header>

            <!-- ========== FORMULAIRE D'AJOUT DE VILLE ========== -->
            <div class="form-container">
                <form class="ville-form" action="#" method="post">
                    <!-- Section informations générales -->
                    <div class="form-section">
                        <h2 class="form-section-title">
                            <svg class="section-icon" viewBox="0 0 24 24" width="20" height="20">
                                <path fill="currentColor" d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
                            </svg>
                            Informations générales
                        </h2>
                        <div class="form-grid">
                            <!-- Nom de la ville -->
                            <div class="form-group">
                                <label for="nom-ville" class="form-label">
                                    Nom de la ville
                                    <span class="required">*</span>
                                </label>
                                <input type="text" id="nom-ville" name="nom_ville" class="form-input" placeholder="ex: Ambositra" required>
                                <span class="form-hint">Nom officiel de la localité</span>
                            </div>

                            <!-- Code ville -->
                            <div class="form-group">
                                <label for="code-ville" class="form-label">
                                    Code ville
                                    <span class="required">*</span>
                                </label>
                                <input type="text" id="code-ville" name="code_ville" class="form-input" placeholder="ex: AMB" maxlength="5" required>
                                <span class="form-hint">3 à 5 caractères majuscules</span>
                            </div>

                            <!-- Région -->
                            <div class="form-group">
                                <label for="region" class="form-label">
                                    Région
                                    <span class="required">*</span>
                                </label>
                                <select id="region" name="region" class="form-select" required>
                                    <option value="" disabled selected>Choisir une région</option>
                                    <option value="Amoron'i Mania">Amoron'i Mania</option>
                                    <option value="Analamanga">Analamanga</option>
                                    <option value="Anosy">Anosy</option>
                                    <option value="Atsimo-Andrefana">Atsimo-Andrefana</option>
                                    <option value="Atsinanana">Atsinanana</option>
                                    <option value="Diana">Diana</option>
                                    <option value="Menabe">Menabe</option>
                                    <option value="Vakinankaratra">Vakinankaratra</option>
                                </select>
                            </div>

                            <!-- District -->
                            <div class="form-group">
                                <label for="district" class="form-label">District</label>
                                <input type="text" id="district" name="district" class="form-input" placeholder="ex: Ambositra">
                                <span class="form-hint">Optionnel</span>
                            </div>
                        </div>
                    </div>

                    <!-- Section coordonnées géographiques -->
                    <div class="form-section">
                        <h2 class="form-section-title">
                            <svg class="section-icon" viewBox="0 0 24 24" width="20" height="20">
                                <path fill="currentColor" d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
                            </svg>
                            Coordonnées géographiques
                        </h2>
                        <div class="form-grid">
                            <!-- Latitude -->
                            <div class="form-group">
                                <label for="latitude" class="form-label">Latitude</label>
                                <input type="text" id="latitude" name="latitude" class="form-input" placeholder="ex: -20.5307">
                                <span class="form-hint">Format décimal (ex: -20.5307)</span>
                            </div>

                            <!-- Longitude -->
                            <div class="form-group">
                                <label for="longitude" class="form-label">Longitude</label>
                                <input type="text" id="longitude" name="longitude" class="form-input" placeholder="ex: 47.2465">
                                <span class="form-hint">Format décimal (ex: 47.2465)</span>
                            </div>

                            <!-- Altitude -->
                            <div class="form-group">
                                <label for="altitude" class="form-label">Altitude (m)</label>
                                <input type="number" id="altitude" name="altitude" class="form-input" placeholder="ex: 1200">
                            </div>

                            <!-- Superficie -->
                            <div class="form-group">
                                <label for="superficie" class="form-label">Superficie (km²)</label>
                                <input type="number" id="superficie" name="superficie" class="form-input" placeholder="ex: 250" step="0.1">
                            </div>
                        </div>
                    </div>

                    <!-- Section données démographiques -->
                    <div class="form-section">
                        <h2 class="form-section-title">
                            <svg class="section-icon" viewBox="0 0 24 24" width="20" height="20">
                                <path fill="currentColor" d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-1 .05 1.16.84 2 1.87 2 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"/>
                            </svg>
                            Données démographiques
                        </h2>
                        <div class="form-grid">
                            <!-- Population totale -->
                            <div class="form-group">
                                <label for="population" class="form-label">Population totale</label>
                                <input type="number" id="population" name="population" class="form-input" placeholder="ex: 50000">
                            </div>

                            <!-- Population sinistrée -->
                            <div class="form-group">
                                <label for="population-sinistree" class="form-label">Population sinistrée</label>
                                <input type="number" id="population-sinistree" name="population_sinistree" class="form-input" placeholder="ex: 12500">
                            </div>

                            <!-- Nombre de ménages -->
                            <div class="form-group">
                                <label for="menages" class="form-label">Nombre de ménages</label>
                                <input type="number" id="menages" name="menages" class="form-input" placeholder="ex: 10000">
                            </div>

                            <!-- Densité -->
                            <div class="form-group">
                                <label for="densite" class="form-label">Densité (hab/km²)</label>
                                <input type="number" id="densite" name="densite" class="form-input" placeholder="Calculé automatiquement" readonly disabled>
                                <span class="form-hint">Calculé automatiquement</span>
                            </div>
                        </div>
                    </div>

                    <!-- Section contact local -->
                    <div class="form-section">
                        <h2 class="form-section-title">
                            <svg class="section-icon" viewBox="0 0 24 24" width="20" height="20">
                                <path fill="currentColor" d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/>
                            </svg>
                            Contact local
                        </h2>
                        <div class="form-grid">
                            <!-- Personne responsable -->
                            <div class="form-group">
                                <label for="responsable" class="form-label">Personne responsable</label>
                                <input type="text" id="responsable" name="responsable" class="form-input" placeholder="ex: Dr. Rakotoarisoa">
                            </div>

                            <!-- Téléphone -->
                            <div class="form-group">
                                <label for="telephone" class="form-label">Téléphone</label>
                                <input type="tel" id="telephone" name="telephone" class="form-input" placeholder="ex: 034 12 345 67">
                            </div>

                            <!-- Email -->
                            <div class="form-group">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" id="email" name="email" class="form-input" placeholder="ex: contact@ville.gov.mg">
                            </div>
                        </div>
                    </div>

                    <!-- Section notes -->
                    <div class="form-section">
                        <h2 class="form-section-title">
                            <svg class="section-icon" viewBox="0 0 24 24" width="20" height="20">
                                <path fill="currentColor" d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/>
                            </svg>
                            Notes additionnelles
                        </h2>
                        <div class="form-group">
                            <textarea id="notes" name="notes" class="form-textarea" rows="4" placeholder="Informations complémentaires sur la ville..."></textarea>
                        </div>
                    </div>

                    <!-- Boutons d'action -->
                    <div class="form-actions">
                        <button type="button" class="btn btn-secondary" onclick="window.location.href='villes.html'">Annuler</button>
                        <button type="submit" class="btn btn-primary">Ajouter la ville</button>
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