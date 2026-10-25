@echo off
setlocal
set "ERRORS=0"
for /R %%f in (*.php) do (
  php -l "%%f" >nul
  if errorlevel 1 (
    echo [ERROR] %%f
    php -l "%%f"
    set "ERRORS=1"
  )
)
if "%ERRORS%"=="0" (
  echo All PHP files passed syntax checking.
) else (
  echo Some PHP files failed syntax checking.
)
exit /b %ERRORS%
