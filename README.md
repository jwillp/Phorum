# Phorum

PROJET DE JEAN-WILLIAM PERREAULT

Moteur de forum ecrit en PHP et utilisant une base de donnee Neo4j, developpe dans le cadre du cours "Environnement de base de donnees" afin d'apprendre a utiliser les base de donnes de types NoSql, dans le cas present, une base de donnees en graphe: Neo4j.

## Notes au professeur

### Installation
Il est conseillé d'utiliser WAMP pour un déploiement rapide et facile.
```ATTENTION il est important d'activer le module APACHE: rewrite_module si ce n'est déjà fait.```

### Structure
Voici un résumé de la structure des dossiers du projet:

- core: Contient le code source PHP et les sous dossier Controller, Model et Vue (MVC)
- public: contient les éléments accessibles directement par l'utilisateur donc la page index.html, les styles css et le javascript
- vendor: contient les librairies externes utilisé (neo4jphp de everyman disponible sur github https://github.com/jadell/neo4jphp)
- doc: la documentation du projet (Le document word ACME et le script d'initialisation)

Pour faciliter les tests de l'application, un fichier nommé "DatabaseInit.cql" est fournis dans le dossier _doc_ contenant
une liste de requêtes Cypher permettant de créer plus rapidement des usagers, un thread et des posts dans ce dernier.


