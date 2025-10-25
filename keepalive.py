import requests
import time

# آدرس اصلی وب‌سرویس در Render (جاشو با لینک خودت عوض کن)
RENDER_URL = "https://glitchcasino.onrender.com"

# مدت زمان بین هر پینگ (به ثانیه)
PING_INTERVAL = 300  # یعنی هر 5 دقیقه

while True:
    try:
        r = requests.get(RENDER_URL)
        print(f"[KEEPALIVE] Ping sent → status: {r.status_code}")
    except Exception as e:
        print(f"[KEEPALIVE] Error: {e}")
    time.sleep(PING_INTERVAL)