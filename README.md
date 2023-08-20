# Local Development
```
APP_ENV=local
APP_KEY=base64:OoT644UiWBNqnkCzvP6Po29To+2CcY/p2VIQ7Po4ERw=
APP_DEBUG=true
APP_URL=https://localhost:6443
```
Make sure files under `infrastructure/scripts` are LF not CRLF
- Run `docker compose up -d`
- Container `docker exec -it plex /bin/bash`
- Migrate `php artisan migrate`
- Connect to database `127.0.0.1` port `33306` user `root` password `password`
- https://localhost:6443

Asset bundling with Vite
- `npm run dev`
- Visit https://localhost:5173 to accept the certificate warning

Azure Pipeline requires the following variables
- `REGISTRY_CONNECTION=k8s connection id`
- `IMAGE_REPOSITORY=plex/NEW-APP-NAME`