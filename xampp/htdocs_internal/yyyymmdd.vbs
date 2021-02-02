timeStampt = Year(Now) & "-" & _
    Right("0" & Month(Now),2)  & "-" & _
    Right("0" & Day(Now),2)
'Wscript.Echo timeStampt
Set objFSO=CreateObject("Scripting.FileSystemObject")
'Wscript.Echo CreateObject("WScript.Shell").ExpandEnvironmentStrings("%CONFHOME%")+"\isoToday.txt"
outFile=CreateObject("WScript.Shell").ExpandEnvironmentStrings("%CONFHOME%")+"\isoToday.txt"
Set objFile = objFSO.CreateTextFile(outFile,True)
objFile.Write _
 timeStampt
objFile.Close


timeStampy = Year(Now-1) & "-" & _
    Right("0" & Month(Now-1),2)  & "-" & _
    Right("0" & Day(Now-1),2)
'Wscript.Echo timeStampy
Set objFSO=CreateObject("Scripting.FileSystemObject")
'Wscript.Echo CreateObject("WScript.Shell").ExpandEnvironmentStrings("%CONFHOME%")+"\isoYesterday.txt"
outFile=CreateObject("WScript.Shell").ExpandEnvironmentStrings("%CONFHOME%")+"\isoYesterday.txt"
Set objFile = objFSO.CreateTextFile(outFile,True)
objFile.Write _
 timeStampy
objFile.Close

timeStamp = Year(Now) & "-" & _
    Right("0" & Month(Now),2)  & "-" & _
    Right("0" & Day(Now),2)  & "_" & _  
    Right("0" & Hour(Now),2) & _
    Right("0" & Minute(Now),2) & _
    Right("0" & Second(Now),2)
'Wscript.Echo timeStamp
Set objFSO=CreateObject("Scripting.FileSystemObject")
'Wscript.Echo CreateObject("WScript.Shell").ExpandEnvironmentStrings("%CONFHOME%")+"\isoNow.txt"
outFile=CreateObject("WScript.Shell").ExpandEnvironmentStrings("%CONFHOME%")+"\isoNow.txt"
Set objFile = objFSO.CreateTextFile(outFile,True)
objFile.Write _
 timeStamp
objFile.Close