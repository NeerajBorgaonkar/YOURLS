# GK Links

`GK Links` is your self-hosted link shortener and click-tracking app, built on top of your YOURLS fork and prepared for deployment on a VPS with Coolify.

## What is set up

- YOURLS fork cloned into this repo
- `user/config.php` switched to environment-based runtime config
- Core admin branding updated to use `GK Links` naming
- Install seed links updated for your project
- `Dockerfile` added for containerized deployment
- `docker-compose.coolify.yml` added for a simple Coolify stack with MySQL
- `.env.coolify.example` added with the variables you need

## Project structure

- `user/config.php` - runtime config for YOURLS and GK Links branding
- `Dockerfile` - PHP + Apache image for YOURLS
- `docker/apache-site.conf` - Apache config with rewrite support
- `docker-compose.coolify.yml` - app + MySQL stack for Coolify
- `.env.coolify.example` - environment variable template

## Coolify deployment

### Option 1: Deploy as a Docker Compose application

1. Push this repo to GitHub.
2. In Coolify, create a new resource from Git.
3. Choose **Docker Compose**.
4. Point Coolify to `docker-compose.coolify.yml`.
5. Copy the values from `.env.coolify.example` into Coolify environment variables.
6. Set `YOURLS_SITE` to your final public domain, for example `https://links.yourdomain.com`.
7. Deploy.
8. Open `https://your-domain/admin/install.php` once to initialize the database.

### Option 2: Deploy app only and use a managed MySQL database

If you want Coolify-managed MySQL as a separate resource:

1. Create a MySQL resource in Coolify.
2. Deploy this repo with the `Dockerfile`.
3. Set the environment variables from `.env.coolify.example`.
4. Change `YOURLS_DB_HOST` in Coolify to your managed DB host and port.
5. Open `/admin/install.php` after the container is live.

## Important runtime variables

- `YOURLS_SITE` - public app URL, no trailing slash
- `YOURLS_DB_HOST` - database host, default `db:3306`
- `YOURLS_DB_NAME` - database name
- `YOURLS_DB_USER` - database user
- `YOURLS_DB_PASS` - database password
- `YOURLS_COOKIEKEY` - long random secret for session cookies
- `YOURLS_USER` - admin username provided through environment variables
- `YOURLS_PASSWORD` - admin password provided through environment variables
- `YOURLS_PRIVATE` - keeps admin access protected
- `YOURLS_UNIQUE_URLS` - defaults to `false` so you can create multiple tracked short links for the same destination
- `YOURLS_URL_CONVERT` - defaults to `62` for shorter mixed-case slugs
- `YOURLS_NO_VERSION_CHECK` - leave `false` in production unless you intentionally disable update checks
- `GK_LINKS_PUBLIC_SITE` - public short-link domain shown in the dashboard and copied to clipboard, defaults to `https://marathimarket.in`
- `GK_LINKS_ROOT_REDIRECT_URL` - where bare-domain visits like `/` should land, defaults to `https://www.guntavnook.com`

## Branding controls

These can be set in Coolify without editing code:

- `GK_LINKS_APP_NAME`
- `GK_LINKS_TAGLINE`
- `GK_LINKS_LOGO_URL`
- `GK_LINKS_FOOTER_HTML`

If `GK_LINKS_LOGO_URL` is empty, YOURLS uses its default logo.

## Recommended next steps

1. Point your short domain or subdomain to the VPS.
2. Push this project to your GitHub fork.
3. Import it into Coolify.
4. Fill in the environment variables.
5. Deploy and run `/admin/install.php`.
6. After first login, add any YOURLS plugins you want for advanced tracking or QR codes.
