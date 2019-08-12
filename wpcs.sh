#!/bin/bash

echo ""
echo $(tput setaf 3)Tidying up PHP if needed...$(tput setaf 7);
git diff --name-only --cached --diff-filter=ACMRTUXB | xargs -I % sh -c 'phpcbf -q %  > /dev/null || true; git add %;';
echo ""
git diff --name-only --cached --diff-filter=ACMRTUXB | xargs phpcs --standard=./phpcs.xml --report-full=./wpcs-errors.md;
if [[ $(wc -c <wpcs-errors.md) -gt 10 ]];
	then
		echo $(tput setaf 1)Fix coding standards issues reported in wpcs-errors.md and re-commit. $(tput setaf 7) && echo "" && exit 1;
	else
		echo $(tput setaf 2)No php coding standards issues found! $(tput setaf 7);
fi;
echo "";
