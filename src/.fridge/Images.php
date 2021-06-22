<?php
/* This file is part of Jack | SSITU | (c) 2021 I-is-as-I-does | MIT License */
namespace SSITU\Jack\Trades;

use \SSITU\Jack\Jack;

class Images
{  

    public function saveb64InPng($dataimg, $path)
    {
        $decdimg = $this->decodeb64($dataimg);
        return Jack::File()->write($decdimg, $path);
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


}
