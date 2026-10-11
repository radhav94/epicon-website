# ✅ Branch Events - Complete Implementation

## Overview

All Branch tracking events have been added to `/public/assets/js/branch-tracking.js` for comprehensive user journey tracking.

---

## New Events Added (Missing from List)

### 1. Purchase Event
**Purpose**: Track when user completes a purchase/subscription payment

```javascript
trackPurchase(transactionId, value, currency, items, additionalData)
```

**Parameters**:
- `transaction_id`: Unique order/transaction ID
- `value`: Revenue value of transaction
- `currency`: ISO currency code (INR, USD, etc.)
- `items`: Purchased item details
- `method`: Payment method
- `unique_transaction_id`: Unique transaction order ID

---

### 2. Sign Up Event
**Purpose**: Track user registration/sign up

```javascript
trackSignUp(method, additionalData)
```

**Parameters**:
- `method`: Registration method (otp, password, truecaller, google, facebook)

---

### 3. Search Event
**Purpose**: Track user searches

```javascript
trackSearch(searchTerm, additionalData)
```

**Parameters**:
- `search_term`: What user searched for

---

### 4. View Item Event
**Purpose**: Track when user views content/items

```javascript
trackViewItem(items, additionalData)
```

**Parameters**:
- `items`: Viewed item details

---

### 5. Add to Cart Event
**Purpose**: Track items added to cart

```javascript
trackAddToCart(items, additionalData)
```

**Parameters**:
- `items`: Items added to cart

---

### 6. Begin Checkout Event
**Purpose**: Track when user starts checkout process

```javascript
trackBeginCheckout(items, additionalData)
```

**Parameters**:
- `items`: Checkout item details

---

### 7. Generate Lead Event
**Purpose**: Track lead generation

```javascript
trackGenerateLead(currency, value, pageLocation, additionalData)
```

**Parameters**:
- `currency`: ISO currency code
- `value`: Lead value (if applicable)
- `page_location`: Page URL where lead was generated

---

### 8. Page View Event
**Purpose**: Track page views and navigation

```javascript
trackPageView(pageTitle, pageReferrer, pageUrl, additionalData)
```

**Parameters**:
- `page_title`: Title of page
- `page_referrer`: Referring page
- `page_url`: Page URL

---

### 9. Video Progress Event
**Purpose**: Track video playback progress

```javascript
trackVideoProgress(videoTitle, videoUrl, percent, additionalData)
```

**Parameters**:
- `video_title`: Video name
- `video_url`: Video URL
- `percent`: Progress percentage (0-100)

---

### 10. File Download Event
**Purpose**: Track when users download files

```javascript
trackFileDownload(fileName, additionalData)
```

**Parameters**:
- `file_name`: Downloaded file name

---

### 11. Select Content Event
**Purpose**: Track content selection

```javascript
trackSelectContent(contentType, contentId, additionalData)
```

**Parameters**:
- `content_type`: Type of content (episode, movie, show, etc.)
- `content_id`: ID of selected content

---

## Implementation Status

✅ **All 11 events implemented** in `/public/assets/js/branch-tracking.js`
✅ **Ready to use** globally across app
✅ **GA4 integration** - Events also tracked to Google Analytics 4
✅ **Console logging** for debugging

---

## Quick Reference

| Event | Function | Purpose |
|-------|----------|---------|
| purchase | trackPurchase() | Order/subscription payment |
| sign_up | trackSignUp() | User registration |
| search | trackSearch() | Content search |
| view_item | trackViewItem() | Content viewing |
| add_to_cart | trackAddToCart() | Add to shopping cart |
| begin_checkout | trackBeginCheckout() | Start checkout flow |
| generate_lead | trackGenerateLead() | Lead generation |
| page_view | trackPageView() | Page navigation |
| video_progress | trackVideoProgress() | Video playback |
| file_download | trackFileDownload() | File downloads |
| select_content | trackSelectContent() | Content selection |

---

## Usage Examples

### During Purchase Flow
```javascript
trackPurchase('ORDER_12345', 199, 'INR', 
  [{item_id: 'plan_1', item_name: 'Premium'}]);
```

### During Registration
```javascript
trackSignUp('otp', {email: 'user@example.com', phone: '919999999999'});
```

### During Content Viewing
```javascript
trackViewItem([{item_id: 'show_123', item_name: 'Stranger Things'}]);
trackSelectContent('episode', 'ep_456');
trackVideoProgress('Episode 1', '/video/ep1', 50);  // 50% watched
```

### During Search
```javascript
trackSearch('Marvel');
```

---

## File Location
`/public/assets/js/branch-tracking.js`

All events are now available and ready to integrate into your user flows!
