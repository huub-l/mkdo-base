#!/usr/bin/env bash
# MKDO Base Setup Script - v1.0.0
# NOTE: This script Requires a Bash shell on OSX
# -----------------------------------------------------------------------------

OAUTHTOKEN=$(<~/.mkdobase_token)

if [ ! "$OAUTHTOKEN" ]
	then

	echo "$(tput setaf 1)Aborting; no GitHub token found in ~/.mkdobase_token$(tput setaf 9)"
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

		# Public or Private repo?
		printf "$(tput setaf 3)Is this a private repo? (y|n) $(tput setaf 9)"
		read -e githubprivate
		echo

		# Exit if no GitHub password entered.
		if [ "$githubprivate" = "y" ] || [ "$githubprivate" = "Y" ]
			then

			# Attempt to create the repository
			echo "$(tput setaf 3)Creating private repository on GitHub...$(tput setaf 9)"
			echo

			httpresponse=$(curl -s -u "$githubuser:$OAUTHTOKEN" -H "Authorization: token $OAUTHTOKEN" -w 'HTTPSTATUS:%{http_code}' -d "{\"name\":\"$slug\",\"private\":\"true\"}" https://api.github.com/orgs/"$githuborg"/repos)

		elif [ "$githubprivate" = "n" ] || [ "$githubprivate" = "N" ]
			then

			# Attempt to create the repository
			echo "$(tput setaf 3)Creating public repository on GitHub...$(tput setaf 9)"
			echo

			httpresponse=$(curl -s -u "$githubuser:$OAUTHTOKEN" -H "Authorization: token $OAUTHTOKEN" -w 'HTTPSTATUS:%{http_code}' -d "{\"name\":\"$slug\"}" https://api.github.com/orgs/"$githuborg"/repos)

		else
			echo "$(tput setaf 1)ERROR: enter \"y\" or \"n\"$(tput setaf 9)"
			echo

			exit 1
		fi

		httpstatus=$(echo "$httpresponse" | tr -d '\n' | sed -e 's/.*HTTPSTATUS://')

		# Proceed if successful.
		if [ "$httpstatus" = "201" ]
			then

				echo "$(tput setaf 3)Carrying out label housekeeping...$(tput setaf 9)"
				echo

				# Delete default labels.
				curl -s -u "$githubuser:$OAUTHTOKEN" -H "Authorization: token $OAUTHTOKEN" --request DELETE "https://api.github.com/repos/"$githuborg"/"$slug"/labels/bug"
				curl -s -u "$githubuser:$OAUTHTOKEN" -H "Authorization: token $OAUTHTOKEN" --request DELETE "https://api.github.com/repos/"$githuborg"/"$slug"/labels/duplicate"
				curl -s -u "$githubuser:$OAUTHTOKEN" -H "Authorization: token $OAUTHTOKEN" --request DELETE "https://api.github.com/repos/"$githuborg"/"$slug"/labels/enhancement"
				curl -s -u "$githubuser:$OAUTHTOKEN" -H "Authorization: token $OAUTHTOKEN" --request DELETE "https://api.github.com/repos/"$githuborg"/"$slug"/labels/invalid"
				curl -s -u "$githubuser:$OAUTHTOKEN" -H "Authorization: token $OAUTHTOKEN" --request DELETE "https://api.github.com/repos/"$githuborg"/"$slug"/labels/question"
				curl -s -u "$githubuser:$OAUTHTOKEN" -H "Authorization: token $OAUTHTOKEN" --request DELETE "https://api.github.com/repos/"$githuborg"/"$slug"/labels/wontfix"
				curl -s -u "$githubuser:$OAUTHTOKEN" -H "Authorization: token $OAUTHTOKEN" --request DELETE "https://api.github.com/repos/"$githuborg"/"$slug"/labels/help%20wanted"
				curl -s -u "$githubuser:$OAUTHTOKEN" -H "Authorization: token $OAUTHTOKEN" --request DELETE "https://api.github.com/repos/"$githuborg"/"$slug"/labels/good%20first%20issue"

				# Add our custom labels.
				curl -s -u "$githubuser:$OAUTHTOKEN" -H "Authorization: token $OAUTHTOKEN" --request POST --data '{"name":"f: Planned","description":"","color":"AAE3D2"}' "https://api.github.com/repos/"$githuborg"/"$slug"/labels" &> /dev/null
				curl -s -u "$githubuser:$OAUTHTOKEN" -H "Authorization: token $OAUTHTOKEN" --request POST --data '{"name":"f: Unplanned","description":"","color":"AAE3D2"}' "https://api.github.com/repos/"$githuborg"/"$slug"/labels" &> /dev/null
				curl -s -u "$githubuser:$OAUTHTOKEN" -H "Authorization: token $OAUTHTOKEN" --request POST --data '{"name":"p: Could","description":"","color":"f99157"}' "https://api.github.com/repos/"$githuborg"/"$slug"/labels" &> /dev/null
				curl -s -u "$githubuser:$OAUTHTOKEN" -H "Authorization: token $OAUTHTOKEN" --request POST --data '{"name":"p: Should","description":"","color":"f99157"}' "https://api.github.com/repos/"$githuborg"/"$slug"/labels" &> /dev/null
				curl -s -u "$githubuser:$OAUTHTOKEN" -H "Authorization: token $OAUTHTOKEN" --request POST --data '{"name":"p: Must","description":"","color":"f99157"}' "https://api.github.com/repos/"$githuborg"/"$slug"/labels" &> /dev/null
				curl -s -u "$githubuser:$OAUTHTOKEN" -H "Authorization: token $OAUTHTOKEN" --request POST --data '{"name":"s: XS","description":"","color":"ffcc66"}' "https://api.github.com/repos/"$githuborg"/"$slug"/labels" &> /dev/null
				curl -s -u "$githubuser:$OAUTHTOKEN" -H "Authorization: token $OAUTHTOKEN" --request POST --data '{"name":"s: S","description":"","color":"ffcc66"}' "https://api.github.com/repos/"$githuborg"/"$slug"/labels" &> /dev/null
				curl -s -u "$githubuser:$OAUTHTOKEN" -H "Authorization: token $OAUTHTOKEN" --request POST --data '{"name":"s: M","description":"","color":"ffcc66"}' "https://api.github.com/repos/"$githuborg"/"$slug"/labels" &> /dev/null
				curl -s -u "$githubuser:$OAUTHTOKEN" -H "Authorization: token $OAUTHTOKEN" --request POST --data '{"name":"s: L","description":"","color":"ffcc66"}' "https://api.github.com/repos/"$githuborg"/"$slug"/labels" &> /dev/null
				curl -s -u "$githubuser:$OAUTHTOKEN" -H "Authorization: token $OAUTHTOKEN" --request POST --data '{"name":"t: Admin","description":"","color":"99cc99"}' "https://api.github.com/repos/"$githuborg"/"$slug"/labels" &> /dev/null
				curl -s -u "$githubuser:$OAUTHTOKEN" -H "Authorization: token $OAUTHTOKEN" --request POST --data '{"name":"t: Code","description":"","color":"99cc99"}' "https://api.github.com/repos/"$githuborg"/"$slug"/labels" &> /dev/null
				curl -s -u "$githubuser:$OAUTHTOKEN" -H "Authorization: token $OAUTHTOKEN" --request POST --data '{"name":"t: Design","description":"","color":"99cc99"}' "https://api.github.com/repos/"$githuborg"/"$slug"/labels" &> /dev/null
				curl -s -u "$githubuser:$OAUTHTOKEN" -H "Authorization: token $OAUTHTOKEN" --request POST --data '{"name":"x: Blocked","description":"","color":"2d2d2d"}' "https://api.github.com/repos/"$githuborg"/"$slug"/labels" &> /dev/null
				curl -s -u "$githubuser:$OAUTHTOKEN" -H "Authorization: token $OAUTHTOKEN" --request POST --data '{"name":"x: Bug","description":"","color":"cc0000"}' "https://api.github.com/repos/"$githuborg"/"$slug"/labels" &> /dev/null
				curl -s -u "$githubuser:$OAUTHTOKEN" -H "Authorization: token $OAUTHTOKEN" --request POST --data '{"name":"x: On Hold","description":"","color":"d0abfc"}' "https://api.github.com/repos/"$githuborg"/"$slug"/labels" &> /dev/null
				curl -s -u "$githubuser:$OAUTHTOKEN" -H "Authorization: token $OAUTHTOKEN" --request POST --data '{"name":"x: Reference","description":"","color":"c7f1fc"}' "https://api.github.com/repos/"$githuborg"/"$slug"/labels" &> /dev/null

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

				echo "$(tput setaf 1)ERROR: failed to create the repository!$(tput setaf 9)"
				echo "$(tput setaf 1)RESPONSE: $httpresponse$(tput setaf 9)"
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
	cp -r "$bpdir"/.babelrc.js .
	cp -r "$bpdir"/.deployignore .
	cp -r "$bpdir"/.eslintrc.js .
	cp -r "$bpdir"/.gitignore .
	cp -r "$bpdir"/.github .
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
mv wp-content/themes/my-project wp-content/themes/"$slug"

# Create MySQL database.
echo "$(tput setaf 3)Creating MySQL database (if it's not already there)...$(tput setaf 9)"
echo
underslug=$(echo $slug|tr '-' '_')

mysql -u root --password=root -e "CREATE DATABASE IF NOT EXISTS $underslug" &> /dev/null
mysql -u root --password=root -e "GRANT ALL PRIVILEGES ON $underslug.* TO wp@localhost IDENTIFIED BY 'wp';" &> /dev/null

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

	# Remove/Install/Activate Plugins.
	echo "$(tput setaf 3)Tinkering with plugins...$(tput setaf 9)"
	echo

	# Remove.
	rm -rf wp-content/plugins/akismet

	# Install.
	wp plugin install better-search-replace --activate --path=wordpress &> /dev/null
	wp plugin install debug-bar --activate --path=wordpress &> /dev/null
	wp plugin install regenerate-thumbnails --activate --path=wordpress &> /dev/null
	wp plugin install imsanity --activate --path=wordpress &> /dev/null
	wp plugin install wp-smushit --activate --path=wordpress &> /dev/null
	wp plugin install so-clean-up-wp-seo --activate --path=wordpress &> /dev/null
	wp plugin install user-switching --activate --path=wordpress &> /dev/null
	wp plugin install wp-mail-catcher --activate --path=wordpress &> /dev/null
	wp plugin install wordpress-seo --activate --path=wordpress &> /dev/null
	wp plugin install https://github.com/wp-premium/gravityforms/archive/master.zip --activate --path=wordpress &> /dev/null

	# Copy the MKDO Core configuration template
	# into the theme includes folder.
	mkdocoredir="wp-content/mu-plugins/mkdo-core"
	themeincludesdir="wp-content/themes/$slug/inc"

	if [ -d "$themeincludesdir" ]
		then

		cp $mkdocoredir/mkdo-core-config-template.php $themeincludesdir
	fi

	# Generate Salts.
	echo "$(tput setaf 3)Generating salts...$(tput setaf 9)"
	echo
	echo '<?php' > salt.php && curl -Ls https://api.wordpress.org/secret-key/1.1/salt/ >> salt.php

	# Update WP Options.
	echo "$(tput setaf 3)Updating WordPress options...$(tput setaf 9)"
	echo

	# Set the site name to the supplied nice name.
	wp option update blogname "$nicename" --allow-root --path=wordpress &> /dev/null

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

# Ignore local-config.php
gitignorefile=".gitignore"
gitignoretarget="!local-config.php"
gitignorereplace="local-config.php"

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

	valet link "$slug" &> /dev/null
	valet secure &> /dev/null
	cd ..

fi

# Remove MKDO Base Setup script.
echo "$(tput setaf 3)Removing MKDO Base Setup script...$(tput setaf 9)"
echo

setupscript="setup.sh"
if [ -f "$setupscript" ]
	then

	rm setup.sh
	rm README.md
	mv README-WORKFLOW.md README.md
	cd ..
	rm setup.sh
	cd "$slug"
fi

echo "$(tput setaf 2)Fin. :)$(tput setaf 9)"
