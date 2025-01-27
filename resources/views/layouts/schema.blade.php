<?php  $page = request()->segment(1);
$default_img = env('AWS_S3_domain').'epicon/assets/images/epicon-logo.png'; ?>

@if($page == 'games' || $page == 'games-all' )
<script type="application/ld+json">
  {
    "@context": "https://schema.org",
    "@type": "Game",
    "offers":{
      "@type":"Offer",
      "priceCurrency":"INR",
      "price":"17.99",
      "availableAtOrFrom":"https://www.epicon.in/play"
    },
    "audience":{
      "@type":"PeopleAudience",
      "suggestedMinAge":"8"
    },
    "description":"Play your favorite online games on Epic On. With a wide selection of games to choose from, Enjoy smooth and seamless gaming edxperience. Sign up for a free trial!",
    "gameItem":["online games", "word up", "kids games", "three card monte"],
    "numberOfPlayers":{
      "@type":"QuantitativeValue",
      "minValue":"3",
      "maxValue":"5"
    },
    "copyrightHolder":"Epicon"
  }
</script>
@elseif($page == 'movies')
<script type="application/ld+json">
  {
    "@context": "https://schema.org",
    "@type": "Movie",
    "name": "Best OTT Platform for Movies | Watch Online Movie Now | EPIC ON",
    "potentialAction" : {
      "@type": "WatchAction",
      "target" : "https://www.epicon.in/movies"
    }
  }
</script>
@elseif($page == 'live-tv')
<script type="application/ld+json">
  {
    "@context":"https://schema.org",
    "@type":"BroadcastEvent",
    "name": "Watch Live Tv | Best OTT Platforms for Live TV | EPIC ON",
    "description": "Catch all the live action with EPIC ON, Indias premier OTT platform for live TV. Stream your favorite news, sports, and entertainment channels from anywhere",
    "isLiveBroadcast": true,
    "videoFormat": "HD",
    "startDate": "2023-11-11T20:30-07:00",
    "broadcastOfEvent": {
      "@type": "Event",
      "name": "Epicon Live TV Show",
      "startDate": "2015-07-05T16:00-07:00",
      "location": {
        "@type": "Country",
        "name": "India"
      }
    }
  }
</script>
@elseif($page == 'podcast')
<script type="application/ld+json">
  {
     "@context": "https://schema.org/",
     "@type": "PodcastEpisode",
     "url": "https://www.epicon.in/listen/podcast/53",
     "name": "Top Podcasts Platform in India | Listen Now",
     "datePublished": "2023-11-18",
     "timeRequired": "00:15:30",
     "description": "Discover the top podcasts in India on Epic On, Indias premier OTT platform. With a wide range of genres to choose from, there is something for everyone. Start listening today!",
     "associatedMedia": {
       "@type": "MediaObject",
       "contentUrl": "https://www.epicon.in/listen/podcast/53"
     },
     "partOfSeries": {
       "@type": "PodcastSeries",
       "name": "Top Podcasts Platform in India | Listen Now",
       "url": "https://www.epicon.in/listen/podcast/53"
     }
  }
</script>
@elseif($page == 'tv-shows')
<script type="application/ld+json">
  {
    "@context": "https://schema.org",
    "@type": "VideoObject",
    "name": "{{ $content['title']?? 'EpicOn'}}",
    "description": "{{ $content['short_description']??'EpicOn'}}",
    "thumbnailUrl": "{{ $content['cover_image_v2']['large']??$default_img}}",
    "contentUrl": "{{ url()->current() }}",
    "embedUrl": "{{ url()->current() }}",
    "uploadDate": "{{ date('Y-m-d',strtotime($content['newrelease_date']??now())) }}",
    "publisher": {
      "@type": "Organization",
      "name": "EPIC ON",
      "logo": {
        "@type": "ImageObject",
        "url": "{{ $default_img }}"
      }
    }@if (isset($content['content_type']) && strtolower($content['content_type']) == 'show'),
    @php
        $actors = [];
        $director = null;
  
        if (isset($content['cast']) && is_array($content['cast'])) {
            foreach ($content['cast'] as $key => $value) {
                if (stripos($key, 'cast') !== false) {
                    $actors = array_map(function($name) {
                        return [
                            "@type" => "Person",
                            "name" => trim($name)
                        ];
                    }, explode(',', $value));
                } elseif (stripos($key, 'director') !== false) {
                    $director = [
                        "@type" => "Person",
                        "name" => $value
                    ];
                }
            }
        }
  
        $structuredData = [
            "actor" => $actors,
            "director" => $director
        ];
    @endphp
    {!! json_encode($structuredData, JSON_PRETTY_PRINT) !!}
  @endif
  
  }
</script>
@elseif($page == '')
<script type="application/ld+json">
{
"@context": "https://schema.org",
"@type": "WebSite",
"name": "EPIC ON",
"url": "https://www.epicon.in/",
"potentialAction": {
"@type": "ViewAction",
"target": "https://www.epicon.in/"
}
}
</script>
@elseif($page == 'search')
<script type="application/ld+json">
{
"@context" : "https://schema.org",
"@type" : "WebSite",
"url" : "https://www.epicon.in/",
"potentialAction" : {
"@type" : "SearchAction",
"target" : "https://www.epicon.in/{search_term_string}",
"query-input" : "required name=search_term_string"
}
}
</script>
@endif