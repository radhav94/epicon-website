#!/bin/bash

# Quick Monitoring for Token Refresh Testing
# Usage: bash QUICK_MONITOR_COMMANDS.sh

echo "🔍 Token Refresh Monitoring Script"
echo "=================================="
echo ""
echo "Choose what to monitor:"
echo ""
echo "1. Start Laravel Server"
echo "2. Watch User Logs (Refresh Logs)"
echo "3. Watch API Logs (Backend Calls)"
echo "4. Watch Error Logs"
echo "5. Run All Logs Together"
echo ""

read -p "Enter choice (1-5): " choice

case $choice in
  1)
    echo "🚀 Starting Laravel development server..."
    echo "Opening http://localhost:8000"
    php artisan serve
    ;;
  
  2)
    echo "📋 Watching User Logs (Refresh Activity)..."
    echo "Press Ctrl+C to stop"
    echo ""
    tail -f storage/logs/user/user-*.log | grep -E "(🔄|Proactive|refresh|Token|initiated)"
    ;;
  
  3)
    echo "📡 Watching API Logs (Backend Calls)..."
    echo "Press Ctrl+C to stop"
    echo ""
    tail -f storage/logs/api/api-*.log
    ;;
  
  4)
    echo "❌ Watching Error Logs..."
    echo "Press Ctrl+C to stop"
    echo ""
    tail -f storage/logs/error/error-*.log
    ;;
  
  5)
    echo "🎯 Running all logs side-by-side..."
    echo "This will open multiple terminal windows"
    echo ""
    
    # Open user logs in new tab
    echo "Starting user logs in new terminal..."
    osascript -e 'tell application "Terminal" to activate' \
              -e "tell application \"System Events\" to keystroke \"t\" using command down" \
              -e "delay 0.5" \
              -e "tell application \"Terminal\" to do script \"cd /Users/in10/Desktop/projects/epicon-web && tail -f storage/logs/user/user-*.log\""
    
    # Open API logs in new tab
    echo "Starting API logs in new terminal..."
    osascript -e 'tell application "Terminal" to activate' \
              -e "tell application \"System Events\" to keystroke \"t\" using command down" \
              -e "delay 0.5" \
              -e "tell application \"Terminal\" to do script \"cd /Users/in10/Desktop/projects/epicon-web && tail -f storage/logs/api/api-*.log\""
    
    echo "✅ Logs opened in new terminal tabs"
    echo "Check Terminal window for logs"
    ;;
  
  *)
    echo "❌ Invalid choice"
    exit 1
    ;;
esac
