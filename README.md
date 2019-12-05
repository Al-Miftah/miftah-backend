# Al-Miftah Backend API

## Installation & Setup
1. Setup [homestead](https://laravel.com/docs/5.8/homestead) on your PC
2. Clone the repository
3. Create a `.env` file with contents from `.env.example` file and then update the env variables
4. Run `composer install && npm install` to install project dependencies
5. Run `php artisan key:generate` to generate the application encryption key
6. Run `php artisan migrate` to migrate the database
7. Run `php artisan passport:install` to create the encryption keys needed to generate secure access tokens
8. Run `php artisan db:seed` to seed the database tables with dummy data
9. Run `php artisan storage:link` to make uploaded files visible in public folder


## Deployment instructions
1. Review official [Guide](https://laravel.com/docs/6.x/deployment)
2. Tweak `.env` variables for production
3. Install Supervisor, Redis
4. Run migrations and seeders (if any)
5. Generate and link public and private oauth keys for passport

## External packages used
- [Laravel passport](https://github.com/laravel/passport)
- [Predis](https://github.com/nrk/predis)


## TODO
- [ ] Forgot password (API)
- [ ] Reset password (API)
- [ ] Verify email (API)
- [ ] Favorite a Question
- [ ] Favorite an Answer
- [ ] Apply authorization to appropriate resources
- [ ] A User get notified when a Speaker he/she follows release a new Speech
- [ ] A User get notified when there's a new Speech in a Topic (Series) he/she is following