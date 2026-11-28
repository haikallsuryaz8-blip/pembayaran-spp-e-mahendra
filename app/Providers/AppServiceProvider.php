<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Custom Postgres Connector for Neon Cloud SNI compatibility on older libpq
        $this->app->bind('db.connector.pgsql', function () {
            return new class extends \Illuminate\Database\Connectors\PostgresConnector {
                protected function getDsn(array $config)
                {
                    $dsn = parent::getDsn($config);
                    if (isset($config['host']) && strpos($config['host'], 'neon.tech') !== false) {
                        $endpoint = explode('.', $config['host'])[0];
                        $endpoint = str_replace('-pooler', '', $endpoint);
                        $dsn .= ";options='endpoint={$endpoint}'";
                    }
                    return $dsn;
                }
            };
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') {
            \Illuminate\Support\Facades\URL::forceScheme('https');
        }
    }
}
