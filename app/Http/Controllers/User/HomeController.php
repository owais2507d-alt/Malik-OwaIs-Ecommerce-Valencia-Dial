<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Setting;
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
            ->take(6)
            ->get();

        $featured = Product::with('category')
            ->where('status', 'active')
            ->latest()
            ->take(3)
            ->get();

        $heroTitle = Setting::getValue('hero_title', 'Valencia');
        $heroTitleAccent = Setting::getValue('hero_title_accent', 'Dial');
        $heroTagline = Setting::getValue('hero_tagline', 'Est. 2026');
        $heroSubtitle = Setting::getValue('hero_subtitle', 'A digital atelier where exceptional craftsmanship meets timeless design.');
        $heroCtaPrimaryText = Setting::getValue('hero_cta_primary_text', 'Explore Collection');
        $heroCtaPrimaryLink = Setting::getValue('hero_cta_primary_link', route('user.shop'));
        $heroCtaSecondaryText = Setting::getValue('hero_cta_secondary_text', 'Join the Vault');
        $heroCtaSecondaryLink = Setting::getValue('hero_cta_secondary_link', route('user.register'));
        $heroVideo = Setting::getValue('hero_video', 'https://cdn.coverr.co/videos/coverr-luxury-watch-on-a-marble-surface-5767/1080p.mp4');

        return view('user.home', compact(
            'categories', 'topSellers', 'featured',
            'heroTitle', 'heroTitleAccent', 'heroTagline', 'heroSubtitle',
            'heroCtaPrimaryText', 'heroCtaPrimaryLink',
            'heroCtaSecondaryText', 'heroCtaSecondaryLink',
            'heroVideo'
        ));
    }
}
