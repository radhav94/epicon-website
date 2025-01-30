<?php  $page = getFirstSegment();
$segment2 = getFirstSegment(2);
$default_img = env('AWS_S3_domain').'epicon/assets/images/epicon-logo.png';
?>

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
    "@type": "WebPage",
    "url": "https://www.epicon.in/movies",
    "name": "Movies",
    "description": "Explore an extensive library of Indian movies across genres on EPIC ON. Enjoy captivating films, from timeless classics to new releases, anytime and anywhere. Start streaming today!",
    "publisher": {
      "@type": "Organization",
      "name": "EPIC ON",
      "url": "https://www.epicon.in",
      "logo": {
          "@type": "ImageObject",
        "url": "{{ $default_img }}"
      }
    },
    "mainEntityOfPage": {
      "@type": "WebPage",
      "@id": "https://www.epicon.in/movies"
    },
    "potentialAction": {
      "@type": "SearchAction",
      "target": "https://www.epicon.in/search?q={search_term_string}",
      "query-input": "required name=search_term_string"
    },
    "breadcrumb": {
      "@type": "BreadcrumbList",
      "itemListElement": [
        {
          "@type": "ListItem",
          "position": 1,
          "name": "Home",
          "item": "https://www.epicon.in"
        },
        {
          "@type": "ListItem",
          "position": 2,
          "name": "Movies",
          "item": "https://www.epicon.in/movies"
        }
      ]
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
@if(!empty($segment2))
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
    }
    
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
                }
                if (stripos($key, 'director') !== false) {
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
  }
</script>
@else
<script type="application/ld+json">
  {
    "@context": "https://schema.org",
    "@type": "WebPage",
    "url": "https://www.epicon.in/tv-shows",
    "name": "Tv Shows",
    "description": "Binge-watch the best Indian TV shows on EPIC ON. There's something for everyone from drama and history to lifestyle and adventure. Start your journey into amazing stories today!",
    "publisher": {
    "@type": "Organization",
    "name": "EPIC ON",
    "url": "https://www.epicon.in",
    "logo": {
        "@type": "ImageObject",
      "url": "{{ $default_img }}"
    }
    },
    "mainEntityOfPage": {
    "@type": "WebPage",
    "@id": "https://www.epicon.in/tv-shows"
    },
    "potentialAction": {
    "@type": "SearchAction",
      "target": "https://www.epicon.in/search?q={search_term_string}",
      "query-input": "required name=search_term_string"
    },
    "breadcrumb": {
    "@type": "BreadcrumbList",
      "itemListElement": [
      {
          "@type": "ListItem",
          "position": 1,
          "name": "Home",
          "item": "https://www.epicon.in"
      },
      {
          "@type": "ListItem",
          "position": 2,
          "name": "Tv shows",
          "item": "https://www.epicon.in/tv-shows"
      }
    ]
    }
  }
</script>
@endif
@elseif($page == '')
<script type="application/ld+json">
  {
    "@context": "http://schema.org/",
    "@type": "Organization",
    "image": "{{ $default_img }}",
    "url": "https://www.epicon.in",
    "email": "support@epicon.in",
    "name": "EPIC ON",
    "logo": {
      "@type": "ImageObject",
      "url": "{{ $default_img }}"
    },
    "sameAs": [
      " https://www.facebook.com/theepicon",
      " https://x.com/theepicon ",
      " https://www.instagram.com/theepicon/ ",
      "https://play.google.com/store/apps/details?id=com.epicchannel.epicon&hl=en",
      "https://apps.apple.com/in/app/epic-on-originals-movies/id1252513341"
    ]
  },
  {
    "@context": "http://schema.org/",
    "@type": "WebSite",
    "url": "https://www.epicon.in/",
    "name": "EPIC ON",
    "potentialAction": {
      "@type": "SearchAction",
      "target": "https://www.epicon.in/search?q={search_term_string}",
      "query-input": "required name=search_term_string"
    }
  },
  {
    "@context": "http://schema.org/",
    "@graph": [
      {
        "@type": "SiteNavigationElement",
        "@id": "https://www.epicon.in/#table-of-contents",
        "name": "Home",
        "url": "https://www.epicon.in"
      },
      {
        "@type": "SiteNavigationElement",
        "@id": "https://www.epicon.in/#table-of-contents",
        "name": "TV Shows",
        "url": "https://www.epicon.in/tv-shows"
      },
      {
        "@type": "SiteNavigationElement",
        "@id": "https://www.epicon.in/#table-of-contents",
        "name": "Movies",
        "url": "https://www.epicon.in/movies"
      },
      {
        "@type": "SiteNavigationElement",
        "@id": "https://www.epicon.in/#table-of-contents",
        "name": " PODCASTS ",
        "url": " https://www.epicon.in/podcast "
      },
      {
        "@type": "SiteNavigationElement",
        "@id": "https://www.epicon.in/#table-of-contents",
        "name": " live tv ",
        "url": " https://www.epicon.in/live-tv "
      },
      {
        "@type": "SiteNavigationElement",
        "@id": "https://www.epicon.in/#table-of-contents",
        "name": "Kids",
        "url": "https://www.epicon.in/kids"
      },
      {
        "@type": "SiteNavigationElement",
        "@id": "https://www.epicon.in/#table-of-contents",
        "name": " DISTRO TV ",
        "url": " https://www.epicon.in/distro-tv "
      },
      {
        "@type": "SiteNavigationElement",
        "@id": "https://www.epicon.in/#table-of-contents",
        "name": " Premium ",
        "url": " https://www.epicon.in/premium "
      },
      {
        "@type": "SiteNavigationElement",
        "@id": "https://www.epicon.in/#table-of-contents",
        "name": " Explore ",
        "url": " https://www.epicon.in/explore "
      },
      {
        "@type": "SiteNavigationElement",
        "@id": "https://www.epicon.in/#table-of-contents",
        "name": "About Us",
        "url": "https://www.epicon.in/about"
      }
    ]
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