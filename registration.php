<?php 
    include 'header.php';
?>

<title>Registration</title> 

    <main>
        <div id="login" >
            <h2>Welcome on our social network</h2>
            <h1>TravelBook</h1>
            <h2>Registration</h2>
            <?php
            /**
             * TRAITEMENT DU FORMULAIRE
             */
            // Etape 1 : vérifier si on est en train d'afficher ou de traiter le formulaire
            // si on recoit un champs email rempli il y a une chance que ce soit un traitement
            $enCoursDeTraitement = isset($_POST['email']);
            if ($enCoursDeTraitement)
            {
                // on ne fait ce qui suit que si un formulaire a été soumis.
                // Etape 2: récupérer ce qu'il y a dans le formulaire @todo: c'est là que votre travaille se situe
                // observez le résultat de cette ligne de débug (vous l'effacerez ensuite)
                // echo "<pre>" . print_r($_POST, 1) . "</pre>";
                // et complétez le code ci dessous en remplaçant les ???
                $new_email = $_POST['email'];
                $new_alias = $_POST['pseudo'];
                $new_passwd = $_POST['motpasse'];
                if (empty($_POST['email']) || empty($_POST['pseudo']) || empty($_POST['motpasse'])){
                    echo 'Please enter a valid nickame, email and password.';
                } else {

                //Etape 4 : Petite sécurité
                // pour éviter les injection sql : https://www.w3schools.com/sql/sql_injection.asp
                $new_email = $mysqli->real_escape_string($new_email);
                $new_alias = $mysqli->real_escape_string($new_alias);
                $new_passwd = $mysqli->real_escape_string($new_passwd);
                // on crypte le mot de passe pour éviter d'exposer notre utilisatrice en cas d'intrusion dans nos systèmes
                $new_passwd = md5($new_passwd);
                // NB: md5 est pédagogique mais n'est pas recommandée pour une vraies sécurité
                //Etape 5 : construction de la requete
                $lInstructionSql = "INSERT INTO users (id, email, password, alias) "
                        . "VALUES (NULL, "
                        . "'" . $new_email . "', "
                        . "'" . $new_passwd . "', "
                        . "'" . $new_alias . "'"
                        . ");";
                // Etape 6: exécution de la requete
                $ok = $mysqli->query($lInstructionSql);
                if ( ! $ok)
                {
                    echo "Your registration failed : " . $mysqli->error;
                } else
                {
                    echo "Your registration succeed : " . $new_alias;
                    echo " <a href='login.php'>Connectez-vous.</a>";
                }
            }}
            ?>    
            <div class=txt_field>                  
                <form action="registration.php" method="post">
                    <input type='hidden'name='???' value='achanger'>
                    <dl>
                        <dt><label for='pseudo'>Nickname</label></dt>
                        <dd><input type='text'name='pseudo'></dd>
                        <dt><label for='email'>E-Mail</label></dt>
                        <dd><input type='email'name='email'></dd>
                        <dt><label for='motpasse'>Password</label></dt>
                        <dd><input type='password'name='motpasse'></dd>
                    </dl>
                    <input type='submit'>
                </form>
                </div>
    </main>
