# Installation

1. Install composer (if you don't already have it installed)
2. In main directory create file ".env.local" and copy code form ".env" file
3. In ".env.local" file uncomment line 30 and configure connection for your database
4. Go with "composer install" command
5. Go with "php bin/console doctrine:migration:migrate" command
6. Go with "php bin/console doctrine:fixtures:load"
7. Go with "php bin/console server:run" command
8. Go to page http://127.0.0.1:8000
9. You can now use one of already generated account (pass for all: "User123") to log in or register the new one
10. Enjoy!!!
