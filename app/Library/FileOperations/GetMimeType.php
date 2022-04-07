<?php

namespace App\Library\FileOperations;


class   GetMimeType
{
    public static function getFileMime($ext)
    {
        $mime = null;
        switch ($ext) {
            case "jpg":
                $mime = "image/jpeg";
                break;
            case "jpeg":
                $mime =  "image/jpeg";
                break;
            case "png":
                $mime =  "image/png";
                break;
            case "gif":
                $mime =  "image/gif";
                break;
            case "bmp":
                $mime =  "image/bmp";
                break;
            case "psd":
                $mime =  "application/psd";
                break;
            case "pptx":
                $mime =  "application/vnd.openxmlformats-officedocument.presentationml.presentation";
                break;
            case "ppt":
                $mime =  "application/vnd.ms-powerpointtd>";
                break;
            case "mdb":
                $mime =  "application/mdb";
                break;
            case "mdbx":
                $mime =  "application/mdbx";
                break;
            case "doc":
                $mime =  "application/msword";
                break;
            case "docx":
                $mime =  "application/docx";
                break;
            case "xlsx":
                $mime =  "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet";
                break;
            case "xls":
                $mime =  "application/vnd.ms-excel";
                break;
            default:
                $mime =  "application/octet-stream";
        }
        return $mime;
    }
}
