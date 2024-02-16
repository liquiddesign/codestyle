<?php

// Načtení zprávy z posledního commitu
$commitMessage = shell_exec('git log -1 --format=%B');

// Ověření formátu conventional commits
$pattern = '/^(feat|fix|docs|style|refactor|test|chore|perf|build|ops)(\([^)]+\))?!?: ((.|\n)+)/';
$isValid = preg_match($pattern, $commitMessage);

// Výsledek
if ($isValid) {
	echo "Conventional commits in last commit: OK";
} else {
	echo "Conventional commits in last commit: ERR";
}

exit($isValid ? 0 : 1);
