call D:\xampp2\htdocs_secret\conf.bat

::start
echo inProgress > D:\xampp2\htdocs_internal\tmp\DBBackupInProgress.txt

set BINHOME=D:\xampp2\htdocs_internal
set CONFHOME=D:\xampp2\htdocs_internal
cscript //nologo %BINHOME%\yyyymmdd.vbs
set /p isoNow= <%CONFHOME%\isoNow.txt
set workFolder=d:\Backups\IRK_Backup_%isoNow%

md %workFolder%
md %workFolder%\DystMail
D:\xampp2\mysql\bin\mysqldump -uroot -p%ROOTP% --result-file="%workFolder%\IRK.sql"  irk
D:\xampp2\mysql\bin\mysqldump -uroot -p%ROOTP% --result-file="%workFolder%\DUMP.sql" irkDump
copy d:\xampp2\htdocs_data\email\DystrybMail_*.txt %workFolder%\DystMail\*.txt
xcopy D:\xampp2\htdocs_data %workFolder%\htdocs_data /EI

"C:\Program Files\7-Zip\7z.exe" a -t7z D:\Backups\IRK_Backup_%isoNow%.7z %workFolder%
rmdir %workFolder% /s /q

::stop
del D:\xampp2\htdocs_internal\tmp\DBBackupInProgress.txt
