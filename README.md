# Test-Laravel

Laravel to-do application using Sanctum cookie authentication (SPA-style). It ships with a simple UI at `/tasks` that covers registration, login/logout, listing tasks, creating/updating/deleting, and toggling completion.

## Requirements
- PHP 8.2+
- Composer
- SQLite (default DB at `database/database.sqlite`)
- Optional: Node.js for asset tooling

## Quick Setup
1) Copy environment file:
   - `cp .env.example .env`
2) Generate app key:
   - `php artisan key:generate`
3) Ensure database file exists:
   - Create an empty file: `database/database.sqlite`
4) Run migrations:
   - `php artisan migrate`

Environment tips:
- Set `APP_URL` in `.env` to your local URL (e.g. `http://127.0.0.1:8000`).
- `SANCTUM_STATEFUL_DOMAINS` includes `127.0.0.1` by default for same-origin cookie requests.

## Run Locally
- Start server: `php artisan serve`
- Open: `http://127.0.0.1:8000/tasks`

## Authentication (Sanctum via cookies)
This app uses Sanctum in SPA mode. All task routes run under `web + auth:sanctum` and are treated as stateful requests using cookies.

Expected browser flow:
- Get CSRF first: `GET /sanctum/csrf-cookie`
- For mutating requests (POST/PUT/PATCH/DELETE) send `X-XSRF-TOKEN` header with the value from `XSRF-TOKEN` cookie, and use `credentials: 'same-origin'`.

Endpoints
- Session:
  - `POST /api/session/login` (email, password)
  - `GET  /api/session/user`
  - `POST /api/session/logout`
- Registration:
  - `POST /api/register` (with CSRF and cookies)
- Tasks:
  - `GET    /api/tasks`
  - `POST   /api/tasks`
  - `PUT    /api/tasks/{task}`
  - `PATCH  /api/tasks/{task}/toggle`
  - `DELETE /api/tasks/{task}`

Routing note:
- Task routes were placed in `routes/web.php` under `prefix('api')->middleware(['web','auth:sanctum'])` to ensure SPA cookie handling.

## `/tasks` UI
- See `resources/views/tasks.blade.php`.
- `ensureCsrf()` fetches the CSRF cookie and reads `XSRF-TOKEN`.
- `register`, `login`, `createTask`, `toggleTask`, `deleteTask` send `X-XSRF-TOKEN` and use `credentials: 'same-origin'`.

## Common Commands
- Install deps: `composer install`
- Migrate: `php artisan migrate`
- Run: `php artisan serve`
- Create a test user: use the registration section on `/tasks`.

## Security Notes
- Do not commit `.env` (ignored by `.gitignore`).
- When calling from outside the browser, always fetch CSRF and send `X-XSRF-TOKEN` or you will get 419.

## Troubleshooting
- 401 on `GET /api/tasks`: you are not logged in—login first, then refresh.
- 419 on `POST /api/register`: CSRF missing—call `/sanctum/csrf-cookie` and send `X-XSRF-TOKEN` with cookies.

## License
Provided for educational and demo purposes.

## Author
Salman Alzahrani — All rights reserved.

— For Arabic version, see: [README.ar.md](./README.ar.md)