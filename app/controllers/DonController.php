<?php

namespace app\controllers;

use app\models\Don;
use app\models\Produit;
use app\models\Categorie;
use flight\Engine;

class DonController {

    protected Engine $app;
    protected Don $donModel;
    protected Produit $produitModel;
    protected Categorie $categorieModel;

    public function __construct(Engine $app) {
        $this->app = $app;
        $this->donModel = new Don($app->db());
        $this->produitModel = new Produit($app->db());
        $this->categorieModel = new Categorie($app->db());
    }

    // Afficher la liste des dons
    public function index() {
        // Récupérer les données
        $dons = $this->donModel->getAll();
        $statistics = $this->donModel->getStatistics();
        $statsByCategory = $this->donModel->getStatisticsByCategory();
        $produits = $this->produitModel->getAll();
        $categories = $this->categorieModel->getAll();
        
        // Préparer les données pour la vue
        $data = [
            'dons' => $dons,
            'total_dons' => $statistics['total_dons'] ?? 0,
            'montant_total' => $statistics['montant_total'] ?? 0,
            'stats_by_category' => $statsByCategory,
            'produits' => $produits,
            'categories' => $categories
        ];
        
        // Rendre la vue
        $this->app->render('dons', $data);
    }

    // Afficher le formulaire d'ajout de don    // Route: GET /add-don
    public function showAddForm() {
        // Récupérer les produits et catégories pour les dropdowns
        $produits = $this->produitModel->getAll();
        $categories = $this->categorieModel->getAll();
        
        $data = [
            'produits' => $produits,
            'categories' => $categories
        ];
        
        $this->app->render('add-don', $data);
    }

    // Traiter l'ajout d'un don    // Route: POST /add-don
    public function store() {
        // Récupérer les données du formulaire
        $nomDonneur = $this->app->request()->data->nom_donneur ?? '';
        $idProduit = (int) ($this->app->request()->data->id_produit ?? 0);
        $quantiteDon = (int) ($this->app->request()->data->quantite_don ?? 0);
        $dateDon = $this->app->request()->data->date_don ?? date('Y-m-d');
        
        // Validation simple
        if (empty($nomDonneur) || $idProduit <= 0 || $quantiteDon <= 0) {
            $this->app->json([
                'success' => false,
                'message' => 'Tous les champs requis doivent être remplis'
            ], 400);
            return;
        }
        
        // Insérer le don
        try {
            $donId = $this->donModel->create($nomDonneur, $idProduit, $quantiteDon, $dateDon);
            
            $this->app->json([
                'success' => true,
                'message' => 'Don ajouté avec succès',
                'id' => $donId
            ]);
        } catch (\Exception $e) {
            $this->app->json([
                'success' => false,
                'message' => 'Erreur lors de l\'ajout du don: ' . $e->getMessage()
            ], 500);
        }
    }

    // Afficher le formulaire d'ajout de produit --- Route: GET /add-produit
    public function showAddProduitForm() {
        $categories = $this->categorieModel->getAll();
        
        $data = [
            'categories' => $categories
        ];
        
        $this->app->render('add-produit', $data);
    }

    // Traiter l'ajout d'un produit    // Route: POST /add-produit
    public function storeProduit() {
        // Récupérer les données du formulaire
        $nomProduit = $this->app->request()->data->nom_produit ?? '';
        $pu = (float) ($this->app->request()->data->pu ?? 0);
        $idCategorie = (int) ($this->app->request()->data->id_categorie ?? 0);
        
        // Validation simple
        if (empty($nomProduit) || $pu < 0 || $idCategorie <= 0) {
            $this->app->json([
                'success' => false,
                'message' => 'Tous les champs requis doivent être remplis correctement'
            ], 400);
            return;
        }
        
        // Insérer le produit
        try {
            $produitId = $this->produitModel->create($nomProduit, $pu, $idCategorie);
            
            $this->app->json([
                'success' => true,
                'message' => 'Produit ajouté avec succès',
                'id' => $produitId
            ]);
        } catch (\Exception $e) {
            $this->app->json([
                'success' => false,
                'message' => 'Erreur lors de l\'ajout du produit: ' . $e->getMessage()
            ], 500);
        }
    }

    // Afficher la liste des catégories
    public function showCategories() {
        $categories = $this->categorieModel->getAll();
        
        $data = [
            'categories' => $categories
        ];
        
        $this->app->render('categorie', $data);
    }

    // API pour ajouter une catégorie (POST /api/categorie)
    public function storeCategorie() {
        // Récupérer les données du formulaire
        $nomCategorie = $this->app->request()->data->nom_categorie ?? '';
        
        // Validation simple
        if (empty($nomCategorie)) {
            header('Content-Type: application/json');
            http_response_code(400);
            echo json_encode([
                'success' => false,
                'message' => 'Le nom de la catégorie est requis'
            ]);
            return;
        }
        
        // Vérifier si la catégorie existe déjà
        if ($this->categorieModel->existsByName($nomCategorie)) {
            header('Content-Type: application/json');
            http_response_code(400);
            echo json_encode([
                'success' => false,
                'message' => 'Cette catégorie existe déjà'
            ]);
            return;
        }
        
        // Insérer la catégorie
        try {
            $categorieId = $this->categorieModel->create($nomCategorie);
            $categorie = $this->categorieModel->getById($categorieId);
            
            header('Content-Type: application/json');
            http_response_code(200);
            echo json_encode([
                'success' => true,
                'message' => 'Catégorie ajoutée avec succès',
                'categorie' => $categorie
            ]);
        } catch (\Exception $e) {
            header('Content-Type: application/json');
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'message' => 'Erreur lors de l\'ajout de la catégorie: ' . $e->getMessage()
            ]);
        }
    }

    //api pour récupérer tous les produits (GET /api/produits)
    public function getProduits() {
        $produits = $this->produitModel->getAll();
        header('Content-Type: application/json');
        http_response_code(200);
        echo json_encode([
            'success' => true,
            'produits' => $produits
        ]);
    }

    //api pour récupérer toutes les catégories (GET /api/categories)
    public function getCategories() {
        $categories = $this->categorieModel->getAll();
        header('Content-Type: application/json');
        http_response_code(200);
        echo json_encode([
            'success' => true,
            'categories' => $categories
        ]);
    }
    
    //suppression categorie (api) -- route DELETE /api/categorie/@id:[0-9]+
    public function deleteCategorie(int $id) {
        try {
            // Vérifier si la catégorie existe
            $categorie = $this->categorieModel->getById($id);
            if (!$categorie) {
                header('Content-Type: application/json');
                http_response_code(404);
                echo json_encode([
                    'success' => false,
                    'message' => 'Catégorie introuvable'
                ]);
                return;
            }
            
            // Vérifier si la catégorie est utilisée dans des produits
            $countProduits = $this->produitModel->countByCategorie($id);
            if ($countProduits > 0) {
                header('Content-Type: application/json');
                http_response_code(400);
                echo json_encode([
                    'success' => false,
                    'message' => "Impossible de supprimer cette catégorie car elle est utilisée par {$countProduits} produit(s). Veuillez d'abord supprimer les produits associés."
                ]);
                return;
            }
            
            // Supprimer la catégorie
            $this->categorieModel->delete($id);
            
            header('Content-Type: application/json');
            http_response_code(200);
            echo json_encode([
                'success' => true,
                'message' => 'Catégorie supprimée avec succès'
            ]);
        } catch (\Exception $e) {
            header('Content-Type: application/json');
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'message' => 'Erreur lors de la suppression: ' . $e->getMessage()
            ]);
        }
    }
    
    /**
     * Afficher la liste des produits
     * Route: GET /produits
     */
    public function showProduits() {
        $produits = $this->produitModel->getAll();
        $categories = $this->categorieModel->getAll();
        
        $data = [
            'produits' => $produits,
            'categories' => $categories
        ];
        
        $this->app->render('produits', $data);
    }
    
    /**
     * Récupérer un produit par ID (API)
     * Route: GET /api/produit/:id
     */
    public function getProduit(int $id) {
        try {
            $produit = $this->produitModel->getById($id);
            
            if (!$produit) {
                header('Content-Type: application/json');
                http_response_code(404);
                echo json_encode([
                    'success' => false,
                    'message' => 'Produit introuvable'
                ]);
                return;
            }
            
            header('Content-Type: application/json');
            http_response_code(200);
            echo json_encode([
                'success' => true,
                'produit' => $produit
            ]);
        } catch (\Exception $e) {
            header('Content-Type: application/json');
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'message' => 'Erreur: ' . $e->getMessage()
            ]);
        }
    }
    
    /**
     * Mettre à jour un produit (API)
     * Route: POST /api/produit/:id/update
     */
    public function updateProduit(int $id) {
        try {
            // Récupérer les données POST ou JSON
            $nomProduit = $this->app->request()->data->nom_produit ?? '';
            $pu = $this->app->request()->data->pu ?? 0;
            $idCategorie = $this->app->request()->data->id_categorie ?? 0;
            
            // Validation
            if (empty($nomProduit) || $pu <= 0 || $idCategorie <= 0) {
                header('Content-Type: application/json');
                http_response_code(400);
                echo json_encode([
                    'success' => false,
                    'message' => 'Données invalides',
                    'debug' => [
                        'nom_produit' => $nomProduit,
                        'pu' => $pu,
                        'id_categorie' => $idCategorie
                    ]
                ]);
                return;
            }
            
            // Vérifier que le produit existe
            $produit = $this->produitModel->getById($id);
            if (!$produit) {
                header('Content-Type: application/json');
                http_response_code(404);
                echo json_encode([
                    'success' => false,
                    'message' => 'Produit introuvable'
                ]);
                return;
            }
            
            // Mettre à jour
            $this->produitModel->update($id, $nomProduit, (float)$pu, (int)$idCategorie);
            
            header('Content-Type: application/json');
            http_response_code(200);
            echo json_encode([
                'success' => true,
                'message' => 'Produit modifié avec succès'
            ]);
        } catch (\Exception $e) {
            header('Content-Type: application/json');
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'message' => 'Erreur: ' . $e->getMessage()
            ]);
        }
    }
    
    /**
     * Supprimer un produit (API)
     * Route: DELETE /api/produit/:id
     */
    public function deleteProduit(int $id) {
        try {
            // Vérifier si le produit existe
            $produit = $this->produitModel->getById($id);
            if (!$produit) {
                header('Content-Type: application/json');
                http_response_code(404);
                echo json_encode([
                    'success' => false,
                    'message' => 'Produit introuvable'
                ]);
                return;
            }
            
            // Vérifier si le produit est utilisé dans des dons
            $countDons = $this->donModel->countByProduit($id);
            if ($countDons > 0) {
                header('Content-Type: application/json');
                http_response_code(400);
                echo json_encode([
                    'success' => false,
                    'message' => "Impossible de supprimer ce produit car il est utilisé dans {$countDons} don(s). Veuillez d'abord supprimer les dons associés."
                ]);
                return;
            }
            
            // Supprimer le produit
            $this->produitModel->delete($id);
            
            header('Content-Type: application/json');
            http_response_code(200);
            echo json_encode([
                'success' => true,
                'message' => 'Produit supprimé avec succès'
            ]);
        } catch (\Exception $e) {
            header('Content-Type: application/json');
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'message' => 'Erreur lors de la suppression: ' . $e->getMessage()
            ]);
        }
    }

    // API: Récupérer un don par ID
    // Route: GET /api/don/:id
    public function getDon($id) {
        try {
            $don = $this->donModel->getById($id);
            
            if (!$don) {
                header('Content-Type: application/json');
                http_response_code(404);
                echo json_encode([
                    'success' => false,
                    'message' => 'Don non trouvé'
                ]);
                return;
            }
            
            header('Content-Type: application/json');
            http_response_code(200);
            echo json_encode([
                'success' => true,
                'don' => $don
            ]);
        } catch (\Exception $e) {
            header('Content-Type: application/json');
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'message' => 'Erreur lors de la récupération: ' . $e->getMessage()
            ]);
        }
    }

    // API: Modifier un don
    // Route: POST /api/don/:id/update
    public function updateDon($id) {
        try {
            // Récupérer les données du formulaire
            $data = $this->app->request()->data;
            
            // Validation
            if (empty($data->id_produit) || empty($data->nom_donneur) || 
                empty($data->quantite) || empty($data->date_don)) {
                header('Content-Type: application/json');
                http_response_code(400);
                echo json_encode([
                    'success' => false,
                    'message' => 'Tous les champs sont obligatoires'
                ]);
                return;
            }
            
            // Vérifier que le don existe
            $existingDon = $this->donModel->getById($id);
            if (!$existingDon) {
                header('Content-Type: application/json');
                http_response_code(404);
                echo json_encode([
                    'success' => false,
                    'message' => 'Don non trouvé'
                ]);
                return;
            }
            
            // Mettre à jour le don
            $this->donModel->update($id, [
                'id_produit' => $data->id_produit,
                'nom_donneur' => $data->nom_donneur,
                'quantite' => $data->quantite,
                'date_don' => $data->date_don
            ]);
            
            header('Content-Type: application/json');
            http_response_code(200);
            echo json_encode([
                'success' => true,
                'message' => 'Don modifié avec succès'
            ]);
        } catch (\Exception $e) {
            header('Content-Type: application/json');
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'message' => 'Erreur lors de la modification: ' . $e->getMessage()
            ]);
        }
    }

    // API: Supprimer un don
    // Route: DELETE /api/don/:id
    public function deleteDon($id) {
        try {
            // Vérifier que le don existe
            $don = $this->donModel->getById($id);
            if (!$don) {
                header('Content-Type: application/json');
                http_response_code(404);
                echo json_encode([
                    'success' => false,
                    'message' => 'Don non trouvé'
                ]);
                return;
            }
            
            // Supprimer le don (pas de contraintes de clé étrangère sur don_vonjy)
            $this->donModel->delete($id);
            
            header('Content-Type: application/json');
            http_response_code(200);
            echo json_encode([
                'success' => true,
                'message' => 'Don supprimé avec succès'
            ]);
        } catch (\Exception $e) {
            header('Content-Type: application/json');
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'message' => 'Erreur lors de la suppression: ' . $e->getMessage()
            ]);
        }
    }
}
