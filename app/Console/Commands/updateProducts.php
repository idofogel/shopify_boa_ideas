<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Product;
use App\Models\Collection;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
class updateProducts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-products';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $lock = Cache::lock('updateProducts');
        if($lock->get()){
            $shopifyStore = 'boaideas-sodastream-home-test.myshopify.com';
            $apiKey = env('SHOPIFY_API');
            $nextCursor = null;
            do {
                // Send a post request to the Shopify API
                // I picked a 100 limit on thequery cause 250 seems to slow but I still need to take in a big batch
                $response = Http::withOptions([
                    'verify' => false, // Disable SSL verification
                ])->withHeaders([
                    'Content-Type' => 'application/json',
                    'X-Shopify-Access-Token' => $apiKey // Authenticate with the API key
                ])->post("https://$shopifyStore/admin/api/2024-10/graphql.json",['query' => '{
                products(first: 100' . ($nextCursor ? ', after: "' . $nextCursor . '"' : '') . ') {
                    edges {
                        node {
                            id
                            title
                            description
                            handle
                            status
                            compareAtPriceRange {
                            maxVariantCompareAtPrice {
                                amount
                                currencyCode
                            }
                            minVariantCompareAtPrice {
                                amount
                                currencyCode
                            }
                            }
                            collections(first: 250){
                                edges {
                                    node {
                                        id
                                    }
                                }
                            }
                        }
                    }
                    pageInfo {
                    hasNextPage
                    endCursor
                    }
                }
                }
                ']);
                if ($response->successful()) {
                    echo 'success<br>';
                    echo $response->status();
                    print_r($response->json());
                    print_r('<br /><br />');
                    $products = $response->json();

                    foreach ($products['data']['products']['edges'] as $col) {
                        $col = $col['node'];
                        $product = Product::updateOrCreate(
                            ['shopify_id' => $col['id']],
                            [
                                'title' => $col['title'],
                                'description' => $col['description'],
                                'handle' => $col['handle'],
                                'status' => $col['status'],
                                'max_variant_compare' => $col['compareAtPriceRange']['maxVariantCompareAtPrice']['amount'],
                                'min_variant_compare' => $col['compareAtPriceRange']['minVariantCompareAtPrice']['amount']
                            ] // Attributes to update if the record exists or create if it doesn't
                        );
                        //remove all connections and then load them again-I chose this strategy and not something more sufisticated because I don't have a lot of test sets. Given more oppurtunities to check the work I would add only the new connections and remove only the zombies
                        $product->collections()->detach();
                        foreach ($col['collections']['edges'] as $colle) {
                            $fir_col = Collection::where('collection_shopify_id', $colle['node']['id'])->first();
                            //adding new connections
                            if($fir_col !== null)
                                $product->collections()->attach([$fir_col->id]);
                        }
                    }
                } else {
                    echo 'not successful';
                    echo $response->status();
                    print_r($response->body());
                }

                $data = $response->json('data.products');
                $nextCursor = $data['pageInfo']['endCursor'];
                print_r(($nextCursor ? 'next cursor<br />' : 'no cursor'));
                
            } while ($data['pageInfo']['hasNextPage']);
            $lock->release();
        }
    }
}
