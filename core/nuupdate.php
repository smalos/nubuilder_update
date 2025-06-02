<?php

function nuDownloadFromGitHub(string $jsonFile, string $githubRootUrl, string $savePath): void
{
    if (!file_exists($jsonFile)) {
        die("File not found: $jsonFile");
    }

    $decoded = json_decode(file_get_contents($jsonFile), true);
    if (!is_array($decoded) || !isset($decoded['files'])) {
        die("Invalid JSON structure: expecting top‐level keys \"version\" and \"files\".");
    }

    // e.g. echo "Version: " . $decoded['version'] . "\n";

    $tree = $decoded['files'];
    nuDownloadTreeNode($tree, $githubRootUrl, $savePath);

    echo "Download complete.\n";
}

function nuDownloadTreeNode(array $node, string $githubRootUrl, string $savePath): void
{
    foreach ($node as $name => $value) {
        if (is_array($value)) {
            nuDownloadTreeNode($value, $githubRootUrl, $savePath);
        } else {

            $relativePath = $value;
            $remoteUrl    = rtrim($githubRootUrl, '/') . '/' . $relativePath;
            $localFile    = rtrim($savePath, '/') . '/' . $relativePath;

            $localDir = dirname($localFile);
            if (!is_dir($localDir)) {
                mkdir($localDir, 0777, true);
            }

            echo "Downloading: $remoteUrl\n";

            $content = @file_get_contents($remoteUrl);
            if ($content === false) {
                echo "  ➔ Failed to download: $remoteUrl\n";
                continue;
            }

            file_put_contents($localFile, $content);
        }
    }
}

function nuUpdateFiles() {

	// Example usage:
	$githubRoot       = 'https://raw.githubusercontent.com/nuBuilder/nuBuilder/refs/heads/master';
	
	$localDownloadDir = __DIR__;
	$jsonList = 'filelist.json';
	$start = microtime(true);
	nuDownloadFromGitHub($jsonList, $githubRoot, $localDownloadDir);
	$elapsed = microtime(true) - $start;
	echo "Elapsed time: " . round($elapsed, 2) . " seconds.\n";

}