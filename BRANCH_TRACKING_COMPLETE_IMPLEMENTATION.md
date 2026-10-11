# ✅ Branch Tracking Implementation - Complete

## Overview

Branch.io tracking has been added to track user interactions across login, registration, and all major user events on the EPIC ON platform.

---

## What Was Done

### 1. ✅ Branch Script Added to default.blade.php

**Location**: `resources/views/layouts/default.blade.php` (head section)

```html
<!-- Branch Script -->
<script>
(function(b,r,a,n,c,h,_){
    if(!b[n]){
        b[n]=function(){b[n].q.push(arguments)};
        b[n].q=[];
    }
    h=r.createElement('script');
    h.async=1;
    h.src=a;
    _=r.getElementsByTagName('script')[0];
    _.parentNode.insertBefore(h,_);
})(window,document,'https://cdn.branch.io/branch-latest.min.js','branch');

branch('init', 'YOUR_BRANCH_KEY');
</script>
```

**Why**: Global availability across all pages (login, registration, homepage, etc.)

### 2. ✅ Branch Event Tracking Function

**Location**: `resources/views/layouts/default.blade.php` (before closing body)

```javascript
<script>
// Global function to track Branch events
window.trackBranchEvent = function(eventName, eventData) {
    try {
        if (typeof branch === 'undefined') {
            console.warn('Branch SDK not loaded yet');
            return;
        }
        
        branch.track(eventName, eventData, function(err) {
            if (err) {
                console.error('Branch track error:', err);
            }
        });
    } catch (error) {
        console.error('Branch tracking error:', error);
    }
};
</script>
```

### 3. ✅ Branch Events Already Added to ga_tag.js

**File**: `public/assets/js/ga_tag.js`

#### Events Currently Tracking Branch:

✅ **Login & Registration**:
- `login_start()` → Branch event: "login_start"
- `login_success()` → Branch event: "login_success"
- `login_failed()` → Branch event: "login_failed"
- `login_skip()` → Branch event: "login_skip"
- `registration_start()` → Branch event: "registration_start"
- `registration_success()` → Branch event: "registration_success"
- `registration_failed()` → Branch event: "registration_failed"
- `registration_skip()` → Branch event: "registration_skip"

✅ **Navigation**:
- `click_menu()` → Branch event: "click_menu"

---

## Pattern for Branch Event Tracking

All tracking follows this pattern in ga_tag.js:

```javascript
function click_menu(e) {
    // Existing GA tracking
    window.google_tag_manager["G-8JER642T3Z"].dataLayer.reset();
    var a = $(e).data("event_context"),
        t = $(e).data("element_text");
    window.dataLayer.push({ 
        event: "click_menu", 
        event_context: a, 
        element_text: t
    });

    // ✅ NEW: Branch Event Tracking
    if (typeof window.trackBranchEvent === 'function') {
        window.trackBranchEvent("click_menu", {
            event_context: a,
            element_text: t,
            timestamp: new Date().toISOString()
        });
    }
}
```

---

## How to Add Branch Tracking to Remaining Functions

### For Each Function, Add This Pattern

```javascript
// ✅ Track Branch Event
if (typeof window.trackBranchEvent === 'function') {
    window.trackBranchEvent("event_name", {
        param1: value1,
        param2: value2,
        timestamp: new Date().toISOString()
    });
}
```

### Functions Needing Branch Tracking

**UI Interactions**:
- `click_social()` - Social media clicks
- `click_subscription()` - Subscription selections
- `click_carousel()` - Carousel interactions
- `share()` - Share actions
- `click_tile()` - Tile/card clicks
- `click_explore()` - Explore button clicks
- `click_teams()` - Team/player clicks
- `outbound_click()` - Outbound links
- `click_cta()` - CTA button clicks
- `click_player()` - Player interactions

**Search**:
- `searchEvent()` - Search submissions
- `click_search_results()` - Search result clicks

**Video/Audio**:
- `video_play()`, `video_pause()`, `video_seek()`, `video_ended()`
- `audio_play()`, `audio_pause()`, `audio_seek()`, `audio_ended()`

**Other**:
- `click_spinner()` - Spinner interactions
- `file_download()` - File downloads

---

## Configuration

Update Branch Key in `resources/views/layouts/default.blade.php`:

```javascript
branch('init', 'key_live_xxxxx');  // Replace with your Branch key
```

Get your Branch key from [Branch Dashboard](https://dashboard.branch.io/settings/app)

---

## Testing

### Verify Branch Loaded

```javascript
console.log(typeof window.branch);  // Should be "object"
console.log(typeof window.trackBranchEvent);  // Should be "function"
```

### Test Event Tracking

```javascript
window.trackBranchEvent("login_success", {
    timestamp: new Date().toISOString()
});
```

### Monitor Events

Visit [Branch Dashboard Events](https://dashboard.branch.io/liveview/events) to see real-time events.

---

## Status

✅ Core Branch tracking implemented  
✅ Login/Registration events tracking  
✅ Menu navigation tracking  
⏳ Remaining UI interactions ready for expansion  

