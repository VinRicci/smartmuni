<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# Local Development

Make sure files under `infrastructure/scripts` are LF not CRLF
- create file .env
- Copy file `.env.example` to `.env`
- Run `docker compose up -d`
- Container `docker exec -it smartmuni /bin/bash` o install an extenson the docker in vscode
- Migrate `php artisan migrate`
- Seed `php artisan db:seed`
- Connect to database `127.0.0.1` port `33306` user `root` password `password`
- https://localhost:6443

Asset bundling with Vite
- `npm run dev`
- Visit https://localhost:5173 to accept the certificate warning

## Available Filament Shield Commands

#### `shield:generate`
Generate Permissions and/or Policies for Filament entities. Accepts the following flags: 
- `--all`                    Generate permissions/policies for all entities
- `--option[=OPTION]`        Override the config generator option(`policies_and_permissions`,`policies`,`permissions`)
- `--resource[=RESOURCE]`    One or many resources separated by comma (,)
- `--page[=PAGE]`            One or many pages separated by comma (,)
- `--widget[=WIDGET]`        One or many widgets separated by comma (,)
- `--exclude`                Exclude the given entities during generation
- `--ignore-config-exclude`  Ignore config `exclude` option during generation

```bash
php artisan shield:generate --all
```

#### `shield:super-admin` 
Create a user with super_admin role.
- Accepts an `--user=` argument that will use the provided ID to find the user to be made super admin.

```bash
php artisan shield:super-admin --user=1
```
