# Continue Watching Tray - Complete Flow

## Overview
The "Continue Watching" tray shows content that the user has started watching but hasn't finished. It appears on the homepage and is dynamically included based on the API response.

---

## Flow Diagram

```
┌─────────────────────────────────────────────────────────────────┐
│ 1. User visits homepage / loads page                            │
│    PageController::index($slug = 'home-v2')                     │
└──────────────────────────┬──────────────────────────────────────┘
                           │
                           ▼
┌─────────────────────────────────────────────────────────────────┐
│ 2. Call homepageData() function                                 │
│    - Makes API call to "pages/homepage"                         │
│    - Includes user_id, profile_id if logged in                  │
└──────────────────────────┬──────────────────────────────────────┘
                           │
                           ▼
┌─────────────────────────────────────────────────────────────────┐
│ 3. API Response returns list with display_type items            │
│    Example response:                                             │
│    {                                                             │
│      "data": {                                                   │
│        "list": [                                                 │
│          { "display_type": "banner", ... },                     │
│          { "display_type": "continuewatching", ... },  ◄──┐    │
│          { "display_type": "trending", ... }                │    │
│        ]                                                         │
│      }                                                           │
│    }                                                             │
└──────────────────────────┬──────────────────────────────────────┘
                           │
                           ▼
┌─────────────────────────────────────────────────────────────────┐
│ 4. In PageController::index() - Extract display_type array      │
│                                                                  │
│    $display_type = array_column(                                │
│        $result['data']['list'], 'display_type'                  │
│    );                                                            │
│    // Result: ['banner', 'continuewatching', 'trending', ...]   │
└──────────────────────────┬──────────────────────────────────────┘
                           │
                           ▼
┌─────────────────────────────────────────────────────────────────┐
│ 5. Check if "continuewatching" exists                           │
│                                                                  │
│    $continuewatching = in_array(                                │
│        "continuewatching",                                       │
│        $display_type                                             │
│    ) ? 'YES' : 'NO';                                            │
└──────────────────────────┬──────────────────────────────────────┘
                           │
                           ▼
┌─────────────────────────────────────────────────────────────────┐
│ 6. Pass to view                                                 │
│    return view('pages.homepage',                                │
│        compact(..., 'continuewatching')                         │
│    );                                                            │
└──────────────────────────┬──────────────────────────────────────┘
                           │
                           ▼
┌─────────────────────────────────────────────────────────────────┐
│ 7. In homepage.blade.php - Use continuewatching variable        │
│                                                                  │
│    var continuewatching = "{{ $continuewatching ?? '' }}";      │
│    // 'YES' or 'NO'                                             │
└──────────────────────────┬──────────────────────────────────────┘
                           │
                           ▼
┌─────────────────────────────────────────────────────────────────┐
│ 8. Render display-default.blade.php                             │
│    - Loops through $result['data']['list']                      │
│    - For each item with display_type                            │
│    - Includes the corresponding template:                       │
│      display.$display_type                                      │
└──────────────────────────┬──────────────────────────────────────┘
                           │
                           ▼
┌─────────────────────────────────────────────────────────────────┐
│ 9. When display_type = "continuewatching"                       │
│    - Includes:                                                  │
│      display/continuewatching.blade.php                         │
│                                                                  │
│    - Template renders:                                          │
│      • Title: "Continue Watching"                               │
│      • Content carousel with continue-watching items            │
│      • Progress bar for each item                               │
│      • "Resume" button                                          │
└─────────────────────────────────────────────────────────────────┘
```

---

## Code Breakdown

### 1. PageController - Extract continuewatching Flag

**File:** `app/Http/Controllers/PageController.php`

```php
public function index($slug = 'home-v2')
{
    // ... other code ...
    
    $data = $this->homepageData($slug);
    $result = $data['result'];
    
    if ($result && @$result['success'] == true) {
        $displayLanguageParam = $data['displayLanguageParam'];
        $stories = $data['stories'];
        
        // Extract display_type array from API response
        $display_type = array_column($result['data']['list'], "display_type");
        
        // Check if "continuewatching" is in the array
        $continuewatching = in_array("continuewatching", $display_type) ? 'YES' : 'NO';
        
        // Pass to view
        return view('pages.homepage', compact(
            'result',
            'displayLanguageParam',
            'stories',
            'meta',
            'slug',
            'continuewatching'  // ◄── Pass this variable
        ));
    }
}
```

### 2. Homepage Blade - Set JavaScript Variable

**File:** `resources/views/pages/homepage.blade.php`

```blade
<script>
    var processing;
    var spinnerAdded = false;
    var continuewatching = "{{ $continuewatching ?? '' }}";  // 'YES' or 'NO'
    var isMobileView = "{{ isMobliDevice() }}";
    var scrollRoute = "{{ request()->path() }}";
    
    // Used in AJAX call for load-more
    $(document).ready(function() {
        // ...
        
        // When user scrolls and requests more content
        $.ajax({
            url: '/pages/loadmore',
            method: 'POST',
            data: {
                page: paging,
                route: routepage,
                continuewatching: continuewatching,  // ◄── Send to server
                isMobileView: isMobileView
            },
            success: function(response) {
                // Append more content
            }
        });
    });
</script>
```

### 3. API Response Structure

**Endpoint:** `GET pages/homepage`

```json
{
    "success": true,
    "data": {
        "name": "Home",
        "list": [
            {
                "display_type": "banner",
                "title": "Featured",
                "content": [...]
            },
            {
                "display_type": "continuewatching",
                "title": "Continue Watching",
                "show_more": true,
                "catalog": "continue-watching-tray",
                "content": [
                    {
                        "ID": 1782723687,
                        "title": "Drama That Hits Home - Episode 1",
                        "slug": "drama-that-hits-home-ep1",
                        "asset_type": "WATCH",
                        "duration": 3600,
                        "user_duration": 1200,  // Watched 20 mins
                        "cover_image": {...},
                        "url": "shows/drama-that-hits-home/season-1/episode-1"
                    },
                    // ... more items
                ]
            },
            {
                "display_type": "trending",
                "title": "Trending Now",
                "content": [...]
            }
        ]
    }
}
```

### 4. Display Template Rendering

**File:** `resources/views/display/display-default.blade.php`

```blade
@if (@$result['data']['list'])
    @foreach ($result['data']['list'] as $key => $value)
        @if (isset($value['display_type']) && (
            (isset($value['content']) && !empty($value['content'])) ||
            $value['display_type'] == "shortandsweet" ||
            $value['display_type'] == "supermix"
        ))
            @php
                // Dynamically construct template path
                $template = 'display.' . $value['display_type'];
                // Result: 'display.continuewatching'
            @endphp
            
            @if (View::exists($template))
                @include($template, [
                    'value' => $value,
                    'title' => $title,
                    'slug' => $slug,
                    'displayLanguageParam' => $displayLanguageParam,
                ])
            @endif
        @endif
    @endforeach
@endif
```

### 5. Continue Watching Template

**File:** `resources/views/display/continuewatching.blade.php`

```blade
@if (array_search("WATCH", array_column($value['content'], "asset_type")) !== false)
<div class="carousel-main">
    <div class="carousel-title-n-arrow px-2 mb-2">
        <h1 class="text-white">{{ $title }}</h1>
        @if (@$value['show_more'])
        <a href="{{ getMidPageUrl($value, $slug) }}">
            <!-- See All arrow -->
        </a>
        @endif
    </div>
    
    <ul class="carousel-initilize p-0">
        @foreach ($value['content'] as $key => $val)
            @if(strtolower(@$val['asset_type']) == "watch")
            <li>
                <!-- Card with promo video hover -->
                <div class="play-card" data-promo-url="{{ @$val['promo_url'] }}">
                    <div class="top-card-img">
                        <img src="{{ $cover_img }}" alt="">
                    </div>
                    
                    <div class="bottom-card-content">
                        <!-- Resume button -->
                        <a class="upper-img play-btn" href="{{ getContentUrl($val) }}">
                            <svg><!-- play icon --></svg>
                            <span>{{ __('Resume') }}</span>
                        </a>
                        
                        <!-- Progress bar showing watch progress -->
                        <div class="progress-main">
                            <?php
                            $progress = (@$val['user_duration'] * 100) / ($val['duration'] ?? 1);
                            ?>
                            <div class="progress">
                                <div class="progress-bar" 
                                     style="width: {{ $progress }}%;">
                                </div>
                            </div>
                            <div class="left-time">
                                {{ convertSecondsToReadable(
                                    @$val['duration'] - @$val['user_duration']
                                ) }} remaining
                            </div>
                        </div>
                    </div>
                </div>
            </li>
            @endif
        @endforeach
    </ul>
</div>
@endif
```

---

## How Continue Watching Data Comes from API

The API (`pages/homepage`) backend logic:

```
1. User makes request with user_id and profile_id
2. API Backend checks database for:
   - Items watched by this user/profile
   - Items with user_duration > 0 (partially watched)
   - Items where user_duration < duration (not completed)
3. API returns a tray object with:
   - display_type: "continuewatching"
   - title: "Continue Watching"
   - content: [array of partially watched items]
```

### Example API Data Structure

```php
[
    'display_type' => 'continuewatching',
    'title' => 'Continue Watching',
    'show_more' => true,
    'catalog' => 'continue-watching-tray',  // Unique identifier
    'content' => [
        [
            'ID' => 1782723687,
            'title' => 'Drama Title',
            'slug' => 'drama-slug',
            'asset_type' => 'WATCH',
            'duration' => 3600,         // Total seconds
            'user_duration' => 1200,    // Watched seconds
            'cover_image' => [...],
            'url' => 'shows/path/...',
            'is_reel' => false,
            'promo_url' => 'https://...'
        ],
        // ... more items
    ]
]
```

---

## Variables & Data Flow

| Variable | Type | Source | Purpose |
|----------|------|--------|---------|
| `$continuewatching` | String | Controller | 'YES' or 'NO' - indicates if tray exists |
| `$display_type` | Array | API Response | All display types in the response |
| `$result['data']['list']` | Array | API Response | Array of tray objects |
| `$value['display_type']` | String | Loop in template | Current tray type being rendered |
| `$value['content']` | Array | API Response | Items in the tray |
| `$val['user_duration']` | Int | API Response | Seconds watched by user |
| `$val['duration']` | Int | API Response | Total duration in seconds |

---

## Frontend Rendering

Once the template renders, the carousel is initialized with Slick.js:

```javascript
// In homepage.js or template
$('.carousel-initilize').slick({
    dots: false,
    infinite: false,
    speed: 300,
    slidesToShow: 5,
    slidesToScroll: 1,
    responsive: [
        { breakpoint: 1200, settings: { slidesToShow: 4 } },
        { breakpoint: 768, settings: { slidesToShow: 2 } }
    ]
});
```

---

## Caching

The continue watching status is cached per request:

**In loadMore method:**
```php
$view = Cache::remember(
    "loadmore/$slug/$page/$continuewatching/$isMobile/$isLoggedIn",
    600,  // 10 minutes
    function() use($slug, $page) {
        // Render view
    }
);
```

Key: `loadmore/home-v2/1/YES/0/1`
- `$slug`: Page slug
- `$page`: Page number
- `$continuewatching`: YES/NO flag
- `$isMobile`: Mobile device flag
- `$isLoggedIn`: User login status

---

## Display Types

Other display types in the system:
- `banner` - Hero banner
- `trending` - Trending content
- `special` - Special collections
- `reels-special` - Special reels
- `languages` - Language-specific content
- `shortandsweet` - Epic Shots/Stories
- `continuewatching` - Continue watching
- `reels-continuewatching` - Continue watching reels
- `supermix` - Personalized mix
- And more...

---

## How Reels Continue Watching Works

**File:** `resources/views/display/reels-continuewatching.blade.php`

Similar to `continuewatching.blade.php` but for reel content:

```blade
@if (array_search("WATCH", array_column($value['content'], "asset_type")) !== false)
    <!-- Similar structure but for reel items -->
    @foreach ($value['content'] as $key => $val)
        @if(@$val['content_type'] == 'EPISODE' || @$val['is_reel'])
            <!-- Render reel item with progress -->
        @endif
    @endforeach
@endif
```

---

## Summary

1. **API** returns list of display types including `"continuewatching"`
2. **Controller** extracts and checks if it exists: `in_array("continuewatching", $display_type)`
3. **Controller** passes `$continuewatching = 'YES'` to view
4. **Template loop** includes `display.continuewatching` for that tray
5. **Blade template** renders carousel with progress bars and resume buttons
6. **Frontend JS** initializes carousel slider

This allows the tray to appear dynamically only when the API includes it in the response.
