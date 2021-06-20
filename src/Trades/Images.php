<?php
/* This file is part of Jack | SSITU | (c) 2021 I-is-as-I-does | MIT License */
namespace SSITU\Jack\Trades;

use \SSITU\Jack\Jack;

class Images
{

    public function b64ToRsrc($dataimg)
    {
        $decdimg = $this->decodeb64($dataimg);
        if ($decdimg !== false) {
            return imagecreatefromstring($decdimg);
        }
        return false;
    }

    public function saveb64InPng($dataimg, $path)
    {
        $decdimg = $this->decodeb64($dataimg);
        return Jack::File()->write($decdimg, $path);
    }

    public function decodeb64($dataimg)
    {
        if (stripos($dataimg, 'data:image/png;base64,') === false) {
            return false;
        }

        $dataimg = str_replace('data:image/png;base64,', '', $dataimg);
        $dataimg = str_replace(' ', '+', $dataimg);
        return base64_decode($dataimg);
    }

    public function fileTob64($path)
    {
        $data = Jack::File()->getContents($path);
        if (!empty($data)) {
            $type = Jack::File()->getExt($path);
            return 'data:image/' . $type . ';base64,' . base64_encode($data);
        }
        return false;
    }

    public function fileToRsc($path)
    {
        $ext = Jack::File()->getExt($path);
        if ($ext === 'jpg') {
            $ext = 'jpeg';
        }
        switch ($ext) {
            case 'png':
                $rscImg = imagecreatefrompng($path);
                break;
            case 'gif':
                $rscImg = imagecreatefromgif($path);
                break;
            case 'webp':
                $rscImg = imagecreatefromwebp($path);
                break;
            case 'jpeg':
                $rscImg = imagecreatefromjpeg($path);
                break;
            default:
                $rscImg = false;

        }
        return $rscImg;

    }

    public function rsrcTob64png($img)
    {
        // @doc: buffering is required; can't directly base64 encode the img resource
        ob_start();
        imagepng($img);
        $contents = ob_get_contents();
        ob_end_clean();
        return "data:image/png;base64," . base64_encode($contents);
    }
}
