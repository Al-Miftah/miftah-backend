# Al-Miftah Backend API

API docs available at `/api/developer/docs`

## Installation & Setup
1. Setup [homestead](https://laravel.com/docs/5.8/homestead) on your PC
2. Clone the repository `git clone https://github.com/Al-Miftah/miftah-backend.git`
3. Create a `.env` file with contents from `.env.example` file and then update the env variables
4. Run `composer install && npm install` to install project dependencies
5. Run `npm run dev` to build css and js assets if any
6. Run `php artisan key:generate` to generate the application encryption key
7. Run `php artisan migrate --seed` to migrate and seed the database
8. Run `php artisan passport:install` to create the encryption keys needed to generate secure access tokens
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

## Run tests
`./vendor/bin/phpunit`

## TODO
- [ ] Apply authorization to appropriate resources
- [ ] A User get notified when there's a new Speech in a Topic (Series) he/she is following
- [ ] Add status page for email and password reset verification
