# Al-Miftah Api

## Installation steps
1. Setup [homestead](https://laravel.com/docs/5.8/homestead) on your PC
2. Clone the repository
3. Create a `.env` file with contents from `.env.example` file and then update the env variables
4. Run `composer install && npm install` to install project dependencies
5. Run `php artisan key:generate` to generate the application encryption key
6. Run `php artisan migrate` to migrate the database
7. Run `php artisan passport:install` to create the encryption keys needed to generate secure access tokens
8. Run `php artisan db:seed` to seed the database tables with dummy data
9. Run `php artisan storage:link` to make uploaded files visible in public folder



## TODO
- [ ] Forgot password (API)
- [ ] Reset password (API)
- [ ] Verify email (API)
- [ ] A User can ask Questions
- [ ] Any Speaker can respond to a Question
- [ ] A User can favorite a Speech
- [ ] A User get notified when there's a new Speech in a Topic he is following
- [ ] A User get notified when a Speaker he follows release a new Speech


## External packages
- [Laravel passport](https://github.com/laravel/passport)
- [Predis](https://github.com/nrk/predis)
