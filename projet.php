<?php 
session_start();
    include("./header.php");
    
    $sql = "SELECT `nom` FROM `projets` where id_projet=${_GET['projet']} and id_user=${_SESSION['id']}";
    $requete = $bdd->query($sql);
    $documents = $requete->fetch();
    if(empty($documents)) header("Location: acceuilCompte.php")
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<h2 align="center">Projet: <?php  echo $documents['nom'] ?></h2>
<div style="display: flex;border: 4px solid black;height: 1000px;text-align: center">
        <div style="border: 4px solid black;height: 500px;width: 500px;">
            <div style="overflow: auto;height: 450px;">
                <table>
                    <thead>
                        <h3>Documents/Fichiers</h3>
                    </thead>
                    <th style="width: 350px" align="left">Nom</th>
                    <th align="left">Date d'Envoie</th>
                    <?php
                        $sql = "SELECT `nom`, `date_envoi`, `date_envoi` FROM `documents` where id_user=${_SESSION['id']} and id_projet=${_GET['projet']}";
                        $requete = $bdd->query($sql);
                        $fichiers = $requete->fetchall();
                        foreach($fichiers as $fichier):
                    ?>
                    <tr>
                        <td align="left"><a href=""><?php echo $fichier["nom"] ?></a></td>
                        <td align="left"><a href=""><?php echo $fichier["date_envoi"] ?></a></td>
                    </tr>
                    <?php  
                        endforeach   
                    ?>
                </table>
            </div>
            
            <div style="position: relative; top: 20px;">
                <table>
                    <tr>
                        <form action="">
                            <input type="submit" value="Ajouter">
                        </form>
                        <a href="importer_fichier.php?projet=<?php echo $documents['nom'] ?>">Importer Fichier</a>
                    </tr>
                </table>
                
                
            </div>
        </div>
        <div style="border: 4px solid black;height: 500px;width: 500px">

        </div>
    </div>
</body>
</html>

