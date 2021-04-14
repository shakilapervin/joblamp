<?php
function admin_asset($path, $secure = null)
{
    return app('url')->asset('public/assets/admin/' . $path, $secure);
}

function frontend_asset($path, $secure = null)
{
    return app('url')->asset('public/assets/frontend/' . $path, $secure);
}

function calculateRating($ratings)
{
    $ratingValues = [];
    foreach ($ratings as $aRating) {
        $ratingValues[] = $aRating->rating;
    }
    if (collect($ratingValues)->sum() > 0){
        $ratingAverage = collect($ratingValues)->sum() / $ratings->count();
    }else{
        $ratingAverage = 0;
    }

    return $ratingAverage;
}
function jobcategories(){
    $jobCategories = \App\JobCategory::where('status',1)->get();
    return $jobCategories;
}
