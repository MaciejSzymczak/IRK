::start
echo inProgress > D:\xampp2\htdocs_internal\tmp\DBCleanUpInProgress.txt
set sqlpath=D:\xampp2\htdocs_internal\sql

call D:\xampp2\htdocs_secret\conf.bat
D:\xampp2\mysql\bin\mysql -uroot -p%ROOTP% irk < %sqlpath%\truncate_irk.sql
D:\xampp2\mysql\bin\mysql -uroot -p%ROOTP% irkDump <  %sqlpath%\truncate_irkdump.sql 
D:\xampp2\mysql\bin\mysql -uroot -p%ROOTP% irk <  %sqlpath%\insertExamples.sql
D:\xampp2\mysql\bin\mysql -uroot -p%ROOTP% irk <  %sqlpath%\insertAdmin.sql
del /Q D:\xampp2\htdocs_data\*.jpg
del /Q d:\xampp2\htdocs_data\DystrybMail_*.txt

::stop
del D:\xampp2\htdocs_internal\tmp\DBCleanUpInProgress.txt
