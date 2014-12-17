# VIDER DB
MATCH (n)
OPTIONAL MATCH (n)-[r]-()
DELETE n,r


# CRÉATION DE L'ADMINISTRATEUR (Le Mot de passe correspond à AAAaaa1111)
CREATE (n:User:Admin {username: "Admin", 
                password: "da4be0ac0074575b4ed2a66bb5838b350b151a32", 
                email: "admin@dynamikoncept.com" ,
                gravatar: "img/adminAvatar.png",
                regDate: "0/0/0"
                })
RETURN n;



# CRÉATION D'USAGERS (Mot de passe = AAAaaa111)
CREATE (n:User {username: "Bob", 
                password: "da4be0ac0074575b4ed2a66bb5838b350b151a32", 
                email: "bob@dynamikoncept.com" ,
                gravatar: "http://www.gravatar.com/avatar/820d0e4ee14e986a44d33782ca852f51?s=80&d=identicon&r=x",
                regDate: "2014/01/12"
                })
RETURN n;


CREATE (n:User {username: "Joe", 
                password: "da4be0ac0074575b4ed2a66bb5838b350b151a32", 
                email: "joe@dynamikoncept.com" ,
                gravatar: "http://www.gravatar.com/avatar/48e0183a60ee43a626a82ba733d2af64?s=80&d=identicon&r=x",
                regDate: "2014/01/12"
                })
RETURN n;



CREATE (n:User {username: "Janis", 
                password: "da4be0ac0074575b4ed2a66bb5838b350b151a32", 
                email: "janis@dynamikoncept.com" ,
                gravatar: "http://www.gravatar.com/avatar/fb695b87b9c8fbabf19369e70f4661cc?s=80&d=identicon&r=x",
                regDate: "2014/01/12"
                })
RETURN n;




# AJOUT D'UN THREAD AVEC DES POSTS


            MATCH (before)-[r:PRECEDES]->(root), (user)
            WHERE root.uid = "549100c423ca8" AND user.username = "Admin"
            CREATE UNIQUE (before)-[:PRECEDES]->(p:Post{ uid: "5491012c862e0", text: "Plusieurs variations de Lorem Ipsum peuvent être trouvées ici ou là, mais la majeure partie d&#39;entre elles a été altérée par l&#39;addition d&#39;humour ou de mots aléatoires qui ne ressemblent pas une seconde à du texte standard. Si vous voulez utiliser un passage du Lorem Ipsum, vous devez être sûr qu&#39;il n&#39;y a rien d&#39;embarrassant caché dans le texte. Tous les générateurs de Lorem Ipsum sur Internet tendent à reproduire le même extrait sans fin, ce qui fait de lipsum.com le seul vrai générateur de Lorem Ipsum. Iil utilise un dictionnaire de plus de 200 mots latins, en combinaison de plusieurs structures de phrases, pour générer un Lorem Ipsum irréprochable. Le Lorem Ipsum ainsi obtenu ne contient aucune répétition, ni ne contient des mots farfelus, ou des touches d&#39;humour.", date: "2014-12-17 05:06:04" })-[:PRECEDES]->(root)
            CREATE UNIQUE (p)-[:WRITTEN_BY]->(user)
            DELETE r
            RETURN p
        CREATE (n:Thread { uid: "5491023bf0a00", title: "Le Lorem Ipsum", date: "2014-12-17 05:10:35" })-[:PRECEDES]->(n)
                        RETURN n


            MATCH (before)-[r:PRECEDES]->(root), (user)
            WHERE root.uid = "5491023bf0a00" AND user.username = "Janis"
            CREATE UNIQUE (before)-[:PRECEDES]->(p:Post{ uid: "5491023c1a838", text: "Le Lorem Ipsum est simplement du faux texte employé dans la composition et la mise en page avant impression. Le Lorem Ipsum est le faux texte standard de l&#39;imprimerie depuis les années 1500, quand un peintre anonyme assembla ensemble des morceaux de texte pour réaliser un livre spécimen de polices de texte. Il n&#39;a pas fait que survivre cinq siècles, mais s&#39;est aussi adapté à la bureautique informatique, sans que son contenu n&#39;en soit modifié. Il a été popularisé dans les années 1960 grâce à la vente de feuilles Letraset contenant des passages du Lorem Ipsum, et, plus récemment, par son inclusion dans des applications de mise en page de texte, comme Aldus PageMaker.", date: "2014-12-17 05:10:36" })-[:PRECEDES]->(root)
            CREATE UNIQUE (p)-[:WRITTEN_BY]->(user)
            DELETE r
            RETURN p
        


            MATCH (before)-[r:PRECEDES]->(root), (user)
            WHERE root.uid = "5491023bf0a00" AND user.username = "Admin"
            CREATE UNIQUE (before)-[:PRECEDES]->(p:Post{ uid: "5491024ae8530", text: "Mais d&#39;où viens-til? Contrairement à une opinion répandue, le Lorem Ipsum n&#39;est pas simplement du texte aléatoire. Il trouve ses racines dans une oeuvre de la littérature latine classique datant de 45 av. J.-C., le rendant vieux de 2000 ans. Un professeur du Hampden-Sydney College, en Virginie, s&#39;est intéressé à un des mots latins les plus obscurs, consectetur, extrait d&#39;un passage du Lorem Ipsum, et en étudiant tous les usages de ce mot dans la littérature classique, découvrit la source incontestable du Lorem Ipsum. Il provient en fait des sections 1.10.32 et 1.10.33 du &#34;De Finibus Bonorum et Malorum&#34; (Des Suprêmes Biens et des Suprêmes Maux) de Cicéron. Cet ouvrage, très populaire pendant la Renaissance, est un traité sur la théorie de l&#39;éthique. Les premières lignes du Lorem Ipsum, &#34;Lorem ipsum dolor sit amet...&#34;, proviennent de la section 1.10.32. L&#39;extrait standard de Lorem Ipsum utilisé depuis le XVIè siècle est reproduit ci-dessous pour les curieux. Les sections 1.10.32 et 1.10.33 du &#34;De Finibus Bonorum et Malorum&#34; de Cicéron sont aussi reproduites dans leur version originale, accompagnée de la traduction anglaise de H. Rackham (1914).", date: "2014-12-17 05:10:50" })-[:PRECEDES]->(root)
            CREATE UNIQUE (p)-[:WRITTEN_BY]->(user)
            DELETE r
            RETURN p
        


            MATCH (before)-[r:PRECEDES]->(root), (user)
            WHERE root.uid = "5491023bf0a00" AND user.username = "Joe"
            CREATE UNIQUE (before)-[:PRECEDES]->(p:Post{ uid: "549102800aa50", text: "On sait depuis longtemps que travailler avec du texte lisible et contenant du sens est source de distractions, et empêche de se concentrer sur la mise en page elle-même. L&#39;avantage du Lorem Ipsum sur un texte générique comme &#39;Du texte. Du texte. Du texte.&#39; est qu&#39;il possède une distribution de lettres plus ou moins normale, et en tout cas comparable avec celle du français standard. De nombreuses suites logicielles de mise en page ou éditeurs de sites Web ont fait du Lorem Ipsum leur faux texte par défaut, et une recherche pour &#39;Lorem Ipsum&#39; vous conduira vers de nombreux sites qui n&#39;en sont encore qu&#39;à leur phase de construction. Plusieurs versions sont apparues avec le temps, parfois par accident, souvent intentionnellement (histoire d&#39;y rajouter de petits clins d&#39;oeil, voire des phrases embarassantes)., date: 2014-12-17 05:11:44" })-[:PRECEDES]->(root)
            CREATE UNIQUE (p)-[:WRITTEN_BY]->(user)
            DELETE r
            RETURN p
        


            MATCH (before)-[r:PRECEDES]->(root), (user)
            WHERE root.uid = "5491023bf0a00" AND user.username = "Bob"
            CREATE UNIQUE (before)-[:PRECEDES]->(p:Post{ uid: "549102a0b9348", text: "Plusieurs variations de Lorem Ipsum peuvent être trouvées ici ou là, mais la majeure partie d&#39;entre elles a été altérée par l&#39;addition d&#39;humour ou de mots aléatoires qui ne ressemblent pas une seconde à du texte standard. Si vous voulez utiliser un passage du Lorem Ipsum, vous devez être sûr qu&#39;il n&#39;y a rien d&#39;embarrassant caché dans le texte. Tous les générateurs de Lorem Ipsum sur Internet tendent à reproduire le même extrait sans fin, ce qui fait de lipsum.com le seul vrai générateur de Lorem Ipsum. Iil utilise un dictionnaire de plus de 200 mots latins, en combinaison de plusieurs structures de phrases, pour générer un Lorem Ipsum irréprochable. Le Lorem Ipsum ainsi obtenu ne contient aucune répétition, ni ne contient des mots farfelus, ou des touches d&#39;humour.", date: "2014-12-17 05:12:16"})-[:PRECEDES]->(root)
            CREATE UNIQUE (p)-[:WRITTEN_BY]->(user)
            DELETE r
            RETURN p
        


            MATCH (before)-[r:PRECEDES]->(root), (user)
            WHERE root.uid = "5491023bf0a00" AND user.username = "Bob"
            CREATE UNIQUE (before)-[:PRECEDES]->(p:Post{ uid: 549102b1d9eb8, text: "Je crois que je vais supprimer ce message", date: "2014-12-17 05:12:33" })-[:PRECEDES]->(root)
            CREATE UNIQUE (p)-[:WRITTEN_BY]->(user)
            DELETE r
            RETURN p
        


            MATCH (n:Post)
            WHERE n.uid = "549102b1d9eb8"
            SET n:DELETED
            RETURN n;











