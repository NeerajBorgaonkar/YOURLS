<?php
/*
 * GK Links configuration
 *
 * This file is safe to commit because it reads runtime settings from
 * environment variables, which fits well with Coolify and container deploys.
 * Authentication stays close to upstream YOURLS by using native env-based
 * credentials instead of custom password handling.
 */

if ( !function_exists( 'gk_links_env' ) ) {
    function gk_links_env( string $key, $default = null ) {
        $value = getenv( $key );
        if ( $value === false || $value === '' ) {
            return $default;
        }

        return $value;
    }
}

if ( !function_exists( 'gk_links_env_bool' ) ) {
    function gk_links_env_bool( string $key, bool $default ): bool {
        $value = getenv( $key );
        if ( $value === false || $value === '' ) {
            return $default;
        }

        return filter_var( $value, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE ) ?? $default;
    }
}

if ( !function_exists( 'gk_links_require_env' ) ) {
    function gk_links_require_env( string $key ): string {
        $value = getenv( $key );
        if ( $value === false || trim( $value ) === '' ) {
            die( sprintf( 'Missing required environment variable: %s', $key ) );
        }

        return trim( $value );
    }
}

if ( !function_exists( 'gk_links_assert_not_placeholder' ) ) {
    function gk_links_assert_not_placeholder( string $key, string $value ): string {
        $placeholder_patterns = [
            'change-this',
            'replace-with',
            'example.com',
            'yourdomain.com',
            'links.example.com',
        ];

        foreach ( $placeholder_patterns as $pattern ) {
            if ( stripos( $value, $pattern ) !== false ) {
                die( sprintf( 'Environment variable %s still contains a placeholder value', $key ) );
            }
        }

        return $value;
    }
}

$yourls_site = gk_links_assert_not_placeholder( 'YOURLS_SITE', gk_links_require_env( 'YOURLS_SITE' ) );
$yourls_db_user = gk_links_assert_not_placeholder( 'YOURLS_DB_USER', gk_links_require_env( 'YOURLS_DB_USER' ) );
$yourls_db_pass = gk_links_assert_not_placeholder( 'YOURLS_DB_PASS', gk_links_require_env( 'YOURLS_DB_PASS' ) );
$yourls_db_name = gk_links_assert_not_placeholder( 'YOURLS_DB_NAME', gk_links_require_env( 'YOURLS_DB_NAME' ) );
$yourls_db_host = gk_links_assert_not_placeholder( 'YOURLS_DB_HOST', gk_links_require_env( 'YOURLS_DB_HOST' ) );
$yourls_cookiekey = gk_links_assert_not_placeholder( 'YOURLS_COOKIEKEY', gk_links_require_env( 'YOURLS_COOKIEKEY' ) );
$yourls_user = gk_links_assert_not_placeholder( 'YOURLS_USER', gk_links_require_env( 'YOURLS_USER' ) );
$yourls_password = gk_links_assert_not_placeholder( 'YOURLS_PASSWORD', gk_links_require_env( 'YOURLS_PASSWORD' ) );

define( 'YOURLS_DB_USER', $yourls_db_user );
define( 'YOURLS_DB_PASS', $yourls_db_pass );
define( 'YOURLS_DB_NAME', $yourls_db_name );
define( 'YOURLS_DB_HOST', $yourls_db_host );
define( 'YOURLS_DB_PREFIX', gk_links_env( 'YOURLS_DB_PREFIX', 'gk_' ) );

define( 'YOURLS_SITE', rtrim( $yourls_site, '/' ) );
define( 'YOURLS_LANG', gk_links_env( 'YOURLS_LANG', '' ) );
define( 'YOURLS_UNIQUE_URLS', gk_links_env_bool( 'YOURLS_UNIQUE_URLS', false ) );
define( 'YOURLS_PRIVATE', gk_links_env_bool( 'YOURLS_PRIVATE', true ) );
define( 'YOURLS_COOKIEKEY', $yourls_cookiekey );
define( 'YOURLS_URL_CONVERT', (int) gk_links_env( 'YOURLS_URL_CONVERT', '62' ) );
define( 'YOURLS_DEBUG', gk_links_env_bool( 'YOURLS_DEBUG', false ) );
define( 'YOURLS_NO_VERSION_CHECK', gk_links_env_bool( 'YOURLS_NO_VERSION_CHECK', false ) );

define( 'GK_LINKS_APP_NAME', gk_links_env( 'GK_LINKS_APP_NAME', 'GK Links' ) );
define( 'GK_LINKS_TAGLINE', gk_links_env( 'GK_LINKS_TAGLINE', 'Your private short-link and tracking platform' ) );
define( 'GK_LINKS_LOGO_URL', gk_links_env( 'GK_LINKS_LOGO_URL', '' ) );
define( 'GK_LINKS_FOOTER_HTML', gk_links_env( 'GK_LINKS_FOOTER_HTML', 'Powered by <a href="https://github.com/NeerajBorgaonkar/YOURLS" title="GK Links source">GK Links</a>' ) );

$yourls_user_passwords = [
    $yourls_user => $yourls_password,
];

define( 'YOURLS_USER', $yourls_user );
putenv( 'YOURLS_PASSWORD=' . $yourls_password );
