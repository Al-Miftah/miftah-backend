# Al-Miftah Api

## Installation steps
### Setup [homestead](https://laravel.com/docs/5.8/homestead) on your PC
### Clone the repository
### Create a `.env` file with contents from `.env.example` file and then update the env variables to suit your taste
### Run `composer install && npm install` to install project dependencies
### Run `php artisan key:generate` to generate the application encryption key
### Run `php artisan migrate` to migrate the database
### Run `php artisan passport:install` to create the encryption keys needed to generate secure access tokens
### Run `php artisan db:seed` to seed the database tables with dummy data



## Project scope
- [ ] Api authentication with passport
- [ ] CRUD Speakers
- [ ] CRUD Topics (Series)
- [ ] CRUD Tags
- [ ] CRUD Speech
- [ ] CRUD Languages
- [ ] Upload audio file with different encodings to a speech
- [ ] A User can ask Questions
- [ ] Any Speaker can respond to a Question
- [ ] A User can favorite a Speech
- [ ] A User can follow a Topic/Series
- [ ] A User get notified when there's a new Speech in a Topic he is following
- [ ] A User can follow/subscribe to a Speaker
- [ ] A User get notified when a Speaker he follows release a new Speech
- [ ] A Speech can be tagged to many available tags or new tag created on the fly
