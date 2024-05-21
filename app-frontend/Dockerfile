
FROM node:18-alpine AS builder

WORKDIR /app

COPY package*.json ./

RUN rm -rf node_modules package-lock.json

RUN npm install

RUN npm install bootstrap axios

COPY . .

RUN echo "SKIP_PREFLIGHT_CHECK=true" > .env

RUN npm run build

FROM nginx:alpine

COPY --from=builder /app/build /usr/share/nginx/html

EXPOSE 8000

CMD ["php", "artisan", "serve"]