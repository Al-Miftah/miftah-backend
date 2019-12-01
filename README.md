# Al-Miftah Api

## Installation steps
Setup [homestead](https://laravel.com/docs/5.8/homestead) on your PC
Clone the repository
Create a `.env` file with contents from `.env.example` file and then update the env variables
Run `composer install && npm install` to install project dependencies
Run `php artisan key:generate` to generate the application encryption key
Run `php artisan migrate` to migrate the database
Run `php artisan passport:install` to create the encryption keys needed to generate secure access tokens
Run `php artisan db:seed` to seed the database tables with dummy data
Run `php artisan storage:link` to make uploaded files visible in public folder



## TODO
- [ ] Setup laravel horizon
- [ ] A User can ask Questions
- [ ] Any Speaker can respond to a Question
- [ ] A User can favorite a Speech
- [ ] A User get notified when there's a new Speech in a Topic he is following
- [ ] A User get notified when a Speaker he follows release a new Speech


## External packages
- [Laravel passport](https://github.com/laravel/passport)
