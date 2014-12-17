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















