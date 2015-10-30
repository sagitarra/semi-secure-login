# semi-secure-login
 It is heavily (and most helpfully) commented at http://forums.devshed.com/php-faqs-stickies-167/program-basic-secure-login-system-using-php-mysql-891201.html I have included it here to point out a few places where a break can be used to troubleshoot the code. That is a misnomer because the code works fine. I used die and echo requests to find the point where the code failed to work properly so I could be assured in blaming godaddy for their bad php configuration. 
 
 For a php session to exist on the next page during a redirect, upload_tmp_dir and session.save_path have to have the same path as displayed below. If they are not the same, the session won’t stay logged in because your program will be looking in the wrong directory and then quickly give up; indicate an empty session and redirect to your login.






![alt tag](https://github.com/sagitarra/semi-secure-login/blob/master/sessionsavepath.jpg)


The paths are the same on the left side because I included a  .user.ini file in the root directory on my server which includes this line: session.save_path = D:/Temp/php   Otherwise, the left “local” side would display D:\Temp\php\session\ ; e.g., if I removed the .user.ini file from my server.
To fix the problem:
•	open wordpad
•	type in the session.save_path = whatever is in the upload_tmp_dir
•	call it “.user” and save it as an MS ini file (or just type in .user.ini and hit save)
•	upload the file into your root directory on your server 
•	test for effect

Godaddy offers an option to use a php5.ini file which can configure the upload temp directory as well.  http://php.net/manual/en/configuration.file.php I’ve heard it is a good practice to have quick access to these temp files to check on your sessions and whether they are piling up in there (bad) or being unset when unused (good).  This didn’t work for me. However, I am satisfied with the user.ini fix. I hope you enjoy this solution because after three calls to their server help folks, I am pretty sure there is no other until they change their code. Aloha!



