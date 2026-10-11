# Form Validation Error - Visual Guide

## Overview
Complete visual reference for form validation error display system.

## Error Display Scenarios

### Scenario 1: Empty Form - All Fields Missing

**What User Sees:**
```
┌──────────────────────────────────────┐
│           Add Profile                │
├──────────────────────────────────────┤
│                                      │
│ Your Name                            │
│ ╔══════════════════════════════╗    │  ← Red border
│ ║                              ║    │  ← Light red background
│ ╚══════════════════════════════╝    │
│ ❌ Name is required                 │  ← Red error text
│                                      │
│ Date of Birth                        │
│ ╔══════════════════════════════╗    │  ← Red border
│ ║  DD/MM/YYYY                   ║    │  ← Light red background
│ ╚══════════════════════════════╝    │
│ ❌ Date of birth is required        │  ← Red error text
│                                      │
│ [Create Profile]                    │
└──────────────────────────────────────┘

Toast Notification (appears):
┌─────────────────────────────────────┐
│ ❌ Name is required                 │
└─────────────────────────────────────┘
```

**HTML Structure:**
```html
<div class="input-field has-error">
    <label class="form-label text-white">Your Name</label>
    <input class="form-control is-invalid" name="name">
    <div class="error-message-text">Name is required</div>
</div>
```

**CSS Classes Applied:**
- `.input-field.has-error` → Container marked with error state
- `.form-control.is-invalid` → Red border + light red background
- `.error-message-text` → Red text, 12px font

---

### Scenario 2: Fixing Errors - User Types Name

**Before (with error):**
```
Your Name
╔══════════════════════════════╗
║                              ║  ← Red border, empty field
╚══════════════════════════════╝
❌ Name is required             ← Red error text
```

**User Types "John":**
```
Your Name
│ John│  ← User typing
```

**After (error cleared - real-time):**
```
Your Name
╔══════════════════════════════╗
║ John                         ║  ← Normal border returned
╚══════════════════════════════╝
                               ← Error text disappeared
```

**CSS Changes:**
- `.is-invalid` class removed
- `.has-error` class removed
- `.error-message-text` removed from DOM

---

### Scenario 3: Valid Form - Ready to Submit

**What User Sees:**
```
┌──────────────────────────────────────┐
│           Add Profile                │
├──────────────────────────────────────┤
│                                      │
│ Your Name                            │
│ ╔══════════════════════════════╗    │
│ ║ John Doe                     ║    │  ← Normal appearance
│ ╚══════════════════════════════╝    │
│                                      │  ← No error message
│ Date of Birth                        │
│ ╔══════════════════════════════╗    │
│ ║ 15/06/1990                   ║    │  ← Normal appearance
│ ╚══════════════════════════════╝    │
│                                      │  ← No error message
│ [Create Profile]                    │  ← Button enabled
└──────────────────────────────────────┘
```

---

### Scenario 4: Multiple Errors

**What User Sees:**
```
┌──────────────────────────────────────┐
│           Add Profile                │
├──────────────────────────────────────┤
│                                      │
│ Your Name                            │
│ ╔══════════════════════════════╗    │  ← Red border
│ ║ AB                           ║    │  ← Light red bg
│ ╚══════════════════════════════╝    │
│ ❌ Name must be at least 3...      │  ← Red error text
│                                      │
│ Date of Birth                        │
│ ╔══════════════════════════════╗    │  ← Red border
│ ║                              ║    │  ← Light red bg
│ ╚══════════════════════════════╝    │
│ ❌ Date of birth is required        │  ← Red error text
│                                      │
│ [Create Profile]                    │
└──────────────────────────────────────┘

Toast (top right):
┌─────────────────────────────────────┐
│ ❌ Name must be at least 3 chars... │
└─────────────────────────────────────┘
```

---

### Scenario 5: Focus State (Normal)

**What User Sees:**
```
Your Name
╔══════════════════════════════╗
║ J|ohn                    ╰   ║  ← Blue border
╚══════════════════════════════╝
  (Blue glow around field)

Focus State Effect:
- Border color: #1BADE6 (blue)
- Box shadow: blue glow
- Background: slightly lighter
```

---

### Scenario 6: Focus State (Error)

**What User Sees:**
```
Your Name
╔══════════════════════════════╗
║ AB|                      ╰    ║  ← RED border (not blue!)
╚══════════════════════════════╝
  (Red glow around field)
❌ Name must be at least 3 characters

Focus State with Error:
- Border color: #ff4444 (red)
- Box shadow: red glow
- Background: light red
```

---

## Color Reference

### Error State Colors
```
┌─────────────────────────────────────────┐
│ Error Text Color:           #ff4444     │ ← Red
│ Error Border Color:         #ff4444     │ ← Red
│ Error Background:    rgba(255,68,68,5%) │ ← Light red tint
│ Error Focus Glow:   rgba(255,68,68,25%)│ ← Red shadow
└─────────────────────────────────────────┘
```

### Normal State Colors
```
┌─────────────────────────────────────────┐
│ Normal Border Color:        #666        │ ← Gray
│ Normal Background:   rgba(255,255,255,5%) │ ← Very light white
│ Focus Border Color:         #1BADE6    │ ← Blue
│ Focus Glow:         rgba(27,173,230,25%)│ ← Blue shadow
└─────────────────────────────────────────┘
```

---

## Animation Timeline

### Error Message Appearance
```
Time: 0ms
opacity: 0
transform: translateY(-5px)
┌─────────────┐
│ ↑ (invisible) │  ← Error message above its final position
└─────────────┘

Time: 150ms (halfway)
opacity: 0.5
transform: translateY(-2.5px)
┌─────────────┐
│ ↓ (fading in) │  ← Moving down, fading in
└─────────────┘

Time: 300ms (complete)
opacity: 1
transform: translateY(0)
┌─────────────┐
│ Error Text  │  ← Visible at final position
└─────────────┘
```

**CSS Animation:**
```css
@keyframes slideInError {
    from { opacity: 0; transform: translateY(-5px); }
    to   { opacity: 1; transform: translateY(0);    }
}
animation: slideInError 0.3s ease-out;
```

---

## Responsive Design

### Desktop (> 768px)
```
┌────────────────────────────────┐
│ Your Name                      │
│ [_____________________]        │
│ ❌ Error message               │
│ (12px error text)              │
│                                │
│ Date of Birth                  │
│ [_____________________]        │
│ ❌ Error message               │
└────────────────────────────────┘
```

### Mobile (≤ 768px)
```
┌──────────────────┐
│ Your Name        │
│ [____________]   │
│ ❌ Error msg     │
│ (11px on mobile) │
│                  │
│ Date of Birth    │
│ [____________]   │
│ ❌ Error msg     │
└──────────────────┘
```

**Changes on Mobile:**
- Font size: 12px → 11px
- Margin bottom: 20px → 18px
- Still fully readable
- Error text doesn't wrap awkwardly

---

## Keyboard Navigation

### Tab Through Form
```
1. User presses TAB
   ↓
   Your Name field focused
   ↓
   ╔══════════════════════════════╗
   ║ [cursor here]                ║ (Blue border, blue glow)
   ╚══════════════════════════════╝

2. User presses TAB again
   ↓
   Date of Birth field focused
   ↓
   ╔══════════════════════════════╗
   ║ DD/MM/YYYY [cursor]          ║ (Blue border, blue glow)
   ╚══════════════════════════════╝
```

### Tab Through with Error
```
1. User presses TAB (field has error)
   ↓
   Your Name field focused (with error)
   ↓
   ╔══════════════════════════════╗
   ║ [cursor here]                ║ (RED border, RED glow!)
   ╚══════════════════════════════╝
   ❌ Name must be at least 3 characters
```

---

## Touch Interaction (Mobile)

### Tap on Field with Error
```
Before Tap:
┌────────────────┐
│ [_____________]│  ← Red field
│ ❌ Error msg   │
└────────────────┘

After Tap:
┌────────────────┐
│ [_____________]│  ← Red field with blue focus glow
│ ⌨️  Keyboard    │  ← Mobile keyboard appears
└────────────────┘
(Error message still visible)
```

### Type to Fix Error
```
As User Types:
┌────────────────┐
│ [A_____________]│  ← Still has error styling
│ ❌ Error msg    │
└────────────────┘
        ↓
┌────────────────┐
│ [Ab____________]│  ← Still shows error (needs 3+ chars)
│ ❌ Error msg    │
└────────────────┘
        ↓
┌────────────────┐
│ [Abc___________]│  ← Error clears! Border returns to normal
│                 │  ← Error message disappears
└────────────────┘
```

---

## Real-time vs Submit Validation

### Real-time (as user types)
```
Initial state:
Your Name
[_________]
(no error, normal styling)

User starts typing "A":
Your Name
[A________]
(still no error, normal styling)

User types "B":
Your Name
[AB_______]
(still no error, BUT has tooltip/live check)

User types "C":
Your Name
[ABC______]
(✓ error clears if there was one)
```

### Submit Validation (current implementation)
```
User fills form partially:
Your Name: [AB]
DOB: [empty]

User clicks "Create Profile":

BOTH errors show together:
Your Name
[AB_______]  ← Red border
❌ Name must be at least 3 characters

Date of Birth
[_________]  ← Red border
❌ Date of birth is required

Toast: "Name must be at least 3 characters"
```

---

## Error Message Font Styling

```
Comparison:

Label (16px, normal weight):
┌────────────────────────────────┐
│ Your Name                      │
└────────────────────────────────┘

Input (14px, normal weight):
┌────────────────────────────────┐
│ [_____________________]         │
└────────────────────────────────┘

Error Text (12px, bold weight):
┌────────────────────────────────┐
│ ❌ Name is required             │
│    ↑ Smaller than input         │
│       ↑ Bold for emphasis       │
└────────────────────────────────┘
```

---

## Toast Notification Integration

### Toast Position & Styling
```
┌─────────────────────────────────────────────┐
│                                             │
│                 Toast Notification          │
│  ╔═══════════════════════════════════════╗ │
│  ║ ❌ Name is required                  ║ │  Top right
│  ╚═══════════════════════════════════════╝ │  Red background
│                                             │  Auto-dismiss: 4s
│                                             │
│ ┌─────────────────┐                       │
│ │   Form Area     │                       │
│ └─────────────────┘                       │
└─────────────────────────────────────────────┘
```

**Toast Details:**
- Type: Error (red)
- Position: Top-right corner
- Duration: 4 seconds
- Message: Same as field error message

---

## Accessibility Features Visualization

### Screen Reader Output
```
Input Label (announced):
"Your Name, required, invalid"

Input State (announced):
"has aria-invalid = true"

Error Message (announced):
"Alert: Name is required"

Visual + Audio = Complete feedback
```

### High Contrast Mode
```
Light Mode:
┌──────────────────────────┐
│ Name field with error    │ ← Red border on white
│ ❌ Red error text        │ ← Red on white (high contrast)
└──────────────────────────┘

Dark Mode (form default):
┌──────────────────────────┐
│ Name field with error    │ ← Red border on dark
│ ❌ Red error text        │ ← Red on dark (still visible)
└──────────────────────────┘
```

---

## Summary Table

| Element | Desktop | Mobile | Error State | Normal State |
|---------|---------|--------|-------------|--------------|
| **Border** | 1px solid | 1px solid | #ff4444 | #666 |
| **Background** | rgba(255,255,255,5%) | rgba(255,255,255,5%) | rgba(255,68,68,5%) | rgba(255,255,255,8%) |
| **Text Color** | White | White | #ff4444 | White |
| **Error Text** | 12px | 11px | Red, bold | N/A |
| **Focus Glow** | Blue | Blue | Red | Blue |
| **Animation** | slideInError 0.3s | slideInError 0.3s | Yes | N/A |
| **Margin Bottom** | 20px | 18px | 20px/18px | 20px/18px |

---

## Testing Checkpoints

- [ ] Error borders appear in red (#ff4444)
- [ ] Error backgrounds appear light red
- [ ] Error messages slide in smoothly
- [ ] Error messages are readable at 12px
- [ ] Multiple errors display correctly
- [ ] Errors clear when field is corrected
- [ ] Focus glow turns red for error fields
- [ ] Toast notification appears with same message
- [ ] Mobile responsiveness verified
- [ ] Touch interaction works smoothly
- [ ] Keyboard navigation shows focus states correctly
- [ ] Screen reader announces errors
- [ ] All browsers show consistent styling
