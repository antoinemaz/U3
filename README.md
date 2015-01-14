### Contexte

U3 est un projet informatique qui a pour but de traiter des candidatures de différentes filières de l'université d'Evry.

Actuellement, les candidatures reçues sont rescenceés dans un outil nommé Redmine. Chaque responsable doit reprendre chaque candidature papier pour les insérer dans cet outil.

La plateforme en cours de développement est un espace permettant de gérer les candidatures, avant qu'elles soient intégrées dans Redmine. Les candidatures transférées dans Redmine sont alors acceptées administrativement.

### Outils et langages utilisés

- PHP et Laravel (framework PHP basé sur Symphony)
- HTML, CSS, JQuery (Javascript)
- WAMP : Apache, Mysql, PHP 
- MySQL
- GitHub
- VMWare : nous avons récupéré une image Ubuntu avec Redmine d'installé 
- Redmine et l'utilisation de ses web services à disposition
- SublimeText (éditeur texte)
- Des APIs pour le datepicker, l'ouverture des PDFs sur la page web...

### Fonctionnalités développées

**Partie utilisateur :**
- Inscription de l'utilisateur
- Mot de passe oublié
- Connexion utilisateur
- Changer mot de passe

**Partie Candidature :**
- Formulaire de candidature : informations de l'étudiant et formation(s) désirée(s)
- Renseignement des stages
- Renseignement des diplomes
- Ajout de pièces jointes (CV, lettre de motivation...)
- Page d'envoie de la candidature

**Partie gestionnaire :**
- Page de configuration : 
  -> Filtre des candidatures : choix de plusieurs couples filiere/année afin de pouvoir afficher les candidatures qui concernent les gestionnaires
- Liste des candidatures filtrées 
- Détail de chaque candidature : Informations de la candidatures, diplômes, stages et PJs (PDFs) ouvertes direcement dans la page. Toutes ces informations sont présentes sur une seule page. 
- Pour une candidature, le gestionnaire peut choisir l'état : A revoir, validée, ou refusée. En cas de validation, la candidature est transférée dans Redmine.

**Partie administrateur :**
Hérite des actions du gestionnaires.  
- Page de configuration : 
  -> Création de compte gestionnaire ou administrateurs
  -> Choix de la période d'inscription et option d'envoi de mails aux gestionnaires en cas de nouvelles candidatures
  -> Purge des données (étudiants/candidatures/stages/diplômes/pièces jointes)

### Reste à faire

- Choix d'un répertoire pour stocker les pièces jointes
- Intégration de l'application sur un serveur 
