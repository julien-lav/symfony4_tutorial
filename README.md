
## Connexion to the database & run the docker-compose.yml

Edit `.env` the line with `DATABASE_URL=mysql://root:root@database:3306/mydatabase`

`docker rm $(docker ps -aq)` 

`docker-compose up -d`

if you need to stop `docker-compose down`

#### Composer install 

`docker-compose exec web composer install`

`docker-compose exec web composer req symfony/asset`

`docker-compose exec web php bin/console asset:install`

We can get rid of the "docker-compose exec web" in entering the docker bash

`docker-compose exec web bash` so now you can type directly php bin/console <ANYTHING>
    
## Adding Materialize

### Arboresence
```
public/assets
         |---css/main.css
         |---css/materialize.min.css
         |---js/main.js
         |---js/materialize.min.js
         |---images/
```
 

In vendor/symfony/twig-bridge/Resources/views/Form

    - copy/past: materialize_layout.html.twg

You'll find it here : https://gist.github.com/JusteLeblanc/da4d2100fc966e0962e5f50daf9333f9

### config/package/twig.yaml
```
twig:
  form_themes:
    - 'materialize_layout.html.twig'
```

### We link all this
```
#templates/base.html.twig
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <title>{% block title %}Welcome!{% endblock %}</title>
        <link rel="icon" type="image/x-icon" href="{{ asset('assets/favicon.ico') }}" />
        <!-- import icons from both materialize and font-awesome-->
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
        <!-- Adding Materialize.css -->
        <link href="{{ asset('assets/css/materialize.min.css') }}" rel="stylesheet"/>
        <link href="{{ asset('assets/css/main.css') }}" rel="stylesheet"/>
        {% block stylesheets %}{% endblock %}
    </head>
    <body>
        <div class="navbar-fixed">
            ...
        </div>

        {% block body %}{% endblock %}

        {% block javascripts %}
            <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
            <script type="text/javascript" src="{{ asset('assets/js/materialize.min.js') }}"></script>
            <script type="text/javascript" src="{{ asset('assets/js/main.js') }}"></script>
        {% endblock %}
    </body>
</html>
```

## Use of UserRepository

#### So thanks to UserRepository, this :
```
public function delete(Request $request, int $id) 
    {
           $user = $this
                    ->getDoctrine()
                    ->getRepository(User::class)
                    ->find($id);
            ...
```

#### Becomes this :
```
public function delete(Request $request, UserRepository $userRepository, int $id) 
    {
            $user = $userRepository->find($id);
            ...
```


## SecurityController

`composer require symfony/security`

`composer require symfony/security-bundle`


## Building a filter

#### Add an url/embed filter
We need to do it so because users may introduce different kinds of link, so we have to treat them all.

`composer require twig/extensions`

```
// src/Twig/AppExtension.php

<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class AppExtension extends AbstractExtension
{
    public function getFilters()
    {
        return array(
            new TwigFilter('embed', array($this, 'embedFilter')),
        );
    }
    public function embedFilter($string)
    {
        $cutMe = 'watch?v=';
        $orMe = 'youtu.be';
        $newString = str_replace($cutMe, "embed/", $string);    
        $resultString = str_replace($orMe, "www.youtube.com/embed", $newString);
        return $resultString;
    }
}
```

```
# config/services.yaml
services:
    App\Twig\AppExtension:
        public: false
        tags: ['twig.extension']
```

Now in the <iframe> we have to filter the url in order to link the video

```
{{ tutorial.link|embed(tutorial.link) }}
```

And in our " <a href=" {{ tutorial.link|replace({'embed/':'watch?v='}) }} ">direct link</a>"
On the otherside the user could have copy/past the embed version of our link, so we simply filter that using replace {{ tutorial.link|replace({'embed/':'watch?v='}) }}   