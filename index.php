<?php

    if(isset($_POST["envoyer"]))
    {   
        
        try
        {
            $bdd = new PDO("mysql:dbname=pod;host:=127.0.0.1","root","");
        }catch(PDOException $e){
            echo "Erreure: ${e}";
        }

        

        if(empty($nom)) $erreur="Veuillez entrer votre nom";
        else{

            if(empty($prenom)) $erreur="Veuillez entrer votre prenom";
            else{

                if(!filter_var($_POST['email'],FILTER_VALIDATE_EMAIL) || empty($email)) $erreur="Votre email est invalide";
                else{

                    $sql="SELECT count('id_user') from users where email='${email}'";
                    $requete = $bdd->query($sql);
                    $user = $requete->fetch();

                    if($user[0] > 0) $erreur="Cette email existe deja";
                    else{

                        if(empty($pseudo)) $erreur="Veuillez entrer un pseudo";
                        else{

                            $sql="SELECT count('pseudo') from users where pseudo='${pseudo}'";
                            $requete = $bdd->query($sql);
                            $user = $requete->fetch();
                            
                            if($user[0] > 0) $erreur="Ce pseudo existe deja";
                            else{

                                if(empty($_POST['mdp'])) $erreur="Veuillez entrer un mot de passe";
                                else{

                                    if(empty($_POST['mdp2'])) $erreur="Veuillez entrer un mot de passe de confirmation";
                                    else{

                                        $mdp=sha1($_POST['mdp']);
                                        $mdp2=sha1($_POST['mdp2']);

                                        if($mdp == $mdp2){

                                            $sql = "INSERT INTO `users`(`nom`, `prenom`, `email`, `pseudo`, `pass`) VALUES ('${nom}','${prenom}','${email}','${pseudo}','${mdp}')";
                                            $bdd->exec($sql);

                                            $sql="SELECT id_user from users where email='${email}'";
                                            $requete = $bdd->query($sql);
                                            $user = $requete->fetch();
                                            mkdir("./".$user[0]);

                                            if(isset($_FILES["image"]) && !empty($_FILES["image"]["name"])){
                                
                                                $size=1024*10;
                                                
                                                if($_FILES["image"]["size"] <= $size){

                                                    $tmp=$_FILES["image"]["tmp_name"];
                                                    $nomA=$_FILES["image"]["name"];
                                                    $formatOk=array("jpeg","jpg","png","gif");
                                                    $format=substr(strpbrk(strtolower($nomA),"."),1);

                                                    if(in_array($format,$formatOk)){

                                                        $sql = "SELECT id_user from users where email='${email}'";
                                                        $requete = $bdd->query($sql);
                                                        $user = $requete->fetch();

                                                        $nomA=$user[0].".".$format;
                                                        $_FILES["image"]["name"]=$nomA;

                                                        $sql = "UPDATE users set avatar='${nomA}' where  email='${email}'";
                                                        $bdd->exec($sql);

                                                        if(!move_uploaded_file($_FILES["image"]["tmp_name"],"./avatar/${nomA}")) $erreur="Echec lors de l'envoi de l'image";
                                                    }
                                                }
                                                else{
                                                    $erreur ="Taille d'image invalide";
                                                }
                                            }
                                            else{
                                                

                                                
                                            }     
                                        }
                                        else{
                                            $erreur = "Votre mot de passe ne concorde pas";
                                        }
                                    }
                                }
                            }
                        }
                    }   
                }
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
    <link rel="stylesheet" type="text/css" href="CssIndex.css">
    
    
</head>
<body>
    <div align="center"><h3>Creer un Compte</h3></div>
    
    <div align="center">
        <form action="" method="post" style="align-content:baseline" enctype="multipart/form-data">
            <table>
                <tr><img src="<?php if(isset($tmp)) echo "./avatar/${nomA}"; else echo "./avatar/default.jpg"?>" alt="center" style="border-radius: 10500px;"></tr>
                <p style="color: red" align="center"> <?php if(isset($erreur)) echo $erreur?> </p>
                <tr>
                    <td align="right"><label for="nom">Nom: </label></td>
                    <td><input type="text" placeholder="Votre nom" name="nom" value="<?php if(isset($nom)) echo $nom?>" ></td>
                </tr>
                <tr>
                    <td align="right"><label for="prenom">Prenom: </label></td>
                    <td><input type="text" placeholder="Votre prenom" name="prenom" value="<?php if(isset($prenom)) echo $prenom?>" ></td>
                </tr>
                <tr>
                    <td align="right"><label for="email">Email: </label></td>
                    <td><input type="email" placeholder="Votre email" name="email"></td>
                </tr>
                <tr>
                    <td align="right"><label for="pseudo">Pseudo: </label></td>
                    <td><input type="text" placeholder="Votre pseudo" name="pseudo" value="<?php if(isset($pseudo)) echo $pseudo?>"></td>
                </tr>
                <tr>
                    <td align="right"><label for="mdp">Mot de passe: </label></td>
                    <td><input type="password" placeholder="Mot de passe" name="mdp"></td>
                </tr>
                <tr>
                    <td align="right"><label for="mdp2">Confirmer mot de passe: </label></td>
                    <td><input type="password" placeholder="Confirmer votre mot de passe" name="mdp2" ></td>
                </tr>
                <tr>
                    <td align="right"><label for="image">Avatar: </label></td>
                    <td><input style="width: 190px;" type="file" name="image"></td>
                </tr>
                <tr>
                    <td></td>
                    <td><input type="submit" name="envoyer" value="Envoyer"></td>
                    <td><input type="reset" name="annuler" value="Annuler"></td>
                </tr>
                <tr>
                    <td align="center"><a href="./AccueilPlateforme.html"><br>Acceuil</a></td>
                </tr>
            </table>
        </form>
    </div>
</body>
</html>
