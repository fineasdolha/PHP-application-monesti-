# Monestie
## _le site_

[![N|Solid](https://th.bing.com/th/id/OIP.8dnEpGYrdV5fDsfpEv19qQAAAA?pid=ImgDet&w=182&h=182&c=7)](https://nodesource.com/products/nsolid)
[![N|Solid](https://th.bing.com/th?id=OIP.eaNty4-p2nNxs-7VAHypzQHaDt&w=350&h=175&c=8&rs=1&qlt=90&o=6&pid=3.1&rm=2)](https://github.com/fineasdolha/PHP-application-monesti-.git)


Il s'agit d'un site qui permet à une personne de mettre à disposition une ou plusieurs salles à une ou plusieurs associations. 
Ce site à 3 accès:
- Les administrateurs
- Les adhérents des associations
- L'entreprise de ménage

## Les associations

    Ce site permet aux associations de reserver ponctuellement par association ainsi que d'afficher les images de leurs événments par 
    association. Les personnes de l'association peuvent communiquer au sein d'une meme 
    association via un fil de conversation. Ils peuvent également contacter le service
    de nettoyage et l'administrateur en cas de problème.
    
## Les administrateurs

    Ils peuvent voir toutes les conversations ainsi que consulter, ajouter et supprimer :
        - les salles
        - les utilisateurs (adhérents, personnel nettoyage et administrateurs)
        - les associations
        - les interventions du personnel de nettoyage (consultation seulement)
    Ils sont les seuls à ajouter, modifier et supprimer les réservations récurrentes
    des associations ainsi que les reservations ponctuelles si besoin.
    
## Le service de nettoyage

    Ils peuvent enregistrer leurs interventions. Si ils ont fait le ménage, ils cliquent 
    sur un bouton, indiquent le nombre d'heures effectuées. L'enregistrement n'est possible 
    qu'une fois par connection. Ils ont la possibilité d'annuler le dernier enregistrement 
    si ils se sont trompés.
    Ils peuvent aussi communiquer avec les différents groupe si besoin, cependant ils 
    ne peuvent consulter que les messages addressés à leur service.
    
## L'organisation

> Pour ce travail, nous avons dû tout créer le merise de la base de donnée, la base de donnée
> sur PhpMyAdmin avec WampServer.
Pour ce projet, nous avons travaillé à deux.
- Fineas Dolhas pour la gestion principalement du calendrier de réservation
- Alix Thèse pour la gestion des conversations inter-groupe et les tables de gestion des administrateurs.

>Nos grandes difficultés ont été dans la constitution de notre base données, car nous n'avions pas
> anticipés certains besoins. Cependant les modifications ont été possible au cours du projet et cela
> nous à permis de mieux en comprendre le fonctionnement.

## Languages

Pour le code, nous avons utilisé :

- [Fullcalendar] - Calendrier sur lequel on fait les reservations
- [FreeFrontend] - Conversation avec formulaire
- [Datatable] - Tableau affichage informations
- [Bootstrap] - framework pratique pour afficher les modals ,le carrousel et menu navigation
- [Dillinger] - Pour visualiser le text en Markdown en parallèle.

## Accès au site

Pour vous connecter, vous trouverez dans notre gitHub :
- la base de donnée nommée monestie :  root mdp : ''
- pour la connection au site vous avez :
-- l'administrateur : at@gmail.com   mot de passe : 123456
-- personne association : ff@gmail.com mot de passe : 123456 association 4
vm@gmail.com mot de passe : 123456 association 3
--  personnel ménage : f2m@gmail.com mdp : 123456 et mp@gmail.com mdp : 123456
Vous l'avez compris les mot de passe sont tous 123456 et toutes les personnes enregistrées sont
 purement fictives, ainsi que les adresses mails. A vous de vous amuser et de créer vos accès.




[//]: # (These are reference links used in the body of this note and get stripped out when the markdown
processor does its job. There is no need to format nicely because it shouldn't be seen. Thanks SO -
http://stackoverflow.com/questions/4823468/store-comments-in-markdown-syntax)

   [Fullcalendar]: <https://fullcalendar.io/>
   [FreeFrontend]: <https://freefrontend.com/bootstrap-comments/>
   [Datatable]: <https://datatables.net/>
   [Bootstrap]: <https://getbootstrap.com/>
[Dillinger]: <https://dillinger.io/>
