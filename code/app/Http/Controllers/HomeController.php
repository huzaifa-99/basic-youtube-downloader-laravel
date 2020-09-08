<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\DomCrawler\Crawler; // for scraping content ** to be updated
use Weidner\Goutte\GoutteFacade; // For making a get request ** to be updated
use YouTube\YouTubeDownloader;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function secondsToTimestamp($runtime)
    {
        if($runtime>3600)
        {
            $hours = $runtime/3600;
            if(!is_float($hours))
            {
                $dummy = $hours.':00:00';
                return $dummy;
            }
        }
        if($runtime>59)
        {   
            $minutes = ($runtime/60)%60;

            if($minutes==0)
            {
                $minutes='00';
            }
            elseif($minutes>0 && $minutes<10)
            {
                $minutes='0'.$minutes;
            }

            $seconds = $runtime%60;

            if($seconds==0)
            {
                $seconds='00';
            }
            elseif($seconds>0 && $seconds<10)
            {
                // str_pad($seconds, 1,'0',STR_PAD_LEFT);
                $seconds='0'.$seconds;
            }

            if(isset($hours))
            {
                $dummy = floor($hours).':'.$minutes.':'.$seconds;
            }
            else
            {
                $dummy = $minutes.':'.$seconds;
            }

            return $dummy;
        }
        return '00:'.$runtime;
    }

    public function getInfo(Request $request)
    {
        $youtube = new YouTubeDownloader();

        $id = $youtube->extractVideoId($request->link); // get video id

        $encodedString = file_get_contents('https://www.youtube.com/get_video_info?video_id='.$id); // get video info (encoded with url and json)

        $urlDecoded = urldecode($encodedString); // decode url

        parse_str($urlDecoded,$jsonString); // parse the url string to get json object.

        $phpObject = json_decode($jsonString['player_response']); // decode the json object to php object.'player_response' contains all info i want.anytime i want to add or remove itags(formats for download) this is where to look for answers.........


        // processing videoDetails here ( The object that contains title,runtime and thumbnail details. )

            $videoDetails = $phpObject->videoDetails;

            $title = $videoDetails->title; 
            $runtime = $this->secondsToTimestamp($videoDetails->lengthSeconds);

            $dThumb = $videoDetails->thumbnail->thumbnails;
            $thumbnail = $dThumb[sizeof($dThumb)-1]->url;  // get the last index containing thumnail link for max px's.

        // processing done


        // processing streamingData here ( The object that contains download links for different qualities. )

            $formats = $phpObject->streamingData->formats;

            $qualities = array(); // array to store download qualities=links

            foreach ($formats as $format) 
            {
                $url = $format->url;  // .'&title='.urlencode($title)
                $quality = $format->qualityLabel;

                $qualities[$quality]=$url;  // appending data to array (here $quality=key and $url=value)
            }

        // processing done


            $videoInfo = array(); // the array to return back

            $videoInfo['title']=$title;
            $videoInfo['runtime']=$runtime;
            $videoInfo['thumbnail']=$thumbnail;
            $videoInfo['qualities']=$qualities;

        

        return json_encode($videoInfo);
    }

      

    public function downloadVideo(Request $request)
    {
        $headers = get_headers($request->quality,1); // 2nd parameter(non-zero) is used to return asoociative array.

        $cType = $headers['Content-Type'];// Content-Type
        $cLength = $headers['Content-Length'];// Content-Length

        if(is_array($headers['Content-Type']))
        {
            $cType = strpos($headers['Content-Type'][1], 'video');
        } 

        // Set Headers
        header('Content-Description: File Transfer');
        header('Content-Type:'.$cType);
        header('Content-Disposition: attachment; filename='.$request->title.'.mp4');
        header('Content-Length: '.$cLength);
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        ob_flush();
        flush();

        // Create a handle and read the file until it ends.
        $handle = fopen($request->quality, "r");    // dd($handle); it is a resource type use getType()
        while (!feof($handle)) 
        {
            echo fread($handle, $cLength);
            ob_flush();
            flush();
        }
        fclose($handle);
        exit;
    }




























    public function search(Request $request)
    {
        $crawler = GoutteFacade::request('GET', 'https://www.google.com');

        if($crawler)
        {   

            dump('here');

            $download = $crawler->filter('#container > #movie_player > .html5-video-container > .video-stream')->attr('src');

            dump($download);

            $path = 'E:/Softwares/Installed/Xampp/htdocs/Projects/project9/p1/public/videos/'.basename($download);

            $file = file_get_contents('https://www.google.com'.$download); 

            dump($file);


            $save = file_put_contents($path, $file);

            if($save) { dd('saved'); } 
            else { dd('could not save'); }
        }

        else{
            dd('no crawler');
        }
       // If Not 
    }

    public function curl_get_file_size( $url ) {
  // Assume failure.
  $result = -1;

  $curl = curl_init( $url );

  // Issue a HEAD request and follow any redirects.
  curl_setopt( $curl, CURLOPT_NOBODY, true );
  curl_setopt( $curl, CURLOPT_HEADER, true );
  curl_setopt( $curl, CURLOPT_RETURNTRANSFER, true );
  curl_setopt( $curl, CURLOPT_FOLLOWLOCATION, true );
  // curl_setopt( $curl, CURLOPT_USERAGENT, get_user_agent_string() );

  $data = curl_exec( $curl );
  curl_close( $curl );

  if( $data ) {
    $content_length = "unknown";
    $status = "unknown";

    if( preg_match( "/^HTTP\/1\.[01] (\d\d\d)/", $data, $matches ) ) {
      $status = (int)$matches[1];
    }

    if( preg_match( "/Content-Length: (\d+)/", $data, $matches ) ) {
      $content_length = (int)$matches[1];
    }

    // http://en.wikipedia.org/wiki/List_of_HTTP_status_codes
    if( $status == 200 || ($status > 300 && $status <= 308) ) {
      $result = $content_length;
    }
  }

  return $result;
}

    public function test(Request $request)
    {   
        $link = 'https://r2---sn-ug5onfvgaq-aixl.googlevideo.com/videoplayback?expire=1591578137&ei=uTndXvjmM8PY1ganmYeACQ&ip=110.93.226.188&id=o-AAWL_05XzhFRaSZKj370fkTgAWmH1GfeJ_P4t3Ryl9Z_&itag=18&source=youtube&requiressl=yes&mh=4N&mm=31,29&mn=sn-ug5onfvgaq-aixl,sn-hju7en7r&ms=au,rdu&mv=m&mvi=1&pl=24&initcwndbps=155000&vprv=1&mime=video/mp4&gir=yes&clen=2660304&ratebypass=yes&dur=28.815&lmt=1590891869423789&mt=1591556441&fvip=4&c=WEB&txp=5531432&sparams=expire,ei,ip,id,itag,source,requiressl,vprv,mime,gir,clen,ratebypass,dur,lmt&sig=AOq0QJ8wRgIhAODQwlMSQ5A_mjhqvSzoICWM9nyGyLFoYh8VoNzviJ4MAiEA4y9hpfsSn-WVf_QnVbHXsnYAT8UGrK5DiUlhh_yciNU=&lsparams=mh,mm,mn,ms,mv,mvi,pl,initcwndbps&lsig=AG3C_xAwRQIhALuqScrzu2yITBRQF1eetEz38-hnoH6e1QUwovOqFvf3AiAM7LQk312c8VU4ZNqpfPH5btpjf1GXpOO8i1Tc0BxCBQ==';

        $headers = get_headers($link,1); // 2nd parameter(non zero) is used to return asoociative array.

        $cType = $headers['Content-Type'];// Content-Type
        $cLength = $headers['Content-Length'];// Content-Length

        if(is_array($headers['Content-Type']))
        {
            $cType = strpos($headers['Content-Type'][1], 'video');
        }

        $handle = fopen($link, "r");    // dd($handle); it is a resurce type use getType()

        header('Content-Description: File Transfer');
        header('Content-Type:'.$cType);
        // header("Content-Type: application/force-download");header("Content-Type: application/download");
        header('Content-Disposition: attachment; filename='.$request->title);
        header('Content-Length: '.$cLength);
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        ob_flush();
        flush();
        // $fp = fopen($file, "r");//$file variable with file file
        while (!feof($handle)) {
            echo fread($handle, $cLength);
            ob_flush();
            flush();
        }
        fclose($handle);

        exit;


        // http_response_code(404);
        /* Test whether the file name contains illegal characters
    such as "../" using the regular expression */
    # if(preg_match('/^[^.][-a-z0-9_.]+[a-z]$/i', $file))
    // if(isset($_REQUEST["file"]))
    // file_exists()readfile()die()


        $file = 'https://r4---sn-npoe7ned.googlevideo.com/videoplayback?expire=1591534983&ei=J5HcXqLZM4mwwgOZyKrICA&ip=128.199.151.21&id=o-AEO9cUDCVFAwzXqJ1CQqYzonA2TC5Al9W8iz4zmVC6i5&itag=22&source=youtube&requiressl=yes&mh=HU&mm=31%2C29&mn=sn-npoe7ned%2Csn-npoeene7&ms=au%2Crdu&mv=m&mvi=3&pl=20&initcwndbps=208750&vprv=1&mime=video%2Fmp4&ratebypass=yes&dur=612.612&lmt=1579629117872174&mt=1591513362&fvip=4&c=WEB&txp=5535432&sparams=expire%2Cei%2Cip%2Cid%2Citag%2Csource%2Crequiressl%2Cvprv%2Cmime%2Cratebypass%2Cdur%2Clmt&sig=AOq0QJ8wRAIgYAUhW89uoIx3lUx0jZHh3_CnRpbOnjBjNc7nNp7-WicCIAQYPfpEbZWR_HvN5wl0drPm3Pl8ALRBzzbZsN6NX6UX&lsparams=mh%2Cmm%2Cmn%2Cms%2Cmv%2Cmvi%2Cpl%2Cinitcwndbps&lsig=AG3C_xAwRQIhAMtVXF3Ner1PEJTM91waO94q7Hc-C0g0MAI09rC-EUV9AiBQ9OzmgDY1PBET59waoxS4l95XsWJuRhqMAeE60XjR5Q%3D%3D&contentlength=100272287&video_id=sRVQweiDK5o';

        
            header('Content-Description: File Transfer');
            header('Content-Type: application/mp4');
            // header("Content-Type: application/force-download");header("Content-Type: application/download");
            header('Content-Disposition: attachment; filename="jcvshcvs.mp4"');
            // header('Content-Length: ' . filesize($file));
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            ob_flush();
            flush();
            $fp = fopen($file, "r");//$file variable with file file
            while (!feof($fp)) {
                echo fread($fp, 65536);
                ob_flush();
                flush();
            }
            fclose($fp);
            
            // readfile($file);
            exit;
        
        dd('here');
        // $title = 'DIY Miniatures Dollhouse Bathroom and Bedroom ~ Belle (Beauty and the Beast) 5 Rooms Decor';

        // dump(urlencode($title));

        // dump(urldecode($title));

        // dd('here'); 
        // $link='https://r1---sn-hju7en7k.googlevideo.com/videoplayback?expire=1591499580&ei=3AbcXqvSC5Oa1wbYv7DQCw&ip=103.140.30.139&id=o-AOw5CfonwMzvJbJfW-ssgL3OpvqaIfPvEsiqdUAKkh0J&itag=18&source=youtube&requiressl=yes&vprv=1&mime=video/mp4&gir=yes&clen=4226024&ratebypass=yes&dur=45.812&lmt=1429965757689550&fvip=4&c=WEB&sparams=expire,ei,ip,id,itag,source,requiressl,vprv,mime,gir,clen,ratebypass,dur,lmt&sig=AOq0QJ8wRQIhAJRdcAD1UUJlzz1Xgy5uhUS5frGtqmoc7_EEP6SqDNQSAiBw5_X3UXej-750LIFS9VvkPbrQqT1G2WCcTx6Zq9zYSQ==&redirect_counter=1&cm2rm=sn-ug5onfvgaq-3ipl7l&req_id=5983f9011359a3ee&cms_redirect=yes&mh=P6&mm=30&mn=sn-hju7en7k&ms=nxu&mt=1591477939&mv=m&mvi=3&pl=24&lsparams=mh,mm,mn,ms,mv,mvi,pl&lsig=AG3C_xAwRAIgHF-FkpFfCFh-GqCmv2h4E1NPVrcAwzHG4BFYK698kgsCIEyoxx1jnXxoUR8Vtpi5GRUIzSc37lcAIbrx0-cso1ov&ir=1&rr=12';



        // dd('here');

        // dd($this->secondsToTimestamp(5400));

        // dd('here');
        // $runtime = 5710;

        // if($runtime>3600)
        // {
        //     $hours = $runtime/3600;
        //     if(!is_float($hours))
        //     {
        //         $dummy = $hours.':00:00';
        //         return $dummy;
        //     }
        // }
        // if($runtime>60)
        // {   
        //     $minutes = ($runtime/60)%60;

        //     $seconds = $runtime%60;

        //     if($seconds==0)
        //     {
        //         $seconds='00';
        //     }
        //     elseif($seconds>0 && $seconds<10)
        //     {
        //         // str_pad($seconds, 1,'0',STR_PAD_LEFT);
        //         $seconds='0'.$seconds;
        //     }

        //     if(isset($hours))
        //     {
        //         $dummy = floor($hours).':'.$minutes.':'.$seconds;
        //     }
        //     else
        //     {
        //         $dummy = $minutes.':'.$seconds;
        //     }

        //     return $dummy;
        // }
        // return $runtime;

        // dd('here');
        

        $youtube = new YouTubeDownloader();

        $id = $youtube->extractVideoId('https://www.youtube.com/watch?v=lmIFXIXQQ_E');

        $encodedString = file_get_contents('https://www.youtube.com/get_video_info?video_id='.$id);

        dump('plane => '.$encodedString);   // The string i got from youtube
       
                                                    // dump('encoded => '.urlencode($encodedString)); this is not needed as it is already encoded

                                                // decoding the string would give jsondata which is to be decoded again for php arrays

                                                // dump('urldecoded => '.urldecode($encodedString));
        

        // urldecoding parsing and json decoding the string

        $urldecoded = urldecode($encodedString);

        parse_str($urldecoded,$jsonString);

        $phpArray = json_decode($jsonString['player_response']); // player_response is the thing i am looking for

        dump($phpArray); // i am have to extract videoDetails and streamingData objects from this objects collection // anytime i want to add or remove itags(formats for download) this is where to look for answers.........

        dump($phpArray->streamingData);

        dump($phpArray->videoDetails);

        // processing streamingData here ( ok ho gia )

        $formats = $phpArray->streamingData->formats;

        $qualities = array();

        foreach ($formats as $format) 
        {
            $dummy = array();

            $url = $format->url;
            $quality = $format->qualityLabel;

            $qualities[$quality]=$url;  // This is the best one

            // $dummy = array($quality => $url);
            // $result = $qualities+$dummy;

            // $dummy = array($quality => $url);
            // array_push($qualities, $dummy);
        }

        dump($qualities);


        // processing videoDetails here ( ok ho gia )


        $videoDetails = $phpArray->videoDetails;

        $title = $videoDetails->title;
        $runtime = $videoDetails->lengthSeconds;
        $dThumb = $videoDetails->thumbnail->thumbnails;
        $thumbnail = $dThumb[sizeof($dThumb)-1]->url;


        $videoInfo = array();

        $videoInfo['title']=$title;
        $videoInfo['runtime']=$runtime;
        $videoInfo['thumbnail']=$thumbnail;
        $videoInfo['qualities']=$qualities;

        dump(json_encode($videoInfo));

        dd('here');
        // here




        // yahan tak fully functional code for getting video details isky aagy trash code hai......


        parse_str($encodedString,$new);
        dump('parsed'); dump($new['player_response']);



        dump('json_decoded'); $player_response =  json_decode($new['player_response']);
        dump($player_response->streamingData->formats);



        dd('end');

        // things i need

        // * video info  ( title,runtime,thumbnail)
        // * format info (itag for quality identification and donwload url )








        // parse_str($new['player_response'],$new1);

        // dd($new1['streamingData']);

        // $decodedJSON = json_decode($new1);

        // dd()



        dd('end');

        

        $video = file_get_contents('https://r2---sn-ug5onfvgaq-3ipl.googlevideo.com/videoplayback?expire=1591383381&ei=9EDaXtvlONOymLAPtMSU4Ac&ip=103.140.30.139&id=o-AHBxIS5glfdcK-DGYLIpXcO2xqAkYcATRsCFmBJ7gGPd&itag=18&source=youtube&requiressl=yes&mh=4N&mm=31%2C26&mn=sn-ug5onfvgaq-3ipl%2Csn-hgn7yn76&ms=au%2Conr&mv=m&mvi=1&pl=24&initcwndbps=198750&vprv=1&mime=video%2Fmp4&gir=yes&clen=2660304&ratebypass=yes&dur=28.815&lmt=1590891869423789&mt=1591361679&fvip=4&c=WEB&txp=5531432&sparams=expire%2Cei%2Cip%2Cid%2Citag%2Csource%2Crequiressl%2Cvprv%2Cmime%2Cgir%2Cclen%2Cratebypass%2Cdur%2Clmt&sig=AOq0QJ8wRQIgARJAc4xeePBt4RDznlE71cD5QG94MidblrRJgs2Rq7MCIQC5xxX3Bs9VtrAwWdM4qcqZ-zHBzYF3TZWWwEhBTOXmHw%3D%3D&lsparams=mh%2Cmm%2Cmn%2Cms%2Cmv%2Cmvi%2Cpl%2Cinitcwndbps&lsig=AG3C_xAwRQIgEvCoqJpNbvTHoLxEDbW0VcgkDxxgUfUbonuQEjNBoFwCIQDuGfhUigcPTxT0-PHnLhU1nv1h_PYkK_k4JciWnr_tsA%3D%3D');
        // // dd($video);

        dd(basename($video));
        dd('here');

//         $youtube = new \YouTube\YouTubeStreamer();
// $youtube->stream('https://youtu.be/1I-3vJSC-Vo  ');

// exit();


// get the url

// get download links 

// find the links which is mp4+video+audio+quality()

// push the links to frontend

// click on the link and download the video using ajax



    // $x = array();

    // array_push($x,'link');

    // dd($x);

//         $new_input = array('type' => 'text', 'label' => 'First name', 'show' => true, 'required' => true);
// $options['inputs']['name'] = $new_input;

// dd($new_input);


    // Step 1 : Get the links
    $yt = new YouTubeDownloader();

    $links = $yt->getDownloadLinks("https://youtu.be/1I-3vJSC-Vo");


    $t = $yt->getBrowser();
    dd($t);
    // Step 2 : Check if the $link variable is a 2D array 
    if(is_array($links))
    {   
        // Handle the links pushing here
        $i=0;
        $mainArr = array();

        while ($i < sizeof($links)) 
        {
            $format = $links[$i]['format'];

            if(strpos($format,'mp4') !== false && strpos($format,'video') !== false && strpos($format,'audio') !== false)
            {   
                $subArr = array();

                $quality = explode(',', $format);

                // Method 1 :: associative keys with quality as key of link
                $subArr = array( trim($quality[2]) => $links[$i]['url']);
                array_push($mainArr,$subArr);

                // Method 2 :: numeric keys with quality[0] and link[1]
                // array_push($subArr,$quality[2]);
                // array_push($subArr,$links[$i]['url']);
                // array_push($mainArr,$subArr);
            }

            $i++;
        }

        dd(array_merge($mainArr[0],$mainArr[1]));
        dd($mainArr);
    }   
    else
    {
        dump('it is not an array');
    }

// if(array_key_exists('format',$links[1])){
//     dump('has');
//     dump(explode(',',$links[1]['format'])); 
// }
dump($links[19]);
dd('end');

// $i = 0;
// while ($i <= 10) 
// {
//     var_dump($links[$i]['format']);
//     echo "<br>";
//     $i++;
// }


// dd('here');
dump($links[5]['format']);
        $desir = $links[5]['url'];

        dd($desir);
        $x = file_get_contents($desir);
        // dd($x);

        $path = 'E:/Softwares/Installed/Xampp/htdocs/Projects/project9/p1/public/videos/video.mp4';

        // dd($path);
        $save = file_put_contents($path, $x);

        dd('saved');







        // var_dump(openssl_get_cert_locations());
        dump('here');

        $req = GoutteFacade::request('GET', 'https://youtu.be/1I-3vJSC-Vo');

        dump($req);

        $fil = $req->filter('.html5-main-video')->attr('src');

        dd($fil);

        $pic  = 'https://www.google.com'.$fil;

        dump($pic); 

        $data = file_get_contents($pic);

        dump($data);

        $path = 'E:/Softwares/Installed/Xampp/htdocs/Projects/project9/p1/public/videos/'.basename($fil);

        $save = file_put_contents($path, $data);


        // file_get_contents() SSL operation failed with code 1. OpenSSL Error messages error14095126SSL routinesssl3_read_nunexpected
        
        /* not working
        $url= 'https://google.com';

        $arrContextOptions=array(
              "ssl"=>array(
                    "verify_peer"=>false,
                    "verify_peer_name"=>false,
                ),
            );  

        $response = file_get_contents($url, false, stream_context_create($arrContextOptions));
        dd($response);
        */



        /* working code
        function url_get_contents ($Url) {
            if (!function_exists('curl_init')){ 
                die('CURL is not installed!');
            }
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $Url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $output = curl_exec($ch);
            curl_close($ch);
            return $output;
        }

        $path = 'E:/Softwares/Installed/Xampp/htdocs/Projects/project9/p1/public/videos/googlelogo_white_background_color_272x92dp.png';
        $file = url_get_contents('https://www.google.com/images/branding/googlelogo/1x/googlelogo_white_background_color_272x92dp.png');
        $save = file_put_contents($path, $file);
        dd('end');

        */
    } 

    // public function getInfo(Request $request)
    // {   
    //     $youtube = new YouTubeDownloader();

    //     $links = $youtube->getDownloadLinks($request->link);

    //     if($links && is_array($links))
    //     {
    //         $mainArr = array();

    //         $i = 0;

    //         while ($i < sizeof($links)) 
    //         {
    //             $format = $links[$i]['format'];

    //             if(strpos($format, 'mp4') !== false && strpos($format, 'video') !== false && strpos($format, 'audio') !== false)
    //             {
    //                 $subArr = array();

    //                 $quality = explode(',',$format);

    //                 $subArr = array( trim($quality[2]) => $links[$i]['url'] );

    //                 array_push($mainArr, $subArr);
    //             }

    //             $i++;
    //         }
            
    //         return json_encode($mainArr);
    //     }

    //     // return video not found or broken link error here
    // }
}
