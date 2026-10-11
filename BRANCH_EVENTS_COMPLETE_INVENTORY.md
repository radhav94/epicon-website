# Complete Branch Events Inventory

**Last Updated:** September 1, 2026  
**Total Events:** 51+  
**Status:** Active Tracking

---

## 📊 Branch Events Summary

All events are tracked through `window.trackBranchEvent()` which calls `branch.logEvent()` with event data and timestamp.

---

## 🔐 Core System Events (Default Page Load)

| Event | File | Lines | Trigger | Data | Status |
|-------|------|-------|---------|------|--------|
| **user_identity_set** | default.blade.php | 139-149 | On page load (logged in) | customerID, email, phone | ✅ Active |
| **user_guest_session** | default.blade.php | 151-155 | On page load (guest) | customerID: guest | ✅ Active |
| **page_view_test** | default.blade.php | 168-177 | 1 sec after page load | page_url, page_title | ✅ Active |

---

## 🔐 User Authentication Events

### Login Flow
| Event | File | Trigger | Data | Status |
|-------|------|---------|------|--------|
| **login_start** | ga_tag.js:460 | "Login with OTP" button clicked | timestamp | ✅ Active |
| **login_success** | ga_tag.js:477 | After successful OTP verification | timestamp | ✅ Active |
| **login_failed** | ga_tag.js:491 | Failed OTP/password verification | timestamp | ✅ Active |
| **login_skip** | ga_tag.js:505 | User closes login modal | timestamp | ✅ Active |

### Registration Flow
| Event | File | Trigger | Data | Status |
|-------|------|---------|------|--------|
| **registration_start** | ga_tag.js:520 | User opens registration form | timestamp | ✅ Active |
| **registration_success** | ga_tag.js:534 | User completes registration | timestamp | ✅ Active |
| **registration_failed** | ga_tag.js:548 | Registration validation fails | timestamp | ✅ Active |
| **registration_skip** | ga_tag.js:562 | User skips registration | timestamp | ✅ Active |

---

## 💳 Payment & Subscription Events

### Payment Events
| Event | File | Trigger | Data | Status |
|-------|------|---------|------|--------|
| **payment_successful** | thankyou.blade.php:209 | Payment completed | order_id, amount, plan_name, dates | ✅ Active |
| **subscription_activated** | thankyou.blade.php:226 | Subscription becomes active | subscription_id, plan_id, plan_name | ✅ Active |

---

## 🎯 User Interaction Events (Click Tracking)

### Navigation & Menu
| Event | File | Line | Trigger | Data | Status |
|-------|------|------|---------|------|--------|
| **click_menu** | ga_tag.js:230 | Menu item clicked | element_text, event_context | ✅ Active |
| **click_social** | ga_tag.js:27 | Social media link clicked | element_text, event_context | ✅ Active |
| **click_subscription** | ga_tag.js:47 | Subscription plan clicked | plan_name, plan_price | ✅ Active |
| **click_carousel** | ga_tag.js:66 | Carousel item clicked | element_text, time_on_page | ✅ Active |
| **click_tile** | ga_tag.js:107 | Content tile clicked | content_name, event_context | ✅ Active |
| **click_explore** | ga_tag.js:127 | Explore button clicked | content_name, event_context | ✅ Active |
| **click_teams** | ga_tag.js:148 | Team/cast member clicked | event_context, team_name | ✅ Active |
| **click_cta** | ga_tag.js:405 | Call-to-action button clicked | element_text, event_context | ✅ Active |

### Search Events
| Event | File | Line | Trigger | Data | Status |
|-------|------|------|---------|------|--------|
| **search** | ga_tag.js:189 | Search query submitted | search_term, timestamp | ✅ Active |
| **click_search_results** | ga_tag.js:208 | Search result clicked | search_term, element_text | ✅ Active |

### Other Interactions
| Event | File | Line | Trigger | Data | Status |
|-------|------|------|---------|------|--------|
| **share** | ga_tag.js:86 | Content shared | content_name, content_type | ✅ Active |
| **click_spinner** | ga_tag.js:247 | Spinner/loading action | element_text, timestamp | ✅ Active |
| **outbound_click** | ga_tag.js:169 | External link clicked | element_text, event_context | ✅ Active |

---

## 🎥 Media Events

### Video Tracking
| Event | File | Line | Trigger | Data | Status |
|-------|------|------|---------|------|--------|
| **video_start** | ga_tag.js:263 | Video playback starts | video_name, video_duration | ✅ Active |
| **video_pause** | ga_tag.js:279 | Video paused | video_name, video_duration | ✅ Active |
| **video_progress** | ga_tag.js:297 | Video progress updates | video_name, video_duration, progress | ✅ Active |
| **video_complete** | ga_tag.js:315 | Video completed | video_name, video_duration | ✅ Active |
| **click_player** | ga_tag.js:424 | Player control clicked | player_name, time_on_page | ✅ Active |

### Audio Tracking
| Event | File | Line | Trigger | Data | Status |
|-------|------|------|---------|------|--------|
| **audio_start** | ga_tag.js:332 | Audio playback starts | audio_name, audio_duration | ✅ Active |
| **audio_pause** | ga_tag.js:348 | Audio paused | audio_name, audio_duration | ✅ Active |
| **audio_progress** | ga_tag.js:365 | Audio progress updates | audio_name, audio_duration | ✅ Active |
| **audio_complete** | ga_tag.js:384 | Audio completed | audio_name, audio_duration | ✅ Active |

---

## 🌍 Country Selection Events

| Event | File | Line | Trigger | Data | Status |
|-------|------|------|---------|------|--------|
| **india_country_selected** | custom.js:447 | India country code selected | country_code, timestamp | ✅ New |
| **non_india_country_selected** | custom.js:451 | Non-India country code selected | country_code, timestamp | ✅ New |

---

## 📥 File & Content Events

| Event | File | Line | Trigger | Data | Status |
|-------|------|------|---------|------|--------|
| **file_download** | ga_tag.js:443 | File downloaded | file_name, file_type | ✅ Active |



### Files with Active Event Tracking:

1. **ga_tag.js** (45+ events)
   - All user interactions, login/registration, media events
   - Located: `/public/assets/js/ga_tag.js`

2. **default.blade.php** (3 events)
   - Core page load events, user identity setup
   - Located: `/resources/views/layouts/default.blade.php`

3. **thankyou.blade.php** (2 events)
   - Payment and subscription completion
   - Located: `/resources/views/subscription/thankyou.blade.php`

4. **custom.js** (2 events)
   - Country code selection
   - Located: `/public/assets/js/custom.js`

5. **branch-tracking.js** (24 helper functions)
   - Defined but NOT USED
   - Located: `/public/assets/js/branch-tracking.js`

---

## 🎯 Event Categories Breakdown

| Category | Count | Status |
|----------|-------|--------|
| Authentication | 8 | ✅ Active |
| Payments | 2 | ✅ Active |
| Media (Video/Audio) | 8 | ✅ Active |
| User Interactions | 16 | ✅ Active |
| Page/System | 3 | ✅ Active |
| Country Selection | 2 | ✅ Active |
| File Operations | 1 | ✅ Active |
| **Total Active** | **40** | ✅ |
| Helper Functions (Unused) | 24 | ❌ |

---

## 🔌 Event Flow Diagram

```
┌─────────────────────┐
│   Page Load         │
└──────────┬──────────┘
           │
    ┌──────▼────────────────┐
    │ Check User Login      │
    └──────┬────────────────┘
           │
    ┌──────┴──────────────────────────┐
    │                                 │
    ▼                                 ▼
┌──────────────────┐        ┌──────────────────┐
│ user_identity_set│        │ user_guest_set   │
│ branch.setID()   │        │ branch.logout()  │
└────────┬─────────┘        └────────┬─────────┘
         │                           │
         └─────────────┬─────────────┘
                       │
                ┌──────▼──────────┐
                │ page_view_test  │
                │ (1 sec delay)   │
                └─────────────────┘

┌────────────────────────────────────────────┐
│   User Interactions (Always Tracked)       │
├────────────────────────────────────────────┤
│ - click_* events (menu, tiles, etc)       │
│ - video/audio events                       │
│ - search events                            │
│ - share events                             │
└────────────────────────────────────────────┘

┌────────────────────────────────────────────┐
│   Authentication Flow                      │
├────────────────────────────────────────────┤
│ login_start → login_success/failed         │
│ registration_start → registration_success  │
└────────────────────────────────────────────┘

┌────────────────────────────────────────────┐
│   Payment Flow                             │
├────────────────────────────────────────────┤
│ → payment_successful                       │
│ → subscription_activated                   │
└────────────────────────────────────────────┘
```

---

## 📊 Console Output Examples

### On Page Load (Logged In):
```javascript
✅ Branch user identity set - User ID: 12345
📤 Branch event called: user_identity_set
📤 Branch event called: page_view_test
✅ Branch event sent: page_view_test
```

### On Login Success:
```javascript
📤 Branch event called: login_start
📤 Branch event called: login_success
✅ Branch event sent: login_success
```

### On Video Play:
```javascript
📤 Branch event called: video_start
  - video_name: "Episode Name"
  - video_duration: 3600
✅ Branch event sent: video_start
```

### On Country Selection:
```javascript
📤 Branch event called: non_india_country_selected
  - country_code: "+1"
  - timestamp: "2026-09-01T10:30:00Z"
✅ Branch event sent: non_india_country_selected
```

---

## 🚀 Verification Checklist

Use this to verify events in Branch Liveview:

- [ ] Page load events (user_identity_set, page_view_test)
- [ ] Login success event
- [ ] Registration success event
- [ ] Video play/pause events
- [ ] Payment success event
- [ ] Subscription activated event
- [ ] Country selection event
- [ ] Click events (menu, tiles, social)
- [ ] Search events

---

## 📝 Next Steps

1. **Monitor in Branch Liveview**: https://dashboard.branch.io/liveview
2. **Verify data accuracy** in Branch Dashboard
3. **Add missing events** if needed:
   - Payment failure event
   - Subscription cancellation
   - Logout event
4. **Test in multiple domains** (production, dev, staging)

---


