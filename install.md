# DTAdmin Installation Guide
This is a rough installation guide for users of DTAdmin.

1. Setup your database and timezone config in server/config.php.
2. Open a web browser and navigate to https://dtadmin.yoursite.tld/dtadmin/install/setup.php.
3. Enter your License Email and License Provisioning Key. Wait for the server to generate your site-specific DRM key. Note that this requires an internet connection to https://lis.towerdevs.xyz/generate_drm.php.
3. Enter a default admin username and password.
4. Enter your mail server details.
5. Wait while the database is populated.
6. Log in at https://dtadmin.yoursite.tld/dtadmin/login.php.

## Server Creation

1. Log in to DTAdmin.
2. Navigate to the "Server Management" page in the sidebar.
3. Click "Download" under "DTQuery Agent".
4. Extract the DTQuery archive on your game server.
5. Run either autoconfig.sh or autoconfig.bat depending on your OS.
6. Enter the API Key you generated, full path to the gameserver files, and full path to any update software (SteamCMD), if any. Enter your RCON password, if any, or leave blank to autodetect. The dtquery/servers/server_(serveridhere).cfg file will be populated with your server's details, and the DTQuery daemon will automatically start.
7. Open Port 43105 in the firewall, if you haven't already.
8. (Optional) Test if DTQuery is working by navigating to https://youriphere:43105/dtquery/test.php and verifying the Status Code is 210A.
9. Click "New Server". A form will display.
10. Enter your server IP.

## Removal of DTQuery

Note: PLEASE do not remove any API keys from either your account or DTQuery's config files! They are required to automatically delete server details from the DTAdmin database when DTQuery is uninstalled.

1. Run uninstall.sh or uninstall.bat depending on your OS.
This will irreversably wipe every trace of DTQuery from your game server, including your API key, although it will not revoke your server-side API key.

## DTQuery Prerequisites

- A web server running either Nginx or Apache2
- At least PHP 7 or php-fpm installed.
- A dedicated public server IP with port forwarding on port 43105.

## DTClient Installation Guide
This details the way you can install DTClient.

1. Run the installer, setup_dtclient(release-number).exe.
2. Optionally enter your DTAdmin URL and port.
3. Log in with your DTAdmin username and password.
4. Wait while the client downloads updates and provisioning data...
5. You should see the Mini dashboard.

## DTClient Removal Guide
1. Uninstall the program "DTClient (release number)" from Control Panel.
