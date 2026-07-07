<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class CategoryProductSeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Mechanical Watches', 'description' => 'Precision-engineered automatic and manual-wind timepieces', 'image' => 'categories/watches.jpg', 'status' => 'active'],
            ['name' => 'Smart Earbuds', 'description' => 'Hi-fidelity wireless audio with active noise cancellation', 'image' => 'categories/earbuds.jpg', 'status' => 'active'],
            ['name' => 'Leather Straps', 'description' => 'Handcrafted Italian leather watch straps', 'image' => 'categories/straps.jpg', 'status' => 'active'],
        ];

        foreach ($categories as $data) {
            Category::updateOrCreate(['name' => $data['name']], $data);
        }

        $watchCategory = Category::where('name', 'Mechanical Watches')->first();
        $earbudCategory = Category::where('name', 'Smart Earbuds')->first();
        $strapCategory = Category::where('name', 'Leather Straps')->first();

        $products = [
            ['name' => 'Valencia Chronograph S1', 'brand' => 'Valencia', 'category_id' => $watchCategory->id, 'price' => 1299.99, 'stock' => 15, 'description' => 'Swiss-made automatic chronograph with sapphire crystal, 42mm stainless steel case, and genuine alligator leather strap. Water resistant to 100m.', 'status' => 'active'],
            ['name' => 'Valencia Heritage Moonphase', 'brand' => 'Valencia', 'category_id' => $watchCategory->id, 'price' => 2499.99, 'stock' => 8, 'description' => 'Haute horlogerie moonphase complication in rose gold case. Hand-wound movement with 72-hour power reserve. Limited edition of 100 pieces.', 'status' => 'active'],
            ['name' => 'Valencia Diver Pro 300', 'brand' => 'Valencia', 'category_id' => $watchCategory->id, 'price' => 899.99, 'stock' => 22, 'description' => 'Professional dive watch with helium escape valve, ceramic bezel, and 300m water resistance. Super-LumiNova markers for underwater visibility.', 'status' => 'active'],
            ['name' => 'Valencia Pilot GMT', 'brand' => 'Valencia', 'category_id' => $watchCategory->id, 'price' => 1599.99, 'stock' => 0, 'description' => 'GMT complication with dual-time zone display. Anti-magnetic movement certified by the Swiss Official Chronometer Testing Institute.', 'status' => 'active'],
            ['name' => 'Valencia Tourbillon Elite', 'brand' => 'Valencia', 'category_id' => $watchCategory->id, 'price' => 12999.99, 'stock' => 3, 'description' => 'Flying tourbillon with skeletonized dial and hand-engraved movement. Platinum case with diamond-set bezel. A masterpiece of micro-mechanics.', 'status' => 'active'],
            ['name' => 'Valencia Dress Watch C3', 'brand' => 'Valencia', 'category_id' => $watchCategory->id, 'price' => 699.99, 'stock' => 30, 'description' => 'Ultra-thin quartz dress watch with sunburst blue dial. 38mm case sits perfectly under a cuff. Scratch-resistant sapphire crystal.', 'status' => 'active'],
            ['name' => 'Valencia Buds Pro', 'brand' => 'Valencia', 'category_id' => $earbudCategory->id, 'price' => 249.99, 'stock' => 50, 'description' => 'True wireless earbuds with adaptive ANC, 24-bit hi-res audio, and 8-hour battery life. Custom 11mm dynamic drivers deliver rich soundstage.', 'status' => 'active'],
            ['name' => 'Valencia Buds Air', 'brand' => 'Valencia', 'category_id' => $earbudCategory->id, 'price' => 149.99, 'stock' => 75, 'description' => 'Open-fit wireless earbuds with spatial audio and dynamic head tracking. Ultra-lightweight at 4g per bud.', 'status' => 'active'],
            ['name' => 'Valencia Headphones Studio', 'brand' => 'Valencia', 'category_id' => $earbudCategory->id, 'price' => 449.99, 'stock' => 20, 'description' => 'Over-ear reference headphones with planar magnetic drivers. Studio-grade DAC and THX AAA amplification.', 'status' => 'active'],
            ['name' => 'Italian Leather Strap - Honey Brown', 'brand' => 'Valencia', 'category_id' => $strapCategory->id, 'price' => 89.99, 'stock' => 40, 'description' => 'Hand-stitched Italian calf leather strap in honey brown. Tapered 22-18mm with stainless steel buckle. Vegetable-tanned and naturally aged.', 'status' => 'active'],
            ['name' => 'Italian Leather Strap - Noir', 'brand' => 'Valencia', 'category_id' => $strapCategory->id, 'price' => 89.99, 'stock' => 35, 'description' => 'Hand-stitched Italian calf leather strap in deep black. Tapered 22-18mm with signed buckle. Water-resistant lining.', 'status' => 'active'],
            ['name' => 'Italian Leather Strap - Burgundy', 'brand' => 'Valencia', 'category_id' => $strapCategory->id, 'price' => 99.99, 'stock' => 18, 'description' => 'Hand-stitched Italian calf leather strap in rich burgundy. Tapered 22-18mm with gold-plated buckle.', 'status' => 'active'],
        ];

        foreach ($products as $data) {
            Product::updateOrCreate(['name' => $data['name'], 'category_id' => $data['category_id']], $data);
        }
    }
}
