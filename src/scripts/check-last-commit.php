<?php


// Funkce pro získání seznamu všech tagů, seřazených od nejnovějších
function getGitTags() {
	$output = shell_exec('git tag --sort=-v:refname');
	$tags = explode("\n", trim($output));
	return $tags;
}

// Funkce pro získání seznamu commitů mezi dvěma tagy
function getCommitsBetweenTags($tag1, $tag2) {
	$output = shell_exec('git log --pretty=format:"%H,%s" ' . $tag1 . '...' . $tag2);
	$commits = explode("\n", trim($output));
	return $commits;
}

// Získání seznamu všech tagů
$tags = getGitTags();

$pattern = '/^(feat|fix|docs|style|refactor|test|chore|perf|build|ops)(\([^)]+\))?!?: ((.|\n)+)/';
$invalidCommits = [];

// Pokud jsou k dispozici minimálně dva tagy, získáme commit mezi nimi
if (count($tags) >= 2) {
	$latestTag = $tags[0];
	$previousTag = $tags[1];

	echo "Poslední dva tagy: $latestTag, $previousTag\n";

	// Získání seznamu commitů mezi dvěma tagy
	$commits = getCommitsBetweenTags($previousTag, $latestTag);

	// Vypsání commitů
	echo "Commity mezi tagy $previousTag a $latestTag:\n";

	foreach ($commits as $commit) {
		[$id, $commitMessage] = \explode(',', $commit);

		$loweredMessage = \strtolower($commitMessage);

		if (\str_starts_with($loweredMessage, 'merge')) {
			continue;
		}

		$isValid = preg_match($pattern, $commitMessage);

		if ($isValid) {
			echo "Conventional commits in $id: OK\n";
		} else {
			echo "Conventional commits in $id: ERR\n";

			$invalidCommits[] = $id;
		}
	}
} else {
	exit(0);
}

exit($invalidCommits ? 1 : 0);
