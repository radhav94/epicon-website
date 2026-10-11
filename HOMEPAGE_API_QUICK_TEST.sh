#!/bin/bash

# ============================================
# Homepage API - Quick Test for Continue Watching
# ============================================

# User Details - Update these with your actual values
USER_TOKEN="eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJkYXRhIjp7InVzZXJfaWQiOjkxOTg2NzQ0Nzc3M30sImlhdCI6MTc4NzgyNTIwMSwiZXhwIjoxNzg3OTExNjAxfQ.QWNwwZAmp3Y1cazeLO_Wxfl4ZX5AMZ55dQkQr21nmQ0"
USER_ID="919867447773"
PROFILE_ID="16413556"
API_TOKEN="szQDOyDaxsS0E4qeV1rMfpYBKnSWVESH"
API_URL="https://contentapistg-njsapi.epicon.in/index/pages/homepage"

# ============================================
# Test 1: Basic Homepage Call
# ============================================
test_basic_homepage() {
    echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
    echo "Test 1: Basic Homepage (No User Auth)"
    echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
    
    curl -s "${API_URL}?slug=home-v2&list_language=all&display_language=en&page=1&limit=3" \
        -H "x-access-auth-token: ${API_TOKEN}" | jq '.data.list[] | {display_type, title}'
    
    echo ""
}

# ============================================
# Test 2: Homepage with User Auth
# ============================================
test_with_user_auth() {
    echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
    echo "Test 2: Homepage with User Authentication"
    echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
    
    curl -s "${API_URL}?slug=home-v2&list_language=all&display_language=en&page=1&limit=3&user_id=${USER_ID}&profile_id=${PROFILE_ID}" \
        -H "x-access-auth-token: ${API_TOKEN}" \
        -H "Authorization: ${USER_TOKEN}" | jq '.data.list[] | {display_type, title}'
    
    echo ""
}

# ============================================
# Test 3: Check Continue Watching Exists
# ============================================
test_continue_watching_exists() {
    echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
    echo "Test 3: Check if Continue Watching Tray Exists"
    echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
    
    RESPONSE=$(curl -s "${API_URL}?slug=home-v2&list_language=all&display_language=en&page=1&limit=3&user_id=${USER_ID}&profile_id=${PROFILE_ID}" \
        -H "x-access-auth-token: ${API_TOKEN}" \
        -H "Authorization: ${USER_TOKEN}")
    
    if echo "$RESPONSE" | grep -q "continuewatching"; then
        echo "✓ Continue Watching tray FOUND"
    else
        echo "✗ Continue Watching tray NOT FOUND"
    fi
    
    echo ""
}

# ============================================
# Test 4: Show Continue Watching Content
# ============================================
test_continue_watching_content() {
    echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
    echo "Test 4: Continue Watching Content Details"
    echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
    
    curl -s "${API_URL}?slug=home-v2&list_language=all&display_language=en&page=1&limit=3&user_id=${USER_ID}&profile_id=${PROFILE_ID}" \
        -H "x-access-auth-token: ${API_TOKEN}" \
        -H "Authorization: ${USER_TOKEN}" | \
        jq '.data.list[] | select(.display_type=="continuewatching") | {
            display_type,
            title,
            show_more,
            item_count: (.content | length),
            items: [.content[] | {title, duration, user_duration, progress_percent: ((.user_duration / .duration * 100) | round)}]
        }'
    
    echo ""
}

# ============================================
# Test 5: All Display Types
# ============================================
test_all_display_types() {
    echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
    echo "Test 5: All Display Types in Response"
    echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
    
    curl -s "${API_URL}?slug=home-v2&list_language=all&display_language=en&page=1&limit=3&user_id=${USER_ID}&profile_id=${PROFILE_ID}" \
        -H "x-access-auth-token: ${API_TOKEN}" \
        -H "Authorization: ${USER_TOKEN}" | \
        jq '.data.list[] | {display_type, title, has_content: (.content | length > 0)}'
    
    echo ""
}

# ============================================
# Test 6: Compare With vs Without Auth
# ============================================
test_compare_auth() {
    echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
    echo "Test 6: Compare Without Auth vs With Auth"
    echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
    
    echo "Without Auth:"
    curl -s "${API_URL}?slug=home-v2&list_language=all&display_language=en&page=1&limit=3" \
        -H "x-access-auth-token: ${API_TOKEN}" | jq '.data.list[] | .display_type' | sort
    
    echo ""
    echo "With Auth:"
    curl -s "${API_URL}?slug=home-v2&list_language=all&display_language=en&page=1&limit=3&user_id=${USER_ID}&profile_id=${PROFILE_ID}" \
        -H "x-access-auth-token: ${API_TOKEN}" \
        -H "Authorization: ${USER_TOKEN}" | jq '.data.list[] | .display_type' | sort
    
    echo ""
}

# ============================================
# Test 7: Save Full Response
# ============================================
test_save_response() {
    echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
    echo "Test 7: Saving Full Response to File"
    echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
    
    OUTPUT_FILE="homepage_response_$(date +%s).json"
    
    curl -s "${API_URL}?slug=home-v2&list_language=all&display_language=en&page=1&limit=3&user_id=${USER_ID}&profile_id=${PROFILE_ID}" \
        -H "x-access-auth-token: ${API_TOKEN}" \
        -H "Authorization: ${USER_TOKEN}" > "$OUTPUT_FILE"
    
    echo "Response saved to: $OUTPUT_FILE"
    echo "File size: $(du -h "$OUTPUT_FILE" | cut -f1)"
    
    echo ""
}

# ============================================
# Main Menu
# ============================================
main_menu() {
    echo "╔════════════════════════════════════════════════════════╗"
    echo "║  Homepage API - Continue Watching Tray Tests           ║"
    echo "╚════════════════════════════════════════════════════════╝"
    echo ""
    echo "Choose a test to run:"
    echo ""
    echo "1) Basic Homepage Call (No Auth)"
    echo "2) Homepage with User Authentication"
    echo "3) Check if Continue Watching Exists"
    echo "4) Show Continue Watching Content Details"
    echo "5) Show All Display Types"
    echo "6) Compare With vs Without Auth"
    echo "7) Save Full Response to File"
    echo "8) Run All Tests"
    echo "0) Exit"
    echo ""
    read -p "Enter choice (0-8): " choice
    
    case $choice in
        1) test_basic_homepage ;;
        2) test_with_user_auth ;;
        3) test_continue_watching_exists ;;
        4) test_continue_watching_content ;;
        5) test_all_display_types ;;
        6) test_compare_auth ;;
        7) test_save_response ;;
        8) 
            test_basic_homepage
            test_with_user_auth
            test_continue_watching_exists
            test_continue_watching_content
            test_all_display_types
            test_compare_auth
            test_save_response
            ;;
        0) echo "Exiting..."; exit 0 ;;
        *) echo "Invalid choice"; main_menu ;;
    esac
    
    read -p "Press Enter to continue..."
    clear
    main_menu
}

# Run main menu if interactive
if [ -t 0 ]; then
    main_menu
else
    # Run all tests if piped
    test_basic_homepage
    test_with_user_auth
    test_continue_watching_exists
    test_continue_watching_content
    test_all_display_types
    test_compare_auth
    test_save_response
fi
