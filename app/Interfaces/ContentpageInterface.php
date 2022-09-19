<?php 

namespace App\Interfaces;

interface ContentpageInterface
{
    
    public function contentPageIndex();
    public function contentPageAddIndex();
    public function addContentPage($request);
    public function viewContentPage($url_title);
    public function contentPages();
    public function contentPageDelete($id);
    public function contentPageEditIndex($id);
}