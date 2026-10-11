# Device Restriction Guide

## Current Status

**Maximum Simultaneous Login Devices: 4**

This means one user can log in on **4 devices at the same time**. When logging in on a **5th device**, the oldest logged-in device is automatically logged out.

---

## 🤔 Why Is This Happening?

When you logged in on:
- Laptop 1: Device 1 ✅
- Laptop 2: Device 2 ✅
- (if you continue logging in on more devices...)
- 5th device: Laptop 1 is automatically logged out ❌

This is a **subscription security feature** to prevent account sharing across too many devices.

---

## 🔧 How to Change the Device Limit

### **Current Configuration**

The device limit is configured in:
```
config/global.php
```

Current setting:
```php
'max_device_limit' => 10
```

(I've already increased it from 4 to 10 for you)

---

## 📋 Device Limit Options

| Setting | Value | Meaning |
|---------|-------|---------|
| Very Strict | 1 | Only 1 device can be logged in at a time |
| Strict | 2 | Only 2 devices can be logged in at the same time |
| **Current** | **10** | **Up to 10 devices can be logged in at the same time** |
| Very Loose | 20 | Up to 20 devices can be logged in at the same time |
| Unlimited | 999 | Essentially unlimited devices |

---

## ✅ To Increase/Change Device Limit

### Step 1: Edit `config/global.php`

Open the file:
```
config/global.php
```

### Step 2: Modify the Value

Change this line:
```php
'max_device_limit' => 10
```

To whatever you want:
```php
'max_device_limit' => 5    // Allow up to 5 devices
'max_device_limit' => 15   // Allow up to 15 devices
'max_device_limit' => 999  // Essentially unlimited
```

### Step 3: Save and Clear Cache

```bash
php artisan config:cache
```

### Step 4: Test

1. Log in on Device 1
2. Log in on Device 2
3. Both should stay logged in (if limit ≥ 2)

---

## 🔌 Backend API Control

**Important Note:** The device limit is **also enforced by the backend API**. 

Your current setup:
- Frontend shows max 10 devices
- Backend enforces its own limit

If you want to allow more than 10, also ask your backend team to:
1. Check their device limit setting
2. Increase it to match the frontend config

The response from `users/viewProfile` API returns:
```json
{
  "max_device_reached": false,  // or true if limit exceeded
  "user_data": { ... }
}
```

---

## 🔍 How Device Tracking Works

### **Device Identification**

Each device is identified by:
1. **Device ID** - Unique browser fingerprint (stored in localStorage)
2. **Device Label** - OS name (Windows 10, macOS, iOS, Android)
3. **User Agent** - Browser info
4. **Device Token** - Session identifier

When you log in, the system:
1. Generates a unique Device ID
2. Sends it to backend API
3. Backend checks: "How many devices is this user already logged in on?"
4. If > limit: Logs out oldest device automatically
5. If < limit: Allows new login

### **User Journey**

```
User Login
   ↓
Backend: "How many devices logged in?"
   ↓
Count < Limit?
   ├─ YES → Allow login ✅
   └─ NO  → Log out oldest device, then allow new login
```

---

## 💾 Storage Locations

### **Frontend (Device Tracking)**

Stored in browser:
- `localStorage.deviceId` - Unique device identifier
- `Cookie.StreamKey` - JWT token
- `Cookie.active_profile` - Current profile

### **Backend (Device Management)**

Stored in backend:
- User session table - List of active devices
- Device tokens - Per-device authentication
- Login timestamps - When each device logged in last

### **User Can See**

Location: **Settings → My Device Limits**
- Shows all logged-in devices
- Shows device names (Windows, macOS, etc.)
- Shows login time for each device
- Can manually log out any device

---

## 🚨 When Max Devices is Reached

### **What Happens**

1. User tries to log in on 5th device (when max=4)
2. System detects limit reached
3. Finds oldest device (e.g., Laptop logged in 3 days ago)
4. Logs out that device automatically
5. New device (2nd laptop) gets logged in

### **User Experience**

- **On old device:** Suddenly logged out, redirected to login page
- **On new device:** Login successful, redirected to home

### **Backend Message**

Frontend receives:
```json
{
  "success": true,
  "maxDevice": true,  // ← Device limit reached!
  "redirect": "/max-device"
}
```

User is then redirected to `/max-device` page showing:
> "Maximum devices reached. Your oldest device has been logged out."

---

## 📖 Related Files

| File | Purpose |
|------|---------|
| `config/global.php` | Frontend device limit config |
| `app/Http/Controllers/MaxDeviceController.php` | Handles max device page |
| `resources/views/pages/account-settings-partials/my-devices.blade.php` | Shows list of logged-in devices |
| `app/Helpers/helpers.php` | Contains `getMaxDevice()` helper |
| `resources/views/auth/login-reg-js.blade.php` | Login logic that checks max devices |

---

## ✨ Summary

**Your current setup:**
- ✅ Max 10 devices can be logged in simultaneously
- ✅ When 11th device logs in, oldest gets logged out automatically
- ✅ Users can manually log out devices in Settings
- ✅ Backend also enforces its own limit

**To change:**
1. Edit `config/global.php`
2. Change `max_device_limit` value
3. Run `php artisan config:cache`
4. Test on multiple devices

---

## FAQ

**Q: Why does my other device log out when I login on a new device?**
A: Device limit reached. Too many devices logged in simultaneously. Increase limit in config/global.php.

**Q: Can I log in on unlimited devices?**
A: Yes, set `max_device_limit` to 999 or remove the check entirely.

**Q: How long before auto-logout happens?**
A: Immediate - when you log in on device #(limit+1), device #1 is logged out immediately.

**Q: Can users manually remove devices?**
A: Yes, in Settings → My Device Limits, users can see all logged-in devices and manually log out any device.

**Q: Is this enforced frontend or backend?**
A: Both. Frontend shows the limit, but backend API enforces it. If backend limit is lower, it will be enforced instead.
