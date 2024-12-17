<?php  $page = request()->segment(1);  ?>

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
    "description":"Watch your favorite TV show online at Epic On. Best OTT Platforms for TV shows in Hindi and English. Subscribe to our platform today!",
    "url":"https://www.epicon.in/tv-shows",
    "@type": "TVSeries",
    "datePublished": "2023-11-30",
    "name": "Watch Indian TV Shows Online at Epic On | Streaming Now | EPIC ON"
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