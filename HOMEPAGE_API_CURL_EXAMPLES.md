# Homepage API - Curl Examples with User Details

## Overview
The homepage API returns all display types including "continuewatching" when user is logged in. This document provides curl examples to test the continue watching tray.

---

## Basic Curl Call (Without User Authentication)

```bash
curl --location --request GET \
  'https://contentapistg-njsapi.epicon.in/index/pages/homepage?slug=home-v2&list_language=all&display_language=en&page=1&limit=3' \
  --header 'x-access-auth-token: szQDOyDaxsS0E4qeV1rMfpYBKnSWVESH' \
  --header 'Content-Type: application/json'
```

**Parameters:**
- `slug`: home-v2 (homepage)
- `list_language`: all (all languages)
- `display_language`: en (English)
- `page`: 1 (first page)
- `limit`: 3 (3 items per tray)

---

## With User Authentication (Continue Watching Visible)

### Method 1: With Authorization Header

```bash
# Set variables
USER_TOKEN="eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJkYXRhIjp7InVzZXJfaWQiOjkxOTg2NzQ0Nzc3M30sImlhdCI6MTc4NzgyNTIwMSwiZXhwIjoxNzg3OTExNjAxfQ.QWNwwZAmp3Y1cazeLO_Wxfl4ZX5AMZ55dQkQr21nmQ0"
USER_ID="919867447773"
PROFILE_ID="16413556"

curl --location --request GET \
  'https://contentapistg-njsapi.epicon.in/index/pages/homepage?slug=home-v2&list_language=all&display_language=en&page=1&limit=3&user_id='"$USER_ID"'&profile_id='"$PROFILE_ID" \
  --header 'x-access-auth-token: szQDOyDaxsS0E4qeV1rMfpYBKnSWVESH' \
  --header 'Authorization: '"$USER_TOKEN" \
  --header 'Content-Type: application/json'
```

**Key Parameters:**
- `user_id`: 919867447773 (user's ID)
- `profile_id`: 16413556 (profile being used)

---

## Complete Curl Examples

### Example 1: Full Homepage Call with All Parameters

```bash
#!/bin/bash

# User Details
USER_TOKEN="eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJkYXRhIjp7InVzZXJfaWQiOjkxOTg2NzQ0Nzc3M30sImlhdCI6MTc4NzgyNTIwMSwiZXhwIjoxNzg3OTExNjAxfQ.QWNwwZAmp3Y1cazeLO_Wxfl4ZX5AMZ55dQkQr21nmQ0"
USER_ID="919867447773"
PROFILE_ID="16413556"
API_TOKEN="szQDOyDaxsS0E4qeV1rMfpYBKnSWVESH"
API_URL="https://contentapistg-njsapi.epicon.in/index/pages/homepage"

# Build query parameters
QUERY_PARAMS="slug=home-v2&list_language=all&display_language=en&page=1&limit=3&user_id=${USER_ID}&profile_id=${PROFILE_ID}"

# Make request
curl --location --request GET \
  "${API_URL}?${QUERY_PARAMS}" \
  --header "x-access-auth-token: ${API_TOKEN}" \
  --header "Authorization: ${USER_TOKEN}" \
  --header 'Content-Type: application/json' \
  --header 'Accept: application/json'
```

### Example 2: With Pretty JSON Output

```bash
curl --location --request GET \
  'https://contentapistg-njsapi.epicon.in/index/pages/homepage?slug=home-v2&list_language=all&display_language=en&page=1&limit=3&user_id=919867447773&profile_id=16413556' \
  --header 'x-access-auth-token: szQDOyDaxsS0E4qeV1rMfpYBKnSWVESH' \
  --header 'Authorization: eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJkYXRhIjp7InVzZXJfaWQiOjkxOTg2NzQ0Nzc3M30sImlhdCI6MTc4NzgyNTIwMSwiZXhwIjoxNzg3OTExNjAxfQ.QWNwwZAmp3Y1cazeLO_Wxfl4ZX5AMZ55dQkQr21nmQ0' \
  --header 'Content-Type: application/json' | jq .
```

### Example 3: Save Response to File

```bash
curl --location --request GET \
  'https://contentapistg-njsapi.epicon.in/index/pages/homepage?slug=home-v2&list_language=all&display_language=en&page=1&limit=3&user_id=919867447773&profile_id=16413556' \
  --header 'x-access-auth-token: szQDOyDaxsS0E4qeV1rMfpYBKnSWVESH' \
  --header 'Authorization: eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJkYXRhIjp7InVzZXJfaWQiOjkxOTg2NzQ0Nzc3M30sImlhdCI6MTc4NzgyNTIwMSwiZXhwIjoxNzg3OTExNjAxfQ.QWNwwZAmp3Y1cazeLO_Wxfl4ZX5AMZ55dQkQr21nmQ0' \
  --header 'Content-Type: application/json' \
  > homepage_response.json

# View the response
cat homepage_response.json | jq .
```

---

## Parameter Reference

### Required Headers

| Header | Value | Purpose |
|--------|-------|---------|
| `x-access-auth-token` | `szQDOyDaxsS0E4qeV1rMfpYBKnSWVESH` | API Authentication |
| `Authorization` | JWT Token | User Authentication (for continue watching) |
| `Content-Type` | application/json | Request format |

### Query Parameters

| Parameter | Example | Purpose | Required |
|-----------|---------|---------|----------|
| `slug` | home-v2 | Page identifier | Yes |
| `list_language` | all | Content language filter | Yes |
| `display_language` | en | Display language (en/hi/ta/ma/te) | Yes |
| `page` | 1 | Page number | Yes |
| `limit` | 3 | Items per tray | Yes |
| `user_id` | 919867447773 | User ID (for personalization) | Optional |
| `profile_id` | 16413556 | Profile ID (for continue watching) | Optional |

---

## Getting User Token

To get a valid user token, perform a login:

```bash
curl --location --request POST \
  'https://contentapistg-njsapi.epicon.in/index/users/login' \
  --header 'x-access-auth-token: szQDOyDaxsS0E4qeV1rMfpYBKnSWVESH' \
  --header 'Content-Type: application/json' \
  --data '{
    "phone_number": "+919876543210",
    "password": "your_password"
  }'
```

Response:
```json
{
    "success": true,
    "data": {
        "token": "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9...",
        "user_id": "919867447773",
        "profile_id": "16413556"
    }
}
```

---

## Response Structure

### Success Response
```json
{
    "success": true,
    "data": {
        "name": "Home",
        "list": [
            {
                "display_type": "banner",
                "title": "Featured",
                "content": [...]
            },
            {
                "display_type": "continuewatching",
                "title": "Continue Watching",
                "show_more": true,
                "catalog": "continue-watching-tray",
                "content": [
                    {
                        "ID": 1782723687,
                        "title": "Drama - Episode 1",
                        "slug": "drama-slug",
                        "asset_type": "WATCH",
                        "duration": 3600,
                        "user_duration": 1200,
                        "cover_image": {...},
                        "url": "shows/drama/season-1/episode-1"
                    }
                ]
            },
            {
                "display_type": "trending",
                "title": "Trending Now",
                "content": [...]
            }
        ]
    }
}
```

---

## Extract Continue Watching from Response

### Using jq
```bash
# Get only the continue watching tray
curl -s 'https://contentapistg-njsapi.epicon.in/index/pages/homepage?slug=home-v2&list_language=all&display_language=en&page=1&limit=3&user_id=919867447773&profile_id=16413556' \
  -H 'x-access-auth-token: szQDOyDaxsS0E4qeV1rMfpYBKnSWVESH' \
  -H 'Authorization: eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJkYXRhIjp7InVzZXJfaWQiOjkxOTg2NzQ0Nzc3M30sImlhdCI6MTc4NzgyNTIwMSwiZXhwIjoxNzg3OTExNjAxfQ.QWNwwZAmp3Y1cazeLO_Wxfl4ZX5AMZ55dQkQr21nmQ0' | \
  jq '.data.list[] | select(.display_type=="continuewatching")'
```

### Using grep
```bash
# Check if continue watching exists
curl -s 'https://contentapistg-njsapi.epicon.in/index/pages/homepage?slug=home-v2&list_language=all&display_language=en&page=1&limit=3&user_id=919867447773&profile_id=16413556' \
  -H 'x-access-auth-token: szQDOyDaxsS0E4qeV1rMfpYBKnSWVESH' \
  -H 'Authorization: eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJkYXRhIjp7InVzZXJfaWQiOjkxOTg2NzQ0Nzc3M30sImlhdCI6MTc4NzgyNTIwMSwiZXhwIjoxNzg3OTExNjAxfQ.QWNwwZAmp3Y1cazeLO_Wxfl4ZX5AMZ55dQkQr21nmQ0' | \
  grep -o '"display_type":"continuewatching"'
```

---

## Test Scenarios

### Scenario 1: Check If Continue Watching Tray Exists

```bash
#!/bin/bash

# Make API call
RESPONSE=$(curl -s 'https://contentapistg-njsapi.epicon.in/index/pages/homepage?slug=home-v2&list_language=all&display_language=en&page=1&limit=3&user_id=919867447773&profile_id=16413556' \
  -H 'x-access-auth-token: szQDOyDaxsS0E4qeV1rMfpYBKnSWVESH' \
  -H 'Authorization: eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJkYXRhIjp7InVzZXJfaWQiOjkxOTg2NzQ0Nzc3M30sImlhdCI6MTc4NzgyNTIwMSwiZXhwIjoxNzg3OTExNjAxfQ.QWNwwZAmp3Y1cazeLO_Wxfl4ZX5AMZ55dQkQr21nmQ0')

# Check for continue watching
if echo "$RESPONSE" | grep -q "continuewatching"; then
    echo "✓ Continue Watching tray FOUND"
    echo "$RESPONSE" | jq '.data.list[] | select(.display_type=="continuewatching") | {display_type, title, content_count: (.content | length)}'
else
    echo "✗ Continue Watching tray NOT FOUND"
fi
```

### Scenario 2: Get Continue Watching Content Count

```bash
curl -s 'https://contentapistg-njsapi.epicon.in/index/pages/homepage?slug=home-v2&list_language=all&display_language=en&page=1&limit=3&user_id=919867447773&profile_id=16413556' \
  -H 'x-access-auth-token: szQDOyDaxsS0E4qeV1rMfpYBKnSWVESH' \
  -H 'Authorization: eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJkYXRhIjp7InVzZXJfaWQiOjkxOTg2NzQ0Nzc3M30sImlhdCI6MTc4NzgyNTIwMSwiZXhwIjoxNzg3OTExNjAxfQ.QWNwwZAmp3Y1cazeLO_Wxfl4ZX5AMZ55dQkQr21nmQ0' | \
  jq '.data.list[] | select(.display_type=="continuewatching") | {title: .title, item_count: (.content | length), items: [.content[] | {title: .title, duration: .duration, user_duration: .user_duration}]}'
```

### Scenario 3: All Display Types in Response

```bash
curl -s 'https://contentapistg-njsapi.epicon.in/index/pages/homepage?slug=home-v2&list_language=all&display_language=en&page=1&limit=3&user_id=919867447773&profile_id=16413556' \
  -H 'x-access-auth-token: szQDOyDaxsS0E4qeV1rMfpYBKnSWVESH' \
  -H 'Authorization: eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJkYXRhIjp7InVzZXJfaWQiOjkxOTg2NzQ0Nzc3M30sImlhdCI6MTc4NzgyNTIwMSwiZXhwIjoxNzg3OTExNjAxfQ.QWNwwZAmp3Y1cazeLO_Wxfl4ZX5AMZ55dQkQr21nmQ0' | \
  jq '.data.list[] | {display_type: .display_type, title: .title, has_content: (.content | length > 0)}'
```

---

## Common Issues & Solutions

### Issue 1: No Authorization Header
**Problem:** Continue watching tray not appearing
**Solution:** Add Authorization header with valid JWT token

```bash
# ✗ Wrong (no auth)
curl 'https://...?slug=home-v2' \
  -H 'x-access-auth-token: ...'

# ✓ Correct (with auth)
curl 'https://...?slug=home-v2' \
  -H 'x-access-auth-token: ...' \
  -H 'Authorization: eyJ...'
```

### Issue 2: Missing user_id or profile_id
**Problem:** Continue watching may not work correctly
**Solution:** Always include both parameters when user is logged in

```bash
# ✓ Correct
?slug=home-v2&user_id=919867447773&profile_id=16413556
```

### Issue 3: Invalid JWT Token
**Problem:** 401 Unauthorized error
**Solution:** Get fresh token from login endpoint

```bash
# Get new token
curl -X POST 'https://.../users/login' \
  -H 'x-access-auth-token: ...' \
  --data '{"phone_number": "+919876543210", "password": "..."}'
```

---

## Postman Collection

```json
{
    "info": {
        "name": "Homepage API - Continue Watching",
        "schema": "https://schema.getpostman.com/json/collection/v2.1.0/collection.json"
    },
    "item": [
        {
            "name": "Homepage with Continue Watching",
            "request": {
                "method": "GET",
                "header": [
                    {
                        "key": "x-access-auth-token",
                        "value": "szQDOyDaxsS0E4qeV1rMfpYBKnSWVESH"
                    },
                    {
                        "key": "Authorization",
                        "value": "{{user_token}}"
                    },
                    {
                        "key": "Content-Type",
                        "value": "application/json"
                    }
                ],
                "url": {
                    "raw": "https://contentapistg-njsapi.epicon.in/index/pages/homepage?slug=home-v2&list_language=all&display_language=en&page=1&limit=3&user_id={{user_id}}&profile_id={{profile_id}}",
                    "protocol": "https",
                    "host": ["contentapistg-njsapi", "epicon", "in"],
                    "path": ["index", "pages", "homepage"],
                    "query": [
                        {"key": "slug", "value": "home-v2"},
                        {"key": "list_language", "value": "all"},
                        {"key": "display_language", "value": "en"},
                        {"key": "page", "value": "1"},
                        {"key": "limit", "value": "3"},
                        {"key": "user_id", "value": "{{user_id}}"},
                        {"key": "profile_id", "value": "{{profile_id}}"}
                    ]
                }
            }
        }
    ]
}
```

---

## Quick Test Command

```bash
# One-liner to test continue watching tray
curl -s 'https://contentapistg-njsapi.epicon.in/index/pages/homepage?slug=home-v2&list_language=all&display_language=en&page=1&limit=3&user_id=919867447773&profile_id=16413556' \
  -H 'x-access-auth-token: szQDOyDaxsS0E4qeV1rMfpYBKnSWVESH' \
  -H 'Authorization: eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJkYXRhIjp7InVzZXJfaWQiOjkxOTg2NzQ0Nzc3M30sImlhdCI6MTc4NzgyNTIwMSwiZXhwIjoxNzg3OTExNjAxfQ.QWNwwZAmp3Y1cazeLO_Wxfl4ZX5AMZ55dQkQr21nmQ0' | \
  jq '.data.list[] | select(.display_type=="continuewatching")'
```

---

## Summary

| Item | Value |
|------|-------|
| **Endpoint** | `pages/homepage` |
| **Method** | GET |
| **Base URL** | https://contentapistg-njsapi.epicon.in/index/ |
| **Auth Header** | x-access-auth-token |
| **User Token** | Authorization header |
| **Continue Watching** | Visible when logged in with user_id & profile_id |
| **Display Type** | "continuewatching" |
| **Key Parameters** | slug, user_id, profile_id, display_language |
