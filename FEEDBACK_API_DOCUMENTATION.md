# Save Feedback API Documentation

## Overview

The `save-feedback` endpoint is used to submit user feedback/queries to the backend system.

---

## Endpoint Details

### Route
**File**: `routes/web.php` (Line 173)
```php
Route::post('save-feedback', [FeedbackController::class, 'saveFeedback'])->name('save-feedback');
```

### Controller
**File**: `app/Http/Controllers/FeedbackController.php`
**Method**: `saveFeedback()`

---

## Backend API Call

The controller calls the backend API:

```php
$response = CurlAPI("pages/queries", "POST", $curlData, 1);
```

**Backend Endpoint**: `pages/queries`
**Method**: POST

---

## Request Format

### Frontend Route
```
POST /save-feedback
```

### Backend API Endpoint
```
POST /pages/queries
```

---

## Request Parameters

### Required Fields

| Field | Type | Description |
|-------|------|-------------|
| `country` | string | Country code (e.g., "IN") |
| `email` | string | User email address |
| `message` | string | Feedback/query message |
| `platform` | string | Platform (e.g., "web", "mobile", "app") |

### Optional Fields

| Field | Type | Description |
|-------|------|-------------|
| `phone` | string | Phone number (without ISD code) |
| `isdcode` | string | ISD code (e.g., "+91") |

---

## Request Data Structure

```php
$curlData = [
    "country" => "IN",
    "email" => "user@example.com",
    "message" => "User feedback message",
    "phone" => "+919999999999",  // Combined: isdcode + phone
    "platform" => "web"
];
```

---

## CURL Command Examples

### Basic Feedback (Email Only)
```bash
curl -X POST http://localhost:8000/save-feedback \
  -H "Content-Type: application/x-www-form-urlencoded" \
  -H "X-CSRF-TOKEN: YOUR_CSRF_TOKEN" \
  -d "country=IN&email=user@example.com&message=Great app!&platform=web"
```

### Complete Feedback (With Phone)
```bash
curl -X POST http://localhost:8000/save-feedback \
  -H "Content-Type: application/x-www-form-urlencoded" \
  -H "X-CSRF-TOKEN: YOUR_CSRF_TOKEN" \
  -d "country=IN&email=user@example.com&message=Great app!&phone=9999999999&isdcode=%2B91&platform=web"
```

### With JSON Format
```bash
curl -X POST http://localhost:8000/save-feedback \
  -H "Content-Type: application/json" \
  -H "X-CSRF-TOKEN: YOUR_CSRF_TOKEN" \
  -d '{
    "country": "IN",
    "email": "user@example.com",
    "message": "Great app!",
    "phone": "9999999999",
    "isdcode": "+91",
    "platform": "web"
  }'
```

### Using Production URL
```bash
curl -X POST https://api.epiconshorts.com/save-feedback \
  -H "Content-Type: application/x-www-form-urlencoded" \
  -H "X-CSRF-TOKEN: YOUR_CSRF_TOKEN" \
  -d "country=IN&email=user@example.com&message=Feedback text&platform=web"
```

---

## Response Format

### Success Response
```json
{
  "statuscode": 200,
  "message": "Feedback submitted successfully",
  "success": true,
  "errorcode": ""
}
```

### Error Response (Missing Fields)
```json
{
  "statuscode": 200,
  "message": "Please fill all required fields!",
  "success": false,
  "errorcode": ""
}
```

### Error Response (Backend Error)
```json
{
  "statuscode": 200,
  "message": "Something went wrong. Please try again!",
  "success": false,
  "errorcode": ""
}
```

---

## Validation Rules

### Required Field Validation
```php
if (empty($email) || empty($message) || empty($country) || empty($platform)) {
    return error "Please fill all required fields!"
}
```

**All of these must be provided**:
- ✅ `country` - Cannot be empty
- ✅ `email` - Cannot be empty
- ✅ `message` - Cannot be empty
- ✅ `platform` - Cannot be empty

**Optional**:
- ❌ `phone` - Can be empty
- ❌ `isdcode` - Can be empty

---

## Data Processing

### Phone Number Handling
```php
// Phone number is combined: ISD code + phone number
"phone" => !empty($phone) ? "$stdisdcode$phone" : ""

// Example:
// isdcode: "+91"
// phone: "9999999999"
// Result: "+919999999999"
```

### Backend API Call
```php
$response = CurlAPI("pages/queries", "POST", $curlData, 1);
// Parameter 4 = 1 means: timeout 1 second
```

---

## Files Involved

| File | Purpose |
|------|---------|
| `routes/web.php` | Route definition |
| `app/Http/Controllers/FeedbackController.php` | Controller logic |
| `resources/views/feedback/feedback.blade.php` | Feedback page form |
| `resources/views/pages/account-settings-partials/help-feedback.blade.php` | Account settings feedback form |

---

## Middleware

**Middleware Applied**: `checkUserAuthToken`

This means:
- ✅ User must be authenticated
- ✅ User must have valid auth token
- ✅ Anonymous feedback NOT allowed

---

## Testing Steps

### 1. Get CSRF Token
```bash
# Visit the feedback page to get CSRF token
curl http://localhost:8000/feedback
# Extract X-CSRF-TOKEN from response
```

### 2. Submit Feedback
```bash
curl -X POST http://localhost:8000/save-feedback \
  -H "Content-Type: application/x-www-form-urlencoded" \
  -H "X-CSRF-TOKEN: YOUR_CSRF_TOKEN_HERE" \
  -b "XSRF-TOKEN=YOUR_CSRF_TOKEN_HERE" \
  -d "country=IN&email=test@example.com&message=Test feedback&platform=web"
```

### 3. Check Response
```json
{
  "statuscode": 200,
  "message": "Feedback submitted successfully",
  "success": true
}
```

---

## Quick Reference

**API Endpoint**: `POST /pages/queries`  
**Frontend Route**: `POST /save-feedback`  
**Authentication**: Required  
**Required Fields**: country, email, message, platform

**To test:**
```bash
curl -X POST http://localhost:8000/save-feedback \
  -H "X-CSRF-TOKEN: YOUR_TOKEN" \
  -d "country=IN&email=test@example.com&message=Test&platform=web"
```
