<?php

namespace App\Http\Controllers;

use App\Models\Slider;
use App\Models\OurStoryBlock;
use App\Models\TimelineEvent;
use App\Models\Brand;
use App\Models\Service;
use App\Models\InstagramTile;
use App\Models\SiteSetting;
use App\Models\HomeHeader;
use App\Models\HomeBagel;

class IndexAdminController extends Controller
{
    public function index()
    {
        $sliders = Slider::orderBy('order')->get();
        $story = OurStoryBlock::first();
        $events = TimelineEvent::orderBy('order')->get();
        $brands = Brand::orderBy('order')->get();
        $services = Service::orderBy('order')->get();
        $tiles = InstagramTile::orderBy('order')->get();
        $settings = SiteSetting::pluck('value', 'key');
        $header = HomeHeader::first();
        $bagels = HomeBagel::orderBy('order')->get();

        return view('pages.index', compact(
            'sliders', 'story', 'events', 'brands', 'services',
            'tiles', 'settings', 'header', 'bagels'
        ));
    }
}
