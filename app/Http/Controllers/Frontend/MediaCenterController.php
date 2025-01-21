<?php

namespace App\Http\Controllers\Frontend;

use App\Blog;
use App\BlogSection;
use App\Http\Controllers\Controller;
use App\Photo;
use App\PhotoSection;
use App\Video;
use App\VideoSection;
use Illuminate\Http\Request;

class MediaCenterController extends Controller
{
    /**
     *
     * ---- News ----
    */
    public function viewNewsSections()
    {
        $pageTitle  = __('dashboard.news');
        $sections   = BlogSection::orderBy('id', 'DESC')->active()->withCount('blogs')->paginate(12);
        return view('frontend.media-center.news.news-sections', compact('pageTitle', 'sections'));
    }

    public function viewNews($slug)
    {
        $section = BlogSection::whereSlug($slug)->active()->first();
        if($section && $section->status == 'active') {
            $pageTitle  = __('dashboard.news') . ' » ' . $section->title;
            $news       = Blog::orderBy('id', 'DESC')->where('blog_section_id', $section->id)->active()->with('blog_section')->paginate(6);
            return view('frontend.media-center.news.news', compact('news'));
        }
        return redirect()->back();
    }

    public function viewNewsDetails($section_slug, $new_slug)
    {
        $new = Blog::orderBy('id', 'DESC')->whereSlug($new_slug)->active()->with('blog_section')->first();
        if($new && $new->blog_section->status == 'active') {
            $pageTitle  = __('dashboard.news') . ' » ' . $new->blog_section->title . ' » ' . $new->title;
            return view('frontend.media-center.news.news-details', compact('new'));
        }
        return redirect()->route('frontend.home');
    }

    /**
     *
     * ---- Photos ----
    */
    public function viewPhotosSections()
    {
        $pageTitle  = __('translation.photos');
        $sections   = PhotoSection::orderBy('id', 'DESC')->active()->withCount('photos')->paginate(9);
        return view('frontend.media-center.photos.photos-sections', compact('pageTitle', 'sections'));
    }

    public function viewPhotos($slug)
    {
        $section = PhotoSection::whereSlug($slug)->active()->first();
        if($section && $section->status == 'active') {
            $pageTitle  = __('translation.photos') . ' » ' . $section->title;
            $photos = Photo::orderBy('id', 'DESC')->where('photo_section_id', $section->id)->active()->with('photo_section')->paginate(12);
            return view('frontend.media-center.photos.photos', compact('pageTitle', 'photos'));
        }
        return redirect()->back();
    }

    /**
     *
     * ---- Videos ----
    */
    public function viewVideosSections()
    {
        $pageTitle  = __('dashboard.videos');
        $sections   = VideoSection::orderBy('id', 'DESC')->active()->withCount('videos')->paginate(6);
        return view('frontend.media-center.videos.videos-sections', compact('pageTitle', 'sections'));
    }

    public function viewVideos($slug)
    {
        $section = VideoSection::whereSlug($slug)->active()->first();
        if($section && $section->status == 'active') {
            $pageTitle  = __('dashboard.videos') . ' » ' . $section->title;
            $videos = Video::orderBy('id', 'DESC')->where('video_section_id', $section->id)->active()->with('video_section')->paginate(12);
            return view('frontend.media-center.videos.videos', compact('pageTitle', 'videos'));
        }
        return redirect()->back();
    }

    public function viewVideosDetails($section_slug, $video_slug)
    {
        $video = Video::orderBy('id', 'DESC')->whereSlug($video_slug)->active()->with('video_section')->first();
        if($video && $video->video_section->status == 'active') {
            $pageTitle  = __('dashboard.videos') . ' » ' . $video->video_section->title . ' » ' . $video->title;
            return view('frontend.media-center.videos.videos-details', compact('pageTitle', 'video'));
        }
        return redirect()->route('frontend.home');
    }
}
