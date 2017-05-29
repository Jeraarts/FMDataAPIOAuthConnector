# FMDataAPIOAuthConnector
OAuth Connector for the FileMaker Data API

REQUIREMENTS

- An installation of FileMaker Server 16 or higher.
- At least 1 OAuth Provider must be configured in the FileMaker Server Admin Console.
- At least 1 user account authenticating through a configured OAuth provider must be specified in the database you will be connecting to.
- PHP version 5.6 or higher must be installed on the webserver (master machine or worker in a multiple machine setup)
- The PHP curl extension must be enabled.

INSTALLATION INSTRUCTIONS

Copy the files and folders in (a subfolder of) the Document root of the Webserver on the FileMaker Server master machine in a Single machine setup, or on the worker machine in a multiple machine setup. The PHP code must live on the same machine as FileMaker Server.

GETTING STARTED

First edit the Configuration.php and enter the hostname of the FileMaker Server. It is important to know that this is the hostname as evaluated by the User Agent (i.e. a web browser) of the user of your application. If you use 'localhost', your application will only work if run on a User Agent on the FileMaker Server machine itselft, which may well work for testing.

It is recommended to move the 'Storage' folder outside the document root of your webserver, so it cannot be compromised. You must adjust the FMDataAPIOAuthConnector class constant STORAGEFOLDERPATH to reflect this change. The current setup and configuration of storage works but is recommended for testing purposes only as it may expose Request Id and Identifier.

To test the FMDataAPIOAuthConnector refer to the Start.php and GetCompaniesList.php files in the Example folder and adjust configuration so it works with a particular FileMaker database.
