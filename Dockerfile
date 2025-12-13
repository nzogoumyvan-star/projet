# Utilise une image PHP avec Apache (équivalent au serveur embarqué de Spring Boot)
FROM php:8.2-apache

# Copie le code source de l'application (index.php, db.php, etc.)
# dans le répertoire racine d'Apache.
COPY . /var/www/html/

# Le serveur web est configuré pour écouter sur le port standard (80)
# que vous maperez ensuite (ex: 8080:80) lors de l'exécution.

# Le conteneur exécutera Apache et votre application PHP
# (l'exécution d'index.php est gérée par Apache).