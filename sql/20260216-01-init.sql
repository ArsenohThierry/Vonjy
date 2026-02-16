create database vonjy;
use vonjy;


create table region_vonjy(
    id INT PRIMARY KEY AUTO_INCREMENT,
    nom_region VARCHAR(50) NOT NULL
);

create table ville_vonjy(
    id INT PRIMARY KEY AUTO_INCREMENT,
    nom_ville VARCHAR(50) NOT NULL,
    nombre_sinistre INT NOT NULL,
    id_region INT NOT NULL,

    FOREIGN KEY (id_region) REFERENCES region_vonjy(id)
);

create table categorie_besoin_vonjy(
    id INT PRIMARY KEY AUTO_INCREMENT,
    nom_categorie VARCHAR(50) NOT NULL

);-- exemple : Nature , Materiaux , Argent

create table produit_vonjy(
    id INT PRIMARY KEY AUTO_INCREMENT,
    nom_produit VARCHAR(50) NOT NULL,
    pu DECIMAL(10,2),
    id_categorie INT NOT NULL,
    FOREIGN KEY (id_categorie) REFERENCES categorie_besoin_vonjy(id)
);-- exemple : Eau , Riz , Argent

create table besoin_ville_vonjy(
    id INT PRIMARY KEY AUTO_INCREMENT,
    id_ville INT,
    id_produit INT,
    quantite_besoin INT NOT NULL,
    date_besoin timestamp NOT NULL,

    FOREIGN KEY (id_ville) REFERENCES ville_vonjy(id),
    FOREIGN KEY (id_produit) REFERENCES produit_vonjy(id)
);-- exemple : 1000 litres d'eau , 500 kg de riz , 2000 Ar

create table don_vonjy(
    id INT PRIMARY KEY AUTO_INCREMENT,
    nom_donneur VARCHAR(100),
    id_produit INT,
    quantite_don INT NOT NULL,
    date_don DATE NOT NULL,

    FOREIGN KEY (id_produit) REFERENCES produit_vonjy(id)
);-- exemple : 500 litres d'eau , 200 kg de riz , 1000 Ar