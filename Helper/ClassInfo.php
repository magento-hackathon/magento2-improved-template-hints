<?php

namespace MagentoHackathon\ImprovedTemplateHints\Helper;

class ClassInfo extends \Magento\Framework\App\Helper\AbstractHelper {


    /**
     * Find file and line of the class statement
     *
     * @param $className
     * @return bool|array
     */
    public function findFileAndLine($className) {
        $result = false;
        $fullPath = $this->searchFullPath($this->getFileFromClassName($className));
        //die($this->getFileFromClassName($className));
        if ($fullPath) {
            $result = array('file' => $fullPath, 'line' => 0);
            $lineNumber = $this->getLineNumber($fullPath, '/class\s+'.$className.'/');
            if ($lineNumber) {
                $result['line'] = $lineNumber;
            }
        }
        return $result;
    }



    /**
     * Get the line number of the first line in a file matching a given regex
     * Not the nicest solution, but probably the fastest
     *
     * @param $file
     * @param $regex
     * @return bool|int
     */
    public function getLineNumber($file, $regex) {
        $i = 0;
        $lineFound = false;
        $handle = @fopen($file, 'r');
        if ($handle) {
            while (($buffer = fgets($handle, 4096)) !== false) {
                $i++;
                if (preg_match($regex, $buffer)) {
                    $lineFound = true;
                    break;
                }
            }
            fclose($handle);
        }
        return $lineFound ? $i : false;
    }



    /**
     * Find a filename in the include path fallback
     *
     * @param $filename
     * @return bool|string
     */
    public function searchFullPath($filename) {
        return file_exists($filename);
    }



    /**
     * Get php file from class name
     *
     * @param $className
     * @return string
     */
    public function getFileFromClassName($className) {
        $reflector = new \ReflectionClass($className);
        return $reflector->getFileName();
    }

}