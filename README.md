
### Connexion to the database

Edit `.env` the line with `DATABASE_URL=mysql://root:root@database:3306/mydatabase`.

`docker rm $(docker ps -aq)`

`docker-compose up -d`

`docker-compose exec composer install`

`docker-compose exec web composer req symfony/asset`

`docker-compose exec web php bin/console asset:install`

### Arboresence
```
public/assets
         |---css/main.css
         |---css/materialize.min.css
         |---js/main.js
         |---js/materialize.min.js
         |---images/
```
 

```
#templates/base.html.twig
    {% extends 'base.html.twig' %}
    {% block title %}Hello {{ controller_name }}!{% endblock %}

    {% block body %}
        <style>
            .example-wrapper { margin: 1em auto; max-width: 800px; width: 95%; font: 18px/1.5 sans-serif; }
            .example-wrapper code { background: #F5F5F5; padding: 2px 6px; }
        </style>

        <div class="example-wrapper">
            <h1>Hello {{ controller_name }} !</h1>

            This friendly message is coming from:
            <ul>
                <li>Your controller at <code><a href="{{ 'src/Controller/HomeController.php'|file_link(0) }}">src/Controller/Controller.php</a></code></li>
                <li>Your template at <code><a href="{{ 'templates/game/index.html.twig'|file_link(0) }}">templates/home/index.html.twig</a></code></li>
                <a class="waves-effect waves-light btn">button</a>
                <a class="waves-effect waves-light btn"><i class="material-icons left">cloud</i>button</a>
                <a class="waves-effect waves-light btn"><i class="material-icons right">cloud</i>button</a>
            </ul>
        </div>
    {% endblock %}
```