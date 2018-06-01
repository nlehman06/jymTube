<?php

use App\Video;
use Illuminate\Database\Seeder;

class VideosTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Video::create([
            "provider"             => "facebook",
            "provider_id"          => "10156310534098024",
            "title"                => "Supplement Round-Up BCAA's",
            "description"          => "It amazes me how many PRE-WORKOUTS on the market DON'T include BCAAs. Big mistake – BCAAs are just as important before a workout as after. In the below video, I explain why. If you want a pre-workout that includes a full 6-gram dose of BCAAs, get PRE JYM: PreJYM.com/bodybuilding.",
            "permalink_url"        => "https://www.facebook.com//JimStoppaniPhD/videos/10156310534098024/",
            "length"               => "00:03:57",
            "picture"              => "https://scontent.xx.fbcdn.net/v/t15.0-10/p168x128/27853565_10156310538823024_3994653089490534400_n.jpg?_nc_cat=0&oh=f42096bc45c6fabc477be5e98122b923&oe=5B76E9CD",
            "created_time"         => "2018-03-26 14:30:00",
            "from_id"              => "307812318023",
            "from_name"            => "Dr. Jim Stoppani",
            "from_profile"         => "https://scontent.xx.fbcdn.net/v/t1.0-1/p50x50/19756356_10155548622063024_7364227892948231468_n.jpg?_nc_cat=1&oh=4e1282e704588a9cf76582bbfafa8173&oe=5B79AA97",
            "submitted_by_user_id" => 1,
            "submitted_date"       => "2018-06-01 01:00:03",
            "status"               => "submitted",
        ]);
    }
}
