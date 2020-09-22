# Bookia

Bookia is a RESTful API to store and retrieve book titles and authors. It is build using [Lumen](https://lumen.laravel.com/). To authorise requests to the API, it uses [Auth0 JWT](https://auth0.com/).

## Set Up Instructions

Clone the project and install its dependencies

```bash
git clone git@github.com:arturjzapater/bookia.git
cd bookia
compose install
```

Create a copy of the [`.env.example`](.env.example) file, rename it as `.env` and generate a new key

```bash
cp -a .env.example .env
php artisan key:generate
```

Configure your database environment. You will need to update the following environment variables to match your MySQL settings:
- `DB_DATABASE`
- `DB_USERNAME`
- `DB_PASSWORD`

Run the dabase migrations:

```bash
php artisan migrate
```

You will also need to have an [Auth0 account](https://auth0.com/signup) and [Create a new API service](https://manage.auth0.com/dashboard/eu/dev-pixie/apis). Once that's done, you will need to set up the following environment variables:
- `AUTH0_DOMAIN` with your account's domain
- `AUTH0_AUD` with your API's audience

You will also need to create the following scopes in your API:
- `create`
- `delete`