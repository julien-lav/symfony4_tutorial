

.env

docker rm $(docker ps -aq)
docker-compose up -d

docker-compose exec composer install
docker-compose exec web composer req symfony/asset

docker-compose exec web php bin/console asset:install

public/assets
         |---css/main.css
         |---css/materialize.min.css
         |---js/main.js
         |---js/materialize.min.js
         |---images/


#templates/base.html.twig

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>{% block title %}Welcome!{% endblock %}</title>
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

        {% block stylesheets %}
        	<link href="{{ asset('assets/css/materialize.min.css') }}" rel="stylesheet"/>
  			<link href="{{ asset('assets/css/main.css') }}" rel="stylesheet"/>
        {% endblock %}
    </head>
    <body>
        {% block body %}{% endblock %}
       

        {% block javascripts %}
        	<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
  			<script type="text/javascript" src="{{ asset('assets/js/materialize.min.js') }}"></script>
        {% endblock %}
    </body>
</html>
        
