# Étape de base Node.js
FROM node:22-alpine as base

WORKDIR /app

COPY package*.json ./
RUN npm ci || npm install

COPY . .

# Cible Development (Vite dev server)
FROM base as development
EXPOSE 5173
CMD ["npm", "run", "dev"]

# Étape de Build Production
FROM base as builder
ARG VITE_API_BASE_URL=/api
ENV VITE_API_BASE_URL=$VITE_API_BASE_URL
RUN npm run build

# Cible Production (Nginx)
FROM nginx:alpine as production
COPY --from=builder /app/dist /usr/share/nginx/html
COPY nginx.conf /etc/nginx/conf.d/default.conf

EXPOSE 80
CMD ["nginx", "-g", "daemon off;"]
