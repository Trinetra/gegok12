<?php
/**
 * SPDX-License-Identifier: MIT
 * (c) 2025 GegoSoft Technologies and GegoK12 Contributors
 */
namespace App\Http\Controllers\Api;


use App\Http\Resources\API\ShowVideo as ShowVideoResource;
use App\Models\Video;
use App\Http\Resources\API\ShowAudio as ShowAudioResource;
use App\Models\Audio;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class VideosController extends Controller
{
        /**
         * Return all video items available to a student.
         *
         * @param int $student_id
         * @return \Illuminate\Http\JsonResponse
         */
        public function showvideo($student_id)
        {        	
            $school_id = Auth::user()->school_id;
            //$academic_year = SiteHelper::getAcademicYear($school_id);

            $student = User::where('id',$student_id)->first();
            $video = Video::where([['standardLink_id',$student->studentAcademicLatest->standardLink_id],['school_id',$school_id],['type','video']])->orWhere([['standardLink_id','=',NULL],['school_id',$school_id],['type','video']])->get();

            $video = ShowVideoResource::collection($video);
            
            return response()->json([
                'success'   =>  true,
                'message'   =>  'Video List',
                'data'      =>  $video
            ],200);          

        }

        /**
         * Return all audio items available to a student.
         *
         * @param int $student_id
         * @return \Illuminate\Http\JsonResponse
         */
        public function showaudio($student_id)
        {        	

            $school_id = Auth::user()->school_id;
            //$academic_year = SiteHelper::getAcademicYear($school_id);

            $student = User::where('id',$student_id)->first();
            $audio = Video::where([['standardLink_id',$student->studentAcademicLatest->standardLink_id],['school_id',$school_id],['type','audio']])->orWhere([['standardLink_id','=',NULL],['school_id',$school_id],['type','audio']])->get();

            $audio = ShowVideoResource::collection($audio);
            
            return response()->json([
                'success'   =>  true,
                'message'   =>  'Audio List',
                'data'      =>  $audio
            ],200);          
           

        }

        /**
         * Return all image items available to a student.
         *
         * @param int $student_id
         * @return \Illuminate\Http\JsonResponse
         */
        public function showimage($student_id)
        {
            $school_id = Auth::user()->school_id;
            //$academic_year = SiteHelper::getAcademicYear($school_id);

            $student = User::where('id',$student_id)->first();
            $image = Video::where([['standardLink_id',$student->studentAcademicLatest->standardLink_id],['school_id',$school_id],['type','image']])->orWhere([['standardLink_id','=',NULL],['school_id',$school_id],['type','image']])->get();

            $image = ShowVideoResource::collection($image);
            
            return response()->json([
                'success'   =>  true,
                'message'   =>  'Image List',
                'data'      =>  $image
            ],200);          
            
        }

        /**
         * Return uploaded media files for the authenticated user's school.
         *
         * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
         */
        public function showfiles()
        {

        	$video = Video::where('school_id',Auth::user()->school_id)->where('media','uploadmedia')->get();
            $video = ShowVideoResource::collection($video);

            return $video; 

        }

        /**
         * Return study media items for a student.
         *
         * @param int $student_id
         * @return \Illuminate\Http\JsonResponse
         */
        public function showmedia($student_id)
        {
            //
            $school_id = Auth::user()->school_id;
            //$academic_year = SiteHelper::getAcademicYear($school_id);

            $student = User::where('id',$student_id)->first();
            $video = Video::where([['standardLink_id',$student->studentAcademicLatest->standardLink_id],['school_id',$school_id],['media','studymedia']])->get();

            $video = ShowVideoResource::collection($video);
            
            return response()->json([
                'success'   =>  true,
                'message'   =>  'Media List',
                'data'      =>  $video
            ],200);
        }

        /**
         * Return value education audio items for the authenticated user's school.
         *
         * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
         */
        public function showaudiovalueducation()
        {
            $video = Video::where([['school_id',Auth::user()->school_id],['media','value_education'],['type','audio']])->get();
            $video = ShowVideoResource::collection($video);

            return $video; 
        }

        /**
         * Return value education video items for the authenticated user's school.
         *
         * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
         */
        public function showvideovalueducation()
        {
            $video = Video::where([['school_id',Auth::user()->school_id],['media','value_education'],['type','video']])->get();
            $video = ShowVideoResource::collection($video);

            return $video; 
        }

        /**
         * Return value education image items for the authenticated user's school.
         *
         * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
         */
        public function showimagevalueducation()
        {
            $video =Video::where([['school_id',Auth::user()->school_id],['media','value_education'],['type','image']])->get();
            $video = ShowVideoResource::collection($video);

            return $video; 
        }
}
