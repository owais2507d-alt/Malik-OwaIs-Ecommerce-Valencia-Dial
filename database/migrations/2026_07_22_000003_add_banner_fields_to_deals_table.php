<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('deals', function (Blueprint $table) {
            $table->string('banner_image')->nullable()->after('description');
            $table->string('badge_text')->nullable()->after('banner_image');
            $table->string('cta_text')->nullable()->after('badge_text');
            $table->string('cta_link')->nullable()->after('cta_text');
        });
    }

    public function down(): void
    {
        Schema::table('deals', function (Blueprint $table) {
            $table->dropColumn(['banner_image', 'badge_text', 'cta_text', 'cta_link']);
        });
    }
};
