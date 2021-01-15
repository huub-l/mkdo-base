#!/usr/bin/env bash
# Make Do Base Setup Script - v1.1.0
# NOTE: This script Requires a Bash shell on OSX
# -----------------------------------------------------------------------------
slug="my-project"
underslug="my_project"

echo "$(tput setaf 3)Initialising Make Do Base Setup script...$(tput setaf 9)"
echo

# Check for software dependencies
echo "$(tput setaf 3)Checking software dependencies...$(tput setaf 9)"
echo

hash git 2>&- || { echo >&2 "Git is required but missing. Exiting."; exit 1; }
hash node 2>&- || { echo >&2 "NodeJS is required but missing. Exiting."; exit 1; }
hash mysql 2>&- || { echo >&2 "MySQL is required but missing. Exiting."; exit 1; }
hash php 2>&- || { echo >&2 "PHP is required but missing. Exiting."; exit 1; }
hash curl 2>&- || { echo >&2 "cURL is required but missing. Exiting."; exit 1; }
hash wp 2>&- || { echo >&2 "WP CLI is required but missing. Exiting."; exit 1; }
hash yarn 2>&- || { echo >&2 "Yarn is required but missing. Exiting."; exit 1; }

# Create MySQL database.
echo "$(tput setaf 3)Creating MySQL database (if it's not already there)...$(tput setaf 9)"
echo

# Cater for those with `root` as as the `root` user password.
mysql -u root --password=root -e "CREATE DATABASE IF NOT EXISTS $underslug" &> /dev/null
mysql -u root --password=root -e "GRANT ALL PRIVILEGES ON $underslug.* TO wp@localhost IDENTIFIED BY 'wp';" &> /dev/null

# Cater for those with no `root` user password.
mysql -u root -e "CREATE DATABASE IF NOT EXISTS $underslug" &> /dev/null
mysql -u root -e "GRANT ALL PRIVILEGES ON $underslug.* TO wp@localhost IDENTIFIED BY 'wp';" &> /dev/null

# Do WordPress Things.
echo "$(tput setaf 3)Installing and configuring WordPress using WP CLI....$(tput setaf 9)"
echo

if [ ! -d wordpress/wp-admin ]
	then

	# Download the latest stable release of WordPress.
	echo "$(tput setaf 3)Downloading WordPress core....$(tput setaf 9)"
	echo
	wp core download --path=wordpress --allow-root &> /dev/null

	# Install the database tables and configure WordPress.
	echo "$(tput setaf 3)Installing WordPress database...$(tput setaf 9)"
	echo
	wp core install --url=my-project.test --title="My Project" --admin_user=admin --admin_password=password --admin_email=hello@makedo.net --allow-root --path=wordpress &> /dev/null

	# Update WP Options.
	echo "$(tput setaf 3)Updating WordPress options...$(tput setaf 9)"
	echo

	# Set the permalink structure to 'post name'.
	wp option update permalink_structure '/%postname%' --allow-root --path=wordpress &> /dev/null

	# Set the default 'Sample Page' as the front page.
	wp option update show_on_front 'page' --allow-root --path=wordpress &> /dev/null
	wp option update page_on_front 2 --allow-root --path=wordpress &> /dev/null
fi

# Install All The Things(tm).
echo "$(tput setaf 3)Installing NPM dependencies...$(tput setaf 9)"
echo
yarn install &> /dev/null

# Add local-config.php
echo "$(tput setaf 3)Adding local-config.php...$(tput setaf 9)"
echo

touch local-config.php
curl -Ls https://raw.githubusercontent.com/mkdo/mkdo-base/master/local-config.php > local-config.php

bakfile=".bak"
sed -i$bakfile "s/my_project/$underslug/g" local-config.php
sed -i$bakfile "s/my_project/$underslug/g" local-config.php.bak

# Build the project.
echo "$(tput setaf 3)Building front-end assets...$(tput setaf 9)"
echo
yarn run dev &> /dev/null

# Success!
echo "$(tput setaf 2)Success! Your Make Do Base project has now been installed.$(tput setaf 9)"
echo

# Setup Valet
printf "$(tput setaf 3)Would you like to configure this site for Valet? (y|n) $(tput setaf 9)"
read -e configurevalet
echo

if [ "$configurevalet" = "y" ] || [ "$configurevalet" = "Y" ]
	then

	hash valet 2>&- || { echo >&2 "$(tput setaf 1)Valet is not installed. Exiting.$(tput setaf 9)"; exit 1; }

	valet link "$slug" &> /dev/null
	valet secure &> /dev/null

fi

# Remove Make Do Base Setup script
echo "$(tput setaf 3)Removing Make Do Base Setup script...$(tput setaf 9)"
echo

setupscript="setup.sh"
if [ -f "$setupscript" ]
	then

	rm setup.sh
	cd ..
	rm setup.sh
	cd "$slug"
fi

echo "$(tput setaf 2)Fin. :)$(tput setaf 9)"
