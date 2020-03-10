<? 
/*
 * This short script find your BOM files in the GET moment
*/
function findBOM(){
    function xdir($path,$recurs) {
        global $find;
        if ($dir = @opendir($path)) {
            while($file = readdir($dir)) {
                if ($file == '.' or $file == '..') continue;
                $file = $path.'/'.$file;
                if (is_dir($file) && $recurs)  {
                    xdir($file,1);
                }
                if (is_file($file) && strstr($file,'.php')) { 
                    $f = fopen($file,'r');
                    $t = fread($f, 3);
                    if ($t == "\xEF\xBB\xBF") {
                        $find = 1;
                        echo "$file<br>\n";
                    }
                    fclose ($f);
                }
            }  
            closedir($dir);
        }
    }
    xdir('.',1);
    xdir('../',1);
    xdir('../../plugins',1);
    if ($find == 0) echo __("All clear");
}
if(isset($_GET['findBOM'])){
    findBOM();
}