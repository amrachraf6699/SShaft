<?php

namespace App\Http\Controllers\Api;

use App\Blog;
use App\Photo;
use App\Video;
use App\BlogSection;
use App\PhotoSection;
use App\VideoSection;
use App\Http\Controllers\Controller;
use App\Http\Resources\BlogResource;
use App\Http\Resources\PhotoResource;
use App\Http\Resources\VideoResource;
use App\Http\Resources\BlogSectionResource;
use App\Http\Resources\PhotoSectionResource;
use App\Http\Resources\VideoSectionResource;

class MediaCenterController extends Controller
{
    /**
     *
     * ---- News ----
    */
    public function viewNewsSections()
    {
        $sections   = BlogSection::orderBy('id', 'DESC')->active()->paginate(12);
        if ($sections->count() > 0) {
            $data['sections']   = BlogSectionResource::collection($sections)->response()->getData(true);
            return response()->api($data, 200);
        }
        return response()->api(null, 200, false, __('api.not found data'));
    }

    public function viewNews($id)
    {
        $section = BlogSection::whereId($id)->active()->first();
        if ($section && $section->status == 'active') {
            $news   = Blog::orderBy('id', 'DESC')->where('blog_section_id', $section->id)->active()->paginate(12);
            if ($news->count() > 0) {
                $data['news']   = BlogResource::collection($news)->response()->getData(true);
                return response()->api($data, 200);
            }
            return response()->api(null, 200, false, __('api.not found data'));
        }
        return response()->api(null, 200, false, __('api.Not found'));
    }

    /**
     *
     * ---- Photos ----
    */
    public function viewPhotosSections()
    {
        $sections   = PhotoSection::orderBy('id', 'DESC')->active()->paginate(12);
        if ($sections->count() > 0) {
            $data['sections']   = PhotoSectionResource::collection($sections)->response()->getData(true);
            return response()->api($data, 200);
        }
        return response()->api(null, 200, false, __('api.not found data'));
    }

    public function viewPhotos($id)
    {
        $section = PhotoSection::whereId($id)->active()->first();
        if ($section && $section->status == 'active') {
            $photos   = Photo::orderBy('id', 'DESC')->where('photo_section_id', $section->id)->active()->paginate(12);
            if ($photos->count() > 0) {
                $data['photos']   = PhotoResource::collection($photos)->response()->getData(true);
                return response()->api($data, 200);
            }
            return response()->api(null, 200, false, __('api.not found data'));
        }
        return response()->api(null, 200, false, __('api.Not found'));
    }

    /**
     *
     * ---- Videos ----
    */
    public function viewVideosSections()
    {
        $sections   = VideoSection::orderBy('id', 'DESC')->active()->paginate(12);
        if ($sections->count() > 0) {
            $data['sections']   = VideoSectionResource::collection($sections)->response()->getData(true);
            return response()->api($data, 200);
        }
        return response()->api(null, 200, false, __('api.not found data'));
    }

    public function viewVideos($id)
    {
        $section = VideoSection::whereId($id)->active()->first();
        if ($section && $section->status == 'active') {
            $videos   = Video::orderBy('id', 'DESC')->where('video_section_id', $section->id)->active()->paginate(12);
            if ($videos->count() > 0) {
                $data['videos']   = VideoResource::collection($videos)->response()->getData(true);
                return response()->api($data, 200);
            }
            return response()->api(null, 200, false, __('api.not found data'));
        }
        return response()->api(null, 200, false, __('api.Not found'));
    }
}
