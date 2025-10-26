@echo off
REM ================================================
REM CHOJIN BEATS - Preparación para Deployment
REM ================================================

echo.
echo ========================================
echo   CHOJIN BEATS - Deployment Prep
echo ========================================
echo.

REM Crear carpeta de deployment
echo [1/5] Creando carpeta de deployment...
if exist deploy_package (
    echo Eliminando carpeta anterior...
    rmdir /s /q deploy_package
)
mkdir deploy_package
echo ✓ Carpeta creada

echo.
echo [2/5] Copiando archivos necesarios...

REM Copiar carpetas principales
xcopy app deploy_package\app\ /E /I /Y /Q
xcopy public deploy_package\public\ /E /I /Y /Q
xcopy system deploy_package\system\ /E /I /Y /Q
xcopy vendor deploy_package\vendor\ /E /I /Y /Q
xcopy writable deploy_package\writable\ /E /I /Y /Q

REM Copiar archivos raíz
copy composer.json deploy_package\ /Y

echo ✓ Archivos copiados

echo.
echo [3/5] Limpiando archivos temporales...

REM Limpiar cache
if exist deploy_package\writable\cache\* (
    del /q deploy_package\writable\cache\* 2>nul
)

REM Limpiar logs
if exist deploy_package\writable\logs\* (
    del /q deploy_package\writable\logs\* 2>nul
)

REM Limpiar sessions
if exist deploy_package\writable\session\* (
    del /q deploy_package\writable\session\* 2>nul
)

echo ✓ Archivos temporales eliminados

echo.
echo [4/5] Copiando plantilla de .env para producción...
copy .env.production deploy_package\.env /Y
echo ✓ Archivo .env copiado

echo.
echo [5/5] Creando archivo comprimido...
echo (Necesitas comprimir manualmente la carpeta deploy_package)

echo.
echo ========================================
echo   DEPLOYMENT PACKAGE LISTO!
echo ========================================
echo.
echo Siguiente paso:
echo 1. Editar deploy_package\.env con tus datos de producción
echo 2. Comprimir la carpeta deploy_package en un .zip
echo 3. Seguir instrucciones en QUICK_DEPLOY.md
echo.
echo Presiona cualquier tecla para abrir la carpeta...
pause >nul
explorer deploy_package

echo.
echo ¡Listo para deployment! 🚀
pause
