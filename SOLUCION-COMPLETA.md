# 🔴 SOLUCIÓN COMPLETA - Problemas de Productos

## ⚠️ PROBLEMA PRINCIPAL
**El servidor está usando JavaScript antiguo porque NO se ha ejecutado `npm run build`**

## ✅ SOLUCIÓN PASO A PASO (EJECUTAR EN EL SERVIDOR)

```bash
cd /home/grupo25sa/tecno

# 1. Hacer pull de TODOS los cambios
git pull

# 2. ⚠️ CRÍTICO: RECONSTRUIR ASSETS (SIN ESTO NADA FUNCIONA)
npm run build
# ⚠️ Esto puede tardar 2-5 minutos, pero ES OBLIGATORIO
# ⚠️ Sin esto, el navegador seguirá usando código antiguo

# 3. Corregir permisos de product_images
mkdir -p public/product_images
chmod -R 777 public/product_images

# 4. Limpiar caches de Laravel
php artisan config:clear
php artisan route:clear
php artisan optimize:clear

# 5. Limpiar caché del navegador
# Presiona Ctrl + Shift + R (hard refresh)
# O cierra y vuelve a abrir el navegador completamente
```

## 🔍 VERIFICACIÓN

Después de ejecutar los comandos:

```bash
# Verificar que los assets se generaron recientemente
ls -lt public/build/assets/*.js | head -3
# Debe mostrar archivos con fecha/hora reciente

# Verificar rutas
php artisan route:list | grep products.update
# Debe mostrar: PUT|PATCH admin/products/{product} products.update

# Verificar permisos
ls -ld public/product_images/
# Debe mostrar: drwxrwxrwx
```

## 📋 PROBLEMAS CORREGIDOS

1. ✅ **Crear producto**: Ahora usa `form.post(route('products.store'))`
2. ✅ **Editar producto**: Ahora usa `form.put(route('products.update', id))`
3. ✅ **Botón "For Sale"**: Ahora usa `route('products.updateToPublished')`
4. ✅ **Permisos de imágenes**: Código mejorado para crear directorio automáticamente
5. ✅ **Formato de fecha**: Corregido para PostgreSQL (Y-m-d)

## ❓ SI AÚN NO FUNCIONA

1. **Verifica que `npm run build` se completó sin errores**
2. **Verifica que los archivos en `public/build/assets/` tienen fecha reciente**
3. **Limpia completamente la caché del navegador** (Ctrl + Shift + Delete)
4. **Verifica en la consola del navegador (F12) qué ruta se está usando**

## 🖼️ SOBRE LAS IMÁGENES ROTAS

Las imágenes se muestran con `/${Product.product_images[0].image}` que debería funcionar si:
- La imagen está en `public/product_images/nombre.jpg`
- El campo en la BD es `product_images/nombre.jpg`

Si las imágenes siguen rotas, verifica:
```bash
# Verificar que las imágenes existen
ls -la public/product_images/ | head -5

# Verificar el path en la base de datos
# El campo `image` en la tabla `product_images` debe ser: "product_images/nombre.jpg"
```

## 📝 NOTA FINAL

**Cada vez que se modifica código Vue/JavaScript, DEBES ejecutar `npm run build` en el servidor.**

El código fuente está en `resources/js/`, pero el navegador usa el código compilado en `public/build/assets/`.

