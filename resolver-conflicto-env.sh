#!/bin/bash
# Script para resolver conflicto en .env

cd /home/grupo25sa/tecno || exit 1

echo "🔧 Resolviendo conflicto en .env..."

# Opción 1: Usar la versión local (la que tenías antes)
echo "📋 Usando versión local de .env..."
git checkout --ours .env

# O si prefieres la versión del remoto:
# git checkout --theirs .env

# Agregar el archivo resuelto
git add .env

echo "✅ Conflicto resuelto. Ahora puedes:"
echo "   1. Verificar el contenido: cat .env | head -20"
echo "   2. Ajustar APP_URL si es necesario"
echo "   3. Limpiar caches: php artisan optimize:clear"

