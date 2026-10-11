# ✅ Branch Logo Click Tracking

## Implementation

Added Branch event tracking to the header logo click event.

### File Modified

**File**: `resources/views/layouts/header.blade.php`
**Line**: 333

### Change

**BEFORE**:
```html
<a onclick="click_menu(this)" data-event_context="header" data-element_text="Home" class="navbar-brand" aria-label="Logo" href="{{ getUrlWithPrefix('homepage') }}">
```

**AFTER**:
```html
<a onclick="click_menu(this); branch('track', 'logo_click');" data-event_context="header" data-element_text="Home" class="navbar-brand" aria-label="Logo" href="{{ getUrlWithPrefix('homepage') }}">
```

---

## What This Does

When a user clicks on the EPIC ON logo in the header, it now tracks the event with Branch:

```javascript
branch('track', 'logo_click');
```

### Event Details

| Property | Value |
|----------|-------|
| Event Name | `logo_click` |
| Trigger | Header logo click |
| Tracking Library | Branch.io |
| Location | Header navigation |

---

## How It Works

1. User clicks the EPIC ON logo
2. Both existing click handler (`click_menu`) and Branch tracking execute
3. Branch records the event with timestamp and user context
4. Event available in Branch Dashboard for analysis

---

## Verify It's Working

### In Branch Dashboard

1. Go to Branch Dashboard
2. Navigate to Analytics → Custom Events
3. Look for `logo_click` events
4. Check the event data, timestamps, and user context

---

## Related Configuration

- **Branch Script Location**: `resources/views/layouts/default.blade.php`
- **Branch Init Code**: 
```javascript
branch('init', 'YOUR_BRANCH_KEY');
```

---

## Testing

### Test Scenario

1. Load the EPIC ON website
2. Click the logo in the header
3. Check Branch Dashboard within 5 minutes
4. Verify `logo_click` event appears

### Expected Result

Event appears in Branch analytics with:
- Event name: `logo_click`
- Timestamp: current time
- User ID: authenticated user (if logged in) or anonymous
- Device info: browser, OS, etc.

---

## Status

✅ Logo click tracking is now **ACTIVE**
