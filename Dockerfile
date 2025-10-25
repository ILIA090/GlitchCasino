# از PHP رسمی استفاده می‌کنیم
FROM php:8.2-cli

# فایل‌ها رو به کانتینر کپی کن
COPY . /app
WORKDIR /app

# پورت Render
ENV PORT=10000

# دستور اجرای PHP
CMD ["php", "-S", "0.0.0.0:10000", "-t", "."]
