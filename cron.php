<?php
$path = "data/user";
if ($handle = opendir($path)) {
    while (false !== ($entry = readdir($handle))) {
        if ($entry != "." && $entry != "..") {
            $sub_path = $path . "/" . $entry;
            if (is_dir($sub_path)) {
                $file_to_delete = $sub_path . "/respans.txt";
                if (file_exists($file_to_delete)) {
                    unlink($file_to_delete);
                }
            }
        }
    }
    closedir($handle);
}
?>