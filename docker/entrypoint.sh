#!/bin/bash
set -e

# Wait for MySQL database to be ready
echo "Aguardando o banco de dados iniciar..."
php -r "
\$count = 0;
while (\$count < 30) {
    try {
        new PDO('mysql:host=' . getenv('DB_HOST') . ';port=' . getenv('DB_PORT') . ';dbname=' . getenv('DB_DATABASE'), getenv('DB_USERNAME'), getenv('DB_PASSWORD'));
        echo 'Banco de dados conectado com sucesso!' . PHP_EOL;
        exit(0);
    } catch (Exception \$e) {
        \$count++;
        echo 'Sem conexao com o banco ainda. Tentando novamente em 2s (' . \$count . '/30)...' . PHP_EOL;
        sleep(2);
    }
}
exit(1);
"

# Run migrations
echo "Rodando as migrations..."
php artisan migrate --force

# Optimize Laravel
echo "Limpando caches antigos..."
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Set permissions for storage & cache
echo "Ajustando permissões..."
chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache
chmod -R 775 /var/www/storage /var/www/bootstrap/cache

# Start supervisor
echo "Iniciando o Supervisor..."
exec /usr/bin/supervisord -n -c /etc/supervisor/supervisord.conf
