<?php

namespace App;

use Exception;
use RuntimeException;

class File{

    private string $src;
    private string $mod;
    private $file;

    public function __construct(array $options = []) {
        if(!isset($options['src'])){
            throw new \RuntimeException('Erreur : Un chemin vers un fichier est nécessaire'."\n");
        }
        if(!isset($options['mod'])){
            throw new \RuntimeException('Erreur : Un mode d\'ouverture du fichier est nécessaire'."\n");
        }

        $this->setSrc($options['src']);
        $this->setMod($options['mod']);
        $this->setFile($this->getSrc());
    }

    public function getSrc():string{
        return $this->src;
    }
    public function setSrc(string $src):void{
        $this->src = $src;
    }

    public function getMod():string{
        return $this->mod;
    }
    public function setMod(string $mod):void{
        $this->mod = $mod;
    }

    public function getFile(){
        return $this->file;
    }
    public function setFile(){
        try {
            /*if(!file_exists($this->getSrc())){
                throw new \Exception('Erreur : Le fichier '.$this->getSrc().' n\'existe pas.'."\n");
            }*/

            $this->file = fopen($this->getSrc(), $this->getMod());

            if($this->getFile() == false){
                throw new Exception('Erreur : '.error_get_last()['message']."\n");
            }
        } catch(Exception $exc){
            echo 'Erreur : '.$exc->getMessage();
        }
    }

    public function closeFile():void{
        fclose($this->getFile());
    }

    public function replaceFile(array $old, array $new, File $dstFile):int{
        foreach($old as $key => $word){
            $old[$key] .= ' ';
        }
        foreach($old as $key => $word){
            $new[$key] .= ' ';
        }

        $content = fgets($this->getFile());
        if($content == false){
            throw new RuntimeException('Une erreur est survenue lors de la lecture de '.$this->getSrc()."\n");
        }
        $newContent = str_replace($old, $new, $content, $counter);
        fwrite($dstFile->getFile(), $newContent);
        $dstFile->closeFile();
                
        return $counter;
    }
}