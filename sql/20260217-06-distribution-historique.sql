-- Table historique des distributions
CREATE TABLE IF NOT EXISTS distribution_historique_vonjy (
    id INT PRIMARY KEY AUTO_INCREMENT,
    date_distribution TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    total_dons_disponibles DECIMAL(15,2) NOT NULL,
    total_attribue DECIMAL(15,2) NOT NULL,
    nb_allocations INT NOT NULL,
    nb_besoins_couverts INT NOT NULL,
    nb_besoins_partiels INT NOT NULL,
    commentaire VARCHAR(255)
);
