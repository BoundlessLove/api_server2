
## Purpose of api_server2 code
BoundlessLove/api_client project's code uses the authentication and authorisation oAuth code provided by the BoundlessLove/oauth_server project's code, inorder to connect and communicate with the BoundlessLove/api_server2 project's code. 

*Note: For its use, a file called config.php needs to be added to this project, which contains the ApiKey needed to enable anyone to connect to this API Server. This is needed in addition to the oauth_server code's authorisation, in order to communicate with the BoundlessLove/api_server2. ApiKey's original purpose was to serve as a defence for DDOS attacks, when the oAuth Server was not being used.*


## License
This project is under a custom license. Use of the code requires **explicit written permission from the author**. See the [LICENSE](./LICENSE) file for details.

##Versions

###Version 0.1
21 Aug 2025 9:00 PM- API Server works on its own, testLog.php works, but when placing logger class into container does not work.

###Version 0.2
21 Aug 2025 9:57 PM- Logging in the form of a service via object instantiated at startup working

###Version 0.3
27 August 2025 8:48 PM - implemented API key. separated API key into file in public root, which cannot be accesses from website. Added Git. App working with API client running on http://localhost:8080
