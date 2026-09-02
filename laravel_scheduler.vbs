Set WinScriptHost = CreateObject("WScript.Shell")
WinScriptHost.Run "C:\php-8.4.20\php.exe C:\web\ote\artisan schedule:run >> C:\web\ote\scheduler_result.log 2>&1", 0, False
Set WinScriptHost = Nothing