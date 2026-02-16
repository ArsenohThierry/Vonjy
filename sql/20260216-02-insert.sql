-- Script d'insertion de données de test pour le module Dons
-- À exécuter après avoir créé la base de données avec 20260216-01-init.sql

USE vonjy;

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
('UNICEF', 1, 500, '2026-02-15'),    -- Riz blanc
('Croix-Rouge', 2, 1000, '2026-02-14'), -- Eau potable
('PAM (Programme Alimentaire Mondial)', 3, 200, '2026-02-13'), -- Huile
('CARE International', 4, 100, '2026-02-12'), -- Sucre

-- Dons de matériau
('ONG Habitat pour l\'Humanité', 5, 300, '2026-02-12'), -- Tôles
('Entreprises Solidaires', 6, 250, '2026-02-11'), -- Ciment
('Croix-Rouge', 7, 150, '2026-02-10'), -- Bâches

-- Dons médicaux
('OMS', 8, 50, '2026-02-08'), -- Kits médicaux
('Médecins Sans Frontières', 9, 200, '2026-02-09'), -- Antibiotiques
('Fondation Bill & Melinda Gates', 10, 180, '2026-02-07'), -- Antipaludiques

-- Dons financiers
('Banque Mondiale', 11, 15000000, '2026-02-10'), -- 15 millions Ar
('Union Européenne', 11, 25000000, '2026-02-06'), -- 25 millions Ar
('Gouvernement Français', 11, 10000000, '2026-02-05'); -- 10 millions Ar

-- Vérification des données insérées
SELECT 'Catégories insérées:' as Info;
SELECT * FROM categorie_besoin_vonjy;

SELECT 'Produits insérés:' as Info;
SELECT p.id, p.nom_produit, p.pu, c.nom_categorie 
FROM produit_vonjy p 
INNER JOIN categorie_besoin_vonjy c ON p.id_categorie = c.id;

SELECT 'Dons insérés:' as Info;
SELECT d.id, d.nom_donneur, p.nom_produit, d.quantite_don, d.date_don,
       (d.quantite_don * p.pu) as montant_total
FROM don_vonjy d
INNER JOIN produit_vonjy p ON d.id_produit = p.id
ORDER BY d.date_don DESC;

SELECT 'Statistiques globales:' as Info;
SELECT 
    COUNT(*) as total_dons,
    SUM(d.quantite_don * p.pu) as montant_total_ar
FROM don_vonjy d
INNER JOIN produit_vonjy p ON d.id_produit = p.id;
