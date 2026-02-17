-- Table pour enregistrer la distribution réelle des dons aux besoins
CREATE TABLE IF NOT EXISTS allocation_don_vonjy (
    id INT PRIMARY KEY AUTO_INCREMENT,
    id_besoin INT NOT NULL,
    id_produit INT NOT NULL,
    id_ville INT NOT NULL,
    quantite_attribuee INT NOT NULL,
    date_allocation TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (id_besoin) REFERENCES besoin_ville_vonjy(id),
    FOREIGN KEY (id_produit) REFERENCES produit_vonjy(id),
    FOREIGN KEY (id_ville) REFERENCES ville_vonjy(id)
);
