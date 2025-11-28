# Solución para el Servidor

## 1. Resolver conflicto de .env

```bash
cd /home/grupo25sa/tecno

# Opción 1: Guardar cambios locales de .env
git stash
git pull
git stash pop

# Opción 2: Si no necesitas los cambios locales
git checkout -- .env
git pull
```

## 2. Corregir permisos de product_images

```bash
# Los archivos existentes pueden tener permisos diferentes, pero el directorio debe ser escribible
chmod 775 public/product_images

# Verificar permisos
ls -la public/product_images/ | head -5
```

## 3. Limpiar archivos temporales de PHP (si existen)

```bash
# Eliminar archivos temporales
rm -f public/product_images/php*.tmp

# O si no tienes permisos, el código los manejará automáticamente
```

## 4. Limpiar caches

```bash
php artisan route:clear
php artisan config:clear
php artisan optimize:clear
```

## 5. Verificar rutas

```bash
php artisan route:list | grep products.store
# Debe aparecer solo UNA vez
```

## Nota sobre permisos

Si algunos archivos en `product_images` no puedes cambiar de propietario, no es crítico. Lo importante es que:
- El directorio tenga permisos 775
- Apache pueda escribir nuevos archivos
- El código crea el directorio automáticamente si no existe

