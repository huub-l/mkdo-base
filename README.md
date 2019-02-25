# MKDO Base
A modern, best-practice filled base for bespoke WordPress site development. 

**NOTE: This readme is automatically deleted when the setup.sh script completes.**

## [Requirements](#requirements)

You will need the following installed on your system before attempting to set-up a MKDO Base based project using this guide:

- [Git](https://git-scm.com/book/en/v2/Getting-Started-Installing-Git)
- [NodeJS & NPM](https://nodejs.org/en/download/)
- [MySQL](https://www.mysql.com/downloads/)
- [PHP](http://php.net/downloads.php)
- [WP Cli](https://wp-cli.org/#installing)
- [Composer](https://getcomposer.org/download/)
- [Yarn](https://yarnpkg.com/lang/en/docs/getting-started/)
- [Webpack CLI](http://github.com/webpack/webpack-cli)

## [Two-Factor Authentication for GitHub API](#2fa)

As this script leverages the GitHub API for repository creation, you will need to take some additional steps before being able to use it to scaffold a new project instance, due to the additional authentication required. If you do not have 2FA enabled on your GitHub account, please do so [here](https://github.com/settings/security) ASAP.

1. Head over to https://github.com/settings/tokens.
2. Generate a new token, giving it `repo` privileges, and name it so that you know it relates to MKDO Boilerplate
3. Copy the token before moving away from this page.
4. Create a new file `~/.kapow_token` on your machine.
5. Paste the token into this file and save.

This script will look for `~/.kapow_token` before doing anything else, and will abort if the token is not present. This file should **only** contain the personal access token you copied from Github, and nothing else.

## [Installation](#installation)

1) Navigate to your projects root e.g. `~/Valet`.

2) Grab the script directly via the terminal using the command below:

`curl -O https://raw.githubusercontent.com/mkdo/mkdo-base/master/setup.sh`

...or...

`wget https://raw.githubusercontent.com/mkdo/mkdo-base/master/setup.sh`

3) Make the `setup.sh` script executable via the command line using `chmod a+x setup.sh`.

4) Run the script with `./setup.sh` and the two additional parameters to facilitate string replacement.

*TIP: Create an alias called `getbase` on your machine that invokes the curl/wget commands above to fetch the MKDO Base before making it executable.*

5) Answer questions as you are prompted, while sipping your beverage of choice.

## [Command Line Parameters](#command-line-parameters)

The parameters must be added in the following order:

- Project Slug e.g. `stark-industries` *
- Project Nice Name e.g `"Stark Industries"`

*NB: The project slug will be used for the theme folder name and database name.*

An example using all of the above would look like this:

`./setup.sh stark-industries "Stark Industries"`
