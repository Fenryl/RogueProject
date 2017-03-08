<?php

function headerHTML($pageCourante = ''){ ?>
    <header>
        <div class="center">
            <div id="header_title">
                <h1>rogue project</h1>
                <div id="header_connect">
                    <?php if(!isset($_SESSION['id'])) {
                        echo '<a href="/inscription.php">inscription</a>'.PHP_EOL;
                        echo '<a href="/connexion.php">connexion</a>'.PHP_EOL;
                    } else {
                        echo '<a href="">mon compte</a>'.PHP_EOL;
                        echo '<a href="/deconnexion.php">déconnexion</a>'.PHP_EOL;
                    }
                    ?>
                </div>
            </div>

            <ul class="big">
                <a href="/index.php"><li <?php echo ($pageCourante == 'index') ? 'id="selected"': '' ; ?>>Accueil</li></a>
                <a href=""><li <?php echo ($pageCourante == 'presentation') ? 'id="selected"': '' ; ?>>Présentation du jeu</li></a>
                <a href="/newsList.php"><li <?php echo ($pageCourante == 'news') ? 'id="selected"': '' ; ?>>News</li></a>
                <a href="/classement.php"><li <?php echo ($pageCourante == 'classement') ? 'id="selected"': '' ; ?>>Classement</li></a>
                <a href=""><li>Contact</li <?php echo ($pageCourante == 'contact') ? 'id="selected"': '' ; ?>></a>
                <?php if(isset($_SESSION['admin']))
                {
                    if ($_SESSION['admin'] == 1) {
                        echo '<a href="/admin.php"><li'; echo ($pageCourante == "admin") ? " id=\"selected\"": ""; echo '>Admin</li></a>';
                    }
                }
                ?>
            </ul>
        </div>
    </header>
<?php }

function footerHTML(){ ?>
    <footer>
        <div class="center">
            <nav>
                <ul class="Footer_Nav big">
                    <li id="Footer_RogueProject">Rogue Project
                        <ul>
                            <li>
                                <a href=""><img src="Resources/icons/facebook.png" alt="logo facebook"></a>
                            </li>
                            <li>
                                <a href=""><img src="Resources/icons/twitter.png" alt="logo twitter"></a>
                            </li>
                            <li>
                                <a href=""><img src="Resources/icons/youtube.png" alt="logo youtube"></a>
                            </li>
                            <li>
                                <a href=""><img src="Resources/icons/github_light.png" alt="logo github"></a>
                            </li>
                        </ul>
                    </li>
                    <li id="Footer_APropos">À propos
                        <ul>
                            <li><a href="">Le jeu</a></li>
                            <li><a href="">L'équipe</a></li>
                        </ul>
                    </li>
                    <li id="Footer_PlanDuSite">Plan du site
                        <ul>
                            <li><a href="/index.php">Accueil</a></li>
                            <li><a href="">Présentation du jeu</a></li>
                            <li><a href="/newsList.php">News</a></li>
                            <li><a href="/classement.php">Classement</a></li>
                            <li><a href="">Contact</a></li>
                        </ul>
                    </li>
                </ul>
            </nav>
        </div>
    </footer>

<?php }