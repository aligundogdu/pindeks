#!/usr/bin/php -q
<?php

echo "\n";
$dizin = $argv[1];
$cikti = directoryToArray($dizin,true);
$toplam = 0;
$say = 0;
foreach($cikti as $dizin){
    $toplam++;
    $buldum = false;
    if(is_dir($dizin)){
            $buldum = false;
            $dosyalar = array("index.php","index.html","index.htm");
            foreach($dosyalar as $dosya){
                if(file_exists($dizin."/$dosya")){
                    $buldum=true;
                }
            }
            if(!$buldum){
                $say++;
                $dosya = "$dizin/index.html";
                $fh = fopen($dosya, 'w') or die("can't open file");
                fwrite($fh, "<!--PinDeks-->");
                fclose($fh);
                echo $dizin."\n :: dosya oluşturuldu";
            }
    }
}

echo "====================\n";
echo "Toplam : $toplam adet dizin\n";
echo "Dosya : $say \n";
echo "====================\n";

function directoryToArray($directory, $recursive) {
	$array_items = array();
	if ($handle = opendir($directory)) {
		while (false !== ($file = readdir($handle))) {
			if ($file != "." && $file != "..") {
				if (is_dir($directory. "/" . $file)) {
					if($recursive) {
						$array_items = array_merge($array_items, directoryToArray($directory. "/" . $file, $recursive));
					}
					$file = $directory . "/" . $file;
					$array_items[] = preg_replace("/\/\//si", "/", $file);
				} else {
					$file = $directory . "/" . $file;
					$array_items[] = preg_replace("/\/\//si", "/", $file);
				}
			}
		}
		closedir($handle);
	}
	return $array_items;
}