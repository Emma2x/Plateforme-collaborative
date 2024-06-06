<?php 
//INSERT INTO `projets`(`nom`, `id_user`) VALUES ('abc','2')
    try
    {
        $bdd = new PDO("mysql:dbname=pod;host:=127.0.0.1","root","");
    }catch(PDOException $e){
        echo "Erreure: ${e}";
    }

    $sql = "SELECT avatar from users where id_user='${_SESSION['id']}'";
    $requete = $bdd->query($sql);
    $avatar = $requete->fetch();
?>


    <header>
        <div style="display: flex;border-bottom: 1px solid black;height: 100px;background-color: blue;" >
            <img src="<?php echo "./avatar/${avatar[0]}"?>" alt="center" style="border-radius: 10500px;" height=90px>
            <div style="margin-left: 20px; margin-top: 20px;bottom-border: 5px solid black;">
                <table>
                    <tr>
                        <td align="left" height=20px><label for="mdp">Pseudo: <?php echo $_SESSION["pseudo"] ?></label></td>
                        <td>
                            <form action="deconnexion.php" method="post">
                                <input type="submit"  name="logout" value="Logout" style="position: absolute; right: 10px;">
                            </form>
                        </td>
                    </tr>
                    <tr>
                        <td align="left" height=20px><label for="email">Email: <?php echo $_SESSION["email"] ?></label></td>
                    </tr>
                    
                </table>  
            </div>
        </div>
    </header>
