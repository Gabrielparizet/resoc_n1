<?php 
    include 'header.php';
    if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['like_post_id'])) {
        // var_dump($_SESSION['connected_id'], $_POST['like_post_id']);
            $likeSqlRequest = "INSERT INTO likes"
            . "(id, user_id, post_id)"
            . "VALUES (NULL, " . $_SESSION['connected_id'] . ", " . $_POST['like_post_id'] . ")";
            $ok = $mysqli->query($likeSqlRequest);
    }
?>

<title>Flux</title> 

<div id="wrapper">
    <?php
    $userId = intval($_SESSION['connected_id']);
    ?>

    <aside>
        <?php
        /**
         * Etape 3: récupérer le nom de l'utilisateur
         */
        $laQuestionEnSql = "SELECT * FROM `users` WHERE id= '$userId' ";
        $lesInformations = $mysqli->query($laQuestionEnSql);
        $user = $lesInformations->fetch_assoc();
        //@todo: afficher le résultat de la ligne ci dessous, remplacer XXX par l'alias et effacer la ligne ci-dessous
        // echo "<pre>" . print_r($user, 1) . "</pre>";
        ?>
        <img src="user.jpg" alt="Portrait de l'utilisatrice"/>
        <section>
            <h3>Présentation</h3>
            <p>Sur cette page vous trouverez tous les message des utilisatrices
                auxquel est abonnée l'utilisatrice <?php echo $user['alias'] ?>
            </p>

        </section>
    </aside>
    <main>
        <?php
        /**
         * Etape 3: récupérer tous les messages des abonnements
         */
        $laQuestionEnSql = "
            SELECT posts.content,
            posts.created,
            posts.id as postID,
            users.alias as author_name,  
            count(likes.id) as like_number,  
            users.id as user_id,
            GROUP_CONCAT(DISTINCT tags.label) AS taglist 
            FROM followers 
            JOIN users ON users.id=followers.followed_user_id
            JOIN posts ON posts.user_id=users.id
            LEFT JOIN posts_tags ON posts.id = posts_tags.post_id  
            LEFT JOIN tags       ON posts_tags.tag_id  = tags.id 
            LEFT JOIN likes      ON likes.post_id  = posts.id 
            WHERE followers.following_user_id='$userId' 
            GROUP BY posts.id
            ORDER BY posts.created DESC  
            ";
        $lesInformations = $mysqli->query($laQuestionEnSql);
        if ( ! $lesInformations)
        {
            echo("Échec de la requete : " . $mysqli->error);
        }
        /**
         * Etape 4: todo Parcourir les messsages et remplir correctement le HTML avec les bonnes valeurs php
         * A vous de retrouver comment faire la boucle while de parcours...
         */
        while ($post = $lesInformations->fetch_assoc()) {
            // echo "<pre>" . print_r($post, 1) . "</pre>";
        ?>                
        <article>
            <h3>
                <time datetime='2020-02-01 11:12:13' ><?php echo $post['created'] ?></time>
            </h3>
            <address>par <a href="wall.php?user_id=<?php echo $post['user_id'] ?>"><?php echo $post['author_name'] ?></a></address>
            <div>
                <p><?php echo $post['content'] ?></p>
            </div>                                            
            <footer>
                <small>
                    <form action="feed.php" method="post">
                            <input type="hidden" name="like_post_id" value=<?php echo $post['postID']?>>
                                <input type="submit" value="♥">
                                    <?php 
                                        echo $post['like_number'];
                                    ?>
                                </input>
                            </input>
                    </form>
                </small>
                <?php 
                        $tag = $post['taglist'];
                        $arrayOfTags = explode(",",$tag);
                        $index = 0;
                        for ($index = 0; $index < count($arrayOfTags); $index++) {
                            echo '<a href="">' . "#" . $arrayOfTags[$index] . '</a>' . ' ';
                        }
                        ?>
            </footer>
        </article>
        <?php } ?>
    </main>
</div>
