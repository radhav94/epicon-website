# Epic Shots Function - Quick Reference

## TL;DR

**epicShots()** fetches short-form story/drama content to display in the "Short and Sweet" carousel on the homepage.

---

## Quick Facts

| Aspect | Detail |
|--------|--------|
| **Function Name** | `epicShots($story_id = "")` |
| **Location** | `PageController.php` |
| **Type** | Private function |
| **Called When** | `display_type == "shortandsweet"` |
| **API Used** | `pages/stories` |
| **Method** | GET |
| **Auth Required** | x-access-auth-token |
| **Parameters** | `$story_id` (optional) |
| **Returns** | Array of stories |

---

## Why It's Called

```
Homepage has a "Short and Sweet" section
         │
         ▼
API returns: display_type = "shortandsweet"
         │
         ▼
Need special story data (not regular content)
         │
         ▼
Call epicShots() to fetch from pages/stories API
         │
         ▼
Get formatted story array
         │
         ▼
Pass to epicshots.blade.php template
         │
         ▼
Render carousel of stories with modals
```

---

## Simple Example

### Code
```php
// In homepageData() function
if ($list['display_type'] == "shortandsweet") {
    $stories = $this->epicShots();  // Call it
}
```

### What Happens
1. Calls API: `GET pages/stories`
2. Processes response
3. Returns array like:
```php
[
    ['id' => 1, 'title' => 'Drama X', 'img_url' => '...', 'short_code' => 'drama-x'],
    ['id' => 2, 'title' => 'Drama Y', 'img_url' => '...', 'short_code' => 'drama-y'],
]
```

### Template Renders
```blade
@foreach ($stories as $story)
    <img src="{{ $story['img_url'] }}" alt="{{ $story['title'] }}">
@endforeach
```

---

## Use Cases

### 1. Homepage Load
```php
$stories = $this->epicShots();  // No parameters
// Returns: All active stories
```

### 2. Open Specific Story
```php
$story = $this->epicShots(123);  // With story ID
// Returns: Single story object with ID 123
```

### 3. By Short Code
```php
$story = $this->epicShotsByShortCode('drama-slug');
// Returns: Story with that short code
```

---

## Code Flow

```
1. Browser visits homepage
     ↓
2. PageController::index() called
     ↓
3. homepageData() called
     ↓
4. Loop through display_types
     ↓
5. Find display_type = "shortandsweet"
     ↓
6. Call: $stories = $this->epicShots()
     ↓
7. epicShots() calls API: GET pages/stories
     ↓
8. Process response into formatted array
     ↓
9. Return $stories array
     ↓
10. Pass to view: $stories passed to blade
     ↓
11. Template: display.epicshots rendered
     ↓
12. Browser: Shows carousel of stories
```

---

## What It Gets from API

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
                        "imageUrl": "...",
                        "short_code": "story-slug",
                        ...
                    }
                ]
            }
        ]
    }
}
```

---

## What It Returns

```php
// All stories (no parameter)
[
    [
        'id' => 123,
        'title' => 'Story Title',
        'img_url' => 'https://...',
        'short_code' => 'story-slug'
    ],
    [
        'id' => 124,
        'title' => 'Another Story',
        'img_url' => 'https://...',
        'short_code' => 'another-slug'
    ]
]

// Specific story (with ID parameter)
{
    'ID' => 123,
    'title' => 'Story Title',
    'imageUrl' => '...',
    'short_code' => '...',
    // Full object...
}
```

---

## In Blade Template

```blade
@if (isset($stories) && $value['display_type'] == "shortandsweet")
    @include('display.epicshots', ['stories' => $stories])
@endif

<!-- In display/epicshots.blade.php -->
@if ($stories)
    @foreach ($stories as $story)
        <div onclick="showStory({{ $story['id'] }})">
            <img src="{{ $story['img_url'] }}" alt="{{ $story['title'] }}">
            <h3>{{ $story['title'] }}</h3>
        </div>
    @endforeach
@endif
```

---

## Related Functions

| Function | Purpose |
|----------|---------|
| `epicShots()` | Get all stories or specific story by ID |
| `epicShotsByShortCode()` | Get story by short code |
| `ajaxStoryData()` | Fetch story for modal popup |

---

## Key Differences

| Aspect | Epic Shots | Other Trays |
|--------|-----------|-----------|
| **Display Type** | "shortandsweet" | "trending", "special", etc. |
| **Data Source** | pages/stories API | homepage API response |
| **Format** | {id, title, img_url, short_code} | Content object |
| **Rendering** | Carousel with modals | Regular carousel |
| **API Call** | Separate call | Included in homepage |

---

## In Summary

- **Name:** `epicShots($story_id = "")`
- **Purpose:** Fetch short-form stories for "Short and Sweet" section
- **Called When:** `display_type == "shortandsweet"`
- **API:** `pages/stories`
- **Returns:** Array of formatted story objects
- **Template:** `display/epicshots.blade.php`
- **Displays As:** Carousel of story thumbnails with click-to-view modals
