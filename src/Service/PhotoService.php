<?php
class PhotoService
{
    public function _construct()
    {
    }
    public function upload($photo, $targetDir): ?string
    {
        $fileName = "../upload/".$targetDir."/". basename($photo["name"]);
        try{
            if(move_uploaded_file($photo["tmp_name"], $fileName)){
                return $fileName;
            }
            throw new Exception("Failed to move uploaded file");
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}