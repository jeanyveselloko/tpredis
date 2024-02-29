# Projet de Développement pour le Cloud (WebApp)

## Sujet de Préférence
Système de Gestion d'Utilisateurs

## Technologies Utilisées
- Base de données : Redis et MySQL (CRUD complet)
- Intégration de l'API du gouvernement BAN (ou autre API si nécessaire)

### README.md
#### 1. Description Technique
   - **Base de Données :**
     - Utilisation de Redis et MySQL pour assurer un CRUD complet.
   - **API du gouvernement BAN :**
     - Intégration pour enrichir les informations d'adresse des utilisateurs.

#### 2. Description Fonctionnelle
   - **Fonctionnalités Principales :**
     - Ajout, modification, suppression, et consultation des utilisateurs.
     - Intégration de l'API BAN pour améliorer les données d'adresse.
   - **Fonctionnalités Secondaires :**
     - Système d'authentification et de gestion de sessions.
     - Affichage des détails des utilisateurs avec une interface conviviale.
     - Utilisation de deux bases de données (Redis pour la rapidité, MySQL pour la persistance).

#### 3. Diagrammes
   - **Use Case :**
   - 
     ![use case drawio](https://github.com/jeanyveselloko/tpredis/assets/83597407/b5cf58b5-cac8-4a46-a061-fc292cd1eb11)

   - **Diagramme d'Activité :**

     ![mes diagrammes-activité drawio](https://github.com/jeanyveselloko/tpredis/assets/83597407/6b6f350c-a79f-4b26-b328-d84077f322ad)

   - **Diagramme de Flux de Données :**

![mes diagrammes-flux de données drawio](https://github.com/jeanyveselloko/tpredis/assets/83597407/446ac1fd-00fb-4168-b30f-4fb35f1e8ce2)

   - **Diagramme de Classe (si applicable) :**

   ![mes diagrammes-classe drawio](https://github.com/jeanyveselloko/tpredis/assets/83597407/f7645592-5291-4f7c-9264-ca7f7e799b57)


## Architecture et Conception

### Choix d'Architecture

Notre système de gestion d'utilisateurs utilise une architecture basée sur le cloud, avec une répartition des responsabilités entre plusieurs composants. Voici les principaux éléments de notre architecture :

1. **Frontend WebApp :**
   - Développé en HTML, CSS, JavaScript.
   - Utilisation du framework Bootstrap pour une interface utilisateur réactive et conviviale.
   - La communication avec le Backend se fait via des requêtes HTTP.

2. **Backend API :**
   - Construit en PHP pour le traitement des requêtes.
   - Intégration avec Redis et MySQL pour assurer un CRUD complet.
   - Gestion des sessions et de l'authentification des utilisateurs.
   - Intégration de l'API du gouvernement BAN pour enrichir les données d'adresse.

3. **Bases de Données :**
   - Utilisation de Redis pour le stockage rapide et en mémoire des données utilisateur.
   - MySQL est utilisé pour la persistance des données et la gestion à long terme.

#### Explication Technique

- **Frontend WebApp :**
  - Développé en utilisant HTML, CSS, et JavaScript pour assurer une expérience utilisateur interactive.
  - Utilisation de Bootstrap pour garantir la convivialité et la réactivité de l'interface.
  - Les requêtes HTTP sont envoyées au Backend pour le traitement.

- **Backend API :**
  - Écrit en PHP pour assurer la logique métier.
  - Utilisation de Redis pour des opérations rapides de lecture/écriture, réduisant la charge sur MySQL.
  - MySQL est utilisé pour stocker les données de manière persistante.
  - Authentification des utilisateurs et gestion des sessions sont implémentées.

- **Bases de Données :**
  - Redis est utilisé comme base de données en mémoire pour des opérations rapides et temporaires.
  - MySQL stocke les données de manière durable pour une utilisation à long terme.

### Estimation des Coûts sur AWS

Coûts sur AWS avec redis : 5$/mois avec 1 base de données

Disponibilité
Pas de réplication

Persistance des données: non

Connexions
256

Sauvegardes quotidiennes et instantanées: oui

CIDR autorise les règles
4

Réplication: non

Soutien
Standard

Regroupement: non


### Dossiers du Projet
1. **src/**
   - Contient le code source de l'application.

2. **tests/**
   - Contient les tests unitaires et fonctionnels ainsi que les tests de sécurité.

### Demo 
1. **Démo de l'Application :**
   - Capture d'écran ou vidéo présentant l'interface utilisateur et les principales fonctionnalités de l'application.

---

*Note: Les liens vers les exemples de diagrammes UML sont fournis dans le [lien vers les exemples](https://github.com/yugmerabtene/ESIEA-FISE-WEB-2024/blob/main/Module-04/TP-01.md).*
