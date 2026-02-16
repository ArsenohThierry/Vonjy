-- Script de création des vues SQL pour optimiser les requêtes
-- À exécuter après l'initialisation de la base de données

USE vonjy;

-- ========================================
-- VUE 1 : Dons complets avec produits et catégories
-- ========================================
-- Cette vue joint les tables don_vonjy, produit_vonjy et categorie_besoin_vonjy
-- pour obtenir toutes les informations nécessaires sur les dons
DROP VIEW IF EXISTS vue_dons_complets;
CREATE VIEW vue_dons_complets AS
SELECT 
    d.id,
    d.nom_donneur,
    d.quantite_don,
    d.date_don,
    d.id_produit,
    p.nom_produit,
    p.pu,
    c.id_categorie,
    c.nom_categorie,
    (d.quantite_don * p.pu) as montant_total
FROM don_vonjy d
INNER JOIN produit_vonjy p ON d.id_produit = p.id
INNER JOIN categorie_besoin_vonjy c ON p.id_categorie = c.id;

-- ========================================
-- VUE 2 : Produits complets avec catégories
-- ========================================
-- Cette vue joint les tables produit_vonjy et categorie_besoin_vonjy
DROP VIEW IF EXISTS vue_produits_complets;
CREATE VIEW vue_produits_complets AS
SELECT 
    p.id,
    p.nom_produit,
    p.pu,
    p.id_categorie,
    c.nom_categorie
FROM produit_vonjy p
INNER JOIN categorie_besoin_vonjy c ON p.id_categorie = c.id;

-- ========================================
-- VUE 3 : Statistiques globales des dons
-- ========================================
-- Cette vue calcule le nombre total de dons et le montant total
DROP VIEW IF EXISTS vue_statistiques_dons;
CREATE VIEW vue_statistiques_dons AS
SELECT 
    COUNT(*) as total_dons,
    COALESCE(SUM(d.quantite_don * p.pu), 0) as montant_total,
    COALESCE(SUM(d.quantite_don), 0) as quantite_totale
FROM don_vonjy d
LEFT JOIN produit_vonjy p ON d.id_produit = p.id;

-- ========================================
-- VUE 4 : Statistiques par catégorie
-- ========================================
-- Cette vue regroupe les dons par catégorie avec les statistiques
DROP VIEW IF EXISTS vue_statistiques_par_categorie;
CREATE VIEW vue_statistiques_par_categorie AS
SELECT 
    c.id as id_categorie,
    c.nom_categorie,
    COUNT(d.id) as nombre_dons,
    COALESCE(SUM(d.quantite_don), 0) as quantite_totale,
    COALESCE(SUM(d.quantite_don * p.pu), 0) as montant_total
FROM categorie_besoin_vonjy c
LEFT JOIN produit_vonjy p ON c.id = p.id_categorie
LEFT JOIN don_vonjy d ON p.id = d.id_produit
GROUP BY c.id, c.nom_categorie;

-- ========================================
-- VUE 5 : Dons récents (top 50)
-- ========================================
-- Cette vue affiche les 50 dons les plus récents
DROP VIEW IF EXISTS vue_dons_recents;
CREATE VIEW vue_dons_recents AS
SELECT 
    d.id,
    d.nom_donneur,
    d.quantite_don,
    d.date_don,
    p.nom_produit,
    p.pu,
    c.nom_categorie,
    (d.quantite_don * p.pu) as montant_total
FROM don_vonjy d
INNER JOIN produit_vonjy p ON d.id_produit = p.id
INNER JOIN categorie_besoin_vonjy c ON p.id_categorie = c.id
ORDER BY d.date_don DESC, d.id DESC
LIMIT 50;

-- Vérification des vues créées
SHOW FULL TABLES WHERE Table_type = 'VIEW';

-- Test des vues
SELECT 'Contenu de vue_dons_complets:' as Info;
SELECT * FROM vue_dons_complets LIMIT 5;

SELECT 'Contenu de vue_statistiques_dons:' as Info;
SELECT * FROM vue_statistiques_dons;

SELECT 'Contenu de vue_statistiques_par_categorie:' as Info;
SELECT * FROM vue_statistiques_par_categorie;

SELECT 'Contenu de vue_produits_complets:' as Info;
SELECT * FROM vue_produits_complets LIMIT 5;
