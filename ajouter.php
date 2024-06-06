<?php
session_start();

    try
    {
        $bdd = new PDO("mysql:dbname=pod;host:=127.0.0.1","root","");
    }catch(PDOException $e){
        echo "Erreure: ${e}";
    }

    if(isset($_POST['valider'])){
        $nom=$_POST['nom'];
        $id_projet=$_SESSION['id_projet'];
        $id=$_SESSION['id'];
        $file="./".$id."/".$nom;
        if(!file_exists($file)){
            mkdir("./".$id."/".$nom);
            $sql = "INSERT INTO `projets`(`nom`, `id_user`) VALUES ('${nom}','${id}')";
            $bdd->exec($sql);
            header("Location: acceuilCompte.php");
        } else{
?>
    <script>window.alert("Ce nom de projet existe deja")</script>
<?php
        }
    }
    if(isset($_POST['annuler'])){
        header("Location: acceuilCompte.php");
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div  align="center">
        <form action="" method="POST">
            <table>
                <tr>
                    <td align="right"><label for="nom">Nom: </label></td>
                    <td><input type="text" placeholder="Nom du projet" name="nom" required></td>
                </tr>
                <tr>
                    <td></td></form>
                    <td>
                        <table>
                            <tr><input type="submit" name="valider" value="Valider" ></tr>
                            <tr>
                                <form action="ajouter.php" method="post">
                                    <input type="submit"  name="annuler" value="Annuler">
                                </form>
                            </tr>
                        </table>
                    
                        
                    </td>
                    
                </tr>
            </table>
        
    </div>
</body>
</html>