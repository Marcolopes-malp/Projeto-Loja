<?php
$dir = __DIR__;

function processFile($full) {
    $content = file_get_contents($full);
    $is_pages = (strpos($full, '/pages/') !== false || strpos($full, '\\pages\\') !== false);
    $is_includes = (strpos($full, '/includes/') !== false || strpos($full, '\\includes\\') !== false);
    $is_root = !$is_pages && !$is_includes;
    
    $prefix = $is_pages ? '../' : './';
    $original = $content;
    
    if ($is_includes) {
        if (basename($full) === 'header.php') {
            // Define BASE_URL if not present
            if (strpos($content, '$BASE_URL =') === false) {
                $content = preg_replace('/<\?php/', "<?php\n\$is_page = strpos(\$_SERVER['SCRIPT_NAME'], '/pages/') !== false;\n\$BASE_URL = \$is_page ? '..' : '.';\n", $content, 1);
            }
            $content = str_replace('./', '<?= $BASE_URL ?>/', $content);
            $content = str_replace("'./", "'<?= \$BASE_URL ?>/", $content);
        } else if (basename($full) === 'footer.php') {
            $content = str_replace('./', '<?= $BASE_URL ?>/', $content);
        }
    } else {
        // Replace HTML string links and PHP redirects
        $content = str_replace('./', $prefix, $content);
    }
    
    if ($content !== $original) {
        file_put_contents($full, $content);
    }
}

function traverse($path) {
    foreach (scandir($path) as $d) {
        if ($d == '.' || $d == '..') continue;
        $full = $path . '/' . $d;
        if (is_dir($full)) {
            traverse($full);
        } else if (pathinfo($full, PATHINFO_EXTENSION) == 'php') {
            processFile($full);
            echo "Processed $full\n";
        }
    }
}
traverse($dir);
echo "Fix complete.\n";
