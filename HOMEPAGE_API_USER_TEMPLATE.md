# Homepage API - User Details Template

Use this template to test the homepage API with your user credentials. Replace the values with your actual user details.

---

## Your User Details

Update these values with actual user information:

```
USER_PHONE: +919876543210
USER_PASSWORD: your_password
USER_ID: 919867447773
PROFILE_ID: 16413556
USER_TOKEN: eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJkYXRhIjp7InVzZXJfaWQiOjkxOTg2NzQ0Nzc3M30sImlhdCI6MTc4NzgyNTIwMSwiZXhwIjoxNzg3OTExNjAxfQ.QWNwwZAmp3Y1cazeLO_Wxfl4ZX5AMZ55dQkQr21nmQ0
```

---

## Step 1: Get User Token (Login)

```bash
curl --location --request POST \
  'https://contentapistg-njsapi.epicon.in/index/users/login' \
  --header 'x-access-auth-token: szQDOyDaxsS0E4qeV1rMfpYBKnSWVESH' \
  --header 'Content-Type: application/json' \
  --data '{
    "phone_number": "+919876543210",
    "password": "your_password"
  }' | jq .
```

**Response will contain:**
```json
{
    "success": true,
    "data": {
        "token": "eyJ...",
        "user_id": "919867447773",
        "profile_id": "16413556"
    }
}
```

Extract these values for next steps.

---

## Step 2: Test Homepage API with Your User

### Simple Test (Copy-Paste Ready)

```bash
# Replace with YOUR values
TOKEN="YOUR_TOKEN_HERE"
USER_ID="YOUR_USER_ID_HERE"
PROFILE_ID="YOUR_PROFILE_ID_HERE"

curl -s 'https://contentapistg-njsapi.epicon.in/index/pages/homepage?slug=home-v2&list_language=all&display_language=en&page=1&limit=3&user_id='"$USER_ID"'&profile_id='"$PROFILE_ID" \
  -H 'x-access-auth-token: szQDOyDaxsS0E4qeV1rMfpYBKnSWVESH' \
  -H 'Authorization: '"$TOKEN" | jq '.data.list[] | select(.display_type=="continuewatching")'
```

---

## Complete Testing Workflow

### 1. Login and Get Token

```bash
#!/bin/bash

# Step 1: Login
echo "Step 1: Logging in..."
LOGIN_RESPONSE=$(curl -s -X POST \
  'https://contentapistg-njsapi.epicon.in/index/users/login' \
  -H 'x-access-auth-token: szQDOyDaxsS0E4qeV1rMfpYBKnSWVESH' \
  -H 'Content-Type: application/json' \
  --data '{
    "phone_number": "+919876543210",
    "password": "your_password"
  }')

# Extract token and IDs
TOKEN=$(echo "$LOGIN_RESPONSE" | jq -r '.data.token')
USER_ID=$(echo "$LOGIN_RESPONSE" | jq -r '.data.user_id')
PROFILE_ID=$(echo "$LOGIN_RESPONSE" | jq -r '.data.profile_id')

echo "✓ Login successful"
echo "  Token: $TOKEN"
echo "  User ID: $USER_ID"
echo "  Profile ID: $PROFILE_ID"
echo ""

# Step 2: Fetch Homepage
echo "Step 2: Fetching homepage..."
HOMEPAGE=$(curl -s "https://contentapistg-njsapi.epicon.in/index/pages/homepage?slug=home-v2&list_language=all&display_language=en&page=1&limit=3&user_id=${USER_ID}&profile_id=${PROFILE_ID}" \
  -H 'x-access-auth-token: szQDOyDaxsS0E4qeV1rMfpYBKnSWVESH' \
  -H "Authorization: $TOKEN")

echo "✓ Homepage fetched"
echo ""

# Step 3: Check for Continue Watching
echo "Step 3: Checking for Continue Watching..."
CONTINUE_WATCHING=$(echo "$HOMEPAGE" | jq '.data.list[] | select(.display_type=="continuewatching")')

if [ -z "$CONTINUE_WATCHING" ]; then
    echo "✗ No Continue Watching tray found"
else
    echo "✓ Continue Watching tray found!"
    echo ""
    echo "Content:"
    echo "$CONTINUE_WATCHING" | jq '{title, item_count: (.content | length), items: [.content[] | {title, duration, user_duration}]}'
fi
```

---

## Quick Commands by Use Case

### Use Case 1: I have a token, want to test homepage

```bash
TOKEN="eyJ..."
USER_ID="919867447773"
PROFILE_ID="16413556"

curl -s "https://contentapistg-njsapi.epicon.in/index/pages/homepage?slug=home-v2&list_language=all&display_language=en&page=1&limit=3&user_id=${USER_ID}&profile_id=${PROFILE_ID}" \
  -H 'x-access-auth-token: szQDOyDaxsS0E4qeV1rMfpYBKnSWVESH' \
  -H "Authorization: $TOKEN" | jq '.data.list[] | select(.display_type=="continuewatching")'
```

### Use Case 2: I want to see all trays

```bash
TOKEN="eyJ..."
USER_ID="919867447773"
PROFILE_ID="16413556"

curl -s "https://contentapistg-njsapi.epicon.in/index/pages/homepage?slug=home-v2&list_language=all&display_language=en&page=1&limit=3&user_id=${USER_ID}&profile_id=${PROFILE_ID}" \
  -H 'x-access-auth-token: szQDOyDaxsS0E4qeV1rMfpYBKnSWVESH' \
  -H "Authorization: $TOKEN" | jq '.data.list[] | {display_type, title, has_items: (.content | length > 0)}'
```

### Use Case 3: Show continue watching items with progress

```bash
TOKEN="eyJ..."
USER_ID="919867447773"
PROFILE_ID="16413556"

curl -s "https://contentapistg-njsapi.epicon.in/index/pages/homepage?slug=home-v2&list_language=all&display_language=en&page=1&limit=3&user_id=${USER_ID}&profile_id=${PROFILE_ID}" \
  -H 'x-access-auth-token: szQDOyDaxsS0E4qeV1rMfpYBKnSWVESH' \
  -H "Authorization: $TOKEN" | \
  jq '.data.list[] | select(.display_type=="continuewatching") | .content[] | {
    title,
    duration_min: (.duration / 60 | floor),
    watched_min: (.user_duration / 60 | floor),
    progress_percent: ((.user_duration / .duration * 100) | floor)
  }'
```

---

## Expected Responses

### If Continue Watching Exists

```json
{
  "display_type": "continuewatching",
  "title": "Continue Watching",
  "show_more": true,
  "catalog": "continue-watching-tray",
  "content": [
    {
      "ID": 1782723687,
      "title": "Drama That Hits Home - Episode 1",
      "slug": "drama-that-hits-home-ep1",
      "asset_type": "WATCH",
      "duration": 3600,
      "user_duration": 1200,
      "cover_image": {
        "original": "https://...",
        "small": "https://...",
        "medium": "https://...",
        "large": "https://..."
      },
      "url": "shows/drama-that-hits-home/season-1/episode-1"
    }
  ]
}
```

### If Continue Watching Does NOT Exist

```bash
# Command returns nothing (empty)
# Or:
null
```

---

## Troubleshooting

### Problem: Invalid Token

```bash
# Error response:
{
    "success": false,
    "message": "Unauthorized",
    "error": "Invalid token"
}

# Solution: Get a fresh token by logging in again
```

### Problem: No Continue Watching Items

```bash
# Check if:
1. User has watched any content
2. Token is valid
3. user_id and profile_id are correct

# Try adding more limit to see other content
?limit=10
```

### Problem: Connection Refused

```bash
# Check:
1. Internet connection
2. API domain is correct
3. No firewall blocking requests
```

---

## Multiple Users Testing

```bash
#!/bin/bash

# Test multiple users
USERS=(
    "phone:+919876543210,password:pass1"
    "phone:+919876543211,password:pass2"
    "phone:+919876543212,password:pass3"
)

for USER in "${USERS[@]}"; do
    IFS=',' read -r PHONE PASSWORD <<< "$USER"
    PHONE="${PHONE#phone:}"
    PASSWORD="${PASSWORD#password:}"
    
    echo "Testing user: $PHONE"
    
    # Login
    TOKEN=$(curl -s -X POST \
      'https://contentapistg-njsapi.epicon.in/index/users/login' \
      -H 'x-access-auth-token: szQDOyDaxsS0E4qeV1rMfpYBKnSWVESH' \
      -H 'Content-Type: application/json' \
      --data "{\"phone_number\": \"$PHONE\", \"password\": \"$PASSWORD\"}" | jq -r '.data.token')
    
    USER_ID=$(curl -s -X POST \
      'https://contentapistg-njsapi.epicon.in/index/users/login' \
      -H 'x-access-auth-token: szQDOyDaxsS0E4qeV1rMfpYBKnSWVESH' \
      -H 'Content-Type: application/json' \
      --data "{\"phone_number\": \"$PHONE\", \"password\": \"$PASSWORD\"}" | jq -r '.data.user_id')
    
    PROFILE_ID=$(curl -s -X POST \
      'https://contentapistg-njsapi.epicon.in/index/users/login' \
      -H 'x-access-auth-token: szQDOyDaxsS0E4qeV1rMfpYBKnSWVESH' \
      -H 'Content-Type: application/json' \
      --data "{\"phone_number\": \"$PHONE\", \"password\": \"$PASSWORD\"}" | jq -r '.data.profile_id')
    
    # Check continue watching
    CW_COUNT=$(curl -s "https://contentapistg-njsapi.epicon.in/index/pages/homepage?slug=home-v2&list_language=all&display_language=en&page=1&limit=3&user_id=${USER_ID}&profile_id=${PROFILE_ID}" \
      -H 'x-access-auth-token: szQDOyDaxsS0E4qeV1rMfpYBKnSWVESH' \
      -H "Authorization: $TOKEN" | \
      jq '.data.list[] | select(.display_type=="continuewatching") | .content | length')
    
    echo "  Continue Watching items: $CW_COUNT"
    echo ""
done
```

---

## Notes

- Token may expire. If you get 401 errors, login again to get a fresh token
- Different profile_ids may have different continue watching data
- Display types may vary based on user's watch history and preferences
- limit parameter controls items per tray (default: 3)
- page parameter for pagination (default: 1)

---

## Keep This Safe

Store your actual user credentials securely:

```bash
# Don't commit this to git!
# Create .env.local or similar

export API_TOKEN="szQDOyDaxsS0E4qeV1rMfpYBKnSWVESH"
export USER_PHONE="+919876543210"
export USER_PASSWORD="your_password"
export API_URL="https://contentapistg-njsapi.epicon.in/index"
```

Then use in scripts:
```bash
curl -s "${API_URL}/pages/homepage?..." \
  -H "x-access-auth-token: ${API_TOKEN}" \
  -H "Authorization: ${USER_TOKEN}"
```
