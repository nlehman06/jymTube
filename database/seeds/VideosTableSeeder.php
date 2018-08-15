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

        Video::create([
            "provider"             => "youtube",
            "provider_id"          => "pkTJgq3WfcY",
            "title"                => "Best Overall Mass Builder For The Biceps: Seated Barbell Curl",
            "description"          => "How to Curl More Weight by Isolating the Biceps\n►https://www.jimstoppani.com/training/seated-barbell-curl\n\nMany guys find that when they do standing barbell curls, they feel it more in the forearms and less in the biceps. That’s because when you perform a typical standing biceps curl the first half of the movement (from straight arm to arm bent about 90 degrees) primarily involves the brachialis (muscle underneath the biceps) and the brachioradialis (forearm muscle on the thumb side of the arm). The biceps don't really kick in until the elbow is close to 90 degrees. This first half of the ROM (range of motion) of the biceps curl is the weakest due to the fact that the biceps haven't fully kicked in yet to assist the brachialis and brachioradialis. Therefore, when you do a full ROM curl starting with your arms fully extended in the bottom position, you’re limited to a weight that you can perform through the weakest portion of the ROM. This limits the amount of stress that you can place on the biceps, and can limit your biceps growth. Watch this video to learn more benefits and how to do this movement with perfect form.\n\nCONNECT WITH ME\n\nFACEBOOK https://www.facebook.com/JimStoppaniPhD/\nINSTAGRAM https://www.instagram.com/jimstoppani/\nTWITTER https://twitter.com/JimStoppani",
            "permalink_url"        => "https://www.youtube.com/watch?v=pkTJgq3WfcY",
            "length"               => "00:04:29",
            "picture"              => "https://i.ytimg.com/vi/pkTJgq3WfcY/mqdefault.jpg",
            "created_time"         => "2018-06-04 18:57:53",
            "from_id"              => "UCTMLcC81ypVNk293RFS7Zaw",
            "from_name"            => "Jim Stoppani, PhD",
            "from_profile"         => "https://yt3.ggpht.com/-kzC5BAMC6NU/AAAAAAAAAAI/AAAAAAAAAAA/5vTD87KawT4/s88-c-k-no-mo-rj-c0xffffff/photo.jpg",
            "submitted_by_user_id" => 1,
            "submitted_date"       => "2018-06-06 01:52:13",
            "status"               => "submitted",
            "created_at"           => "2018-06-06 01:52:13",
            "updated_at"           => "2018-06-06 01:52:13",

        ]);
    }
}
