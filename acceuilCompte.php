<?php 
session_start();
//INSERT INTO `projets`(`nom`, `id_user`) VALUES ('abc','2')
    if(!isset($_SESSION['id'])){
        header("Location: acceuil.php");
        session_destroy();
    }
    include("./header.php")
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div style="display: flex;border: 4px solid black;height: 1000px;text-align: center">
        <div style="border: 4px solid black;height: 500px;width: 500px;">
            <div style="overflow: auto;height: 450px;">
                <table>
                    <thead>
                        <h3>Mes Projets</h3>
                    </thead>
                    <th style="width: 350px" align="left">Nom</th>
                    <th align="left">Date de Creation</th>
                    <?php
                        $sql = "SELECT `nom`, `date_creation`,`id_projet` FROM `projets` where id_user=${_SESSION['id']}";
                        $requete = $bdd->query($sql);
                        $documents = $requete->fetchall();
                        
                        foreach($documents as $document):
                            $_SESSION['id_projet'] = $document['id_projet'];
                    ?>
                    <tr>
                        <td align="left"><a href="<?php echo "projet.php?projet=".$document['id_projet'] ?> "><?php echo $document["nom"] ?></a></td>
                        <td align="left"><a href="<?php echo "projet.php?projet=".$document['id_projet'] ?> "><?php echo $document["date_creation"] ?></a></td>
                    </tr>
                    <?php  
                        endforeach   
                    ?>
                </table>
            </div>
            
            
            <div style="position: relative; top: 20px;">
                <form action="ajouter.php" method="post">
                    <input type="submit"  name="ajouter" value="Ajout">
                </form>
            </div>
        </div>
        <div style="border: 4px solid black;height: 500px;width: 500px">
        
        </div>
    </div>
</body>
</html>
