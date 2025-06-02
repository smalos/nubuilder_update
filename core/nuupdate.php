<?php


function nuRunUpdate() {
	echo "nuRunUpdate";
}

return;

function listFilesRecursive($directory, $basePath = '', $excludes = [], $rootIncludes = []) {
    $files = [];

    $directory = rtrim($directory, '/');

    $items = scandir($directory);
    foreach ($items as $item) {
        if ($item === '.' || $item === '..') continue;

        $fullPath = "$directory/$item";
        $relativePath = $basePath === '' ? $item : "$basePath/$item";

        // 🔒 If at root, only include items in the include list
        if ($basePath === '' && !in_array($item, $rootIncludes)) {
            continue;
        }

        // 🚫 Skip if in the exclude list
        if (in_array($relativePath, $excludes)) {
            continue;
        }

        if (is_dir($fullPath)) {
            // Recurse into allowed subdirectories
            $files = array_merge($files, listFilesRecursive($fullPath, $relativePath, $excludes, $rootIncludes));
        } else {
            $files[] = $relativePath;
        }
    }

    return $files;
}

function 

$rootIncludes = [
    'index.php',
    'LICENSE.txt',
	"nubuilder4.sql",
	"nuconfig-sample.php",
	"README.md",
	"readme.txt",
	"update.htm",
	"version.txt",
	"core"
];


$excludes = [
    'abc.js',          // file in the base directory
    'abc/efg.php',     // file inside subdirectory 'abc'
    'nuconfig.php',    // exclude a whole folder
];



$files = listFilesRecursive(__DIR__, '', $excludes, $rootIncludes);


// header('Content-Type: application/json');
// echo json_encode($files, JSON_PRETTY_PRINT);

// file_put_contents('filelist.json', json_encode($files, JSON_PRETTY_PRINT));


function downloadFromGitHub($jsonFile, $githubRootUrl, $savePath) {
    if (!file_exists($jsonFile)) {
        die("File not found: $jsonFile");
    }

    $fileList = json_decode(file_get_contents($jsonFile), true);

    foreach ($fileList as $relativePath) {
        $remoteUrl = rtrim($githubRootUrl, '/') . '/' . $relativePath;
        $localFile = rtrim($savePath, '/') . '/' . $relativePath;

        // Ensure local folder exists
        $localDir = dirname($localFile);
        if (!is_dir($localDir)) {
            mkdir($localDir, 0777, true);
        }

        echo "Downloading: $remoteUrl\n";

        $content = file_get_contents($remoteUrl);
        if ($content === false) {
            echo "Failed to download: $remoteUrl\n";
            continue;
        }

        file_put_contents($localFile, $content);
    }

    echo "Download complete.\n";
}

$start = time();

$githubRoot = 'https://raw.githubusercontent.com/nuBuilder/nuBuilder/refs/heads/master';
$localDownloadPath = __DIR__; // . '/downloaded'; // or another folder
$jsonList = 'filelist.json';

downloadFromGitHub($jsonList, $githubRoot, $localDownloadPath);


$end = time();
$duration = $end - $start; // duration in seconds
echo "Duration: $duration seconds";