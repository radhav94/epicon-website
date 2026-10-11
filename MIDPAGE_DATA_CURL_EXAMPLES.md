# Midpage Data API - Curl Call Examples

## API Endpoint
```
GET https://contentapistg-njsapi.epicon.in/index/pages/midpageData
```

## Overview
The `pages/midpageData` endpoint is used to fetch paginated content data for midpage listings. It's called from the PageController's `showmidpagedetail()` method.

---

## Basic Curl Call (Terminal/Command Line)

### Standard GET Request
```bash
curl -X GET "https://contentapistg-njsapi.epicon.in/index/pages/midpageData?catalogId=10&limit=20&page=1&pageSlug=drama-that-hits-home&trayID=10" \
  -H "x-access-auth-token: szQDOyDaxsS0E4qeV1rMfpYBKnSWVESH" \
  -H "Content-Type: application/x-www-form-urlencoded"
```

### With Reel Parameter
```bash
curl -X GET "https://contentapistg-njsapi.epicon.in/index/pages/midpageData?catalogId=10&limit=20&page=1&pageSlug=drama-that-hits-home&trayID=10&is_reel=true" \
  -H "x-access-auth-token: szQDOyDaxsS0E4qeV1rMfpYBKnSWVESH" \
  -H "Content-Type: application/x-www-form-urlencoded"
```

---

## PHP Implementation (Using CurlAPI Helper)

### In Controller
```php
<?php
// Method 1: Using the CurlAPI helper function
$apiParams = [
    'catalogId' => $catalog,
    'limit' => 20,
    'page' => 1,
    'pageSlug' => 'drama-that-hits-home',
    'trayID' => $trayID
];

// Add is_reel parameter if needed
if ($is_reel) {
    $apiParams['is_reel'] = 'true';
}

$epicwebArr = CurlAPI("pages/midpageData", "GET", $apiParams, 1);

// Check response
if (isset($epicwebArr) && @$epicwebArr['success'] == true) {
    $pagination = $epicwebArr['pagination'] ?? [];
    $data = @$epicwebArr['data'];
    dd($data); // Debug output
} else {
    Log::channel('error_404')->debug('Error: ' . json_encode($epicwebArr));
}
?>
```

### Standalone cURL Implementation (PHP)
```php
<?php
// Standalone cURL call without using the CurlAPI helper
$apiParams = [
    'catalogId' => 10,
    'limit' => 20,
    'page' => 1,
    'pageSlug' => 'drama-that-hits-home',
    'trayID' => 10,
    'is_reel' => 'true'
];

$url = 'https://contentapistg-njsapi.epicon.in/index/pages/midpageData?' . http_build_query($apiParams);

$curl = curl_init();
curl_setopt_array($curl, array(
    CURLOPT_URL => $url,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 120,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'GET',
    CURLOPT_HTTPHEADER => array(
        'x-access-auth-token: szQDOyDaxsS0E4qeV1rMfpYBKnSWVESH',
        'Content-Type: application/x-www-form-urlencoded'
    ),
));

$response = curl_exec($curl);
$curl_errno = curl_errno($curl);
$http_status = curl_getinfo($curl);
curl_close($curl);

if ($curl_errno > 0) {
    $curl_error = curl_error($curl);
    echo "cURL error: $curl_error";
} else {
    $responseData = json_decode($response, true);
    
    if ($responseData && @$responseData['success'] == true) {
        $pagination = $responseData['pagination'] ?? [];
        $data = @$responseData['data'];
        
        echo "Success! Got " . count($data) . " items";
        print_r($data);
    } else {
        echo "API Error: " . json_encode($responseData);
    }
}
?>
```

---

## Query Parameters

| Parameter | Type | Required | Description | Example |
|-----------|------|----------|-------------|---------|
| `catalogId` | String/Int | Yes | The catalog/tray ID to fetch | `10` |
| `limit` | Int | Yes | Number of items per page | `20` |
| `page` | Int | Yes | Page number for pagination | `1` |
| `pageSlug` | String | Yes | The slug of the page/tray | `drama-that-hits-home` |
| `trayID` | String/Int | Yes | Tray ID (often same as catalogId) | `10` |
| `is_reel` | String | No | Set to 'true' for reel content | `true` |

---

## Response Format

### Success Response
```json
{
    "success": true,
    "data": [
        {
            "ID": 1782723687,
            "title": "Content Title",
            "slug": "content-slug",
            "catalog": "10",
            "is_premium": true,
            "free_premium": false,
            "short_description": "A brief description",
            "cover_image": {
                "original": "https://...",
                "small": "https://...",
                "medium": "https://...",
                "large": "https://..."
            },
            "url": "shows/content-slug/season-1/episode-1"
        }
        // ... more items
    ],
    "pagination": {
        "currentPage": 1,
        "hasNextPage": true,
        "totalPages": 5,
        "totalItems": 100
    }
}
```

### Error Response
```json
{
    "success": false,
    "message": "Error occurred",
    "error": "Details about the error"
}
```

---

## Common Issues & Debugging

### Issue: Double Slash in URL (`//`)
**Problem:** URL appears as `/midpage//drama-that-hits-home/10/1782723687`

**Solution:** This is fixed in the helper function. The `getMidPageUrl()` function now ensures proper slug handling by:
- Always adding a default slug ('home-v2') if empty
- Properly concatenating the path segments

### Issue: Missing Reel Content
**Problem:** Reel content not loading or shows error

**Solution:** Add the `is_reel=true` parameter to the query string:
```bash
curl -X GET "https://contentapistg-njsapi.epicon.in/index/pages/midpageData?catalogId=10&limit=20&page=1&pageSlug=drama-that-hits-home&trayID=10&is_reel=true"
```

### Issue: Authentication Failed
**Problem:** Response shows authentication error

**Solution:** Ensure the auth token is included in headers:
```bash
-H "x-access-auth-token: szQDOyDaxsS0E4qeV1rMfpYBKnSWVESH"
```

---

## API Domains by Environment

| Environment | Domain | Config Key |
|-------------|--------|-----------|
| DEV | `https://contentapistg-njsapi.epicon.in/index/` | API_DOMAIN_1 |
| STAGE | `https://contentapistg-njsapi.epicon.in/index/` | API_DOMAIN_1 |
| PRODUCTION | `https://contentapiprod-njsapi.epicon.in/index/` | API_DOMAIN_1 |

---

## Integration with PageController

### In `showmidpagedetail()` Method
```php
public function showmidpagedetail(Request $request, $pageslug, $catalog = null, $ContentSlug = null, $trayID = null, $redirect = 'other')
{
    $page = 1;
    $limit = 14;
    $perpage = 20;
    $is_reel_input = $request->input('is_reel', false);
    $is_reel = ($is_reel_input === true || $is_reel_input === 'true');
    
    if (!$request->is_hybrid) {
        if ($redirect == 'explore') {
            // Explore page uses different endpoint
            $url = "pages/midpage/{$pageslug}";
            $apiParams = ['page' => 1, 'catalog_slug' => $catalog, 'view_all' => 'true'];
            if ($is_reel) {
                $apiParams['is_reel'] = 'true';
            }
            $epicwebArr = CurlAPI($url, "GET", $apiParams, 1);
        } else {
            // Standard midpage uses pages/midpageData endpoint
            $apiParams = [
                'catalogId' => $catalog,
                'limit' => $perpage,
                'page' => 1,
                'pageSlug' => @$ContentSlug,
                'trayID' => $trayID
            ];
            if ($is_reel) {
                $apiParams['is_reel'] = 'true';
            }
            $epicwebArr = CurlAPI("pages/midpageData", "GET", $apiParams, 1);
        }
    }
    
    if (isset($epicwebArr) && @$epicwebArr['success'] == true) {
        $pagination = $epicwebArr['pagination'] ?? [];
        $epicwebArr = @$epicwebArr['data'];
        return view('pages.midpage', compact('epicwebArr', 'pageslug', 'catalog', 'page', 'perpage', 'pagination', 'is_reel'));
    }
}
```

---

## Testing the Endpoint

### Using cURL in Terminal
```bash
# Test basic call
curl -X GET "https://contentapistg-njsapi.epicon.in/index/pages/midpageData?catalogId=10&limit=5&page=1&pageSlug=drama-that-hits-home&trayID=10" \
  -H "x-access-auth-token: szQDOyDaxsS0E4qeV1rMfpYBKnSWVESH"

# Pretty print JSON response
curl -s -X GET "https://contentapistg-njsapi.epicon.in/index/pages/midpageData?catalogId=10&limit=5&page=1&pageSlug=drama-that-hits-home&trayID=10" \
  -H "x-access-auth-token: szQDOyDaxsS0E4qeV1rMfpYBKnSWVESH" | jq .
```

### Using Postman
1. Create new request
2. Set method to `GET`
3. URL: `https://contentapistg-njsapi.epicon.in/index/pages/midpageData`
4. Add query parameters in the "Params" tab
5. Add header: `x-access-auth-token: szQDOyDaxsS0E4qeV1rMfpYBKnSWVESH`
6. Click "Send"

---

## References
- API Config: `config/epicconfig.php`
- API Helper: `app/Helpers/api_helpers.php` (CurlAPI function)
- Controller: `app/Http/Controllers/PageController.php`
- Helper Functions: `app/Helpers/helpers.php` (getMidPageUrl, etc.)
