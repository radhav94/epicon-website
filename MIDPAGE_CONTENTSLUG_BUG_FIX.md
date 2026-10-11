# ✅ Missing ContentSlug in Midpage Route - FIXED

## Problem

**Symptoms**: When clicking "See More" buttons on home page trays, the generated URL was missing the first segment (ContentSlug):

```
❌ WRONG: /midpage//only-on-epic-on-originals-limited-series/10/1782722305
✅ RIGHT: /midpage/home-v2/only-on-epic-on-originals-limited-series/10/1782722305
```

**Impact**: Empty first parameter causes route mismatch and potential 404 errors

---

## Root Cause

The `getMidPageUrl()` helper function in `app/Helpers/helpers.php` was trying to determine the current page slug (`$ContentSlug`) using multiple fallback strategies:

1. Explicitly passed `$pageSlug` parameter
2. Request attribute `pageSlug` set by controller
3. Request segment 1 (from URL path)
4. Default to empty string

**The Issue**: On the homepage:
- Route is `/` (home) or `/{slug}` 
- When rendering trays, `request()->segment(1)` returns `'pages'` (internal routing)
- This value gets filtered out as an invalid page slug
- `$ContentSlug` ends up empty
- URL generated: `/midpage//slug/catalog/id` (notice double slash)

---

## Solution

**File**: `app/Helpers/helpers.php` (Line 751-789)

**Key Change**: Added fallback to use `page_slug` from API data when `$ContentSlug` is empty

```php
// If ContentSlug is still empty, try to use page_slug from API data (fallback)
if (empty($ContentSlug) && !empty($value['page_slug'])) {
    $ContentSlug = $value['page_slug'];
}
```

### How It Works

The updated priority order for determining `$ContentSlug`:

1. **Explicitly passed parameter** - When view passes it directly
2. **Request attribute** - Set by controller for AJAX requests  
3. **URL segment** - For direct page navigation
4. **API data field** - `page_slug` from the tray/section data (NEW FALLBACK)

This ensures that even when other sources fail, the API's `page_slug` field provides the correct value.

---

## Updated Function

```php
function getMidPageUrl($value, $pageSlug = null)
{
    // 1. Try explicit parameter
    // 2. Try request attribute (set by controller)
    // 3. Try URL segment
    $ContentSlug = $pageSlug 
        ?? request()->attributes->get('pageSlug') 
        ?? request()->segment(1) 
        ?? '';

    // Filter out internal route segments
    if (in_array($ContentSlug, ['pages', 'page', 'loadmore', 'ajaxStoryData'])) {
        $ContentSlug = '';
    }
    
    // Handle Hindi language routes
    if ($ContentSlug === 'hi') {
        $ContentSlug = request()->attributes->get('pageSlug') ?? request()->segment(2) ?? '';
    }

    // NEW: Fallback to page_slug from API data when empty
    if (empty($ContentSlug) && !empty($value['page_slug'])) {
        $ContentSlug = $value['page_slug'];
    }

    // Generate URL...
    $midpage_prefix = '/midpage/';
    if (isKidsPage()) {
        $midpage_prefix = '/kids/midpage/';
    }
    $url = getUrl($midpage_prefix . ($ContentSlug.'/'.$value['slug'] ?? 'slug') . '/' . @$value['catalog'].'/'.@$value['ID']);
    
    // Handle reel content...
    if (!empty($value['content']) && is_array($value['content'])) {
        $firstItem = reset($value['content']);
        if (!empty($firstItem['is_reel'])) {
            $url .= '?is_reel=true';
        }
    }
    
    return $url;
}
```

---

## Testing

### Before Fix
```
Homepage → Click "See More" on tray
→ URL: /midpage//only-on-epic-on-originals-limited-series/10/1782722305
→ Result: Route not found or incorrect rendering
```

### After Fix  
```
Homepage → Click "See More" on tray
→ URL: /midpage/home-v2/only-on-epic-on-originals-limited-series/10/1782722305
→ Result: ✓ Midpage loads correctly with proper context
```

---

## Files Changed

- `app/Helpers/helpers.php` - Updated `getMidPageUrl()` function (lines 751-789)

---

## Affected Features

✅ "See More" buttons on all home page trays  
✅ "View All" links on content sections  
✅ Load more pagination on midpage  
✅ All tray types: trending, blockbuster, special, etc.  

---

## Backward Compatibility

✅ **Fully backward compatible**
- Only adds a fallback when all other methods fail
- Doesn't change behavior for existing working URLs
- Doesn't break any existing functionality

---

## Status

✅ **FIXED** - Home page tray links now generate correct URLs with proper ContentSlug parameter

