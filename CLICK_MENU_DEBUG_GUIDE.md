# Debug Guide: click_menu Function Console Logging

## Issue
The `click_menu()` function is being called from many places but `console.log()` is not printing in browser console.

## Solution Applied

### Enhanced Debugging Added to ga_tag.js

Updated the `click_menu()` function with detailed logging to track execution flow.

## What The Enhanced Debug Logs Show

### 1. Function Called
```
🚀 click_menu() called with element: <HTMLElement>
```
✅ Confirms function is being invoked

### 2. Element Data
```
📌 Element data: {event_context: "header", element_text: "Home"}
```
✅ Shows all data attributes from the clicked element

### 3. Extracted Values
```
📊 event_context: header
📝 element_text: Home
```
✅ Shows the extracted context and text values

### 4. Event Pushed
```
✅ click_menu event pushed to dataLayer
```
✅ Confirms GA dataLayer received the event

---

## How to Test

### Step 1: Open Browser Console
Press: F12 (or Cmd+Option+I on Mac)
Go to: Console tab

### Step 2: Navigate to Login Page
Click: Home link in login page or any menu item

### Step 3: Check Console Output

You should see messages like:
```
🚀 click_menu() called with element: <a>
📌 Element data: {event_context: "header", element_text: "Home"}
📊 event_context: header
📝 element_text: Home
✅ click_menu event pushed to dataLayer
```

---

## Common Issues & Fixes

### Issue 1: Console Not Showing Logs
**Cause**: Browser console not open
**Fix**: Press F12 and go to Console tab

### Issue 2: Blank Log Output  
**Cause**: Element doesn't have required data attributes
**Fix**: Check element has both `data-event_context` and `data-element_text`

### Issue 3: "Cannot read property 'reset'"
**Cause**: Google Tag Manager not loaded
**Fix**: Wait for GTM to load, error is caught anyway

---

## File Modified

- **File**: `public/assets/js/ga_tag.js`
- **Function**: `click_menu()`
- **Changes**: Enhanced with 6 debug console.log statements

---

## Next Steps

1. Open DevTools Console (F12)
2. Navigate to login page
3. Click any menu item
4. Watch console for debug messages
5. If no output, check error in console
6. Verify element has correct data attributes

✅ Enhanced debugging is now active!
