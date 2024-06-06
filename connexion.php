<?php
    session_start();
    if(isset($_POST["envoyer"]))
    {   
        
        try
        {
            $bdd = new PDO("mysql:dbname=pod;host:=127.0.0.1","root","");
        }catch(PDOException $e){
            echo "Erreure: ${e}";
        }

        $email=$_POST['email'];

        if(!filter_var($_POST['email'],FILTER_VALIDATE_EMAIL) || empty($email)) $erreur="Votre email est invalide";
        else{
            $sql="SELECT email,pass,id_user,pseudo from users where email='${email}'";
            $requete = $bdd->query($sql);
            $user = $requete->fetch();

            if($user[0] == $email){

                if(empty($_POST['mdp'])) $erreur="Veuillez entrer un mot de passe";
                else{
                    $mdp=sha1($_POST['mdp']);
                    if($user[1] == $mdp){
                        $_SESSION["id"]=$user[2];
                        $_SESSION["pseudo"]=$user[3];
                        $_SESSION["email"]=$user[0];
                        header("Location: acceuilCompte.php?id=${_SESSION['id'] }");
                    }
                    else $erreur="Mot de passe incorrect";
                }
            } 
            else{
                $erreur="Email incorrect";
                
            }
        }
    }


    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="CssConnexion.css">
</head>
<body>
    <div align="center"><h3>Connexion</h3></div>
    
    <div align="center">
        <form action="" method="post" style="align-content:baseline" enctype="multipart/form-data">
            <table>
            <p style="color: red" align="center"> <?php if(isset($erreur)) echo $erreur?> </p>
                <tr>
                    <td align="right"><label for="email">Email: </label><br></td>
                    <td><input type="email" placeholder="Votre email" name="email"><br></td>
                    <br>
                </tr>
                <tr>
                    <td align="right" height=50px><label for="mdp">Mot de passe: </label></td>
                    <td><input type="password" placeholder="Mot de passe" name="mdp"><br></td>
                </tr>
                <tr>
                    <td></td>
                    <td><input type="submit" name="envoyer" value="Se Connecter"><br></td>
                    <td><input type="reset" name="annuler" value="Annuler"><br></td>
                </tr>
                <tr>
                    <td></td>
                    <td><a href="index.php">Creer un compte ?</a><br></td>
                    <td><a href="AccueilPlateforme.html">Acceuil</a><br></td>
                </tr>
            </table>
        </form>
    </div>
</body>
</html>


