#!/bin/bash
# Script completo para corregir todos los permisos de Laravel

echo "🔧 Corrigiendo permisos completos de Laravel..."

cd /home/grupo25sa/tecno || exit 1

# 1. Crear todos los directorios necesarios si no existen
echo "📁 Creando directorios necesarios..."
mkdir -p storage/framework/cache/data
mkdir -p storage/framework/sessions
mkdir -p storage/framework/views
mkdir -p storage/logs
mkdir -p storage/app/public
mkdir -p bootstrap/cache

# 2. Eliminar y recrear el archivo de log
echo "📝 Recreando archivo de log..."
rm -f storage/logs/laravel.log
touch storage/logs/laravel.log

# 3. Dar permisos de escritura (sin chown ya que puede no tener permisos)
echo "🔐 Aplicando permisos..."
chmod -R 777 storage
chmod -R 777 bootstrap/cache

# 4. Permisos específicos para el archivo de log
chmod 666 storage/logs/laravel.log

# 5. Verificar permisos
echo ""
echo "✅ Permisos aplicados"
echo ""
echo "📋 Verificando:"
ls -ld storage/
ls -ld storage/logs/
ls -la storage/logs/laravel.log
ls -ld bootstrap/cache/

echo ""
echo "💡 Si aún hay problemas, puede ser necesario que el administrador ejecute:"
echo "   sudo chown -R grupo25sa:apache storage bootstrap/cache"
echo "   sudo chown grupo25sa:apache storage/logs/laravel.log"

