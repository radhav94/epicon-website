# Epic Shots Function - Complete Explanation

## Overview
The `epicShots()` function is called to fetch and prepare "Epic Shots" (short-form stories/microdramas) data for display on the homepage in the "Short and Sweet" section.

---

## Function Purpose

**What it does:**
- Fetches story/short-form content from the `pages/stories` API endpoint
- Processes and formats the data for display in the carousel
- Returns an array of story objects ready to render in the blade template

**Why it's called:**
When the homepage API response includes `display_type: "shortandsweet"`, the Epic Shots carousel needs special data that's different from regular content trays. Instead of using the generic content array, we call this function to fetch dedicated story data.

---

## When It's Called

### 1. In `homepageData()` Function
**File:** `app/Http/Controllers/PageController.php`

```php
foreach ($lists as $key => $list) {
    // Handle shortandsweet stories
    if ($list['display_type'] == "shortandsweet") {
        $stories = $this->epicShots();  // ◄── Called here
    }
    
    // Handle continue watching - fetch dedicated API
    if ($list['display_type'] == "continuewatching" && isUserLoggedIn()) {
        $continueWatchingData = $this->getContinueWatchingData();
        // ...
    }
}
```

**When?**
- During homepage data loading
- When looping through display types
- Only when `display_type == "shortandsweet"`

### 2. In `ajaxStoryData()` Function
**File:** `app/Http/Controllers/PageController.php`

```php
public function ajaxStoryData(Request $request)
{
    $id = $request->id;

    if (preg_match("/[a-z]/i", $id)) {
        $content_list = $this->epicShotsByShortCode($id);
        // ...
    } else {
        $story_list = $this->epicShots($id);  // ◄── Called with ID
    }
    // ...
}
```

**When?**
- When user clicks on a story to open the modal
- If ID is numeric, fetch specific story by ID

---

## Function Implementation

### Full Code
```php
private function epicShots($story_id = "")
{
    $stories_arr = [];
    
    // Call the API to get all stories
    $response = CurlAPI("pages/stories", "GET", null, 1);
    
    if ($response && @$response['success'] == true) {
        $data = $response['data'] ?? [];
        $list = $data['list'] ?? [];
        
        foreach ($list as $val) {
            // Only include stories with active status
            if (@$val['status']) {
                $stories = key_exists('stories', $val) ? $val['stories'] : [];
                
                foreach ($stories as $story) {
                    // If searching for specific story by ID
                    if (!empty($story_id) && @$story['ID'] == $story_id) {
                        $stories_arr = $story;
                        break;
                    } else {
                        // Build array of all active stories
                        $stories_arr[] = [
                            'id' => @$story['ID'],
                            'title' => @$story['title'],
                            'img_url' => getCardImage($story, 'imageUrl', 'small', []),
                            'short_code' => @$story['content_list'][0]['short_code']
                        ];
                    }
                }
            }
        }
    }
    
    return $stories_arr;
}
```

### How It Works Step-by-Step

1. **Initialize empty array**
   ```php
   $stories_arr = [];
   ```

2. **Call API**
   ```php
   $response = CurlAPI("pages/stories", "GET", null, 1);
   ```
   - Endpoint: `pages/stories`
   - Method: GET
   - No parameters
   - Uses API_DOMAIN_1

3. **Check success**
   ```php
   if ($response && @$response['success'] == true) {
   ```

4. **Extract data**
   ```php
   $data = $response['data'] ?? [];
   $list = $data['list'] ?? [];
   ```

5. **Loop through lists**
   ```php
   foreach ($list as $val) {
       if (@$val['status']) {  // Only active stories
   ```

6. **Extract stories from each list**
   ```php
   $stories = key_exists('stories', $val) ? $val['stories'] : [];
   ```

7. **Process each story**
   ```php
   foreach ($stories as $story) {
       if (!empty($story_id) && @$story['ID'] == $story_id) {
           // Return specific story if ID provided
           $stories_arr = $story;
           break;
       } else {
           // Build formatted array for all stories
           $stories_arr[] = [
               'id' => @$story['ID'],
               'title' => @$story['title'],
               'img_url' => getCardImage($story, 'imageUrl', 'small', []),
               'short_code' => @$story['content_list'][0]['short_code']
           ];
       }
   }
   ```

8. **Return result**
   ```php
   return $stories_arr;
   ```

---

## Data Flow

```
┌───────────────────────────────────┐
│ Homepage Load                      │
└────────────┬────────────────────────┘
             │
             ▼
┌───────────────────────────────────┐
│ homepageData() called              │
└────────────┬────────────────────────┘
             │
             ▼
┌───────────────────────────────────┐
│ Loop through display_type items   │
└────────────┬────────────────────────┘
             │
      ┌──────┴────────┐
      │               │
      ▼               ▼
  shortand        continuewatching?
  sweet?
      │                    │
   YES │                   │ YES
      ▼                    ▼
  ┌──────────────┐  ┌────────────────────┐
  │ Call         │  │ Call                │
  │ epicShots()  │  │ getContinueWatching │
  └──────┬───────┘  │ Data()              │
         │          └────────────────────┘
         ▼
  ┌──────────────────────────────┐
  │ API: pages/stories           │
  │ GET /pages/stories           │
  └──────┬───────────────────────┘
         │
         ▼
  ┌──────────────────────────────┐
  │ Process response:            │
  │ - Extract lists with status  │
  │ - Get stories from each list │
  │ - Format with id, title, url │
  └──────┬───────────────────────┘
         │
         ▼
  ┌──────────────────────────────┐
  │ Return $stories_arr          │
  │ [                            │
  │   {id, title, img_url, ...}, │
  │   {id, title, img_url, ...}  │
  │ ]                            │
  └──────┬───────────────────────┘
         │
         ▼
  ┌──────────────────────────────┐
  │ Pass to homepage view:       │
  │ $stories = epicShots result  │
  └──────┬───────────────────────┘
         │
         ▼
  ┌──────────────────────────────┐
  │ In display-default.blade.php │
  │ @if (display_type ==         │
  │      "shortandsweet")        │
  │   @include('display.epicshots'│
  │      ['stories' => $stories])│
  └──────┬───────────────────────┘
         │
         ▼
  ┌──────────────────────────────┐
  │ In epicshots.blade.php       │
  │ Render carousel of stories   │
  │ with thumbnails & modals     │
  └──────────────────────────────┘
```

---

## API Endpoint

### Request
```
GET https://contentapistg-njsapi.epicon.in/index/pages/stories
Header: x-access-auth-token: szQDOyDaxsS0E4qeV1rMfpYBKnSWVESH
```

### Response Format
```json
{
    "success": true,
    "data": {
        "list": [
            {
                "status": true,
                "stories": [
                    {
                        "ID": 123,
                        "title": "Story Title",
                        "imageUrl": "https://...",
                        "short_code": "story-slug",
                        "content_list": [
                            {
                                "short_code": "story-slug"
                            }
                        ]
                    },
                    // more stories
                ]
            },
            // more lists
        ]
    }
}
```

---

## Output Format

### Without story_id (Default - All Stories)
```php
$stories = [
    [
        'id' => 123,
        'title' => 'Story Title',
        'img_url' => 'https://cdn.../image.jpg',
        'short_code' => 'story-slug'
    ],
    [
        'id' => 124,
        'title' => 'Another Story',
        'img_url' => 'https://cdn.../image2.jpg',
        'short_code' => 'another-slug'
    ],
    // ... more stories
]
```

### With story_id (Specific Story)
```php
$story = [
    'ID' => 123,
    'title' => 'Story Title',
    'imageUrl' => 'https://...',
    'short_code' => 'story-slug',
    // full story object
]
```

---

## Blade Template Usage

### In `display-default.blade.php`
```blade
@if (isset($stories) && $value['display_type'] == "shortandsweet")
    @include('display.epicshots', ['stories' => $stories])
    @include('components.video-player-modal')
@else
    @include($template, [...])
@endif
```

### In `display/epicshots.blade.php`
```blade
@if ($stories)
    <section class="carousel-main mt-0" id="epic-shots">
        <div class="carousel-title-n-arrow px-2 mb-2">
            <h1 class="text-white">Short and Sweet</h1>
        </div>
        
        <div class="gaming-galore-main">
            <div class="epic-shots">
                @foreach ($stories as $story)
                    <div>
                        <a onclick="click_tile(this)" 
                           data-title="{{ @$story['title'] }}" 
                           data-type="Epic Shots"
                           data-id="{{ @$story['id'] }}">
                            <img src="{{ @$story['img_url'] }}" 
                                 alt="{{ @$story['title'] }}">
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    
    @section('style')
        <style>
            #epicShots video {
                width: 100%;
                height: 100%;
            }
        </style>
    @endsection
    
    <div class="modal epic-shots-modal fade" id="epicShots" tabindex="-1">
        <!-- Story modal content -->
    </div>
@endif
```

---

## Why Separate API Call?

**Question:** Why not use the stories data from the main homepage response?

**Answer:** 
1. **Different data structure** - Stories have a specific format different from regular content
2. **Dedicated endpoint** - API has a separate `pages/stories` endpoint optimized for stories
3. **Performance** - Fetching only when needed (when display_type is shortandsweet)
4. **Caching** - Can be cached separately if needed
5. **Flexibility** - Easy to update story logic independently from homepage

---

## Parameters

| Parameter | Type | Default | Purpose |
|-----------|------|---------|---------|
| `$story_id` | String | Empty | If provided, returns only that specific story. If empty, returns all stories. |

---

## Return Value

**Type:** Array

**When story_id is empty:**
```
[
    ['id' => 1, 'title' => '...', 'img_url' => '...', 'short_code' => '...'],
    ['id' => 2, 'title' => '...', 'img_url' => '...', 'short_code' => '...'],
    ...
]
```

**When story_id is provided:**
```
[
    'ID' => 1,
    'title' => '...',
    'imageUrl' => '...',
    'short_code' => '...',
    'content_list' => [...]
    // Full story object
]
```

**When API fails:**
```
[]  // Empty array
```

---

## Related Functions

### epicShotsByShortCode($short_code)
Fetches a specific story by its short_code:
```php
private function epicShotsByShortCode($short_code = "")
{
    $stories_arr = [];
    $response = CurlAPI("pages/stories/video?short_code=" . $short_code, "GET", null, 1);
    if ($response && @$response['success'] == true) {
        $stories_arr = $response['data']['list'] ?? [];
    }
    return $stories_arr;
}
```

---

## Usage Summary

| Context | Call | Purpose |
|---------|------|---------|
| Homepage | `epicShots()` | Get all stories for "Short and Sweet" carousel |
| Story Modal | `epicShots($id)` | Get specific story to display in modal |
| Story Page | `epicShotsByShortCode($code)` | Get story by short code for dedicated page |

---

## Key Points

✅ Called when `display_type == "shortandsweet"`  
✅ Fetches from `pages/stories` API endpoint  
✅ Returns formatted array for blade template  
✅ Can fetch all stories or specific story by ID  
✅ Filters only active stories (status = true)  
✅ Extracts id, title, image, and short_code  
✅ Passed to `display.epicshots` blade template  
✅ Rendered as carousel with story modals  
