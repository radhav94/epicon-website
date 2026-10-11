# Player Stuck Detection - Enhanced Loader Handling

## Overview

The player loader now has **intelligent stuck detection** to properly handle cases where the video gets stuck or stops buffering data.

---

## How It Works

### Three Timeout Layers

The system uses three different timeout mechanisms to handle stuck videos:

#### 1. **Stuck Detection (15 seconds)**
- Starts when loader shows (waiting event fires)
- After 15 seconds without data, spinner color changes to **orange**
- User sees visual feedback that something is wrong
- Loader remains visible so user knows it's buffering

```javascript
var STUCK_THRESHOLD = 15000; // 15 seconds
stuckTimeout = setTimeout(function() {
    console.warn('⚠️ Video appears to be stuck - loader shown for 15+ seconds');
    loaderEl.classList.add('stuck');
}, STUCK_THRESHOLD);
```

#### 2. **Progress Reset Timer**
- Resets if data arrives (progress event fires)
- Shows that network is working, just slow
- Only applies when waiting and not already marked stuck
- Keeps spinner white while data is flowing

```javascript
videoEl.addEventListener('progress', function() {
    if (loaderEl.classList.contains('show') && !loaderEl.classList.contains('stuck')) {
        clearTimeout(stuckTimeout);
        // Reset timer - give it another 15 seconds
        stuckTimeout = setTimeout(..., STUCK_THRESHOLD);
    }
});
```

#### 3. **Force Hide (30 seconds)**
- Absolute maximum - always hides loader after 30 seconds
- Prevents infinite spinning loader
- Even if stuck, user can see video/continue interaction
- Backup safety mechanism

```javascript
var AUTO_HIDE_THRESHOLD = 30000; // 30 seconds
loaderTimeout = setTimeout(function() {
    console.log('⏱️ Loader timeout (30s) - auto-hiding to prevent stuck spinner');
    loaderEl.classList.remove('show');
    loaderEl.classList.remove('stuck');
}, AUTO_HIDE_THRESHOLD);
```

---

## Visual States

### Scenario 1: Normal Buffering (0-15 seconds)
```
Timeline:
  0s: waiting event → loader shows (white spinner)
  5s: progress event → data arriving, reset timer
 10s: still buffering...
 15s: no 'canplay' yet, but data flowing → spinner stays WHITE
```

**Visual**: White spinning indicator
**Message**: "Video buffering..."

---

### Scenario 2: Stuck Video (15-30 seconds)
```
Timeline:
  0s: waiting event → loader shows (white spinner)
  8s: no progress event fires → stuck detection activates
 15s: STUCK! → spinner turns ORANGE
 20s: still stuck, but keeps spinning
 30s: FORCE HIDE → loader disappears
```

**Visual at 15s**: Orange spinning indicator (visual warning)
**Visual at 30s**: Loader disappears automatically
**Console**: Warning message at 15s and 30s

---

### Scenario 3: Quick Recovery
```
Timeline:
  0s: waiting event → loader shows (white spinner)
  3s: progress event → data arriving
  7s: canplay event → DATA READY
  8s: All timeouts cleared, loader hides
```

**Visual**: Spinner briefly shows, then disappears
**Console**: "✅ Video can play - hiding loader"

---

### Scenario 4: Seek Buffering
```
Timeline:
  0s: User seeks → seeking event fires, stuck timeout cleared
  1s: Video buffering (waiting event)
  4s: seeked event → loader hides immediately
```

**Visual**: Spinner appears briefly during seek
**Console**: "✔️ Seek complete - hiding loader"

---

## Event Handlers

| Event | Action | Stuck Status |
|-------|--------|--------------|
| `waiting` | Show loader, start 15s stuck timer, start 30s force hide timer | Waiting |
| `canplay` | Hide loader, clear all timers | Clear |
| `canplaythrough` | Hide loader, clear all timers | Clear |
| `play` | Hide loader, clear all timers | Clear |
| `seeking` | Show loader, clear stuck timer, keep force hide | Seeking |
| `seeked` | Hide loader, clear all timers | Clear |
| `progress` | Reset stuck timer if data flowing | Refresh |
| `error` | Hide loader immediately | Error |
| `loadstart` | Clear all timers | Reset |

---

## Console Output Timeline

### Normal Buffering
```
📹 Video waiting for data - showing loader
✅ Video can play - hiding loader
```

### Stuck Detection
```
📹 Video waiting for data - showing loader
(15 seconds pass with no progress)
⚠️ Video appears to be stuck - loader shown for 15+ seconds
(15 more seconds pass)
⏱️ Loader timeout (30s) - auto-hiding to prevent stuck spinner
```

### Seeking
```
🔍 Video seeking - showing loader
✔️ Seek complete - hiding loader
```

### Error
```
❌ Video error - hiding loader
```

---

## Spinner Color Changes

### White Spinner (Normal Buffering)
- Default state
- Shows when waiting but data is flowing
- `border-top-color: #fff` and `border-right-color: rgba(255, 255, 255, 0.2)`

### Orange Spinner (Stuck Warning)
- Applied after 15 seconds with no data
- Visual indicator to user that something is wrong
- `border-top-color: #ff9500` (orange)
- `border-right-color: #ff9500` (orange)

```css
.player-loader.stuck .player-loader__spinner {
    border-top-color: #ff9500;  /* Orange warning color */
    border-right-color: #ff9500;
}
```

---

## Handling Stuck Scenarios

### Scenario: Video URL is Wrong
```
Timeline:
  0s: Video tries to load
  15s: Spinner turns orange (stuck)
  30s: Loader auto-hides
Result: User sees orange warning, then video disappears
Expected: User knows it's stuck, can go back or try again
```

### Scenario: Network is Very Slow
```
Timeline:
  0s: Video starts buffering (slow network)
  5s: progress event fires (some data arriving)
  8s: stuck timer resets (another 15s window)
 20s: canplay event finally fires
Result: Loader shows for ~20s (white), then hides when ready
```

### Scenario: Video Gets Stuck Mid-Playback
```
Timeline:
  User playing normally
  Network dies
  waiting event fires
  15s: Spinner turns orange
  30s: Force hides
Result: User is warned with orange spinner, can retry or go back
```

---

## Benefits of This Approach

✅ **No Infinite Spinners** - Always hides after 30s max
✅ **Visual Feedback** - Orange color indicates problems
✅ **Smart Detection** - Knows difference between slow vs stuck
✅ **Data Awareness** - Resets timer if data is flowing
✅ **User Friendly** - Clear console messages for debugging
✅ **Responsive** - Works on desktop and mobile
✅ **Fallback Safe** - Error event handling included

---

## Testing Stuck Scenarios

### Test 1: Intentionally Slow Network
```
Chrome DevTools → Network Tab → Throttle to "Slow 3G"
1. Play video
2. See white spinner appear
3. Observe spinner at 15 seconds
   - If data flowing: stays white, might finish loading
   - If no data: turns orange at 15s mark
4. At 30s: loader disappears
```

### Test 2: Broken URL
```
1. Edit video URL in inspect element to broken URL
2. Click play
3. waiting event fires immediately
4. At 15s: spinner turns orange
5. At 30s: loader hides automatically
6. Video element shows error state
```

### Test 3: Network Disconnected Mid-Play
```
1. Start playing normally
2. Turn off Wi-Fi / throttle network to offline
3. waiting event fires when buffering needed
4. Observe spinner behavior:
   - White: 0-15s
   - Orange: 15-30s
   - Hidden: 30s+
```

### Test 4: Seek on Stuck Video
```
1. Get video stuck (turn off network)
2. At 15s mark: spinner is orange
3. Turn network back on
4. Click to seek
5. seeking event fires → stuck class removed, spinner becomes white
6. seeked event fires → loader hides
```

---

## Browser Console Debugging

All events log to console. Open DevTools (F12) to see:

```javascript
// View all loader-related events
console.log messages with:
- 📹 Video waiting
- ✅ Video can play
- 🔍 Video seeking
- ✔️ Seek complete
- ⚠️ Video stuck (15s)
- ⏱️ Loader timeout (30s)
- ❌ Video error
```

Filter console by "loader" or "📹" to see only player events.

---

## Configuration

Current timeouts:
- **Stuck Detection**: 15 seconds
- **Force Hide**: 30 seconds

To change these, modify in `public/js/video-player.js`:

```javascript
var STUCK_THRESHOLD = 15000; // milliseconds
var AUTO_HIDE_THRESHOLD = 30000; // milliseconds
```

Adjust based on typical network conditions in your region.

---

## Summary

✅ Loader shows when video buffers
✅ Spinner turns orange after 15s if stuck
✅ Auto-hides after 30s maximum (prevent infinite spin)
✅ Resets timer if data arrives (progress event)
✅ Handles all video events (play, seeking, error, etc)
✅ Works on normal player (movies/TV shows)
✅ Console messages for debugging
✅ Mobile responsive design
✅ Graceful fallback (always hides eventually)

The loader is now **stuck-aware** and provides better user experience! 🎬
