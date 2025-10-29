# Script para crear ZIP de produccion - LubaBeats Beta

Write-Host "====================================" -ForegroundColor Cyan
Write-Host "  CREANDO ZIP PARA PRODUCCION" -ForegroundColor Cyan
Write-Host "====================================" -ForegroundColor Cyan
Write-Host ""

$zipName = "LubaBeats_Beta_Produccion.zip"
$zipPath = "C:\xampp\htdocs\CHOJIN\$zipName"
$tempFolder = "C:\xampp\htdocs\CHOJIN\temp_produccion"

if (Test-Path $tempFolder) {
    Remove-Item -Path $tempFolder -Recurse -Force
}

New-Item -ItemType Directory -Path $tempFolder | Out-Null

Write-Host "Copiando archivos necesarios..." -ForegroundColor Yellow
Write-Host ""

Write-Host "Copiando app/Controllers/" -ForegroundColor Green
Copy-Item -Path "C:\xampp\htdocs\CHOJIN\app\Controllers" -Destination "$tempFolder\app\Controllers" -Recurse

Write-Host "Copiando app/Views/" -ForegroundColor Green
Copy-Item -Path "C:\xampp\htdocs\CHOJIN\app\Views" -Destination "$tempFolder\app\Views" -Recurse

Write-Host "Copiando app/Config/" -ForegroundColor Green
Copy-Item -Path "C:\xampp\htdocs\CHOJIN\app\Config" -Destination "$tempFolder\app\Config" -Recurse

Write-Host "Copiando app/Models/" -ForegroundColor Green
Copy-Item -Path "C:\xampp\htdocs\CHOJIN\app\Models" -Destination "$tempFolder\app\Models" -Recurse

Write-Host "Copiando app/Libraries/" -ForegroundColor Green
Copy-Item -Path "C:\xampp\htdocs\CHOJIN\app\Libraries" -Destination "$tempFolder\app\Libraries" -Recurse

Write-Host "Copiando public/assets/" -ForegroundColor Green
Copy-Item -Path "C:\xampp\htdocs\CHOJIN\public\assets" -Destination "$tempFolder\public\assets" -Recurse

Write-Host ""
Write-Host "Comprimiendo archivos..." -ForegroundColor Yellow

if (Test-Path $zipPath) {
    Remove-Item -Path $zipPath -Force
}

Compress-Archive -Path "$tempFolder\*" -DestinationPath $zipPath -CompressionLevel Optimal

Remove-Item -Path $tempFolder -Recurse -Force

Write-Host ""
Write-Host "====================================" -ForegroundColor Green
Write-Host "  ZIP CREADO EXITOSAMENTE!" -ForegroundColor Green
Write-Host "====================================" -ForegroundColor Green
Write-Host ""

$zipSize = (Get-Item $zipPath).Length / 1MB
Write-Host "Ubicacion: $zipPath" -ForegroundColor Cyan
Write-Host "Tamano: $([math]::Round($zipSize, 2)) MB" -ForegroundColor Cyan
Write-Host ""

Write-Host "CONTENIDO DEL ZIP:" -ForegroundColor Yellow
Write-Host "  app/Controllers/" -ForegroundColor White
Write-Host "  app/Views/" -ForegroundColor White
Write-Host "  app/Config/" -ForegroundColor White
Write-Host "  app/Models/" -ForegroundColor White
Write-Host "  app/Libraries/" -ForegroundColor White
Write-Host "  public/assets/" -ForegroundColor White
Write-Host ""

explorer.exe "C:\xampp\htdocs\CHOJIN"
