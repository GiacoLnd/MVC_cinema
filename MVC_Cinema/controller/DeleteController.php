<?php

namespace Controller;
use Model\Connect;

class DeleteController {
    public function deleteGenre($id){
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $id = $_POST["id"];

            $pdo = Connect::seConnecter();
            $requete = $pdo->prepare("DELETE FROM genre WHERE id_genre = :id");
            $requete->execute(["id" => $id]);
        
            if ($requete->rowCount() > 0) {
                echo json_encode(['success' => true, 'message' => 'Donnée supprimée avec succès.']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Aucune donnée trouvée avec cet ID.']);
            }
        }
    }
}