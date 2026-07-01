<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->decimal('old_price', 12, 2)->nullable()->after('price');
            $table->unsignedTinyInteger('discount_percent')->default(0)->after('old_price');
            $table->decimal('rating', 2, 1)->unsigned()->default(0)->after('discount_percent');
            $table->unsignedInteger('reviews_count')->default(0)->after('rating');
            $table->boolean('free_delivery')->default(false)->after('reviews_count');
            $table->boolean('fast_delivery')->default(false)->after('free_delivery');
            $table->boolean('verified')->default(false)->after('fast_delivery');
            $table->string('promo_text')->nullable()->after('verified');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn([
                'old_price',
                'discount_percent',
                'rating',
                'reviews_count',
                'free_delivery',
                'fast_delivery',
                'verified',
                'promo_text',
            ]);
        });
    }
};
