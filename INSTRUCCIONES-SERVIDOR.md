# Instrucciones para el Servidor - Actualizar Productos con Imágenes

## ⚠️ PROBLEMA ACTUAL
El servidor está usando JavaScript antiguo que envía POST a rutas incorrectas.

## ✅ SOLUCIÓN PASO A PASO

### 1. Hacer pull de los cambios
```bash
cd /home/grupo25sa/tecno
git pull
```

### 2. RECONSTRUIR ASSETS (CRÍTICO - SIN ESTO NO FUNCIONA)
```bash
# Esto recompila el código Vue/JavaScript con las correcciones
npm run build

# Esto puede tardar 2-5 minutos, pero ES OBLIGATORIO
```

### 3. Limpiar caches de Laravel
```bash
php artisan config:clear
php artisan route:clear
php artisan optimize:clear
```

### 4. Limpiar caché del navegador
- Presiona `Ctrl + Shift + R` (o `Cmd + Shift + R` en Mac) para hacer hard refresh
- O abre las herramientas de desarrollador (F12) > Network > marca "Disable cache"
- O cierra y vuelve a abrir el navegador

## 🔍 VERIFICACIÓN

Después de ejecutar estos comandos, verifica:

1. **Rutas correctas:**
```bash
php artisan route:list | grep products.update
# Debe mostrar: PUT|PATCH admin/products/{product} products.update
```

2. **Assets compilados:**
```bash
ls -la public/build/assets/ | head -5
# Debe mostrar archivos .js recientes
```

## ❓ SI AÚN NO FUNCIONA

1. Verifica que `npm run build` se completó sin errores
2. Verifica que los archivos en `public/build/assets/` tienen fecha reciente
3. Limpia completamente la caché del navegador
4. Verifica en la consola del navegador (F12) qué ruta se está usando

## 📝 NOTA IMPORTANTE

**Cada vez que se modifica código Vue/JavaScript, DEBES ejecutar `npm run build` en el servidor para que los cambios se apliquen.**

El código en `resources/js/` es el código fuente. El código que usa el navegador está en `public/build/assets/` y se genera con `npm run build`.

