<?php
class FormSancitizer{
    public static  function sanitizeFormString($inputText){
        // loai bo the html 
        $inputText = strip_tags($inputText);
        // $inputText = str_replace(" ","",$inputText);
        // loai bo khoang trang 
        $inputText = trim($inputText);
        // chuoi thanh chu thuong
        $inputText = strtolower($inputText);
        // chu cai dau tien duoc viet hoa
        $inputText = ucfirst($inputText);
        return $inputText;
    }

    public static  function sanitizeFormUsername($inputText){
        // loai bo the html 
        $inputText = strip_tags($inputText);
    
        $inputText = str_replace(" ","",$inputText);
        return $inputText;
    }
    public static  function sanitizeFormPassword($inputText){
        // loai bo the html 
        $inputText = strip_tags($inputText);
        return $inputText;
    }
     public static  function sanitizeFormEmail($inputText){
        // loai bo the html 
        $inputText = strip_tags($inputText);
        $inputText = str_replace(" ","",$inputText);
        return $inputText;
    }

}
