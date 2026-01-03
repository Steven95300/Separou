# 🚆 Séparou - Itinéraires & Horaires RER

**Projet Universitaire - Licence d'Informatique (L2)**
Réalisé par : **Steven BASKARA** & **Julien RAAD**

## 📝 Présentation
"Séparou" est un site web conçu pour faciliter la planification des déplacements en Île-de-France. Développé dans le cadre de l'UE Web à CY Cergy Paris Université, ce projet met en pratique l'utilisation d'APIs tierces pour fournir des informations de transport en temps réel (horaires, gares, escales).

## ✨ Fonctionnalités principales
- **Recherche de gares** : Système intuitif pour saisir et identifier les gares de départ et d'arrivée.
- **Horaires en temps réel** : Affichage des heures de départ, d'arrivée et de la durée des trajets via l'API SNCF.
- **Suivi des Statistiques** : Enregistrement des recherches effectuées dans un fichier CSV pour identifier les trajets les plus consultés.
- **Personnalisation par Cookies** : Mémorisation automatique de la dernière gare consultée et de la date pour une navigation fluide.
- **Gestion des erreurs** : Messages clairs en cas de défaillance réseau ou d'API indisponible.

## 🛠️ Technologies utilisées
- **Backend** : PHP 8+
- **Frontend** : HTML5, CSS3 (Design responsive)
- **API** : Intégration de l'**API SNCF** explorée via **Navitia Playground**
- **Données** : Format **CSV** pour le stockage des statistiques d'utilisation

## 🚀 Installation
1. Clonez ce dépôt sur votre serveur local (WAMP, XAMPP, etc.).
2. Configurez votre clé d'API SNCF dans les fichiers de configuration PHP.
3. Assurez-vous que le dossier contenant les fichiers `.csv` possède les droits d'écriture.
4. Accédez au site via `index.php`.

## 📊 Structure du Projet
- **Page d'accueil** : Interface de recherche principale.
- **Page de résultats** : Affichage dynamique des horaires et correspondances suggérées.
- **Page de détails** : Informations approfondies sur les arrêts intermédiaires et les transferts.
- **Page statistiques** : Visualisation des données basées sur les recherches fréquentes.

## 📚 Documentation
Le dossier `/docs` contient le rapport de projet complet (PDF) détaillant la conception, la répartition des tâches (Diagramme de Gantt) et les spécifications techniques.
