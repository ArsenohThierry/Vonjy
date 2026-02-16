CREATE OR REPLACE VIEW v_besoins_detail_vonjy AS
SELECT
    b.id AS id_besoin,

    r.id AS id_region,
    r.nom_region,

    v.id AS id_ville,
    v.nom_ville,

    c.id AS id_categorie,
    c.nom_categorie,

    p.id AS id_produit,
    p.nom_produit,

    b.quantite_besoin,
    p.pu,
    (b.quantite_besoin * p.pu) AS montant_estime,

    b.date_besoin

FROM besoin_ville_vonjy b
JOIN ville_vonjy v ON b.id_ville = v.id
JOIN region_vonjy r ON v.id_region = r.id
JOIN produit_vonjy p ON b.id_produit = p.id
JOIN categorie_besoin_vonjy c ON p.id_categorie = c.id;


SELECT
    id_ville,
    nom_ville,
    SUM(montant_estime) AS estimation_totale
FROM v_besoins_detail_vonjy
WHERE id_ville = 1
GROUP BY id_ville, nom_ville;

SELECT id_ville,nom_ville,SUM(montant_estime) AS estimation_totale FROM v_besoins_detail_vonjy WHERE id_ville = 1 GROUP BY id_ville, nom_ville;
--estimation totaale des besoins pour une ville

SELECT
    COALESCE(SUM(b.quantite_besoin * p.pu), 0) AS estimation_totale_besoins
FROM besoin_ville_vonjy b
JOIN produit_vonjy p ON b.id_produit = p.id;
--total de tous les besoins estimés

SELECT COALESCE(SUM(b.quantite_besoin * p.pu), 0) AS estimation_totale_besoins FROM besoin_ville_vonjy b JOIN produit_vonjy p ON b.id_produit = p.id;

SELECT
    v.id AS id_ville,
    v.nom_ville AS ville,
    r.nom_region AS region,
    COUNT(b.id) AS nombre_besoins,
    COALESCE(SUM(b.quantite_besoin * p.pu), 0) AS total_estime_ar
FROM ville_vonjy v
JOIN region_vonjy r ON v.id_region = r.id
LEFT JOIN besoin_ville_vonjy b ON v.id = b.id_ville
LEFT JOIN produit_vonjy p ON b.id_produit = p.id
GROUP BY v.id, v.nom_ville, r.nom_region
ORDER BY total_estime_ar DESC;
--pour avoir le detail des villes necessaire dans villes.php