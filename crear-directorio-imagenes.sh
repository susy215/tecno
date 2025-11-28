#!/bin/bash
# Script para crear el directorio de imágenes de productos

echo "📁 Creando directorio para imágenes de productos..."

cd /home/grupo25sa/tecno || exit 1

# Crear directorio en public
mkdir -p public/product_images

# Dar permisos
chmod -R 775 public/product_images
chown -R grupo25sa:apache public/product_images

# Verificar
echo "✅ Directorio creado:"
ls -ld public/product_images/

echo ""
echo "💡 El directorio está listo para recibir imágenes de productos"

