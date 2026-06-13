# Guide de Test et d'Installation — SmartKids

Ce guide détaille les étapes nécessaires pour installer, configurer et tester la plateforme SmartKids sur un environnement local (Windows/XAMPP).

## 1. Prérequis

Assurez-vous que les outils suivants sont installés :
- **PHP 8.2+** (Inclus dans XAMPP)
- **Composer** (Gestionnaire de dépendances PHP)
- **Node.js & NPM** (Pour compiler les assets CSS/JS)
- **MySQL** (Serveur de base de données, via XAMPP)

## 2. Installation du Projet

Ouvrez un terminal dans le dossier racine du projet `smartkids` et exécutez les commandes suivantes :

### A. Dépendances PHP et JS
```bash
composer install
npm install
```

### B. Configuration de l'environnement
Copiez le fichier d'exemple et générez la clé d'application :
```powershell
cp .env.example .env
php artisan key:generate
```

### C. Configuration de la base de données
Ouvrez le fichier `.env` et vérifiez les paramètres de connexion. Pour un environnement XAMPP standard :
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=smartkids
DB_USERNAME=root
DB_PASSWORD=
```
> [!IMPORTANT]
> Créez manuellement la base de données `smartkids` dans phpMyAdmin avant de passer à l'étape suivante.

## 3. Déploiement de la Base de Données

Nous avons mis en place un système de seeding complet avec des données tunisiennes réalistes. Exécutez cette commande pour réinitialiser et peupler la base :

```bash
php artisan migrate:fresh --seed
```

Cette commande va :
1. Supprimer toutes les tables existantes.
2. Recréer la structure (14 tables).
3. Configurer les rôles et permissions (Admin, Éducateur, Parent).
4. Injecter 35 profils d'enfants, 4 enseignants, et des milliers d'enregistrements de présence/activités.

## 4. Lancement de l'Application

Démarrez le serveur de développement Laravel et le compilateur Vite dans deux terminaux séparés :

**Terminal 1 (Serveur) :**
```bash
php artisan serve
```

**Terminal 2 (Assets) :**
```bash
npm run dev
```

L'application sera accessible sur `http://localhost:8000`.

## 5. Comptes de Test

Utilisez les identifiants suivants pour tester les différents portails :

| Profil | Email | Mot de passe |
| :--- | :--- | :--- |
| **Administrateur** | `admin@smartkids.tn` | `password` |
| **Éducateur** | `educateur@smartkids.tn` | `password` |
| **Parent** | `parent@smartkids.tn` | `password` |

## 6. Liste des Points à Tester

### Portail Admin
- [ ] Consulter les statistiques temps réel sur le tableau de bord.
- [ ] Gérer les enfants (CRUD) et les assigner à des classes.
- [ ] Créer un menu hebdomadaire dans l'onglet "Repas".
- [ ] Planifier une nouvelle activité et inscrire des enfants.

### Portail Parent
- [ ] Visualiser le résumé de présence de son enfant.
- [ ] Consulter l'historique des paiements et le prochain dû.
- [ ] Consulter le menu de la cantine de la semaine.

### Messagerie Interne
- [ ] Envoyer un message depuis le compte Admin vers un Parent.
- [ ] Vérifier la réception et la cloche de notification sur le compte destinataire.

---
*Ce guide a été généré pour la version 1.0 du projet SmartKids.*
