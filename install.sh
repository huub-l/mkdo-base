#!/usr/bin/env bash
# Make Do Boilerplate Setup Script - v1.0.0
# NOTE: This script Requires a Bash shell on OSX
# -----------------------------------------------------------------------------
slug="my-project"
underslug="my_project"

echo "$(tput setaf 3)Initialising Make Do Boilerplate Setup script...$(tput setaf 9)"
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
hash webpack 2>&- || { echo >&2 "Webpack CLI is required but missing. Exiting."; exit 1; }
hash composer 2>&- || { echo >&2 "Composer is required but missing. Exiting."; exit 1; }
hash yarn 2>&- || { echo >&2 "Yarn is required but missing. Exiting."; exit 1; }

# Create MySQL database.
echo "$(tput setaf 3)Creating MySQL database (if it's not already there)...$(tput setaf 9)"
echo

mysql -u root --password=root -e "CREATE DATABASE IF NOT EXISTS $underslug" &> /dev/null
mysql -u root --password=root -e "GRANT ALL PRIVILEGES ON $underslug.* TO wp@localhost IDENTIFIED BY 'wp';" &> /dev/null

# Do WordPress Things.
echo "$(tput setaf 3)Installing and configuring WordPress using WP CLI....$(tput setaf 9)"
echo

if [ ! -d build/wordpress/wp-admin ]
	then

	# Download the latest stable release of WordPress.
	echo "$(tput setaf 3)Downloading WordPress core....$(tput setaf 9)"
	echo
	wp core download --path=build/wordpress --allow-root &> /dev/null

	# Install the database tables and configure WordPress.
	echo "$(tput setaf 3)Installing WordPress database...$(tput setaf 9)"
	echo
	wp core install --url=my-project.test --title="My Project" --admin_user=admin --admin_password=password --admin_email=hello@makedo.net --allow-root --path=build/wordpress &> /dev/null

	# Update WP Options.
	echo "$(tput setaf 3)Updating WordPress options...$(tput setaf 9)"
	echo

	# Set the permalink structure to 'post name'.
	wp option update permalink_structure '/%postname%' --allow-root --path=build/wordpress &> /dev/null

	# Set the default 'Sample Page' as the front page.
	wp option update show_on_front 'page' --allow-root --path=build/wordpress &> /dev/null
	wp option update page_on_front 2 --allow-root --path=build/wordpress &> /dev/null
fi

# Install All The Things(tm).
echo "$(tput setaf 3)Installing NPM dependencies...$(tput setaf 9)"
echo
yarn install &> /dev/null

# Add local-config.php
echo "$(tput setaf 3)Adding local-config.php...$(tput setaf 9)"
echo

touch build/local-config.php
curl -Ls https://raw.githubusercontent.com/kapow-wp/kapow-boilerplate/master/build/local-config.php > build/local-config.php

bakfile=".bak"
sed -i$bakfile "s/my_project/$underslug/g" build/local-config.php

# Build the project.
echo "$(tput setaf 3)Building front-end assets...$(tput setaf 9)"
echo
yarn run dev &> /dev/null

# Success!
echo "$(tput setaf 2)Success! Your Make Do Boilerplate based project has now been installed.$(tput setaf 9)"
echo

# Setup Valet
printf "$(tput setaf 3)Would you like to configure this site for Valet? (y|n) $(tput setaf 9)"
read -e configurevalet
echo

if [ "$configurevalet" = "y" ] || [ "$configurevalet" = "Y" ]
	then

	hash valet 2>&- || { echo >&2 "$(tput setaf 1)Valet is not installed. Exiting.$(tput setaf 9)"; exit 1; }

	cd build
	valet link "$slug" &> /dev/null
	valet secure

fi

# Remove Make Do Boilerplate Setup script
echo "$(tput setaf 3)Removing Make Do Boilerplate Setup script...$(tput setaf 9)"
echo

setupscript="kapow.sh"
if [ -f "$setupscript" ]
	then

	cd ..
	rm kapow.sh
	cd "$slug"
fi

echo "$(tput setaf 2)Fin. :)$(tput setaf 9)"
