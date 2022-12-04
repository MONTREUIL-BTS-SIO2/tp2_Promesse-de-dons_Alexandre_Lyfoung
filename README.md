# READ ME PROMESSE DE DON
### Requirement
- Symfony
- Composer
- Php
- Docker
- MySQL
- GitHub
- A browser (Google Chrome, Firefox, Edge ...)

### Install the Project
Git Clone the project 
````
git@github.com:MONTREUIL-BTS-SIO2/tp2_Promesse-de-dons_Alexandre_Lyfoung.git
````

Then in the CLI, in the directory "tp2_Promesse-de-dons_Alexandre_Lyfoung"

1) Install Composer
````
composer install
````

2) Create the docker container
````
docker compose create
````
Start the containers
````
docker compose up -d
````
3) Create .env file
Open the project with a Php Editor (Like PhpStorm)
then copy at the root the .env-exemple and rename it ".env"

Change the line 
````
 # DATABASE_URL="mysql://app:!ChangeMe!@127.0.0.1:3306/app?serverVersion=8&charset=utf8mb4"
````

Into 
````
DATABASE_URL="mysql://root:sio@127.0.0.1:3306/promessedon?serverVersion=8&charset=utf8mb4"
````

### Start the Project

You can now start the project.

To do this you must load the fixtures.

Type those command in your terminal:
``symfony console doctrine:migrate:migrations``
``composer require fakerphp/faker``
``symfony console doctrine:fixtures:load``

This will load a set of Entity Campagne, Don and create 1 user that will be the Authenticated user.

Now use this command : ``symfony serv:start``
and by typing "localhost:8000" in your url search bar you will have the project on your web browser or in your terminal next to the sentence **"Local Web Server    Listening on"** there will be the url of our web server : click on this.
    
### How do it work ?

First you will have this page :
![HomePage](HomePage.PNG)

There is many option here:
- You can authenticate yourself with the user pre-registered by clicking on **"Login"**
Email : user@ort.fr
Password: password
You will be an Authenticated user.

- You can click on the button **"Campagne"** to get access of the list of donation campaign.

-By clicking on **"Accueil"** you will return on this page

#### As an non authenticated user

You have clicked on the button before login so you will have this page : 
![Campagne_liste_ano](VoirDons-user.PNG)

On this page you can make a donation for one of a campaign by clicking on the button **"Faire une promesse de don"**

You will have this page then :
![PromesseDon_New](CreateDon-Ano.PNG)

You just have to fill the form with your information and then click on the button **"Valider"** and your donation will be accepted.

#### As an authenticated user

Your home page will be like this :
![HomeUser](HomeUser.PNG)

You can see that you are authentificated with the email that appear in the navbar.

You will also have an new option called **"Stat"** but that for later.

By clicking on **"Campagne"**

Your interface will be like this :
![Campagne-user](campagne-user.PNG)

Like the annonymous user you can make a donation but you can also check the donation campaign with the button **"Voir Campagne"**
- This will display this page : 
 ![ShowCampagne](ShowCampagne.PNG)  
 and you can modify the donation campaign
 ![ModifyCampagne](ModifyCampagne.PNG)
 > if checkbox **"Active"** is checked annonymous user can not see this donation campaign


If you click on **"Voir les Dons"** you will have this :
![VoirListeDons](VoirDons-user.PNG)

On this page you can modify a donation or see a donation

**"Visualiser"** button display :
![VoirDon](VoirDon.PNG)

**"Modifier"** button display:
![ModifierDon](ModifierDon.PNG)

> Note: You can now put a date when the donation has been done

To Finish you have access to the page **"Stats"** 
![StatsPage](Stat.PNG)
It's show you the 3 campaign that has the most donation, the most received donation and the 3 that has the better ratio between received and get promises.

### Support
This project is a student project here the documentation :
 [https://gentle-jewel-8bf.notion.site/TP-2-Application-de-promesses-de-dons-afe8b72ecf15491eba0b0885c1b82f5b](https://gentle-jewel-8bf.notion.site/TP-2-Application-de-promesses-de-dons-afe8b72ecf15491eba0b0885c1b82f5b "https://gentle-jewel-8bf.notion.site/TP-2-Application-de-promesses-de-dons-afe8b72ecf15491eba0b0885c1b82f5b")

### Authors
By Alexandre Lyfoung

### Project Status
For now (04/12/22) the development of this project not will continue. But maybe some day i will return 🤓.


