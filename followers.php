<?php include 'header.php' ?>

<title>Suiveurs</title> 

<div id="wrapper">          
    <!-- <aside> -->
        <img src = "user.jpg" alt = "User profile"/>
        <!-- <section> -->
            <h3>Description</h3>
            <p>  On this page you will find the list of people that are following this user's posts.
                n° <?php echo intval($_SESSION['connected_id']) ?></p>

        <!-- </section>
    </aside> -->
    <main class='contacts'>
        <?php
        // Etape 1: récupérer l'id de l'utilisateur
        $userId = intval($_SESSION['connected_id']);
        // Etape 3: récupérer le nom de l'utilisateur
        $laQuestionEnSql = "
            SELECT users.*
            FROM followers
            LEFT JOIN users ON users.id=followers.following_user_id
            WHERE followers.followed_user_id='$userId'
            GROUP BY users.id
            ";
        $lesInformations = $mysqli->query($laQuestionEnSql);
        // Etape 4: à vous de jouer
        //@todo: faire la boucle while de parcours des abonnés et mettre les bonnes valeurs ci dessous 
        while ($followers = $lesInformations->fetch_assoc()) {
            // echo "<pre>" . print_r($followers,1) . "</pre>";
        ?>
        <article>
            <img src="user.jpg" alt="blason"/>
            <h3><a href="wall.php?user_id=<?php echo $followers['id'] ?>"><?php echo $followers['alias'] ?></a></h3>
            <p>id: <?php echo $followers['id'] ?></p>
        </article>
        <?php } ?>
    </main>
</div>