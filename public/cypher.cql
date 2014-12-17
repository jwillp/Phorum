
            MATCH (before)-[r:PRECEDES]->(root), (user)
            WHERE root.uid = 549100c423ca8 AND user.username = Admin
            CREATE UNIQUE (before)-[:PRECEDES]->(p:Post{ uid: 5491012c862e0, text: Plusieurs variations de Lorem Ipsum peuvent être trouvées ici ou là, mais la majeure partie d&#39;entre elles a été altérée par l&#39;addition d&#39;humour ou de mots aléatoires qui ne ressemblent pas une seconde à du texte standard. Si vous voulez utiliser un passage du Lorem Ipsum, vous devez être sûr qu&#39;il n&#39;y a rien d&#39;embarrassant caché dans le texte. Tous les générateurs de Lorem Ipsum sur Internet tendent à reproduire le même extrait sans fin, ce qui fait de lipsum.com le seul vrai générateur de Lorem Ipsum. Iil utilise un dictionnaire de plus de 200 mots latins, en combinaison de plusieurs structures de phrases, pour générer un Lorem Ipsum irréprochable. Le Lorem Ipsum ainsi obtenu ne contient aucune répétition, ni ne contient des mots farfelus, ou des touches d&#39;humour., date: 2014-12-17 05:06:04 })-[:PRECEDES]->(root)
            CREATE UNIQUE (p)-[:WRITTEN_BY]->(user)
            DELETE r
            RETURN p
        