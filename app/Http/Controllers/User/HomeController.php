<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Deal;
use App\Models\Product;
use App\Models\Setting;
use App\Models\Slide;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::where('status', 'active')->get();

        $topSellers = Product::with('category')
            ->where('status', 'active')
            ->where('stock', '>', 0)
            ->latest()
            ->take(4)
            ->get();

        $featured = Product::with('category')
            ->where('status', 'active')
            ->latest()
            ->take(3)
            ->get();

        $slides = Slide::where('is_active', true)
            ->orderBy('order')
            ->get();

        $activeDeal = Deal::where('is_active', true)
            ->where('end_date', '>', now())
            ->orderBy('end_date')
            ->first();

        $videoSectionFile = Setting::getValue('video_section_file', '');
        $rawUrl = Setting::getValue('video_section_url', '');
        $videoSectionUrl = $this->convertToEmbedUrl($rawUrl);
        $videoSectionSubtitle = Setting::getValue('video_section_subtitle', 'Watch');
        $videoSectionTitle = Setting::getValue('video_section_title', 'THE CRAFT BEHIND THE CRAFT');
        $videoSectionDescription = Setting::getValue('video_section_description', 'Witness the artistry of master horologists at work — where every second is a masterpiece in the making.');

        return view('user.home', compact(
            'categories', 'topSellers', 'featured',
            'slides', 'activeDeal', 'videoSectionFile', 'videoSectionUrl',
            'videoSectionSubtitle', 'videoSectionTitle', 'videoSectionDescription'
        ));
    }

    private function convertToEmbedUrl(string $url): string
    {
        if (empty($url)) return '';

        if (preg_match('/(?:youtube\.com\/(?:shorts\/|embed\/|watch\?v=)|youtu\.be\/)([a-zA-Z0-9_-]{11})/', $url, $matches)) {
            return 'https://www.youtube.com/embed/' . $matches[1];
        }

        return $url;
    }
}
