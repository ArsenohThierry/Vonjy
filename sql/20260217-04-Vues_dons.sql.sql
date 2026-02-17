
--vues pour les dons 
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
    p.id_categorie,
    c.nom_categorie,
    (d.quantite_don * p.pu) as montant_total
FROM don_vonjy d
INNER JOIN produit_vonjy p ON d.id_produit = p.id
INNER JOIN categorie_besoin_vonjy c ON p.id_categorie = c.id;

-- VUE 2 : Produits complets avec catégories
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

-- VUE 3 : Statistiques globales des dons
DROP VIEW IF EXISTS vue_statistiques_dons;
CREATE VIEW vue_statistiques_dons AS
SELECT 
    COUNT(*) as total_dons,
    COALESCE(SUM(d.quantite_don * p.pu), 0) as montant_total,
    COALESCE(SUM(d.quantite_don), 0) as quantite_totale
FROM don_vonjy d
LEFT JOIN produit_vonjy p ON d.id_produit = p.id;

-- VUE 4 : Statistiques par catégorie
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

-- VUE 5 : Dons récents (top 50)
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

-- ============================================================
-- PARTIE 3 : INSERTION DES DONNÉES DE TEST
-- ============================================================

-- Insertion des catégories
INSERT INTO categorie_besoin_vonjy (nom_categorie) VALUES
('Nature'),
('Matériau'),
('Argent'),
('Médical'),
('Alimentaire');

-- Insertion des produits
INSERT INTO produit_vonjy (nom_produit, pu, id_categorie) VALUES
-- Nature / Alimentaire
('Riz blanc (sac 50kg)', 45000, 5),
('Eau potable (pack 6x1.5L)', 4800, 5),
('Huile végétale (bidon 5L)', 35000, 5),
('Sucre (sac 50kg)', 42000, 5),

-- Matériau
('Tôles ondulées (2m x 1m)', 28000, 2),
('Sacs de ciment (50kg)', 32000, 2),
('Bâches imperméables (4m x 6m)', 18000, 2),

-- Médical
('Kit médical de base', 125000, 4),
('Antibiotiques (boîte)', 45000, 4),
('Antipaludiques (boîte)', 38000, 4),

-- Argent
('Don financier', 1, 3);

-- Insertion de dons de test
INSERT INTO don_vonjy (nom_donneur, id_produit, quantite_don, date_don) VALUES
-- Dons de nature/alimentaire
('UNICEF', 1, 500, '2026-02-15'),
('Croix-Rouge', 2, 1000, '2026-02-14'),
('PAM (Programme Alimentaire Mondial)', 3, 200, '2026-02-13'),
('CARE International', 4, 100, '2026-02-12'),

-- Dons de matériau
('ONG Habitat pour l\'Humanité', 5, 300, '2026-02-12'),
('Entreprises Solidaires', 6, 250, '2026-02-11'),
('Croix-Rouge', 7, 150, '2026-02-10'),

-- Dons médicaux
('OMS', 8, 50, '2026-02-08'),
('Médecins Sans Frontières', 9, 200, '2026-02-09'),
('Fondation Bill & Melinda Gates', 10, 180, '2026-02-07'),

-- Dons financiers
('Banque Mondiale', 11, 15000000, '2026-02-10'),
('Union Européenne', 11, 25000000, '2026-02-06'),
('Gouvernement Français', 11, 10000000, '2026-02-05');

