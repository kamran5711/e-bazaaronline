<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Sitemap\SitemapGenerator;

class SiteMapController extends Controller
{
    public function index()
    {
       return SitemapGenerator::create(url(""))->getSitemap()->writeToDisk('public', 'sitemap.xml');

        // return url("");
    }
}
