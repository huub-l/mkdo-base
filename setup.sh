#!/usr/bin/env bash
# MKDO Base Setup Script - v1.0.0
# NOTE: This script Requires a Bash shell on OSX
# -----------------------------------------------------------------------------

OAUTHTOKEN=$(<~/.kapow_token)

if [ ! "$OAUTHTOKEN" ]
	then

	echo "$(tput setaf 1)Aborting; no GitHub token found in ~/.kapow_token$(tput setaf 9)"
	echo

	exit 1;
fi

echo "$(tput setaf 3)Initialising MKDO Base Setup Script...$(tput setaf 9)"
echo

# Check for software dependencies
echo "$(tput setaf 3)Checking software dependencies...$(tput setaf 9)"
echo

hash git 2>&- || { echo >&2 "Git is required but missing. Exiting."; exit 1; }
hash node 2>&- || { echo >&2 "NodeJS is required but missing. Exiting."; exit 1; }
hash mysql 2>&- || { echo >&2 "MySQL is required but missing. Exiting."; exit 1; }
hash php 2>&- || { echo >&2 "PHP is required but missing. Exiting."; exit 1; }
hash unzip 2>&- || { echo >&2 "Unzip is required but missing. Exiting."; exit 1; }
hash curl 2>&- || { echo >&2 "cURL is required but missing. Exiting."; exit 1; }
hash wp 2>&- || { echo >&2 "WP CLI is required but missing. Exiting."; exit 1; }
hash webpack 2>&- || { echo >&2 "Webpack is required but missing. Exiting."; exit 1; }
hash composer 2>&- || { echo >&2 "Composer is required but missing. Exiting."; exit 1; }
hash yarn 2>&- || { echo >&2 "Yarn is required but missing. Exiting."; exit 1; }

# Input variables
slug=$1
nicename=$2

# If we have no slug, default to the
# standard 'my-project' slug.
if [ ! "$slug" ]
	then
	slug="my-project"
fi

gitdir=".git"

# Create the repository, or create a directory
# Check to see if this script is being executed from an existing repository.
if [ ! -d "$gitdir" ]
	then

		# Ask for GitHub org username.
		printf "$(tput setaf 3)Please enter the GitHub organisation username: $(tput setaf 9)"
		read -e githuborg
		echo

		# Exit if no GitHub org username entered.
		if [ -z "$githuborg" ]
			then

			echo "$(tput setaf 1)ERROR: no GitHub organisation username entered!$(tput setaf 9)"
			echo

			exit 1

		fi

		# Ask for GitHub username.
		printf "$(tput setaf 3)Please enter your GitHub username: $(tput setaf 9)"
		read -e githubuser
		echo

		# Exit if no GitHub username entered.
		if [ -z "$githubuser" ]

			then

			echo "$(tput setaf 1)ERROR: no GitHub username entered!$(tput setaf 9)"
			echo

			exit 1

		fi

		# Ask for GitHub password.
		printf "$(tput setaf 3)Please enter your GitHub password: $(tput setaf 9)"
		read -s githubpass
		echo
		echo

		# Exit if no GitHub password entered.
		if [ -z "$githubpass" ]

			then

			echo "$(tput setaf 1)ERROR: no GitHub password entered!$(tput setaf 9)"
			echo

			exit 1

		fi

		# Attempt to create the repository
		echo "$(tput setaf 3)Creating repository on GitHub...$(tput setaf 9)"
		echo

		httpresponse=$(curl -s -u "$githubuser:$githubpass" -H "Authorization: token $OAUTHTOKEN" -w 'HTTPSTATUS:%{http_code}' -d "{\"name\":\"$slug\",\"private\":\"true\"}" https://api.github.com/orgs/"$githuborg"/repos)

		httpstatus=$(echo "$httpresponse" | tr -d '\n' | sed -e 's/.*HTTPSTATUS://')

		# Proceed if successful.
		if [ "$httpstatus" = "201" ]
			then

				echo "$(tput setaf 3)Carrying out label housekeeping...$(tput setaf 9)"
				echo

				# Delete default labels.
				curl -s -u "$githubuser:$githubpass" -H "Authorization: token $OAUTHTOKEN" --request DELETE "https://api.github.com/repos/"$githuborg"/"$slug"/labels/bug"
				curl -s -u "$githubuser:$githubpass" -H "Authorization: token $OAUTHTOKEN" --request DELETE "https://api.github.com/repos/"$githuborg"/"$slug"/labels/duplicate"
				curl -s -u "$githubuser:$githubpass" -H "Authorization: token $OAUTHTOKEN" --request DELETE "https://api.github.com/repos/"$githuborg"/"$slug"/labels/enhancement"
				curl -s -u "$githubuser:$githubpass" -H "Authorization: token $OAUTHTOKEN" --request DELETE "https://api.github.com/repos/"$githuborg"/"$slug"/labels/invalid"
				curl -s -u "$githubuser:$githubpass" -H "Authorization: token $OAUTHTOKEN" --request DELETE "https://api.github.com/repos/"$githuborg"/"$slug"/labels/question"
				curl -s -u "$githubuser:$githubpass" -H "Authorization: token $OAUTHTOKEN" --request DELETE "https://api.github.com/repos/"$githuborg"/"$slug"/labels/wontfix"
				curl -s -u "$githubuser:$githubpass" -H "Authorization: token $OAUTHTOKEN" --request DELETE "https://api.github.com/repos/"$githuborg"/"$slug"/labels/help%20wanted"
				curl -s -u "$githubuser:$githubpass" -H "Authorization: token $OAUTHTOKEN" --request DELETE "https://api.github.com/repos/"$githuborg"/"$slug"/labels/good%20first%20issue"

				# Add our custom labels.
				curl -s -u "$githubuser:$githubpass" -H "Authorization: token $OAUTHTOKEN" --request POST --data '{"name":"Epic","description":"Epic issue that consists of multiple sub-issues.","color":"0052cc"}' "https://api.github.com/repos/"$githuborg"/"$slug"/labels" &> /dev/null
				curl -s -u "$githubuser:$githubpass" -H "Authorization: token $OAUTHTOKEN" --request POST --data '{"name":"Sub","description":"Sub-issue belonging to the parent Epic issue.","color":"b60205"}' "https://api.github.com/repos/"$githuborg"/"$slug"/labels" &> /dev/null
				curl -s -u "$githubuser:$githubpass" -H "Authorization: token $OAUTHTOKEN" --request POST --data '{"name":"Bug (Confirmed)","description":"Bug that has been confirmed and requires a fix.","color":"b60205"}' "https://api.github.com/repos/"$githuborg"/"$slug"/labels" &> /dev/null
				curl -s -u "$githubuser:$githubpass" -H "Authorization: token $OAUTHTOKEN" --request POST --data '{"name":"Bug (Reported)","description":"Bug that has been reported, but not confirmed.","color":"e99695"}' "https://api.github.com/repos/"$githuborg"/"$slug"/labels" &> /dev/null
				curl -s -u "$githubuser:$githubpass" -H "Authorization: token $OAUTHTOKEN" --request POST --data '{"name":"Blocked","description":"Blocked by matters that are outside our control.","color":"fbca04"}' "https://api.github.com/repos/"$githuborg"/"$slug"/labels" &> /dev/null
				curl -s -u "$githubuser:$githubpass" -H "Authorization: token $OAUTHTOKEN" --request POST --data '{"name":"On Hold","description":"Feature that is to be frozen until further notice.","color":"d93f0b"}' "https://api.github.com/repos/"$githuborg"/"$slug"/labels" &> /dev/null
				curl -s -u "$githubuser:$githubpass" -H "Authorization: token $OAUTHTOKEN" --request POST --data '{"name":"Help Needed","description":"Request for assistance from another Engineer.","color":"d4c5f9"}' "https://api.github.com/repos/"$githuborg"/"$slug"/labels" &> /dev/null
				curl -s -u "$githubuser:$githubpass" -H "Authorization: token $OAUTHTOKEN" --request POST --data '{"name":"PR: Do Not Merge","description":"Pull Request that cannot not be merged in yet.","color":"d93f0b"}' "https://api.github.com/repos/"$githuborg"/"$slug"/labels" &> /dev/null
				curl -s -u "$githubuser:$githubpass" -H "Authorization: token $OAUTHTOKEN" --request POST --data '{"name":"PR: Needs Merge","description":"Pull Request that can be merged into master.","color":"0e8a16"}' "https://api.github.com/repos/"$githuborg"/"$slug"/labels" &> /dev/null
				curl -s -u "$githubuser:$githubpass" -H "Authorization: token $OAUTHTOKEN" --request POST --data '{"name":"PR: Client Review","description":"Feature is now on the Client Review site.","color":"fef2c0"}' "https://api.github.com/repos/"$githuborg"/"$slug"/labels" &> /dev/null
				curl -s -u "$githubuser:$githubpass" -H "Authorization: token $OAUTHTOKEN" --request POST --data '{"name":"PR: MKDO Review","description":"Feature is now on the Make Do Review site.","color":"c2e0c6"}' "https://api.github.com/repos/"$githuborg"/"$slug"/labels" &> /dev/null
				curl -s -u "$githubuser:$githubpass" -H "Authorization: token $OAUTHTOKEN" --request POST --data '{"name":"PR: Needs Testing","description":"Pull Request that is ready for independent testing.","color":"#6e5abc"}' "https://api.github.com/repos/"$githuborg"/"$slug"/labels" &> /dev/null
				curl -s -u "$githubuser:$githubpass" -H "Authorization: token $OAUTHTOKEN" --request POST --data '{"name":"Needs Detail","description":"Issue that is not sufficiently fleshed out.","color":"111111"}' "https://api.github.com/repos/"$githuborg"/"$slug"/labels" &> /dev/null

				# Clone the new repository.
				git clone git@github.com:"$githuborg"/"$slug".git &> /dev/null

				if [ -d "$slug" ]

					then

					# Enter the repository directory.
					echo "$(tput setaf 3)Switching to repository directory...$(tput setaf 9)"
					echo

					cd "$slug"

				fi

			else

				if [ "$httpstatus" = "401" ]
					then
					echo "$(tput setaf 1)HTTP status is $httpstatus $(tput setaf 9)"
				fi

				echo "$(tput setaf 1)ERROR: failed to create the repository!$(tput setaf 9)"
				echo

				exit 1

		fi

	else

		echo "$(tput setaf 1)ERROR: this script has been executed inside an existing repository!$(tput setaf 9)"
		echo

		exit 1

fi

# Fetch and extract the archives from GitHub.
echo "$(tput setaf 3)Downloading MKDO Base repository...$(tput setaf 9)"
echo

downloadurl="https://github.com/mkdo/mkdo-base/archive/master.zip";

curl -s -Lo "mkdo-base-master.zip" "$downloadurl"

unzip "mkdo-base-master.zip" &> /dev/null 2>&1

echo "$(tput setaf 3)Scaffolding your MKDO Base instance...$(tput setaf 9)"
echo

# Move Base.
bpdir="mkdo-base-master";
if [ -d "$bpdir" ]
	then
	cp -r "$bpdir"/* .
	cp -r "$bpdir"/.deployignore .
	cp -r "$bpdir"/.gitignore .
	cp -r "$bpdir"/.github .
	cp -r "$bpdir"/.huskyrc.js .
	cp -r "$bpdir"/.babelrc.js .
	cp -r "$bpdir"/.eslintrc.js .
	cp -r "$bpdir"/.postcssrc.js .
	cp -r "$bpdir"/.prettierrc.js .
	cp -r "$bpdir"/.stylelintrc.js .
fi

# Remove the archives for good housekeeping.
rm ./*.zip
rm -r mkdo-base-master

# String replacements using input variables
echo "$(tput setaf 3)Carrying out string replacements...$(tput setaf 9)"
echo
for file in $(find .  -type f ! -name '*.woff' ! -name '*.ttf' ! -name '*.eot' ! -name '*.ico' ! -name '' ! -name 'setup.sh' ! -name '.DS_Store' ! -name '*.png' ! -name '*.mo'); do
	if [[ -f $file ]] && [[ -w $file ]]; then

		# This is needed in order for this script to work with BSD & GNU sed
		bakfile=".bak"

		# Slug - hyphen and underscore replacements.
		if [[ "$slug" ]]
		then
		sed -i$bakfile "s/my-project/$slug/g" "$file"

		underslug=$(echo $slug|tr '-' '_')
		sed -i$bakfile "s/my_project/$underslug/g" "$file"
		fi

		# Nice Name.
		if [[ "$nicename" ]]
		then
		sed -i$bakfile "s/My Project/$nicename/g" "$file"
		fi
	fi
done

# Remove all the .bak files
find . -name '*.bak' -delete

# Rename the Theme
mv build/wp-content/themes/my-project build/wp-content/themes/"$slug"

# Create MySQL database.
echo "$(tput setaf 3)Creating MySQL database (if it's not already there)...$(tput setaf 9)"
echo
underslug=$(echo $slug|tr '-' '_')

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

	# Remove/Install/Activate Plugins.
	echo "$(tput setaf 3)Tinkering with plugins...$(tput setaf 9)"
	echo

	# Remove.
	rm -rf build/wp-content/plugins/akismet

	# Install.
	wp plugin install better-search-replace --activate --path=build/wordpress &> /dev/null
	wp plugin install debug-bar --activate --path=build/wordpress &> /dev/null
	wp plugin install regenerate-thumbnails --activate --path=build/wordpress &> /dev/null
	wp plugin install imsanity --activate --path=build/wordpress &> /dev/null
	wp plugin install wp-smushit --activate --path=build/wordpress &> /dev/null
	wp plugin install so-clean-up-wp-seo --activate --path=build/wordpress &> /dev/null
	wp plugin install user-switching --activate --path=build/wordpress &> /dev/null
	wp plugin install wp-mail-catcher --activate --path=build/wordpress &> /dev/null
	wp plugin install wordpress-seo --activate --path=build/wordpress &> /dev/null
	wp plugin install https://github.com/wp-premium/gravityforms/archive/master.zip --activate --path=build/wordpress &> /dev/null

	# Load our mu-plugins.
	echo "require_once( plugin_dir_path( __FILE__ ) . 'mkdo-core/plugin.php' );" >> build/wp-content/mu-plugins/loader.php

	# Copy the MKDO Core configuration template
	# into the theme includes folder.
	mkdocoredir="build/wp-content/mu-plugins/mkdo-core"
	themeincludesdir="build/wp-content/themes/$slug/inc"

	if [ -d "$themeincludesdir" ]
		then

		cp $mkdocoredir/mkdo-core-config-template.php $themeincludesdir
	fi

	# Generate Salts.
	echo "$(tput setaf 3)Generating salts...$(tput setaf 9)"
	echo
	echo '<?php' > build/salt.php && curl -Ls https://api.wordpress.org/secret-key/1.1/salt/ >> build/salt.php

	# Update WP Options.
	echo "$(tput setaf 3)Updating WordPress options...$(tput setaf 9)"
	echo

	# Set the site name to the supplied nice name.
	wp option update blogname "$nicename" --allow-root --path=build/wordpress &> /dev/null

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

# Ignore local-config.php
gitignorefile=".gitignore"
gitignoretarget="!build/local-config.php"
gitignorereplace="build/local-config.php"

if [ -f "$gitignorefile" ]
	then

	echo "$(tput setaf 3)Adding local-config.php to Git ignored files...$(tput setaf 9)"
	echo

	sed -i'' -- "s#$gitignoretarget#$gitignorereplace#g" "$gitignorefile"
fi

# Build the project.
echo "$(tput setaf 3)Building front-end assets...$(tput setaf 9)"
echo
yarn run dev &> /dev/null

if [ -d "$gitdir" ]
	then

	echo "$(tput setaf 3)Committing and pushing to repo...$(tput setaf 9)"
	echo

	git add .
	git commit -m "Initial MKDO Base instance." --no-verify  &> /dev/null
	git push origin master  &> /dev/null

	echo "$(tput setaf 3)Creating the addition default branches (staging, review)...$(tput setaf 9)"
	echo

	# Staging
	git checkout -b staging  &> /dev/null
	git push origin staging  &> /dev/null
	git branch --set-upstream-to=origin/staging staging  &> /dev/null

	# Review
	git checkout -b review  &> /dev/null
	git push origin review  &> /dev/null
	git branch --set-upstream-to=origin/review review  &> /dev/null

	# Back to Master
	git checkout master  &> /dev/null
fi

# Success!
echo "$(tput setaf 2)Success! Your MKDO Base instance has now been created.$(tput setaf 9)"
echo

# Set-up Valet
printf "$(tput setaf 3)Would you like to configure this site for Valet? (y|n) $(tput setaf 9)"
read -e configurevalet
echo

if [ "$configurevalet" = "y" ] || [ "$configurevalet" = "Y" ]
	then

	hash valet 2>&- || { echo >&2 "$(tput setaf 1)Valet is not installed. Exiting.$(tput setaf 9)"; exit 1; }

	cd build
	valet link "$slug" &> /dev/null
	valet secure &> /dev/null

fi

# Remove MKDO Base Setup script.
echo "$(tput setaf 3)Removing MKDO Base Setup script...$(tput setaf 9)"
echo

setupscript="setup.sh"
if [ -f "$setupscript" ]
	then

	rm setup.sh
	rm README.md
	cd ..
	rm setup.sh
	cd "$slug"
fi

echo "$(tput setaf 2)Fin. :)$(tput setaf 9)"
