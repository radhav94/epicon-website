# Branch Events Debugging Guide

## ✅ What Was Fixed

### 1. **Development Domain Restriction** ❌→✅
- **Problem**: Branch SDK only loaded on production domains (epicon.in)
- **Solution**: Added localhost, 127.0.0.1, and any domain with 'dev', 'staging', 'local' in name
- **File**: `/resources/views/layouts/default.blade.php` (lines 86-104)

### 2. **Event Retry Logic** ❌→✅
- **Problem**: Events failed silently if Branch SDK wasn't ready when onclick handler fired
- **Solution**: Multi-retry system with exponential backoff (200ms → 400ms → 600ms → 800ms → 1000ms)
- **Max Retries**: 5 attempts before giving up
- **File**: `/resources/views/layouts/default.blade.php` (lines 177-229)

### 3. **Initialization Flag** ❌→✅
- **Problem**: No way to check if Branch was initialized
- **Solution**: Added `window._branchInitialized` flag set in init callback
- **File**: `/resources/views/layouts/default.blade.php` (lines 145, 149)

### 4. **Error Logging** ❌→✅
- **Problem**: Errors silently swallowed by empty catch blocks
- **Solution**: All catch blocks now log errors to console
- **Files**: `/public/assets/js/ga_tag.js`

### 5. **Test Helper Function** ❌→✅
- **Added**: `window.testBranchEvents()` helper function
- **Usage**: Run in browser console to test all event types
- **File**: `/resources/views/layouts/default.blade.php` (lines 231-267)

---

## 🔍 How to Test

### Step 1: Check Page Load
Open browser DevTools (F12) → Console tab

You should see:
```
✅ Branch SDK will load on domain: localhost
✅ Branch SDK loaded successfully
✅ Branch SDK initialized successfully
✅ Branch page_view_test sent successfully
```

### Step 2: Test Event Functions
In browser console, run:
```javascript
window.testBranchEvents()
```

You should see:
```
🧪 === BRANCH EVENTS TEST ===
✅ Branch SDK loaded: true
✅ Branch initialized: true
✅ trackBranchEvent available: true

📤 Testing page_view_test event...
✅ Branch event sent successfully: page_view_test

📤 Testing click_menu event...
✅ Branch event sent successfully: click_menu

📤 Testing login_start event...
✅ Branch event sent successfully: login_start
```

### Step 3: Test Real User Interactions

#### Test click_menu (Menu Click)
1. Click any menu item (Home, Subscribe, Games, etc.)
2. In console you should see:
```
📤 Branch event called: click_menu {...}
📨 Sending event to Branch immediately: click_menu
✅ Branch event sent successfully: click_menu
```

#### Test login_start (Login Button)
1. Click login button
2. In console you should see:
```
📤 Branch event called: login_start {...}
📨 Sending event to Branch immediately: login_start
✅ Branch event sent successfully: login_start
```

### Step 4: Verify Network Requests
1. Open DevTools → Network tab
2. Filter for: `api2.branch.io`
3. You should see POST requests for each event
4. Click each request and check Response tab for `"success": true`

---

## 📊 Event Flow Diagram

```
User clicks button (e.g., menu item)
        ↓
onclick="click_menu(this)" handler fires
        ↓
ga_tag.js click_menu() function called
        ↓
window.trackBranchEvent("click_menu", {...}) called
        ↓
Is Branch SDK available?
    ├─ YES → branch.logEvent() called immediately ✅
    └─ NO → Retry logic activates (5 attempts with backoff)
        ↓
    After 200ms: Check again
    If YES → branch.logEvent() called ✅
    If NO → Wait 400ms and retry...
```

---

## 🚨 Troubleshooting

### Event sent but "❌ Branch event failed:" error
- Check console for error message details
- May be a network issue or invalid Branch key
- Check `/public/assets/js/ga_tag.js` that `window.trackBranchEvent` is being called

### Nothing happens when clicking (silent failure)
- Check if `window.branch` exists: `console.log(typeof window.branch)`
- Check if initialized: `console.log(window._branchInitialized)`
- Check if trackBranchEvent exists: `console.log(typeof window.trackBranchEvent)`
- Run `window.testBranchEvents()` to test directly

### Events only work sometimes (intermittent)
- Normal on slow connections - retry logic kicks in
- Watch console for "⚠️ Branch SDK not available yet" warnings
- Should retry and eventually succeed

### Getting "⚠️ Branch SDK skipped" message
- You're on a domain that's NOT in the whitelist
- Add your domain to line 93 in default.blade.php:
```javascript
var isAllowedDomain = host === 'www.epicon.in' || 
                     host === 'epicon.in' || 
                     host === 'devepicon-v3.epicon.in' ||
                     host === 'your-domain-here.local';  // Add here
```

---

## 📋 Event Types Supported

### Authentication Events
- `login_start` - When login modal opens
- `login_success` - After successful login
- `login_failed` - Failed login attempt
- `login_skip` - User skips login

### Navigation Events
- `click_menu` - Any menu click
- `click_social` - Social media link click
- `click_search` - Search performed

### Content Events
- `page_view_test` - Page load (test event)
- `video_start` - Video player starts
- `video_pause` - Video paused
- `video_resume` - Video resumed
- `share` - Content shared

### Form Events
- `form_submit` - Any form submission
- `form_error` - Form validation error

---

## 💾 Files Modified

1. `/resources/views/layouts/default.blade.php`
   - Added domain whitelist (development support)
   - Enhanced trackBranchEvent with retry logic
   - Added _branchInitialized flag
   - Added testBranchEvents() helper

2. `/public/assets/js/ga_tag.js`
   - Added error logging to catch blocks
   - All event functions call trackBranchEvent

3. `/resources/views/layouts/header.blade.php`
   - onclick="click_menu(this)" handlers already present

4. `/resources/views/auth/login-reg-popup.blade.php`
   - onclick="login_start(this)" handlers already present

---

## 🎯 Expected Results After Fixes

✅ page_view_test fires on every page load  
✅ click_menu fires when any menu item clicked  
✅ login_start fires when login button clicked  
✅ All other events trigger on their respective user actions  
✅ Events retry automatically if timing issue occurs  
✅ Browser console shows detailed logging for debugging  
✅ Branch API receives all events with proper metadata  

