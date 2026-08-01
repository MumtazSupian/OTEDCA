Set WinScriptHost = CreateObject("WScript.Shell")
WinScriptHost.Run "C:\php-8.4.20\php.exe C:\web\ar\artisan schedule:run >> C:\web\ar\scheduler_result.log 2>&1", 0, False
Set WinScriptHost = Nothing