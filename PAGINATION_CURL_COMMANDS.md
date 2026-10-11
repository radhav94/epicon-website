# Pagination API CURL Commands for is_reel Parameter Testing

## Environment Configuration

Based on your `config/epicconfig.php`:

- **Staging Base URL:** `http://contentapistg-njsapi.epicon.in/index/`
- **Auth Token:** `szQDOyDaxsS0E4qeV1rMfpYBKnSWVESH`

---

## 1. Testing Non-Reel Content Pagination (is_reel = false)

### Show More - Non-Reel Content (Horizontal Layout)
```bash
curl -X POST 'http://epicon-web.test/paginatecontent' \
  -H 'Content-Type: application/x-www-form-urlencoded' \
  -H 'X-CSRF-TOKEN: your-csrf-token-here' \
  -H 'X-Requested-With: XMLHttpRequest' \
  -d 'page=2&catalogid=your-catalog-id&pageslug=your-page-slug&mainslug=your-main-slug&is_reel=false'
```

### Response (Expected)
```json
{
  "paginateHTML": "<li>..card markup..</li>...",
  "dataCount": 14,
  "limit": 14,
  "hasNextPage": true
}
```

---

## 2. Testing Reel Content Pagination (is_reel = true)

### Show More - Reel Content (Vertical Layout)
```bash
curl -X POST 'http://epicon-web.test/paginatecontent' \
  -H 'Content-Type: application/x-www-form-urlencoded' \
  -H 'X-CSRF-TOKEN: your-csrf-token-here' \
  -H 'X-Requested-With: XMLHttpRequest' \
  -d 'page=2&catalogid=your-catalog-id&pageslug=your-page-slug&mainslug=your-main-slug&is_reel=true'
```

### Response (Expected)
```json
{
  "paginateHTML": "<li>..vertical card markup..</li>...",
  "dataCount": 14,
  "limit": 14,
  "hasNextPage": true
}
```

---

## 3. Backend API Calls (Direct Content API)

### Non-Reel Content - Pages/Midpage Endpoint
```bash
curl -X GET 'http://contentapistg-njsapi.epicon.in/index/pages/midpage/your-page-slug' \
  -H 'x-access-auth-token: szQDOyDaxsS0E4qeV1rMfpYBKnSWVESH' \
  -d 'page=1&catalog_slug=your-catalog&view_all=true'
```

### Reel Content - Pages/Midpage Endpoint (with is_reel parameter)
```bash
curl -X GET 'http://contentapistg-njsapi.epicon.in/index/pages/midpage/your-page-slug' \
  -H 'x-access-auth-token: szQDOyDaxsS0E4qeV1rMfpYBKnSWVESH' \
  -d 'page=1&catalog_slug=your-catalog&view_all=true&is_reel=true'
```

### Non-Reel Content - Pages/Midpage Data Endpoint
```bash
curl -X GET 'http://contentapistg-njsapi.epicon.in/index/pages/midpageData' \
  -H 'x-access-auth-token: szQDOyDaxsS0E4qeV1rMfpYBKnSWVESH' \
  -d 'catalogId=your-catalog-id&limit=14&page=1'
```

### Reel Content - Pages/Midpage Data Endpoint (with is_reel parameter)
```bash
curl -X GET 'http://contentapistg-njsapi.epicon.in/index/pages/midpageData' \
  -H 'x-access-auth-token: szQDOyDaxsS0E4qeV1rMfpYBKnSWVESH' \
  -d 'catalogId=your-catalog-id&limit=14&page=1&is_reel=true'
```

---

## 4. Using curl with Query Parameters (Alternative Format)

### Frontend Pagination - Page 2, Non-Reel
```bash
curl -X POST 'http://epicon-web.test/paginatecontent' \
  -H 'Content-Type: application/x-www-form-urlencoded' \
  -H 'X-CSRF-TOKEN: your-csrf-token' \
  -H 'X-Requested-With: XMLHttpRequest' \
  --data-urlencode 'page=2' \
  --data-urlencode 'catalogid=123' \
  --data-urlencode 'pageslug=test-page' \
  --data-urlencode 'mainslug=explore' \
  --data-urlencode 'is_reel=false'
```

### Frontend Pagination - Page 3, Reel Content
```bash
curl -X POST 'http://epicon-web.test/paginatecontent' \
  -H 'Content-Type: application/x-www-form-urlencoded' \
  -H 'X-CSRF-TOKEN: your-csrf-token' \
  -H 'X-Requested-With: XMLHttpRequest' \
  --data-urlencode 'page=3' \
  --data-urlencode 'catalogid=456' \
  --data-urlencode 'pageslug=reel-page' \
  --data-urlencode 'mainslug=explore' \
  --data-urlencode 'is_reel=true'
```

---

## 5. cURL with Cookies (If Session Authentication Required)

```bash
curl -X POST 'http://epicon-web.test/paginatecontent' \
  -H 'Content-Type: application/x-www-form-urlencoded' \
  -H 'X-CSRF-TOKEN: your-csrf-token' \
  -H 'X-Requested-With: XMLHttpRequest' \
  -b 'PHPSESSID=your-session-id' \
  -d 'page=2&catalogid=123&pageslug=test&mainslug=explore&is_reel=true'
```

---

## 6. Expected Response Structure

### Success Response
```json
{
  "paginateHTML": "<li class=\"cards-list\">...</li><li class=\"cards-list\">...</li>",
  "dataCount": 14,
  "limit": 14,
  "hasNextPage": true
}
```

### Error Response
```json
{
  "paginateHTML": "false",
  "dataCount": "",
  "limit": 14,
  "hasNextPage": false
}
```

---

## 7. Testing Checklist

### Non-Reel Content Tests
- [ ] Page 1 without is_reel parameter → Should use cover_image (horizontal)
- [ ] Page 1 with is_reel=false → Should use cover_image (horizontal)
- [ ] Page 2 without is_reel parameter → Should use cover_image (horizontal)
- [ ] Page 2 with is_reel=false → Should use cover_image (horizontal)
- [ ] Verify images are horizontal (landscape format)

### Reel Content Tests
- [ ] Page 1 with is_reel=true → Should use vertical_cover_image (vertical)
- [ ] Page 2 with is_reel=true → Should use vertical_cover_image (vertical)
- [ ] Page 3 with is_reel=true → Should use vertical_cover_image (vertical)
- [ ] Verify images are vertical (portrait format)
- [ ] Verify card layout is vertical grid

### Play Content Tests
- [ ] PLAY content with is_reel=true → Should still use cover_image
- [ ] PLAY content without is_reel → Should use cover_image
- [ ] Verify PLAY content always horizontal

---

## 8. Using Postman

**Method:** POST
**URL:** `http://epicon-web.test/paginatecontent`

**Headers:**
```
Content-Type: application/x-www-form-urlencoded
X-CSRF-TOKEN: your-csrf-token
X-Requested-With: XMLHttpRequest
```

**Body (form-data):**
```
page: 2
catalogid: 123
pageslug: your-page-slug
mainslug: explore
is_reel: true
```

---

## 9. JavaScript Fetch Example

```javascript
// Fetch next page of reel content
fetch('/paginatecontent', {
  method: 'POST',
  headers: {
    'Content-Type': 'application/x-www-form-urlencoded',
    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
    'X-Requested-With': 'XMLHttpRequest'
  },
  body: new URLSearchParams({
    page: 2,
    catalogid: '123',
    pageslug: 'my-page',
    mainslug: 'explore',
    is_reel: 'true'
  })
})
.then(response => response.json())
.then(data => {
  console.log('HTML:', data.paginateHTML);
  console.log('Count:', data.dataCount);
  console.log('Has Next:', data.hasNextPage);
});
```

---

## 10. Key Parameters

| Parameter | Required | Values | Description |
|-----------|----------|--------|-------------|
| `page` | Yes | 1, 2, 3... | Page number for pagination |
| `catalogid` | Yes | numeric | Catalog/Collection ID |
| `pageslug` | Yes | string | Page slug identifier |
| `mainslug` | Yes | string | Main menu slug (explore, detail, etc.) |
| `is_reel` | No | true/false | Whether content is reel (vertical layout) |

---

## 11. Image Selection Logic

### When is_reel = false or asset_type = 'PLAY'
```
Selected Image: cover_image
Layout: Horizontal
Size: Large
Format: Landscape (wider than tall)
```

### When is_reel = true and asset_type != 'PLAY'
```
Selected Image: vertical_cover_image (fallback to cover_image if not available)
Layout: Vertical Grid
Format: Portrait (taller than wide)
```

---

## Notes

1. **CSRF Token:** Replace `your-csrf-token` with actual token from your session
2. **Session:** Ensure you're authenticated (have valid session cookie)
3. **API Domains:** Update base URLs based on your environment (dev/stage/prod)
4. **Catalog IDs:** Get from your database or API response
5. **Testing:** Use browser DevTools Network tab to capture actual requests
6. **Response Size:** Large paginations may return big HTML strings
