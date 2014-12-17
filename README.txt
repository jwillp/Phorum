PROJET DE JEAN-WILLIAM PERREAULT

Le projet est développé en utilisant PHP et Neo4j.

Il est conseillé d'utiliser WAMP pour un déploiement rapide et facile.
# ATTENTION il est important d'activer le module APACHE: rewrite_module si ce n'est déjà fait.

Voici un résumé de la structure des dossiers du projet

core: Contient le code source PHP et les sous dossier Controller Model et Vue (MVC)
public: contient les éléments accessibles directement par l'utilisateur donc la page index.html, les styles css et le javascript
vendor: contient les librairies externes utilisé (neo4jphp de everyman disponible sur github)

doc: la documentation du projet (Le document word ACME et le script d'initialisation)


Pour facilité les tests de l'application
dans le dossier doc un fichier nommé "DatabaseInit.cql" est fournis contenant
Une liste de requêtes Cypher permettant de créer plus rapidement des usagers, un thread et des posts dans ce dernier.


