::this script is currently not in use because D:\xampp2\xampp_stop.EXE ends with error (Apache needs to be stopped via console)

::start
echo inProgress > D:\xampp2\htdocs_internal\tmp\ApacheCleanInProgress.txt

D:\xampp2\xampp_stop.EXE
del D:\xampp2\apache\logs\error.log
del D:\xampp2\apache\logs\access.log
del D:\xampp2\apache\logs\ssl_request.log
D:\xampp2\mysql\data\mysql_error.log

D:\xampp2\xampp_start.EXE

::stop
del D:\xampp2\htdocs_internal\tmp\ApacheCleanInProgress.txt
