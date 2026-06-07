# Deployment Verification Report

## Scope

This report verifies the `GK Links` deployment scaffold after hardening the project for production-style YOURLS deployment on Coolify.

## Verified fixes

- Authentication now uses native YOURLS environment credentials via `YOURLS_USER` and `YOURLS_PASSWORD`.
- Cleartext fallback credentials were removed from `user/config.php`.
- Required deployment variables now fail fast when missing or left as placeholders.
- Coolify compose no longer publishes a direct host port.
- MySQL no longer forces the legacy `mysql_native_password` plugin.
- YOURLS version checks are enabled by default again.

## Files reviewed

- `user/config.php`
- `docker-compose.coolify.yml`
- `.env.coolify.example`
- `Dockerfile`
- `docker/apache-site.conf`
- `includes/functions-html.php`
- `admin/install.php`
- `includes/functions-install.php`

## Readiness status

### Ready with conditions

The project is structurally ready for deployment **once real environment variables are provided in Coolify**.

## Remaining pre-deploy requirements

- Set real values for `YOURLS_SITE`, `YOURLS_DB_USER`, `YOURLS_DB_PASS`, `YOURLS_DB_NAME`, `YOURLS_DB_HOST`, `YOURLS_COOKIEKEY`, `YOURLS_USER`, `YOURLS_PASSWORD`, and `MYSQL_ROOT_PASSWORD`.
- Ensure your Coolify application is attached to a public domain and reverse proxy route before first install.
- Confirm the target MySQL 8.0 instance is reachable from the app container.

## Notes

- This audit was static. Local runtime validation could not be executed because `php`, `composer`, and `docker` are not installed in the current shell environment.
- YOURLS core changes remain limited to branding and seed-link adjustments; authentication behavior now stays close to upstream implementation.
