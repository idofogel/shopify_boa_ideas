<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Collection;
use App\Models\Product;
use App\Models\LastSyncDate;
// use App\Models\Product;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
// use Illuminate\Console\ShouldBeUnique;
class getShopifyColletionsAndProducts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    // use ShouldBeUnique;
    protected $signature = 'app:get-shopify-colletions-and-products';

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
        $lock = Cache::lock('getShopifyCollectionAndProducts');
        if($lock->get()){
            print_r('in the command');
            $shopifyStore = 'boaideas-sodastream-home-test.myshopify.com';
            $nextCursor = null;
            do {        
                $response = Http::withOptions([
                    'verify' => false, // Disable SSL verification
                ])->withHeaders([
                    'Content-Type' => 'application/json',
                    'X-Shopify-Access-Token' => env('SHOPIFY_API') // Authenticate with the API key
                ])->post("https://$shopifyStore/admin/api/2024-10/graphql.json",['query' => '{
                collections(first: 100' . ($nextCursor ? ', after: "' . $nextCursor . '"' : '') . ') {
                    edges {
                    node {
                        id
                        title
                        description
                        handle
                    }
                    }
                    pageInfo {
                        hasNextPage
                        endCursor
                    }
                }
                }']);
                if ($response->successful()) {
                    $collectio = $response->json();
                    print_r($collectio);
                    foreach ($collectio['data']['collections']['edges'] as $col) {
                        $col = $col['node'];
                        print_r('<br />creating<br />');
                        print_r($col);

                        $collection = Collection::updateOrCreate(
                            ['collection_shopify_id' => $col['id']],
                            [
                                'title' => $col['title'],
                                'description' => $col['description'],
                                'handle' => $col['handle']
                            ] // Attributes to update if the record exists or create if it doesn't
                        );
                    }
                }
                $data = $response->json('data.collections');
                    $nextCursor = $data['pageInfo']['endCursor'];
            } while ($data['pageInfo']['hasNextPage']);
            if(LastSyncDate::count() === 0){
                LastSyncDate::create([ 'change_headline' => 'created']);
            } else {
                $last_sync = LastSyncDate::first();
                $last_sync->update([
                    'change_headline' => date('Y-m-d H:i:s')
                ]);
            }
            $lock->release();
        }

    }
}
