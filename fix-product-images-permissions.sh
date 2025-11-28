#!/bin/bash
# Script para corregir permisos del directorio product_images

echo "🔧 Corrigiendo permisos de product_images..."

cd /home/grupo25sa/tecno || exit 1

# 1. Crear el directorio si no existe
mkdir -p public/product_images

# 2. Dar permisos máximos (777) para que Apache pueda escribir
chmod -R 777 public/product_images

# 3. Verificar permisos
echo ""
echo "✅ Permisos aplicados"
echo ""
echo "📋 Verificando:"
ls -ld public/product_images/

# 4. Verificar que es escribible
if [ -w public/product_images ]; then
    echo "✅ El directorio es escribible"
else
    echo "❌ El directorio NO es escribible"
    echo "💡 Puede ser necesario que el administrador ejecute:"
    echo "   sudo chown -R grupo25sa:apache public/product_images"
    echo "   sudo chmod -R 775 public/product_images"
fi

echo ""
echo "💡 Si los problemas persisten, verifica:"
echo "   1. Que el directorio existe: ls -ld public/product_images/"
echo "   2. Que tiene permisos: ls -la public/product_images/ | head -3"
echo "   3. Que Apache puede escribir (puede requerir chown con sudo)"

