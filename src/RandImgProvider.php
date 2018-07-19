<?php

namespace Siro\RandImg;

use Faker\Provider\Base;
use InvalidArgumentException;

class RandImgProvider extends Base
{
    /**
     * @var string
     */
    private $baseUrl = 'http://www.rand-img.com';
    
    /**
     * Utility method for provide random numbers for the urls.
     *
     * @return integer Random number.
     */
    private function getRandNumber($min = 1, $max = 1000000)
    {
        return mt_rand($min, $max);
    }

    /**
     * Downloads a file from the specified url and saves it in the
     * full path passed. It uses cURL.
     *
     * @param string $url      The url of the image to download
     * @param string $filePath The full path where store the image
     *
     * @return bool true if success, else remove the image and return false.
     */
    private function getRemoteImage($url, $filePath)
    {
        $fp = fopen($filePath, 'w');
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_FILE, $fp);
        $success = curl_exec($ch) && curl_getinfo($ch, CURLINFO_HTTP_CODE) === 200;
        fclose($fp);
        curl_close($ch);

        if (!$success) {
            unlink($filePath);

            return false;
        }

        return true;
    }

    /**
     * Generate a random image url.
     *
     * @param integer $width
     * @param integer $height
     * @param string  $category The image topic. Defaults to empty (no category).
     * @param array   $params   Optional associative array with the list of parameters for the image.
     *  You can see a list of parameters and its possible values in
     *  https://github.com/SiroDiaz/RandImgProvider/blob/master/README.md
     *
     * @return string Returns the phrase passed in
     */
    public function imageUrl($width = 720, $height = 480, $category = '', array $params = [])
    {
        $url = $this->baseUrl;
        $url .= "/$width";
        $url .= "/$height";
        $url .= !empty($category) ? "/$category" : '';

        if (isset($params['rand']) && $params['rand']) {
            $params['rand'] = $this->getRandNumber();
        }
        
        if (count($params)) {
            $url .= '?'. http_build_query($params);
        }

        return $url;
    }

    /**
     * Helper method that generate a squared image url.
     *
     * @param int $width The image width. Default to 720px.
     * @param array $params Optional associative array with the list of parameters for the image.
     */
    public function squaredImageUrl($width = 720, $category = '', array $params = [])
    {
        return $this->imageUrl($width, $width, $category, $params);
    }

    /**
     * Generate a random gif url. It can attach
     * a random number to avoid that multiple gifs loaded
     * in the page will be all the same gif.
     *
     * @param bool $rand Defaults to false
     */
    public function gifUrl($rand = false)
    {
        return $rand
            ? $this->baseUrl .'/gif?rand='. $this->getRandNumber()
            : $this->baseUrl .'/gif';
    }
    
    /**
     * Downloads an image to the specified directory.
     *
     * @param string $dir
     * @param integer $width
     * @param integer $height
     * @param string $category
     * @param array $params
     * @throws InvalidArgumentException If not a directory or writeable
     *
     * @return string Filename with the path
     */
    public function image($dir = null, $width = 720, $height = 480, $category = '', array $params = [])
    {
        $dir = is_null($dir) ? sys_get_temp_dir() : $dir;
        if (!is_dir(filename) || !is_writeable($dir)) {
            throw new InvalidArgumentException(sprintf('Cannot write to directory "%s"', $dir));
        }

        $fileName = md5(uniqid(empty($_SERVER['SERVER_ADDR']) ? '' : $_SERVER['SERVER_ADDR'], true)) .'.jpg';
        $filePath = $dir . DIRECTORY_SEPARATOR . $fileName;
        $url = $this->imageUrl($width, $height, $category, $params);
        $this->getRemoteImage($url, $filePath);
        
        return $filePath;
    }

    /**
     * Downloads a gif to the specified directory.
     *
     * @param string $dir
     * @throws InvalidArgumentException If not a directory or writeable
     *
     * @return string Filename with the path
     */
    public function gif($dir = null)
    {
        $dir = is_null($dir) ? sys_get_temp_dir() : $dir;
        if (!is_dir(filename) || !is_writeable($dir)) {
            throw new InvalidArgumentException(sprintf('Cannot write to directory "%s"', $dir));
        }

        $fileName = md5(uniqid(empty($_SERVER['SERVER_ADDR']) ? '' : $_SERVER['SERVER_ADDR'], true)) .'.gif';
        $filePath = $dir . DIRECTORY_SEPARATOR . $fileName;
        $url = $this->imageUrl($width, $height, $category, $params);
        $this->getRemoteImage($url, $filePath);
        
        return $filePath;
    }
}
