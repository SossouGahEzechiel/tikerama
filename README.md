# TIKERAMA

Ce projet est un test technique développé pour TIKERAMA dans le cadre de ma candidature pour le poste de Développeur Fullstack.

## Prérequis

- PHP 8.2
- Composer
- Git
- Un serveur de messagerie (MailDev recommandé pour le développement)

## Installation

1. Clonez le dépôt GitHub :
   ```bash
   git clone https://github.com/votre-utilisateur/tikerama.git
   cd tikerama
   ```

2. Installez les dépendances du projet avec Composer :
   ```bash
   composer install
   ```

3. Créez un fichier `.env` en vous basant sur le fichier `.env.example` :
   ```bash
   cp .env.example .env
   ```

4. Configurez les paramètres du fichier `.env` :
   - Assurez-vous que la base de données soit configurée pour utiliser SQLite :
     ```env
     DB_CONNECTION=sqlite
     DB_DATABASE=/chemin/vers/la/base/de/donnees/database.sqlite
     ```
   - Configurez le serveur de messagerie pour le développement avec MailDev :
     ```env
     MAIL_MAILER=smtp
     MAIL_HOST=localhost
     MAIL_PORT=1025
     MAIL_USERNAME=null
     MAIL_PASSWORD=null
     MAIL_ENCRYPTION=null
     ```

5. Créez le fichier de la base de données SQLite :
   ```bash
   touch /chemin/vers/la/base/de/donnees/database.sqlite
   ```

6. Exécutez les migrations pour configurer la base de données :
   ```bash
   php artisan migrate
   ```

7. Peuplez la base de données avec des données de test :
   ```bash
   php artisan db:seed
   ```

8. Lancez le serveur de développement :
   ```bash
   php artisan serve
   ```

## Documentation de l'API

La documentation de l'API est disponible à l'URL suivante : `http://localhost:8000/api/openapi`.

## Remerciements

Je tiens à remercier l'équipe de TIKERAMA pour l'opportunité de participer à ce test technique.

---

Pour toute question ou suggestion, n'hésitez pas à me contacter.
