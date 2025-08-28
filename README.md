
## Purpose of api_server2 code
BoundlessLove/api_client project's code uses the 'authentication and authorisation' from the oAuth code provided by the BoundlessLove/oauth_server project's code, inorder to connect and communicate with the BoundlessLove/api_server2 project's code. 

*Note: For its use, a file called config.php needs to be added to this project, which contains the ApiKey needed to enable anyone to connect to this API Server. This is needed in addition to the oauth_server code's authorisation, in order to communicate with the BoundlessLove/api_server2. ApiKey's original purpose was to serve as a defence for DDOS attacks, when the oAuth Server was not being used.*


## Pre-Requisite: [Applies to Dev branch only] Setup virtual host on default apache2 server running on Ubuntu 22.04 LTS on port 8080 (accessible via http://localhost:8080)
Apache was used. The process used was as following:
### a. Verify Apache has php module Enabled
#### i. Run 'apache2ctl -M | grep php'. Outcome should show something like 'php_module (shared)'. If not continue with below steps.
#### ii. Run following commands:

sudo apt install

sudo apt install libapache2-mod-php

sudo a2enmod php

sudo systemctl restart apache2


### b. Setup Virtual host
#### i. Run 'sudo nano /etc/apache2/sites-available/api_client.conf'
#### ii. Add something like:
<VirtualHost *:8080>

    ServerName api_client.com
    
    ServerAdmin webmaster@localhost
    
    DocumentRoot /home/administrator@internal.systematicdefence.tech/projects/api_client
    
    <Directory /home/administrator@internal.systematicdefence.tech/projects/api_client>
    
        Options Indexes FollowSymLinks
        
        AllowOverride All
        
        Require all granted
        
    </Directory>

    ErrorLog ${APACHE_LOG_DIR}/error.log
    
    CustomLog ${APACHE_LOG_DIR}/access.log combined
    
< /VirtualHost>

#### iii. In order for Apache to know how to handle '.php' files, add this also to the api_client.conf file:

*<FilesMatch \.php$> SetHandler application/x-httpd-php < /FilesMatch>*

#### iv. In order for Apache to know default starting page, also add to api_client.conf file just before the ErrorLog sentence:
DirectoryIndex index.php index.html

#### v. Run ‘sudo nano /etc/apache2/ports.conf’ and add ‘Listen 8080’, if it does not exist.
#### vi. Activate config with 'sudo a2ensite my-site.conf'
#### vii. Verify sytax of api_client.conf with 'sudo apache2ctl configtest'
#### viii. Provide correct permissions - In Linux, for Apache to serve files from a directory like /home/administrator@internal.systematicdefence.tech/projects/api_server2, it needs **execute (`x`) permission** on **every parent directory** in that path. It also needs owner type permissions for its user 'www-data' on the virtual host directory, in order to be able to write files to in it. Hence, run following commands:
##### --Give others access to traverse the directories that lead to the webroot. Note it does not expose file contents.

sudo chmod o+x /home

sudo chmod o+x /home/administrator@internal.systematicdefence.tech

sudo chmod o+x /home/administrator@internal.systematicdefence.tech/projects

##### --Give Apache the ability to execute files in the web root api_client (give www-data user's group owner rights on folder):

sudo chmod -R 755 /home/administrator@internal.systematicdefence.tech/projects/api_client

sudo chown -R administrator@internal.systematicdefence.tech:www-data /home/administrator@internal.systematicdefence.tech/projects/api_client

##### --Give Apache the ability to write to any log files:
chmod 664 /home/administrator@internal.systematicdefence.tech/projects/api_client/logs/app.log

##### --To verify, that the granting of permissions have worked, run this command, and it should succeeded in writing 'test' to the app.log file: 
sudo -u www-data echo "test" >> /path/to/logs/app.log

#### ix. Verify that Apache has the required access to api_client webroot via cmd 'ls -ld':
Outcome: drwxr-xr-x 4 administrator@internal.systematicdefence.tech www-data

#### x Reload Apache with command 'sudo systemctl reload apache2'
#### xi. Try accessing site via `http://localhost:8080`. 
If issues encountered, run command to veiw error log inorder to identify exact problem:

sudo tail -n 50 /var/log/apache2/error.log

## License
This project is under a custom license. Use of the code requires **explicit written permission from the author**. See the [LICENSE](./LICENSE) file for details.

## Versions

### Version 0.1
21 Aug 2025 9:00 PM- API Server works on its own, testLog.php works, but when placing logger class into container does not work.

### Version 0.2
21 Aug 2025 9:57 PM- Logging in the form of a service via object instantiated at startup working

### Version 0.3
27 August 2025 8:48 PM - implemented API key. separated API key into file in public root, which cannot be accesses from website. Added Git. App working with API client running on http://localhost:8080
