# Objectifs

Créer une application packagée en **un binaire unique**, à partir d’un backend PHP (servi par **FrankenPHP**, **Laravel** avec **API Platform**, d’un frontend en CLI, le tout avec une architecture en **monorepo**

Le but de cette application est de m’exercer à un travail **fullstack**, sur un projet qui répond à un de mes besoins présents : **centraliser ma prise de note** en prévision d’une fiche de lecture, d’une présentation, etc.

J’ai une affection particulière pour **le terminal** et j’ai décidé de tester ici la création d’une application CLI puis TUI pour satisfaire ma dernière lubie. 

De plus, j’aimerais aller au bout de cet projet en proposant **un binaire** afin de pouvoir partager facilement mon projet sans configuration ou installation compliquée. 

# Oui, mais c’est quoi cette application ?

C’est pouvoir centraliser de la prise de notes via le terminal. 
Aujourd’hui, j’utilise [Raindrop.io](https://raindrop.io/) pour sauvegarder et annoter des pages que je veux lire et dont je veux tirer des informations. J’aime beaucoup cette application, et je n’ai rien à lui reprocher. 

J’ai juste envie de faire quelque chose d’approchant, dans le terminal. 

Par exemple :
```
./notetaker add:link https://www.researchgate.net/publication/256848134_Effects_of_Test-Driven_Development_A_Comparative_Analysis_of_Empirical_Studies --folder TDD and TDAH --tags TDD,toread --description "Article sur les impacts du TDD"
./notetaker add:note 1 --content "Abstract. Test-driven development is a software development practice where small sections of test code are used to direct the development of program units. Writing test code prior to the production code promises several positive effects on the development process itself and on associ- ated products and processes as well. However, there are few comparative studies on the effects of test-driven development. Thus, it is difficult to assess the potential process and product effects when applying test- driven development. In order to get an overview of the observed effects of test-driven development, an in-depth review of existing empirical studies was carried out. The results for ten different internal and external quality attributes indicate that test-driven development can reduce the amount of introduced defects and lead to more maintainable code. Parts of the implemented code may also be somewhat smaller in size and complexity. While maintenance of test-driven code can take less time, initial devel- opment may last longer. Besides the comparative analysis, this article sketches related work and gives an outlook on future research." --type abstract 
./notetaker export:link 1 
```

Est-ce que j’utiliserais mon propre outil ? Peut-être. Mais j’ai surtout envie de le faire.

# Comment je vais m’y prendre ?

D’abord, avec une approche **TDD**. C’est aujourd’hui ce qui me semble le plus évident pour avancer sereinement dans les étapes de code sans perdre de vue un objectif précis. À ce titre, j’ai préparé une documentation **Astro** qui me permettra de documenter et de valider ma roadmap au fur et à mesure. 

Ensuite, je veux d’abord créer un **Proof of Concept** afin de valider la validité de mon projet. 
Si je ne peux pas faire de binaire unique, je changerai de tactique. 

# Mon POC
- Créer un binaire qui permet d’exécuter un front en ligne de commande qui appelle une API locale

# Mon MVP
- Une API qui permet de créer des liens
- Un CLI qui consomme cette API et qui exporte un fichier .md

# Installation
À vrai dire j’en sais rien. C’est initialisé avec [Moonrepo](https://moonrepo.dev/), mais j’imagine qu’il faut installer le contenu de chaque projet ? Peut-être faut-il que j’ajoute une tâche "install" dans ma config ? Il faudra que j’essaie. 

# Configuration
Personnellement, j’ai configuré mon /etc/hosts de cette façon:
```bash
127.0.0.1 local.test
127.0.0.1 backend.local.test
127.0.0.1 docs.local.test
```

Grâce à Caddy (`moon run caddy:dev`), vous pourrez accéder aux pages avec http://backend.local.test et http://docs.local.test

# Utilisation
```
moon run :dev
```

# Comment m’encourager ?

Des pouces en l’air, des conseils, des *iced mocha*, des sessions de body doubling sur FocusMate ou de la revue de code… Si vous passez sur ce repos, laissez un coucou, ça fera plaisir !
