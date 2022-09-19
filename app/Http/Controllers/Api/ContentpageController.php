<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Interfaces\ContentpageInterface;

class ContentpageController extends Controller
{
    protected $ContentpageInterface;

    public function __construct(ContentpageInterface $ContentpageInterface)
    {
        $this->ContentpageInterface = $ContentpageInterface;
    }

    public function contentPageIndex()
    {
      return $this->ContentpageInterface->contentPageIndex();
    }

    public function contentPageAddIndex()
    {
      return $this->ContentpageInterface->contentPageAddIndex();
    }

    public function addContentPage(Request $request)
    {
      return $this->ContentpageInterface->addContentPage($request);
    }

    public function viewContentPage($url_title)
    {
      return $this->ContentpageInterface->viewContentPage($url_title);
    }

    public function contentPages()
    {
      return $this->ContentpageInterface->contentPages();
    }

    public function contentPageDelete($id)
    {
      return $this->ContentpageInterface->contentPageDelete($id);
    }

    public function contentPageEditIndex($id)
    {
      return $this->ContentpageInterface->contentPageEditIndex($id);
    }
}
