<?php

namespace App\Console\Commands;

use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Console\Command;

//***php artisan productgenerate-slugs */

class GenerateProductSlugs extends Command
{
    protected $signature = 'product:generate-slugs';
    protected $description = 'Generate/Regenerate SEO slugs for all products using Make, Model, Engine, Product Type, Name, and Number';

    public function handle()
    {
        $this->info('Starting product slug generation...');

        $products = Product::with(['category', 'subCategory', 'proEngine', 'productType'])->get();
        $total = $products->count();
        $updated = 0;

        $bar = $this->output->createProgressBar($total);
        $bar->start();

        foreach ($products as $product) {
            $slugParts = array_filter([
                $product->category->name ?? '',
                $product->subCategory->name ?? '',
                $product->proEngine->name ?? '',
                $product->productType->name ?? '',
                $product->name ?? '',
                $product->number ?? ''
            ]);

            $slugText = implode(' ', $slugParts);
            $slug = Str::slug($slugText, '-');

            if ($slug) {
                $product->slug = $slug;
                $product->save();
                $updated++;
            }

            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info("Successfully generated and updated slugs for {$updated} out of {$total} products!");

        return 0;
    }
}
