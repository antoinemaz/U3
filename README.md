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

**Partie Candidature :**
- Renseignement des informations d'une candidature
- Liste des stages
- Liste des diplomes
- Ajout de pièces jointes (CV, lettre de motivation...)

**Partie gestionnaire :**
- Création de compte gestionnaire
- Liste des candidatures soumises
- Détail de chaque candidature 

### Reste à faire

- Modification de candidature côté gestionnaire
- Marquage "à revoir" de la candidature
- Changer le type en "longtext" pour Commentaire et tâches, "string" pour CP
- Regex pour le renseignement du téléphone dans la candidature
- Affichage du commentaire du gestionnaire coté étudiant ( en cas de candidature "à revoir")
- Faire apparaitre les états des candidatures
- Une fois les candidatures validées : suppression des informations dans notre base de données, à l'exception du nom, prénom, de l'état, de la filière et de l'année convoitée 
- Insertion de la candidature dans Redmine une fois validée
- Notification de nouvelles candidature : prévoir une configuration pour l'envoi de mails automatique (si pic de candidature, on pourra cocher non pour éviter d'être spammer de mails)
- Possibilité pour le gestionnaire, d'indiquer le(s) filière(s) et le(s) année(s) qu'ils gèrent afin de lister seuelement les candidatures qui lui intérèsse
