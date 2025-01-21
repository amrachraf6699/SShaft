<?php

namespace App\Http\Controllers\Dashboard;

use App\Blog;
use App\BlogSection;
use App\Branch;
use App\Event;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Neighborhood;
use App\Donor;
use App\Photo;
use App\PhotoSection;
use App\Service;
use App\ServiceSection;
use App\Video;
use App\VideoSection;
use Illuminate\Support\Facades\Storage;

class ImportDataController extends Controller
{
    public function importAllEvents()
    {
        /** JSON EVENTS */
        // $jsonEvents = Storage::disk('public_import')->get('/oldDataAlbir/events.json');
        // $jsonEvents = json_decode($jsonEvents, true);
        // foreach($jsonEvents['data'] as $d){
        //     Event::create($d);
        // }

        /** NEWS SECTIONS */
        // $jsonNewsSections = Storage::disk('public_import')->get('/oldDataAlbir/news_sections.json');
        // $jsonNewsSections = json_decode($jsonNewsSections, true);
        // foreach($jsonNewsSections['data'] as $d){
        //     BlogSection::create($d);
        // }

        /** NEWS */
        // $jsonNews = Storage::disk('public_import')->get('/oldDataAlbir/news.json');
        // $jsonNews = json_decode($jsonNews, true);
        // foreach($jsonNews['data'] as $d){
        //     Blog::create($d);
        // }

        /** PHOTO SECTION */
        // $jsonPhotoSection = Storage::disk('public_import')->get('/oldDataAlbir/photos_sections.json');
        // $jsonPhotoSection = json_decode($jsonPhotoSection, true);
        // foreach($jsonPhotoSection['data'] as $d){
        //     PhotoSection::create([
        //         'id'            => $d['id'],
        //         'title'         => $d['title'],
        //         'img'           => $d['pic'],
        //         'status'        => $d['status'],
        //         'views_count'   => $d['hits'],
        //     ]);
        // }

        /** PHOTO */
        // $jsonPhoto = Storage::disk('public_import')->get('/oldDataAlbir/photos.json');
        // $jsonPhoto = json_decode($jsonPhoto, true);
        // foreach($jsonPhoto['data'] as $d){
        //     Photo::create([
        //         'photo_section_id'  => $d['did'],
        //         'title'             => $d['title'],
        //         'img'               => $d['pic'],
        //         'status'            => $d['status'],
        //         'views_count'       => $d['hits'],
        //     ]);
        // }

        /** VIDEOS SECTION */
        // $jsonVideosSection = Storage::disk('public_import')->get('/oldDataAlbir/videos_sections.json');
        // $jsonVideosSection = json_decode($jsonVideosSection, true);
        // foreach($jsonVideosSection['data'] as $d){
        //     VideoSection::create([
        //         'title'         => $d['title'],
        //         'img'           => $d['pic'],
        //         'status'        => $d['status'],
        //         'views_count'   => $d['hits'],
        //     ]);
        // }

        /** VIDEOS */
        // $jsonVideos = Storage::disk('public_import')->get('/oldDataAlbir/videos.json');
        // $jsonVideos = json_decode($jsonVideos, true);
        // foreach($jsonVideos['data'] as $d){
        //     Video::create([
        //         'video_section_id'  => $d['did'],
        //         'title'             => $d['title'],
        //         'img'               => $d['pic'],
        //         'url'               => 'https://www.youtube.com/watch?v=' . $d['video'],
        //         'status'            => $d['status'],
        //         'views_count'       => $d['hits'],
        //     ]);
        // }

        /** CITIES */
        // $jsonCities = Storage::disk('public_import')->get('/oldDataAlbir/cities.json');
        // $jsonCities = json_decode($jsonCities, true);
        // foreach($jsonCities['data'] as $d){
        //     Neighborhood::create([
        //         'name'      => $d['name'],
        //         'status'    => $d['status'],
        //     ]);
        // }

        /** BRANCHES */
        // $jsonBranches = Storage::disk('public_import')->get('/oldDataAlbir/branches.json');
        // $jsonBranches = json_decode($jsonBranches, true);
        // foreach($jsonBranches['data'] as $d){
        //     Branch::create([
        //         'name'              => $d['name'],
        //         'content'           => $d['content'],
        //         'link_map_address'  => '-',
        //         'status'            => $d['status'],
        //     ]);
        // }

        /** SERVICE SECTIONS */
        // $serviceSections = Storage::disk('public_import')->get('/oldDataAlbir/services_sections.json');
        // $serviceSections = json_decode($serviceSections, true);
        // foreach($serviceSections['data'] as $d){
        //     ServiceSection::create([
        //         'id'                => $d['id'],
        //         'title'             => $d['title'],
        //         'status'            => $d['status'],
        //     ]);
        // }

        /** SERVICES */
        // $services = Storage::disk('public_import')->get('/oldDataAlbir/services.json');
        // $services = json_decode($services, true);
        // foreach($services['data'] as $d){
        //     Service::create([
        //         'id'                        => $d['id'],
        //         'service_section_id'        => $d['service_section_id'],
        //         'title'                     => $d['title'],
        //         'how_does_the_service_work' => $d['howServiceWork'] ? $d['howServiceWork'] : '-',
        //         'content'                   => $d['content'] ? $d['content'] : '-',
        //         'price_value'               => $d['service_type'],
        //         'basic_service_value'       => $d['factor'] ? $d['factor'] : null,
        //         'target_value'              => 1000000,
        //         'status'                    => $d['status'],
        //         'img'                       => $d['img'],
        //         'app_icon'                  => $d['app_icon'],
        //     ]);
        // }

        /** DONORS */
        // $donors = Storage::disk('public_import')->get('/oldDataAlbir/users_donors__1.json');
        // $donors = json_decode($donors, true);

        // foreach($donors['data'] as $d){
        //     // Donor::create([
        //     //     'id'        => $d['id'],
        //     //     'phone'     => $d['mobile'] ? $d['mobile'] : $d['id'],
        //     //     'name'      => $d['name'],
        //     //     'email'     => $d['email'] ? $d['email'] : $d['id'],
        //     //     'gender'    => $d['sex'],
        //     // ]);
        // }
        return 'Success';
    }
}
