#!/bin/bash
# Script completo para corregir permisos y verificar .env

echo "🔧 Corrigiendo problemas del servidor..."

cd /home/grupo25sa/tecno || exit 1

# 1. Corregir permisos de storage/logs
echo "📁 Corrigiendo permisos de storage/logs..."
rm -f storage/logs/laravel.log
touch storage/logs/laravel.log
chmod 666 storage/logs/laravel.log
chown grupo25sa:apache storage/logs/laravel.log
chmod -R 775 storage/logs
chown -R grupo25sa:apache storage/logs

# 2. Corregir permisos de storage/framework
echo "📁 Corrigiendo permisos de storage/framework..."
chmod -R 775 storage/framework
chown -R grupo25sa:apache storage/framework

# 3. Corregir permisos de bootstrap/cache
echo "📁 Corrigiendo permisos de bootstrap/cache..."
chmod -R 775 bootstrap/cache
chown -R grupo25sa:apache bootstrap/cache

# 4. Verificar .env - buscar problemas de contraseña
echo "🔍 Verificando .env..."
if grep -q "DB_PASSWORD" .env; then
    echo "✅ DB_PASSWORD encontrado en .env"
    DB_PASS=$(grep "^DB_PASSWORD=" .env | cut -d '=' -f2)
    if [ -z "$DB_PASS" ] || [ "$DB_PASS" = "" ]; then
        echo "⚠️  DB_PASSWORD está vacío o no está configurado correctamente"
        echo "   Verifica que la contraseña esté correcta en .env"
    fi
else
    echo "❌ DB_PASSWORD no encontrado en .env"
fi

# 5. Limpiar caches
echo "🧹 Limpiando caches..."
php artisan config:clear
php artisan route:clear
php artisan optimize:clear

echo ""
echo "✅ Permisos corregidos"
echo ""
echo "📋 Verificando:"
ls -la storage/logs/laravel.log
ls -ld storage/logs/
ls -ld storage/framework/views/

echo ""
echo "💡 Si el error de PostgreSQL persiste, verifica:"
echo "   1. La contraseña en .env: DB_PASSWORD=..."
echo "   2. Que la contraseña no tenga caracteres especiales que necesiten escape"
echo "   3. Que el usuario grupo25sa tenga acceso a la base de datos"

