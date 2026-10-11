# Fix Local Testing - 5 Minutes

**Issue:** StreamKey cookie is for `.epicon.in` but you access `localhost:8000`  
**Solution:** Access via `devepicon-v3.epicon.in:8000` instead  
**Time:** 5 minutes

---

## Step 1: Edit /etc/hosts (1 minute)

```bash
# Open hosts file
sudo nano /etc/hosts

# Add this line at the end:
127.0.0.1    devepicon-v3.epicon.in

# Save: Press Ctrl+X, then Y, then Enter
```

---

## Step 2: Stop Laravel Server (30 seconds)

If running `php artisan serve`, stop it (Ctrl+C)

---

## Step 3: Restart Laravel (30 seconds)

```bash
php artisan serve
```

Output should show:
```
Laravel development server started: http://127.0.0.1:8000
```

---

## Step 4: Access via New Domain (30 seconds)

Instead of opening:
```
http://localhost:8000  ❌
```

Open:
```
http://devepicon-v3.epicon.in:8000  ✅
```

---

## Step 5: Login & Test (3 minutes)

1. Login with credentials
2. Open DevTools (F12)
3. Go to Console tab
4. Paste this:

```javascript
console.log("Cookies:", document.cookie);
console.log("StreamKey found:", document.cookie.includes('StreamKey'));
```

**Expected output:**
```
Cookies: StreamKey=eyJ...; TokenExpiresAt=...
StreamKey found: true
```

---

## Step 6: Check Token Refresh

**In console, paste:**

```javascript
window.__initTokenRefresh()
```

**Expected output:**
```
✅ StreamKey token found - starting refresh cycle
✅ Token (first 30 chars): eyJhbGciOiJIUzI1NiIsInR5...
🔄 Initial token refresh on page load...
📅 Setting up periodic refresh every 5 minutes
✅ Token refresh system ready
```

---

## Done! ✅

Token refresh should now work. Wait 5 minutes and check:

```javascript
// In console after 5 minutes:
// Should see periodic refresh messages
```

---

## If Still Not Working

### Verify /etc/hosts was updated:

```bash
cat /etc/hosts | grep epicon
# Should show: 127.0.0.1    devepicon-v3.epicon.in
```

### Clear browser cache:

- DevTools → Application → Clear Site Data
- Then reload page

### Check cookie domain in DevTools:

- DevTools → Application → Cookies
- Click on StreamKey
- Domain should now be: `.epicon-...` ✅

---

## Production Notes

This fix is for **local development only**.

In production:
- Users access `epicon.in`
- Cookie is set for `.epicon.in`
- Everything works automatically ✅

No code changes needed for production!

