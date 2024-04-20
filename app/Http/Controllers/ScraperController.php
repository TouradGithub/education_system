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
            //Init Guzzle
            $client = new Client();
            $url = 'https://www.dzexams.com';
            //Get request
            $response = $client->request(
                'GET',
                'https://www.dzexams.com/'
            );

            $response_status_code = $response->getStatusCode();
            $html = $response->getBody()->getContents();

            if($response_status_code==200){
                // dd($html);
                $dom = HtmlDomParser::str_get_html( $html );

                $song_items = $dom->find('div[class="panel"]');

                $count = 0;
                foreach ($song_items as $song_item){
                        $route = $url.''.trim($song_item->find('a[class="list-group-item"]',0)->getAttribute('href'));
                        $name = trim($song_item->find('a[class="list-group-item"]',0)->text());

                        // $gradeScrape =new GradeScraping();
                        // $gradeScrape->name=$name;
                        // $gradeScrape->route=$route;
                        // $gradeScrape->save();

                        // $this->primariGrade($route,$gradeScrape->id);
                        $this->primariGrade($route,1);


                    $count++;
                }
            }


        // view('scrape.index', compact('data'));
    }
    public function getGradeByName(String $name){

        $grade = Grade::where(function($query) use ($name) {

            $query->whereRaw("name", [strtolower($name)]);
        })->first();

        return $grade->id;

    }
    public function primariGrade(String $route
    ,int $scraper_grade_id
    ){
        // dd($route);
        $client = new Client();
        $response = $client->request(
            'GET',
            $route
        );

        $response_status_code = $response->getStatusCode();
        $html = $response->getBody()->getContents();

        if($response_status_code==200){
            // dd($html);
            $dom = HtmlDomParser::str_get_html( $html );

            $song_items = $dom->find('a[class="btn-group header item social-instagram -700 item-tablist"]');

            $count = 0;
            foreach ($song_items as $song_item){


                    $routeClass = trim($song_item->getAttribute('href'));
                    $name = $song_item->find('button[class="btn btn-group-content"]')[0]->text();
                    $counter_data =trim($song_item->find('button[class="btn btn-group-count bg-1"]')[0]->text());

                    // $classeScrape =new ClassScraping();
                    // $classeScrape->name=$name;
                    // $classeScrape->route='https://www.dzexams.com'.$routeClass;
                    // $classeScrape->counter_data=$counter_data;
                    // $classeScrape->scraper_grade_id=$scraper_grade_id;

                    // $classeScrape->save();
                    // $this->subjectByClass('https://www.dzexams.com'.$routeClass,$classeScrape->id);
                    $this->subjectByClass('https://www.dzexams.com'.$routeClass,1);

                $count++;
            }
        }

    }

    public function subjectByClass(String $route,int $scraper_class_id){

        $client = new Client();
        $response = $client->request(
            'GET',
            $route
        );

        $response_status_code = $response->getStatusCode();
        $html = $response->getBody()->getContents();

        if($response_status_code==200){
            // dd($html);
            $dom = HtmlDomParser::str_get_html( $html );

            $song_items = $dom->find('a[class="btn-group item btn-info"]');
            // dd($song_items);
            $count = 0;
            foreach ($song_items as $song_item){
                // if($count==0){

                    $routeClass = trim($song_item->getAttribute('href'));
                    $name = $song_item->find('button[class="btn btn-group-content"]')[0]->text();
                    $counter_data =trim($song_item->find('button[class="btn btn-group-count bg-1"]')[0]->text());                    $subjectScrape =new SubjectScraping();
                    // $subjectScrape=new SubjectScraping();
                    // $subjectScrape->name=$name;
                    // $subjectScrape->route='https://www.dzexams.com'.$routeClass;
                    // $subjectScrape->counter_data=$counter_data;
                    // $subjectScrape->scraper_class_id=$scraper_class_id;
                    // $subjectScrape->save();
                    $this->subjectData('https://www.dzexams.com'.$routeClass,1);
                // }
                $count++;
            }
        }


    }

    public function subjectData(String $route,int $scraper_class_id){
        // dd($route);
        $client = new Client();
        $response = $client->request(
            'GET',
            $route
        );

        $response_status_code = $response->getStatusCode();
        $html = $response->getBody()->getContents();

        if($response_status_code==200){
            // dd($html);
            $dom = HtmlDomParser::str_get_html( $html );

            $song_items = $dom->find('div[class="btn-group item"]');
            // dd($song_items);
            $count = 0;
            foreach ($song_items as $song_item){
                if($count==1){

                    $routeClass = trim($song_item->getAttribute('href'));
                    $yearsection = $song_item->find('a[class="btn btn-group-sol btn-item-sujet"]')[0]->text();
                    $routeSection = $song_item->find('a[class="btn btn-group-sol btn-item-sujet"]')[0];
                    $counter_data =trim($song_item->find('a[class="btn btn-group-content   btn-item-sujet"]')[0]->text());                    $subjectScrape =new SubjectScraping();
                    dd($routeSection);
                    // $subjectScrape=new SubjectScraping();
                    // $subjectScrape->name=$name;
                    // $subjectScrape->route='https://www.dzexams.com'.$routeClass;
                    // $subjectScrape->counter_data=$counter_data;
                    // $subjectScrape->scraper_class_id=$scraper_class_id;
                    // $subjectScrape->save();
                }
                $count++;
            }
        }


    }

}


