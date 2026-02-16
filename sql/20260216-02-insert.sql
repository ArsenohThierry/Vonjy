INSERT INTO region_vonjy (nom_region) VALUES
('Analamanga'),
('Atsinanana'),
('Haute Matsiatra'),
('Boeny'),
('Anosy');


INSERT INTO ville_vonjy (nom_ville, nombre_sinistre, id_region) VALUES
('Antananarivo', 120, 1),
('Toamasina', 80, 2),
('Fianarantsoa', 45, 3),
('Mahajanga', 60, 4),
('Fort-Dauphin', 30, 5);

INSERT INTO categorie_besoin_vonjy (nom_categorie) VALUES
('Nature'),
('Materiaux'),
('Argent');

INSERT INTO produit_vonjy (nom_produit, pu, id_categorie) VALUES
('Eau (litre)', 1000.00, 1),
('Riz (kg)', 2500.00, 1),
('Huile (litre)', 8000.00, 1),
('Tente', 150000.00, 2),
('Couverture', 30000.00, 2),
('Argent (Ar)', 1.00, 3);

INSERT INTO besoin_ville_vonjy 
(id_ville, id_produit, quantite_besoin, date_besoin) VALUES
(1, 1, 5000, NOW()),
(1, 2, 2000, NOW()),
(2, 1, 3000, NOW()),
(2, 4, 100, NOW()),
(3, 2, 1500, NOW()),
(3, 5, 300, NOW()),
(4, 3, 1000, NOW()),
(4, 6, 2000000, NOW()),
(5, 1, 2500, NOW()),
(5, 4, 80, NOW());
