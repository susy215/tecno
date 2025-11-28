#!/bin/bash
# Script para verificar que todo funciona correctamente

echo "🔍 Verificando funcionamiento de Laravel..."

cd /home/grupo25sa/tecno || exit 1

# 1. Verificar permisos
echo "📋 Verificando permisos:"
echo "storage/logs/laravel.log:"
ls -la storage/logs/laravel.log
echo ""
echo "bootstrap/cache/:"
ls -ld bootstrap/cache/
echo ""
echo "storage/framework/cache/:"
ls -ld storage/framework/cache/ 2>/dev/null || echo "⚠️  No se puede acceder a storage/framework/cache/"

# 2. Verificar que Laravel puede escribir
echo ""
echo "🧪 Probando escritura en storage/logs..."
php artisan tinker --execute="Log::info('Test de permisos');" 2>&1 | head -5

# 3. Verificar rutas
echo ""
echo "🛣️  Verificando rutas:"
php artisan route:list | grep -E "products\.(store|update)" | head -3

# 4. Verificar directorio de imágenes
echo ""
echo "🖼️  Verificando directorio de imágenes:"
ls -ld public/product_images/ 2>/dev/null || echo "⚠️  Directorio product_images no existe"

echo ""
echo "✅ Verificación completa"

