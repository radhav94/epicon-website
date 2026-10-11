# Continue Watching - Dedicated API Integration

## Overview
When the homepage API response includes `display_type: "continuewatching"`, the application now calls a dedicated `pages/continueWatching` API endpoint to fetch the actual continue watching data instead of using the generic tray data.

---

## API Endpoint Details

### Continue Watching API
- **Endpoint:** `pages/continueWatching`
- **Method:** `POST`
- **Auth:** Requires user Authorization token + x-access-auth-token
- **Query Params:** `profile_id`

### Curl Example
```bash
curl --location --request POST 'https://contentapistg-njsapi.epicon.in/index/pages/continueWatching?profile_id=16413556' \
  --header 'Authorization: eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJkYXRhIjp7InVzZXJfaWQiOjkxOTg2NzQ0Nzc3M30sImlhdCI6MTc4NzgyNTIwMSwiZXhwIjoxNzg3OTExNjAxfQ.QWNwwZAmp3Y1cazeLO_Wxfl4ZX5AMZ55dQkQr21nmQ0' \
  --header 'x-access-auth-token: szQDOyDaxsS0E4qeV1rMfpYBKnSWVESH'
```

---

## Implementation Flow

### 1. Homepage Data Fetch
When a user loads the homepage, the `PageController::index()` calls `homepageData()`:

```php
$data = $this->homepageData($slug);
$result = $data['result'];
```

### 2. Loop Through Display Types
The updated `homepageData()` now iterates through all trays:

```php
foreach ($lists as $key => $list) {
    // Handle shortandsweet stories
    if ($list['display_type'] == "shortandsweet") {
        $stories = $this->epicShots();
    }
    
    // Handle continue watching - fetch dedicated API
    if ($list['display_type'] == "continuewatching" && isUserLoggedIn()) {
        $continueWatchingData = $this->getContinueWatchingData();
        if ($continueWatchingData && @$continueWatchingData['success'] == true) {
            // Replace the generic continue watching tray with the dedicated API response
            $lists[$key]['content'] = @$continueWatchingData['data'] ?? [];
            $result['data']['list'][$key] = $lists[$key];
        }
    }
}
```

### 3. Call Dedicated Continue Watching API
When `display_type` is `"continuewatching"` and user is logged in:

```php
private function getContinueWatchingData()
{
    if (!isUserLoggedIn()) {
        return null;
    }

    $profileId = getProfileId();
    $params = [
        'profile_id' => $profileId
    ];

    \Log::channel('api')->info("getContinueWatchingData params: " . json_encode($params));

    // Call the dedicated continue watching API endpoint
    // Method: POST  
    // Requires: Authorization header (user token) + x-access-auth-token
    $result = CurlAPI("pages/continueWatching", "POST", $params, 1, true);

    if ($result && @$result['success'] == true) {
        \Log::channel('api')->info("Continue Watching API Success: " . json_encode($result));
        return $result;
    } else {
        \Log::channel('error_404')->debug('Continue Watching API Error: ' . json_encode($result));
        return null;
    }
}
```

### 4. Replace Generic Data with Dedicated API Response
```php
// Update the content array with data from dedicated API
$lists[$key]['content'] = @$continueWatchingData['data'] ?? [];

// Update the result object to reflect the change
$result['data']['list'][$key] = $lists[$key];
```

---

## CurlAPI Parameters Explained

The `CurlAPI()` function call:
```php
$result = CurlAPI("pages/continueWatching", "POST", $params, 1, true);
```

Parameters:
- `"pages/continueWatching"` - API endpoint path
- `"POST"` - HTTP method
- `$params` - Request parameters `['profile_id' => $profileId]`
- `1` - API domain (API_DOMAIN_1 from config)
- `true` - Send user Authorization token

When `true` is passed as the 5th parameter (`$sendUserToken`), the CurlAPI helper:
- Adds the Authorization header with the user's token
- Already includes x-access-auth-token from config

---

## Data Flow Diagram

```
┌─────────────────────────────────────────┐
│ 1. Homepage Load                        │
│    PageController::index()              │
└──────────────┬──────────────────────────┘
               │
               ▼
┌─────────────────────────────────────────┐
│ 2. Call homepageData($slug)             │
└──────────────┬──────────────────────────┘
               │
               ▼
┌─────────────────────────────────────────┐
│ 3. API Call: pages/homepage             │
│    Returns list with display_type items │
└──────────────┬──────────────────────────┘
               │
               ▼
┌─────────────────────────────────────────┐
│ 4. Loop Through $lists                  │
│    Check each display_type              │
└──────────────┬──────────────────────────┘
               │
      ┌────────┼────────┐
      │                 │
      ▼                 ▼
┌─────────────┐  ┌──────────────────────┐
│ shortand    │  │ continuewatching?    │
│ sweet?      │  └──────────────────────┘
└─────────────┘           │
      │            ┌──────┴──────┐
      │            │             │
      ▼            ▼             ▼
  Call Epic    User Logged   Return null
  Shots API    In?
               │
        ┌──────┴──────┐
        │             │
        ▼             ▼
      YES           NO
        │             │
        ▼             ▼
  ┌────────────────┐  Skip
  │ Call Continue  │
  │ Watching API   │
  └────────┬───────┘
           │
           ▼
  ┌─────────────────────┐
  │ Success?            │
  └────────┬────────────┘
           │
      ┌────┴────┐
      │          │
      ▼          ▼
    YES          NO
     │           │
     ▼           ▼
  Replace     Log
  Content     Error
  Array
     │
     ▼
  ┌──────────────────────────┐
  │ Update result['data']     │
  │ with new content          │
  └──────────────────────────┘
```

---

## Key Changes Made

### File: `app/Http/Controllers/PageController.php`

**1. Modified `homepageData()` function:**
- Changed `foreach ($lists as $list)` to `foreach ($lists as $key => $list)`
- Removed `break` statement (allow multiple special trays)
- Added check for `"continuewatching"` display type
- Calls new `getContinueWatchingData()` method when appropriate
- Replaces generic tray content with dedicated API response

**2. Added new `getContinueWatchingData()` function:**
- Checks if user is logged in (returns null otherwise)
- Gets the profile ID
- Calls `CurlAPI("pages/continueWatching", "POST", $params, 1, true)`
- Logs success/error responses
- Returns the API response or null on failure

---

## Response Format

### Success Response
```json
{
    "success": true,
    "data": [
        {
            "ID": 1782723687,
            "title": "Drama That Hits Home - S01E01",
            "slug": "drama-that-hits-home-ep1",
            "asset_type": "WATCH",
            "duration": 3600,
            "user_duration": 1200,
            "cover_image": {...},
            "url": "shows/drama-that-hits-home/season-1/episode-1",
            "is_reel": false,
            "promo_url": "https://..."
        },
        // ... more items
    ]
}
```

### Error Response
```json
{
    "success": false,
    "message": "Error message",
    "error": "Error details"
}
```

---

## Template Rendering

Once the data is replaced, the blade template (`display/continuewatching.blade.php`) renders normally:

```blade
@if (array_search("WATCH", array_column($value['content'], "asset_type")) !== false)
<div class="carousel-main">
    <div class="carousel-title-n-arrow px-2 mb-2">
        <h1 class="text-white">{{ $title }}</h1>
        @if (@$value['show_more'])
        <a href="{{ getMidPageUrl($value, $slug) }}">
            <!-- See All button -->
        </a>
        @endif
    </div>
    
    <ul class="carousel-initilize p-0">
        @foreach ($value['content'] as $key => $val)
            <!-- Render each item with progress bar -->
        @endforeach
    </ul>
</div>
@endif
```

---

## Logging

The implementation logs both API calls:

**Success Logs:**
```
Channel: api
Message: "Continue Watching API Success: {...}"
```

**Error Logs:**
```
Channel: error_404
Message: "Continue Watching API Error: {...}"
```

**Params Logs:**
```
Channel: api
Message: "getContinueWatchingData params: {"profile_id":"16413556"}"
```

---

## Conditions

The dedicated API is called only when:
1. ✅ `display_type == "continuewatching"` in the homepage response
2. ✅ User is logged in (`isUserLoggedIn()`)
3. ✅ API returns success response

If any condition fails, the generic continue watching tray from the main API is used.

---

## Testing

### Test with cURL
```bash
# Get token first (from login)
TOKEN="your_jwt_token_here"
PROFILE_ID="16413556"

curl -X POST "https://contentapistg-njsapi.epicon.in/index/pages/continueWatching?profile_id=$PROFILE_ID" \
  -H "Authorization: $TOKEN" \
  -H "x-access-auth-token: szQDOyDaxsS0E4qeV1rMfpYBKnSWVESH"
```

### Test in Application
1. Login as a user
2. Navigate to homepage
3. Check if "Continue Watching" tray appears
4. Open browser DevTools Network tab
5. Look for `pages/continueWatching` API call
6. Verify it receives proper Authorization and x-access-auth-token headers

---

## Backwards Compatibility

✅ **Fully backwards compatible**
- If `display_type` is not `"continuewatching"`, no changes
- If user is not logged in, uses generic tray data
- If dedicated API fails, falls back to generic data
- No changes to blade templates or template rendering logic
- All existing trays (trending, special, etc.) work unchanged

---

## Summary

| Aspect | Details |
|--------|---------|
| **Endpoint** | `pages/continueWatching` |
| **Method** | POST |
| **Trigger** | `display_type == "continuewatching"` |
| **Auth** | User Authorization + x-access-auth-token |
| **Function** | `PageController::getContinueWatchingData()` |
| **Called From** | `PageController::homepageData()` |
| **Response** | Array of continue watching items |
| **Logging** | api & error_404 channels |
| **Fallback** | Generic homepage tray data |
