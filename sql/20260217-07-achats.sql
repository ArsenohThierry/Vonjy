-- Table de configuration (clé-valeur)
CREATE TABLE IF NOT EXISTS config_vonjy (
    cle VARCHAR(50) PRIMARY KEY,
    valeur VARCHAR(255) NOT NULL,
    description VARCHAR(255)
);

-- Insérer le frais d'achat par défaut (10%)
INSERT INTO config_vonjy (cle, valeur, description) VALUES 
('frais_achat_pourcent', '10', 'Pourcentage de frais sur les achats (ex: 10 = 10%)');

-- Table des achats (achat de besoins via dons argent)
CREATE TABLE IF NOT EXISTS achat_vonjy (
    id INT PRIMARY KEY AUTO_INCREMENT,
    id_besoin INT NOT NULL,
    id_produit INT NOT NULL,
    id_ville INT NOT NULL,
    quantite_achetee INT NOT NULL,
    prix_unitaire DECIMAL(15,2) NOT NULL,
    frais_pourcent DECIMAL(5,2) NOT NULL,
    montant_ht DECIMAL(15,2) NOT NULL,
    montant_frais DECIMAL(15,2) NOT NULL,
    montant_total DECIMAL(15,2) NOT NULL,
    date_achat TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (id_besoin) REFERENCES besoin_ville_vonjy(id),
    FOREIGN KEY (id_produit) REFERENCES produit_vonjy(id),
    FOREIGN KEY (id_ville) REFERENCES ville_vonjy(id)
);
