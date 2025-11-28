#!/bin/bash
# Script para corregir permisos y verificar formato de fecha

echo "🔧 Corrigiendo permisos de storage/logs..."

cd /home/grupo25sa/tecno || exit 1

# 1. Corregir permisos de storage/logs
rm -f storage/logs/laravel.log
touch storage/logs/laravel.log
chmod 666 storage/logs/laravel.log
chmod -R 775 storage/logs
chmod -R 775 storage/framework
chmod -R 775 bootstrap/cache

echo "✅ Permisos corregidos"
echo ""
echo "📋 Verificando permisos:"
ls -la storage/logs/laravel.log
ls -ld storage/logs/

echo ""
echo "💡 Si los permisos no se pueden cambiar con chown, los permisos 666 y 775 deberían ser suficientes"

