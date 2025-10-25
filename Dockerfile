FROM php:8.2-cli

# کپی کل پروژه
COPY . /app
WORKDIR /app

ENV PORT=10000

CMD ["php", "-S", "0.0.0.0:10000", "-t", "."]
