<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\Models\Grade;
use App\Models\GradeScraping;
use App\Models\ClassScraping;
use App\Models\SubjectScraping;
use Sunra\PhpSimple\HtmlDomParser;
class ScraperController extends Controller
{



    public function scraper(Request $request)
    {


        // for($i=11;$i<=14;$i++){
        //     $k=1;
        //     $item=$k++;
        //     $this->subjectData($i,$item);
        // }
        // view('scrape.index', compact('data'));
    }

    public function subjectData($class_id,$t){



        $client = new Client();
        $url = 'https://www.dzexams.com/ar/'.$t.'am';

        // dd($url);
        $response = $client->request(
            'GET',
            'https://www.dzexams.com/ar/'.$t.'am'
            // 'https://www.dzexams.com/ar/1as/mathematiques'
        );

        $response_status_code = $response->getStatusCode();
        $html = $response->getBody()->getContents();

        if($response_status_code==200){
                 $dom = HtmlDomParser::str_get_html($html);

            $song_items = $dom->find('a[class="btn-group item btn-info"]');
           $song_items;
            $count = 0;
            foreach ($song_items as $song_item){
                $counter = $song_item->find('button[class="btn btn-group-count bg-1"]',0)->text();
                $item_name = $song_item->find('button[class="btn btn-group-content"]',0)->text();
                $icon = $song_item->find('img[class="caption-figure"]',0)->src;
                // dd( $counter );
                // if($class_id==3){
                //     dd($items);
                // }

                    $gradeScrape =new SubjectScraping();
                    $gradeScrape->name=$item_name;
                    $gradeScrape->icon=$icon;
                    $gradeScrape->counter=$counter;
                    $gradeScrape->class_id=$class_id;
                    $gradeScrape->save();




                $count++;

        }
        }
    }

}


