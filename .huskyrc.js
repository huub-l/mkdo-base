const tasks = arr => arr.join(' && ');

module.exports = {
	hooks: {
		'pre-commit': tasks([
			'echo ""',
			'echo "$(tput setaf 3)Tidying up PHP if needed...$(tput setaf 7)"',
			'git diff --name-only --cached --diff-filter=ACMRTUXB | xargs phpcbf -q &> /dev/null  || :',
			'echo ""',
			'echo "$(tput setaf 3)Making sure PHP passes coding standards checks...$(tput setaf 7)"',
			'echo ""',
			'git diff --name-only --cached --diff-filter=ACMRTUXB | xargs phpcs -q --standard=./phpcs.xml --report-full=./wpcs-errors.md || :',
			'FILESIZE=$(wc -c <wpcs-errors.md)',
			'if [ "$FILESIZE" -gt 10 ]; then echo "$(tput setaf 1)Fix coding standards issues reported in wpcs-errors.md and re-commit! $(tput setaf 7)"; exit 1; else echo "$(tput setaf 2)No coding standards issues found! $(tput setaf 7)"; fi',
		]),
	},
};
